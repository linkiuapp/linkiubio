@extends('shared::layouts.admin')

@section('title', 'Gestión de Anuncios')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="announcementsIndex">
    {{-- SECTION: Header Card --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        {{-- SECTION: Header --}}
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Gestión de Anuncios</h2>
                    <p class="text-sm text-gray-600">Administra comunicados y actualizaciones para las tiendas</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('superlinkiu.announcements.create') }}" 
                       class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Crear Anuncio
                    </a>
                </div>
            </div>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Statistics --}}
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Activos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Banners</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['banners'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="image" class="w-5 h-5 text-yellow-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-red-50 rounded-lg p-4 border border-red-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Críticos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['critical'] }}</p>
                        </div>
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-red-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End SECTION: Statistics --}}

        {{-- SECTION: Filters --}}
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                    <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        <option value="">Todos los tipos</option>
                        <option value="critical" {{ request('type') === 'critical' ? 'selected' : '' }}>Crítico</option>
                        <option value="important" {{ request('type') === 'important' ? 'selected' : '' }}>Importante</option>
                        <option value="info" {{ request('type') === 'info' ? 'selected' : '' }}>Información</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                        <option value="">Todos los estados</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expirados</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Título o contenido..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 flex-1 justify-center font-medium transition-colors">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Filtrar
                    </button>
                    <a href="{{ route('superlinkiu.announcements.index') }}" 
                       class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    </a>
                </div>
            </form>
        </div>
        {{-- End SECTION: Filters --}}

        {{-- SECTION: Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Anuncio
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Fechas
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Banner
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">{{ $announcement->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ Str::limit($announcement->content, 80) }}
                                    </p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700">
                                            Prioridad: {{ $announcement->priority }}
                                        </span>
                                        @if($announcement->target_plans)
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-700">
                                                Planes: {{ implode(', ', $announcement->target_plans) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($announcement->type === 'critical')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Crítico
                                    </span>
                                @elseif($announcement->type === 'important')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Importante
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Información
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    @if($announcement->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inactivo
                                        </span>
                                    @endif
                                    
                                    @if($announcement->isExpired())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Expirado
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="space-y-1">
                                    <div>
                                        <span class="font-medium">Publicado:</span><br>
                                        {{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : 'Inmediato' }}
                                    </div>
                                    @if($announcement->expires_at)
                                        <div>
                                            <span class="font-medium">Expira:</span><br>
                                            {{ $announcement->expires_at->format('d/m/Y H:i') }}
                                        </div>
                                    @else
                                        <div class="text-green-600">Permanente</div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($announcement->show_as_banner)
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Banner
                                        </span>
                                        @if($announcement->banner_image)
                                            <img src="{{ $announcement->banner_image_url }}" 
                                                 alt="Banner" 
                                                 class="w-12 h-8 object-cover rounded border border-gray-200">
                                        @endif
                                        @if($announcement->banner_html)
                                            <span class="text-xs text-gray-500">HTML</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">Sin banner</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('superlinkiu.announcements.show', $announcement) }}"
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                                       title="Ver detalle">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    
                                    <a href="{{ route('superlinkiu.announcements.edit', $announcement) }}"
                                       class="text-yellow-600 hover:text-yellow-900 p-2 rounded-lg hover:bg-yellow-50 transition-colors"
                                       title="Editar">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>

                                    <form method="POST" 
                                          action="{{ route('superlinkiu.announcements.toggle-active', $announcement) }}" 
                                          class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="text-{{ $announcement->is_active ? 'red' : 'green' }}-600 hover:text-{{ $announcement->is_active ? 'red' : 'green' }}-900 p-2 rounded-lg hover:bg-{{ $announcement->is_active ? 'red' : 'green' }}-50 transition-colors"
                                                title="{{ $announcement->is_active ? 'Desactivar' : 'Activar' }}">
                                            @if($announcement->is_active)
                                                <i data-lucide="pause-circle" class="w-4 h-4"></i>
                                            @else
                                                <i data-lucide="play-circle" class="w-4 h-4"></i>
                                            @endif
                                        </button>
                                    </form>

                                    <button @click="deleteAnnouncement({{ $announcement->id }}, '{{ addslashes($announcement->title) }}')"
                                            class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                            title="Eliminar">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i data-lucide="file-text" class="w-12 h-12 text-gray-400"></i>
                                    <div>
                                        <h3 class="text-gray-900 font-medium">No hay anuncios</h3>
                                        <p class="text-gray-500 text-sm">Crea el primer anuncio para comunicarte con las tiendas</p>
                                    </div>
                                    <a href="{{ route('superlinkiu.announcements.create') }}" 
                                       class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        Crear Anuncio
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- End SECTION: Table --}}

        @if($announcements->hasPages())
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
    {{-- End SECTION: Header Card --}}

    {{-- SECTION: Delete Modal --}}
    <div x-show="showDeleteModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50"
         style="display: none;">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirmar Eliminación</h3>
            <p class="text-gray-600 mb-4">
                ¿Estás seguro de que deseas eliminar el anuncio 
                "<span x-text="announcementToDelete.title" class="font-medium"></span>"?
            </p>
            <p class="text-sm text-red-600 mb-6">Esta acción no se puede deshacer.</p>
            
            <div class="flex justify-end gap-3">
                <button @click="showDeleteModal = false" 
                        class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg font-medium transition-colors">
                    Cancelar
                </button>
                <button @click="confirmDelete()" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
    {{-- End SECTION: Delete Modal --}}
</div>

@push('scripts')
<script>
// Manejar mensajes flash con toasts
@if(session('success'))
    window.toast.success('Éxito', '{{ session('success') }}', 5000, 'top-center');
@endif

@if(session('error'))
    window.toast.error('Error', '{{ session('error') }}', 5000, 'top-center');
@endif

function announcementsIndex() {
    return {
        showDeleteModal: false,
        announcementToDelete: {},
        
        deleteAnnouncement(id, title) {
            this.announcementToDelete = { id, title };
            this.showDeleteModal = true;
        },
        
        confirmDelete() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/superlinkiu/announcements/${this.announcementToDelete.id}`;
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
            
            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfField);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
}
</script>
@endpush
@endsection
