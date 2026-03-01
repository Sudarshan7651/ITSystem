@extends('admin.layout.app')
@section('title', 'Add Course')

@section('content')
<div class="page-header">
    <h1>Add Course</h1>
    <p>Create a new course under a department</p>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.courses.store') }}">
        @csrf
        <div class="form-grid">

            {{-- Step 1: Pick College --}}
            <div class="form-group full">
                <label for="college_id">College *</label>
                <select id="college_id" name="college_id" required>
                    <option value="">— Select College —</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>
                            {{ $college->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Step 2: Pick Department (filtered by JS) --}}
            <div class="form-group full">
                <label for="department_id">Department *</label>
                <select id="department_id" name="department_id" required>
                    <option value="">— Select College first —</option>
                    @foreach($departments as $dept)
                        <option
                            value="{{ $dept->id }}"
                            data-college="{{ $dept->college_id }}"
                            {{ old('department_id') == $dept->id ? 'selected' : '' }}
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
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Bachelor of Computer Engineering" required>
                @error('name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="short_name">Short Name</label>
                <input id="short_name" type="text" name="short_name" value="{{ old('short_name') }}" placeholder="e.g. B.E. Comp">
                @error('short_name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="duration_years">Duration (Years) *</label>
                <input id="duration_years" type="number" name="duration_years" value="{{ old('duration_years', 4) }}" min="1" max="10" required>
                <span style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:4px">
                    Classes (FY, SY, TY…) will be auto-created based on duration
                </span>
                @error('duration_years') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="active"   {{ old('status','active') == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <span class="input-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Course</button>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
(function () {
    const collegeSelect    = document.getElementById('college_id');
    const deptSelect       = document.getElementById('department_id');
    const allDeptOptions   = Array.from(deptSelect.querySelectorAll('option[data-college]'));

    function filterDepts(selectedCollegeId) {
        // Reset dept dropdown placeholder
        deptSelect.querySelector('option[value=""]').textContent =
            selectedCollegeId ? '— Select Department —' : '— Select College first —';

        let visibleCount = 0;
        allDeptOptions.forEach(opt => {
            const match = opt.dataset.college === selectedCollegeId;
            opt.style.display = match ? '' : 'none';
            if (!match && opt.selected) {
                opt.selected = false;
                deptSelect.value = '';
            }
            if (match) visibleCount++;
        });

        deptSelect.disabled = visibleCount === 0;
    }

    // On college change
    collegeSelect.addEventListener('change', function () {
        filterDepts(this.value);
    });

    // On page load (restore old() value after validation fail)
    const initialCollege = '{{ old('college_id') }}';
    if (initialCollege) {
        collegeSelect.value = initialCollege;
        filterDepts(initialCollege);
        // Also restore selected department
        const oldDept = '{{ old('department_id') }}';
        if (oldDept) deptSelect.value = oldDept;
    } else {
        filterDepts('');
    }
})();
</script>
@endsection
