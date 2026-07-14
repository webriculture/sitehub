<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\FormSubmissionReceived;
use App\Models\Tenant\Submission;
use App\Support\Turnstile;
use App\Tenancy\Tenancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Public form intake. Cache-coherent by design: feedback travels via query
 * parameters (?sent= / ?error=) so responses never depend on session flash
 * that a cached page would swallow. CSRF is deliberately exempted for this
 * route (cached pages hold stale tokens); Turnstile + honeypot are the
 * protection, and failures are user-visible — never silent.
 */
final class FormSubmissionController
{
    public function __invoke(Request $request, string $key): RedirectResponse
    {
        $site = Tenancy::current();

        abort_unless($site !== null && $site->hasFeature('forms'), 404);

        $back = $this->backUrl($request);

        // Honeypot: bots fill it, humans never see it. Pretend success.
        if ($request->filled('website')) {
            return redirect()->to($back.'?sent='.$key);
        }

        $secret = $site->secret('turnstile_secret') ?? config('services.turnstile.secret');

        if (! Turnstile::verify($secret, $request->input('cf-turnstile-response'), $request->ip())) {
            return redirect()->to($back.'?error=verification');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return redirect()->to($back.'?error=validation');
        }

        $payload = $validator->validated();

        Submission::query()->create([
            'form_key' => $key,
            'payload' => $payload,
        ]);

        $recipients = array_filter((array) ($site->settings['form_recipients'] ?? []));

        if ($recipients !== []) {
            Mail::to($recipients)->send(new FormSubmissionReceived($site, $key, $payload));
        }

        return redirect()->to($back.'?sent='.$key);
    }

    private function backUrl(Request $request): string
    {
        $referer = $request->headers->get('referer', '/');

        // Same-host paths only; strip any prior feedback params.
        $parts = parse_url($referer);

        $path = ($parts['path'] ?? '/');

        return $path === '' ? '/' : $path;
    }
}
