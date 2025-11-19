{{--
Vista Index - Listado de Categorías
Muestra todas las categorías con filtros, acciones y paginación
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Categorías')

    @section('content')
    {{-- SECTION: Empty State Configuration --}}
    @php
        // Personaliza estos valores para el estado vacío
        $emptyStateSvg = 'base_ui_empty_categorias.svg';
        $emptyStateTitle = 'No hay categorías disponibles';
        $emptyStateMessage = 'Comienza agregando categorías para tus productos.';
    @endphp
    {{-- End SECTION: Empty State Configuration --}}

    {{-- SECTION: Main Container --}}
    <div 
        x-data="categoryManagement" 
        class="space-y-4" 
        x-init="init()"
    >
        {{-- SECTION: Success Alert - Category Created --}}
        @if(session('category_created'))
            <div 
                x-data="{ show: true }"
                x-show="show"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                x-init="setTimeout(() => show = false, 5000)"
            >
                <x-alert-bordered 
                    type="success" 
                    title="Actualización exitosa" 
                    message="La categoría se ha creado correctamente."
                />
            </div>
        @endif
        {{-- End SECTION: Success Alert - Category Created --}}

        {{-- SECTION: Success Alert - Category Updated --}}
        @if(session('category_updated'))
            <div 
                x-data="{ show: true }"
                x-show="show"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                x-init="setTimeout(() => show = false, 5000)"
            >
                <x-alert-bordered 
                    type="success" 
                    title="Actualización exitosa" 
                    message="La categoría se ha actualizado correctamente."
                />
            </div>
        @endif
        {{-- End SECTION: Success Alert - Category Updated --}}

        {{-- SECTION: Success Alert - Category Deleted --}}
        <div 
            x-show="showSuccessAlert"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            style="display: none;"
        >
            <x-alert-bordered 
                type="success" 
                title="Actualización exitosa" 
                message="La categoría se ha eliminado correctamente."
            />
        </div>
        {{-- End SECTION: Success Alert - Category Deleted --}}

        {{-- SECTION: Success Alert - Bulk Delete --}}
        <div 
            x-show="showBulkDeleteSuccessAlert"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            style="display: none;"
        >
            <x-alert-bordered type="success" title="Actualización exitosa">
                <span x-text="'Se eliminaron ' + bulkDeleteSuccessCount + (bulkDeleteSuccessCount === 1 ? ' categoría correctamente.' : ' categorías correctamente.')"></span>
            </x-alert-bordered>
        </div>
        {{-- End SECTION: Success Alert - Bulk Delete --}}

        {{-- SECTION: Toggle Error Alert --}}
        <div 
            x-show="showToggleError"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            style="display: none;"
        >
            <x-alert-bordered type="error" title="Error">
                <span x-text="toggleErrorMessage"></span>
            </x-alert-bordered>
        </div>
        {{-- End SECTION: Toggle Error Alert --}}

        {{-- SECTION: Content Card --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            {{-- SECTION: Header --}}
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Categorías</h2>
                        <p class="text-sm text-gray-600">
                            Usando {{ $totalCategories }} de {{ $categoryLimit }} categorías disponibles en tu plan {{ $store->plan->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div x-show="selectedCategories.length > 0" x-cloak style="display: none;">
                            <button
                                type="button"
                                @click="deleteSelectedCategories()"
                                class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-3 px-4 body-small bg-red-500 text-white hover:bg-red-600 focus:bg-red-600 border border-transparent"
                            >
                                <i data-lucide="trash-2" class="shrink-0 w-4 h-4"></i>
                                <span x-text="'Eliminar ' + selectedCategories.length + (selectedCategories.length === 1 ? ' categoría' : ' categorías')"></span>
                            </button>
                        </div>
                        @if($totalCategories < $categoryLimit)
                            <a href="{{ route('tenant.admin.categories.create', $store->slug) }}">
                                <x-button-icon 
                                    type="solid" 
                                    color="dark" 
                                    size="md" 
                                    icon="plus-circle"
                                    text="Nueva Categoría"
                                />
                            </a>
                        @else
                            <x-button-icon 
                                type="outline" 
                                color="secondary" 
                                size="md" 
                                icon="plus-circle"
                                text="Límite Alcanzado"
                                :disabled="true"
                            />
                        @endif
                    </div>
                </div>
            </div>
            {{-- End SECTION: Header --}}

            {{-- SECTION: Toolbar --}}
            <div class="px-6 py-3 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        {{-- ITEM: Status Filter --}}
                        <div class="w-48">
                            <select
                                name="filterStatus"
                                id="filter-status"
                                x-model="filterStatus"
                                @change="applyFilters()"
                                class="py-2 px-3 pr-9 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none bg-white text-gray-700"
                            >
                                <option value="">Todas</option>
                                <option value="active">Activas</option>
                                <option value="inactive">Inactivas</option>
                            </select>
                        </div>
                        {{-- End ITEM: Status Filter --}}
                        
                        {{-- ITEM: Type Filter --}}
                        <div class="w-56">
                            <select
                                name="filterType"
                                id="filter-type"
                                x-model="filterType"
                                @change="applyFilters()"
                                class="py-2 px-3 pr-9 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none bg-white text-gray-700"
                            >
                                <option value="">Todas las categorías</option>
                                <option value="main">Solo principales</option>
                                <option value="sub">Solo subcategorías</option>
                            </select>
                        </div>
                        {{-- End ITEM: Type Filter --}}
                    </div>

                    <div class="text-sm text-gray-600">
                        Mostrando <span data-category-count="{{ $categories->count() }}">{{ $categories->firstItem() ?? 0 }}</span> - {{ $categories->lastItem() ?? 0 }} de {{ $categories->total() }} categorías
                    </div>
                </div>
            </div>
            {{-- End SECTION: Toolbar --}}

            {{-- SECTION: Table Content --}}
            @if(($viewType ?? 'table') === 'table')
                <x-categories-table 
                    :categories="$categories" 
                    :store="$store" 
                    :emptyStateSvg="$emptyStateSvg"
                    :emptyStateTitle="$emptyStateTitle"
                    :emptyStateMessage="$emptyStateMessage"
                    :totalCategories="$totalCategories"
                    :categoryLimit="$categoryLimit"
                />
            @endif
            {{-- End SECTION: Table Content --}}

            {{-- SECTION: Pagination --}}
            @if($categories->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $categories->links() }}
                </div>
            @endif
            {{-- End SECTION: Pagination --}}
        </div>
        {{-- End SECTION: Content Card --}}

        {{-- SECTION: Bulk Delete Confirmation Modal --}}
        <div 
            x-show="showBulkDeleteModal"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="closeBulkDeleteModal()"
            style="display: none;"
            x-cloak
            x-on:keydown.escape.window="closeBulkDeleteModal()"
        ></div>

        <div 
            x-show="showBulkDeleteModal"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            aria-labelledby="bulk-delete-modal-label"
            style="display: none;"
            x-cloak
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    {{-- SECTION: Modal Header --}}
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 id="bulk-delete-modal-label" class="font-bold text-gray-800">
                            ¿Eliminar categorías?
                        </h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                            aria-label="Cerrar"
                            @click="closeBulkDeleteModal()"
                            :disabled="bulkDeleteLoading"
                        >
                            <span class="sr-only">Cerrar</span>
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>
                    {{-- End SECTION: Modal Header --}}

                    {{-- SECTION: Modal Body --}}
                    <div class="p-4 overflow-y-auto">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800">
                                    Se eliminarán <strong><span x-text="selectedCategories.length"></span> <span x-text="selectedCategories.length === 1 ? 'categoría' : 'categorías'"></span></strong> de forma permanente.
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Esta acción no se puede deshacer.
                                </p>
                                
                                {{-- ITEM: Error Alert --}}
                                <div x-show="bulkDeleteError" class="mt-3" x-cloak>
                                    <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                        <div class="flex">
                                            <div class="shrink-0">
                                                <i data-lucide="alert-circle" class="size-5"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p x-text="bulkDeleteError"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End ITEM: Error Alert --}}
                            </div>
                        </div>
                    </div>
                    {{-- End SECTION: Modal Body --}}

                    {{-- SECTION: Modal Footer --}}
                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
                            @click="closeBulkDeleteModal()"
                            :disabled="bulkDeleteLoading"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                            @click="confirmBulkDelete()"
                            :disabled="bulkDeleteLoading"
                        >
                            <span x-show="!bulkDeleteLoading">Sí, eliminar</span>
                            <span x-show="bulkDeleteLoading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Eliminando...
                            </span>
                        </button>
                    </div>
                    {{-- End SECTION: Modal Footer --}}
                </div>
            </div>
        </div>
        {{-- End SECTION: Bulk Delete Confirmation Modal --}}
    </div>
    {{-- End SECTION: Main Container --}}

    {{-- SECTION: Delete Confirmation Modal --}}
    <div 
        x-data="deleteModalData()"
        x-on:keydown.escape.window="closeModal()"
        @delete-category.window="openModal($event.detail.id, $event.detail.name, $event.detail.rowElement)"
    >
        {{-- Modal Overlay --}}
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="closeModal()"
            style="display: none;"
        ></div>

        {{-- Modal Content --}}
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            aria-labelledby="delete-modal-label"
            style="display: none;"
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    {{-- SECTION: Modal Header --}}
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 id="delete-modal-label" class="font-bold text-gray-800">
                            ¿Eliminar categoría?
                        </h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                            aria-label="Cerrar"
                            @click="closeModal()"
                            :disabled="loading"
                        >
                            <span class="sr-only">Cerrar</span>
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>
                    {{-- End SECTION: Modal Header --}}

                    {{-- SECTION: Modal Body --}}
                    <div class="p-4 overflow-y-auto">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800">
                                    Se eliminará la categoría <strong>"<span x-text="categoryName"></span>"</strong> de forma permanente.
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Esta acción no se puede deshacer.
                                </p>
                                
                                {{-- ITEM: Error Alert --}}
                                <div x-show="error" class="mt-3" x-cloak>
                                    <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                        <div class="flex">
                                            <div class="shrink-0">
                                                <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                            </div>
                                            <div class="ms-2">
                                                <h3 class="text-sm font-medium">
                                                    Error: <span x-text="error"></span>
                                                </h3>
                                            </div>
                                            <div class="ps-3 ms-auto">
                                                <div class="-mx-1.5 -my-1.5">
                                                    <button 
                                                        type="button" 
                                                        class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100" 
                                                        @click="error = null"
                                                    >
                                                        <span class="sr-only">Descartar</span>
                                                        <i data-lucide="x" class="shrink-0 size-4"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- End ITEM: Error Alert --}}
                            </div>
                        </div>
                    </div>
                    {{-- End SECTION: Modal Body --}}

                    {{-- SECTION: Modal Footer --}}
                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
                            @click="closeModal()"
                            :disabled="loading"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                            @click="confirmDelete()"
                            :disabled="loading"
                        >
                            <span x-show="!loading">Sí, eliminar</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Eliminando...
                            </span>
                        </button>
                    </div>
                    {{-- End SECTION: Modal Footer --}}
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Delete Confirmation Modal --}}

    @push('scripts')
    <script>
        function deleteModalData() {
            return {
                open: false,
                categoryId: null,
                categoryName: '',
                categoryRow: null,
                loading: false,
                error: null,
                
                openModal(id, name, rowElement) {
                    this.categoryId = id;
                    this.categoryName = name;
                    this.categoryRow = rowElement;
                    this.error = null;
                    this.open = true;
                },
                
                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.categoryId = null;
                        this.categoryName = '';
                        this.categoryRow = null;
                        this.error = null;
                    }
                },
                
                async confirmDelete() {
                    if (!this.categoryId) return;
                    
                    this.loading = true;
                    this.error = null;
                    
                    try {
                        const storeSlug = '{{ $store->slug }}';
                        const response = await fetch('/' + storeSlug + '/admin/categories/' + this.categoryId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            }
                        });

                        let data;
                        try {
                            data = await response.json();
                        } catch (e) {
                            throw new Error('Error al procesar la respuesta del servidor');
                        }

                        if (!response.ok) {
                            throw new Error(data.error || 'Error al eliminar la categoría');
                        }

                        if (data.error) {
                            throw new Error(data.error);
                        }

                        this.loading = false;
                        
                        const rowToDelete = this.categoryRow;
                        const categoryName = this.categoryName;
                        
                        this.closeModal();
                        
                        if (rowToDelete && rowToDelete.parentNode) {
                            rowToDelete.style.transition = 'opacity 0.3s ease-out';
                            rowToDelete.style.opacity = '0';
                            setTimeout(() => {
                                if (rowToDelete.parentNode) {
                                    rowToDelete.remove();
                                    this.updateCategoryCount();
                                    
                                    // Verificar si quedan categorías y mostrar EmptyState si es necesario
                                    const categoryManagement = Alpine.$data(document.querySelector('[x-data="categoryManagement"]'));
                                    if (categoryManagement && categoryManagement.checkAndShowEmptyState) {
                                        categoryManagement.checkAndShowEmptyState();
                                    }
                                    
                                    window.dispatchEvent(new CustomEvent('show-success-alert'));
                                }
                            }, 300);
                        } else {
                            window.location.reload();
                            return;
                        }
                    } catch (error) {
                        this.error = error.message || 'Error al eliminar la categoría';
                        this.loading = false;
                    }
                },
                
                updateCategoryCount() {
                    const totalCount = document.querySelectorAll('tbody tr[data-category-id]').length;
                    const countElement = document.querySelector('[data-category-count]');
                    if (countElement) {
                        countElement.textContent = totalCount;
                    }
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('categoryManagement', () => ({
                filterStatus: '{{ request('status', '') }}',
                filterType: '{{ request('type', '') }}',
                showSuccessAlert: false,
                selectedCategories: [],
                selectAll: false,
                showBulkDeleteModal: false,
                bulkDeleteLoading: false,
                bulkDeleteError: null,
                bulkDeleteSuccessCount: 0,
                showBulkDeleteSuccessAlert: false,
                showToggleError: false,
                toggleErrorMessage: '',

                init() {
                    window.addEventListener('show-success-alert', () => {
                        this.showSuccessAlert = true;
                        this.$nextTick(() => {
                            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                window.createIcons({ icons: window.lucideIcons });
                            }
                        });
                        setTimeout(() => {
                            this.showSuccessAlert = false;
                        }, 5000);
                    });

                    // Inicializar iconos Lucide
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                },

                deleteCategory(id, name, event) {
                    const rowElement = event.target.closest('tr');
                    if (!rowElement) {
                        return;
                    }
                    window.dispatchEvent(new CustomEvent('delete-category', {
                        detail: { id, name, rowElement }
                    }));
                },

                applyFilters() {
                    const params = new URLSearchParams(window.location.search);
                    
                    if (this.filterStatus) {
                        params.set('status', this.filterStatus);
                    } else {
                        params.delete('status');
                    }
                    
                    if (this.filterType) {
                        params.set('type', this.filterType);
                    } else {
                        params.delete('type');
                    }
                    
                    window.location.search = params.toString();
                },

                toggleSelectAll() {
                    const selectAllCheckbox = document.getElementById('select-all-categories');
                    if (!selectAllCheckbox) return;
                    
                    const isChecked = selectAllCheckbox.checked;
                    this.selectAll = isChecked;
                    
                    const checkboxes = document.querySelectorAll('.category-checkbox');
                    checkboxes.forEach(checkbox => {
                        const categoryId = parseInt(checkbox.value);
                        const productsCount = parseInt(checkbox.closest('tr').dataset.productsCount || '0');
                        
                        // Solo seleccionar si no tiene productos
                        if (productsCount === 0) {
                            checkbox.checked = isChecked;
                            if (isChecked) {
                                if (!this.selectedCategories.includes(categoryId)) {
                                    this.selectedCategories.push(categoryId);
                                }
                            } else {
                                this.selectedCategories = this.selectedCategories.filter(id => id !== categoryId);
                            }
                        }
                    });
                },

                toggleCategory(checkbox) {
                    if (!checkbox) return;
                    const categoryId = parseInt(checkbox.value);
                    const productsCount = parseInt(checkbox.closest('tr').dataset.productsCount || '0');
                    
                    // Solo permitir seleccionar si no tiene productos
                    if (productsCount > 0) {
                        checkbox.checked = false;
                        return;
                    }
                    
                    if (checkbox.checked) {
                        if (!this.selectedCategories.includes(categoryId)) {
                            this.selectedCategories.push(categoryId);
                        }
                    } else {
                        this.selectedCategories = this.selectedCategories.filter(id => id !== categoryId);
                    }
                    this.updateSelectAllState();
                },

                updateSelectAllState() {
                    const checkboxes = document.querySelectorAll('.category-checkbox');
                    const selectAllCheckbox = document.getElementById('select-all-categories');
                    if (!checkboxes.length || !selectAllCheckbox) return;
                    
                    const selectableCheckboxes = Array.from(checkboxes).filter(cb => {
                        const productsCount = parseInt(cb.closest('tr').dataset.productsCount || '0');
                        return productsCount === 0;
                    });
                    
                    const checkedCount = selectableCheckboxes.filter(cb => cb.checked).length;
                    this.selectAll = selectableCheckboxes.length > 0 && checkedCount === selectableCheckboxes.length;
                    selectAllCheckbox.checked = this.selectAll;
                },

                deleteSelectedCategories() {
                    if (this.selectedCategories.length === 0) return;
                    this.showBulkDeleteModal = true;
                },

                closeBulkDeleteModal() {
                    if (!this.bulkDeleteLoading) {
                        this.showBulkDeleteModal = false;
                        this.bulkDeleteError = null;
                    }
                },

                async confirmBulkDelete() {
                    if (this.selectedCategories.length === 0) return;
                    
                    this.bulkDeleteLoading = true;
                    this.bulkDeleteError = null;
                    
                    const storeSlug = '{{ $store->slug }}';
                    const categoryIdsToDelete = [...this.selectedCategories];
                    let successCount = 0;
                    let errorCount = 0;
                    
                    for (const categoryId of categoryIdsToDelete) {
                        try {
                            const response = await fetch('/' + storeSlug + '/admin/categories/' + categoryId, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                                    'Accept': 'application/json',
                                }
                            });
                            
                            const data = await response.json();
                            if (response.ok && data.success) {
                                successCount++;
                                
                                // Eliminar fila del DOM
                                const row = document.querySelector(`tr[data-category-id="${categoryId}"]`);
                                if (row) {
                                    row.style.transition = 'opacity 0.3s ease-out';
                                    row.style.opacity = '0';
                                    setTimeout(() => {
                                        if (row.parentNode) {
                                            row.remove();
                                        }
                                    }, 300);
                                }
                            } else {
                                errorCount++;
                            }
                        } catch (error) {
                            errorCount++;
                        }
                    }
                    
                    this.bulkDeleteLoading = false;
                    this.closeBulkDeleteModal();
                    this.selectedCategories = [];
                    this.selectAll = false;
                    const selectAllCheckbox = document.getElementById('select-all-categories');
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = false;
                    }
                    
                    // Esperar un poco para que las animaciones de eliminación terminen
                    setTimeout(() => {
                        this.updateSelectAllState();
                        
                        // Verificar si quedan categorías y mostrar EmptyState si es necesario
                        this.checkAndShowEmptyState();
                        
                        if (errorCount === 0) {
                            this.bulkDeleteSuccessCount = successCount;
                            
                            // Mostrar alerta de éxito
                            this.showBulkDeleteSuccessAlert = true;
                            
                            // Inicializar iconos Lucide después de mostrar la alerta
                            this.$nextTick(() => {
                                if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                    window.createIcons({ icons: window.lucideIcons });
                                }
                            });
                            
                            // Scroll suave hacia arriba para ver la alerta
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            
                            // Ocultar alerta después de 5 segundos
                            setTimeout(() => {
                                this.showBulkDeleteSuccessAlert = false;
                            }, 5000);
                        } else {
                            this.bulkDeleteError = `Se eliminaron ${successCount} categorías. ${errorCount > 0 ? `${errorCount} categorías no pudieron ser eliminadas.` : ''}`;
                            this.showBulkDeleteModal = true;
                        }
                    }, 350);
                },

                checkAndShowEmptyState() {
                    // Esperar un poco para que las animaciones de eliminación terminen
                    setTimeout(() => {
                        const tbody = document.querySelector('tbody');
                        if (!tbody) return;
                        
                        // Contar filas visibles (excluyendo el empty state dinámico y el empty state de Blade)
                        const categoryRows = tbody.querySelectorAll('tr[data-category-id]');
                        const visibleRows = Array.from(categoryRows).filter(row => {
                            // Verificar si la fila está realmente visible en el DOM
                            const style = window.getComputedStyle(row);
                            return style.display !== 'none' && 
                                   row.style.opacity !== '0' && 
                                   row.offsetParent !== null &&
                                   !row.classList.contains('removing');
                        });
                        
                        const dynamicEmptyState = document.getElementById('dynamic-empty-state');
                        
                        if (visibleRows.length === 0) {
                            // Ocultar el thead de la tabla
                            const thead = document.querySelector('thead');
                            if (thead) {
                                thead.style.display = 'none';
                            }
                            
                            // Ocultar cualquier empty state de Blade que pueda estar visible
                            const bladeEmptyStateRows = tbody.querySelectorAll('tr:not([data-category-id]):not(#dynamic-empty-state)');
                            bladeEmptyStateRows.forEach(row => {
                                if (row.id !== 'dynamic-empty-state') {
                                    row.style.display = 'none';
                                }
                            });
                            
                            // Mostrar el empty state dinámico si existe
                            if (dynamicEmptyState) {
                                dynamicEmptyState.style.display = '';
                                
                                // Inicializar iconos Lucide en el empty state después de mostrarlo
                                this.$nextTick(() => {
                                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                        window.createIcons({ icons: window.lucideIcons });
                                    }
                                });
                            }
                        } else {
                            // Mostrar el thead si hay filas
                            const thead = document.querySelector('thead');
                            if (thead) {
                                thead.style.display = '';
                            }
                            
                            // Ocultar el empty state dinámico
                            if (dynamicEmptyState) {
                                dynamicEmptyState.style.display = 'none';
                            }
                            
                            // Mostrar el empty state de Blade si existe y no hay filas visibles
                            // (esto no debería pasar, pero por si acaso)
                            const bladeEmptyStateRows = tbody.querySelectorAll('tr:not([data-category-id]):not(#dynamic-empty-state)');
                            bladeEmptyStateRows.forEach(row => {
                                if (row.id !== 'dynamic-empty-state') {
                                    row.style.display = 'none';
                                }
                            });
                        }
                    }, 400); // Esperar un poco más que la animación de eliminación (300ms)
                }
            }));
        });

        // Checkbox functionality
        document.addEventListener('change', function(e) {
            // Select all checkbox
            if (e.target.id === 'select-all-categories') {
                const categoryManagement = Alpine.$data(document.querySelector('[x-data="categoryManagement"]'));
                if (categoryManagement) {
                    categoryManagement.toggleSelectAll();
                }
            }
            
            // Individual checkboxes
            if (e.target.classList.contains('category-checkbox')) {
                const categoryManagement = Alpine.$data(document.querySelector('[x-data="categoryManagement"]'));
                if (categoryManagement) {
                    categoryManagement.toggleCategory(e.target);
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }

            // Función para actualizar el estado del botón eliminar según el conteo de productos
            function updateDeleteButtonState(categoryId, productsCount) {
                const row = document.querySelector(`tr[data-category-id="${categoryId}"]`);
                if (!row) return;

                const deleteButton = row.querySelector('.category-delete-btn');
                if (!deleteButton) return;

                // Actualizar el atributo data-products-count
                row.setAttribute('data-products-count', productsCount);
                deleteButton.setAttribute('data-products-count', productsCount);

                // Habilitar o deshabilitar el botón
                if (productsCount > 0) {
                    deleteButton.disabled = true;
                    deleteButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    deleteButton.disabled = false;
                    deleteButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // Escuchar eventos de actualización de conteo de productos
            window.addEventListener('update-category-products-count', function(event) {
                const { categoryId, productsCount } = event.detail;
                updateDeleteButtonState(categoryId, productsCount);
            });

            // Toggle de estado de categoría
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('category-toggle')) {
                    const categoryId = e.target.dataset.categoryId;
                    const url = e.target.dataset.url;
                    const originalChecked = e.target.checked;
                    
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Actualizar el badge de estado en la misma fila
                            const row = e.target.closest('tr');
                            if (row) {
                                const statusCell = row.querySelector('td:nth-child(4)');
                                if (statusCell) {
                                    if (e.target.checked) {
                                        statusCell.innerHTML = '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-green-100 text-green-800">Activa</span>';
                                    } else {
                                        statusCell.innerHTML = '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-red-100 text-red-800">Inactiva</span>';
                                    }
                                }
                            }
                        } else {
                            e.target.checked = !originalChecked;
                            // Mostrar error con AlertBordered
                            const categoryManagement = Alpine.$data(document.querySelector('[x-data="categoryManagement"]'));
                            if (categoryManagement) {
                                categoryManagement.showToggleError = true;
                                categoryManagement.toggleErrorMessage = data.error || 'Error al cambiar el estado';
                                setTimeout(() => {
                                    categoryManagement.showToggleError = false;
                                }, 5000);
                            }
                        }
                    })
                    .catch(error => {
                        e.target.checked = !originalChecked;
                        // Mostrar error con AlertBordered
                        const categoryManagement = Alpine.$data(document.querySelector('[x-data="categoryManagement"]'));
                        if (categoryManagement) {
                            categoryManagement.showToggleError = true;
                            categoryManagement.toggleErrorMessage = 'Error al cambiar el estado';
                            setTimeout(() => {
                                categoryManagement.showToggleError = false;
                            }, 5000);
                        }
                    });
                }
            });
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
