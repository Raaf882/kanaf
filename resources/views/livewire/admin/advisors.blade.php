<div style="max-width:1440px; width:100%; margin:0 auto; padding:32px 80px 60px;" dir="rtl" x-data>

    {{-- Toast --}}
    @if($showToast)
    <div x-data="{ show: true }"
         x-init="setTimeout(() => { show = false; $wire.dismissToast(); }, 3500)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
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

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}"
               class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#1A6B3C]">لوحة الإدارة</a>
                    <span>/</span>
                    <span class="text-gray-600 font-semibold">إدارة المرشدين</span>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900">إدارة المرشدين</h1>
            </div>
        </div>
        <button wire:click="openCreate"
                class="flex items-center gap-2 bg-[#1A6B3C] hover:bg-[#155C33] text-white text-base font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm shadow-[#1A6B3C]/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            إضافة مرشد
        </button>
    </div>

    {{-- Search --}}
    <div class="relative mb-5">
        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="بحث بالاسم أو البريد أو القسم أو رقم الوظيفة..."
               class="w-full pr-10 pl-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] bg-white">
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <p class="text-sm text-gray-500">
                إجمالي المرشدين: <span class="font-bold text-gray-800">{{ $advisors->total() }}</span>
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 bg-gray-50 text-sm font-semibold">
                        <th class="text-right px-5 py-3">الاسم</th>
                        <th class="text-right px-5 py-3">البريد الإلكتروني</th>
                        <th class="text-right px-5 py-3">رقم الوظيفة</th>
                        <th class="text-right px-5 py-3">الكلية</th>
                        <th class="text-right px-5 py-3">القسم</th>
                        <th class="text-right px-5 py-3">تاريخ الإضافة</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse($advisors as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium text-gray-800">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-xs flex-shrink-0">
                                {{ mb_substr($a->name, 0, 1) }}
                            </div>
                            {{ $a->name }}
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">{{ $a->email }}</td>
                    <td class="px-5 py-3">
                        @if($a->job_number)
                        <span class="font-mono text-xs text-gray-700 bg-gray-100 px-2.5 py-1 rounded-lg">{{ $a->job_number }}</span>
                        @else
                        <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-600">{{ $a->college ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $a->department ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-400 text-xs">{{ $a->created_at->format('Y/m/d') }}</td>
                    <td class="px-5 py-3">
                        <div class="flex gap-1.5 justify-end">
                            <button wire:click="openEdit({{ $a->id }})"
                                    class="text-blue-500 hover:text-blue-700 text-xs border border-blue-200 rounded-lg px-3 py-1 hover:bg-blue-50 transition-colors">تعديل</button>
                            <button wire:click="confirmDelete({{ $a->id }}, '{{ addslashes($a->name) }}')"
                                    class="text-red-500 hover:text-red-700 text-xs border border-red-200 rounded-lg px-3 py-1 hover:bg-red-50 transition-colors">حذف</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <p class="text-gray-400 text-sm font-medium">لا يوجد مرشدون بعد</p>
                        @if($search)
                        <p class="text-gray-300 text-xs mt-1">جرّب تغيير كلمة البحث</p>
                        @endif
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($advisors->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $advisors->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ── Create / Edit Modal ── --}}
@if($showModal)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" wire:click="closeModal"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[92vh] overflow-y-auto z-10">

        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 sticky top-0 bg-white rounded-t-3xl z-10">
            <div>
                <h3 class="font-bold text-gray-800">
                    {{ $modalMode === 'create' ? 'إضافة مرشد أكاديمي جديد' : 'تعديل بيانات المرشد' }}
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $modalMode === 'create' ? 'أدخل بيانات المرشد أدناه' : 'عدّل البيانات ثم اضغط حفظ' }}
                </p>
            </div>
            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form wire:submit="save" class="px-6 py-5 space-y-4">

            <div class="grid grid-cols-2 gap-4">

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">الاسم الكامل <span class="text-red-500">*</span></label>
                    <input wire:model="fName" type="text" placeholder="مثال: د. فاطمة علي الزهراني"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] @error('fName') border-red-400 @enderror">
                    @error('fName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">البريد الإلكتروني <span class="text-red-500">*</span></label>
                    <input wire:model="fEmail" type="email" placeholder="advisor@kanaf.sa"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] @error('fEmail') border-red-400 @enderror" dir="ltr">
                    @error('fEmail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        كلمة المرور
                        @if($modalMode === 'edit')
                        <span class="text-gray-400 font-normal text-xs">(اتركها فارغة للإبقاء على الحالية)</span>
                        @else
                        <span class="text-red-500">*</span>
                        @endif
                    </label>
                    <input wire:model="fPassword" type="password" placeholder="••••••••"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] @error('fPassword') border-red-400 @enderror" dir="ltr">
                    @error('fPassword') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">رقم الوظيفة</label>
                    <input wire:model="fJobNumber" type="text" placeholder="ADV-0012"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]" dir="ltr">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">الكلية</label>
                    <input wire:model="fCollege" type="text" placeholder="كلية الحاسب والمعلومات"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">القسم</label>
                    <input wire:model="fDepartment" type="text" placeholder="قسم علوم الحاسب"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C]">
                </div>

            </div>

            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="button" wire:click="closeModal"
                        class="flex-1 py-3 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">إلغاء</button>
                <button type="submit"
                        class="flex-1 py-3 text-sm font-bold text-white bg-[#1A6B3C] hover:bg-[#155C33] rounded-xl transition-colors flex items-center justify-center gap-2">
                    <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    {{ $modalMode === 'create' ? 'إضافة المرشد' : 'حفظ التعديلات' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ── Delete Confirmation ── --}}
@if($showDeleteConfirm)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" wire:click="cancelDelete"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 z-10 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="font-bold text-gray-800 text-lg mb-2">تأكيد الحذف</h3>
        <p class="text-gray-500 text-sm mb-6">
            هل أنت متأكد من حذف <strong class="text-gray-800">"{{ $deleteLabel }}"</strong>؟
            <br><span class="text-xs text-red-500 mt-1 block">لا يمكن التراجع عن هذا الإجراء.</span>
        </p>
        <div class="flex gap-3">
            <button wire:click="cancelDelete" class="flex-1 py-2.5 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">إلغاء</button>
            <button wire:click="doDelete"
                    class="flex-1 py-2.5 text-sm font-bold text-white bg-red-600 hover:bg-red-700 rounded-xl transition-colors flex items-center justify-center gap-2">
                <svg wire:loading wire:target="doDelete" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                حذف نهائياً
            </button>
        </div>
    </div>
</div>
@endif
