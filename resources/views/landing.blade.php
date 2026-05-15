<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كَـنَـف — منصة الإرشاد الأكاديمي</title>
    <link rel="icon" href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        *, body { font-family: 'Cairo', sans-serif; }

        .hero-bg {
            background: linear-gradient(160deg, #f0faf4 0%, #ffffff 55%, #fffbeb 100%);
            min-height: 88vh;
            display: flex;
            align-items: center;
        }

        .card-hover {
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px -12px rgba(26,107,60,.15);
        }

        .logo-text {
            font-weight: 900;
            color: #1A6B3C;
            letter-spacing: .04em;
        }

        /* Fix: ensure emojis render at full size */
        .emoji-icon {
            font-style: normal;
            line-height: 1;
        }
    </style>
</head>
<body class="bg-white text-gray-900 overflow-x-hidden">

{{-- ══════════════════════════════════════════
     GOVERNMENT BANNER
══════════════════════════════════════════ --}}
<div class="bg-[#1A6B3C] text-white text-xs py-2 px-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/>
            </svg>
            <span class="font-semibold">موقع حكومي مسجل لدى هيئة الحكومة الرقمية</span>
            <span class="opacity-50 mx-1 hidden sm:inline">|</span>
            <a href="#" class="hidden sm:inline underline underline-offset-2 opacity-75 hover:opacity-100">كيف تتحقق؟</a>
        </div>
        <div class="flex items-center gap-1 opacity-70">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            <span>آمن ومشفّر</span>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════ --}}
<header class="bg-white border-b border-gray-100 sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2.5">
                <img src="{{ asset('images/kanaf-logo.png') }}" alt="كَـنَـف" class="w-9 h-9 object-contain" onerror="this.style.display='none'">
                <span class="logo-text text-xl hidden sm:block">كَـنَـف</span>
            </a>

            {{-- Desktop links --}}
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-gray-600">
                <a href="#"         class="text-[#1A6B3C] border-b-2 border-[#1A6B3C] pb-0.5">الرئيسية</a>
                <a href="#journey"  class="hover:text-[#1A6B3C] transition-colors">رحلتك الأكاديمية</a>
                <a href="#features" class="hover:text-[#1A6B3C] transition-colors">مستقبلك المهني</a>
            </nav>

            {{-- Actions --}}
            <div class="flex items-center gap-2">
                {{-- Search icon --}}
                <button class="hidden sm:flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 border border-gray-200 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                {{-- Language --}}
                <span class="hidden sm:flex items-center gap-1 text-xs font-semibold text-gray-500 border border-gray-200 rounded-lg px-3 py-1.5 cursor-pointer hover:bg-gray-50">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    English
                </span>
                <a href="{{ route('login') }}"
                   class="flex items-center gap-1.5 text-[#1A6B3C] border border-[#1A6B3C]/30 text-sm font-bold px-4 py-2 rounded-xl hover:bg-[#F0FAF4] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    تسجيل الدخول
                </a>
                {{-- Mobile toggle --}}
                <button @click="open=!open" class="md:hidden w-9 h-9 rounded-lg flex items-center justify-center text-gray-600 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-transition class="md:hidden border-t border-gray-100 py-3 space-y-1">
            <a href="#"         @click="open=false" class="block px-3 py-2 text-sm font-semibold text-[#1A6B3C] rounded-lg bg-[#F0FAF4]">الرئيسية</a>
            <a href="#journey"  @click="open=false" class="block px-3 py-2 text-sm font-semibold text-gray-700 rounded-lg hover:bg-gray-50">رحلتك الأكاديمية</a>
            <a href="#features" @click="open=false" class="block px-3 py-2 text-sm font-semibold text-gray-700 rounded-lg hover:bg-gray-50">مستقبلك المهني</a>
        </div>
    </div>
