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
    ],

];
