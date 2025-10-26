<x-tenant-admin-layout :store="$store">
    @section('title', 'Categorías')

    @section('content')
    <div x-data="categoryManagement" class="space-y-4">
        <!-- Header con contador y botón crear -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-black-500 mb-2">Categorías</h2>
                        <p class="text-sm text-black-300">
                            Usando {{ $totalCategories }} de {{ $categoryLimit }} categorías disponibles en tu plan {{ $store->plan->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($totalCategories < $categoryLimit)
                            <a href="{{ route('tenant.admin.categories.create', $store->slug) }}" 
                               class="btn-primary flex items-center gap-2">
                                <x-solar-add-circle-outline class="w-5 h-5" />
                                Nueva Categoría
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
                                class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none">
                            <option value="">Todas</option>
                            <option value="active">Activas</option>
                            <option value="inactive">Inactivas</option>
                        </select>
                        
                        <select x-model="filterType" @change="applyFilters()" 
                                class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none">
                            <option value="">Todas las categorías</option>
                            <option value="main">Solo principales</option>
                            <option value="sub">Solo subcategorías</option>
                        </select>
                    </div>

                    <div class="text-sm text-black-300">
                        Mostrando {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} de {{ $categories->total() }} categorías
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- CONTENIDO PRINCIPAL --}}
            {{-- ================================================================ --}}
            
            @if($viewType === 'table')
                @include('tenant-admin::categories.components.table-view')
            @endif

            <!-- Paginación -->
            @if($categories->hasPages())
                <div class="px-6 py-4 border-t border-accent-100">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('categoryManagement', () => ({
                filterStatus: '',
                filterType: '',

                init() {
                    // Inicializar Sortable.js para drag & drop
                    if (typeof Sortable !== 'undefined') {
                        new Sortable(document.getElementById('sortableCategories'), {
                            handle: '.drag-handle',
                            animation: 150,
                            onEnd: (evt) => {
                                this.updateOrder();
                            }
                        });
                    }
                },

                async deleteCategory(id, name) {
                    const result = await Swal.fire({
                        title: '¿Eliminar categoría?',
                        html: `Se eliminará la categoría <strong>"${name}"</strong> de forma permanente`,
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
                                const response = await fetch(`/{{ $store->slug }}/admin/categories/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        'Accept': 'application/json',
                                    }
                                });

                                const data = await response.json();

                                if (!response.ok || !data.success) {
                                    throw new Error(data.error || 'Error al eliminar la categoría');
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
                            title: '¡Eliminada!',
                            text: 'Categoría eliminada exitosamente',
                            confirmButtonColor: '#00c76f',
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                },

                async toggleStatus(id) {
                    try {
                        const response = await fetch(`/{{ $store->slug }}/admin/categories/${id}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            // Recargar la página para actualizar el estado
                            window.location.reload();
                        } else {
                            alert(data.error || 'Error al cambiar el estado');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error al cambiar el estado');
                    }
                },

                async updateOrder() {
                    const rows = document.querySelectorAll('#sortableCategories tr');
                    const categories = [];

                    rows.forEach((row, index) => {
                        const id = row.dataset.id;
                        if (id) {
                            categories.push({
                                id: parseInt(id),
                                sort_order: index
                            });
                        }
                    });

                    try {
                        const response = await fetch(`/{{ $store->slug }}/admin/categories/update-order`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ categories })
                        });

                        if (!response.ok) {
                            console.error('Error al actualizar el orden');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                },

                applyFilters() {
                    // Implementar filtros con JavaScript o recargar con parámetros
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
                }
            }));
        });

        // Toggle functionality
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('category-toggle')) {
                const categoryId = e.target.dataset.categoryId;
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
                        // Recargar la página para actualizar el estado
                        window.location.reload();
                    } else {
                        alert(data.error || 'Error al cambiar el estado');
                        // Revertir el toggle si hay error
                        e.target.checked = !e.target.checked;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cambiar el estado');
                    // Revertir el toggle si hay error
                    e.target.checked = !e.target.checked;
                });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 