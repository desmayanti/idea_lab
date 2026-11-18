<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'idea_id',
        'survey_response_id',
        'respondent_name',
        'respondent_class',
        'feasibility',
        'impact',
        'comment'
    ];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function surveyResponse()
    {
        return $this->belongsTo(SurveyResponse::class, 'survey_response_id');
    }
}
