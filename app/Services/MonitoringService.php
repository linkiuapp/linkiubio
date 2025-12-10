<?php

namespace App\Services;

use App\Models\ErrorLog;
use App\Models\TrafficLog;
use App\Models\PerformanceLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonitoringService
{
    /**
     * Obtener resumen general (últimas 24h)
     */
    public function getSummary(int $hours = 24): array
    {
        $since = now()->subHours($hours);

        return [
            'errors_count' => ErrorLog::where('created_at', '>=', $since)->count(),
            'traffic_count' => TrafficLog::where('logged_at', '>=', $since)->count(),
            'avg_response_time' => round(TrafficLog::where('logged_at', '>=', $since)->avg('response_time_ms') ?? 0, 2),
            'error_rate' => $this->calculateErrorRate($since),
            'slow_requests' => TrafficLog::where('logged_at', '>=', $since)
                ->where('response_time_ms', '>', 1000)
                ->count(),
            'memory_usage_avg' => round(TrafficLog::where('logged_at', '>=', $since)
                ->whereNotNull('memory_usage_mb')
                ->avg('memory_usage_mb') ?? 0, 2),
        ];
    }

    /**
     * Calcular tasa de errores
     */
    protected function calculateErrorRate(Carbon $since): float
    {
        $totalRequests = TrafficLog::where('logged_at', '>=', $since)->count();
        $errorRequests = TrafficLog::where('logged_at', '>=', $since)
            ->where('status_code', '>=', 400)
            ->count();

        if ($totalRequests === 0) {
            return 0;
        }

        return round(($errorRequests / $totalRequests) * 100, 2);
    }

    /**
     * Obtener errores por día (últimos 7 días)
     */
    public function getErrorsByDay(int $days = 7): array
    {
        $since = now()->subDays($days);

        return ErrorLog::selectRaw('DATE(created_at) as date, COUNT(*) as count, level')
            ->where('created_at', '>=', $since)
            ->groupBy('date', 'level')
            ->orderBy('date')
            ->get()
            ->groupBy('date')
            ->map(function ($items) {
                return [
                    'date' => $items->first()->date,
                    'error' => $items->where('level', 'ERROR')->sum('count'),
                    'warning' => $items->where('level', 'WARNING')->sum('count'),
                    'total' => $items->sum('count'),
                ];
            })
            ->values()
            ->toArray();
    }

    /**
     * Obtener tráfico por día (últimos 7 días)
     */
    public function getTrafficByDay(int $days = 7): array
    {
        $since = now()->subDays($days);

        return TrafficLog::selectRaw('DATE(logged_at) as date, COUNT(*) as count')
            ->where('logged_at', '>=', $since)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    /**
     * Obtener rutas más visitadas
     */
    public function getTopRoutes(int $limit = 10, int $hours = 24): array
    {
        $since = now()->subHours($hours);

        return TrafficLog::selectRaw('route, COUNT(*) as count, AVG(response_time_ms) as avg_time')
            ->where('logged_at', '>=', $since)
            ->groupBy('route')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'route' => $item->route,
                    'count' => $item->count,
                    'avg_time' => round($item->avg_time, 2),
                ];
            })
            ->toArray();
    }

    /**
     * Obtener rutas más lentas
     */
    public function getSlowestRoutes(int $limit = 10, int $hours = 24): array
    {
        $since = now()->subHours($hours);

        return TrafficLog::selectRaw('route, AVG(response_time_ms) as avg_time, COUNT(*) as count')
            ->where('logged_at', '>=', $since)
            ->groupBy('route')
            ->havingRaw('AVG(response_time_ms) > ?', [1000])
            ->orderByDesc('avg_time')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'route' => $item->route,
                    'avg_time' => round($item->avg_time, 2),
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    /**
     * Obtener errores recientes
     */
    public function getRecentErrors(int $limit = 20, array $filters = []): array
    {
        $query = ErrorLog::with(['user', 'store'])
            ->orderByDesc('last_occurred_at');

        // Filtros
        if (isset($filters['level'])) {
            $query->where('level', $filters['level']);
        }

        if (isset($filters['route'])) {
            $query->where('route', $filters['route']);
        }

        if (isset($filters['store_id'])) {
            $query->where('store_id', $filters['store_id']);
        }

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        return $query->limit($limit)->get()->toArray();
    }

    /**
     * Obtener status codes distribution
     */
    public function getStatusCodesDistribution(int $hours = 24): array
    {
        $since = now()->subHours($hours);

        return TrafficLog::selectRaw('status_code, COUNT(*) as count')
            ->where('logged_at', '>=', $since)
            ->groupBy('status_code')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) {
                return [
                    'status_code' => $item->status_code,
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    /**
     * Obtener IPs más activas
     */
    public function getTopIPs(int $limit = 10, int $hours = 24): array
    {
        $since = now()->subHours($hours);

        return TrafficLog::selectRaw('ip_address, COUNT(*) as count')
            ->where('logged_at', '>=', $since)
            ->groupBy('ip_address')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'ip_address' => $item->ip_address,
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    /**
     * Obtener stores con más tráfico
     */
    public function getTopStores(int $limit = 10, int $hours = 24): array
    {
        $since = now()->subHours($hours);

        return TrafficLog::with('store')
            ->selectRaw('store_id, COUNT(*) as count')
            ->where('logged_at', '>=', $since)
            ->whereNotNull('store_id')
            ->groupBy('store_id')
            ->orderByDesc('count')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'store_id' => $item->store_id,
                    'store_name' => $item->store?->name ?? 'N/A',
                    'count' => $item->count,
                ];
            })
            ->toArray();
    }

    /**
     * Obtener queries lentas
     */
    public function getSlowQueries(int $limit = 10, int $hours = 24): array
    {
        $since = now()->subHours($hours);

        return PerformanceLog::where('type', 'slow_query')
            ->where('logged_at', '>=', $since)
            ->orderByDesc('execution_time_ms')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'query' => $item->query,
                    'execution_time_ms' => $item->execution_time_ms,
                    'route' => $item->route,
                    'logged_at' => $item->logged_at,
                ];
            })
            ->toArray();
    }

    /**
     * Obtener rutas disponibles para filtros
     */
    public function getAvailableRoutes(): array
    {
        return ErrorLog::select('route')
            ->whereNotNull('route')
            ->distinct()
            ->orderBy('route')
            ->pluck('route')
            ->toArray();
    }
}

