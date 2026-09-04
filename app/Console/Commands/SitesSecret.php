<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Site;
use Illuminate\Console\Command;

final class SitesSecret extends Command
{
    protected $signature = 'sites:secret {slug : Site slug}
                            {key : Secret key, e.g. need_navigator_token}
                            {--unset : Remove the secret instead}';

    protected $description = 'Set (via hidden prompt) or remove an encrypted secret for a site';

    public function handle(): int
    {
        $site = Site::query()->where('slug', $this->argument('slug'))->first();

        if ($site === null) {
            $this->error('Unknown site ['.$this->argument('slug').'].');

            return self::FAILURE;
        }

        $key = strtolower((string) $this->argument('key'));

        if (preg_match('/^[a-z0-9_]+$/', $key) !== 1) {
            $this->error('Secret keys must be snake_case ([a-z0-9_]+).');

            return self::FAILURE;
        }

        $secrets = $site->secrets ?? [];

        if ($this->option('unset')) {
            if (! array_key_exists($key, $secrets)) {
                $this->warn('Site ['.$site->slug.'] has no secret ['.$key.'] — nothing to remove.');

                return self::SUCCESS;
            }

            unset($secrets[$key]);
            $site->update(['secrets' => $secrets]);
            $this->info('Secret ['.$key.'] removed from site ['.$site->slug.'].');

            return self::SUCCESS;
        }

        // Hidden prompt only — the value must never pass through argv,
        // shell history, or process listings.
        $value = trim((string) $this->secret('Value for ['.$key.'] (input hidden)'));

        if ($value === '') {
            $this->error('Empty value — nothing saved.');

            return self::FAILURE;
        }

        $replacing = array_key_exists($key, $secrets);
        $secrets[$key] = $value;
        $site->update(['secrets' => $secrets]);

        $this->info('Secret ['.$key.'] '.($replacing ? 'replaced' : 'set')." for site [{$site->slug}] (".strlen($value).' chars).');

        return self::SUCCESS;
    }
}
