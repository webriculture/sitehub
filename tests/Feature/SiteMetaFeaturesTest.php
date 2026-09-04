<?php

declare(strict_types=1);

use App\Models\Site;

function registerMetaSite(string $slug, array $settings = []): Site
{
    $site = Site::factory()->create(['slug' => $slug, 'settings' => $settings]);
    $site->domains()->create(['hostname' => $slug.'.test', 'is_primary' => true]);

    return $site;
}

it('stamps noindex on every non-primary host response and none on the primary', function (): void {
    $site = registerMetaSite('site-a');
    $site->domains()->create(['hostname' => 'staging.site-a.test', 'redirect_to_primary' => false]);

    $this->get('http://staging.site-a.test/')
        ->assertOk()
        ->assertHeader('X-Robots-Tag', 'noindex, nofollow');

    $this->get('http://site-a.test/')
        ->assertOk()
        ->assertHeaderMissing('X-Robots-Tag');
});

it('serves a per-site llms.txt when the site has authored one', function (): void {
    registerMetaSite('neednavigator');

    $this->get('http://neednavigator.test/llms.txt')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSee('Need Navigator', escape: false);
});

it('404s llms.txt for a site without one', function (): void {
    registerMetaSite('site-a');

    $this->get('http://site-a.test/llms.txt')->assertNotFound();
});

it('301s legacy URLs through the site redirect map', function (): void {
    registerMetaSite('site-a', ['redirects' => ['/pages/old-thing' => '/about']]);

    $this->get('http://site-a.test/pages/old-thing')
        ->assertStatus(301)
        ->assertRedirect('/about');
});

it('never lets the redirect map shadow an existing template', function (): void {
    registerMetaSite('site-a', ['redirects' => ['/about' => '/']]);

    $this->get('http://site-a.test/about')->assertOk()->assertSee('About Site A');
});

it('404s unmapped missing pages even when a redirect map exists', function (): void {
    registerMetaSite('site-a', ['redirects' => ['/pages/old-thing' => '/about']]);

    $this->get('http://site-a.test/pages/other-thing')->assertNotFound();
});
