<div style="max-width:1440px; width:100%; margin:0 auto; padding:32px 80px 60px;" dir="rtl" x-data>

    {{-- ── Toast Notification ── --}}
    @if($showToast)
    <div x-data="{ show: true }"
         x-init="setTimeout(() => { show = false; $wire.dismissToast(); }, 3500)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-sm font-semibold
                {{ $toastType === 'success' ? 'bg-[#1A6B3C] text-white' : 'bg-red-600 text-white' }}">
        @if($toastType === 'success')
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg>
        @else
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        @endif
        {{ $toastMessage }}
    </div>
    @endif

    {{-- ── Header ── --}}
    <div style="background:linear-gradient(135deg,#1A6B3C 0%,#2d8a54 100%); border-radius:20px; padding:24px 32px; color:#fff; display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
        <div>
            <p style="font-size:0.85rem; opacity:0.75; margin-bottom:4px;">{{ __('منصة كَـنَـف') }}</p>
            <h1 style="font-size:1.6rem; font-weight:900; margin:0 0 4px;">{{ __('لوحة الإدارة') }}</h1>
            <p style="font-size:0.85rem; opacity:0.85;">{{ __('إدارة شاملة لمنصة كَـنَـف') }}</p>
        </div>
        <div style="background:rgba(255,255,255,0.15); border-radius:12px; padding:6px 14px; font-size:0.8rem; font-family:monospace; font-weight:700;">
            Admin Panel
        </div>
    </div>

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        @php
        $cards = [
            ['label'=>__('الطلاب'),       'value'=>$stats['students'],     'color'=>'blue',   'section'=>'students',     'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            ['label'=>__('المرشدون'),     'value'=>$stats['advisors'],     'color'=>'green',  'section'=>'advisors',     'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ['label'=>__('المواد'),       'value'=>$stats['courses'],      'color'=>'purple', 'section'=>'courses',      'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ['label'=>__('المسارات'),     'value'=>$stats['career_paths'], 'color'=>'yellow', 'section'=>'career_paths', 'icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10'],
            ['label'=>__('التسجيلات'),   'value'=>$stats['enrollments'],  'color'=>'indigo', 'section'=>'overview',     'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ['label'=>__('حالات حرجة'), 'value'=>$stats['critical'],     'color'=>'red',    'section'=>'students',     'icon'=>'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
        ];
        $cm = ['blue'=>['bg'=>'bg-blue-50','icon'=>'text-blue-600','num'=>'text-blue-700'],'green'=>['bg'=>'bg-green-50','icon'=>'text-green-600','num'=>'text-[#1A6B3C]'],'purple'=>['bg'=>'bg-purple-50','icon'=>'text-purple-600','num'=>'text-purple-700'],'yellow'=>['bg'=>'bg-yellow-50','icon'=>'text-yellow-600','num'=>'text-yellow-700'],'indigo'=>['bg'=>'bg-indigo-50','icon'=>'text-indigo-600','num'=>'text-indigo-700'],'red'=>['bg'=>'bg-red-50','icon'=>'text-red-600','num'=>'text-red-700']];
        @endphp
        @foreach($cards as $card)
        @php $c=$cm[$card['color']]; @endphp
        <button wire:click="setSection('{{ $card['section'] }}')"
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-right hover:shadow-md transition-shadow cursor-pointer">
            <div class="w-9 h-9 {{ $c['bg'] }} rounded-xl flex items-center justify-center mb-2">
                <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
            <p class="text-2xl font-extrabold {{ $c['num'] }}">{{ $card['value'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ $card['label'] }}</p>
        </button>
        @endforeach
    </div>

    {{-- ── Layout ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Sidebar --}}
        <nav class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-3 space-y-1">
                @foreach([
                    ['id'=>'overview',     'label'=>__('نظرة عامة'),        'icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['id'=>'students',     'label'=>__('الطلاب'),            'icon'=>'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['id'=>'advisors',     'label'=>__('المرشدون'),          'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['id'=>'courses',      'label'=>__('المواد الدراسية'),   'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                    ['id'=>'career_paths', 'label'=>__('المسارات المهنية'),  'icon'=>'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ] as $sec)
                <button wire:click="setSection('{{ $sec['id'] }}')"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all text-right
                               {{ $activeSection === $sec['id'] ? 'bg-[#1A6B3C] text-white' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sec['icon'] }}"/>
                    </svg>
                    {{ $sec['label'] }}
                </button>
                @endforeach
            </div>
        </nav>

        {{-- Content --}}
        <div class="lg:col-span-4 space-y-4">

            @if($activeSection !== 'overview')
            <div class="relative">
                <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ __('بحث...') }}"
                       class="w-full pr-9 pl-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] bg-white">
            </div>
            @endif

            {{-- ──────── OVERVIEW ──────── --}}
            @if($activeSection === 'overview')
            <div class="space-y-5">

                {{-- Quick CRUD Links --}}
                <div class="grid grid-cols-3 gap-4">
                    <a href="{{ route('admin.students') }}"
                       class="flex items-center gap-3 bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-md hover:border-[#1A6B3C]/20 transition-all group">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100 transition-colors">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">إدارة الطلاب</p>
                            <p class="text-xs text-gray-400">إضافة وتعديل وحذف</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 mr-auto rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('admin.subjects') }}"
                       class="flex items-center gap-3 bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-md hover:border-[#1A6B3C]/20 transition-all group">
                        <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-purple-100 transition-colors">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">إدارة المواد</p>
                            <p class="text-xs text-gray-400">إضافة وتعديل وحذف</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 mr-auto rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('admin.advisors') }}"
                       class="flex items-center gap-3 bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-md hover:border-[#1A6B3C]/20 transition-all group">
                        <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-green-100 transition-colors">
                            <svg class="w-5 h-5 text-[#1A6B3C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm">إدارة المرشدين</p>
                            <p class="text-xs text-gray-400">إضافة وتعديل وحذف</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 mr-auto rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="font-bold text-gray-800 mb-4">{{ __('أحدث الطلاب المسجلين') }}</h2>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-500 border-b border-gray-100 text-xs font-semibold">
                                <th class="text-right pb-3">{{ __('الاسم') }}</th>
                                <th class="text-right pb-3">{{ __('البريد') }}</th>
                                <th class="text-right pb-3">{{ __('تاريخ التسجيل') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentStudents as $s)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 font-medium text-gray-800">{{ $s->name }}</td>
                                <td class="py-3 text-gray-500">{{ $s->email }}</td>
                                <td class="py-3 text-gray-400">{{ $s->created_at->format('Y/m/d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="grid grid-cols-2 gap-5">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="font-bold text-gray-800 mb-4">{{ __('المواد الأكثر تسجيلاً') }}</h2>
                        <ul class="space-y-3">
                            @foreach($courses->sortByDesc('enrollments_count')->take(5) as $c)
                            <li class="flex justify-between items-center text-sm">
                                <span class="text-gray-700">{{ $c->name }}</span>
                                <span class="font-bold text-[#1A6B3C] bg-[#F0FAF4] px-2 py-0.5 rounded-lg text-xs">{{ $c->enrollments_count }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h2 class="font-bold text-gray-800 mb-4">{{ __('المسارات المهنية') }}</h2>
                        <ul class="space-y-3">
                            @foreach($careerPaths as $p)
                            <li class="flex justify-between items-center text-sm">
                                <span class="text-gray-700">{{ $p->name }}</span>
                                <span class="text-xs bg-[#F0FAF4] text-[#1A6B3C] px-2 py-1 rounded-full font-semibold">{{ $p->experts_count }} {{ __('خبير') }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ──────── STUDENTS ──────── --}}
            @elseif($activeSection === 'students')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h2 class="font-bold text-gray-800">{{ __('إدارة الطلاب') }}
                        <span class="text-sm text-gray-400 font-normal">({{ $students->count() }})</span>
                    </h2>
                    <button wire:click="openCreate('student')"
                            class="flex items-center gap-1.5 bg-[#1A6B3C] hover:bg-[#155C33] text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('إضافة طالب') }}
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-500 border-b border-gray-100 bg-gray-50 text-xs font-semibold">
                                <th class="text-right px-5 py-3">{{ __('الاسم') }}</th>
                                <th class="text-right px-5 py-3">{{ __('البريد') }}</th>
                                <th class="text-right px-5 py-3">{{ __('التخصص') }}</th>
                                <th class="text-right px-5 py-3">{{ __('المستوى') }}</th>
                                <th class="text-right px-5 py-3">{{ __('المتوسط') }}</th>
                                <th class="text-right px-5 py-3">{{ __('الحالة') }}</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        @forelse($students as $s)
                        @php
                            $avg = $s->enrollments->avg('total_score') ?? 0;
                            $sc  = $avg >= 80 ? 'bg-green-100 text-[#1A6B3C]' : ($avg >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                            $sl  = $avg >= 80 ? __('متميز') : ($avg >= 50 ? __('مستقر') : __('حرج'));
                            $levels = ['', __('الأول'), __('الثاني'), __('الثالث'), __('الرابع'), __('الخامس'), __('السادس'), __('السابع'), __('الثامن')];
                        @endphp
                        <tr class="hover:bg-gray-50 cursor-pointer" wire:click="openDetail({{ $s->id }})">
                            <td class="px-5 py-3 font-medium text-gray-800">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-[#F0FAF4] flex items-center justify-center text-[#1A6B3C] font-bold text-xs flex-shrink-0">
                                        {{ mb_substr($s->name, 0, 1) }}
                                    </div>
                                    {{ $s->name }}
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs">{{ $s->email }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $s->major ?? '—' }}</td>
                            <td class="px-5 py-3 text-center text-gray-600">{{ $levels[$s->academic_level ?? 0] ?? '—' }}</td>
                            <td class="px-5 py-3 text-center font-bold {{ $avg >= 80 ? 'text-[#1A6B3C]' : ($avg >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $s->enrollments->count() > 0 ? round($avg).'%' : '—' }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $sc }}">{{ $sl }}</span>
                            </td>
                            <td class="px-5 py-3" wire:click.stop>
                                <div class="flex gap-1.5 justify-end">
                                    <button wire:click="openEdit('student', {{ $s->id }})"
                                            class="text-blue-500 hover:text-blue-700 text-xs border border-blue-200 rounded-lg px-3 py-1 hover:bg-blue-50 transition-colors">{{ __('تعديل') }}</button>
                                    <button wire:click="confirmDelete('student', {{ $s->id }}, '{{ addslashes($s->name) }}')"
                                            class="text-red-500 hover:text-red-700 text-xs border border-red-200 rounded-lg px-3 py-1 hover:bg-red-50 transition-colors">{{ __('حذف') }}</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-14 text-center">
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-gray-400 text-sm">{{ __('لا توجد نتائج') }}</p>
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ──────── ADVISORS ──────── --}}
            @elseif($activeSection === 'advisors')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h2 class="font-bold text-gray-800">{{ __('إدارة المرشدين') }}
                        <span class="text-sm text-gray-400 font-normal">({{ $advisors->count() }})</span>
                    </h2>
                    <button wire:click="openCreate('advisor')"
                            class="flex items-center gap-1.5 bg-[#1A6B3C] hover:bg-[#155C33] text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('إضافة مرشد') }}
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-500 border-b border-gray-100 bg-gray-50 text-xs font-semibold">
                                <th class="text-right px-5 py-3">{{ __('الاسم') }}</th>
                                <th class="text-right px-5 py-3">{{ __('البريد') }}</th>
                                <th class="text-right px-5 py-3">{{ __('رقم الوظيفة') }}</th>
                                <th class="text-right px-5 py-3">{{ __('الكلية') }}</th>
                                <th class="text-right px-5 py-3">{{ __('القسم') }}</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        @forelse($advisors as $a)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3 font-medium text-gray-800">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xs flex-shrink-0">
                                        {{ mb_substr($a->name, 0, 1) }}
                                    </div>
                                    {{ $a->name }}
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs">{{ $a->email }}</td>
                            <td class="px-5 py-3 text-gray-600 font-mono text-xs">{{ $a->job_number ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $a->college ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $a->department ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <div class="flex gap-1.5 justify-end">
                                    <button wire:click="openEdit('advisor', {{ $a->id }})"
                                            class="text-blue-500 hover:text-blue-700 text-xs border border-blue-200 rounded-lg px-3 py-1 hover:bg-blue-50 transition-colors">{{ __('تعديل') }}</button>
                                    <button wire:click="confirmDelete('advisor', {{ $a->id }}, '{{ addslashes($a->name) }}')"
                                            class="text-red-500 hover:text-red-700 text-xs border border-red-200 rounded-lg px-3 py-1 hover:bg-red-50 transition-colors">{{ __('حذف') }}</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-14 text-center">
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <p class="text-gray-400 text-sm">{{ __('لا يوجد مرشدون بعد') }}</p>
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ──────── COURSES ──────── --}}
            @elseif($activeSection === 'courses')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h2 class="font-bold text-gray-800">{{ __('إدارة المواد الدراسية') }}
                        <span class="text-sm text-gray-400 font-normal">({{ $courses->count() }})</span>
                    </h2>
                    <button wire:click="openCreate('course')"
                            class="flex items-center gap-1.5 bg-[#1A6B3C] hover:bg-[#155C33] text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('إضافة مادة') }}
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-500 border-b border-gray-100 bg-gray-50 text-xs font-semibold">
                                <th class="text-right px-5 py-3">{{ __('رمز المادة') }}</th>
                                <th class="text-right px-5 py-3">{{ __('اسم المادة') }}</th>
                                <th class="text-center px-5 py-3">{{ __('الساعات') }}</th>
                                <th class="text-center px-5 py-3">{{ __('المسجلون') }}</th>
                                <th class="text-right px-5 py-3">{{ __('الوصف') }}</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        @forelse($courses as $c)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <span class="font-mono font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-lg text-xs">{{ $c->code }}</span>
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $c->name }}</td>
                            <td class="px-5 py-3 text-center text-gray-600">
                                <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded-lg text-xs font-semibold">{{ $c->credits }} {{ __('ساعة') }}</span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="font-bold text-[#1A6B3C] bg-[#F0FAF4] px-2.5 py-1 rounded-lg text-xs">{{ $c->enrollments_count }}</span>
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs max-w-[200px] truncate">{{ $c->description ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <div class="flex gap-1.5 justify-end">
                                    <button wire:click="openEdit('course', {{ $c->id }})"
                                            class="text-blue-500 hover:text-blue-700 text-xs border border-blue-200 rounded-lg px-3 py-1 hover:bg-blue-50 transition-colors">{{ __('تعديل') }}</button>
                                    <button wire:click="confirmDelete('course', {{ $c->id }}, '{{ addslashes($c->name) }}')"
                                            class="text-red-500 hover:text-red-700 text-xs border border-red-200 rounded-lg px-3 py-1 hover:bg-red-50 transition-colors">{{ __('حذف') }}</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-14 text-center">
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <p class="text-gray-400 text-sm">{{ __('لا توجد مواد بعد') }}</p>
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ──────── CAREER PATHS ──────── --}}
            @elseif($activeSection === 'career_paths')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <h2 class="font-bold text-gray-800">{{ __('إدارة المسارات المهنية') }}
                        <span class="text-sm text-gray-400 font-normal">({{ $careerPaths->count() }})</span>
                    </h2>
                    <button wire:click="openCreate('career_path')"
                            class="flex items-center gap-1.5 bg-[#1A6B3C] hover:bg-[#155C33] text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('إضافة مسار') }}
                    </button>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($careerPaths as $p)
                    <div class="px-5 py-4 flex items-start justify-between hover:bg-gray-50 gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800">{{ $p->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ $p->description }}</p>
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach(array_slice($p->core_skills ?? [], 0, 4) as $skill)
                                <span class="text-xs bg-[#F0FAF4] text-[#1A6B3C] px-2 py-0.5 rounded-full">{{ $skill }}</span>
                                @endforeach
                                @if(count($p->core_skills ?? []) > 4)
                                <span class="text-xs text-gray-400">+{{ count($p->core_skills) - 4 }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">{{ $p->experts_count }} {{ __('خبير') }}</span>
                            <button wire:click="openEdit('career_path', {{ $p->id }})"
                                    class="text-blue-500 hover:text-blue-700 text-xs border border-blue-200 rounded-lg px-3 py-1.5 hover:bg-blue-50 transition-colors">{{ __('تعديل') }}</button>
                            <button wire:click="confirmDelete('career_path', {{ $p->id }}, '{{ addslashes($p->name) }}')"
                                    class="text-red-500 hover:text-red-700 text-xs border border-red-200 rounded-lg px-3 py-1.5 hover:bg-red-50 transition-colors">{{ __('حذف') }}</button>
                        </div>
                    </div>
                    @empty
                    <div class="py-14 text-center">
                        <p class="text-gray-400 text-sm">{{ __('لا توجد مسارات بعد') }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════
     STUDENT DETAIL DRAWER
══════════════════════════════════════════════════════════════════ --}}
@if($showDetail && $detailUser)
<div class="fixed inset-0 z-50 flex justify-end">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeDetail"></div>
    <div class="relative bg-white w-full max-w-md h-full overflow-y-auto shadow-2xl z-10 flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 bg-white sticky top-0 z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-[#F0FAF4] flex items-center justify-center text-[#1A6B3C] font-extrabold text-lg">
                    {{ mb_substr($detailUser->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-base">{{ $detailUser->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $detailUser->email }}</p>
                </div>
            </div>
            <button wire:click="closeDetail" class="text-gray-400 hover:text-gray-600 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Info Cards --}}
        @php
            $avg = $detailUser->enrollments->avg('total_score') ?? 0;
            $levels = ['', __('الأول'), __('الثاني'), __('الثالث'), __('الرابع'), __('الخامس'), __('السادس'), __('السابع'), __('الثامن')];
        @endphp
        <div class="px-6 py-4 grid grid-cols-3 gap-3">
            <div class="bg-[#F0FAF4] rounded-2xl p-3 text-center">
                <p class="text-xl font-extrabold text-[#1A6B3C]">{{ $detailUser->enrollments->count() > 0 ? round($avg).'%' : '—' }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('المتوسط') }}</p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-3 text-center">
                <p class="text-xl font-extrabold text-gray-700">{{ $detailUser->enrollments->count() }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('المواد') }}</p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-3 text-center">
                <p class="text-xl font-extrabold text-gray-700">{{ $levels[$detailUser->academic_level ?? 0] ?? '—' }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('المستوى') }}</p>
            </div>
        </div>

        {{-- Student Info --}}
        <div class="px-6 pb-4">
            <div class="bg-gray-50 rounded-2xl p-4 space-y-2 text-sm">
                @if($detailUser->student_id)
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('الرقم الجامعي') }}</span>
                    <span class="font-mono font-semibold text-gray-700">{{ $detailUser->student_id }}</span>
                </div>
                @endif
                @if($detailUser->major)
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('التخصص') }}</span>
                    <span class="font-semibold text-gray-700">{{ $detailUser->major }}</span>
                </div>
                @endif
                @if($detailUser->college)
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('الكلية') }}</span>
                    <span class="font-semibold text-gray-700">{{ $detailUser->college }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('تاريخ التسجيل') }}</span>
                    <span class="font-semibold text-gray-700">{{ $detailUser->created_at->format('Y/m/d') }}</span>
                </div>
            </div>
        </div>

        {{-- Enrollments --}}
        <div class="px-6 pb-6 flex-1">
            <h4 class="font-bold text-gray-800 mb-3 text-sm">{{ __('المواد المسجلة') }}</h4>
            @if($detailUser->enrollments->count() > 0)
            <div class="space-y-2">
                @foreach($detailUser->enrollments->sortByDesc('total_score') as $enroll)
                @php
                    $score = $enroll->total_score ?? 0;
                    $barColor = $score >= 80 ? 'bg-[#1A6B3C]' : ($score >= 60 ? 'bg-yellow-400' : 'bg-red-400');
                    $grade = $score >= 90 ? 'A+' : ($score >= 85 ? 'A' : ($score >= 80 ? 'A-' : ($score >= 75 ? 'B+' : ($score >= 70 ? 'B' : ($score >= 65 ? 'B-' : ($score >= 60 ? 'C+' : ($score >= 55 ? 'C' : ($score >= 50 ? 'D' : 'F'))))))));
                @endphp
                <div class="bg-gray-50 rounded-xl p-3">
                    <div class="flex items-center justify-between mb-1.5">
                        <div>
                            <span class="font-mono text-xs text-purple-600 font-bold">{{ $enroll->course->code ?? '—' }}</span>
                            <span class="text-xs text-gray-700 font-medium mr-1.5">{{ $enroll->course->name ?? '—' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-mono font-bold {{ $score >= 80 ? 'text-[#1A6B3C]' : ($score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">{{ $grade }}</span>
                            <span class="text-xs font-bold {{ $score >= 80 ? 'text-[#1A6B3C]' : ($score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">{{ $score }}%</span>
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                        <div class="{{ $barColor }} h-1.5 rounded-full transition-all" style="width: {{ min($score, 100) }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="py-8 text-center text-gray-400 text-sm">{{ __('لا توجد مواد مسجلة') }}</div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-white sticky bottom-0 flex gap-3">
            <button wire:click="openEdit('student', {{ $detailUser->id }}); closeDetail()"
                    class="flex-1 py-2.5 text-sm font-semibold text-white bg-[#1A6B3C] hover:bg-[#155C33] rounded-xl transition-colors">
                {{ __('تعديل البيانات') }}
            </button>
            <button wire:click="confirmDelete('student', {{ $detailUser->id }}, '{{ addslashes($detailUser->name) }}'); closeDetail()"
                    class="px-4 py-2.5 text-sm font-semibold text-red-600 border border-red-200 hover:bg-red-50 rounded-xl transition-colors">
                {{ __('حذف') }}
            </button>
        </div>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════════════════════
     CRUD MODAL
══════════════════════════════════════════════════════════════════ --}}
@if($showModal)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeModal"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[92vh] overflow-y-auto z-10">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 sticky top-0 bg-white rounded-t-3xl z-10">
            <div>
                <h3 class="font-bold text-gray-800">
                    @if($modalMode === 'create')
                        @if($modalType === 'student') {{ __('إضافة طالب جديد') }}
                        @elseif($modalType === 'advisor') {{ __('إضافة مرشد جديد') }}
                        @elseif($modalType === 'course') {{ __('إضافة مادة دراسية') }}
                        @else {{ __('إضافة مسار مهني') }}
                        @endif
                    @else
                        @if($modalType === 'student') {{ __('تعديل بيانات الطالب') }}
                        @elseif($modalType === 'advisor') {{ __('تعديل بيانات المرشد') }}
                        @elseif($modalType === 'course') {{ __('تعديل المادة الدراسية') }}
                        @else {{ __('تعديل المسار المهني') }}
                        @endif
                    @endif
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $modalMode === 'create' ? __('أدخل البيانات المطلوبة أدناه') : __('عدّل البيانات ثم اضغط حفظ') }}
                </p>
            </div>
            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form wire:submit="save" class="px-6 py-5 space-y-4">

            {{-- ── STUDENT / ADVISOR FORM ── --}}
            @if(in_array($modalType, ['student', 'advisor']))
            <div class="grid grid-cols-2 gap-4">

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('الاسم الكامل') }} <span class="text-red-500">*</span></label>
                    <input wire:model="fName" type="text" placeholder="مثال: خالد محمد العتيبي"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] @error('fName') border-red-300 @enderror">
                    @error('fName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('البريد الإلكتروني') }} <span class="text-red-500">*</span></label>
                    <input wire:model="fEmail" type="email" placeholder="user@kanaf.sa"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] @error('fEmail') border-red-300 @enderror" dir="ltr">
                    @error('fEmail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        {{ __('كلمة المرور') }}
                        @if($modalMode === 'edit')
                        <span class="text-gray-400 font-normal text-xs">({{ __('اتركها فارغة للإبقاء على الحالية') }})</span>
                        @else
                        <span class="text-red-500">*</span>
                        @endif
                    </label>
                    <input wire:model="fPassword" type="password" placeholder="••••••••"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] @error('fPassword') border-red-300 @enderror" dir="ltr">
                    @error('fPassword') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('الكلية') }}</label>
                    <input wire:model="fCollege" type="text" placeholder="كلية الحاسب والمعلومات"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]">
                </div>

                @if($modalType === 'student')
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('التخصص') }}</label>
                    <input wire:model="fMajor" type="text" placeholder="علوم الحاسب"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('الرقم الجامعي') }}</label>
                    <input wire:model="fStudentId" type="text" placeholder="4410012345"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]" dir="ltr">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('المستوى الدراسي') }}</label>
                    <select wire:model="fLevel"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] bg-white">
                        @foreach(['1'=>__('الأول'),'2'=>__('الثاني'),'3'=>__('الثالث'),'4'=>__('الرابع'),'5'=>__('الخامس'),'6'=>__('السادس'),'7'=>__('السابع'),'8'=>__('الثامن')] as $v=>$l)
                        <option value="{{ $v }}">{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                @else
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('القسم') }}</label>
                    <input wire:model="fDepartment" type="text" placeholder="علوم الحاسب"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('رقم الوظيفة') }}</label>
                    <input wire:model="fJobNumber" type="text" placeholder="ADV-0012"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]" dir="ltr">
                </div>
                @endif

            </div>
            @endif

            {{-- ── COURSE FORM ── --}}
            @if($modalType === 'course')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('رمز المادة') }} <span class="text-red-500">*</span></label>
                    <input wire:model="fCode" type="text" placeholder="CS301"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] font-mono uppercase @error('fCode') border-red-300 @enderror" dir="ltr">
                    @error('fCode') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('الساعات المعتمدة') }}</label>
                    <select wire:model="fCredits"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] bg-white">
                        @foreach([1,2,3,4,5,6] as $cr)
                        <option value="{{ $cr }}">{{ $cr }} {{ __('ساعة') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('اسم المادة') }} <span class="text-red-500">*</span></label>
                    <input wire:model="fName" type="text" placeholder="خوارزميات وهياكل البيانات"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] @error('fName') border-red-300 @enderror">
                    @error('fName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('الوصف') }}</label>
                    <textarea wire:model="fDescription" rows="3" placeholder="وصف مختصر عن محتوى المادة..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] resize-none"></textarea>
                </div>
            </div>
            @endif

            {{-- ── CAREER PATH FORM ── --}}
            @if($modalType === 'career_path')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('اسم المسار') }} <span class="text-red-500">*</span></label>
                    <input wire:model="fPathName" type="text" placeholder="مسار تحليل البيانات"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] @error('fPathName') border-red-300 @enderror">
                    @error('fPathName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">{{ __('الوصف') }} <span class="text-red-500">*</span></label>
                    <textarea wire:model="fPathDesc" rows="3" placeholder="وصف المسار المهني وما يقدمه للطالب..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] resize-none @error('fPathDesc') border-red-300 @enderror"></textarea>
                    @error('fPathDesc') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        {{ __('المهارات الأساسية') }}
                        <span class="text-gray-400 font-normal text-xs">({{ __('مفصولة بفاصلة عربية ،') }})</span>
                    </label>
                    <input wire:model="fPathSkills" type="text" placeholder="SQL، Python، Power BI، التحليل الإحصائي"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        {{ __('مجالات العمل') }}
                        <span class="text-gray-400 font-normal text-xs">({{ __('مفصولة بفاصلة عربية ،') }})</span>
                    </label>
                    <input wire:model="fPathFields" type="text" placeholder="الشركات التقنية، البنوك، الحكومة"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]">
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="button" wire:click="closeModal"
                        class="flex-1 py-3 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                    {{ __('إلغاء') }}
                </button>
                <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#1A6B3C] hover:bg-[#155C33] rounded-xl transition-colors flex items-center justify-center gap-2">
                    <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span>{{ $modalMode === 'create' ? __('إضافة') : __('حفظ التعديلات') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════════════════════
     DELETE CONFIRMATION
══════════════════════════════════════════════════════════════════ --}}
@if($showDeleteConfirm)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="cancelDelete"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 z-10 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-2">{{ __('تأكيد الحذف') }}</h3>
        <p class="text-gray-500 text-sm mb-6">
            {{ __('هل أنت متأكد من حذف') }} <strong class="text-gray-800">"{{ $deleteLabel }}"</strong>؟
            <br><span class="text-xs text-red-500 mt-1 block">{{ __('لا يمكن التراجع عن هذا الإجراء.') }}</span>
        </p>
        <div class="flex gap-3">
            <button wire:click="cancelDelete"
                    class="flex-1 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                {{ __('إلغاء') }}
            </button>
            <button wire:click="doDelete"
                    class="flex-1 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors flex items-center justify-center gap-2">
                <svg wire:loading wire:target="doDelete" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                {{ __('حذف نهائياً') }}
            </button>
        </div>
    </div>
</div>
@endif
