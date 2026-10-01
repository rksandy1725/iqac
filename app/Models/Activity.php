<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'criterion_id',
        'key_indicator_id',
        'metric_id',
        'department_id',
        'title',
        'description',
        'academic_year',
        'status',
        'start_date',
        'end_date',
        'evidence_url',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

    public function keyIndicator(): BelongsTo
    {
        return $this->belongsTo(KeyIndicator::class);
    }

    public function metric(): BelongsTo
    {
        return $this->belongsTo(Metric::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function scopeForAcademicYear($query, string $year)
    {
        return $query->where('academic_year', $year);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
