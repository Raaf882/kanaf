<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10" x-data>

    {{-- ── Toast ── --}}
    @if($showToast)
    <div x-data="{ show: true }"
         x-init="setTimeout(() => { show = false; $wire.dismissToast(); }, 4000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-end="opacity-0"
         class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-sm font-semibold
                {{ $toastType === 'success' ? 'bg-[#1A6B3C] text-white' : 'bg-gray-700 text-white' }}">
        {{ $toastMessage }}
    </div>
    @endif

    {{-- ── Pending Nominations Banner ── --}}
    @if($this->pendingNominations->count() > 0)
    <div class="space-y-3">
        @foreach($this->pendingNominations as $nom)
        <div class="bg-gradient-to-l from-amber-50 to-yellow-50 border border-amber-200 rounded-2xl p-5 flex items-start gap-4">
            {{-- Icon --}}
            <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center text-2xl flex-shrink-0">
                {{ $nom->event_type_icon }}
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="text-xs font-bold text-amber-700 bg-amber-200 px-2.5 py-0.5 rounded-full">ترشيح جديد ⭐</span>
                    <span class="text-xs text-gray-500 bg-white border border-gray-200 px-2 py-0.5 rounded-full">{{ $nom->event_type_arabic }}</span>
                </div>
                <h3 class="font-bold text-gray-800 text-base">{{ $nom->event_name }}</h3>
                <p class="text-sm text-gray-600 mt-0.5">
                    رشّحك <span class="font-semibold text-gray-700">{{ $nom->advisor->name }}</span> للمشاركة في هذه الفعالية
                </p>
                <div class="flex items-center gap-4 mt-1.5 text-xs text-gray-500 flex-wrap">
                    @if($nom->event_date)
                    <span>📅 {{ $nom->event_date->format('Y/m/d') }}</span>
                    @endif
                    @if($nom->event_location)
                    <span>📍 {{ $nom->event_location }}</span>
                    @endif
                    <span class="text-gray-400">{{ $nom->created_at->diffForHumans() }}</span>
                </div>
                @if($nom->message)
                <div class="mt-2 bg-white border border-amber-200 rounded-xl px-3 py-2 text-sm text-gray-600 italic">
                    "{{ $nom->message }}"
                </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-2 flex-shrink-0">
                <button wire:click="respondNomination({{ $nom->id }}, 'accepted')"
                        class="flex items-center gap-1.5 bg-[#1A6B3C] hover:bg-[#155C33] text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    قبول الترشيح
                </button>
                <button wire:click="respondNomination({{ $nom->id }}, 'rejected')"
                        class="flex items-center gap-1.5 bg-white hover:bg-red-50 text-red-600 border border-red-200 text-xs font-bold px-4 py-2.5 rounded-xl transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    رفض
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ── Past Nominations (accepted/rejected) ── --}}
    @if($this->pastNominations->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="font-bold text-gray-700 text-sm">سجل الترشيحات</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($this->pastNominations as $nom)
            <div class="px-6 py-3 flex items-center gap-4">
                <span class="text-xl">{{ $nom->event_type_icon }}</span>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-700 text-sm">{{ $nom->event_name }}</p>
                    <p class="text-xs text-gray-400">{{ $nom->event_type_arabic }} · {{ $nom->responded_at?->format('Y/m/d') }}</p>
                </div>
                <span class="text-xs font-bold px-3 py-1 rounded-full {{ $nom->status_colors }}">
                    {{ $nom->status_arabic }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900">{{ __('أهلاً') }} {{ auth()->user()->first_name }}</h1>
        <p class="text-gray-400 mt-1.5 text-sm">{{ __('في لوحتك الأكاديمية ستجد ملخصاً واضحاً لوضعك الدراسي الحالي، مع توجيهات تساعدك على تحديد خطواتك التالية.') }}</p>
    </div>

    {{-- Info cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Student info --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider">{{ __('معلومات الطالب') }}</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-xs text-gray-400">{{ __('اسم الطالب') }}</p>
                    <p class="font-semibold text-[#1A6B3C]">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">{{ __('الرقم الجامعي') }}</p>
                    <p class="font-semibold text-[#1A6B3C]">{{ auth()->user()->student_id ?? '441' . str_pad(auth()->id(), 7, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">{{ __('التخصص') }}</p>
                    <p class="font-semibold text-[#1A6B3C]">{{ auth()->user()->major ?? 'علوم حاسب' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">{{ __('المستوى') }}</p>
                    @php
                        $levels = ['', __('الأول'), __('الثاني'), __('الثالث'), __('الرابع'), __('الخامس'), __('السادس'), __('السابع'), __('الثامن')];
                        $lvl = auth()->user()->academic_level ?? 4;
                    @endphp
                    <p class="font-semibold text-[#1A6B3C]">{{ $levels[$lvl] ?? $lvl }}</p>
                </div>
            </div>
        </div>

        {{-- Advisor contact --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider">{{ __('تواصل مع المرشد') }}</h3>
            @if($this->advisor)
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#F0FAF4] flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-[#1A6B3C]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">{{ __('اسم المرشد') }}</p>
                        <p class="font-semibold text-gray-700">{{ $this->advisor->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#F0FAF4] flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">{{ __('رقم المكتب') }}</p>
                        <p class="font-semibold text-gray-700">{{ $this->advisor->job_number ?? '199099' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-[#F0FAF4] flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">{{ __('البريد الإلكتروني') }}</p>
                        <p class="font-semibold text-gray-700">{{ $this->advisor->email }}</p>
                    </div>
                </div>
            </div>
            @else
            <p class="text-sm text-gray-400">{{ __('لم يتم تعيين مرشد أكاديمي بعد.') }}</p>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    <div>
        <h2 class="text-xl font-extrabold text-gray-800 mb-5">{{ __('المستوى الدراسي') }}</h2>
        @php $stats = $this->stats; @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <p class="text-3xl font-extrabold text-gray-800">{{ $stats['improvement'] }}%</p>
                <p class="text-xs text-gray-400 mt-1">{{ __('نسبة التحسن الحالية') }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <div class="w-10 h-10 rounded-xl bg-[#F0FAF4] flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-3xl font-extrabold text-gray-800">{{ $stats['courses'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ __('المواد المجتازة') }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <p class="text-3xl font-extrabold text-gray-800">{{ number_format($stats['gpa'], 1) }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ __('المعدل التراكمي') }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <p class="text-base font-extrabold {{ $stats['status_color'] }} mt-2">{{ $stats['status'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ __('الحالة الأكاديمية') }}</p>
            </div>
        </div>
    </div>

    {{-- ── SAP AI Prediction Card ── --}}
    @php $sap = $this->sapPrediction; @endphp
    <div class="rounded-2xl border shadow-sm p-6
                {{ $sap['available']
                    ? ($sap['risk'] ? 'bg-red-50 border-red-200' : 'bg-emerald-50 border-emerald-200')
                    : 'bg-gray-50 border-gray-100' }}">

        <div class="flex items-start gap-4">
            {{-- Icon --}}
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0
                        {{ $sap['available']
                            ? ($sap['risk'] ? 'bg-red-100' : 'bg-emerald-100')
                            : 'bg-gray-100' }}">
                <svg class="w-6 h-6 {{ $sap['available'] ? ($sap['risk'] ? 'text-red-600' : 'text-emerald-600') : 'text-gray-400' }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>

            {{-- Content --}}
            <div class="flex-1">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <h3 class="font-black text-gray-800 text-base">{{ __('تحليل الذكاء الاصطناعي') }}</h3>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white/70 text-gray-500 border border-gray-200">SAP Model</span>
                </div>

                @if($sap['available'])
                    <p class="text-sm font-semibold {{ $sap['risk'] ? 'text-red-700' : 'text-emerald-700' }} mb-1">
                        {{ $sap['risk']
                            ? 'يشير نموذج الذكاء الاصطناعي إلى احتمالية تدني أكاديمي — يُنصح بمتابعة مرشدك الأكاديمي.'
                            : 'وضعك الأكاديمي مستقر وفق تحليل النموذج، استمر في مسارك الحالي.' }}
                    </p>
                    @if($sap['confidence'])
                        <p class="text-xs text-gray-400">نسبة الثقة في التحليل: <span class="font-bold text-gray-600">{{ $sap['confidence'] }}%</span></p>
                    @endif
                @else
                    <p class="text-sm text-gray-500">
                        {{ __('لا تتوفر بيانات كافية لإجراء تحليل الذكاء الاصطناعي في الوقت الحالي.') }}
                    </p>
                @endif
            </div>

            {{-- Badge --}}
            @if($sap['available'])
                <span class="flex-shrink-0 text-sm font-black px-3 py-1.5 rounded-xl
                             {{ $sap['risk'] ? 'bg-red-600 text-white' : 'bg-emerald-600 text-white' }}">
                    {{ $sap['label'] }}
                </span>
            @endif
        </div>
    </div>

    {{-- Courses --}}
    @if($this->enrollments->isNotEmpty())
    <div>
        <h2 class="text-xl font-extrabold text-gray-800 mb-5">{{ __('مواد هذا الفصل') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($this->enrollments as $enrollment)
            @php
                $badge      = $enrollment->performance_badge;
                $score      = $enrollment->total_score;
                $rec        = $enrollment->kanaf_recommendation;
                $reason     = $enrollment->level_reason;
                $courseLevel = $enrollment->course_level;

                $badgeConfig = match ($badge) {
                    'أداء جيد' => [
                        'label'       => __('أداء مرتفع'),
                        'icon_path'   => 'M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5',
                        'badge_bg'    => 'bg-[#F0FAF4]',
                        'badge_text'  => 'text-[#1A6B3C]',
                        'icon_color'  => 'text-[#1A6B3C]',
                        'level_text'  => 'text-[#1A6B3C]',
                        'action_bg'   => 'bg-[#F0FAF4]',
                        'action_text' => 'text-[#1A6B3C]',
                        'action_label'=> __('تقدم ممتاز في المادة'),
                    ],
                    'أداء متوسط' => [
                        'label'       => __('أداء متوسط'),
                        'icon_path'   => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'badge_bg'    => 'bg-amber-50',
                        'badge_text'  => 'text-amber-600',
                        'icon_color'  => 'text-amber-500',
                        'level_text'  => 'text-amber-600',
                        'action_bg'   => 'bg-amber-50',
                        'action_text' => 'text-amber-700',
                        'action_label'=> __('خطوات بسيطة تقدم أكثر'),
                    ],
                    default => [
                        'label'       => __('يحتاج تحسين'),
                        'icon_path'   => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                        'badge_bg'    => 'bg-red-50',
                        'badge_text'  => 'text-red-600',
                        'icon_color'  => 'text-red-500',
                        'level_text'  => 'text-red-600',
                        'action_bg'   => 'bg-red-50',
                        'action_text' => 'text-red-700',
                        'action_label'=> __('دعم بسيط قد يصنع فرقاً'),
                    ],
                };
            @endphp

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 {{ $badgeConfig['badge_bg'] }} {{ $badgeConfig['badge_text'] }} px-3 py-1.5 rounded-xl">
                        <svg class="w-4 h-4 {{ $badgeConfig['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $badgeConfig['icon_path'] }}"/>
                        </svg>
                        <span class="text-xs font-bold">{{ $badgeConfig['label'] }}</span>
                    </div>
                    <span class="text-sm font-bold text-gray-500">{{ $score }}/100</span>
                </div>

                <div class="space-y-1.5 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">{{ __('المادة') }}</span>
                        <span class="font-semibold text-gray-800">{{ $enrollment->course->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">{{ __('مستوى المادة') }}</span>
                        <span class="font-semibold {{ $badgeConfig['level_text'] }}">{{ $courseLevel }}</span>
                    </div>
                    <div class="flex justify-between items-start gap-2">
                        <span class="text-gray-400 flex-shrink-0">{{ __('سبب المستوى') }}</span>
                        <span class="font-medium text-gray-600 text-right text-xs leading-relaxed">{{ $reason }}</span>
                    </div>
                </div>

                <div class="inline-flex">
                    <span class="{{ $badgeConfig['action_bg'] }} {{ $badgeConfig['action_text'] }} text-xs font-semibold px-3 py-1.5 rounded-lg">
                        {{ $badgeConfig['action_label'] }}
                    </span>
                </div>

                <a href="{{ route('course-details', $enrollment->course) }}"
                   class="w-full text-center bg-[#1A6B3C] hover:bg-[#155C33] text-white text-sm font-bold py-2.5 rounded-xl transition-colors mt-auto">
                    {{ __('عرض التفاصيل') }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Saved career paths --}}
    @if($this->savedPaths->isNotEmpty())
    <div>
        <h2 class="text-xl font-extrabold text-gray-800 mb-1">{{ __('المسارات المفضلة') }}</h2>
        <p class="text-gray-400 text-sm mb-5">{{ __('المسارات التي قمت بحفظها لمتابعتها لاحقاً.') }}</p>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($this->savedPaths as $pivot)
            @php $path = $pivot->careerPath; @endphp
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <h3 class="font-bold text-[#1A6B3C]">{{ $path->name }}</h3>
                </div>
                <p class="text-xs text-gray-500 mb-3 leading-relaxed">{{ $path->description }}</p>
                @if($pivot->is_recommended)
                <p class="text-xs text-amber-600 font-semibold mb-3">
                    {{ __('لماذا يناسبك: لديك أداء جيد في المواد التحليلية، مما يدعم توجهك نحو هذا المسار') }}
                </p>
                @endif
                <a href="{{ route('career-path-detail', $path) }}"
                   class="block text-center text-sm font-bold text-white bg-[#1A6B3C] hover:bg-[#155C33] py-2.5 rounded-xl transition-colors">
                    {{ __('استعراض المسار') }}
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
