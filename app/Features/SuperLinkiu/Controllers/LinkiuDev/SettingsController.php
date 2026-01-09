<?php

namespace App\Features\SuperLinkiu\Controllers\LinkiuDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\DevNotificationSetting;
use App\Features\SuperLinkiu\Models\DevNotificationLog;
use App\Features\SuperLinkiu\Services\LinkiuDev\DevWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Mostrar configuración de notificaciones
     */
    public function index()
    {
        $settings = DevNotificationSetting::getInstance();

        // Estadísticas de notificaciones
        $stats = [
            'total_sent' => DevNotificationLog::whereIn('status', ['sent', 'delivered', 'read'])->count(),
            'failed' => DevNotificationLog::status('failed')->count(),
            'today' => DevNotificationLog::whereDate('created_at', today())->count(),
            'last_7_days' => DevNotificationLog::recent(7)->count(),
        ];

        // Últimas notificaciones
        $recentLogs = DevNotificationLog::with(['project', 'task', 'client'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('superlinkiu::linkiudev.settings.index', compact('settings', 'stats', 'recentLogs'));
    }

    /**
     * Actualizar configuración
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number' => 'required|string|max:20',
            'country_code' => 'required|string|max:5',
            'daily_summary_enabled' => 'boolean',
            'daily_summary_time' => 'required|date_format:H:i',
            'task_reminders_enabled' => 'boolean',
            'default_reminder_minutes' => 'required|integer|min:5|max:1440',
            'client_notifications_enabled' => 'boolean',
        ]);

        $validated['daily_summary_enabled'] = $request->boolean('daily_summary_enabled');
        $validated['task_reminders_enabled'] = $request->boolean('task_reminders_enabled');
        $validated['client_notifications_enabled'] = $request->boolean('client_notifications_enabled');

        $settings = DevNotificationSetting::getInstance();
        $settings->update($validated);

        Log::info('LinkiuDev: Configuración de notificaciones actualizada');

        return back()->with('success', 'Configuración guardada correctamente.');
    }

    /**
     * Enviar notificación de prueba
     */
    public function testNotification(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:daily_summary,task_reminder',
        ]);

        $settings = DevNotificationSetting::getInstance();

        if (empty($settings->whatsapp_number)) {
            return back()->with('error', 'Debes configurar un número de WhatsApp primero.');
        }

        try {
            $whatsappService = app(DevWhatsAppService::class);

            if ($validated['type'] === 'daily_summary') {
                $whatsappService->sendTestDailySummary();
                $message = 'Resumen diario de prueba enviado.';
            } else {
                $whatsappService->sendTestTaskReminder();
                $message = 'Recordatorio de prueba enviado.';
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            Log::error('LinkiuDev: Error enviando notificación de prueba', [
                'type' => $validated['type'],
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Error al enviar la notificación: ' . $e->getMessage());
        }
    }

    /**
     * Ver logs de notificaciones
     */
    public function notificationLogs(Request $request)
    {
        $query = DevNotificationLog::with(['project', 'task', 'client']);

        // Filtro por tipo
        if ($request->filled('type')) {
            $query->type($request->type);
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Filtro por fecha
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(25)->withQueryString();

        return view('superlinkiu::linkiudev.settings.notification-logs', compact('logs'));
    }

    /**
     * Debug de configuración WhatsApp
     */
    public function debug()
    {
        $whatsappService = app(DevWhatsAppService::class);
        $debugInfo = $whatsappService->getDebugInfo();

        return response()->json($debugInfo, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
