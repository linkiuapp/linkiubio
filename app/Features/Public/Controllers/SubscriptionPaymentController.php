<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\SubSubscription;
use App\Features\SuperLinkiu\Models\SubPayment;
use App\Models\PaymentGateway;
use App\Services\PaymentGateways\EpaycoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionPaymentController extends Controller
{
    /**
     * Vista pública de la suscripción
     */
    public function show(string $token)
    {
        $subscription = SubSubscription::with(['client', 'serviceType'])
            ->where('payment_token', $token)
            ->firstOrFail();

        // Obtener o crear pago pendiente
        $payment = $subscription->payments()->pending()->first();
        
        if (!$payment && $subscription->status !== 'cancelled') {
            $payment = $subscription->createPayment();
        }

        // Obtener gateway de pago
        $gateway = PaymentGateway::where('name', 'epayco')
            ->where('is_active', true)
            ->first();

        $pseBanks = [];
        if ($gateway) {
            try {
                $epaycoService = new EpaycoService($gateway);
                $banksResult = $epaycoService->getPseBanks();
                $pseBanks = $banksResult['banks'] ?? [];
            } catch (\Exception $e) {
                Log::error('Error obteniendo bancos PSE para suscripción', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('public.subscription-payment', compact('subscription', 'payment', 'pseBanks', 'gateway'));
    }

    /**
     * Procesar pago
     */
    public function processPayment(Request $request, string $token)
    {
        $subscription = SubSubscription::with('client')
            ->where('payment_token', $token)
            ->firstOrFail();

        $validated = $request->validate([
            'payment_method' => 'required|in:pse,cash',
            'bank_code' => 'required_if:payment_method,pse',
            'cash_type' => 'required_if:payment_method,cash',
            'document_type' => 'required|in:CC,CE,NIT,PA',
            'document' => 'required|string|max:30',
        ]);

        // Obtener pago pendiente
        $payment = $subscription->payments()->pending()->first();
        
        if (!$payment) {
            return back()->with('error', 'No hay pago pendiente para esta suscripción.');
        }

        // Obtener gateway
        $gateway = PaymentGateway::where('name', 'epayco')
            ->where('is_active', true)
            ->firstOrFail();

        try {
            $epaycoService = new EpaycoService($gateway);

            $reference = $payment->generateReference();
            $payment->update(['payment_reference' => $reference]);

            $paymentData = [
                'reference' => $reference,
                'reference_type' => 'subscription',
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'description' => "Pago suscripción: {$subscription->service_name}",
                'name' => $subscription->client->name,
                'last_name' => '',
                'email' => $subscription->client->email ?? 'cliente@linkiudev.com',
                'phone' => $subscription->client->phone ?? '',
                'document_type' => $validated['document_type'],
                'document' => $validated['document'],
                'response_url' => route('public.subscription.payment.response', $payment->payment_token),
                'confirmation_url' => route('api.subscription.payment.webhook'),
            ];

            $result = $epaycoService->createPaymentSession(
                $paymentData,
                $validated['payment_method'],
                $validated['bank_code'] ?? null,
                $validated['cash_type'] ?? null
            );

            if ($result['success'] && isset($result['checkout_url'])) {
                // Guardar datos de ePayco
                $payment->update([
                    'payment_method' => $validated['payment_method'],
                    'epayco_data' => $result,
                ]);

                return redirect($result['checkout_url']);
            }

            return back()->with('error', $result['error'] ?? 'Error al procesar el pago.');

        } catch (\Exception $e) {
            Log::error('Error procesando pago de suscripción', [
                'subscription_id' => $subscription->id,
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }

    /**
     * Respuesta de pago (redirect desde ePayco)
     */
    public function paymentResponse(Request $request, string $paymentToken)
    {
        $payment = SubPayment::with(['subscription.client'])
            ->where('payment_token', $paymentToken)
            ->firstOrFail();

        // Verificar estado con ePayco
        $gateway = PaymentGateway::where('name', 'epayco')
            ->where('is_active', true)
            ->first();

        $status = 'pending';
        $message = 'Tu pago está siendo procesado.';

        if ($gateway && $payment->payment_reference) {
            try {
                $epaycoService = new EpaycoService($gateway);
                $result = $epaycoService->verifyPayment($payment->payment_reference);

                if ($result['success']) {
                    $status = $result['status'];

                    if ($status === 'approved') {
                        $message = '¡Tu pago fue procesado exitosamente!';
                    } elseif ($status === 'rejected') {
                        $message = 'El pago fue rechazado. Por favor, intenta nuevamente.';
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error verificando pago de suscripción', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return view('public.subscription-payment-response', compact('payment', 'status', 'message'));
    }

    /**
     * Webhook de confirmación de pago (llamado por ePayco)
     */
    public function paymentWebhook(Request $request)
    {
        Log::info('SubscriptionDev: Webhook de pago recibido', $request->all());

        $reference = $request->input('x_ref_payco') 
            ?? $request->input('ref_payco') 
            ?? $request->input('x_invoice');

        if (!$reference) {
            return response()->json(['error' => 'Referencia no encontrada'], 400);
        }

        // Buscar el pago por referencia
        $payment = SubPayment::where('payment_reference', $reference)->first();

        if (!$payment) {
            Log::warning('SubscriptionDev: Pago no encontrado para referencia', [
                'reference' => $reference
            ]);
            return response()->json(['error' => 'Pago no encontrado'], 404);
        }

        // Mapear estado de ePayco
        $epaycoStatus = $request->input('x_cod_response') 
            ?? $request->input('cod_response');
        
        $status = match($epaycoStatus) {
            '1' => 'paid',
            '2' => 'failed',
            '3' => 'pending',
            default => 'pending',
        };

        if ($status === 'paid' && $payment->status !== 'paid') {
            $payment->markAsPaid(
                $request->input('x_franchise') ?? 'epayco',
                $reference,
                $request->input('x_ref_payco')
            );

            $payment->update([
                'epayco_data' => $request->all(),
            ]);

            Log::info('SubscriptionDev: Pago marcado como pagado via webhook', [
                'payment_id' => $payment->id,
                'subscription_id' => $payment->subscription_id
            ]);
        } elseif ($status === 'failed') {
            $payment->markAsFailed(
                $request->input('x_response_reason_text') ?? 'Pago rechazado'
            );

            Log::info('SubscriptionDev: Pago marcado como fallido via webhook', [
                'payment_id' => $payment->id
            ]);
        }

        return response()->json(['success' => true]);
    }
}
