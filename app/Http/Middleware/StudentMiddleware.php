<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     * Only allows users with role = 'student' to pass through.
     * Also blocks students who are not yet approved.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isStudent()) {
            abort(403, 'Access denied. Students only.');
        }

        if (! auth()->user()->isActive()) {
            auth()->logout();
            return redirect()->route('student.login')
                ->withErrors(['account' => 'Your account has been deactivated.']);
        }

        if (! auth()->user()->isApproved()) {
            auth()->logout();
            return redirect()->route('student.login')
                ->withErrors(['account' => 'Your account is pending admin approval. Please wait.']);
        }

        return $next($request);
    }
}
