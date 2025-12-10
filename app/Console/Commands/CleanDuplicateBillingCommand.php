<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Store;
use App\Shared\Models\Subscription;
use App\Shared\Models\Invoice;
use Illuminate\Support\Facades\DB;

class CleanDuplicateBillingCommand extends Command
{
    protected $signature = 'billing:clean-duplicates {--dry-run : Solo mostrar lo que se eliminaría sin ejecutar}';
    protected $description = 'Limpia suscripciones y facturas duplicadas, dejando solo la más reciente';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->warn('🔍 MODO DRY-RUN: Solo se mostrará lo que se eliminaría');
        } else {
            $this->warn('⚠️  MODO REAL: Se eliminarán duplicados');
        }
        
        $this->info('');
        $this->info('Buscando duplicados...');
        $this->info('');

        $stores = Store::with(['subscription'])->get();
        $totalDuplicates = 0;
        $totalInvoicesDuplicated = 0;

        foreach ($stores as $store) {
            // Buscar suscripciones duplicadas
            $subscriptions = Subscription::where('store_id', $store->id)
                ->orderBy('created_at', 'desc')
                ->get();

            if ($subscriptions->count() > 1) {
                $this->error("🔴 Tienda #{$store->id} ({$store->name}): {$subscriptions->count()} suscripciones");
                
                // Mantener la más reciente, eliminar las demás
                $toKeep = $subscriptions->first();
                $toDelete = $subscriptions->slice(1);

                foreach ($toDelete as $sub) {
                    $this->line("  ❌ Eliminando suscripción #{$sub->id} (creada: {$sub->created_at})");
                    
                    if (!$isDryRun) {
                        // Eliminar facturas asociadas a esta suscripción
                        Invoice::where('subscription_id', $sub->id)->delete();
                        $sub->delete();
                    }
                    
                    $totalDuplicates++;
                }
                
                $this->line("  ✅ Manteniendo suscripción #{$toKeep->id} (más reciente)");
            }

            // Buscar facturas duplicadas para el mismo período
            $invoices = Invoice::where('store_id', $store->id)
                ->select('id', 'period', 'invoice_number', 'created_at')
                ->get()
                ->groupBy('period');

            foreach ($invoices as $period => $periodInvoices) {
                if ($periodInvoices->count() > 1) {
                    $this->warn("  🟡 Período '{$period}': {$periodInvoices->count()} facturas");
                    
                    // Mantener la más reciente
                    $toKeep = $periodInvoices->sortByDesc('created_at')->first();
                    $toDelete = $periodInvoices->except($toKeep->id);

                    foreach ($toDelete as $inv) {
                        $this->line("    ❌ Eliminando factura #{$inv->invoice_number}");
                        
                        if (!$isDryRun) {
                            Invoice::find($inv->id)->delete();
                        }
                        
                        $totalInvoicesDuplicated++;
                    }
                }
            }
        }

        $this->info('');
        $this->info('=====================================');
        $this->info("Total suscripciones duplicadas: {$totalDuplicates}");
        $this->info("Total facturas duplicadas: {$totalInvoicesDuplicated}");
        
        if ($isDryRun) {
            $this->warn('');
            $this->warn('⚠️  Esto fue una simulación. Ejecuta sin --dry-run para aplicar los cambios.');
        } else {
            $this->success('');
            $this->success('✅ Limpieza completada exitosamente');
        }

        return Command::SUCCESS;
    }
}
