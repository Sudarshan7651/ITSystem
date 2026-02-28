<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     * Only allows users with role = 'teacher' to pass through.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isTeacher()) {
            abort(403, 'Access denied. Teachers only.');
        }

        if (! auth()->user()->isActive()) {
            auth()->logout();
            return redirect()->route('teacher.login')
                ->withErrors(['account' => 'Your account has been deactivated.']);
        }

        return $next($request);
    }
}
