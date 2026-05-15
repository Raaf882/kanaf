<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Students extends Component
{
    use WithPagination;

    public string $search = '';

    public string $toastMessage = '';
    public bool   $showToast    = false;
    public string $toastType    = 'success';

    public bool   $showModal = false;
    public string $modalMode = 'create';
    public ?int   $editId    = null;

    public bool  $showDetail   = false;
    public ?int  $detailUserId = null;

    public bool   $showDeleteConfirm = false;
    public ?int   $deleteId          = null;
    public string $deleteLabel       = '';

    public string $fName      = '';
    public string $fEmail     = '';
    public string $fPassword  = '';
    public string $fStudentId = '';
    public string $fCollege   = '';
    public string $fMajor     = '';
    public string $fLevel     = '1';

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
        $this->modalMode = 'edit';
        $this->editId    = $id;
        $u = User::findOrFail($id);
        $this->fName      = $u->name;
        $this->fEmail     = $u->email;
        $this->fStudentId = $u->student_id     ?? '';
        $this->fCollege   = $u->college        ?? '';
        $this->fMajor     = $u->major          ?? '';
        $this->fLevel     = (string)($u->academic_level ?? '1');
        $this->showModal  = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $rules = [
            'fName'  => 'required|string|max:100',
            'fEmail' => 'required|email|max:150|unique:users,email' . ($this->editId ? ",{$this->editId}" : ''),
        ];
        if ($this->modalMode === 'create') {
            $rules['fPassword'] = 'required|min:6';
        }

        $this->validate($rules, [
            'fName.required'     => 'الاسم مطلوب',
            'fEmail.required'    => 'البريد الإلكتروني مطلوب',
            'fEmail.unique'      => 'البريد الإلكتروني مستخدم بالفعل',
            'fPassword.required' => 'كلمة المرور مطلوبة',
            'fPassword.min'      => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        ]);

        $data = [
            'name'           => $this->fName,
            'email'          => $this->fEmail,
            'role'           => 'student',
            'student_id'     => $this->fStudentId ?: null,
            'college'        => $this->fCollege    ?: null,
            'major'          => $this->fMajor      ?: null,
            'academic_level' => (int)$this->fLevel ?: null,
        ];

        if ($this->fPassword) {
            $data['password'] = Hash::make($this->fPassword);
        }

        if ($this->modalMode === 'edit') {
            User::findOrFail($this->editId)->update($data);
            $this->toast('تم تحديث بيانات الطالب بنجاح');
        } else {
            User::create($data);
            $this->toast('تمت إضافة الطالب بنجاح');
        }

        $this->closeModal();
    }

    public function openDetail(int $userId): void
    {
        $this->detailUserId = $userId;
        $this->showDetail   = true;
    }

    public function closeDetail(): void
    {
        $this->showDetail   = false;
        $this->detailUserId = null;
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
        User::findOrFail($this->deleteId)->delete();
        $this->showDeleteConfirm = false;
        $this->deleteId          = null;
        $this->showDetail        = false;
        $this->detailUserId      = null;
        $this->toast('تم حذف الطالب بنجاح');
    }

    private function resetForm(): void
    {
        $this->fName = $this->fEmail = $this->fPassword = $this->fStudentId = '';
        $this->fCollege = $this->fMajor = '';
        $this->fLevel = '1';
        $this->resetValidation();
    }

    public function render()
    {
        $students = User::where('role', 'student')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhere('major', 'like', "%{$this->search}%")
                ->orWhere('student_id', 'like', "%{$this->search}%"))
            ->with('enrollments')
            ->latest()
            ->paginate(15);

        $detailUser = $this->detailUserId
            ? User::with(['enrollments.course'])->find($this->detailUserId)
            : null;

        return view('livewire.admin.students', compact('students', 'detailUser'))
            ->layout('layouts.app', ['title' => 'إدارة الطلاب']);
    }
}
