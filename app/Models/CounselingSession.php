<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounselingSession extends Model
{
    protected $fillable = [
        'student_id', 'advisor_id', 'session_type',
        'session_at', 'reason', 'status', 'attended',
    ];

    protected $casts = [
        'session_at' => 'datetime',
        'attended'   => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function getSessionTypeArabicAttribute(): string
    {
        return match ($this->session_type) {
            'academic'   => 'إرشاد أكاديمي',
            'career'     => 'إرشاد مهني',
            'personal'   => 'دعم شخصي',
            'follow_up'  => 'متابعة دورية',
            default      => $this->session_type,
        };
    }

    public function getStatusArabicAttribute(): string
    {
        return match ($this->status) {
            'confirmed'   => 'مؤكدة',
            'unconfirmed' => 'غير مؤكدة',
            'postponed'   => 'تم التأجيل',
            default       => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'confirmed'   => 'green',
            'unconfirmed' => 'yellow',
            'postponed'   => 'red',
            default       => 'gray',
        };
    }
}
