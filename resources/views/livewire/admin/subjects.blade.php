<div class="page-body" dir="rtl" x-data>

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
                    <span class="text-gray-600 font-semibold">إدارة المواد الدراسية</span>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900">إدارة المواد الدراسية</h1>
            </div>
        </div>
        <button wire:click="openCreate"
                class="flex items-center gap-2 bg-[#1A6B3C] hover:bg-[#155C33] text-white text-base font-bold px-5 py-2.5 rounded-xl transition-colors shadow-sm shadow-[#1A6B3C]/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            إضافة مادة
        </button>
    </div>

    {{-- Search --}}
    <div class="relative mb-5">
        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="بحث برمز المادة أو الاسم أو الوصف..."
               class="w-full pe-10 ps-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] bg-white">
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <p class="text-sm text-gray-500">
                إجمالي المواد: <span class="font-bold text-gray-800">{{ $subjects->total() }}</span>
            </p>
        </div>
        <div class="overflow-x-auto" style="scroll-padding-inline-start:16px;">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-gray-500 border-b border-gray-100 bg-gray-50 text-sm font-semibold">
                        <th class="text-right px-5 py-3">رمز المادة</th>
                        <th class="text-right px-5 py-3">اسم المادة</th>
                        <th class="text-center px-5 py-3">الساعات المعتمدة</th>
                        <th class="text-center px-5 py-3">المسجلون</th>
                        <th class="text-right px-5 py-3">الوصف</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse($subjects as $s)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3">
                        <span class="font-mono font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-lg text-xs">{{ $s->code }}</span>
                    </td>
                    <td class="px-5 py-3 font-medium text-gray-800">{{ $s->name }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $s->credits }} ساعة</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="font-bold text-[#1A6B3C] bg-[#F0FAF4] px-2.5 py-1 rounded-lg text-xs">{{ $s->enrollments_count }}</span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs max-w-[220px] truncate">{{ $s->description ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <div class="flex gap-1.5 justify-end">
                            <button wire:click="openEdit({{ $s->id }})"
                                    class="text-blue-500 hover:text-blue-700 text-xs border border-blue-200 rounded-lg px-3 py-1 hover:bg-blue-50 transition-colors">تعديل</button>
                            <button wire:click="confirmDelete({{ $s->id }}, '{{ addslashes($s->name) }}')"
                                    class="text-red-500 hover:text-red-700 text-xs border border-red-200 rounded-lg px-3 py-1 hover:bg-red-50 transition-colors">حذف</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <p class="text-gray-400 text-sm font-medium">لا توجد مواد دراسية</p>
                        @if($search)
                        <p class="text-gray-300 text-xs mt-1">جرّب تغيير كلمة البحث</p>
                        @endif
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($subjects->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $subjects->links() }}
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
                    {{ $modalMode === 'create' ? 'إضافة مادة دراسية جديدة' : 'تعديل المادة الدراسية' }}
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $modalMode === 'create' ? 'أدخل بيانات المادة أدناه' : 'عدّل البيانات ثم اضغط حفظ' }}
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

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">رمز المادة <span class="text-red-500">*</span></label>
                    <input wire:model="fCode" type="text" placeholder="CS301"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] font-mono uppercase @error('fCode') border-red-400 @enderror" dir="ltr">
                    @error('fCode') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">الساعات المعتمدة</label>
                    <select wire:model="fCredits" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] bg-white">
                        @foreach([1,2,3,4,5,6] as $cr)
                        <option value="{{ $cr }}">{{ $cr }} ساعة</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">اسم المادة <span class="text-red-500">*</span></label>
                    <input wire:model="fName" type="text" placeholder="خوارزميات وهياكل البيانات"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] @error('fName') border-red-400 @enderror">
                    @error('fName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">الوصف <span class="text-gray-400 font-normal text-xs">(اختياري)</span></label>
                    <textarea wire:model="fDescription" rows="3" placeholder="وصف مختصر عن محتوى المادة..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A6B3C] resize-none"></textarea>
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
                    {{ $modalMode === 'create' ? 'إضافة المادة' : 'حفظ التعديلات' }}
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
            هل أنت متأكد من حذف مادة <strong class="text-gray-800">"{{ $deleteLabel }}"</strong>؟
            <br><span class="text-xs text-red-500 mt-1 block">سيتم حذف جميع التسجيلات المرتبطة بها.</span>
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
