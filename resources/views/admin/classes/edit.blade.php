@extends('admin.layout.app')
@section('title', 'Edit Class')

@section('content')
<div class="page-header">
    <h1>Edit Class</h1>
    <p>Update class details</p>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.classes.update', $class) }}">
        @csrf @method('PUT')
        <div class="form-grid">

            {{-- Step 1: College (auto-selected from existing class's course→dept→college) --}}
            <div class="form-group full">
                <label for="college_id">College *</label>
                <select id="college_id" name="college_id" required>
                    <option value="">— Select College —</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}"
                            {{ old('college_id', $class->course->department->college_id ?? '') == $college->id ? 'selected' : '' }}>
                            {{ $college->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Step 2: Department (filtered by college) --}}
            <div class="form-group full">
                <label for="department_id">Department *</label>
                <select id="department_id" name="department_id" required disabled>
                    <option value="">— Select College first —</option>
                    @foreach($departments as $dept)
                        <option
                            value="{{ $dept->id }}"
                            data-college="{{ $dept->college_id }}"
                            {{ old('department_id', $class->course->department_id ?? '') == $dept->id ? 'selected' : '' }}
                            style="display:none"
                        >{{ $dept->name }}@if($dept->short_name) ({{ $dept->short_name }})@endif</option>
                    @endforeach
                </select>
            </div>

            {{-- Step 3: Course (filtered by department) --}}
            <div class="form-group full">
                <label for="course_id">Course *</label>
                <select id="course_id" name="course_id" required disabled>
                    <option value="">— Select Department first —</option>
                    @foreach($courses as $course)
                        <option
                            value="{{ $course->id }}"
                            data-department="{{ $course->department_id }}"
                            {{ old('course_id', $class->course_id) == $course->id ? 'selected' : '' }}
                            style="display:none"
                        >{{ $course->name }}@if($course->short_name) ({{ $course->short_name }})@endif</option>
                    @endforeach
                </select>
                @error('course_id') <span class="input-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="name">Class Name *</label>
                <input id="name" type="text" name="name" value="{{ old('name', $class->name) }}" required>
                @error('name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="label">Label</label>
                <input id="label" type="text" name="label" value="{{ old('label', $class->label) }}">
                @error('label') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="active"   {{ old('status', $class->status) == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $class->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <span class="input-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Class</button>
            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
(function () {
    const collegeSelect  = document.getElementById('college_id');
    const deptSelect     = document.getElementById('department_id');
    const courseSelect   = document.getElementById('course_id');

    const allDeptOpts   = Array.from(deptSelect.querySelectorAll('option[data-college]'));
    const allCourseOpts = Array.from(courseSelect.querySelectorAll('option[data-department]'));

    function filterDepts(collegeId, preserve) {
        deptSelect.querySelector('option[value=""]').textContent =
            collegeId ? '— Select Department —' : '— Select College first —';

        let count = 0;
        allDeptOpts.forEach(opt => {
            const show = opt.dataset.college === collegeId;
            opt.style.display = show ? '' : 'none';
            if (!show && opt.selected && !preserve) { opt.selected = false; deptSelect.value = ''; }
            if (show) count++;
        });

        deptSelect.disabled = count === 0;
        if (!preserve) filterCourses('', false);
    }

    function filterCourses(deptId, preserve) {
        courseSelect.querySelector('option[value=""]').textContent =
            deptId ? '— Select Course —' : '— Select Department first —';

        let count = 0;
        allCourseOpts.forEach(opt => {
            const show = opt.dataset.department === deptId;
            opt.style.display = show ? '' : 'none';
            if (!show && opt.selected && !preserve) { opt.selected = false; courseSelect.value = ''; }
            if (show) count++;
        });

        courseSelect.disabled = count === 0;
    }

    collegeSelect.addEventListener('change', function () { filterDepts(this.value, false); });
    deptSelect.addEventListener('change',    function () { filterCourses(this.value, false); });

    // On page load — restore existing selections
    const initCollege = collegeSelect.value;
    const initDept    = deptSelect.options[deptSelect.selectedIndex]?.value || '';
    const initCourse  = courseSelect.options[courseSelect.selectedIndex]?.value || '';

    if (initCollege) {
        filterDepts(initCollege, true);
        if (initDept) {
            deptSelect.value = initDept;
            filterCourses(initDept, true);
            if (initCourse) courseSelect.value = initCourse;
        }
    } else {
        filterDepts('', false);
    }
})();
</script>
@endsection
