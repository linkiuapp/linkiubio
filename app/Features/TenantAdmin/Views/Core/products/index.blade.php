<x-tenant-admin-layout :store="$store">
    @section('title', 'Productos')

    @section('content')
    {{-- SECTION: Main Container --}}
    <div x-data="productManagement" class="space-y-4">
        {{-- SECTION: Header Card --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            {{-- SECTION: Header --}}
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Productos</h2>
                        <p class="text-sm text-gray-600">
                            Usando {{ $currentCount }} de {{ $maxProducts }} productos disponibles en tu plan {{ $store->plan->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($currentCount < $maxProducts)
                            <a href="{{ route('tenant.admin.products.create', $store->slug) }}">
                                <x-button-icon 
                                    type="solid" 
                                    color="dark" 
                                    icon="plus-circle"
                                    size="md"
                                    text="Nuevo Producto"
                                />
                            </a>
                        @else
                            <x-button-icon 
                                type="outline" 
                                color="secondary" 
                                icon="plus-circle"
                                size="md"
                                text="Límite Alcanzado"
                                :disabled="true"
                            />
                        @endif
                    </div>
                </div>
            </div>
            {{-- End SECTION: Header --}}


            {{-- SECTION: Toolbar --}}
            <div class="px-6 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        {{-- ITEM: Status Filter --}}
                        <x-select-basic 
                            name="filterStatus"
                            select-id="filter-status"
                            :options="[
                                '' => 'Todos',
                                'active' => 'Activos',
                                'inactive' => 'Inactivos'
                            ]"
                            :selected="request('status', '')"
                            placeholder="Filtrar por estado"
                            x-model="filterStatus"
                            @change="applyFilters()"
                            class="w-48"
                        />
                        {{-- End ITEM: Status Filter --}}
                        
                        {{-- ITEM: Type Filter --}}
                        <x-select-basic 
                            name="filterType"
                            select-id="filter-type"
                            :options="[
                                '' => 'Todos los tipos',
                                'simple' => 'Productos simples',
                                'variable' => 'Productos variables'
                            ]"
                            :selected="request('type', '')"
                            placeholder="Filtrar por tipo"
                            x-model="filterType"
                            @change="applyFilters()"
                            class="w-48"
                        />
                        {{-- End ITEM: Type Filter --}}

                        {{-- ITEM: Category Filter --}}
                        @if($categories->count() > 0)
                            <x-select-basic 
                                name="filterCategory"
                                select-id="filter-category"
                                :options="$categories->pluck('name', 'id')->prepend('Todas las categorías', '')"
                                :selected="request('category', '')"
                                placeholder="Filtrar por categoría"
                                x-model="filterCategory"
                                @change="applyFilters()"
                                class="w-48"
                            />
                        @endif
                        {{-- End ITEM: Category Filter --}}
                    </div>
                    
                    <div class="flex items-center gap-3">
                        {{-- ITEM: Search Input --}}
                        <x-input-with-icon 
                            type="text"
                            icon="search"
                            icon-position="left"
                            placeholder="Buscar productos..."
                            x-model="searchTerm"
                            @input.debounce.500ms="applyFilters()"
                            class="w-64"
                        />
                        {{-- End ITEM: Search Input --}}
                        
                        {{-- ITEM: Bulk Actions --}}
                        <div x-show="selectedProducts.length > 0" x-cloak class="flex items-center gap-2" style="display: none;">
                            <x-button-icon 
                                type="solid" 
                                color="success" 
                                icon="check-circle"
                                size="sm"
                                text="Activar"
                                @click="bulkActivate()"
                            />
                            <x-button-icon 
                                type="solid" 
                                color="warning" 
                                icon="x-circle"
                                size="sm"
                                text="Desactivar"
                                @click="bulkDeactivate()"
                            />
                            <x-button-icon 
                                type="solid" 
                                color="error" 
                                icon="trash-2"
                                size="sm"
                                text="Eliminar"
                                @click="bulkDelete()"
                            />
                        </div>
                        {{-- End ITEM: Bulk Actions --}}
                    </div>
                </div>
            </div>
            {{-- End SECTION: Toolbar --}}

            {{-- SECTION: Table Content --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">
                                <input 
                                    type="checkbox" 
                                    id="select-all-products" 
                                    @change="toggleAll($event.target.checked)"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                >
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Producto
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Precio
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Categorías
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Activar/Desactivar
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Compartir
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $product->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <input 
                                        type="checkbox" 
                                        class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                        value="{{ $product->id }}"
                                        @change="toggleProduct({{ $product->id }}, $event.target.checked)"
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm">
                                        <div class="w-12 h-12 mr-3 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden shrink-0">
                                            @if($product->images && $product->images->count() > 0)
                                                <img 
                                                    src="{{ $product->images->first()->image_url }}" 
                                                    alt="{{ $product->name }}"
                                                    class="w-full h-full object-cover"
                                                    onerror="this.onerror=null; this.parentElement.innerHTML='<i data-lucide=\\'package\\' class=\\'w-6 h-6 text-gray-400\\'></i>';"
                                                >
                                            @else
                                                <i data-lucide="package" class="w-6 h-6 text-gray-400"></i>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-500">
                                                SKU: {{ $product->sku ?: 'Sin SKU' }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ $product->type === 'variable' ? 'Variable' : 'Simple' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="font-semibold text-gray-900">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($product->categories && $product->categories->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($product->categories->take(2) as $category)
                                                <x-badge-soft 
                                                    type="info" 
                                                    :text="$category->name"
                                                    class="text-xs"
                                                />
                                            @endforeach
                                            @if($product->categories->count() > 2)
                                                <span class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">
                                                    +{{ $product->categories->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">Sin categorías</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($product->is_active)
                                        <x-badge-soft 
                                            type="success" 
                                            text="Activo"
                                        />
                                    @else
                                        <x-badge-soft 
                                            type="error" 
                                            text="Inactivo"
                                        />
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-switch-basic 
                                        switch-name="product-toggle-{{ $product->id }}"
                                        :checked="$product->is_active"
                                        value="1"
                                        data-product-id="{{ $product->id }}"
                                        data-url="{{ route('tenant.admin.products.toggle-status', [$store->slug, $product->id]) }}"
                                        class="product-toggle"
                                    />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-switch-basic 
                                        switch-name="sharing-toggle-{{ $product->id }}"
                                        :checked="$product->allow_sharing"
                                        value="1"
                                        data-product-id="{{ $product->id }}"
                                        data-url="{{ route('tenant.admin.products.toggle-sharing', [$store->slug, $product->id]) }}"
                                        class="sharing-toggle"
                                    />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-tooltip-top text="Ver detalles">
                                            <a 
                                                href="{{ route('tenant.admin.products.show', [$store->slug, $product->id]) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                aria-label="Ver detalles"
                                            >
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                        </x-tooltip-top>

                                        <x-tooltip-top text="Editar">
                                            <a 
                                                href="{{ route('tenant.admin.products.edit', [$store->slug, $product->id]) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                                aria-label="Editar"
                                            >
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                        </x-tooltip-top>

                                        <x-tooltip-top text="Eliminar">
                                            <button 
                                                type="button"
                                                @click="@if($store->isActionProtected('products', 'delete'))
                                                            requireMasterKey('products.delete', 'Eliminar producto: {{ addslashes($product->name) }}', () => deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}'))
                                                        @else
                                                            deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')
                                                        @endif"
                                                class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                aria-label="Eliminar"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </x-tooltip-top>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        @php
                                            $emptyStateSvg = 'base_ui_empty_productos.svg';
                                        @endphp
                                        <img src="{{ asset('images-ui/' . $emptyStateSvg) }}" alt="Empty state" class="w-32 h-32 mb-4" />
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay productos</h3>
                                        <p class="text-sm text-gray-600 mb-6">Comienza agregando tu primer producto</p>
                                        @if($currentCount < $maxProducts)
                                            <a href="{{ route('tenant.admin.products.create', $store->slug) }}">
                                                <x-button-icon 
                                                    type="solid" 
                                                    color="dark" 
                                                    icon="plus-circle"
                                                    size="md"
                                                    text="Crear Producto"
                                                />
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        
                        {{-- Empty State Dinámico (oculto por defecto) --}}
                        <tr id="dynamic-empty-state" style="display: none;">
                            <td colspan="8" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <img src="{{ asset('images-ui/base_ui_empty_productos.svg') }}" alt="Empty state" class="w-32 h-32 mb-4" />
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay productos</h3>
                                    <p class="text-sm text-gray-600 mb-6">Comienza agregando tu primer producto</p>
                                    @if($currentCount < $maxProducts)
                                        <a href="{{ route('tenant.admin.products.create', $store->slug) }}">
                                            <x-button-icon 
                                                type="solid" 
                                                color="dark" 
                                                icon="plus-circle"
                                                size="md"
                                                text="Crear Producto"
                                            />
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- End SECTION: Table Content --}}

            {{-- SECTION: Pagination --}}
            @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $products->links() }}
                </div>
            @endif
            {{-- End SECTION: Pagination --}}
        </div>
        {{-- End SECTION: Header Card --}}
    </div>
    {{-- End SECTION: Main Container --}}

    {{-- SECTION: Master Key Modal --}}
    <x-modal-master-key 
        modalId="master-key-modal"
        action="products.delete"
        actionLabel="Eliminar producto"
    />
    {{-- End SECTION: Master Key Modal --}}

    {{-- SECTION: Delete Confirmation Modal --}}
    <div 
        x-data="deleteModalData()"
        x-on:keydown.escape.window="closeModal()"
        @delete-product.window="openModal($event.detail.id, $event.detail.name, $event.detail.rowElement)"
    >
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
            x-cloak
        ></div>

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
            x-cloak
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 id="delete-modal-label" class="font-bold text-gray-800">
                            ¿Eliminar producto?
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

                    <div class="p-4 overflow-y-auto">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800">
                                    Se eliminará el producto <strong>"<span x-text="productName"></span>"</strong> de forma permanente.
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Esta acción no se puede deshacer.
                                </p>
                                
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
                            </div>
                        </div>
                    </div>

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
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Delete Confirmation Modal --}}

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productManagement', () => ({
                selectedProducts: [],
                filterStatus: '',
                filterType: '',
                filterCategory: '',
                searchTerm: '',

                init() {
                    // Inicializar Sortable.js para drag & drop si está disponible
                    if (typeof Sortable !== 'undefined') {
                        new Sortable(document.getElementById('sortableProducts'), {
                            handle: '.drag-handle',
                            animation: 150,
                            onEnd: () => {
                                this.updateOrder();
                            }
                        });
                    }
                },

                deleteProduct(id, name) {
                    const rowElement = document.querySelector(`tr[data-id="${id}"]`);
                    window.dispatchEvent(new CustomEvent('delete-product', {
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

                    if (this.filterCategory) {
                        params.set('category', this.filterCategory);
                    } else {
                        params.delete('category');
                    }

                    if (this.searchTerm) {
                        params.set('search', this.searchTerm);
                    } else {
                        params.delete('search');
                    }
                    
                    window.location.search = params.toString();
                },

            }));
        });

        // Toggle functionality con actualización silenciosa
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-toggle')) {
                const productId = e.target.dataset.productId;
                const url = e.target.dataset.url;
                const row = e.target.closest('tr');
                
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
                        // Actualización silenciosa: actualizar badge de estado sin recargar
                        const statusCell = row.querySelector('td:nth-child(5)');
                        if (statusCell) {
                            const isActive = e.target.checked;
                            const badgeClass = isActive 
                                ? 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-green-100 text-green-800'
                                : 'inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-red-100 text-red-800';
                            const badgeText = isActive ? 'Activo' : 'Inactivo';
                            statusCell.innerHTML = `<span class="${badgeClass}">${badgeText}</span>`;
                        }
                    } else {
                        // Revertir el toggle si hay error
                        e.target.checked = !e.target.checked;
                        // Mostrar error con componente del DesignSystem
                        window.showToast('error', data.error || 'Error al cambiar el estado');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Revertir el toggle si hay error
                    e.target.checked = !e.target.checked;
                    window.showToast('error', 'Error al cambiar el estado');
                });
            }
        });

        // Toggle de compartir con actualización silenciosa
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('sharing-toggle')) {
                const url = e.target.dataset.url;
                const newValue = e.target.checked;
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ allow_sharing: newValue })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualización silenciosa - no mostrar alerta
                    } else {
                        e.target.checked = !newValue;
                        window.showToast('error', data.error || 'Error al actualizar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    e.target.checked = !newValue;
                    window.showToast('error', 'Error al actualizar');
                });
            }
        });

        // Función para el modal de eliminación
        function deleteModalData() {
            return {
                open: false,
                productId: null,
                productName: '',
                productRow: null,
                loading: false,
                error: null,
                
                openModal(id, name, rowElement) {
                    this.productId = id;
                    this.productName = name;
                    this.productRow = rowElement;
                    this.error = null;
                    this.open = true;
                },
                
                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.productId = null;
                        this.productName = '';
                        this.productRow = null;
                        this.error = null;
                    }
                },
                
                async confirmDelete() {
                    if (!this.productId) return;
                    
                    this.loading = true;
                    this.error = null;
                    
                    try {
                        const storeSlug = '{{ $store->slug }}';
                        const response = await fetch('/' + storeSlug + '/admin/products/' + this.productId, {
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
                            throw new Error(data.error || 'Error al eliminar el producto');
                        }

                        if (data.error) {
                            throw new Error(data.error);
                        }

                        this.loading = false;
                        
                        const rowToDelete = this.productRow;
                        const productName = this.productName;
                        
                        this.closeModal();
                        
                        if (rowToDelete && rowToDelete.parentNode) {
                            rowToDelete.style.transition = 'opacity 0.3s ease-out';
                            rowToDelete.style.opacity = '0';
                            setTimeout(() => {
                                if (rowToDelete.parentNode) {
                                    rowToDelete.remove();
                                    
                                    // Verificar si quedan productos después de eliminar
                                    setTimeout(() => {
                                        const tbody = document.querySelector('tbody');
                                        if (!tbody) return;
                                        
                                        const productRows = tbody.querySelectorAll('tr[data-id]');
                                        const visibleRows = Array.from(productRows).filter(row => {
                                            const style = window.getComputedStyle(row);
                                            return style.display !== 'none' && 
                                                   row.style.opacity !== '0' && 
                                                   row.offsetParent !== null &&
                                                   !row.classList.contains('removing');
                                        });
                                        
                                        const dynamicEmptyState = document.getElementById('dynamic-empty-state');
                                        
                                        // Si no quedan productos, mostrar empty state
                                        if (visibleRows.length === 0 && dynamicEmptyState) {
                                            const thead = document.querySelector('thead');
                                            if (thead) {
                                                thead.style.display = 'none';
                                            }
                                            
                                            // Ocultar cualquier empty state de Blade que pueda estar visible
                                            const bladeEmptyStateRows = tbody.querySelectorAll('tr:not([data-id]):not(#dynamic-empty-state)');
                                            bladeEmptyStateRows.forEach(row => {
                                                if (row.id !== 'dynamic-empty-state') {
                                                    row.style.display = 'none';
                                                }
                                            });
                                            
                                            // Mostrar el empty state dinámico
                                            dynamicEmptyState.style.display = '';
                                            
                                            // Re-inicializar iconos Lucide
                                            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                                window.createIcons({ icons: window.lucideIcons });
                                            }
                                        } else {
                                            // Si hay productos, mostrar thead y ocultar empty state
                                            const thead = document.querySelector('thead');
                                            if (thead) {
                                                thead.style.display = '';
                                            }
                                            
                                            if (dynamicEmptyState) {
                                                dynamicEmptyState.style.display = 'none';
                                            }
                                        }
                                    }, 350);
                                    
                                    window.showToast('success', 'Producto eliminado exitosamente');
                                }
                            }, 300);
                        } else {
                            window.location.reload();
                            return;
                        }
                    } catch (error) {
                        this.error = error.message || 'Error al eliminar el producto';
                        this.loading = false;
                    }
                }
            };
        }

        // Inicializar iconos Lucide
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 