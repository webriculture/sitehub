<?php

declare(strict_types=1);

use App\Models\Site;
use App\Tenancy\SiteProvisioner;
use Illuminate\Support\Facades\DB;
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

it('sets a secret via hidden prompt without echoing it', function (): void {
    Site::factory()->create(['slug' => 'site-a']);

    $this->artisan('sites:secret site-a need_navigator_token')
        ->expectsQuestion('Value for [need_navigator_token] (input hidden)', 'nn_evt_plaintext-marker')
        ->doesntExpectOutputToContain('nn_evt_plaintext-marker')
        ->assertSuccessful();

    $site = Site::query()->where('slug', 'site-a')->first();

    expect($site->secret('need_navigator_token'))->toBe('nn_evt_plaintext-marker')
        ->and(DB::table('sites')->where('slug', 'site-a')->value('secrets'))
        ->not->toContain('nn_evt_plaintext-marker');
});

it('preserves other secrets when setting one', function (): void {
    Site::factory()->create(['slug' => 'site-a', 'secrets' => ['other_key' => 'keep-me']]);

    $this->artisan('sites:secret site-a need_navigator_token')
        ->expectsQuestion('Value for [need_navigator_token] (input hidden)', 'new-value')
        ->assertSuccessful();

    $site = Site::query()->where('slug', 'site-a')->first();

    expect($site->secret('other_key'))->toBe('keep-me')
        ->and($site->secret('need_navigator_token'))->toBe('new-value');
});

it('rejects an empty secret value', function (): void {
    Site::factory()->create(['slug' => 'site-a']);

    $this->artisan('sites:secret site-a need_navigator_token')
        ->expectsQuestion('Value for [need_navigator_token] (input hidden)', '   ')
        ->assertFailed();

    expect(Site::query()->where('slug', 'site-a')->first()->secret('need_navigator_token'))->toBeNull();
});

it('removes a secret with --unset', function (): void {
    Site::factory()->create(['slug' => 'site-a', 'secrets' => ['need_navigator_token' => 'old', 'other_key' => 'keep-me']]);

    $this->artisan('sites:secret site-a need_navigator_token --unset')->assertSuccessful();

    $site = Site::query()->where('slug', 'site-a')->first();

    expect($site->secret('need_navigator_token'))->toBeNull()
        ->and($site->secret('other_key'))->toBe('keep-me');
});

it('rejects secrets for unknown sites and malformed keys', function (): void {
    Site::factory()->create(['slug' => 'site-a']);

    $this->artisan('sites:secret nope need_navigator_token')->assertFailed();
    $this->artisan('sites:secret site-a "bad key!"')->assertFailed();
});

it('sets, replaces, and unsets a site setting via sites:setting', function (): void {
    Site::factory()->create(['slug' => 'site-a', 'settings' => ['locales' => ['es']]]);

    $this->artisan('sites:setting site-a need_navigator_url https://fco.neednavigator.test')
        ->assertSuccessful();

    expect(Site::query()->where('slug', 'site-a')->first()->settings)
        ->toBe(['locales' => ['es'], 'need_navigator_url' => 'https://fco.neednavigator.test']);

    $this->artisan('sites:setting site-a form_recipients \'["a@example.test","b@example.test"]\' --json')
        ->assertSuccessful();

    expect(Site::query()->where('slug', 'site-a')->first()->settings['form_recipients'])
        ->toBe(['a@example.test', 'b@example.test']);

    $this->artisan('sites:setting site-a need_navigator_url --unset')->assertSuccessful();

    expect(Site::query()->where('slug', 'site-a')->first()->settings)
        ->toBe(['locales' => ['es'], 'form_recipients' => ['a@example.test', 'b@example.test']]);
});

it('refuses to store credential-looking keys in settings', function (): void {
    Site::factory()->create(['slug' => 'site-a']);

    $this->artisan('sites:setting site-a need_navigator_token nn_evt_marker')->assertFailed();

    expect(Site::query()->where('slug', 'site-a')->first()->settings ?? [])->toBe([]);
});

it('rejects a missing value and invalid JSON in sites:setting', function (): void {
    Site::factory()->create(['slug' => 'site-a']);

    $this->artisan('sites:setting site-a locales')->assertFailed();
    $this->artisan('sites:setting site-a locales "[es" --json')->assertFailed();
    $this->artisan('sites:setting nope locales es')->assertFailed();
});
