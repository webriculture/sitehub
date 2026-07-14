<?php

declare(strict_types=1);

namespace App\Tenancy;

use App\Models\Site;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Everything needed to bring a new site into existence:
 * landlord row, tenant database (created + migrated), and the
 * sites-as-code directory skeleton. Idempotent — safe to re-run.
 */
final class SiteProvisioner
{
    public function provision(string $slug, string $name, array $features = []): Site
    {
        $site = Site::query()->firstOrCreate(
            ['slug' => $slug],
            ['name' => $name, 'features' => $features, 'settings' => []],
        );

        $this->createTenantDatabase($site);
        $this->migrateTenant($site);
        $this->scaffoldDirectories($site);

        return $site;
    }

    public function createTenantDatabase(Site $site): void
    {
        $database = Tenancy::databaseName($site);

        if (preg_match('/^[a-z0-9_]+$/', $database) !== 1) {
            throw new \InvalidArgumentException("Unsafe tenant database name [{$database}].");
        }

        $admin = DB::connection('landlord-admin');

        $exists = $admin->selectOne('select 1 from pg_database where datname = ?', [$database]) !== null;

        if (! $exists) {
            $admin->statement('CREATE DATABASE "'.$database.'"');
        }
    }

    public function migrateTenant(Site $site, bool $fresh = false): void
    {
        $previous = Tenancy::current();

        Tenancy::makeCurrent($site);

        Artisan::call($fresh ? 'migrate:fresh' : 'migrate', [
            '--database' => 'tenant',
            '--path' => config('sitehub.tenant_migrations_path'),
            '--force' => true,
        ]);

        $previous !== null ? Tenancy::makeCurrent($previous) : Tenancy::forget();
    }

    public function scaffoldDirectories(Site $site): void
    {
        $viewPath = $site->viewPath();

        if (! File::isDirectory($viewPath.'/pages')) {
            File::makeDirectory($viewPath.'/pages', 0755, true);

            File::put($viewPath.'/pages/home.blade.php', <<<BLADE
                <!doctype html>
                <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>{$site->name}</title>
                </head>
                <body>
                    <h1>{$site->name}</h1>
                    <p>Coming soon.</p>
                </body>
                </html>
                BLADE);

            File::put($viewPath.'/site.json', json_encode([
                'name' => $site->name,
                'notes' => '',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL);
        }

        $assetPath = public_path('sites/'.$site->slug);

        if (! File::isDirectory($assetPath)) {
            File::makeDirectory($assetPath, 0755, true);
            File::put($assetPath.'/.gitkeep', '');
        }
    }

    public function dropTenantDatabase(Site $site): void
    {
        $database = Tenancy::databaseName($site);

        DB::connection('landlord-admin')->statement('DROP DATABASE IF EXISTS "'.$database.'" WITH (FORCE)');
    }
}
