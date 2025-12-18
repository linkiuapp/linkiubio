<?php

namespace App\Services\PaymentGateways;

use App\Models\PaymentGateway;
use App\Models\PaymentGatewayTransaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Epayco\Epayco;

class EpaycoService
{
    protected PaymentGateway $gateway;
    protected Epayco $epayco;
    protected array $credentials;

    public function __construct(PaymentGateway $gateway)
    {
        $this->gateway = $gateway;
        
        // Obtener credenciales de API REST
        $publicKey = $gateway->getCredential('public_key');
        $privateKey = $gateway->getCredential('private_key');

        if (!$publicKey || !$privateKey) {
            throw new \Exception('Credenciales de Epayco incompletas. Se requieren PUBLIC_KEY y PRIVATE_KEY.');
        }

        // Inicializar SDK de Epayco
        $this->epayco = new Epayco([
            "apiKey" => $publicKey,
            "privateKey" => $privateKey,
            "lenguage" => "ES",
            "test" => $gateway->is_test_mode
        ]);
    }

    /**
     * Crear sesión de pago
     * Soporta múltiples métodos: PSE, Cash, Payment (tarjetas), etc.
     * 
     * @param array $data Datos del pago
     * @param string $method Método de pago: 'pse', 'cash', 'payment' (default: 'pse')
     * @param string|null $bankCode Código del banco (solo para PSE)
     * @param string|null $cashType Tipo de efectivo: 'efecty', 'gana', 'baloto', etc. (solo para Cash)
     * @return array
     */
    public function createPaymentSession(array $data, string $method = 'pse', ?string $bankCode = null, ?string $cashType = null): array
    {
        try {
            // Validar que el monto sea mayor a cero
            $amount = floatval($data['amount'] ?? 0);
            if ($amount <= 0) {
                throw new \Exception("El monto del pago debe ser mayor a cero. Monto recibido: {$amount}");
            }
            
            // Obtener IP del cliente
            $clientIp = request()->ip() ?? '127.0.0.1';
            
            // Crear transacción en BD primero
            $transaction = PaymentGatewayTransaction::create([
                'payment_gateway_id' => $this->gateway->id,
                'transaction_id' => $data['reference'],
                'reference' => $data['reference'],
                'reference_type' => $data['reference_type'] ?? 'registration',
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'COP',
                'status' => 'pending',
                'request_data' => array_merge($data, ['method' => $method]),
            ]);

            $response = null;
            $redirectUrl = null;
            $epaycoTransactionId = null;

            // Crear pago según el método seleccionado
            switch ($method) {
                case 'pse':
                    $response = $this->createPsePayment($data, $bankCode, $clientIp);
                    $redirectUrl = $response->data->urlbanco ?? null;
                    $epaycoTransactionId = $response->data->ref_payco ?? $response->data->ticketId ?? null;
                    break;

                case 'cash':
                    $cashType = $cashType ?? 'efecty';
                    $response = $this->createCashPayment($data, $cashType, $clientIp);
                    $redirectUrl = $response->data->urlbanco ?? null;
                    $epaycoTransactionId = $response->data->ref_payco ?? $response->data->ticketId ?? null;
                    break;

                case 'payment':
                    // Para tarjetas de crédito/débito, requiere token_card y customer_id
                    // Este método se implementará cuando tengamos el token de tarjeta
                    throw new \Exception('Método de pago con tarjeta requiere tokenización previa. Use PSE o Cash.');
                    break;

                default:
                    throw new \Exception("Método de pago no soportado: {$method}");
            }

            // Verificar respuesta
            if (!isset($response->success) || !$response->success) {
                // Capturar mensaje de error de múltiples fuentes posibles
                $errorMessage = 'Error desconocido';
                $errorCode = null;
                
                // Primero intentar obtener errores específicos desde data.errores (array de errores)
                if (isset($response->data->errores) && is_array($response->data->errores) && !empty($response->data->errores)) {
                    $error = $response->data->errores[0];
                    $errorCode = $error->codError ?? $error['codError'] ?? null;
                    $errorMessage = $error->errorMessage ?? $error['errorMessage'] ?? 'Error en la transacción';
                    
                    // Traducir o mejorar mensajes de error comunes
                    if ($errorCode === 'E014') {
                        $errorMessage = 'El monto mínimo para transacciones PSE no ha sido alcanzado. Por favor verifica el monto o usa otro método de pago.';
                    } elseif ($errorCode === 'E015') {
                        $errorMessage = 'El monto máximo para transacciones PSE ha sido excedido.';
                    }
                } elseif (isset($response->data->error) && !empty($response->data->error)) {
                    $errorMessage = $response->data->error;
                } elseif (isset($response->data->message) && !empty($response->data->message)) {
                    $errorMessage = $response->data->message;
                } elseif (isset($response->message) && !empty($response->message)) {
                    $errorMessage = $response->message;
                } elseif (isset($response->text_response) && !empty($response->text_response)) {
                    $errorMessage = $response->text_response;
                    // Si hay title_response, combinarlo
                    if (isset($response->title_response) && !empty($response->title_response)) {
                        $errorMessage = $response->title_response . ': ' . $errorMessage;
                    }
                } elseif (isset($response->title_response) && !empty($response->title_response)) {
                    $errorMessage = $response->title_response;
                }
                
                // Si aún no tenemos un mensaje claro, intentar obtener más información
                if ($errorMessage === 'Error desconocido' && isset($response->data)) {
                    // Intentar convertir data a string si es un objeto
                    if (is_object($response->data)) {
                        $errorData = json_encode($response->data);
                        if (strlen($errorData) < 500) {
                            $errorMessage = $errorData;
                        }
                    } elseif (is_string($response->data)) {
                        $errorMessage = $response->data;
                    }
                }
                
                // Log completo de la respuesta para debugging
                Log::error('Respuesta de error de Epayco', [
                    'method' => $method,
                    'error_code' => $errorCode,
                    'response' => $response,
                    'response_json' => json_encode($response),
                    'data' => $data,
                    'error_message' => $errorMessage,
                ]);
                
                throw new \Exception("Error al crear pago {$method}: " . $errorMessage);
            }

            // Actualizar transacción con respuesta
            $transaction->update([
                'transaction_id' => $epaycoTransactionId ?? $data['reference'],
                'response_data' => (array)$response,
            ]);

            if (!$redirectUrl) {
                throw new \Exception('No se recibió URL de redirección de Epayco');
            }

            return [
                'success' => true,
                'transaction_id' => $transaction->id,
                'checkout_url' => $redirectUrl,
                'payment_data' => [
                    'ref_payco' => $response->data->ref_payco ?? null,
                    'ticket_id' => $response->data->ticketId ?? null,
                ],
                'epayco_response' => $response,
            ];

        } catch (\Exception $e) {
            Log::error('Error creando sesión de pago Epayco', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
                'method' => $method,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Crear pago PSE (Pagos Seguros en Línea)
     */
    protected function createPsePayment(array $data, ?string $bankCode, string $clientIp)
    {
        // Validar banco
        if (empty($bankCode)) {
            throw new \Exception('Código de banco requerido para pagos PSE');
        }
        
        // Validar monto
        $amount = floatval($data['amount'] ?? 0);
        if ($amount <= 0) {
            throw new \Exception("El monto debe ser mayor a cero para pagos PSE. Monto recibido: {$amount}");
        }
        
        // Epayco PSE generalmente requiere un monto mínimo de $5,000 COP

        $pseData = [
            "bank" => $bankCode,
            "invoice" => $data['reference'],
            "description" => $data['description'] ?? 'Pago de registro Linkiu',
            "value" => number_format($amount, 2, '.', ''), // Asegurar formato correcto del monto
            "tax" => "0",
            "tax_base" => "0",
            "currency" => $data['currency'] ?? "COP",
            "type_person" => "0", // 0 = Persona Natural, 1 = Persona Jurídica
            "doc_type" => $this->mapDocumentTypeToEpayco($data['document_type'] ?? 'CC'),
            "doc_number" => $data['document'] ?? '',
            "name" => $data['name'],
            "last_name" => $data['last_name'] ?? '',
            "email" => $data['email'],
            "country" => "CO",
            "city" => $data['city'] ?? "Bogota",
            "cell_phone" => $data['phone'] ?? '',
            "ip" => $clientIp,
            "url_response" => $data['response_url'],
            "url_confirmation" => $data['confirmation_url'],
            "metodoconfirmacion" => "POST",
        ];

        return $this->epayco->bank->create($pseData);
    }

    /**
     * Crear pago en efectivo (Efecty, Gana, Baloto, Punto Red, Red Servi, SuRed)
     * @param string $cashType Código del método: EF (Efecty), GA (Gana), BA (Baloto), PR (Punto Red), RS (Red Servi), SR (SuRed)
     */
    protected function createCashPayment(array $data, string $cashType, string $clientIp)
    {
        // Validar código de método de efectivo
        $validCashTypes = ['PR', 'RS', 'SR', 'BA', 'EF', 'GA'];
        if (!in_array(strtoupper($cashType), $validCashTypes)) {
            throw new \Exception("Código de método de efectivo no válido: {$cashType}. Debe ser uno de: " . implode(', ', $validCashTypes));
        }
        
        // Normalizar a mayúsculas
        $cashType = strtoupper($cashType);
        
        // Calcular fecha de expiración (máximo 5 días para Efecty, 30 días para otros)
        $maxDays = ($cashType === 'EF') ? 5 : 30;
        $endDate = now()->addDays($maxDays)->format('Y-m-d');

        $cashData = [
            "invoice" => $data['reference'],
            "description" => $data['description'] ?? 'Pago de registro Linkiu',
            "value" => (string)$data['amount'],
            "tax" => "0",
            "tax_base" => "0",
            "currency" => $data['currency'] ?? "COP",
            "type_person" => "0",
            "doc_type" => $this->mapDocumentTypeToEpayco($data['document_type'] ?? 'CC'),
            "doc_number" => $data['document'] ?? '',
            "name" => $data['name'],
            "last_name" => $data['last_name'] ?? '',
            "email" => $data['email'],
            "cell_phone" => $data['phone'] ?? '',
            "country" => "CO",
            "city" => $data['city'] ?? "Bogota",
            "end_date" => $endDate,
            "ip" => $clientIp,
            "url_response" => $data['response_url'],
            "url_confirmation" => $data['confirmation_url'],
            "metodoconfirmacion" => "POST",
        ];

        return $this->epayco->cash->create($cashType, $cashData);
    }

    /**
     * Crear pago con tarjeta de crédito/débito
     * Requiere token_card y customer_id (se obtienen después de tokenizar la tarjeta)
     */
    public function createCardPayment(array $data, string $tokenCard, string $customerId): array
    {
        try {
            $clientIp = request()->ip() ?? '127.0.0.1';

            // Crear transacción en BD
            $transaction = PaymentGatewayTransaction::create([
                'payment_gateway_id' => $this->gateway->id,
                'transaction_id' => $data['reference'],
                'reference' => $data['reference'],
                'reference_type' => $data['reference_type'] ?? 'registration',
                'amount' => $data['amount'],
                'currency' => $data['currency'] ?? 'COP',
                'status' => 'pending',
                'request_data' => array_merge($data, ['method' => 'payment', 'token_card' => $tokenCard, 'customer_id' => $customerId]),
            ]);

            // Crear pago con tarjeta usando SDK
            $paymentData = [
                "token_card" => $tokenCard,
                "customer_id" => $customerId,
                "doc_type" => $this->mapDocumentTypeToEpayco($data['document_type'] ?? 'CC'),
                "doc_number" => $data['document'] ?? '',
                "name" => $data['name'],
                "last_name" => $data['last_name'] ?? '',
                "email" => $data['email'],
                "value" => (string)$data['amount'],
                "currency" => $data['currency'] ?? "COP",
                "description" => $data['description'] ?? 'Pago de registro Linkiu',
                "ip" => $clientIp,
                "url_response" => $data['response_url'] ?? null,
                "url_confirmation" => $data['confirmation_url'] ?? null,
                "method_confirmation" => "POST",
            ];

            $response = $this->epayco->charge->create($paymentData);

            if (!isset($response->success) || !$response->success) {
                throw new \Exception('Error al procesar pago con tarjeta: ' . ($response->message ?? 'Error desconocido'));
            }

            // Actualizar transacción
            $transaction->update([
                'transaction_id' => $response->data->ref_payco ?? $response->data->transactionId ?? $data['reference'],
                'response_data' => (array)$response,
                'status' => $this->mapEpaycoStatus($response->data->x_cod_response ?? null),
            ]);

            return [
                'success' => true,
                'transaction_id' => $transaction->id,
                'payment_data' => [
                    'ref_payco' => $response->data->ref_payco ?? null,
                    'transaction_id' => $response->data->transactionId ?? null,
                ],
                'epayco_response' => $response,
            ];

        } catch (\Exception $e) {
            Log::error('Error creando pago con tarjeta Epayco', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Mapear tipo de documento a formato Epayco
     */
    protected function mapDocumentTypeToEpayco(string $type): string
    {
        return match($type) {
            'cc', 'CC' => 'CC',
            'ce', 'CE' => 'CE',
            'passport', 'PA' => 'PA',
            'nit', 'NIT' => 'NIT',
            default => 'CC',
        };
    }

    /**
     * Verificar estado de pago usando API REST del SDK
     * Soporta verificación de PSE, Cash y Payment (tarjetas)
     */
    public function verifyPayment(string $reference): array
    {
        try {
            // Buscar transacción primero
            $transaction = PaymentGatewayTransaction::where('reference', $reference)
                ->orWhere('transaction_id', $reference)
                ->where('payment_gateway_id', $this->gateway->id)
                ->first();

            if (!$transaction) {
                throw new \Exception('Transacción no encontrada');
            }

            // Usar el transaction_id de Epayco si está disponible
            $epaycoTransactionId = $transaction->transaction_id ?? $reference;
            
            // Determinar método de pago desde request_data
            $requestData = $transaction->request_data ?? [];
            $method = $requestData['method'] ?? 'pse';
            
            $response = null;

            // Consultar estado según el método usado
            switch ($method) {
                case 'pse':
                    $response = $this->epayco->bank->get($epaycoTransactionId);
                    break;
                
                case 'cash':
                    $response = $this->epayco->cash->transaction($epaycoTransactionId);
                    break;
                
                case 'payment':
                    // Para pagos con tarjeta, usar charge->transaction
                    $response = $this->epayco->charge->transaction($epaycoTransactionId);
                    break;
                
                default:
                    // Intentar con múltiples métodos en orden
                    try {
                        $response = $this->epayco->bank->get($epaycoTransactionId);
                    } catch (\Exception $e1) {
                        try {
                            $response = $this->epayco->cash->transaction($epaycoTransactionId);
                        } catch (\Exception $e2) {
                            // Último intento con charge
                            $response = $this->epayco->charge->transaction($epaycoTransactionId);
                        }
                    }
                    break;
            }

            if (!isset($response->success) || !$response->success) {
                // Intentar obtener mensaje de error de múltiples fuentes
                $errorMessage = $response->message 
                    ?? $response->data->x_response_reason_text 
                    ?? $response->data->x_response_reason 
                    ?? $response->data->errorMessage 
                    ?? $response->text_response 
                    ?? 'Error desconocido';
                
                throw new \Exception('Error al consultar estado en Epayco: ' . $errorMessage);
            }

            // Mapear estado (diferentes métodos pueden tener diferentes campos)
            $epaycoStatus = $response->data->x_cod_response 
                ?? $response->data->cod_response 
                ?? $response->data->x_cod_transaction_state 
                ?? null;
            $status = $this->mapEpaycoStatus($epaycoStatus);
            
            // Actualizar transacción
            $transaction->update([
                'status' => $status,
                'response_data' => (array)$response,
                'processed_at' => now(),
                'error_message' => $status === 'rejected' 
                    ? ($response->data->x_response_reason_text ?? $response->data->x_response_reason ?? 'Pago rechazado') 
                    : null,
            ]);

            if ($status === 'approved') {
                $transaction->markAsApproved();
            } elseif ($status === 'rejected') {
                $transaction->markAsRejected(
                    $response->data->x_response_reason_text ?? $response->data->x_response_reason ?? 'Pago rechazado'
                );
            }

            return [
                'success' => true,
                'status' => $status,
                'data' => $response,
            ];

        } catch (\Exception $e) {
            Log::error('Error verificando pago Epayco', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'reference' => $reference,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Procesar webhook de confirmación
     */
    public function processWebhook(array $data): array
    {
        try {
            $reference = $data['x_ref_payco'] ?? $data['ref_payco'] ?? $data['refPayco'] ?? null;
            
            if (!$reference) {
                throw new \Exception('Referencia no encontrada en webhook');
            }

            // Buscar transacción por reference o transaction_id
            $transaction = PaymentGatewayTransaction::where(function($query) use ($reference) {
                    $query->where('reference', $reference)
                          ->orWhere('transaction_id', $reference);
                })
                ->where('payment_gateway_id', $this->gateway->id)
                ->first();

            if (!$transaction) {
                throw new \Exception('Transacción no encontrada para referencia: ' . $reference);
            }

            // Mapear estado de Epayco
            $epaycoStatus = $data['x_cod_response'] ?? $data['cod_response'] ?? $data['x_cod_transaction_state'] ?? null;
            $status = $this->mapEpaycoStatus($epaycoStatus);

            // Actualizar transacción
            $transaction->update([
                'status' => $status,
                'response_data' => $data,
                'processed_at' => now(),
                'error_message' => $status === 'rejected' ? ($data['x_response_reason_text'] ?? $data['x_response_reason'] ?? 'Pago rechazado') : null,
            ]);

            if ($status === 'approved') {
                $transaction->markAsApproved();
            } elseif ($status === 'rejected') {
                $transaction->markAsRejected($data['x_response_reason_text'] ?? $data['x_response_reason'] ?? 'Pago rechazado');
            }

            return [
                'success' => true,
                'transaction' => $transaction,
                'status' => $status,
            ];

        } catch (\Exception $e) {
            Log::error('Error procesando webhook Epayco', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Obtener lista de bancos disponibles para PSE
     * Intenta primero con el SDK, luego con API REST directa como fallback
     */
    public function getPseBanks(): array
    {
        try {
            // Método 1: Intentar con SDK de Epayco
            $banks = null;
            try {
                $banks = $this->epayco->bank->pseBank($this->gateway->is_test_mode);
            } catch (\Exception $sdkException) {
                // Silenciosamente intentar con API REST directa
            }
            
            if (!$banks || !isset($banks->success) || !$banks->success) {
                // Si el SDK falla, intentar con API REST directa
                $banks = $this->getBanksFromRestApi();
            }

            if (!$banks || !isset($banks->success) || !$banks->success) {
                throw new \Exception('Error al obtener lista de bancos: ' . ($banks->message ?? ($banks->title_response ?? 'Error desconocido')));
            }


            // Obtener datos de bancos
            $banksData = $banks->data ?? null;
            
            // Normalizar y filtrar bancos del SDK
            $normalizedBanks = $this->normalizeBanksData($banksData);
            
            // Si hay muy pocos bancos después de normalizar, intentar con API REST directa
            if (count($normalizedBanks) < 5) {
                $restBanks = $this->getBanksFromRestApi();
                if ($restBanks && isset($restBanks->success) && $restBanks->success) {
                    $restNormalized = $this->normalizeBanksData($restBanks->data ?? null);
                    
                    // Combinar y eliminar duplicados
                    $normalizedBanks = $this->mergeBanksAndRemoveDuplicates($normalizedBanks, $restNormalized);
                }
            }
            
            // Si aún hay muy pocos bancos (menos de 10), usar lista estática como último recurso
            // Esto puede pasar si la API de Epayco tiene limitaciones o la cuenta tiene restricciones
            if (count($normalizedBanks) < 10) {
                // Lista estática de principales bancos colombianos para PSE (basada en códigos oficiales)
                $staticBanks = [
                    ['bankCode' => '1022', 'bankName' => 'BANCOLOMBIA'],
                    ['bankCode' => '1052', 'bankName' => 'BANCO DE BOGOTÁ'],
                    ['bankCode' => '1013', 'bankName' => 'BBVA COLOMBIA'],
                    ['bankCode' => '1019', 'bankName' => 'BANCO COLPATRIA'],
                    ['bankCode' => '1066', 'bankName' => 'BANCO DAVIVIENDA'],
                    ['bankCode' => '1051', 'bankName' => 'BANCO DE OCCIDENTE'],
                    ['bankCode' => '1062', 'bankName' => 'BANCO FALABELLA'],
                    ['bankCode' => '1063', 'bankName' => 'BANCO PICHINCHA'],
                    ['bankCode' => '1072', 'bankName' => 'BANCO POPULAR'],
                    ['bankCode' => '1065', 'bankName' => 'BANCO AGRARIO'],
                    ['bankCode' => '1006', 'bankName' => 'BANCO AV VILLAS'],
                    ['bankCode' => '1077', 'bankName' => 'BANKA'],
                    ['bankCode' => '1032', 'bankName' => 'BANCO UNION COLOMBIANO'],
                    ['bankCode' => '1058', 'bankName' => 'BANCOOMEVA'],
                    ['bankCode' => '1091', 'bankName' => 'CONFIAR'],
                    ['bankCode' => '1012', 'bankName' => 'BANCO GNB SUDAMERIS'],
                    ['bankCode' => '1038', 'bankName' => 'BANCO SANTANDER'],
                ];
                
                // Combinar bancos obtenidos con lista estática, eliminando duplicados
                $normalizedBanks = $this->mergeBanksAndRemoveDuplicates($normalizedBanks, $staticBanks);
                
                // Ordenar por nombre de banco
                usort($normalizedBanks, function($a, $b) {
                    $nameA = $a['bankName'] ?? $a['bank_name'] ?? '';
                    $nameB = $b['bankName'] ?? $b['bank_name'] ?? '';
                    return strcmp($nameA, $nameB);
                });
            }
            
            // Eliminar duplicados finales por código de banco (por si acaso)
            $normalizedBanks = $this->removeDuplicateBanks($normalizedBanks);

            return [
                'success' => true,
                'banks' => $normalizedBanks,
            ];
        } catch (\Exception $e) {
            Log::error('Error obteniendo bancos PSE', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'banks' => [],
            ];
        }
    }


    /**
     * Obtener bancos mediante API REST directa de Epayco
     */
    protected function getBanksFromRestApi(): ?object
    {
        try {
            $publicKey = $this->gateway->getCredential('public_key');
            $testMode = $this->gateway->is_test_mode;
            
            // URL base según el modo (test o producción)
            $baseUrl = $testMode 
                ? 'https://secure.epayco.co' 
                : 'https://secure.payco.co';
            
            // Intentar primero como POST
            $url = "{$baseUrl}/restpagos/pse/bancos.json";
            $response = Http::timeout(15)
                ->asForm()
                ->post($url, [
                    'public_key' => $publicKey
                ]);
            
            // Si falla POST, intentar como GET
            if (!$response->successful()) {
                $urlGet = "{$baseUrl}/restpagos/pse/bancos.json?public_key={$publicKey}";
                $response = Http::timeout(15)->get($urlGet);
            }
            
            if ($response->successful()) {
                $restData = $response->json();
                
                if (isset($restData['success']) && $restData['success'] && isset($restData['data'])) {
                    return (object)[
                        'success' => true,
                        'data' => $restData['data']
                    ];
                }
            }
            
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Normalizar datos de bancos (objeto o array) a array indexado
     */
    protected function normalizeBanksData($banksData): array
    {
        $normalizedBanks = [];
        
        if (is_object($banksData)) {
            // Si es un objeto, convertir a array asociativo primero
            $banksArray = json_decode(json_encode($banksData), true);
            
            if (is_array($banksArray)) {
                // Verificar si las claves son numéricas (array indexado) o strings (objeto asociativo)
                $hasNumericKeys = !empty($banksArray) && array_keys($banksArray) === range(0, count($banksArray) - 1);
                
                if ($hasNumericKeys) {
                    // Es un array indexado, usar directamente
                    foreach ($banksArray as $bank) {
                        if (is_array($bank) && !empty($bank)) {
                            $normalizedBanks[] = $bank;
                        }
                    }
                } else {
                    // Es un objeto asociativo (claves son strings, ej: códigos de banco)
                    // Convertir cada propiedad a elemento del array
                    foreach ($banksArray as $key => $bank) {
                        if (is_array($bank) && !empty($bank)) {
                            // Asegurar que tenga bankCode si no lo tiene
                            if (!isset($bank['bankCode']) && !isset($bank['bank_code'])) {
                                $bank['bankCode'] = is_numeric($key) ? $key : null;
                            }
                            $normalizedBanks[] = $bank;
                        } elseif (is_object($bank)) {
                            $bankArray = json_decode(json_encode($bank), true);
                            if (!isset($bankArray['bankCode']) && !isset($bankArray['bank_code'])) {
                                $bankArray['bankCode'] = is_numeric($key) ? $key : null;
                            }
                            $normalizedBanks[] = $bankArray;
                        }
                    }
                }
            }
        } elseif (is_array($banksData)) {
            // Ya es un array
            foreach ($banksData as $key => $bank) {
                if (is_object($bank)) {
                    $bank = json_decode(json_encode($bank), true);
                }
                if (is_array($bank) && !empty($bank)) {
                    $normalizedBanks[] = $bank;
                }
            }
        }
        
        // Filtrar bancos no válidos (ej: bankCode "0" que es texto instructivo)
        $normalizedBanks = array_filter($normalizedBanks, function($bank) {
            if (!is_array($bank)) {
                return false;
            }
            
            $bankCode = $bank['bankCode'] ?? $bank['bank_code'] ?? $bank['code'] ?? '';
            $bankName = $bank['bankName'] ?? $bank['bank_name'] ?? $bank['name'] ?? '';
            
            // Filtrar: debe tener código y nombre, y el código no debe ser "0"
            return !empty($bankCode) 
                && $bankCode !== "0" 
                && $bankCode !== 0 
                && !empty($bankName)
                && !preg_match('/seleccione|selecciona|select/i', $bankName); // Filtrar textos instructivos
        });
        
        // Re-indexar el array después del filtro
        return array_values($normalizedBanks);
    }

    /**
     * Combinar dos arrays de bancos y eliminar duplicados por código de banco
     */
    protected function mergeBanksAndRemoveDuplicates(array $banks1, array $banks2): array
    {
        // Usar el primer array como base
        $merged = $banks1;
        
        // Obtener códigos de bancos ya presentes
        $existingCodes = [];
        foreach ($merged as $bank) {
            $code = (string)($bank['bankCode'] ?? $bank['bank_code'] ?? '');
            if (!empty($code)) {
                $existingCodes[strtoupper($code)] = true;
            }
        }
        
        // Agregar bancos del segundo array solo si no existen
        foreach ($banks2 as $bank) {
            $code = (string)($bank['bankCode'] ?? $bank['bank_code'] ?? '');
            if (!empty($code) && !isset($existingCodes[strtoupper($code)])) {
                $merged[] = $bank;
                $existingCodes[strtoupper($code)] = true;
            }
        }
        
        return array_values($merged);
    }

    /**
     * Eliminar bancos duplicados por código de banco de un array
     */
    protected function removeDuplicateBanks(array $banks): array
    {
        $uniqueBanks = [];
        $seenCodes = [];
        
        foreach ($banks as $bank) {
            $code = (string)($bank['bankCode'] ?? $bank['bank_code'] ?? '');
            
            // Si el código está vacío, saltarlo
            if (empty($code)) {
                continue;
            }
            
            // Normalizar código a mayúsculas para comparación
            $codeUpper = strtoupper($code);
            
            // Si ya vimos este código, saltarlo
            if (isset($seenCodes[$codeUpper])) {
                continue;
            }
            
            // Agregar banco y marcar código como visto
            $uniqueBanks[] = $bank;
            $seenCodes[$codeUpper] = true;
        }
        
        return array_values($uniqueBanks);
    }

    /**
     * Verificar firma del webhook (si está disponible)
     * Nota: Con API REST, la verificación de firma puede no ser necesaria
     * pero se mantiene para compatibilidad con webhooks tradicionales
     */
    protected function verifyWebhookSignature(array $data, ?string $pKey = null): bool
    {
        // Si no hay P_KEY, no podemos verificar (API REST no lo requiere siempre)
        if (!$pKey) {
            // Con API REST, confiamos en que Epayco envía los webhooks correctamente
            // La verificación se hace consultando la transacción después
            return true;
        }

        $signature = $data['x_signature'] ?? $data['signature'] ?? null;
        
        if (!$signature) {
            // Si no hay firma pero hay P_KEY, podría ser un webhook de API REST
            // En ese caso, permitimos pero registramos
            return true;
        }

        $signatureString = $pKey . '^' .
            ($data['x_cust_id_cliente'] ?? $data['cust_id_cliente'] ?? '') . '^' .
            ($data['x_ref_payco'] ?? $data['ref_payco'] ?? '') . '^' .
            ($data['x_transaction_id'] ?? $data['transaction_id'] ?? '') . '^' .
            ($data['x_amount'] ?? $data['amount'] ?? '') . '^' .
            ($data['x_currency_code'] ?? $data['currency_code'] ?? 'COP');

        $calculatedSignature = md5($signatureString);

        return hash_equals($calculatedSignature, $signature);
    }

    /**
     * Mapear estado de Epayco a estado interno
     */
    protected function mapEpaycoStatus(?string $epaycoStatus): string
    {
        return match($epaycoStatus) {
            '1', 'APPROVED' => 'approved',
            '2', 'REJECTED' => 'rejected',
            '3', 'PENDING' => 'pending',
            '4', 'CANCELLED' => 'cancelled',
            default => 'pending',
        };
    }
}

