<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with('college')->withCount('courses');

        if ($request->filled('search'))
            $query->where('name', 'like', '%' . $request->search . '%');
        if ($request->filled('college_id'))
            $query->where('college_id', $request->college_id);
        if ($request->filled('status'))
            $query->where('status', $request->status);

        $departments = $query->latest()->paginate(15)->withQueryString();
        $colleges    = College::orderBy('name')->get();
        return view('admin.departments.index', compact('departments', 'colleges'));
    }

    public function create()
    {
        $colleges = College::where('status', 'active')->get();
        return view('admin.departments.create', compact('colleges'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name'       => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'status'     => 'required|in:active,inactive',
        ]);

        Department::create($data);

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        $colleges = College::where('status', 'active')->get();
        return view('admin.departments.edit', compact('department', 'colleges'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name'       => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'status'     => 'required|in:active,inactive',
        ]);

        $department->update($data);

        return redirect()->route('admin.departments.index')
                         ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')
                         ->with('success', 'Department deleted successfully.');
    }
}
