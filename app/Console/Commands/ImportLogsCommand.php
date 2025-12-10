<?php

namespace App\Console\Commands;

use App\Jobs\LogErrorJob;
use App\Services\SystemDebugService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring:import-logs {--days=30 : Número de días a importar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar logs existentes de archivos a la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $this->info("📥 Importando logs de los últimos {$days} días...");

        $logPath = storage_path('logs/laravel.log');
        
        if (!File::exists($logPath)) {
            $this->warn('⚠️  No se encontró el archivo de log');
            return 1;
        }

        $cutoffDate = now()->subDays($days);
        $errors = SystemDebugService::getRecentErrors(10000); // Obtener muchos logs
        
        $imported = 0;
        $skipped = 0;

        $this->withProgressBar($errors, function ($error) use ($cutoffDate, &$imported, &$skipped) {
            try {
                $timestamp = \Carbon\Carbon::parse($error['timestamp']);
                
                // Solo importar si está dentro del rango de días
                if ($timestamp->lt($cutoffDate)) {
                    $skipped++;
                    return;
                }

                // Parsear el mensaje para extraer información
                $message = $error['message'];
                $stackTrace = $error['stack_trace'] ?? '';
                
                // Intentar extraer archivo y línea del stack trace
                $file = null;
                $line = null;
                if (preg_match('/#0 .*?\((.*?):(\d+)\)/', $stackTrace, $matches)) {
                    $file = $matches[1];
                    $line = (int) $matches[2];
                }

                // Despachar job para loggear en BD
                LogErrorJob::dispatch([
                    'level' => $error['level'] ?? 'ERROR',
                    'message' => $message,
                    'stack_trace' => $stackTrace,
                    'file' => $file,
                    'line' => $line,
                    'route' => null, // No disponible en logs antiguos
                    'method' => null,
                    'ip_address' => null,
                    'user_agent' => null,
                    'user_id' => null,
                    'store_id' => null,
                    'context' => $error['context'] ?? [],
                    'request_data' => null,
                ]);

                $imported++;
            } catch (\Exception $e) {
                $skipped++;
            }
        });

        $this->newLine();
        $this->info("✅ Importación completada:");
        $this->line("   - Importados: {$imported}");
        $this->line("   - Omitidos: {$skipped}");

        return 0;
    }
}
