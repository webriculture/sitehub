<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Tenancy\SiteProvisioner;
use App\Tenancy\Tenancy;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

final class SitesCreate extends Command
{
    protected $signature = 'sites:create {slug : Kebab-case site slug, e.g. fransalem}
                            {--name= : Display name (defaults to the slug, titled)}';

    protected $description = 'Provision a new site: landlord row, tenant database, directory skeleton';

    public function handle(SiteProvisioner $provisioner): int
    {
        $slug = strtolower((string) $this->argument('slug'));

        if (preg_match('/^[a-z0-9]+(-[a-z0-9]+)*$/', $slug) !== 1) {
            $this->error("Slug [{$slug}] must be kebab-case: lowercase letters, digits, single hyphens.");

            return self::FAILURE;
        }

        $name = (string) ($this->option('name') ?: Str::of($slug)->replace('-', ' ')->title());

        $site = $provisioner->provision($slug, $name);

        $this->info("Site [{$site->slug}] ready.");
        $this->line('  Tenant DB:  '.Tenancy::databaseName($site));
        $this->line('  Pages:      resources/sites/'.$site->slug.'/pages/');
        $this->line('  Assets:     public/sites/'.$site->slug.'/');
        $this->line('Next: php artisan sites:domain '.$site->slug.' <hostname> --primary');

        return self::SUCCESS;
    }
}
