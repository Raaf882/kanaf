<?php

namespace App\Livewire\Student;

use App\Models\CareerPath;
use App\Models\Enrollment;
use App\Models\StudentCareerPath;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CareerFuture extends Component
{
    // ── Toast ─────────────────────────────────────────────────────
    public bool   $showToast    = false;
    public string $toastMessage = '';

    // ── Detect student level ──────────────────────────────────────
    #[Computed]
    public function isNewStudent(): bool
    {
        $enrollmentCount = Enrollment::where('user_id', Auth::id())->count();
        $level           = Auth::user()->academic_level ?? 10;
        return $enrollmentCount === 0 || $level <= 2;
    }

    // ── All paths (for new students / explore view) ───────────────
    #[Computed]
    public function allPaths(): \Illuminate\Database\Eloquent\Collection
    {
        return CareerPath::with(['experts', 'certifications'])->get();
    }

    // ── Recommended paths (for established students) ──────────────
    #[Computed]
    public function recommendedPaths(): Collection
    {
        $user        = Auth::user();
        $enrollments = Enrollment::where('user_id', $user->id)->with('course')->get();
        $avgScore    = $enrollments->avg('total_score') ?? 0;
        $major       = $user->major ?? '';

        $majorKeywords = [
            'الذكاء الاصطناعي' => ['ذكاء', 'ai', 'machine'],
            'هندسة البرمجيات'   => ['برمجيات', 'software', 'تطوير'],
            'نظم المعلومات'      => ['نظم', 'information', 'إدارة'],
            'علوم الحاسب'        => ['حاسب', 'computer', 'خوارزميات'],
            'الأمن السيبراني'    => ['أمن', 'security', 'cyber'],
            'تحليل البيانات'     => ['بيانات', 'data', 'تحليل'],
        ];

        $paths = $this->allPaths->map(function (CareerPath $path) use ($major, $avgScore, $majorKeywords) {
            $score    = 0;
            $whyParts = [];

            foreach ($majorKeywords as $maj => $keywords) {
                foreach ($keywords as $kw) {
                    if (mb_stripos($major, $kw) !== false || mb_stripos($path->name, $kw) !== false) {
                        $score += 3;
                        $whyParts[] = "تخصصك في {$major} يتوافق مع هذا المسار";
                        break 2;
                    }
                }
            }

            if ($avgScore >= 70) {
                $score += 2;
                $whyParts[] = 'أداؤك المرتفع في المواد التحليلية يدعم توجهك نحو هذا المسار';
            } elseif ($avgScore >= 50) {
                $score += 1;
                $whyParts[] = 'مستواك الأكاديمي مناسب لهذا المسار';
            }

            if (empty($whyParts)) {
                $whyParts[] = 'هذا المسار يفتح آفاقاً مهنية واسعة في سوق العمل السعودي';
            }

            return [
                'path'  => $path,
                'score' => $score,
                'why'   => implode('، ', array_unique($whyParts)),
            ];
        });

        return $paths->sortByDesc('score')->values()->take(3);
    }

    // ── Saved path IDs ────────────────────────────────────────────
    #[Computed]
    public function savedIds(): array
    {
        return StudentCareerPath::where('user_id', Auth::id())
            ->where('is_saved', true)
            ->pluck('career_path_id')
            ->toArray();
    }

    // ── Toggle save ───────────────────────────────────────────────
    public function toggleSave(int $pathId): void
    {
        $pivot = StudentCareerPath::firstOrCreate(
            ['user_id' => Auth::id(), 'career_path_id' => $pathId],
            ['is_recommended' => false, 'is_saved' => false]
        );

        $wasSaved = $pivot->is_saved;
        $pivot->update(['is_saved' => !$wasSaved]);

        $this->toastMessage = $wasSaved
            ? 'تم إزالة المسار من المفضلة'
            : '✅ تم حفظ المسار في المفضلة!';
        $this->showToast = true;

        unset($this->savedIds);
    }

    public function dismissToast(): void
    {
        $this->showToast = false;
    }

    public function render()
    {
        return view('livewire.student.career-future')
            ->layout('layouts.app', ['title' => 'مستقبلك المهني']);
    }
}
