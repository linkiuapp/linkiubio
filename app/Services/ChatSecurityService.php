<?php

namespace App\Services;

use App\Shared\Models\Store;
use App\Shared\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

/**
 * ChatSecurityService - Seguridad para KiuBot
 * 
 * Protege contra:
 * - Prompt injection
 * - Data leakage
 * - Privilege escalation
 * - Abuse/spam
 */
class ChatSecurityService
{
    /**
     * Patrones peligrosos de prompt injection
     */
    protected array $dangerousPatterns = [
        // Bypass de system prompt
        '/ignore\s+(all\s+)?(previous|prior|above)\s+(instructions?|prompts?|commands?)/i',
        '/forget\s+(all\s+)?(previous|prior|above|your)\s+(instructions?|prompts?|commands?)/i',
        '/disregard\s+(all\s+)?(previous|prior|above)/i',
        '/(act|behave)\s+as\s+if\s+you\s+have\s+no\s+restrictions/i',
        
        // Manipulación de rol
        '/you\s+are\s+now\s+(a|an)/i',
        '/act\s+as\s+(a|an|if)\s+(admin|root|system|developer)/i',
        '/pretend\s+(you\s+are|to\s+be)/i',
        '/roleplay\s+as/i',
        
        // Intentos de revelar system prompt
        '/show\s+(me\s+)?(your|the)\s+(system|initial)\s+prompt/i',
        '/what\s+(is|are)\s+your\s+(instructions?|prompts?|rules?)/i',
        '/repeat\s+(your|the)\s+(instructions?|system\s+prompt)/i',
        
        // SQL y comandos
        '/select\s+.*\s+from\s+/i',
        '/drop\s+table/i',
        '/delete\s+from/i',
        '/update\s+.*\s+set/i',
        '/insert\s+into/i',
        '/exec\s*\(/i',
        '/eval\s*\(/i',
        
        // Acceso a datos sensibles
        '/show\s+(me\s+)?(all\s+)?(api\s+)?keys?/i',
        '/give\s+me\s+(access|admin|root)/i',
        '/bypass\s+(security|authentication)/i',
        
        // Inyección de código
        '/<script[^>]*>/i',
        '/<iframe[^>]*>/i',
        '/javascript:/i',
        '/on(load|error|click)\s*=/i',
        
        // Acceso a otras tiendas
        '/all\s+(stores?|tiendas?|shops?)/i',
        '/other\s+(stores?|tiendas?|users?)/i',
        '/(todas|otros)\s+(las\s+)?(tiendas?|usuarios?)/i',
    ];
    
    /**
     * Palabras sospechosas que requieren logging
     */
    protected array $suspiciousKeywords = [
        'admin', 'root', 'system', 'debug', 'password', 'token', 'api key',
        'database', 'sql', 'injection', 'hack', 'exploit', 'bypass',
        'all stores', 'todas las tiendas', 'other users'
    ];

    /**
     * Validar mensaje del usuario antes de procesarlo
     */
    public function validateMessage(string $message, Store $store, User $user): array
    {
        // 1. Detectar prompt injection
        $injectionDetected = $this->detectPromptInjection($message);
        if ($injectionDetected) {
            $this->logSecurityEvent('prompt_injection_attempt', [
                'store_id' => $store->id,
                'user_id' => $user->id,
                'message' => $message,
                'pattern' => $injectionDetected,
            ]);
            
            return [
                'valid' => false,
                'reason' => 'prompt_injection',
                'message' => 'Lo siento, no puedo procesar ese tipo de mensaje. Por favor, hazme una pregunta sobre tu tienda o sobre cómo usar Linkiu.'
            ];
        }
        
        // 2. Verificar rate limiting
        $rateLimitExceeded = $this->checkRateLimit($user->id);
        if ($rateLimitExceeded) {
            $this->logSecurityEvent('rate_limit_exceeded', [
                'store_id' => $store->id,
                'user_id' => $user->id,
            ]);
            
            return [
                'valid' => false,
                'reason' => 'rate_limit',
                'message' => 'Has enviado demasiados mensajes. Por favor, espera un momento antes de intentar nuevamente.'
            ];
        }
        
        // 3. Detectar palabras sospechosas (solo logging, no bloquear)
        $this->detectSuspiciousKeywords($message, $store, $user);
        
        // 4. Validar longitud del mensaje
        if (strlen($message) > 1000) {
            return [
                'valid' => false,
                'reason' => 'message_too_long',
                'message' => 'Tu mensaje es muy largo. Por favor, hazlo más corto (máximo 1000 caracteres).'
            ];
        }
        
        // 5. Detectar spam (mensajes repetidos)
        if ($this->isSpam($message, $user->id)) {
            $this->logSecurityEvent('spam_detected', [
                'store_id' => $store->id,
                'user_id' => $user->id,
                'message' => $message,
            ]);
            
            return [
                'valid' => false,
                'reason' => 'spam',
                'message' => 'Por favor, evita enviar el mismo mensaje repetidamente.'
            ];
        }
        
        return [
            'valid' => true,
            'sanitized_message' => $this->sanitizeMessage($message)
        ];
    }
    
    /**
     * Detectar intentos de prompt injection
     */
    protected function detectPromptInjection(string $message): ?string
    {
        foreach ($this->dangerousPatterns as $pattern) {
            if (preg_match($pattern, $message)) {
                return $pattern;
            }
        }
        
        return null;
    }
    
