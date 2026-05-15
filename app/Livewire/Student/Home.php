<?php

namespace App\Livewire\Student;

use App\Models\Nomination;
use App\Models\User;
use App\Services\SapPredictionService;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Home extends Component
{
    // ── Toast ─────────────────────────────────────────────────────
    public bool   $showToast    = false;
    public string $toastMessage = '';
    public string $toastType    = 'success';

    #[Computed]
    public function student(): User
    {
        return auth()->user()->load(['enrollments.course', 'careerPaths.careerPath']);
    }

    #[Computed]
    public function advisor(): ?User
    {
        return User::where('role', 'advisor')->first();
    }

    #[Computed]
    public function enrollments()
    {
        return $this->student->enrollments->sortByDesc('total_score');
    }

    #[Computed]
    public function savedPaths()
    {
        return $this->student->careerPaths()->with('careerPath')->get();
    }

    #[Computed]
    public function pendingNominations()
    {
        return Nomination::where('student_id', auth()->id())
            ->where('status', 'pending')
            ->with('advisor')
            ->latest()
            ->get();
    }

    #[Computed]
    public function pastNominations()
    {
        return Nomination::where('student_id', auth()->id())
            ->whereIn('status', ['accepted', 'rejected'])
            ->with('advisor')
            ->latest()
            ->limit(5)
            ->get();
    }

    // ── Respond to nomination ─────────────────────────────────────
    public function respondNomination(int $nominationId, string $response): void
    {
        $nomination = Nomination::where('id', $nominationId)
            ->where('student_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$nomination) return;

        $nomination->update([
            'status'       => $response, // 'accepted' | 'rejected'
            'responded_at' => now(),
        ]);

        $msg = $response === 'accepted'
            ? '🎉 تم قبول الترشيح! سيتواصل معك مرشدك الأكاديمي قريباً.'
            : 'تم رفض الترشيح.';

        $this->toastMessage = $msg;
        $this->toastType    = $response === 'accepted' ? 'success' : 'neutral';
        $this->showToast    = true;

        unset($this->pendingNominations, $this->pastNominations);
    }

    public function dismissToast(): void
    {
        $this->showToast = false;
    }

    #[Computed]
    public function stats(): array
    {
        $enrollments = $this->enrollments;
        $total       = $enrollments->count();

        if ($total === 0) {
            return ['improvement' => 0, 'courses' => 0, 'gpa' => 0.0, 'status' => 'مستقر', 'status_color' => 'text-amber-600'];
        }

        $avgScore    = $enrollments->avg('total_score');
        $gpa         = round(($avgScore / 100) * 5, 2);
        $aboveAvg    = $enrollments->filter(fn ($e) => $e->total_score >= 70)->count();
        $improvement = $total > 0 ? round(($aboveAvg / $total) * 100) : 0;

        $status = match (true) {
            $avgScore >= 80 => 'متميز',
            $avgScore >= 60 => 'جيد',
            $avgScore >= 50 => 'مستقر',
            default         => 'يحتاج متابعة',
        };

        return [
            'improvement'  => $improvement,
            'courses'      => $total,
            'gpa'          => $gpa,
            'status'       => $status,
            'status_color' => match ($status) {
                'متميز'         => 'text-[#1A6B3C]',
                'جيد'           => 'text-blue-600',
                'مستقر'         => 'text-amber-600',
                default         => 'text-red-600',
            },
        ];
    }

    // ── SAP AI Prediction ──────────────────────────────────────────
    #[Computed]
    public function sapPrediction(): array
    {
        $user      = auth()->user();
        $studentId = $user->student_id ?? 'S-' . str_pad($user->id, 4, '0', STR_PAD_LEFT);

        $sap        = app(SapPredictionService::class);
        $prediction = $sap->predict($studentId);

        return [
            'available'  => $prediction !== null,
            'raw'        => $prediction,
            'risk'       => $sap->isAtRisk($prediction),
            'label'      => $sap->getLabel($prediction),
            'confidence' => $sap->getConfidence($prediction),
        ];
    }

    public function render()
    {
        return view('livewire.student.home')
            ->layout('layouts.app', ['title' => 'الرئيسية']);
    }
}
