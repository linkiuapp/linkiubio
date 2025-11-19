{{--
Vista Show - Detalles de variable
Muestra información completa de una variable con diseño compacto
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Detalles de Variable')

    @section('content')
    {{-- SECTION: Main Container --}}
    <div class="max-w-6xl mx-auto space-y-4">
        {{-- SECTION: Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.admin.variables.index', $store->slug) }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Detalles de Variable</h1>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Main Card --}}
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            {{-- SECTION: Card Header --}}
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        {{-- ITEM: Variable Icon --}}
                        <div class="shrink-0 w-12 h-12 bg-white rounded-lg border border-gray-200 p-2 flex items-center justify-center">
                            @php
                                $variableNameLower = strtolower($variable->name);
                                
                                // Detectar icono según el nombre de la variable
                                if (str_contains($variableNameLower, 'color') || str_contains($variableNameLower, 'colour')) {
                                    $icon = 'palette';
                                } elseif (str_contains($variableNameLower, 'talla') || str_contains($variableNameLower, 'size') || str_contains($variableNameLower, 'tamaño')) {
                                    $icon = 'ruler';
                                } else {
                                    // Icono según tipo de variable
                                    $icon = match($variable->type) {
                                        'radio' => 'circle',
                                        'checkbox' => 'check-square',
                                        'text' => 'type',
                                        'numeric' => 'calculator',
                                        default => 'settings',
                                    };
                                }
                            @endphp
                            <i data-lucide="{{ $icon }}" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        {{-- End ITEM: Variable Icon --}}

                        {{-- ITEM: Variable Info --}}
                        <div class="flex-1 min-w-0">
                            <h2 class="text-base font-semibold text-gray-900 truncate">{{ $variable->name }}</h2>
                            <div class="flex items-center gap-2 flex-wrap mt-1">
                                {{-- COMPONENT: BadgeSoft | props:{type:{{ $variable->is_active ? 'success' : 'error' }}, text:{{ $variable->is_active ? 'Activa' : 'Inactiva' }}} --}}
                                <x-badge-soft 
                                    :type="$variable->is_active ? 'success' : 'error'"
                                    :text="$variable->is_active ? 'Activa' : 'Inactiva'"
                                />
                                {{-- End COMPONENT: BadgeSoft --}}

                                @if($variable->is_required_default)
                                    {{-- COMPONENT: BadgeSoft | props:{type:info, text:Requerida} --}}
                                    <x-badge-soft 
                                        type="info" 
                                        text="Requerida"
                                    />
                                    {{-- End COMPONENT: BadgeSoft --}}
                                @endif

                                {{-- COMPONENT: BadgeSoft | props:{type:info, text:{{ $variable->type_name }}} --}}
                                <x-badge-soft 
                                    type="info" 
                                    :text="$variable->type_name"
                                />
                                {{-- End COMPONENT: BadgeSoft --}}
                            </div>
                        </div>
                        {{-- End ITEM: Variable Info --}}
                    </div>

                    {{-- ITEM: Edit Button --}}
                    <div class="shrink-0">
                        <a href="{{ route('tenant.admin.variables.edit', [$store->slug, $variable->id]) }}">
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
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Información General</h3>
                        <div class="space-y-2">
                            <div>
                                <span class="text-xs font-medium text-gray-500">Nombre:</span>
                                <p class="text-sm text-gray-900 mt-0.5">{{ $variable->name }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Tipo:</span>
                                <p class="text-sm text-gray-900 mt-0.5">{{ $variable->type_name }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Estado:</span>
                                <p class="text-sm text-gray-900 mt-0.5">
                                    {{ $variable->is_active ? 'Activa' : 'Inactiva' }}
                                </p>
                            </div>
                            @if($variable->is_required_default)
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Requerida por defecto:</span>
                                    <p class="text-sm text-gray-900 mt-0.5">Sí</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- End ITEM: Basic Information --}}

                    {{-- ITEM: Configuration --}}
                    <div class="space-y-2">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">
                            @if($variable->type === 'numeric')
                                Configuración Numérica
                            @else
                                Configuración
                            @endif
                        </h3>
                        <div class="space-y-2">
                            @if($variable->type === 'numeric')
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Valor mínimo:</span>
                                    <p class="text-sm text-gray-900 mt-0.5">{{ $variable->min_value ?? 'Sin límite' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Valor máximo:</span>
                                    <p class="text-sm text-gray-900 mt-0.5">{{ $variable->max_value ?? 'Sin límite' }}</p>
                                </div>
                            @else
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Tipo de entrada:</span>
                                    <p class="text-sm text-gray-900 mt-0.5">
                                        @if($variable->requiresOptions())
                                            Con opciones predefinidas
                                        @else
                                            Entrada libre
                                        @endif
                                    </p>
                                </div>
                            @endif
                            <div>
                                <span class="text-xs font-medium text-gray-500">Creado:</span>
                                <p class="text-xs text-gray-900 mt-0.5">{{ $variable->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Actualizado:</span>
                                <p class="text-xs text-gray-900 mt-0.5">{{ $variable->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- End ITEM: Configuration --}}
                </div>
                {{-- End SECTION: Information Grid --}}

                {{-- SECTION: Statistics --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Estadísticas</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        {{-- ITEM: Options Stat --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Opciones</p>
                                    <p class="text-lg font-bold text-gray-900 mt-0.5">{{ $variable->options->count() }}</p>
                                </div>
                                <i data-lucide="list" class="w-5 h-5 text-blue-600 shrink-0"></i>
                            </div>
                        </div>
                        {{-- End ITEM: Options Stat --}}

                        {{-- ITEM: Products Stat --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Productos</p>
                                    <p class="text-lg font-bold text-gray-900 mt-0.5">{{ $variable->assignments()->whereHas('product')->count() }}</p>
                                </div>
                                <i data-lucide="package" class="w-5 h-5 text-blue-600 shrink-0"></i>
                            </div>
                        </div>
                        {{-- End ITEM: Products Stat --}}

                        {{-- ITEM: Created Date Stat --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Creada</p>
                                    <p class="text-xs text-gray-900 mt-0.5">{{ $variable->created_at->format('d/m/Y') }}</p>
                                </div>
                                <i data-lucide="calendar" class="w-5 h-5 text-blue-600 shrink-0"></i>
                            </div>
                        </div>
                        {{-- End ITEM: Created Date Stat --}}
                    </div>
                </div>
                {{-- End SECTION: Statistics --}}

                {{-- SECTION: Options --}}
                @if($variable->requiresOptions())
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Opciones de la Variable</h3>
                        @if($variable->options->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($variable->options as $option)
                                    {{-- ITEM: Option Card --}}
                                    {{-- COMPONENT: CardBase | props:{size:sm} --}}
                                    <x-card-base size="sm">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $option->name }}</h4>
                                                <span class="text-xs text-gray-500">#{{ $loop->iteration }}</span>
                                            </div>
                                            
                                            @if($option->price_modifier != 0)
                                                <div class="text-xs">
                                                    <span class="font-medium text-gray-500">Precio:</span>
                                                    @if($option->price_modifier > 0)
                                                        <span class="text-green-600 font-semibold">+${{ number_format($option->price_modifier, 2) }}</span>
                                                    @else
                                                        <span class="text-red-600 font-semibold">-${{ number_format(abs($option->price_modifier), 2) }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                            @if($option->color_hex)
                                                <div class="flex items-center gap-2 text-xs">
                                                    <span class="font-medium text-gray-500">Color:</span>
                                                    <span 
                                                        class="inline-block w-4 h-4 rounded border border-gray-300" 
                                                        style="background-color: {{ $option->color_hex }}"
                                                    ></span>
                                                    <span class="font-mono text-gray-600">{{ $option->color_hex }}</span>
                                                </div>
                                            @endif
                                            
                                            <div class="pt-2 border-t border-gray-200">
                                                <span class="text-xs text-gray-500">
                                                    Creado: {{ $option->created_at->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </x-card-base>
                                    {{-- End COMPONENT: CardBase --}}
                                    {{-- End ITEM: Option Card --}}
                                @endforeach
                            </div>
                        @else
                            {{-- COMPONENT: EmptyState | props:{svg:empty-options.svg, title:No hay opciones, message:Esta variable no tiene opciones configuradas} --}}
                            <x-empty-state 
                                svg="empty-options.svg"
                                title="No hay opciones"
                                message="Esta variable no tiene opciones configuradas"
                            />
                            {{-- End COMPONENT: EmptyState --}}
                        @endif
                    </div>
                @endif
                {{-- End SECTION: Options --}}

                {{-- SECTION: Metadata --}}
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex flex-wrap items-center gap-4 text-xs">
                        <div>
                            <span class="font-medium text-gray-500">Fecha de creación:</span>
                            <span class="text-gray-900 ml-1">{{ $variable->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-500">Última actualización:</span>
                            <span class="text-gray-900 ml-1">{{ $variable->updated_at->format('d/m/Y H:i') }}</span>
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
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
