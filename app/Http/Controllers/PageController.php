<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Site;
use App\Tenancy\Tenancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * Serves a site's pages from its Blade templates:
 * `/` -> site::pages.home, `/about` -> site::pages.about,
 * `/pages/history` -> site::pages.pages.history (flattened legacy sites
 * keep their /pages/{slug} URLs; the template tree mirrors the URL tree).
 *
 * Localization: a site may declare extra locales in settings (e.g. ['es']).
 * `/es/...` sets the app locale and prefers `pages/es/...` templates,
 * falling back to the default-locale template (with the locale still set,
 * so components and lang strings translate even before a page is fully
 * translated).
 */
final class PageController
{
    public function __invoke(Request $request, string $path = ''): mixed
    {
        $path = trim($path, '/');
        $site = Tenancy::current();

        [$locale, $path] = $this->splitLocale($site, $path);

        if ($locale !== null) {
            app()->setLocale($locale);
        }

        // Platform-wide rule: the legacy home URL permanently moved to `/`.
        if ($path === 'pages/home') {
            return redirect($locale ? '/'.$locale : '/', 301);
        }

        $template = $this->templateFor($path);

        abort_if($template === null, 404);

        foreach ($this->candidates($template, $locale) as $view) {
            if (View::exists($view)) {
                return view($view);
            }
        }

        abort(404);
    }

    /** @return array{?string, string} */
    private function splitLocale(?Site $site, string $path): array
    {
        if ($site === null || $site->extraLocales() === []) {
            return [null, $path];
        }

        $segments = explode('/', $path, 2);

        if (in_array($segments[0], $site->extraLocales(), true)) {
            return [$segments[0], $segments[1] ?? ''];
        }

        return [null, $path];
    }

    /** @return list<string> */
    private function candidates(string $template, ?string $locale): array
    {
        return $locale === null
            ? ["site::pages.{$template}"]
            : ["site::pages.{$locale}.{$template}", "site::pages.{$template}"];
    }

    private function templateFor(string $path): ?string
    {
        if ($path === '') {
            return 'home';
        }

        $segments = explode('/', $path);

        foreach ($segments as $segment) {
            if (preg_match('/^[a-z0-9][a-z0-9_-]*$/i', $segment) !== 1) {
                return null;
            }
        }

        return implode('.', $segments);
    }
}
