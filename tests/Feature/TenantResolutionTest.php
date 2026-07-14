<?php

declare(strict_types=1);

use App\Models\Site;

it('returns 404 for an unknown hostname', function (): void {
    $this->get('http://unknown-host.test/')->assertNotFound();
});

it('serves each site its own pages', function (): void {
    Site::factory()
        ->create(['slug' => 'site-a', 'name' => 'Site A'])
        ->domains()->create(['hostname' => 'site-a.test', 'is_primary' => true]);

    Site::factory()
        ->create(['slug' => 'site-b', 'name' => 'Site B'])
        ->domains()->create(['hostname' => 'site-b.test', 'is_primary' => true]);

    $this->get('http://site-a.test/')->assertOk()->assertSee('Site A');
    $this->get('http://site-b.test/')->assertOk()->assertSee('Site B');
    $this->get('http://site-b.test/')->assertDontSee('Site A');
});

it('301s a secondary domain to the primary, preserving the path', function (): void {
    $site = Site::factory()->create(['slug' => 'site-a']);
    $site->domains()->create(['hostname' => 'site-a.test', 'is_primary' => true]);
    $site->domains()->create(['hostname' => 'www.site-a.test', 'redirect_to_primary' => true]);

    $this->get('http://www.site-a.test/about?x=1')
        ->assertStatus(301)
        ->assertRedirect('http://site-a.test/about?x=1');
});

it('serves a secondary domain directly when redirect is disabled', function (): void {
    $site = Site::factory()->create(['slug' => 'site-a', 'name' => 'Site A']);
    $site->domains()->create(['hostname' => 'site-a.test', 'is_primary' => true]);
    $site->domains()->create(['hostname' => 'alias.test', 'redirect_to_primary' => false]);

    $this->get('http://alias.test/')->assertOk()->assertSee('Site A');
});
