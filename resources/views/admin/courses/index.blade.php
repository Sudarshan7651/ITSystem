@extends('admin.layout.app')
@section('title', 'Courses')

@section('content')
<div class="page-header">
    <h1>Courses</h1>
    <p>Manage courses offered across departments</p>
</div>

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.courses.index') }}" id="courseFilterForm">
    <div class="filter-bar">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        @if(request()->hasAny(['search','college_id','department_id','status']))
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary btn-sm">Clear</a>
        @endif
        <div class="filter-divider"></div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search course…" class="filter-input" style="width:160px">
        <select name="college_id" class="filter-select" id="filterCollege">
            <option value="">All Colleges</option>
            @foreach($colleges as $college)
                <option value="{{ $college->id }}" {{ request('college_id') == $college->id ? 'selected' : '' }}>
                    {{ $college->name }}
                </option>
            @endforeach
        </select>
        <select name="department_id" class="filter-select" id="filterDept">
            <option value="">All Departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}"
                    data-college="{{ $dept->college_id }}"
                    {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
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
    <h2>Results ({{ $courses->total() }})</h2>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">+ Add Course</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Course</th>
                <th>Department</th>
                <th>College</th>
                <th>Duration</th>
                <th>Classes</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
            <tr>
                <td class="td-muted">{{ $courses->firstItem() + $loop->index }}</td>
                <td>
                    <strong>{{ $course->name }}</strong>
                    @if($course->short_name) <span class="td-muted" style="font-size:11px"> ({{ $course->short_name }})</span> @endif
                </td>
                <td class="td-muted">{{ $course->department->name ?? '—' }}</td>
                <td class="td-muted" style="font-size:12px">{{ $course->department->college->name ?? '—' }}</td>
                <td class="td-muted">{{ $course->duration_years }} yr</td>
                <td>{{ $course->classes_count }}</td>
                <td><span class="badge badge-{{ $course->status }}">{{ ucfirst($course->status) }}</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Delete this course?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:rgba(255,255,255,0.25);padding:40px">No courses found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">{{ $courses->links() }}</div>


<script>
// Cascade dept dropdown in filter bar by selected college
(function(){
    const col  = document.getElementById('filterCollege');
    const dept = document.getElementById('filterDept');
    const opts = Array.from(dept.querySelectorAll('option[data-college]'));

    function sync(colId) {
        opts.forEach(o => {
            o.style.display = (!colId || o.dataset.college === colId) ? '' : 'none';
            if (o.dataset.college !== colId && o.selected && colId) { o.selected = false; dept.value = ''; }
        });
    }
    col.addEventListener('change', () => sync(col.value));
    sync(col.value); // restore on page load
})();
</script>
@endsection
