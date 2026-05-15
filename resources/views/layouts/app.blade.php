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

        /* ── Desktop font & layout scaling ── */
        @media (min-width: 1280px) {
            html { font-size: 17px; }
        }
        @media (min-width: 1536px) {
            html { font-size: 18px; }
        }

        /* ── Page content max-width ── */
        .page-container {
            max-width: 1440px;
            width: 100%;
            margin-inline: auto;
            padding-inline: 80px;
        }
        @media (max-width: 1280px) {
            .page-container { padding-inline: 40px; }
        }
        @media (max-width: 768px) {
            .page-container { padding-inline: 20px; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- =================== GOVERNMENT BANNER =================== --}}
    <dga-second-nav-header>
        <dga-second-nav-header-content>
            <dga-second-nav-header-item label="{{ __('موقع حكومي رسمي مسجل لدى هيئة الحكومة الرقمية') }}">
            </dga-second-nav-header-item>
        </dga-second-nav-header-content>
    </dga-second-nav-header>

    {{-- =================== NAVBAR =================== --}}
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
                @auth
                @if(auth()->user()->role === 'student')
                <dga-nav-header-link label="{{ __('الرئيسية') }}"          id="nl-home"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('رحلتك الأكاديمية') }}"  id="nl-journey"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('مستقبلك المهني') }}"    id="nl-career"></dga-nav-header-link>
                @elseif(auth()->user()->role === 'advisor')
                <dga-nav-header-link label="{{ __('الرئيسية') }}"          id="nl-home"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('متابعة الطلاب') }}"    id="nl-track"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('الجلسات') }}"           id="nl-sessions"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('الترشيحات') }}"         id="nl-nominations"></dga-nav-header-link>
                @elseif(auth()->user()->role === 'admin')
                <dga-nav-header-link label="{{ __('لوحة الإدارة') }}"     id="nl-admin-dash"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('الطلاب') }}"            id="nl-admin-students"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('المواد') }}"            id="nl-admin-subjects"></dga-nav-header-link>
                <dga-nav-header-link label="{{ __('المرشدون') }}"          id="nl-admin-advisors"></dga-nav-header-link>
                @endif
                @endauth
            </dga-nav-header-menu>
        </dga-nav-header-main>

        <dga-nav-header-actions>
            @auth
            @livewire('shared.notification-bell')
            @endauth
            <dga-header-action-btn id="nl-lang" label="{{ app()->getLocale() === 'ar' ? 'English' : 'عربي' }}" icon="translation"></dga-header-action-btn>
            @auth
            <dga-header-action-btn id="nl-user" label="{{ __('أهلاً') }} {{ Auth::user()->first_name }}" icon="user"></dga-header-action-btn>
            @endauth
        </dga-nav-header-actions>
    </dga-nav-header>

    {{-- Hidden logout form --}}
    @auth
    <form id="kanaf-logout" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
    @endauth

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        function goTo(id, url) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('click', function () { window.location.href = url; });
        }
        @auth
        @if(auth()->user()->role === 'student')
        goTo('nl-home',    '{{ route('home') }}');
        goTo('nl-journey', '{{ route('academic-journey') }}');
        goTo('nl-career',  '{{ route('career-future') }}');
        @elseif(auth()->user()->role === 'advisor')
        goTo('nl-home', '{{ route('advisor.dashboard') }}');
        goTo('nl-track', '#students-tracking');
        goTo('nl-sessions', '#sessions');
        goTo('nl-nominations', '#nominations');
        @elseif(auth()->user()->role === 'admin')
        goTo('nl-admin-dash',     '{{ route('admin.dashboard') }}');
        goTo('nl-admin-students', '{{ route('admin.students') }}');
        goTo('nl-admin-subjects', '{{ route('admin.subjects') }}');
        goTo('nl-admin-advisors', '{{ route('admin.advisors') }}');
        @endif
        var userBtn = document.getElementById('nl-user');
        if (userBtn) userBtn.addEventListener('click', function () {
            document.getElementById('kanaf-logout').submit();
        });
        @endauth
        var langBtn = document.getElementById('nl-lang');
        if (langBtn) langBtn.addEventListener('click', function () {
            window.location.href = '{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}';
        });
    });
    </script>

    {{-- =================== PAGE =================== --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- =================== FOOTER =================== --}}
    <dga-footer id="app-footer"></dga-footer>
    <script>
    customElements.whenDefined('dga-footer').then(function () {
        var f = document.getElementById('app-footer');
        if (!f) return;
        f.background      = 'Light';
        f.NavLinks        = true;
        f.socialMediaTitle = 'وسائل التواصل الاجتماعي';
        f.copyright       = 'جميع الحقوق محفوظة لهيئة الحكومة الرقمية © 2026';
        f.groupLinks = [
            { title: 'المنصة', links: [
                { name: 'رحلتك الأكاديمية', target: '#' },
                { name: 'مستقبلك المهني',   target: '#' },
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

    @livewireScripts
</body>
</html>