    /**
     * Verificar rate limiting
     * Límites:
     * - 15 mensajes por minuto
     * - 100 mensajes por hora
     * - 500 mensajes por día
     */
    protected function checkRateLimit(int $userId): bool
    {
        $key = "chat_rate_limit:{$userId}";
        
        // Límite por minuto
        if (RateLimiter::tooManyAttempts($key . ':minute', 15)) {
            return true;
        }
        
        // Límite por hora
        if (RateLimiter::tooManyAttempts($key . ':hour', 100)) {
            return true;
        }
        
        // Límite por día
        if (RateLimiter::tooManyAttempts($key . ':day', 500)) {
            return true;
        }
        
        // Incrementar contadores
        RateLimiter::hit($key . ':minute', 60); // 1 minuto
        RateLimiter::hit($key . ':hour', 3600); // 1 hora
        RateLimiter::hit($key . ':day', 86400); // 1 día
        
        return false;
    }
    
    /**
     * Detectar palabras sospechosas (solo logging)
     */
    protected function detectSuspiciousKeywords(string $message, Store $store, User $user): void
    {
        $lowerMessage = strtolower($message);
        $foundKeywords = [];
        
        foreach ($this->suspiciousKeywords as $keyword) {
            if (str_contains($lowerMessage, strtolower($keyword))) {
                $foundKeywords[] = $keyword;
            }
        }
        
        if (!empty($foundKeywords)) {
            $this->logSecurityEvent('suspicious_keywords', [
                'store_id' => $store->id,
                'user_id' => $user->id,
                'message' => $message,
                'keywords' => $foundKeywords,
            ]);
        }
    }
    
    /**
     * Detectar spam (mensajes idénticos repetidos)
     */
    protected function isSpam(string $message, int $userId): bool
    {
        $cacheKey = "chat_last_messages:{$userId}";
        $lastMessages = Cache::get($cacheKey, []);
        
        // Hash del mensaje
        $messageHash = md5($message);
        
        // Contar cuántas veces se ha enviado este mensaje en los últimos 5 minutos
        $count = collect($lastMessages)->filter(fn($hash) => $hash === $messageHash)->count();
        
        // Si se envió más de 3 veces, es spam
        if ($count >= 3) {
            return true;
        }
        
        // Agregar mensaje actual al historial
        $lastMessages[] = $messageHash;
        
        // Mantener solo los últimos 10 mensajes
        if (count($lastMessages) > 10) {
            array_shift($lastMessages);
        }
        
        // Guardar en cache por 5 minutos
        Cache::put($cacheKey, $lastMessages, now()->addMinutes(5));
        
        return false;
    }
    
    /**
     * Sanitizar mensaje del usuario
     */
    protected function sanitizeMessage(string $message): string
    {
        // Remover HTML tags
        $message = strip_tags($message);
        
        // Remover múltiples espacios
        $message = preg_replace('/\s+/', ' ', $message);
        
        // Trim
        $message = trim($message);
        
        return $message;
    }
    
    /**
     * Validar que la respuesta de la IA no filtre información sensible
     */
    public function validateResponse(string $response, Store $store): array
    {
        // Patrones de información sensible
        $sensitivePatterns = [
            // API Keys o tokens
            '/[a-zA-Z0-9]{32,}/',
            // Emails de otros usuarios (excepto el de la tienda actual)
            '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/',
            // Números de teléfono largos (posibles de otras tiendas)
            '/\+?[\d\s\-\(\)]{10,}/',
        ];
        
        $hasSensitiveData = false;
        foreach ($sensitivePatterns as $pattern) {
            if (preg_match($pattern, $response)) {
                // Verificar si es info de la tienda actual (permitido)
                if (!$this->isCurrentStoreInfo($response, $store)) {
                    $hasSensitiveData = true;
                    break;
                }
            }
        }
        
        if ($hasSensitiveData) {
            $this->logSecurityEvent('sensitive_data_in_response', [
                'store_id' => $store->id,
                'response_preview' => substr($response, 0, 200),
            ]);
            
            return [
                'valid' => false,
                'message' => 'Lo siento, ocurrió un error al generar la respuesta. Por favor, intenta reformular tu pregunta.'
            ];
        }
        
        return [
            'valid' => true,
            'response' => $response
        ];
    }
    
    /**
     * Verificar si la información es de la tienda actual
     */
    protected function isCurrentStoreInfo(string $text, Store $store): bool
    {
        // Si contiene el email o teléfono de la tienda actual, está ok
        if ($store->email && str_contains($text, $store->email)) {
            return true;
        }
        
        if ($store->phone && str_contains($text, $store->phone)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Registrar evento de seguridad
     */
    protected function logSecurityEvent(string $type, array $data): void
    {
        Log::channel('security')->warning("ChatSecurity: {$type}", array_merge([
            'type' => $type,
            'timestamp' => now()->toIso8601String(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ], $data));
    }
    
    /**
     * Obtener estadísticas de seguridad para una tienda
     */
    public function getSecurityStats(Store $store): array
    {
        $cacheKey = "chat_security_stats:{$store->id}";
        
        return Cache::remember($cacheKey, now()->addHours(1), function () use ($store) {
            // Aquí podrías consultar una tabla de logs si quieres estadísticas más detalladas
            return [
                'total_blocks_today' => 0, // Implementar si guardas en BD
                'injection_attempts_today' => 0,
                'rate_limit_hits_today' => 0,
            ];
        });
    }
}
