<?php

namespace App\Features\SuperLinkiu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevAgendaEntry extends Model
{
    protected $table = 'dev_agenda_entries';

    protected $fillable = [
        'title',
        'description',
        'type',
        'date',
        'start_time',
        'end_time',
        'location',
        'project_id',
        'client_id',
        'reminder_minutes',
        'reminder_sent',
        'color',
        'is_all_day',
    ];

    protected $casts = [
        'date' => 'date',
        'reminder_sent' => 'boolean',
        'is_all_day' => 'boolean',
        'reminder_minutes' => 'integer',
    ];

    const TYPE_MEETING = 'meeting';
    const TYPE_REMINDER = 'reminder';
    const TYPE_TASK = 'task';
    const TYPE_CALL = 'call';
    const TYPE_OTHER = 'other';

    /**
     * Proyecto relacionado
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(DevProject::class, 'project_id');
    }

    /**
     * Cliente relacionado
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(DevClient::class, 'client_id');
    }

    /**
     * Hora formateada
     */
    public function getTimeRangeAttribute(): string
    {
        if ($this->is_all_day) {
            return 'Todo el día';
        }
        
        $start = \Carbon\Carbon::parse($this->start_time)->format('H:i');
        
        if ($this->end_time) {
            $end = \Carbon\Carbon::parse($this->end_time)->format('H:i');
            return "{$start} - {$end}";
        }
        
        return $start;
    }

    /**
     * Duración en minutos
     */
    public function getDurationMinutesAttribute(): ?int
    {
        if (!$this->start_time || !$this->end_time || $this->is_all_day) {
            return null;
        }
        
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        
        return $start->diffInMinutes($end);
    }

    /**
     * Calcular cuando enviar el recordatorio
     */
    public function getReminderTimeAttribute(): ?\Carbon\Carbon
    {
        if (!$this->date || !$this->start_time || !$this->reminder_minutes || $this->is_all_day) {
            return null;
        }
        
        return \Carbon\Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->start_time)
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
        
        return $now->gte($reminderTime) && $now->lte($reminderTime->addMinutes(5));
    }

    /**
     * Label del tipo en español
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            self::TYPE_MEETING => 'Reunión',
            self::TYPE_REMINDER => 'Recordatorio',
            self::TYPE_TASK => 'Tarea',
            self::TYPE_CALL => 'Llamada',
            self::TYPE_OTHER => 'Otro',
            default => $this->type,
        };
    }

    /**
     * Icono del tipo
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            self::TYPE_MEETING => 'users',
            self::TYPE_REMINDER => 'bell',
            self::TYPE_TASK => 'check-square',
            self::TYPE_CALL => 'phone',
            self::TYPE_OTHER => 'calendar',
            default => 'calendar',
        };
    }

    /**
     * Color por defecto según el tipo
     */
    public function getDefaultColorAttribute(): string
    {
        if ($this->color) {
            return $this->color;
        }
        
        return match($this->type) {
            self::TYPE_MEETING => '#3b82f6', // blue
            self::TYPE_REMINDER => '#f59e0b', // amber
            self::TYPE_TASK => '#10b981', // green
            self::TYPE_CALL => '#8b5cf6', // purple
            self::TYPE_OTHER => '#6b7280', // gray
            default => '#6b7280',
        };
    }

    /**
     * Marcar recordatorio como enviado
     */
    public function markReminderSent(): void
    {
        $this->update(['reminder_sent' => true]);
    }

    /**
     * Scope: Entradas de hoy
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    /**
     * Scope: Entradas de una fecha
     */
    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope: Entradas de una semana
     */
    public function scopeInWeek($query, $startOfWeek, $endOfWeek)
    {
        return $query->whereBetween('date', [$startOfWeek, $endOfWeek]);
    }

    /**
     * Scope: Entradas de un mes
     */
    public function scopeInMonth($query, $year, $month)
    {
        return $query->whereYear('date', $year)->whereMonth('date', $month);
    }

    /**
     * Scope: Por tipo
     */
    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Pendientes de recordatorio
     */
    public function scopePendingReminder($query)
    {
        return $query->where('reminder_sent', false)
                     ->whereNotNull('reminder_minutes')
                     ->whereDate('date', '>=', today());
    }
}
