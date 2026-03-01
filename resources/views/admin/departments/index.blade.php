@extends('admin.layout.app')
@section('title', 'Departments')

@section('content')
<div class="page-header">
    <h1>Departments</h1>
    <p>Manage departments across all colleges</p>
</div>

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.departments.index') }}">
    <div class="filter-bar">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        @if(request()->hasAny(['search','college_id','status']))
            <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary btn-sm">Clear</a>
        @endif
        <div class="filter-divider"></div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name…" class="filter-input" style="width:300px">
        <select name="college_id" class="filter-select">
            <option value="">All Colleges</option>
            @foreach($colleges as $college)
                <option value="{{ $college->id }}" {{ request('college_id') == $college->id ? 'selected' : '' }}>
                    {{ $college->name }}
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
    <h2>Results ({{ $departments->total() }})</h2>
    <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">+ Add Department</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Department</th>
                <th>College</th>
                <th>Courses</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $dept)
            <tr>
                <td class="td-muted">{{ $departments->firstItem() + $loop->index }}</td>
                <td>
                    <strong>{{ $dept->name }}</strong>
                    @if($dept->short_name) <span class="td-muted" style="font-size:11px"> ({{ $dept->short_name }})</span> @endif
                </td>
                <td class="td-muted">{{ $dept->college->name ?? '—' }}</td>
                <td>{{ $dept->courses_count }}</td>
                <td><span class="badge badge-{{ $dept->status }}">{{ ucfirst($dept->status) }}</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-sm btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}" onsubmit="return confirm('Delete this department?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:rgba(255,255,255,0.25);padding:40px">No departments found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">{{ $departments->links() }}</div>

@endsection
