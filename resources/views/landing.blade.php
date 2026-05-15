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

        /* ── Page wrapper — Figma spec: 1440px flex column ── */
        #page-root {
            display: flex;
            width: 1440px;
            max-width: 100%;
            flex-direction: column;
            align-items: flex-start;
            margin-inline: auto;
            overflow-x: hidden;
        }

        /* ── Shared section wrapper ── */
        .section-inner {
            width: 100%;
            max-width: 1440px;
        }
        .section-content {
            max-width: 1280px;
            margin-inline: auto;
            padding-inline: 80px;
        }
        @media (max-width: 1024px) {
            .section-content { padding-inline: 40px; }
        }
        @media (max-width: 640px) {
            .section-content { padding-inline: 20px; }
        }

        /* ── Hero ── */
        #hero {
            background: #f3f4f6;
            width: 100%;
            padding-block: 60px;
        }
        .hero-grid {
            display: flex;
            align-items: center;
            gap: 0;
            min-height: 480px;
            position: relative;
        }
        .hero-text {
            flex: 0 0 660px;
            max-width: 660px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            z-index: 2;
            position: relative;
        }
        .hero-image-wrap {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-inline-start: -60px; /* overlap matching Figma negative gap */
        }
        @media (max-width: 900px) {
            .hero-grid { flex-direction: column; gap: 24px; }
            .hero-text { flex: unset; max-width: 100%; }
            .hero-image-wrap { margin-inline-start: 0; }
        }

        /* ── Carousel dots ── */
        .dot { width: 8px; height: 8px; border-radius: 50%; background: #d1d5db; transition: all .25s; }
        .dot.active { background: #1A6B3C; width: 24px; border-radius: 4px; }

        /* ── About section ── */
        #about {
            background: #ffffff;
            width: 100%;
            padding-block: 40px;
        }
        .about-grid {
            display: flex;
            align-items: center;
            gap: 32px;
        }
        .about-image {
            flex: 0 0 407px;
            height: 474px;
            border-radius: 20px;
            overflow: hidden;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .about-text {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        @media (max-width: 900px) {
            .about-grid { flex-direction: column; }
            .about-image { flex: unset; width: 100%; height: 260px; }
        }

        /* ── Services section ── */
        #services {
            background: #f3f8f5;
            width: 100%;
            padding-block: 40px;
        }
        .service-card {
            flex-shrink: 0;
            width: 300px;
            min-height: 220px;
            background: #ffffff;
            border-radius: 16px;
            padding: 32px 28px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
            transition: transform .25s, box-shadow .25s;
            cursor: default;
        }
        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(26,107,60,.12);
        }
        .service-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: #e6f4ec;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .scroll-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scroll-hide::-webkit-scrollbar { display: none; }

        /* ── Articles section ── */
        #articles {
            background: #ffffff;
            width: 100%;
            padding-block: 40px;
            padding-bottom: 80px;
        }
        .article-card {
            flex-shrink: 0;
            width: 320px;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            transition: transform .2s, box-shadow .2s;
        }
        .article-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
        }
        .article-img {
            height: 180px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .article-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .tag-chip {
            display: inline-flex;
            align-items: center;
            background: #e6f4ec;
            color: #1A6B3C;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 100px;
            width: fit-content;
        }

        /* ── Section heading ── */
        .section-badge {
            font-size: 14px;
            font-weight: 700;
            color: #1A6B3C;
            letter-spacing: .06em;
        }
        .section-title {
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 900;
            color: #111827;
            line-height: 1.25;
            margin: 0;
        }
        .section-desc {
            font-size: 1.05rem;
            color: #6b7280;
            line-height: 1.9;
            margin: 0;
        }

        /* ── Desktop font scaling ── */
        @media (min-width: 1280px) {
            html { font-size: 17px; }
        }
        @media (min-width: 1536px) {
            html { font-size: 18px; }
        }
    </style>
</head>
<body class="bg-white text-gray-900 overflow-x-hidden">
<div id="page-root">

{{-- ══════════════════════════════════════════
     1. GOVERNMENT BANNER (Digital Stamp)
══════════════════════════════════════════ --}}
<dga-second-nav-header>
    <dga-second-nav-header-content>
        <dga-second-nav-header-item label="موقع حكومي رسمي مسجل لدى هيئة الحكومة الرقمية">
        </dga-second-nav-header-item>
    </dga-second-nav-header-content>
</dga-second-nav-header>

{{-- ══════════════════════════════════════════
     2. NAV HEADER
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
            <dga-nav-header-link label="الرئيسية"          id="ln-home"></dga-nav-header-link>
            <dga-nav-header-link label="عن المنصة"         id="ln-about"></dga-nav-header-link>
            <dga-nav-header-link label="خدماتنا"           id="ln-services"></dga-nav-header-link>
            <dga-nav-header-link label="المقالات"          id="ln-articles"></dga-nav-header-link>
        </dga-nav-header-menu>
    </dga-nav-header-main>
    <dga-nav-header-actions>
        <dga-header-action-btn id="ln-lang"  label="English"       icon="translation"></dga-header-action-btn>
        <dga-header-action-btn id="ln-login" label="تسجيل الدخول" icon="user"></dga-header-action-btn>
    </dga-nav-header-actions>
</dga-nav-header>

<script>
customElements.whenDefined('dga-nav-header-logos').then(function () {
    function shrinkLogo() {
        document.querySelectorAll('dga-nav-header-logos').forEach(function (el) {
            if (el.shadowRoot) {
                if (!el.shadowRoot.querySelector('style[data-kanaf-logo]')) {
                    var s = document.createElement('style');
                    s.setAttribute('data-kanaf-logo', '1');
                    s.textContent = '.header__logo img { height: 32px !important; width: auto !important; }';
                    el.shadowRoot.appendChild(s);
                }
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
    function scrollTo(id, anchor) {
        var el = document.getElementById(id);
        if (el) el.addEventListener('click', function () {
            var t = document.querySelector(anchor);
            if (t) t.scrollIntoView({ behavior: 'smooth' });
        });
    }
    goTo('ln-home',    '{{ route("landing") }}');
    scrollTo('ln-about',    '#about');
    scrollTo('ln-services', '#services');
    scrollTo('ln-articles', '#articles');
    goTo('ln-lang',  '{{ route("locale", app()->getLocale() === "ar" ? "en" : "ar") }}');
    goTo('ln-login', '{{ route("login") }}');
});
</script>

{{-- ══════════════════════════════════════════
     3. HERO SECTION  (#f3f4f6, 534px)
══════════════════════════════════════════ --}}
<section id="hero" class="section-inner">
    <div class="section-content" style="padding-block: 40px;">
        <div class="hero-grid">

            {{-- Text (right side in RTL) --}}
            <div class="hero-text">
                <div>
                    <span class="section-badge">منصة الإرشاد الأكاديمي</span>
                </div>
                <h1 style="font-size: clamp(5rem, 10vw, 8.5rem); font-weight: 900; line-height: 1;
                            color: #1A6B3C; letter-spacing: .02em; margin: 0;">
                    كَـنَـف
                </h1>
                <p style="font-size: 1.2rem; color: #4b5563; line-height: 1.9; margin: 0; max-width: 500px;">
                    منصة ذكية لمتابعة الأداء الأكاديمي وتقديم الدعم المبكر،
                    تربط الطالب بمساره المهني المناسب من خلال إرشاد أكاديمي احترافي.
                </p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('login') }}"
                       style="display:inline-flex; align-items:center; gap:10px;
                              background:#1A6B3C; color:#fff; font-weight:700; font-size:1.05rem;
                              padding:14px 36px; border-radius:12px; text-decoration:none;
                              transition: background .2s, transform .2s; box-shadow: 0 4px 20px rgba(26,107,60,.3);"
                       onmouseover="this.style.background='#155e34'; this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.background='#1A6B3C'; this.style.transform='translateY(0)'">
                        ابدأ الآن
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <a href="#about"
                       style="display:inline-flex; align-items:center; gap:8px;
                              background:transparent; color:#1A6B3C; font-weight:700; font-size:1.05rem;
                              padding:14px 28px; border-radius:12px; text-decoration:none;
                              border:1.5px solid #1A6B3C; transition: background .2s;"
                       onclick="event.preventDefault(); document.getElementById('about').scrollIntoView({behavior:'smooth'})"
                       onmouseover="this.style.background='#e6f4ec'"
                       onmouseout="this.style.background='transparent'">
                        تعرّف أكثر
                    </a>
                </div>

                {{-- Stats row --}}
                <div style="display:flex; gap:40px; padding-top:12px; flex-wrap:wrap;">
                    <div>
                        <div style="font-size:2rem; font-weight:900; color:#1A6B3C; line-height:1.1;">+500</div>
                        <div style="font-size:.9rem; color:#9ca3af; font-weight:600; margin-top:2px;">طالب مسجّل</div>
                    </div>
                    <div style="width:1px; background:#e5e7eb;"></div>
                    <div>
                        <div style="font-size:2rem; font-weight:900; color:#1A6B3C; line-height:1.1;">30+</div>
                        <div style="font-size:.9rem; color:#9ca3af; font-weight:600; margin-top:2px;">مرشد أكاديمي</div>
                    </div>
                    <div style="width:1px; background:#e5e7eb;"></div>
                    <div>
                        <div style="font-size:2rem; font-weight:900; color:#1A6B3C; line-height:1.1;">95%</div>
                        <div style="font-size:.9rem; color:#9ca3af; font-weight:600; margin-top:2px;">رضا المستخدمين</div>
                    </div>
                </div>
            </div>

            {{-- Image (left side in RTL) --}}
            <div class="hero-image-wrap">
                <img src="{{ asset('images/kanaf2.png') }}"
                     alt="كَنَف"
                     style="max-height: 426px; max-width: 100%; object-fit: contain; drop-shadow: 0 20px 60px rgba(0,0,0,.12);"
                     onerror="this.parentElement.style.display='none'">
            </div>
        </div>

        {{-- Carousel dots --}}
        <div style="display:flex; align-items:center; justify-content:center; gap:8px; margin-top:32px;">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     4. ABOUT US SECTION  (#ffffff, 554px)
══════════════════════════════════════════ --}}
<section id="about" class="section-inner" style="background:#ffffff;">
    <div class="section-content" style="padding-block:40px;">
        <div class="about-grid">

            {{-- Image (right side in RTL) --}}
            <div class="about-image">
                <img src="{{ asset('images/kanaf-logo.png') }}"
                     alt="كَنَف"
                     style="width:220px; height:220px; object-fit:contain; opacity:.85;"
                     onerror="this.style.display='none'">
            </div>

            {{-- Text --}}
            <div class="about-text">
                <div>
                    <span class="section-badge">عن المنصة</span>
                    <h2 class="section-title" style="margin-top:8px;">لماذا كَـنَـف؟</h2>
                </div>
                <p class="section-desc">
                    كَنَف منصة ذكية متكاملة تُرافق الطالب خلال رحلته الجامعية عبر دعم أكاديمي استباقي.
                    تساعده على فهم وضعه الدراسي الحالي، وتكشف مؤشرات التعثر المبكر، وتقترح حلولاً
                    عملية بالتعاون مع المرشد الأكاديمي المعتمد.
                </p>
                <p class="section-desc">
                    تعتمد المنصة على نماذج ذكاء اصطناعي لتحليل الأداء الأكاديمي وتقديم توصيات مخصصة
                    تتناسب مع احتياجات كل طالب، مما يُمكّنه من اتخاذ قرارات أكاديمية ومهنية أكثر وضوحاً.
                </p>

                {{-- Feature chips --}}
                <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:8px;">
                    @foreach(['تحليل الأداء الأكاديمي', 'الإرشاد الأكاديمي', 'الاستشارات المهنية', 'الذكاء الاصطناعي'] as $feat)
                    <span style="display:inline-flex; align-items:center; gap:6px;
                                 background:#e6f4ec; color:#1A6B3C; font-size:.8rem; font-weight:700;
                                 padding:6px 14px; border-radius:100px;">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $feat }}
                    </span>
                    @endforeach
                </div>

                <div style="margin-top:8px;">
                    <a href="{{ route('login') }}"
                       style="display:inline-flex; align-items:center; gap:8px;
                              color:#1A6B3C; font-weight:700; font-size:.9rem; text-decoration:none;
                              border-bottom:2px solid #1A6B3C; padding-bottom:2px; transition:opacity .2s;"
                       onmouseover="this.style.opacity='.7'"
                       onmouseout="this.style.opacity='1'">
                        ابدأ رحلتك الأكاديمية
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     5. SERVICES SECTION  (#f3f8f5, 686px)
══════════════════════════════════════════ --}}
<section id="services" class="section-inner" style="background:#f3f8f5;">
    <div class="section-content" style="padding-block:40px;">

        {{-- Section header --}}
        <div style="display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:32px;">
            <div style="text-align:right;">
                <span class="section-badge">خدماتنا</span>
                <h2 class="section-title" style="margin-top:8px;">كيف تساعدك منصة كَـنَـف؟</h2>
                <p class="section-desc" style="margin-top:8px; max-width:560px;">
                    مجموعة متكاملة من الخدمات الأكاديمية الذكية المصممة لمساعدة الطالب على النجاح.
                </p>
            </div>
            <a href="{{ route('login') }}"
               style="flex-shrink:0; display:inline-flex; align-items:center; gap:6px;
                      color:#1A6B3C; font-weight:700; font-size:.85rem; text-decoration:none;
                      border:1.5px solid #1A6B3C; padding:8px 18px; border-radius:8px;
                      transition:background .2s;"
               onmouseover="this.style.background='#e6f4ec'"
               onmouseout="this.style.background='transparent'">
                عرض الكل
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </div>

        {{-- Service cards scroll --}}
        <div class="overflow-x-auto scroll-hide" id="services-scroll">
            <div style="display:flex; gap:20px; width:max-content; padding-bottom:4px;">

                @php
                $services = [
                    ['icon'=>'chart', 'title'=>'متابعة الأداء الأكاديمي', 'desc'=>'تتابع المنصة أداءك الأكاديمي باستمرار وتكشف فرص التحسين مبكراً قبل التعثر.', 'color'=>'#1A6B3C'],
                    ['icon'=>'bulb',  'title'=>'توصيات استباقية ذكية',    'desc'=>'تنبيهات ذكية مدعومة بالذكاء الاصطناعي تساعدك على اتخاذ قرارات أكاديمية أوضح.', 'color'=>'#0ea5e9'],
                    ['icon'=>'people','title'=>'دعم وإرشاد أكاديمي',      'desc'=>'سهولة الوصول إلى مرشدك الأكاديمي وحجز الجلسات الاستشارية عند الحاجة.', 'color'=>'#7c3aed'],
                    ['icon'=>'path',  'title'=>'استكشاف المسارات المهنية','desc'=>'اكتشف المسارات المهنية التي تناسب مهاراتك وشغفك للتخطيط لمستقبلك المهني.', 'color'=>'#f59e0b'],
                    ['icon'=>'book',  'title'=>'مصادر تعليمية مقترحة',    'desc'=>'محتوى ومصادر تعليمية منتقاة تساعدك على تعزيز فهمك وتحسين مستواك الدراسي.', 'color'=>'#dc2626'],
                ];
                @endphp

                @foreach($services as $svc)
                <div class="service-card">
                    <div class="service-icon" style="background:{{ $svc['color'] }}1a;">
                        @if($svc['icon'] === 'chart')
                        <svg width="24" height="24" fill="none" stroke="{{ $svc['color'] }}" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        @elseif($svc['icon'] === 'bulb')
                        <svg width="24" height="24" fill="none" stroke="{{ $svc['color'] }}" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        @elseif($svc['icon'] === 'people')
                        <svg width="24" height="24" fill="none" stroke="{{ $svc['color'] }}" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        @elseif($svc['icon'] === 'path')
                        <svg width="24" height="24" fill="none" stroke="{{ $svc['color'] }}" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        @else
                        <svg width="24" height="24" fill="none" stroke="{{ $svc['color'] }}" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        @endif
                    </div>
                    <div>
                        <h3 style="font-size:1rem; font-weight:800; color:#111827; margin:0 0 8px;">{{ $svc['title'] }}</h3>
                        <p style="font-size:.85rem; color:#6b7280; line-height:1.7; margin:0;">{{ $svc['desc'] }}</p>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        {{-- Carousel dots --}}
        <div style="display:flex; align-items:center; justify-content:center; gap:8px; margin-top:24px;">
            <div class="dot active"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     6. ARTICLES AND NEWS SECTION  (#fff, 812px)
══════════════════════════════════════════ --}}
<section id="articles" class="section-inner" style="background:#ffffff;">
    <div class="section-content" style="padding-top:40px; padding-bottom:80px;">

        {{-- Section header --}}
        <div style="display:flex; align-items:flex-end; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:32px;">
            <div style="text-align:right;">
                <span class="section-badge">المقالات والأخبار</span>
                <h2 class="section-title" style="margin-top:8px;">آخر المقالات والأخبار</h2>
            </div>
            <a href="{{ route('login') }}"
               style="flex-shrink:0; display:inline-flex; align-items:center; gap:6px;
                      color:#1A6B3C; font-weight:700; font-size:.85rem; text-decoration:none;
                      border:1.5px solid #1A6B3C; padding:8px 18px; border-radius:8px;
                      transition:background .2s;"
               onmouseover="this.style.background='#e6f4ec'"
               onmouseout="this.style.background='transparent'">
                عرض الكل
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        </div>

        {{-- Article cards --}}
        <div style="display:flex; gap:24px; flex-wrap:wrap;">

            @php
            $articles = [
                ['tag'=>'إرشاد أكاديمي', 'title'=>'كيف يساعدك المرشد الأكاديمي على تجاوز تحديات الفصل الدراسي؟', 'date'=>'١٢ مايو ٢٠٢٦', 'read'=>'٥ دقائق'],
                ['tag'=>'ذكاء اصطناعي',  'title'=>'الذكاء الاصطناعي في التعليم: كيف تكشف كَنَف التعثر الأكاديمي مبكراً', 'date'=>'٨ مايو ٢٠٢٦',  'read'=>'٧ دقائق'],
                ['tag'=>'مستقبل مهني',   'title'=>'دليلك لاختيار المسار المهني المناسب بعد التخرج', 'date'=>'٣ مايو ٢٠٢٦',  'read'=>'٦ دقائق'],
                ['tag'=>'نصائح',         'title'=>'١٠ عادات أكاديمية تساعدك على تحسين معدلك التراكمي', 'date'=>'٢٨ أبريل ٢٠٢٦', 'read'=>'٤ دقائق'],
            ];
            $tagColors = [
                'إرشاد أكاديمي' => ['bg'=>'#e6f4ec', 'color'=>'#1A6B3C'],
                'ذكاء اصطناعي'  => ['bg'=>'#eff6ff', 'color'=>'#1d4ed8'],
                'مستقبل مهني'   => ['bg'=>'#fffbeb', 'color'=>'#92400e'],
                'نصائح'         => ['bg'=>'#fdf4ff', 'color'=>'#7e22ce'],
            ];
            @endphp

            @foreach($articles as $article)
            @php $tc = $tagColors[$article['tag']] ?? ['bg'=>'#f3f4f6','color'=>'#374151']; @endphp
            <div class="article-card">
                <div class="article-img">
                    {{-- Decorative placeholder --}}
                    <svg width="48" height="48" fill="none" stroke="#d1d5db" stroke-width="1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="article-body">
                    <span class="tag-chip" style="background:{{ $tc['bg'] }}; color:{{ $tc['color'] }};">{{ $article['tag'] }}</span>
                    <h3 style="font-size:.95rem; font-weight:800; color:#111827; line-height:1.6; margin:0;">
                        {{ $article['title'] }}
                    </h3>
                    <div style="display:flex; align-items:center; gap:12px; margin-top:auto;">
                        <span style="font-size:.75rem; color:#9ca3af;">{{ $article['date'] }}</span>
                        <span style="font-size:.75rem; color:#9ca3af;">·</span>
                        <span style="font-size:.75rem; color:#9ca3af;">وقت القراءة: {{ $article['read'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     7. FOOTER  (DGA Design System)
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
            { name: 'عن المنصة',        target: '#about' },
            { name: 'خدماتنا',          target: '#services' },
            { name: 'المقالات والأخبار', target: '#articles' },
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
