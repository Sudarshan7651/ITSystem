@extends('admin.layout.app')
@section('title', 'Add Department')

@section('content')
<div class="page-header">
    <h1>Add Department</h1>
    <p>Create a new department under a college</p>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.departments.store') }}">
        @csrf
        <div class="form-grid">
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
                @error('college_id') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group full">
                <label for="name">Department Name *</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Computer Engineering" required>
                @error('name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="short_name">Short Name</label>
                <input id="short_name" type="text" name="short_name" value="{{ old('short_name') }}" placeholder="e.g. CE">
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
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Department</button>
            <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
