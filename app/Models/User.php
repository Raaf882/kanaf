<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CounselingSession;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'student_id',
        'college', 'major', 'department', 'job_number', 'academic_level', 'gpa',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0];
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function careerPaths(): HasMany
    {
        return $this->hasMany(StudentCareerPath::class);
    }

    public function counselingSessions(): HasMany
    {
        return $this->hasMany(CounselingSession::class, 'student_id');
    }

    public function advisorSessions(): HasMany
    {
        return $this->hasMany(CounselingSession::class, 'advisor_id');
    }

    public function nominations(): HasMany
    {
        return $this->hasMany(Nomination::class, 'student_id');
    }

    public function sentNominations(): HasMany
    {
        return $this->hasMany(Nomination::class, 'advisor_id');
    }

    public function recommendedCareerPath(): ?CareerPath
    {
        $pivot = $this->careerPaths()->where('is_recommended', true)->with('careerPath')->first();

        return $pivot?->careerPath;
    }
}
