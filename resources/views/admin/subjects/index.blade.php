@extends('admin.layout.app')
@section('title', 'Subjects')

@section('content')
<div class="page-header">
    <h1>Subjects</h1>
    <p>Manage subjects assigned to each class year of a course.</p>
</div>

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.subjects.index') }}">
<div class="filter-bar" style="margin-bottom:16px; flex-wrap:wrap; gap:8px;">
    <input  class="filter-input" name="search"        placeholder="Search name / code…" value="{{ request('search') }}">
    <div class="filter-divider"></div>
    <select class="filter-select" name="college_id"    id="fi-college">
        <option value="">All Colleges</option>
        @foreach($colleges as $c)
            <option value="{{ $c->id }}" {{ request('college_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
        @endforeach
    </select>
    <select class="filter-select" name="department_id" id="fi-dept">
        <option value="">All Departments</option>
        @foreach($departments as $d)
            <option value="{{ $d->id }}" {{ request('department_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
        @endforeach
    </select>
    <select class="filter-select" name="course_id"     id="fi-course">
        <option value="">All Courses</option>
        @foreach($courses as $c)
            <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
        @endforeach
    </select>
    <select class="filter-select" name="class_id"      id="fi-class">
        <option value="">All Classes</option>
        @foreach($classes as $cl)
            <option value="{{ $cl->id }}" {{ request('class_id') == $cl->id ? 'selected' : '' }}>
                {{ $cl->course->short_name ?? $cl->course->name }} — {{ $cl->label ?? $cl->name }}
            </option>
        @endforeach
    </select>
    <select class="filter-select" name="type">
        <option value="">All Types</option>
        <option value="theory"    {{ request('type') === 'theory'    ? 'selected' : '' }}>Theory</option>
        <option value="practical" {{ request('type') === 'practical' ? 'selected' : '' }}>Practical</option>
        <option value="elective"  {{ request('type') === 'elective'  ? 'selected' : '' }}>Elective</option>
    </select>
    <select class="filter-select" name="status">
        <option value="">All Status</option>
        <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary btn-sm">Reset</a>
</div>
</form>

<div class="table-topbar">
    <h2>{{ $subjects->total() }} Subject{{ $subjects->total() !== 1 ? 's' : '' }}</h2>
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary btn-sm">＋ Add Subject</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Code</th>
                <th>Type</th>
                <th>Class</th>
                <th>Course</th>
                <th>Department</th>
                <th>College</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($subjects as $i => $sub)
            @php
                $cy   = $sub->classYear;
                $crs  = $cy?->course;
                $dept = $crs?->department;
                $col  = $dept?->college;
            @endphp
            <tr>
                <td class="td-muted">{{ $subjects->firstItem() + $i }}</td>
                <td style="font-weight:600;">{{ $sub->name }}</td>
                <td class="td-muted">{{ $sub->code ?? '—' }}</td>
                <td>
                    @php
                        $typeStyle = match($sub->type) {
                            'theory'    => 'background:rgba(96,165,250,0.12);color:#93c5fd;',
                            'practical' => 'background:rgba(167,139,250,0.12);color:#c4b5fd;',
                            'elective'  => 'background:rgba(251,191,36,0.12);color:#fcd34d;',
                            default     => '',
                        };
                    @endphp
                    <span class="badge" style="{{ $typeStyle }}">{{ ucfirst($sub->type) }}</span>
                </td>
                <td>{{ $cy?->label ?? $cy?->name ?? '—' }}</td>
                <td>{{ $crs?->short_name ?? $crs?->name ?? '—' }}</td>
                <td class="td-muted">{{ $dept?->name ?? '—' }}</td>
                <td class="td-muted">{{ $col?->name ?? '—' }}</td>
                <td>
                    <span class="badge badge-{{ $sub->status }}">{{ ucfirst($sub->status) }}</span>
                </td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('admin.subjects.edit', $sub) }}" class="btn btn-edit btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.subjects.destroy', $sub) }}"
                              onsubmit="return confirm('Delete subject \'{{ addslashes($sub->name) }}\'?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-delete btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10" style="text-align:center;padding:40px;color:rgba(255,255,255,0.25);">
                    No subjects found. <a href="{{ route('admin.subjects.create') }}" style="color:rgba(255,255,255,0.5);">Add the first one.</a>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($subjects->hasPages())
    <div class="pagination">{{ $subjects->links() }}</div>
@endif
@endsection
