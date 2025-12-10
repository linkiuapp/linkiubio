<?php

namespace App\Jobs;

use App\Models\MonitoringAlert;
use App\Models\ErrorLog;
use App\Models\TrafficLog;
use App\Services\AlertService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CheckAlertsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $alerts = MonitoringAlert::active()->get();
            $alertService = app(AlertService::class);

            foreach ($alerts as $alert) {
                if (!$alert->canTrigger()) {
                    continue; // Skip si está en cooldown
                }

                $shouldTrigger = $alertService->checkAlert($alert);

                if ($shouldTrigger) {
                    // Obtener contexto antes de disparar
                    $context = $alertService->getAlertContext($alert);
                    $alertService->triggerAlert($alert, $context);
                    $alert->markAsTriggered();
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to check alerts', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
