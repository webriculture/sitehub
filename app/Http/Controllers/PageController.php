<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * Serves a site's pages from its Blade templates:
 * `/` -> site::pages.home, `/about` -> site::pages.about,
 * `/pages/history` -> site::pages.pages.history (flattened legacy sites
 * keep their /pages/{slug} URLs; the template tree mirrors the URL tree).
 */
final class PageController
{
    public function __invoke(Request $request, string $path = ''): mixed
    {
        $path = trim($path, '/');

        // Platform-wide rule: the legacy home URL permanently moved to `/`.
        if ($path === 'pages/home') {
            return redirect('/', 301);
        }

        $template = $this->templateFor($path);

        abort_if($template === null || ! View::exists("site::pages.{$template}"), 404);

        return view("site::pages.{$template}");
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
