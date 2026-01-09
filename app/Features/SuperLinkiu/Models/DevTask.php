<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DevTask extends Model
{
    protected $table = 'dev_tasks';

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'status',
        'priority',
        'order',
        'start_date',
        'due_date',
        'scheduled_date',
        'scheduled_start_time',
        'scheduled_end_time',
        'reminder_minutes',
        'reminder_sent',
        'completed_at',
        'notify_on_complete',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'scheduled_date' => 'date',
        'completed_at' => 'datetime',
        'notify_on_complete' => 'boolean',
        'reminder_sent' => 'boolean',
        'order' => 'integer',
        'reminder_minutes' => 'integer',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REVIEW = 'review';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';

    /**
     * Proyecto de la tarea
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(DevProject::class, 'project_id');
    }

    /**
     * Subtareas
     */
    public function subtasks(): HasMany
    {
        return $this->hasMany(DevSubtask::class, 'task_id')->orderBy('order');
    }

    /**
     * Logs de notificaciones
     */
    public function notificationLogs(): HasMany
    {
        return $this->hasMany(DevNotificationLog::class, 'task_id');
    }

    /**
     * Cliente (a través del proyecto)
     */
    public function getClientAttribute(): ?DevClient
    {
        return $this->project?->client;
    }

    /**
     * Porcentaje de completado basado en subtareas
     */
    public function getSubtasksProgressAttribute(): int
    {
        $total = $this->subtasks()->count();
        
        if ($total === 0) {
            return $this->status === self::STATUS_COMPLETED ? 100 : 0;
        }
        
        $completed = $this->subtasks()->where('is_completed', true)->count();
        
        return (int) round(($completed / $total) * 100);
    }

    /**
     * Verificar si está programada para hoy
     */
    public function getIsScheduledTodayAttribute(): bool
    {
        return $this->scheduled_date && $this->scheduled_date->isToday();
    }

    /**
     * Verificar si está atrasada
     */
    public function getIsOverdueAttribute(): bool
    {
        if (!$this->due_date || $this->status === self::STATUS_COMPLETED) {
            return false;
        }
        
        return $this->due_date->isPast();
    }

    /**
     * Hora formateada para mostrar
     */
    public function getScheduledTimeRangeAttribute(): ?string
    {
        if (!$this->scheduled_start_time) {
            return null;
        }
        
        $start = \Carbon\Carbon::parse($this->scheduled_start_time)->format('H:i');
        
        if ($this->scheduled_end_time) {
            $end = \Carbon\Carbon::parse($this->scheduled_end_time)->format('H:i');
            return "{$start} - {$end}";
        }
        
        return $start;
    }

    /**
     * Calcular cuando enviar el recordatorio
     */
    public function getReminderTimeAttribute(): ?\Carbon\Carbon
    {
        if (!$this->scheduled_date || !$this->scheduled_start_time || !$this->reminder_minutes) {
            return null;
        }
        
        return \Carbon\Carbon::parse($this->scheduled_date->format('Y-m-d') . ' ' . $this->scheduled_start_time)
            ->subMinutes($this->reminder_minutes);
    }

    /**
     * Verificar si necesita enviar recordatorio ahora
     */
    public function shouldSendReminder(): bool
    {
        if ($this->reminder_sent || !$this->reminder_time) {
            return false;
        }
        
        $now = now();
        $reminderTime = $this->reminder_time;
        
        // Enviar si estamos dentro de los 5 minutos después de la hora del recordatorio
        return $now->gte($reminderTime) && $now->lte($reminderTime->addMinutes(5));
    }

    /**
     * Label del estado en español
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_IN_PROGRESS => 'En Progreso',
            self::STATUS_REVIEW => 'En Revisión',
            self::STATUS_COMPLETED => 'Completada',
            self::STATUS_CANCELLED => 'Cancelada',
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
            self::STATUS_IN_PROGRESS => 'blue',
            self::STATUS_REVIEW => 'yellow',
            self::STATUS_COMPLETED => 'green',
            self::STATUS_CANCELLED => 'red',
            default => 'gray',
        };
    }

    /**
     * Label de prioridad
     */
    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            self::PRIORITY_LOW => 'Baja',
            self::PRIORITY_MEDIUM => 'Media',
            self::PRIORITY_HIGH => 'Alta',
            default => $this->priority,
        };
    }

    /**
     * Marcar como completada
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);
        
        // Marcar todas las subtareas como completadas
        $this->subtasks()->update(['is_completed' => true]);
    }

    /**
     * Marcar recordatorio como enviado
     */
    public function markReminderSent(): void
    {
        $this->update(['reminder_sent' => true]);
    }

    /**
     * Scope: Tareas de hoy
     */
    public function scopeScheduledToday($query)
    {
        return $query->whereDate('scheduled_date', today());
    }

    /**
     * Scope: Tareas de una fecha
     */
    public function scopeScheduledOn($query, $date)
    {
        return $query->whereDate('scheduled_date', $date);
    }

    /**
     * Scope: Tareas programadas (con fecha en agenda)
     */
    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduled_date');
    }

    /**
     * Scope: Tareas pendientes de recordatorio
     */
    public function scopePendingReminder($query)
    {
        return $query->where('reminder_sent', false)
                     ->whereNotNull('reminder_minutes')
                     ->whereNotNull('scheduled_date')
                     ->whereNotNull('scheduled_start_time')
                     ->whereIn('status', [self::STATUS_PENDING, self::STATUS_IN_PROGRESS]);
    }

    /**
     * Scope: Por estado
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Activas (no completadas ni canceladas)
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_COMPLETED, self::STATUS_CANCELLED]);
    }
}
