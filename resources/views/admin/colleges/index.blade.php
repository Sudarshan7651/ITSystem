@extends('admin.layout.app')
@section('title', 'Colleges')

@section('content')
<div class="page-header">
    <h1>Colleges</h1>
    <p>Manage all colleges in the system</p>
</div>

<div class="table-topbar">
    <h2>All Colleges ({{ $colleges->total() }})</h2>
    <a href="{{ route('admin.colleges.create') }}" class="btn btn-primary">+ Add College</a>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Short Name</th>
                <th>Location</th>
                <th>Departments</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($colleges as $college)
            <tr>
                <td class="td-muted">{{ $loop->iteration }}</td>
                <td><strong>{{ $college->name }}</strong></td>
                <td class="td-muted">{{ $college->short_name ?? '—' }}</td>
                <td class="td-muted">{{ $college->location ?? '—' }}</td>
                <td>{{ $college->departments_count }}</td>
                <td><span class="badge badge-{{ $college->status }}">{{ ucfirst($college->status) }}</span></td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('admin.colleges.edit', $college) }}" class="btn btn-sm btn-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.colleges.destroy', $college) }}" onsubmit="return confirm('Delete this college and all its departments?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:rgba(255,255,255,0.25);padding:40px">No colleges found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">
    @foreach($colleges->links()->elements[0] ?? [] as $page => $url)
        @if($page == $colleges->currentPage())
            <span class="active-page">{{ $page }}</span>
        @else
            <a href="{{ $url }}">{{ $page }}</a>
        @endif
    @endforeach
</div>
@endsection
