<?php

declare(strict_types=1);

use App\Models\Site;
use App\Tenancy\SiteProvisioner;
use Illuminate\Support\Facades\File;

afterEach(function (): void {
    if ($site = Site::query()->where('slug', 'tmp-cmdsite')->first()) {
        app(SiteProvisioner::class)->dropTenantDatabase($site);
    }

    File::deleteDirectory(resource_path('sites/tmp-cmdsite'));
    File::deleteDirectory(public_path('sites/tmp-cmdsite'));
});

it('provisions a site end to end via sites:create', function (): void {
    $this->artisan('sites:create tmp-cmdsite --name="Command Site"')
        ->assertSuccessful();

    $site = Site::query()->where('slug', 'tmp-cmdsite')->firstOrFail();

    expect($site->name)->toBe('Command Site')
        ->and(File::exists(resource_path('sites/tmp-cmdsite/pages/home.blade.php')))->toBeTrue()
        ->and(File::exists(resource_path('sites/tmp-cmdsite/site.json')))->toBeTrue()
        ->and(File::isDirectory(public_path('sites/tmp-cmdsite')))->toBeTrue();
});

it('rejects a non-kebab-case slug', function (): void {
    $this->artisan('sites:create "Bad Slug"')->assertFailed();
});

it('switches the primary domain via sites:domain', function (): void {
    $site = Site::factory()->create(['slug' => 'site-a']);
    $site->domains()->create(['hostname' => 'old.test', 'is_primary' => true]);

    $this->artisan('sites:domain site-a new.test --primary')->assertSuccessful();

    expect($site->domains()->where('is_primary', true)->pluck('hostname')->all())
        ->toBe(['new.test']);
});

it('enables and disables features via sites:feature', function (): void {
    Site::factory()->create(['slug' => 'site-a']);

    $this->artisan('sites:feature site-a galleries forms')->assertSuccessful();

    expect(Site::query()->where('slug', 'site-a')->first()->features)
        ->toBe(['galleries', 'forms']);

    $this->artisan('sites:feature site-a forms --disable')->assertSuccessful();

    expect(Site::query()->where('slug', 'site-a')->first()->features)
        ->toBe(['galleries']);
});

it('rejects unknown features', function (): void {
    Site::factory()->create(['slug' => 'site-a']);

    $this->artisan('sites:feature site-a blockchain')->assertFailed();
});
