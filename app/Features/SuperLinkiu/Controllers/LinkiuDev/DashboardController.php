<?php

namespace App\Features\SuperLinkiu\Controllers\LinkiuDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\DevClient;
use App\Features\SuperLinkiu\Models\DevProject;
use App\Features\SuperLinkiu\Models\DevTask;
use App\Features\SuperLinkiu\Models\DevAgendaEntry;

class DashboardController extends Controller
{
    /**
     * Dashboard principal de LinkiuDev
     */
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_clients' => DevClient::active()->count(),
            'active_projects' => DevProject::active()->count(),
            'pending_tasks' => DevTask::active()->count(),
            'today_events' => DevAgendaEntry::today()->count() + DevTask::scheduledToday()->count(),
        ];

        // Proyectos recientes en progreso
        $activeProjects = DevProject::with('client', 'tasks')
            ->active()
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Tareas programadas para hoy
        $todayTasks = DevTask::with('project.client')
            ->scheduledToday()
            ->active()
            ->orderBy('scheduled_start_time')
            ->get();

        // Eventos de agenda de hoy
        $todayEvents = DevAgendaEntry::with('project', 'client')
            ->today()
            ->orderBy('start_time')
            ->get();

        // Proyectos atrasados
        $overdueProjects = DevProject::with('client')
            ->active()
            ->whereNotNull('due_date')
            ->where('due_date', '<', today())
            ->orderBy('due_date')
            ->take(5)
            ->get();

        // Tareas de alta prioridad pendientes
        $highPriorityTasks = DevTask::with('project.client')
            ->active()
            ->where('priority', 'high')
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('superlinkiu::linkiudev.dashboard', compact(
            'stats',
            'activeProjects',
            'todayTasks',
            'todayEvents',
            'overdueProjects',
            'highPriorityTasks'
        ));
    }
}
