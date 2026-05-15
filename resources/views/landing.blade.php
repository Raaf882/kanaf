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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, body { font-family: 'Cairo', sans-serif; }

        /* ── Page wrapper — Figma spec ── */
        #page-root {
            display: flex;
            width: 1440px;
            max-width: 100%;          /* responsive fallback */
            flex-direction: column;
            align-items: flex-start;
            margin-inline: auto;      /* centre on screens wider than 1440px */
            overflow-x: hidden;
        }

        /* ── Hero ── */
        .hero-section {
            background: #f8fafb;
            min-height: 82vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 70% 80% at 30% 50%, rgba(26,107,60,.05) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Feature image-cards ── */
        .feat-card {
            position: relative;
            border-radius: 1.25rem;
            overflow: hidden;
            flex-shrink: 0;
            width: 240px;
            height: 300px;
            cursor: pointer;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .feat-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -10px rgba(0,0,0,.2); }
        .feat-card .card-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform .4s ease;
        }
        .feat-card:hover .card-bg { transform: scale(1.06); }
        .feat-card .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,.75) 0%, rgba(0,0,0,.15) 55%, transparent 100%);
        }
        .feat-card .card-body {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 1.25rem;
            color: #fff;
            text-align: right;
        }

        /* ── Step list ── */
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            flex-direction: row-reverse;
            padding: .75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .step-item:last-child { border-bottom: none; }
        .step-num {
            flex-shrink: 0;
            width: 2rem;
            height: 2rem;
            border-radius: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: .8rem;
            color: #fff;
        }

        /* ── Carousel dots ── */
        .dot { width: 8px; height: 8px; border-radius: 50%; background: #d1d5db; transition: background .2s; }
        .dot.active { background: #1A6B3C; width: 22px; border-radius: 4px; }

        /* ── Scrollbar hide ── */
        .scroll-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scroll-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-white text-gray-900 overflow-x-hidden">
<div id="page-root">

{{-- ══════════════════════════════════════════
     GOVERNMENT BANNER
══════════════════════════════════════════ --}}
<dga-second-nav-header>
    <dga-second-nav-header-content>
        <dga-second-nav-header-item label="موقع حكومي رسمي مسجل لدى هيئة الحكومة الرقمية">
        </dga-second-nav-header-item>
    </dga-second-nav-header-content>
</dga-second-nav-header>

{{-- ══════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════ --}}
<dga-nav-header sticky="true" divider="true" full-width="true">
    <dga-nav-header-main collapsed="true">
        <dga-nav-header-logos
            logo-src="{{ asset('images/kanaf-logo.png') }}"
            logo-alt="كَنَف"
            logo-link="{{ route('landing') }}"
            gov-src="https://dga-nds-fbhtx.ondigitalocean.app/mobile-logo.svg"
            gov-link="#">
        </dga-nav-header-logos>
        <dga-nav-header-menu>
            <dga-nav-header-link label="الرئيسية"         id="ln-home"></dga-nav-header-link>
            <dga-nav-header-link label="رحلتك الأكاديمية" id="ln-journey"></dga-nav-header-link>
            <dga-nav-header-link label="مستقبلك المهني"   id="ln-career"></dga-nav-header-link>
        </dga-nav-header-menu>
    </dga-nav-header-main>
    <dga-nav-header-actions>
        <dga-header-action-btn id="ln-search" label="البحث"         icon="search"></dga-header-action-btn>
        <dga-header-action-btn id="ln-lang"   label="English"        icon="translation"></dga-header-action-btn>
        <dga-header-action-btn id="ln-login"  label="تسجيل الدخول"  icon="user"></dga-header-action-btn>
    </dga-nav-header-actions>
</dga-nav-header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function goTo(id, url) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('click', function () { window.location.href = url; });
    }
    goTo('ln-home',    '#');
    goTo('ln-journey', '#journey');
    goTo('ln-career',  '#features');
    goTo('ln-lang',    '{{ route('locale', app()->getLocale() === 'ar' ? 'en' : 'ar') }}');
    goTo('ln-login',   '{{ route('login') }}');
});
</script>

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section class="hero-section w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-10 lg:py-0">
        <div class="grid lg:grid-cols-2 gap-6 items-center min-h-[80vh]">

            {{-- RIGHT: Text --}}
            <div class="space-y-5 text-right py-12 lg:py-0">
                <h1 class="font-black leading-none"
                    style="font-size: clamp(5.5rem, 13vw, 9.5rem); color:#1A6B3C; font-family:'Cairo',sans-serif; letter-spacing:0.02em; line-height:1.05;">
                    كَـنَـف
                </h1>
                <p class="text-gray-500 text-lg leading-loose max-w-md mr-0">
                    منصة ذكية لتتابع الأداء الأكاديمي،<br>
                    وتقترح حلولاً مبكرة، وتربط الطالب<br>
                    بمساره المهني المناسب.
                </p>
                <div class="pt-2">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 bg-[#1A6B3C] text-white font-bold text-base px-10 py-3.5 rounded-xl hover:bg-[#155e34] transition-all shadow-lg shadow-[#1A6B3C]/25 hover:-translate-y-0.5">
                        ابدأ الآن
                    </a>
                </div>
            </div>

            {{-- LEFT: 3D Hero Image --}}
            <div class="flex justify-center items-center h-full">
                <img src="{{ asset('images/kanaf2.png') }}"
                     alt="كَـنَـف"
                     class="w-auto object-contain drop-shadow-2xl"
                     style="max-height: 72vh; max-width: 100%;"
                     onerror="this.style.display='none'">
            </div>
        </div>
    </div>

    {{-- Carousel dot --}}
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex items-center gap-2">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     WHY KANAF
══════════════════════════════════════════ --}}
<section id="why" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- RIGHT: Text --}}
            <div class="text-right order-1">
                <h2 class="text-4xl font-black text-gray-900 mb-5 leading-tight">
                    لماذا كَـنَـف؟
                </h2>
                <p class="text-gray-500 text-base leading-loose mb-8">
                    كنف ترافق الطالب خلال رحلته الجامعية عبر دعم أكاديمي استباقي
                    يساعده على فهم وضعه الدراسي واتخاذ خطوات أكثر وضوحًا نحو
                    مستقبله المهني.
                </p>
            </div>

            {{-- LEFT: Logo --}}
            <div class="flex justify-center order-2">
                <img src="{{ asset('images/kanaf-logo.png') }}"
                     alt="كَـنَـف"
                     class="w-64 h-64 object-contain"
                     onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     FEATURES — Image cards carousel
