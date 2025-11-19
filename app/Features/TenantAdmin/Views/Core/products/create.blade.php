{{--
Vista Create - Formulario de creación de productos
Permite crear nuevos productos con información básica, imágenes, categorías y variables
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Nuevo Producto')

    @section('content')
    <div class="max-w-6xl mx-auto space-y-6 mt-6">
        {{-- SECTION: Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.products.index', $store->slug) }}" class="inline-flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
                </a>
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Nuevo Producto</h1>
                    <p class="text-sm text-gray-600 mt-1">Crea un nuevo producto para tu tienda</p>
                </div>
            </div>
            <div class="bg-gray-100 rounded-lg px-4 py-2 border border-gray-200">
                <span class="text-sm text-gray-700 font-medium">{{ $currentCount }}/{{ $maxProducts }} productos</span>
            </div>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Info Alert --}}
        <x-alert-soft 
            type="info"
            :message="'Estás usando ' . $currentCount . ' de ' . $maxProducts . ' productos disponibles en tu plan ' . $store->plan->name . '.'"
        />
        {{-- End SECTION: Info Alert --}}

        {{-- SECTION: Validation Errors Alert --}}
        @if($errors->any())
            <x-alert-bordered type="error" title="Por favor corrige los siguientes errores:">
                <ul class="list-disc list-inside mt-2 space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-sm text-gray-700">{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert-bordered>
        @endif
        {{-- End SECTION: Validation Errors Alert --}}

        {{-- SECTION: Form --}}
        <form method="POST" action="{{ route('tenant.admin.products.store', $store->slug) }}" enctype="multipart/form-data" x-data="productCreateForm()" class="space-y-6">
            @csrf
            
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
                            :value="old('name')"
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
                            :value="old('sku')"
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
                            placeholder="Describe las características principales del producto...">{{ old('description') }}</textarea>
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
                                    value="{{ old('price') }}"
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
                                :selected="old('type', '')"
                                placeholder=""
                                x-model="productType"
                                @change="toggleVariablesSection()"
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
                            :checked="old('is_active', true)"
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

            {{-- SECTION: Imágenes Card --}}
            <x-card-base title="Imágenes del Producto" shadow="sm">
                <div class="space-y-4">
                    <div 
                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50 hover:bg-gray-100 transition-colors duration-200 cursor-pointer" 
                        id="image-upload-area"
                        @click="$refs.fileInput.click()"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="handleFileDrop($event)"
                        :class="isDragging ? 'bg-blue-50 border-blue-400' : ''"
                    >
                        <div class="flex flex-col items-center justify-center gap-4">
                            <i data-lucide="cloud-upload" class="w-12 h-12 text-gray-400"></i>
                            <div>
                                <p class="text-base text-gray-700 mb-2">Arrastra y suelta las imágenes aquí o</p>
                                <p class="text-gray-900 text-base font-semibold">haz clic para seleccionar</p>
                                <input 
                                    type="file" 
                                    id="images" 
                                    name="images[]" 
                                    multiple 
                                    accept="image/*" 
                                    class="hidden"
                                    x-ref="fileInput"
                                    @change="handleFileSelect($event)"
                                >
                            </div>
                            <p class="text-sm text-gray-500">Soporta múltiples imágenes (JPG, PNG, WEBP)</p>
                        </div>
                    </div>
                    <div id="image-previews" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                </div>
            </x-card-base>
            {{-- End SECTION: Imágenes Card --}}

            {{-- SECTION: Categorías Card --}}
            @if($categories->count() > 0)
            <x-card-base title="Categorías" shadow="sm">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($categories as $category)
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input 
                                type="checkbox" 
                                name="categories[]" 
                                value="{{ $category->id }}"
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
            <x-card-base shadow="sm" id="variables-section" style="display: none;">
                <div class="mb-4 pb-4 border-b border-gray-200">
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
                                    @php
                                        $typeIcons = [
                                            'radio' => 'radio',
                                            'checkbox' => 'check-square',
                                            'text' => 'type',
                                            'numeric' => 'hash'
                                        ];
                                        $typeIcon = $typeIcons[$type] ?? 'settings';
                                    @endphp
                                    <h4 class="text-sm font-semibold text-gray-700">
                                        {{ \App\Features\TenantAdmin\Models\ProductVariable::TYPES[$type] ?? $type }}
                                        <span class="text-gray-500 font-normal">({{ $typeVariables->count() }})</span>
                                    </h4>
                                </div>
                                
                                <div class="space-y-3">
                                    @foreach($typeVariables as $variable)
                                        <div 
                                            class="variable-card border rounded-lg p-4 transition-all duration-200 border-gray-200 hover:border-blue-300 bg-white"
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
                                                        style="display: none; opacity: 0; transform: translateY(-10px);"
                                                    >
                                                        {{-- Opciones disponibles para seleccionar --}}
                                                        @if($variable->requiresOptions() && $variable->activeOptions->count() > 0)
                                                            <div class="bg-white border border-gray-200 rounded-lg p-3">
                                                                <label class="text-xs font-semibold text-gray-700 mb-2 block">
                                                                    Selecciona las opciones que usará este producto <span class="text-red-500">*</span>
                                                                </label>
                                                                <div class="space-y-2">
                                                                    @foreach($variable->activeOptions as $option)
                                                                        <div class="flex items-center gap-3 p-2 rounded border border-gray-200 hover:border-blue-300 transition-colors option-item" data-option-id="{{ $option->id }}" data-variable-id="{{ $variable->id }}">
                                                                            <label class="flex items-center gap-2 cursor-pointer flex-1">
                                                                                <input 
                                                                                    type="checkbox" 
                                                                                    name="variables[{{ $variable->id }}][options][]"
                                                                                    value="{{ $option->id }}"
                                                                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 variable-option-checkbox"
                                                                                    data-variable-id="{{ $variable->id }}"
                                                                                    data-option-id="{{ $option->id }}"
                                                                                >
                                                                                <span class="text-sm text-gray-700 font-medium">{{ $option->name }}</span>
                                                                            </label>
                                                                            <div class="option-quantity-field" style="display: none;">
                                                                                <label class="text-xs text-gray-600 mr-2">Cantidad:</label>
                                                                                <input 
                                                                                    type="number" 
                                                                                    name="variables[{{ $variable->id }}][quantities][{{ $option->id }}]"
                                                                                    value="0"
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
                                                                    :checked="$variable->is_required_default"
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
                                                                    value="{{ $loop->iteration }}"
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
                    <a href="{{ route('tenant.admin.products.index', $store->slug) }}">
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
                        text="Crear Producto"
                        html-type="submit"
                        @click.prevent="confirmSubmit()"
                    />
                </div>
            </div>
            {{-- End SECTION: Action Buttons --}}
        </form>
        {{-- End SECTION: Form --}}
    </div>

    {{-- Registrar componentes Alpine ANTES de que Alpine procese el DOM --}}
    @push('styles')
    <script>
        // Registrar componentes Alpine usando alpine:init
        document.addEventListener('alpine:init', () => {
            // Componente para el formulario principal
            Alpine.data('productCreateForm', () => ({
                    productType: '{{ old('type', '') }}',
                    isDragging: false,
                    selectedFiles: [],
                    
                    init() {
                        // Inicializar iconos Lucide
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                        
                        // Mostrar/ocultar sección de variables según el tipo inicial
                        this.toggleVariablesSection();
                    },
                    
                    toggleVariablesSection() {
                        const variablesSection = document.getElementById('variables-section');
                        if (this.productType === 'variable') {
                            if (variablesSection) {
                                variablesSection.style.display = 'block';
                            }
                        } else {
                            if (variablesSection) {
                                variablesSection.style.display = 'none';
                            }
                        }
                    },
                    
                    toggleVariableOptions(variableId, isChecked) {
                        const optionsDiv = document.getElementById('options_' + variableId);
                        if (optionsDiv) {
                            optionsDiv.style.display = isChecked ? 'block' : 'none';
                        }
                    },
                    
                    // Validar antes de submit
                    validateForm() {
                        if (this.productType !== 'variable') {
                            return true;
                        }
                        
                        // Usar la función de validación de variables (JavaScript vanilla)
                        if (typeof window.validateVariablesForm === 'function') {
                            return window.validateVariablesForm();
                        }
                        
                        return true;
                    },
                    
                    handleFileSelect(event) {
                        const files = Array.from(event.target.files);
                        this.processFiles(files);
                    },
                    
                    handleFileDrop(event) {
                        this.isDragging = false;
                        const files = Array.from(event.dataTransfer.files);
                        this.processFiles(files);
                    },
                    
                    processFiles(files) {
                        files.forEach(file => {
                            if (file.type.startsWith('image/')) {
                                this.selectedFiles.push(file);
                                this.createImagePreview(file);
                            }
                        });
                        this.updateFileInput();
                    },
                    
                    createImagePreview(file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const previewsContainer = document.getElementById('image-previews');
                            if (!previewsContainer) return;
                            
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'relative group';
                            previewDiv.dataset.fileName = file.name;
                            previewDiv.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                <button type="button" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity" onclick="window.removeImage(this, '${file.name}')">
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
                    },
                    
                    updateFileInput() {
                        const fileInput = document.getElementById('images');
                        if (!fileInput) return;
                        
                        const dt = new DataTransfer();
                        this.selectedFiles.forEach(file => dt.items.add(file));
                        fileInput.files = dt.files;
                    },
                    
                    confirmSubmit() {
                        const form = this.$el.closest('form');
                        if (!form) return;
                        
                        // Validar formulario nativo
                        if (!form.checkValidity()) {
                            form.reportValidity();
                            return;
                        }
                        
                        // Validar variables
                        if (!this.validateForm()) {
                            return;
                        }
                        
                        form.submit();
                    }
                }));
        });
    </script>
    @endpush
    
    @push('scripts')
    <script>
        // Gestión de Variables con JavaScript vanilla
        (function() {
            let selectedVariables = {};
            let searchTerm = '';
            
            function initVariables() {
                // Inicializar todas las variables como no seleccionadas
                @if($variables->count() > 0)
                    @foreach($variables as $variable)
                        selectedVariables[{{ $variable->id }}] = false;
                    @endforeach
                @endif
                
                updateSelectedCount();
                setupEventListeners();
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
            
            // Función para validar antes de submit (usada por productCreateForm)
            window.validateVariablesForm = function() {
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
        
        // Función global para eliminar imágenes
        window.removeImage = function(button, fileName) {
            const form = Alpine.$data(document.querySelector('[x-data*="productCreateForm"]'));
            if (form && form.selectedFiles) {
                form.selectedFiles = form.selectedFiles.filter(file => file.name !== fileName);
                form.updateFileInput();
            }
            button.closest('.relative').remove();
        };
        
        // Inicializar iconos Lucide al cargar
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
