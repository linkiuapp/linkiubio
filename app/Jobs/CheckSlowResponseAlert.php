<?php

namespace App\Jobs;

use App\Models\MonitoringAlert;
use App\Services\AlertService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CheckSlowResponseAlert implements ShouldQueue
{
    use Queueable;

    protected $responseTime;
    protected $route;

    /**
     * Create a new job instance.
     */
    public function __construct(int $responseTime, ?string $route = null)
    {
        $this->responseTime = $responseTime;
        $this->route = $route;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Buscar alertas activas de tipo slow_response
            $alerts = MonitoringAlert::active()
                ->byType('slow_response')
                ->get();

            foreach ($alerts as $alert) {
                if (!$alert->canTrigger()) {
                    continue;
                }

                $conditions = $alert->conditions;
                $threshold = $conditions['threshold_ms'] ?? 5000;

                if ($this->responseTime > $threshold) {
                    $alertService = app(AlertService::class);
                    $alertService->triggerAlert($alert, [
                        'response_time' => $this->responseTime,
                        'route' => $this->route,
                        'threshold' => $threshold,
                    ]);
                    $alert->markAsTriggered();
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to check slow response alert', [
                'error' => $e->getMessage(),
                'response_time' => $this->responseTime,
                'route' => $this->route
            ]);
        }
    }
}
