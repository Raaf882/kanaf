<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول — كَـنَـف</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="shortcut icon"                        href="{{ asset('images/kanaf-logo.png') }}">
    <link rel="apple-touch-icon"                     href="{{ asset('images/kanaf-logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Cairo', sans-serif; }
        .kanaf-logo { font-family: 'Cairo', sans-serif; font-weight: 900; letter-spacing: 0.05em; }

        .hero-bg {
            background-image: url('/images/login-bg.jpg');
            background-size: cover;
            background-position: center;
        }
        .hero-bg-fallback {
            background: linear-gradient(135deg,
                #0d3d24 0%,
                #1A6B3C 30%,
                #2d8a54 55%,
                #c8a876 80%,
                #b8956a 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        input[type="password"]::-ms-reveal { display: none; }
    </style>
</head>
<body class="min-h-screen flex flex-col">

{{-- ═══ NAVBAR ════════════════════════════════════════════════════ --}}
<nav class="bg-white/90 backdrop-blur border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Right: Logo + Nav --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('root') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/kanaf-logo.png') }}" alt="كَـنَـف"
                         class="h-10 w-10 object-contain"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="h-10 w-10 rounded-full bg-[#1A6B3C] items-center justify-center hidden">
                        <span class="kanaf-logo text-white text-[11px]">كَنَف</span>
                    </div>
                    <span class="kanaf-logo text-[#1A6B3C] text-xl tracking-wide hidden sm:block">كَـــنَـف</span>
                </a>

                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('root') }}" class="text-sm font-semibold text-[#1A6B3C] border-b-2 border-[#1A6B3C] pb-1">الرئيسية</a>
                    <span class="text-sm font-semibold text-gray-400 cursor-default pb-1">رحلتك الأكاديمية</span>
                    <span class="text-sm font-semibold text-gray-400 cursor-default pb-1">مستقبلك المهني</span>
                </div>
            </div>

            {{-- Left: Search + Lang + Login --}}
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-1.5 text-sm text-gray-600 hover:text-gray-800 transition-colors px-3 py-2 rounded-xl hover:bg-gray-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span class="hidden sm:inline text-xs font-semibold">البحث</span>
                </button>

                <button class="flex items-center gap-1 text-xs text-gray-600 border border-gray-300 rounded-lg px-3 py-1.5 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    English
                </button>

                <a href="{{ route('login') }}"
                   class="flex items-center gap-1.5 text-sm font-semibold text-gray-700 hover:text-[#1A6B3C] transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    تسجيل الدخول
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- ═══ HERO ═══════════════════════════════════════════════════════ --}}
<main class="flex-1 relative hero-bg hero-bg-fallback">

    {{-- Dark overlay for readability --}}
    <div class="absolute inset-0 bg-black/20"></div>

    {{-- Decorative floating elements (visible when no image) --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-1/3 w-20 h-20 bg-white/5 rounded-2xl rotate-12 animate-pulse"></div>
        <div class="absolute top-1/4 left-1/4 w-12 h-12 bg-[#1A6B3C]/20 rounded-xl rotate-45"></div>
        <div class="absolute bottom-1/4 left-1/3 w-16 h-16 bg-white/5 rounded-full"></div>
        <div class="absolute top-1/3 right-1/4 w-8 h-8 bg-white/10 rounded-lg rotate-12"></div>
    </div>

    <div class="relative z-10 min-h-[calc(100vh-64px)] flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                {{-- Login card (right side in RTL) --}}
                <div class="glass-card rounded-3xl shadow-2xl p-8 sm:p-10 w-full max-w-lg mx-auto lg:mx-0">

                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">تسجيل الدخول</h1>
                    <p class="text-sm text-gray-500 mb-8 leading-relaxed">
                        لأن كل طالب يحتاج شخص يسانده ؛ كنف هنا لدعم رحلتك
                    </p>

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-6">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                        @csrf

                        {{-- Email / username --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                اسم المستخدم او الايميل
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="ادخل اسم المستخدم او الايميل الجامعي"
                                   class="w-full border border-gray-200 bg-gray-50/60 rounded-2xl px-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] focus:border-transparent placeholder-gray-400 transition-all">
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                كلمة المرور
                            </label>
                            <div class="relative">
                                <input id="password-input" type="password" name="password" required
                                       placeholder="ادخل كلمة المرور"
                                       class="w-full border border-gray-200 bg-gray-50/60 rounded-2xl px-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] focus:border-transparent placeholder-gray-400 transition-all">
                                <button type="button" onclick="togglePassword()"
                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#1A6B3C] transition-colors">
                                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full bg-[#1A6B3C] hover:bg-[#155C33] active:bg-[#0f4326] text-white font-bold py-4 rounded-2xl transition-all shadow-lg shadow-[#1A6B3C]/20 hover:shadow-[#1A6B3C]/30 text-base mt-2">
                            تسجيل الدخول
                        </button>
                    </form>

                    {{-- Extra links --}}
                    <div class="mt-6 pt-5 border-t border-gray-100 space-y-2">
                        <button class="flex items-center gap-2 text-sm text-gray-600 hover:text-[#1A6B3C] transition-colors font-semibold w-full">
                            <svg class="w-4 h-4 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            هل نسيت كلمة المرور؟
                        </button>
                        <button class="flex items-center gap-2 text-sm text-gray-600 hover:text-[#1A6B3C] transition-colors font-semibold w-full">
                            <svg class="w-4 h-4 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            تغيير كلمة المرور
                        </button>
                    </div>

                    {{-- Demo hint --}}
                    <p class="text-center text-xs text-gray-400 mt-5">
                        للتجربة:
                        <span class="font-mono font-semibold text-gray-600">khalid@kanaf.sa</span>
                        /
                        <span class="font-mono font-semibold text-gray-600">password</span>
                    </p>
                </div>

                {{-- 3D Illustration (left side in RTL = right visually) --}}
                <div class="hidden lg:flex justify-center items-center">
                    <img src="/images/login-hero.png"
                         alt="كَـنَـف"
                         class="w-full max-w-lg drop-shadow-2xl"
                         onerror="this.style.display='none';">
                </div>

            </div>
        </div>
    </div>
</main>

{{-- ═══ FOOTER ═════════════════════════════════════════════════════ --}}
<footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/kanaf-logo.png') }}" alt="كَـنَـف"
                     class="h-12 w-12 object-contain"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="h-12 w-12 rounded-full bg-[#1A6B3C] items-center justify-center hidden">
                    <span class="kanaf-logo text-white text-sm">كَنَف</span>
                </div>
                <div class="h-12 w-12 bg-gray-800 rounded-lg flex items-center justify-center">
                    <span class="text-white text-xs font-bold">سدايا</span>
                </div>
            </div>
            <nav class="flex gap-6 text-sm text-gray-500">
                <a href="#" class="hover:text-gray-800 transition-colors">خريطة الموقع</a>
                <a href="#" class="hover:text-gray-800 transition-colors">RSS</a>
                <a href="#" class="hover:text-gray-800 transition-colors">تطبيق الجوال</a>
            </nav>
        </div>
        <div class="mt-6 text-center text-sm text-gray-500 space-y-1">
            <p class="font-bold text-gray-700">جميع الحقوق محفوظة لهيئة الحوكمة الرقمية © 2026</p>
            <p>تم تطويره وصيانته بواسطة كَـنَـف</p>
            <p>تاريخ آخر تعديل: 04/12/2026</p>
        </div>
    </div>
</footer>

<script>
function togglePassword() {
    const input   = document.getElementById('password-input');
    const eyeOn   = document.getElementById('eye-icon');
    const eyeOff  = document.getElementById('eye-off-icon');
    if (input.type === 'password') {
        input.type  = 'text';
        eyeOn.classList.add('hidden');
        eyeOff.classList.remove('hidden');
    } else {
        input.type  = 'password';
        eyeOn.classList.remove('hidden');
        eyeOff.classList.add('hidden');
    }
}
</script>

</body>
</html>
