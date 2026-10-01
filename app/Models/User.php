<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'phone',
        'designation',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function iqacMemberships(): HasMany
    {
        return $this->hasMany(IqacMember::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'created_by');
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class, 'created_by');
    }

    public function uploadedDocuments(): HasMany
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCoordinator(): bool
    {
        return $this->role === 'coordinator';
    }

    public function isHod(): bool
    {
        return $this->role === 'hod';
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles);
    }
}
