<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ErrorLog extends Model
{
    protected $fillable = [
        'level',
        'message',
        'stack_trace',
        'file',
        'line',
        'route',
        'method',
        'ip_address',
        'user_agent',
        'user_id',
        'store_id',
        'context',
        'request_data',
        'occurrence_count',
        'first_occurred_at',
        'last_occurred_at',
    ];

    protected $casts = [
        'context' => 'array',
        'request_data' => 'array',
        'first_occurred_at' => 'datetime',
        'last_occurred_at' => 'datetime',
        'occurrence_count' => 'integer',
    ];

    /**
     * Relación con usuario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Shared\Models\User::class);
    }

    /**
     * Relación con tienda
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(\App\Shared\Models\Store::class);
    }

    /**
     * Scopes
     */
    public function scopeByLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    public function scopeByRoute($query, string $route)
    {
        return $query->where('route', $route);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    public function scopeGrouped($query)
    {
        return $query->selectRaw('
                message,
                file,
                line,
                route,
                level,
                COUNT(*) as count,
                MAX(created_at) as last_occurred,
                MIN(created_at) as first_occurred
            ')
            ->groupBy('message', 'file', 'line', 'route', 'level');
    }
}
