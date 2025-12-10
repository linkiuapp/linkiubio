<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringAlert extends Model
{
    protected $fillable = [
        'name',
        'type',
        'conditions',
        'channel',
        'is_active',
        'cooldown_minutes',
        'last_triggered_at',
    ];

    protected $casts = [
        'conditions' => 'array',
        'is_active' => 'boolean',
        'cooldown_minutes' => 'integer',
        'last_triggered_at' => 'datetime',
    ];

    /**
     * Verificar si el alert puede ser disparado (respetando cooldown)
     */
    public function canTrigger(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->last_triggered_at) {
            return true;
        }

        $minutesSinceLastTrigger = now()->diffInMinutes($this->last_triggered_at);
        return $minutesSinceLastTrigger >= $this->cooldown_minutes;
    }

    /**
     * Marcar como disparado
     */
    public function markAsTriggered(): void
    {
        $this->update(['last_triggered_at' => now()]);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByChannel($query, string $channel)
    {
        return $query->where('channel', $channel);
    }
}
