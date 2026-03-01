<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Internship Tracking System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #0e0e10; color: #fff; min-height: 100vh; display: flex; flex-direction: column; }

        /* ── Top Bar ── */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            background: #151517;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            padding: 0 24px;
            height: 56px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-brand { font-size: 15px; font-weight: 700; color: #fff; letter-spacing: -0.3px; }
        .topbar-brand span { color: rgba(255,255,255,0.35); font-weight: 400; }
        .topbar-user { display: flex; align-items: center; gap: 12px; font-size: 13px; color: rgba(255,255,255,0.45); }
        .topbar-user strong { color: rgba(255,255,255,0.85); }
        .btn-logout {
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.5); padding: 6px 14px; border-radius: 7px;
            font-size: 12px; font-weight: 500; cursor: pointer; font-family: inherit;
            transition: all 0.15s;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.1); color: #fff; }

        /* ── Hamburger ── */
        .btn-hamburger {
            background: none; border: none; cursor: pointer;
            display: flex; flex-direction: column; justify-content: center; gap: 5px;
            padding: 6px; border-radius: 7px; transition: background 0.15s;
        }
        .btn-hamburger:hover { background: rgba(255,255,255,0.07); }
        .btn-hamburger span {
            display: block; width: 20px; height: 2px;
            background: rgba(255,255,255,0.6); border-radius: 2px;
            transition: all 0.25s;
        }

        /* ── Nav Arrows ── */
        .nav-arrows { display: flex; gap: 2px; }
        .nav-arrow {
            background: none; border: none; cursor: pointer;
            color: rgba(255,255,255,0.45); font-size: 16px; font-weight: 600;
            width: 30px; height: 30px; border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s, color 0.15s; line-height: 1;
        }
        .nav-arrow:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-arrow:active { background: rgba(255,255,255,0.13); }


        /* ── Layout ── */
        .layout { display: flex; flex: 1; min-height: calc(100vh - 56px); }

        /* ── Sidebar ── */
        .sidebar {
            width: 220px; flex-shrink: 0;
            background: #151517;
            border-right: 1px solid rgba(255,255,255,0.06);
            padding: 20px 12px;
            display: flex; flex-direction: column; gap: 4px;
            transition: width 0.25s ease, padding 0.25s ease;
            overflow: hidden;
        }
        .sidebar.collapsed {
            width: 0; padding: 0; border: none;
        }
        .sidebar.collapsed .sidebar-section,
        .sidebar.collapsed a { display: none; }
        .sidebar-section { font-size: 10px; font-weight: 600; color: rgba(255,255,255,0.25); text-transform: uppercase; letter-spacing: 0.08em; padding: 10px 10px 4px; margin-top: 8px; }
        .sidebar a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.15s;
        }
        .sidebar a:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .sidebar a.active { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar a .icon { font-size: 15px; width: 18px; text-align: center; }

        /* ── Main Content ── */
        .main { flex: 1; padding: 32px 36px; overflow-x: auto; }
        .page-header { margin-bottom: 28px; }
        .page-header h1 { font-size: 22px; font-weight: 700; margin-bottom: 4px; }
        .page-header p { color: rgba(255,255,255,0.35); font-size: 13px; }

        /* ── Alerts ── */
        .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; }
        .alert-success { background: rgba(52,211,153,0.1); border: 1px solid rgba(52,211,153,0.25); color: #6ee7b7; }
        .alert-error   { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.25); color: #fca5a5; }

        /* ── Table ── */
        .table-wrap { background: #151517; border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead th { padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 0.06em; border-bottom: 1px solid rgba(255,255,255,0.06); background: rgba(255,255,255,0.02); }
        tbody tr { border-bottom: 1px solid rgba(255,255,255,0.04); transition: background 0.1s; }
        tbody tr:last-child { border: none; }
        tbody tr:hover { background: rgba(255,255,255,0.03); }
        tbody td { padding: 13px 16px; color: rgba(255,255,255,0.75); vertical-align: middle; }
        .td-muted { color: rgba(255,255,255,0.3); }

        /* ── Badge ── */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 50px; font-size: 11px; font-weight: 600; }
        .badge-active   { background: rgba(52,211,153,0.12); color: #6ee7b7; }
        .badge-inactive { background: rgba(248,113,113,0.12); color: #fca5a5; }

        /* ── Buttons ── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; transition: all 0.15s; text-decoration: none; }
        .btn-primary { background: #fff; color: #111; }
        .btn-primary:hover { opacity: 0.88; }
        .btn-sm { padding: 5px 12px; font-size: 12px; border-radius: 6px; }
        .btn-edit { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.1); }
        .btn-edit:hover { background: rgba(255,255,255,0.12); color: #fff; }
        .btn-delete { background: rgba(248,113,113,0.1); color: #fca5a5; border: 1px solid rgba(248,113,113,0.2); }
        .btn-delete:hover { background: rgba(248,113,113,0.2); }
        .btn-secondary { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.1); }
        .btn-secondary:hover { background: rgba(255,255,255,0.12); color: #fff; }
        .action-group { display: flex; gap: 6px; }

        /* ── Card (form wrapper) ── */
        .form-card { background: #151517; border: 1px solid rgba(255,255,255,0.07); border-radius: 14px; padding: 32px; max-width: 640px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.05em; }
        input[type=text], input[type=email], input[type=password], input[type=number], select, textarea {
            width: 100%; padding: 10px 13px;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px; color: #fff; font-size: 14px; font-family: inherit; outline: none;
            transition: border-color 0.15s;
        }
        input:focus, select:focus, textarea:focus { border-color: rgba(255,255,255,0.35); }
        input::placeholder, textarea::placeholder { color: rgba(255,255,255,0.2); }
        select option { background: #1e1e20; }
        .input-error { font-size: 12px; color: #fca5a5; margin-top: 3px; }
        .form-actions { display: flex; gap: 10px; margin-top: 24px; }

        /* ── Pagination ── */
        .pagination { display: flex; gap: 6px; justify-content: flex-end; margin-top: 20px; flex-wrap:wrap; }
        .pagination nav { display:flex; gap:6px; flex-wrap:wrap; justify-content:flex-end; width:100%; }
        .pagination nav span, .pagination nav a { padding: 6px 12px; border-radius: 7px; font-size: 13px; text-decoration: none; display:inline-block; }
        .pagination nav a { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.6); border: 1px solid rgba(255,255,255,0.08); }
        .pagination nav a:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .pagination nav span[aria-current] { background: #fff; color: #111; font-weight: 700; }
        .pagination nav span:not([aria-current]) { color: rgba(255,255,255,0.2); }

        /* ── Table top bar ── */
        .table-topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .table-topbar h2 { font-size: 15px; font-weight: 600; }

        /* ── Filter Bar ── */
        .filter-bar {
            display: flex; align-items: center; gap: 8px;
            flex-wrap: nowrap; overflow-x: auto;
            background: #151517; border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px; padding: 10px 14px;
        }
        .filter-divider { width: 1px; height: 22px; background: rgba(255,255,255,0.1); flex-shrink:0; margin: 0 4px; }
        .filter-input {
            width: 30%; flex-shrink: 0;
            padding: 7px 11px;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 7px; color: #fff; font-size: 12px; font-family: inherit; outline: none;
        }
        .filter-input:focus { border-color: rgba(255,255,255,0.3); }
        .filter-input::placeholder { color: rgba(255,255,255,0.2); }
        .filter-select {
            padding: 7px 10px; flex-shrink: 0;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 7px; color: rgba(255,255,255,0.7); font-size: 12px;
            font-family: inherit; outline: none; cursor: pointer; max-width: 160px;
        }
        .filter-select option { background: #1e1e20; }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <header class="topbar">
        <div style="display:flex;align-items:center;gap:8px">
            <button class="btn-hamburger" id="sidebarToggle" title="Toggle sidebar">
                <span></span><span></span><span></span>
            </button>
            <div class="nav-arrows">
                <button class="nav-arrow" id="navBack"    onclick="history.back()"    title="Go back">&#8592;</button>
                <button class="nav-arrow" id="navForward" onclick="history.forward()" title="Go forward">&#8594;</button>
            </div>
            
        </div>
        <div class="topbar-user">
            <strong>{{ auth()->user()->name }}</strong>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </header>

    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="adminSidebar">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon">⊟</span> Dashboard
            </a>

            <div class="sidebar-section">Manage</div>
            <a href="{{ route('admin.colleges.index') }}" class="{{ request()->routeIs('admin.colleges.*') ? 'active' : '' }}">
                <span class="icon">🏛</span> Colleges
            </a>
            <a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                <span class="icon">🏢</span> Departments
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="{{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                <span class="icon">👨‍🏫</span> Teachers
            </a>
            <a href="{{ route('admin.courses.index') }}" class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <span class="icon">📚</span> Courses
            </a>
            <a href="{{ route('admin.subjects.index') }}" class="{{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
                <span class="icon">📖</span> Subjects
            </a>
        </aside>

        <!-- Main -->
        <main class="main">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            @yield('content')
        </main>
    </div>
<script>
(function () {
    const sidebar = document.getElementById('adminSidebar');
    const btn     = document.getElementById('sidebarToggle');
    const KEY     = 'adminSidebarCollapsed';

    // Restore state from localStorage
    if (localStorage.getItem(KEY) === '1') sidebar.classList.add('collapsed');

    btn.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem(KEY, sidebar.classList.contains('collapsed') ? '1' : '0');
    });
})();
</script>
    @stack('scripts')
</body>
</html>
