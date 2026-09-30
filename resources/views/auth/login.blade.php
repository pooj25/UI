<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Track Tech Fabric System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── Left panel ───────────────── */
        .left-panel {
            background: #111827;
            display: flex; flex-direction: column;
            justify-content: center; align-items: flex-start;
            padding: 4rem 3.5rem;
            position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(22,163,74,0.25) 0%, transparent 55%),
                radial-gradient(circle at 80% 80%, rgba(15,118,110,0.2) 0%, transparent 55%);
        }
        .left-panel > * { position: relative; z-index: 1; }
        .brand-badge {
            display: inline-flex; align-items: center; gap: 0.6rem;
            background: rgba(22,163,74,0.15);
            border: 1px solid rgba(22,163,74,0.3);
            border-radius: 999px; padding: 0.4rem 1rem;
            margin-bottom: 2.5rem;
        }
        .brand-badge .dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #16a34a;
            box-shadow: 0 0 8px rgba(22,163,74,0.8);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%,100% { opacity: 1; } 50% { opacity: 0.4; }
        }
        .brand-badge span { font-size: 0.78rem; color: #4ade80; font-weight: 600; letter-spacing: 0.05em; }
        .left-panel h1 {
            font-size: 2.6rem; font-weight: 800; color: #f9fafb; line-height: 1.15;
            margin-bottom: 1.25rem;
        }
        .left-panel h1 span { color: #4ade80; }
        .left-panel p {
            font-size: 1rem; color: #9ca3af; max-width: 360px; line-height: 1.7;
            margin-bottom: 2.5rem;
        }
        .feature-list { list-style: none; }
        .feature-list li {
            display: flex; align-items: center; gap: 0.65rem;
            font-size: 0.875rem; color: #d1d5db; margin-bottom: 0.75rem;
        }
        .feature-list li i { color: #16a34a; font-size: 1rem; }
        .left-footer {
            position: absolute; bottom: 2rem; left: 3.5rem;
            font-size: 0.72rem; color: #4b5563;
        }

        /* ── Right panel ──────────────── */
        .right-panel {
            background: #f9fafb;
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 2.5rem;
        }
        .login-box { width: 100%; max-width: 400px; }
        .login-box h2 {
            font-size: 1.65rem; font-weight: 700; color: #111827;
            margin-bottom: 0.35rem;
        }
        .login-box .sub {
            font-size: 0.85rem; color: #6b7280; margin-bottom: 2rem;
        }
        .form-label {
            font-size: 0.82rem; font-weight: 600; color: #374151;
            display: block; margin-bottom: 0.4rem;
        }
        .input-wrap {
            position: relative; margin-bottom: 1.15rem;
        }
        .input-wrap i.icon {
            position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%);
            color: #9ca3af; font-size: 0.9rem;
        }
        .input-wrap input {
            width: 100%; padding: 0.65rem 0.9rem 0.65rem 2.5rem;
            border: 1.5px solid #e5e7eb; border-radius: 9px;
            font-size: 0.9rem; font-family: 'Inter', sans-serif;
            background: #fff; color: #111827;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }
        .input-wrap input:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22,163,74,0.12);
        }
        .input-wrap input.is-invalid { border-color: #ef4444; }
        .error-msg { font-size: 0.78rem; color: #dc2626; margin-top: 0.3rem; }
        .alert-error {
            background: rgba(220,38,38,0.07); border: 1px solid rgba(220,38,38,0.2);
            border-radius: 9px; padding: 0.7rem 1rem;
            font-size: 0.83rem; color: #991b1b; margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .check-row {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.83rem; color: #6b7280; margin-bottom: 1.5rem;
        }
        .check-row input[type="checkbox"] { accent-color: #16a34a; width: 15px; height: 15px; }
        .btn-sign-in {
            width: 100%; padding: 0.72rem;
            background: linear-gradient(135deg, #15803d, #16a34a);
            border: none; border-radius: 9px;
            font-size: 0.9rem; font-weight: 600; color: #fff;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-sign-in:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(22,163,74,0.35);
        }
        .divider { height: 1px; background: #e5e7eb; margin: 1.5rem 0; }
        .hint-box {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-radius: 9px; padding: 0.8rem 1rem;
            font-size: 0.79rem; color: #166534;
        }
        .hint-box strong { color: #15803d; }
        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.5rem; }
        }
        :root { color-scheme: dark; }
        body { font-family: 'DM Sans', sans-serif; color: #edf3ee; background: #0b1113; }
        .left-panel {
            background: radial-gradient(ellipse at 18% 15%, rgba(94,208,160,0.2), transparent 55%), radial-gradient(ellipse at 88% 84%, rgba(224,164,119,0.12), transparent 48%), #10191a;
        }
        .left-panel::before {
            background-image: linear-gradient(rgba(185,208,192,0.035) 1px, transparent 1px), linear-gradient(90deg, rgba(185,208,192,0.035) 1px, transparent 1px);
            background-size: 34px 34px;
        }
        .brand-badge { background: rgba(196,240,107,0.08); border-color: rgba(196,240,107,0.2); border-radius: 6px; }
        .brand-badge .dot { background: #c4f06b; box-shadow: 0 0 10px rgba(196,240,107,0.48); }
        .brand-badge span, .left-panel h1 span { color: #c4f06b; }
        .left-panel h1 { color: #edf3ee; }
        .left-panel p { color: #a4b1aa; }
        .feature-list li { color: #c7d2cb; }
        .feature-list li i { color: #5ed0a0; }
        .left-footer { color: #718078; }
        .right-panel { background: radial-gradient(ellipse at 78% 10%, rgba(53,99,78,0.1), transparent 30rem), #0b1113; }
        .login-box {
            padding: clamp(1.5rem, 4vw, 2.5rem);
            border: 1px solid rgba(191,211,197,0.14);
            border-radius: 8px;
            background: rgba(20,29,31,0.78);
            box-shadow: 0 22px 60px rgba(0,0,0,0.25);
            backdrop-filter: blur(18px);
        }
        .login-box h2 { color: #edf3ee; }
        .login-box .sub { color: #899894; }
        .form-label { color: #c7d2cb; }
        .input-wrap i.icon { color: #82918a; }
        .input-wrap input {
            color: #edf3ee;
            background: rgba(7,13,14,0.55);
            border: 1px solid rgba(191,211,197,0.17);
            border-radius: 6px;
            font-family: 'DM Sans', sans-serif;
        }
        .input-wrap input::placeholder { color: #74827b; }
        .input-wrap input:focus { border-color: rgba(196,240,107,0.62); box-shadow: 0 0 0 3px rgba(196,240,107,0.1); }
        .input-wrap input.is-invalid { border-color: #ff8a7d; }
        .error-msg { color: #ffaaa2; }
        .alert-error { color: #ffaaa2; background: rgba(255,138,125,0.08); border-color: rgba(255,138,125,0.2); border-radius: 6px; }
        .check-row { color: #a4b1aa; }
        .check-row input[type="checkbox"] { accent-color: #c4f06b; }
        .btn-sign-in { color: #17200e; background: #c4f06b; border-radius: 6px; }
        .btn-sign-in:hover { color: #17200e; background: #d4f58a; box-shadow: 0 8px 24px rgba(196,240,107,0.18); }
        .divider { background: rgba(191,211,197,0.13); }
        .hint-box { color: #b8c8bd; background: rgba(94,208,160,0.06); border-color: rgba(94,208,160,0.16); border-radius: 6px; }
        .hint-box strong { color: #91e2b4; }
        @media (max-width: 768px) {
            .right-panel { min-height: 100vh; padding: 1.25rem; }
            .login-box { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <!-- Left branding panel -->
    <div class="left-panel">
        <div class="brand-badge">
            <div class="dot"></div>
            <span>TRACK TECH SOLUTIONS</span>
        </div>
        <h1>Fabric<br>Production<br><span>Management</span></h1>
        <p>End-to-end garment production control — from fabric receipt to cutting floor, powered by QR tracking.</p>
        <ul class="feature-list">
            <li><i class="bi bi-check-circle-fill"></i> GRN & Roll-level QR Tracking</li>
            <li><i class="bi bi-check-circle-fill"></i> Fabric Inspection & DHU Analysis</li>
            <li><i class="bi bi-check-circle-fill"></i> Lay Model & Cut Planning</li>
            <li><i class="bi bi-check-circle-fill"></i> Real-time Production Status</li>
        </ul>
        <div class="left-footer">© {{ date('Y') }} Track Tech Solutions</div>
    </div>

    <!-- Right login panel -->
    <div class="right-panel">
        <div class="login-box">
            <h2>Welcome back</h2>
            <p class="sub">Sign in to your workspace to continue.</p>

            @if($errors->any())
                <div class="alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <label class="form-label" for="email">Email Address</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope icon"></i>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="you@tracktech.com"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        autocomplete="email" autofocus>
                </div>
                @error('email')<div class="error-msg"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror

                <label class="form-label" for="password">Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock icon"></i>
                    <input type="password" id="password" name="password"
                        placeholder="••••••••"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        autocomplete="current-password">
                </div>
                @error('password')<div class="error-msg">{{ $message }}</div>@enderror

                <div class="check-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me for 30 days</label>
                </div>

                <button type="submit" class="btn-sign-in">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>
            </form>

            <div class="divider"></div>
            <div class="hint-box">
                <i class="bi bi-info-circle me-1"></i>
                Default: <strong>admin@tracktech.com</strong> / <strong>ChangeMe@123</strong>
            </div>
        </div>
    </div>
</body>
</html>
