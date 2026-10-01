<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description', 'hod_id'];

    public function hod(): BelongsTo
    {
        return $this->belongsTo(User::class, 'hod_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
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
