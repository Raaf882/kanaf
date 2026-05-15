<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expert extends Model
{
    protected $fillable = ['career_path_id', 'name', 'title', 'company', 'linkedin_url', 'avatar'];

    public function careerPath(): BelongsTo
    {
        return $this->belongsTo(CareerPath::class);
    }
}
