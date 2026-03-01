@extends('admin.layout.app')
@section('title', 'Classes')

@section('content')
<div class="page-header">
    <h1>Classes</h1>
    <p>Manage year-wise classes (FY, SY, TY, etc.) under each course</p>
</div>

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.classes.index') }}">
    <div class="filter-bar">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        @if(request()->hasAny(['search','college_id','department_id','course_id','status']))
            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary btn-sm">Clear</a>
        @endif
        <div class="filter-divider"></div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search class…" class="filter-input" style="width:160px">
        <select name="college_id" class="filter-select" id="fCollege">
            <option value="">All Colleges</option>
            @foreach($colleges as $college)
                <option value="{{ $college->id }}" {{ request('college_id') == $college->id ? 'selected' : '' }}>{{ $college->name }}</option>
            @endforeach
        </select>
        <select name="department_id" class="filter-select" id="fDept">
            <option value="">All Depts</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}" data-college="{{ $dept->college_id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
            @endforeach
        </select>
        <select name="course_id" class="filter-select" id="fCourse">
            <option value="">All Courses</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" data-department="{{ $course->department_id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
            @endforeach
        </select>
        <select name="status" class="filter-select">
            <option value="">All Status</option>
            <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
</form>

<div class="table-topbar" style="margin-top:16px">
    <h2>Results ({{ $classes->total() }})</h2>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">+ Add Class</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Class</th>
                <th>Label</th>
                <th>Course</th>
                <th>Department</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
            <tr>
                <td class="td-muted">{{ $classes->firstItem() + $loop->index }}</td>
                <td><strong>{{ $class->name }}</strong></td>
                <td class="td-muted">{{ $class->label ?? '—' }}</td>
                <td class="td-muted">{{ $class->course->name ?? '—' }}</td>
                <td class="td-muted" style="font-size:12px">
                    {{ $class->course->department->name ?? '—' }}
                    <span style="color:rgba(255,255,255,0.2)"> / {{ $class->course->department->college->name ?? '—' }}</span>
                </td>
                <td><span class="badge badge-{{ $class->status }}">{{ ucfirst($class->status) }}</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" onsubmit="return confirm('Delete this class?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:rgba(255,255,255,0.25);padding:40px">No classes found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">{{ $classes->links() }}</div>


<script>
(function(){
    const fCol    = document.getElementById('fCollege');
    const fDept   = document.getElementById('fDept');
    const fCourse = document.getElementById('fCourse');
    const dOpts   = Array.from(fDept.querySelectorAll('option[data-college]'));
    const cOpts   = Array.from(fCourse.querySelectorAll('option[data-department]'));

    function syncDept(colId) {
        dOpts.forEach(o => {
            o.style.display = (!colId || o.dataset.college === colId) ? '' : 'none';
            if (colId && o.dataset.college !== colId && o.selected) { o.selected = false; fDept.value = ''; }
        });
        syncCourse(fDept.value);
    }
    function syncCourse(deptId) {
        cOpts.forEach(o => {
            o.style.display = (!deptId || o.dataset.department === deptId) ? '' : 'none';
            if (deptId && o.dataset.department !== deptId && o.selected) { o.selected = false; fCourse.value = ''; }
        });
    }
    fCol.addEventListener('change',  () => syncDept(fCol.value));
    fDept.addEventListener('change', () => syncCourse(fDept.value));
    syncDept(fCol.value); // restore on page load
})();
</script>
@endsection
