<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassYear;
use App\Models\College;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class ClassYearController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassYear::with('course.department.college');

        if ($request->filled('search')) {
            $s = '%' . $request->search . '%';
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)->orWhere('label', 'like', $s);
            });
        }
        if ($request->filled('course_id'))
            $query->where('course_id', $request->course_id);
        elseif ($request->filled('department_id'))
            $query->whereHas('course', fn($q) => $q->where('department_id', $request->department_id));
        elseif ($request->filled('college_id'))
            $query->whereHas('course.department', fn($q) => $q->where('college_id', $request->college_id));
        if ($request->filled('status'))
            $query->where('status', $request->status);

        $classes     = $query->latest()->paginate(20)->withQueryString();
        $colleges    = College::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $courses     = Course::orderBy('name')->get();
        return view('admin.classes.index', compact('classes', 'colleges', 'departments', 'courses'));
    }

    public function create()
    {
        $colleges    = College::where('status', 'active')->get();
        $departments = Department::with('college')->where('status', 'active')->get();
        $courses     = Course::with('department.college')->where('status', 'active')->get();
        return view('admin.classes.create', compact('colleges', 'departments', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name'      => 'required|string|max:50',
            'label'     => 'nullable|string|max:100',
            'status'    => 'required|in:active,inactive',
        ]);

        ClassYear::create($data);

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Class created successfully.');
    }

    public function edit(ClassYear $class)
    {
        $colleges    = College::where('status', 'active')->get();
        $departments = Department::with('college')->where('status', 'active')->get();
        $courses     = Course::with('department.college')->where('status', 'active')->get();
        return view('admin.classes.edit', compact('class', 'colleges', 'departments', 'courses'));
    }

    public function update(Request $request, ClassYear $class)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name'      => 'required|string|max:50',
            'label'     => 'nullable|string|max:100',
            'status'    => 'required|in:active,inactive',
        ]);

        $class->update($data);

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Class updated successfully.');
    }

    public function destroy(ClassYear $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')
                         ->with('success', 'Class deleted successfully.');
    }
}
