@extends('admin.layout.app')
@section('title', 'Edit Teacher')

@section('content')
<div class="page-header">
    <h1>Edit Teacher</h1>
    <p>Update teacher account details</p>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input id="name" type="text" name="name" value="{{ old('name', $teacher->name) }}" required>
                @error('name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="employee_id">Employee ID</label>
                <input id="employee_id" type="text" name="employee_id" value="{{ old('employee_id', $teacher->employee_id) }}">
                @error('employee_id') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input id="email" type="email" name="email" value="{{ old('email', $teacher->email) }}" required>
                @error('email') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', $teacher->phone) }}">
                @error('phone') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="password">New Password <span style="color:rgba(255,255,255,0.3)">(leave blank to keep)</span></label>
                <input id="password" type="password" name="password" placeholder="Min 8 characters">
                @error('password') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation">
            </div>
            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" required>
                    <option value="active"   {{ old('status', $teacher->status) == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <span class="input-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Teacher</button>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
