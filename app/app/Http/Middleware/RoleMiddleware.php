<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Your middleware logic goes here
        // You can check the role and perform necessary actions
        // For example, check if the authenticated user has the specified role

        if ($request->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
