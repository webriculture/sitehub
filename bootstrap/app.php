<?php

declare(strict_types=1);

use App\Http\Middleware\ResolveSite;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\ResponseCache\Middlewares\CacheResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Order matters: cached responses short-circuit before tenant
        // resolution (cache keys include the hostname); everything past
        // CacheResponse runs with the site bound and tenant DB connected.
        $middleware->web(prepend: [
            CacheResponse::class,
            ResolveSite::class,
        ]);

        $middleware->web(append: [
            SecurityHeaders::class,
        ]);

        // Public form posts come from response-cached pages whose CSRF tokens
        // go stale; Turnstile + honeypot protect this unauthenticated route.
        $middleware->validateCsrfTokens(except: [
            'forms/*',
        ]);

        // Route middleware is sorted by the priority list; without this,
        // ResolveSite lands AFTER Filament's Authenticate and no site is
        // bound when canAccessPanel() checks membership.
        $middleware->prependToPriorityList(
            before: Authenticate::class,
            prepend: ResolveSite::class,
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