══════════════════════════════════════════ --}}
<section id="features" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section header --}}
        <div class="flex items-start justify-between mb-10 flex-wrap gap-4">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-1.5 text-sm font-bold text-[#1A6B3C] border border-[#1A6B3C]/30 px-4 py-2 rounded-xl hover:bg-[#F0FAF4] transition-colors self-end">
                عرض الكل
                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <div class="text-right">
                <h2 class="text-3xl font-black text-gray-900 mb-2">
                    كيف تساعدك منصة كَـنَـف
                </h2>
                <p class="text-gray-500 text-sm leading-relaxed">
                    كنف ترافقك خلال رحلتك الجامعية عبر متابعة الأداء الأكاديمي وتقديم التوجيه المناسب في الوقت المناسب.
                </p>
            </div>
        </div>

        {{-- Horizontal scroll cards --}}
        <div class="overflow-x-auto scroll-hide pb-4" id="feat-scroll">
            <div class="flex gap-4 w-max px-1">

                {{-- Card 1: مستقبلك المهني --}}
                <div class="feat-card">
                    <div class="card-bg" style="background: linear-gradient(135deg,#0d3d24 0%,#1A6B3C 40%,#2d8a54 100%);">
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;opacity:.15;">
                            <svg width="120" height="120" fill="none" stroke="#fff" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-overlay"></div>
                    <div class="card-body">
                        <p class="font-black text-base mb-1">استقبلك المهني</p>
                        <p class="text-white/75 text-xs leading-relaxed">استكشاف مسارات مهنية تناسب مهاراتك واهتماماتك</p>
                    </div>
                </div>

                {{-- Card 2: توصيات استباقية --}}
                <div class="feat-card">
                    <div class="card-bg" style="background: linear-gradient(135deg,#1e3a5f 0%,#2563eb 50%,#3b82f6 100%);">
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;opacity:.15;">
                            <svg width="120" height="120" fill="none" stroke="#fff" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-overlay"></div>
                    <div class="card-body">
                        <p class="font-black text-base mb-1">توصيات استباقية</p>
                        <p class="text-white/75 text-xs leading-relaxed">تنبيهات ذكية تساعدك على اتخاذ قرارات أكاديمية أوضح قبل حدوث التعثر</p>
                    </div>
                </div>

                {{-- Card 3: دعم وإرشاد أكاديمي --}}
                <div class="feat-card">
                    <div class="card-bg" style="background: linear-gradient(135deg,#1a3a2a 0%,#166534 50%,#15803d 100%);">
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;opacity:.15;">
                            <svg width="120" height="120" fill="none" stroke="#fff" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-overlay"></div>
                    <div class="card-body">
                        <p class="font-black text-base mb-1">دعم وإرشاد أكاديمي</p>
                        <p class="text-white/75 text-xs leading-relaxed">سهولة الوصول إلى المرشد الأكاديمي وحجز الجلسات عند الحاجة</p>
                    </div>
                </div>

                {{-- Card 4: متابعة أكاديمية ذكية --}}
                <div class="feat-card">
                    <div class="card-bg" style="background: linear-gradient(135deg,#4a1d96 0%,#7c3aed 50%,#8b5cf6 100%);">
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;opacity:.15;">
                            <svg width="120" height="120" fill="none" stroke="#fff" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-overlay"></div>
                    <div class="card-body">
                        <p class="font-black text-base mb-1">متابعة أكاديمية ذكية</p>
                        <p class="text-white/75 text-xs leading-relaxed">تتابع المنصة أداءك الأكاديمي باستمرار وتكشف فرص التحسين مبكرًا</p>
                    </div>
                </div>

                {{-- Card 5: مصادر تعليمية مقترحة --}}
                <div class="feat-card">
                    <div class="card-bg" style="background: linear-gradient(135deg,#7c1d1d 0%,#dc2626 50%,#ef4444 100%);">
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;opacity:.15;">
                            <svg width="120" height="120" fill="none" stroke="#fff" stroke-width="1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-overlay"></div>
                    <div class="card-body">
                        <p class="font-black text-base mb-1">مصادر تعليمية مقترحة</p>
                        <p class="text-white/75 text-xs leading-relaxed">اقتراح محتوى ومصادر تعليمية تساعدك على تعزيز فهمك وتحسين مستواك</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Carousel dots --}}
        <div class="flex items-center justify-center gap-2 mt-6" id="feat-dots">
            <div class="dot active" data-index="0"></div>
            <div class="dot" data-index="1"></div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     JOURNEY / STEPS  (simple numbered list)
