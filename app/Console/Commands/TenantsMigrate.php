<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Site;
use App\Tenancy\SiteProvisioner;
use App\Tenancy\Tenancy;
use Illuminate\Console\Command;

final class TenantsMigrate extends Command
{
    protected $signature = 'tenants:migrate {--site= : Only this site slug}
                            {--fresh : Drop all tables and re-run tenant migrations}';

    protected $description = 'Run tenant migrations for every site (or one site via --site=)';

    public function handle(SiteProvisioner $provisioner): int
    {
        $sites = Site::query()
            ->when($this->option('site'), fn ($q, $slug) => $q->where('slug', $slug))
            ->orderBy('slug')
            ->get();

        if ($sites->isEmpty()) {
            $this->warn('No matching sites.');

            return self::FAILURE;
        }

        foreach ($sites as $site) {
            $this->line('Migrating <info>'.Tenancy::databaseName($site).'</info> ...');
            $provisioner->createTenantDatabase($site);
            $provisioner->migrateTenant($site, fresh: (bool) $this->option('fresh'));
        }

        $this->info($sites->count().' tenant database(s) migrated.');

        return self::SUCCESS;
    }
}
