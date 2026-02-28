<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile — Student</title>
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
        .brand { font-size: 16px; font-weight: 700; color: #fff; text-decoration: none; }
        .header-nav { display: flex; align-items: center; gap: 10px; }
        .nav-link {
            color: rgba(255,255,255,0.5);
            font-size: 13px;
            text-decoration: none;
            padding: 7px 14px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.07); color: #fff; }
        .logout-form button {
            background: none; border: none; cursor: pointer;
            color: rgba(255,255,255,0.4); font-size: 13px;
            padding: 7px 14px; border-radius: 8px; font-family: inherit;
            transition: background 0.2s;
        }
        .logout-form button:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .page { max-width: 740px; margin: 44px auto; padding: 0 24px; }
        .page-header { margin-bottom: 28px; }
        .page-header h1 { font-size: 24px; font-weight: 700; }
        .page-header p { color: rgba(255,255,255,0.4); font-size: 14px; margin-top: 4px; }
        .avatar-row {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 28px;
            padding: 22px 24px;
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
        }
        .avatar {
            width: 64px; height: 64px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: 700; flex-shrink: 0;
        }
        .avatar-info h2 { font-size: 17px; font-weight: 600; }
        .avatar-info p { font-size: 13px; color: rgba(255,255,255,0.4); margin-top: 2px; }
        .role-badge {
            display: inline-block;
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.5);
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 6px;
        }
        .chips { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
        .chip {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.45);
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 6px;
        }
        .tabs {
            display: flex;
            gap: 2px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 24px;
        }
        .tab-btn {
            background: none; border: none; cursor: pointer;
            font-family: inherit; font-size: 14px; font-weight: 500;
            color: rgba(255,255,255,0.4);
            padding: 10px 18px;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px;
            transition: color 0.2s;
        }
        .tab-btn:hover { color: rgba(255,255,255,0.7); }
        .tab-btn.active { color: #fff; border-bottom-color: #fff; }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }
        .card {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 26px;
            margin-bottom: 16px;
        }
        .card-title {
            font-size: 14px; font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.7);
        }
        .locked-info {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 16px 18px;
            margin-bottom: 18px;
        }
        .locked-info h4 {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.06em;
            color: rgba(255,255,255,0.25);
            margin-bottom: 12px;
        }
        .locked-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .locked-field label { font-size: 11px; color: rgba(255,255,255,0.3); display: block; margin-bottom: 3px; }
        .locked-field span { font-size: 14px; font-weight: 500; }
        .danger-card {
            background: #1a1a1a;
            border: 1px solid rgba(255,80,80,0.2);
            border-radius: 12px;
            padding: 26px;
        }
        .danger-card .card-title { color: #fca5a5; border-bottom-color: rgba(255,80,80,0.12); }
        .alert-success {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.75);
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 13px;
            margin-bottom: 18px;
        }
        .alert-error {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,80,80,0.3);
            color: #fca5a5;
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 13px;
            margin-bottom: 18px;
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 500; margin-bottom: 7px; }
        .locked-badge {
            background: rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.3);
            font-size: 10px;
            padding: 1px 6px;
            border-radius: 4px;
            margin-left: 6px;
        }
        input, select {
            width: 100%;
            padding: 11px 14px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s;
            appearance: none;
        }
        input:focus, select:focus { border-color: rgba(255,255,255,0.4); }
        input[readonly] { opacity: 0.35; cursor: not-allowed; }
        select option { background: #1a1a1a; }
        .input-error { color: #fca5a5; font-size: 12px; margin-top: 5px; display: block; }
        .btn {
            padding: 10px 22px;
            border: none; border-radius: 8px;
            font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif;
            cursor: pointer; transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background: #fff; color: #111; }
        .btn-danger  { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
    </style>
</head>
<body>
<header>
    <a href="{{ route('student.dashboard') }}" class="brand">Internship Tracking System</a>
    <div class="header-nav">
        <a href="{{ route('student.dashboard') }}" class="nav-link">Dashboard</a>
        <a href="{{ route('student.profile') }}"   class="nav-link active">Profile</a>
        <form method="POST" action="{{ route('student.logout') }}" class="logout-form">
            @csrf <button type="submit">Logout</button>
        </form>
    </div>
</header>
<div class="page">
    <div class="page-header">
        <h1>My Profile</h1>
        <p>Manage your account information and settings</p>
    </div>
    @if (session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any() && ! session('tab'))
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif
    <div class="avatar-row">
        <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div class="avatar-info">
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }}</p>
            <span class="role-badge">Student</span>
            <div class="chips">
                @if($user->roll_number) <span class="chip">Roll: {{ $user->roll_number }}</span> @endif
                @if($user->year)        <span class="chip">Year {{ $user->year }}</span> @endif
                @if($user->college)     <span class="chip">{{ $user->college->short_name ?? $user->college->name }}</span> @endif
            </div>
        </div>
    </div>
    <div class="tabs">
        <button class="tab-btn {{ session('tab') === 'password' || session('tab') === 'danger' ? '' : 'active' }}" onclick="switchTab('edit', this)">Edit Profile</button>
        <button class="tab-btn {{ session('tab') === 'password' ? 'active' : '' }}" onclick="switchTab('password', this)">Change Password</button>
        <button class="tab-btn {{ session('tab') === 'danger' ? 'active' : '' }}" onclick="switchTab('danger', this)" style="color:rgba(252,165,165,0.5);">Danger Zone</button>
    </div>

    <div id="tab-edit" class="tab-panel {{ session('tab') === 'password' || session('tab') === 'danger' ? '' : 'active' }}">
        <div class="locked-info">
            <h4>Academic Info — locked</h4>
            <div class="locked-grid">
                <div class="locked-field"><label>Roll Number</label><span>{{ $user->roll_number ?? '—' }}</span></div>
                <div class="locked-field"><label>College</label><span>{{ $user->college?->name ?? '—' }}</span></div>
                <div class="locked-field"><label>Department</label><span>{{ $user->department?->name ?? '—' }}</span></div>
                <div class="locked-field"><label>Course</label><span>{{ $user->course?->name ?? '—' }}</span></div>
            </div>
        </div>
        <div class="card">
            <div class="card-title">Personal Information</div>
            <form method="POST" action="{{ route('student.profile.update') }}">
                @csrf @method('PATCH')
                <div class="form-row">
                    <div class="form-group">
                        <label for="s_name">Full Name</label>
                        <input id="s_name" type="text" name="name" value="{{ old('name', $user->name) }}" required />
                        @error('name') <span class="input-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="s_phone">Phone</label>
                        <input id="s_phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" required />
                        @error('phone') <span class="input-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Email <span class="locked-badge">locked</span></label>
                        <input type="email" value="{{ $user->email }}" readonly />
                    </div>
                    <div class="form-group">
                        <label for="s_year">Year of Study</label>
                        <select id="s_year" name="year" required>
                            @for ($y = 1; $y <= 6; $y++)
                                <option value="{{ $y }}" {{ old('year', $user->year) == $y ? 'selected' : '' }}>Year {{ $y }}</option>
                            @endfor
                        </select>
                        @error('year') <span class="input-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>

    <div id="tab-password" class="tab-panel {{ session('tab') === 'password' ? 'active' : '' }}">
        <div class="card">
            <div class="card-title">Change Password</div>
            @if (session('tab') === 'password' && $errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('student.profile.password') }}">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label for="current_pwd">Current Password</label>
                    <input id="current_pwd" type="password" name="current_password" placeholder="••••••••" required />
                    @error('current_password') <span class="input-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="new_pwd">New Password</label>
                        <input id="new_pwd" type="password" name="password" placeholder="••••••••" required />
                        @error('password') <span class="input-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="new_pwd_confirm">Confirm New Password</label>
                        <input id="new_pwd_confirm" type="password" name="password_confirmation" placeholder="••••••••" required />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>

    <div id="tab-danger" class="tab-panel {{ session('tab') === 'danger' ? 'active' : '' }}">
        <div class="danger-card">
            <div class="card-title">Delete Account</div>
            <p style="color:rgba(255,255,255,0.4); font-size:14px; margin-bottom:18px;">This action is permanent and cannot be undone.</p>
            @if (session('tab') === 'danger' && $errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('student.profile.destroy') }}" onsubmit="return confirm('Are you absolutely sure?')">
                @csrf @method('DELETE')
                <div class="form-group" style="max-width:340px;">
                    <label for="del_pwd">Confirm your password</label>
                    <input id="del_pwd" type="password" name="password" placeholder="••••••••" required />
                    @error('password') <span class="input-error">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-danger">Delete My Account</button>
            </form>
        </div>
    </div>
</div>
<script>
    function switchTab(name, btn) {
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('tab-' + name).classList.add('active');
        btn.classList.add('active');
    }
</script>
</body>
</html>
