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
        
        // Usar plantilla: order_placed_notification_es_v2
        // Variables: {{1}} = pedido, {{2}} = tienda, {{3}} = número WhatsApp negocio
        return $this->sendTemplateMessage($phone, 'order_placed_notification_es_v2', [
            ['type' => 'text', 'text' => $order->order_number],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Cambio de Estado (Cliente)
     */
    public function notifyOrderStatusChanged($order, $oldStatus, $newStatus)
    {
        $phone = $this->formatPhone($order->customer_phone);
        $store = $order->store;
        
        $statusLabels = [
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmado',
            'preparing' => 'En preparación',
            'shipped' => 'En camino',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado'
        ];

        $statusLabel = $statusLabels[$newStatus] ?? $newStatus;
        
        // Usar plantilla: order_status_es_v2
        // Variables: {{1}} = pedido, {{2}} = nuevo estado, {{3}} = número WhatsApp negocio
        return $this->sendTemplateMessage($phone, 'order_status_es_v2', [
            ['type' => 'text', 'text' => $order->order_number],
            ['type' => 'text', 'text' => $statusLabel],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Nuevo Pedido (Admin)
     */
    public function notifyAdminNewOrder($order, $store)
    {
        // Usar el número del admin/store owner
        $adminPhone = $this->formatPhone($store->owner_phone ?? $this->phone);
        
        // Usar plantilla: order_registration_notification_es
        // Variables: {{1}} = pedido, {{2}} = cliente, {{3}} = total
        return $this->sendTemplateMessage($adminPhone, 'order_registration_notification_es', [
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
        
        // Usar plantilla: payment_proof_received_notification_es
        // Variables: {{1}} = pedido, {{2}} = cliente
        return $this->sendTemplateMessage($adminPhone, 'payment_proof_received_notification_es', [
            ['type' => 'text', 'text' => $order->order_number],
            ['type' => 'text', 'text' => $order->customer_name]
        ]);
    }

    /**
     * Formatear número de teléfono para envío (con código de país)
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
     * Formatear número de teléfono de la tienda para mostrar (sin código de país)
     * Usado en las plantillas de WhatsApp
     */
    protected function formatStorePhoneForDisplay($store)
    {
        $storePhone = $store->owner_phone ?? $store->phone ?? 'N/A';
        $storePhoneDisplay = preg_replace('/[^0-9]/', '', $storePhone);
        
        // Remover código de país si está presente
        if (substr($storePhoneDisplay, 0, 2) === '57' && strlen($storePhoneDisplay) === 12) {
            $storePhoneDisplay = substr($storePhoneDisplay, 2);
        }
        
        return $storePhoneDisplay;
    }

    /**
     * Verificar si las notificaciones están habilitadas
     */
    public function isEnabled()
    {
        return !empty($this->userId) && !empty($this->secret);
    }

    /**
     * ========================================
     * NOTIFICACIONES DE RESERVACIONES
     * ========================================
     */

    /**
     * Notificación: Reserva Solicitada (Cliente)
     * Plantilla: reservation_requested_es_v3
     * Variables: {{1}} = código reserva, {{2}} = tienda, {{3}} = fecha, {{4}} = hora, {{5}} = número WhatsApp negocio
     */
    public function notifyReservationRequested($reservation)
    {
        $phone = $this->formatPhone($reservation->customer_phone);
        $store = $reservation->store;
        
        $date = $reservation->reservation_date->format('d/m/Y');
        $time = $reservation->reservation_time;
        
        return $this->sendTemplateMessage($phone, 'reservation_requested_es_v3', [
            ['type' => 'text', 'text' => $reservation->reference_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => $date],
            ['type' => 'text', 'text' => $time],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Reserva Confirmada (Cliente)
     * Plantilla: reservation_confirmed_es_v3
     * Variables: {{1}} = código reserva, {{2}} = tienda, {{3}} = fecha, {{4}} = hora, {{5}} = mesa, {{6}} = número WhatsApp negocio
     */
    public function notifyReservationConfirmed($reservation)
    {
        $phone = $this->formatPhone($reservation->customer_phone);
        $store = $reservation->store;
        
        $date = $reservation->reservation_date->format('d/m/Y');
        $time = $reservation->reservation_time;
        $tableInfo = $reservation->table 
            ? "Mesa {$reservation->table->table_number}" 
            : 'Mesa por asignar';
        
        return $this->sendTemplateMessage($phone, 'reservation_confirmed_es_v3', [
            ['type' => 'text', 'text' => $reservation->reference_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => $date],
            ['type' => 'text', 'text' => $time],
            ['type' => 'text', 'text' => $tableInfo],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Recordatorio de Reserva (Cliente)
     * Plantilla: reservation_reminder_client_es_v3
     * Variables: {{1}} = código reserva, {{2}} = tienda, {{3}} = fecha, {{4}} = hora, {{5}} = número WhatsApp negocio
     */
    public function notifyReservationReminder($reservation)
    {
        $phone = $this->formatPhone($reservation->customer_phone);
        $store = $reservation->store;
        
        $date = $reservation->reservation_date->format('d/m/Y');
        $time = $reservation->reservation_time;
        
        return $this->sendTemplateMessage($phone, 'reservation_reminder_client_es_v3', [
            ['type' => 'text', 'text' => $reservation->reference_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => $date],
            ['type' => 'text', 'text' => $time],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Reserva Cancelada (Cliente)
     * Plantilla: reservation_client_es
     * Variables: {{1}} = referencia, {{2}} = tienda, {{3}} = estado, {{4}} = número WhatsApp tienda
     */
    public function notifyReservationCancelled($reservation)
    {
        $phone = $this->formatPhone($reservation->customer_phone);
        $store = $reservation->store;
        
        return $this->sendTemplateMessage($phone, 'reservation_client_es', [
            ['type' => 'text', 'text' => $reservation->reference_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => 'Cancelada'],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Nueva Reserva (Admin)
     * Plantilla: reservation_admin_es
     * Variables: {{1}} = referencia, {{2}} = cliente, {{3}} = fecha, {{4}} = hora, {{5}} = personas
     */
    public function notifyAdminNewReservation($reservation, $store)
    {
        $adminPhone = $this->formatPhone($store->owner_phone ?? $this->phone);
        
        $date = $reservation->reservation_date->format('d/m/Y');
        $time = $reservation->reservation_time;
        $partySize = $reservation->party_size . ' ' . ($reservation->party_size == 1 ? 'persona' : 'personas');
        
        return $this->sendTemplateMessage($adminPhone, 'reservation_admin_es', [
            ['type' => 'text', 'text' => $reservation->reference_code],
            ['type' => 'text', 'text' => $reservation->customer_name],
            ['type' => 'text', 'text' => $date],
            ['type' => 'text', 'text' => $time],
            ['type' => 'text', 'text' => $partySize]
        ]);
    }

    /**
     * ========================================
     * NOTIFICACIONES DE RESERVAS DE HOTEL
     * ========================================
     */

    /**
     * Notificación: Reserva de Hotel Solicitada (Cliente)
     * Plantilla: hotel_reservation_requested_es_v2
     * Variables: {{1}} = código reserva, {{2}} = hotel, {{3}} = tipo habitación, {{4}} = check-in, {{5}} = check-out, {{6}} = noches, {{7}} = número WhatsApp negocio
     */
    public function notifyHotelReservationRequested($hotelReservation)
    {
        $phone = $this->formatPhone($hotelReservation->guest_phone);
        $store = $hotelReservation->store;
        
        $checkIn = $hotelReservation->check_in_date->format('d/m/Y');
        $checkOut = $hotelReservation->check_out_date->format('d/m/Y');
        $nights = $hotelReservation->num_nights . ' ' . ($hotelReservation->num_nights == 1 ? 'noche' : 'noches');
        
        return $this->sendTemplateMessage($phone, 'hotel_reservation_requested_es_v2', [
            ['type' => 'text', 'text' => $hotelReservation->reservation_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => $hotelReservation->roomType->name],
            ['type' => 'text', 'text' => $checkIn],
            ['type' => 'text', 'text' => $checkOut],
            ['type' => 'text', 'text' => $nights],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Reserva de Hotel Confirmada (Cliente)
     * Plantilla: hotel_reservation_confirmed_es_v2
     * Variables: {{1}} = código reserva, {{2}} = hotel, {{3}} = habitación #, {{4}} = tipo, {{5}} = check-in, {{6}} = check-out, {{7}} = número WhatsApp negocio
     */
    public function notifyHotelReservationConfirmed($hotelReservation)
    {
        $phone = $this->formatPhone($hotelReservation->guest_phone);
        $store = $hotelReservation->store;
        
        $checkIn = $hotelReservation->check_in_date->format('d/m/Y');
        $checkOut = $hotelReservation->check_out_date->format('d/m/Y');
        $roomInfo = $hotelReservation->room 
            ? "Habitación #{$hotelReservation->room->room_number}" 
            : 'Habitación por asignar';
        
        return $this->sendTemplateMessage($phone, 'hotel_reservation_confirmed_es_v2', [
            ['type' => 'text', 'text' => $hotelReservation->reservation_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => $roomInfo],
            ['type' => 'text', 'text' => $hotelReservation->roomType->name],
            ['type' => 'text', 'text' => $checkIn],
            ['type' => 'text', 'text' => $checkOut],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Recordatorio Check-in (Cliente)
     * Plantilla: hotel_checkin_reminder_es_v2
     * Variables: {{1}} = código reserva, {{2}} = hotel, {{3}} = habitación #, {{4}} = fecha check-in, {{5}} = hora check-in, {{6}} = número WhatsApp negocio
     */
    public function notifyHotelCheckinReminder($hotelReservation)
    {
        $phone = $this->formatPhone($hotelReservation->guest_phone);
        $store = $hotelReservation->store;
        
        $checkInDate = $hotelReservation->check_in_date->format('d/m/Y');
        $roomInfo = $hotelReservation->room 
            ? "Habitación #{$hotelReservation->room->room_number}" 
            : 'Habitación por asignar';
        
        // Obtener hora de check-in de settings
        $settings = \App\Shared\Models\HotelSetting::where('store_id', $store->id)->first();
        $checkInTime = $settings 
            ? \Carbon\Carbon::parse($settings->check_in_time)->format('g:i A')
            : '3:00 PM';
        
        return $this->sendTemplateMessage($phone, 'hotel_checkin_reminder_es_v2', [
            ['type' => 'text', 'text' => $hotelReservation->reservation_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => $roomInfo],
            ['type' => 'text', 'text' => $checkInDate],
            ['type' => 'text', 'text' => $checkInTime],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Reserva de Hotel Cancelada (Cliente)
     * Plantilla: hotel_reservation_client_es
     * Variables: {{1}} = referencia, {{2}} = hotel, {{3}} = estado, {{4}} = número WhatsApp hotel
     */
    public function notifyHotelReservationCancelled($hotelReservation)
    {
        $phone = $this->formatPhone($hotelReservation->guest_phone);
        $store = $hotelReservation->store;
        
        return $this->sendTemplateMessage($phone, 'hotel_reservation_client_es', [
            ['type' => 'text', 'text' => $hotelReservation->reservation_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => 'Cancelada'],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Check-in Completado (Cliente)
     * Plantilla: hotel_reservation_client_es
     * Variables: {{1}} = referencia, {{2}} = hotel, {{3}} = estado, {{4}} = número WhatsApp hotel
     */
    public function notifyHotelCheckInCompleted($hotelReservation)
    {
        $phone = $this->formatPhone($hotelReservation->guest_phone);
        $store = $hotelReservation->store;
        
        $roomInfo = $hotelReservation->room 
            ? "Habitación #{$hotelReservation->room->room_number}" 
            : 'Habitación asignada';
        
        return $this->sendTemplateMessage($phone, 'hotel_reservation_client_es', [
            ['type' => 'text', 'text' => $hotelReservation->reservation_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => "Check-in completado - {$roomInfo}"],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Check-out Completado (Cliente)
     * Plantilla: hotel_reservation_client_es
     * Variables: {{1}} = referencia, {{2}} = hotel, {{3}} = estado, {{4}} = número WhatsApp hotel
     */
    public function notifyHotelCheckOutCompleted($hotelReservation)
    {
        $phone = $this->formatPhone($hotelReservation->guest_phone);
        $store = $hotelReservation->store;
        
        return $this->sendTemplateMessage($phone, 'hotel_reservation_client_es', [
            ['type' => 'text', 'text' => $hotelReservation->reservation_code],
            ['type' => 'text', 'text' => $store->name],
            ['type' => 'text', 'text' => 'Check-out completado - Gracias por tu visita'],
            ['type' => 'text', 'text' => $this->formatStorePhoneForDisplay($store)]
        ]);
    }

    /**
     * Notificación: Nueva Reserva de Hotel (Admin)
     * Plantilla: hotel_reservation_registration_notification_es
     * Variables: {{1}} = código reserva, {{2}} = huésped, {{3}} = tipo habitación, {{4}} = check-in, {{5}} = check-out, {{6}} = total
     */
    public function notifyAdminNewHotelReservation($hotelReservation, $store)
    {
        $adminPhone = $this->formatPhone($store->owner_phone ?? $this->phone);
        
        $checkIn = $hotelReservation->check_in_date->format('d/m/Y');
        $checkOut = $hotelReservation->check_out_date->format('d/m/Y');
        $total = '$' . number_format($hotelReservation->total, 0, ',', '.');
        
        return $this->sendTemplateMessage($adminPhone, 'hotel_reservation_registration_notification_es', [
            ['type' => 'text', 'text' => $hotelReservation->reservation_code],
            ['type' => 'text', 'text' => $hotelReservation->guest_name],
            ['type' => 'text', 'text' => $hotelReservation->roomType->name],
            ['type' => 'text', 'text' => $checkIn],
            ['type' => 'text', 'text' => $checkOut],
            ['type' => 'text', 'text' => $total]
        ]);
    }
}

