<?php

namespace App\Livewire\Student;

use App\Models\Assignment;
use App\Models\AttendanceRecord;
use App\Models\Course;
use App\Models\CounselingSession;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CourseDetails extends Component
{
    public Course      $course;
    public ?Enrollment $enrollment = null;
    public ?User       $advisor    = null;

    // ── Stats ──────────────────────────────────────────────────────
    public int   $totalAssignments     = 0;
    public int   $completedAssignments = 0;
    public float $completedTestsPct    = 0;
    public float $absenceRate          = 0;

    // ── Modals: 'guidance' | 'education' | 'decision' | '' ────────
    public string $activeModal = '';

    // ── Booking form ───────────────────────────────────────────────
    public string $bookSessionType = 'academic';
    public string $bookDateTime    = '';
    public string $bookReason      = '';

    // ── Decision simulation ────────────────────────────────────────
    public string $decisionChoice = ''; // 'withdraw' | 'continue'

    // ── Toast ──────────────────────────────────────────────────────
    public bool   $showToast    = false;
    public string $toastMessage = '';
    public string $toastType    = 'success';

    public function mount(Course $course): void
    {
        $this->course   = $course;
        $userId         = Auth::id();
        $this->advisor  = User::where('role', 'advisor')->first();

        $this->enrollment = Enrollment::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        $this->totalAssignments = Assignment::where('course_id', $course->id)->count();

        $this->completedAssignments = $course->assignments()
            ->whereHas('submissions', fn ($q) => $q->where('user_id', $userId)->whereNotNull('submitted_at'))
            ->count();

        if ($this->enrollment) {
            $taken = 0;
            foreach (['quiz1_theory', 'quiz2_theory', 'quiz3_theory', 'mid_theory', 'final_theory'] as $col) {
                if ($this->enrollment->$col > 0) $taken++;
            }
            $this->completedTestsPct = round(($taken / 5) * 100);
        }

        $totalSessions = AttendanceRecord::where('user_id', $userId)
            ->where('course_id', $course->id)->count();
        if ($totalSessions > 0) {
            $absent = AttendanceRecord::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->where('status', 'absent')->count();
            $this->absenceRate = round(($absent / $totalSessions) * 100);
        }
    }

    // ── Modal control ──────────────────────────────────────────────
    public function openModal(string $modal): void
    {
        $this->activeModal    = $modal;
        $this->decisionChoice = '';
        $this->resetValidation();
    }

    public function closeModal(): void
    {
        $this->activeModal     = '';
        $this->bookSessionType = 'academic';
        $this->bookDateTime    = '';
        $this->bookReason      = '';
        $this->decisionChoice  = '';
    }

    // ── Book a counseling session ──────────────────────────────────
    public function bookSession(): void
    {
        $this->validate([
            'bookSessionType' => 'required|string',
            'bookDateTime'    => 'required|date',
        ], [
            'bookDateTime.required' => 'وقت الجلسة مطلوب',
            'bookDateTime.date'     => 'تاريخ غير صحيح',
        ]);

        if ($this->advisor) {
            CounselingSession::create([
                'student_id'   => Auth::id(),
                'advisor_id'   => $this->advisor->id,
                'session_type' => $this->bookSessionType,
                'session_at'   => $this->bookDateTime,
                'reason'       => $this->bookReason ?: 'طلب إرشاد للمادة: ' . $this->course->name,
                'status'       => 'unconfirmed',
            ]);
        }

        $this->closeModal();
        $this->toastMessage = '✅ تم إرسال طلب الجلسة! سيتواصل معك مرشدك قريباً.';
        $this->toastType    = 'success';
        $this->showToast    = true;
    }

    // ── Decision simulation choice ─────────────────────────────────
    public function chooseDecision(string $choice): void
    {
        $this->decisionChoice = $choice;
    }

    // ── Toast dismiss ──────────────────────────────────────────────
    public function dismissToast(): void
    {
        $this->showToast = false;
    }

    public function render()
    {
        return view('livewire.student.course-details')
            ->layout('layouts.app', ['title' => $this->course->name]);
    }
}
