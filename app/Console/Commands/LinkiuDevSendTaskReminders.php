<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Features\SuperLinkiu\Models\DevNotificationSetting;
use App\Features\SuperLinkiu\Models\DevTask;
use App\Features\SuperLinkiu\Models\DevAgendaEntry;
use App\Features\SuperLinkiu\Services\LinkiuDev\DevWhatsAppService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LinkiuDevSendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linkiudev:send-task-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios de tareas y eventos próximos por WhatsApp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = DevNotificationSetting::getInstance();

        if (!$settings->areRemindersConfigured()) {
            $this->warn('Los recordatorios no están configurados o habilitados.');
            return Command::SUCCESS;
        }

        $this->info('Buscando tareas y eventos que necesitan recordatorio...');

        $whatsappService = app(DevWhatsAppService::class);
        $sentCount = 0;
        $errorCount = 0;

        // Buscar tareas que necesitan recordatorio
        $tasks = DevTask::with('project.client')
            ->pendingReminder()
            ->whereDate('scheduled_date', today())
            ->get();

        foreach ($tasks as $task) {
            if ($task->shouldSendReminder()) {
                $this->line("📋 Enviando recordatorio para tarea: {$task->name}");
                
                try {
                    $result = $whatsappService->sendTaskReminder($task);
                    
                    if ($result) {
                        $sentCount++;
                        $this->info("  ✅ Enviado");
                    } else {
                        $errorCount++;
                        $this->error("  ❌ Error al enviar");
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    $this->error("  ❌ Error: " . $e->getMessage());
                    Log::error('LinkiuDev: Error enviando recordatorio de tarea', [
                        'task_id' => $task->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        // Buscar eventos de agenda que necesitan recordatorio
        $agendaEntries = DevAgendaEntry::with(['project', 'client'])
            ->pendingReminder()
            ->whereDate('date', today())
            ->where('is_all_day', false)
            ->get();

        foreach ($agendaEntries as $entry) {
            if ($entry->shouldSendReminder()) {
                $this->line("📅 Enviando recordatorio para evento: {$entry->title}");
                
                try {
                    $result = $whatsappService->sendAgendaReminder($entry);
                    
                    if ($result) {
                        $sentCount++;
                        $this->info("  ✅ Enviado");
                    } else {
                        $errorCount++;
                        $this->error("  ❌ Error al enviar");
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    $this->error("  ❌ Error: " . $e->getMessage());
                    Log::error('LinkiuDev: Error enviando recordatorio de agenda', [
                        'entry_id' => $entry->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $this->newLine();
        $this->info("Resumen: {$sentCount} recordatorios enviados, {$errorCount} errores.");

        if ($sentCount > 0) {
            Log::info('LinkiuDev: Recordatorios enviados', [
                'sent' => $sentCount,
                'errors' => $errorCount
            ]);
        }

        return Command::SUCCESS;
    }
}
