<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Invoice;
use App\Shared\Models\Store;
use App\Features\SuperLinkiu\Services\StoreService;
use Carbon\Carbon;

class SuspendOverdueStores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:suspend-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suspender tiendas con facturas vencidas por más de 7 días';

    protected StoreService $storeService;

    public function __construct(StoreService $storeService)
    {
        parent::__construct();
        $this->storeService = $storeService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Buscando tiendas con facturas vencidas (+7 días)...');
        
        $gracePeriodDays = 7; // Días de gracia después del vencimiento
        $cutoffDate = Carbon::now()->subDays($gracePeriodDays);
        
        // Buscar facturas vencidas hace más de 7 días que aún están pendientes
        $overdueInvoices = Invoice::where('status', 'overdue')
            ->where('due_date', '<', $cutoffDate)
            ->with('store')
            ->get();
        
        $this->info("📊 Encontradas {$overdueInvoices->count()} facturas vencidas (+7 días)");
        
        $suspendedCount = 0;
        $skippedCount = 0;
        
        foreach ($overdueInvoices as $invoice) {
            $store = $invoice->store;
            
            // Verificar que la tienda no esté ya suspendida
            if ($store->status === 'suspended') {
                $this->line("  ⏭ {$store->name} - Ya suspendida");
                continue;
            }
            
            // Intentar suspender la tienda
            try {
                $this->warn("  ⚠️ Suspendiendo: {$store->name}");
                $this->warn("     Factura: {$invoice->invoice_number}");
                $this->warn("     Vencida desde: {$invoice->due_date->format('d/m/Y')} ({$invoice->due_date->diffInDays(now())} días)");
                
                // Usar el servicio para suspender (incluye validaciones)
                $result = $this->storeService->updateStatus($store, 'suspended');
                
                if ($result['success']) {
                    $suspendedCount++;
                    $this->error("  ✓ SUSPENDIDA: {$store->name}");
                    
                    // Log de auditoría
                    \Log::warning('Tienda suspendida automáticamente por factura vencida', [
                        'store_id' => $store->id,
                        'store_name' => $store->name,
                        'invoice_id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'due_date' => $invoice->due_date->format('Y-m-d'),
                        'days_overdue' => $invoice->due_date->diffInDays(now())
                    ]);
                } else {
                    $skippedCount++;
                    $this->warn("  ⏭ NO suspendida: {$result['message']}");
                }
                
            } catch (\Exception $e) {
                $skippedCount++;
                $this->error("  ✗ Error suspendiendo {$store->name}: {$e->getMessage()}");
                
                \Log::error('Error en suspensión automática', [
                    'store_id' => $store->id,
                    'invoice_id' => $invoice->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        $this->info("\n📊 RESUMEN:");
        $this->info("  ✅ Suspendidas: {$suspendedCount}");
        $this->warn("  ⏭ Omitidas: {$skippedCount}");
        
        if ($suspendedCount > 0) {
            $this->warn("\n⚠️ IMPORTANTE: Las tiendas suspendidas NO podrán vender hasta que paguen.");
        }
        
        return 0;
    }
}
