<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrafficLog extends Model
{
    protected $fillable = [
        'method',
        'route',
        'ip_address',
        'user_agent',
        'status_code',
        'response_time_ms',
        'memory_usage_mb',
        'user_id',
        'store_id',
        'request_data',
        'logged_at',
    ];

    protected $casts = [
        'request_data' => 'array',
        'logged_at' => 'datetime',
        'response_time_ms' => 'integer',
        'memory_usage_mb' => 'float',
        'status_code' => 'integer',
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
    public function scopeByRoute($query, string $route)
    {
        return $query->where('route', $route);
    }

    public function scopeByStatusCode($query, int $statusCode)
    {
        return $query->where('status_code', $statusCode);
    }

    public function scopeSlow($query, int $thresholdMs = 1000)
    {
        return $query->where('response_time_ms', '>', $thresholdMs);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('logged_at', '>=', now()->subHours($hours));
    }

    public function scopeByMethod($query, string $method)
    {
        return $query->where('method', strtoupper($method));
    }
}