</header>

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section class="hero-bg w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-0 w-full">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-0 items-center">

            {{-- RIGHT: Text (first in RTL = appears on right) --}}
            <div class="space-y-6 text-right py-16">
                <h1 class="font-black leading-none"
                    style="font-size: clamp(5rem, 12vw, 9rem); color:#1A6B3C; font-family:'Cairo',sans-serif; letter-spacing:0.02em; line-height:1.1;">
                    كَـنَـف
                </h1>

                <p class="text-gray-600 text-lg leading-relaxed">
                    منصة ذكية تتابع الأداء الأكاديمي،<br>
                    وتقترح حلولاً مبكرة، وتربط الطالب<br>
                    بمساره المهني المناسب.
                </p>

                <div>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 bg-[#1A6B3C] text-white font-bold text-base px-9 py-3.5 rounded-2xl hover:bg-[#155e34] transition-all shadow-lg shadow-[#1A6B3C]/25 hover:-translate-y-0.5">
                        ابدأ الآن
                    </a>
                </div>
            </div>

            {{-- LEFT: Hero Image (second in RTL = appears on left) --}}
            <div class="flex justify-center lg:justify-end items-center">
                <div class="relative">
                    <img src="{{ asset('images/kanaf2.png') }}"
                         alt="كَـنَـف"
                         class="w-auto object-contain drop-shadow-xl"
                         style="max-height: 85vh; max-width: 100%;"
                         onerror="this.style.display='none'">

                    {{-- Floating badge - top right of image --}}
                    <div class="absolute top-8 right-0 bg-amber-400 text-white text-xs font-black px-3 py-1.5 rounded-xl shadow-lg whitespace-nowrap">
                        🎓 إرشاد ذكي
                    </div>

                    {{-- Floating badge - bottom left of image --}}
                    <div class="absolute bottom-10 left-0 bg-[#1A6B3C] text-white text-xs font-black px-3 py-1.5 rounded-xl shadow-lg whitespace-nowrap">
                        ✅ متابعة أكاديمية
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     WHY KANAF
══════════════════════════════════════════ --}}
<section id="why" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Two-column: text right, logo left --}}
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-20">

            {{-- RIGHT: Text --}}
            <div class="text-right">
                <span class="inline-block bg-amber-50 text-amber-600 text-sm font-bold px-4 py-1.5 rounded-full border border-amber-200 mb-5">
                    ✨ لماذا تختار كَـنَـف؟
                </span>
                <h2 class="text-4xl font-black text-gray-900 mb-5 leading-tight">لماذا كَـنَـف؟</h2>
                <p class="text-gray-700 text-xl font-bold leading-relaxed mb-3">
                    كَنَف ترافق الطالب خلال رحلته الجامعية عبر دعم أكاديمي استباقي
                </p>
                <p class="text-gray-500 text-base leading-relaxed">
                    يساعده على فهم وضعه الدراسي واتخاذ خطوات أكثر وضوحاً نحو مستقبله المهني.
                </p>
            </div>

            {{-- LEFT: Logo --}}
            <div class="flex justify-center">
                <img src="{{ asset('images/kanaf-logo.png') }}"
                     alt="كَـنَـف"
                     class="w-64 h-64 object-contain"
                     onerror="this.style.display='none'">
            </div>
        </div>

        {{-- 3 cards --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div class="card-hover bg-white rounded-2xl p-7 border border-gray-100 shadow-sm text-right">
                <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-2">ذكاء اصطناعي في خدمتك</h3>
                <p class="text-gray-500 text-sm leading-relaxed">تحليل شامل لأدائك الأكاديمي مع توصيات مخصصة لكل طالب بشكل مستقل.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-7 border border-gray-100 shadow-sm text-right">
                <div class="w-14 h-14 bg-[#F0FAF4] rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-2">مرشد أكاديمي مخصص</h3>
                <p class="text-gray-500 text-sm leading-relaxed">تواصل مباشر مع مرشدك وجلسات إرشادية منظّمة وترشيحات للفعاليات.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-7 border border-gray-100 shadow-sm text-right">
                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-2">خارطة مهنية واضحة</h3>
                <p class="text-gray-500 text-sm leading-relaxed">اكتشف المسار المهني الأنسب بناءً على مهاراتك ودرجاتك الأكاديمية.</p>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     FEATURES
══════════════════════════════════════════ --}}
<section id="features" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="max-w-2xl mx-auto text-center mb-16">
            <span class="inline-block bg-[#1A6B3C]/10 text-[#1A6B3C] text-sm font-bold px-4 py-1.5 rounded-full mb-4">
                🌟 مميزات المنصة
            </span>
            <h2 class="text-4xl font-black text-gray-900 mb-4">
                كيف تساعدك منصة <span class="text-[#1A6B3C]">كَـنَـف</span>؟
            </h2>
            <p class="text-gray-500 text-base leading-relaxed">
                خمس ركائز أساسية تضمن لك رحلة أكاديمية ومهنية متميزة
            </p>
        </div>

        {{-- Row 1: 2 large cards --}}
        <div class="grid md:grid-cols-2 gap-6 mb-6">

            <div class="card-hover bg-white rounded-2xl p-7 border border-gray-100 shadow-sm text-right ring-1 ring-blue-100">
                <div class="flex items-start gap-4 flex-row-reverse mb-4">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 mb-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            Career Path
                        </span>
                        <h3 class="text-lg font-black text-gray-900">مستقبلك المهني</h3>
                    </div>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">اكتشف المسارات المهنية المناسبة لتخصصك ودرجاتك مع توصيات مخصصة.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-7 border border-gray-100 shadow-sm text-right ring-1 ring-amber-100">
                <div class="flex items-start gap-4 flex-row-reverse mb-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 mb-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            AI Powered
                        </span>
                        <h3 class="text-lg font-black text-gray-900">توصيات استباقية</h3>
                    </div>
                </div>
                <p class="text-gray-500 text-sm leading-relaxed">نظام ذكي يرصد أداءك ويقدّم توصيات قبل أن تطلبها.</p>
            </div>
        </div>

        {{-- Row 2: 3 cards --}}
        <div class="grid md:grid-cols-3 gap-6">

            <div class="card-hover bg-white rounded-2xl p-7 border border-gray-100 shadow-sm text-right ring-1 ring-green-100">
                <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#1A6B3C]"></span>
                    Mentorship
                </span>
                <h3 class="text-base font-black text-gray-900 mb-2">دعم وإرشاد أكاديمي</h3>
                <p class="text-gray-500 text-sm leading-relaxed">تواصل مع مرشدك، احجز جلسات، وتلقَّ ترشيحات للفعاليات.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-7 border border-gray-100 shadow-sm text-right ring-1 ring-purple-100">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                    Analytics
                </span>
                <h3 class="text-base font-black text-gray-900 mb-2">متابعة أكاديمية ذكية</h3>
                <p class="text-gray-500 text-sm leading-relaxed">لوحة تحكم تعرض درجاتك وGPA وأداءك في كل مادة بشكل بياني.</p>
            </div>

            <div class="card-hover bg-white rounded-2xl p-7 border border-gray-100 shadow-sm text-right ring-1 ring-rose-100">
                <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 mb-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                    Resources
                </span>
                <h3 class="text-base font-black text-gray-900 mb-2">مصادر تعليمية مقترحة</h3>
                <p class="text-gray-500 text-sm leading-relaxed">مكتبة من الكورسات والمصادر مرتبطة بمسارك المهني وتخصصك.</p>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     JOURNEY / TIMELINE
