<?php

namespace App\Console\Commands;

use App\Shared\Models\Invoice;
use App\Shared\Models\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResetInvoiceToPendingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:reset-to-pending 
                            {invoice : ID o número de factura (ej: 123 o INV-202501-001)}
                            {--suspend-store : Suspender la tienda si estaba activa}
                            {--dry-run : Solo mostrar lo que haría sin hacer cambios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marca una factura pagada como pendiente nuevamente para testing';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $invoiceIdentifier = $this->argument('invoice');
        $shouldSuspendStore = $this->option('suspend-store');
        $isDryRun = $this->option('dry-run');

        $this->info("🔄 Reseteando factura: {$invoiceIdentifier}");
        $this->newLine();

        // Buscar la factura por ID o número
        $invoice = Invoice::where('id', $invoiceIdentifier)
            ->orWhere('invoice_number', $invoiceIdentifier)
            ->with(['store', 'store.subscription', 'plan'])
            ->first();

        if (!$invoice) {
            $this->error("❌ No se encontró la factura: {$invoiceIdentifier}");
            return 1;
        }

        // Verificar que la factura esté pagada
        if (!$invoice->isPaid()) {
            $this->warn("⚠️  La factura #{$invoice->invoice_number} no está pagada (estado: {$invoice->status})");
            
            if (!$this->confirm('¿Deseas continuar de todos modos?')) {
                $this->info('Operación cancelada.');
                return 0;
            }
        }

        // Mostrar información actual
        $this->info("📄 Factura: #{$invoice->invoice_number}");
        $this->line("   Estado actual: {$invoice->status}");
        $this->line("   Fecha de pago: " . ($invoice->paid_date ? $invoice->paid_date->format('Y-m-d H:i:s') : 'N/A'));
        $this->line("   Monto: $" . number_format($invoice->amount, 2, ',', '.'));
        $this->newLine();

        $store = $invoice->store;
        if ($store) {
            $this->info("🏪 Tienda: {$store->name}");
            $this->line("   Estado actual: {$store->status}");
            $this->line("   Razón de suspensión: " . ($store->suspension_reason ?? 'N/A'));
            if ($store->subscription) {
                $this->line("   Estado de suscripción: {$store->subscription->status}");
            }
            $this->newLine();
        }

        if ($isDryRun) {
            $this->warn("🔍 MODO DRY-RUN: No se harán cambios reales");
            $this->newLine();
        }

        try {
            // Guardar valores originales para el log
            $originalStatus = $invoice->status;
            $originalPaidDate = $invoice->paid_date;

            DB::transaction(function() use ($invoice, $store, $shouldSuspendStore, $isDryRun, $originalStatus, $originalPaidDate) {
                // 1. Resetear factura a pendiente
                if (!$isDryRun) {
                    $invoice->update([
                        'status' => 'pending',
                        'paid_date' => null,
                    ]);
                    
                    // Limpiar metadata relacionada con el procesamiento
                    $metadata = $invoice->metadata ?? [];
                    unset($metadata['payment_notes']);
                    unset($metadata['processed_by']);
                    unset($metadata['processed_at']);
                    $invoice->update(['metadata' => $metadata]);
                    
                    $invoice->refresh();
                    
                    // Log después de actualizar
                    Log::info('🔄 Factura reseteada a pendiente mediante comando', [
                        'invoice_id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'store_id' => $store->id ?? null,
                        'store_name' => $store->name ?? null,
                        'store_suspended' => $shouldSuspendStore && $store->status === 'active',
                        'previous_status' => $originalStatus,
                        'previous_paid_date' => $originalPaidDate ? $originalPaidDate->toDateTimeString() : null,
                        'reset_by' => 'console_command',
                        'command' => $this->signature,
                    ]);
                }
                
                $this->info("✅ Factura #{$invoice->invoice_number} marcada como 'pending'");
                $this->line("   - Status: pending");
                $this->line("   - Paid date: null");
                $this->newLine();

                // 2. Opcionalmente suspender la tienda
                if ($store && $shouldSuspendStore && $store->status === 'active') {
                    if (!$isDryRun) {
                        $store->update([
                            'status' => 'suspended',
                            'suspension_reason' => 'billing_overdue',
                            'suspended_at' => now(),
                            'suspended_invoice_id' => $invoice->id,
                        ]);

                        // Suspender suscripción también
                        if ($store->subscription && $store->subscription->status === \App\Shared\Models\Subscription::STATUS_ACTIVE) {
                            $store->subscription->update([
                                'status' => \App\Shared\Models\Subscription::STATUS_SUSPENDED,
                                'metadata' => array_merge($store->subscription->metadata ?? [], [
                                    'suspended_for' => 'billing_overdue',
                                    'suspended_at' => now(),
                                    'suspended_invoice' => $invoice->invoice_number,
                                ])
                            ]);
                        }
                    }
                    
                    $this->info("🚫 Tienda '{$store->name}' suspendida");
                    $this->line("   - Status: suspended");
                    $this->line("   - Suspension reason: billing_overdue");
                    $this->newLine();
                }
            });

            $this->newLine();
            $this->info("✨ Proceso completado exitosamente");
            
            if ($isDryRun) {
                $this->warn("💡 Ejecuta sin --dry-run para aplicar los cambios");
            } else {
                $this->info("💡 Ahora puedes probar el proceso de aprobación de pago para verificar la reactivación automática");
            }

            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            Log::error('Error reseteando factura a pendiente', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 1;
        }
    }
}