<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - 1HZS FOTOCOPY & PRINT</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --color-bg: #e1e1e1;
        --color-card: #FFFFFF;
        --color-border: #E6E9F2;
        --color-text-primary: #16213E;
        --color-text-secondary: #6B7280;
        --color-accent-blue: #2F6BFF;
        --color-accent-blue-dark: #2557E0;
        --color-accent-purple: #7C3AED;
        --color-input-bg: #F8F9FC;
        --color-input-border: #E2E5EE;
        --color-danger-soft: #FCEAEA;
        --color-danger: #DC2626;

        --shadow-card: 0 1px 2px rgba(16, 24, 64, 0.04), 0 12px 32px -12px rgba(16, 24, 64, 0.10);
        --radius-lg: 20px;
        --radius-md: 12px;
        --radius-sm: 10px;
    }

    * { box-sizing: border-box; }

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    body {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: var(--color-bg);
        background-image:
        radial-gradient(circle at 12% 8%, rgba(47, 107, 255, 0.07), transparent 40%),
        radial-gradient(circle at 88% 92%, rgba(124, 58, 237, 0.06), transparent 42%);
        color: var(--color-text-primary);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        background: var(--color-card);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        padding: 40px 36px 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .logo-badge {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--color-accent-blue), var(--color-accent-purple));
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px -6px rgba(47, 107, 255, 0.45);
        margin-bottom: 18px;
    }

    .logo-badge svg {
        width: 28px;
        height: 28px;
        stroke: #FFFFFF;
    }

    .brand-title {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.01em;
        margin: 0;
        text-align: center;
        color: var(--color-text-primary);
    }

    .brand-title .accent {
        color: var(--color-accent-blue);
    }

    .brand-subtitle {
        margin: 6px 0 0;
        font-size: 13.5px;
        color: var(--color-text-secondary);
        text-align: center;
    }

    .alert-error {
        width: 100%;
        margin-top: 20px;
        padding: 11px 14px;
        background: var(--color-danger-soft);
        border: 1px solid #F5C2C2;
        color: var(--color-danger);
        font-size: 13.5px;
        font-weight: 500;
        border-radius: var(--radius-sm);
        text-align: center;
    }

    form {
        width: 100%;
        margin-top: 28px;
    }

    .field {
        margin-bottom: 18px;
    }

    .field label {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--color-text-secondary);
        margin-bottom: 8px;
    }

    .input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-wrap svg {
        position: absolute;
        left: 14px;
        width: 18px;
        height: 18px;
        stroke: #8B93A7;
        pointer-events: none;
    }

    .input-wrap input {
        width: 100%;
        padding: 12px 14px 12px 42px;
        font-size: 14.5px;
        font-family: inherit;
        color: var(--color-text-primary);
        background: var(--color-input-bg);
        border: 1px solid var(--color-input-border);
        border-radius: var(--radius-sm);
        outline: none;
        transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
    }

    .input-wrap input.input-error {
        border-color: var(--color-danger);
    }

    .input-wrap input::placeholder {
        color: #A2A9BB;
    }

    .input-wrap input:focus {
        border-color: var(--color-accent-blue);
        background: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(47, 107, 255, 0.12);
    }

    .btn-login {
        width: 100%;
        margin-top: 6px;
        padding: 13px 16px;
        font-family: inherit;
        font-size: 15px;
        font-weight: 700;
        color: #FFFFFF;
        background: linear-gradient(135deg, var(--color-accent-blue), var(--color-accent-blue-dark));
        border: none;
        border-radius: var(--radius-sm);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 10px 22px -8px rgba(47, 107, 255, 0.55);
        transition: transform 0.12s ease, box-shadow 0.12s ease, filter 0.12s ease;
    }

    .btn-login:hover {
        filter: brightness(1.04);
        box-shadow: 0 12px 26px -8px rgba(47, 107, 255, 0.6);
    }

    .btn-login:active {
        transform: translateY(1px);
    }

    .btn-login svg {
        width: 18px;
        height: 18px;
        stroke: #FFFFFF;
    }

    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 22px 0;
        width: 100%;
    }

    .divider::before,
    .divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: var(--color-border);
    }

    .divider span {
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #A2A9BB;
    }

    .btn-google {
        width: 100%;
        padding: 12px 16px;
        font-family: inherit;
        font-size: 14.5px;
        font-weight: 600;
        color: var(--color-text-primary);
        background: #FFFFFF;
        border: 1px solid var(--color-input-border);
        border-radius: var(--radius-sm);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: background 0.15s ease, border-color 0.15s ease;
    }

    .btn-google:hover {
        background: #F8F9FC;
        border-color: #D6DAE6;
    }

    .btn-google svg {
        width: 18px;
        height: 18px;
    }

    @media (max-width: 480px) {
        .login-card {
        padding: 32px 22px 26px;
        border-radius: 18px;
        }
    }

    @media (max-width: 360px) {
        body { padding: 16px; }
        .login-card { padding: 28px 18px 22px; }
    }
    </style>
    </head>
    <body>

    <div class="login-card">
        <div class="logo-badge">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9V2h12v7"></path>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        </div>

        <h1 class="brand-title">POS <span class="accent">Fotocopy</span></h1>
        <p class="brand-subtitle">Silakan login untuk mengakses sistem</p>

        {{-- Menampilkan error dari Laravel Auth::attempt() / validasi --}}
        @if ($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" novalidate>
        @csrf

        <div class="field">
            <label for="email">Alamat Email</label>
            <div class="input-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                <path d="m22 6-10 7L2 6"></path>
            </svg>
            <input type="email" id="email" name="email" placeholder="admin@contoh.com" autocomplete="email"
                    class="{{ $errors->has('email') ? 'input-error' : '' }}"
                    value="{{ old('email') }}" required autofocus>
            </div>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <div class="input-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <input type="password" id="password" name="password" placeholder="Masukkan password"
                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                    autocomplete="current-password" required>
            </div>
        </div>

        <button type="submit" class="btn-login">
            Login
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
            <polyline points="10 17 15 12 10 7"></polyline>
            <line x1="15" y1="12" x2="3" y2="12"></line>
            </svg>
        </button>
        </form>

        <div class="divider"><span>ATAU</span></div>

        <button type="button" class="btn-google" onclick="window.location.href='{{ route('google.login') }}'">
        <svg viewBox="0 0 48 48">
            <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
            <path fill="#FF3D00" d="m6.306 14.691 6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
            <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
            <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
        </svg>
        Masuk dengan Google
        </button>
        
    </div>

</body>
</html>