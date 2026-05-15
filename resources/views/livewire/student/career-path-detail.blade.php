<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- ══ BREADCRUMB + BACK ══ --}}
    <div class="flex items-center justify-between mb-6">
        <button onclick="history.back()"
                class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        <nav class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('career-future') }}" class="hover:text-[#1A6B3C] transition-colors">مستقبلك المهني</a>
            <span>›</span>
            <span class="text-gray-700 font-semibold">{{ $careerPath->name }}</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        {{-- ══ SIDEBAR ══ --}}
        <aside class="lg:col-span-1 order-2 lg:order-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6 sticky top-24">

                {{-- Work fields --}}
                <div>
                    <div class="flex items-center gap-2 mb-3 flex-row-reverse justify-end">
                        <h3 class="font-black text-gray-800 text-sm">مجالات العمل</h3>
                        <svg class="w-4 h-4 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <ul class="space-y-1.5 text-right">
                        @foreach($careerPath->work_fields ?? [] as $field)
                        <li class="text-sm text-gray-600">{{ $field }}</li>
                        @endforeach
                    </ul>
                </div>

                <hr class="border-gray-100">

                {{-- Certifications --}}
                <div>
                    <div class="flex items-center gap-2 mb-3 flex-row-reverse justify-end">
                        <h3 class="font-black text-gray-800 text-sm">الشهادات الأحترافية المقترحة:</h3>
                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <ul class="space-y-1.5 text-right">
                        @foreach($careerPath->certifications as $cert)
                        <li class="text-sm text-gray-600">{{ $cert->name }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </aside>

        {{-- ══ MAIN CONTENT ══ --}}
        <main class="lg:col-span-3 order-1 lg:order-2 space-y-6">

            {{-- Title & description --}}
            <div class="text-right">
                <h1 class="text-3xl font-black text-gray-900 mb-2">{{ $careerPath->name }}</h1>
                <p class="text-gray-500 text-base leading-relaxed">{{ $careerPath->description }}</p>
            </div>

            {{-- Why recommended --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-right space-y-2">
                <p class="font-black text-gray-900">سبب اقتراح المسار للطالب:</p>
                <p class="font-bold text-gray-700 leading-relaxed">
                    تم اقتراح هذا المسار بناءً على أدائك الجيد في المواد التحليلية والتقنية.
                </p>
            </div>

            {{-- Core skills --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-right">
                <h2 class="font-black text-gray-900 mb-4">المهارات الأساسية:</h2>
                <ul class="space-y-1.5">
                    @foreach($careerPath->core_skills ?? [] as $skill)
                    <li class="text-sm text-gray-700 flex items-center gap-2 justify-end">
                        <span>{{ $skill }}-</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Inspiring figures --}}
            @if($careerPath->experts->count())
            <div class="text-right">
                <h2 class="font-black text-gray-900 text-lg mb-4">شخصيات ملهمة بالسوق السعودي</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($careerPath->experts->take(3) as $expert)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                        {{-- Avatar --}}
                        <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        {{-- Name --}}
                        <a href="{{ $expert->linkedin_url ?? '#' }}"
                           target="_blank"
                           class="font-bold text-[#1A6B3C] text-sm hover:underline block mb-1">
                            {{ $expert->name }}
                        </a>
                        {{-- Title & company --}}
                        <p class="text-xs text-gray-500 mb-3">
                            {{ $expert->title }} — {{ $expert->company }}
                        </p>
                        {{-- LinkedIn --}}
                        @if($expert->linkedin_url)
                        <a href="{{ $expert->linkedin_url }}" target="_blank"
                           class="inline-block text-xs text-blue-600 hover:underline border border-blue-200 rounded-lg px-3 py-1 hover:bg-blue-50 transition-colors">
                            [ LinkedIn ]
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- How to start --}}
            @if($careerPath->suggested_plan)
            <div class="text-right">
                <h2 class="font-black text-gray-900 text-lg mb-4">كيف تبدأ؟</h2>
                <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-black text-gray-800 text-center mb-4">الخطة المقترحة</h3>
                    <ol class="space-y-2.5 text-right">
                        @foreach($careerPath->suggested_plan as $i => $step)
                        <li class="text-sm text-gray-700 flex items-start gap-2 justify-end">
                            <span class="leading-relaxed">{{ $step }}</span>
                            <span class="font-black text-[#1A6B3C] flex-shrink-0">{{ $i + 1 }}.</span>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
            @endif

            {{-- Save button --}}
            <div>
                <button wire:click="toggleSave"
                        class="flex items-center gap-2 font-bold text-sm px-7 py-3 rounded-xl transition-all
                               {{ $isSaved
                                  ? 'bg-[#1A6B3C] text-white hover:bg-[#155e34] shadow-md'
                                  : 'bg-[#1A6B3C] text-white hover:bg-[#155e34] shadow-md' }}">
                    <svg class="w-4 h-4" fill="{{ $isSaved ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    {{ $isSaved ? '✓ تم الحفظ في المسارات المفضلة' : 'حفظ في المسارات المفضلة' }}
                </button>
            </div>

        </main>
    </div>

</div>
