@extends('admin.layout.app')
@section('title', 'Edit College')

@section('content')
<div class="page-header">
    <h1>Edit College</h1>
    <p>Update college details</p>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.colleges.update', $college) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group full">
                <label for="name">College Name *</label>
                <input id="name" type="text" name="name" value="{{ old('name', $college->name) }}" required>
                @error('name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="short_name">Short Name</label>
                <input id="short_name" type="text" name="short_name" value="{{ old('short_name', $college->short_name) }}">
                @error('short_name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="active"   {{ old('status', $college->status) == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $college->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group full">
                <label for="location">Location</label>
                <input id="location" type="text" name="location" value="{{ old('location', $college->location) }}">
                @error('location') <span class="input-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update College</button>
            <a href="{{ route('admin.colleges.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
