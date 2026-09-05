<?php

declare(strict_types=1);

use App\Models\Site;
use Symfony\Component\Finder\Finder;

function registerSite(string $slug): Site
{
    $site = Site::factory()->create(['slug' => $slug]);
    $site->domains()->create(['hostname' => $slug.'.test', 'is_primary' => true]);

    return $site;
}

it('serves nested page templates by URL path', function (): void {
    registerSite('site-a');

    $this->get('http://site-a.test/about')->assertOk()->assertSee('About Site A');
});

it('404s a missing page', function (): void {
    registerSite('site-a');

    $this->get('http://site-a.test/nope')->assertNotFound();
});

it('404s malformed path segments', function (): void {
    registerSite('site-a');

    $this->get('http://site-a.test/.hidden')->assertNotFound();
    $this->get('http://site-a.test/foo.bar/baz')->assertNotFound();
});

it('permanently redirects the legacy home URL to root', function (): void {
    registerSite('site-a');

    $this->get('http://site-a.test/pages/home')
        ->assertStatus(301)
        ->assertRedirect('http://site-a.test');
});

it('serves robots.txt and sitemap.xml per site', function (): void {
    $site = registerSite('site-a');

    $this->get('http://site-a.test/robots.txt')
        ->assertOk()
        ->assertSee('Sitemap: https://site-a.test/sitemap.xml', escape: false);

    // Non-primary hostnames must refuse indexing — via the X-Robots-Tag
    // header, with robots.txt left crawlable so crawlers can see it.
    $site->domains()->create(['hostname' => 'staging.site-a.test', 'redirect_to_primary' => false]);

    $this->get('http://staging.site-a.test/robots.txt')
        ->assertOk()
        ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
        ->assertSee('Allow: /', escape: false)
        ->assertDontSee('Sitemap:');

    $this->get('http://site-a.test/sitemap.xml')
        ->assertOk()
        ->assertSee('<loc>https://site-a.test/</loc>', escape: false)
        ->assertSee('<loc>https://site-a.test/about</loc>', escape: false);
});

it('smoke: every committed page of every site renders', function (): void {
    foreach (glob(resource_path('sites/*'), GLOB_ONLYDIR) as $dir) {
        $slug = basename($dir);
        registerSite($slug);

        if (! is_dir($dir.'/pages')) {
            continue;
        }

        foreach (Finder::create()->files()->in($dir.'/pages')->name('*.blade.php') as $file) {
            $relative = str_replace('.blade.php', '', $file->getRelativePathname());
            $url = $relative === 'home' ? '/' : '/'.str_replace(DIRECTORY_SEPARATOR, '/', $relative);

            $this->get('http://'.$slug.'.test'.$url)->assertOk();
        }
    }
});

it('301s legacy URLs via the site redirect map, exact keys first then longest prefix', function (): void {
    $site = registerSite('site-a');
    $site->update(['settings' => ['redirects' => [
        '/resources/display/classes' => '/classes',
        '/resources/display/*' => '/resources',
        '/courses/view/*' => '/classes',
        '/courses/*' => '/about',
    ]]]);

    $this->get('http://site-a.test/resources/display/classes')->assertStatus(301)->assertRedirect('/classes');
    $this->get('http://site-a.test/resources/display/anything_else')->assertStatus(301)->assertRedirect('/resources');
    $this->get('http://site-a.test/courses/view/some-long-legacy-slug')->assertStatus(301)->assertRedirect('/classes');
    $this->get('http://site-a.test/courses/index')->assertStatus(301)->assertRedirect('/about');
    $this->get('http://site-a.test/courses')->assertNotFound(); // "/courses/*" needs something below it
    $this->get('http://site-a.test/about')->assertOk(); // existing templates always win over the map
});

it('sends 302 from the redirect map when a site opts into a soft cutover', function (): void {
    $site = registerSite('site-a');
    $site->update(['settings' => ['redirect_status' => 302, 'redirects' => ['/pages/old' => '/about']]]);

    $this->get('http://site-a.test/pages/old')->assertStatus(302)->assertRedirect('/about');
    $this->get('http://site-a.test/pages/home')->assertStatus(301); // platform rule, never per-site
});

it('reads redirect_status as sites:setting stores it, a string', function (): void {
    $site = registerSite('site-a');
    $site->update(['settings' => ['redirect_status' => '302', 'redirects' => ['/pages/old' => '/about']]]);

    $this->get('http://site-a.test/pages/old')->assertStatus(302);
});

it('falls back to 301 for any redirect_status other than 301 or 302', function (): void {
    $site = registerSite('site-a');
    $site->update(['settings' => ['redirect_status' => 418, 'redirects' => ['/pages/old' => '/about']]]);

    $this->get('http://site-a.test/pages/old')->assertStatus(301);
});
