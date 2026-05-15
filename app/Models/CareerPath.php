<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CareerPath extends Model
{
    protected $fillable = [
        'name', 'description', 'core_skills', 'work_fields', 'suggested_plan', 'icon',
    ];

    protected $casts = [
        'core_skills'    => 'array',
        'work_fields'    => 'array',
        'suggested_plan' => 'array',
    ];

    public function experts(): HasMany
    {
        return $this->hasMany(Expert::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    public function studentPaths(): HasMany
    {
        return $this->hasMany(StudentCareerPath::class);
    }
}
