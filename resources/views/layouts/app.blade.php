<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('كَـنَـف') }} — {{ __('كَـنَـف') }}</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/kanaf-logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body        { font-family: 'Cairo', sans-serif; }
        .badge-avg  { background:#FFF8E1; color:#B8860B; border:1px solid #F0C040; }
        .badge-good { background:#E8F5E9; color:#1A6B3C; border:1px solid #81C784; }
        .badge-weak { background:#FFEBEE; color:#C62828; border:1px solid #EF9A9A; }

        /* ── Desktop font scaling ── */
        @media (min-width: 1280px) { html { font-size: 17px; } }
        @media (min-width: 1536px) { html { font-size: 18px; } }

        /* ── Page content max-width ── */
        .page-container {
            max-width: 1440px;
            width: 100%;
            margin-inline: auto;
            padding-inline: 80px;
        }
        @media (max-width: 1280px) { .page-container { padding-inline: 40px; } }
        @media (max-width: 768px)  { .page-container { padding-inline: 20px; } }

        /* ── Full page body wrapper ── */
        .page-body {
            max-width: 1440px;
            width: 100%;
            margin-inline: auto;
            padding: 32px 80px 60px;
        }
        @media (max-width: 1280px) { .page-body { padding-inline: 40px; } }
        @media (max-width: 1024px) { .page-body { padding-inline: 32px; } }
        @media (max-width: 768px)  { .page-body { padding: 20px 20px 40px; } }

        /* ── Hero strip ── */
        .page-hero-strip {
            background: #f3f4f6;
            padding-block: 36px 28px;
            width: 100%;
        }
        .page-hero-inner {
            max-width: 1440px;
            width: 100%;
            margin-inline: auto;
            padding-inline: 80px;
        }
        @media (max-width: 1280px) { .page-hero-inner { padding-inline: 40px; } }
        @media (max-width: 768px)  { .page-hero-inner { padding-inline: 20px; } }

        /* ── Nav / Footer hover ── */
        .kanaf-nav-link:hover    { color: #1A6B3C !important; }
        .kanaf-footer-link:hover { color: #ffffff !important; }

        /* ── Responsive nav ── */
        @media (max-width: 768px) {
            .kanaf-nav-links  { display: none; }
            .kanaf-nav-inner  { padding: 0 20px !important; }
        }
        @media (max-width: 480px) {
            .kanaf-nav-username { display: none; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- =================== NAVBAR =================== --}}
    <nav style="background:#ffffff; border-bottom:1.5px solid #e5e7eb; position:sticky; top:0; z-index:50; box-shadow:0 1px 6px rgba(0,0,0,0.04);">
        <div class="kanaf-nav-inner" style="max-width:1440px; width:100%; margin:0 auto; padding:0 80px; height:64px; display:flex; align-items:center; justify-content:space-between;" dir="rtl">

            {{-- Logo --}}
            <a href="{{ route('landing') }}" style="display:flex; align-items:center; gap:10px; text-decoration:none; flex-shrink:0;">
                <img src="{{ asset('images/kanaf-logo.png') }}" alt="{{ __('كَنَف') }}" style="height:34px; width:auto;">
                <span style="font-size:1.2rem; font-weight:900; color:#1A6B3C;">كَـنَـف</span>
            </a>

            {{-- Nav links --}}
            <div class="kanaf-nav-links" style="display:flex; align-items:center; gap:28px;">
                @auth
                @if(auth()->user()->role === 'student')
                <a href="{{ route('home') }}"             class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">الرئيسية</a>
                <a href="{{ route('academic-journey') }}" class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">رحلتك الأكاديمية</a>
                <a href="{{ route('career-future') }}"    class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">مستقبلك المهني</a>
                @elseif(auth()->user()->role === 'advisor')
                <a href="{{ route('advisor.dashboard') }}"                   class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">الرئيسية</a>
                <a href="{{ route('advisor.dashboard') }}#students-tracking" class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">متابعة الطلاب</a>
                <a href="{{ route('advisor.dashboard') }}#sessions"          class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">الجلسات</a>
                <a href="{{ route('advisor.dashboard') }}#nominations"       class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">الترشيحات</a>
                @elseif(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">لوحة الإدارة</a>
                <a href="{{ route('admin.students') }}"  class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">الطلاب</a>
                <a href="{{ route('admin.subjects') }}"  class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">المواد</a>
                <a href="{{ route('admin.advisors') }}"  class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">المرشدون</a>
                @endif
                @else
                <a href="{{ route('landing') }}"          class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">الرئيسية</a>
                <a href="{{ route('academic-journey') }}" class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">رحلتك الأكاديمية</a>
                <a href="{{ route('career-future') }}"    class="kanaf-nav-link" style="color:#374151; font-weight:600; text-decoration:none; font-size:0.92rem; transition:color .15s;">مستقبلك المهني</a>
                @endauth
            </div>

            {{-- User actions --}}
            <div style="display:flex; align-items:center; gap:10px; flex-shrink:0;">

                {{-- Language toggle --}}
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

                @auth
                @livewire('shared.notification-bell')
                <span class="kanaf-nav-username" style="color:#6b7280; font-size:0.88rem; font-weight:600;">{{ Auth::user()->first_name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="background:#1A6B3C; color:#fff; border:none; padding:7px 16px; border-radius:8px; font-weight:700; cursor:pointer; font-size:0.88rem; font-family:inherit; line-height:1;">خروج</button>
                </form>
                @else
                <a href="{{ route('login') }}" style="background:#1A6B3C; color:#fff; padding:7px 18px; border-radius:8px; font-weight:700; font-size:0.9rem; text-decoration:none; line-height:1; display:inline-block;">تسجيل الدخول</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- =================== PAGE =================== --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- =================== FOOTER =================== --}}
    <footer style="background:#1A6B3C; color:#fff; padding:36px 0; margin-top:auto;">
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

    @livewireScripts
</body>
</html>
