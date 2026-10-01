<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IqacMember extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'role_in_iqac', 'designation', 'term_start', 'term_end'];

    protected $casts = [
        'term_start' => 'date',
        'term_end' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
