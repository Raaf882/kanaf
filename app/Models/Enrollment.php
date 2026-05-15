<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'semester',
        'quiz1_theory', 'quiz2_theory', 'quiz3_theory', 'mid_theory', 'final_theory',
        'quiz1_practical', 'quiz2_practical', 'quiz3_practical', 'mid_practical', 'final_practical',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getTotalScoreAttribute(): int
    {
        return $this->quiz1_theory + $this->quiz2_theory + $this->quiz3_theory
            + $this->mid_theory + $this->final_theory
            + $this->quiz1_practical + $this->quiz2_practical + $this->quiz3_practical
            + $this->mid_practical + $this->final_practical;
    }

    /**
     * Level based on completed portions (excludes empty final grades).
     */
    public function getCourseLevelAttribute(): string
    {
        $earned    = 0;
        $available = 12; // 3 theory quizzes + 3 practical quizzes (always present)

        $earned += $this->quiz1_theory + $this->quiz2_theory + $this->quiz3_theory;
        $earned += $this->quiz1_practical + $this->quiz2_practical + $this->quiz3_practical;

        if ($this->mid_theory > 0) {
            $available += 20;
            $earned    += $this->mid_theory;
        }
        if ($this->final_theory > 0) {
            $available += 20;
            $earned    += $this->final_theory;
        }
        if ($this->mid_practical > 0) {
            $available += 20;
            $earned    += $this->mid_practical;
        }
        if ($this->final_practical > 0) {
            $available += 20;
            $earned    += $this->final_practical;
        }

        $pct = $available > 0 ? ($earned / $available) * 100 : 0;

        return match (true) {
            $pct >= 90 => 'ممتاز',
            $pct >= 80 => 'جيد جداً',
            $pct >= 70 => 'جيد',
            $pct >= 60 => 'مقبول',
            default    => 'ضعيف',
        };
    }

    /**
     * Overall performance badge based on total / 100.
     */
    public function getPerformanceBadgeAttribute(): string
    {
        return match (true) {
            $this->total_score >= 80 => 'أداء جيد',
            $this->total_score >= 55 => 'أداء متوسط',
            default                  => 'أداء يحتاج تحسين',
        };
    }

    /**
     * The كنف option most suited for this student in this course.
     * Returns: 'education' | 'guidance' | 'decision'
     */
    public function getKanafRecommendationAttribute(): string
    {
        $score = $this->total_score;

        if ($score < 40) {
            return 'decision';
        }

        if ($score < 65) {
            return 'education';
        }

        return 'guidance';
    }

    /**
     * Reason text for the current course level.
     */
    public function getLevelReasonAttribute(): string
    {
        if ($this->final_theory > 0 && $this->final_theory < ($this->mid_theory * 0.7)) {
            return 'انخفاض بسيط في درجات آخر اختبار';
        }

        if ($this->quiz2_theory === 0 || $this->quiz2_practical === 0) {
            return 'غياب في بعض الكويزات أثّر على المجموع';
        }

        return 'الأداء مستقر بناءً على الدرجات الحالية';
    }
}
