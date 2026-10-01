<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KeyIndicator extends Model
{
    use HasFactory;

    protected $fillable = ['criterion_id', 'ki_code', 'ki_name', 'description'];

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

    public function metrics(): HasMany
    {
        return $this->hasMany(Metric::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
