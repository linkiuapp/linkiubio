<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Servicio genérico para envío de códigos OTP por WhatsApp
 * Implementación actual: Infobip WhatsApp Business API
 * 
 * Este servicio está diseñado para ser independiente del proveedor,
 * permitiendo cambiar de proveedor sin modificar el código que lo usa.
 */
class OTPSmsService
{
    protected $apiKey;
    protected $baseUrl;
    protected $whatsappSender;
    protected $templateName;
    protected $templateLanguage;

    public function __construct()
    {
        // Configuración del proveedor WhatsApp (Infobip)
        $this->apiKey = env('INFOBIP_API_KEY');
        // URL base personalizada de Infobip (formato: https://{subdomain}.api.infobip.com)
        $baseUrl = env('INFOBIP_BASE_URL');
        if ($baseUrl) {
            // Remover barra final si existe
            $baseUrl = rtrim($baseUrl, '/');
            // Agregar https:// si no está presente
            if (!str_starts_with($baseUrl, 'http')) {
                $baseUrl = 'https://' . $baseUrl;
            }
        }
        $this->baseUrl = $baseUrl ?: 'https://api.infobip.com';
        // Número de WhatsApp Business (formato: 15557334575)
        $this->whatsappSender = env('INFOBIP_WHATSAPP_SENDER');
        // Nombre de la plantilla de WhatsApp aprobada
        $this->templateName = env('INFOBIP_WHATSAPP_OTP_TEMPLATE', 'password_reset_code_es');
        // Idioma de la plantilla (puede ser 'es' o 'es_CO')
        $this->templateLanguage = env('INFOBIP_WHATSAPP_TEMPLATE_LANGUAGE', 'es');
    }

    /**
     * Verificar si el servicio está habilitado
     */
    public function isEnabled()
    {
        return !empty($this->apiKey) && !empty($this->whatsappSender);
    }

