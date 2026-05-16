<div x-data>

{{-- ══ TOAST ══ --}}
@if($showToast)
<div x-data="{ show: true }"
     x-init="setTimeout(() => { show = false; $wire.dismissToast(); }, 4000)"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-end="opacity-0"
     class="fixed top-20 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-sm font-bold bg-[#1A6B3C] text-white">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
    </svg>
    {{ $toastMessage }}
    <button wire:click="dismissToast" class="opacity-60 hover:opacity-100 me-1">✕</button>
</div>
@endif

<div class="page-body space-y-10">

{{-- ══════════════════════════════════════════
     SECTION 1: HEADER + ADVISOR INFO
══════════════════════════════════════════ --}}
<div dir="rtl">
    {{-- Hero greeting --}}
    <div style="background:linear-gradient(135deg,#1A6B3C 0%,#2d8a54 100%); border-radius:20px; padding:28px 32px; color:#fff; display:flex; align-items:flex-start; justify-content:space-between; gap:20px; flex-wrap:wrap; align-items:center;">
        <div>
            <p style="font-size:0.85rem; opacity:0.8; margin-bottom:4px;">لوحة تحكم المرشد الأكاديمي</p>
            <h1 style="font-size:1.75rem; font-weight:900; margin:0 0 6px;">أهلاً {{ auth()->user()->first_name }} 👋</h1>
            <p style="font-size:0.87rem; opacity:0.85;">وجودك يصنع فرقاً في رحلة الطلاب الأكاديمية. أدارة متابعة طلابك اليوم.</p>
        </div>
        {{-- Advisor info grid --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; text-align:end; flex-shrink:0; max-width:360px; width:100%;">
            @php
                $user = auth()->user();
                $infoItems = [
                    ['label' => 'اسم المرشد',       'value' => $user->name ?? $user->first_name],
                    ['label' => 'القسم الأكاديمي',   'value' => $user->department ?? 'قسم علوم الحاسب'],
                    ['label' => 'الرقم الوظيفي',    'value' => $user->job_number ?? '4411111111'],
                    ['label' => 'اللقب الأكاديمي',  'value' => $user->title ?? 'أستاذ مساعد'],
                    ['label' => 'الكلية',            'value' => $user->college ?? 'كلية الحاسب'],
                    ['label' => 'الكلية العلمية',   'value' => $user->faculty ?? 'كلية علوم الحاسب والمعلومات'],
                ];
            @endphp
            @foreach($infoItems as $item)
            <div style="background:rgba(255,255,255,0.15); border-radius:10px; padding:7px 14px; font-size:0.8rem;">
                <span style="opacity:0.7; display:block; font-size:0.72rem; margin-bottom:1px;">{{ $item['label'] }}</span>
                <span style="font-weight:700;">{{ $item['value'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     SECTION 2: ملخص اليوم
══════════════════════════════════════════ --}}
<div dir="rtl">
    <h2 class="text-2xl font-black text-gray-900 mb-4 text-right">ملخص اليوم</h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        @php
            $todayCount       = $this->todaySessions->count();
            $totalCount       = $this->students->count();
            $outstandingCount = $this->outstandingStudents->count();
            $criticalCount    = $this->criticalStudents->count();
        @endphp

        {{-- Today sessions --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-[#F0FAF4] rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-3xl font-black text-gray-900">{{ $todayCount }}</p>
            <p class="text-sm text-gray-400 mt-1 font-semibold leading-snug">لديك جلسات مجدولة لهذا اليوم</p>
            <button onclick="document.getElementById('sessions')?.scrollIntoView({behavior:'smooth'})"
                    class="mt-3 w-full text-sm font-bold py-2 rounded-lg bg-[#1A6B3C] text-white hover:bg-[#155e34] transition-colors">
                عرض الجلسات
            </button>
        </div>

        {{-- Total students --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-black text-gray-900">{{ $totalCount }}</p>
            <p class="text-sm text-gray-400 mt-1 font-semibold leading-snug">استعراض الطلاب المسجلين تحت إشرافك</p>
            <button onclick="document.getElementById('students-tracking')?.scrollIntoView({behavior:'smooth'})"
                    class="mt-3 w-full text-sm font-bold py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition-colors">
                عرض الطلاب
            </button>
        </div>

        {{-- Outstanding --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <p class="text-3xl font-black text-gray-900">{{ $outstandingCount }}</p>
            <p class="text-sm text-gray-400 mt-1 font-semibold leading-snug">طلاب مرشحون لفرص أكاديمية ومهنية</p>
            <button onclick="document.getElementById('outstanding-students')?.scrollIntoView({behavior:'smooth'})"
                    class="mt-3 w-full text-sm font-bold py-2 rounded-lg bg-amber-500 text-white hover:bg-amber-600 transition-colors">
                عرض الطلاب
            </button>
        </div>

        {{-- Critical --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-black text-gray-900">{{ $criticalCount }}</p>
            <p class="text-sm text-gray-400 mt-1 font-semibold leading-snug">تم رصد حالات تحتاج متابعة أكاديمية عاجل</p>
            <button onclick="document.getElementById('critical-students')?.scrollIntoView({behavior:'smooth'})"
                    class="mt-3 w-full text-sm font-bold py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition-colors">
                عرض الطلاب
            </button>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     AI SUMMARY: SAP Prediction Overview
══════════════════════════════════════════ --}}
@php
    $sapAtRisk  = $this->students->filter(fn($s) => $s['sap_risk'] === true)->count();
    $sapScanned = $this->students->filter(fn($s) => $s['sap_prediction'] !== null)->count();
    $sapTotal   = $this->students->count();
@endphp
@if($sapScanned > 0)
<div class="bg-gradient-to-l from-violet-50 to-indigo-50 border border-indigo-100 rounded-2xl p-5">
    <div class="flex items-center gap-3 mb-4">
        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
        </div>
        <div>
            <h3 class="font-black text-gray-800 text-lg">تحليل الذكاء الاصطناعي — SAP Model</h3>
            <p class="text-sm text-gray-500">فحص احتمالية التدني الأكاديمي لطلابك</p>
        </div>
        <span class="mr-auto text-sm font-bold px-3 py-1 rounded-full bg-indigo-100 text-indigo-700">
            تم فحص {{ $sapScanned }} من {{ $sapTotal }}
        </span>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-xl p-4 text-center border border-red-100">
            <p class="text-3xl font-black text-red-600">{{ $sapAtRisk }}</p>
            <p class="text-sm text-gray-500 mt-1">طلاب في خطر تدني (AI)</p>
        </div>
        <div class="bg-white rounded-xl p-4 text-center border border-emerald-100">
            <p class="text-3xl font-black text-emerald-600">{{ $sapScanned - $sapAtRisk }}</p>
            <p class="text-sm text-gray-500 mt-1">طلاب بأداء مستقر (AI)</p>
        </div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════
     SECTION 3: الطلاب الأكثر احتياجاً للدعم
══════════════════════════════════════════ --}}
<div id="critical-students">
    <div class="mb-5 text-right">
        <h2 class="text-2xl font-black text-gray-900">الطلاب الأكثر احتياجاً للدعم</h2>
        <p class="text-base text-gray-400 mt-1">طلاب تم رصد مؤشرات أكاديمية تستدعي التدخل والمتابعة المبكرة.</p>
    </div>

    @if($this->criticalStudents->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-400">
        <div class="text-4xl mb-3">✅</div>
        <p class="font-semibold">لا يوجد طلاب في خانة الخطر حالياً</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($this->criticalStudents->take(6) as $s)
        @include('livewire.advisor.partials.student-card', ['student' => $s, 'type' => 'critical'])
        @endforeach
    </div>
    @endif
</div>

{{-- ══════════════════════════════════════════
     SECTION 4: الطلاب المتميزون
══════════════════════════════════════════ --}}
<div id="outstanding-students">
    <div class="mb-5 text-right">
        <h2 class="text-2xl font-black text-gray-900">الطلاب المتميزون</h2>
        <p class="text-base text-gray-400 mt-1">طلاب أظهروا أداءً متميزاً ولم تُراعَ لهم الفرص الأكاديمية أو المهنية المناسبة.</p>
    </div>

    @if($this->outstandingStudents->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-400">
        <div class="text-4xl mb-3">📊</div>
        <p class="font-semibold">لا يوجد طلاب متميزون في الوقت الحالي</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($this->outstandingStudents->take(6) as $s)
        @include('livewire.advisor.partials.student-card', ['student' => $s, 'type' => 'outstanding'])
        @endforeach
    </div>
    @endif
</div>

{{-- ══════════════════════════════════════════
     SECTION 5: متابعة الطلاب (accordion)
══════════════════════════════════════════ --}}
<div id="students-tracking">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-2xl font-black text-gray-900">متابعة الطلاب</h2>
        <div class="relative">
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="بحث عن طالب..."
                   class="text-sm border border-gray-200 rounded-xl px-4 py-2 text-right focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 w-52">
        </div>
    </div>
    <p class="text-sm text-gray-400 text-right mb-4">تابع أداء طلابك وتمكّن من متابعة كل فرد بشكل مفصّل في كل مستوى دراسي.</p>

    <div class="space-y-3">
        @foreach($this->studentsByLevel as $level => $students)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- Accordion header --}}
            <button wire:click="toggleLevel({{ $level }})"
                    class="w-full flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400 transition-transform {{ $expandedLevel === $level ? 'rotate-180' : '' }}"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    <span class="text-sm text-gray-400 font-semibold">{{ $students->count() }} طالب</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-black text-gray-800">طلاب المستوى {{ $level }}</span>
                </div>
            </button>

            {{-- Accordion body --}}
            @if($expandedLevel === $level)
            <div class="border-t border-gray-100 p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($students as $s)
                    @include('livewire.advisor.partials.student-card', ['student' => $s, 'type' => $s['status']])
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endforeach

        @if($this->studentsByLevel->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center text-gray-400">
            <p class="font-semibold">لا توجد نتائج للبحث</p>
        </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════
     SECTION 6: الجلسات
══════════════════════════════════════════ --}}
<div id="sessions">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-2xl font-black text-gray-900">الجلسات</h2>
        <button wire:click="openBooking()"
                class="flex items-center gap-2 bg-[#1A6B3C] text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-[#155e34] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            حجز جلسة جديدة
        </button>
    </div>
    <p class="text-base text-gray-400 text-right mb-4">استعرض الجلسات الأخيرة وتمكّن من متابعة حالة كل جلسة وحضور الطلاب.</p>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($this->recentSessions->isEmpty())
        <div class="p-10 text-center text-gray-400">
            <div class="text-4xl mb-3">📅</div>
            <p class="font-semibold">لا توجد جلسات مسجلة بعد</p>
            <button wire:click="openBooking()" class="mt-3 text-[#1A6B3C] text-sm font-bold hover:underline">
                احجز أول جلسة
            </button>
        </div>
        @else
        <div class="overflow-x-auto" style="scroll-padding-inline-start:16px;">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-right px-4 py-3 text-sm font-black text-gray-500">الرقم الجامعي</th>
                        <th class="text-right px-4 py-3 text-sm font-black text-gray-500">الطالب</th>
                        <th class="text-right px-4 py-3 text-sm font-black text-gray-500">وقت الجلسة</th>
                        <th class="text-right px-4 py-3 text-sm font-black text-gray-500">نوع الجلسة</th>
                        <th class="text-right px-4 py-3 text-sm font-black text-gray-500">الحالة</th>
                        <th class="text-right px-4 py-3 text-sm font-black text-gray-500">الحضور</th>
                        <th class="text-left px-4 py-3 text-sm font-black text-gray-500">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($this->recentSessions as $session)
                    <tr class="hover:bg-gray-50 transition-colors">
                        {{-- Student ID --}}
                        <td class="px-4 py-3.5 text-right text-gray-500 font-mono text-xs">
                            {{ $session->student?->student_id ?? '—' }}
                        </td>
                        {{-- Student name --}}
                        <td class="px-4 py-3.5 text-right font-bold text-gray-800">
                            {{ $session->student?->name ?? '—' }}
                        </td>
                        {{-- Time --}}
                        <td class="px-4 py-3.5 text-right text-gray-500 text-xs">
                            {{ $session->session_at?->format('d/m/Y') }}
                        </td>
                        {{-- Session type --}}
                        <td class="px-4 py-3.5 text-right text-gray-600 font-medium">
                            {{ $session->session_type_arabic }}
                        </td>
                        {{-- Status --}}
                        <td class="px-4 py-3.5 text-right">
                            @php
                                $sc = match($session->status) {
                                    'confirmed'   => 'bg-green-50 text-green-700',
                                    'unconfirmed' => 'bg-amber-50 text-amber-700',
                                    'postponed'   => 'bg-red-50 text-red-700',
                                    default       => 'bg-gray-100 text-gray-600',
                                };
                                $sl = match($session->status) {
                                    'confirmed'   => 'تم التأكيد',
                                    'unconfirmed' => 'قائمة',
                                    'postponed'   => 'مؤجلة',
                                    default       => $session->status,
                                };
                            @endphp
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $sc }}">{{ $sl }}</span>
                        </td>
                        {{-- Attendance --}}
                        <td class="px-4 py-3.5 text-right">
                            @if($session->attended === true)
                                <span class="text-xs font-bold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">حاضر</span>
                            @elseif($session->attended === false)
                                <span class="text-xs font-bold text-red-600 bg-red-50 px-2.5 py-1 rounded-full">غائب</span>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        {{-- Actions --}}
                        <td class="px-4 py-3.5 text-left">
                            <button wire:click="openRating({{ $session->id }})"
                                    class="text-xs font-bold px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 transition-colors whitespace-nowrap">
                                تقييم الجلسة
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 flex justify-start">
            <button wire:click="openBooking()"
                    class="flex items-center gap-1.5 text-[#1A6B3C] text-xs font-bold hover:underline">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                حجز جلسة جديدة
            </button>
        </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════════════
     SECTION 7: الترشيحات
══════════════════════════════════════════ --}}
<div id="nominations">
    <h2 class="text-2xl font-black text-gray-900 text-right mb-5">الترشيحات</h2>
    <p class="text-base text-gray-400 text-right mb-6">
        يتيح هذا القسم للمرشد إرسال ترشيحات إلى الطلاب حول فرص أكاديمية أو مهنية مناسبة للطالب.
    </p>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="space-y-5">

            {{-- Row 1: اسم الطالب (right) + الرقم الجامعي (left) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Student selector (first = rightmost in RTL) --}}
                <div class="text-right">
                    <label class="block text-sm font-black text-gray-600 mb-1.5">
                        اسم الطالب <span class="text-red-500">*</span>
                    </label>
                    <select wire:model.live="formStudentId"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 focus:border-[#1A6B3C]
                                   @error('formStudentId') border-red-400 @enderror">
                        <option value="">اختر الطالب...</option>
                        @foreach($this->allStudents as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                        @endforeach
                    </select>
                    @error('formStudentId')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Student ID (second = leftmost in RTL, readonly) --}}
                <div class="text-right">
                    <label class="block text-sm font-black text-gray-600 mb-1.5">الرقم الجامعي</label>
                    <input type="text"
                           readonly
                           value="{{ $formStudentId ? ($this->allStudents->firstWhere('id', $formStudentId)?->student_id ?? '—') : '' }}"
                           placeholder="يُملأ تلقائياً عند اختيار الطالب"
                           class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right cursor-not-allowed text-gray-500">
                </div>
            </div>

            {{-- Row 2: نوع الفعالية (right) + الجهة المنظمة (left) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Event type (first = rightmost in RTL) --}}
                <div class="text-right">
                    <label class="block text-sm font-black text-gray-600 mb-1.5">
                        نوع الفعالية <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="formEventType"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right bg-white
                                   focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 focus:border-[#1A6B3C]">
                        <option value="conference">مؤتمر</option>
                        <option value="hackathon">هاكاثون</option>
                        <option value="competition">مسابقة</option>
                        <option value="activity">نشاط طلابي</option>
                        <option value="training">تدريب</option>
                    </select>
                </div>
                {{-- Organizer (second = leftmost in RTL) --}}
                <div class="text-right">
                    <label class="block text-sm font-black text-gray-600 mb-1.5">الجهة المنظمة</label>
                    <input wire:model="formOrganizer"
                           type="text"
                           placeholder="اسم الجهة المنظمة للفعالية"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right
                                  focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 focus:border-[#1A6B3C]">
                </div>
            </div>

            {{-- Row 3: تاريخ الفعالية --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-right">
                    <label class="block text-sm font-black text-gray-600 mb-1.5">تاريخ الفعالية</label>
                    <input wire:model="formEventDate"
                           type="date"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right
                                  focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 focus:border-[#1A6B3C]">
                </div>
                <div></div>
            </div>

            {{-- Notes --}}
            <div class="text-right">
                <label class="block text-xs font-black text-gray-600 mb-1.5">ملاحظات</label>
                <textarea wire:model="formNotes"
                          rows="3"
                          placeholder="أضف أي ملاحظات أو تفاصيل إضافية للترشيح..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-right resize-none
                                 focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 focus:border-[#1A6B3C]
                                 placeholder:text-gray-300"></textarea>
            </div>

            {{-- Submit --}}
            <div class="flex justify-start">
                <button wire:click="submitNominationForm"
                        wire:loading.attr="disabled"
                        class="flex items-center gap-2 bg-[#1A6B3C] hover:bg-[#155e34] text-white font-bold px-8 py-3 rounded-xl transition-colors text-sm disabled:opacity-60">
                    <span wire:loading.remove wire:target="submitNominationForm">إرسال الترشيح</span>
                    <span wire:loading wire:target="submitNominationForm">جاري الإرسال...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Sent nominations list --}}
    @if($this->sentNominations->isNotEmpty())
    <div class="mt-6">
        <h3 class="font-black text-gray-700 text-sm text-right mb-3">الترشيحات المرسلة ({{ $this->sentNominations->count() }})</h3>
        <div class="space-y-2">
            @foreach($this->sentNominations->take(5) as $nom)
            @php
                $nc = match($nom->status) {
                    'accepted' => 'bg-green-50 border-green-200 text-green-700',
                    'rejected' => 'bg-red-50 border-red-200 text-red-700',
                    default    => 'bg-amber-50 border-amber-200 text-amber-700',
                };
                $nl = match($nom->status) {
                    'accepted' => 'قُبل',
                    'rejected' => 'رُفض',
                    default    => 'بانتظار الرد',
                };
            @endphp
            <div class="flex items-center justify-between bg-white border border-gray-100 rounded-xl px-4 py-3">
                <div class="flex items-center gap-2">
                    @if($nom->status === 'pending')
                    <button wire:click="cancelNomination({{ $nom->id }})"
                            class="text-xs text-red-400 hover:text-red-600 font-semibold">
                        إلغاء
                    </button>
                    @endif
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full border {{ $nc }}">{{ $nl }}</span>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-800 text-sm">{{ $nom->student?->name }}</p>
                    <p class="text-xs text-gray-400">{{ $nom->event_name }} · {{ $nom->created_at?->diffForHumans() }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

</div>{{-- end max-w container --}}

{{-- ══════════════════════════════════════════
     MODAL: Book Session
══════════════════════════════════════════ --}}
@if($showBooking)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
     wire:click.self="closeBooking">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl" dir="rtl">
        {{-- Header --}}
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <button wire:click="closeBooking"
                    class="flex items-center gap-1.5 text-gray-400 hover:text-gray-700 text-sm font-semibold" dir="ltr">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                اغلاق
            </button>
            <h2 class="text-2xl font-black text-gray-900">حجز جلسة جديدة</h2>
        </div>
        <div class="p-6 space-y-4">

            {{-- Row 1: اسم الطالب + الرقم الجامعي --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-black text-gray-600 mb-1.5">
                        الرقم الجامعي للطالب <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="bookStudentNo" type="text" placeholder="ادخل الرقم الجامعي للطالب"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 @error('bookStudentNo') border-red-400 @enderror">
                    @error('bookStudentNo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-black text-gray-600 mb-1.5">
                        اسم الطالب <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="bookStudentName" type="text" placeholder="ادخل اسم الطالب"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 @error('bookStudentName') border-red-400 @enderror">
                    @error('bookStudentName') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Row 2: البريد + التخصص --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-black text-gray-600 mb-1.5">التخصص</label>
                    <select wire:model="bookMajor"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right bg-white focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30">
                        <option value="">اختر التخصص</option>
                        <option value="علوم الحاسب">علوم الحاسب</option>
                        <option value="هندسة البرمجيات">هندسة البرمجيات</option>
                        <option value="نظم المعلومات">نظم المعلومات</option>
                        <option value="الذكاء الاصطناعي">الذكاء الاصطناعي</option>
                        <option value="أمن المعلومات">أمن المعلومات</option>
                        <option value="شبكات الحاسب">شبكات الحاسب</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-black text-gray-600 mb-1.5">
                        البريد الالكتروني للطالب <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="bookEmail" type="email" placeholder="ادخل البريد الالكتروني"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 @error('bookEmail') border-red-400 @enderror">
                    @error('bookEmail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Row 3: نوع الجلسة + التاريخ --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-black text-gray-600 mb-1.5">
                        وقت/ تاريخ الجلسة <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="bookDateTime" type="datetime-local"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 @error('bookDateTime') border-red-400 @enderror">
                    @error('bookDateTime') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-black text-gray-600 mb-1.5">
                        نوع الجلسة <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="bookSessionType"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right bg-white focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30">
                        <option value="academic">إرشاد أكاديمي</option>
                        <option value="career">إرشاد مهني</option>
                        <option value="personal">دعم شخصي</option>
                        <option value="follow_up">متابعة دورية</option>
                    </select>
                </div>
            </div>

            {{-- سبب الجلسة --}}
            <div>
                <label class="block text-sm font-black text-gray-600 mb-1.5">سبب الجلسة</label>
                <textarea wire:model="bookReason" rows="4" placeholder="ادخل سبب الجلسة"
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-right resize-none focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30 placeholder:text-gray-300"></textarea>
            </div>

            {{-- Submit --}}
            <div class="flex justify-start pt-1">
                <button wire:click="saveSession" wire:loading.attr="disabled"
                        class="bg-[#1A6B3C] hover:bg-[#155e34] text-white font-bold px-10 py-3 rounded-xl transition-colors text-sm disabled:opacity-60">
                    <span wire:loading.remove wire:target="saveSession">إرسال</span>
                    <span wire:loading wire:target="saveSession">جاري الحفظ...</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════
     MODAL: Rate Session
══════════════════════════════════════════ --}}
@if($showRating)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
     wire:click.self="closeRating">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg" dir="rtl">
        {{-- Header --}}
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <button wire:click="closeRating"
                    class="flex items-center gap-1.5 text-gray-400 hover:text-gray-700 text-sm font-semibold" dir="ltr">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                اغلاق
            </button>
            <div class="text-right">
                <h2 class="text-xl font-black text-gray-900">تقييم الجلسة</h2>
                <p class="text-xs text-gray-400 mt-0.5">ساعدنا في تحسين تجربة الإرشاد الأكاديمي من خلال تقييم مدى استفادتك من الجلسة.</p>
            </div>
        </div>

        <div class="p-6 space-y-6">
            {{-- Star rating --}}
            <div class="text-right">
                <h3 class="font-black text-gray-800 mb-1">كيف تقيم هذه الخدمة؟</h3>
                <p class="text-sm text-gray-400 mb-3">قيم تجربتك من (1) ضعيف إلى (5) ممتاز</p>
                <div class="flex gap-2 justify-end" x-data="{ hovered: 0 }">
                    @for($i = 5; $i >= 1; $i--)
                    <button
                        @mouseenter="hovered = {{ $i }}"
                        @mouseleave="hovered = 0"
                        wire:click="$set('ratingStars', {{ $i }})"
                        class="focus:outline-none transition-transform hover:scale-110">
                        <svg class="w-9 h-9 transition-colors"
                             :class="(hovered >= {{ $i }} || {{ $ratingStars }} >= {{ $i }}) ? 'text-amber-400' : 'text-gray-200'"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </button>
                    @endfor
                </div>
                @error('ratingStars') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Dropdown 1 --}}
            <div class="text-right">
                <label class="block font-black text-gray-800 mb-2">هل كانت التوجيهات واضحة؟</label>
                <div class="relative">
                    <select wire:model="ratingClarity"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-right bg-white appearance-none focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30">
                        <option value="">اختر...</option>
                        <option value="yes">نعم</option>
                        <option value="partially">جزئياً</option>
                        <option value="no">لا</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Dropdown 2 --}}
            <div class="text-right">
                <label class="block font-black text-gray-800 mb-2">هل ساعدتك الجلسة في فهم وضعك الأكاديمي؟</label>
                <div class="relative">
                    <select wire:model="ratingHelp"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-right bg-white appearance-none focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]/30">
                        <option value="">اختر...</option>
                        <option value="yes">نعم</option>
                        <option value="partially">جزئياً</option>
                        <option value="no">لا</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Note --}}
            <p class="text-xs text-gray-400 text-right leading-relaxed">
                رأيك يساعدنا على تحسين تجربة الدعم الأكاديمي وتقديم جلسات أكثر فاعلية.
            </p>

            {{-- Submit --}}
            <div class="flex justify-start">
                <button wire:click="submitRating" wire:loading.attr="disabled"
                        class="bg-[#1A6B3C] hover:bg-[#155e34] text-white font-bold px-8 py-3 rounded-xl transition-colors text-sm disabled:opacity-60">
                    <span wire:loading.remove wire:target="submitRating">إرسال التقييم</span>
                    <span wire:loading wire:target="submitRating">جاري الإرسال...</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════
     MODAL: Nomination (from card)
══════════════════════════════════════════ --}}
@if($showNomination)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
     wire:click.self="closeNomination">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl">
        <div class="flex items-center justify-between p-6 border-b border-gray-100">
            <button wire:click="closeNomination"
                    class="flex items-center gap-1.5 text-gray-400 hover:text-gray-700 text-sm font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                اغلاق
            </button>
            <div class="text-right">
                <h2 class="text-lg font-black text-gray-900">ترشيح للفرصة</h2>
                <p class="text-xs text-amber-600 font-bold mt-0.5">{{ $nomStudentName }} — {{ $nomStudentScore }}</p>
            </div>
        </div>
        <div class="p-6 space-y-4">
            {{-- Event type --}}
            <div class="grid grid-cols-5 gap-2">
                @foreach([
                    ['conference','🎤','مؤتمر'],
                    ['hackathon','💻','هاكاثون'],
                    ['competition','🏆','مسابقة'],
                    ['activity','🎯','نشاط'],
                    ['training','📚','تدريب'],
                ] as [$v,$icon,$label])
                <button wire:click="$set('nomEventType','{{ $v }}')"
                        class="flex flex-col items-center gap-1 py-3 rounded-xl border-2 text-xs font-bold transition-all
                               {{ $nomEventType === $v ? 'border-amber-400 bg-amber-50 text-amber-700' : 'border-gray-200 text-gray-500 hover:border-amber-200' }}">
                    <span class="text-xl">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </button>
                @endforeach
            </div>
            <div class="text-right">
                <label class="block text-xs font-black text-gray-600 mb-1.5">اسم الفعالية *</label>
                <input wire:model="nomEventName" type="text" placeholder="اسم المؤتمر أو الفعالية"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-amber-300 @error('nomEventName') border-red-400 @enderror">
                @error('nomEventName') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-right">
                    <label class="block text-sm font-black text-gray-600 mb-1.5">الموقع</label>
                    <input wire:model="nomEventLocation" type="text" placeholder="مدينة أو رابط الفعالية"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-amber-300">
                </div>
                <div class="text-right">
                    <label class="block text-sm font-black text-gray-600 mb-1.5">تاريخ الفعالية</label>
                    <input wire:model="nomEventDate" type="date"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-amber-300 @error('nomEventDate') border-red-400 @enderror">
                    @error('nomEventDate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="text-right">
                <label class="block text-xs font-black text-gray-600 mb-1.5">رسالة شخصية للطالب</label>
                <textarea wire:model="nomMessage" rows="3"
                          placeholder="اكتب رسالة تشجيعية للطالب..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-right resize-none focus:outline-none focus:ring-2 focus:ring-amber-300 placeholder:text-gray-300"></textarea>
            </div>
            <div class="flex justify-start">
                <button wire:click="submitNomination" wire:loading.attr="disabled"
                        class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-bold px-8 py-3 rounded-xl transition-colors text-sm disabled:opacity-60">
                    <span wire:loading.remove wire:target="submitNomination">إرسال الترشيح</span>
                    <span wire:loading wire:target="submitNomination">جاري الإرسال...</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

</div>{{-- end x-data --}}
