<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountryMiddleware
{
    /**
     * Valid country subdomains for UI purposes only
     */
    protected const SUBDOMAINS = ['usa', 'canada', 'aus'];

    /**
     * Handle an incoming request.
     *
     * NOTE: Subdomains are now used for UI/routing purposes only.
     * Database filtering is now based on country/state/city form fields, not subdomains.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Extract subdomain from host for UI routing purposes
        $host = $request->getHost();
        $parts = explode('.', $host);
        $subdomain = count($parts) > 1 ? strtolower($parts[0]) : null;

        // Store subdomain in request for UI routing (not for database filtering)
        if ($subdomain && in_array($subdomain, self::SUBDOMAINS, true)) {
            $request->attributes->set('subdomain', $subdomain);
        } else {
            $request->attributes->set('subdomain', null);
        }

        // Do NOT set session('country') based on subdomain
        // Country filtering now happens via form fields and explicit queries

        return $next($request);
    }
}
