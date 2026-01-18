<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssistantConversation extends Model
{
    protected $fillable = [
        'store_id',
        'user_id',
        'session_id',
    ];

    /**
     * Relación con Store
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(\App\Shared\Models\Store::class);
    }

    /**
     * Relación con User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Shared\Models\User::class);
    }

    /**
     * Relación con Messages
     */
    public function messages(): HasMany
    {
        return $this->hasMany(AssistantMessage::class, 'conversation_id')->orderBy('created_at', 'asc');
    }

    /**
     * Obtener o crear conversación por sesión
     */
    public static function getOrCreateSession(string $sessionId, int $storeId, int $userId): self
    {
        return static::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'store_id' => $storeId,
                'user_id' => $userId,
            ]
        );
    }
}
