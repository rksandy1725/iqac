<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_type',
        'title',
        'meeting_date',
        'meeting_time',
        'venue',
        'agenda',
        'minutes',
        'action_items',
        'status',
        'created_by',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(MeetingAttendee::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('meeting_date', '>=', now())->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
