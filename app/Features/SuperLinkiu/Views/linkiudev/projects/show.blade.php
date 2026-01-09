@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - ' . $project->name)

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('superlinkiu.linkiudev.projects.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <div>
                <h1 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    {{ $project->name }}
                    <span class="px-2 py-0.5 text-xs rounded-full bg-{{ $project->status_color }}-100 text-{{ $project->status_color }}-800 dark:bg-{{ $project->status_color }}-900/30 dark:text-{{ $project->status_color }}-300">
                        {{ $project->status_label }}
                    </span>
                </h1>
                <a href="{{ route('superlinkiu.linkiudev.clients.show', $project->client) }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-primary-300">
                    {{ $project->client?->name }}
                </a>
            </div>
        </div>
        <div class="flex gap-2">
            <form action="{{ route('superlinkiu.linkiudev.projects.notify-client', $project) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors flex items-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Notificar Cliente
                </button>
            </form>
            <a href="{{ route('superlinkiu.linkiudev.projects.edit', $project) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                Editar
            </a>
            <a href="{{ route('superlinkiu.linkiudev.tasks.create', ['project_id' => $project->id]) }}" class="px-4 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Nueva Tarea
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info del Proyecto --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Progreso --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Progreso</h3>
                <div class="text-center mb-4">
                    <div class="relative inline-flex items-center justify-center w-32 h-32">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="8" fill="none" class="text-gray-200 dark:text-gray-700"></circle>
                            <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="8" fill="none" 
                                    stroke-dasharray="{{ 2 * 3.14159 * 56 }}" 
                                    stroke-dashoffset="{{ 2 * 3.14159 * 56 * (1 - $project->progress_percentage / 100) }}"
                                    class="text-primary-300 transition-all duration-500"></circle>
                        </svg>
                        <span class="absolute text-2xl font-bold text-gray-900 dark:text-white">{{ $project->progress_percentage }}%</span>
                    </div>
                </div>
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">{{ $project->tasks_progress }} tareas</p>
            </div>

            {{-- Detalles --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Detalles</h3>
                <dl class="space-y-3">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Prioridad</dt>
                        <dd class="text-sm font-medium">
                            <span class="px-2 py-0.5 rounded-full bg-{{ $project->priority_color }}-100 text-{{ $project->priority_color }}-800 dark:bg-{{ $project->priority_color }}-900/30 dark:text-{{ $project->priority_color }}-300">
                                {{ $project->priority_label }}
                            </span>
                        </dd>
                    </div>
                    @if($project->start_date)
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Inicio</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $project->start_date->format('d/m/Y') }}</dd>
                    </div>
                    @endif
                    @if($project->due_date)
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Fecha límite</dt>
                        <dd class="text-sm {{ $project->is_overdue ? 'text-red-600 font-medium' : 'text-gray-900 dark:text-white' }}">
                            {{ $project->due_date->format('d/m/Y') }}
                            @if($project->is_overdue)
                                <span class="text-xs">({{ abs($project->days_remaining) }} días de atraso)</span>
                            @elseif($project->days_remaining !== null)
                                <span class="text-xs text-gray-500">({{ $project->days_remaining }} días)</span>
                            @endif
                        </dd>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Notificar cliente</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">
                            {{ $project->notify_client_on_status_change ? 'Sí' : 'No' }}
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Descripción --}}
            @if($project->description)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Descripción</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $project->description }}</p>
            </div>
            @endif
        </div>

        {{-- Tareas --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Tareas ({{ $project->tasks->count() }})
                    </h3>
                    <a href="{{ route('superlinkiu.linkiudev.tasks.create', ['project_id' => $project->id]) }}" class="text-sm text-primary-300 hover:underline flex items-center gap-1">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Agregar
                    </a>
                </div>

                @if($project->tasks->isEmpty())
                    <div class="text-center py-12">
                        <i data-lucide="list-checks" class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3"></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">No hay tareas en este proyecto</p>
                        <a href="{{ route('superlinkiu.linkiudev.tasks.create', ['project_id' => $project->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg transition-colors">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Crear Primera Tarea
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-gray-200 dark:divide-gray-700" id="tasks-list">
                        @foreach($project->tasks as $task)
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" data-task-id="{{ $task->id }}">
                                <div class="flex items-start gap-4">
                                    {{-- Status checkbox --}}
                                    <button 
                                        type="button"
                                        onclick="toggleTaskStatus({{ $task->id }}, '{{ $task->status }}')"
                                        class="mt-1 w-5 h-5 rounded border-2 flex items-center justify-center transition-colors {{ $task->status === 'completed' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 dark:border-gray-600 hover:border-primary-300' }}"
                                    >
                                        @if($task->status === 'completed')
                                            <i data-lucide="check" class="w-3 h-3"></i>
                                        @endif
                                    </button>
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <div>
                                                <a href="{{ route('superlinkiu.linkiudev.tasks.show', $task) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-primary-300 {{ $task->status === 'completed' ? 'line-through text-gray-500' : '' }}">
                                                    {{ $task->name }}
                                                </a>
                                                @if($task->scheduled_date)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        📅 {{ $task->scheduled_date->format('d/m') }} {{ $task->scheduled_time_range }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <span class="px-2 py-0.5 text-xs rounded-full bg-{{ $task->priority === 'high' ? 'red' : ($task->priority === 'medium' ? 'yellow' : 'gray') }}-100 text-{{ $task->priority === 'high' ? 'red' : ($task->priority === 'medium' ? 'yellow' : 'gray') }}-800">
                                                    {{ $task->priority_label }}
                                                </span>
                                                <a href="{{ route('superlinkiu.linkiudev.tasks.edit', $task) }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        {{-- Subtareas --}}
                                        @if($task->subtasks->isNotEmpty())
                                            <div class="mt-2 space-y-1">
                                                @foreach($task->subtasks as $subtask)
                                                    <div class="flex items-center gap-2 text-sm">
                                                        <button 
                                                            type="button"
                                                            onclick="toggleSubtask({{ $subtask->id }})"
                                                            class="w-4 h-4 rounded border flex items-center justify-center transition-colors {{ $subtask->is_completed ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 dark:border-gray-600 hover:border-primary-300' }}"
                                                        >
                                                            @if($subtask->is_completed)
                                                                <i data-lucide="check" class="w-3 h-3"></i>
                                                            @endif
                                                        </button>
                                                        <span class="{{ $subtask->is_completed ? 'line-through text-gray-400' : 'text-gray-600 dark:text-gray-400' }}">
                                                            {{ $subtask->name }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});

function toggleTaskStatus(taskId, currentStatus) {
    const newStatus = currentStatus === 'completed' ? 'pending' : 'completed';
    
    fetch(`/superlinkiu/linkiudev/tasks/${taskId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function toggleSubtask(subtaskId) {
    fetch(`/superlinkiu/linkiudev/tasks/subtasks/${subtaskId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush
