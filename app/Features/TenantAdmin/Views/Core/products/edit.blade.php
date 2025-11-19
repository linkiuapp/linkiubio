<x-tenant-admin-layout :store="$store">
    @section('title', 'Editar Producto')

    @section('content')
    <div class="max-w-6xl mx-auto space-y-6 mt-6">
        {{-- SECTION: Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.products.index', $store->slug) }}" class="inline-flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
                </a>
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Editar Producto</h1>
                    <p class="text-sm text-gray-600 mt-1">{{ $product->name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>
        {{-- End SECTION: Header --}}

        <form method="POST" action="{{ route('tenant.admin.products.update', [$store->slug, $product->id]) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            {{-- SECTION: Información Básica Card --}}
            <x-card-base title="Información Básica" shadow="sm">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- ITEM: Nombre --}}
                        <x-ds.text-input
                            type="text"
                            name="name"
                            id="name"
                            label="Nombre del Producto"
                            placeholder="Ej: Camiseta Básica Blanca"
                            :value="old('name', $product->name)"
                            :required="true"
                            :error="$errors->first('name')"
                        />
                        {{-- End ITEM: Nombre --}}

                        {{-- ITEM: SKU --}}
                        <x-ds.text-input
                            type="text"
                            name="sku"
                            id="sku"
                            label="SKU (Código)"
                            placeholder="Ej: CAM-BAS-001"
                            :value="old('sku', $product->sku)"
                            :error="$errors->first('sku')"
                        />
                        {{-- End ITEM: SKU --}}
                    </div>

                    {{-- ITEM: Descripción --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-800 mb-2">
                            Descripción
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror"
                            placeholder="Describe las características principales del producto...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- End ITEM: Descripción --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- ITEM: Precio --}}
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-800 mb-2">
                                Precio <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-gray-500">$</span>
                                <input 
                                    type="number" 
                                    id="price" 
                                    name="price" 
                                    value="{{ old('price', $product->price) }}"
                                    min="0" 
                                    step="0.01"
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-300 @enderror"
                                    placeholder="15000"
                                    required>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- End ITEM: Precio --}}

                        {{-- ITEM: Tipo --}}
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-800 mb-2">
                                Tipo de Producto <span class="text-red-500">*</span>
                            </label>
                            <x-select-basic 
                                name="type"
                                select-id="type"
                                label="Tipo de Producto"
                                :options="[
                                    '' => 'Selecciona un tipo',
                                    'simple' => 'Simple',
                                    'variable' => 'Variable'
                                ]"
                                :selected="old('type', $product->type)"
                                placeholder=""
                                :error="$errors->first('type')"
                                :required="true"
                            />
                        </div>
                        {{-- End ITEM: Tipo --}}
                    </div>

                    {{-- ITEM: Estado Activo --}}
                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <x-switch-basic 
                            switch-name="is_active"
                            :checked="old('is_active', $product->is_active)"
                            value="1"
                        />
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-800">Producto activo</span>
                            <p class="text-xs text-gray-500">El producto estará visible en tu tienda</p>
                        </div>
                    </div>
                    {{-- End ITEM: Estado Activo --}}
                </div>
            </x-card-base>
            {{-- End SECTION: Información Básica Card --}}

            {{-- SECTION: Imágenes Actuales Card --}}
            @if($product->images && $product->images->count() > 0)
            <x-card-base title="Imágenes Actuales" shadow="sm">
                <div class="space-y-4 mt-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                        <div class="relative group">
                            <img src="{{ $image->image_url }}" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}';" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                            <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <label class="flex items-center bg-red-600 text-white rounded-full p-1 cursor-pointer hover:bg-red-700">
                                    <input type="checkbox" 
                                           name="delete_images[]" 
                                           value="{{ $image->id }}" 
                                           class="sr-only delete-image-checkbox"
                                           onchange="toggleImageForDeletion(this)">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </label>
                            </div>
                            <div class="absolute bottom-1 left-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($image->is_main)
                                <span class="bg-blue-600 text-white rounded-full px-2 py-1 text-xs font-medium">
                                    Principal
                                </span>
                                @else
                                <button type="button" 
                                        onclick="setMainImage({{ $image->id }})"
                                        class="bg-gray-900 bg-opacity-75 text-white rounded-full px-2 py-1 text-xs hover:bg-opacity-100 transition-opacity">
                                    Hacer principal
                                </button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-600 mt-4">
                        Marca las imágenes que deseas eliminar con el ícono de basura. Las imágenes marcadas se eliminarán al guardar.
                    </p>
                </div>
            </x-card-base>
            @endif
            {{-- End SECTION: Imágenes Actuales Card --}}

            {{-- SECTION: Nuevas Imágenes Card --}}
            <x-card-base title="Agregar Nuevas Imágenes" shadow="sm">
                <div class="space-y-4 mt-4">
                    <div 
                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200 cursor-pointer" 
                        id="image-upload-area"
                        onclick="document.getElementById('images').click()"
                    >
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="cloud-upload" class="w-12 h-12 text-gray-400"></i>
                            <div>
                                <p class="text-base text-gray-700 mb-2">Arrastra y suelta las imágenes aquí o</p>
                                <p class="text-gray-900 text-base font-semibold">haz clic para seleccionar</p>
                                <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                            </div>
                            <p class="text-sm text-gray-500">Soporta múltiples imágenes (JPG, PNG, WEBP)</p>
                        </div>
                    </div>
                    <div id="image-previews" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                </div>
            </x-card-base>
            {{-- End SECTION: Nuevas Imágenes Card --}}

            {{-- SECTION: Categorías Card --}}
            @if($categories->count() > 0)
            <x-card-base title="Categorías" shadow="sm">
                <div class="space-y-4 mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($categories as $category)
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input 
                                type="checkbox" 
                                name="categories[]" 
                                value="{{ $category->id }}"
                                {{ $product->categories->contains($category->id) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            >
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-800">{{ $category->name }}</span>
                                @if($category->description)
                                <p class="text-xs text-gray-500 mt-1">{{ $category->description }}</p>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <a href="{{ route('tenant.admin.categories.create', $store->slug) }}" 
                           class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-sm font-medium">
                            <i data-lucide="plus-circle" class="w-4 h-4"></i>
                            Crear nueva categoría
                        </a>
                    </div>
                </div>
            </x-card-base>
            @endif
            {{-- End SECTION: Categorías Card --}}

            {{-- SECTION: Variables Card (solo para productos variables) --}}
            <x-card-base shadow="sm" id="variables-section" style="display: {{ $product->type === 'variable' ? 'block' : 'none' }};">
                <div class="mt-4 mb-4 pb-4 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Variables del Producto</h3>
                            <p class="text-sm text-gray-600 mt-1">Asigna variables personalizables a este producto</p>
                        </div>
                        @if($variables->count() == 0)
                            <a href="{{ route('tenant.admin.variables.index', $store->slug) }}" 
                               class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1 font-medium">
                                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                Crear Variable
                            </a>
                        @endif
                    </div>
                    
                    @if($variables->count() > 0)
                        {{-- SECTION: Contador y Acciones Rápidas --}}
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-600">
                                    Variables seleccionadas: <strong id="selected-variables-count" class="text-gray-900">0</strong>
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button 
                                    type="button"
                                    id="select-all-variables"
                                    class="text-xs text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1"
                                >
                                    <i data-lucide="check-square" class="w-3 h-3"></i>
                                    Seleccionar todas
                                </button>
                                <span class="text-gray-300">|</span>
                                <button 
                                    type="button"
                                    id="deselect-all-variables"
                                    class="text-xs text-gray-600 hover:text-gray-700 font-medium flex items-center gap-1"
                                >
                                    <i data-lucide="square" class="w-3 h-3"></i>
                                    Deseleccionar todas
                                </button>
                            </div>
                        </div>
                        {{-- End SECTION: Contador y Acciones Rápidas --}}
                        
                        {{-- SECTION: Búsqueda --}}
                        <div class="mt-3">
                            <div class="relative">
                                <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                <input 
                                    type="text"
                                    id="variable-search-input"
                                    placeholder="Buscar variables por nombre..."
                                    class="w-full pl-10 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                            </div>
                        </div>
                        {{-- End SECTION: Búsqueda --}}
                    @endif
                </div>
                
                <div class="space-y-4" id="variables-container">
                    @if($variables->count() > 0)
                        @php
                            $groupedVariables = $variables->groupBy('type');
                        @endphp
                        
                        @foreach($groupedVariables as $type => $typeVariables)
                            {{-- SECTION: Grupo por Tipo --}}
                            <div class="variable-group" data-type="{{ $type }}">
                                <div class="mb-3 flex items-center gap-2">
                                    <h4 class="text-sm font-semibold text-gray-700">
                                        {{ \App\Features\TenantAdmin\Models\ProductVariable::TYPES[$type] ?? $type }}
                                        <span class="text-gray-500 font-normal">({{ $typeVariables->count() }})</span>
                                    </h4>
                                </div>
                                
                                <div class="space-y-3">
                                    @foreach($typeVariables as $variable)
                                        @php
                                            $assignment = $product->variableAssignments->firstWhere('variable_id', $variable->id);
                                            $isAssigned = $assignment !== null;
                                            $selectedOptions = $isAssigned && $assignment->selected_options ? $assignment->selected_options : [];
                                        @endphp
                                        <div 
                                            class="variable-card border rounded-lg p-4 transition-all duration-200 {{ $isAssigned ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300 bg-white' }}"
                                            data-variable-id="{{ $variable->id }}"
                                            data-variable-name="{{ strtolower($variable->name) }}"
                                        >
                                            <div class="flex items-start gap-4">
                                                {{-- Checkbox para seleccionar variable --}}
                                                <div class="flex items-center h-6 pt-0.5">
                                                    <input 
                                                        type="checkbox" 
                                                        id="variable_{{ $variable->id }}"
                                                        name="variables[{{ $variable->id }}][enabled]"
                                                        value="1"
                                                        {{ $isAssigned ? 'checked' : '' }}
                                                        class="variable-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                        data-variable-id="{{ $variable->id }}"
                                                    >
                                                </div>
                                                
                                                {{-- Info de la variable --}}
                                                <div class="flex-1">
                                                    <label for="variable_{{ $variable->id }}" class="cursor-pointer flex items-center gap-2 mb-2">
                                                        @php
                                                            $typeIcons = [
                                                                'radio' => 'radio',
                                                                'checkbox' => 'check-square',
                                                                'text' => 'type',
                                                                'numeric' => 'hash'
                                                            ];
                                                            $icon = $typeIcons[$variable->type] ?? 'settings';
                                                        @endphp
                                                        <i data-lucide="{{ $icon }}" class="w-4 h-4 text-gray-500"></i>
                                                        <h4 class="text-sm font-medium text-gray-800">{{ $variable->name }}</h4>
                                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded text-xs font-medium">{{ $variable->type_name }}</span>
                                                        @if($variable->is_active)
                                                            <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded text-xs font-medium">Activa</span>
                                                        @else
                                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs font-medium">Inactiva</span>
                                                        @endif
                                                        @if($variable->assignments_count > 0)
                                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-xs font-medium">
                                                                {{ $variable->assignments_count }} producto(s)
                                                            </span>
                                                        @endif
                                                    </label>
                                                    @if($variable->requiresOptions())
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            {{ $variable->activeOptions->count() }} opciones disponibles
                                                        </p>
                                                    @endif
                                                    
                                                    {{-- Opciones de la variable (se muestran al seleccionar) --}}
                                                    <div 
                                                        class="mt-3 space-y-3 variable-options transition-all duration-200" 
                                                        id="options_{{ $variable->id }}"
                                                        style="display: {{ $isAssigned ? 'block' : 'none' }}; opacity: {{ $isAssigned ? '1' : '0' }}; transform: {{ $isAssigned ? 'translateY(0)' : 'translateY(-10px)' }};"
                                                    >
                                                        {{-- Opciones disponibles para seleccionar --}}
                                                        @if($variable->requiresOptions() && $variable->activeOptions->count() > 0)
                                                            <div class="bg-white border border-gray-200 rounded-lg p-3">
                                                                <label class="text-xs font-semibold text-gray-700 mb-2 block">
                                                                    Selecciona las opciones que usará este producto <span class="text-red-500">*</span>
                                                                </label>
                                                                <div class="space-y-2">
                                                                    @foreach($variable->activeOptions as $option)
                                                                        @php
                                                                            // Obtener cantidad existente del producto
                                                                            $existingQuantity = 0;
                                                                            if ($product->option_quantities && isset($product->option_quantities[$variable->id][$option->id])) {
                                                                                $existingQuantity = (int) $product->option_quantities[$variable->id][$option->id];
                                                                            }
                                                                        @endphp
                                                                        <div class="flex items-center gap-3 p-2 rounded border border-gray-200 hover:border-blue-300 transition-colors option-item {{ in_array($option->id, $selectedOptions) ? 'border-blue-300 bg-blue-50' : '' }}" data-option-id="{{ $option->id }}" data-variable-id="{{ $variable->id }}">
                                                                            <label class="flex items-center gap-2 cursor-pointer flex-1">
                                                                                <input 
                                                                                    type="checkbox" 
                                                                                    name="variables[{{ $variable->id }}][options][]"
                                                                                    value="{{ $option->id }}"
                                                                                    {{ in_array($option->id, $selectedOptions) ? 'checked' : '' }}
                                                                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 variable-option-checkbox"
                                                                                    data-variable-id="{{ $variable->id }}"
                                                                                    data-option-id="{{ $option->id }}"
                                                                                >
                                                                                <span class="text-sm text-gray-700 font-medium">{{ $option->name }}</span>
                                                                            </label>
                                                                            <div class="option-quantity-field" style="display: {{ in_array($option->id, $selectedOptions) ? 'flex' : 'none' }}; align-items: center;">
                                                                                <label class="text-xs text-gray-600 mr-2">Cantidad:</label>
                                                                                <input 
                                                                                    type="number" 
                                                                                    name="variables[{{ $variable->id }}][quantities][{{ $option->id }}]"
                                                                                    value="{{ $existingQuantity }}"
                                                                                    min="0"
                                                                                    step="1"
                                                                                    placeholder="0"
                                                                                    class="w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 option-quantity-input"
                                                                                    data-option-id="{{ $option->id }}"
                                                                                >
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <p 
                                                                    class="text-xs text-red-600 mt-2 flex items-center gap-1 variable-error-{{ $variable->id }}"
                                                                    style="display: none;"
                                                                >
                                                                    <i data-lucide="alert-circle" class="w-3 h-3"></i>
                                                                    Debes seleccionar al menos una opción
                                                                </p>
                                                            </div>
                                                        @endif
                                                        
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                            {{-- Toggle Requerido --}}
                                                            <div class="flex items-center gap-2">
                                                                <input type="hidden" name="variables[{{ $variable->id }}][is_required]" value="0">
                                                                <x-switch-basic 
                                                                    switch-name="variables[{{ $variable->id }}][is_required]"
                                                                    :checked="$isAssigned ? ($assignment->is_required ?? false) : ($variable->is_required_default ?? false)"
                                                                    value="1"
                                                                />
                                                                <label class="text-sm text-gray-700 cursor-pointer">
                                                                    Campo requerido
                                                                </label>
                                                            </div>
                                                            
                                                            {{-- Orden de visualización --}}
                                                            <div>
                                                                <label class="text-xs text-gray-600 mb-1 block">Orden</label>
                                                                <input 
                                                                    type="number" 
                                                                    name="variables[{{ $variable->id }}][display_order]"
                                                                    value="{{ $isAssigned ? ($assignment->display_order ?? $loop->iteration) : $loop->iteration }}"
                                                                    min="1"
                                                                    class="w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                                >
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- Etiqueta personalizada --}}
                                                        <div>
                                                            <label class="text-xs text-gray-600 mb-1 block">Etiqueta personalizada (opcional)</label>
                                                            <input 
                                                                type="text" 
                                                                name="variables[{{ $variable->id }}][custom_label]"
                                                                value="{{ $isAssigned ? ($assignment->custom_label ?? '') : '' }}"
                                                                placeholder="Ej: Selecciona tu color favorito"
                                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {{-- End SECTION: Grupo por Tipo --}}
                        @endforeach
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i data-lucide="settings" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
                            <p class="text-sm mb-2">No hay variables creadas</p>
                            <a href="{{ route('tenant.admin.variables.index', $store->slug) }}" 
                               class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Crear primera variable
                            </a>
                        </div>
                    @endif
                </div>
            </x-card-base>
            {{-- End SECTION: Variables Card --}}

            {{-- SECTION: Action Buttons --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex justify-end gap-3">
                    <a href="{{ route('tenant.admin.products.show', [$store->slug, $product->id]) }}">
                        <x-button-base 
                            type="outline" 
                            color="error" 
                            size="md"
                            text="Cancelar"
                        />
                    </a>
                    <x-button-icon 
                        type="solid" 
                        color="dark" 
                        icon="check"
                        size="md"
                        text="Actualizar Producto"
                        html-type="submit"
                    />
                </div>
            </div>
            {{-- End SECTION: Action Buttons --}}
        </form>
    </div>

    @push('scripts')
    <script>
        // Gestión de Variables con JavaScript vanilla
        (function() {
            let selectedVariables = {};
            let searchTerm = '';
            
            function initVariables() {
                // Inicializar variables seleccionadas basándose en las asignaciones existentes
                @if($variables->count() > 0)
                    @foreach($variables as $variable)
                        @php
                            $assignment = $product->variableAssignments->firstWhere('variable_id', $variable->id);
                            $isAssigned = $assignment !== null;
                        @endphp
                        selectedVariables[{{ $variable->id }}] = {{ $isAssigned ? 'true' : 'false' }};
                    @endforeach
                @endif
                
                updateSelectedCount();
                setupEventListeners();
                
                // Inicializar visualización de opciones para variables ya seleccionadas
                Object.keys(selectedVariables).forEach(variableId => {
                    if (selectedVariables[variableId]) {
                        const checkbox = document.getElementById('variable_' + variableId);
                        if (checkbox && checkbox.checked) {
                            toggleVariable(parseInt(variableId), true);
                        }
                    }
                });
            }
            
            function setupEventListeners() {
                // Checkboxes de variables
                document.querySelectorAll('.variable-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const variableId = parseInt(this.dataset.variableId);
                        const isChecked = this.checked;
                        toggleVariable(variableId, isChecked);
                    });
                });
                
                // Checkboxes de opciones
                document.querySelectorAll('.variable-option-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const variableId = parseInt(this.dataset.variableId);
                        const optionId = parseInt(this.dataset.optionId);
                        const isChecked = this.checked;
                        
                        // Mostrar/ocultar campo de cantidad
                        const optionItem = this.closest('.option-item');
                        if (optionItem) {
                            const quantityField = optionItem.querySelector('.option-quantity-field');
                            if (quantityField) {
                                if (isChecked) {
                                    quantityField.style.display = 'flex';
                                    quantityField.style.alignItems = 'center';
                                } else {
                                    quantityField.style.display = 'none';
                                    // Resetear cantidad cuando se deselecciona
                                    const quantityInput = quantityField.querySelector('.option-quantity-input');
                                    if (quantityInput) {
                                        quantityInput.value = '0';
                                    }
                                }
                            }
                        }
                        
                        validateVariableOptions(variableId);
                    });
                });
                
                // Botones de seleccionar/deseleccionar todas
                const selectAllBtn = document.getElementById('select-all-variables');
                const deselectAllBtn = document.getElementById('deselect-all-variables');
                
                if (selectAllBtn) {
                    selectAllBtn.addEventListener('click', selectAllVariables);
                }
                
                if (deselectAllBtn) {
                    deselectAllBtn.addEventListener('click', deselectAllVariables);
                }
                
                // Búsqueda
                const searchInput = document.getElementById('variable-search-input');
                if (searchInput) {
                    let searchTimeout;
                    searchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            searchTerm = this.value.toLowerCase();
                            filterVariables();
                        }, 300);
                    });
                }
                
                // Mostrar/ocultar sección de variables según el tipo de producto
                const typeSelect = document.getElementById('type');
                if (typeSelect) {
                    typeSelect.addEventListener('change', function() {
                        const variablesSection = document.getElementById('variables-section');
                        if (variablesSection) {
                            if (this.value === 'variable') {
                                variablesSection.style.display = 'block';
                            } else {
                                variablesSection.style.display = 'none';
                            }
                        }
                    });
                }
            }
            
            function toggleVariable(variableId, isChecked) {
                selectedVariables[variableId] = isChecked;
                
                const variableCard = document.querySelector(`[data-variable-id="${variableId}"]`);
                const optionsDiv = document.getElementById(`options_${variableId}`);
                
                if (variableCard) {
                    if (isChecked) {
                        variableCard.classList.remove('border-gray-200', 'bg-white');
                        variableCard.classList.add('border-blue-500', 'bg-blue-50');
                        if (optionsDiv) {
                            optionsDiv.style.display = 'block';
                            optionsDiv.style.opacity = '1';
                            optionsDiv.style.transform = 'translateY(0)';
                        }
                    } else {
                        variableCard.classList.remove('border-blue-500', 'bg-blue-50');
                        variableCard.classList.add('border-gray-200', 'bg-white');
                        if (optionsDiv) {
                            optionsDiv.style.display = 'none';
                        }
                        
                        // Ocultar campos de cantidad y deseleccionar opciones cuando se deselecciona la variable
                        const optionItems = variableCard.querySelectorAll('.option-item');
                        optionItems.forEach(item => {
                            const checkbox = item.querySelector('.variable-option-checkbox');
                            const quantityField = item.querySelector('.option-quantity-field');
                            if (checkbox && checkbox.checked) {
                                checkbox.checked = false;
                            }
                            if (quantityField) {
                                quantityField.style.display = 'none';
                                const quantityInput = quantityField.querySelector('.option-quantity-input');
                                if (quantityInput) {
                                    quantityInput.value = '0';
                                }
                            }
                        });
                        
                        // Limpiar errores
                        const errorMsg = document.querySelector(`.variable-error-${variableId}`);
                        if (errorMsg) {
                            errorMsg.style.display = 'none';
                        }
                    }
                }
                
                updateSelectedCount();
            }
            
            function updateSelectedCount() {
                const count = Object.values(selectedVariables).filter(v => v).length;
                const countElement = document.getElementById('selected-variables-count');
                if (countElement) {
                    countElement.textContent = count;
                }
            }
            
            function selectAllVariables() {
                document.querySelectorAll('.variable-checkbox').forEach(function(checkbox) {
                    const variableId = parseInt(checkbox.dataset.variableId);
                    if (checkbox && !checkbox.checked) {
                        checkbox.checked = true;
                        selectedVariables[variableId] = true;
                        toggleVariable(variableId, true);
                    }
                });
            }
            
            function deselectAllVariables() {
                document.querySelectorAll('.variable-checkbox').forEach(function(checkbox) {
                    const variableId = parseInt(checkbox.dataset.variableId);
                    if (checkbox && checkbox.checked) {
                        checkbox.checked = false;
                        selectedVariables[variableId] = false;
                        toggleVariable(variableId, false);
                    }
                });
            }
            
            function filterVariables() {
                const variableCards = document.querySelectorAll('.variable-card');
                variableCards.forEach(card => {
                    const variableName = card.dataset.variableName || '';
                    if (!searchTerm || variableName.includes(searchTerm)) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 10);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 200);
                    }
                });
            }
            
            function validateVariableOptions(variableId) {
                const checkboxes = document.querySelectorAll(`input[name="variables[${variableId}][options][]"]:checked`);
                const errorMsg = document.querySelector(`.variable-error-${variableId}`);
                
                if (checkboxes.length === 0 && errorMsg) {
                    errorMsg.style.display = 'flex';
                } else if (errorMsg) {
                    errorMsg.style.display = 'none';
                }
            }
            
            // Función para validar antes de submit
            window.validateVariablesForm = function() {
                const typeSelect = document.getElementById('type');
                if (!typeSelect || typeSelect.value !== 'variable') {
                    return true;
                }
                
                const selectedCount = Object.values(selectedVariables).filter(v => v).length;
                
                if (selectedCount === 0) {
                    window.showToast('error', 'Debes seleccionar al menos una variable para productos variables');
                    return false;
                }
                
                // Validar que cada variable seleccionada tenga al menos una opción
                let hasErrors = false;
                document.querySelectorAll('.variable-option-checkbox').forEach(checkbox => {
                    const variableId = parseInt(checkbox.dataset.variableId);
                    if (selectedVariables[variableId]) {
                        const variableOptions = document.querySelectorAll(`input[name="variables[${variableId}][options][]"]:checked`);
                        if (variableOptions.length === 0) {
                            const errorMsg = document.querySelector(`.variable-error-${variableId}`);
                            if (errorMsg) {
                                errorMsg.style.display = 'flex';
                                hasErrors = true;
                            }
                        }
                    }
                });
                
                return !hasErrors;
            };
            
            // Inicializar cuando el DOM esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initVariables);
            } else {
                initVariables();
            }
        })();
        
        // Validación del formulario antes de submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const typeSelect = document.getElementById('type');
            if (typeSelect && typeSelect.value === 'variable') {
                if (typeof window.validateVariablesForm === 'function') {
                    if (!window.validateVariablesForm()) {
                        e.preventDefault();
                        return false;
                    }
                }
            }
        });
        
        // Inicializar iconos Lucide al cargar
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
            
            // Inicializar drag & drop para nuevas imágenes
            initImageUpload();
        });
        
        // Función para marcar/desmarcar imágenes para eliminar
        function toggleImageForDeletion(checkbox) {
            const imageDiv = checkbox.closest('.group');
            if (checkbox.checked) {
                imageDiv.classList.add('opacity-50');
                imageDiv.querySelector('img').style.filter = 'grayscale(100%)';
            } else {
                imageDiv.classList.remove('opacity-50');
                imageDiv.querySelector('img').style.filter = 'none';
            }
        }
        
        // Función para establecer imagen principal
        async function setMainImage(imageId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ url($store->slug . "/admin/products/" . $product->id . "/set-main-image") }}';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="image_id" value="${imageId}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
        
        // Inicializar drag & drop para nuevas imágenes
        function initImageUpload() {
            const uploadArea = document.getElementById('image-upload-area');
            const fileInput = document.getElementById('images');
            const previewsContainer = document.getElementById('image-previews');
            
            if (!uploadArea || !fileInput || !previewsContainer) return;
            
            let selectedFiles = [];
            
            // Click en el área de upload
            uploadArea.addEventListener('click', () => fileInput.click());
            
            // Drag & drop
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('bg-blue-50', 'border-blue-400');
            });
            
            uploadArea.addEventListener('dragleave', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('bg-blue-50', 'border-blue-400');
            });
            
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('bg-blue-50', 'border-blue-400');
                const files = Array.from(e.dataTransfer.files);
                handleFiles(files);
            });
            
            // Selección de archivos
            fileInput.addEventListener('change', (e) => {
                const files = Array.from(e.target.files);
                handleFiles(files);
            });
            
            function handleFiles(files) {
                files.forEach(file => {
                    if (file.type.startsWith('image/')) {
                        selectedFiles.push(file);
                        createImagePreview(file);
                    }
                });
                updateFileInput();
            }
            
            function createImagePreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'relative group';
                    previewDiv.dataset.fileName = file.name;
                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                        <button type="button" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity" onclick="removeImage(this, '${file.name}')">
                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                        </button>
                        <p class="text-xs text-gray-600 mt-1 truncate">${file.name}</p>
                    `;
                    previewsContainer.appendChild(previewDiv);
                    
                    // Re-inicializar iconos Lucide
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                };
                reader.readAsDataURL(file);
            }
            
            function removeImage(button, fileName) {
                selectedFiles = selectedFiles.filter(file => file.name !== fileName);
                button.closest('.relative').remove();
                updateFileInput();
            }
            
            function updateFileInput() {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            }
            
            // Exponer función globalmente
            window.removeImage = removeImage;
        }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 