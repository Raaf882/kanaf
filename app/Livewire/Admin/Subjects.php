<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Subjects extends Component
{
    use WithPagination;

    public string $search = '';

    public string $toastMessage = '';
    public bool   $showToast    = false;
    public string $toastType    = 'success';

    public bool   $showModal = false;
    public string $modalMode = 'create';
    public ?int   $editId    = null;

    public bool   $showDeleteConfirm = false;
    public ?int   $deleteId          = null;
    public string $deleteLabel       = '';

    public string $fCode        = '';
    public string $fName        = '';
    public string $fCredits     = '3';
    public string $fDescription = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function toast(string $message, string $type = 'success'): void
    {
        $this->toastMessage = $message;
        $this->toastType    = $type;
        $this->showToast    = true;
    }

    public function dismissToast(): void
    {
        $this->showToast = false;
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->modalMode = 'create';
        $this->editId    = null;
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $this->resetForm();
        $this->modalMode    = 'edit';
        $this->editId       = $id;
        $c = Course::findOrFail($id);
        $this->fCode        = $c->code;
        $this->fName        = $c->name;
        $this->fCredits     = (string)$c->credits;
        $this->fDescription = $c->description ?? '';
        $this->showModal    = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $this->validate([
            'fCode'    => 'required|string|max:20|unique:courses,code' . ($this->editId ? ",{$this->editId}" : ''),
            'fName'    => 'required|string|max:150',
            'fCredits' => 'required|integer|min:1|max:6',
        ], [
            'fCode.required'    => 'رمز المادة مطلوب',
            'fName.required'    => 'اسم المادة مطلوب',
            'fCode.unique'      => 'رمز المادة موجود مسبقاً',
            'fCredits.required' => 'الساعات المعتمدة مطلوبة',
        ]);

        $data = [
            'code'        => strtoupper($this->fCode),
            'name'        => $this->fName,
            'credits'     => (int)$this->fCredits,
            'description' => $this->fDescription ?: null,
        ];

        if ($this->modalMode === 'edit') {
            Course::findOrFail($this->editId)->update($data);
            $this->toast('تم تحديث المادة بنجاح');
        } else {
            Course::create($data);
            $this->toast('تمت إضافة المادة بنجاح');
        }

        $this->closeModal();
    }

    public function confirmDelete(int $id, string $label): void
    {
        $this->deleteId          = $id;
        $this->deleteLabel       = $label;
        $this->showDeleteConfirm = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteConfirm = false;
        $this->deleteId          = null;
    }

    public function doDelete(): void
    {
        Course::findOrFail($this->deleteId)->delete();
        $this->showDeleteConfirm = false;
        $this->deleteId          = null;
        $this->toast('تم حذف المادة بنجاح');
    }

    private function resetForm(): void
    {
        $this->fCode = $this->fName = $this->fDescription = '';
        $this->fCredits = '3';
        $this->resetValidation();
    }

    public function render()
    {
        $subjects = Course::withCount('enrollments')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%")
                ->orWhere('description', 'like', "%{$this->search}%"))
            ->orderBy('code')
            ->paginate(15);

        return view('livewire.admin.subjects', compact('subjects'))
            ->layout('layouts.app', ['title' => 'إدارة المواد الدراسية']);
    }
}
