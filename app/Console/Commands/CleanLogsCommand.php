<?php

namespace App\Console\Commands;

use App\Jobs\CleanOldLogsJob;
use Illuminate\Console\Command;

class CleanLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring:clean-logs {--days=30 : Número de días a mantener}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar logs antiguos de la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');

        $this->info("🧹 Limpiando logs más antiguos de {$days} días...");

        if (!$this->confirm("¿Estás seguro de que deseas eliminar logs más antiguos de {$days} días?")) {
            $this->info('Operación cancelada');
            return 0;
        }

        try {
            CleanOldLogsJob::dispatch($days);
            $this->info('✅ Limpieza de logs completada');
        } catch (\Exception $e) {
            $this->error('❌ Error al limpiar logs: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
