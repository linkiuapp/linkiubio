<?php

namespace App\Jobs;

use App\Models\ErrorLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LogErrorJob implements ShouldQueue
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
            // Verificar si ya existe un error similar (mismo mensaje, archivo y línea)
            $existingError = ErrorLog::where('message', $this->data['message'])
                ->where('file', $this->data['file'] ?? null)
                ->where('line', $this->data['line'] ?? null)
                ->where('route', $this->data['route'] ?? null)
                ->first();

            if ($existingError) {
                // Incrementar contador y actualizar última ocurrencia
                $existingError->increment('occurrence_count');
                $existingError->update([
                    'last_occurred_at' => now(),
                    'ip_address' => $this->data['ip_address'] ?? null,
                    'user_id' => $this->data['user_id'] ?? null,
                    'store_id' => $this->data['store_id'] ?? null,
                ]);
            } else {
                // Crear nuevo error
                ErrorLog::create([
                    'level' => $this->data['level'] ?? 'ERROR',
                    'message' => $this->data['message'],
                    'stack_trace' => $this->data['stack_trace'] ?? null,
                    'file' => $this->data['file'] ?? null,
                    'line' => $this->data['line'] ?? null,
                    'route' => $this->data['route'] ?? null,
                    'method' => $this->data['method'] ?? null,
                    'ip_address' => $this->data['ip_address'] ?? null,
                    'user_agent' => $this->data['user_agent'] ?? null,
                    'user_id' => $this->data['user_id'] ?? null,
                    'store_id' => $this->data['store_id'] ?? null,
                    'context' => $this->data['context'] ?? null,
                    'request_data' => $this->data['request_data'] ?? null,
                    'occurrence_count' => 1,
                    'first_occurred_at' => now(),
                    'last_occurred_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            // No fallar si hay error al loggear (evitar loops infinitos)
            Log::error('Failed to log error to database', [
                'error' => $e->getMessage(),
                'data' => $this->data
            ]);
        }
    }
}
