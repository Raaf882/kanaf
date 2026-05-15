<x-layouts.app title="الرئيسية">

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- HERO                                                           --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gradient-to-bl from-[#F0FAF4] via-white to-[#EEF2FF] py-16 md:py-20">

    {{-- Decorative blobs --}}
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#1A6B3C]/8 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-16 -right-16 w-72 h-72 bg-purple-200/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Text side --}}
            <div class="order-2 lg:order-1 text-center lg:text-right">
                <div class="inline-flex items-center gap-2 bg-[#1A6B3C]/10 text-[#1A6B3C] text-xs font-bold px-4 py-2 rounded-full mb-6">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    منظومة إرشادية استباقية
                </div>

                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                    أهلاً
                    <span class="text-[#1A6B3C]">{{ Auth::user()->first_name }}</span>،
                    <br>
                    <span class="text-gray-700">في كَـنَـف</span>
                </h1>

                <p class="text-lg text-gray-500 mb-8 leading-relaxed max-w-xl mx-auto lg:mx-0">
                    منظومتك الذكية للإرشاد الأكاديمي والمهني —
                    تتابع أداءك، ترشدك للمسار الأنسب، وتضعك على طريق النجاح.
                </p>

                <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                    <a href="{{ route('academic-journey') }}"
                       class="flex items-center gap-2 bg-[#1A6B3C] hover:bg-[#155C33] text-white font-bold px-6 py-3 rounded-2xl transition-all shadow-lg shadow-[#1A6B3C]/20 hover:shadow-[#1A6B3C]/30 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        رحلتي الأكاديمية
                    </a>
                    <a href="{{ route('career-future') }}"
                       class="flex items-center gap-2 bg-white hover:bg-gray-50 text-[#1A6B3C] font-bold px-6 py-3 rounded-2xl border border-[#1A6B3C]/20 transition-all hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        مستقبلي المهني
                    </a>
                </div>

                {{-- Quick stats --}}
                <div class="grid grid-cols-3 gap-4 mt-10 pt-8 border-t border-gray-200">
                    <div class="text-center">
                        <div class="text-2xl font-extrabold text-[#1A6B3C]">98%</div>
                        <div class="text-xs text-gray-400 mt-0.5">نسبة الحضور</div>
                    </div>
                    <div class="text-center border-x border-gray-200">
                        <div class="text-2xl font-extrabold text-amber-500">3.8</div>
                        <div class="text-xs text-gray-400 mt-0.5">المعدل التراكمي</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-extrabold text-blue-500">6</div>
                        <div class="text-xs text-gray-400 mt-0.5">مقررات مسجلة</div>
                    </div>
                </div>
            </div>

            {{-- Illustration side --}}
            <div class="order-1 lg:order-2 flex justify-center">
                <div class="relative w-full max-w-md">
                    {{-- Hero illustration image --}}
                    <img src="/images/hero-illustration.png"
                         alt="كَـنَـف"
                         class="w-full drop-shadow-2xl"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                    {{-- SVG fallback illustration --}}
                    <div class="w-full aspect-square bg-gradient-to-br from-[#F0FAF4] to-[#E8F5E9] rounded-3xl flex items-center justify-center hidden"
                         style="display:none">
                        <div class="text-center p-10">
                            {{-- Stylized book + graduation cap SVG --}}
                            <svg viewBox="0 0 200 200" class="w-48 h-48 mx-auto" fill="none">
                                <circle cx="100" cy="100" r="90" fill="#F0FAF4"/>
                                {{-- Books stack --}}
                                <rect x="50" y="100" width="60" height="12" rx="3" fill="#1A6B3C" opacity="0.8"/>
                                <rect x="55" y="88"  width="55" height="12" rx="3" fill="#2D9D60" opacity="0.8"/>
                                <rect x="45" y="112" width="65" height="12" rx="3" fill="#155C33" opacity="0.8"/>
                                {{-- Graduation cap --}}
                                <polygon points="100,40 140,60 100,80 60,60" fill="#1A6B3C"/>
                                <rect x="130" y="60" width="4" height="20" rx="2" fill="#1A6B3C"/>
                                <circle cx="132" cy="82" r="5" fill="#F59E0B"/>
                                {{-- Stars --}}
                                <circle cx="150" cy="45" r="4" fill="#F59E0B" opacity="0.7"/>
                                <circle cx="55"  cy="55" r="3" fill="#6B21A8" opacity="0.5"/>
                                <circle cx="160" cy="90" r="3" fill="#1A6B3C" opacity="0.5"/>
                            </svg>
                            <p class="text-[#1A6B3C] font-bold text-xl mt-2">كَـنَـف</p>
                            <p class="text-gray-400 text-sm">منظومتك الإرشادية</p>
                        </div>
                    </div>

                    {{-- Floating badge cards --}}
                    <div class="absolute -bottom-4 -right-4 bg-white rounded-2xl shadow-lg px-4 py-3 flex items-center gap-2.5 border border-gray-100">
                        <div class="w-8 h-8 bg-[#F0FAF4] rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#1A6B3C]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-800">أداء أكاديمي</div>
                            <div class="text-xs text-[#1A6B3C] font-semibold">ممتاز ✓</div>
                        </div>
                    </div>

                    <div class="absolute -top-4 -left-4 bg-white rounded-2xl shadow-lg px-4 py-3 flex items-center gap-2.5 border border-gray-100">
                        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-gray-800">مسار مقترح</div>
                            <div class="text-xs text-amber-600 font-semibold">تحليل البيانات</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════ --}}
{{-- QUICK LINKS                                                    --}}
{{-- ══════════════════════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <div class="text-center mb-10">
        <h2 class="text-2xl font-extrabold text-gray-800">استكشف منصة كَـنَـف</h2>
        <p class="text-gray-400 mt-2 text-sm">كل ما تحتاجه لمستقبل أكاديمي ومهني متميز</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <a href="{{ route('academic-journey') }}"
           class="group relative bg-white rounded-3xl shadow-sm border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-[#F0FAF4] to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="w-14 h-14 bg-[#F0FAF4] group-hover:bg-[#1A6B3C] rounded-2xl flex items-center justify-center mb-5 transition-colors">
                    <svg class="w-7 h-7 text-[#1A6B3C] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">رحلتك الأكاديمية</h3>
                <p class="text-gray-400 text-sm leading-relaxed">تابع درجاتك ومقرراتك، واطلع على توصيات كَـنَـف المخصصة لك في كل مادة لتحسين أدائك.</p>
                <div class="flex items-center gap-1.5 mt-5 text-[#1A6B3C] text-sm font-semibold">
                    <span>ابدأ الآن</span>
                    <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        </a>

        <a href="{{ route('career-future') }}"
           class="group relative bg-white rounded-3xl shadow-sm border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="w-14 h-14 bg-purple-50 group-hover:bg-[#6B21A8] rounded-2xl flex items-center justify-center mb-5 transition-colors">
                    <svg class="w-7 h-7 text-[#6B21A8] group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">مستقبلك المهني</h3>
                <p class="text-gray-400 text-sm leading-relaxed">اكتشف مسارك المهني المقترح بناءً على أدائك الأكاديمي، وتواصل مع خبراء السوق السعودي.</p>
                <div class="flex items-center gap-1.5 mt-5 text-[#6B21A8] text-sm font-semibold">
                    <span>اكتشف مسارك</span>
                    <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        </a>
    </div>
</section>

</x-layouts.app>
