<x-layouts.app title="{{ __('رحلتك الأكاديمية') }}">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-[#1A6B3C]">{{ __('الرئيسية') }}</a>
        <span>›</span>
        <span class="text-gray-800 font-medium">{{ __('رحلتك الأكاديمية') }}</span>
    </nav>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">{{ __('رحلتك الأكاديمية') }}</h1>
            <p class="text-gray-500 text-sm">{{ __('تتبع أداءك في جميع المقررات وتوصيات كَـنَـف') }}</p>
        </div>
    </div>

    @php
        $enrollments = \App\Models\Enrollment::where('user_id', auth()->id())
            ->with('course')
            ->get();

        $totalCourses = $enrollments->count();
        $goodCount    = $enrollments->filter(fn($e) => $e->total_score >= 70)->count();
        $avgScore     = $totalCourses > 0 ? round($enrollments->avg('total_score'), 1) : 0;
        $gpa          = round($avgScore / 100 * 5, 2);
    @endphp

    @if($totalCourses > 0)
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <p class="text-3xl font-extrabold text-[#1A6B3C]">{{ $totalCourses }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ __('إجمالي المقررات') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <p class="text-3xl font-extrabold text-blue-600">{{ $goodCount }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ __('مقررات بأداء جيد') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <p class="text-3xl font-extrabold text-gray-800">{{ $avgScore }}%</p>
            <p class="text-xs text-gray-500 mt-1">{{ __('المتوسط العام') }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
            <p class="text-3xl font-extrabold text-purple-600">{{ $gpa }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ __('المعدل التراكمي / 5') }}</p>
        </div>
    </div>
    @endif

    @if($enrollments->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-gray-500 font-medium">{{ __('لا توجد مقررات مسجلة حتى الآن') }}</p>
            <p class="text-sm text-gray-400 mt-1">{{ __('تواصل مع مرشدك الأكاديمي للتسجيل في المقررات') }}</p>
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
                'أداء جيد'    => 'bg-[#1A6B3C]',
                'أداء متوسط' => 'bg-yellow-400',
                default        => 'bg-red-400',
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

            <div class="flex items-start justify-between mb-3">
                <div class="flex-1 min-w-0 pe-3">
                    <h3 class="font-bold text-gray-800 truncate">{{ $enrollment->course->name }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $enrollment->course->code }} • {{ $enrollment->course->credits }} {{ __('ساعات') }}</p>
                </div>
                <span class="text-xs px-2.5 py-1 rounded-full font-semibold whitespace-nowrap flex-shrink-0 {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </div>

            <div class="w-full bg-gray-100 rounded-full h-2.5 mb-3">
                <div class="{{ $barColor }} h-2.5 rounded-full transition-all" style="width: {{ min($score, 100) }}%"></div>
            </div>

            <div class="flex items-center justify-between mb-3">
                <p class="text-lg font-extrabold text-gray-800">{{ $score }}<span class="text-sm font-normal text-gray-400"> / 100</span></p>
                @if($enrollment->course_level)
                    <span class="text-xs bg-gray-100 text-gray-600 rounded-full px-2.5 py-1 font-medium">
                        {{ $enrollment->course_level }}
                    </span>
                @endif
            </div>

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
