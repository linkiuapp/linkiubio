<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppNotificationService
{
    protected $userId;
    protected $secret;
    protected $phone;
    protected $botId;
    protected $token = null;
    protected $tokenExpiry = null;

    public function __construct()
    {
        $this->userId = env('SENDPULSE_USER_ID');
        $this->secret = env('SENDPULSE_SECRET');
        $this->phone = env('SENDPULSE_WHATSAPP_PHONE');
        $this->botId = env('SENDPULSE_BOT_ID', '68d1dfe7e42ed41d8a04c150');
    }

    /**
     * Obtener token de acceso
     */
    protected function getAccessToken()
    {
        // Si el token aún es válido, retornarlo
        if ($this->token && $this->tokenExpiry && now()->isBefore($this->tokenExpiry)) {
            return $this->token;
        }

        try {
            $response = Http::post('https://api.sendpulse.com/oauth/access_token', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->userId,
                'client_secret' => $this->secret
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (!isset($data['access_token'])) {
                    Log::error('SendPulse: Respuesta sin access_token', [
                        'response' => $data
                    ]);
                    return null;
                }
                
                $this->token = $data['access_token'];
                $this->tokenExpiry = now()->addSeconds($data['expires_in'] - 60);
                
                Log::info('SendPulse: Token obtenido correctamente');
                
                return $this->token;
            }

            Log::error('SendPulse: Error obteniendo token', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('SendPulse: Excepción obteniendo token', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Obtener o crear contacto en SendPulse
     */
    protected function getOrCreateContact($phone)
    {
        $token = $this->getAccessToken();
        
        if (!$token) {
            return null;
        }

        try {
            // 1. Buscar contacto existente primero
            $searchResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get('https://api.sendpulse.com/whatsapp/contacts', [
                'phone' => $phone
            ]);

            if ($searchResponse->successful()) {
                $data = $searchResponse->json();
                // Si se encuentra en los resultados
                if (!empty($data) && isset($data[0]['id'])) {
                    Log::info('SendPulse: Contacto encontrado', [
                        'phone' => $phone,
                        'contact_id' => $data[0]['id']
                    ]);
                    return $data[0]['id'];
                }
            }

            // 2. Si no existe, intentar crear contacto
            $createResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post('https://api.sendpulse.com/whatsapp/contacts', [
                'bot_id' => $this->botId,
                'phone' => $phone
            ]);

            if ($createResponse->successful()) {
                $data = $createResponse->json();
                $contactId = $data['id'] ?? null;
                Log::info('SendPulse: Contacto creado', [
                    'phone' => $phone,
                    'contact_id' => $contactId
                ]);
                return $contactId;
            }

            // 3. Si el error es "Contact already exists", buscar de nuevo con más detalle
            if ($createResponse->status() === 400) {
                $errorBody = $createResponse->json();
                if (isset($errorBody['errors']['phone']) && 
                    is_array($errorBody['errors']['phone']) && 
                    in_array('Contact already exists', $errorBody['errors']['phone'])) {
                    
                    Log::info('SendPulse: Contacto ya existe, buscando de nuevo...', ['phone' => $phone]);
                    
                    // Buscar de nuevo pero más exhaustivo
                    $retrySearch = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token
                    ])->get('https://api.sendpulse.com/whatsapp/contacts', [
                        'phone' => $phone
                    ]);
                    
                    if ($retrySearch->successful()) {
                        $data = $retrySearch->json();
                        if (!empty($data) && isset($data[0]['id'])) {
                            return $data[0]['id'];
                        }
                    }
                }
            }

            Log::error('SendPulse: Error creando contacto', [
                'status' => $createResponse->status(),
                'body' => $createResponse->body(),
                'phone' => $phone
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('SendPulse: Excepción obteniendo contacto', [
                'error' => $e->getMessage(),
                'phone' => $phone
            ]);
            return null;
        }
    }

    /**
     * Enviar mensaje de WhatsApp usando plantillas aprobadas
     */
    protected function sendTemplateMessage($to, $templateName, $parameters = [])
    {
        $token = $this->getAccessToken();
        
        if (!$token) {
            Log::error('SendPulse: No se pudo obtener token para plantilla');
            return false;
        }

            try {
                // Convertir parámetros al formato esperado por SendPulse
                $templateParams = [];
                foreach ($parameters as $param) {
                    $templateParams[] = [
                        'type' => 'text',
                        'text' => $param['text']
                    ];
                }
                
                // ESTRUCTURA CORRECTA según documentación oficial de SendPulse
                // https://sendpulse.com/integrations/api/chatbot/whatsapp
                $payload = [
                    'bot_id' => $this->botId,
                    'phone' => $to,
                    'template' => [
                        'name' => $templateName,
                        'language' => [
                            'code' => 'es'
                        ]
                    ]
                ];
                
                // Agregar components solo si hay parámetros
                if (!empty($templateParams)) {
                    $payload['template']['components'] = [
                        [
                            'type' => 'body',
                            'parameters' => $templateParams
                        ]
                    ];
                }
                
                Log::info('📤 Enviando plantilla WhatsApp', [
                    'endpoint' => 'sendTemplateByPhone',
                    'payload' => $payload
                ]);
                
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ])->post("https://api.sendpulse.com/whatsapp/contacts/sendTemplateByPhone", $payload);

            if ($response->successful()) {
                Log::info('✅ WhatsApp plantilla enviada correctamente', [
                    'to' => $to,
                    'template' => $templateName,
                    'parameters' => $parameters
                ]);
                return true;
            }

            Log::error('SendPulse: Error enviando plantilla', [
                'status' => $response->status(),
                'body' => $response->body(),
                'to' => $to,
                'template' => $templateName
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('SendPulse: Excepción enviando plantilla', [
                'error' => $e->getMessage(),
                'to' => $to,
                'template' => $templateName,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Notificación: Pedido Creado (Cliente)
     */
    public function notifyOrderCreated($order)
    {
        $phone = $this->formatPhone($order->customer_phone);
        $store = $order->store;
        
        // Usar plantilla: order_placed_notification_es
        // Variables: {{1}} = pedido, {{2}} = tienda
        return $this->sendTemplateMessage($phone, 'order_placed_notification_es', [
            ['type' => 'text', 'text' => $order->order_number],
            ['type' => 'text', 'text' => $store->name]
        ]);
    }

    /**
     * Notificación: Cambio de Estado (Cliente)
     */
    public function notifyOrderStatusChanged($order, $oldStatus, $newStatus)
    {
        $phone = $this->formatPhone($order->customer_phone);
        
        $statusLabels = [
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmado',
            'preparing' => 'En preparación',
            'shipped' => 'En camino',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado'
        ];

        $statusLabel = $statusLabels[$newStatus] ?? $newStatus;
        
        // Usar plantilla: order_status_es
        // Variables: {{1}} = pedido, {{2}} = nuevo estado
        return $this->sendTemplateMessage($phone, 'order_status_es', [
            ['type' => 'text', 'text' => $order->order_number],
            ['type' => 'text', 'text' => $statusLabel]
        ]);
    }

    /**
     * Notificación: Nuevo Pedido (Admin)
     */
    public function notifyAdminNewOrder($order, $store)
    {
        // Usar el número del admin/store owner
        $adminPhone = $this->formatPhone($store->owner_phone ?? $this->phone);
        
        // Usar plantilla: admin_new_order_notification_es
        // Variables: {{1}} = pedido, {{2}} = cliente, {{3}} = total
        return $this->sendTemplateMessage($adminPhone, 'admin_new_order_notification_es', [
            ['type' => 'text', 'text' => $order->order_number],
            ['type' => 'text', 'text' => $order->customer_name],
            ['type' => 'text', 'text' => $order->formatted_total]
        ]);
    }

    /**
     * Notificación: Comprobante de Pago Subido (Admin)
     */
    public function notifyAdminPaymentProofUploaded($order, $store)
    {
        $adminPhone = $this->formatPhone($store->owner_phone ?? $this->phone);
        
        // Usar plantilla: admin_payment_proof_uploaded_es
        // Variables: {{1}} = pedido, {{2}} = cliente
        return $this->sendTemplateMessage($adminPhone, 'admin_payment_proof_uploaded_es', [
            ['type' => 'text', 'text' => $order->order_number],
            ['type' => 'text', 'text' => $order->customer_name]
        ]);
    }

    /**
     * Formatear número de teléfono
     */
    protected function formatPhone($phone)
    {
        // Remover caracteres no numéricos
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Si empieza con 57 (Colombia), ya tiene código de país
        if (substr($phone, 0, 2) === '57') {
            return $phone;
        }
        
        // Si empieza con 3 (celular Colombia), agregar 57
        if (substr($phone, 0, 1) === '3' && strlen($phone) === 10) {
            return '57' . $phone;
        }
        
        return $phone;
    }

    /**
     * Verificar si las notificaciones están habilitadas
     */
    public function isEnabled()
    {
        return !empty($this->userId) && !empty($this->secret);
    }
}

