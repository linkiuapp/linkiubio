<?php

namespace App\Jobs;

use App\Models\ErrorLog;
use App\Models\TrafficLog;
use App\Models\PerformanceLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CleanOldLogsJob implements ShouldQueue
{
    use Queueable;

    protected $days;

    /**
     * Create a new job instance.
     */
    public function __construct(int $days = 30)
    {
        $this->days = $days;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $cutoffDate = now()->subDays($this->days);

            // Limpiar logs antiguos
            $errorLogsDeleted = ErrorLog::where('created_at', '<', $cutoffDate)->delete();
            $trafficLogsDeleted = TrafficLog::where('logged_at', '<', $cutoffDate)->delete();
            $performanceLogsDeleted = PerformanceLog::where('logged_at', '<', $cutoffDate)->delete();

            Log::info('Old logs cleaned', [
                'days' => $this->days,
                'error_logs_deleted' => $errorLogsDeleted,
                'traffic_logs_deleted' => $trafficLogsDeleted,
                'performance_logs_deleted' => $performanceLogsDeleted,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to clean old logs', [
                'error' => $e->getMessage(),
                'days' => $this->days
            ]);
        }
    }
}
