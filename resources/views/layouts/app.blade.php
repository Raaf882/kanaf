<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? __('كَـنَـف') }} — {{ __('كَـنَـف') }}</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="shortcut icon"        href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="apple-touch-icon"     href="{{ asset('images/kanaf-logo.png') }}">

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
        .kanaf-logo { font-family:'Cairo',sans-serif; font-weight:900; letter-spacing:0.05em; }
        .kanaf-img  { display:inline-block; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- =================== NAVBAR =================== --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo + Nav --}}
                <div class="flex items-center gap-8">
                    <a href="{{ route('landing') }}"
                       class="flex items-center gap-2.5">
                        <img src="{{ asset('images/kanaf-logo.png') }}"
                             alt="{{ __('كَـنَـف') }}"
                             class="h-10 w-10 object-contain kanaf-img"
                             onerror="this.style.display='none';">
                        <span class="kanaf-logo text-[#1A6B3C] text-xl tracking-wide hidden sm:block">{{ __('كَـــنَـف') }}</span>
                    </a>

                    @auth
                    <div class="hidden md:flex items-center gap-6">
                        @if(auth()->user()->role === 'student')
                        <a href="{{ route('landing') }}"
                           class="text-sm font-semibold pb-1 transition-colors
                                  {{ request()->routeIs('landing') ? 'text-[#1A6B3C] border-b-2 border-[#1A6B3C]' : 'text-gray-600 hover:text-[#1A6B3C]' }}">
                            {{ __('الرئيسية') }}
                        </a>
                        <a href="{{ route('academic-journey') }}"
                           class="text-sm font-semibold pb-1 transition-colors
                                  {{ request()->routeIs('academic-journey*') ? 'text-[#1A6B3C] border-b-2 border-[#1A6B3C]' : 'text-gray-600 hover:text-[#1A6B3C]' }}">
                            {{ __('رحلتك الأكاديمية') }}
                        </a>
                        <a href="{{ route('career-future') }}"
                           class="text-sm font-semibold pb-1 transition-colors
                                  {{ request()->routeIs('career-future*') ? 'text-[#1A6B3C] border-b-2 border-[#1A6B3C]' : 'text-gray-600 hover:text-[#1A6B3C]' }}">
                            {{ __('مستقبلك المهني') }}
                        </a>
                        @elseif(auth()->user()->role === 'advisor')
                        <a href="{{ route('landing') }}"
                           class="text-sm font-semibold pb-1 transition-colors {{ request()->routeIs('landing') ? 'text-[#1A6B3C] border-b-2 border-[#1A6B3C]' : 'text-gray-600 hover:text-[#1A6B3C]' }}">
                            الرئيسية
                        </a>
                        <a href="#students-tracking"
                           onclick="document.getElementById('students-tracking')?.scrollIntoView({behavior:'smooth'}); return false;"
                           class="text-sm font-semibold pb-1 text-gray-600 hover:text-[#1A6B3C] transition-colors">
                            متابعة الطلاب
                        </a>
                        <a href="#sessions"
                           onclick="document.getElementById('sessions')?.scrollIntoView({behavior:'smooth'}); return false;"
                           class="text-sm font-semibold pb-1 text-gray-600 hover:text-[#1A6B3C] transition-colors">
                            الجلسات
                        </a>
                        <a href="#nominations"
                           onclick="document.getElementById('nominations')?.scrollIntoView({behavior:'smooth'}); return false;"
                           class="text-sm font-semibold pb-1 text-gray-600 hover:text-[#1A6B3C] transition-colors">
                            الترشيحات
                        </a>
                        @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('landing') }}"
                           class="text-sm font-semibold pb-1 transition-colors {{ request()->routeIs('landing') ? 'text-[#1A6B3C] border-b-2 border-[#1A6B3C]' : 'text-gray-600 hover:text-[#1A6B3C]' }}">
                            {{ __('الرئيسية') }}
                        </a>
                        @endif
                    </div>
                    @endauth
                </div>

                {{-- Right: Bell + Language + User --}}
                <div class="flex items-center gap-3">
                    @auth
                    @livewire('shared.notification-bell')

                    <a href="{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}"
                       class="flex items-center gap-1 text-xs text-gray-600 border border-gray-300 rounded-lg px-3 py-1.5 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'English' : 'عربي' }}</span>
                    </a>

                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <div class="w-8 h-8 rounded-full bg-[#F0FAF4] border border-[#1A6B3C]/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#1A6B3C]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="font-semibold hidden sm:block">{{ __('أهلاً') }} {{ Auth::user()->first_name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-gray-400 hover:text-red-500 transition-colors">
                                {{ __('خروج') }}
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- =================== PAGE =================== --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- =================== FOOTER =================== --}}
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/kanaf-logo.png') }}"
                         alt="{{ __('كَـنَـف') }}"
                         class="h-12 w-12 object-contain"
                         onerror="this.style.display='none';">
                    <div class="h-12 w-12 bg-gray-800 rounded-lg flex items-center justify-center">
                        <span class="text-white text-xs font-bold">سدايا</span>
                    </div>
                </div>
                <nav class="flex gap-6 text-sm text-gray-500">
                    <a href="#" class="hover:text-gray-800 transition-colors">{{ __('خريطة الموقع') }}</a>
                    <a href="#" class="hover:text-gray-800 transition-colors">RSS</a>
                    <a href="#" class="hover:text-gray-800 transition-colors">{{ __('تطبيق الجوال') }}</a>
                </nav>
            </div>
            <div class="mt-6 text-center text-sm text-gray-500 space-y-1">
                <p class="font-bold text-gray-700">{{ __('جميع الحقوق محفوظة لهيئة الحوكمة الرقمية © 2026') }}</p>
                <p>{{ __('تم تطويره وصيانته بواسطة كَـنَـف') }}</p>
                <p>{{ __('تاريخ آخر تعديل: 04/12/2026') }}</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
