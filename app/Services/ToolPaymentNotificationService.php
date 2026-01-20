<?php

namespace App\Services;

use App\Models\LinkiuTool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Servicio para enviar notificaciones de pago por WhatsApp usando Infobip
 * 
 * NOTA: La plantilla debe estar en categoría UTILITY (utilidad) en Infobip
 * Los recordatorios de pago son notificaciones transaccionales, no marketing
 */
class ToolPaymentNotificationService
{
    protected $apiKey;
    protected $baseUrl;
    protected $whatsappSender;
    protected $templateName;

    public function __construct()
    {
        $this->apiKey = env('INFOBIP_API_KEY');
        $baseUrl = env('INFOBIP_BASE_URL');
        
        if ($baseUrl) {
            $baseUrl = rtrim($baseUrl, '/');
            if (!str_starts_with($baseUrl, 'http')) {
                $baseUrl = 'https://' . $baseUrl;
            }
        }
        
        $this->baseUrl = $baseUrl ?: 'https://api.infobip.com';
        $this->whatsappSender = env('INFOBIP_WHATSAPP_SENDER');
        // Plantilla en categoría UTILITY (utilidad) - usando plantilla existente: auto_pay_reminder_es
        // IMPORTANTE: Debe ser UTILITY, no MARKETING, porque son notificaciones transaccionales
        $this->templateName = env('INFOBIP_WHATSAPP_TOOL_PAYMENT_TEMPLATE', 'auto_pay_reminder_es');
    }

    /**
     * Verificar si el servicio está habilitado
     */
    public function isEnabled(): bool
    {
        return !empty($this->apiKey) && !empty($this->whatsappSender);
    }

    /**
     * Enviar notificación de pago próximo
     * 
     * @param LinkiuTool $tool Herramienta
     * @param string|null $customMessage Mensaje personalizado (opcional)
     * @return array ['success' => bool, 'message' => string]
     */
    public function sendPaymentReminder(LinkiuTool $tool, ?string $customMessage = null): array
    {
        if (!$this->isEnabled()) {
            return [
                'success' => false,
                'message' => 'Servicio WhatsApp no habilitado'
            ];
        }

        if (!$tool->notification_phone) {
            return [
                'success' => false,
                'message' => 'La herramienta no tiene número de teléfono configurado'
            ];
        }

        try {
            $formattedPhone = $this->formatPhone($tool->notification_phone);
            $params = $this->buildMessageParams($tool, $customMessage);

            $payload = [
                'messages' => [
                    [
                        'from' => $this->whatsappSender,
                        'to' => $formattedPhone,
                        'content' => [
                            'templateName' => $this->templateName,
                            'templateData' => [
                                'body' => [
                                    'placeholders' => $params
                                ]
                            ],
                            'language' => 'es'
                        ]
                    ]
                ]
            ];

            Log::info('ToolPaymentNotification: Enviando notificación de pago', [
                'tool_id' => $tool->id,
                'tool_name' => $tool->name,
                'phone' => $formattedPhone,
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'App ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post("{$this->baseUrl}/whatsapp/1/message/template", $payload);

            if ($response->successful()) {
                Log::info('ToolPaymentNotification: Notificación enviada exitosamente', [
                    'tool_id' => $tool->id,
                ]);

                return [
                    'success' => true,
                    'message' => 'Notificación enviada exitosamente'
                ];
            } else {
                $errorMessage = $response->json()['requestError']['serviceException']['text'] ?? 'Error desconocido';
                
                Log::error('ToolPaymentNotification: Error enviando notificación', [
                    'tool_id' => $tool->id,
                    'error' => $errorMessage,
                    'response' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'message' => "Error: {$errorMessage}"
                ];
            }

        } catch (\Exception $e) {
            Log::error('ToolPaymentNotification: Excepción al enviar notificación', [
                'tool_id' => $tool->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => "Error: {$e->getMessage()}"
            ];
        }
    }

    /**
     * Construir parámetros del mensaje para la plantilla
     * 
     * Plantilla: auto_pay_reminder_es (categoría UTILITY)
     * 
     * Estructura de la plantilla:
     * "Hola,
     * Tu pago automático {{1}}, por un valor {{2}}, está programado para el {{3}} en la cuenta {{4}}.
     * Asegúrate de tener saldo suficiente para evitar cargos."
     * 
     * Parámetros esperados:
     * {{1}} = Tipo de facturación (ej: "Mensual", "Anual", "Renovación")
     * {{2}} = Valor/monto formateado (ej: "USD 50.00" o "COP 200,000.00")
     * {{3}} = Fecha programada (ej: "15 de enero de 2025")
     * {{4}} = Cuenta/nombre de la herramienta (ej: "Stripe", "AWS")
     */
    protected function buildMessageParams(LinkiuTool $tool, ?string $customMessage = null): array
    {
        $toolName = $tool->name;
        $amount = $tool->getFormattedCost();
        
        // Tipo de facturación
        $billingType = match($tool->billing_type) {
            'monthly' => 'Mensual',
            'yearly' => 'Anual',
            'pay_per_use' => 'Por uso',
            default => 'Renovación'
        };
        
        // Formatear fecha
        $dueDate = $tool->next_renewal_date 
            ? $tool->next_renewal_date->format('d \d\e F \d\e Y')
            : 'No definida';

        return [
            $billingType,  // {{1}} - Tipo de facturación (ej: "Mensual", "Anual")
            $amount,        // {{2}} - Valor/monto formateado
            $dueDate,       // {{3}} - Fecha programada
            $toolName,      // {{4}} - Cuenta/nombre de la herramienta
        ];
    }

    /**
     * Formatear número de teléfono al formato internacional
     */
    protected function formatPhone(string $phone): string
    {
        // Eliminar espacios y caracteres especiales
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Si no empieza con +, agregar código de país de Colombia
        if (!str_starts_with($phone, '+')) {
            // Si empieza con 57, agregar +
            if (str_starts_with($phone, '57')) {
                $phone = '+' . $phone;
            } else {
                // Asumir que es número colombiano y agregar +57
                $phone = '+57' . $phone;
            }
        }
        
        return $phone;
    }
}
