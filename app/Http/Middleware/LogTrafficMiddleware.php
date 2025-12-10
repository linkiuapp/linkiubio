<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\LogTrafficJob;
use App\Jobs\CheckSlowResponseAlert;
use App\Models\TrafficLog;

class LogTrafficMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo loggear si está habilitado
        // Usar config() en lugar de env() para evitar problemas de cache
        $monitoringEnabled = config('monitoring.enabled', env('MONITORING_ENABLED', false));
        $logTraffic = config('monitoring.log_traffic', env('MONITORING_LOG_TRAFFIC', false));
        
        if (!$monitoringEnabled || !$logTraffic) {
            return $next($request);
        }

        $startTime = microtime(true);
        $startMemory = memory_get_usage();
        
        $response = $next($request);
        
        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        
        $responseTime = round(($endTime - $startTime) * 1000); // ms
        $memoryUsage = round(($endMemory - $startMemory) / 1024 / 1024, 2); // MB
        
        $logData = [
            'method' => $request->method(),
            'route' => $request->route()?->getName() ?? $request->path(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status_code' => $response->getStatusCode(),
            'response_time_ms' => $responseTime,
            'memory_usage_mb' => $memoryUsage,
            'user_id' => auth()->id(),
            'store_id' => $request->route('store')?->id,
            'request_data' => $this->sanitizeRequest($request),
            'logged_at' => now(),
        ];
        
        // En desarrollo local, guardar directamente (síncrono)
        // En producción, usar cola (async)
        if (app()->environment('local', 'testing')) {
            try {
                $created = TrafficLog::create($logData);
                // Log de debug solo en local
                if (config('app.debug')) {
                    \Log::debug('Traffic logged (sync)', [
                        'id' => $created->id,
                        'route' => $logData['route'],
                        'method' => $logData['method']
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to log traffic (sync)', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'data' => $logData
                ]);
            }
        } else {
            // Log en BD (async con queue) para producción
            LogTrafficJob::dispatch($logData);
        }
        
        // Alertas si es necesario (solo si es muy lento)
        if ($responseTime > 5000) { // > 5 segundos
            if (app()->environment('local', 'testing')) {
                // En local, procesar alerta síncronamente
                try {
                    $alertJob = new CheckSlowResponseAlert($responseTime, $request->route()?->getName() ?? $request->path());
                    $alertJob->handle();
                } catch (\Exception $e) {
                    \Log::error('Failed to check slow response alert', ['error' => $e->getMessage()]);
                }
            } else {
                CheckSlowResponseAlert::dispatch($responseTime, $request->route()?->getName() ?? $request->path());
            }
        }
        
        return $response;
    }

    /**
     * Sanitizar datos del request para remover información sensible
     */
    protected function sanitizeRequest(Request $request): array
    {
        $data = $request->all();
        
        // Campos sensibles a remover/ocultar
        $sensitiveFields = [
            'password',
            'password_confirmation',
            'current_password',
            'token',
            'api_key',
            'secret',
            'access_token',
            'refresh_token',
            'remember_token',
            'credit_card',
            'cvv',
            'card_number',
            '_token', // CSRF token
        ];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '***REDACTED***';
            }
        }
        
        // Limitar tamaño del array (solo primeros 20 campos)
        if (count($data) > 20) {
            $data = array_slice($data, 0, 20, true);
            $data['_truncated'] = true;
        }
        
        return $data;
    }
}
