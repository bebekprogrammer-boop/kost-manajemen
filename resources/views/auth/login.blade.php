<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – {{ env('KOST_NAME', 'KOST-MANAJEMEN') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue-primary:   #1d4ed8;
            --blue-dark:      #1e3a8a;
            --blue-deeper:    #172554;
            --blue-light:     #dbeafe;
            --blue-mid:       #93c5fd;
            --green-accent:   #fbff00;
            --green-light:    #dcfce7;
            --green-dark:     #798015;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--blue-deeper) 0%, var(--blue-dark) 45%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Background decoration */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 90% 10%, rgba(34,197,94,0.12) 0%, transparent 55%),
                radial-gradient(ellipse 50% 70% at 5% 90%, rgba(29,78,216,0.3) 0%, transparent 50%);
            pointer-events: none;
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 56px 56px;
            pointer-events: none;
        }

        .bg-circle {
            position: fixed;
            right: -150px;
            top: 50%;
            transform: translateY(-50%);
            width: 600px;
            height: 600px;
            border-radius: 50%;
            border: 1.5px solid rgba(251,255,0,0.08);
            pointer-events: none;
        }
        .bg-circle::before {
            content: '';
            position: absolute;
            inset: 60px;
            border-radius: 50%;
            border: 1.5px solid rgba(251,255,0,0.05);
        }

        /* ─── CARD ─── */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            background: rgba(255,255,255,0.98);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 32px 80px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.1);
            overflow: hidden;
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Card header */
        .card-header {
            background: linear-gradient(135deg, var(--blue-deeper), var(--blue-primary));
            padding: 2rem 2rem 1.75rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .card-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 80% at 50% 120%, rgba(251,255,0,0.08), transparent);
        }
        .card-header-inner { position: relative; z-index: 1; }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 1rem;
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.15);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .brand-name {
            font-weight: 900;
            font-size: 1rem;
            color: #fff;
            letter-spacing: -0.01em;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -0.02em;
        }
        .card-subtitle {
            font-size: 0.78rem;
            color: rgba(191,219,254,0.85);
            margin-top: 0.3rem;
        }

        /* Card body */
        .card-body {
            padding: 1.75rem 2rem 2rem;
        }

        /* Alert */
        .alert-status {
            background: var(--green-light);
            border: 1px solid #86efac;
            color: #15803d;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.6rem 0.9rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
        }

        /* Form fields */
        .field { margin-bottom: 1.1rem; }

        .field label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.35rem;
            letter-spacing: 0.01em;
        }

        .field input[type="email"],
        .field input[type="password"] {
            width: 100%;
            padding: 0.65rem 0.9rem;
            border: 1.5px solid #e0e7ff;
            border-radius: 9px;
            font-size: 0.875rem;
            font-family: 'Roboto', sans-serif;
            color: #1e293b;
            background: #f8faff;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .field input:focus {
            border-color: var(--blue-primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
        }
        .field input::placeholder { color: #94a3b8; }

        /* Error text */
        .field-error {
            font-size: 0.72rem;
            color: #dc2626;
            margin-top: 0.3rem;
            font-weight: 500;
        }

        /* Remember + forgot */
        .form-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }
        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.78rem;
            color: #475569;
            cursor: pointer;
            font-weight: 500;
        }
        .remember-label input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: var(--blue-primary);
            cursor: pointer;
        }
        .forgot-link {
            font-size: 0.75rem;
            color: var(--blue-primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: var(--blue-dark); text-decoration: underline; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            background: var(--blue-primary);
            color: #fff;
            font-weight: 800;
            font-size: 0.9rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 18px rgba(29,78,216,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-family: 'Roboto', sans-serif;
        }
        .btn-submit:hover {
            background: #1e40af;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(29,78,216,0.4);
        }
        .btn-submit:active { transform: translateY(0); }

        /* Back link */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            margin-top: 1.25rem;
            font-size: 0.75rem;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--blue-primary); }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid #e0e7ff;
            margin: 1.1rem 0;
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-circle"></div>

    <div class="login-card">

        <!-- Header -->
        <div class="card-header">
            <div class="card-header-inner">
                <div class="flex justify-center">
                    <div class="brand">
                        <div class="brand-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <span class="brand-name">{{ env('KOST_NAME', 'KOST-MANAJEMEN') }}</span>
                    </div>
                </div>
                <p class="card-title">Login Admin</p>
                <p class="card-subtitle">Masuk untuk mengelola data kost</p>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert-status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@example.com"
                           required autofocus autocomplete="username">
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password"
                           placeholder="••••••••"
                           required autocomplete="current-password">
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="form-footer-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Masuk ke Dashboard
                </button>
            </form>

            <!-- Back to home -->
            <a href="{{ route('home') }}" class="back-link">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
