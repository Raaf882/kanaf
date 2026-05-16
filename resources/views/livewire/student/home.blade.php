<div x-data>

    {{-- ── Toast ── --}}
    @if($showToast)
    <div x-data="{ show: true }"
         x-init="setTimeout(() => { show = false; $wire.dismissToast(); }, 4000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-end="opacity-0"
         class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-sm font-semibold
                {{ $toastType === 'success' ? 'bg-[#1A6B3C] text-white' : 'bg-gray-700 text-white' }}">
        {{ $toastMessage }}
    </div>
    @endif

    {{-- ── Pending Nominations Banner ── --}}
    @if($this->pendingNominations->count() > 0)
    <div style="background:#f3f8f5; border-bottom:1px solid #d1fae5;">
        <div class="page-container py-4 space-y-3" dir="rtl">
            @foreach($this->pendingNominations as $nom)
            <div class="bg-white border border-amber-200 rounded-2xl p-5 flex items-start gap-4 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-2xl flex-shrink-0">
                    {{ $nom->event_type_icon }}
                </div>
                <div class="flex-1 min-w-0 text-right">
                    <div class="flex items-center gap-2 flex-wrap mb-1 justify-end">
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $nom->event_type_arabic }}</span>
                        <span class="text-xs font-bold text-amber-700 bg-amber-100 px-2.5 py-0.5 rounded-full">ترشيح جديد ⭐</span>
                    </div>
                    <h3 class="font-bold text-gray-800 text-base">{{ $nom->event_name }}</h3>
                    <p class="text-sm text-gray-600 mt-0.5">
                        رشّحك <span class="font-bold text-gray-800">{{ $nom->advisor->name }}</span> للمشاركة
                    </p>
                    @if($nom->event_date)
                    <p class="text-xs text-gray-400 mt-1">📅 {{ $nom->event_date->format('Y/m/d') }}</p>
                    @endif
                    @if($nom->message)
                    <p class="text-xs text-gray-500 italic mt-2 bg-gray-50 px-3 py-2 rounded-xl">"{{ $nom->message }}"</p>
                    @endif
                </div>
                <div class="flex flex-col gap-2 flex-shrink-0">
                    <button wire:click="respondNomination({{ $nom->id }}, 'accepted')"
                            class="flex items-center gap-1.5 bg-[#1A6B3C] text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-[#155C33] transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        قبول
                    </button>
                    <button wire:click="respondNomination({{ $nom->id }}, 'rejected')"
                            class="text-xs font-bold px-4 py-2.5 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition-colors">
                        رفض
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Page Content ── --}}
    <div class="page-body space-y-8" dir="rtl">

        {{-- ══ 1. Hero greeting ══ --}}
        <div style="background:linear-gradient(135deg,#1A6B3C 0%,#2d8a54 100%); border-radius:20px; padding:32px 36px; color:#fff; display:flex; align-items:center; justify-content:space-between; gap:24px; flex-wrap:wrap;">
            <div>
                @php
                    $hour = now()->hour;
                    $greeting = $hour < 12 ? 'صباح الخير' : ($hour < 17 ? 'مساء الخير' : 'مساء النور');
                @endphp
                <p style="font-size:.9rem; opacity:.8; margin:0 0 4px;">{{ $greeting }}</p>
                <h1 style="font-size:2rem; font-weight:900; margin:0; line-height:1.2;">
                    أهلاً {{ auth()->user()->first_name }} 👋
                </h1>
                <p style="font-size:.9rem; opacity:.75; margin:8px 0 0; max-width:480px; line-height:1.7;">
                    في لوحتك الأكاديمية ستجد ملخصاً واضحاً لوضعك الدراسي الحالي، مع توجيهات تساعدك على تحديد خطواتك التالية.
                </p>
            </div>
            <div style="opacity:.15;">
                <svg width="80" height="80" fill="none" stroke="#fff" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
        </div>

        {{-- ══ 2. Student info + Advisor ══ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Student info --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black text-gray-800 text-base mb-4 pb-3 border-b border-gray-100 flex items-center gap-2 flex-row-reverse justify-end">
                    <span>معلومات الطالب</span>
                    <div class="w-7 h-7 rounded-lg bg-[#F0FAF4] flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#1A6B3C]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </h3>
                @php
                    $levels = ['', 'الأول', 'الثاني', 'الثالث', 'الرابع', 'الخامس', 'السادس', 'السابع', 'الثامن'];
                    $lvl = auth()->user()->academic_level ?? 4;
                @endphp
                <dl class="space-y-3 text-sm text-right">
                    @foreach([
                        ['اسم الطالب',    auth()->user()->name],
                        ['الرقم الجامعي', auth()->user()->student_id ?? '441'.str_pad(auth()->id(),7,'0',STR_PAD_LEFT)],
                        ['التخصص',        auth()->user()->major ?? 'علوم حاسب'],
                        ['المستوى',       $levels[$lvl] ?? $lvl],
                    ] as [$label, $value])
                    <div class="flex justify-between items-center py-2 border-b border-gray-50 last:border-0">
                        <span class="font-bold text-[#1A6B3C]">{{ $value }}</span>
                        <span class="text-gray-500 text-xs font-semibold">{{ $label }}</span>
                    </div>
                    @endforeach
                </dl>
            </div>

            {{-- Advisor contact --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-black text-gray-800 text-base mb-4 pb-3 border-b border-gray-100 flex items-center gap-2 flex-row-reverse justify-end">
                    <span>تواصل مع المرشد</span>
                    <div class="w-7 h-7 rounded-lg bg-[#F0FAF4] flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                </h3>
                @if($this->advisor)
                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <div class="w-9 h-9 rounded-xl bg-[#F0FAF4] flex items-center justify-center text-[#1A6B3C] font-black text-sm flex-shrink-0">
                            {{ mb_substr($this->advisor->name, 0, 1) }}
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400">اسم المرشد</p>
                            <p class="font-bold text-gray-800 text-sm">{{ $this->advisor->name }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-gray-50 rounded-xl text-right">
                            <p class="text-xs text-gray-400 mb-0.5">رقم المكتب</p>
                            <p class="font-bold text-gray-700 text-sm">{{ $this->advisor->job_number ?? '199099' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl text-right overflow-hidden">
                            <p class="text-xs text-gray-400 mb-0.5">البريد الإلكتروني</p>
                            <p class="font-bold text-gray-700 text-xs truncate">{{ $this->advisor->email }}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="py-8 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-sm font-medium">لم يتم تعيين مرشد أكاديمي بعد</p>
                </div>
                @endif
            </div>
        </div>

        {{-- ══ 3. المستوى الدراسي (Stats) ══ --}}
        @php $stats = $this->stats; @endphp
        <div>
            <h2 class="text-2xl font-black text-gray-900 text-right mb-5">المستوى الدراسي</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                    <p class="text-3xl font-black text-gray-900">{{ $stats['improvement'] }}%</p>
                    <p class="text-sm text-gray-400 mt-2 font-semibold">نسبة التحسن</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                    <p class="text-3xl font-black text-gray-900">{{ $stats['courses'] }}</p>
                    <p class="text-sm text-gray-400 mt-2 font-semibold">المواد المجتازة</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                    <p class="text-3xl font-black text-gray-900">{{ number_format($stats['gpa'], 1) }}</p>
                    <p class="text-sm text-gray-400 mt-2 font-semibold">المعدل التراكمي</p>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                    <p class="text-xl font-black {{ $stats['status_color'] }} mt-2">{{ $stats['status'] }}</p>
                    <p class="text-sm text-gray-400 mt-2 font-semibold">الحالة الأكاديمية</p>
                </div>
            </div>
        </div>

        {{-- SAP AI Prediction — only when data is available --}}
        @php $sap = $this->sapPrediction; @endphp
        @if($sap['available'])
        <div class="rounded-2xl border p-6 shadow-sm {{ $sap['risk'] ? 'bg-red-50 border-red-200' : 'bg-[#F0FAF4] border-green-200' }}">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0
                    {{ $sap['risk'] ? 'bg-red-100' : 'bg-green-100' }}">
                    <svg class="w-6 h-6 {{ $sap['risk'] ? 'text-red-600' : 'text-[#1A6B3C]' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div class="flex-1 text-right">
                    <div class="flex items-center gap-2 flex-wrap mb-1 justify-end">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/70 text-gray-500 border border-gray-200">SAP Model</span>
                        <h3 class="font-black text-gray-800 text-base">تحليل الذكاء الاصطناعي</h3>
                    </div>
                    <p class="text-sm font-semibold {{ $sap['risk'] ? 'text-red-700' : 'text-[#1A6B3C]' }}">
                        {{ $sap['risk']
                            ? 'يشير نموذج الذكاء الاصطناعي إلى احتمالية تدنٍّ أكاديمي — يُنصح بمتابعة مرشدك الأكاديمي.'
                            : 'وضعك الأكاديمي مستقر وفق تحليل النموذج، استمر في مسارك الحالي.' }}
                    </p>
                    @if($sap['confidence'])
                    <p class="text-xs text-gray-400 mt-1">نسبة الثقة: <span class="font-bold text-gray-600">{{ $sap['confidence'] }}%</span></p>
                    @endif
                </div>
                <span class="flex-shrink-0 text-sm font-black px-3 py-1.5 rounded-xl
                    {{ $sap['risk'] ? 'bg-red-600 text-white' : 'bg-[#1A6B3C] text-white' }}">
                    {{ $sap['label'] }}
                </span>
            </div>
        </div>
        @endif

        {{-- ══ 4. مواد هذا الفصل ══ --}}
        @if($this->enrollments->isNotEmpty())
        <div>
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-2xl font-black text-gray-900">مواد هذا الفصل</h2>
                <a href="{{ route('academic-journey') }}"
                   class="text-sm font-bold text-[#1A6B3C] flex items-center gap-1.5 hover:underline">
                    عرض الكل
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach ($this->enrollments as $enrollment)
                @php
                    $score = $enrollment->total_score;

                    $badgeConfig = match(true) {
                        $score >= 80 => [
                            'label'     => 'أداء مرتفع 👍',
                            'bg'        => 'bg-[#F0FAF4]',
                            'text'      => 'text-[#1A6B3C]',
                            'border'    => 'border-green-200',
                            'levelText' => 'ممتاز',
                            'levelColor'=> 'text-[#1A6B3C]',
                            'chipBg'    => 'bg-[#F0FAF4] text-[#1A6B3C]',
                            'chip'      => 'تقدم ممتاز في المادة',
                        ],
                        $score >= 55 => [
                            'label'     => 'أداء متوسط ℹ️',
                            'bg'        => 'bg-amber-50',
                            'text'      => 'text-amber-700',
                            'border'    => 'border-amber-200',
                            'levelText' => 'جيد',
                            'levelColor'=> 'text-amber-700',
                            'chipBg'    => 'bg-amber-50 text-amber-700',
                            'chip'      => 'خطوات بسيطة تقدم أكثر',
                        ],
                        default      => [
                            'label'     => 'يحتاج تحسين ⚠️',
                            'bg'        => 'bg-red-50',
                            'text'      => 'text-red-700',
                            'border'    => 'border-red-200',
                            'levelText' => 'يحتاج متابعة',
                            'levelColor'=> 'text-amber-600',
                            'chipBg'    => 'bg-red-50 text-red-700',
                            'chip'      => 'دعم بسيط قد يصنع فرقاً',
                        ],
                    };
                @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col gap-3">

                    {{-- Badge --}}
                    <div class="flex justify-end">
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-full border
                                     {{ $badgeConfig['bg'] }} {{ $badgeConfig['text'] }} {{ $badgeConfig['border'] }}">
                            {{ $badgeConfig['label'] }}
                        </span>
                    </div>

                    {{-- Course info --}}
                    <div class="space-y-1.5 text-sm text-right">
                        <p class="text-gray-800">
                            <span class="font-black text-gray-900">المادة: </span>{{ $enrollment->course->name }}
                        </p>
                        <p class="text-gray-800">
                            <span class="font-black text-gray-900">مستوى المادة: </span>
                            <span class="font-bold {{ $badgeConfig['levelColor'] }}">{{ $badgeConfig['levelText'] }}</span>
                        </p>
                        <p class="text-gray-600 leading-snug">
                            <span class="font-black text-gray-900">سبب المستوى: </span>{{ $enrollment->level_reason }}
                        </p>
                    </div>

                    {{-- Action chip --}}
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-lg {{ $badgeConfig['chipBg'] }} self-start">
                        {{ $badgeConfig['chip'] }}
                    </span>

                    {{-- CTA --}}
                    <a href="{{ route('course-details', $enrollment->course) }}"
                       class="mt-auto w-full text-center bg-[#1A6B3C] hover:bg-[#155C33] text-white text-sm font-bold py-2.5 rounded-xl transition-colors">
                        عرض التفاصيل
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ══ 5. المسارات المفضلة ══ --}}
        @if($this->savedPaths->isNotEmpty())
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-black text-gray-900">المسارات المفضلة</h2>
                <a href="{{ route('career-future') }}"
                   class="text-sm font-bold text-[#1A6B3C] flex items-center gap-1.5 hover:underline">
                    عرض الكل
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </div>
            <p class="text-sm text-gray-400 text-right mb-5">المسارات التي قمت بحفظها لمتابعتها لاحقاً.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach ($this->savedPaths as $pivot)
                @php $path = $pivot->careerPath; @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-[#F0FAF4] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="font-black text-[#1A6B3C] text-base">{{ $path->name }}</h3>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">{{ $path->description }}</p>
                    <a href="{{ route('career-path-detail', $path) }}"
                       class="block text-center text-sm font-bold text-white bg-[#1A6B3C] hover:bg-[#155C33] py-2.5 rounded-xl transition-colors">
                        استعراض المسار
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Past nominations --}}
        @if($this->pastNominations->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2 flex-row-reverse justify-end">
                <h3 class="font-black text-gray-800 text-sm">سجل الترشيحات</h3>
                <div class="w-6 h-6 rounded-lg bg-gray-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    </svg>
                </div>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($this->pastNominations as $nom)
                <div class="px-6 py-3 flex items-center gap-4">
                    <span class="text-xs font-bold px-3 py-1 rounded-full {{ $nom->status_colors }}">
                        {{ $nom->status_arabic }}
                    </span>
                    <div class="text-right flex-1">
                        <p class="font-bold text-gray-700 text-sm">{{ $nom->event_name }}</p>
                        <p class="text-xs text-gray-400">{{ $nom->event_type_arabic }} · {{ $nom->responded_at?->format('Y/m/d') }}</p>
                    </div>
                    <span class="text-xl">{{ $nom->event_type_icon }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
