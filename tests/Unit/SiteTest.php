<?php

declare(strict_types=1);

use App\Models\Site;
use App\Tenancy\Tenancy;

it('answers feature checks from the features array', function (): void {
    $site = new Site(['features' => ['galleries']]);

    expect($site->hasFeature('galleries'))->toBeTrue()
        ->and($site->hasFeature('forms'))->toBeFalse();
});

it('derives tenant database names from the slug', function (): void {
    $site = new Site(['slug' => 'fran-salem']);

    expect(Tenancy::databaseName($site))->toBe('test_site_fran_salem');
});
