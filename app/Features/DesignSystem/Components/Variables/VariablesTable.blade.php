{{--
VariablesTable - Tabla de variables con checkboxes, badges y acciones
Uso: Mostrar lista de variables con información de tipo, estado, opciones y acciones
Cuándo usar: Vista index de variables
Cuándo NO usar: Cuando se necesite otra estructura de tabla
Ejemplo: <x-variables-table :variables="$variables" :store="$store" :emptyStateSvg="$emptyStateSvg" :emptyStateTitle="$emptyStateTitle" :emptyStateMessage="$emptyStateMessage" :totalVariables="$totalVariables" :variableLimit="$variableLimit" />
--}}

@props([
    'variables' => [],
    'store' => null,
    'emptyStateSvg' => 'base_ui_empty_variables.svg',
    'emptyStateTitle' => 'No hay variables disponibles',
    'emptyStateMessage' => 'Comienza agregando variables para tus productos.',
    'totalVariables' => 0,
    'variableLimit' => 0,
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
                            id="select-all-variables" 
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Variable
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
                        Opciones
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
                @forelse($variables as $variable)
                    <tr class="hover:bg-gray-50 transition-colors" data-variable-id="{{ $variable->id }}" data-products-count="{{ $variable->products_count }}">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <input 
                                type="checkbox" 
                                class="variable-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 {{ $variable->products_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                value="{{ $variable->id }}"
                                @if($variable->products_count > 0) disabled @endif
                            >
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm">
                                <div class="w-10 h-10 mr-3 flex items-center justify-center bg-gray-100 rounded-lg">
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
                                    <i data-lucide="{{ $icon }}" class="w-5 h-5 text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $variable->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        @if($variable->requiresOptions())
                                            {{ $variable->options->count() }} opciones
                                        @elseif($variable->isNumeric())
                                            @if($variable->min_value || $variable->max_value)
                                                Rango: {{ $variable->min_value ?? 0 }} - {{ $variable->max_value ?? '∞' }}
                                            @else
                                                Sin límites
                                            @endif
                                        @else
                                            Texto libre
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge-soft 
                                type="info" 
                                :text="$variable->type_name"
                            />
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($variable->is_active)
                                <x-badge-soft type="success" text="Activa" />
                            @else
                                <x-badge-soft type="error" text="Inactiva" />
                            @endif
                        </td>

                        <td class="px-6 py-4 flex items-center">
                            <label for="toggle-{{ $variable->id }}" class="relative inline-block w-11 h-6 cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    id="toggle-{{ $variable->id }}"
                                    class="peer sr-only variable-toggle"
                                    data-variable-id="{{ $variable->id }}"
                                    data-url="{{ route('tenant.admin.variables.toggle-status', [$store->slug, $variable->id]) }}"
                                    {{ $variable->is_active ? 'checked' : '' }}
                                >
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($variable->requiresOptions())
                                <x-badge-soft 
                                    type="info" 
                                    :text="(string)$variable->options->count()"
                                />
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <x-badge-soft 
                                type="info" 
                                :text="(string)$variable->products_count"
                            />
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-2 justify-center">
                                <a 
                                    href="{{ route('tenant.admin.variables.show', [$store->slug, $variable->id]) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                    aria-label="Ver detalles"
                                    title="Ver detalles"
                                >
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                <a 
                                    href="{{ route('tenant.admin.variables.edit', [$store->slug, $variable->id]) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                    aria-label="Editar"
                                    title="Editar"
                                >
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                <button 
                                    type="button"
                                    @click.stop="deleteVariable({{ $variable->id }}, '{{ addslashes($variable->name) }}', $event)"
                                    class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors variable-delete-btn {{ $variable->products_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    data-variable-id="{{ $variable->id }}"
                                    data-products-count="{{ $variable->products_count }}"
                                    aria-label="Eliminar"
                                    title="Eliminar"
                                    @if($variable->products_count > 0) disabled @endif
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12">
                            <div class="flex flex-col items-center justify-center text-center">
                                <img src="{{ $svgPath }}" alt="Empty state" class="w-32 h-32 mb-4" />
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $emptyStateTitle }}</h3>
                                <p class="text-sm text-gray-600 mb-6">{{ $emptyStateMessage }}</p>
                                @if($totalVariables < $variableLimit)
                                    <a 
                                        href="{{ route('tenant.admin.variables.create', $store->slug) }}"
                                        class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors shadow-sm"
                                    >
                                        <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                        Crear primera variable
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                
                {{-- Empty state dinámico para cuando se eliminan todas las variables mediante AJAX --}}
                <tr id="dynamic-empty-state" style="display: none;">
                    <td colspan="8" class="px-6 py-12">
                        <div class="flex flex-col items-center justify-center text-center">
                            <img src="{{ $svgPath }}" alt="Empty state" class="w-32 h-32 mb-4" />
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $emptyStateTitle }}</h3>
                            <p class="text-sm text-gray-600 mb-6">{{ $emptyStateMessage }}</p>
                            @if($totalVariables < $variableLimit)
                                <a 
                                    href="{{ route('tenant.admin.variables.create', $store->slug) }}"
                                    class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors shadow-sm"
                                >
                                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                    Crear primera variable
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

    // Toggle de estado de variable
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('variable-toggle')) {
            const variableId = e.target.dataset.variableId;
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
                    const variableManagement = Alpine.$data(document.querySelector('[x-data="variableManagement"]'));
                    if (variableManagement) {
                        variableManagement.showToggleError = true;
                        variableManagement.toggleErrorMessage = data.error || 'Error al cambiar el estado';
                        setTimeout(() => {
                            variableManagement.showToggleError = false;
                        }, 5000);
                    }
                }
            })
            .catch(error => {
                e.target.checked = !originalChecked;
                // Mostrar error con AlertBordered
                const variableManagement = Alpine.$data(document.querySelector('[x-data="variableManagement"]'));
                if (variableManagement) {
                    variableManagement.showToggleError = true;
                    variableManagement.toggleErrorMessage = 'Error al cambiar el estado';
                    setTimeout(() => {
                        variableManagement.showToggleError = false;
                    }, 5000);
                }
            });
        }
    });
});
</script>
@endpush

