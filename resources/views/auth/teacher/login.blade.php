<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login — Internship Tracking System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #111;
            color: #fff;
        }
        .card {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
        }
        .badge {
            display: inline-block;
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.6);
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        h1 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
        .subtitle { color: rgba(255,255,255,0.45); font-size: 14px; margin-bottom: 32px; }
        .alert-error {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,100,100,0.3);
            color: #fca5a5;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            margin-bottom: 18px;
        }
        .alert-success {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.8);
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            margin-bottom: 18px;
        }
        .form-group { margin-bottom: 18px; }
        label { display: block; color: rgba(255,255,255,0.55); font-size: 13px; font-weight: 500; margin-bottom: 7px; }
        input {
            width: 100%;
            padding: 11px 14px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }
        input:focus { border-color: rgba(255,255,255,0.4); }
        input::placeholder { color: rgba(255,255,255,0.25); }
        .input-error { color: #fca5a5; font-size: 12px; margin-top: 5px; display: block; }
        .btn {
            width: 100%;
            padding: 12px;
            background: #fff;
            border: none;
            border-radius: 8px;
            color: #111;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s;
            margin-top: 8px;
            font-family: 'Inter', sans-serif;
        }
        .btn:hover { opacity: 0.88; }
        .footer-links { margin-top: 20px; text-align: center; font-size: 13px; color: rgba(255,255,255,0.35); }
        .footer-links a { color: rgba(255,255,255,0.65); text-decoration: none; font-weight: 500; }
        .footer-links a:hover { color: #fff; }
        .divider {
            text-align: center;
            color: rgba(255,255,255,0.2);
            font-size: 12px;
            margin: 24px 0 16px;
            position: relative;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 38%;
            height: 1px;
            background: rgba(255,255,255,0.08);
        }
        .divider::before { left: 0; }
        .divider::after  { right: 0; }
    </style>
</head>
<body>
    <div class="card">
        <div class="badge">Teacher Portal</div>
        <h1>Welcome back</h1>
        <p class="subtitle">Sign in to your teacher account</p>
        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('teacher.login') }}">
            @csrf
            <div class="form-group">
                <label for="teacher_email">Email Address</label>
                <input id="teacher_email" type="email" name="email" value="{{ old('email') }}" placeholder="teacher@example.com" required />
                @error('email') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="teacher_password">Password</label>
                <input id="teacher_password" type="password" name="password" placeholder="••••••••" required />
                @error('password') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
        <div class="divider">Other Portals</div>
        <div class="footer-links">
            <a href="{{ route('admin.login') }}">Admin</a>
            &nbsp;·&nbsp;
            <a href="{{ route('student.login') }}">Student</a>
        </div>
        
    </div>
</body>
</html>
