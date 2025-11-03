<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteImageBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $backupPath
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (Storage::disk('public')->exists($this->backupPath)) {
            Storage::disk('public')->delete($this->backupPath);
            Log::info('Backup de imagen eliminado', [
                'path' => $this->backupPath
            ]);
        }
    }
}

