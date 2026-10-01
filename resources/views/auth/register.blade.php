<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'IQAC Management') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; overflow-x: hidden; }

        .login-container { display: flex; min-height: 100vh; }

        .brand-panel {
            flex: 0 0 42%;
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
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);
            animation: pulse-bg 8s ease-in-out infinite;
        }

        @keyframes pulse-bg { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }

        .brand-panel::after {
            content: '';
            position: absolute;
            bottom: -100px; right: -100px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.1);
        }

        .brand-content { position: relative; z-index: 2; text-align: center; max-width: 420px; }

        .brand-logo {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.1);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.15);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .brand-logo i { font-size: 2.2rem; color: #60a5fa; }

        .brand-title { font-size: 1.75rem; font-weight: 800; color: #fff; margin-bottom: 0.75rem; }
        .brand-subtitle { font-size: 0.95rem; color: rgba(255,255,255,0.7); line-height: 1.7; }

        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            background: #f8fafc;
        }

        .login-card { width: 100%; max-width: 440px; }

        .login-header { margin-bottom: 2rem; }
        .login-header h2 { font-size: 1.65rem; font-weight: 700; color: #0f172a; margin-bottom: 0.4rem; }
        .login-header p { color: #64748b; font-size: 0.93rem; }

        .form-floating { margin-bottom: 0.85rem; }

        .form-floating .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem; height: 52px;
            font-size: 0.93rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-floating .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-floating label { color: #94a3b8; font-size: 0.88rem; }

        .input-icon {
            position: absolute; right: 16px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8; cursor: pointer; z-index: 5; font-size: 1.05rem;
        }

        .input-icon:hover { color: #3b82f6; }

        .btn-login {
            width: 100%; height: 50px;
            border-radius: 12px;
            font-size: 0.95rem; font-weight: 600;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none; color: #fff;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #64748b;
        }

        .login-footer a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover { text-decoration: underline; }

        .alert-danger { border-radius: 12px; border: none; background: #fef2f2; color: #991b1b; padding: 0.85rem 1rem; font-size: 0.88rem; }

        @media (max-width: 991px) { .brand-panel { display: none; } .form-panel { padding: 2rem 1.5rem; } }
        @media (max-width: 480px) { .form-panel { padding: 1.5rem 1rem; } }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="brand-panel">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h1 class="brand-title">Join IQAC</h1>
                <p class="brand-subtitle">
                    Create your account to contribute to institutional quality assurance and academic excellence.
                </p>
            </div>
        </div>

        <div class="form-panel">
            <div class="login-card">
                <div class="login-header">
                    <h2>Create Account</h2>
                    <p>Fill in your details to get started</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-floating position-relative">
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                        <label for="name">Full Name</label>
                        <i class="bi bi-person input-icon"></i>
                    </div>

                    <div class="form-floating position-relative">
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email') }}" placeholder="name@example.com" required>
                        <label for="email">Email address</label>
                        <i class="bi bi-envelope input-icon"></i>
                    </div>

                    <div class="form-floating position-relative">
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Password" required autocomplete="new-password">
                        <label for="password">Password</label>
                        <i class="bi bi-lock input-icon" id="togglePassword" style="cursor:pointer;"></i>
                    </div>

                    <div class="form-floating position-relative">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                               placeholder="Confirm Password" required autocomplete="new-password">
                        <label for="password_confirmation">Confirm Password</label>
                        <i class="bi bi-lock-fill input-icon"></i>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-person-plus"></i>
                        Create Account
                    </button>
                </form>

                <div class="login-footer">
                    Already have an account? <a href="{{ route('login') }}">Sign in</a>
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</body>
</html>