══════════════════════════════════════════ --}}
<section id="journey" class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="max-w-2xl mx-auto text-center mb-16">
            <span class="inline-block bg-amber-50 text-amber-600 text-sm font-bold px-4 py-1.5 rounded-full border border-amber-200 mb-4">
                خطوات واضحة
            </span>
            <h2 class="text-4xl font-black text-gray-900 mb-4">رحلتك مع <span class="text-[#1A6B3C]">كَـنَـف</span></h2>
            <p class="text-gray-500 text-base">ثماني خطوات تأخذك من التسجيل إلى تحقيق أهدافك</p>
        </div>

        @php
        $steps = [
            ['n'=>1,'icon'=>'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
             'title'=>'سجل الدخول بحسابك الجامعي',  'desc'=>'ادخل بياناتك الأكاديمية وابدأ في دقيقتين فقط.', 'color'=>'#1A6B3C'],
            ['n'=>2,'icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
             'title'=>'تابع حالتك الأكاديمية ومؤشرات الأداء', 'desc'=>'تعرّف على أدائك بشكل بصري واضح.',           'color'=>'#1A6B3C'],
            ['n'=>3,'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
             'title'=>'استعرض موادك الحالية وتفاصيل كل مادة','desc'=>'اطّلع على نتائجك وتحليل نقاط قوتك وضعفك.',     'color'=>'#1A6B3C'],
            ['n'=>4,'icon'=>'M13 10V3L4 14h7v7l9-11h-7z',
             'title'=>'تعرّف على التوصيات المقترحة لتحسين مستواك','desc'=>'احصل على توصيات ذكية مخصصة لك.',          'color'=>'#1A6B3C'],
            ['n'=>5,'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
             'title'=>'استفد من المحتوى التعليمي والدعم الأكاديمي','desc'=>'مكتبة محتوى مرتبطة بمسارك وتخصصك.',      'color'=>'#F4A61C'],
            ['n'=>6,'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
             'title'=>'احجز جلسة مع مرشدك الأكاديمي عند الحاجة','desc'=>'احجز جلسة إرشادية في أي وقت.',            'color'=>'#F4A61C'],
            ['n'=>7,'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
             'title'=>'استكشف المسارات المهنية المناسبة لك',     'desc'=>'اكتشف مسارك المهني بناءً على أدائك.',      'color'=>'#F4A61C'],
            ['n'=>8,'icon'=>'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
             'title'=>'اتخذ خطوات أكاديمية أكثر وضوحاً وثقة',    'desc'=>'أنهِ مسيرتك بثقة ومستقبل مهني مشرق.',     'color'=>'#F4A61C'],
        ];
        @endphp

        <div class="grid sm:grid-cols-2 gap-4">
            @foreach($steps as $step)
            <div class="flex items-start gap-4 flex-row-reverse bg-gray-50 rounded-2xl p-5 hover:bg-[#F0FAF4] transition-colors border border-gray-100">
                {{-- Number badge (RIGHT in RTL via flex-row-reverse) --}}
                <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center font-black text-white text-sm shadow-sm"
                     style="background: {{ $step['color'] }}">
                    {{ $step['n'] }}
                </div>
                {{-- Content --}}
                <div class="text-right flex-1">
                    <p class="font-black text-gray-900 text-sm mb-1">{{ $step['title'] }}</p>
                    <p class="text-gray-500 text-xs leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 bg-[#1A6B3C] text-white font-bold text-base px-10 py-4 rounded-2xl hover:bg-[#155e34] transition-all shadow-lg shadow-[#1A6B3C]/20 hover:-translate-y-0.5">
                ابدأ رحلتك الآن — مجاناً
            </a>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     TRUST STRIP
