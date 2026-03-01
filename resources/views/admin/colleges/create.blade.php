@extends('admin.layout.app')
@section('title', 'Add College')

@section('content')
<div class="page-header">
    <h1>Add College</h1>
    <p>Create a new college in the system</p>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.colleges.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group full">
                <label for="name">College Name *</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Government Polytechnic College" required>
                @error('name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="short_name">Short Name</label>
                <input id="short_name" type="text" name="short_name" value="{{ old('short_name') }}" placeholder="e.g. GPC">
                @error('short_name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="active"   {{ old('status','active') == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group full">
                <label for="location">Location</label>
                <input id="location" type="text" name="location" value="{{ old('location') }}" placeholder="e.g. Mumbai, Maharashtra">
                @error('location') <span class="input-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save College</button>
            <a href="{{ route('admin.colleges.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
