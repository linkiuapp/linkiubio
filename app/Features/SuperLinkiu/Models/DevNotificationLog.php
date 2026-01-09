<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevNotificationLog extends Model
{
    protected $table = 'dev_notification_logs';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'recipient_phone',
        'recipient_type',
        'message_id',
        'status',
        'payload',
        'error_message',
        'project_id',
        'task_id',
        'client_id',
        'created_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
    ];

    const TYPE_CLIENT_UPDATE = 'client_update';
    const TYPE_DAILY_SUMMARY = 'daily_summary';
    const TYPE_TASK_REMINDER = 'task_reminder';
    const TYPE_WEBHOOK_RESPONSE = 'webhook_response';

    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_READ = 'read';
    const STATUS_FAILED = 'failed';

    const RECIPIENT_CLIENT = 'client';
    const RECIPIENT_ADMIN = 'admin';

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    /**
     * Proyecto relacionado
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(DevProject::class, 'project_id');
    }

    /**
     * Tarea relacionada
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(DevTask::class, 'task_id');
    }

    /**
     * Cliente relacionado
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(DevClient::class, 'client_id');
    }

    /**
     * Label del tipo en español
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            self::TYPE_CLIENT_UPDATE => 'Actualización a Cliente',
            self::TYPE_DAILY_SUMMARY => 'Resumen Diario',
            self::TYPE_TASK_REMINDER => 'Recordatorio de Tarea',
            self::TYPE_WEBHOOK_RESPONSE => 'Respuesta Webhook',
            default => $this->type,
        };
    }

    /**
     * Label del estado en español
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_SENT => 'Enviado',
            self::STATUS_DELIVERED => 'Entregado',
            self::STATUS_READ => 'Leído',
            self::STATUS_FAILED => 'Fallido',
            default => $this->status,
        };
    }

    /**
     * Color del estado
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'gray',
            self::STATUS_SENT => 'blue',
            self::STATUS_DELIVERED => 'green',
            self::STATUS_READ => 'green',
            self::STATUS_FAILED => 'red',
            default => 'gray',
        };
    }

    /**
     * Marcar como enviado
     */
    public function markAsSent(string $messageId = null): void
    {
        $this->update([
            'status' => self::STATUS_SENT,
            'message_id' => $messageId,
        ]);
    }

    /**
     * Marcar como entregado
     */
    public function markAsDelivered(): void
    {
        $this->update(['status' => self::STATUS_DELIVERED]);
    }

    /**
     * Marcar como leído
     */
    public function markAsRead(): void
    {
        $this->update(['status' => self::STATUS_READ]);
    }

    /**
     * Marcar como fallido
     */
    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'error_message' => $errorMessage,
        ]);
    }

    /**
     * Crear log de notificación
     */
    public static function createLog(
        string $type,
        string $recipientPhone,
        string $recipientType,
        array $payload = [],
        ?int $projectId = null,
        ?int $taskId = null,
        ?int $clientId = null
    ): self {
        return self::create([
            'type' => $type,
            'recipient_phone' => $recipientPhone,
            'recipient_type' => $recipientType,
            'status' => self::STATUS_PENDING,
            'payload' => $payload,
            'project_id' => $projectId,
            'task_id' => $taskId,
            'client_id' => $clientId,
        ]);
    }

    /**
     * Scope: Por tipo
     */
    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Por estado
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Fallidos
     */
    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    /**
     * Scope: Recientes
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
