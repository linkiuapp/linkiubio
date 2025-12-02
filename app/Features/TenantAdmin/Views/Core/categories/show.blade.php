{{--
Vista Show - Detalles de categoría
Layout de 2 columnas inspirado en Lovable: Ícono y Estado a la izquierda, Información General y Vista Previa SEO a la derecha
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Detalles de Categoría')

    @section('content')
    <div 
        x-data="deleteModalData()"
        class="max-w-7xl mx-auto space-y-6"
    >
        {{-- SECTION: Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.categories.index', $store->slug) }}" 
                   class="inline-flex items-center justify-center hover:bg-gray-100 p-2 rounded-lg transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600"></i>
                </a>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Detalles de Categoría</h1>
                    <p class="text-sm text-gray-500">Información completa de la categoría</p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('tenant.admin.categories.edit', [$store->slug, $category->id]) }}">
                    <button type="button" 
                            class="inline-flex items-center gap-2 px-4 py-2 border border-gray-500 text-gray-600 rounded-lg hover:bg-blue-700 hover:text-white hover:border-blue-700 transition-colors text-sm font-medium">
                        <i data-lucide="edit" class="w-4 h-4"></i>
                        Editar
                    </button>
                </a>
                <button type="button" 
                        @click="openDeleteModal()"
                        class="inline-flex items-center gap-2 px-4 py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-700 hover:text-white hover:border-red-700 transition-colors text-sm font-medium">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                    Eliminar
                </button>
            </div>
        </div>
        {{-- End SECTION: Header --}}

        {{-- Grid: 2 columnas - Izquierda (Ícono + Estado) | Derecha (Info + SEO) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          
            {{-- COLUMNA IZQUIERDA (1 columna del grid) --}}
            <div class="space-y-6">
                {{-- Card: Icono --}}
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="p-6">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Ícono</h2>
                        
                        <div class="flex items-center justify-center rounded-lg border-2 border-blue-100 bg-blue-50 p-12">
                            @if($category->icon)
                                @if(isset($category->icon->image_url))
                                    <img 
                                        src="{{ $category->icon->image_url }}" 
                                        alt="{{ e($category->icon->display_name ?? $category->icon->name ?? 'Icono') }}" 
                                        class="w-28 h-28 object-contain"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                                    >
                                    <i data-lucide="image" class="w-28 h-28 text-gray-400" style="display: none;"></i>
                                @elseif(isset($category->icon->icon))
                                    <i data-lucide="{{ e($category->icon->icon) }}" class="w-28 h-28 text-gray-400"></i>
                                @else
                                    <span class="text-7xl">📁</span>
                                @endif
                            @else
                                <span class="text-7xl">📁</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Card: Estado --}}
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="p-6">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Estado</h2>
                        
                        <div class="space-y-4">
                            {{-- Visibilidad --}}
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Visibilidad</span>
                                @if($category->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        <i data-lucide="eye" class="w-3 h-3"></i>
                                        Activa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                        <i data-lucide="eye-off" class="w-3 h-3"></i>
                                        Inactiva
                                    </span>
                                @endif
                            </div>

                            <div class="border-t border-gray-200"></div>

                            {{-- Productos --}}
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Productos</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $category->products_count ?? 0 }}</span>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            {{-- Subcategorías (solo si es categoría principal) --}}
                            @if(!$category->parent)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Subcategorías</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $category->children->count() }}</span>
                            </div>

                            <div class="border-t border-gray-200"></div>
                            @endif

                            {{-- Fechas --}}
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Creada</span>
                                    <span class="text-sm text-gray-900">
                                        {{ $category->created_at->locale('es')->isoFormat('D MMM YYYY') }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Actualizada</span>
                                    <span class="text-sm text-gray-900">
                                        {{ $category->updated_at->locale('es')->isoFormat('D MMM YYYY') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUMNA DERECHA (2 columnas del grid) --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Card: Información General --}}
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="p-6">
                        <div class="mb-6">
                            <h2 class="text-base font-semibold text-gray-900">Información General</h2>
                            <p class="text-xs text-gray-500 mt-1">Detalles y configuración de la categoría</p>
                        </div>

                        <div class="space-y-4">
                            {{-- Nombre --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-2">
                                    Nombre
                                </label>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ e($category->name) }}
                                </p>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            {{-- Slug --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-2">
                                    Slug (URL)
                                </label>
                                <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                    <code class="text-sm text-gray-900 break-all">
                                        {{ config('app.url') }}/{{ e($store->slug) }}/categoria/<span class="font-semibold text-blue-600">{{ e($category->slug) }}</span>
                                    </code>
                                </div>
                            </div>

                            <div class="border-t border-gray-200"></div>

                            {{-- Descripción --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-2">
                                    Descripción
                                </label>
                                @if($category->description)
                                    <p class="text-sm text-gray-900 leading-relaxed">
                                        {{ e($category->description) }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-500 italic">
                                        No hay descripción disponible
                                    </p>
                                @endif
                            </div>

                            <div class="border-t border-gray-200"></div>

                            {{-- Categoría Padre --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-2">
                                    Categoría Padre
                                </label>
                                @if($category->parent)
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('tenant.admin.categories.show', [$store->slug, $category->parent->id]) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-900 border border-gray-200 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors">
                                            {{ e($category->parent->name) }}
                                        </a>
                                        <span class="text-xs text-gray-500">(Subcategoría)</span>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600">
                                        Categoría principal (sin padre)
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card: Vista Previa SEO --}}
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="p-6">
                        <div class="mb-6">
                            <h2 class="text-base font-semibold text-gray-900">Vista Previa SEO</h2>
                            <p class="text-xs text-gray-500 mt-1">Cómo se verá en buscadores</p>
                        </div>

                        {{-- Google Preview --}}
                        <div class="space-y-2 rounded-lg border border-gray-200 bg-gray-50 p-5">
                            {{-- Breadcrumb --}}
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-[10px] font-bold">
                                        <i data-lucide="globe" class="w-4 h-4 text-white"></i>
                                    </span>
                                    <span>{{ e($store->name) }}</span>
                                </span>
                                <span>›</span>
                                <span>Categorías</span>
                                <span>›</span>
                                <span>{{ e($category->name) }}</span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-sm font-medium text-blue-600 hover:underline cursor-pointer">
                                {{ e($category->name) }} - {{ e($store->name) }}
                            </h3>

                            {{-- Description --}}
                            @if($category->description)
                                <p class="text-xs text-gray-700 leading-relaxed">
                                    {{ e(Str::limit($category->description, 160)) }}
                                </p>
                            @else
                                <p class="text-xs text-gray-500 italic">
                                    Explora nuestra colección de productos en esta categoría
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Card: Subcategorías (si las tiene) --}}
                @if($category->children->count() > 0)
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                    <div class="p-6">
                        <div class="mb-4">
                            <h2 class="text-base font-semibold text-gray-900">Subcategorías</h2>
                            <p class="text-xs text-gray-500 mt-1">{{ $category->children->count() }} {{ Str::plural('subcategoría', $category->children->count()) }} en esta categoría</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($category->children as $child)
                            <a href="{{ route('tenant.admin.categories.show', [$store->slug, $child->id]) }}"
                               class="block bg-gray-50 border border-gray-200 rounded-lg p-4 hover:bg-gray-100 hover:border-gray-300 transition-all group">
                                <div class="flex items-center gap-3">
                                    <div class="shrink-0 w-10 h-10 bg-white rounded-lg border border-gray-200 p-1.5 flex items-center justify-center group-hover:border-gray-300 transition-colors">
                                        @if($child->icon)
                                            @if(isset($child->icon->image_url))
                                                <img 
                                                    src="{{ $child->icon->image_url }}" 
                                                    alt="{{ e($child->icon->display_name ?? $child->icon->name ?? 'Icono') }}" 
                                                    class="w-full h-full object-contain"
                                                    loading="lazy"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                                                >
                                                <i data-lucide="folder" class="w-full h-full text-gray-400" style="display: none;"></i>
                                            @else
                                                <i data-lucide="folder" class="w-full h-full text-gray-400"></i>
                                            @endif
                                        @else
                                            <i data-lucide="folder" class="w-full h-full text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs font-medium text-gray-900 truncate group-hover:text-blue-600 transition-colors">
                                            {{ e($child->name) }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ $child->products_count ?? 0 }} {{ Str::plural('producto', $child->products_count ?? 0) }}
                                        </p>
                                    </div>
                                    <div class="shrink-0">
                                        @if($child->is_active)
                                            <span class="w-2 h-2 bg-green-500 rounded-full block" title="Activa"></span>
                                        @else
                                            <span class="w-2 h-2 bg-gray-400 rounded-full block" title="Inactiva"></span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- SECTION: Delete Confirmation Modal --}}
        <div x-on:keydown.escape.window="closeModal()">
            {{-- Modal Overlay --}}
            <div 
                x-show="open"
                x-cloak
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[9999] bg-black-500 bg-opacity-10 backdrop-blur-sm"
                @click="closeModal()"
                style="display: none;"
            ></div>

            {{-- Modal Content --}}
            <div 
                x-show="open"
                x-cloak
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[9999] overflow-x-hidden overflow-y-auto pointer-events-none"
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
                                    Se eliminará la categoría <strong>"{{ e($category->name) }}"</strong> de forma permanente.
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
        {{-- End SECTION: Delete Confirmation Modal --}}
    </div>

    @push('scripts')
    <script>
        function deleteModalData() {
            return {
                open: false,
                categoryId: {{ $category->id }},
                categoryName: {!! json_encode($category->name) !!},
                loading: false,
                error: null,
                
                openDeleteModal() {
                    this.error = null;
                    this.open = true;
                },
                
                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.error = null;
                    }
                },
                
                async confirmDelete() {
                    this.loading = true;
                    this.error = null;
                    
                    try {
                        const storeSlug = '{{ $store->slug }}';
                        const categoryId = {{ $category->id }};
                        const response = await fetch('/' + storeSlug + '/admin/categories/' + categoryId, {
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
                        this.closeModal();
                        
                        // Redirigir a la lista de categorías
                        window.location.href = '/' + storeSlug + '/admin/categories';
                    } catch (error) {
                        this.error = error.message || 'Error al eliminar la categoría';
                        this.loading = false;
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar iconos Lucide
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>