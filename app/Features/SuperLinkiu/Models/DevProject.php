<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DevProject extends Model
{
    protected $table = 'dev_projects';

    protected $fillable = [
        'client_id',
        'name',
        'description',
        'status',
        'priority',
        'start_date',
        'due_date',
        'completed_at',
        'notify_client_on_status_change',
        'budget',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'notify_client_on_status_change' => 'boolean',
        'budget' => 'decimal:2',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_ON_HOLD = 'on_hold';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';

    /**
     * Cliente del proyecto
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(DevClient::class, 'client_id');
    }

    /**
     * Tareas del proyecto
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(DevTask::class, 'project_id')->orderBy('order');
    }

    /**
     * Entradas de agenda relacionadas
     */
    public function agendaEntries(): HasMany
    {
        return $this->hasMany(DevAgendaEntry::class, 'project_id');
    }

    /**
     * Logs de notificaciones
     */
    public function notificationLogs(): HasMany
    {
        return $this->hasMany(DevNotificationLog::class, 'project_id');
    }

    /**
     * Porcentaje de completado basado en tareas
     */
    public function getProgressPercentageAttribute(): int
    {
        $totalTasks = $this->tasks()->count();
        
        if ($totalTasks === 0) {
            return 0;
        }
        
        $completedTasks = $this->tasks()->where('status', 'completed')->count();
        
        return (int) round(($completedTasks / $totalTasks) * 100);
    }

    /**
     * Tareas completadas / Total
     */
    public function getTasksProgressAttribute(): string
    {
        $total = $this->tasks()->count();
        $completed = $this->tasks()->where('status', 'completed')->count();
        
        return "{$completed}/{$total}";
    }

    /**
     * Verificar si el proyecto está atrasado
     */
    public function getIsOverdueAttribute(): bool
    {
        if (!$this->due_date || $this->status === self::STATUS_COMPLETED) {
            return false;
        }
        
        return $this->due_date->isPast();
    }

    /**
     * Días restantes o de atraso
     */
    public function getDaysRemainingAttribute(): ?int
    {
        if (!$this->due_date) {
            return null;
        }
        
        return now()->startOfDay()->diffInDays($this->due_date, false);
    }

    /**
     * Label del estado en español
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_IN_PROGRESS => 'En Progreso',
            self::STATUS_ON_HOLD => 'En Pausa',
            self::STATUS_COMPLETED => 'Completado',
            self::STATUS_CANCELLED => 'Cancelado',
            default => $this->status,
        };
    }

    /**
     * Color del estado para badges
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'gray',
            self::STATUS_IN_PROGRESS => 'blue',
            self::STATUS_ON_HOLD => 'yellow',
            self::STATUS_COMPLETED => 'green',
            self::STATUS_CANCELLED => 'red',
            default => 'gray',
        };
    }

    /**
     * Label de prioridad en español
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
     * Color de prioridad
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            self::PRIORITY_LOW => 'gray',
            self::PRIORITY_MEDIUM => 'yellow',
            self::PRIORITY_HIGH => 'red',
            default => 'gray',
        };
    }

    /**
     * Marcar como completado
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);
    }

    /**
     * Scope: Proyectos activos (no completados ni cancelados)
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_COMPLETED, self::STATUS_CANCELLED]);
    }

    /**
     * Scope: Por estado
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Por prioridad
     */
    public function scopePriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope: Buscar
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhereHas('client', function ($clientQuery) use ($search) {
                  $clientQuery->where('name', 'like', "%{$search}%");
              });
        });
    }
}
