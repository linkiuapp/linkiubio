<?php

namespace App\Services;

use App\Models\MonitoringAlert;
use App\Models\ErrorLog;
use App\Models\TrafficLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Shared\Models\BillingSetting;

class AlertService
{
    protected $otpSmsService;
    protected $lastErrorCount = 0;
    protected $lastTrafficCount = 0;
    protected $lastResponseTime = 0;
    protected $lastMemoryUsage = 0;

    public function __construct()
    {
        // Inicializar servicio de WhatsApp si está disponible
        try {
            $this->otpSmsService = app(\App\Services\OTPSmsService::class);
        } catch (\Exception $e) {
            $this->otpSmsService = null;
        }
    }

    /**
     * Verificar si un alert debe dispararse
     */
    public function checkAlert(MonitoringAlert $alert): bool
    {
        $conditions = $alert->conditions;

        $result = match($alert->type) {
            'error_rate' => $this->checkErrorRate($conditions),
            'traffic_spike' => $this->checkTrafficSpike($conditions),
            'slow_response' => $this->checkSlowResponse($conditions),
            'high_memory' => $this->checkHighMemory($conditions),
            'custom' => $this->checkCustom($conditions),
            default => false,
        };

        return $result;
    }

    /**
     * Obtener contexto para el mensaje de alerta
     */
    public function getAlertContext(MonitoringAlert $alert): array
    {
        $conditions = $alert->conditions ?? [];
        $context = [];

        switch ($alert->type) {
            case 'error_rate':
                $context = [
                    'count' => $this->lastErrorCount,
                    'threshold' => $conditions['threshold'] ?? 10,
                    'route_pattern' => $conditions['route_pattern'] ?? null,
                ];
                break;
            case 'traffic_spike':
                $context = [
                    'count' => $this->lastTrafficCount,
                    'threshold' => $conditions['threshold'] ?? 1000,
                ];
                break;
            case 'slow_response':
                $context = [
                    'response_time' => round($this->lastResponseTime, 2),
                    'threshold' => $conditions['threshold_ms'] ?? 3000,
                    'route_pattern' => $conditions['route_pattern'] ?? null,
                ];
                break;
            case 'high_memory':
                $context = [
                    'memory_usage' => round($this->lastMemoryUsage, 2),
                    'threshold' => $conditions['threshold_mb'] ?? 512,
                ];
                break;
        }

        return $context;
    }

    /**
     * Disparar un alert
     */
    public function triggerAlert(MonitoringAlert $alert, array $context = []): void
    {
        // Si no se proporciona contexto, obtenerlo automáticamente
        if (empty($context)) {
            $context = $this->getAlertContext($alert);
        }

        $message = $this->buildAlertMessage($alert, $context);

        match($alert->channel) {
            'email' => $this->sendEmailAlert($alert, $message),
            'whatsapp' => $this->sendWhatsAppAlert($alert, $message),
            'in_app' => $this->logInAppAlert($alert, $message),
            default => Log::warning('Unknown alert channel', ['channel' => $alert->channel]),
        };
    }

    /**
     * Verificar tasa de errores
     */
    protected function checkErrorRate(array $conditions): bool
    {
        $threshold = $conditions['threshold'] ?? 10;
        $minutes = $conditions['minutes'] ?? 5;
        $level = $conditions['level'] ?? 'ERROR';
        $route_pattern = $conditions['route_pattern'] ?? null; // Filtro opcional por ruta

        $query = ErrorLog::where('level', $level)
            ->where('created_at', '>=', now()->subMinutes($minutes));

        // Si hay un patrón de ruta, filtrar por él
        if ($route_pattern) {
            $query->where('route', 'like', "%{$route_pattern}%");
        }

        $count = $query->count();

        // Guardar el count en el contexto para el mensaje
        $this->lastErrorCount = $count;

        return $count >= $threshold;
    }

    /**
     * Verificar pico de tráfico
     */
    protected function checkTrafficSpike(array $conditions): bool
    {
        $threshold = $conditions['threshold'] ?? 1000;
        $minutes = $conditions['minutes'] ?? 1;

        $count = TrafficLog::where('logged_at', '>=', now()->subMinutes($minutes))
            ->count();

        // Guardar el count para el mensaje
        $this->lastTrafficCount = $count;

        return $count >= $threshold;
    }

