<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    protected $fillable = ['career_path_id', 'name', 'provider'];

    public function careerPath(): BelongsTo
    {
        return $this->belongsTo(CareerPath::class);
    }
}
