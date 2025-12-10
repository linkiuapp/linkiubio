<?php

namespace App\Jobs;

use App\Models\TrafficLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LogTrafficJob implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            TrafficLog::create($this->data);
        } catch (\Exception $e) {
            // No fallar si hay error al loggear (evitar loops infinitos)
            Log::error('Failed to log traffic', [
                'error' => $e->getMessage(),
                'data' => $this->data
            ]);
        }
    }
}
