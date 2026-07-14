<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Site;
use Illuminate\Console\Command;

final class SitesFeature extends Command
{
    protected $signature = 'sites:feature {slug : Site slug}
                            {features* : Feature keys to enable (see config/sitehub.php)}
                            {--disable : Disable the given features instead}';

    protected $description = 'Enable or disable first-party features for a site';

    public function handle(): int
    {
        $site = Site::query()->where('slug', $this->argument('slug'))->first();

        if ($site === null) {
            $this->error('Unknown site ['.$this->argument('slug').'].');

            return self::FAILURE;
        }

        $known = config('sitehub.features');
        $requested = array_map('strtolower', $this->argument('features'));

        if ($unknown = array_diff($requested, $known)) {
            $this->error('Unknown feature(s): '.implode(', ', $unknown).'. Known: '.implode(', ', $known).'.');

            return self::FAILURE;
        }

        $current = $site->features ?? [];

        $site->features = $this->option('disable')
            ? array_values(array_diff($current, $requested))
            : array_values(array_unique([...$current, ...$requested]));

        $site->save();

        $this->info('Site ['.$site->slug.'] features: '.(implode(', ', $site->features) ?: '(none)'));

        return self::SUCCESS;
    }
}
