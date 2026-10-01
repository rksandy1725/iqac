<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AqarReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year',
        'prepared_by',
        'status',
        'json_data',
        'remarks',
        'submitted_to_naac_on',
    ];

    protected $casts = [
        'json_data' => 'array',
        'submitted_to_naac_on' => 'datetime',
    ];

    public function preparer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function scopeForYear($query, string $year)
    {
        return $query->where('academic_year', $year);
    }
}
