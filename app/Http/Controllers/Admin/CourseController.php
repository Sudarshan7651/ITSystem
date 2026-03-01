<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('department.college')->withCount('classes');

        if ($request->filled('search')) {
            $s = '%' . $request->search . '%';
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)->orWhere('short_name', 'like', $s);
            });
        }
        if ($request->filled('department_id'))
            $query->where('department_id', $request->department_id);
        elseif ($request->filled('college_id'))
            $query->whereHas('department', fn($q) => $q->where('college_id', $request->college_id));
        if ($request->filled('status'))
            $query->where('status', $request->status);

        $courses     = $query->latest()->paginate(15)->withQueryString();
        $colleges    = College::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('admin.courses.index', compact('courses', 'colleges', 'departments'));
    }

    public function create()
    {
        $colleges    = College::where('status', 'active')->get();
        $departments = Department::with('college')->where('status', 'active')->get();
        return view('admin.courses.create', compact('colleges', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id'  => 'required|exists:departments,id',
            'name'           => 'required|string|max:255',
            'short_name'     => 'nullable|string|max:50',
            'duration_years' => 'required|integer|min:1|max:10',
            'status'         => 'required|in:active,inactive',
        ]);

        $course = Course::create($data);
        $this->generateClasses($course);

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course created successfully with ' . $course->duration_years . ' class(es).');
    }

    public function edit(Course $course)
    {
        $colleges    = College::where('status', 'active')->get();
        $departments = Department::with('college')->where('status', 'active')->get();
        return view('admin.courses.edit', compact('course', 'colleges', 'departments'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'department_id'  => 'required|exists:departments,id',
            'name'           => 'required|string|max:255',
            'short_name'     => 'nullable|string|max:50',
            'duration_years' => 'required|integer|min:1|max:10',
            'status'         => 'required|in:active,inactive',
        ]);

        $oldDuration = $course->duration_years;
        $course->update($data);

        // Regenerate classes only if duration changed
        if ((int) $oldDuration !== (int) $course->duration_years) {
            $course->classes()->delete();
            $this->generateClasses($course);
        }

        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')
                         ->with('success', 'Course deleted successfully.');
    }

    /**
     * Auto-generate class year records based on course duration.
     */
    private function generateClasses(Course $course): void
    {
        $map = [
            1 => [['FY', 'First Year']],
            2 => [['FY', 'First Year'],  ['SY', 'Second Year']],
            3 => [['FY', 'First Year'],  ['SY', 'Second Year'], ['TY', 'Third Year']],
            4 => [['FY', 'First Year'],  ['SY', 'Second Year'], ['TY', 'Third Year'], ['LY', 'Last Year']],
        ];

        $years = $map[$course->duration_years]
            ?? array_map(
                fn($n) => ["Year $n", "Year $n"],
                range(1, $course->duration_years)
            );

        foreach ($years as [$name, $label]) {
            $course->classes()->create([
                'name'   => $name,
                'label'  => $label,
                'status' => 'active',
            ]);
        }
    }
}
