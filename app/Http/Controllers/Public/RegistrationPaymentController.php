<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayTransaction;
use App\Models\PendingRegistration;
use App\Services\PaymentGateways\EpaycoService;
use App\Services\BillingService;
use App\Shared\Models\Store;
use App\Shared\Models\User;
use App\Shared\Models\BusinessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationPaymentController extends Controller
{
    /**
     * Iniciar pago con Epayco
     */
    public function initiatePayment(Request $request)
    {
        // Validar que tenemos los datos del wizard en sesión
        $planId = Session::get('wizard.plan_id');
        $billingPeriod = Session::get('wizard.billing_period');
        $ownerEmail = $request->input('owner_email');
        $ownerName = $request->input('owner_name');
        $ownerDocument = $request->input('owner_document_number');
        $ownerDocumentType = $request->input('owner_document_type');

        if (!$planId || !$billingPeriod || !$ownerEmail || !$ownerName) {
            return back()->withErrors(['error' => 'Datos incompletos. Por favor completa todos los pasos del registro.']);
        }

        // Obtener plan y calcular monto
        $plan = \App\Shared\Models\Plan::find($planId);
        if (!$plan) {
            return back()->withErrors(['error' => 'Plan no encontrado.']);
        }

        $prices = $plan->prices ?? [];
        $amount = match($billingPeriod) {
            'monthly' => $plan->price,
            'quarterly' => $prices['quarterly'] ?? ($plan->price * 3),
            'semester' => $prices['semester'] ?? ($plan->price * 6),
            'annual' => $prices['annual'] ?? ($plan->price * 12),
            default => $plan->price
        };

        // Validar que el monto sea mayor a cero para pagos con Epayco
        if ($amount <= 0) {
            Log::warning('Intento de pago con monto cero o negativo', [
                'plan_id' => $planId,
                'plan_name' => $plan->name,
                'amount' => $amount,
                'billing_period' => $billingPeriod,
            ]);
            return back()->withErrors(['error' => 'Los planes gratuitos no requieren pago. Por favor completa el registro sin pasarela de pago.']);
        }

        // Obtener gateway de Epayco
        $epaycoGateway = PaymentGateway::where('name', 'epayco')
            ->where('is_active', true)
            ->first();

        if (!$epaycoGateway) {
            return back()->withErrors(['error' => 'Pasarela de pagos no disponible. Por favor usa transferencia bancaria.']);
        }

        // Generar referencia única
        $reference = 'REG-' . time() . '-' . uniqid();

        // Obtener método de pago Epayco seleccionado
        $epaycoMethod = $request->input('epayco_method', 'pse');
        
        // Validar método
        $validMethods = ['pse', 'cash'];
        if (!in_array($epaycoMethod, $validMethods)) {
            return back()->withErrors(['error' => 'Método de pago no válido.']);
        }

        // Crear servicio Epayco
        $epaycoService = new EpaycoService($epaycoGateway);

        // Preparar datos del pago
        $paymentData = [
            'reference' => $reference,
            'amount' => $amount,
            'currency' => 'COP',
            'description' => "Registro Linkiu - Plan {$plan->name} ({$billingPeriod})",
            'email' => $ownerEmail,
            'name' => $ownerName,
            'last_name' => '',
            'document' => $ownerDocument,
            'document_type' => $this->mapDocumentType($ownerDocumentType),
            'phone' => Session::get('wizard.phone', ''),
            'city' => Session::get('wizard.city', 'Bogota'),
            'reference_type' => 'registration',
            'response_url' => route('register.payment.response'),
            'confirmation_url' => route('register.payment.webhook'),
        ];

        // Determinar método y parámetros según selección
        $method = 'pse';
        $bankCode = null;
        $cashType = null;

        if ($epaycoMethod === 'pse') {
            $method = 'pse';
            // Obtener código de banco del formulario
            $bankCode = $request->input('pse_bank_code');
            if (!$bankCode) {
                return back()->withErrors(['pse_bank_code' => 'Por favor selecciona el banco desde el cual realizarás el pago PSE.']);
            }
            
            // Si es Nequi (1507) o Daviplata (1551), validar número de teléfono de billetera
            if (in_array($bankCode, ['1507', '1551'])) {
                $walletPhone = $request->input('wallet_phone');
                if (!$walletPhone) {
                    $walletName = $bankCode === '1507' ? 'Nequi' : 'Daviplata';
                    return back()->withErrors(['wallet_phone' => "Por favor ingresa el número de teléfono asociado a tu cuenta {$walletName}."]);
                }
                // Validar formato (10 dígitos)
                if (!preg_match('/^[0-9]{10}$/', $walletPhone)) {
                    return back()->withErrors(['wallet_phone' => 'El número de teléfono debe tener 10 dígitos.']);
                }
                // Usar el número de la billetera en lugar del del Step 2
                $paymentData['phone'] = $walletPhone;
            }
        } elseif ($epaycoMethod === 'cash') {
            $method = 'cash';
            // Obtener tipo de efectivo del select
            $cashType = $request->input('cash_type');
            if (!$cashType) {
                return back()->withErrors(['cash_type' => 'Por favor selecciona el método de pago en efectivo (Punto Red, Red Servi, Efecty, etc.).']);
            }
            // Validar que el código sea válido
            $validCashTypes = ['PR', 'RS', 'SR', 'BA', 'EF', 'GA'];
            if (!in_array($cashType, $validCashTypes)) {
                return back()->withErrors(['cash_type' => 'Método de pago en efectivo no válido.']);
            }
        }

        // Crear sesión de pago con el método seleccionado
        $result = $epaycoService->createPaymentSession($paymentData, $method, $bankCode, $cashType);

        if (!$result['success']) {
            Log::error('Error creando sesión de pago Epayco', [
                'error' => $result['error'] ?? 'Error desconocido',
                'data' => $paymentData
            ]);

            return back()->withErrors(['error' => 'Error al iniciar el pago. Por favor intenta de nuevo o usa transferencia bancaria.']);
        }

        // Guardar referencia en sesión para después
        Session::put('payment.reference', $reference);
        Session::put('payment.plan_id', $planId);
        Session::put('payment.billing_period', $billingPeriod);
        Session::put('payment.owner_data', [
            'email' => $ownerEmail,
            'name' => $ownerName,
            'document' => $ownerDocument,
            'document_type' => $ownerDocumentType,
            'password' => $request->input('password'), // Guardar contraseña para crear usuario después
        ]);

        // Redirigir directamente a Epayco (PSE devuelve URL de redirección)
        return redirect($result['checkout_url']);
    }

    /**
     * Respuesta de pago (cuando el usuario regresa de Epayco)
     */
    public function paymentResponse(Request $request)
    {
        // Epayco puede enviar diferentes campos según el método de pago
        $refPayco = $request->input('ref_payco') ?? $request->input('x_ref_payco') ?? $request->input('refPayco');
        $reference = $refPayco ?? Session::get('payment.reference');

        if (!$reference) {
            return redirect()->route('register.step4')
                ->withErrors(['error' => 'No se pudo verificar el pago. Por favor contacta soporte.']);
        }

        // Buscar transacción por reference o transaction_id
        $transaction = PaymentGatewayTransaction::where(function($query) use ($reference) {
                $query->where('reference', $reference)
                      ->orWhere('transaction_id', $reference);
            })
            ->first();

        if (!$transaction) {
            Log::warning('Transacción no encontrada en paymentResponse', [
                'reference' => $reference,
                'request_data' => $request->all()
            ]);
            return redirect()->route('register.step4')
                ->withErrors(['error' => 'Transacción no encontrada. Por favor contacta soporte.']);
        }

        // Verificar estado del pago
        $epaycoGateway = PaymentGateway::find($transaction->payment_gateway_id);
        if (!$epaycoGateway) {
            return redirect()->route('register.step4')
                ->withErrors(['error' => 'Error al verificar el pago.']);
        }

        // Actualizar transacción con datos de respuesta si vienen
        if ($request->has('x_cod_response') || $request->has('cod_response')) {
            $epaycoStatus = $request->input('x_cod_response') ?? $request->input('cod_response');
            $status = $this->mapEpaycoStatus($epaycoStatus);
            
            $transaction->update([
                'status' => $status,
                'response_data' => array_merge($transaction->response_data ?? [], $request->all()),
                'processed_at' => now(),
            ]);
        } else {
            // Si no viene el estado, consultar usando el SDK
            try {
                $epaycoService = new EpaycoService($epaycoGateway);
                $verification = $epaycoService->verifyPayment($reference);
                
                // Recargar transacción actualizada
                $transaction->refresh();
            } catch (\Exception $e) {
                Log::error('Error verificando pago en paymentResponse', [
                    'error' => $e->getMessage(),
                    'reference' => $reference
                ]);
            }
        }

        // Si el pago fue aprobado, crear tienda inmediatamente
        if ($transaction->isApproved()) {
            return $this->createStoreFromEpaycoPayment($transaction);
        }

        // Si está pendiente, crear registro pendiente y mostrar mensaje
        if ($transaction->isPending()) {
            $registration = $this->createRegistrationFromPayment($transaction, false);
            return redirect()->route('register.step5', $registration->id)
                ->with('info', 'Tu pago está siendo procesado. Te notificaremos cuando sea confirmado.');
        }

        // Si fue rechazado, redirigir a página de rechazo
        // Primero crear un registro rechazado para mostrar en la vista
        try {
            $registration = $this->createRejectedRegistration($transaction);
            return redirect()->route('register.rejected', $registration->id);
        } catch (\Exception $e) {
            Log::error('Error creando registro rechazado', [
                'error' => $e->getMessage(),
                'transaction_id' => $transaction->id
            ]);
            return redirect()->route('register.step4')
                ->withErrors(['error' => 'El pago fue rechazado. Por favor intenta de nuevo o usa transferencia bancaria.']);
        }
    }

    /**
     * Mapear estado de Epayco
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

    /**
     * Webhook de confirmación de Epayco
     */
    public function webhook(Request $request)
    {
        try {
            $epaycoGateway = PaymentGateway::where('name', 'epayco')
                ->where('is_active', true)
                ->first();

            if (!$epaycoGateway) {
                Log::warning('Webhook Epayco recibido pero gateway no está activo');
                return response()->json(['error' => 'Gateway no activo'], 400);
            }

            $epaycoService = new EpaycoService($epaycoGateway);
            $result = $epaycoService->processWebhook($request->all());

            if (!$result['success']) {
                Log::error('Error procesando webhook Epayco', [
                    'error' => $result['error'],
                    'data' => $request->all()
                ]);
                return response()->json(['error' => $result['error']], 400);
            }

            $transaction = $result['transaction'];

            // Si el pago fue aprobado, crear tienda inmediatamente (desde webhook)
            if ($transaction->isApproved()) {
                try {
                    $this->createStoreFromEpaycoPayment($transaction);
                } catch (\Exception $e) {
                    Log::error('Error creando tienda desde webhook Epayco', [
                        'transaction_id' => $transaction->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Excepción procesando webhook Epayco', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Error procesando webhook'], 500);
        }
    }

    /**
     * Crear tienda inmediatamente desde pago Epayco aprobado
     */
    protected function createStoreFromEpaycoPayment(PaymentGatewayTransaction $transaction)
    {
        // Verificar que no exista ya un registro para esta transacción
        $existingRegistration = PendingRegistration::where('payment_transaction_id', $transaction->id)->first();
        if ($existingRegistration) {
            // Si ya existe y está aprobado, redirigir a success
            if ($existingRegistration->status === 'approved' && $existingRegistration->created_store_id) {
                return redirect()->route('register.success', $existingRegistration->id);
            }
            // Si existe pero no está aprobado, redirigir a step5
            return redirect()->route('register.step5', $existingRegistration->id);
        }

        // Obtener datos de la sesión
        $planId = Session::get('payment.plan_id') ?? Session::get('wizard.plan_id');
        $billingPeriod = Session::get('payment.billing_period') ?? Session::get('wizard.billing_period');
        $ownerData = Session::get('payment.owner_data', []);

        if (!$planId || !$billingPeriod || empty($ownerData) || !isset($ownerData['password'])) {
            Log::error('Datos incompletos para crear tienda desde pago Epayco', [
                'transaction_id' => $transaction->id,
                'session_data' => Session::all()
            ]);
            return redirect()->route('register.step4')
                ->withErrors(['error' => 'Datos incompletos. Por favor contacta soporte.']);
        }

        try {
            DB::beginTransaction();

            // Verificar si el slug ya existe y generar uno único
            $slug = Session::get('wizard.slug');
            $counter = 1;
            while (Store::where('slug', $slug)->exists()) {
                $slug = Session::get('wizard.slug') . '-' . $counter;
                $counter++;
            }

            // Verificar si la categoría requiere aprobación manual
            $category = BusinessCategory::find(Session::get('wizard.business_category_id'));
            
            // 1. Crear tienda
            $store = Store::create([
                'name' => Session::get('wizard.store_name'),
                'slug' => $slug,
                'plan_id' => $planId,
                'business_category_id' => Session::get('wizard.business_category_id'),
                'email' => Session::get('wizard.email'),
                'phone' => Session::get('wizard.phone'),
                'city' => Session::get('wizard.city'),
                'department' => Session::get('wizard.department'),
                'country' => 'Colombia',
                'address' => Session::get('wizard.address'),
                'description' => Session::get('wizard.store_description'),
                'document_type' => Session::get('wizard.document_type'),
                'document_number' => Session::get('wizard.document_number'),
                'meta_title' => Session::get('wizard.meta_title'),
                'meta_description' => Session::get('wizard.meta_description'),
                'meta_keywords' => Session::get('wizard.meta_keywords'),
                'status' => 'active',
                'approval_status' => $category && !$category->requires_manual_approval ? 'approved' : 'pending_approval',
                'approved_at' => $category && !$category->requires_manual_approval ? now() : null,
                'approved_by' => $category && !$category->requires_manual_approval ? null : null, // Auto-aprobado, no hay admin
                'created_by' => null, // Registro público
            ]);

            // 2. Verificar si el email del usuario ya existe
            if (User::where('email', $ownerData['email'])->exists()) {
                throw new \Exception('El correo electrónico ya está registrado en el sistema.');
            }

            // 3. Crear usuario administrador asociado a la tienda
            $user = User::create([
                'name' => $ownerData['name'],
                'email' => $ownerData['email'],
                'password' => Hash::make($ownerData['password']),
                'role' => 'store_admin',
                'store_id' => $store->id,
            ]);

            // 4. Crear suscripción y factura usando BillingService (centralizado)
            // IMPORTANTE: paymentStatus = 'paid' porque el pago ya fue aprobado por Epayco
            $billingService = app(BillingService::class);
            $billing = $billingService->createInitialBilling(
                store: $store,
                billingCycle: $billingPeriod,
                hasTrialPeriod: null, // null = usar trial_days del plan automáticamente
                trialDays: null,      // null = usar trial_days del plan automáticamente
                paymentStatus: 'paid', // ✅ Pago aprobado por Epayco, factura marcada como pagada
                createdBy: null, // Registro público
                metadata: [
                    'registration_source' => 'epayco_payment',
                    'payment_transaction_id' => $transaction->id,
                    'payment_method' => 'epayco',
                    'source' => 'public_registration_wizard'
                ]
            );

            // 5. Crear PendingRegistration con status 'approved' para trazabilidad
            $registration = PendingRegistration::create([
                // Step 1
                'plan_id' => $planId,
                'billing_period' => $billingPeriod,
                
                // Step 2
                'business_category_id' => Session::get('wizard.business_category_id'),
                'business_name' => Session::get('wizard.business_name'),
                'document_type' => Session::get('wizard.document_type'),
                'document_number' => Session::get('wizard.document_number'),
                'phone' => Session::get('wizard.phone'),
                'email' => Session::get('wizard.email'),
                'city' => Session::get('wizard.city'),
                'department' => Session::get('wizard.department'),
                'address' => Session::get('wizard.address'),
                'description' => Session::get('wizard.description'),
                
                // Step 3
                'store_name' => Session::get('wizard.store_name'),
                'slug' => $slug,
                'store_description' => Session::get('wizard.store_description'),
                'meta_title' => Session::get('wizard.meta_title'),
                'meta_description' => Session::get('wizard.meta_description'),
                'meta_keywords' => Session::get('wizard.meta_keywords'),
                
                // Step 4
                'owner_name' => $ownerData['name'],
                'owner_email' => $ownerData['email'],
                'owner_document_type' => $ownerData['document_type'] ?? 'cc',
                'owner_document_number' => $ownerData['document'],
                'hashed_password' => Hash::make($ownerData['password']),
                'temp_password_encrypted' => encrypt($ownerData['password']), // Para mostrarla en success
                
                // Pago
                'payment_method' => 'epayco',
                'payment_transaction_id' => $transaction->id,
                'payment_proof' => null,
                
                // Estado - APROBADO porque el pago fue aprobado
                'status' => 'approved',
                'processed_at' => now(),
                'created_store_id' => $store->id,
            ]);

            DB::commit();

            // Limpiar sesión
            Session::forget('payment.reference');
            Session::forget('payment.plan_id');
            Session::forget('payment.billing_period');
            Session::forget('payment.owner_data');
            Session::forget('wizard.plan_id');
            Session::forget('wizard.billing_period');
            Session::forget('wizard.business_category_id');
            Session::forget('wizard.store_name');
            Session::forget('wizard.slug');
            Session::forget('wizard.store_description');
            Session::forget('wizard.meta_title');
            Session::forget('wizard.meta_description');
            Session::forget('wizard.meta_keywords');
            Session::forget('wizard.business_name');
            Session::forget('wizard.document_type');
            Session::forget('wizard.document_number');
            Session::forget('wizard.phone');
            Session::forget('wizard.email');
            Session::forget('wizard.city');
            Session::forget('wizard.department');
            Session::forget('wizard.address');
            Session::forget('wizard.description');

            Log::info('Tienda creada exitosamente desde pago Epayco aprobado', [
                'store_id' => $store->id,
                'registration_id' => $registration->id,
                'transaction_id' => $transaction->id
            ]);

            // Redirigir directamente a success
            return redirect()->route('register.success', $registration->id);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error creando tienda desde pago Epayco', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('register.step4')
                ->withErrors(['error' => 'Error al crear la tienda: ' . $e->getMessage()]);
        }
    }

    /**
     * Crear registro rechazado para mostrar en rejected.blade.php
     */
    protected function createRejectedRegistration(PaymentGatewayTransaction $transaction)
    {
        // Verificar que no exista ya un registro para esta transacción
        $existingRegistration = PendingRegistration::where('payment_transaction_id', $transaction->id)->first();
        if ($existingRegistration) {
            return $existingRegistration;
        }

        // Obtener datos de la sesión
        $planId = Session::get('payment.plan_id') ?? Session::get('wizard.plan_id');
        $billingPeriod = Session::get('payment.billing_period') ?? Session::get('wizard.billing_period');
        $ownerData = Session::get('payment.owner_data', []);

        if (!$planId || !$billingPeriod || empty($ownerData)) {
            throw new \Exception('Datos incompletos para crear registro rechazado');
        }

        // Crear registro rechazado
        $registration = PendingRegistration::create([
            // Step 1
            'plan_id' => $planId,
            'billing_period' => $billingPeriod,
            
            // Step 2
            'business_category_id' => Session::get('wizard.business_category_id'),
            'business_name' => Session::get('wizard.business_name'),
            'document_type' => Session::get('wizard.document_type'),
            'document_number' => Session::get('wizard.document_number'),
            'phone' => Session::get('wizard.phone'),
            'email' => Session::get('wizard.email'),
            'city' => Session::get('wizard.city'),
            'department' => Session::get('wizard.department'),
            'address' => Session::get('wizard.address'),
            'description' => Session::get('wizard.description'),
            
            // Step 3
            'store_name' => Session::get('wizard.store_name'),
            'slug' => Session::get('wizard.slug'),
            'store_description' => Session::get('wizard.store_description'),
            'meta_title' => Session::get('wizard.meta_title'),
            'meta_description' => Session::get('wizard.meta_description'),
            'meta_keywords' => Session::get('wizard.meta_keywords'),
            
            // Step 4
            'owner_name' => $ownerData['name'] ?? '',
            'owner_email' => $ownerData['email'] ?? '',
            'owner_document_type' => $ownerData['document_type'] ?? 'cc',
            'owner_document_number' => $ownerData['document'] ?? '',
            
            // Pago
            'payment_method' => 'epayco',
            'payment_transaction_id' => $transaction->id,
            'payment_proof' => null,
            
            // Estado
            'status' => 'rejected',
            'rejected_reason' => 'Pago rechazado por la pasarela de pagos Epayco.',
            'processed_at' => now(),
        ]);

        return $registration;
    }

    /**
     * Crear registro pendiente desde pago (para pagos pendientes o transferencias)
     */
    protected function createRegistrationFromPayment(PaymentGatewayTransaction $transaction, bool $sendWhatsApp = true)
    {
        // Verificar que no exista ya un registro para esta transacción
        $existingRegistration = PendingRegistration::where('payment_transaction_id', $transaction->id)->first();
        if ($existingRegistration) {
            return redirect()->route('register.step5', $existingRegistration->id);
        }

        // Obtener datos de la sesión
        $planId = Session::get('payment.plan_id') ?? Session::get('wizard.plan_id');
        $billingPeriod = Session::get('payment.billing_period') ?? Session::get('wizard.billing_period');
        $ownerData = Session::get('payment.owner_data', []);

        if (!$planId || !$billingPeriod || empty($ownerData)) {
            Log::error('Datos incompletos para crear registro desde pago', [
                'transaction_id' => $transaction->id,
                'session_data' => Session::all()
            ]);
            return redirect()->route('register.step4')
                ->withErrors(['error' => 'Datos incompletos. Por favor contacta soporte.']);
        }

        // Crear registro pendiente
        $registration = PendingRegistration::create([
            // Step 1
            'plan_id' => $planId,
            'billing_period' => $billingPeriod,
            
            // Step 2
            'business_category_id' => Session::get('wizard.business_category_id'),
            'business_name' => Session::get('wizard.business_name'),
            'document_type' => Session::get('wizard.document_type'),
            'document_number' => Session::get('wizard.document_number'),
            'phone' => Session::get('wizard.phone'),
            'email' => Session::get('wizard.email'),
            'city' => Session::get('wizard.city'),
            'department' => Session::get('wizard.department'),
            'address' => Session::get('wizard.address'),
            'description' => Session::get('wizard.description'),
            
            // Step 3
            'store_name' => Session::get('wizard.store_name'),
            'slug' => Session::get('wizard.slug'),
            'store_description' => Session::get('wizard.store_description'),
            'meta_title' => Session::get('wizard.meta_title'),
            'meta_description' => Session::get('wizard.meta_description'),
            'meta_keywords' => Session::get('wizard.meta_keywords'),
            
            // Step 4
            'owner_name' => $ownerData['name'] ?? '',
            'owner_email' => $ownerData['email'] ?? '',
            'owner_document_type' => $ownerData['document_type'] ?? 'cc',
            'owner_document_number' => $ownerData['document'] ?? '',
            
            // Pago
            'payment_method' => 'epayco',
            'payment_transaction_id' => $transaction->id,
            'payment_proof' => null, // No hay comprobante, el pago es en línea
            
            // Estado
            'status' => 'pending',
        ]);

        // Limpiar sesión
        Session::forget('payment.reference');
        Session::forget('payment.plan_id');
        Session::forget('payment.billing_period');
        Session::forget('payment.owner_data');
        Session::forget('wizard.plan_id');
        Session::forget('wizard.billing_period');
        Session::forget('wizard.business_category_id');

        // Enviar notificación WhatsApp solo si se solicita
        if ($sendWhatsApp) {
            try {
                $whatsapp = app(\App\Services\WhatsAppNotificationService::class);
                if ($whatsapp->isEnabled()) {
                    $whatsapp->notifyNewRegistrationPending($registration, '573233332112');
                    $registration->update(['whatsapp_sent_at' => now()]);
                }
            } catch (\Exception $e) {
                Log::error('Error enviando WhatsApp de registro', [
                    'registration_id' => $registration->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $registration;
    }

    /**
     * Mapear tipo de documento a formato Epayco
     */
    protected function mapDocumentType(string $type): string
    {
        return match($type) {
            'cc' => 'CC',
            'ce' => 'CE',
            'passport' => 'PA',
            default => 'CC',
        };
    }
}
