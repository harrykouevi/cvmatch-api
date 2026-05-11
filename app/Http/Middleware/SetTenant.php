<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = auth()->user()?->tenant_id;

        if ($tenantId) {
            app()->instance('tenant_id', $tenantId);
        }

        return $next($request);
    }
}
