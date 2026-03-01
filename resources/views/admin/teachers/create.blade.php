@extends('admin.layout.app')
@section('title', 'Add Teacher')

@section('content')
<div class="page-header">
    <h1>Add Teacher</h1>
    <p>Create a new teacher account</p>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.teachers.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Rahul Sharma" required>
                @error('name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="employee_id">Employee ID</label>
                <input id="employee_id" type="text" name="employee_id" value="{{ old('employee_id') }}" placeholder="e.g. EMP-0042">
                @error('employee_id') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="teacher@college.edu" required>
                @error('email') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. 9876543210">
                @error('phone') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input id="password" type="password" name="password" placeholder="Min 8 characters" required>
                @error('password') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password *</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
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
            <button type="submit" class="btn btn-primary">Create Teacher</button>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
