<?php

namespace App\Services;

use App\Shared\Models\Store;
use App\Shared\Models\Subscription;
use App\Shared\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BillingService
{
    /**
     * Crear suscripción y factura para una tienda nueva
     * Este es el ÚNICO método que debe usarse para crear billing inicial
     */
    public function createInitialBilling(
        Store $store, 
        string $billingCycle = 'monthly',
        ?bool $hasTrialPeriod = null,  // null = usar el del plan
        ?int $trialDays = null,         // null = usar el del plan
        string $paymentStatus = 'pending',
        ?int $createdBy = null,
        array $metadata = []
    ): array {
        
        DB::beginTransaction();

        try {
            // Validar que no exista ya una suscripción
            if (Subscription::where('store_id', $store->id)->exists()) {
                Log::warning('Intento de crear suscripción duplicada', [
                    'store_id' => $store->id,
                    'store_name' => $store->name
                ]);
                throw new \Exception('La tienda ya tiene una suscripción activa');
            }

            // Validar plan
            if (!$store->plan_id || !$store->plan) {
                throw new \Exception('La tienda no tiene un plan asignado');
            }

            // Validar billing cycle
            if (!in_array($billingCycle, ['monthly', 'quarterly', 'semester', 'annual'])) {
                $billingCycle = 'monthly';
            }

            // Obtener trial period del plan si no se especificó
            if ($hasTrialPeriod === null || $trialDays === null) {
                $trialDays = $store->plan->trial_days ?? 0;
                $hasTrialPeriod = $trialDays > 0;
            }

            // Calcular fechas
            $now = now();
            
            // Trial Period
            $trialStart = null;
            $trialEnd = null;
            $periodStart = $now;
            
            if ($hasTrialPeriod && $trialDays > 0) {
                $trialStart = $now;
                $trialEnd = $now->copy()->addDays($trialDays);
                $periodStart = $trialEnd->copy()->addDay(); // Período de pago empieza después del trial
            }

            // Período de facturación
            $periodDays = match($billingCycle) {
                'monthly' => 30,
                'quarterly' => 90,
                'semester' => 180,
                'annual' => 365,
                default => 30
            };
            
            $periodEnd = $periodStart->copy()->addDays($periodDays);
            $nextBillingDate = $periodEnd->copy();

            // Obtener precio del plan
            $amount = $store->plan->getPriceForPeriod($billingCycle);

            if (!$amount || $amount <= 0) {
                throw new \Exception("El plan no tiene precio configurado para el período {$billingCycle}");
            }

            // 1. CREAR SUSCRIPCIÓN
            $subscription = Subscription::create([
                'store_id' => $store->id,
                'plan_id' => $store->plan_id,
                'status' => Subscription::STATUS_ACTIVE,
                'billing_cycle' => $billingCycle,
                'current_period_start' => $periodStart->toDateString(),
                'current_period_end' => $periodEnd->toDateString(),
                'next_billing_date' => $nextBillingDate->toDateString(),
                'next_billing_amount' => $amount,
                'trial_start' => $trialStart?->toDateString(),
                'trial_end' => $trialEnd?->toDateString(),
                'metadata' => array_merge([
                    'created_via' => 'BillingService',
                    'has_trial' => $hasTrialPeriod,
                    'trial_days' => $trialDays,
                    'created_by_id' => $createdBy,
                ], $metadata)
            ]);

            // 2. CREAR PRIMERA FACTURA
            // Si hay trial, la factura se emite pero con vencimiento después del trial
            $issueDate = $now;
            $dueDate = $hasTrialPeriod && $trialEnd 
                ? $trialEnd->copy()->addDays(15) // 15 días después del trial
                : $issueDate->copy()->addDays(15); // 15 días desde hoy

            // Si tiene trial y la factura no está pagada, ajustar notas
            $notes = $this->generateInvoiceNotes($hasTrialPeriod, $trialDays, $paymentStatus, $metadata);

            $invoice = Invoice::create([
                'store_id' => $store->id,
                'subscription_id' => $subscription->id,
                'plan_id' => $store->plan_id,
                'amount' => $amount,
                'period' => $billingCycle,
                'status' => $paymentStatus,
                'issue_date' => $issueDate->toDateString(),
                'due_date' => $dueDate->toDateString(),
                'paid_date' => $paymentStatus === 'paid' ? $now->toDateString() : null,
                'notes' => $notes,
                'metadata' => array_merge([
                    'created_via' => 'BillingService',
                    'is_first_invoice' => true,
                    'has_trial' => $hasTrialPeriod,
                    'trial_days' => $trialDays,
                    'created_by_id' => $createdBy,
                ], $metadata)
            ]);

            DB::commit();

            Log::info('Billing creado exitosamente', [
                'store_id' => $store->id,
                'subscription_id' => $subscription->id,
                'invoice_id' => $invoice->id,
                'has_trial' => $hasTrialPeriod,
                'trial_days' => $trialDays
            ]);

            return [
                'subscription' => $subscription,
                'invoice' => $invoice
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error creando billing inicial', [
                'store_id' => $store->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Generar notas para la factura
     */
    private function generateInvoiceNotes(bool $hasTrial, int $trialDays, string $paymentStatus, array $metadata): string
    {
        $notes = [];

        if ($hasTrial && $trialDays > 0) {
            $notes[] = "Incluye {$trialDays} días de prueba gratuita";
        }

        if (isset($metadata['registration_id'])) {
            $notes[] = "Registro desde wizard público";
        } elseif (isset($metadata['auto_approved'])) {
            $notes[] = "Aprobación automática";
        } elseif (isset($metadata['manual_approval'])) {
            $notes[] = "Aprobación manual";
        } else {
            $notes[] = "Primera factura";
        }

        if ($paymentStatus === 'paid') {
            $notes[] = "Pagada al registro";
        }

        return implode(' - ', $notes);
    }

    /**
     * Verificar si una tienda está en período de prueba
     */
    public function isInTrialPeriod(Store $store): bool
    {
        $subscription = $store->subscription;
        
        if (!$subscription || !$subscription->trial_end) {
            return false;
        }

        return now()->lte($subscription->trial_end);
    }

    /**
     * Obtener días restantes de prueba
     */
    public function getRemainingTrialDays(Store $store): int
    {
        if (!$this->isInTrialPeriod($store)) {
            return 0;
        }

        return now()->diffInDays($store->subscription->trial_end, false);
    }
}

