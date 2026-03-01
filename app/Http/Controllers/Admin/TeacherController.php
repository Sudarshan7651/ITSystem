<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'teacher')->with('department.college');

        if ($request->filled('search')) {
            $s = '%' . $request->search . '%';
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)
                  ->orWhere('email', 'like', $s)
                  ->orWhere('employee_id', 'like', $s);
            });
        }
        if ($request->filled('status'))
            $query->where('status', $request->status);

        $teachers = $query->latest()->paginate(15)->withQueryString();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'phone'       => 'nullable|string|max:20',
            'employee_id' => 'nullable|string|max:100|unique:users,employee_id',
            'status'      => 'required|in:active,inactive',
        ]);

        $data['role']     = 'teacher';
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher created successfully.');
    }

    public function edit(User $teacher)
    {
        abort_if($teacher->role !== 'teacher', 404);
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        abort_if($teacher->role !== 'teacher', 404);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $teacher->id,
            'password'    => 'nullable|string|min:8|confirmed',
            'phone'       => 'nullable|string|max:20',
            'employee_id' => 'nullable|string|max:100|unique:users,employee_id,' . $teacher->id,
            'status'      => 'required|in:active,inactive',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $teacher->update($data);

        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(User $teacher)
    {
        abort_if($teacher->role !== 'teacher', 404);
        $teacher->delete();
        return redirect()->route('admin.teachers.index')
                         ->with('success', 'Teacher deleted successfully.');
    }
}
