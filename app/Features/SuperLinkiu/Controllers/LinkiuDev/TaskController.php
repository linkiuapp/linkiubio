<?php

namespace App\Features\SuperLinkiu\Controllers\LinkiuDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\DevProject;
use App\Features\SuperLinkiu\Models\DevTask;
use App\Features\SuperLinkiu\Models\DevSubtask;
use App\Features\SuperLinkiu\Models\DevNotificationSetting;
use App\Features\SuperLinkiu\Services\LinkiuDev\DevWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Listar todas las tareas
     */
    public function index(Request $request)
    {
        $query = DevTask::with(['project.client', 'subtasks']);

        // Búsqueda
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Filtro por proyecto
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Filtro por prioridad
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filtro: solo tareas programadas
        if ($request->boolean('scheduled_only')) {
            $query->scheduled();
        }

        // Filtro: tareas de hoy
        if ($request->boolean('today_only')) {
            $query->scheduledToday();
        }

        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $tasks = $query->paginate(20)->withQueryString();
        $projects = DevProject::with('client')->active()->orderBy('name')->get();

        return view('superlinkiu::linkiudev.tasks.index', compact('tasks', 'projects'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request)
    {
        $projects = DevProject::with('client')->active()->orderBy('name')->get();
        $selectedProjectId = $request->get('project_id');
        $settings = DevNotificationSetting::getInstance();

        return view('superlinkiu::linkiudev.tasks.create', compact('projects', 'selectedProjectId', 'settings'));
    }

    /**
     * Guardar nueva tarea
     */
    public function store(Request $request)
    {
        // Filtrar subtareas vacías antes de validar
        if ($request->has('subtasks')) {
            $subtasks = array_filter($request->input('subtasks'), function ($value) {
                return !empty(trim($value ?? ''));
            });
            $request->merge(['subtasks' => array_values($subtasks)]);
        }

        $validated = $request->validate([
            'project_id' => 'required|exists:dev_projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:pending,in_progress,review,completed,cancelled',
            'priority' => 'required|in:low,medium,high',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'scheduled_date' => 'nullable|date',
            'scheduled_start_time' => 'nullable|date_format:H:i',
            'scheduled_end_time' => 'nullable|date_format:H:i|after:scheduled_start_time',
            'reminder_minutes' => 'nullable|integer|min:5|max:1440',
            'notify_on_complete' => 'boolean',
            'subtasks' => 'nullable|array',
            'subtasks.*' => 'nullable|string|max:255',
        ]);

        $validated['notify_on_complete'] = $request->boolean('notify_on_complete');
        
        // Obtener el orden máximo actual
        $maxOrder = DevTask::where('project_id', $validated['project_id'])->max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;

        // Extraer subtareas antes de crear la tarea
        $subtasksData = $validated['subtasks'] ?? [];
        unset($validated['subtasks']);

        $task = DevTask::create($validated);

        // Crear subtareas si existen
        if (!empty($subtasksData)) {
            foreach ($subtasksData as $index => $subtaskName) {
                if (!empty(trim($subtaskName))) {
                    $task->subtasks()->create([
                        'name' => trim($subtaskName),
                        'order' => $index,
                    ]);
                }
            }
        }

        Log::info('LinkiuDev: Tarea creada', [
            'task_id' => $task->id,
            'project_id' => $task->project_id,
            'name' => $task->name
        ]);

        // Redirigir según el contexto
        if ($request->has('redirect_to_project')) {
            return redirect()
                ->route('superlinkiu.linkiudev.projects.show', $task->project_id)
                ->with('success', 'Tarea creada correctamente.');
        }

        return redirect()
            ->route('superlinkiu.linkiudev.tasks.show', $task)
            ->with('success', 'Tarea creada correctamente.');
    }

    /**
     * Ver detalle de la tarea
     */
    public function show(DevTask $task)
    {
        $task->load(['project.client', 'subtasks', 'notificationLogs']);

        return view('superlinkiu::linkiudev.tasks.show', compact('task'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(DevTask $task)
    {
        $projects = DevProject::with('client')->active()->orderBy('name')->get();
        $settings = DevNotificationSetting::getInstance();

        return view('superlinkiu::linkiudev.tasks.edit', compact('task', 'projects', 'settings'));
    }

    /**
     * Actualizar tarea
     */
    public function update(Request $request, DevTask $task)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:dev_projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:pending,in_progress,review,completed,cancelled',
            'priority' => 'required|in:low,medium,high',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'scheduled_date' => 'nullable|date',
            'scheduled_start_time' => 'nullable|date_format:H:i',
            'scheduled_end_time' => 'nullable|date_format:H:i|after:scheduled_start_time',
            'reminder_minutes' => 'nullable|integer|min:5|max:1440',
            'notify_on_complete' => 'boolean',
        ]);

        $oldStatus = $task->status;
        $validated['notify_on_complete'] = $request->boolean('notify_on_complete');

        // Si el estado cambió a completado, registrar la fecha
        if ($validated['status'] === 'completed' && $oldStatus !== 'completed') {
            $validated['completed_at'] = now();
            
            // Notificar al cliente si está habilitado
            if ($task->notify_on_complete) {
                $this->sendTaskCompletedNotification($task);
            }
        } elseif ($validated['status'] !== 'completed') {
            $validated['completed_at'] = null;
        }

        // Resetear el flag de recordatorio si cambia la fecha/hora
        if ($task->scheduled_date != ($validated['scheduled_date'] ?? null) ||
            $task->scheduled_start_time != ($validated['scheduled_start_time'] ?? null)) {
            $validated['reminder_sent'] = false;
        }

        $task->update($validated);

        Log::info('LinkiuDev: Tarea actualizada', [
            'task_id' => $task->id,
            'old_status' => $oldStatus,
            'new_status' => $validated['status']
        ]);

        return redirect()
            ->route('superlinkiu.linkiudev.tasks.show', $task)
            ->with('success', 'Tarea actualizada correctamente.');
    }

    /**
     * Eliminar tarea
     */
    public function destroy(DevTask $task)
    {
        $taskName = $task->name;
        $projectId = $task->project_id;

        // Primero eliminar las subtareas
        $task->subtasks()->delete();
        $task->delete();

        Log::info('LinkiuDev: Tarea eliminada', ['task_name' => $taskName]);

        // Redirigir según de dónde venga
        $referer = request()->headers->get('referer');
        if ($referer && str_contains($referer, '/tasks')) {
            return redirect()
                ->route('superlinkiu.linkiudev.tasks.index')
                ->with('success', "Tarea '{$taskName}' eliminada correctamente.");
        }

        return redirect()
            ->route('superlinkiu.linkiudev.projects.show', $projectId)
            ->with('success', "Tarea '{$taskName}' eliminada correctamente.");
    }

    /**
     * Actualizar estado de la tarea (AJAX)
     */
    public function updateStatus(Request $request, DevTask $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,review,completed,cancelled',
        ]);

        $oldStatus = $task->status;
        $newStatus = $validated['status'];

        // Si el estado no cambió, no hacer nada
        if ($oldStatus === $newStatus) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sin cambios.',
                    'task' => $task->load('subtasks')
                ]);
            }
            return back();
        }

        $updateData = ['status' => $newStatus];

        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $updateData['completed_at'] = now();
        } elseif ($newStatus !== 'completed') {
            $updateData['completed_at'] = null;
        }

        $task->update($updateData);

        // Notificar al cliente sobre el cambio de estado
        $this->notifyClientStatusChange($task, $oldStatus, $newStatus);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente.',
                'task' => $task->fresh()->load('subtasks')
            ]);
        }

        return back()->with('success', 'Estado de la tarea actualizado.');
    }

    /**
     * Notificar al cliente sobre cambio de estado
     */
    protected function notifyClientStatusChange(DevTask $task, string $oldStatus, string $newStatus): void
    {
        try {
            $settings = DevNotificationSetting::getInstance();
            
            // Verificar si las notificaciones al cliente están habilitadas
            if (!$settings->areClientNotificationsEnabled()) {
                Log::info('LinkiuDev: Notificaciones a clientes deshabilitadas');
                return;
            }

            $project = $task->project;
            $client = $project?->client;

            // Verificar que hay cliente con teléfono
            if (!$client || empty($client->phone)) {
                Log::info('LinkiuDev: Cliente sin teléfono, no se envía notificación', [
                    'task_id' => $task->id
                ]);
                return;
            }

            $whatsappService = app(DevWhatsAppService::class);

            // Preparar mensaje según el nuevo estado
            $statusMessages = [
                'in_progress' => "La tarea '{$task->name}' ha comenzado 🚀",
                'review' => "La tarea '{$task->name}' está en revisión 🔍",
                'completed' => "La tarea '{$task->name}' ha sido completada ✅",
            ];

            // Solo notificar para estados relevantes
            if (!isset($statusMessages[$newStatus])) {
                return;
            }

            $result = $whatsappService->sendProjectUpdateToClient(
                $project,
                $statusMessages[$newStatus]
            );

            Log::info('LinkiuDev: Notificación de cambio de estado enviada', [
                'task_id' => $task->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'client_id' => $client->id,
                'result' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('LinkiuDev: Error enviando notificación de cambio de estado', [
                'task_id' => $task->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Programar tarea en agenda (AJAX)
     */
    public function schedule(Request $request, DevTask $task)
    {
        $validated = $request->validate([
            'scheduled_date' => 'required|date',
            'scheduled_start_time' => 'required|date_format:H:i',
            'scheduled_end_time' => 'nullable|date_format:H:i|after:scheduled_start_time',
            'reminder_minutes' => 'nullable|integer|min:5|max:1440',
        ]);

        $validated['reminder_sent'] = false;

        $task->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Tarea programada correctamente.',
                'task' => $task->fresh()
            ]);
        }

        return back()->with('success', 'Tarea programada en la agenda.');
    }

    /**
     * Reordenar tareas (AJAX)
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|exists:dev_tasks,id',
            'tasks.*.order' => 'required|integer|min:0',
        ]);

        foreach ($validated['tasks'] as $taskData) {
            DevTask::where('id', $taskData['id'])->update(['order' => $taskData['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Orden actualizado.']);
    }

    /**
     * Crear subtarea
     */
    public function storeSubtask(Request $request, DevTask $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $maxOrder = $task->subtasks()->max('order') ?? 0;

        $subtask = $task->subtasks()->create([
            'name' => $validated['name'],
            'order' => $maxOrder + 1,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'subtask' => $subtask
            ]);
        }

        return back()->with('success', 'Subtarea agregada.');
    }

    /**
     * Actualizar subtarea
     */
    public function updateSubtask(Request $request, DevSubtask $subtask)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subtask->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'subtask' => $subtask
            ]);
        }

        return back()->with('success', 'Subtarea actualizada.');
    }

    /**
     * Eliminar subtarea
     */
    public function destroySubtask(DevSubtask $subtask)
    {
        $subtask->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Subtarea eliminada.');
    }

    /**
     * Toggle estado de subtarea
     */
    public function toggleSubtask(DevSubtask $subtask)
    {
        $subtask->toggle();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'subtask' => $subtask
            ]);
        }

        return back();
    }

    /**
     * Enviar notificación de tarea completada
     */
    protected function sendTaskCompletedNotification(DevTask $task): void
    {
        $settings = DevNotificationSetting::getInstance();
        
        if (!$settings->areClientNotificationsEnabled()) {
            return;
        }

        try {
            $whatsappService = app(DevWhatsAppService::class);
            $whatsappService->sendTaskCompletedToClient($task);
        } catch (\Exception $e) {
            Log::error('LinkiuDev: Error enviando notificación de tarea completada', [
                'task_id' => $task->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
