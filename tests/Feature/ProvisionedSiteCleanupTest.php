<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Tests\Concerns\ProvisionsSites;

uses(ProvisionsSites::class);

afterEach(fn () => $this->cleanupProvisionedSites());

it('removes scaffolded site directories on cleanup', function (): void {
    $this->provisionSite('tmp-sweep');

    expect(File::isDirectory(resource_path('sites/tmp-sweep')))->toBeTrue()
        ->and(File::isDirectory(public_path('sites/tmp-sweep')))->toBeTrue();

    $this->cleanupProvisionedSites();

    expect(File::isDirectory(resource_path('sites/tmp-sweep')))->toBeFalse()
        ->and(File::isDirectory(public_path('sites/tmp-sweep')))->toBeFalse();
});

it('leaves site directories alone if they existed before provisioning', function (): void {
    File::makeDirectory(resource_path('sites/tmp-kept/pages'), 0755, true);
    File::makeDirectory(public_path('sites/tmp-kept'), 0755, true);

    try {
        $this->provisionSite('tmp-kept');
        $this->cleanupProvisionedSites();

        expect(File::isDirectory(resource_path('sites/tmp-kept')))->toBeTrue()
            ->and(File::isDirectory(public_path('sites/tmp-kept')))->toBeTrue();
    } finally {
        File::deleteDirectory(resource_path('sites/tmp-kept'));
        File::deleteDirectory(public_path('sites/tmp-kept'));
    }
});
