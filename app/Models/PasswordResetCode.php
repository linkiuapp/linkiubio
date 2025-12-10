<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'token',
        'expires_at',
        'used_at',
        'ip_address',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    /**
     * Relación con el usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Shared\Models\User::class);
    }

    /**
     * Verificar si el código está expirado
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Verificar si el código ya fue usado
     */
    public function isUsed(): bool
    {
        return $this->used_at !== null;
    }

    /**
     * Verificar si el código es válido
     */
    public function isValid(): bool
    {
        return !$this->isExpired() && !$this->isUsed();
    }

    /**
     * Marcar código como usado
     */
    public function markAsUsed(): void
    {
        $this->update(['used_at' => now()]);
    }

    /**
     * Scope para códigos válidos
     */
    public function scopeValid($query)
    {
        return $query->where('expires_at', '>', now())
                    ->whereNull('used_at');
    }
}
