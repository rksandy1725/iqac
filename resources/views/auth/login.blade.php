<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'IQAC Management') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; overflow-x: hidden; }

        .login-container {
            display: flex;
            min-height: 100vh;
        }

        /* Left Panel - Branding */
        .brand-panel {
            flex: 1;
            background: linear-gradient(135deg, #0d1b3e 0%, #1a365d 50%, #234e7a 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);
            animation: pulse-bg 8s ease-in-out infinite;
        }

        @keyframes pulse-bg {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .brand-panel::after {
            content: '';
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.1);
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 480px;
        }

        .brand-logo {
            width: 90px;
            height: 90px;
            background: rgba(255,255,255,0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.15);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .brand-logo i { font-size: 2.5rem; color: #60a5fa; }

        .brand-title {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            font-size: 1rem;
            color: rgba(255,255,255,0.7);
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        .brand-features {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .brand-feature {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.85rem 1.25rem;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .brand-feature:hover {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }

        .brand-feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .brand-feature-text {
            text-align: left;
        }

        .brand-feature-text h6 {
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.15rem;
        }

        .brand-feature-text small {
            color: rgba(255,255,255,0.5);
            font-size: 0.78rem;
        }

        /* Right Panel - Login Form */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: #f8fafc;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            margin-bottom: 2.5rem;
        }

        .login-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #64748b;
            font-size: 0.95rem;
        }

        .form-floating { margin-bottom: 1rem; }

        .form-floating .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1rem;
            height: 56px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-floating .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-floating label {
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            z-index: 5;
            font-size: 1.1rem;
        }

        .input-icon:hover { color: #3b82f6; }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .form-check-label {
            color: #475569;
            font-size: 0.88rem;
        }

        .forgot-link {
            color: #3b82f6;
            font-size: 0.88rem;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            height: 52px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            padding: 0 1rem;
        }

        .demo-credentials {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 1.25rem;
        }

        .demo-credentials h6 {
            color: #1e40af;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .credential-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            font-size: 0.82rem;
            border-bottom: 1px solid #dbeafe;
        }

        .credential-item:last-child { border-bottom: none; }

        .credential-item span { color: #475569; }
        .credential-item strong { color: #1e40af; font-family: monospace; }

        .copy-btn {
            background: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 0.7rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .copy-btn:hover { background: #2563eb; }

        /* Error styling */
        .alert-danger {
            border-radius: 12px;
            border: none;
            background: #fef2f2;
            color: #991b1b;
            padding: 0.85rem 1rem;
            font-size: 0.88rem;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .brand-panel { display: none; }
            .form-panel { padding: 2rem 1.5rem; }
        }

        @media (max-width: 480px) {
            .form-panel { padding: 1.5rem 1rem; }
            .login-card { max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Panel - Branding -->
        <div class="brand-panel">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h1 class="brand-title">IQAC Management System</h1>
                <p class="brand-subtitle">
                    Internal Quality Assurance Cell - Empowering institutions with systematic quality enhancement and NAAC accreditation readiness.
                </p>
                <div class="brand-features">
                    <div class="brand-feature">
                        <div class="brand-feature-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div class="brand-feature-text">
                            <h6>NAAC Criteria Tracking</h6>
                            <small>Monitor all 7 criteria with real-time progress</small>
                        </div>
                    </div>
                    <div class="brand-feature">
                        <div class="brand-feature-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <div class="brand-feature-text">
                            <h6>AQAR Report Generation</h6>
                            <small>Auto-generate annual quality reports</small>
                        </div>
                    </div>
                    <div class="brand-feature">
                        <div class="brand-feature-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="brand-feature-text">
                            <h6>Collaborative Platform</h6>
                            <small>Connect faculty, HODs, and coordinators</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="form-panel">
            <div class="login-card">
                <div class="login-header">
                    <h2>Welcome back</h2>
                    <p>Sign in to your IQAC account</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-floating position-relative">
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                        <label for="email">Email address</label>
                        <i class="bi bi-envelope input-icon"></i>
                    </div>

                    <div class="form-floating position-relative">
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Password" required autocomplete="current-password">
                        <label for="password">Password</label>
                        <i class="bi bi-lock input-icon" id="togglePassword" style="cursor:pointer;"></i>
                    </div>

                    <div class="remember-row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this;
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.replace('bi-lock', 'bi-lock-fill');
            } else {
                password.type = 'password';
                icon.classList.replace('bi-lock-fill', 'bi-lock');
            }
        });

        // Copy to clipboard
        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                event.target.textContent = 'Copied!';
                setTimeout(() => { event.target.textContent = 'Copy'; }, 1500);
            });
        }
    </script>
</body>
</html>
