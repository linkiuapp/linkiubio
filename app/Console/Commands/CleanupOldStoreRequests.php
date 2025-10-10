<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shared\Models\Store;
use App\Shared\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanupOldStoreRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stores:cleanup-old-requests 
                            {--days=90 : Número de días después de los cuales limpiar solicitudes rechazadas}
                            {--dry-run : Mostrar qué se limpiaría sin realizar cambios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpia/archiva solicitudes de tiendas rechazadas antiguas (>90 días por defecto)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $dryRun = $this->option('dry-run');
        
        $this->info('🧹 Limpieza de solicitudes de tiendas rechazadas antiguas...');
        $this->info("📅 Umbral: Solicitudes rechazadas hace más de {$days} días");
        
        if ($dryRun) {
            $this->warn('⚠️  MODO DRY-RUN: No se realizarán cambios en la BD');
        }
        
        // Obtener solicitudes rechazadas antiguas
        $cutoffDate = Carbon::now()->subDays($days);
        
        $oldRejectedStores = Store::where('approval_status', 'rejected')
            ->where('rejected_at', '<', $cutoffDate)
            ->orderBy('rejected_at', 'asc')
            ->get();
        
        if ($oldRejectedStores->isEmpty()) {
            $this->info('✅ No hay solicitudes antiguas para limpiar.');
            return Command::SUCCESS;
        }
        
        $this->info("📊 Solicitudes rechazadas antiguas encontradas: {$oldRejectedStores->count()}");
        
        // Mostrar listado
        $tableData = [];
        foreach ($oldRejectedStores as $store) {
            $daysOld = $store->rejected_at->diffInDays(Carbon::now());
            $adminEmail = $store->admins->first()?->email ?? 'N/A';
            
            $tableData[] = [
                $store->id,
                $store->name,
                $adminEmail,
                $store->business_document_number ?? 'N/A',
                $store->rejected_at->format('d/m/Y'),
                $daysOld . ' días'
            ];
        }
        
        $this->table(
            ['ID', 'Nombre', 'Admin Email', 'Documento', 'Rechazada', 'Antigüedad'],
            $tableData
        );
        
        if ($dryRun) {
            $this->warn('✅ DRY-RUN completado. No se realizaron cambios.');
            return Command::SUCCESS;
        }
        
        // Confirmar acción
        if (!$this->confirm("¿Confirmas que deseas eliminar {$oldRejectedStores->count()} solicitud(es) rechazada(s)?")) {
            $this->info('❌ Operación cancelada por el usuario.');
            return Command::SUCCESS;
        }
        
        // Realizar limpieza
        DB::beginTransaction();
        try {
            $deletedCount = 0;
            
            foreach ($oldRejectedStores as $store) {
                // Log antes de eliminar
                Log::channel('daily')->info('Limpiando solicitud rechazada antigua', [
                    'store_id' => $store->id,
                    'store_name' => $store->name,
                    'admin_email' => $store->admins->first()?->email ?? 'N/A',
                    'business_document_number' => $store->business_document_number,
                    'rejected_at' => $store->rejected_at->toDateTimeString(),
                    'days_old' => $store->rejected_at->diffInDays(Carbon::now())
                ]);
                
                // Eliminar usuarios admin asociados (si no tienen otras tiendas)
                foreach ($store->admins as $admin) {
                    // Verificar si el admin solo está asociado a esta tienda
                    $otherStores = $admin->stores()->where('stores.id', '!=', $store->id)->count();
                    
                    if ($otherStores === 0) {
                        $this->line("  🗑️  Eliminando usuario admin: {$admin->email}");
                        $admin->delete();
                    }
                }
                
                // Eliminar tienda
                $this->line("  🗑️  Eliminando tienda: {$store->name}");
                $store->delete();
                $deletedCount++;
            }
            
            DB::commit();
            
            $this->info("✅ Limpieza completada: {$deletedCount} solicitud(es) eliminada(s).");
            
            // Log de resumen
            Log::channel('daily')->info('Limpieza de solicitudes rechazadas completada', [
                'deleted_count' => $deletedCount,
                'threshold_days' => $days,
                'cutoff_date' => $cutoffDate->toDateTimeString()
            ]);
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->error('❌ Error durante la limpieza: ' . $e->getMessage());
            
            Log::channel('daily')->error('Error en limpieza de solicitudes rechazadas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return Command::FAILURE;
        }
    }
}
