<?php

namespace App\Livewire\Advisor;

use App\Models\CounselingSession;
use App\Models\Nomination;
use App\Models\User;
use App\Services\SapPredictionService;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends Component
{
    // ── Toast ─────────────────────────────────────────────────────
    public bool   $showToast    = false;
    public string $toastMessage = '';

    // ── Booking modal ─────────────────────────────────────────────
    public bool   $showBooking      = false;
    public ?int   $bookingStudentId = null;
    public string $bookStudentName  = '';
    public string $bookStudentNo    = '';
    public string $bookEmail        = '';
    public string $bookMajor        = '';
    public string $bookSessionType  = 'academic';
    public string $bookDateTime     = '';
    public string $bookReason       = '';

    // ── Nomination modal (card button) ────────────────────────────
    public bool   $showNomination    = false;
    public ?int   $nomStudentId      = null;
    public string $nomStudentName    = '';
    public string $nomStudentScore   = '';
    public string $nomEventType      = 'conference';
    public string $nomEventName      = '';
    public string $nomEventDate      = '';
    public string $nomEventLocation  = '';
    public string $nomMessage        = '';

    // ── Inline nomination form ─────────────────────────────────────
    public ?int   $formStudentId  = null;
    public string $formEventType  = 'conference';
    public string $formOrganizer  = '';
    public string $formEventDate  = '';
    public string $formNotes      = '';

    // ── Accordion ─────────────────────────────────────────────────
    public string $search        = '';
    public ?int   $expandedLevel = null;

    // ── Thresholds ────────────────────────────────────────────────
    private const CRITICAL_SCORE    = 50;
    private const OUTSTANDING_SCORE = 80;

    public function mount(): void
    {
        $this->expandedLevel = 8;
    }

    // ── Toast ─────────────────────────────────────────────────────
    public function toast(string $message): void
    {
        $this->toastMessage = $message;
        $this->showToast    = true;
    }

    public function dismissToast(): void
    {
        $this->showToast = false;
    }

    // ── Accordion ─────────────────────────────────────────────────
    public function toggleLevel(int $level): void
    {
        $this->expandedLevel = ($this->expandedLevel === $level) ? null : $level;
    }

    // ── Nomination modal (from card) ──────────────────────────────
    public function openNomination(int $studentId): void
    {
        $student = User::find($studentId);
        if (!$student) return;

        $enrollments = $student->enrollments;
        $avg = $enrollments->count() > 0 ? round($enrollments->avg('total_score')) : 0;

        $this->nomStudentId      = $studentId;
        $this->nomStudentName    = $student->name;
        $this->nomStudentScore   = $avg . '%';
        $this->nomEventType      = 'conference';
        $this->nomEventName      = '';
        $this->nomEventDate      = '';
        $this->nomEventLocation  = '';
        $this->nomMessage        = '';
        $this->showNomination    = true;
    }

    public function closeNomination(): void
    {
        $this->showNomination = false;
        $this->nomStudentId   = null;
        $this->resetValidation();
    }

    public function submitNomination(): void
    {
        $this->validate([
            'nomEventType' => 'required|string',
            'nomEventName' => 'required|string|max:200',
            'nomEventDate' => 'nullable|date|after_or_equal:today',
        ], [
            'nomEventName.required'       => 'اسم الفعالية مطلوب',
            'nomEventDate.after_or_equal' => 'يجب أن يكون التاريخ في المستقبل',
        ]);

        $exists = Nomination::where('student_id', $this->nomStudentId)
            ->where('advisor_id', auth()->id())
            ->where('event_name', $this->nomEventName)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            $this->addError('nomEventName', 'لديك ترشيح معلق لهذا الطالب في نفس الفعالية');
            return;
        }

        Nomination::create([
            'student_id'     => $this->nomStudentId,
            'advisor_id'     => auth()->id(),
            'event_type'     => $this->nomEventType,
            'event_name'     => $this->nomEventName,
            'event_date'     => $this->nomEventDate ?: null,
            'event_location' => $this->nomEventLocation ?: null,
            'message'        => $this->nomMessage ?: null,
            'status'         => 'pending',
        ]);

        $this->closeNomination();
        $this->toast('✅ تم إرسال الترشيح للطالب');
        unset($this->sentNominations);
    }

    public function cancelNomination(int $nominationId): void
    {
        Nomination::where('id', $nominationId)
            ->where('advisor_id', auth()->id())
            ->where('status', 'pending')
            ->delete();

        $this->toast('تم إلغاء الترشيح');
        unset($this->sentNominations);
    }

    // ── Inline nomination form ─────────────────────────────────────
    public function submitNominationForm(): void
    {
        $this->validate([
            'formStudentId' => 'required|integer|exists:users,id',
            'formEventType' => 'required|string',
        ], [
            'formStudentId.required' => 'يجب اختيار الطالب',
            'formStudentId.exists'   => 'الطالب غير موجود',
        ]);

        Nomination::create([
            'student_id'     => $this->formStudentId,
            'advisor_id'     => auth()->id(),
            'event_type'     => $this->formEventType,
            'event_name'     => $this->formOrganizer ?: $this->formEventType,
            'event_date'     => $this->formEventDate ?: null,
            'event_location' => $this->formOrganizer ?: null,
            'message'        => $this->formNotes ?: null,
            'status'         => 'pending',
        ]);

        // Reset
        $this->formStudentId = null;
        $this->formEventType = 'conference';
        $this->formOrganizer = '';
        $this->formEventDate = '';
        $this->formNotes     = '';
        $this->resetValidation();

        $this->toast('✅ تم إرسال الترشيح للطالب');
        unset($this->sentNominations);
    }

    // ── Booking modal ─────────────────────────────────────────────
    public function openBooking(?int $studentId = null): void
    {
        $this->resetBookingForm();
        $this->bookingStudentId = $studentId;
        $this->showBooking      = true;

        if ($studentId) {
            $student = User::find($studentId);
            if ($student) {
                $this->bookStudentName = $student->name;
                $this->bookStudentNo   = $student->student_id ?? '';
                $this->bookEmail       = $student->email;
                $this->bookMajor       = $student->major ?? '';
            }
        }
    }

    public function closeBooking(): void
    {
        $this->showBooking = false;
        $this->resetBookingForm();
    }

    public function saveSession(): void
    {
        $this->validate([
            'bookStudentName' => 'required|string',
            'bookStudentNo'   => 'required|string',
            'bookEmail'       => 'required|email',
            'bookSessionType' => 'required|string',
            'bookDateTime'    => 'required|date',
        ]);

        $student = $this->bookingStudentId
            ? User::find($this->bookingStudentId)
            : User::where('email', $this->bookEmail)->first();

        if ($student) {
            CounselingSession::create([
                'student_id'   => $student->id,
                'advisor_id'   => auth()->id(),
                'session_type' => $this->bookSessionType,
                'session_at'   => $this->bookDateTime,
                'reason'       => $this->bookReason,
                'status'       => 'unconfirmed',
            ]);
        }

        $this->closeBooking();
        $this->toast('✅ تم حجز الجلسة بنجاح');
        unset($this->todaySessions, $this->recentSessions);
    }

    private function resetBookingForm(): void
    {
        $this->bookStudentName  = '';
        $this->bookStudentNo    = '';
        $this->bookEmail        = '';
        $this->bookMajor        = '';
        $this->bookSessionType  = 'academic';
        $this->bookDateTime     = '';
        $this->bookReason       = '';
        $this->bookingStudentId = null;
    }

    // ── Computed: students ────────────────────────────────────────
    #[Computed]
    public function students(): Collection
    {
        return User::where('role', 'student')
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->with(['enrollments.course'])
            ->get()
            ->map(fn (User $s) => $this->analyseStudent($s))
            ->sortByDesc('avg_score');
    }

    #[Computed]
    public function criticalStudents(): Collection
    {
        return $this->students->filter(fn ($s) => $s['status'] === 'critical')->values();
    }

    #[Computed]
    public function outstandingStudents(): Collection
    {
        return $this->students->filter(fn ($s) => $s['status'] === 'nomination')->values();
    }

    #[Computed]
    public function studentsByLevel(): Collection
    {
        return $this->students
            ->groupBy(fn ($s) => $s['academic_level'] ?? 1)
            ->sortKeysDesc();
    }

    #[Computed]
    public function allStudents(): \Illuminate\Database\Eloquent\Collection
    {
        return User::where('role', 'student')->orderBy('name')->get(['id','name','student_id']);
    }

    #[Computed]
    public function todaySessions(): Collection
    {
        return CounselingSession::where('advisor_id', auth()->id())
            ->whereDate('session_at', today())
            ->with('student')
            ->get();
    }

    #[Computed]
    public function recentSessions(): Collection
    {
        return CounselingSession::where('advisor_id', auth()->id())
            ->with('student')
            ->latest('session_at')
            ->limit(10)
            ->get();
    }

    #[Computed]
    public function sentNominations(): Collection
    {
        return Nomination::where('advisor_id', auth()->id())
            ->with('student')
            ->latest()
            ->get();
    }

    // ── Analysis ──────────────────────────────────────────────────
    private function analyseStudent(User $student): array
    {
        $enrollments = $student->enrollments;

        if ($enrollments->isEmpty()) {
            return $this->emptyAnalysis($student);
        }

        $avgScore = $enrollments->avg('total_score');

        $status = match (true) {
            $avgScore < self::CRITICAL_SCORE     => 'critical',
            $avgScore >= self::OUTSTANDING_SCORE => 'nomination',
            default                              => 'stable',
        };

        $weakCourses = $enrollments->filter(fn ($e) => $e->total_score < 50)
            ->map(fn ($e) => $e->course->name)->values()->toArray();

        $goodCourses = $enrollments->filter(fn ($e) => $e->total_score >= 80)
            ->map(fn ($e) => $e->course->name)->values()->toArray();

        $reason = match ($status) {
            'critical'   => count($weakCourses) > 0
                ? 'تراجع في الاختبارات: ' . implode('، ', array_slice($weakCourses, 0, 2))
                : 'انخفاض ملحوظ في معدل الدرجات',
            'nomination' => count($goodCourses) > 0
                ? 'أداء متميز ومستقر في المواد'
                : 'أداء ممتاز ومستقر',
            default      => 'الأداء في النطاق المقبول',
        };

        $pendingNominations = Nomination::where('student_id', $student->id)
            ->where('status', 'pending')->count();

        // ── SAP AI Prediction ──────────────────────────────────────
        $studentId  = $student->student_id ?? 'S-' . str_pad($student->id, 4, '0', STR_PAD_LEFT);
        $sap        = app(SapPredictionService::class);
        $prediction = $sap->predict($studentId);
        $sapRisk    = $sap->isAtRisk($prediction);
        $sapLabel   = $sap->getLabel($prediction);
        $sapConf    = $sap->getConfidence($prediction);

        return [
            'id'                  => $student->id,
            'name'                => $student->name,
            'student_id'          => $studentId,
            'college'             => $student->college ?? 'كلية الحاسب',
            'major'               => $student->major ?? 'علوم الحاسب',
            'academic_level'      => $student->academic_level ?? 8,
            'gpa'                 => round($student->gpa ?? ($avgScore / 25), 1),
            'avg_score'           => round($avgScore),
            'status'              => $status,
            'reason'              => $reason,
            'weak_courses'        => $weakCourses,
            'good_courses'        => $goodCourses,
            'pending_nominations' => $pendingNominations,
            // AI prediction fields
            'sap_prediction'      => $prediction,
            'sap_risk'            => $sapRisk,
            'sap_label'           => $sapLabel,
            'sap_confidence'      => $sapConf,
        ];
    }

    private function emptyAnalysis(User $student): array
    {
        return [
            'id'                  => $student->id,
            'name'                => $student->name,
            'student_id'          => $student->student_id ?? 'S-' . str_pad($student->id, 4, '0', STR_PAD_LEFT),
            'college'             => $student->college ?? 'كلية الحاسب',
            'major'               => $student->major ?? 'علوم الحاسب',
            'academic_level'      => $student->academic_level ?? 5,
            'gpa'                 => 0,
            'avg_score'           => 0,
            'status'              => 'stable',
            'reason'              => 'لا توجد بيانات أكاديمية مسجلة',
            'weak_courses'        => [],
            'good_courses'        => [],
            'pending_nominations' => 0,
            // AI prediction fields
            'sap_prediction'      => null,
            'sap_risk'            => false,
            'sap_label'           => 'غير متاح',
            'sap_confidence'      => null,
        ];
    }

    public function render()
    {
        return view('livewire.advisor.dashboard')
            ->layout('layouts.app', ['title' => 'لوحة المرشد الأكاديمي']);
    }
}
