<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'respondent_name',
        'respondent_email',
        'rating',
        'comments',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
    ];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(FeedbackSurvey::class, 'survey_id');
    }
}
