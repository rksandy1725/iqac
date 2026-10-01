<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Metric extends Model
{
    use HasFactory;

    protected $fillable = ['key_indicator_id', 'metric_code', 'metric_name', 'description', 'data_template_type'];

    public function keyIndicator(): BelongsTo
    {
        return $this->belongsTo(KeyIndicator::class);
    }

    public function criterion(): BelongsTo
    {
        return $this->hasOneThrough(Criterion::class, KeyIndicator::class, 'id', 'id', 'key_indicator_id', 'criterion_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
