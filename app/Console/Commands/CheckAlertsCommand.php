<?php

namespace App\Console\Commands;

use App\Jobs\CheckAlertsJob;
use Illuminate\Console\Command;

class CheckAlertsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring:check-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar alertas de monitoreo configuradas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando alertas de monitoreo...');

        try {
            CheckAlertsJob::dispatch();
            $this->info('✅ Verificación de alertas completada');
        } catch (\Exception $e) {
            $this->error('❌ Error al verificar alertas: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
