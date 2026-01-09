@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Tareas')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Tareas</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona todas tus tareas</p>
        </div>
        <a href="{{ route('superlinkiu.linkiudev.tasks.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva Tarea
        </a>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form action="{{ route('superlinkiu.linkiudev.tasks.index') }}" method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Buscar tareas..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                >
            </div>
            <select name="status" class="w-auto min-w-[140px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                <option value="">Todos los estados</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                <option value="review" {{ request('status') === 'review' ? 'selected' : '' }}>En Revisión</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completada</option>
            </select>
            <select name="priority" class="w-auto min-w-[130px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                <option value="">Prioridad</option>
                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Alta</option>
                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Media</option>
                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Baja</option>
            </select>
            <select name="project_id" class="w-auto min-w-[150px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                <option value="">Todos los proyectos</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i>
                Buscar
            </button>
            @if(request()->hasAny(['search', 'status', 'priority', 'project_id']))
                <a href="{{ route('superlinkiu.linkiudev.tasks.index') }}" class="px-4 py-2.5 text-gray-600 hover:text-gray-800">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- Lista de Tareas --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($tasks->isEmpty())
            <div class="text-center py-12">
                <i data-lucide="list-checks" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay tareas</h3>
                <p class="text-sm text-gray-500 mb-4">Comienza creando tu primera tarea</p>
                <a href="{{ route('superlinkiu.linkiudev.tasks.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nueva Tarea
                </a>
            </div>
        @else
            <div class="divide-y divide-gray-200">
                @foreach($tasks as $task)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-4">
                            <button 
                                type="button"
                                onclick="toggleTaskStatus({{ $task->id }}, '{{ $task->status }}')"
                                class="mt-1 w-5 h-5 rounded border-2 flex items-center justify-center transition-colors {{ $task->status === 'completed' ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 hover:border-blue-500' }}"
                                title="{{ $task->status === 'completed' ? 'Marcar como pendiente' : 'Marcar como completada' }}"
                            >
                                @if($task->status === 'completed')
                                    <i data-lucide="check" class="w-3 h-3"></i>
                                @endif
                            </button>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <a href="{{ route('superlinkiu.linkiudev.tasks.show', $task) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 {{ $task->status === 'completed' ? 'line-through text-gray-500' : '' }}">
                                            {{ $task->name }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-1">
                                            <a href="{{ route('superlinkiu.linkiudev.projects.show', $task->project) }}" class="text-xs text-gray-500 hover:text-blue-600">
                                                {{ $task->project?->name }}
                                            </a>
                                            <span class="text-xs text-gray-400">•</span>
                                            <span class="text-xs text-gray-500">{{ $task->project?->client?->name }}</span>
                                        </div>
                                        @if($task->scheduled_date)
                                            <p class="text-xs text-blue-600 mt-1">
                                                📅 {{ $task->scheduled_date->format('d/m/Y') }} {{ $task->scheduled_time_range }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        {{-- Dropdown de estado --}}
                                        <div class="relative" x-data="{ open: false }">
                                            <button 
                                                @click="open = !open"
                                                class="px-2 py-0.5 text-xs rounded-full bg-{{ $task->status_color }}-100 text-{{ $task->status_color }}-800 hover:ring-2 hover:ring-{{ $task->status_color }}-300 cursor-pointer flex items-center gap-1"
                                            >
                                                {{ $task->status_label }}
                                                <i data-lucide="chevron-down" class="w-3 h-3"></i>
                                            </button>
                                            <div 
                                                x-show="open" 
                                                @click.away="open = false"
                                                x-transition
                                                class="absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-20"
                                            >
                                                <button onclick="updateTaskStatus({{ $task->id }}, 'pending')" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 flex items-center gap-2 {{ $task->status === 'pending' ? 'bg-gray-50 font-medium' : '' }}">
                                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span> Pendiente
                                                </button>
                                                <button onclick="updateTaskStatus({{ $task->id }}, 'in_progress')" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 flex items-center gap-2 {{ $task->status === 'in_progress' ? 'bg-gray-50 font-medium' : '' }}">
                                                    <span class="w-2 h-2 rounded-full bg-blue-400"></span> En Progreso
                                                </button>
                                                <button onclick="updateTaskStatus({{ $task->id }}, 'review')" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 flex items-center gap-2 {{ $task->status === 'review' ? 'bg-gray-50 font-medium' : '' }}">
                                                    <span class="w-2 h-2 rounded-full bg-yellow-400"></span> En Revisión
                                                </button>
                                                <button onclick="updateTaskStatus({{ $task->id }}, 'completed')" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 flex items-center gap-2 {{ $task->status === 'completed' ? 'bg-gray-50 font-medium' : '' }}">
                                                    <span class="w-2 h-2 rounded-full bg-green-400"></span> Completada
                                                </button>
                                            </div>
                                        </div>
                                        @php
                                            $priorityColor = $task->priority === 'high' ? 'red' : ($task->priority === 'medium' ? 'yellow' : 'gray');
                                        @endphp
                                        <span class="px-2 py-0.5 text-xs rounded-full bg-{{ $priorityColor }}-100 text-{{ $priorityColor }}-800">
                                            {{ $task->priority_label }}
                                        </span>
                                        <a href="{{ route('superlinkiu.linkiudev.tasks.edit', $task) }}" class="text-gray-400 hover:text-gray-600" title="Editar">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <button type="button" onclick="deleteTask({{ $task->id }}, '{{ addslashes($task->name) }}')" class="text-gray-400 hover:text-red-600" title="Eliminar">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($tasks->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $tasks->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

{{-- Modal de Eliminación --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-red-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">¿Eliminar tarea?</h3>
                        <p class="text-sm text-gray-600 mt-2">
                            Se eliminará la tarea "<span id="taskName" class="font-medium"></span>" de forma permanente. Esta acción no se puede deshacer.
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 rounded-b-xl">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                    Cancelar
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                        Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Toast de éxito --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.success('¡Listo!', '{{ session('success') }}', 5000, 'bottom-center');
    }
});
</script>
@endif

<script>
function updateTaskStatus(taskId, newStatus) {
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
        } else {
            alert('Error al actualizar el estado');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el estado');
    });
}

function toggleTaskStatus(taskId, currentStatus) {
    const newStatus = currentStatus === 'completed' ? 'pending' : 'completed';
    updateTaskStatus(taskId, newStatus);
}

function deleteTask(id, name) {
    document.getElementById('taskName').textContent = name;
    document.getElementById('deleteForm').action = `/superlinkiu/linkiudev/tasks/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection
