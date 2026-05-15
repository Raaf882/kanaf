<?php

namespace App\Livewire\Admin;

use App\Models\CareerPath;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Dashboard extends Component
{
    // ── Navigation ────────────────────────────────────────────────
    public string $activeSection = 'overview';
    public string $search        = '';

    // ── Toast notification ────────────────────────────────────────
    public string $toastMessage = '';
    public bool   $showToast    = false;
    public string $toastType    = 'success'; // success | error

    // ── Modal state ───────────────────────────────────────────────
    public bool    $showModal  = false;
    public string  $modalType  = '';   // student|advisor|course|career_path
    public string  $modalMode  = 'create'; // create|edit
    public ?int    $editId     = null;

    // ── Detail / View drawer ──────────────────────────────────────
    public bool  $showDetail   = false;
    public ?int  $detailUserId = null;

    // ── Delete confirm ────────────────────────────────────────────
    public bool   $showDeleteConfirm = false;
    public string $deleteType        = '';
    public ?int   $deleteId          = null;
    public string $deleteLabel       = '';

    // ── Student form ──────────────────────────────────────────────
    public string $fName      = '';
    public string $fEmail     = '';
    public string $fPassword  = '';
    public string $fStudentId = '';
    public string $fCollege   = '';
    public string $fMajor     = '';
    public string $fLevel     = '1';

    // ── Advisor form ──────────────────────────────────────────────
    public string $fJobNumber  = '';
    public string $fDepartment = '';

    // ── Course form ───────────────────────────────────────────────
    public string $fCode        = '';
    public string $fCredits     = '3';
    public string $fDescription = '';

    // ── Career path form ─────────────────────────────────────────
    public string $fPathName   = '';
    public string $fPathDesc   = '';
    public string $fPathSkills = '';
    public string $fPathFields = '';

    // ── Sections ─────────────────────────────────────────────────
    public function setSection(string $section): void
    {
        $this->activeSection = $section;
        $this->search        = '';
        $this->showDetail    = false;
    }

    // ── Toast ─────────────────────────────────────────────────────
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

    // ── Detail drawer ─────────────────────────────────────────────
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

    // ── Open modals ──────────────────────────────────────────────
    public function openCreate(string $type): void
    {
        $this->resetForms();
        $this->modalType = $type;
        $this->modalMode = 'create';
        $this->editId    = null;
        $this->showModal = true;
    }

    public function openEdit(string $type, int $id): void
    {
        $this->resetForms();
        $this->modalType = $type;
        $this->modalMode = 'edit';
        $this->editId    = $id;

        match ($type) {
            'student', 'advisor' => $this->fillUserForm($id),
            'course'             => $this->fillCourseForm($id),
            'career_path'        => $this->fillPathForm($id),
            default              => null,
        };

        $this->showModal = true;
    }

    private function fillUserForm(int $id): void
    {
        $user              = User::findOrFail($id);
        $this->fName       = $user->name;
        $this->fEmail      = $user->email;
        $this->fStudentId  = $user->student_id ?? '';
        $this->fCollege    = $user->college    ?? '';
        $this->fMajor      = $user->major      ?? '';
        $this->fLevel      = (string)($user->academic_level ?? '1');
        $this->fJobNumber  = $user->job_number  ?? '';
        $this->fDepartment = $user->department  ?? '';
    }

    private function fillCourseForm(int $id): void
    {
        $c                  = Course::findOrFail($id);
        $this->fCode        = $c->code;
        $this->fName        = $c->name;
        $this->fCredits     = (string)$c->credits;
        $this->fDescription = $c->description ?? '';
    }

    private function fillPathForm(int $id): void
    {
        $p                 = CareerPath::findOrFail($id);
        $this->fPathName   = $p->name;
        $this->fPathDesc   = $p->description;
        $this->fPathSkills = implode('، ', $p->core_skills ?? []);
        $this->fPathFields = implode('، ', $p->work_fields ?? []);
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForms();
    }

    // ── Save ─────────────────────────────────────────────────────
    public function save(): void
    {
        match ($this->modalType) {
            'student'     => $this->saveUser('student'),
            'advisor'     => $this->saveUser('advisor'),
            'course'      => $this->saveCourse(),
            'career_path' => $this->savePath(),
            default       => null,
        };
    }

    private function saveUser(string $role): void
    {
        $rules = [
            'fName'  => 'required|string|max:100',
            'fEmail' => 'required|email|max:150|unique:users,email' . ($this->editId ? ",{$this->editId}" : ''),
        ];

        if ($this->modalMode === 'create') {
            $rules['fPassword'] = ['required', 'min:6'];
        }

        $this->validate($rules, [
            'fName.required'  => 'الاسم مطلوب',
            'fEmail.required' => 'البريد الإلكتروني مطلوب',
            'fEmail.unique'   => 'البريد الإلكتروني مستخدم بالفعل',
            'fPassword.required' => 'كلمة المرور مطلوبة',
            'fPassword.min'      => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        ]);

        $data = [
            'name'       => $this->fName,
            'email'      => $this->fEmail,
            'role'       => $role,
            'college'    => $this->fCollege    ?: null,
            'department' => $this->fDepartment ?: null,
        ];

        if ($role === 'student') {
            $data['student_id']     = $this->fStudentId ?: null;
            $data['major']          = $this->fMajor     ?: null;
            $data['academic_level'] = (int)$this->fLevel ?: null;
        } else {
            $data['job_number'] = $this->fJobNumber ?: null;
        }

        if ($this->fPassword) {
            $data['password'] = Hash::make($this->fPassword);
        }

        if ($this->modalMode === 'edit' && $this->editId) {
            User::findOrFail($this->editId)->update($data);
            $label = $role === 'student' ? 'تم تحديث بيانات الطالب' : 'تم تحديث بيانات المرشد';
        } else {
            User::create($data);
            $label = $role === 'student' ? 'تمت إضافة الطالب بنجاح' : 'تمت إضافة المرشد بنجاح';
        }

        $this->closeModal();
        $this->toast($label);
    }

    private function saveCourse(): void
    {
        $this->validate([
            'fCode'    => 'required|string|max:20|unique:courses,code' . ($this->editId ? ",{$this->editId}" : ''),
            'fName'    => 'required|string|max:150',
            'fCredits' => 'required|integer|min:1|max:6',
        ], [
            'fCode.required'  => 'رمز المادة مطلوب',
            'fName.required'  => 'اسم المادة مطلوب',
            'fCode.unique'    => 'رمز المادة موجود مسبقاً',
            'fCredits.required' => 'الساعات المعتمدة مطلوبة',
        ]);

        $data = [
            'code'        => strtoupper($this->fCode),
            'name'        => $this->fName,
            'credits'     => (int)$this->fCredits,
            'description' => $this->fDescription ?: null,
        ];

        if ($this->modalMode === 'edit' && $this->editId) {
            Course::findOrFail($this->editId)->update($data);
            $this->toast('تم تحديث المادة بنجاح');
        } else {
            Course::create($data);
            $this->toast('تمت إضافة المادة بنجاح');
        }

        $this->closeModal();
    }

    private function savePath(): void
    {
        $this->validate([
            'fPathName' => 'required|string|max:150',
            'fPathDesc' => 'required|string',
        ], [
            'fPathName.required' => 'اسم المسار مطلوب',
            'fPathDesc.required' => 'وصف المسار مطلوب',
        ]);

        $skills = array_values(array_filter(array_map('trim', explode('،', $this->fPathSkills))));
        $fields = array_values(array_filter(array_map('trim', explode('،', $this->fPathFields))));

        $data = [
            'name'        => $this->fPathName,
            'description' => $this->fPathDesc,
            'core_skills' => $skills,
            'work_fields' => $fields,
        ];

        if ($this->modalMode === 'edit' && $this->editId) {
            CareerPath::findOrFail($this->editId)->update($data);
            $this->toast('تم تحديث المسار بنجاح');
        } else {
            CareerPath::create($data);
            $this->toast('تمت إضافة المسار بنجاح');
        }

        $this->closeModal();
    }

    // ── Delete ────────────────────────────────────────────────────
    public function confirmDelete(string $type, int $id, string $label): void
    {
        $this->deleteType        = $type;
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
        match ($this->deleteType) {
            'student', 'advisor' => User::findOrFail($this->deleteId)->delete(),
            'course'             => Course::findOrFail($this->deleteId)->delete(),
            'career_path'        => CareerPath::findOrFail($this->deleteId)->delete(),
            default              => null,
        };

        $this->showDeleteConfirm = false;
        $this->deleteId          = null;
        $this->toast('تم الحذف بنجاح', 'success');
    }

    // ── Helpers ───────────────────────────────────────────────────
    private function resetForms(): void
    {
        $this->fName = $this->fEmail = $this->fPassword = $this->fStudentId = '';
        $this->fCollege = $this->fMajor = $this->fJobNumber = $this->fDepartment = '';
        $this->fCode = $this->fDescription = '';
        $this->fPathName = $this->fPathDesc = $this->fPathSkills = $this->fPathFields = '';
        $this->fLevel   = '1';
        $this->fCredits = '3';
        $this->resetValidation();
    }

    // ── Render ────────────────────────────────────────────────────
    public function render()
    {
        $stats = [
            'students'     => User::where('role', 'student')->count(),
            'advisors'     => User::where('role', 'advisor')->count(),
            'courses'      => Course::count(),
            'career_paths' => CareerPath::count(),
            'enrollments'  => Enrollment::count(),
            'critical'     => User::where('role', 'student')->with('enrollments')
                ->get()->filter(fn($u) => $u->enrollments->avg('total_score') < 50 && $u->enrollments->count() > 0)->count(),
        ];

        $recentStudents = User::where('role', 'student')->latest()->take(5)->get();

        $students = User::where('role', 'student')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhere('major', 'like', "%{$this->search}%"))
            ->with('enrollments')
            ->latest()->get();

        $advisors = User::where('role', 'advisor')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhere('department', 'like', "%{$this->search}%"))
            ->latest()->get();

        $courses = Course::withCount('enrollments')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%"))
            ->orderBy('code')->get();

        $careerPaths = CareerPath::withCount('experts')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->get();

        // Detail user (for drawer)
        $detailUser = $this->detailUserId
            ? User::with(['enrollments.course'])->find($this->detailUserId)
            : null;

        return view('livewire.admin.dashboard', compact(
            'stats', 'recentStudents', 'students', 'advisors', 'courses', 'careerPaths', 'detailUser'
        ))->layout('layouts.app', ['title' => 'لوحة الإدارة']);
    }
}
