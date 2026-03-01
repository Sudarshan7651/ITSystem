@extends('admin.layout.app')
@section('title', 'Edit Subject')

@push('styles')
<style>
    .cascade-note { font-size: 11px; color: rgba(255,255,255,0.25); margin-top: 3px; }
    .type-pills { display:flex; gap:8px; flex-wrap:wrap; }
    .type-pill  { display:flex; align-items:center; gap:6px; padding:8px 14px; border-radius:8px;
                  border:1px solid rgba(255,255,255,0.1); cursor:pointer; font-size:13px; font-weight:500;
                  color:rgba(255,255,255,0.5); background:rgba(255,255,255,0.03); transition:all 0.15s; }
    .type-pill:hover { background:rgba(255,255,255,0.07); color:#fff; }
    .type-pill.selected-theory    { border-color:#60a5fa; background:rgba(96,165,250,0.12); color:#93c5fd; }
    .type-pill.selected-practical { border-color:#a78bfa; background:rgba(167,139,250,0.12); color:#c4b5fd; }
    .type-pill.selected-elective  { border-color:#fbbf24; background:rgba(251,191,36,0.12);  color:#fcd34d; }
    .type-pill input { display:none; }
</style>
@endpush

@section('content')
@php
    $existingClassYear  = $subject->classYear;
    $existingCourse     = $existingClassYear?->course;
    $existingDept       = $existingCourse?->department;
    $existingCollege    = $existingDept?->college;
    $currentType        = old('type', $subject->type);
@endphp

<div class="page-header">
    <h1>Edit Subject</h1>
    <p>Update subject details.</p>
</div>

<form method="POST" action="{{ route('admin.subjects.update', $subject) }}">
@csrf @method('PATCH')
<div class="form-card" style="max-width:700px;">

    {{-- ── Row 1: College + Department ── --}}
    <div class="form-grid">
        <div class="form-group">
            <label for="college_id">College</label>
            <select id="college_id" name="_college_id">
                <option value="">— Select College —</option>
                @foreach($colleges as $col)
                    <option value="{{ $col->id }}"
                        {{ (old('_college_id', $existingCollege?->id)) == $col->id ? 'selected' : '' }}>
                        {{ $col->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="department_id">Department</label>
            <select id="department_id" name="_department_id">
                <option value="">— Select Department —</option>
                @foreach($departments->where('college_id', $existingCollege?->id) as $d)
                    <option value="{{ $d->id }}"
                        {{ (old('_department_id', $existingDept?->id)) == $d->id ? 'selected' : '' }}>
                        {{ $d->name }}
                    </option>
                @endforeach
            </select>
            <span class="cascade-note">Select a college first.</span>
        </div>
    </div>

    {{-- ── Row 2: Course + Class ── --}}
    <div class="form-grid" style="margin-top:18px;">
        <div class="form-group">
            <label for="course_id">Course</label>
            <select id="course_id" name="_course_id">
                <option value="">— Select Course —</option>
                @foreach($courses->where('department_id', $existingDept?->id) as $c)
                    <option value="{{ $c->id }}"
                        {{ (old('_course_id', $existingCourse?->id)) == $c->id ? 'selected' : '' }}>
                        {{ $c->short_name ?? $c->name }}
                    </option>
                @endforeach
            </select>
            <span class="cascade-note">Select a department first.</span>
        </div>
        <div class="form-group">
            <label for="class_id">Class / Year</label>
            <select id="class_id" name="class_id">
                <option value="">— Select Class —</option>
                @foreach($classes->where('course_id', $existingCourse?->id) as $cl)
                    <option value="{{ $cl->id }}"
                        {{ (old('class_id', $subject->class_id)) == $cl->id ? 'selected' : '' }}>
                        {{ $cl->label ?? $cl->name }}
                    </option>
                @endforeach
            </select>
            @error('class_id') <span class="input-error">{{ $message }}</span> @enderror
            <span class="cascade-note">Select a course first.</span>
        </div>
    </div>

    <hr style="border:none;border-top:1px solid rgba(255,255,255,0.06);margin:24px 0;">

    {{-- ── Row 3: Name + Code ── --}}
    <div class="form-grid">
        <div class="form-group">
            <label for="name">Subject Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $subject->name) }}" placeholder="e.g. OJT / CEP" required>
            @error('name') <span class="input-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="code">Subject Code <span style="font-weight:400;text-transform:none;font-size:11px;">(optional)</span></label>
            <input type="text" id="code" name="code" value="{{ old('code', $subject->code) }}" placeholder="e.g. CS301">
            @error('code') <span class="input-error">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- ── Row 4: Type ── --}}
    <div class="form-group" style="margin-top:18px;">
        <label>Type *</label>
        <div class="type-pills">
            @foreach(['theory' => '📖 Theory', 'practical' => '🔬 Practical', 'elective' => '⭐ Elective'] as $val => $label)
                <label class="type-pill{{ $currentType === $val ? ' selected-'.$val : '' }}" id="pill-{{ $val }}">
                    <input type="radio" name="type" value="{{ $val }}" {{ $currentType === $val ? 'checked' : '' }}>
                    {{ $label }}
                </label>
            @endforeach
        </div>
        @error('type') <span class="input-error">{{ $message }}</span> @enderror
    </div>

    {{-- ── Row 5: Status ── --}}
    <div class="form-group" style="margin-top:18px;">
        <label for="status">Status *</label>
        <select id="status" name="status">
            <option value="active"   {{ old('status', $subject->status) === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $subject->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status') <span class="input-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>
</form>

@push('styles')
<script>
(function () {
    const allDepts   = @json($departments);
    const allCourses = @json($courses);
    const allClasses = @json($classes);

    const selCollege = document.getElementById('college_id');
    const selDept    = document.getElementById('department_id');
    const selCourse  = document.getElementById('course_id');
    const selClass   = document.getElementById('class_id');

    function populate(select, items, valField, labelFn, emptyLabel, selectedVal) {
        const current = selectedVal ?? select.value;
        select.innerHTML = `<option value="">${emptyLabel}</option>`;
        items.forEach(item => {
            const opt = document.createElement('option');
            opt.value       = item[valField];
            opt.textContent = labelFn(item);
            if (String(item[valField]) === String(current)) opt.selected = true;
            select.appendChild(opt);
        });
    }

    selCollege.addEventListener('change', function () {
        const cid = this.value;
        populate(selDept,   allDepts.filter(d => !cid || String(d.college_id) === cid), 'id', d => d.name, '— Select Department —');
        populate(selCourse, [], 'id', c => c.name, '— Select Course —');
        populate(selClass,  [], 'id', cl => cl.name, '— Select Class —');
    });

    selDept.addEventListener('change', function () {
        const did = this.value;
        populate(selCourse, allCourses.filter(c => !did || String(c.department_id) === did), 'id', c => (c.short_name || c.name), '— Select Course —');
        populate(selClass,  [], 'id', cl => cl.name, '— Select Class —');
    });

    selCourse.addEventListener('change', function () {
        const cid = this.value;
        populate(selClass, allClasses.filter(cl => !cid || String(cl.course_id) === cid), 'id', cl => (cl.label || cl.name), '— Select Class —');
    });

    // ── Type pill highlight ──
    document.querySelectorAll('.type-pill input[type=radio]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.type-pill').forEach(p => p.className = 'type-pill');
            if (this.checked) this.parentElement.classList.add('selected-' + this.value);
        });
    });
})();
</script>
@endpush
@endsection