══════════════════════════════════════════ --}}
<section id="journey" class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-right mb-12">
            <h2 class="text-3xl font-black text-gray-900">رحلتك مع كَـنَـف</h2>
        </div>

        @php
        $steps = [
            ['n'=>1, 'title'=>'سجل الدخول بحسابك الجامعي',                    'color'=>'#1A6B3C'],
            ['n'=>2, 'title'=>'تابع حالتك الأكاديمية ومؤشرات الأداء',         'color'=>'#1A6B3C'],
            ['n'=>3, 'title'=>'استعرض موادك الحالية وتفاصيل كل مادة',         'color'=>'#1A6B3C'],
            ['n'=>4, 'title'=>'تعرّف على التوصيات المقترحة لتحسين مستواك',    'color'=>'#1A6B3C'],
            ['n'=>5, 'title'=>'استفد من المحتوى التعليمي والدعم الأكاديمي',   'color'=>'#F4A61C'],
            ['n'=>6, 'title'=>'احجز جلسة مع مرشدك الأكاديمي عند الحاجة',    'color'=>'#F4A61C'],
            ['n'=>7, 'title'=>'استكشف المسارات المهنية المناسبة لك',          'color'=>'#F4A61C'],
            ['n'=>8, 'title'=>'اتخذ خطوات أكاديمية أكثر وضوحاً وثقة',        'color'=>'#F4A61C'],
        ];
        @endphp

        <div>
            @foreach($steps as $step)
            <div class="step-item">
                <div class="step-num" style="background:{{ $step['color'] }}">
                    {{ $step['n'] }}
                </div>
                <p class="text-gray-700 font-semibold text-sm text-right flex-1 py-1">
                    {{ $step['title'] }}
                </p>
            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     FOOTER  (DGA Design System — Light)
══════════════════════════════════════════ --}}
<dga-footer id="landing-footer"></dga-footer>
<script>
customElements.whenDefined('dga-footer').then(function () {
    var f = document.getElementById('landing-footer');
    if (!f) return;
    f.background       = 'Light';
    f.NavLinks         = true;
    f.socialMediaTitle = 'وسائل التواصل الاجتماعي';
    f.copyright        = 'جميع الحقوق محفوظة لهيئة الحكومة الرقمية © 2026';
    f.groupLinks = [
        { title: 'المنصة', links: [
            { name: 'رحلتك الأكاديمية', target: '#journey' },
            { name: 'مستقبلك المهني',   target: '#features' },
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
        { name: 'سياسة الخصوصية',  target: '#' },
        { name: 'الشروط والأحكام', target: '#' },
    ];
    f.bottomImages = ['{{ asset("images/kanaf-logo.png") }}'];
});
</script>

</div>{{-- /page-root --}}
</body>
</html>
