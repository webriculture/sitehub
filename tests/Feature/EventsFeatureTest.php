<?php

declare(strict_types=1);

use App\Models\Tenant\Event;
use App\Tenancy\Tenancy;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Http;
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

it('caps the rendered feed when a limit is given', function (): void {
    $site = $this->provisionSite('ev-g', ['events']);

    $this->artisan('events:sync --site=ev-g')->assertSuccessful();

    Tenancy::makeCurrent($site);

    // The FRAN home page shows a bounded teaser; /events renders the full feed.
    expect(Event::query()->count())->toBe(2)
        ->and(substr_count(Blade::render('<x-site-events limit="1" />'), 'sh-event__title'))->toBe(1)
        ->and(substr_count(Blade::render('<x-site-events />'), 'sh-event__title'))->toBe(2);
});

it('renders nothing when the events feature is disabled', function (): void {
    $site = $this->provisionSite('ev-d');
    Tenancy::makeCurrent($site);

    expect(trim(Blade::render('<x-site-events />')))->toBe('');
});

it('pulls the http feed from a per-site url override with the site token', function (): void {
    config(['sitehub.need_navigator.driver' => 'http']);

    Http::fake([
        'dev.neednavigator.test/*' => Http::response(['data' => [[
            'id' => 'dev-class-1',
            'kind' => 'class',
            'title' => ['en' => 'Dev Nurturing Parenting', 'es' => 'Crianza con Cariño (Dev)'],
            'starts_at' => now()->addWeek()->toIso8601String(),
            'registration_url' => 'https://dev.neednavigator.test/e/dev-class-1',
        ]]]),
    ]);

    $site = $this->provisionSite('ev-e', ['events']);
    $site->update([
        'settings' => ['need_navigator_url' => 'https://dev.neednavigator.test'],
        'secrets' => ['need_navigator_token' => 'tok_test_override'],
    ]);

    $this->artisan('events:sync --site=ev-e')->assertSuccessful();

    Http::assertSent(fn ($request) => str_starts_with($request->url(), 'https://dev.neednavigator.test/api/v1/events')
        && $request->hasHeader('Authorization', 'Bearer tok_test_override'));

    Tenancy::makeCurrent($site);

    $event = Event::query()->where('external_id', 'dev-class-1')->sole();

    expect($event->kind)->toBe('class')
        ->and($event->registration_url)->toBe('https://dev.neednavigator.test/e/dev-class-1');

    $html = Blade::render('<x-site-events kind="class" />');

    expect($html)->toContain('Dev Nurturing Parenting')
        ->and($html)->toContain('https://dev.neednavigator.test/e/dev-class-1');
});

it('skips feed items without a usable english title', function (): void {
    config(['sitehub.need_navigator.driver' => 'http']);

    Http::fake([
        'dev.neednavigator.test/*' => Http::response(['data' => [
            [
                'id' => 'cls_titleless',
                'kind' => 'class',
                'title' => [],
                'starts_at' => now()->addWeek()->toIso8601String(),
            ],
            [
                'id' => 'cls_good',
                'kind' => 'class',
                'title' => ['en' => 'Named Class'],
                'starts_at' => now()->addWeek()->toIso8601String(),
            ],
        ]]),
    ]);

    $site = $this->provisionSite('ev-f', ['events']);
    $site->update([
        'settings' => ['need_navigator_url' => 'https://dev.neednavigator.test'],
        'secrets' => ['need_navigator_token' => 'tok_test'],
    ]);

    $this->artisan('events:sync --site=ev-f')->assertSuccessful();

    Tenancy::makeCurrent($site);

    expect(Event::query()->pluck('external_id')->all())->toBe(['cls_good']);
});
