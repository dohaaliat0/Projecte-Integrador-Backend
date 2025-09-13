<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::authenticate() && Auth::user()->role !== $role) {
            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }

        

        return $next($request);
    }
}


