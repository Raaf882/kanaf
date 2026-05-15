<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data>

    {{-- ══════════════ TOAST ══════════════ --}}
    @if($showToast)
    <div x-data="{ show: true }"
         x-init="setTimeout(() => { show = false; $wire.dismissToast() }, 4000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-end="opacity-0"
         class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-3 px-5 py-3 rounded-2xl shadow-xl text-sm font-semibold
                {{ $toastType === 'success' ? 'bg-[#1A6B3C] text-white' : 'bg-gray-800 text-white' }}">
        <span>{{ $toastMessage }}</span>
        <button wire:click="dismissToast" class="opacity-60 hover:opacity-100 mr-1">✕</button>
    </div>
    @endif

    {{-- ══════════════ BREADCRUMB + BACK ══════════════ --}}
    <div class="flex items-center justify-between mb-6">
        <button onclick="history.back()"
                class="flex items-center gap-1.5 text-gray-400 hover:text-gray-700 transition-colors text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        <nav class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('academic-journey') }}" class="hover:text-[#1A6B3C] transition-colors">رحلتك الأكاديمية</a>
            <span>›</span>
            <span class="text-gray-700 font-semibold">{{ $course->name }}</span>
            <span>›</span>
            <span class="text-gray-500">تفاصيل المادة</span>
        </nav>
    </div>

    {{-- ══════════════ PAGE TITLE ══════════════ --}}
    <h1 class="text-3xl font-black text-gray-900 mb-8 text-right">{{ $course->name }}</h1>

    @if($enrollment)

    {{-- ══════════════ MAIN GRID ══════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        {{-- ── SIDEBAR: Grade Analysis ── --}}
        <aside class="lg:col-span-1 order-2 lg:order-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5 sticky top-24">

                <h3 class="font-black text-gray-800 text-center text-base border-b border-gray-100 pb-3">تحليل الأداء</h3>

                {{-- Theory --}}
                <div>
                    <p class="text-xs font-black text-gray-500 mb-2.5 text-right">درجات المادة النظرية</p>
                    <ul class="space-y-1.5 text-sm text-gray-700">
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">{{ $enrollment->quiz1_theory }} من 4</span>
                            <span>درجة كويز الفترة الأولى</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">{{ $enrollment->quiz2_theory }} من 4</span>
                            <span>درجة كويز الفترة الثاني</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">{{ $enrollment->quiz3_theory }} من 4</span>
                            <span>درجة كويز الفترة الثالث</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">{{ $enrollment->mid_theory }} من 20</span>
                            <span>درجة اختبار الفترة الأول</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">
                                {{ $enrollment->final_theory > 0 ? $enrollment->final_theory.' من 20' : '—' }}
                            </span>
                            <span>درجة اختبار الفترة الثاني</span>
                        </li>
                    </ul>
                </div>

                <hr class="border-gray-100">

                {{-- Practical --}}
                <div>
                    <p class="text-xs font-black text-gray-500 mb-2.5 text-right">درجات المادة العملية</p>
                    <ul class="space-y-1.5 text-sm text-gray-700">
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">{{ $enrollment->quiz1_practical }} من 4</span>
                            <span>درجة كويز الفترة الأولى</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">{{ $enrollment->quiz2_practical }} من 4</span>
                            <span>درجة كويز الفترة الثاني</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">{{ $enrollment->quiz3_practical }} من 4</span>
                            <span>درجة كويز الفترة الثالث</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">
                                {{ $enrollment->mid_practical > 0 ? $enrollment->mid_practical : '—' }}
                            </span>
                            <span>درجة اختبار الفترة الأول</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="text-gray-400 text-xs font-semibold">
                                {{ $enrollment->final_practical > 0 ? $enrollment->final_practical : '—' }}
                            </span>
                            <span>درجة اختبار الفترة الثاني</span>
                        </li>
                    </ul>
                </div>

                <hr class="border-gray-100">

                <div class="text-center py-1">
                    <span class="text-xs text-gray-400 font-semibold">مجموع الدرجات الحالية</span>
                    <div class="text-2xl font-black text-gray-900 mt-1">
                        {{ $enrollment->total_score }}
                        <span class="text-sm text-gray-400 font-semibold">من 100</span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ── MAIN CONTENT ── --}}
        <main class="lg:col-span-3 order-1 lg:order-2 space-y-5">

            {{-- Performance badge + course info --}}
            @php
                $score   = $enrollment->total_score;
                $badge   = $enrollment->performance_badge;
                $rec     = $enrollment->kanaf_recommendation;

                $badgeStyle = match(true) {
                    $score >= 80 => ['bg'=>'bg-green-50',  'text'=>'text-green-700',  'border'=>'border-green-200', 'icon'=>'✅', 'label'=>'أداء جيد'],
                    $score >= 55 => ['bg'=>'bg-amber-50',  'text'=>'text-amber-700',  'border'=>'border-amber-200', 'icon'=>'⚠️', 'label'=>'بحاجة تحسين'],
                    default      => ['bg'=>'bg-red-50',    'text'=>'text-red-700',    'border'=>'border-red-200',   'icon'=>'🚨', 'label'=>'بحاجة تحسين'],
                };

                $levelColor = match($enrollment->course_level) {
                    'ممتاز','جيد جداً' => 'text-[#1A6B3C]',
                    'جيد'              => 'text-blue-600',
                    'مقبول'            => 'text-amber-600',
                    default            => 'text-amber-600',
                };

                $levelLabel = match($enrollment->course_level) {
                    'ممتاز'    => 'ممتاز',
                    'جيد جداً' => 'جيد جداً',
                    'جيد'      => 'جيد',
                    'مقبول'    => 'بحاجة متابعة',
                    default    => 'بحاجة متابعة',
                };
            @endphp

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                {{-- Top badge --}}
                <div class="flex items-center justify-between mb-5 flex-wrap gap-3">
                    <button wire:click="openModal('guidance')"
                            class="text-xs text-[#1A6B3C] border border-[#1A6B3C]/30 rounded-full px-4 py-1.5 hover:bg-[#F0FAF4] transition-colors font-semibold">
                        دعم بسيط قد يصنع فرقاً
                    </button>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-bold {{ $badgeStyle['bg'] }} {{ $badgeStyle['text'] }} border {{ $badgeStyle['border'] }}">
                        {{ $badgeStyle['icon'] }} {{ $badgeStyle['label'] }}
                    </span>
                </div>

                {{-- Course info --}}
                <div class="space-y-2 text-sm text-right">
                    <p class="text-gray-800">
                        <span class="font-black text-gray-900">المادة: </span>
                        {{ $course->name }}
                    </p>
                    <p class="text-gray-800">
                        <span class="font-black text-gray-900">مستوى المادة: </span>
                        <span class="font-bold {{ $levelColor }}">{{ $levelLabel }}</span>
                    </p>
                    <p class="text-gray-800">
                        <span class="font-black text-gray-900">سبب المستوى: </span>
                        {{ $enrollment->level_reason }}
                    </p>
                </div>
            </div>

            {{-- Stats: 3 cards --}}
            <div class="grid grid-cols-3 gap-4">
                {{-- Tests completed --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                    <div class="w-10 h-10 bg-[#F0FAF4] rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $completedTestsPct }}%</p>
                    <p class="text-xs text-gray-400 mt-1 font-semibold">نسبة الاختبارات المنجزة</p>
                </div>

                {{-- Assignments --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                    <div class="w-10 h-10 bg-[#F0FAF4] rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-black text-gray-900">
                        {{ $completedAssignments }}
                        <span class="text-lg text-gray-400">من{{ $totalAssignments }}</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1 font-semibold">عدد الواجبات المنجزة</p>
                </div>

                {{-- Absence --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                    <div class="w-10 h-10 bg-[#F0FAF4] rounded-xl flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $absenceRate }}%</p>
                    <p class="text-xs text-gray-400 mt-1 font-semibold">نسبة الغياب في المادة</p>
                </div>
            </div>

            {{-- Performance Analysis text --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-right space-y-3">
                <h2 class="text-lg font-black text-gray-900">تحليل الأداء</h2>
                @if($score >= 80)
                    <p class="text-green-700 text-sm leading-relaxed font-medium">
                        أداؤك في هذه المادة ممتاز! استمر في هذا المستوى للحفاظ على نتيجتك النهائية.
                    </p>
                @elseif($score >= 55)
                    <p class="text-amber-700 text-sm leading-relaxed font-medium">
                        يُلاحظ وجود انخفاض في نتائج التقييمات الأخيرة مع انخفاض في نسبة الحضور، مما قد يؤثر على النتيجة النهائية للمادة.
                    </p>
                @else
                    <p class="text-red-700 text-sm leading-relaxed font-medium">
                        يُلاحظ وجود انخفاض ملحوظ في الدرجات مع ارتفاع في نسبة الغياب. يُنصح بالتواصل مع المرشد الأكاديمي فوراً لوضع خطة تحسين.
                    </p>
                @endif
            </div>

            {{-- ══ كنف Options ══ --}}
            <div>
                <h2 class="text-lg font-black text-gray-900 mb-4 text-right">كيف يمكن لكَـنَـف مساعدتك؟</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- كنف التعليم --}}
                    <div class="relative bg-white rounded-2xl border-2 shadow-sm overflow-visible
                                {{ $rec === 'education' ? 'border-[#6B21A8]' : 'border-gray-100' }}">
                        @if($rec === 'education')
                        <div class="absolute -top-3.5 right-4 bg-[#6B21A8] text-white text-xs font-black px-3 py-1 rounded-full">
                            الخيار الأفضل ⭐
                        </div>
                        @endif
                        <div class="p-5 space-y-3">
                            <div class="text-center">
                                <div class="text-2xl mb-1">📚</div>
                                <h3 class="font-black text-gray-900 text-sm">كنف التعليم</h3>
                            </div>
                            <p class="text-xs text-gray-500 text-center leading-relaxed">
                                محتوى تعليمي مبسط يساعدك على فهم أسباب التعثر وتحسين مستواك الأكاديمي
                            </p>
                            <button wire:click="openModal('education')"
                                    class="w-full py-2.5 rounded-xl text-sm font-bold transition-colors
                                           {{ $rec === 'education' ? 'bg-[#6B21A8] text-white hover:bg-[#5b1a96]' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                استعرض المصادر
                            </button>
                        </div>
                    </div>

                    {{-- كنف الإرشاد --}}
                    <div class="relative bg-white rounded-2xl border-2 shadow-sm overflow-visible
                                {{ $rec === 'guidance' ? 'border-[#6B21A8]' : 'border-gray-100' }}">
                        @if($rec === 'guidance')
                        <div class="absolute -top-3.5 right-4 bg-[#6B21A8] text-white text-xs font-black px-3 py-1 rounded-full">
                            الخيار الأفضل ⭐
                        </div>
                        @endif
                        <div class="p-5 space-y-3">
                            <div class="text-center">
                                <div class="text-2xl mb-1">🤝</div>
                                <h3 class="font-black text-gray-900 text-sm">كنف الإرشاد</h3>
                            </div>
                            <p class="text-xs text-gray-500 text-center leading-relaxed">
                                تواصل مع مرشد أكاديمي للحصول على خطة موجهة تناسب حالتك
                            </p>
                            <button wire:click="openModal('guidance')"
                                    class="w-full py-2.5 rounded-xl text-sm font-bold transition-colors
                                           {{ $rec === 'guidance' ? 'bg-[#6B21A8] text-white hover:bg-[#5b1a96]' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                احجز جلسة
                            </button>
                        </div>
                    </div>

                    {{-- كنف القرار --}}
                    <div class="relative bg-white rounded-2xl border-2 shadow-sm overflow-visible
                                {{ $rec === 'decision' ? 'border-[#6B21A8]' : 'border-gray-100' }}">
                        @if($rec === 'decision')
                        <div class="absolute -top-3.5 right-4 bg-[#6B21A8] text-white text-xs font-black px-3 py-1 rounded-full">
                            الخيار الأفضل ⭐
                        </div>
                        @endif
                        <div class="p-5 space-y-3">
                            <div class="text-center">
                                <div class="text-2xl mb-1">🧭</div>
                                <h3 class="font-black text-gray-900 text-sm">كنف القرار</h3>
                            </div>
                            <p class="text-xs text-gray-500 text-center leading-relaxed">
                                استعرض أثر قراراتك الأكاديمية مثل الانسحاب أو الاستمرار
                            </p>
                            <button wire:click="openModal('decision')"
                                    class="w-full py-2.5 rounded-xl text-sm font-bold transition-colors
                                           {{ $rec === 'decision' ? 'bg-[#6B21A8] text-white hover:bg-[#5b1a96]' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                جرّب القرار قبل تنفيذه
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>

    @else
    {{-- No enrollment --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
        <div class="text-5xl mb-4">📭</div>
        <p class="text-gray-500 font-semibold">لا يوجد تسجيل في هذه المادة.</p>
        <a href="{{ route('academic-journey') }}" class="mt-4 inline-block text-[#1A6B3C] font-bold hover:underline text-sm">
            العودة لرحلتك الأكاديمية
        </a>
    </div>
    @endif


    {{-- ═══════════════════════════════════════════════════════════
         MODAL: كنف الإرشاد — Guidance / Book a Session
    ═══════════════════════════════════════════════════════════ --}}
    @if($activeModal === 'guidance')
    <div class="fixed inset-0 z-50 flex items-start justify-center bg-black/40 backdrop-blur-sm overflow-y-auto py-10"
         wire:click.self="closeModal">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <button wire:click="closeModal"
                        class="flex items-center gap-1.5 text-gray-400 hover:text-gray-700 text-sm font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    اغلاق
                </button>
                <div class="text-right">
                    <h2 class="text-xl font-black text-gray-900">كنف الإرشاد</h2>
                    <p class="text-sm text-gray-400 mt-0.5">تواصل مع مرشد أكاديمي للحصول على خطة موجهة تناسب حالتك</p>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-5">

                {{-- Advisor info (readonly) --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-right">
                        <label class="block text-sm font-black text-gray-700 mb-1.5">
                            اسم المرشد <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               value="{{ $advisor?->name ?? 'غير محدد' }}"
                               readonly
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 text-right cursor-not-allowed">
                    </div>
                    <div class="text-right">
                        <label class="block text-sm font-black text-gray-700 mb-1.5">
                            البريد الالكتروني للمرشد <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               value="{{ $advisor?->email ?? 'غير محدد' }}"
                               readonly
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 text-right cursor-not-allowed">
                    </div>
                </div>

                {{-- Session type + DateTime --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-right">
                        <label class="block text-sm font-black text-gray-700 mb-1.5">
                            وقت / تاريخ الجلسة <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local"
                               wire:model="bookDateTime"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right
                                      focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 focus:border-[#1A6B3C]
                                      @error('bookDateTime') border-red-400 @enderror">
                        @error('bookDateTime')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="text-right">
                        <label class="block text-sm font-black text-gray-700 mb-1.5">
                            نوع الجلسة <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="bookSessionType"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right
                                       focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 focus:border-[#1A6B3C] bg-white">
                            <option value="academic">إرشاد أكاديمي</option>
                            <option value="career">إرشاد مهني</option>
                            <option value="personal">دعم شخصي</option>
                            <option value="follow_up">متابعة دورية</option>
                        </select>
                    </div>
                </div>

                {{-- Reason --}}
                <div class="text-right">
                    <label class="block text-sm font-black text-gray-700 mb-1.5">سبب الجلسة</label>
                    <textarea wire:model="bookReason"
                              rows="4"
                              placeholder="اكتب سبب طلب الجلسة أو ما تريد مناقشته..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-right resize-none
                                     focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 focus:border-[#1A6B3C]
                                     placeholder:text-gray-300"></textarea>
                </div>

                {{-- Submit --}}
                <div class="flex justify-start">
                    <button wire:click="bookSession" wire:loading.attr="disabled"
                            class="flex items-center gap-2 bg-[#1A6B3C] hover:bg-[#155e34] text-white font-bold px-8 py-3 rounded-xl transition-colors disabled:opacity-60">
                        <span wire:loading.remove wire:target="bookSession">إرسال</span>
                        <span wire:loading wire:target="bookSession">جاري الإرسال...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif


    {{-- ═══════════════════════════════════════════════════════════
         MODAL: كنف التعليم — Educational Resources
    ═══════════════════════════════════════════════════════════ --}}
    @if($activeModal === 'education')
    <div class="fixed inset-0 z-50 flex items-start justify-center bg-black/40 backdrop-blur-sm overflow-y-auto py-10"
         wire:click.self="closeModal">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl mx-4 overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <button wire:click="closeModal"
                        class="flex items-center gap-1.5 text-gray-400 hover:text-gray-700 text-sm font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    اغلاق
                </button>
                <div class="text-right">
                    <h2 class="text-xl font-black text-gray-900">كنف التعليم</h2>
                    <p class="text-sm text-gray-400 mt-0.5">مصادر ومحتوى تعليمي مقترح لمساعدتك على تحسين فهم المادة وتعزيز مستواك الأكاديمي</p>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-8">

                {{-- Video section --}}
                <div>
                    <h3 class="font-black text-gray-900 text-base mb-4 text-right">المقاطع التعليمية</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach([
                            ['title'=>'فيديو قصير يساعدك على مراجعة المفاهيم الأساسية.',
                             'sub'=>'مقطع مبسط يشرح مفاهيم الخوارزميات وهياكل البيانات بطريقة سهلة وتفاعلية'],
                            ['title'=>'فيديو قصير يساعدك على مراجعة المفاهيم الأساسية.',
                             'sub'=>'مقطع مبسط يشرح مفاهيم الخوارزميات وهياكل البيانات بطريقة سهلة وتفاعلية'],
                            ['title'=>'فيديو قصير يساعدك على مراجعة المفاهيم الأساسية.',
                             'sub'=>'مقطع مبسط يشرح مفاهيم الخوارزميات وهياكل البيانات بطريقة سهلة وتفاعلية'],
                        ] as $video)
                        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                            {{-- Thumbnail --}}
                            <div class="bg-gray-100 h-28 flex items-center justify-center relative">
                                <button class="w-12 h-12 rounded-full bg-[#1A6B3C] flex items-center justify-center shadow-lg hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </button>
                            </div>
                            {{-- Info --}}
                            <div class="p-3 text-right space-y-1.5">
                                <p class="text-xs font-bold text-gray-800 leading-snug">{{ $video['title'] }}</p>
                                <p class="text-xs text-gray-400 leading-relaxed">{{ $video['sub'] }}</p>
                                <button class="w-full bg-[#1A6B3C] hover:bg-[#155e34] text-white text-xs font-bold py-2 rounded-lg transition-colors mt-1">
                                    مشاهدة المقطع
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Summaries --}}
                <div>
                    <h3 class="font-black text-gray-900 text-base mb-4 text-right">ملخصات المادة</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['ملخص الخوارزميات','ملخص الاختبارات القصيرة','ملخص أهم المفاهيم'] as $summary)
                        <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm text-right flex items-center justify-between hover:border-[#1A6B3C]/30 hover:bg-[#F0FAF4] transition-colors cursor-pointer group">
                            <button class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 group-hover:border-[#1A6B3C] group-hover:text-[#1A6B3C] transition-colors flex-shrink-0">
                                <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            <span class="font-bold text-sm text-gray-800">{{ $summary }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Back button --}}
                <div class="flex justify-start">
                    <button wire:click="closeModal"
                            class="flex items-center gap-2 bg-[#1A6B3C] hover:bg-[#155e34] text-white font-bold px-6 py-2.5 rounded-xl transition-colors text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        العودة لتفاصيل المادة
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif


    {{-- ═══════════════════════════════════════════════════════════
         MODAL: كنف القرار — Decision Simulation
    ═══════════════════════════════════════════════════════════ --}}
    @if($activeModal === 'decision')
    <div class="fixed inset-0 z-50 flex items-start justify-center bg-black/40 backdrop-blur-sm overflow-y-auto py-10"
         wire:click.self="closeModal">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <button wire:click="closeModal"
                        class="flex items-center gap-1.5 text-gray-400 hover:text-gray-700 text-sm font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    اغلاق
                </button>
                <div class="text-right">
                    <h2 class="text-xl font-black text-gray-900">كنف القرار</h2>
                    <p class="text-sm text-gray-400 mt-0.5">استعرض أثر قراراتك الأكاديمية قبل تنفيذها</p>
                </div>
            </div>

            <div class="p-6 space-y-6">

                {{-- Course summary --}}
                <div class="bg-gray-50 rounded-2xl p-4 text-right space-y-1 border border-gray-100">
                    <p class="text-sm font-black text-gray-700">{{ $course->name }}</p>
                    @if($enrollment)
                    <p class="text-xs text-gray-400">
                        درجتك الحالية:
                        <span class="font-bold text-gray-700">{{ $enrollment->total_score }}/100</span>
                        — مستوى: <span class="font-bold {{ $levelColor ?? 'text-amber-600' }}">{{ $levelLabel ?? 'بحاجة متابعة' }}</span>
                    </p>
                    @endif
                </div>

                {{-- Choose decision --}}
                <p class="text-sm font-black text-gray-700 text-right">اختر القرار الذي تفكر فيه:</p>
                <div class="grid grid-cols-2 gap-4">

                    {{-- Withdraw --}}
                    <button wire:click="chooseDecision('withdraw')"
                            class="text-right p-5 rounded-2xl border-2 transition-all
                                   {{ $decisionChoice === 'withdraw'
                                      ? 'border-red-400 bg-red-50'
                                      : 'border-gray-200 hover:border-red-300 hover:bg-red-50/50' }}">
                        <div class="text-2xl mb-2">🚪</div>
                        <h3 class="font-black text-gray-900 text-sm mb-1">الانسحاب من المادة</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">سحب تسجيلك من المادة هذا الفصل</p>
                    </button>

                    {{-- Continue --}}
                    <button wire:click="chooseDecision('continue')"
                            class="text-right p-5 rounded-2xl border-2 transition-all
                                   {{ $decisionChoice === 'continue'
                                      ? 'border-[#1A6B3C] bg-[#F0FAF4]'
                                      : 'border-gray-200 hover:border-[#1A6B3C]/40 hover:bg-[#F0FAF4]/50' }}">
                        <div class="text-2xl mb-2">📖</div>
                        <h3 class="font-black text-gray-900 text-sm mb-1">الاستمرار في المادة</h3>
                        <p class="text-xs text-gray-400 leading-relaxed">المضي قُدُماً والتحسين في الفترة المتبقية</p>
                    </button>
                </div>

                {{-- Result: Withdraw --}}
                @if($decisionChoice === 'withdraw' && $enrollment)
                @php
                    $gpaWithout = round(
                        ($enrollment->total_score >= 90 ? 5 :
                        ($enrollment->total_score >= 80 ? 4.75 :
                        ($enrollment->total_score >= 75 ? 4.5 :
                        ($enrollment->total_score >= 70 ? 4 :
                        ($enrollment->total_score >= 65 ? 3.5 :
                        ($enrollment->total_score >= 60 ? 3 :
                        ($enrollment->total_score >= 55 ? 2.5 :
                        ($enrollment->total_score >= 50 ? 2 : 0)))))))),
                    2);
                @endphp
                <div class="bg-red-50 border border-red-200 rounded-2xl p-5 text-right space-y-3">
                    <h3 class="font-black text-red-700 flex items-center gap-2 justify-end">
                        نتيجة الانسحاب
                        <span>🔴</span>
                    </h3>
                    <ul class="space-y-1.5 text-sm text-gray-700">
                        <li class="flex items-center gap-2 justify-end">
                            <span>ستُسجَّل المادة برمز <strong>W</strong> في سجلاتك</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                        </li>
                        <li class="flex items-center gap-2 justify-end">
                            <span>درجة الـ GPA لهذه المادة: <strong class="text-red-600">0 نقطة</strong></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                        </li>
                        <li class="flex items-center gap-2 justify-end">
                            <span>ستحتاج إعادة تسجيل المادة في الفصل القادم</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                        </li>
                        <li class="flex items-center gap-2 justify-end">
                            <span>ستخسر الساعات المعتمدة ({{ $course->credits ?? 3 }} ساعات)</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                        </li>
                    </ul>
                    <div class="pt-2 border-t border-red-200">
                        <p class="text-xs text-red-600 font-semibold">💡 توصية: راجع مرشدك الأكاديمي قبل اتخاذ هذا القرار.</p>
                    </div>
                </div>
                @endif

                {{-- Result: Continue --}}
                @if($decisionChoice === 'continue' && $enrollment)
                @php
                    $currentScore = $enrollment->total_score;
                    $hasExams = $enrollment->final_theory === 0 || $enrollment->final_practical === 0;
                    $remainingMax = 0;
                    if ($enrollment->final_theory === 0) $remainingMax += 20;
                    if ($enrollment->final_practical === 0) $remainingMax += 20;
                    $bestCase = min(100, $currentScore + $remainingMax);
                    $realisticCase = min(100, $currentScore + round($remainingMax * 0.7));
                @endphp
                <div class="bg-[#F0FAF4] border border-green-200 rounded-2xl p-5 text-right space-y-3">
                    <h3 class="font-black text-[#1A6B3C] flex items-center gap-2 justify-end">
                        توقعات الاستمرار
                        <span>🟢</span>
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white rounded-xl p-3 text-center border border-green-100">
                            <div class="text-2xl font-black text-[#1A6B3C]">{{ $bestCase }}</div>
                            <div class="text-xs text-gray-400 font-semibold mt-1">أفضل حالة / 100</div>
                        </div>
                        <div class="bg-white rounded-xl p-3 text-center border border-green-100">
                            <div class="text-2xl font-black text-amber-600">{{ $realisticCase }}</div>
                            <div class="text-xs text-gray-400 font-semibold mt-1">التوقع الواقعي / 100</div>
                        </div>
                    </div>
                    <ul class="space-y-1.5 text-sm text-gray-700">
                        <li class="flex items-center gap-2 justify-end">
                            <span>الدرجات المتبقية المتاحة: <strong>{{ $remainingMax }} نقطة</strong></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-[#1A6B3C] flex-shrink-0"></span>
                        </li>
                        @if($realisticCase >= 60)
                        <li class="flex items-center gap-2 justify-end">
                            <span class="text-green-700 font-semibold">✅ بإمكانك اجتياز المادة مع التركيز في الفترة المتبقية</span>
                        </li>
                        @else
                        <li class="flex items-center gap-2 justify-end">
                            <span class="text-amber-700 font-semibold">⚠️ تحتاج تحسناً ملحوظاً للوصول لدرجة النجاح</span>
                        </li>
                        @endif
                    </ul>
                    <div class="pt-2 border-t border-green-200">
                        <p class="text-xs text-[#1A6B3C] font-semibold">💡 توصية: احجز جلسة مع مرشدك لوضع خطة تحسين فعّالة.</p>
                    </div>
                </div>
                @endif

                {{-- Action buttons --}}
                @if($decisionChoice)
                <div class="flex gap-3 justify-start">
                    @if($decisionChoice === 'continue')
                    <button wire:click="openModal('guidance')"
                            class="flex items-center gap-2 bg-[#1A6B3C] text-white font-bold px-5 py-2.5 rounded-xl text-sm hover:bg-[#155e34] transition-colors">
                        🤝 احجز جلسة إرشاد
                    </button>
                    @endif
                    <button wire:click="closeModal"
                            class="flex items-center gap-2 bg-gray-100 text-gray-700 font-bold px-5 py-2.5 rounded-xl text-sm hover:bg-gray-200 transition-colors">
                        إغلاق
                    </button>
                </div>
                @endif

            </div>
        </div>
    </div>
    @endif

</div>
