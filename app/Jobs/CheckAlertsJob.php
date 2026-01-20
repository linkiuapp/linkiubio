<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Job para verificar alertas de monitoreo
 * 
 * Nota: Las tablas de monitoreo fueron eliminadas en migración 2026_01_17_124113_drop_monitoring_tables.php
 * Este job se mantiene para evitar errores en el comando scheduled, pero no realiza ninguna acción
 */
class CheckAlertsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 30;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Las tablas de monitoreo fueron eliminadas
        // Este job se mantiene para evitar errores en el comando scheduled
        // pero no realiza ninguna acción
        
        Log::debug('CheckAlertsJob ejecutado - Sistema de monitoreo deshabilitado');
    }
}
