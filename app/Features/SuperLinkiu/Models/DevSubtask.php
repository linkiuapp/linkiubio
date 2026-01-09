<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevSubtask extends Model
{
    protected $table = 'dev_subtasks';

    protected $fillable = [
        'task_id',
        'name',
        'is_completed',
        'order',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Tarea padre
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(DevTask::class, 'task_id');
    }

    /**
     * Toggle completado
     */
    public function toggle(): void
    {
        $this->update(['is_completed' => !$this->is_completed]);
    }

    /**
     * Marcar como completada
     */
    public function markAsCompleted(): void
    {
        $this->update(['is_completed' => true]);
    }

    /**
     * Marcar como pendiente
     */
    public function markAsPending(): void
    {
        $this->update(['is_completed' => false]);
    }

    /**
     * Scope: Completadas
     */
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    /**
     * Scope: Pendientes
     */
    public function scopePending($query)
    {
        return $query->where('is_completed', false);
    }
}
