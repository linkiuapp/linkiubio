@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Proyectos')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Proyectos</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona tus proyectos de desarrollo</p>
        </div>
        <a href="{{ route('superlinkiu.linkiudev.projects.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nuevo Proyecto
        </a>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form action="{{ route('superlinkiu.linkiudev.projects.index') }}" method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Buscar proyectos..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                >
            </div>
            <select name="status" class="w-auto min-w-[140px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                <option value="">Todos los estados</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                <option value="on_hold" {{ request('status') === 'on_hold' ? 'selected' : '' }}>En Pausa</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completado</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
            </select>
            <select name="priority" class="w-auto min-w-[130px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                <option value="">Prioridad</option>
                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Alta</option>
                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Media</option>
                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Baja</option>
            </select>
            <select name="client_id" class="w-auto min-w-[150px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                <option value="">Todos los clientes</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i>
                Buscar
            </button>
            @if(request()->hasAny(['search', 'status', 'priority', 'client_id']))
                <a href="{{ route('superlinkiu.linkiudev.projects.index') }}" class="px-4 py-2.5 text-gray-600 hover:text-gray-800">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- Lista de Proyectos --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($projects as $project)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-5">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1 min-w-0 mr-2">
                            <a href="{{ route('superlinkiu.linkiudev.projects.show', $project) }}" class="text-base font-semibold text-gray-900 hover:text-blue-600 block truncate">
                                {{ $project->name }}
                            </a>
                            <a href="{{ route('superlinkiu.linkiudev.clients.show', $project->client) }}" class="text-sm text-gray-500 hover:text-blue-600">
                                {{ $project->client?->name }}
                            </a>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-{{ $project->priority_color }}-100 text-{{ $project->priority_color }}-800 flex-shrink-0">
                            {{ $project->priority_label }}
                        </span>
                    </div>

                    @if($project->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $project->description }}</p>
                    @endif

                    {{-- Progreso --}}
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-gray-500">Progreso</span>
                            <span class="text-xs font-medium text-gray-900">{{ $project->progress_percentage }}%</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full transition-all" style="width: {{ $project->progress_percentage }}%"></div>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                            <span class="text-xs text-gray-500">{{ $project->tasks_progress }} tareas</span>
                            @if($project->due_date)
                                <span class="text-xs {{ $project->is_overdue ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                    {{ $project->is_overdue ? 'Atrasado' : 'Vence' }} {{ $project->due_date->format('d/m') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Estado y acciones --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <span class="px-3 py-1 text-xs rounded-full bg-{{ $project->status_color }}-100 text-{{ $project->status_color }}-800">
                            {{ $project->status_label }}
                        </span>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('superlinkiu.linkiudev.projects.show', $project) }}" class="text-blue-600 hover:text-blue-800" title="Ver">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </a>
                            <a href="{{ route('superlinkiu.linkiudev.projects.edit', $project) }}" class="text-gray-500 hover:text-gray-700" title="Editar">
                                <i data-lucide="pencil" class="w-5 h-5"></i>
                            </a>
                            @if($project->tasks_count == 0)
                                <button type="button" onclick="deleteProject({{ $project->id }}, '{{ $project->name }}')" class="text-red-500 hover:text-red-700" title="Eliminar">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            @else
                                <span class="text-gray-300 cursor-not-allowed" title="No se puede eliminar: tiene {{ $project->tasks_count }} tareas">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <i data-lucide="folder" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay proyectos</h3>
                    <p class="text-sm text-gray-500 mb-4">Comienza creando tu primer proyecto</p>
                    <a href="{{ route('superlinkiu.linkiudev.projects.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Nuevo Proyecto
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginación --}}
    @if($projects->hasPages())
        <div class="flex justify-center mt-6">
            {{ $projects->links() }}
        </div>
    @endif
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
                        <h3 class="text-lg font-semibold text-gray-900">¿Eliminar proyecto?</h3>
                        <p class="text-sm text-gray-600 mt-2">
                            Se eliminará el proyecto "<span id="projectName" class="font-medium"></span>" de forma permanente. Esta acción no se puede deshacer.
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
function deleteProject(id, name) {
    document.getElementById('projectName').textContent = name;
    document.getElementById('deleteForm').action = `/superlinkiu/linkiudev/projects/${id}`;
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
