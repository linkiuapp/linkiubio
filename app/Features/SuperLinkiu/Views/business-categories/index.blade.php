@extends('shared::layouts.admin')

@section('title', 'Categorías de Negocio')

@section('content')
<div class="container-fluid" x-data="categoryManager">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Categorías de Negocio</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona las categorías de negocio y configura la aprobación automática</p>
        </div>
        <button @click="openCreateModal()" class="btn-primary">
            <x-solar-add-circle-outline class="w-5 h-5 mr-2" />
            Nueva Categoría
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <p class="text-xs font-medium text-gray-500 uppercase">Total</p>
            <p class="text-2xl font-bold text-gray-900">{{ $categories->total() }}</p>
        </div>
        <div class="bg-success-50 border border-success-200 rounded-lg p-4">
            <p class="text-xs font-medium text-success-600 uppercase">Auto-Aprobación</p>
            <p class="text-2xl font-bold text-success-700">{{ $categories->where('requires_manual_approval', false)->where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-warning-50 border border-warning-200 rounded-lg p-4">
            <p class="text-xs font-medium text-warning-600 uppercase">Revisión Manual</p>
            <p class="text-2xl font-bold text-warning-700">{{ $categories->where('requires_manual_approval', true)->where('is_active', true)->count() }}</p>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <p class="text-xs font-medium text-gray-500 uppercase">Inactivas</p>
            <p class="text-2xl font-bold text-gray-700">{{ $categories->where('is_active', false)->count() }}</p>
        </div>
    </div>

    {{-- Lista de Categorías --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Aprobación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiendas</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                        @if($category->description)
                                            <div class="text-xs text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($category->requires_manual_approval)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-100 text-warning-800">
                                        <x-solar-eye-outline class="w-3 h-3 mr-1" />
                                        Revisión Manual
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                        <x-solar-check-circle-outline class="w-3 h-3 mr-1" />
                                        Auto-Aprobación
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('superlinkiu.business-categories.toggle-status', $category) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $category->is_active ? 'bg-success-300' : 'bg-gray-300' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $category->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $category->stores_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button @click="openEditModal({{ json_encode($category) }})" class="text-primary-200 hover:text-primary-300 mr-3">
                                    Editar
                                </button>
                                <form action="{{ route('superlinkiu.business-categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger-300 hover:text-danger-400">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <x-solar-document-outline class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                                <p class="text-lg">No hay categorías registradas</p>
                                <button @click="openCreateModal()" class="mt-4 text-primary-200 hover:text-primary-300">
                                    Crear primera categoría
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $categories->links() }}
        </div>
    </div>

    {{-- Modal Crear/Editar --}}
    <div x-show="showModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 aria-hidden="true"
                 @click="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form :action="isEditing ? `/superlinkiu/business-categories/${editingId}` : '{{ route('superlinkiu.business-categories.store') }}'" method="POST">
                    @csrf
                    <input type="hidden" name="_method" x-bind:value="isEditing ? 'PUT' : 'POST'">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4" x-text="isEditing ? 'Editar Categoría' : 'Nueva Categoría'"></h3>
                        
                        <div class="space-y-4">
                            {{-- Nombre --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                                <input type="text" name="name" x-model="form.name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-200 focus:border-primary-200">
                            </div>

                            {{-- Descripción --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <textarea name="description" x-model="form.description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-200 focus:border-primary-200"></textarea>
                            </div>

                            {{-- Tipo de Aprobación --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Aprobación *</label>
                                <div class="space-y-2">
                                    <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="requires_manual_approval" value="0" x-model="form.requires_manual_approval" class="mt-1 mr-3">
                                        <div>
                                            <span class="font-medium text-gray-900">Auto-Aprobación</span>
                                            <p class="text-xs text-gray-500">Aprobar automáticamente si el documento es válido</p>
                                        </div>
                                    </label>
                                    <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="requires_manual_approval" value="1" x-model="form.requires_manual_approval" class="mt-1 mr-3">
                                        <div>
                                            <span class="font-medium text-gray-900">Revisión Manual</span>
                                            <p class="text-xs text-gray-500">Requiere aprobación del SuperAdmin</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- Estado --}}
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" x-model="form.is_active" class="mr-2">
                                    <span class="text-sm font-medium text-gray-700">Categoría activa</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="btn-primary w-full sm:w-auto sm:ml-3">
                            <span x-text="isEditing ? 'Actualizar' : 'Crear'"></span>
                        </button>
                        <button type="button" @click="closeModal()" class="btn-secondary w-full sm:w-auto mt-3 sm:mt-0">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('categoryManager', () => ({
        showModal: false,
        isEditing: false,
        editingId: null,
        form: {
            name: '',
            icon: '',
            description: '',
            requires_manual_approval: '1',
            is_active: true
        },

        openCreateModal() {
            this.isEditing = false;
            this.editingId = null;
            this.form = {
                name: '',
                icon: '',
                description: '',
                requires_manual_approval: '1',
                is_active: true
            };
            this.showModal = true;
        },

        openEditModal(category) {
            this.isEditing = true;
            this.editingId = category.id;
            this.form = {
                name: category.name,
                icon: category.icon || '',
                description: category.description || '',
                requires_manual_approval: category.requires_manual_approval ? '1' : '0',
                is_active: category.is_active
            };
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
        }
    }));
});
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection

