<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class TeacherProfileController extends Controller
{
    /**
     * Show the teacher's profile page.
     */
    public function show(): View
    {
        $user        = auth()->user()->load('department.college');
        $departments = Department::where('status', 'active')->orderBy('name')->get();
        return view('teacher.profile', compact('user', 'departments'));
    }

    /**
     * Update the teacher's profile details.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:20'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'employee_id'   => ['required', 'string', 'max:50', 'unique:users,employee_id,' . $user->id],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the teacher's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])
                         ->with('tab', 'password');
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully!')->with('tab', 'password');
    }

    /**
     * Delete the teacher's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $user = auth()->user();

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password confirmation failed.'])
                         ->with('tab', 'danger');
        }

        auth()->logout();
        $user->tokens()->delete();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('teacher.login')
            ->with('success', 'Your account has been deleted.');
    }
}
