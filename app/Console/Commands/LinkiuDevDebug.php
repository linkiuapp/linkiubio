<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Features\SuperLinkiu\Models\DevNotificationSetting;
use App\Features\SuperLinkiu\Models\DevTask;
use App\Features\SuperLinkiu\Models\DevAgendaEntry;
use App\Features\SuperLinkiu\Services\LinkiuDev\DevWhatsAppService;
use Carbon\Carbon;

class LinkiuDevDebug extends Command
{
    protected $signature = 'linkiudev:debug 
                            {--test-reminder : Enviar recordatorio de prueba}
                            {--test-summary : Enviar resumen de prueba}
                            {--force-task= : Forzar envío de recordatorio para una tarea específica (ID)}
                            {--check-tasks : Mostrar tareas pendientes de recordatorio}';

    protected $description = 'Diagnóstico y pruebas del sistema de notificaciones LinkiuDev';

    public function handle()
    {
        $this->info('=== LinkiuDev Debug ===');
        $this->newLine();

        // Mostrar configuración
        $this->showConfiguration();

        // Mostrar tareas pendientes
        if ($this->option('check-tasks')) {
            $this->showPendingTasks();
        }

        // Enviar recordatorio de prueba
        if ($this->option('test-reminder')) {
            $this->sendTestReminder();
        }

        // Enviar resumen de prueba
        if ($this->option('test-summary')) {
            $this->sendTestSummary();
        }

        // Forzar envío para tarea específica
        if ($taskId = $this->option('force-task')) {
            $this->forceTaskReminder($taskId);
        }

        return Command::SUCCESS;
    }

    protected function showConfiguration(): void
    {
        $this->info('📋 Configuración:');
        
        $whatsappService = app(DevWhatsAppService::class);
        $debug = $whatsappService->getDebugInfo();

        $this->table(
            ['Parámetro', 'Valor'],
            [
                ['Servicio habilitado', $debug['service_enabled'] ? '✅ Sí' : '❌ No'],
                ['API Key configurada', $debug['api_key_configured'] ? '✅ Sí' : '❌ No'],
                ['WhatsApp Sender', $debug['whatsapp_sender'] ?: '❌ No configurado'],
                ['Base URL', $debug['base_url']],
                ['Número admin (raw)', $debug['admin_number_raw'] ?: '❌ Vacío'],
                ['Código país', $debug['admin_country_code'] ?: '❌ No configurado'],
                ['Número admin (full)', $debug['admin_number_full'] ?: '❌ Vacío'],
                ['Resumen diario habilitado', $debug['daily_summary_enabled'] ? '✅ Sí' : '❌ No'],
                ['Resumen configurado', $debug['daily_summary_configured'] ? '✅ Sí' : '❌ No'],
                ['Recordatorios habilitados', $debug['reminders_enabled'] ? '✅ Sí' : '❌ No'],
                ['Recordatorios configurados', $debug['reminders_configured'] ? '✅ Sí' : '❌ No'],
            ]
        );

        $this->newLine();
        $this->info('📝 Plantillas configuradas:');
        foreach ($debug['templates'] as $key => $value) {
            $this->line("  - {$key}: {$value}");
        }
        $this->newLine();
    }

    protected function showPendingTasks(): void
    {
        $this->info('📋 Tareas pendientes de recordatorio (hoy):');
        
        $tasks = DevTask::with('project')
            ->pendingReminder()
            ->whereDate('scheduled_date', today())
            ->get();

        if ($tasks->isEmpty()) {
            $this->warn('  No hay tareas pendientes de recordatorio para hoy.');
            return;
        }

        $now = now();
        $rows = [];

        foreach ($tasks as $task) {
            $reminderTime = $task->reminder_time;
            $shouldSend = $task->shouldSendReminder();
            
            $status = '⏳ Pendiente';
            if ($shouldSend) {
                $status = '🔔 ¡AHORA!';
            } elseif ($reminderTime && $now->gt($reminderTime->copy()->addMinutes(5))) {
                $status = '⚠️ Pasado (ventana cerrada)';
            }

            $rows[] = [
                $task->id,
                \Illuminate\Support\Str::limit($task->name, 25),
                $task->project?->name ?? '-',
                $task->scheduled_start_time,
                $task->reminder_minutes . ' min',
                $reminderTime?->format('H:i') ?? '-',
                $status,
            ];
        }

        $this->table(
            ['ID', 'Tarea', 'Proyecto', 'Hora inicio', 'Recordatorio', 'Hora recordatorio', 'Estado'],
            $rows
        );
        
        $this->newLine();
        $this->line("  Hora actual: " . $now->format('H:i:s'));
        $this->newLine();
    }

    protected function sendTestReminder(): void
    {
        $this->info('📤 Enviando recordatorio de prueba...');
        
        try {
            $whatsappService = app(DevWhatsAppService::class);
            $result = $whatsappService->sendTestTaskReminder();

            if ($result) {
                $this->info('  ✅ Recordatorio de prueba enviado correctamente');
            } else {
                $this->error('  ❌ Error al enviar el recordatorio');
            }
        } catch (\Exception $e) {
            $this->error('  ❌ Error: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    protected function sendTestSummary(): void
    {
        $this->info('📤 Enviando resumen de prueba...');
        
        try {
            $whatsappService = app(DevWhatsAppService::class);
            $result = $whatsappService->sendTestDailySummary();

            if ($result) {
                $this->info('  ✅ Resumen de prueba enviado correctamente');
            } else {
                $this->error('  ❌ Error al enviar el resumen');
            }
        } catch (\Exception $e) {
            $this->error('  ❌ Error: ' . $e->getMessage());
        }
        
        $this->newLine();
    }

    protected function forceTaskReminder(int $taskId): void
    {
        $this->info("📤 Forzando envío de recordatorio para tarea #{$taskId}...");
        
        $task = DevTask::with('project')->find($taskId);

        if (!$task) {
            $this->error('  ❌ Tarea no encontrada');
            return;
        }

        $this->line("  Tarea: {$task->name}");
        $this->line("  Proyecto: " . ($task->project?->name ?? 'Sin proyecto'));
        $this->line("  Fecha programada: " . ($task->scheduled_date?->format('Y-m-d') ?? 'No programada'));
        $this->line("  Hora: " . ($task->scheduled_start_time ?? 'Sin hora'));
        $this->line("  Recordatorio ya enviado: " . ($task->reminder_sent ? 'Sí' : 'No'));

        if (!$this->confirm('¿Deseas enviar el recordatorio ahora?', true)) {
            $this->warn('  Cancelado.');
            return;
        }

        try {
            $whatsappService = app(DevWhatsAppService::class);
            
            // Temporalmente resetear reminder_sent para forzar el envío
            $originalReminderSent = $task->reminder_sent;
            
            $result = $whatsappService->sendTaskReminder($task);

            if ($result) {
                $this->info('  ✅ Recordatorio enviado correctamente');
            } else {
                $this->error('  ❌ Error al enviar el recordatorio');
                // Restaurar el estado original si falló
                if (!$originalReminderSent) {
                    $task->update(['reminder_sent' => false]);
                }
            }
        } catch (\Exception $e) {
            $this->error('  ❌ Error: ' . $e->getMessage());
        }
        
        $this->newLine();
    }
}
