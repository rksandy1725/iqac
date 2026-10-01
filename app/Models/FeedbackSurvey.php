<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeedbackSurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'target_group',
        'criterion_id',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(FeedbackResponse::class, 'survey_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
