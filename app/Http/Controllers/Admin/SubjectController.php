<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassYear;
use App\Models\College;
use App\Models\Course;
use App\Models\Department;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with('classYear.course.department.college');

        if ($request->filled('search')) {
            $s = '%' . $request->search . '%';
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)->orWhere('code', 'like', $s);
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        } elseif ($request->filled('course_id')) {
            $query->whereHas('classYear', fn($q) => $q->where('course_id', $request->course_id));
        } elseif ($request->filled('department_id')) {
            $query->whereHas('classYear.course', fn($q) => $q->where('department_id', $request->department_id));
        } elseif ($request->filled('college_id')) {
            $query->whereHas('classYear.course.department', fn($q) => $q->where('college_id', $request->college_id));
        }

        if ($request->filled('type'))
            $query->where('type', $request->type);

        if ($request->filled('status'))
            $query->where('status', $request->status);

        $subjects    = $query->latest()->paginate(20)->withQueryString();
        $colleges    = College::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $courses     = Course::orderBy('name')->get();
        $classes     = ClassYear::orderBy('name')->get();

        return view('admin.subjects.index', compact('subjects', 'colleges', 'departments', 'courses', 'classes'));
    }

    public function create()
    {
        $colleges    = College::where('status', 'active')->orderBy('name')->get();
        $departments = Department::with('college')->where('status', 'active')->orderBy('name')->get();
        $courses     = Course::with('department.college')->where('status', 'active')->orderBy('name')->get();
        $classes     = ClassYear::with('course.department.college')->where('status', 'active')->orderBy('name')->get();

        return view('admin.subjects.create', compact('colleges', 'departments', 'courses', 'classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name'     => 'required|string|max:255',
            'code'     => 'nullable|string|max:50',
            'type'     => 'required|in:theory,practical,elective',
            'status'   => 'required|in:active,inactive',
        ]);

        Subject::create($data);

        return redirect()->route('admin.subjects.index')
                         ->with('success', 'Subject added successfully.');
    }

    public function edit(Subject $subject)
    {
        $colleges    = College::where('status', 'active')->orderBy('name')->get();
        $departments = Department::with('college')->where('status', 'active')->orderBy('name')->get();
        $courses     = Course::with('department.college')->where('status', 'active')->orderBy('name')->get();
        $classes     = ClassYear::with('course.department.college')->where('status', 'active')->orderBy('name')->get();

        return view('admin.subjects.edit', compact('subject', 'colleges', 'departments', 'courses', 'classes'));
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name'     => 'required|string|max:255',
            'code'     => 'nullable|string|max:50',
            'type'     => 'required|in:theory,practical,elective',
            'status'   => 'required|in:active,inactive',
        ]);

        $subject->update($data);

        return redirect()->route('admin.subjects.index')
                         ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('admin.subjects.index')
                         ->with('success', 'Subject deleted successfully.');
    }
}
