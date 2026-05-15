<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nomination extends Model
{
    protected $fillable = [
        'student_id',
        'advisor_id',
        'event_type',
        'event_name',
        'event_date',
        'event_location',
        'message',
        'status',
        'responded_at',
    ];

    protected $casts = [
        'event_date'   => 'date',
        'responded_at' => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function advisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    // ── Accessors ─────────────────────────────────────────────────
    public function getEventTypeArabicAttribute(): string
    {
        return match ($this->event_type) {
            'conference'  => 'مؤتمر',
            'hackathon'   => 'هاكاثون',
            'activity'    => 'فعالية',
            'competition' => 'مسابقة',
            'training'    => 'تدريب',
            default       => $this->event_type,
        };
    }

    public function getStatusArabicAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'بانتظار الرد',
            'accepted' => 'تم القبول',
            'rejected' => 'تم الرفض',
            default    => $this->status,
        };
    }

    public function getStatusColorsAttribute(): string
    {
        return match ($this->status) {
            'accepted' => 'bg-green-100 text-[#1A6B3C]',
            'rejected' => 'bg-red-100 text-red-600',
            default    => 'bg-amber-100 text-amber-700',
        };
    }

    public function getEventTypeIconAttribute(): string
    {
        return match ($this->event_type) {
            'conference'  => '🎤',
            'hackathon'   => '💻',
            'activity'    => '🎯',
            'competition' => '🏆',
            'training'    => '📚',
            default       => '📋',
        };
    }
}
