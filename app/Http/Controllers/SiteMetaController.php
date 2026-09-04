<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Response;
use Symfony\Component\Finder\Finder;

/**
 * Platform-uniform robots.txt and sitemap.xml for every site.
 * The sitemap is derived from the site's page templates on disk —
 * pages-as-code means the filesystem IS the page registry.
 */
final class SiteMetaController
{
    public function robots(Site $site): Response
    {
        $primary = $site->primaryDomain()?->hostname;

        // Only the primary domain invites indexing. Non-primary hosts stay
        // crawlable on purpose: ResolveSite stamps X-Robots-Tag: noindex on
        // their responses, and a Disallow here would hide that header from
        // crawlers (robots.txt blocks crawling, not indexing).
        if ($primary !== null && request()->getHost() !== $primary) {
            return response("User-agent: *\nAllow: /\n", 200, ['Content-Type' => 'text/plain']);
        }

        $lines = ['User-agent: *', 'Allow: /'];

        if ($primary !== null) {
            $lines[] = 'Sitemap: https://'.$primary.'/sitemap.xml';
        }

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain']);
    }

    /**
     * Per-site /llms.txt — a plain-text product/site summary for AI
     * assistants, authored alongside the site's pages. 404 when a site
     * hasn't written one.
     */
    public function llms(Site $site): Response
    {
        $file = $site->viewPath().'/llms.txt';

        abort_unless(is_file($file), 404);

        return response((string) file_get_contents($file), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function sitemap(Site $site): Response
    {
        $primary = $site->primaryDomain()?->hostname ?? 'localhost';

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($this->pageUrls($site) as [$url, $lastmod]) {
            $xml .= '  <url><loc>https://'.$primary.$url.'</loc><lastmod>'.$lastmod.'</lastmod></url>'."\n";
        }

        $xml .= '</urlset>'."\n";

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    /** @return list<array{string, string}> */
    private function pageUrls(Site $site): array
    {
        $pagesPath = $site->viewPath().'/pages';

        if (! is_dir($pagesPath)) {
            return [];
        }

        $urls = [];

        $extraLocales = $site->extraLocales();

        foreach (Finder::create()->files()->in($pagesPath)->name('*.blade.php') as $file) {
            $relative = str_replace('.blade.php', '', $file->getRelativePathname());
            $relative = str_replace(DIRECTORY_SEPARATOR, '/', $relative);

            // Locale home pages live at the locale root: es/home -> /es
            foreach ($extraLocales as $locale) {
                if ($relative === $locale.'/home') {
                    $relative = $locale;
                    break;
                }
            }

            $url = $relative === 'home' ? '/' : '/'.$relative;

            $urls[$url] = [$url, date('Y-m-d', $file->getMTime())];
        }

        ksort($urls);

        return array_values($urls);
    }
}
