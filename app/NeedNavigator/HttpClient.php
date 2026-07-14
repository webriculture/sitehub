<?php

declare(strict_types=1);

namespace App\NeedNavigator;

use App\Models\Site;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Real Need Navigator API driver. Endpoint and auth details are
 * config/secret driven so per-environment wiring never touches code:
 * base URL in config, per-site bearer token in the site's encrypted
 * secrets under `need_navigator_token`.
 */
final class HttpClient implements NeedNavigatorClient
{
    public function events(Site $site): array
    {
        $baseUrl = config('sitehub.need_navigator.base_url');
        $token = $site->secret('need_navigator_token');

        if (! is_string($baseUrl) || $baseUrl === '') {
            throw new RuntimeException('Need Navigator base URL is not configured (NEED_NAVIGATOR_URL).');
        }

        if ($token === null) {
            throw new RuntimeException("Site [{$site->slug}] has no need_navigator_token secret.");
        }

        $response = Http::baseUrl($baseUrl)
            ->withToken($token)
            ->acceptJson()
            ->timeout(15)
            ->retry(2, 500)
            ->get('/api/v1/events');

        $response->throw();

        $items = $response->json('data') ?? $response->json();

        if (! is_array($items)) {
            throw new RuntimeException('Unexpected Need Navigator events payload shape.');
        }

        return array_values($items);
    }
}
