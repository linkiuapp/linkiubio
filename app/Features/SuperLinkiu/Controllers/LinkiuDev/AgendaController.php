<?php

namespace App\Features\SuperLinkiu\Controllers\LinkiuDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\DevAgendaEntry;
use App\Features\SuperLinkiu\Models\DevTask;
use App\Features\SuperLinkiu\Models\DevProject;
use App\Features\SuperLinkiu\Models\DevClient;
use App\Features\SuperLinkiu\Models\DevNotificationSetting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendaController extends Controller
{
    /**
     * Vista principal del calendario
     */
    public function index(Request $request)
    {
        // Obtener la fecha actual o la solicitada
        $currentDate = $request->filled('date') 
            ? Carbon::parse($request->date) 
            : now();

        // Vista por defecto: semanal
        $view = $request->get('view', 'week');

        // Obtener proyectos y clientes para los selectores
        $projects = DevProject::active()->orderBy('name')->get();
        $clients = DevClient::active()->orderBy('name')->get();
        $settings = DevNotificationSetting::getInstance();

        return view('superlinkiu::linkiudev.agenda.index', compact(
            'currentDate',
            'view',
            'projects',
            'clients',
            'settings'
        ));
    }

    /**
     * Obtener datos del calendario (AJAX)
     */
    public function calendarData(Request $request)
    {
        $startDate = Carbon::parse($request->start);
        $endDate = Carbon::parse($request->end);

        $events = [];

        // Obtener entradas de agenda
        $agendaEntries = DevAgendaEntry::with(['project', 'client'])
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        foreach ($agendaEntries as $entry) {
            $events[] = [
                'id' => 'agenda_' . $entry->id,
                'title' => $entry->title,
                'start' => $entry->is_all_day 
                    ? $entry->date->format('Y-m-d')
                    : $entry->date->format('Y-m-d') . 'T' . $entry->start_time,
                'end' => $entry->end_time && !$entry->is_all_day
                    ? $entry->date->format('Y-m-d') . 'T' . $entry->end_time
                    : null,
                'allDay' => $entry->is_all_day,
                'backgroundColor' => $entry->default_color,
                'borderColor' => $entry->default_color,
                'extendedProps' => [
                    'type' => 'agenda_entry',
                    'entry_type' => $entry->type,
                    'description' => $entry->description,
                    'location' => $entry->location,
                    'project_name' => $entry->project?->name,
                    'client_name' => $entry->client?->name,
                    'reminder_minutes' => $entry->reminder_minutes,
                ],
            ];
        }

        // Obtener tareas programadas (incluyendo completadas)
        $tasks = DevTask::with(['project.client'])
            ->whereNotNull('scheduled_date')
            ->whereBetween('scheduled_date', [$startDate, $endDate])
            ->whereNotIn('status', ['cancelled']) // Excluir solo canceladas
            ->get();

        foreach ($tasks as $task) {
            // Determinar color según estado
            if ($task->status === 'completed') {
                // Completadas: verde opaco
                $taskColor = 'rgba(34, 197, 94, 0.5)'; // green-500 con opacidad
                $borderColor = '#22c55e';
            } elseif ($task->scheduled_date->isPast() && !in_array($task->status, ['completed', 'cancelled'])) {
                // Vencidas no completadas: rojo opaco
                $taskColor = 'rgba(239, 68, 68, 0.5)'; // red-500 con opacidad
                $borderColor = '#ef4444';
            } else {
                // Pendientes/En progreso: color según prioridad
                $taskColor = match($task->priority) {
                    'high' => '#ef4444',
                    'medium' => '#f59e0b',
                    'low' => '#6b7280',
                    default => '#3b82f6',
                };
                $borderColor = $taskColor;
            }

            $events[] = [
                'id' => 'task_' . $task->id,
                'title' => ($task->status === 'completed' ? '✅ ' : '📋 ') . $task->name,
                'start' => $task->scheduled_start_time 
                    ? $task->scheduled_date->format('Y-m-d') . 'T' . $task->scheduled_start_time
                    : $task->scheduled_date->format('Y-m-d'),
                'end' => $task->scheduled_end_time 
                    ? $task->scheduled_date->format('Y-m-d') . 'T' . $task->scheduled_end_time
                    : null,
                'allDay' => !$task->scheduled_start_time,
                'backgroundColor' => $taskColor,
                'borderColor' => $borderColor,
                'extendedProps' => [
                    'type' => 'task',
                    'status' => $task->status,
                    'status_label' => $task->status_label,
                    'priority' => $task->priority,
                    'priority_label' => $task->priority_label,
                    'description' => $task->description,
                    'project_name' => $task->project?->name,
                    'client_name' => $task->project?->client?->name,
                    'reminder_minutes' => $task->reminder_minutes,
                ],
            ];
        }

        return response()->json($events);
    }

    /**
     * Crear entrada de agenda
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:meeting,reminder,task,call,other',
            'date' => 'required|date',
            'start_time' => 'required_unless:is_all_day,true|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'project_id' => 'nullable|exists:dev_projects,id',
            'client_id' => 'nullable|exists:dev_clients,id',
            'reminder_minutes' => 'nullable|integer|min:5|max:1440',
            'color' => 'nullable|string|max:7',
            'is_all_day' => 'boolean',
        ]);

        $validated['is_all_day'] = $request->boolean('is_all_day');
        
        if ($validated['is_all_day']) {
            $validated['start_time'] = '00:00';
            $validated['end_time'] = null;
        }

        $entry = DevAgendaEntry::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Evento creado correctamente.',
                'entry' => $entry->load(['project', 'client'])
            ]);
        }

        return back()->with('success', 'Evento creado correctamente.');
    }

    /**
     * Actualizar entrada de agenda
     */
    public function update(Request $request, DevAgendaEntry $entry)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:meeting,reminder,task,call,other',
            'date' => 'required|date',
            'start_time' => 'required_unless:is_all_day,true|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'project_id' => 'nullable|exists:dev_projects,id',
            'client_id' => 'nullable|exists:dev_clients,id',
            'reminder_minutes' => 'nullable|integer|min:5|max:1440',
            'color' => 'nullable|string|max:7',
            'is_all_day' => 'boolean',
        ]);

        $validated['is_all_day'] = $request->boolean('is_all_day');
        
        if ($validated['is_all_day']) {
            $validated['start_time'] = '00:00';
            $validated['end_time'] = null;
        }

        // Resetear recordatorio si cambió la fecha/hora
        if ($entry->date != $validated['date'] || $entry->start_time != ($validated['start_time'] ?? null)) {
            $validated['reminder_sent'] = false;
        }

        $entry->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Evento actualizado correctamente.',
                'entry' => $entry->fresh()->load(['project', 'client'])
            ]);
        }

        return back()->with('success', 'Evento actualizado correctamente.');
    }

    /**
     * Eliminar entrada de agenda
     */
    public function destroy(DevAgendaEntry $entry)
    {
        $entry->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Evento eliminado correctamente.'
            ]);
        }

        return back()->with('success', 'Evento eliminado correctamente.');
    }

    /**
     * Obtener agenda de hoy (para widget)
     */
    public function today()
    {
        $today = today();

        // Entradas de agenda de hoy
        $agendaEntries = DevAgendaEntry::with(['project', 'client'])
            ->today()
            ->orderBy('start_time')
            ->get();

        // Tareas programadas para hoy
        $tasks = DevTask::with(['project.client'])
            ->scheduledToday()
            ->active()
            ->orderBy('scheduled_start_time')
            ->get();

        // Combinar y ordenar por hora
        $allEvents = collect();

        foreach ($agendaEntries as $entry) {
            $allEvents->push([
                'type' => 'agenda',
                'id' => $entry->id,
                'title' => $entry->title,
                'time' => $entry->is_all_day ? 'Todo el día' : $entry->time_range,
                'start_time' => $entry->start_time,
                'description' => $entry->description,
                'entry_type' => $entry->type,
                'color' => $entry->default_color,
                'project' => $entry->project?->name,
                'client' => $entry->client?->name,
            ]);
        }

        foreach ($tasks as $task) {
            $allEvents->push([
                'type' => 'task',
                'id' => $task->id,
                'title' => $task->name,
                'time' => $task->scheduled_time_range ?? 'Sin hora',
                'start_time' => $task->scheduled_start_time,
                'description' => $task->description,
                'status' => $task->status,
                'priority' => $task->priority,
                'project' => $task->project?->name,
                'client' => $task->project?->client?->name,
            ]);
        }

        // Ordenar por hora de inicio
        $sortedEvents = $allEvents->sortBy(function ($event) {
            if ($event['time'] === 'Todo el día' || $event['time'] === 'Sin hora') {
                return '00:00';
            }
            return $event['start_time'] ?? '00:00';
        })->values();

        if (request()->wantsJson()) {
            return response()->json([
                'date' => $today->format('Y-m-d'),
                'events' => $sortedEvents
            ]);
        }

        return view('superlinkiu::linkiudev.agenda.today', [
            'date' => $today,
            'events' => $sortedEvents
        ]);
    }
}
