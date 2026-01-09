<?php

namespace App\Features\SuperLinkiu\Services\SubscriptionDev;

use App\Features\SuperLinkiu\Models\SubSubscription;
use App\Features\SuperLinkiu\Models\SubPayment;
use App\Features\SuperLinkiu\Models\SubReminder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SubWhatsAppService
{
    protected $apiKey;
    protected $baseUrl;
    protected $whatsappSender;

    // Plantilla específica para facturación/suscripciones
    protected $templateName = 'linkiudev_invoice_notice_es';

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
    }

    /**
     * Verificar si el servicio está habilitado
     */
    public function isEnabled(): bool
    {
        return !empty($this->apiKey) && !empty($this->whatsappSender);
    }

    /**
     * Enviar recordatorio de pago
     */
    public function sendPaymentReminder(SubSubscription $subscription, ?int $daysUntilDue = null): bool
    {
        $client = $subscription->client;
        
        if (!$client || empty($client->phone)) {
            Log::warning('SubscriptionDev WhatsApp: Cliente sin teléfono', [
                'subscription_id' => $subscription->id
            ]);
            return false;
        }

        $phone = $client->full_phone;
        $daysUntilDue = $daysUntilDue ?? $subscription->days_until_due;

        // Monto formateado
        $amount = number_format($subscription->amount, 0, ',', '.');

        // Plantilla linkiudev_invoice_notice_es:
        // Aviso de facturacion.
        // Cliente: {{1}}
        // Servicio: {{2}}
        // Fecha de vencimiento: {{3}}
        // Monto: {{4}} COP
        // Paga en: {{5}}
        $params = [
            $client->name,                                    // {{1}} Cliente
            $subscription->service_name,                      // {{2}} Servicio
            $subscription->next_billing_date->format('d/m/Y'),// {{3}} Fecha de vencimiento
            $amount,                                          // {{4}} Monto
            $subscription->public_url,                        // {{5}} Link de pago
        ];

        // Crear registro de recordatorio
        $reminderType = $daysUntilDue <= 0 ? 'overdue' : "reminder_{$daysUntilDue}d";
        $reminder = SubReminder::createForSubscription($subscription, $reminderType);

        $result = $this->sendTemplateMessage($phone, $params);

        if ($result['success']) {
            $reminder->markAsSent($result['message_id'] ?? null);
            return true;
        } else {
            $reminder->markAsFailed($result['error'] ?? 'Error desconocido');
            return false;
        }
    }

    /**
     * Enviar confirmación de pago
     */
    public function sendPaymentConfirmation(SubPayment $payment): bool
    {
        $subscription = $payment->subscription;
        $client = $subscription->client;
        
        if (!$client || empty($client->phone)) {
            return false;
        }

        $phone = $client->full_phone;

        $params = [
            $client->name,                           // {{1}} Nombre
            $subscription->service_name,             // {{2}} Servicio
            '✅ Pago recibido',                      // {{3}} Estado
            "Monto: {$payment->formatted_amount}",   // {{4}}
            "Tu suscripción está activa hasta el {$subscription->next_billing_date->format('d/m/Y')}. ¡Gracias!", // {{5}}
        ];

        $result = $this->sendTemplateMessage($phone, $params);

        return $result['success'];
    }

    /**
     * Enviar mensaje usando plantilla de Infobip
     */
    protected function sendTemplateMessage(string $phone, array $params): array
    {
        if (!$this->isEnabled()) {
            Log::warning('SubscriptionDev WhatsApp: Servicio no habilitado');
            return ['success' => false, 'error' => 'Servicio no habilitado'];
        }

        try {
            $formattedPhone = $this->formatPhone($phone);

            $placeholders = [];
            foreach ($params as $param) {
                $placeholders[] = (string) $param;
            }

            $payload = [
                'messages' => [
                    [
                        'from' => $this->whatsappSender,
                        'to' => $formattedPhone,
                        'content' => [
                            'templateName' => $this->templateName,
                            'templateData' => [
                                'body' => [
                                    'placeholders' => $placeholders
                                ]
                            ],
                            'language' => 'es_CO'
                        ]
                    ]
                ]
            ];

            Log::info('SubscriptionDev WhatsApp: Enviando mensaje', [
                'to' => $formattedPhone,
                'template' => $this->templateName,
                'placeholders' => $placeholders
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'App ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post("{$this->baseUrl}/whatsapp/1/message/template", $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                $messageId = $responseData['messages'][0]['messageId'] ?? null;

                Log::info('SubscriptionDev WhatsApp: Mensaje enviado', [
                    'message_id' => $messageId,
                    'to' => $formattedPhone
                ]);

                return ['success' => true, 'message_id' => $messageId];
            }

            $errorMessage = $response->json()['requestError']['serviceException']['text'] 
                ?? $response->body();

            Log::error('SubscriptionDev WhatsApp: Error enviando mensaje', [
                'status' => $response->status(),
                'error' => $errorMessage,
                'to' => $formattedPhone
            ]);

            return ['success' => false, 'error' => $errorMessage];

        } catch (\Exception $e) {
            Log::error('SubscriptionDev WhatsApp: Excepción', [
                'error' => $e->getMessage(),
                'to' => $phone
            ]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Formatear número de teléfono
     */
    protected function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Si tiene 10 dígitos y empieza con 3, asumir Colombia
        if (strlen($phone) === 10 && str_starts_with($phone, '3')) {
            return '57' . $phone;
        }

        // Si ya tiene código de país
        if (strlen($phone) >= 11) {
            return $phone;
        }

        return $phone;
    }
}
