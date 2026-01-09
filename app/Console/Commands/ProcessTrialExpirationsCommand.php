<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Subscription;
use App\Shared\Models\Store;
use App\Shared\Models\Invoice;
use App\Services\BillingNotificationService;
use Carbon\Carbon;

class ProcessTrialExpirationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'trial:process-expirations 
                            {--dry-run : Run without making changes}
                            {--notify : Send notifications to store owners}';

    /**
     * The console command description.
     */
    protected $description = 'Process trial period expirations: generate invoices, send warnings, and suspend if needed';

    protected ?BillingNotificationService $notificationService = null;

    // Configuración de avisos de trial
    private const WARNING_DAYS_BEFORE = [7, 3, 1]; // Días antes de vencimiento para avisar
    private const GRACE_PERIOD_DAYS = 3;           // Días de gracia después de vencer trial
    private const SUSPENSION_DAYS = 7;             // Días después del trial para suspender si no paga

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $shouldNotify = $this->option('notify');

        if ($shouldNotify) {
            $this->notificationService = app(BillingNotificationService::class);
        }

        $this->info('🧪 Procesando vencimientos de períodos de prueba...');
        
        if ($isDryRun) {
            $this->warn('⚠️  MODO DRY-RUN: No se realizarán cambios reales');
        }

        // 1. Enviar avisos previos al vencimiento
        $warningsSent = $this->sendTrialWarnings($isDryRun, $shouldNotify);

        // 2. Procesar trials que vencen hoy - generar factura
        $invoicesGenerated = $this->processTrialsEndingToday($isDryRun, $shouldNotify);

        // 3. Procesar trials vencidos sin pago - período de gracia
        $gracePeriodCount = $this->processGracePeriodTrials($isDryRun, $shouldNotify);

        // 4. Suspender trials vencidos sin pago después del período de gracia
        $suspendedCount = $this->suspendExpiredTrials($isDryRun, $shouldNotify);

        // Mostrar resumen
        $this->info("\n📊 RESUMEN:");
        $this->info("📧 Avisos de vencimiento próximo enviados: {$warningsSent}");
        $this->info("📄 Facturas generadas por fin de trial: {$invoicesGenerated}");
        $this->info("⏳ Tiendas en período de gracia: {$gracePeriodCount}");
        $this->info("🚫 Tiendas suspendidas por no pagar: {$suspendedCount}");

        if ($isDryRun) {
            $this->warn("⚠️  Esto fue una simulación - no se realizaron cambios");
        } else {
            $this->info("🎉 ¡Proceso completado exitosamente!");
        }

        return 0;
    }

    /**
     * Send warnings for trials about to expire
     */
    private function sendTrialWarnings(bool $isDryRun, bool $shouldNotify): int
    {
        $sentCount = 0;

        foreach (self::WARNING_DAYS_BEFORE as $daysBefore) {
            $targetDate = now()->addDays($daysBefore)->toDateString();
            
            $expiringTrials = Subscription::where('status', Subscription::STATUS_ACTIVE)
                ->whereNotNull('trial_end')
                ->whereDate('trial_end', $targetDate)
                ->with(['store', 'plan'])
                ->get();

            if ($expiringTrials->isEmpty()) {
                continue;
            }

            $this->info("📧 Enviando avisos de trial (vence en {$daysBefore} días): {$expiringTrials->count()} tiendas");

            foreach ($expiringTrials as $subscription) {
                $store = $subscription->store;
                
                if (!$store || $store->status !== 'active') {
                    continue;
                }

                $this->line("  📬 Aviso → {$store->name} (vence: {$subscription->trial_end->format('d/m/Y')})");

                if (!$isDryRun && $shouldNotify && $this->notificationService) {
                    try {
                        $this->notificationService->sendTrialExpirationWarning($store, $subscription, $daysBefore);
                        $sentCount++;
                    } catch (\Exception $e) {
                        $this->error("    ❌ Error enviando aviso: " . $e->getMessage());
                    }
                } else {
                    $sentCount++;
                }
            }
        }

        return $sentCount;
    }

    /**
     * Process trials ending today - generate invoices
     */
    private function processTrialsEndingToday(bool $isDryRun, bool $shouldNotify): int
    {
        $today = now()->toDateString();
        
        $endingTrials = Subscription::where('status', Subscription::STATUS_ACTIVE)
            ->whereNotNull('trial_end')
            ->whereDate('trial_end', $today)
            ->with(['store', 'plan'])
            ->get();

        if ($endingTrials->isEmpty()) {
            $this->line("📄 No hay trials que venzan hoy");
            return 0;
        }

        $this->info("📄 Procesando trials que vencen hoy: {$endingTrials->count()} tiendas");

        $generated = 0;
        foreach ($endingTrials as $subscription) {
            $store = $subscription->store;
            $plan = $subscription->plan;
            
            if (!$store || !$plan) {
                continue;
            }

            // Verificar si ya existe factura para este período
            $existingInvoice = Invoice::where('store_id', $store->id)
                ->where('subscription_id', $subscription->id)
                ->whereIn('status', ['pending', 'paid'])
                ->where('created_at', '>=', now()->subDays(7))
                ->first();

            if ($existingInvoice) {
                $this->line("  ⏭ {$store->name} - Ya tiene factura pendiente");
                continue;
            }

            $this->line("  📄 Generando factura → {$store->name} ({$plan->name})");

            if (!$isDryRun) {
                try {
                    // Calcular monto según período de facturación
                    $amount = $plan->getPriceForPeriod($subscription->billing_cycle);

                    // Crear factura
                    $invoice = Invoice::create([
                        'store_id' => $store->id,
                        'subscription_id' => $subscription->id,
                        'plan_id' => $plan->id,
                        'amount' => $amount,
                        'period' => $subscription->billing_cycle,
                        'status' => 'pending',
                        'issue_date' => now(),
                        'due_date' => now()->addDays(self::GRACE_PERIOD_DAYS),
                        'notes' => 'Factura generada automáticamente al finalizar período de prueba',
                        'metadata' => [
                            'generated_by' => 'trial_expiration',
                            'trial_end' => $subscription->trial_end->toDateString(),
                            'auto_generated' => true,
                        ]
                    ]);

                    // Actualizar suscripción - quitar trial y establecer período
                    $periodDays = $this->getPeriodDays($subscription->billing_cycle);
                    $subscription->update([
                        'trial_end' => null,
                        'current_period_start' => now(),
                        'current_period_end' => now()->addDays($periodDays),
                        'next_billing_date' => now()->addDays($periodDays),
                        'status' => Subscription::STATUS_GRACE_PERIOD,
                        'grace_period_end' => now()->addDays(self::GRACE_PERIOD_DAYS),
                    ]);

                    // Enviar notificación
                    if ($shouldNotify && $this->notificationService) {
                        $this->notificationService->sendTrialEndedInvoice($store, $invoice);
                    }

                    $generated++;

                    \Log::info('Factura generada por fin de trial', [
                        'store_id' => $store->id,
                        'invoice_id' => $invoice->id,
                        'amount' => $amount,
                    ]);

                } catch (\Exception $e) {
                    $this->error("    ❌ Error: " . $e->getMessage());
                    \Log::error('Error generando factura de trial', [
                        'store_id' => $store->id,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                $generated++;
            }
        }

        return $generated;
    }

    /**
     * Process trials in grace period
     */
    private function processGracePeriodTrials(bool $isDryRun, bool $shouldNotify): int
    {
        $gracePeriodSubs = Subscription::where('status', Subscription::STATUS_GRACE_PERIOD)
            ->whereNotNull('grace_period_end')
            ->where('grace_period_end', '>', now())
            ->with(['store', 'plan'])
            ->get();

        if ($gracePeriodSubs->isEmpty()) {
            return 0;
        }

        $this->info("⏳ Tiendas en período de gracia: {$gracePeriodSubs->count()}");

        foreach ($gracePeriodSubs as $subscription) {
            $store = $subscription->store;
            $daysLeft = (int) now()->diffInDays($subscription->grace_period_end, false);
            
            $this->line("  ⏳ {$store->name} - {$daysLeft} días restantes de gracia");

            // Enviar recordatorio si quedan pocos días
            if (!$isDryRun && $shouldNotify && $this->notificationService && $daysLeft <= 1) {
                try {
                    $this->notificationService->sendGracePeriodWarning($store, $subscription, $daysLeft);
                } catch (\Exception $e) {
                    $this->error("    ❌ Error enviando recordatorio: " . $e->getMessage());
                }
            }
        }

        return $gracePeriodSubs->count();
    }

    /**
     * Suspend trials that expired without payment
     */
    private function suspendExpiredTrials(bool $isDryRun, bool $shouldNotify): int
    {
        // Buscar suscripciones cuyo período de gracia ya terminó
        $expiredGrace = Subscription::where('status', Subscription::STATUS_GRACE_PERIOD)
            ->whereNotNull('grace_period_end')
            ->where('grace_period_end', '<', now())
            ->with(['store', 'plan'])
            ->get();

        // También buscar trials vencidos que nunca fueron procesados
        $unprocessedTrials = Subscription::where('status', Subscription::STATUS_ACTIVE)
            ->whereNotNull('trial_end')
            ->where('trial_end', '<', now()->subDays(self::SUSPENSION_DAYS))
            ->with(['store', 'plan'])
            ->get();

        $toSuspend = $expiredGrace->merge($unprocessedTrials)->unique('id');

        if ($toSuspend->isEmpty()) {
            $this->line("🚫 No hay tiendas que requieran suspensión por trial vencido");
            return 0;
        }

        $this->info("🚫 Suspendiendo tiendas por trial/gracia vencido: {$toSuspend->count()}");

        $suspended = 0;
        foreach ($toSuspend as $subscription) {
            $store = $subscription->store;
            
            if (!$store || $store->status === 'suspended') {
                continue;
            }

            // Verificar si tiene factura pagada
            $hasPaidInvoice = Invoice::where('store_id', $store->id)
                ->where('status', 'paid')
                ->where('created_at', '>=', now()->subDays(30))
                ->exists();

            if ($hasPaidInvoice) {
                // Tiene pago, reactivar suscripción
                $this->line("  ✅ {$store->name} - Tiene pago, activando suscripción");
                
                if (!$isDryRun) {
                    $subscription->update([
                        'status' => Subscription::STATUS_ACTIVE,
                        'grace_period_end' => null,
                    ]);
                }
                continue;
            }

            $this->line("  🚫 Suspendiendo: {$store->name}");

            if (!$isDryRun) {
                try {
                    // Suspender tienda
                    $store->update([
                        'status' => 'suspended',
                        'suspension_reason' => 'trial_expired_no_payment',
                        'suspended_at' => now(),
                    ]);

                    // Suspender suscripción
                    $subscription->update([
                        'status' => Subscription::STATUS_SUSPENDED,
                        'grace_period_end' => null,
                        'metadata' => array_merge($subscription->metadata ?? [], [
                            'suspended_for' => 'trial_expired_no_payment',
                            'suspended_at' => now()->toIso8601String(),
                        ])
                    ]);

                    // Enviar notificación
                    if ($shouldNotify && $this->notificationService) {
                        $this->notificationService->sendTrialSuspensionNotification($store, $subscription);
                    }

                    $suspended++;

                    \Log::warning('Tienda suspendida por trial vencido sin pago', [
                        'store_id' => $store->id,
                        'store_name' => $store->name,
                    ]);

                } catch (\Exception $e) {
                    $this->error("    ❌ Error suspendiendo: " . $e->getMessage());
                }
            } else {
                $suspended++;
            }
        }

        return $suspended;
    }

    /**
     * Get period days for billing cycle
     */
    private function getPeriodDays(string $billingCycle): int
    {
        return match($billingCycle) {
            'monthly' => 30,
            'quarterly' => 90,
            'semester' => 180,
            'annual' => 365,
            default => 30
        };
    }
}
