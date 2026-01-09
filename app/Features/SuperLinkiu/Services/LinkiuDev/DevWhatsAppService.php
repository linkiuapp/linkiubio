<?php

namespace App\Features\SuperLinkiu\Services\LinkiuDev;

use App\Features\SuperLinkiu\Models\DevNotificationSetting;
use App\Features\SuperLinkiu\Models\DevNotificationLog;
use App\Features\SuperLinkiu\Models\DevProject;
use App\Features\SuperLinkiu\Models\DevTask;
use App\Features\SuperLinkiu\Models\DevAgendaEntry;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DevWhatsAppService
{
    protected $apiKey;
    protected $baseUrl;
    protected $whatsappSender;

    // Nombres de plantillas de Infobip (UTILITY category)
    // NOTA: Usamos la misma plantilla aprobada para todo, adaptando el contenido
    protected $templates = [
        'project_update' => 'linkiudev_project_update_es',  // ✅ Aprobada
        'task_reminder'  => 'linkiudev_project_update_es',  // ✅ Usa la misma (aprobada)
        'daily_summary'  => 'linkiudev_project_update_es',  // ✅ Usa la misma (aprobada)
    ];

    public function __construct()
    {
        $this->apiKey = env('INFOBIP_API_KEY');
        $baseUrl = env('INFOBIP_BASE_URL');
        
        if ($baseUrl) {
            $baseUrl = rtrim($baseUrl, '/');
            if (!str_starts_with($baseUrl, 'http')) {
                $baseUrl = 'https://' . $baseUrl;
            }
        }
        
        $this->baseUrl = $baseUrl ?: 'https://api.infobip.com';
        $this->whatsappSender = env('INFOBIP_WHATSAPP_SENDER');
    }

    /**
     * Verificar si el servicio está habilitado
     */
    public function isEnabled(): bool
    {
        return !empty($this->apiKey) && !empty($this->whatsappSender);
    }

    /**
     * Obtener información de debug del servicio
     */
    public function getDebugInfo(): array
    {
        $settings = DevNotificationSetting::getInstance();
        
        return [
            'service_enabled' => $this->isEnabled(),
            'api_key_configured' => !empty($this->apiKey),
            'whatsapp_sender' => $this->whatsappSender,
            'base_url' => $this->baseUrl,
            'admin_number_raw' => $settings->whatsapp_number,
            'admin_country_code' => $settings->country_code,
            'admin_number_full' => $settings->full_whatsapp_number,
            'daily_summary_enabled' => $settings->daily_summary_enabled,
            'daily_summary_configured' => $settings->isDailySummaryConfigured(),
            'reminders_enabled' => $settings->task_reminders_enabled,
            'reminders_configured' => $settings->areRemindersConfigured(),
            'templates' => $this->templates,
        ];
    }

    /**
     * Enviar actualización de proyecto al cliente
     */
    public function sendProjectUpdateToClient(DevProject $project, ?string $customMessage = null): bool
    {
        $client = $project->client;
        
        if (!$client || empty($client->phone)) {
            throw new \Exception('El cliente no tiene número de teléfono configurado.');
        }

        $phone = $client->full_phone;
        
        // Calcular progreso del proyecto
        $progress = $project->progress_percentage;
        $progressText = "Progreso: {$progress}% ({$project->tasks_progress} tareas)";

        // Parámetros para la plantilla
        $params = [
            $client->name,
            $project->name,
            $project->status_label,
            $progressText,
            $customMessage ?? 'Tu proyecto está avanzando según lo planeado.',
        ];

        $log = DevNotificationLog::createLog(
            DevNotificationLog::TYPE_CLIENT_UPDATE,
            $phone,
            DevNotificationLog::RECIPIENT_CLIENT,
            ['template' => $this->templates['project_update'], 'params' => $params],
            $project->id,
            null,
            $client->id
        );

        return $this->sendTemplateMessage($phone, $this->templates['project_update'], $params, $log);
    }

    /**
     * Enviar notificación de cambio de estado del proyecto
     */
    public function sendProjectStatusChange(DevProject $project, string $oldStatus, string $newStatus): bool
    {
        $client = $project->client;
        
        if (!$client || empty($client->phone)) {
            return false;
        }

        $phone = $client->full_phone;
        
        $statusLabels = [
            'pending' => 'Pendiente',
            'in_progress' => 'En Progreso',
            'on_hold' => 'En Pausa',
            'completed' => 'Completado ✅',
            'cancelled' => 'Cancelado',
        ];

        $newStatusLabel = $statusLabels[$newStatus] ?? $newStatus;
        $message = $newStatus === 'completed' 
            ? '¡Tu proyecto ha sido completado exitosamente!' 
            : "El estado de tu proyecto ha cambiado a: {$newStatusLabel}";

        $params = [
            $client->name,
            $project->name,
            $newStatusLabel,
            "Progreso: {$project->progress_percentage}%",
            $message,
        ];

        $log = DevNotificationLog::createLog(
            DevNotificationLog::TYPE_CLIENT_UPDATE,
            $phone,
            DevNotificationLog::RECIPIENT_CLIENT,
            ['template' => $this->templates['project_update'], 'params' => $params, 'status_change' => [$oldStatus, $newStatus]],
            $project->id,
            null,
            $client->id
        );

        return $this->sendTemplateMessage($phone, $this->templates['project_update'], $params, $log);
    }

    /**
     * Enviar notificación de tarea completada al cliente
     */
    public function sendTaskCompletedToClient(DevTask $task): bool
    {
        $project = $task->project;
        $client = $project?->client;
        
        if (!$client || empty($client->phone)) {
            return false;
        }

        $phone = $client->full_phone;
        
        $params = [
            $client->name,
            $project->name,
            $task->name,
            'Completada ✅',
            "Progreso del proyecto: {$project->progress_percentage}%",
        ];

        $log = DevNotificationLog::createLog(
            DevNotificationLog::TYPE_CLIENT_UPDATE,
            $phone,
            DevNotificationLog::RECIPIENT_CLIENT,
            ['template' => $this->templates['project_update'], 'params' => $params],
            $project->id,
            $task->id,
            $client->id
        );

        return $this->sendTemplateMessage($phone, $this->templates['project_update'], $params, $log);
    }

    /**
     * Enviar resumen diario al admin
     * Usa la plantilla project_update adaptada:
     * {{1}}=Nombre, {{2}}=Proyecto, {{3}}=Estado, {{4}}=Progreso, {{5}}=Mensaje
     */
    public function sendDailySummary(): bool
    {
        $settings = DevNotificationSetting::getInstance();
        
        if (!$settings->isDailySummaryConfigured()) {
            return false;
        }

        $phone = $settings->full_whatsapp_number;
        $today = today();

        // Obtener tareas programadas para hoy
        $tasks = DevTask::with('project.client')
            ->scheduledToday()
            ->active()
            ->orderBy('scheduled_start_time')
            ->get();

        // Obtener eventos de agenda
        $events = DevAgendaEntry::with(['project', 'client'])
            ->today()
            ->orderBy('start_time')
            ->get();

        // Construir lista de actividades
        $activitiesList = "";
        $counter = 1;

        foreach ($events as $event) {
            $time = $event->is_all_day ? '📅' : Carbon::parse($event->start_time)->format('H:i');
            $activitiesList .= "{$counter}. {$time} - {$event->title}\n";
            $counter++;
        }

        foreach ($tasks as $task) {
            $time = $task->scheduled_start_time 
                ? Carbon::parse($task->scheduled_start_time)->format('H:i')
                : '📋';
            $activitiesList .= "{$counter}. {$time} - {$task->name}\n";
            $counter++;
        }

        $totalItems = $counter - 1;

        if ($totalItems === 0) {
            $activitiesList = "No tienes actividades programadas. 🎉";
        }

        // Adaptamos a los 5 parámetros de project_update
        $params = [
            'Admin',                                    // {{1}} Nombre
            'Agenda ' . $today->format('d/m'),          // {{2}} "Proyecto"
            'Resumen del día',                          // {{3}} Estado
            "{$totalItems} actividades pendientes",     // {{4}} "Progreso"
            $activitiesList,                            // {{5}} Mensaje/detalle
        ];

        $log = DevNotificationLog::createLog(
            DevNotificationLog::TYPE_DAILY_SUMMARY,
            $phone,
            DevNotificationLog::RECIPIENT_ADMIN,
            ['template' => $this->templates['daily_summary'], 'params' => $params, 'date' => $today->format('Y-m-d')]
        );

        return $this->sendTemplateMessage($phone, $this->templates['daily_summary'], $params, $log);
    }

    /**
     * Enviar recordatorio de tarea al admin
     * Usa la plantilla project_update adaptada:
     * {{1}}=Nombre, {{2}}=Proyecto, {{3}}=Estado, {{4}}=Progreso, {{5}}=Mensaje
     */
    public function sendTaskReminder(DevTask $task): bool
    {
        $settings = DevNotificationSetting::getInstance();
        
        if (!$settings->areRemindersConfigured()) {
            return false;
        }

        $phone = $settings->full_whatsapp_number;
        
        $minutesUntil = $task->reminder_minutes ?? 30;
        $startTime = $task->scheduled_start_time 
            ? Carbon::parse($task->scheduled_start_time)->format('H:i')
            : 'Sin hora';

        // Adaptamos a los 5 parámetros de project_update
        $params = [
            'Admin',                                    // {{1}} Nombre
            $task->project?->name ?? 'Tarea',           // {{2}} Proyecto
            "⏰ En {$minutesUntil} min",                // {{3}} Estado (como recordatorio)
            "Hora: {$startTime}",                       // {{4}} "Progreso" (hora)
            "📋 {$task->name}",                         // {{5}} Mensaje (nombre de la tarea)
        ];

        $log = DevNotificationLog::createLog(
            DevNotificationLog::TYPE_TASK_REMINDER,
            $phone,
            DevNotificationLog::RECIPIENT_ADMIN,
            ['template' => $this->templates['task_reminder'], 'params' => $params],
            $task->project_id,
            $task->id
        );

        $result = $this->sendTemplateMessage($phone, $this->templates['task_reminder'], $params, $log);

        if ($result) {
            $task->markReminderSent();
        }

        return $result;
    }

    /**
     * Enviar recordatorio de evento de agenda al admin
     * Usa la plantilla project_update adaptada:
     * {{1}}=Nombre, {{2}}=Proyecto, {{3}}=Estado, {{4}}=Progreso, {{5}}=Mensaje
     */
    public function sendAgendaReminder(DevAgendaEntry $entry): bool
    {
        $settings = DevNotificationSetting::getInstance();
        
        if (!$settings->areRemindersConfigured()) {
            return false;
        }

        $phone = $settings->full_whatsapp_number;
        
        $minutesUntil = $entry->reminder_minutes ?? 30;
        $startTime = $entry->start_time 
            ? Carbon::parse($entry->start_time)->format('H:i')
            : 'Sin hora';

        // Adaptamos a los 5 parámetros de project_update
        $params = [
            'Admin',                                    // {{1}} Nombre
            $entry->type_label ?? 'Evento',             // {{2}} "Proyecto" (tipo de evento)
            "⏰ En {$minutesUntil} min",                // {{3}} Estado (como recordatorio)
            "Hora: {$startTime}",                       // {{4}} "Progreso" (hora)
            "📋 {$entry->title}",                       // {{5}} Mensaje (título del evento)
        ];

        $log = DevNotificationLog::createLog(
            DevNotificationLog::TYPE_TASK_REMINDER,
            $phone,
            DevNotificationLog::RECIPIENT_ADMIN,
            ['template' => $this->templates['task_reminder'], 'params' => $params, 'agenda_entry_id' => $entry->id],
            $entry->project_id
        );

        $result = $this->sendTemplateMessage($phone, $this->templates['task_reminder'], $params, $log);

        if ($result) {
            $entry->markReminderSent();
        }

        return $result;
    }

    /**
     * Enviar resumen diario de prueba
     * Usa la plantilla project_update adaptada
     */
    public function sendTestDailySummary(): bool
    {
        $settings = DevNotificationSetting::getInstance();
        $phone = $settings->full_whatsapp_number;

        // Adaptamos a los 5 parámetros de project_update
        $params = [
            'Admin',                                    // {{1}} Nombre
            'Agenda ' . now()->format('d/m'),           // {{2}} "Proyecto"
            'Resumen del día',                          // {{3}} Estado
            '3 actividades pendientes',                 // {{4}} "Progreso"
            "1. 09:00 - Reunión de prueba\n2. 10:30 - Tarea de ejemplo\n3. 14:00 - Llamada 🧪", // {{5}}
        ];

        $log = DevNotificationLog::createLog(
            DevNotificationLog::TYPE_DAILY_SUMMARY,
            $phone,
            DevNotificationLog::RECIPIENT_ADMIN,
            ['template' => $this->templates['daily_summary'], 'params' => $params, 'test' => true]
        );

        return $this->sendTemplateMessage($phone, $this->templates['daily_summary'], $params, $log);
    }

    /**
     * Enviar recordatorio de prueba
     * Usa la plantilla project_update adaptada
     */
    public function sendTestTaskReminder(): bool
    {
        $settings = DevNotificationSetting::getInstance();
        $phone = $settings->full_whatsapp_number;

        // Adaptamos a los 5 parámetros de project_update
        $params = [
            'Admin',                                    // {{1}} Nombre
            'Proyecto de prueba',                       // {{2}} Proyecto
            '⏰ En 30 min',                             // {{3}} Estado
            'Hora: ' . now()->addMinutes(30)->format('H:i'), // {{4}} "Progreso"
            '📋 Tarea de prueba 🧪',                    // {{5}} Mensaje
        ];

        $log = DevNotificationLog::createLog(
            DevNotificationLog::TYPE_TASK_REMINDER,
            $phone,
            DevNotificationLog::RECIPIENT_ADMIN,
            ['template' => $this->templates['task_reminder'], 'params' => $params, 'test' => true]
        );

        return $this->sendTemplateMessage($phone, $this->templates['task_reminder'], $params, $log);
    }

    /**
     * Enviar mensaje usando plantilla de Infobip
     */
    protected function sendTemplateMessage(string $phone, string $templateName, array $params, DevNotificationLog $log): bool
    {
        if (!$this->isEnabled()) {
            Log::warning('LinkiuDev WhatsApp: Servicio no habilitado');
            $log->markAsFailed('Servicio WhatsApp no habilitado');
            return false;
        }

        try {
            $formattedPhone = $this->formatPhone($phone);

            // Construir placeholders para Infobip
            $placeholders = [];
            foreach ($params as $param) {
                $placeholders[] = (string) $param;
            }

            $payload = [
                'messages' => [
                    [
                        'from' => $this->whatsappSender,
                        'to' => $formattedPhone,
                        'content' => [
                            'templateName' => $templateName,
                            'templateData' => [
                                'body' => [
                                    'placeholders' => $placeholders
                                ]
                            ],
                            'language' => 'es_CO'
                        ]
                    ]
                ]
            ];

            Log::info('LinkiuDev WhatsApp: Enviando mensaje', [
                'to' => $formattedPhone,
                'from' => $this->whatsappSender,
                'template' => $templateName,
                'placeholders_count' => count($placeholders),
                'placeholders' => $placeholders,
                'payload' => $payload
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'App ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post("{$this->baseUrl}/whatsapp/1/message/template", $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                $messageId = $responseData['messages'][0]['messageId'] ?? null;

                Log::info('LinkiuDev WhatsApp: Mensaje enviado', [
                    'message_id' => $messageId,
                    'to' => $formattedPhone
                ]);

                $log->markAsSent($messageId);
                return true;
            }

            $errorMessage = $response->json()['requestError']['serviceException']['text'] 
                ?? $response->body();

            Log::error('LinkiuDev WhatsApp: Error enviando mensaje', [
                'status' => $response->status(),
                'error' => $errorMessage,
                'to' => $formattedPhone
            ]);

            $log->markAsFailed($errorMessage);
            return false;

        } catch (\Exception $e) {
            Log::error('LinkiuDev WhatsApp: Excepción', [
                'error' => $e->getMessage(),
                'to' => $phone
            ]);

            $log->markAsFailed($e->getMessage());
            return false;
        }
    }

    /**
     * Formatear número de teléfono
     */
    protected function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Si tiene 10 dígitos y empieza con 3, asumir Colombia
        if (strlen($phone) === 10 && str_starts_with($phone, '3')) {
            return '57' . $phone;
        }

        // Si ya tiene código de país
        if (strlen($phone) >= 11) {
            return $phone;
        }

        return $phone;
    }

    /**
     * Procesar respuesta de webhook (para marcar tareas como completadas)
     */
    public function processWebhookResponse(string $messageId, string $phone, string $response): array
    {
        $result = [
            'success' => false,
            'action' => null,
            'message' => '',
        ];

        // Buscar el log original
        $originalLog = DevNotificationLog::where('message_id', $messageId)->first();

        if (!$originalLog) {
            $result['message'] = 'Mensaje original no encontrado';
            return $result;
        }

        // Normalizar respuesta
        $response = strtolower(trim($response));

        // Interpretar respuesta
        if (in_array($response, ['✅', 'ok', 'completada', 'listo', 'done', '1'])) {
            // Marcar tarea como completada
            if ($originalLog->task_id) {
                $task = DevTask::find($originalLog->task_id);
                if ($task) {
                    $task->markAsCompleted();
                    $result['success'] = true;
                    $result['action'] = 'task_completed';
                    $result['message'] = "Tarea '{$task->name}' marcada como completada";
                }
            }
        } elseif (in_array($response, ['⏸️', 'posponer', 'later', '2'])) {
            // Posponer 30 minutos
            if ($originalLog->task_id) {
                $task = DevTask::find($originalLog->task_id);
                if ($task && $task->scheduled_start_time) {
                    $newStartTime = Carbon::parse($task->scheduled_start_time)->addMinutes(30);
                    $newEndTime = $task->scheduled_end_time 
                        ? Carbon::parse($task->scheduled_end_time)->addMinutes(30)
                        : null;

                    $task->update([
                        'scheduled_start_time' => $newStartTime->format('H:i'),
                        'scheduled_end_time' => $newEndTime?->format('H:i'),
                        'reminder_sent' => false,
                    ]);

                    $result['success'] = true;
                    $result['action'] = 'task_postponed';
                    $result['message'] = "Tarea '{$task->name}' pospuesta 30 minutos";
                }
            }
        }

        // Registrar la respuesta del webhook
        DevNotificationLog::createLog(
            DevNotificationLog::TYPE_WEBHOOK_RESPONSE,
            $phone,
            DevNotificationLog::RECIPIENT_ADMIN,
            [
                'original_message_id' => $messageId,
                'response' => $response,
                'action' => $result['action'],
            ],
            $originalLog->project_id,
            $originalLog->task_id
        );

        return $result;
    }
}
