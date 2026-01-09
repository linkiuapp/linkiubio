@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - ' . $task->name)

@section('content')
<div class="container-fluid max-w-4xl">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('superlinkiu.linkiudev.projects.show', $task->project) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <div>
                <h1 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2 {{ $task->status === 'completed' ? 'line-through text-gray-500' : '' }}">
                    {{ $task->name }}
                </h1>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <a href="{{ route('superlinkiu.linkiudev.projects.show', $task->project) }}" class="hover:text-primary-300">{{ $task->project?->name }}</a>
                    <span>•</span>
                    <span>{{ $task->project?->client?->name }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('superlinkiu.linkiudev.tasks.edit', $task) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                Editar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info Principal --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Estado y Prioridad --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <div class="flex flex-wrap gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Estado</p>
                        <span class="px-3 py-1 text-sm rounded-full bg-{{ $task->status_color }}-100 text-{{ $task->status_color }}-800 dark:bg-{{ $task->status_color }}-900/30 dark:text-{{ $task->status_color }}-300">
                            {{ $task->status_label }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Prioridad</p>
                        <span class="px-3 py-1 text-sm rounded-full bg-{{ $task->priority === 'high' ? 'red' : ($task->priority === 'medium' ? 'yellow' : 'gray') }}-100 text-{{ $task->priority === 'high' ? 'red' : ($task->priority === 'medium' ? 'yellow' : 'gray') }}-800">
                            {{ $task->priority_label }}
                        </span>
                    </div>
                    @if($task->scheduled_date)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Programada</p>
                        <span class="text-sm text-gray-900 dark:text-white">
                            📅 {{ $task->scheduled_date->format('d/m/Y') }} {{ $task->scheduled_time_range }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Descripción --}}
            @if($task->description)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Descripción</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $task->description }}</p>
            </div>
            @endif

            {{-- Subtareas --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                        Subtareas ({{ $task->subtasks->where('is_completed', true)->count() }}/{{ $task->subtasks->count() }})
                    </h3>
                    <button type="button" onclick="showAddSubtask()" class="text-sm text-primary-300 hover:underline">
                        + Agregar
                    </button>
                </div>

                {{-- Formulario para nueva subtarea --}}
                <form id="add-subtask-form" action="{{ route('superlinkiu.linkiudev.tasks.subtasks.store', $task) }}" method="POST" class="hidden mb-4">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="name" placeholder="Nueva subtarea..." class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <button type="submit" class="px-4 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg text-sm">Agregar</button>
                        <button type="button" onclick="hideAddSubtask()" class="px-4 py-2 text-gray-500 hover:text-gray-700">Cancelar</button>
                    </div>
                </form>

                @if($task->subtasks->isEmpty())
                    <p class="text-sm text-gray-500 dark:text-gray-400">No hay subtareas</p>
                @else
                    <div class="space-y-2">
                        @foreach($task->subtasks as $subtask)
                            <div class="flex items-center gap-3 p-2 bg-gray-50 dark:bg-gray-700/50 rounded">
                                <button 
                                    type="button"
                                    onclick="toggleSubtask({{ $subtask->id }})"
                                    class="w-5 h-5 rounded border-2 flex items-center justify-center transition-colors {{ $subtask->is_completed ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 dark:border-gray-600 hover:border-primary-300' }}"
                                >
                                    @if($subtask->is_completed)
                                        <i data-lucide="check" class="w-3 h-3"></i>
                                    @endif
                                </button>
                                <span class="flex-1 text-sm {{ $subtask->is_completed ? 'line-through text-gray-400' : 'text-gray-900 dark:text-white' }}">
                                    {{ $subtask->name }}
                                </span>
                                <form action="{{ route('superlinkiu.linkiudev.tasks.subtasks.destroy', $subtask) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Acciones rápidas --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Acciones</h3>
                <div class="space-y-2">
                    @if($task->status !== 'completed')
                        <button onclick="toggleTaskStatus({{ $task->id }}, '{{ $task->status }}')" class="w-full px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm flex items-center justify-center gap-2">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            Marcar Completada
                        </button>
                    @else
                        <button onclick="toggleTaskStatus({{ $task->id }}, '{{ $task->status }}')" class="w-full px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm flex items-center justify-center gap-2">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                            Reabrir Tarea
                        </button>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Información</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-gray-400">Creada</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $task->created_at->format('d/m/Y') }}</dd>
                    </div>
                    @if($task->completed_at)
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-gray-400">Completada</dt>
                        <dd class="text-green-600">{{ $task->completed_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-gray-500 dark:text-gray-400">Notificar cliente</dt>
                        <dd class="text-gray-900 dark:text-white">{{ $task->notify_on_complete ? 'Sí' : 'No' }}</dd>
                    </div>
                </dl>
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

function showAddSubtask() {
    document.getElementById('add-subtask-form').classList.remove('hidden');
}

function hideAddSubtask() {
    document.getElementById('add-subtask-form').classList.add('hidden');
}

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
    });
}

function toggleSubtask(subtaskId) {
    fetch(`/superlinkiu/linkiudev/tasks/subtasks/${subtaskId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endpush
