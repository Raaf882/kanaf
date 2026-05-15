{{--
    $student : array from analyseStudent()
    $type    : 'critical' | 'outstanding' | 'stable'
--}}
<div class="bg-white rounded-2xl border {{ $type === 'critical' ? 'border-red-100' : ($type === 'outstanding' ? 'border-green-100' : 'border-gray-100') }} shadow-sm p-5 flex flex-col items-center text-center gap-3">

    {{-- Avatar --}}
    <div class="w-14 h-14 rounded-full flex items-center justify-center
                {{ $type === 'critical' ? 'bg-red-50' : ($type === 'outstanding' ? 'bg-green-50' : 'bg-gray-100') }}">
        <svg class="w-8 h-8 {{ $type === 'critical' ? 'text-red-400' : ($type === 'outstanding' ? 'text-[#1A6B3C]' : 'text-gray-400') }}"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
    </div>

    {{-- Name --}}
    <h3 class="font-black text-gray-900 text-base leading-tight">{{ $student['name'] }}</h3>

    {{-- Info list --}}
    <div class="w-full space-y-1 text-right text-sm text-gray-600">
        <div class="flex justify-between items-center">
            <span class="font-semibold text-gray-800">{{ $student['student_id'] }}</span>
            <span class="text-gray-400 text-xs">الرقم الجامعي</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="font-semibold text-gray-800">{{ $student['college'] }}</span>
            <span class="text-gray-400 text-xs">الكلية</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="font-semibold text-gray-800">{{ $student['major'] }}</span>
            <span class="text-gray-400 text-xs">التخصص</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="font-black
                         {{ $type === 'critical' ? 'text-red-600' : ($type === 'outstanding' ? 'text-[#1A6B3C]' : 'text-gray-800') }}">
                {{ $student['gpa'] }}
            </span>
            <span class="text-gray-400 text-xs">المعدل</span>
        </div>
    </div>

    <hr class="w-full border-gray-100">

    {{-- Reason --}}
    <p class="text-xs text-gray-600 leading-relaxed text-right w-full">
        @if($type === 'critical')
            <span class="text-red-500 ml-1">⚠️</span>
        @elseif($type === 'outstanding')
            <span class="text-green-600 ml-1">✅</span>
        @else
            <span class="ml-1">📊</span>
        @endif
        {{ $student['reason'] }}
    </p>

    {{-- Status pills --}}
    <div class="flex flex-wrap gap-1.5 justify-center">
        @if($type === 'critical')
            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-700">بحاجة دعم</span>
            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-orange-100 text-orange-700">متوقع تدخل</span>
            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">
                المستوى {{ $student['academic_level'] }}
            </span>
        @elseif($type === 'outstanding')
            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-green-100 text-green-700">أداء متميز</span>
            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">للترشيح</span>
            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">
                المستوى {{ $student['academic_level'] }}
            </span>
        @else
            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700">مستقر</span>
            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">
                المستوى {{ $student['academic_level'] }}
            </span>
        @endif
    </div>

    {{-- AI Prediction Badge ──────────────────────────────── --}}
    @if(!empty($student['sap_prediction']))
        @php
            $sapRisk  = $student['sap_risk'] ?? false;
            $sapLabel = $student['sap_label'] ?? '';
            $sapConf  = $student['sap_confidence'] ?? null;
        @endphp
        <div class="w-full rounded-xl px-3 py-2 flex items-center gap-2 {{ $sapRisk ? 'bg-red-50 border border-red-200' : 'bg-emerald-50 border border-emerald-200' }}">
            {{-- Brain icon --}}
            <svg class="w-4 h-4 flex-shrink-0 {{ $sapRisk ? 'text-red-500' : 'text-emerald-600' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-black {{ $sapRisk ? 'text-red-700' : 'text-emerald-700' }}">
                    {{ $sapLabel }}
                </p>
                <p class="text-[10px] text-gray-400">تحليل ذكاء اصطناعي{{ $sapConf ? ' · ' . $sapConf . '%' : '' }}</p>
            </div>
            @if($sapRisk)
                <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded-full flex-shrink-0">تدني</span>
            @else
                <span class="text-xs font-bold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-full flex-shrink-0">آمن</span>
            @endif
        </div>
    @endif

    {{-- Action buttons --}}
    <div class="w-full flex gap-2 mt-1">
        <button wire:click="$dispatch('open-student-detail', { id: {{ $student['id'] }} })"
                class="flex-1 text-xs font-bold py-2 px-3 rounded-xl border border-gray-200 text-gray-600 hover:border-[#1A6B3C] hover:text-[#1A6B3C] transition-colors">
            عرض الحالة
        </button>

        @if($type === 'critical')
        <button wire:click="openBooking({{ $student['id'] }})"
                class="flex-1 text-xs font-bold py-2 px-3 rounded-xl bg-red-500 text-white hover:bg-red-600 transition-colors">
            حجز جلسة
        </button>
        @elseif($type === 'outstanding')
        <button wire:click="openNomination({{ $student['id'] }})"
                class="flex-1 text-xs font-bold py-2 px-3 rounded-xl bg-[#1A6B3C] text-white hover:bg-[#155e34] transition-colors">
            ترشيح للفرصة
        </button>
        @endif
    </div>

</div>
