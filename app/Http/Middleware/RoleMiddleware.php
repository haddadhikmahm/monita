<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            abort(401);
        }

        if (! in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized action. Your role does not have access to this resource.');
        }

        return $next($request);
    }
}
