<x-layouts.app title="{{ __('رحلتك الأكاديمية') }}">
@php
    $enrollments  = \App\Models\Enrollment::where('user_id', auth()->id())
        ->with('course')
        ->get();
    $totalCourses = $enrollments->count();
    $goodCount    = $enrollments->filter(fn($e) => $e->total_score >= 70)->count();
    $avgScore     = $totalCourses > 0 ? round($enrollments->avg('total_score'), 1) : 0;
    $gpa          = round($avgScore / 100 * 5, 2);
@endphp

{{-- ══ HERO HEADER ══ --}}
<div class="page-hero-strip">
    <div class="page-hero-inner">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-5" dir="rtl">
            <a href="{{ route('home') }}" class="hover:text-[#1A6B3C] transition-colors">{{ __('الرئيسية') }}</a>
            <svg class="w-3.5 h-3.5 text-gray-400 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-800 font-semibold">{{ __('رحلتك الأكاديمية') }}</span>
        </nav>

        {{-- Title row --}}
        <div class="flex items-end justify-between" dir="rtl">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ __('رحلتك الأكاديمية') }}</h1>
                <p class="text-gray-500 text-base">{{ __('تتبع أداءك في جميع المقررات وتوصيات كَـنَـف') }}</p>
            </div>
            @if($totalCourses > 0)
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-2xl px-4 py-2 shadow-sm">
                <svg class="w-4 h-4 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="text-sm font-bold text-gray-700">{{ $totalCourses }} {{ __('مقرر مسجّل') }}</span>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ══ MAIN CONTENT ══ --}}
<div class="page-body" dir="rtl">

    {{-- Stats Row --}}
    @if($totalCourses > 0)
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-[#F0FAF4] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-[#1A6B3C]">{{ $totalCourses }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ __('إجمالي المقررات') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-blue-600">{{ $goodCount }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('مقررات بأداء جيد') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-800">{{ $avgScore }}%</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('المتوسط العام') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-purple-600">{{ $gpa }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('المعدل التراكمي / 5') }}</p>
            </div>
        </div>

    </div>
    @endif

    {{-- Course Grid --}}
    @if($enrollments->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="text-gray-700 font-bold text-lg mb-2">{{ __('لا توجد مقررات مسجلة حتى الآن') }}</p>
            <p class="text-sm text-gray-400">{{ __('تواصل مع مرشدك الأكاديمي للتسجيل في المقررات') }}</p>
        </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($enrollments as $enrollment)
        @php
            $badge = $enrollment->performance_badge;
            $score = $enrollment->total_score;
            $badgeClass = match($badge) {
                'أداء جيد'    => 'badge-good',
                'أداء متوسط' => 'badge-avg',
                default        => 'badge-weak',
            };
            $barColor = match($badge) {
                'أداء جيد'    => '#1A6B3C',
                'أداء متوسط' => '#F59E0B',
                default        => '#EF4444',
            };
            $recKey = $enrollment->kanaf_recommendation ?? '';
            $recommendation = match($recKey) {
                'decision'  => __('يُنصح بمراجعة المرشد الأكاديمي لبحث خيارات الاستمرار في المادة'),
                'guidance'  => __('استمر في مسارك الجيد وطوّر مهاراتك في هذا المجال'),
                'education' => __('يُنصح بمراجعة المحتوى وحضور ساعات المكتب لتحسين درجاتك'),
                default     => '',
            };
            $badgeLabel = match($badge) {
                'أداء جيد'    => __('أداء جيد'),
                'أداء متوسط' => __('أداء متوسط'),
                default        => __('يحتاج تحسين'),
            };
        @endphp
        <a href="{{ route('course-details', $enrollment->course) }}"
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all hover:-translate-y-0.5 block">

            {{-- Header row --}}
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1 min-w-0 pe-3">
                    <h3 class="font-bold text-gray-800 mb-0.5 leading-snug">{{ $enrollment->course->name }}</h3>
                    <p class="text-xs text-gray-400">{{ $enrollment->course->code }} · {{ $enrollment->course->credits }} {{ __('ساعات') }}</p>
                </div>
                <span class="text-xs px-2.5 py-1 rounded-full font-semibold whitespace-nowrap flex-shrink-0 {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </div>

            {{-- Score + bar --}}
            <div class="mb-3">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-xs text-gray-400">{{ __('الدرجة') }}</span>
                    <span class="text-lg font-extrabold text-gray-800">{{ $score }}<span class="text-sm font-normal text-gray-400"> / 100</span></span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all" style="width: {{ min($score, 100) }}%; background:{{ $barColor }};"></div>
                </div>
            </div>

            {{-- Level chip --}}
            @if($enrollment->course_level)
            <div class="mb-3">
                <span class="text-xs bg-gray-100 text-gray-600 rounded-full px-2.5 py-1 font-medium">
                    {{ $enrollment->course_level }}
                </span>
            </div>
            @endif

            {{-- Kanaf recommendation --}}
            @if($recommendation)
            <div class="bg-[#F0FAF4] rounded-xl p-2.5 flex items-start gap-2">
                <svg class="w-4 h-4 text-[#1A6B3C] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                <p class="text-xs text-[#1A6B3C] font-medium leading-relaxed">{{ $recommendation }}</p>
            </div>
            @endif

        </a>
        @endforeach
    </div>
    @endif

</div>
</x-layouts.app>