    /**
     * Verificar respuesta lenta
     */
    protected function checkSlowResponse(array $conditions): bool
    {
        $threshold = $conditions['threshold_ms'] ?? 3000;
        $minutes = $conditions['minutes'] ?? 10;
        $route_pattern = $conditions['route_pattern'] ?? null; // Filtro opcional por ruta

        $query = TrafficLog::where('logged_at', '>=', now()->subMinutes($minutes));

        // Si hay un patrón de ruta, filtrar por él
        if ($route_pattern) {
            $query->where('route', 'like', "%{$route_pattern}%");
        }

        $avgResponseTime = $query->avg('response_time_ms');

        // Guardar el tiempo para el mensaje
        $this->lastResponseTime = $avgResponseTime ?? 0;

        return $avgResponseTime && $avgResponseTime > $threshold;
    }

    /**
     * Verificar alto uso de memoria
     */
    protected function checkHighMemory(array $conditions): bool
    {
        $threshold = $conditions['threshold_mb'] ?? 512;
        $minutes = $conditions['minutes'] ?? 10;

        $avgMemory = TrafficLog::where('logged_at', '>=', now()->subMinutes($minutes))
            ->whereNotNull('memory_usage_mb')
            ->avg('memory_usage_mb');

        // Guardar el uso de memoria para el mensaje
        $this->lastMemoryUsage = $avgMemory ?? 0;

        return $avgMemory && $avgMemory > $threshold;
    }

    /**
     * Verificar condición personalizada
     */
    protected function checkCustom(array $conditions): bool
    {
        // Implementar lógica personalizada según las condiciones
        // Por ahora retornar false
        return false;
    }

    /**
     * Construir mensaje del alert
     */
    protected function buildAlertMessage(MonitoringAlert $alert, array $context = []): string
    {
        $message = "🚨 Alerta: {$alert->name}\n\n";

        $conditions = $alert->conditions ?? [];
        $routePattern = $conditions['route_pattern'] ?? null;

        switch ($alert->type) {
            case 'error_rate':
                $count = $context['count'] ?? $this->lastErrorCount ?? 'múltiples';
                $message .= "Se detectaron {$count} errores en los últimos minutos.";
                if ($routePattern) {
                    $message .= "\nRutas afectadas: {$routePattern}";
                }
                break;
            case 'traffic_spike':
                $count = $context['count'] ?? $this->lastTrafficCount ?? 'múltiples';
                $message .= "Pico de tráfico detectado: {$count} requests en los últimos minutos.";
                break;
            case 'slow_response':
                $responseTime = $context['response_time'] ?? $this->lastResponseTime ?? 'N/A';
                $threshold = $context['threshold'] ?? $conditions['threshold_ms'] ?? 'N/A';
                $message .= "Respuesta lenta detectada: {$responseTime}ms (umbral: {$threshold}ms)";
                if (isset($context['route'])) {
                    $message .= "\nRuta: {$context['route']}";
                }
                if ($routePattern) {
                    $message .= "\nRutas afectadas: {$routePattern}";
                }
                break;
            case 'high_memory':
                $memoryUsage = $context['memory_usage'] ?? $this->lastMemoryUsage ?? 'N/A';
                $threshold = $context['threshold'] ?? $conditions['threshold_mb'] ?? 'N/A';
                $message .= "Alto uso de memoria: {$memoryUsage}MB (umbral: {$threshold}MB)";
                break;
            default:
                $message .= "Condición personalizada activada.";
        }

        $message .= "\n\nTiempo: " . now()->format('d/m/Y H:i:s');

        return $message;
    }

