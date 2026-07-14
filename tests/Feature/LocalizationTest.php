<?php

declare(strict_types=1);

use App\Models\Site;

function bilingualSite(): Site
{
    $site = Site::factory()->create([
        'slug' => 'fransalem',
        'settings' => ['locales' => ['es']],
    ]);
    $site->domains()->create(['hostname' => 'fransalem.test', 'is_primary' => true]);

    return $site;
}

it('serves the spanish home at /es', function (): void {
    bilingualSite();

    $this->get('http://fransalem.test/es')
        ->assertOk()
        ->assertSee('Un lugar acogedor')
        ->assertSee('lang="es"', escape: false);
});

it('serves english at the root', function (): void {
    bilingualSite();

    $this->get('http://fransalem.test/')
        ->assertOk()
        ->assertSee('A welcoming place')
        ->assertSee('lang="en"', escape: false);
});

it('serves localized subpages under the locale prefix', function (): void {
    bilingualSite();

    $this->get('http://fransalem.test/es/about')->assertOk()->assertSee('Quiénes somos');
    $this->get('http://fransalem.test/about')->assertOk()->assertSee('About FRAN');
});

it('does not treat locale prefixes as locales on sites without them', function (): void {
    $site = Site::factory()->create(['slug' => 'site-a']);
    $site->domains()->create(['hostname' => 'site-a.test', 'is_primary' => true]);

    // site-a has no 'es' locale and no es/ templates: 404, not a fallback.
    $this->get('http://site-a.test/es')->assertNotFound();
});

it('lists locale home pages at the locale root in the sitemap', function (): void {
    bilingualSite();

    $this->get('http://fransalem.test/sitemap.xml')
        ->assertOk()
        ->assertSee('<loc>https://fransalem.test/es</loc>', escape: false)
        ->assertSee('<loc>https://fransalem.test/es/about</loc>', escape: false);
});
