<x-tenant-admin-layout :store="$store">
    @section('title', 'Ver Producto')

    @section('content')
    <div class="max-w-7xl mx-auto space-y-6 mt-6">
        {{-- SECTION: Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.products.index', $store->slug) }}" class="inline-flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
                </a>
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h1>
                    @if($product->sku)
                    <span class="text-sm text-gray-600 font-mono mt-1 block">{{ $product->sku }}</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.products.edit', [$store->slug, $product->id]) }}">
                    <x-button-icon 
                        type="solid" 
                        color="dark" 
                        icon="pencil"
                        size="md"
                        text="Editar"
                    />
                </a>
            </div>
        </div>
        {{-- End SECTION: Header --}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- SECTION: Columna Principal --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- SECTION: Información del Producto Card --}}
                <x-card-base title="Información del Producto" shadow="sm">
                    <div class="space-y-4 mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                                <p class="text-sm text-gray-900">{{ $product->name }}</p>
                            </div>
                            @if($product->sku)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                                <p class="text-sm text-gray-900 font-mono">{{ $product->sku }}</p>
                            </div>
                            @endif
                        </div>
                        
                        @if($product->description)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $product->description }}</p>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                                <p class="text-lg font-semibold text-blue-600">${{ number_format($product->price, 2) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                                <p class="text-sm text-gray-900">{{ $product->type === 'simple' ? 'Producto Simple' : 'Producto Variable' }}</p>
                            </div>
                        </div>
                        
                        {{-- Categorías --}}
                        @if($product->categories && $product->categories->count() > 0)
                        <div class="pt-2 border-t border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categorías</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->categories as $category)
                                <x-badge-soft 
                                    type="info" 
                                    :text="$category->name"
                                />
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        {{-- Información adicional --}}
                        <div class="pt-2 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Creado</label>
                                    <p class="text-sm text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Actualizado</label>
                                    <p class="text-sm text-gray-900">{{ $product->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Badges de Estado y Tipo --}}
                        <div class="flex items-center gap-3 pt-2 border-t border-gray-200">
                            <x-badge-soft 
                                :type="$product->is_active ? 'success' : 'error'" 
                                :text="$product->is_active ? 'Activo' : 'Inactivo'"
                            />
                            <x-badge-soft 
                                :type="$product->type === 'simple' ? 'info' : 'warning'" 
                                :text="$product->type === 'simple' ? 'Simple' : 'Variable'"
                            />
                        </div>
                    </div>
                </x-card-base>
                {{-- End SECTION: Información del Producto Card --}}

                {{-- SECTION: Imágenes Card --}}
                @if($product->images && $product->images->count() > 0)
                <x-card-base title="Imágenes" shadow="sm">
                    <div class="mt-4">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($product->images as $image)
                            <div class="relative group">
                                <img src="{{ $image->image_url }}" 
                                     alt="{{ $product->name }}"
                                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}';"
                                     class="w-full h-32 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity"
                                     onclick="openImageModal('{{ $image->image_url }}')">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all rounded-lg flex items-center justify-center">
                                    <i data-lucide="eye" class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </div>
                                @if($image->is_main)
                                <div class="absolute top-2 left-2">
                                    <span class="bg-blue-600 text-white rounded-full px-2 py-1 text-xs font-medium">Principal</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </x-card-base>
                @endif
                {{-- End SECTION: Imágenes Card --}}

            </div>
            {{-- End SECTION: Columna Principal --}}

            {{-- SECTION: Sidebar --}}
            <div class="space-y-6">
                {{-- SECTION: Acciones Card --}}
                <x-card-base title="Acciones" shadow="sm">
                    <div class="space-y-3 mt-4">
                        <a href="{{ route('tenant.admin.products.edit', [$store->slug, $product->id]) }}" class="block w-full">
                            <x-button-icon 
                                type="solid" 
                                color="dark" 
                                icon="pencil"
                                size="md"
                                text="Editar Producto"
                                block="true"
                            />
                        </a>
                        
                        <form method="POST" action="{{ route('tenant.admin.products.toggle-status', [$store->slug, $product->id]) }}" class="w-full" id="toggle-status-form">
                            @csrf
                            <x-button-icon 
                                type="solid" 
                                :color="$product->is_active ? 'warning' : 'success'"
                                :icon="$product->is_active ? 'pause-circle' : 'play-circle'"
                                size="md"
                                :text="$product->is_active ? 'Desactivar' : 'Activar'"
                                html-type="submit"
                                block="true"
                            />
                        </form>

                        <form method="POST" action="{{ route('tenant.admin.products.destroy', [$store->slug, $product->id]) }}" 
                              class="w-full" id="delete-product-form">
                            @csrf
                            @method('DELETE')
                            <x-button-icon 
                                type="solid" 
                                color="error" 
                                icon="trash-2"
                                size="md"
                                text="Eliminar"
                                html-type="submit"
                                block="true"
                            />
                        </form>
                    </div>
                </x-card-base>
                {{-- End SECTION: Acciones Card --}}

                {{-- SECTION: Variables Card --}}
                @if($product->type === 'variable' && $product->variableAssignments && $product->variableAssignments->count() > 0)
                <x-card-base title="Variables del Producto" shadow="sm">
                    <div class="space-y-4 mt-4">
                        @foreach($product->variableAssignments as $assignment)
                            @php
                                $variable = $assignment->variable;
                                $selectedOptions = $assignment->selected_options ?? [];
                            @endphp
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start gap-3 mb-3">
                                    @php
                                        $typeIcons = [
                                            'radio' => 'radio',
                                            'checkbox' => 'check-square',
                                            'text' => 'type',
                                            'numeric' => 'hash'
                                        ];
                                        $icon = $typeIcons[$variable->type] ?? 'settings';
                                    @endphp
                                    <i data-lucide="{{ $icon }}" class="w-5 h-5 text-gray-500 mt-0.5"></i>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900">{{ $assignment->custom_label ?: $variable->name }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <x-badge-soft 
                                                type="info" 
                                                :text="$variable->type_name"
                                                class="text-xs"
                                            />
                                            @if($assignment->is_required)
                                            <x-badge-soft 
                                                type="warning" 
                                                text="Requerida"
                                                class="text-xs"
                                            />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                @if($variable->requiresOptions() && count($selectedOptions) > 0)
                                    <div class="mt-3">
                                        <label class="block text-xs font-medium text-gray-600 mb-2">Opciones seleccionadas:</label>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($variable->activeOptions->whereIn('id', $selectedOptions) as $option)
                                                <div class="flex items-center gap-2 px-2 py-1 bg-blue-50 border border-blue-200 rounded text-xs">
                                                    <span class="text-blue-900 font-medium">{{ $option->name }}</span>
                                                    @if($product->option_quantities && isset($product->option_quantities[$variable->id][$option->id]))
                                                        <span class="text-blue-700">({{ $product->option_quantities[$variable->id][$option->id] }})</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($variable->requiresOptions())
                                    <p class="text-xs text-gray-500 mt-2">Todas las opciones disponibles</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </x-card-base>
                @endif
                {{-- End SECTION: Variables Card --}}
            </div>
            {{-- End SECTION: Sidebar --}}
        </div>
    </div>

    {{-- SECTION: Modal de Imagen --}}
    <div x-data="{ open: false, imageUrl: '' }" x-on:keydown.escape.window="open = false" id="imageModalContainer">
        {{-- Modal Overlay --}}
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="open = false"
            style="display: none;"
        ></div>

        {{-- Modal Content --}}
        <div 
            x-show="open"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            style="display: none;"
        >
            <div 
                class="sm:max-w-4xl sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none"
                x-transition:enter="transition-all ease-in-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-all ease-in-out duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-2xl rounded-xl pointer-events-auto"
                >
                    {{-- Header --}}
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Vista de Imagen</h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200" 
                            aria-label="Cerrar"
                            @click="open = false"
                        >
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="p-4 overflow-y-auto">
                        <img :src="imageUrl" alt="Imagen del producto" class="max-w-full max-h-[70vh] object-contain mx-auto rounded-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Modal de Imagen --}}

    @push('scripts')
    <script>
        // Función para abrir modal de imagen
        function openImageModal(imageUrl) {
            const container = document.getElementById('imageModalContainer');
            if (container) {
                const alpineData = Alpine.$data(container);
                if (alpineData) {
                    alpineData.imageUrl = imageUrl;
                    alpineData.open = true;
                }
            }
        }

        // Interceptar formulario de toggle status
        document.addEventListener('DOMContentLoaded', function() {
            const toggleForm = document.getElementById('toggle-status-form');
            if (toggleForm) {
                toggleForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const isActive = {{ $product->is_active ? 'true' : 'false' }};
                    const action = isActive ? 'desactivar' : 'activar';
                    const actionText = action.charAt(0).toUpperCase() + action.slice(1);
                    
                    // Mostrar modal de confirmación
                    const confirmModalContainer = document.getElementById('confirm-toggle-modal-container');
                    if (confirmModalContainer) {
                        const alpineData = Alpine.$data(confirmModalContainer);
                        if (alpineData) {
                            alpineData.message = `El producto será ${action}do`;
                            alpineData.open = true;
                            
                            // Manejar confirmación
                            document.getElementById('confirm-toggle-yes').onclick = async function() {
                                alpineData.open = false;
                                
                                const url = toggleForm.action;
                                
                                try {
                                    const response = await fetch(url, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            'Accept': 'application/json'
                                        }
                                    });
                                    
                                    const data = await response.json();
                                    
                                    if (data.success) {
                                        window.showToast('success', data.message);
                                        setTimeout(() => {
                                            location.reload();
                                        }, 500);
                                    } else {
                                        window.showToast('error', data.error || 'Error al cambiar el estado');
                                    }
                                } catch (error) {
                                    window.showToast('error', 'Error al procesar la solicitud');
                                }
                            };
                        }
                    }
                });
            }
            
            // Función para mostrar modal de confirmación de eliminación
            function showDeleteConfirmation() {
                const confirmDeleteContainer = document.getElementById('confirm-delete-modal-container');
                if (confirmDeleteContainer) {
                    const alpineData = Alpine.$data(confirmDeleteContainer);
                    if (alpineData) {
                        alpineData.open = true;
                        
                        // Limpiar cualquier handler anterior
                        const yesButton = document.getElementById('confirm-delete-yes');
                        if (yesButton) {
                            yesButton.onclick = function() {
                                alpineData.open = false;
                                const deleteForm = document.getElementById('delete-product-form');
                                if (deleteForm) {
                                    deleteForm.submit();
                                }
                            };
                        }
                    }
                }
            }
            
            // Interceptar formulario de eliminación
            const deleteForm = document.getElementById('delete-product-form');
            if (deleteForm) {
                deleteForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    // Si está protegido, mostrar master key primero
                    @if($store->isActionProtected('products', 'delete'))
                        requireMasterKey('products.delete', 'Eliminar producto: {{ addslashes($product->name) }}', () => {
                            // Después de validar master key, mostrar modal de confirmación
                            showDeleteConfirmation();
                        });
                    @else
                        // Si no está protegido, mostrar directamente el modal de confirmación
                        showDeleteConfirmation();
                    @endif
                });
            }
            
            // Inicializar iconos Lucide
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    
    {{-- SECTION: Modales de Confirmación --}}
    {{-- Modal de Confirmación Toggle Status --}}
    <div x-data="{ open: false, message: '' }" x-on:keydown.escape.window="open = false" id="confirm-toggle-modal-container">
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="open = false"
            style="display: none;"
        ></div>
        <div 
            x-show="open"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            style="display: none;"
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-2xl rounded-xl pointer-events-auto"
                    x-transition:enter="transition-all ease-in-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition-all ease-in-out duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Confirmar Acción</h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none" 
                            @click="open = false"
                        >
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-4" x-text="message"></p>
                        <div class="flex justify-end gap-3">
                            <x-button-base 
                                type="outline" 
                                color="secondary" 
                                size="md"
                                text="Cancelar"
                                @click="open = false"
                            />
                            <x-button-icon 
                                type="solid" 
                                :color="$product->is_active ? 'warning' : 'success'"
                                icon="check"
                                size="md"
                                text="Confirmar"
                                id="confirm-toggle-yes"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Modal de Confirmación Eliminación --}}
    <div x-data="{ open: false }" x-on:keydown.escape.window="open = false" id="confirm-delete-modal-container">
        <div 
            x-show="open"
            x-transition:enter="transition-opacity duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="open = false"
            style="display: none;"
        ></div>
        <div 
            x-show="open"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            style="display: none;"
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-2xl rounded-xl pointer-events-auto"
                    x-transition:enter="transition-all ease-in-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition-all ease-in-out duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 class="font-bold text-gray-800">Confirmar Eliminación</h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none" 
                            @click="open = false"
                        >
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 mb-4">¿Estás seguro de que quieres eliminar este producto? Esta acción no se puede deshacer.</p>
                        <div class="flex justify-end gap-3">
                            <x-button-base 
                                type="outline" 
                                color="secondary" 
                                size="md"
                                text="Cancelar"
                                @click="open = false"
                            />
                            <x-button-icon 
                                type="solid" 
                                color="error" 
                                icon="trash-2"
                                size="md"
                                text="Eliminar"
                                id="confirm-delete-yes"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End SECTION: Modales de Confirmación --}}
    
    {{-- SECTION: Master Key Modal --}}
    <x-modal-master-key 
        modalId="master-key-modal"
        action="products.delete"
        actionLabel="Eliminar producto"
    />
    {{-- End SECTION: Master Key Modal --}}
    @endsection
</x-tenant-admin-layout> 