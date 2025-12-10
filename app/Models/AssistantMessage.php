<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssistantMessage extends Model
{
    protected $fillable = [
        'conversation_id',
        'role',
        'message',
        'metadata',
        'tokens_used',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Relación con Conversation
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AssistantConversation::class);
    }
}