    /**
     * Enviar código OTP por WhatsApp
     * 
     * @param string $phone Número de teléfono del destinatario
     * @param string $code Código OTP de 6 dígitos
     * @param string|null $message Mensaje personalizado (opcional, se usa para personalizar el mensaje de la plantilla)
     * @return bool
     */
    public function sendOTP($phone, $code, $message = null)
    {
        if (!$this->isEnabled()) {
            Log::error('OTP WhatsApp: Servicio no habilitado. Verifica INFOBIP_API_KEY e INFOBIP_WHATSAPP_SENDER en .env');
            return false;
        }

        try {
            $formattedPhone = $this->formatPhone($phone);
            
            // Payload para WhatsApp usando plantilla
            // Formato según documentación oficial de Infobip
            // El endpoint /whatsapp/1/message/template requiere formato con messages array
            // La plantilla incluye botones, por lo que debemos incluir los parámetros de botones también
            $payload = [
                'messages' => [
                    [
                        'from' => $this->whatsappSender,
                        'to' => $formattedPhone,
                        'content' => [
                            'templateName' => $this->templateName,
                            'templateData' => [
                                'body' => [
                                    'placeholders' => [$code] // El código OTP como primer parámetro
                                ],
                                'buttons' => [
                                    [
                                        'type' => 'URL',
                                        'parameter' => $code // El código OTP también va en el botón
                                    ]
                                ]
                            ],
                            'language' => $this->templateLanguage
                        ]
                    ]
                ]
            ];

            Log::info('📤 OTP WhatsApp: Enviando código OTP', [
                'to' => $formattedPhone,
                'from' => $this->whatsappSender,
                'template' => $this->templateName,
                'code' => $code,
                'payload' => $payload
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'App ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post("{$this->baseUrl}/whatsapp/1/message/template", $payload);
            
            // Log de respuesta para debugging
            Log::info('📥 OTP WhatsApp: Respuesta de Infobip', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Verificar si hay errores en la respuesta
                // El formato de respuesta puede variar según el endpoint usado
                if (isset($responseData['messages']) && !empty($responseData['messages'])) {
                    // Formato con array messages
                    $messageStatus = $responseData['messages'][0]['status'] ?? null;
                    
                    if ($messageStatus && isset($messageStatus['name']) && $messageStatus['name'] === 'REJECTED') {
                        $errorDescription = $messageStatus['description'] ?? 'Desconocido';
                        $errorGroupName = $messageStatus['groupName'] ?? 'Desconocido';
                        
                        Log::error('❌ OTP WhatsApp: Mensaje rechazado por Infobip', [
                            'to' => $formattedPhone,
                            'status' => $messageStatus['name'],
                            'description' => $errorDescription,
                            'groupName' => $errorGroupName,
                            'errorId' => $messageStatus['id'] ?? null
                        ]);
                        
                        throw new \Exception("WHATSAPP_REJECTED: {$errorDescription}", 0);
                    }
                    
                    Log::info('✅ OTP WhatsApp: Código OTP enviado correctamente', [
                        'to' => $formattedPhone,
                        'messageId' => $responseData['messages'][0]['messageId'] ?? 'N/A',
                        'status' => $responseData['messages'][0]['status']['name'] ?? 'N/A'
                    ]);
                } elseif (isset($responseData['status'])) {
                    // Formato simple (sin array messages)
                    $messageStatus = $responseData['status'];
                    
                    if (isset($messageStatus['name']) && $messageStatus['name'] === 'REJECTED') {
                        $errorDescription = $messageStatus['description'] ?? 'Desconocido';
                        
                        Log::error('❌ OTP WhatsApp: Mensaje rechazado por Infobip', [
                            'to' => $formattedPhone,
                            'status' => $messageStatus['name'],
                            'description' => $errorDescription
                        ]);
                        
                        throw new \Exception("WHATSAPP_REJECTED: {$errorDescription}", 0);
                    }
                    
                    Log::info('✅ OTP WhatsApp: Código OTP enviado correctamente', [
                        'to' => $formattedPhone,
                        'messageId' => $responseData['messageId'] ?? 'N/A',
                        'status' => $messageStatus['name'] ?? 'N/A'
                    ]);
                } else {
                    // Respuesta exitosa pero formato desconocido
                    Log::info('✅ OTP WhatsApp: Código OTP enviado correctamente', [
                        'to' => $formattedPhone,
                        'response' => $responseData
                    ]);
                }
                
                return true;
            }

            // Error HTTP (4xx, 5xx)
            $responseBody = $response->json();
            $errorMessage = $responseBody['requestError']['serviceException']['text'] ?? $response->body();
            
            // Si la respuesta es un array, intentar extraer más información
            if (is_array($responseBody)) {
                $errorMessage = json_encode($responseBody, JSON_PRETTY_PRINT);
            }
            
            Log::error('❌ OTP WhatsApp: Error HTTP enviando código OTP', [
                'status' => $response->status(),
                'error' => $errorMessage,
                'response_body' => $responseBody,
                'to' => $formattedPhone,
                'payload' => json_encode($payload, JSON_PRETTY_PRINT)
            ]);

            // Detectar rate limiting (429)
            if ($response->status() === 429) {
                $retryAfter = $response->header('Retry-After', 60); // Default 60 segundos
                throw new \Exception("RATE_LIMIT_EXCEEDED: Demasiadas solicitudes. Intenta nuevamente en {$retryAfter} segundos.", 0);
            }

            // Detectar errores comunes
            if (stripos($errorMessage, 'template') !== false && stripos($errorMessage, 'not found') !== false) {
                throw new \Exception('TEMPLATE_NOT_FOUND', 0);
            }
            
            // Detectar error de parámetros de plantilla
            if (stripos($errorMessage, 'template parameters') !== false || 
                stripos($errorMessage, '7008') !== false) {
                throw new \Exception('TEMPLATE_PARAMETERS_MISMATCH', 0);
            }

            return false;
        } catch (\Exception $e) {
            // Re-lanzar excepciones específicas para que el controlador las maneje
            if (strpos($e->getMessage(), 'WHATSAPP_REJECTED') === 0 || 
                $e->getMessage() === 'TEMPLATE_NOT_FOUND' ||
                $e->getMessage() === 'TEMPLATE_PARAMETERS_MISMATCH' ||
                strpos($e->getMessage(), 'RATE_LIMIT_EXCEEDED') === 0) {
                throw $e;
            }
            
            Log::error('❌ OTP WhatsApp: Excepción enviando código OTP', [
                'error' => $e->getMessage(),
                'to' => $phone,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Enviar código de recuperación de contraseña
     * 
     * @param string $phone Número de teléfono del destinatario
     * @param string $code Código de 6 dígitos
     * @return bool
     */
    public function sendPasswordResetCode($phone, $code)
    {
        // El mensaje se envía a través de la plantilla de WhatsApp
        // La plantilla debe contener el texto apropiado
        return $this->sendOTP($phone, $code);
    }

    /**
     * Formatear número de teléfono al formato internacional
     * 
     * @param string $phone Número de teléfono
     * @return string Número formateado
     */
    protected function formatPhone($phone)
    {
        // Remover caracteres no numéricos
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Si el número tiene 10 dígitos y empieza con 3, asumir que es Colombia
        if (strlen($phone) == 10 && substr($phone, 0, 1) == '3') {
            $phone = '57' . $phone; // Agregar código de país de Colombia
        }
        
        // Si el número tiene 10 dígitos y no tiene código de país, agregar código de Colombia
        if (strlen($phone) == 10 && substr($phone, 0, 2) != '57') {
            $phone = '57' . $phone;
        }
        
        return $phone;
    }

    /**
     * Obtener estado de un mensaje enviado
     * 
     * @param string $messageId ID del mensaje
     * @return array|null
     */
    public function getMessageStatus($messageId)
    {
        if (!$this->isEnabled()) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'App ' . $this->apiKey,
                'Accept' => 'application/json'
            ])->get("{$this->baseUrl}/whatsapp/1/reports", [
                'messageId' => $messageId
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('OTP WhatsApp: Error obteniendo estado del mensaje', [
                'messageId' => $messageId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('OTP WhatsApp: Excepción obteniendo estado del mensaje', [
                'messageId' => $messageId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}

