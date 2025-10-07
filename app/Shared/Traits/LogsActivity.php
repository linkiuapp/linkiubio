<?php

namespace App\Shared\Traits;

use Illuminate\Support\Facades\Log;

trait LogsActivity
{
    /**
     * Log de actividad crítica
     */
    protected function logActivity(string $action, $model = null, array $context = []): void
    {
        $user = auth()->user();
        
        $logData = [
            'action' => $action,
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'user_role' => $user?->role,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString(),
        ];
        
        if ($model) {
            $logData['model_type'] = get_class($model);
            $logData['model_id'] = $model->id ?? null;
            
            // Agregar información específica del modelo
            if (method_exists($model, 'toArray')) {
                $logData['model_data'] = $this->sanitizeModelData($model);
            }
        }
        
        // Agregar contexto adicional
        $logData = array_merge($logData, $context);
        
        // Log en canal de auditoría
        Log::channel('audit')->info("AUDIT: {$action}", $logData);
    }
    
    /**
     * Log de cambio de estado
     */
    protected function logStateChange($model, string $field, $oldValue, $newValue): void
    {
        $this->logActivity('state_change', $model, [
            'field' => $field,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'change_description' => "{$field} changed from '{$oldValue}' to '{$newValue}'"
        ]);
    }
    
    /**
     * Log de acción crítica de seguridad
     */
    protected function logSecurityAction(string $action, array $context = []): void
    {
        $logData = array_merge([
            'security_action' => true,
            'alert_level' => 'high'
        ], $context);
        
        $this->logActivity("SECURITY: {$action}", null, $logData);
        
        // También log en el canal de seguridad
        Log::channel('security')->warning("SECURITY ACTION: {$action}", $logData);
    }
    
    /**
     * Sanitizar datos del modelo para el log
     */
    private function sanitizeModelData($model): array
    {
        $data = $model->toArray();
        
        // Remover campos sensibles
        $sensitiveFields = ['password', 'remember_token', 'api_key', 'secret'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '***REDACTED***';
            }
        }
        
        return $data;
    }
}

