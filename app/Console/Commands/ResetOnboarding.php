<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\StoreOnboardingStep;
use App\Shared\Models\Store;

class ResetOnboarding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onboarding:reset {store_id? : ID de la tienda (opcional, si no se proporciona se resetean todas)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resetear el progreso del onboarding de una tienda para probar el confetti';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storeId = $this->argument('store_id');

        if ($storeId) {
            // Resetear onboarding de una tienda específica
            $store = Store::find($storeId);
            
            if (!$store) {
                $this->error("Tienda con ID {$storeId} no encontrada");
                return 1;
            }

            $deleted = StoreOnboardingStep::where('store_id', $storeId)->delete();
            $this->info("✅ Onboarding reseteado para: {$store->name} (ID: {$storeId})");
            $this->info("   {$deleted} pasos eliminados");
            $this->line("\n🎯 Ahora completa cualquier paso del onboarding para probar el confetti cuando termines todos los pasos.");
            
        } else {
            // Confirmar antes de resetear todas las tiendas
            if (!$this->confirm('¿Estás seguro de resetear el onboarding de TODAS las tiendas?', false)) {
                $this->info('Operación cancelada');
                return 0;
            }

            $totalStores = Store::count();
            $deleted = StoreOnboardingStep::query()->delete();
            
            $this->info("✅ Onboarding reseteado para {$totalStores} tiendas");
            $this->info("   {$deleted} pasos eliminados en total");
        }

        $this->newLine();
        $this->comment('💡 Tip: Usa "php artisan onboarding:reset {store_id}" para resetear una tienda específica');

        return 0;
    }
}

