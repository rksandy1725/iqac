<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'criterion_id',
        'metric_id',
        'title',
        'file_path',
        'file_type',
        'link_url',
        'document_type',
        'uploaded_by',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

    public function metric(): BelongsTo
    {
        return $this->belongsTo(Metric::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
