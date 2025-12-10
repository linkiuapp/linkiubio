<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceLog extends Model
{
    protected $fillable = [
        'type',
        'route',
        'query',
        'execution_time_ms',
        'memory_usage_mb',
        'context',
        'logged_at',
    ];

    protected $casts = [
        'context' => 'array',
        'logged_at' => 'datetime',
        'execution_time_ms' => 'integer',
        'memory_usage_mb' => 'integer',
    ];

    /**
     * Scopes
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeSlowQueries($query, int $thresholdMs = 1000)
    {
        return $query->where('type', 'slow_query')
            ->where('execution_time_ms', '>', $thresholdMs);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('logged_at', '>=', now()->subHours($hours));
    }

    public function scopeByRoute($query, string $route)
    {
        return $query->where('route', $route);
    }
}
