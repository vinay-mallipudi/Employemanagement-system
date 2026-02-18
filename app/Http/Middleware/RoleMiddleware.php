<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($role === 'admin' && !$user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        if ($role === 'employee' && !$user->isEmployee() && !$user->isAdmin()) {
            // Admins can access employee routes, but employees can't access admin routes
             abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
