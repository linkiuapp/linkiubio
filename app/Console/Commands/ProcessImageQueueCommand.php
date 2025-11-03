<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;

class ProcessImageQueueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:process-queue 
                            {--limit=10 : Número máximo de jobs a procesar}
                            {--timeout=600 : Timeout en segundos (10 min por defecto)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesar un lote limitado de imágenes de la cola (para Laravel Cloud)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = (int) $this->option('limit');
        $timeout = (int) $this->option('timeout');
        
        $this->info("🔄 Procesando hasta {$limit} trabajos de la cola 'images'...");
        $this->info("⏱️  Timeout: {$timeout} segundos (10 min máximo en Laravel Cloud)");
        $this->newLine();
        
        $startTime = time();
        
        try {
            // Usar queue:work con límite de trabajos y parar cuando termine
            // Esto evita el timeout de 15 minutos en Laravel Cloud
            $this->call('queue:work', [
                '--queue' => 'images',
                '--tries' => 3,
                '--timeout' => 120, // 2 minutos por job
                '--max-jobs' => $limit,
                '--stop-when-empty' => true,
                '--max-time' => $timeout, // Tiempo total máximo
            ]);
            
            $elapsed = time() - $startTime;
            $this->newLine();
            $this->info("✅ Proceso completado");
            $this->info("⏱️  Tiempo: {$elapsed} segundos");
            
            // Si quedan más trabajos, sugerir ejecutar de nuevo
            $remaining = \DB::table('jobs')->where('queue', 'images')->count();
            if ($remaining > 0) {
                $this->warn("⚠️  Aún quedan {$remaining} trabajos en la cola");
                $this->info("💡 Ejecuta de nuevo: php artisan images:process-queue --limit={$limit}");
            }
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error("❌ Error procesando cola: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

