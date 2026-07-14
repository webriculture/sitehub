<?php

declare(strict_types=1);

use App\Models\Tenant\Event;
use App\Tenancy\Tenancy;
use Illuminate\Support\Facades\Blade;
use Tests\Concerns\ProvisionsSites;

uses(ProvisionsSites::class);

afterEach(fn () => $this->cleanupProvisionedSites());

it('syncs stub events idempotently and prunes stale ones', function (): void {
    $site = $this->provisionSite('ev-a', ['events']);

    $this->artisan('events:sync --site=ev-a')->assertSuccessful();

    Tenancy::makeCurrent($site);
    expect(Event::query()->count())->toBe(2);

    // Re-running must not duplicate.
    $this->artisan('events:sync --site=ev-a')->assertSuccessful();
    Tenancy::makeCurrent($site);
    expect(Event::query()->count())->toBe(2);

    // An event no longer in the feed gets pruned.
    Event::query()->create([
        'external_id' => 'stale-1',
        'title' => ['en' => 'Old Event'],
        'starts_at' => now()->addDay(),
        'synced_at' => now(),
    ]);

    $this->artisan('events:sync --site=ev-a')->assertSuccessful();
    Tenancy::makeCurrent($site);

    expect(Event::query()->count())->toBe(2)
        ->and(Event::query()->where('external_id', 'stale-1')->exists())->toBeFalse();
});

it('skips sites without the events feature', function (): void {
    $this->provisionSite('ev-b');

    $this->artisan('events:sync --site=ev-b')
        ->expectsOutputToContain('No sites with the events feature.')
        ->assertSuccessful();
});

it('renders upcoming events bilingually through the component', function (): void {
    $site = $this->provisionSite('ev-c', ['events']);

    $this->artisan('events:sync --site=ev-c')->assertSuccessful();

    Tenancy::makeCurrent($site);

    $html = Blade::render('<x-site-events />');

    expect($html)
        ->toContain('FRAN Center Open House')
        ->toContain('Positive Parenting Workshop');

    app()->setLocale('es');

    expect(Blade::render('<x-site-events />'))
        ->toContain('Casa Abierta del Centro FRAN')
        ->toContain('Taller de Crianza Positiva');

    app()->setLocale('en');
});

it('renders nothing when the events feature is disabled', function (): void {
    $site = $this->provisionSite('ev-d');
    Tenancy::makeCurrent($site);

    expect(trim(Blade::render('<x-site-events />')))->toBe('');
});
