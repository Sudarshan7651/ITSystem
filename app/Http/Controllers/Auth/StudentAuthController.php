<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ClassYear;
use App\Models\College;
use App\Models\Department;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class StudentAuthController extends Controller
{
    /**
     * Show the student login form.
     */
    public function showLogin(): View
    {
        return view('auth.student.login');
    }

    /**
     * Handle student login attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])
                    ->where('role', 'student')
                    ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'These credentials do not match our student records.',
            ])->onlyInput('email');
        }

        if ($user->status === 'inactive') {
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Contact the administrator.',
            ])->onlyInput('email');
        }

        if ($user->is_approved === 'not_approved') {
            return back()->withErrors([
                'email' => 'Your account is pending approval. Please wait for an administrator to approve your registration.',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('student.dashboard');
    }

    /**
     * Show the student registration form with colleges, departments & courses as JSON for cascading dropdowns.
     */
    public function showRegister(): View
    {
        $colleges    = College::where('status', 'active')->orderBy('name')->get();
        $departments = Department::where('status', 'active')->orderBy('name')->get();
        $courses     = Course::where('status', 'active')->orderBy('name')->get();
        $classes     = ClassYear::where('status', 'active')->get();

        return view('auth.student.register', compact('colleges', 'departments', 'courses', 'classes'));
    }

    /**
     * Handle student registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Password::defaults()],
            'college_id'    => ['required', 'integer', 'exists:colleges,id'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'course_id'     => ['required', 'integer', 'exists:courses,id'],
            'class_id'      => ['required', 'integer', 'exists:classes,id'],
            'roll_number'   => ['required', 'string', 'max:50', 'unique:users,roll_number'],
            'phone'         => ['required', 'string', 'max:20'],
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => 'student',
            'college_id'    => $request->college_id,
            'department_id' => $request->department_id,
            'course_id'     => $request->course_id,
            'class_id'      => $request->class_id,
            'roll_number'   => $request->roll_number,
            'phone'         => $request->phone,
            'status'        => 'active',
            'is_approved'   => 'not_approved',
        ]);

        return redirect()->route('student.login')
            ->with('success', 'Registration successful! Your account is pending Teacher approval. You will be notified once approved.');
    }

    /**
     * Show the student dashboard.
     */
    public function dashboard(): View
    {
        return view('student.dashboard');
    }

    /**
     * Logout the student.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }
}
