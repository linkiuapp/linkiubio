@extends('shared::layouts.admin')

@section('title', 'Gestión de Imágenes UI')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header Card --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        {{-- SECTION: Header --}}
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Gestión de Imágenes UI</h2>
                    <p class="text-sm text-gray-600">Administra las imágenes del sistema (SVG y WebP únicamente)</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('superlinkiu.ui-images.create', ['context' => request('context', 'store')]) }}" 
                       class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Nueva Imagen
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
                            <p class="text-sm text-gray-600">Tiendas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['store'] ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="store" class="w-5 h-5 text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Admin Tiendas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['tenant_admin'] ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="user" class="w-5 h-5 text-purple-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Sitio Web</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['website'] ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="globe" class="w-5 h-5 text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-orange-50 rounded-lg p-4 border border-orange-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Super Admin</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['super_admin'] ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="settings" class="w-5 h-5 text-orange-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End SECTION: Statistics --}}

        {{-- SECTION: Tabs (Contextos) --}}
        <div class="border-b border-gray-200" id="tabs-container">
            <nav class="flex space-x-4 px-6" aria-label="Tabs">
                @php
                    $currentContext = request('context', 'store');
                @endphp
                <button type="button"
                        data-context="store"
                        onclick="changeTab('store')"
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm {{ $currentContext === 'store' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} transition-colors">
                    Tiendas
                </button>
                <button type="button"
                        data-context="tenant_admin"
                        onclick="changeTab('tenant_admin')"
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm {{ $currentContext === 'tenant_admin' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} transition-colors">
                    Admin Tiendas
                </button>
                <button type="button"
                        data-context="website"
                        onclick="changeTab('website')"
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm {{ $currentContext === 'website' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} transition-colors">
                    Sitio Web
                </button>
                <button type="button"
                        data-context="super_admin"
                        onclick="changeTab('super_admin')"
                        class="tab-button py-4 px-1 border-b-2 font-medium text-sm {{ $currentContext === 'super_admin' ? 'border-orange-600 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} transition-colors">
                    Super Admin
                </button>
            </nav>
        </div>
        {{-- End SECTION: Tabs --}}

        {{-- SECTION: Filters (Categoría) --}}
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50" id="filters-container">
            <form method="GET" action="{{ route('superlinkiu.ui-images.index') }}" class="flex items-end gap-4" id="category-filter-form">
                <input type="hidden" name="context" value="{{ $currentContext }}" id="context-input">
                
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                    <select name="category" 
                            onchange="this.form.submit()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                            id="category-select">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $cat)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <a href="{{ route('superlinkiu.ui-images.index', ['context' => $currentContext]) }}" 
                       class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg flex items-center justify-center transition-colors"
                       title="Limpiar filtros">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    </a>
                </div>
            </form>
        </div>
        {{-- End SECTION: Filters --}}

        {{-- SECTION: Table --}}
        <div id="table-wrapper" class="relative">
            <div id="table-loading" class="hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Imagen
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Contexto
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Categoría
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Formato
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @for($i = 0; $i < 5; $i++)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg animate-pulse"></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        <div class="h-4 bg-gray-200 rounded w-32 animate-pulse"></div>
                                        <div class="h-3 bg-gray-200 rounded w-40 animate-pulse"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="h-4 bg-gray-200 rounded w-20 animate-pulse"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="h-6 bg-gray-200 rounded-full w-24 animate-pulse"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="h-6 bg-gray-200 rounded-full w-16 animate-pulse"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="h-6 bg-gray-200 rounded-full w-16 animate-pulse"></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="h-4 w-4 bg-gray-200 rounded animate-pulse"></div>
                                        <div class="h-4 w-4 bg-gray-200 rounded animate-pulse"></div>
                                    </div>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="overflow-x-auto" id="table-container">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Imagen
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Contexto
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Categoría
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Formato
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($images as $image)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                    <img src="{{ $image->url }}" 
                                         alt="{{ $image->name }}" 
                                         class="max-w-full max-h-full object-contain">
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">{{ $image->name }}</h3>
                                    @if($image->url)
                                        <a href="{{ $image->url }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="text-sm text-blue-600 hover:text-blue-800 mt-1 inline-flex items-center gap-1">
                                            <span>{{ Str::limit($image->url, 40) }}</span>
                                            <i data-lucide="external-link" class="w-3 h-3"></i>
                                        </a>
                                    @else
                                        <p class="text-sm text-gray-400 mt-1">Sin URL</p>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $contextLabels = [
                                        'store' => 'Tiendas',
                                        'tenant_admin' => 'Admin Tiendas',
                                        'website' => 'Sitio Web',
                                        'super_admin' => 'Super Admin',
                                    ];
                                @endphp
                                <span class="text-sm text-gray-900">{{ $contextLabels[$image->context] ?? $image->context }}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ ucfirst(str_replace('_', ' ', $image->category)) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ strtoupper($image->mime_type === 'image/svg+xml' ? 'SVG' : 'WebP') }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($image->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('superlinkiu.ui-images.edit', $image) }}"
                                       class="text-gray-600 hover:text-gray-800"
                                       title="Editar">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('superlinkiu.ui-images.destroy', $image) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta imagen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800"
                                                title="Eliminar">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i data-lucide="image" class="w-12 h-12 text-gray-400 mb-4"></i>
                                    <p class="text-gray-500 font-medium">No se encontraron imágenes</p>
                                    <p class="text-gray-400 text-sm mt-1">Crea tu primera imagen para comenzar</p>
                                    <a href="{{ route('superlinkiu.ui-images.create', ['context' => request('context', 'store')]) }}" 
                                       class="mt-4 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                        Agregar Primera Imagen
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
        {{-- End SECTION: Table --}}

        {{-- SECTION: Pagination --}}
        <div id="pagination-container">
            @if($images->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $images->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
        {{-- End SECTION: Pagination --}}
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    let isLoading = false;

    function changeTab(context) {
        if (isLoading) return;
        
        isLoading = true;
        const url = new URL(window.location.href);
        url.searchParams.set('context', context);
        url.searchParams.delete('page'); // Reset pagination when changing context
        
        // Show skeleton loader
        const skeletonLoader = document.getElementById('table-loading');
        const tableContainer = document.getElementById('table-container');
        if (skeletonLoader && tableContainer) {
            skeletonLoader.classList.remove('hidden');
            tableContainer.classList.add('hidden');
        }
        
        // Update active tab styling
        document.querySelectorAll('.tab-button').forEach(btn => {
            const btnContext = btn.getAttribute('data-context');
            const colorClasses = {
                'store': { active: 'border-blue-600 text-blue-600', inactive: 'border-transparent text-gray-500' },
                'tenant_admin': { active: 'border-purple-600 text-purple-600', inactive: 'border-transparent text-gray-500' },
                'website': { active: 'border-green-600 text-green-600', inactive: 'border-transparent text-gray-500' },
                'super_admin': { active: 'border-orange-600 text-orange-600', inactive: 'border-transparent text-gray-500' }
            };
            
            if (btnContext === context) {
                btn.className = `tab-button py-4 px-1 border-b-2 font-medium text-sm ${colorClasses[btnContext].active} transition-colors`;
            } else {
                btn.className = `tab-button py-4 px-1 border-b-2 font-medium text-sm ${colorClasses[btnContext].inactive} hover:text-gray-700 hover:border-gray-300 transition-colors`;
            }
        });
        
        // Update URL without reload
        window.history.pushState({ context: context }, '', url.toString());
        
        // Update context input
        document.getElementById('context-input').value = context;
        
        // Fetch new content
        fetch(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update table container
            const tableContainerEl = document.getElementById('table-container');
            const paginationContainer = document.getElementById('pagination-container');
            
            // Parse the table HTML to extract content
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data.table;
            
            const tableContent = tempDiv.querySelector('.overflow-x-auto');
            const paginationContent = tempDiv.querySelector('#pagination-container');
            
            if (tableContent && tableContainerEl) {
                tableContainerEl.innerHTML = tableContent.innerHTML;
            }
            
            if (paginationContent && paginationContainer) {
                paginationContainer.innerHTML = paginationContent.innerHTML;
            }
            
            // Update category select
            const categorySelect = document.getElementById('category-select');
            if (categorySelect) {
                const currentCategory = categorySelect.value || '';
                categorySelect.innerHTML = data.categories;
                if (currentCategory) {
                    categorySelect.value = currentCategory;
                }
            }
            
            // Reinitialize icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Hide skeleton and show table
            const skeletonLoader = document.getElementById('table-loading');
            if (skeletonLoader && tableContainerEl) {
                skeletonLoader.classList.add('hidden');
                tableContainerEl.classList.remove('hidden');
            }
            
            isLoading = false;
        })
        .catch(error => {
            console.error('Error loading tab content:', error);
            const skeletonLoader = document.getElementById('table-loading');
            const tableContainerEl = document.getElementById('table-container');
            if (skeletonLoader && tableContainerEl) {
                skeletonLoader.classList.add('hidden');
                tableContainerEl.classList.remove('hidden');
            }
            isLoading = false;
        });
    }
</script>
@endpush
@endsection
