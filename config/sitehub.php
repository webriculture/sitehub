<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Tenant database prefix
    |--------------------------------------------------------------------------
    |
    | Each site's tenant database is named "{prefix}{slug_with_underscores}"
    | on the same PostgreSQL cluster as the landlord database. Tests override
    | this so they can never touch a real tenant database.
    |
    */

    'tenant_db_prefix' => env('SITEHUB_TENANT_DB_PREFIX', 'site_'),

    /*
    |--------------------------------------------------------------------------
    | Tenant migrations path
    |--------------------------------------------------------------------------
    */

    'tenant_migrations_path' => 'database/migrations/tenant',

    /*
    |--------------------------------------------------------------------------
    | Media disk
    |--------------------------------------------------------------------------
    |
    | Where client media (partner logos, gallery photos) is stored. Production
    | uses the shared platform bucket with per-site key prefixes; tests use
    | the local public disk so they never touch S3.
    |
    */

    'media_disk' => env('SITEHUB_MEDIA_DISK', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Known feature keys
    |--------------------------------------------------------------------------
    |
    | Features are first-party platform modules enabled per site via the
    | sites.features column. Only keys listed here may be enabled.
    |
    */

    'features' => [
        'galleries',
        'forms',
        'partners',
        'events',
    ],

    /*
    |--------------------------------------------------------------------------
    | Need Navigator
    |--------------------------------------------------------------------------
    |
    | Events/classes are authored in Need Navigator and pulled by events:sync.
    | driver: 'stub' (sample data) until the real API details are wired;
    | per-site bearer tokens live in the site's encrypted secrets under
    | the `need_navigator_token` key.
    |
    */

    'need_navigator' => [
        'driver' => env('NEED_NAVIGATOR_DRIVER', 'stub'),
        'base_url' => env('NEED_NAVIGATOR_URL'),
    ],

];
