<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration — Internship Tracking System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
            background: #111;
            color: #fff;
        }
        .card {
            background: #1a1a1a;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 48px 40px;
            width: 100%;
            max-width: 560px;
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
        .subtitle { color: rgba(255,255,255,0.45); font-size: 14px; margin-bottom: 22px; }
        .notice {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.6);
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 13px;
            margin-bottom: 22px;
        }
        .alert-error {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,100,100,0.3);
            color: #fca5a5;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
            margin-bottom: 18px;
        }
        .section-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            margin-bottom: 14px;
            margin-top: 4px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; color: rgba(255,255,255,0.55); font-size: 13px; font-weight: 500; margin-bottom: 7px; }
        input, select {
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
            appearance: none;
            -webkit-appearance: none;
        }
        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(255,255,255,0.3)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }
        select option { background: #1a1a1a; }
        select:disabled { opacity: 0.35; cursor: not-allowed; }
        input:focus, select:focus { border-color: rgba(255,255,255,0.4); }
        input::placeholder { color: rgba(255,255,255,0.25); }
        .input-error { color: #fca5a5; font-size: 12px; margin-top: 5px; display: block; }
        .select-hint { font-size: 11px; color: rgba(255,255,255,0.25); margin-top: 5px; }
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
            margin-top: 10px;
            font-family: 'Inter', sans-serif;
        }
        .btn:hover { opacity: 0.88; }
        .footer-links { margin-top: 22px; text-align: center; font-size: 13px; color: rgba(255,255,255,0.35); }
        .footer-links a { color: rgba(255,255,255,0.65); text-decoration: none; font-weight: 500; }
        .footer-links a:hover { color: #fff; }
    </style>
</head>
<body>
<script>
    const ALL_DEPARTMENTS = @json($departments->map(fn($d) => ['id' => $d->id, 'name' => $d->name, 'college_id' => $d->college_id]));
    const ALL_COURSES     = @json($courses->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'department_id' => $c->department_id]));
</script>
<div class="card">
    <div class="badge">Student Registration</div>
    <h1>Create your account</h1>
    <p class="subtitle">Register to access the Internship Tracking System</p>
    <div class="notice">⏳ After registration, your account requires <strong>admin approval</strong> before you can log in.</div>
    @if ($errors->any())
        <div class="alert-error">
            <ul style="list-style:none;">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('student.register') }}">
        @csrf
        <div class="section-label">Personal Information</div>
        <div class="form-row">
            <div class="form-group">
                <label for="s_name">Full Name</label>
                <input id="s_name" type="text" name="name" value="{{ old('name') }}" placeholder="Jane Doe" required />
                @error('name') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="s_roll_number">Roll Number</label>
                <input id="s_roll_number" type="text" name="roll_number" value="{{ old('roll_number') }}" placeholder="CS2024001" required />
                @error('roll_number') <span class="input-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="s_email">Email Address</label>
                <input id="s_email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required />
                @error('email') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="s_phone">Phone Number</label>
                <input id="s_phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="+91 98765 43210" required />
                @error('phone') <span class="input-error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="section-label" style="margin-top:4px;">Academic Information</div>
        <div class="form-group">
            <label for="s_college_id">College</label>
            <select id="s_college_id" name="college_id" required onchange="onCollegeChange(this.value)">
                <option value="" disabled {{ old('college_id') ? '' : 'selected' }}>— Select your college —</option>
                @foreach ($colleges as $college)
                    <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>
                        {{ $college->name }}{{ $college->location ? ' ('.$college->location.')' : '' }}
                    </option>
                @endforeach
            </select>
            @error('college_id') <span class="input-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="s_department_id">Department</label>
            <select id="s_department_id" name="department_id" required disabled onchange="onDepartmentChange(this.value)">
                <option value="" disabled selected>— Select college first —</option>
            </select>
            <span class="select-hint" id="dept_hint">Select a college first.</span>
            @error('department_id') <span class="input-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="s_course_id">Course</label>
            <select id="s_course_id" name="course_id" required disabled>
                <option value="" disabled selected>— Select department first —</option>
            </select>
            <span class="select-hint" id="course_hint">Select a department first.</span>
            @error('course_id') <span class="input-error">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="s_year">Year of Study</label>
            <select id="s_year" name="year" required>
                <option value="" disabled {{ old('year') ? '' : 'selected' }}>— Select year —</option>
                @for ($y = 1; $y <= 6; $y++)
                    <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>Year {{ $y }}</option>
                @endfor
            </select>
            @error('year') <span class="input-error">{{ $message }}</span> @enderror
        </div>
        <div class="section-label" style="margin-top:4px;">Password</div>
        <div class="form-row">
            <div class="form-group">
                <label for="s_password">Password</label>
                <input id="s_password" type="password" name="password" placeholder="••••••••" required />
                @error('password') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="s_password_confirm">Confirm Password</label>
                <input id="s_password_confirm" type="password" name="password_confirmation" placeholder="••••••••" required />
            </div>
        </div>
        <button type="submit" class="btn">Register as Student</button>
    </form>
    <div class="footer-links">Already have an account? <a href="{{ route('student.login') }}">Sign in here</a></div>
</div>
<script>
    const deptSelect   = document.getElementById('s_department_id');
    const courseSelect = document.getElementById('s_course_id');
    const deptHint     = document.getElementById('dept_hint');
    const courseHint   = document.getElementById('course_hint');
    const oldDeptId    = "{{ old('department_id') }}";
    const oldCourseId  = "{{ old('course_id') }}";
    const oldCollegeId = "{{ old('college_id') }}";

    function buildOption(value, text, selected = false) {
        const opt = document.createElement('option');
        opt.value = value; opt.textContent = text;
        if (selected) opt.selected = true;
        return opt;
    }
    function resetSelect(el, placeholder) {
        el.innerHTML = '';
        el.appendChild(buildOption('', placeholder, true));
        el.disabled = true;
    }
    function onCollegeChange(collegeId) {
        const filtered = ALL_DEPARTMENTS.filter(d => d.college_id == collegeId);
        resetSelect(deptSelect, '— Select department —');
        resetSelect(courseSelect, '— Select department first —');
        deptHint.textContent = filtered.length ? '' : 'No departments available.';
        courseHint.textContent = 'Select a department first.';
        if (!filtered.length) return;
        filtered.forEach(d => deptSelect.appendChild(buildOption(d.id, d.name, d.id == oldDeptId)));
        deptSelect.disabled = false;
        if (oldDeptId && filtered.some(d => d.id == oldDeptId)) onDepartmentChange(oldDeptId);
    }
    function onDepartmentChange(deptId) {
        const filtered = ALL_COURSES.filter(c => c.department_id == deptId);
        resetSelect(courseSelect, '— Select course —');
        courseHint.textContent = filtered.length ? '' : 'No courses available.';
        if (!filtered.length) return;
        filtered.forEach(c => courseSelect.appendChild(buildOption(c.id, c.name, c.id == oldCourseId)));
        courseSelect.disabled = false;
    }
    document.addEventListener('DOMContentLoaded', function () {
        if (oldCollegeId) onCollegeChange(oldCollegeId);
    });
</script>
</body>
</html>
