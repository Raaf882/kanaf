<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('تسجيل الدخول') }} — {{ __('كَـنَـف') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="shortcut icon"         href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="apple-touch-icon"      href="{{ asset('images/kanaf-logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Cairo', sans-serif; }
        input[type="password"]::-ms-reveal { display: none; }

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
            text-align: right;
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
</head>
<body>
<div class="login-page">

    {{-- Government Banner --}}
    <dga-second-nav-header>
        <dga-second-nav-header-content>
            <dga-second-nav-header-item label="{{ __('موقع حكومي رسمي مسجل لدى هيئة الحكومة الرقمية') }}">
            </dga-second-nav-header-item>
        </dga-second-nav-header-content>
    </dga-second-nav-header>

    {{-- Nav Header --}}
    <dga-nav-header sticky="true" divider="true" full-width="true">
        <dga-nav-header-main collapsed="true">
            <dga-nav-header-logos
                logo-src="{{ asset('images/kanaf-logo.png') }}"
                logo-alt="{{ __('كَـنَـف') }}"
                logo-link="{{ route('landing') }}"
                gov-src="https://dga-nds-fbhtx.ondigitalocean.app/mobile-logo.svg"
                gov-link="#">
            </dga-nav-header-logos>
            <dga-nav-header-menu>
                <dga-nav-header-link label="{{ __('الرئيسية') }}"          id="lnl-home"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('رحلتك الأكاديمية') }}"  id="lnl-journey"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('مستقبلك المهني') }}"    id="lnl-career"></dga-nav-header-link>
            </dga-nav-header-menu>
        </dga-nav-header-main>
        <dga-nav-header-actions>
            <dga-header-action-btn id="lnl-lang"  label="{{ app()->getLocale() === 'ar' ? 'English' : 'عربي' }}" icon="translation"></dga-header-action-btn>
            <dga-header-action-btn id="lnl-login" label="{{ __('تسجيل الدخول') }}" icon="user"></dga-header-action-btn>
        </dga-nav-header-actions>
    </dga-nav-header>

    <script>
    customElements.whenDefined('dga-nav-header-logos').then(function () {
        function shrinkLogo() {
            document.querySelectorAll('dga-nav-header-logos').forEach(function (el) {
                if (el.shadowRoot && !el.shadowRoot.querySelector('style[data-kanaf-logo]')) {
                    var s = document.createElement('style');
                    s.setAttribute('data-kanaf-logo', '1');
                    s.textContent = '.header__logo img { height: 32px !important; width: auto !important; }';
                    el.shadowRoot.appendChild(s);
                }
            });
        }
        requestAnimationFrame(shrinkLogo);
        setTimeout(shrinkLogo, 400);
    });
    document.addEventListener('DOMContentLoaded', function () {
        function goTo(id, url) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('click', function () { window.location.href = url; });
        }
        goTo('lnl-home',    '{{ route('landing') }}');
        goTo('lnl-journey', '{{ route('login') }}');
        goTo('lnl-career',  '{{ route('login') }}');
        goTo('lnl-login',   '{{ route('login') }}');
        var langBtn = document.getElementById('lnl-lang');
        if (langBtn) langBtn.addEventListener('click', function () {
            window.location.href = '{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}';
        });
    });
    </script>

    {{-- Main content --}}
    <div class="login-hero">
        <div class="login-inner">

            {{-- Login card (right side in RTL) --}}
            <div class="login-card">

                {{-- Header --}}
                <div style="text-align:right; margin-bottom:32px;">
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
                        <label style="font-size:.875rem; font-weight:700; color:#374151; text-align:right;">
                            {{ __('اسم المستخدم أو البريد الإلكتروني') }}
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="{{ __('ادخل بريدك الإلكتروني الجامعي') }}"
                               class="form-input {{ $errors->any() ? 'error' : '' }}"
                               dir="ltr"
                               style="text-align:right; direction:rtl;">
                    </div>

                    {{-- Password --}}
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <label style="font-size:.875rem; font-weight:700; color:#374151; text-align:right;">
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
                                   style="padding-left:48px;">
                            <button type="button"
                                    onclick="togglePassword()"
                                    style="position:absolute; left:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#9ca3af; padding:2px;">
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
    <dga-footer id="login-footer"></dga-footer>
    <script>
    customElements.whenDefined('dga-footer').then(function () {
        var f = document.getElementById('login-footer');
        if (!f) return;
        f.background       = 'Light';
        f.NavLinks         = true;
        f.socialMediaTitle = 'وسائل التواصل الاجتماعي';
        f.copyright        = 'جميع الحقوق محفوظة لهيئة الحكومة الرقمية © 2026';
        f.groupLinks = [
            { title: 'المنصة', links: [
                { name: 'عن المنصة',         target: '{{ route("landing") }}#about' },
                { name: 'خدماتنا',           target: '{{ route("landing") }}#services' },
                { name: 'المقالات والأخبار', target: '{{ route("landing") }}#articles' },
            ]},
            { title: 'الدعم', links: [
                { name: 'خريطة الموقع', target: '#' },
                { name: 'RSS',           target: '#' },
                { name: 'تطبيق الجوال', target: '#' },
            ]},
        ];
        f.socialMediaLinks = [
            { title: 'تويتر',    target: '#', icon: { name: 'TwitterIcon',   variant: 'stroke' } },
            { title: 'يوتيوب',   target: '#', icon: { name: 'YoutubeIcon',   variant: 'stroke' } },
            { title: 'إنستغرام', target: '#', icon: { name: 'InstagramIcon', variant: 'stroke' } },
        ];
        f.basicLinks = [
            { name: 'الرئيسية',      target: '{{ route("landing") }}' },
            { name: 'تسجيل الدخول', target: '{{ route("login") }}' },
        ];
        f.extraLinks = [
            { name: 'سياسة الخصوصية',   target: '#' },
            { name: 'الشروط والأحكام', target: '#' },
        ];
        f.bottomImages = ['{{ asset("images/kanaf-logo.png") }}'];
    });
    </script>

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
