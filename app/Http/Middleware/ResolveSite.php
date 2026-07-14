<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Domain;
use App\Tenancy\Tenancy;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves the requested hostname to a Site (or 404s), 301s secondary
 * domains to the primary, and switches tenant context for the request.
 * Must run before anything that touches site data or site views.
 */
final class ResolveSite
{
    public function handle(Request $request, Closure $next): Response
    {
        $domain = Domain::query()
            ->with('site.domains')
            ->where('hostname', strtolower($request->getHost()))
            ->first();

        abort_if($domain === null, 404);

        $site = $domain->site;

        if (! $domain->is_primary && $domain->redirect_to_primary) {
            $primary = $site->primaryDomain();

            if ($primary !== null && $primary->hostname !== $domain->hostname) {
                return redirect()->to(
                    $request->getScheme().'://'.$primary->hostname.$request->getRequestUri(),
                    301
                );
            }
        }

        Tenancy::makeCurrent($site);

        return $next($request);
    }
}
