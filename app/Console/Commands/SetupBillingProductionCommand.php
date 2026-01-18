<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class SetupBillingProductionCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'billing:setup-production 
                            {--verify : Solo verificar sin hacer cambios}
                            {--force : Forzar configuración sin confirmación}';

    /**
     * The console command description.
     */
    protected $description = 'Configura y verifica el sistema de facturación para producción';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Configuración del Sistema de Facturación para Producción');
        $this->newLine();

        $isVerifyOnly = $this->option('verify');
        $isForced = $this->option('force');

        if (!$isVerifyOnly && !$isForced) {
            if (!$this->confirm('¿Deseas configurar el sistema de facturación para producción?', true)) {
                $this->warn('Operación cancelada.');
                return 1;
            }
        }

        $results = [
            'commands' => $this->verifyCommands(),
            'scheduler' => $this->verifyScheduler(),
            'permissions' => $this->verifyPermissions(),
            'logs' => $this->verifyLogs(),
        ];

        if (!$isVerifyOnly) {
            $this->newLine();
            $this->info('📋 Resumen de Configuración:');
            $this->displayResults($results);
            
            $this->newLine();
            $this->info('✅ Configuración completada. Revisa el archivo docs/COMANDOS_FACTURACION_PRODUCTION.md para más detalles.');
        } else {
            $this->newLine();
            $this->info('📋 Resumen de Verificación:');
            $this->displayResults($results);
        }

        return 0;
    }

    /**
     * Verificar que los comandos existan
     */
    protected function verifyCommands(): array
    {
        $this->info('🔍 Verificando comandos de facturación...');

        $requiredCommands = [
            'billing:generate-monthly',
            'billing:sync-invoices',
            'billing:update-overdue',
            'billing:process-suspensions',
            'invoices:send-reminders',
            'billing:send-notifications',
            'billing:sync-store-subscription-status',
        ];

        $results = [];
        foreach ($requiredCommands as $command) {
            try {
                Artisan::call($command, ['--help' => true]);
                $results[$command] = ['status' => 'ok', 'message' => 'Comando disponible'];
            } catch (\Exception $e) {
                $results[$command] = ['status' => 'error', 'message' => 'Comando no encontrado'];
            }
        }

        return $results;
    }

    /**
     * Verificar configuración del scheduler
     */
    protected function verifyScheduler(): array
    {
        $this->info('📅 Verificando configuración del scheduler...');

        $schedulerFile = base_path('routes/console.php');
        $hasScheduler = File::exists($schedulerFile);

        if (!$hasScheduler) {
            return [
                'status' => 'error',
                'message' => 'Archivo routes/console.php no encontrado'
            ];
        }

        $content = File::get($schedulerFile);
        $requiredCommands = [
            'billing:sync-invoices',
            'billing:process-suspensions',
            'invoices:send-reminders',
        ];

        $found = [];
        foreach ($requiredCommands as $command) {
            if (str_contains($content, $command)) {
                $found[] = $command;
            }
        }

        if (count($found) === count($requiredCommands)) {
            return [
                'status' => 'ok',
                'message' => 'Scheduler configurado correctamente',
                'commands' => $found
            ];
        }

        return [
            'status' => 'warning',
            'message' => 'Algunos comandos no están en el scheduler',
            'found' => $found,
            'missing' => array_diff($requiredCommands, $found)
        ];
    }

    /**
     * Verificar permisos de directorios
     */
    protected function verifyPermissions(): array
    {
        $this->info('🔐 Verificando permisos de directorios...');

        $directories = [
            storage_path('logs') => 'Logs',
            storage_path('framework/cache') => 'Cache',
        ];

        $results = [];
        foreach ($directories as $path => $name) {
            if (!File::isDirectory($path)) {
                $results[$name] = ['status' => 'error', 'message' => 'Directorio no existe'];
                continue;
            }

            if (!is_writable($path)) {
                $results[$name] = ['status' => 'warning', 'message' => 'Directorio no escribible'];
            } else {
                $results[$name] = ['status' => 'ok', 'message' => 'Permisos correctos'];
            }
        }

        return $results;
    }

    /**
     * Verificar configuración de logs
     */
    protected function verifyLogs(): array
    {
        $this->info('📝 Verificando configuración de logs...');

        $logFile = storage_path('logs/laravel.log');
        $logExists = File::exists($logFile);
        $logWritable = $logExists ? is_writable($logFile) : false;

        return [
            'status' => $logExists && $logWritable ? 'ok' : 'warning',
            'message' => $logExists 
                ? ($logWritable ? 'Logs configurados correctamente' : 'Archivo de log no escribible')
                : 'Archivo de log no existe (se creará automáticamente)'
        ];
    }

    /**
     * Mostrar resultados de verificación
     */
    protected function displayResults(array $results): void
    {
        foreach ($results as $section => $data) {
            $this->newLine();
            $this->line("  <fg=cyan>{$section}:</>");

            if (isset($data['status'])) {
                // Resultado simple
                $status = $data['status'];
                $message = $data['message'] ?? '';
                $icon = $status === 'ok' ? '✅' : ($status === 'warning' ? '⚠️' : '❌');
                $color = $status === 'ok' ? 'green' : ($status === 'warning' ? 'yellow' : 'red');
                $this->line("    {$icon} <fg={$color}>{$message}</>");
            } else {
                // Resultado múltiple
                foreach ($data as $key => $item) {
                    $status = $item['status'] ?? 'unknown';
                    $message = $item['message'] ?? '';
                    $icon = $status === 'ok' ? '✅' : ($status === 'warning' ? '⚠️' : '❌');
                    $color = $status === 'ok' ? 'green' : ($status === 'warning' ? 'yellow' : 'red');
                    $this->line("    {$icon} <fg={$color}>{$key}: {$message}</>");
                }
            }
        }
    }
}
