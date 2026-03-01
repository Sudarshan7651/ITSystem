@extends('admin.layout.app')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Welcome back, {{ auth()->user()->name }}. Here's your system overview.</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:16px;margin-bottom:36px">
    <a href="{{ route('admin.colleges.index') }}" style="text-decoration:none">
        <div class="stat-card">
            <div class="stat-icon">🏛</div>
            <div class="stat-val">{{ $stats['colleges'] }}</div>
            <div class="stat-label">Colleges</div>
        </div>
    </a>
    <a href="{{ route('admin.departments.index') }}" style="text-decoration:none">
        <div class="stat-card">
            <div class="stat-icon">🏢</div>
            <div class="stat-val">{{ $stats['departments'] }}</div>
            <div class="stat-label">Departments</div>
        </div>
    </a>
    <a href="{{ route('admin.teachers.index') }}" style="text-decoration:none">
        <div class="stat-card">
            <div class="stat-icon">👨‍🏫</div>
            <div class="stat-val">{{ $stats['teachers'] }}</div>
            <div class="stat-label">Teachers</div>
        </div>
    </a>
    <a href="{{ route('admin.courses.index') }}" style="text-decoration:none">
        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-val">{{ $stats['courses'] }}</div>
            <div class="stat-label">Courses</div>
        </div>
    </a>
    <div class="stat-card">
        <div class="stat-icon">🎓</div>
        <div class="stat-val">{{ $stats['students'] }}</div>
        <div class="stat-label">Students</div>
    </div>
    <div class="stat-card" style="border-color:rgba(248,113,113,0.2)">
        <div class="stat-icon">⏳</div>
        <div class="stat-val" style="color:#fca5a5">{{ $stats['pending'] }}</div>
        <div class="stat-label">Pending Approvals</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
    <div style="background:#151517;border:1px solid rgba(255,255,255,0.07);border-radius:12px;padding:24px">
        <h3 style="font-size:14px;font-weight:600;margin-bottom:16px">Quick Actions</h3>
        <div style="display:flex;flex-direction:column;gap:8px">
            <a href="{{ route('admin.colleges.create') }}" class="btn btn-secondary btn-sm" style="justify-content:flex-start">🏛 &nbsp; Add New College</a>
            <a href="{{ route('admin.departments.create') }}" class="btn btn-secondary btn-sm" style="justify-content:flex-start">🏢 &nbsp; Add New Department</a>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-secondary btn-sm" style="justify-content:flex-start">👨‍🏫 &nbsp; Add New Teacher</a>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-secondary btn-sm" style="justify-content:flex-start">📚 &nbsp; Add New Course</a>
            <a href="{{ route('admin.subjects.create') }}" class="btn btn-secondary btn-sm" style="justify-content:flex-start">📖 &nbsp; Add New Subject</a>
        </div>
    </div>
    <div style="background:#151517;border:1px solid rgba(255,255,255,0.07);border-radius:12px;padding:24px">
        <h3 style="font-size:14px;font-weight:600;margin-bottom:16px">System Info</h3>
        <div style="font-size:13px;color:rgba(255,255,255,0.4);display:flex;flex-direction:column;gap:10px">
            <div style="display:flex;justify-content:space-between"><span>Laravel Version</span><span style="color:rgba(255,255,255,0.7)">{{ app()->version() }}</span></div>
            <div style="display:flex;justify-content:space-between"><span>PHP Version</span><span style="color:rgba(255,255,255,0.7)">{{ PHP_VERSION }}</span></div>
            <div style="display:flex;justify-content:space-between"><span>Environment</span><span style="color:rgba(255,255,255,0.7)">{{ app()->environment() }}</span></div>
            <div style="display:flex;justify-content:space-between"><span>Current Time</span><span style="color:rgba(255,255,255,0.7)">{{ now()->format('d M Y, h:i A') }}</span></div>
        </div>
    </div>
</div>

<style>
.stat-card {
    background:#151517; border:1px solid rgba(255,255,255,0.07);
    border-radius:12px; padding:22px 20px;
    transition:border-color 0.15s, background 0.15s;
}
.stat-card:hover { background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.12); }
.stat-icon { font-size:22px; margin-bottom:10px; }
.stat-val  { font-size:28px; font-weight:700; margin-bottom:4px; }
.stat-label{ font-size:12px; color:rgba(255,255,255,0.35); font-weight:500; }
</style>
@endsection
