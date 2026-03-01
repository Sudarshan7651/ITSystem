@extends('admin.layout.app')
@section('title', 'Teachers')

@section('content')
<div class="page-header">
    <h1>Teachers</h1>
    <p>Manage all teacher accounts</p>
</div>

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.teachers.index') }}">
    <div class="filter-bar">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary btn-sm">Clear</a>
        @endif
        <div class="filter-divider"></div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, employee ID…" class="filter-input" style="width:300px;">
        <select name="status" class="filter-select">
            <option value="">All Status</option>
            <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
</form>

<div class="table-topbar" style="margin-top:16px">
    <h2>Results ({{ $teachers->total() }})</h2>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">+ Add Teacher</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Employee ID</th>
                <th>Department</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $teacher)
            <tr>
                <td class="td-muted">{{ $teachers->firstItem() + $loop->index }}</td>
                <td><strong>{{ $teacher->name }}</strong></td>
                <td class="td-muted">{{ $teacher->email }}</td>
                <td class="td-muted">{{ $teacher->employee_id ?? '—' }}</td>
                <td class="td-muted">
                    @if($teacher->department)
                        {{ $teacher->department->name }}
                        <span style="color:rgba(255,255,255,0.2)"> / {{ $teacher->department->college->name ?? '—' }}</span>
                    @else —
                    @endif
                </td>
                <td><span class="badge badge-{{ $teacher->status }}">{{ ucfirst($teacher->status) }}</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}" onsubmit="return confirm('Delete this teacher account?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:rgba(255,255,255,0.25);padding:40px">No teachers found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">{{ $teachers->links() }}</div>

@endsection
