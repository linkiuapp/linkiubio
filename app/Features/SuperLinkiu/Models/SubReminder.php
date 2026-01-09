<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubReminder extends Model
{
    protected $table = 'sub_reminders';

    protected $fillable = [
        'subscription_id',
        'payment_id',
        'type',
        'status',
        'sent_at',
        'message_id',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';
    const STATUS_FAILED = 'failed';

    // ==================== RELACIONES ====================

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(SubSubscription::class, 'subscription_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(SubPayment::class, 'payment_id');
    }

    // ==================== ACCESSORS ====================

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'reminder_30d' => '30 días antes',
            'reminder_15d' => '15 días antes',
            'reminder_7d' => '7 días antes',
            'reminder_5d' => '5 días antes',
            'reminder_3d' => '3 días antes',
            'reminder_1d' => '1 día antes',
            'overdue' => 'Vencido',
            default => $this->type,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_SENT => 'Enviado',
            self::STATUS_FAILED => 'Fallido',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_SENT => 'green',
            self::STATUS_FAILED => 'red',
            default => 'gray',
        };
    }

    // ==================== SCOPES ====================

    public function scopeSent($query)
    {
        return $query->where('status', self::STATUS_SENT);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // ==================== MÉTODOS ====================

    public function markAsSent(?string $messageId = null): void
    {
        $this->update([
            'status' => self::STATUS_SENT,
            'sent_at' => now(),
            'message_id' => $messageId,
        ]);
    }

    public function markAsFailed(?string $errorMessage = null): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'error_message' => $errorMessage,
        ]);
    }

    public static function createForSubscription(SubSubscription $subscription, string $type, ?SubPayment $payment = null): self
    {
        return self::create([
            'subscription_id' => $subscription->id,
            'payment_id' => $payment?->id,
            'type' => $type,
            'status' => self::STATUS_PENDING,
        ]);
    }
}
