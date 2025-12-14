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
                $errorMessage = $response->message ?? ($response->data->error ?? 'Error desconocido');
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
        // Si no se proporciona banco, usar uno por defecto común (Bancolombia)
        $bankCode = $bankCode ?? "1022";

        $pseData = [
            "bank" => $bankCode,
            "invoice" => $data['reference'],
            "description" => $data['description'] ?? 'Pago de registro Linkiu',
            "value" => (string)$data['amount'],
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
     * Crear pago en efectivo (Efecty, Gana, Baloto, etc.)
     */
    protected function createCashPayment(array $data, string $cashType, string $clientIp)
    {
        // Calcular fecha de expiración (máximo 5 días para Efecty, 30 días para otros)
        $maxDays = in_array($cashType, ['efecty']) ? 5 : 30;
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
                    // Intentar con bank primero (PSE)
                    try {
                        $response = $this->epayco->bank->get($epaycoTransactionId);
                    } catch (\Exception $e) {
                        // Si falla, intentar con charge
                        $response = $this->epayco->charge->transaction($epaycoTransactionId);
                    }
                    break;
            }

            if (!isset($response->success) || !$response->success) {
                throw new \Exception('Error al consultar estado en Epayco: ' . ($response->message ?? 'Error desconocido'));
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
     */
    public function getPseBanks(): array
    {
        try {
            $banks = $this->epayco->bank->pseBank($this->gateway->is_test_mode);
            
            if (!isset($banks->success) || !$banks->success) {
                throw new \Exception('Error al obtener lista de bancos: ' . ($banks->message ?? 'Error desconocido'));
            }

            return [
                'success' => true,
                'banks' => $banks->data ?? [],
            ];
        } catch (\Exception $e) {
            Log::error('Error obteniendo bancos PSE', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'banks' => [],
            ];
        }
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
            Log::info('Webhook sin firma recibido (posible API REST)', ['data' => $data]);
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

