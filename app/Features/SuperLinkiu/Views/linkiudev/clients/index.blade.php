@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Clientes')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Clientes</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona tus clientes de desarrollo</p>
        </div>
        <a href="{{ route('superlinkiu.linkiudev.clients.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nuevo Cliente
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Total Clientes</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $clients->total() }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Activos</p>
                    <p class="text-2xl font-bold text-green-600">{{ $clients->where('is_active', true)->count() }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Con Proyectos Activos</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $clients->filter(fn($c) => $c->active_projects_count > 0)->count() }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i data-lucide="folder-kanban" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4">
            <form action="{{ route('superlinkiu.linkiudev.clients.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Buscar por nombre, email o teléfono..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                    >
                </div>
                <div>
                    <select name="status" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                        <option value="">Todos los estados</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors flex items-center gap-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                    Buscar
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('superlinkiu.linkiudev.clients.index') }}" class="px-4 py-2.5 text-gray-600 hover:text-gray-800">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Lista de Clientes Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($clients as $client)
            <div class="bg-white rounded-xl shadow-sm border-2 {{ $client->is_active ? 'border-green-300' : 'border-gray-300' }} overflow-hidden">
                {{-- Header de la Card --}}
                <div class="p-5 {{ $client->is_active ? 'bg-green-50' : 'bg-gray-50' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-bold text-lg">
                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $client->name }}</h3>
                                <p class="text-sm text-gray-600">Desde {{ $client->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @if($client->is_active)
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">ACTIVO</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">INACTIVO</span>
                        @endif
                    </div>
                </div>

                {{-- Contenido --}}
                <div class="p-5 space-y-4">
                    {{-- Teléfono --}}
                    <div class="flex items-start gap-3">
                        <i data-lucide="phone" class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5"></i>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $client->country_code }} {{ $client->phone }}</p>
                            <p class="text-xs text-gray-600">WhatsApp habilitado</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    @if($client->email)
                    <div class="flex items-start gap-3">
                        <i data-lucide="mail" class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5"></i>
                        <p class="text-sm text-gray-600">{{ $client->email }}</p>
                    </div>
                    @endif

                    {{-- Proyectos --}}
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <div class="flex items-center gap-2">
                            <i data-lucide="folder-kanban" class="w-5 h-5 text-blue-600"></i>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $client->projects_count }} Proyectos</p>
                                @if($client->active_projects_count > 0)
                                    <p class="text-xs text-gray-600">{{ $client->active_projects_count }} activos</p>
                                @else
                                    <p class="text-xs text-gray-600">Sin proyectos activos</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('superlinkiu.linkiudev.projects.create', ['client_id' => $client->id]) }}" 
                           class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors"
                           title="Nuevo Proyecto">
                            <i data-lucide="folder-plus" class="w-4 h-4"></i>
                        </a>
                    </div>

                    {{-- Notas --}}
                    @if($client->notes)
                    <div class="flex items-start gap-2 text-xs text-gray-500">
                        <i data-lucide="file-text" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
                        <span class="line-clamp-2">{{ $client->notes }}</span>
                    </div>
                    @endif
                </div>

                {{-- Acciones --}}
                <div class="p-5 bg-gray-50 border-t border-gray-200 flex gap-3">
                    <a href="{{ route('superlinkiu.linkiudev.clients.show', $client) }}" 
                       class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium text-center transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                        Ver Detalles
                    </a>
                    <a href="{{ route('superlinkiu.linkiudev.clients.edit', $client) }}" 
                       class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors flex items-center gap-2">
                        <i data-lucide="pencil" class="w-4 h-4"></i>
                    </a>
                    @if($client->projects_count == 0)
                        <button type="button" onclick="deleteClient({{ $client->id }}, '{{ addslashes($client->name) }}')" 
                           class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg font-medium transition-colors flex items-center gap-2">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    @else
                        <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed flex items-center gap-2" title="No se puede eliminar: tiene {{ $client->projects_count }} proyectos">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <i data-lucide="users" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <p class="text-lg font-medium text-gray-600 mb-2">No hay clientes registrados</p>
                <p class="text-sm text-gray-500 mb-4">Comienza agregando tu primer cliente</p>
                <a href="{{ route('superlinkiu.linkiudev.clients.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nuevo Cliente
                </a>
            </div>
        @endforelse
    </div>

    {{-- Paginación --}}
    @if($clients->hasPages())
    <div class="flex justify-center mt-6">
        {{ $clients->links() }}
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
                        <h3 class="text-lg font-semibold text-gray-900">¿Eliminar cliente?</h3>
                        <p class="text-sm text-gray-600 mt-2">
                            Se eliminará el cliente "<span id="clientName" class="font-medium"></span>" de forma permanente. Esta acción no se puede deshacer.
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
function deleteClient(id, name) {
    document.getElementById('clientName').textContent = name;
    document.getElementById('deleteForm').action = `/superlinkiu/linkiudev/clients/${id}`;
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
