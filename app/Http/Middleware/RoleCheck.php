<?php

namespace App\Http\Middleware;

use Closure;

class RoleCheck
{
    public function handle($request, Closure $next, $role) {
        if (!$request->user()) {
            return response()->unauthenticated();
        }
        if (!$request->user()->hasRole($role)) {
            return response()->forbidden();
        }

        return $next($request);
    }
}
