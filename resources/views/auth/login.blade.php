<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    {{-- ── FOUC guard: hide page until all head CSS is parsed ── --}}
    <style>html:not(.ready){visibility:hidden}</style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('تسجيل الدخول') }} — {{ __('كَـنَـف') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="shortcut icon"         href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="apple-touch-icon"      href="{{ asset('images/kanaf-logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=optional" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Cairo', sans-serif; }
        input[type="password"]::-ms-reveal { display: none; }

        /* ── Nav / Footer hover ── */
        .kanaf-nav-link:hover    { color: #1A6B3C !important; }
        .kanaf-footer-link:hover { color: #ffffff !important; }
        @media (max-width: 768px) {
            .kanaf-nav-links { display: none !important; }
            .kanaf-nav-inner { padding: 0 20px !important; }
        }

        @media (min-width: 1280px) { html { font-size: 17px; } }
        @media (min-width: 1536px) { html { font-size: 18px; } }

        .login-page { background: #f3f4f6; min-height: 100vh; display: flex; flex-direction: column; }

        .login-hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 80px;
        }
        .login-inner {
            max-width: 1440px;
            width: 100%;
            display: flex;
            align-items: center;
            gap: 80px;
        }
        .login-card {
            flex: 0 0 520px;
            max-width: 520px;
            background: #ffffff;
            border-radius: 24px;
            padding: 56px 48px;
            box-shadow: 0 4px 40px rgba(0,0,0,.08);
        }
        .login-illustration {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 900px) {
            .login-hero { padding: 40px 20px; }
            .login-inner { flex-direction: column; gap: 32px; }
            .login-card { flex: unset; max-width: 100%; }
            .login-illustration { display: none; }
        }

        .form-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 1rem;
            font-family: 'Cairo', sans-serif;
            transition: border-color .2s, box-shadow .2s;
            text-align: end;
            color: #111827;
        }
        .form-input:focus {
            outline: none;
            border-color: #1A6B3C;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,107,60,.08);
        }
        .form-input.error { border-color: #ef4444; }

        .btn-primary {
            width: 100%;
            background: #1A6B3C;
            color: #fff;
            font-weight: 800;
            font-family: 'Cairo', sans-serif;
            font-size: 1rem;
            padding: 14px 24px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: background .2s, transform .15s;
        }
        .btn-primary:hover { background: #155e34; transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
    </style>
    {{-- ── Reveal page once all preceding CSS is parsed (parser-blocking) ── --}}
    <script>document.documentElement.classList.add('ready')</script>
</head>
<body>
<div class="login-page">

    {{-- Navbar --}}
    <nav style="background:#ffffff; border-bottom:1.5px solid #e5e7eb; position:sticky; top:0; z-index:50; box-shadow:0 1px 6px rgba(0,0,0,0.04);">
        <div class="kanaf-nav-inner" style="max-width:1440px; width:100%; margin:0 auto; padding:0 80px; height:64px; display:flex; align-items:center; justify-content:space-between;" dir="rtl">
            <a href="{{ route('landing') }}" style="display:flex; align-items:center; gap:10px; text-decoration:none; flex-shrink:0;">
                <img src="{{ asset('images/kanaf-logo.png') }}" alt="{{ __('كَنَف') }}" style="height:34px; width:auto;">
                <span style="font-size:1.2rem; font-weight:900; color:#1A6B3C;">كَـنَـف</span>
            </a>
            <div class="kanaf-nav-links" style="display:flex; align-items:center; gap:28px;">
                <a href="{{ route('landing') }}"          class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">الرئيسية</a>
                <a href="{{ route('landing') }}#about"    class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">عن المنصة</a>
                <a href="{{ route('landing') }}#services" class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">خدماتنا</a>
            </div>
            <div style="display:flex; align-items:center; gap:10px; flex-shrink:0;">
                <a href="{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                   title="{{ app()->getLocale() === 'ar' ? 'Switch to English' : 'التبديل للعربية' }}"
                   style="display:flex; align-items:center; gap:5px; color:#374151; font-weight:700; font-size:0.82rem; text-decoration:none; padding:5px 10px; border-radius:8px; border:1.5px solid #e5e7eb; transition:border-color .15s, color .15s;"
                   onmouseover="this.style.borderColor='#1A6B3C'; this.style.color='#1A6B3C';"
                   onmouseout="this.style.borderColor='#e5e7eb'; this.style.color='#374151';">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    {{ app()->getLocale() === 'ar' ? 'EN' : 'عربي' }}
                </a>
                <a href="{{ route('login') }}" style="background:#1A6B3C; color:#fff; padding:7px 18px; border-radius:8px; font-weight:700; font-size:0.9rem; text-decoration:none; line-height:1; display:inline-block;">تسجيل الدخول</a>
            </div>
        </div>
    </nav>

    {{-- Main content --}}
    <div class="login-hero">
        <div class="login-inner">

            {{-- Login card (right side in RTL) --}}
            <div class="login-card">

                {{-- Header --}}
                <div style="text-align:end; margin-bottom:32px;">
                    <div style="display:flex; align-items:center; gap:12px; justify-content:flex-end; margin-bottom:16px;">
                        <div>
                            <h1 style="font-size:1.75rem; font-weight:900; color:#111827; margin:0; line-height:1.2;">
                                {{ __('تسجيل الدخول') }}
                            </h1>
                            <p style="font-size:.9rem; color:#6b7280; margin-top:6px; line-height:1.6;">
                                {{ __('لأن كل طالب يحتاج شخص يسانده، كَنَف هنا لدعم رحلتك') }}
                            </p>
                        </div>
                        <div style="width:48px; height:48px; border-radius:14px; background:#e6f4ec; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <svg width="24" height="24" fill="none" stroke="#1A6B3C" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Error message --}}
                    @if($errors->any())
                    <div style="background:#fef2f2; border:1px solid #fca5a5; border-radius:12px; padding:12px 16px; margin-bottom:0; display:flex; align-items:flex-start; gap:10px;">
                        <svg width="16" height="16" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0; margin-top:1px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p style="font-size:.85rem; color:#dc2626; margin:0;">{{ $errors->first() }}</p>
                    </div>
                    @endif
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('login.post') }}" style="display:flex; flex-direction:column; gap:20px;">
                    @csrf

                    {{-- Email --}}
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <label style="font-size:.875rem; font-weight:700; color:#374151; text-align:end;">
                            {{ __('اسم المستخدم أو البريد الإلكتروني') }}
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="{{ __('ادخل بريدك الإلكتروني الجامعي') }}"
                               class="form-input {{ $errors->any() ? 'error' : '' }}"
                               dir="ltr"
                               style="text-align:end; direction:rtl;">
                    </div>

                    {{-- Password --}}
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <label style="font-size:.875rem; font-weight:700; color:#374151; text-align:end;">
                            {{ __('كلمة المرور') }}
                        </label>
                        <div style="position:relative;">
                            <input id="password-input"
                                   type="password"
                                   name="password"
                                   required
                                   placeholder="••••••••"
                                   class="form-input {{ $errors->any() ? 'error' : '' }}"
                                   dir="ltr"
                                   style="padding-inline-start:48px;">
                            <button type="button"
                                    onclick="togglePassword()"
                                    style="position:absolute; inset-inline-start:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af; padding:2px;">
                                <svg id="eye-on"  width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-off" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-primary" style="margin-top:4px;">
                        {{ __('تسجيل الدخول') }}
                    </button>

                    {{-- Divider --}}
                    <div style="display:flex; align-items:center; gap:12px; margin-top:4px;">
                        <div style="flex:1; height:1px; background:#e5e7eb;"></div>
                        <span style="font-size:.8rem; color:#9ca3af; font-weight:600;">{{ __('أو') }}</span>
                        <div style="flex:1; height:1px; background:#e5e7eb;"></div>
                    </div>

                    {{-- Helper links --}}
                    <div style="display:flex; flex-direction:column; gap:8px; text-align:center;">
                        <button type="button"
                                style="background:none; border:none; cursor:pointer; font-size:.875rem; color:#1A6B3C; font-weight:700; font-family:'Cairo',sans-serif; text-decoration:underline; text-underline-offset:3px;">
                            {{ __('نسيت كلمة المرور؟') }}
                        </button>
                        <button type="button"
                                style="background:none; border:none; cursor:pointer; font-size:.875rem; color:#6b7280; font-weight:600; font-family:'Cairo',sans-serif;">
                            {{ __('تغيير كلمة المرور') }}
                        </button>
                    </div>
                </form>

                {{-- Demo hint --}}
                <div style="margin-top:24px; padding:12px 16px; background:#f9fafb; border-radius:12px; border:1px dashed #e5e7eb; text-align:center;">
                    <p style="font-size:.75rem; color:#9ca3af; margin:0; line-height:1.6;">
                        {{ __('للتجربة') }}:
                        <span style="font-family:monospace; font-weight:700; color:#374151;">khalid@kanaf.sa</span>
                        <span style="color:#d1d5db; margin:0 4px;">/</span>
                        <span style="font-family:monospace; font-weight:700; color:#374151;">password</span>
                    </p>
                </div>
            </div>

            {{-- Illustration (left side in RTL) --}}
            <div class="login-illustration">
                <div style="position:relative; text-align:center;">
                    {{-- Decorative background circle --}}
                    <div style="position:absolute; inset:-40px; border-radius:50%; background:radial-gradient(circle, rgba(26,107,60,.08) 0%, transparent 70%); pointer-events:none;"></div>

                    <img src="{{ asset('images/kanaf2.png') }}"
                         alt="{{ __('كَـنَـف') }}"
                         style="max-height:420px; max-width:100%; object-fit:contain; position:relative; z-index:1; filter:drop-shadow(0 20px 40px rgba(26,107,60,.15));"
                         onerror="this.parentElement.innerHTML='<div style=\'text-align:center\'><div style=\'font-size:6rem;font-weight:900;color:#1A6B3C;line-height:1;\'>كَـنَـف</div><p style=\'color:#9ca3af;font-size:.9rem;margin-top:12px;\'>منصة الإرشاد الأكاديمي</p></div>'">

                    {{-- Feature chips under illustration --}}
                    <div style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-top:32px; position:relative; z-index:1;">
                        @foreach([__('تحليل الأداء'), __('إرشاد أكاديمي'), __('ذكاء اصطناعي'), __('مسارات مهنية')] as $chip)
                        <span style="display:inline-flex; align-items:center; gap:6px; background:#fff; border:1px solid #e5e7eb;
                                     color:#374151; font-size:.8rem; font-weight:700; padding:6px 14px;
                                     border-radius:100px; box-shadow:0 1px 4px rgba(0,0,0,.06);">
                            <span style="width:6px; height:6px; border-radius:50%; background:#1A6B3C; flex-shrink:0;"></span>
                            {{ $chip }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer style="background:#1A6B3C; color:#fff; padding:24px 0; margin-top:auto;">
        <div style="max-width:1440px; width:100%; margin:0 auto; padding:0 80px;" dir="rtl">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:20px;">
                <a href="{{ route('landing') }}" style="display:flex; align-items:center; gap:10px; text-decoration:none; color:#fff; flex-shrink:0;">
                    <img src="{{ asset('images/kanaf-logo.png') }}" alt="{{ __('كَنَف') }}" style="height:28px; width:auto; filter:brightness(0) invert(1);">
                    <span style="font-size:1.1rem; font-weight:900;">كَـنَـف</span>
                </a>
                <div style="display:flex; gap:24px; flex-wrap:wrap;">
                    <a href="{{ route('landing') }}#about"    class="kanaf-footer-link" style="color:rgba(255,255,255,0.8); text-decoration:none; font-size:0.88rem; font-weight:600; transition:color .15s;">عن المنصة</a>
                    <a href="{{ route('landing') }}#services" class="kanaf-footer-link" style="color:rgba(255,255,255,0.8); text-decoration:none; font-size:0.88rem; font-weight:600; transition:color .15s;">خدماتنا</a>
                    <a href="{{ route('landing') }}#articles" class="kanaf-footer-link" style="color:rgba(255,255,255,0.8); text-decoration:none; font-size:0.88rem; font-weight:600; transition:color .15s;">المقالات</a>
                    <a href="{{ route('login') }}"            class="kanaf-footer-link" style="color:rgba(255,255,255,0.8); text-decoration:none; font-size:0.88rem; font-weight:600; transition:color .15s;">تسجيل الدخول</a>
                </div>
                <p style="color:rgba(255,255,255,0.65); font-size:0.82rem; margin:0; flex-shrink:0;">جميع الحقوق محفوظة © 2026 كَـنَـف</p>
            </div>
        </div>
    </footer>

</div>{{-- /login-page --}}

<script>
function togglePassword() {
    var inp    = document.getElementById('password-input');
    var eyeOn  = document.getElementById('eye-on');
    var eyeOff = document.getElementById('eye-off');
    if (inp.type === 'password') {
        inp.type = 'text';
        eyeOn.style.display  = 'none';
        eyeOff.style.display = '';
    } else {
        inp.type = 'password';
        eyeOn.style.display  = '';
        eyeOff.style.display = 'none';
    }
}
</script>
</body>
</html>
