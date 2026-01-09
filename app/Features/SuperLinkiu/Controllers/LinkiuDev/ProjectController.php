<?php

namespace App\Features\SuperLinkiu\Controllers\LinkiuDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\DevClient;
use App\Features\SuperLinkiu\Models\DevProject;
use App\Features\SuperLinkiu\Models\DevNotificationSetting;
use App\Features\SuperLinkiu\Services\LinkiuDev\DevWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Listar todos los proyectos
     */
    public function index(Request $request)
    {
        $query = DevProject::with('client')->withCount('tasks');

        // Búsqueda
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Filtro por prioridad
        if ($request->filled('priority')) {
            $query->priority($request->priority);
        }

        // Filtro por cliente
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Ordenamiento
        $sortField = $request->get('sort', 'updated_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $projects = $query->paginate(15)->withQueryString();
        $clients = DevClient::active()->orderBy('name')->get();

        return view('superlinkiu::linkiudev.projects.index', compact('projects', 'clients'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request)
    {
        $clients = DevClient::active()->orderBy('name')->get();
        $selectedClientId = $request->get('client_id');

        return view('superlinkiu::linkiudev.projects.create', compact('clients', 'selectedClientId'));
    }

    /**
     * Guardar nuevo proyecto
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:dev_clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:pending,in_progress,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'notify_client_on_status_change' => 'boolean',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $validated['notify_client_on_status_change'] = $request->boolean('notify_client_on_status_change');

        $project = DevProject::create($validated);

        Log::info('LinkiuDev: Proyecto creado', [
            'project_id' => $project->id,
            'name' => $project->name,
            'client_id' => $project->client_id
        ]);

        return redirect()
            ->route('superlinkiu.linkiudev.projects.show', $project)
            ->with('success', 'Proyecto creado correctamente.');
    }

    /**
     * Ver detalle del proyecto
     */
    public function show(DevProject $project)
    {
        $project->load([
            'client',
            'tasks' => function ($q) {
                $q->with('subtasks')->orderBy('order');
            },
            'agendaEntries' => function ($q) {
                $q->where('date', '>=', today())->orderBy('date')->take(10);
            },
            'notificationLogs' => function ($q) {
                $q->orderBy('created_at', 'desc')->take(10);
            }
        ]);

        return view('superlinkiu::linkiudev.projects.show', compact('project'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(DevProject $project)
    {
        $clients = DevClient::active()->orderBy('name')->get();

        return view('superlinkiu::linkiudev.projects.edit', compact('project', 'clients'));
    }

    /**
     * Actualizar proyecto
     */
    public function update(Request $request, DevProject $project)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:dev_clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|in:pending,in_progress,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'notify_client_on_status_change' => 'boolean',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $oldStatus = $project->status;
        $validated['notify_client_on_status_change'] = $request->boolean('notify_client_on_status_change');

        // Si el estado cambió a completado, registrar la fecha
        if ($validated['status'] === 'completed' && $oldStatus !== 'completed') {
            $validated['completed_at'] = now();
        } elseif ($validated['status'] !== 'completed') {
            $validated['completed_at'] = null;
        }

        $project->update($validated);

        // Notificar al cliente si cambió el estado y está habilitado
        if ($oldStatus !== $validated['status'] && $project->notify_client_on_status_change) {
            $this->sendStatusChangeNotification($project, $oldStatus, $validated['status']);
        }

        Log::info('LinkiuDev: Proyecto actualizado', [
            'project_id' => $project->id,
            'old_status' => $oldStatus,
            'new_status' => $validated['status']
        ]);

        return redirect()
            ->route('superlinkiu.linkiudev.projects.show', $project)
            ->with('success', 'Proyecto actualizado correctamente.');
    }

    /**
     * Eliminar proyecto
     */
    public function destroy(DevProject $project)
    {
        $projectName = $project->name;

        // Verificar si tiene tareas
        if ($project->tasks()->exists()) {
            return back()->with('error', 'No se puede eliminar un proyecto con tareas. Elimina primero las tareas.');
        }

        $project->delete();

        Log::info('LinkiuDev: Proyecto eliminado', ['project_name' => $projectName]);

        return redirect()
            ->route('superlinkiu.linkiudev.projects.index')
            ->with('success', "Proyecto '{$projectName}' eliminado correctamente.");
    }

    /**
     * Actualizar estado del proyecto (AJAX)
     */
    public function updateStatus(Request $request, DevProject $project)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,on_hold,completed,cancelled',
        ]);

        $oldStatus = $project->status;
        $newStatus = $validated['status'];

        $updateData = ['status' => $newStatus];

        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $updateData['completed_at'] = now();
        } elseif ($newStatus !== 'completed') {
            $updateData['completed_at'] = null;
        }

        $project->update($updateData);

        // Notificar al cliente si está habilitado
        if ($oldStatus !== $newStatus && $project->notify_client_on_status_change) {
            $this->sendStatusChangeNotification($project, $oldStatus, $newStatus);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente.',
                'project' => $project->fresh()
            ]);
        }

        return back()->with('success', 'Estado del proyecto actualizado.');
    }

    /**
     * Notificar manualmente al cliente sobre el proyecto
     */
    public function notifyClient(Request $request, DevProject $project)
    {
        $validated = $request->validate([
            'message' => 'nullable|string|max:500',
        ]);

        $settings = DevNotificationSetting::getInstance();
        
        if (!$settings->areClientNotificationsEnabled()) {
            return back()->with('error', 'Las notificaciones a clientes están deshabilitadas.');
        }

        try {
            $whatsappService = app(DevWhatsAppService::class);
            $whatsappService->sendProjectUpdateToClient(
                $project,
                $validated['message'] ?? null
            );

            return back()->with('success', 'Notificación enviada al cliente.');
        } catch (\Exception $e) {
            Log::error('LinkiuDev: Error enviando notificación al cliente', [
                'project_id' => $project->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Error al enviar la notificación: ' . $e->getMessage());
        }
    }

    /**
     * Enviar notificación de cambio de estado
     */
    protected function sendStatusChangeNotification(DevProject $project, string $oldStatus, string $newStatus): void
    {
        $settings = DevNotificationSetting::getInstance();
        
        if (!$settings->areClientNotificationsEnabled()) {
            return;
        }

        try {
            $whatsappService = app(DevWhatsAppService::class);
            $whatsappService->sendProjectStatusChange($project, $oldStatus, $newStatus);
        } catch (\Exception $e) {
            Log::error('LinkiuDev: Error enviando notificación de cambio de estado', [
                'project_id' => $project->id,
                'error' => $e->getMessage()
            ]);
        }
    }
}
