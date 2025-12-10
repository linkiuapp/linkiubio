<?php

namespace App\Console\Commands;

use App\Models\PendingRegistration;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanupPendingRegistrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pending-registrations:cleanup 
                            {--status=pending : Estado de los registros a limpiar (pending, approved, rejected, all)}
                            {--days=30 : Número de días después de los cuales limpiar registros}
                            {--all : Borrar todos los registros del estado especificado sin importar la fecha}
                            {--dry-run : Mostrar qué se borraría sin realizar cambios}
                            {--force : Forzar eliminación sin confirmación}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpia registros pendientes antiguos de la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $status = $this->option('status');
        $days = $this->option('days');
        $all = $this->option('all');
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        $this->info('🧹 Limpieza de registros pendientes...');
        
        // Validar estado
        $validStatuses = ['pending', 'approved', 'rejected', 'all'];
        if (!in_array($status, $validStatuses)) {
            $this->error("❌ Estado inválido. Opciones válidas: " . implode(', ', $validStatuses));
            return Command::FAILURE;
        }

        // Construir query
        $query = PendingRegistration::query();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if (!$all) {
            $cutoffDate = Carbon::now()->subDays($days);
            $query->where('created_at', '<', $cutoffDate);
            $this->info("📅 Umbral: Registros creados hace más de {$days} días");
        } else {
            $this->warn('⚠️  MODO ALL: Se borrarán TODOS los registros del estado especificado');
        }

        if ($dryRun) {
            $this->warn('⚠️  MODO DRY-RUN: No se realizarán cambios en la BD');
        }

        $registrations = $query->orderBy('created_at', 'asc')->get();

        if ($registrations->isEmpty()) {
            $this->info('✅ No hay registros para limpiar.');
            return Command::SUCCESS;
        }

        $this->info("📊 Registros encontrados: {$registrations->count()}");

        // Mostrar resumen por estado
        $statusCounts = $registrations->groupBy('status')->map->count();
        $this->table(
            ['Estado', 'Cantidad'],
            $statusCounts->map(fn($count, $status) => [$status, $count])->values()->toArray()
        );

        // Mostrar algunos ejemplos
        $this->info("\n📋 Primeros 10 registros a eliminar:");
        $tableData = [];
        foreach ($registrations->take(10) as $reg) {
            $daysOld = $reg->created_at->diffInDays(Carbon::now());
            $tableData[] = [
                $reg->id,
                $reg->store_name ?? 'N/A',
                $reg->owner_email,
                $reg->status,
                $reg->created_at->format('d/m/Y'),
                $daysOld . ' días'
            ];
        }

        $this->table(
            ['ID', 'Tienda', 'Email', 'Estado', 'Creado', 'Antigüedad'],
            $tableData
        );

        if ($registrations->count() > 10) {
            $this->info("... y " . ($registrations->count() - 10) . " más");
        }

        if ($dryRun) {
            $this->warn('✅ DRY-RUN completado. No se realizaron cambios.');
            return Command::SUCCESS;
        }

        // Confirmar acción
        if (!$force && !$this->confirm("¿Confirmas que deseas eliminar {$registrations->count()} registro(s)?")) {
            $this->info('❌ Operación cancelada por el usuario.');
            return Command::SUCCESS;
        }

        // Realizar limpieza
        DB::beginTransaction();
        try {
            $deletedCount = 0;
            $filesDeleted = 0;

            foreach ($registrations as $registration) {
                // Log antes de eliminar
                Log::channel('daily')->info('Limpiando registro pendiente', [
                    'registration_id' => $registration->id,
                    'store_name' => $registration->store_name,
                    'owner_email' => $registration->owner_email,
                    'status' => $registration->status,
                    'created_at' => $registration->created_at->toDateTimeString(),
                    'days_old' => $registration->created_at->diffInDays(Carbon::now())
                ]);

                // Eliminar comprobante de pago si existe
                if ($registration->payment_proof) {
                    try {
                        if (Storage::disk('public')->exists($registration->payment_proof)) {
                            Storage::disk('public')->delete($registration->payment_proof);
                            $filesDeleted++;
                        }
                    } catch (\Exception $e) {
                        $this->warn("  ⚠️  No se pudo eliminar el archivo: {$registration->payment_proof}");
                    }
                }

                // Eliminar registro
                $this->line("  🗑️  Eliminando registro ID: {$registration->id} - {$registration->store_name}");
                $registration->delete();
                $deletedCount++;
            }

            DB::commit();

            $this->info("✅ Limpieza completada:");
            $this->info("   - Registros eliminados: {$deletedCount}");
            if ($filesDeleted > 0) {
                $this->info("   - Archivos eliminados: {$filesDeleted}");
            }

            // Log de resumen
            Log::channel('daily')->info('Limpieza de registros pendientes completada', [
                'deleted_count' => $deletedCount,
                'files_deleted' => $filesDeleted,
                'status_filter' => $status,
                'days_threshold' => $all ? 'all' : $days
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error durante la limpieza: " . $e->getMessage());
            Log::error('Error en limpieza de registros pendientes', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }
}

