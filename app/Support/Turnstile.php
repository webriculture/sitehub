<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Http;

final class Turnstile
{
    /**
     * Verifies a Cloudflare Turnstile token. When no secret is configured
     * (local/dev), verification is skipped — production sites must configure
     * a secret (site-level override or TURNSTILE_SECRET_KEY).
     */
    public static function verify(?string $secret, ?string $token, ?string $ip): bool
    {
        if ($secret === null || $secret === '') {
            return true;
        }

        if ($token === null || $token === '') {
            return false;
        }

        $response = Http::asForm()
            ->timeout(10)
            ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $ip,
            ]);

        return $response->successful() && $response->json('success') === true;
    }
}
