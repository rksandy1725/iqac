<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criterion extends Model
{
    use HasFactory;

    protected $fillable = ['criterion_number', 'name', 'description', 'weightage'];

    public function keyIndicators(): HasMany
    {
        return $this->hasMany(KeyIndicator::class);
    }

    public function metrics(): HasMany
    {
        return $this->hasManyThrough(Metric::class, KeyIndicator::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function feedbackSurveys(): HasMany
    {
        return $this->hasMany(FeedbackSurvey::class);
    }
}