══════════════════════════════════════════ --}}
<section class="py-12 bg-[#1A6B3C]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-white/60 text-xs font-bold tracking-widest mb-6">موثوق به في</p>
        <div class="flex flex-wrap items-center justify-center gap-10 sm:gap-16">
            @foreach(['جامعة الملك عبدالله','جامعة الملك عبدالعزيز','جامعة الملك سعود','جامعة الأميرة نورة'] as $u)
            <span class="text-white/70 hover:text-white transition-colors font-bold text-sm">{{ $u }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     FINAL CTA
══════════════════════════════════════════ --}}
<section class="py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-2xl mx-auto px-4 text-center">
        <div class="w-16 h-16 bg-[#F0FAF4] rounded-2xl flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
        </div>
        <h2 class="text-4xl font-black text-gray-900 mb-4 leading-tight">
            جاهز تبدأ رحلتك مع <span class="text-[#1A6B3C]">كَـنَـف</span>؟
        </h2>
        <p class="text-gray-500 text-base mb-8 leading-relaxed">
            انضم لمئات الطلاب الذين يستفيدون من الإرشاد الأكاديمي الذكي ويحققون أهدافهم.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 bg-[#1A6B3C] text-white font-bold text-base px-10 py-4 rounded-2xl hover:bg-[#155e34] transition-all shadow-lg shadow-[#1A6B3C]/20 hover:-translate-y-0.5">
                تسجيل الدخول
                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="#why"
               class="inline-flex items-center gap-2 text-gray-600 font-bold text-base px-8 py-4 rounded-2xl border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all">
                اعرف أكثر
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ --}}
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/kanaf-logo.png') }}" alt="كَـنَـف" class="w-9 h-9 object-contain" onerror="this.style.display='none'">
                    <span class="logo-text text-2xl text-white">كَـنَـف</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                    منصة الإرشاد الأكاديمي الذكي — تحليل الأداء، اقتراح المسارات، وربط الطالب بمرشده الأكاديمي.
                </p>
            </div>

            {{-- Links --}}
            <div>
                <h3 class="text-white font-black text-sm mb-4 pb-2 border-b border-white/10">المنصة</h3>
                <ul class="space-y-2.5 text-sm text-gray-400">
                    <li><a href="#why"      class="hover:text-white transition-colors">لماذا كَـنَـف؟</a></li>
                    <li><a href="#features" class="hover:text-white transition-colors">المميزات</a></li>
                    <li><a href="#journey"  class="hover:text-white transition-colors">رحلتك الأكاديمية</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">تسجيل الدخول</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div>
                <h3 class="text-white font-black text-sm mb-4 pb-2 border-b border-white/10">الدعم</h3>
                <ul class="space-y-2.5 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">مركز المساعدة</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">تواصل معنا</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">خريطة الموقع</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">تطبيق الجوال</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="bg-white/10 text-white/60 text-xs font-bold px-3 py-1 rounded-lg">سدايا</span>
                <span class="bg-white/10 text-white/60 text-xs font-bold px-3 py-1 rounded-lg">هيئة الحكومة الرقمية</span>
            </div>
            <div class="text-center sm:text-right">
                <p class="text-white/60 text-sm font-semibold">جميع الحقوق محفوظة لهيئة الحوكمة الرقمية © 2026</p>
                <p class="text-white/30 text-xs mt-0.5">تم تطويره وصيانته بواسطة فريق كَـنَـف</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
