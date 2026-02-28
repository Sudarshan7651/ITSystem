<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Only allows users with role = 'admin' to pass through.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403, 'Access denied. Admins only.');
        }

        if (! auth()->user()->isActive()) {
            auth()->logout();
            return redirect()->route('admin.login')
                ->withErrors(['account' => 'Your account has been deactivated.']);
        }

        return $next($request);
    }
}
