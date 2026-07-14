<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\Tenant\Event;
use App\NeedNavigator\NeedNavigatorClient;
use App\Tenancy\Tenancy;
use Illuminate\Console\Command;
use Spatie\ResponseCache\Facades\ResponseCache;
use Throwable;

final class EventsSync extends Command
{
    protected $signature = 'events:sync {--site= : Only this site slug}';

    protected $description = 'Pull events/classes from Need Navigator for every site with the events feature';

    public function handle(NeedNavigatorClient $client): int
    {
        $sites = Site::query()
            ->when($this->option('site'), fn ($q, $slug) => $q->where('slug', $slug))
            ->orderBy('slug')
            ->get()
            ->filter(fn (Site $site) => $site->hasFeature('events'));

        if ($sites->isEmpty()) {
            $this->warn('No sites with the events feature.');

            return self::SUCCESS;
        }

        $failures = 0;

        foreach ($sites as $site) {
            try {
                $changed = $this->syncSite($client, $site);
                $this->info("[{$site->slug}] synced".($changed ? ' (content changed, cache flushed)' : ' (no changes)'));
            } catch (Throwable $e) {
                $failures++;
                $this->error("[{$site->slug}] sync failed: {$e->getMessage()}");
                report($e);
            }
        }

        Tenancy::forget();

        return $failures === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function syncSite(NeedNavigatorClient $client, Site $site): bool
    {
        $items = $client->events($site);

        Tenancy::makeCurrent($site);

        $changed = false;
        $seen = [];

        foreach ($items as $item) {
            if (! isset($item['id'], $item['title'], $item['starts_at'])) {
                continue; // malformed item: skip rather than poison the sync
            }

            $seen[] = (string) $item['id'];

            $event = Event::query()->updateOrCreate(
                ['external_id' => (string) $item['id']],
                [
                    'kind' => $item['kind'] ?? 'event',
                    'title' => $item['title'],
                    'description' => $item['description'] ?? [],
                    'location' => $item['location'] ?? [],
                    'starts_at' => $item['starts_at'],
                    'ends_at' => $item['ends_at'] ?? null,
                    'all_day' => (bool) ($item['all_day'] ?? false),
                    'registration_url' => $item['registration_url'] ?? null,
                    'raw' => $item,
                    'synced_at' => now(),
                ],
            );

            $changed = $changed || $event->wasRecentlyCreated || $event->wasChanged([
                'kind', 'title', 'description', 'location', 'starts_at', 'ends_at', 'all_day', 'registration_url',
            ]);
        }

        $stale = Event::query()->whereNotIn('external_id', $seen)->delete();

        if ($changed || $stale > 0) {
            ResponseCache::clear();

            return true;
        }

        return false;
    }
}
