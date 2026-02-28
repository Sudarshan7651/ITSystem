<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard — Internship Tracking System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #111; color: #fff; min-height: 100vh; }
        header {
            background: #1a1a1a;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand { font-size: 16px; font-weight: 700; color: #fff; }
        .user-info { display: flex; align-items: center; gap: 12px; }
        .user-info span { font-size: 14px; color: rgba(255,255,255,0.5); }
        .nav-link {
            color: rgba(255,255,255,0.55);
            font-size: 13px;
            text-decoration: none;
            padding: 7px 14px;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            transition: background 0.2s;
        }
        .nav-link:hover { background: rgba(255,255,255,0.07); color: #fff; }
        .logout-btn {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.6);
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background 0.2s;
        }
        .logout-btn:hover { background: rgba(255,255,255,0.1); color: #fff; }
        main { padding: 40px 32px; max-width: 1000px; margin: 0 auto; }
        h1 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
        .subtitle { color: rgba(255,255,255,0.4); margin-bottom: 32px; font-size: 14px; }
        .role-badge {
            display: inline-block;
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.5);
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 8px;
            vertical-align: middle;
        }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
        .card {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 24px;
        }
        .card-icon { font-size: 28px; margin-bottom: 12px; }
        .card-title { font-size: 12px; color: rgba(255,255,255,0.4); margin-bottom: 4px; }
        .card-value { font-size: 22px; font-weight: 700; }
    </style>
</head>
<body>
    <header>
        <div class="brand">Internship Tracking System</div>
        <div class="user-info">
            <span>{{ auth()->user()->name }}</span>
            <a href="{{ route('teacher.profile') }}" class="nav-link">My Profile</a>
            <form method="POST" action="{{ route('teacher.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </header>
    <main>
        <h1>Dashboard <span class="role-badge">Teacher</span></h1>
        <p class="subtitle">Manage your students and internship progress</p>
        <div class="cards">
            <div class="card">
                <div class="card-icon">🎓</div>
                <div class="card-title">My Students</div>
                <div class="card-value">—</div>
            </div>
            <div class="card">
                <div class="card-icon">📋</div>
                <div class="card-title">Internship Reports</div>
                <div class="card-value">—</div>
            </div>
            <div class="card">
                <div class="card-icon">✅</div>
                <div class="card-title">Approved</div>
                <div class="card-value">—</div>
            </div>
        </div>
    </main>
</body>
</html>
