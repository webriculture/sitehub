<?php

declare(strict_types=1);

namespace App\Tenancy;

use App\Models\Site;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

/**
 * Switches the application into a site's context: points the `tenant`
 * database connection at the site's own database and registers the
 * `site::` view namespace for its templates.
 *
 * Tenant models must NEVER be queried before a site is current.
 */
final class Tenancy
{
    public static function makeCurrent(Site $site): void
    {
        config(['database.connections.tenant.database' => self::databaseName($site)]);
        DB::purge('tenant');

        app()->instance(Site::class, $site);

        View::replaceNamespace('site', $site->viewPath());

        // The finder caches resolved view paths by name; without a flush,
        // "site::pages.home" would keep pointing at the previous site.
        View::getFinder()->flush();
    }

    public static function forget(): void
    {
        config(['database.connections.tenant.database' => null]);
        DB::purge('tenant');

        app()->forgetInstance(Site::class);
    }

    public static function current(): ?Site
    {
        return app()->bound(Site::class) ? app(Site::class) : null;
    }

    public static function databaseName(Site $site): string
    {
        return config('sitehub.tenant_db_prefix').str_replace('-', '_', $site->slug);
    }
}
