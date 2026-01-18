<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Invoice;
use App\Shared\Models\Store;
use App\Shared\Models\Subscription;
use App\Services\BillingNotificationService;
use Carbon\Carbon;

class ProcessBillingSuspensionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'billing:process-suspensions {--dry-run : Run without making changes} {--force-days= : Override suspension days threshold}';

    /**
     * The console command description.
     */
    protected $description = 'Process automatic billing suspensions for overdue invoices';

    protected $notificationService;

    // Configuración de avisos PREVENTIVOS (antes de vencer)
    private const PREVENTIVE_WARNING_15_DAYS = 15; // Recordatorio temprano
    private const PREVENTIVE_WARNING_7_DAYS = 7;   // Recordatorio medio
    private const PREVENTIVE_WARNING_5_DAYS = 5;   // Recordatorio urgente
    
    // Configuración de avisos CORRECTIVOS (después de vencer)
    private const OVERDUE_WARNING_1_DAY = 1;       // Aviso inmediato
    
    // Configuración de suspensiones por período (días después de vencer)
    private const SUSPENSION_DAYS_MONTHLY = 3;     // Mensual: 3 días
    private const SUSPENSION_DAYS_QUARTERLY = 5;   // Trimestral: 5 días
    private const SUSPENSION_DAYS_SEMESTER = 10;   // Semestral: 10 días
    private const SUSPENSION_DAYS_ANNUAL = 15;     // Anual: 15 días

    public function __construct(BillingNotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $forceDays = $this->option('force-days');

        $this->info('🚫 Procesando suspensiones automáticas por falta de pago...');
        
        if ($isDryRun) {
            $this->warn('⚠️  MODO DRY-RUN: No se realizarán cambios reales');
        }

        if ($forceDays) {
            $this->warn("⚠️  Usando {$forceDays} días como umbral de suspensión (en lugar de " . self::SUSPENSION_DAYS . ")");
        }

        // 1. Procesar avisos PREVENTIVOS (antes de vencer)
        $preventiveCounts = $this->processPreventiveWarnings($isDryRun);

        // 2. Procesar avisos CORRECTIVOS (después de vencer)
        $correctiveCounts = $this->processCorrectiveWarnings($isDryRun);

        // 3. Procesar suspensiones automáticas (dinámicas según período)
        $suspensionCount = $this->processAutomaticSuspensions($isDryRun, $forceDays);

        // Mostrar resumen
        $this->info("\n📊 RESUMEN:");
        $this->info("📧 Avisos preventivos (15 días antes): {$preventiveCounts['15_days']}");
        $this->info("📧 Avisos preventivos (7 días antes): {$preventiveCounts['7_days']}");
        $this->info("⚠️  Avisos preventivos (5 días antes): {$preventiveCounts['5_days']}");
        $this->info("🚨 Avisos correctivos (1 día después): {$correctiveCounts['1_day']}");
        $this->info("🚫 Tiendas suspendidas (según período): {$suspensionCount}");

        if ($isDryRun) {
            $this->warn("⚠️  Esto fue una simulación - no se realizaron cambios");
        } else {
            $this->info("🎉 ¡Proceso completado exitosamente!");
        }
    }

    /**
     * Process preventive warnings (before due date)
     */
    private function processPreventiveWarnings(bool $isDryRun): array
    {
        $counts = ['15_days' => 0, '7_days' => 0, '5_days' => 0];

        // Recordatorio temprano (15 días antes)
        $counts['15_days'] = $this->sendPreventiveWarnings(self::PREVENTIVE_WARNING_15_DAYS, 'preventive_15_days', $isDryRun);
        
        // Recordatorio medio (7 días antes)
        $counts['7_days'] = $this->sendPreventiveWarnings(self::PREVENTIVE_WARNING_7_DAYS, 'preventive_7_days', $isDryRun);
        
        // Recordatorio urgente (5 días antes)
        $counts['5_days'] = $this->sendPreventiveWarnings(self::PREVENTIVE_WARNING_5_DAYS, 'preventive_5_days', $isDryRun);

        return $counts;
    }

    /**
     * Process corrective warnings (after due date)
     */
    private function processCorrectiveWarnings(bool $isDryRun): array
    {
        $counts = ['1_day' => 0];

        // Aviso inmediato (1 día después de vencer)
        $counts['1_day'] = $this->sendCorrectiveWarnings(self::OVERDUE_WARNING_1_DAY, 'overdue_1_day', $isDryRun);

        return $counts;
    }

    /**
     * Send preventive warnings (before due date)
     */
    private function sendPreventiveWarnings(int $daysBefore, string $warningType, bool $isDryRun): int
    {
        $targetDate = now()->addDays($daysBefore)->toDateString();
        
        $upcomingInvoices = Invoice::where('status', 'pending')
            ->where('due_date', $targetDate)
            ->with(['store', 'plan', 'store.subscription'])
            ->get();

        if ($upcomingInvoices->isEmpty()) {
            return 0;
        }

        $warningLabel = match($warningType) {
            'preventive_15_days' => 'recordatorio temprano',
            'preventive_7_days' => 'recordatorio medio',
            'preventive_5_days' => 'recordatorio urgente',
            default => $warningType
        };

        $this->info("📧 Enviando {$warningLabel} a {$upcomingInvoices->count()} tiendas ({$daysBefore} días antes):");

        $sent = 0;
        foreach ($upcomingInvoices as $invoice) {
            // Verificar que la tienda esté activa
            if ($invoice->store->status !== 'active') {
                continue;
            }

            $this->line("  📬 {$warningLabel} → {$invoice->store->name} (#{$invoice->invoice_number})");
            
            if (!$isDryRun) {
                try {
                    $this->notificationService->sendPreventiveWarning($invoice, $warningType, $daysBefore);
                    $sent++;

                    // Log para auditoría
                    \Log::info('Aviso preventivo de factura enviado', [
                        'invoice_id' => $invoice->id,
                        'store_id' => $invoice->store_id,
                        'warning_type' => $warningType,
                        'days_before' => $daysBefore
                    ]);
                } catch (\Exception $e) {
                    $this->error("    ❌ Error enviando aviso: " . $e->getMessage());
                    \Log::error('Error enviando aviso preventivo de factura', [
                        'invoice_id' => $invoice->id,
                        'warning_type' => $warningType,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                $sent++;
            }
        }

        return $sent;
    }

    /**
     * Send corrective warnings (after due date)
     */
    private function sendCorrectiveWarnings(int $daysOverdue, string $warningType, bool $isDryRun): int
    {
        $targetDate = now()->subDays($daysOverdue)->toDateString();
        
        $overdueInvoices = Invoice::where('status', 'overdue')
            ->where('due_date', $targetDate)
            ->with(['store', 'plan', 'store.subscription'])
            ->get();

        if ($overdueInvoices->isEmpty()) {
            return 0;
        }

        $warningLabel = match($warningType) {
            'overdue_1_day' => 'aviso de vencimiento inmediato',
            default => $warningType
        };

        $this->info("🚨 Enviando {$warningLabel} a {$overdueInvoices->count()} tiendas ({$daysOverdue} días vencidas):");

        $sent = 0;
        foreach ($overdueInvoices as $invoice) {
            // Verificar que la tienda siga activa
            if ($invoice->store->status !== 'active') {
                continue;
            }

            $this->line("  📬 {$warningLabel} → {$invoice->store->name} (#{$invoice->invoice_number})");
            
            if (!$isDryRun) {
                try {
                    $this->notificationService->sendBillingWarning($invoice, $warningType, $daysOverdue);
                    $sent++;

                    // Log para auditoría
                    \Log::info('Aviso correctivo de factura vencida enviado', [
                        'invoice_id' => $invoice->id,
                        'store_id' => $invoice->store_id,
                        'warning_type' => $warningType,
                        'days_overdue' => $daysOverdue
                    ]);
                } catch (\Exception $e) {
                    $this->error("    ❌ Error enviando aviso: " . $e->getMessage());
                    \Log::error('Error enviando aviso correctivo de factura vencida', [
                        'invoice_id' => $invoice->id,
                        'warning_type' => $warningType,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                $sent++;
            }
        }

        return $sent;
    }

    /**
     * Process automatic suspensions for overdue invoices (dynamic based on billing period)
     */
    private function processAutomaticSuspensions(bool $isDryRun, ?int $forceDays = null): int
    {
        // Obtener todas las facturas vencidas
        $overdueInvoices = Invoice::where('status', 'overdue')
            ->with(['store', 'store.subscription', 'plan'])
            ->get();

        if ($overdueInvoices->isEmpty()) {
            $this->line("🚫 No hay facturas vencidas para evaluar suspensión");
            return 0;
        }

        // Filtrar facturas que cumplen los días de suspensión según su período
        $severlyOverdue = $overdueInvoices->filter(function ($invoice) use ($forceDays) {
            if ($forceDays) {
                // Si se fuerza un número de días, usarlo para todas
                return $invoice->due_date->diffInDays(now()) >= $forceDays;
            }
            
            // Calcular días de suspensión según el período de facturación
            $suspensionDays = $this->getSuspensionDaysForPeriod($invoice->period);
            return $invoice->due_date->diffInDays(now()) >= $suspensionDays;
        });

        // Filtrar solo tiendas que aún estén activas
        $suspendableStores = $severlyOverdue->filter(function ($invoice) {
            return $invoice->store && $invoice->store->status === 'active';
        });

        if ($suspendableStores->isEmpty()) {
            $this->line("🚫 No hay tiendas que requieran suspensión automática");
            return 0;
        }

        $this->info("🚫 Suspendiendo {$suspendableStores->count()} tiendas por facturas vencidas:");

        $suspended = 0;
        foreach ($suspendableStores as $invoice) {
            $store = $invoice->store;
            $daysOverdue = $invoice->due_date->diffInDays(now());
            $suspensionDays = $forceDays ?? $this->getSuspensionDaysForPeriod($invoice->period);
            $periodLabel = $this->getPeriodLabel($invoice->period);
            
            $this->line("  🚫 Suspendiendo: {$store->name} (#{$invoice->invoice_number} - {$daysOverdue} días vencida, período: {$periodLabel}, prórroga: {$suspensionDays} días)");
            
            if (!$isDryRun) {
                try {
                    $this->suspendStore($store, $invoice, $daysOverdue);
                    $suspended++;
                } catch (\Exception $e) {
                    $this->error("    ❌ Error suspendiendo tienda: " . $e->getMessage());
                    \Log::error('Error suspendiendo tienda por falta de pago', [
                        'store_id' => $store->id,
                        'invoice_id' => $invoice->id,
                        'error' => $e->getMessage()
                    ]);
                }
            } else {
                $suspended++;
            }
        }

        return $suspended;
    }

    /**
     * Suspend a store for non-payment
     */
    private function suspendStore(Store $store, Invoice $invoice, int $daysOverdue): void
    {
        // 1. Cambiar estado de la tienda
        $store->update([
            'status' => 'suspended',
            'suspension_reason' => 'billing_overdue',
            'suspended_at' => now(),
            'suspended_invoice_id' => $invoice->id
        ]);

        // 2. Suspender suscripción si existe
        if ($store->subscription) {
            $store->subscription->update([
                'status' => Subscription::STATUS_SUSPENDED,
                'grace_period_end' => null,
                'metadata' => array_merge($store->subscription->metadata ?? [], [
                    'suspended_for' => 'billing_overdue',
                    'suspended_at' => now(),
                    'suspended_invoice' => $invoice->invoice_number,
                    'days_overdue' => $daysOverdue
                ])
            ]);
        }

        // 3. Enviar notificación de suspensión
        $this->notificationService->sendSuspensionNotification($store, $invoice, $daysOverdue);

        // 4. Log para auditoría
        \Log::warning('Tienda suspendida por falta de pago', [
            'store_id' => $store->id,
            'store_name' => $store->name,
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'days_overdue' => $daysOverdue,
            'suspended_at' => now()
        ]);

        $this->line("    ✅ Tienda {$store->name} suspendida exitosamente");
    }

    /**
     * Get suspension days based on billing period
     */
    private function getSuspensionDaysForPeriod(?string $period): int
    {
        return match($period) {
            'monthly' => self::SUSPENSION_DAYS_MONTHLY,        // Mensual: 3 días
            'quarterly' => self::SUSPENSION_DAYS_QUARTERLY,    // Trimestral: 5 días
            'semester', 'biannual' => self::SUSPENSION_DAYS_SEMESTER, // Semestral: 10 días
            'annual', 'yearly' => self::SUSPENSION_DAYS_ANNUAL, // Anual: 15 días
            default => self::SUSPENSION_DAYS_MONTHLY           // Por defecto: mensual (3 días)
        };
    }

    /**
     * Get period label for display
     */
    private function getPeriodLabel(?string $period): string
    {
        return match($period) {
            'monthly' => 'Mensual',
            'quarterly' => 'Trimestral',
            'semester', 'biannual' => 'Semestral',
            'annual', 'yearly' => 'Anual',
            default => 'Mensual'
        };
    }
}

