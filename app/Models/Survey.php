<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'title',
        'period_start',
        'period_end',
        'is_open',
        'quadrant_threshold',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'quadrant_threshold' => 'float',
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
