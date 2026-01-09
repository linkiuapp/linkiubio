@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">LinkiuDev - Dashboard</h1>
            <p class="text-sm text-gray-600 mt-1">Gestión de proyectos de desarrollo</p>
        </div>
        <a href="{{ route('superlinkiu.linkiudev.projects.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nuevo Proyecto
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Clientes</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['total_clients'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Proyectos Activos</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['active_projects'] }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i data-lucide="folder-kanban" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Tareas Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_tasks'] }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i data-lucide="list-checks" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Agenda Hoy</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['today_events'] }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i data-lucide="calendar-days" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid principal --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Tareas de Hoy --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-blue-600"></i>
                    Agenda de Hoy
                </h2>
                <a href="{{ route('superlinkiu.linkiudev.agenda.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todo →
                </a>
            </div>
            <div class="p-6">
                @if($todayTasks->isEmpty() && $todayEvents->isEmpty())
                    <div class="text-center py-8">
                        <i data-lucide="calendar-check" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                        <p class="text-sm text-gray-500">No hay eventos ni tareas para hoy</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($todayEvents as $event)
                            <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg">
                                <div class="flex-shrink-0 w-16 text-center">
                                    <span class="text-xs font-medium text-blue-600">
                                        {{ $event->is_all_day ? 'Todo el día' : \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $event->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $event->type_label }}</p>
                                </div>
                            </div>
                        @endforeach
                        @foreach($todayTasks as $task)
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0 w-16 text-center">
                                    <span class="text-xs font-medium text-gray-600">
                                        {{ $task->scheduled_start_time ? \Carbon\Carbon::parse($task->scheduled_start_time)->format('H:i') : '--:--' }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">📋 {{ $task->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $task->project?->name }}</p>
                                </div>
                                @php
                                    $priorityColor = $task->priority === 'high' ? 'red' : ($task->priority === 'medium' ? 'yellow' : 'gray');
                                @endphp
                                <span class="px-2 py-1 text-xs rounded-full bg-{{ $priorityColor }}-100 text-{{ $priorityColor }}-800">
                                    {{ $task->priority_label }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Proyectos Activos --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="folder-git-2" class="w-5 h-5 text-green-600"></i>
                    Proyectos en Progreso
                </h2>
                <a href="{{ route('superlinkiu.linkiudev.projects.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Ver todos →
                </a>
            </div>
            <div class="p-6">
                @if($activeProjects->isEmpty())
                    <div class="text-center py-8">
                        <i data-lucide="folder" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                        <p class="text-sm text-gray-500 mb-2">No hay proyectos activos</p>
                        <a href="{{ route('superlinkiu.linkiudev.projects.create') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Crear proyecto →
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($activeProjects as $project)
                            <a href="{{ route('superlinkiu.linkiudev.projects.show', $project) }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $project->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $project->client?->name }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $project->status_color }}-100 text-{{ $project->status_color }}-800">
                                        {{ $project->status_label }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-600 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $project->progress_percentage }}%</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Proyectos Atrasados y Tareas Prioritarias --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Proyectos Atrasados --}}
        @if($overdueProjects->isNotEmpty())
        <div class="bg-white rounded-lg shadow-sm border-2 border-red-300 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-red-50">
                <h2 class="text-base font-semibold text-red-600 flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                    Proyectos Atrasados
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($overdueProjects as $project)
                        <a href="{{ route('superlinkiu.linkiudev.projects.show', $project) }}" class="flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $project->name }}</p>
                                <p class="text-xs text-gray-500">{{ $project->client?->name }}</p>
                            </div>
                            <span class="text-xs text-red-600 font-medium">
                                {{ abs($project->days_remaining) }} días de atraso
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Tareas de Alta Prioridad --}}
        @if($highPriorityTasks->isNotEmpty())
        <div class="bg-white rounded-lg shadow-sm border-2 border-yellow-300 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-yellow-50">
                <h2 class="text-base font-semibold text-yellow-600 flex items-center gap-2">
                    <i data-lucide="flag" class="w-5 h-5"></i>
                    Tareas de Alta Prioridad
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($highPriorityTasks as $task)
                        <a href="{{ route('superlinkiu.linkiudev.tasks.show', $task) }}" class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $task->name }}</p>
                                <p class="text-xs text-gray-500">{{ $task->project?->name }} - {{ $task->project?->client?->name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $task->status_color }}-100 text-{{ $task->status_color }}-800">
                                {{ $task->status_label }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
