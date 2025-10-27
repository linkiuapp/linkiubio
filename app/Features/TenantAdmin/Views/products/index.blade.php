<x-tenant-admin-layout :store="$store">
    @section('title', 'Productos')

    @section('content')
    <div x-data="productManagement" class="space-y-4">
        <!-- Header con contador y botón crear -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-black-500 mb-2">Productos</h2>
                        <p class="text-sm text-black-300">
                            Usando {{ $currentCount }} de {{ $maxProducts }} productos disponibles en tu plan {{ $store->plan->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($currentCount < $maxProducts)
                            <a href="{{ route('tenant.admin.products.create', $store->slug) }}" 
                               class="btn-primary flex items-center gap-2">
                                <x-solar-add-circle-outline class="w-5 h-5" />
                                Nuevo Producto
                            </a>
                        @else
                            <button class="btn-secondary opacity-50 cursor-not-allowed flex items-center gap-2" disabled>
                                <x-solar-add-circle-outline class="w-5 h-5" />
                                Límite Alcanzado
                            </button>
                        @endif
                    </div>
                </div>
            </div>


            <!-- Barra de herramientas -->
            <div class="px-6 py-3 border-b border-accent-100 bg-accent-50">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <!-- Filtros rápidos -->
                        <select x-model="filterStatus" @change="applyFilters()" 
                                class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                            <option value="">Todos</option>
                            <option value="active">Activos</option>
                            <option value="inactive">Inactivos</option>
                        </select>
                        
                        <select x-model="filterType" @change="applyFilters()" 
                                class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                            <option value="">Todos los tipos</option>
                            <option value="simple">Productos simples</option>
                            <option value="variable">Productos variables</option>
                        </select>

                        @if($categories->count() > 0)
                        <select x-model="filterCategory" @change="applyFilters()" 
                                class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <!-- Buscador -->
                        <div class="relative">
                            <x-solar-magnifer-outline class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-black-300" />
                            <input type="text" 
                                   x-model="searchTerm"
                                   @input="applyFilters()"
                                   placeholder="Buscar productos..."
                                   class="pl-10 pr-4 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                        </div>
                        
                        <!-- Acciones masivas -->
                        <div x-show="selectedProducts.length > 0" class="flex items-center gap-2">
                            <button @click="bulkActivate()" 
                                    class="px-3 py-1.5 bg-success-400 text-accent-50 rounded-lg text-sm hover:bg-success-300 flex items-center gap-1">
                                <x-solar-check-circle-outline class="w-4 h-4" />
                                Activar
                            </button>
                            <button @click="bulkDeactivate()" 
                                    class="px-3 py-1.5 bg-warning-300 text-black-500 rounded-lg text-sm hover:bg-warning-200 flex items-center gap-1">
                                <x-solar-close-circle-outline class="w-4 h-4" />
                                Desactivar
                            </button>
                            <button @click="bulkDelete()" 
                                    class="px-3 py-1.5 bg-error-400 text-accent-50 rounded-lg text-sm hover:bg-error-300 flex items-center gap-1">
                                <x-solar-trash-bin-minimalistic-outline class="w-4 h-4" />
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de productos -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-accent-100 border-b border-accent-200">
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" 
                                       @change="toggleAll($event.target.checked)"
                                       class="rounded border-accent-300">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                                Producto
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                                Precio
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                                Categorías
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                                Estado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                                Activar/Desactivar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                                Compartir
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-accent-50 divide-y divide-accent-200">
                        @forelse($products as $product)
                            <tr class="text-black-400 hover:bg-accent-100" data-id="{{ $product->id }}">
                                <td class="px-6 py-4">
                                    <input type="checkbox" 
                                           class="product-checkbox rounded border-accent-300" 
                                           value="{{ $product->id }}"
                                           @change="toggleProduct({{ $product->id }}, $event.target.checked)">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-sm">
                                        <div class="w-12 h-12 mr-3 flex items-center justify-center bg-accent-100 rounded-lg overflow-hidden">
                                            @if($product->images && $product->images->count() > 0)
                                                <img src="{{ $product->images->first()->image_url }}" 
                                                     alt="{{ $product->name }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <x-solar-gallery-minimalistic-outline class="w-6 h-6 text-black-300" />
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $product->name }}</p>
                                            <p class="text-xs text-black-300">
                                                SKU: {{ $product->sku ?: 'Sin SKU' }}
                                            </p>
                                            <p class="text-xs text-black-200">
                                                {{ $product->type === 'variable' ? 'Variable' : 'Simple' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="font-semibold text-primary-300">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($product->categories && $product->categories->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($product->categories->take(2) as $category)
                                                <span class="text-xs bg-primary-50 text-primary-300 px-2 py-1 rounded">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                            @if($product->categories->count() > 2)
                                                <span class="text-xs bg-black-100 text-black-300 px-2 py-1 rounded">
                                                    +{{ $product->categories->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-black-200">Sin categorías</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($product->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-200 text-black-300">
                                            <x-solar-check-circle-outline class="w-3 h-3 mr-1" />
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-error-200 text-accent-50">
                                            <x-solar-close-circle-outline class="w-3 h-3 mr-1" />
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox"
                                               class="sr-only peer product-toggle"
                                               {{ $product->is_active ? 'checked' : '' }}
                                               data-product-id="{{ $product->id }}"
                                               data-url="{{ route('tenant.admin.products.toggle-status', [$store->slug, $product->id]) }}">
                                        <div class="w-11 h-6 bg-accent-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-accent-50 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-accent-50 after:border-accent-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-300"></div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox"
                                               class="sr-only peer sharing-toggle"
                                               {{ $product->allow_sharing ? 'checked' : '' }}
                                               data-product-id="{{ $product->id }}"
                                               data-url="{{ route('tenant.admin.products.toggle-sharing', [$store->slug, $product->id]) }}"
                                               onchange="toggleSharing(this)">
                                        <div class="w-11 h-6 bg-disabled-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-success-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-success-300"></div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('tenant.admin.products.show', [$store->slug, $product->id]) }}" 
                                           class="text-info-200 hover:text-info-300" title="Ver">
                                            <x-solar-eye-outline class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('tenant.admin.products.edit', [$store->slug, $product->id]) }}" 
                                           class="text-warning-200 hover:text-warning-300" title="Editar">
                                            <x-solar-pen-outline class="w-4 h-4" />
                                        </a>
                                        <button @click="@if($store->isActionProtected('products', 'delete'))
                                                            requireMasterKey('products.delete', 'Eliminar producto: {{ $product->name }}', () => deleteProduct({{ $product->id }}, '{{ $product->name }}'))
                                                        @else
                                                            deleteProduct({{ $product->id }}, '{{ $product->name }}')
                                                        @endif" 
                                                class="text-error-200 hover:text-error-300" title="Eliminar">
                                            <x-solar-trash-bin-minimalistic-outline class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <x-solar-box-outline class="w-12 h-12 text-black-200 mb-4" />
                                        <h3 class="text-lg font-medium text-black-300 mb-2">No hay productos</h3>
                                        <p class="text-sm text-black-200 mb-4">Comienza agregando tu primer producto</p>
                                        @if($currentCount < $maxProducts)
                                            <a href="{{ route('tenant.admin.products.create', $store->slug) }}" 
                                               class="btn-primary flex items-center gap-2">
                                                <x-solar-add-circle-outline class="w-5 h-5" />
                                                Crear Producto
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
                <div class="px-6 py-4 border-t border-accent-100">
                    {{ $products->links() }}
                </div>
            @endif
        </div>


    </div>

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

                async deleteProduct(id, name) {
                    const result = await Swal.fire({
                        title: '¿Eliminar producto?',
                        html: `Se eliminará el producto <strong>"${name}"</strong> de forma permanente`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ed2e45',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: '✓ Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading(),
                        preConfirm: async () => {
                            try {
                                const response = await fetch(`/{{ $store->slug }}/admin/products/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        'Accept': 'application/json',
                                    }
                                });

                                const data = await response.json();

                                if (!response.ok || !data.success) {
                                    throw new Error(data.error || 'Error al eliminar el producto');
                                }

                                return data;
                            } catch (error) {
                                Swal.showValidationMessage(error.message);
                            }
                        }
                    });

                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Eliminado!',
                            text: 'Producto eliminado exitosamente',
                            confirmButtonColor: '#00c76f',
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.reload();
                        });
                    }
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
                    
                    window.location.search = params.toString();
                },

            }));
        });

        // Toggle functionality
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-toggle')) {
                const productId = e.target.dataset.productId;
                const url = e.target.dataset.url;
                
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
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message || 'Estado actualizado correctamente',
                            confirmButtonColor: '#00c76f',
                            confirmButtonText: 'OK',
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.error || 'Error al cambiar el estado',
                            confirmButtonColor: '#ed2e45'
                        });
                        // Revertir el toggle si hay error
                        e.target.checked = !e.target.checked;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cambiar el estado',
                        confirmButtonColor: '#ed2e45'
                    });
                    // Revertir el toggle si hay error
                    e.target.checked = !e.target.checked;
                });
            }
        });

        // Toggle de compartir (función global)
        window.toggleSharing = async function(toggleElement) {
            const url = toggleElement.dataset.url;
            const newValue = toggleElement.checked;
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ allow_sharing: newValue })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    console.log('✅ Compartir actualizado:', data.message);
                    // Opcional: Mostrar toast de confirmación
                } else {
                    alert(data.error || 'Error al actualizar');
                    toggleElement.checked = !newValue;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al actualizar');
                toggleElement.checked = !newValue;
            }
        };
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 