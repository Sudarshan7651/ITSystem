@extends('admin.layout.app')
@section('title', 'Edit Course')

@section('content')
<div class="page-header">
    <h1>Edit Course</h1>
    <p>Update course details</p>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.courses.update', $course) }}">
        @csrf @method('PUT')
        <div class="form-grid">

            {{-- Step 1: Pick College --}}
            <div class="form-group full">
                <label for="college_id">College *</label>
                <select id="college_id" name="college_id" required>
                    <option value="">— Select College —</option>
                    @foreach($colleges as $college)
                        {{-- Pre-select the college of the current course's department --}}
                        <option value="{{ $college->id }}"
                            {{ old('college_id', $course->department->college_id ?? '') == $college->id ? 'selected' : '' }}>
                            {{ $college->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Step 2: Department filtered by JS --}}
            <div class="form-group full">
                <label for="department_id">Department *</label>
                <select id="department_id" name="department_id" required>
                    <option value="">— Select College first —</option>
                    @foreach($departments as $dept)
                        <option
                            value="{{ $dept->id }}"
                            data-college="{{ $dept->college_id }}"
                            {{ old('department_id', $course->department_id) == $dept->id ? 'selected' : '' }}
                            style="display:none"
                        >
                            {{ $dept->name }}@if($dept->short_name) ({{ $dept->short_name }})@endif
                        </option>
                    @endforeach
                </select>
                @error('department_id') <span class="input-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full">
                <label for="name">Course Name *</label>
                <input id="name" type="text" name="name" value="{{ old('name', $course->name) }}" required>
                @error('name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="short_name">Short Name</label>
                <input id="short_name" type="text" name="short_name" value="{{ old('short_name', $course->short_name) }}">
                @error('short_name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="duration_years">Duration (Years) *</label>
                <input id="duration_years" type="number" name="duration_years" value="{{ old('duration_years', $course->duration_years) }}" min="1" max="10" required>
                @error('duration_years') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="active"   {{ old('status', $course->status) == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $course->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <span class="input-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Course</button>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
(function () {
    const collegeSelect  = document.getElementById('college_id');
    const deptSelect     = document.getElementById('department_id');
    const allDeptOptions = Array.from(deptSelect.querySelectorAll('option[data-college]'));

    function filterDepts(selectedCollegeId, preserveDept) {
        deptSelect.querySelector('option[value=""]').textContent =
            selectedCollegeId ? '— Select Department —' : '— Select College first —';

        let visibleCount = 0;
        allDeptOptions.forEach(opt => {
            const match = opt.dataset.college === selectedCollegeId;
            opt.style.display = match ? '' : 'none';
            if (!match && opt.selected && !preserveDept) {
                opt.selected = false;
                deptSelect.value = '';
            }
            if (match) visibleCount++;
        });

        deptSelect.disabled = visibleCount === 0;
    }

    collegeSelect.addEventListener('change', function () {
        filterDepts(this.value, false);
    });

    // On page load: show the departments for the already-selected college
    const initialCollege = collegeSelect.value;
    if (initialCollege) {
        filterDepts(initialCollege, true); // true = preserve the current dept selection
    } else {
        filterDepts('', false);
    }
})();
</script>
@endsection
