<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Site;
use Illuminate\Console\Command;

final class SitesDomain extends Command
{
    protected $signature = 'sites:domain {slug : Site slug}
                            {hostname : Hostname to attach, e.g. fransalem.com}
                            {--primary : Make this the site\'s primary domain}
                            {--no-redirect : Serve this domain directly instead of 301ing to the primary}';

    protected $description = 'Attach a hostname to a site';

    public function handle(): int
    {
        $site = Site::query()->where('slug', $this->argument('slug'))->first();

        if ($site === null) {
            $this->error('Unknown site ['.$this->argument('slug').'].');

            return self::FAILURE;
        }

        $hostname = strtolower((string) $this->argument('hostname'));

        if ($this->option('primary')) {
            $site->domains()->update(['is_primary' => false]);
        }

        $site->domains()->updateOrCreate(
            ['hostname' => $hostname],
            [
                'is_primary' => (bool) $this->option('primary'),
                'redirect_to_primary' => ! $this->option('no-redirect'),
            ],
        );

        $this->info("Domain [{$hostname}] attached to [{$site->slug}]".($this->option('primary') ? ' as primary' : '').'.');

        return self::SUCCESS;
    }
}
