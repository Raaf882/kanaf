<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- ══ TOAST ══ --}}
    @if($showToast)
    <div x-data="{ show: true }"
         x-init="setTimeout(() => { show = false; $wire.dismissToast() }, 3500)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-end="opacity-0"
         class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-[#1A6B3C] text-white text-sm font-semibold px-5 py-3 rounded-2xl shadow-xl flex items-center gap-3">
        <span>{{ $toastMessage }}</span>
        <button wire:click="dismissToast" class="opacity-60 hover:opacity-100">✕</button>
    </div>
    @endif

    {{-- ══ BREADCRUMB ══ --}}
    <div class="flex items-center justify-between mb-6">
        <button onclick="history.back()"
                class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        <nav class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-[#1A6B3C] transition-colors">الرئيسية</a>
            <span>›</span>
            <span class="text-gray-700 font-semibold">مستقبلك المهني</span>
        </nav>
    </div>

    {{-- ══ HEADER ══ --}}
    <div class="mb-8 text-right">
        <h1 class="text-4xl font-black text-gray-900 mb-3">مستقبلك المهني</h1>

        @if($this->isNewStudent)
            <p class="text-gray-500 text-base">
                تعرّف على الفرص والمسارات المهنية المطلوبة في سوق العمل السعودي بناءً على تخصصك.
            </p>
            {{-- Info note --}}
            <div class="mt-4 flex items-start gap-2 text-right justify-end">
                <p class="text-gray-700 text-sm leading-relaxed max-w-xl">
                    اكتشافك المبكر للمسارات المهنية يساعدك على بناء مهاراتك وخبراتك بشكل أوضح خلال رحلتك الجامعية.
                </p>
                <span class="text-lg flex-shrink-0">📌</span>
            </div>
        @else
            <p class="text-gray-500 text-base">
                بناءً على أدائك الأكاديمي واهتماماتك، هذه مسارات مهنية مناسبة يمكنك استكشافها
            </p>
            {{-- How we chose notice --}}
            <div class="mt-4 flex items-start gap-2 text-right justify-end">
                <div class="text-right">
                    <p class="text-gray-700 text-sm font-bold">كيف تم اختيار المسارات؟</p>
                    <p class="text-gray-600 text-sm leading-relaxed max-w-xl mt-0.5">
                        تم بناء هذه التوصيات اعتماداً على المواد التي يظهر فيها أداؤك مرتفع، بالإضافة إلى الأنماط العامة في تقدمك الأكاديمي
                    </p>
                </div>
                <span class="text-lg flex-shrink-0">📌</span>
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════════════════
         NEW STUDENT VIEW — 2×2 grid, all paths, skills list
    ══════════════════════════════════════════════════════ --}}
    @if($this->isNewStudent)

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach($this->allPaths as $path)
        @php $isSaved = in_array($path->id, $this->savedIds); @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-right hover:shadow-md transition-shadow">

            {{-- Title row --}}
            <div class="flex items-start gap-3 mb-3 flex-row-reverse">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-black text-[#1A6B3C] text-base">{{ $path->name }}</h3>
                    <p class="text-gray-500 text-sm mt-1 leading-relaxed">{{ $path->description }}</p>
                </div>
            </div>

            {{-- Skills --}}
            @if(!empty($path->core_skills))
            <div class="mb-4">
                <p class="font-black text-gray-800 text-sm mb-2">أهم المهارات</p>
                <ul class="space-y-1">
                    @foreach(array_slice($path->core_skills, 0, 4) as $skill)
                    <li class="flex items-center gap-1.5 justify-end text-sm text-gray-600">
                        <span>{{ $skill }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-[#1A6B3C] flex-shrink-0"></span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Save button --}}
            <div class="flex gap-2 mt-4">
                <a href="{{ route('career-path-detail', $path) }}"
                   class="flex-1 text-center text-sm font-bold py-2.5 px-4 rounded-xl bg-[#1A6B3C] text-white hover:bg-[#155e34] transition-colors">
                    استعراض المسار
                </a>
                <button wire:click="toggleSave({{ $path->id }})"
                        class="flex-1 text-sm font-bold py-2.5 px-4 rounded-xl border-2 transition-colors
                               {{ $isSaved
                                  ? 'border-[#1A6B3C] bg-[#F0FAF4] text-[#1A6B3C]'
                                  : 'border-gray-200 text-gray-600 hover:border-[#1A6B3C] hover:text-[#1A6B3C]' }}">
                    {{ $isSaved ? '✓ محفوظ' : 'حفظ في المسارات المفضلة' }}
                </button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════════════
         ESTABLISHED STUDENT VIEW — 3-col, recommended, with "why"
    ══════════════════════════════════════════════════════ --}}
    @else

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @foreach($this->recommendedPaths as $item)
        @php
            $path   = $item['path'];
            $why    = $item['why'];
            $isSaved = in_array($path->id, $this->savedIds);
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-right flex flex-col hover:shadow-md transition-shadow">

            {{-- Title row --}}
            <div class="flex items-start gap-3 mb-3 flex-row-reverse">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-black text-[#1A6B3C] text-base">{{ $path->name }}</h3>
                    <p class="text-gray-500 text-sm mt-1 leading-relaxed">{{ $path->description }}</p>
                </div>
            </div>

            {{-- Why --}}
            <div class="flex-1 mb-4">
                <p class="text-sm text-gray-800 leading-relaxed">
                    <span class="font-black">لماذا يناسبك: </span>
                    <span class="font-bold">{{ $why }}</span>
                </p>
            </div>

            {{-- Buttons --}}
            <div class="space-y-2 mt-auto">
                <a href="{{ route('career-path-detail', $path) }}"
                   class="block text-center text-sm font-bold py-2.5 px-4 rounded-xl bg-[#1A6B3C] text-white hover:bg-[#155e34] transition-colors">
                    استعراض المسار
                </a>
                <button wire:click="toggleSave({{ $path->id }})"
                        class="w-full text-sm font-bold py-2.5 px-4 rounded-xl border-2 transition-colors
                               {{ $isSaved
                                  ? 'border-[#1A6B3C] bg-[#F0FAF4] text-[#1A6B3C]'
                                  : 'border-gray-200 text-gray-600 hover:border-[#1A6B3C] hover:text-[#1A6B3C]' }}">
                    {{ $isSaved ? '✓ محفوظ في المفضلة' : 'حفظ في المسارات المفضلة' }}
                </button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Explore all link --}}
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-400 mb-3">هل تريد استكشاف جميع المسارات المتاحة؟</p>
        <a href="#" class="inline-flex items-center gap-2 text-[#1A6B3C] font-bold text-sm border border-[#1A6B3C]/30 px-5 py-2.5 rounded-xl hover:bg-[#F0FAF4] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            استعراض جميع المسارات
        </a>
    </div>

    @endif

    {{-- ══ SAVED NOTICE ══ --}}
    @if(count($this->savedIds) > 0)
    <div class="mt-10 bg-[#F0FAF4] border border-[#1A6B3C]/20 rounded-2xl p-5 flex items-center justify-between">
        <span class="text-xs text-gray-500">يمكنك مراجعتها من صفحة الرئيسية</span>
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
            <p class="text-sm font-semibold text-gray-800">
                لديك <span class="text-[#1A6B3C] font-black">{{ count($this->savedIds) }}</span> مسار محفوظ
            </p>
        </div>
    </div>
    @endif

</div>
