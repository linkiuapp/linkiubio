{{--
CategoriesTable - Tabla de categorías con checkboxes, badges y acciones
Uso: Mostrar lista de categorías con información de tipo (principal/subcategoría), estado y acciones
Cuándo usar: Vista index de categorías
Cuándo NO usar: Cuando se necesite otra estructura de tabla
Ejemplo: <x-categories-table :categories="$categories" :store="$store" :emptyStateSvg="$emptyStateSvg" :emptyStateTitle="$emptyStateTitle" :emptyStateMessage="$emptyStateMessage" :totalCategories="$totalCategories" :categoryLimit="$categoryLimit" />
--}}

@props([
    'categories' => [],
    'store' => null,
    'emptyStateSvg' => 'base_ui_empty_categorias.svg',
    'emptyStateTitle' => 'No hay categorías disponibles',
    'emptyStateMessage' => 'Comienza agregando categorías para tus productos.',
    'totalCategories' => 0,
    'categoryLimit' => 0,
])

@php
    // Construir la ruta del SVG desde la carpeta images-ui del DesignSystem
    // Los SVG están en app/Features/DesignSystem/images-ui/
    // Se acceden a través de la ruta /images-ui/{filename} definida en routes/web.php
    $svgPath = asset('images-ui/' . ltrim($emptyStateSvg, '/'));
@endphp

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">
                        <input 
                            type="checkbox" 
                            id="select-all-categories" 
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Categoría
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Tipo
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Activar/Desactivar
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Productos
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors" data-category-id="{{ $category->id }}" data-products-count="{{ $category->products_count }}">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <input 
                                type="checkbox" 
                                class="category-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 {{ $category->products_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                value="{{ $category->id }}"
                                @if($category->products_count > 0) disabled @endif
                            >
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm">
                                @if($category->icon)
                                    <img 
                                        class="object-contain w-10 h-10 mr-3 rounded"
                                        src="{{ $category->icon->image_url }}"
                                        alt="{{ $category->icon->display_name }}"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.querySelector('i').style.display='block';"
                                    />
                                @endif
                                <div class="flex items-center">
                                    @if(!$category->icon)
                                        <i data-lucide="folder" class="w-10 h-10 mr-3 text-gray-400" style="display: none;"></i>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $category->slug }}</p>
                                        @if($category->description)
                                            <p class="text-xs text-gray-500 mt-1">{{ $category->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($category->parent)
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Subcategoría de {{ $category->parent->name }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-blue-100 text-blue-800">
                                    Principal
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($category->is_active)
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-green-100 text-green-800">
                                    Activa
                                </span>
                            @else
                                <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-red-100 text-red-800">
                                    Inactiva
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <label for="toggle-{{ $category->id }}" class="relative inline-block w-11 h-6 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="toggle-{{ $category->id }}"
                                    class="peer sr-only category-toggle"
                                    data-category-id="{{ $category->id }}"
                                    data-url="{{ route('tenant.admin.categories.toggle-status', [$store->slug, $category->id]) }}"
                                    {{ $category->is_active ? 'checked' : '' }}
                                >
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $category->products_count }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2">
                                <a 
                                    href="{{ route('tenant.admin.categories.show', [$store->slug, $category->id]) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                    aria-label="Ver detalles"
                                    title="Ver detalles"
                                >
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                <a 
                                    href="{{ route('tenant.admin.categories.edit', [$store->slug, $category->id]) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                    aria-label="Editar"
                                    title="Editar"
                                >
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                <button 
                                    type="button"
                                    @click.stop="deleteCategory({{ $category->id }}, '{{ addslashes($category->name) }}', $event)"
                                    class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors category-delete-btn {{ $category->products_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    data-category-id="{{ $category->id }}"
                                    data-products-count="{{ $category->products_count }}"
                                    aria-label="Eliminar"
                                    title="Eliminar"
                                    @if($category->products_count > 0) disabled @endif
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12">
                            <div class="flex flex-col items-center justify-center text-center">
                                <img src="{{ $svgPath }}" alt="Empty state" class="w-32 h-32 mb-4" />
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $emptyStateTitle }}</h3>
                                <p class="text-sm text-gray-600 mb-6">{{ $emptyStateMessage }}</p>
                                @if($totalCategories < $categoryLimit)
                                    <a 
                                        href="{{ route('tenant.admin.categories.create', $store->slug) }}"
                                        class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors shadow-sm"
                                    >
                                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                        Crear primera categoría
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                
                {{-- Empty state dinámico para cuando se eliminan todas las categorías mediante AJAX --}}
                <tr id="dynamic-empty-state" style="display: none;">
                    <td colspan="7" class="px-6 py-12">
                        <div class="flex flex-col items-center justify-center text-center">
                            <img src="{{ $svgPath }}" alt="Empty state" class="w-32 h-32 mb-4" />
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $emptyStateTitle }}</h3>
                            <p class="text-sm text-gray-600 mb-6">{{ $emptyStateMessage }}</p>
                            @if($totalCategories < $categoryLimit)
                                <a 
                                    href="{{ route('tenant.admin.categories.create', $store->slug) }}"
                                    class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors shadow-sm"
                                >
                                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                    Crear primera categoría
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }

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