    /**
     * Enviar alert por email usando Infobip
     */
    protected function sendEmailAlert(MonitoringAlert $alert, string $message): void
    {
        $email = env('MONITORING_ALERT_EMAIL', config('mail.from.address'));

        if (!$email) {
            Log::warning('No email configured for monitoring alerts');
            return;
        }

        try {
            // Usar Infobip para enviar emails de alertas
            $this->sendEmailViaInfobip($alert, $email, $message);
        } catch (\Exception $e) {
            Log::error('Failed to send email alert', [
                'error' => $e->getMessage(),
                'alert_id' => $alert->id,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Enviar email de alerta a través de Infobip API
     */
    protected function sendEmailViaInfobip(MonitoringAlert $alert, string $toEmail, string $message): void
    {
        $apiKey = env('INFOBIP_API_KEY');
        $baseUrl = rtrim(env('INFOBIP_BASE_URL', 'https://api.infobip.com'), '/');
        if (!str_starts_with($baseUrl, 'http')) {
            $baseUrl = 'https://' . $baseUrl;
        }
        $fromEmail = env('INFOBIP_EMAIL_FROM', config('mail.from.address'));
        // El nombre puede tener espacios, así que usamos trim para limpiar
        $fromName = trim(env('INFOBIP_EMAIL_FROM_NAME', config('mail.from.name', 'Linkiu Monitoreo')));

        if (!$apiKey) {
            throw new \Exception('INFOBIP_API_KEY no configurada');
        }

        // Construir el contenido HTML del email usando la plantilla
        $htmlContent = $this->buildAlertEmailHtml($alert, $message);

        // Validar que el email "from" esté configurado
        if (!$fromEmail) {
            throw new \Exception('INFOBIP_EMAIL_FROM no configurado. Debe usar el dominio verificado en Infobip (ej: noreply@www.linkiu.bio)');
        }

        // Payload para Infobip Email API
        // Formato según documentación: https://www.infobip.com/docs/email/send-email-over-api
        $payload = [
            'from' => $fromEmail,
            'to' => $toEmail,
            'subject' => "🚨 Alerta de Monitoreo: {$alert->name}",
            'html' => $htmlContent,
            'text' => strip_tags($message), // Versión texto plano
        ];

        // Si hay nombre del remitente, agregarlo al payload
        if ($fromName) {
            $payload['from'] = "{$fromName} <{$fromEmail}>";
        }

        Log::info('Enviando email de alerta vía Infobip', [
            'alert_id' => $alert->id,
            'to' => $toEmail,
            'from' => $payload['from'],
            'endpoint' => "{$baseUrl}/email/3/send"
        ]);

        // Infobip Email API requiere multipart/form-data (NO acepta JSON como WhatsApp)
        // Los logs confirman que multipart funciona correctamente
        $response = \Illuminate\Support\Facades\Http::timeout(30)->withHeaders([
            'Authorization' => 'App ' . $apiKey,
            'Accept' => 'application/json',
        ])->asMultipart()->post("{$baseUrl}/email/3/send", [
            [
                'name' => 'from',
                'contents' => $payload['from']
            ],
            [
                'name' => 'to',
                'contents' => $toEmail
            ],
            [
                'name' => 'subject',
                'contents' => $payload['subject']
            ],
            [
                'name' => 'html',
                'contents' => $htmlContent
            ],
            [
                'name' => 'text',
                'contents' => $payload['text']
            ],
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            $messageId = $responseData['messages'][0]['messageId'] ?? ($responseData['messageId'] ?? 'N/A');
            $status = $responseData['messages'][0]['status'] ?? ($responseData['status'] ?? null);
            
            Log::info('Email alert sent successfully via Infobip', [
                'alert_id' => $alert->id,
                'to' => $toEmail,
                'from' => $payload['from'],
                'message_id' => $messageId,
                'status' => $status,
                'full_response' => $responseData
            ]);
            
            // Si hay un status, verificar si hay algún problema
            if ($status && isset($status['name']) && $status['name'] !== 'PENDING') {
                Log::warning('Email alert status not PENDING', [
                    'message_id' => $messageId,
                    'status' => $status,
                    'description' => $status['description'] ?? 'N/A'
                ]);
            }
        } else {
            $errorBody = $response->body();
            $errorData = $response->json();
            $errorMessage = $errorData['requestError']['serviceException']['text'] ?? ($errorData['message'] ?? $errorBody);
            
            Log::error('Infobip Email API error', [
                'status' => $response->status(),
                'error' => $errorMessage,
                'body' => $errorBody,
                'full_response' => $errorData
            ]);
            
            throw new \Exception("Infobip Email API error: {$errorMessage}");
        }
    }

    /**
     * Construir HTML del email de alerta usando plantilla Blade
     */
    protected function buildAlertEmailHtml(MonitoringAlert $alert, string $message): string
    {
        $context = $this->getAlertContext($alert);
        $alertTypeConfig = $this->getAlertTypeConfig($alert->type);
        $appUrl = config('app.url');
        
        // Obtener logo desde S3 (Laravel Cloud) o fallback
        $logoUrl = $this->getLogoUrl();

        // Obtener detalles según el tipo de alerta
        $alertDetails = $this->getAlertDetailsForEmail($alert, $context);

        // Renderizar la plantilla Blade
        return view('superlinkiu::emails.plantillas-correo.monitoreo', [
            'alert' => $alert,
            'message' => $message,
            'alertTypeConfig' => $alertTypeConfig,
            'alertDetails' => $alertDetails,
            'logoUrl' => $logoUrl,
            'appUrl' => $appUrl,
        ])->render();
    }

    /**
     * Obtener configuración visual según el tipo de alerta
     */
    protected function getAlertTypeConfig(string $alertType): array
    {
        return match($alertType) {
            'error_rate' => [
                'icon' => $this->getWarningIcon(),
                'bgColor' => '#fef2f2',
                'borderColor' => '#ffe2e2',
                'iconBg' => '#fee2e2',
            ],
            'traffic_spike' => [
                'icon' => $this->getChartIcon(),
                'bgColor' => '#eff6ff',
                'borderColor' => '#dbeafe',
                'iconBg' => '#dbeafe',
            ],
            'slow_response' => [
                'icon' => $this->getClockIcon(),
                'bgColor' => '#fef3c7',
                'borderColor' => '#fde68a',
                'iconBg' => '#fde68a',
            ],
            'high_memory' => [
                'icon' => $this->getDatabaseIcon(),
                'bgColor' => '#f3e8ff',
                'borderColor' => '#e9d5ff',
                'iconBg' => '#e9d5ff',
            ],
            default => [
                'icon' => $this->getBellIcon(),
                'bgColor' => '#f1f5f9',
                'borderColor' => '#cbd5e1',
                'iconBg' => '#cbd5e1',
            ],
        };
    }

    /**
     * Obtener detalles formateados para el email según el tipo de alerta
     */
    protected function getAlertDetailsForEmail(MonitoringAlert $alert, array $context): array
    {
        $features = '';
        
        switch ($alert->type) {
            case 'error_rate':
                $features = "
                                                    <td style='width: 33.33%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #fef2f2; border: 1px solid #ffe2e2; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getWarningIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        Errores detectados: <strong>" . ($context['count'] ?? 0) . "</strong>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td style='width: 33.33%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #ecfdf5; border: 1px solid #d0fae5; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getStatsIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        Umbral configurado: <strong>" . ($context['threshold'] ?? 0) . "</strong>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td style='width: 33.33%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #fef2f2; border: 1px solid #ffe2e2; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getSearchIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        " . (isset($context['route_pattern']) && $context['route_pattern'] ? "Ruta: <strong>{$context['route_pattern']}</strong>" : "Revisa el dashboard") . "
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                ";
                break;
                
            case 'traffic_spike':
                $features = "
                                                    <td style='width: 50%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #eff6ff; border: 1px solid #dbeafe; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getChartIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        Requests detectados: <strong>" . number_format($context['count'] ?? 0) . "</strong>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td style='width: 50%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #ecfdf5; border: 1px solid #d0fae5; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getStatsIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        Umbral configurado: <strong>" . number_format($context['threshold'] ?? 0) . "</strong>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                ";
                break;
                
            case 'slow_response':
                $features = "
                                                    <td style='width: 33.33%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #fef3c7; border: 1px solid #fde68a; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getClockIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        Tiempo: <strong>" . round($context['response_time'] ?? 0, 2) . "ms</strong>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td style='width: 33.33%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #ecfdf5; border: 1px solid #d0fae5; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getClockIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        Umbral: <strong>" . ($context['threshold'] ?? 0) . "ms</strong>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td style='width: 33.33%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #fef2f2; border: 1px solid #ffe2e2; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getSearchIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        " . (isset($context['route_pattern']) && $context['route_pattern'] ? "Ruta: <strong>{$context['route_pattern']}</strong>" : "Revisa el dashboard") . "
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                ";
                break;
                
            case 'high_memory':
                $features = "
                                                    <td style='width: 50%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #f3e8ff; border: 1px solid #e9d5ff; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getDatabaseIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        Memoria usada: <strong>" . round($context['memory_usage'] ?? 0, 2) . "MB</strong>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td style='width: 50%; padding: 0 8px; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #ecfdf5; border: 1px solid #d0fae5; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getStatsIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        Umbral configurado: <strong>" . ($context['threshold'] ?? 0) . "MB</strong>
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                ";
                break;
                
            default:
                $features = "
                                                    <td style='width: 100%; padding: 0; vertical-align: top;'>
                                                        <table role='presentation' cellspacing='0' cellpadding='0' border='0' width='100%'>
                                                            <tr>
                                                                <td style='background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px; margin-bottom: 12px; text-align: center;'>
                                                                    <div style='width: 24px; height: 24px; margin: 0 auto; line-height: 24px;'>
                                                                        " . $this->getBellIcon() . "
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding-top: 12px;'>
                                                                    <p style='margin: 0; font-family: Inter, sans-serif; font-weight: 400; font-size: 14px; line-height: 20px; color: #314158;'>
                                                                        Revisa el dashboard para más detalles
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                ";
        }
        
        return ['features' => $features];
    }

    /**
     * Obtener URL del logo desde S3 o fallback
     * Retorna null si no hay logo disponible (la plantilla mostrará texto)
     */
    protected function getLogoUrl(): ?string
    {
        try {
            // Intentar obtener logo desde BillingSetting (S3)
            $settings = BillingSetting::getInstance();
            if ($settings && $settings->app_logo) {
                $logoPath = $settings->app_logo;
                
                // Verificar si el archivo existe
                if (Storage::disk('public')->exists($logoPath)) {
                    $logoUrl = Storage::disk('public')->url($logoPath);
                    
                    // Asegurar URL absoluta
                    if (!str_starts_with($logoUrl, 'http')) {
                        $logoUrl = config('app.url') . '/' . ltrim($logoUrl, '/');
                    }
                    
                    // Asegurar HTTPS en producción
                    if (config('app.env') === 'production' && str_starts_with($logoUrl, 'http://')) {
                        $logoUrl = str_replace('http://', 'https://', $logoUrl);
                    }
                    
                    Log::info('Logo URL generada', ['url' => $logoUrl, 'path' => $logoPath]);
                    return $logoUrl;
                } else {
                    Log::warning('Logo no existe en storage', ['path' => $logoPath]);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Error obteniendo logo desde BillingSetting', ['error' => $e->getMessage()]);
        }
        
        // Intentar fallback a ruta local
        $fallbackPath = 'images-ui/base_ui_login_logo.svg';
        if (file_exists(public_path($fallbackPath))) {
            $fallbackUrl = config('app.url') . '/' . ltrim($fallbackPath, '/');
            Log::info('Usando logo fallback local', ['url' => $fallbackUrl]);
            return $fallbackUrl;
        }
        
        // Si no hay logo disponible, retornar null (la plantilla mostrará texto)
        Log::info('No hay logo disponible, usando texto');
        return null;
    }

    /**
     * Icono de advertencia (texto compatible con emails)
     */
    protected function getWarningIcon(): string
    {
        return '<span style="font-size: 20px; color: #dc2626; font-weight: bold;">⚠</span>';
    }

    /**
     * Icono de gráfico (texto compatible con emails)
     */
    protected function getChartIcon(): string
    {
        return '<span style="font-size: 20px; color: #155dfc;">📈</span>';
    }

    /**
     * Icono de reloj (texto compatible con emails)
     */
    protected function getClockIcon(): string
    {
        return '<span style="font-size: 20px; color: #f59e0b;">⏱</span>';
    }

    /**
     * Icono de base de datos (texto compatible con emails)
     */
    protected function getDatabaseIcon(): string
    {
        return '<span style="font-size: 20px; color: #9333ea;">💾</span>';
    }

    /**
     * Icono de campana (texto compatible con emails)
     */
    protected function getBellIcon(): string
    {
        return '<span style="font-size: 20px; color: #64748b;">🔔</span>';
    }

    /**
     * Icono de búsqueda (texto compatible con emails)
     */
    protected function getSearchIcon(): string
    {
        return '<span style="font-size: 20px; color: #dc2626;">🔍</span>';
    }

    /**
     * Icono de estadísticas (texto compatible con emails)
     */
    protected function getStatsIcon(): string
    {
        return '<span style="font-size: 20px; color: #10b981;">📊</span>';
    }

    /**
     * Enviar alert por WhatsApp
     */
    protected function sendWhatsAppAlert(MonitoringAlert $alert, string $message): void
    {
        $phone = env('MONITORING_ALERT_WHATSAPP');

        if (!$phone || !$this->otpSmsService || !$this->otpSmsService->isEnabled()) {
            Log::warning('WhatsApp not configured for monitoring alerts');
            return;
        }

        try {
            $conditions = $alert->conditions ?? [];
            $templateName = $this->getWhatsAppTemplateName($alert->type);
            $templateData = $this->buildWhatsAppTemplateData($alert, $conditions);

            // Log para debugging
            Log::info('WhatsApp alert prepared', [
                'alert_id' => $alert->id,
                'template_name' => $templateName,
                'template_data' => $templateData,
                'phone' => $phone
            ]);

            // TODO: Implementar envío real cuando las plantillas estén aprobadas en Infobip
            // Por ahora solo logueamos
            // $this->otpSmsService->sendWhatsAppTemplate($phone, $templateName, $templateData);
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp alert', [
                'error' => $e->getMessage(),
                'alert_id' => $alert->id
            ]);
        }
    }

    /**
     * Obtener nombre de plantilla WhatsApp según tipo de alerta
     */
    protected function getWhatsAppTemplateName(string $alertType): string
    {
        return match($alertType) {
            'error_rate' => 'monitoring_error_alert_es',
            'traffic_spike' => 'monitoring_traffic_spike_alert_es',
            'slow_response' => 'monitoring_slow_response_alert_es',
            'high_memory' => 'monitoring_high_memory_alert_es',
            default => 'monitoring_error_alert_es',
        };
    }

    /**
     * Construir datos para plantilla WhatsApp
     */
    protected function buildWhatsAppTemplateData(MonitoringAlert $alert, array $conditions): array
    {
        $context = $this->getAlertContext($alert);
        $routePattern = $conditions['route_pattern'] ?? null;

        return match($alert->type) {
            'error_rate' => [
                $alert->name,
                (string)($context['count'] ?? $this->lastErrorCount ?? 0),
                $routePattern ? "Rutas afectadas: {$routePattern}" : "Revisa el dashboard de monitoreo para más detalles.",
                now()->format('d/m/Y H:i:s')
            ],
            'traffic_spike' => [
                $alert->name,
                number_format($context['count'] ?? $this->lastTrafficCount ?? 0),
                number_format($context['threshold'] ?? $conditions['threshold'] ?? 1000),
                now()->format('d/m/Y H:i:s')
            ],
            'slow_response' => [
                $alert->name,
                (string)round($context['response_time'] ?? $this->lastResponseTime ?? 0, 2),
                (string)($context['threshold'] ?? $conditions['threshold_ms'] ?? 3000),
                $routePattern ? "Rutas afectadas: {$routePattern}" : "Revisa el dashboard de monitoreo para más detalles.",
                now()->format('d/m/Y H:i:s')
            ],
            'high_memory' => [
                $alert->name,
                (string)round($context['memory_usage'] ?? $this->lastMemoryUsage ?? 0, 2),
                (string)($context['threshold'] ?? $conditions['threshold_mb'] ?? 512),
                now()->format('d/m/Y H:i:s')
            ],
            default => [
                $alert->name,
                'Error desconocido',
                'Revisa el dashboard de monitoreo',
                now()->format('d/m/Y H:i:s')
            ],
        };
    }

    /**
     * Loggear alert in-app
     */
    protected function logInAppAlert(MonitoringAlert $alert, string $message): void
    {
        Log::warning('In-app alert', [
            'alert_id' => $alert->id,
            'alert_name' => $alert->name,
            'message' => $message
        ]);
    }
}

