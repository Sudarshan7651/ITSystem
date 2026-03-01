<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLogin(): View
    {
        return view('auth.admin.login');
    }

    /**
     * Handle admin login attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login only for admin role
        $user = User::where('email', $credentials['email'])
                    ->where('role', 'admin')
                    ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'These credentials do not match our admin records.',
            ])->onlyInput('email');
        }

        if ($user->status === 'inactive') {
            return back()->withErrors([
                'email' => 'Your admin account has been deactivated.',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard(): View
    {
        $stats = [
            'colleges'   => \App\Models\College::count(),
            'departments'=> \App\Models\Department::count(),
            'teachers'   => \App\Models\User::where('role', 'teacher')->count(),
            'courses'    => \App\Models\Course::count(),
            'students'   => \App\Models\User::where('role', 'student')->count(),
            'pending'    => \App\Models\User::where('role', 'student')->where('is_approved', 'not_approved')->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Logout the admin.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
