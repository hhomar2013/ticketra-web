<div class="login-page p-5">
    {{-- ══════ LEFT PANEL ══════ --}}
    <div class="login-left">
        <div class="blob-2"></div>
        <div class="left-content">

            <div class="left-icon-wrap">🎫</div>

            <h2 style="color: #fff; font-weight: 800; font-size: 28px; margin-bottom: 12px; line-height: 1.3;">
                Ticketra <br> IT Support System
            </h2>
            <p style="color: rgba(255,255,255,.7); font-size: 14px; line-height: 1.7; margin-bottom: 36px;">
                Manage, track, and resolve all your technical support requests in one place — faster and smarter.
            </p>

            <div class="d-flex flex-wrap justify-content-center">
                <div class="stat-pill">
                    <span class="dot" style="background: #4ade80;"></span>
                    Real-time updates
                </div>
                <div class="stat-pill">
                    <span class="dot" style="background: #facc15;"></span>
                    Smart notifications
                </div>
                <div class="stat-pill">
                    <span class="dot" style="background: #60a5fa;"></span>
                    Multi-branch support
                </div>
                <div class="stat-pill">
                    <span class="dot" style="background: #f472b6;"></span>
                    Feedback & ratings
                </div>
            </div>

        </div>
    </div>

    {{-- ══════ RIGHT PANEL ══════ --}}
    <div class="login-right">
        <div class="login-form-wrap">

            {{-- Brand --}}
            <div class="brand-row">
                <div class="brand-icon">🎫</div>
                <div>
                    <div style="font-size: 15px; font-weight: 700; color: #111827;">
                        {{ config('app.name') }}
                    </div>
                    <div style="font-size: 12px; color: #ffffff;">Support Portal</div>
                </div>
            </div>

            <div class="login-title">Welcome back 👋</div>
            <div class="login-sub">Sign in to continue to your dashboard</div>

            <form wire:submit.prevent="login">

                {{-- Email --}}
                <div class="field-group">
                    <label class="field-lbl">Email Address</label>
                    <div class="field-wrap">
                        <i class="fas fa-envelope f-icon"></i>
                        <input type="email" wire:model="email" class="f-input @error('email') is-invalid @enderror"
                            placeholder="you@company.com" autocomplete="email">
                    </div>
                    @error('email')
                        <div class="f-error">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field-group">
                    <label class="field-lbl">Password</label>
                    <div class="field-wrap">
                        <i class="fas fa-lock f-icon"></i>
                        <input type="password" wire:model="password"
                            class="f-input @error('password') is-invalid @enderror" placeholder="••••••••"
                            autocomplete="current-password">
                    </div>
                    @error('password')
                        <div class="f-error">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember --}}
                <div class="remember-row">
                    <label>
                        <input type="checkbox" wire:model.live="remember" />
                        Remember this device
                    </label>
                </div>

                {{-- Submit --}}
                <button class="btn-signin">
                    <span wire:loading.remove wire:target="login">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        Sign In
                    </span>
                    <span wire:loading wire:target="login">
                        <span class="spinner-border spinner-border-sm"></span>
                        Signing in...
                    </span>
                </button>

            </form>

            <div class="divider">{{ date('Y') }}</div>

            <div class="footer-copy">
                &copy; {{ date('Y') }} Developed by
                <a href="https://hhomar2013.github.io/OmarMahgoub/" target="_blank">MTG.</a>
            </div>

        </div>
    </div>

</div>


@push('css')
    <style>
        * {
            box-sizing: border-box;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            background: #f0f4ff !important;
        }

        /* ── Left Panel ── */
        .login-left {
            flex: 1;
            background: linear-gradient(145deg, #0d6efd 0%, #0047c4 60%, #002fa3 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 48px;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -80px;
            left: -80px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
        }

        .login-left::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -60px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .05);
        }

        .login-left .blob-2 {
            position: absolute;
            top: 50%;
            left: -40px;
            transform: translateY(-50%);
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
        }

        .left-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 380px;
        }

        .left-icon-wrap {
            width: 90px;
            height: 90px;
            border-radius: 24px;
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            font-size: 40px;
            border: 1px solid rgba(255, 255, 255, .2);
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 40px;
            padding: 10px 20px;
            margin: 6px 4px;
            font-size: 13px;
            color: rgba(255, 255, 255, .9);
        }

        .stat-pill .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        /* ── Right Panel ── */
        .login-right {
            width: 460px;
            min-width: 460px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 48px 44px;
        }

        .login-form-wrap {
            width: 100%;
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0d6efd, #0047c4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .login-title {
            font-size: 26px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 4px;
        }

        .login-sub {
            font-size: 14px;
            color: #9ca3af;
            margin-bottom: 36px;
        }

        .field-group {
            margin-bottom: 20px;
        }

        .field-lbl {
            display: block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .field-wrap {
            position: relative;
        }

        .field-wrap .f-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
            pointer-events: none;
            z-index: 1;
        }

        .f-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px 12px 42px;
            font-size: 14px;
            color: #111827;
            background: #f9fafb;
            transition: all .2s;
            outline: none;
        }

        .f-input::placeholder {
            color: #9ca3af;
        }

        .f-input:focus {
            border-color: #0d6efd;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, .1);
        }

        .f-input.is-invalid {
            border-color: #ef4444;
            background: #fff8f8;
        }

        .f-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember-row label {
            font-size: 13px;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-row input[type=checkbox] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            accent-color: #0d6efd;
            cursor: pointer;
        }

        .btn-signin {
            width: 100%;
            background: linear-gradient(135deg, #0d6efd, #0047c4);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            padding: 14px;
            letter-spacing: .3px;
            cursor: pointer;
            transition: transform .15s, box-shadow .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-signin:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(13, 110, 253, .35);
        }

        .btn-signin:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            color: #d1d5db;
            font-size: 12px;
            margin: 28px 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: calc(50% - 24px);
            height: 1px;
            background: #e5e7eb;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .footer-copy {
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            margin-top: 32px;
        }

        .footer-copy a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }

            .login-right {
                width: 100%;
                min-width: unset;
                padding: 36px 24px;
            }
        }
    </style>
@endpush
