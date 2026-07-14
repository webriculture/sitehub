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
    registerSite('site-a');

    $this->get('http://site-a.test/robots.txt')
        ->assertOk()
        ->assertSee('Sitemap: https://site-a.test/sitemap.xml', escape: false);

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
