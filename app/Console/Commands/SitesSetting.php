<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Site;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use JsonException;
use Spatie\ResponseCache\Facades\ResponseCache;

/**
 * Edits one entry of a site's `settings` jsonb (non-secret configuration:
 * locales, form recipients, redirects, the per-org Need Navigator host…).
 * Secrets never belong here — `sites:secret` stores those encrypted.
 */
final class SitesSetting extends Command
{
    protected $signature = 'sites:setting {slug : Site slug}
                            {key : Setting key (dot notation reaches nested keys)}
                            {value? : New value — a string, or JSON with --json}
                            {--json : Decode the value as JSON (arrays, booleans, numbers, null)}
                            {--unset : Remove the key instead of setting it}';

    protected $description = 'Set or remove one entry in a site\'s (non-secret) settings';

    /** Key fragments that indicate a credential — those go through sites:secret. */
    private const SECRET_MARKERS = ['token', 'secret', 'password', 'api_key', 'apikey'];

    public function handle(): int
    {
        $site = Site::query()->where('slug', $this->argument('slug'))->first();

        if ($site === null) {
            $this->error('Unknown site ['.$this->argument('slug').'].');

            return self::FAILURE;
        }

        $key = (string) $this->argument('key');

        foreach (self::SECRET_MARKERS as $marker) {
            if (str_contains(strtolower($key), $marker)) {
                $this->error('['.$key.'] looks like a credential. Settings are stored in plain text — use `sites:secret` instead.');

                return self::FAILURE;
            }
        }

        $settings = $site->settings ?? [];

        if ($this->option('unset')) {
            if (! Arr::has($settings, $key)) {
                $this->warn('Site ['.$site->slug.'] has no setting ['.$key.']; nothing to remove.');
            }

            Arr::forget($settings, $key);
        } else {
            $raw = $this->argument('value');

            if ($raw === null) {
                $this->error('A value is required unless --unset is given.');

                return self::FAILURE;
            }

            $value = (string) $raw;

            if ($this->option('json')) {
                try {
                    $value = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                    $this->error('Value is not valid JSON: '.$e->getMessage());

                    return self::FAILURE;
                }
            }

            Arr::set($settings, $key, $value);
        }

        $site->settings = $settings;
        $site->save();

        // Settings shape rendered pages (locales, redirects, form config), so
        // drop cached responses the same way events:sync does after a change.
        ResponseCache::clear();

        $this->info('Site ['.$site->slug.'] settings:');
        $this->line(json_encode($site->settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return self::SUCCESS;
    }
}
