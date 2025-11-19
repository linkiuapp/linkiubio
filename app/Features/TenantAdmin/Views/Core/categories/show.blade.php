{{--
Vista Show - Detalles de categoría
Muestra información completa de una categoría con diseño compacto
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Detalles de Categoría')

    @section('content')
    {{-- SECTION: Main Container --}}
    <div class="max-w-6xl mx-auto space-y-4">
        {{-- SECTION: Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.admin.categories.index', $store->slug) }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Detalles de Categoría</h1>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Main Card --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            {{-- SECTION: Card Header --}}
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        {{-- ITEM: Category Icon --}}
                        <div class="shrink-0 w-12 h-12 bg-white rounded-lg border border-gray-200 p-2 flex items-center justify-center">
                            @if($category->icon)
                                <img 
                                    src="{{ $category->icon->image_url }}" 
                                    alt="{{ $category->icon->display_name }}" 
                                    class="w-full h-full object-contain"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                                >
                                <i data-lucide="folder" class="w-full h-full text-gray-400" style="display: none;"></i>
                            @else
                                <i data-lucide="folder" class="w-full h-full text-gray-400"></i>
                            @endif
                        </div>
                        {{-- End ITEM: Category Icon --}}

                        {{-- ITEM: Category Info --}}
                        <div class="flex-1 min-w-0">
                            <h2 class="text-base font-semibold text-gray-900 truncate">{{ $category->name }}</h2>
                            <div class="flex items-center gap-2 flex-wrap mt-1">
                                {{-- COMPONENT: BadgeSoft | props:{type:{{ $category->is_active ? 'success' : 'error' }}, text:{{ $category->is_active ? 'Activa' : 'Inactiva' }}} --}}
                                <x-badge-soft 
                                    :type="$category->is_active ? 'success' : 'error'"
                                    :text="$category->is_active ? 'Activa' : 'Inactiva'"
                                />
                                {{-- End COMPONENT: BadgeSoft --}}

                                @if($category->parent)
                                    <span class="text-xs text-gray-500">
                                        Subcategoría de: <strong class="text-gray-700">{{ $category->parent->name }}</strong>
                                    </span>
                                @else
                                    <span class="text-xs text-gray-500">Categoría principal</span>
                                @endif
                            </div>
                        </div>
                        {{-- End ITEM: Category Info --}}
                    </div>

                    {{-- ITEM: Edit Button --}}
                    <div class="shrink-0">
                        <a href="{{ route('tenant.admin.categories.edit', [$store->slug, $category->id]) }}">
                            {{-- COMPONENT: ButtonIcon | props:{type:solid, color:dark, icon:edit, size:sm} --}}
                            <x-button-icon 
                                type="solid" 
                                color="dark" 
                                icon="edit"
                                size="sm"
                                text="Editar"
                            />
                            {{-- End COMPONENT: ButtonIcon --}}
                        </a>
                    </div>
                    {{-- End ITEM: Edit Button --}}
                </div>
            </div>
            {{-- End SECTION: Card Header --}}

            {{-- SECTION: Card Content --}}
            <div class="p-4 space-y-4">
                {{-- SECTION: Information Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- ITEM: Basic Information --}}
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Información Básica</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-xs font-medium text-gray-500">Nombre:</span>
                                <p class="text-sm text-gray-900 mt-0.5">{{ $category->name }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Slug:</span>
                                <p class="text-xs text-gray-900 font-mono mt-0.5">{{ $category->slug }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">URL:</span>
                                <p class="text-xs text-gray-900 mt-0.5">
                                    <a 
                                        href="{{ config('app.url') }}/{{ $store->slug }}/categoria/{{ $category->slug }}" 
                                        target="_blank" 
                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 hover:underline"
                                    >
                                        {{ config('app.url') }}/{{ $store->slug }}/categoria/{{ $category->slug }}
                                        <i data-lucide="external-link" class="w-3 h-3"></i>
                                    </a>
                                </p>
                            </div>
                            @if($category->description)
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Descripción:</span>
                                    <p class="text-xs text-gray-700 mt-0.5">{{ $category->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- End ITEM: Basic Information --}}

                    {{-- ITEM: Configuration --}}
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Configuración</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-xs font-medium text-gray-500">Estado:</span>
                                <p class="text-sm text-gray-900 mt-0.5">
                                    {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Tipo:</span>
                                <p class="text-sm text-gray-900 mt-0.5">
                                    {{ $category->parent ? 'Subcategoría' : 'Categoría principal' }}
                                </p>
                            </div>
                            @if($category->parent)
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Categoría padre:</span>
                                    <p class="text-sm text-gray-900 mt-0.5">
                                        <a 
                                            href="{{ route('tenant.admin.categories.show', [$store->slug, $category->parent->id]) }}" 
                                            class="text-blue-600 hover:text-blue-700 hover:underline"
                                        >
                                            {{ $category->parent->name }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- End ITEM: Configuration --}}
                </div>
                {{-- End SECTION: Information Grid --}}

                {{-- SECTION: Statistics --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Estadísticas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        {{-- ITEM: Products Stat --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Productos</p>
                                    <p class="text-lg font-bold text-gray-900 mt-0.5">{{ $category->products_count }}</p>
                                </div>
                                <i data-lucide="package" class="w-5 h-5 text-blue-600 shrink-0"></i>
                            </div>
                        </div>
                        {{-- End ITEM: Products Stat --}}

                        {{-- ITEM: Subcategories Stat --}}
                        @if(!$category->parent)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500">Subcategorías</p>
                                        <p class="text-lg font-bold text-gray-900 mt-0.5">{{ $category->children->count() }}</p>
                                    </div>
                                    <i data-lucide="folder" class="w-5 h-5 text-gray-600 shrink-0"></i>
                                </div>
                            </div>
                        @endif
                        {{-- End ITEM: Subcategories Stat --}}

                        {{-- ITEM: Created Date Stat --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Creada</p>
                                    <p class="text-xs text-gray-900 mt-0.5">{{ $category->created_at->format('d/m/Y') }}</p>
                                </div>
                                <i data-lucide="calendar" class="w-5 h-5 text-blue-600 shrink-0"></i>
                            </div>
                        </div>
                        {{-- End ITEM: Created Date Stat --}}
                    </div>
                </div>
                {{-- End SECTION: Statistics --}}

                {{-- SECTION: Subcategories --}}
                @if($category->children->count() > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Subcategorías</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($category->children as $child)
                                {{-- ITEM: Subcategory Card --}}
                                <div class="bg-white border border-gray-200 rounded-lg p-3">
                                    <div class="flex items-center gap-3">
                                        <div class="shrink-0 w-10 h-10 bg-gray-50 rounded-lg border border-gray-200 p-1.5 flex items-center justify-center">
                                            @if($child->icon)
                                                <img 
                                                    src="{{ $child->icon->image_url }}" 
                                                    alt="{{ $child->icon->display_name }}" 
                                                    class="w-full h-full object-contain"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                                                >
                                                <i data-lucide="folder" class="w-full h-full text-gray-400" style="display: none;"></i>
                                            @else
                                                <i data-lucide="folder" class="w-full h-full text-gray-400"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $child->name }}</h4>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $child->products_count }} productos</p>
                                        </div>
                                        <div class="flex items-center gap-2 shrink-0">
                                            @if($child->is_active)
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                            @else
                                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                            @endif
                                            <a 
                                                href="{{ route('tenant.admin.categories.show', [$store->slug, $child->id]) }}" 
                                                class="text-gray-400 hover:text-blue-600 transition-colors"
                                                title="Ver detalles"
                                            >
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                {{-- End ITEM: Subcategory Card --}}
                            @endforeach
                        </div>
                    </div>
                @endif
                {{-- End SECTION: Subcategories --}}

                {{-- SECTION: Metadata --}}
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex flex-wrap items-center gap-4 text-xs">
                        <div>
                            <span class="font-medium text-gray-500">Fecha de creación:</span>
                            <span class="text-gray-900 ml-1">{{ $category->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Última actualización:</span>
                            <span class="text-gray-900 ml-1">{{ $category->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Metadata --}}
            </div>
            {{-- End SECTION: Card Content --}}
        </div>
        {{-- End SECTION: Main Card --}}
    </div>
    {{-- End SECTION: Main Container --}}

    @push('scripts')
    <script>
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
