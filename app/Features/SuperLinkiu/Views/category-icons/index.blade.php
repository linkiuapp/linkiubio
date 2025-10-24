@extends('shared::layouts.admin')
@section('title', 'Iconos de Categorías')

@section('content')
<div class="flex-1 space-y-6" x-data="iconManager()">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-black-400">Iconos de Categorías</h1>
            <p class="text-black-300 mt-1">Gestiona los iconos disponibles para las categorías de las tiendas</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.category-icons.create') }}" class="btn-primary">
                <x-solar-add-circle-outline class="w-4 h-4 mr-2" />
                Nuevo Icono
            </a>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Iconos -->
        <div class="bg-accent-50 rounded-xl p-6 shadow-sm border border-accent-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-300 mb-1">Total de Iconos</p>
                    <p class="text-2xl font-bold text-black-500">{{ $totalIcons }}</p>
                </div>
                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                    <x-solar-gallery-outline class="w-6 h-6 text-primary-300" />
                </div>
            </div>
        </div>

        <!-- Iconos Activos -->
        <div class="bg-accent-50 rounded-xl p-6 shadow-sm border border-accent-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-300 mb-1">Iconos Activos</p>
                    <p class="text-2xl font-bold text-success-400">{{ $activeIcons }}</p>
                </div>
                <div class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center">
                    <x-solar-check-circle-outline class="w-6 h-6 text-success-400" />
                </div>
            </div>
        </div>

        <!-- Iconos Globales -->
        <div class="bg-accent-50 rounded-xl p-6 shadow-sm border border-accent-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-300 mb-1">Iconos Globales</p>
                    <p class="text-2xl font-bold text-info-300">{{ $globalIcons }}</p>
                </div>
                <div class="w-12 h-12 bg-info-100 rounded-lg flex items-center justify-center">
                    <x-solar-star-bold class="w-6 h-6 text-info-300" />
                </div>
            </div>
        </div>

        <!-- Categorías con Iconos -->
        <div class="bg-accent-50 rounded-xl p-6 shadow-sm border border-accent-100">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-sm font-medium text-black-300 mb-1">Categorías con Iconos</p>
                    <p class="text-2xl font-bold text-warning-300">{{ $categoriesWithIcons }}</p>
                </div>
                <div class="w-12 h-12 bg-warning-100 rounded-lg flex items-center justify-center">
                    <x-solar-folder-with-files-outline class="w-6 h-6 text-warning-300" />
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-accent-50 rounded-xl shadow-sm border border-accent-100 overflow-hidden">
        <!-- Barra de búsqueda y filtros -->
        <div class="px-6 py-4 border-b border-accent-100 bg-accent-50">
            <div class="relative">
                <input type="text" 
                       x-model="searchQuery"
                       @input="filterIcons()"
                       placeholder="Buscar iconos... (ej: hamburguesa, laptop)"
                       class="w-full px-4 py-3 pl-12 rounded-lg border-2 border-accent-200 focus:border-primary-200 focus:ring-2 focus:ring-primary-100 transition-colors">
                <x-solar-magnifer-outline class="w-5 h-5 absolute left-4 top-3.5 text-black-300" />
            </div>
        </div>

        <!-- Tabs de Categorías -->
        <div class="px-6 py-3 border-b border-accent-100 bg-gradient-to-r from-accent-50 to-accent-100 overflow-x-auto">
            <div class="flex gap-2 min-w-max">
                <button @click="selectedCategory = 'all'; filterIcons()" 
                        :class="selectedCategory === 'all' ? 'bg-primary-200 text-accent-50' : 'bg-accent-200 text-black-400 hover:bg-accent-300'"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors whitespace-nowrap">
                    Todos ({{ $totalIcons }})
                </button>
                
                <button @click="selectedCategory = 'global'; filterIcons()" 
                        :class="selectedCategory === 'global' ? 'bg-info-300 text-accent-50' : 'bg-accent-200 text-black-400 hover:bg-accent-300'"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-colors whitespace-nowrap flex items-center gap-2">
                    <x-solar-star-bold class="w-4 h-4" />
                    Globales ({{ $globalIcons }})
                </button>

                @foreach($businessCategories as $category)
                    <button @click="selectedCategory = {{ $category->id }}; filterIcons()" 
                            :class="selectedCategory === {{ $category->id }} ? 'bg-primary-200 text-accent-50' : 'bg-accent-200 text-black-400 hover:bg-accent-300'"
                            class="px-4 py-2 rounded-lg font-medium text-sm transition-colors whitespace-nowrap">
                        {{ $category->icon ?? '📦' }} {{ $category->name }} ({{ $category->icons_count ?? 0 }})
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Content Area -->
        @if($icons->count() > 0)
            <div class="p-6">
                <!-- Icons Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                    @foreach($icons as $icon)
                        <div class="icon-card bg-accent-100 rounded-xl p-4 border-2 border-accent-200 hover:border-primary-200 hover:shadow-md transition-all duration-200 group"
                             data-icon-id="{{ $icon->id }}"
                             data-icon-name="{{ strtolower($icon->display_name . ' ' . $icon->name) }}"
                             data-is-global="{{ $icon->is_global ? 'true' : 'false' }}"
                             data-categories="{{ $icon->businessCategories->pluck('id')->implode(',') }}">
                            
                            <!-- Icon Preview -->
                            <div @click="viewIcon({{ $icon->id }})" 
                                 class="aspect-square bg-accent-50 rounded-lg p-3 mb-3 flex items-center justify-center overflow-hidden group-hover:bg-primary-50 transition-colors cursor-pointer">
                                @if($icon->image_url)
                                    <img src="{{ $icon->image_url }}" 
                                         alt="{{ $icon->display_name }}" 
                                         class="w-full h-full object-contain">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-black-200">
                                        <x-solar-gallery-outline class="w-8 h-8" />
                                    </div>
                                @endif
                            </div>

                            <!-- Icon Info -->
                            <div class="text-center mb-3">
                                <h3 class="text-sm font-semibold text-black-400 mb-1 truncate">{{ $icon->display_name }}</h3>
                                <p class="text-xs text-black-300 truncate">{{ $icon->name }}</p>
                            </div>

                            <!-- Status Badge -->
                            <div class="flex justify-center mb-3">
                                @if($icon->is_global)
                                    <span class="px-2 py-1 text-xs bg-info-100 text-info-400 rounded-full font-medium flex items-center gap-1">
                                        <x-solar-star-bold class="w-3 h-3" />
                                        Global
                                    </span>
                                @elseif($icon->is_active)
                                    <span class="px-2 py-1 text-xs bg-success-100 text-success-400 rounded-full font-medium">Activo</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-warning-100 text-warning-400 rounded-full font-medium">Inactivo</span>
                                @endif
                            </div>

                            <!-- Actions Row -->
                            <div class="flex items-center justify-center gap-2">
                                <!-- Toggle Switch -->
                                <label class="relative inline-flex items-center cursor-pointer" title="Activar/Desactivar">
                                    <input type="checkbox" 
                                           class="sr-only peer icon-toggle"
                                           {{ $icon->is_active ? 'checked' : '' }}
                                           data-icon-id="{{ $icon->id }}"
                                           data-url="{{ route('superlinkiu.category-icons.toggle-active', $icon->id) }}">
                                    <div class="w-9 h-5 bg-accent-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-200 rounded-full peer 
                                                peer-checked:after:translate-x-full peer-checked:after:border-accent-50 
                                                after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                                after:bg-accent-50 after:rounded-full after:h-4 after:w-4 after:transition-all 
                                                peer-checked:bg-success-300"></div>
                                </label>

                                <!-- Edit Button -->
                                <a href="{{ route('superlinkiu.category-icons.edit', $icon->id) }}" 
                                   class="p-1.5 text-primary-300 hover:text-primary-400 hover:bg-primary-50 rounded-lg transition-colors"
                                   title="Editar">
                                    <x-solar-pen-2-outline class="w-4 h-4" />
                                </a>

                                <!-- Delete Button -->
                                <button @click="deleteIcon({{ $icon->id }}, '{{ $icon->display_name }}')"
                                        class="p-1.5 text-error-300 hover:text-error-400 hover:bg-error-50 rounded-lg transition-colors"
                                        title="Eliminar">
                                    <x-solar-trash-bin-trash-outline class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Mensaje cuando no hay resultados de búsqueda -->
                <div x-show="noResults" x-transition class="py-12 text-center">
                    <div class="w-20 h-20 bg-black-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <x-solar-magnifer-outline class="w-10 h-10 text-black-300" />
                    </div>
                    <h3 class="text-lg font-semibold text-black-400 mb-2">No se encontraron iconos</h3>
                    <p class="text-black-300 mb-6">
                        Intenta con otro término de búsqueda o categoría
                    </p>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-black-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-solar-gallery-outline class="w-10 h-10 text-black-300" />
                </div>
                <h3 class="text-lg font-semibold text-black-400 mb-2">No hay iconos registrados</h3>
                <p class="text-black-300 mb-6 max-w-md mx-auto">
                    Comienza agregando algunos iconos para las categorías de las tiendas. 
                    Los iconos ayudarán a los administradores a organizar mejor sus productos.
                </p>
                <a href="{{ route('superlinkiu.category-icons.create') }}" class="btn-primary">
                    <x-solar-add-circle-outline class="w-4 h-4 mr-2" />
                    Crear Primer Icono
                </a>
            </div>
        @endif
    </div>

    <!-- Modal de eliminación -->
    <div x-show="showDeleteModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Background overlay -->
            <div x-show="showDeleteModal" @click="showDeleteModal = false"
                 class="fixed inset-0 bg-black-500/75 backdrop-blur-sm"></div>

            <!-- Modal -->
            <div x-show="showDeleteModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 class="relative bg-accent-50 rounded-lg shadow-xl max-w-md w-full p-6">
                
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-error-50 flex items-center justify-center">
                        <x-solar-trash-bin-trash-bold class="w-6 h-6 text-error-300" />
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-black-400 mb-2">Eliminar Icono</h3>
                        <p class="text-sm text-black-300">
                            ¿Estás seguro de eliminar el icono "<span x-text="deleteIconName"></span>"? 
                            Esta acción no se puede deshacer.
                        </p>
                    </div>
                </div>
                
                <div class="mt-6 flex gap-3 justify-end">
                    <button @click="showDeleteModal = false" class="btn-outline-secondary">
                        Cancelar
                    </button>
                    <button @click="confirmDelete()" class="btn-primary bg-error-300 hover:bg-error-400">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('iconManager', () => ({
        searchQuery: '',
        selectedCategory: 'all',
        showDeleteModal: false,
        deleteIconId: null,
        deleteIconName: '',
        noResults: false,

        init() {
            // Inicializar
        },

        filterIcons() {
            const cards = document.querySelectorAll('.icon-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.dataset.iconName;
                const isGlobal = card.dataset.isGlobal === 'true';
                const categories = card.dataset.categories.split(',').map(id => parseInt(id));

                // Filtro de búsqueda
                const matchesSearch = this.searchQuery === '' || name.includes(this.searchQuery.toLowerCase());

                // Filtro de categoría
                let matchesCategory = false;
                if (this.selectedCategory === 'all') {
                    matchesCategory = true;
                } else if (this.selectedCategory === 'global') {
                    matchesCategory = isGlobal;
                } else {
                    matchesCategory = categories.includes(this.selectedCategory);
                }

                // Mostrar/ocultar
                if (matchesSearch && matchesCategory) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            this.noResults = visibleCount === 0 && (this.searchQuery !== '' || this.selectedCategory !== 'all');
        },

        viewIcon(iconId) {
            // Por ahora solo redirige a editar
            window.location.href = `/superlinkiu/category-icons/${iconId}/edit`;
        },

        deleteIcon(iconId, iconName) {
            this.deleteIconId = iconId;
            this.deleteIconName = iconName;
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            if (!this.deleteIconId) return;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/superlinkiu/category-icons/${this.deleteIconId}`;
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            form.appendChild(methodInput);
            form.appendChild(tokenInput);
            document.body.appendChild(form);
            form.submit();

            this.showDeleteModal = false;
        }
    }));
});

// Toggle activar/desactivar icono
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('icon-toggle')) {
        const iconId = e.target.dataset.iconId;
        const url = e.target.dataset.url;
        const isChecked = e.target.checked;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar badge de estado
                const card = document.querySelector(`[data-icon-id="${iconId}"]`);
                const badge = card.querySelector('span.px-2');
                
                if (data.is_active) {
                    badge.className = 'px-2 py-1 text-xs bg-success-100 text-success-400 rounded-full font-medium';
                    badge.textContent = 'Activo';
                } else {
                    badge.className = 'px-2 py-1 text-xs bg-warning-100 text-warning-400 rounded-full font-medium';
                    badge.textContent = 'Inactivo';
                }
            } else {
                // Revertir toggle
                e.target.checked = !isChecked;
                alert(data.message || 'Error al cambiar el estado');
            }
        })
        .catch(error => {
            // Revertir toggle
            e.target.checked = !isChecked;
            alert('Error de conexión');
        });
    }
});
</script>
@endpush
@endsection
