@extends('shared::layouts.admin')

@section('title', 'Editar Imagen UI: ' . $uiImage->name)

@section('content')
<div class="max-w-6xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.ui-images.index', ['context' => $uiImage->context]) }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Editar: {{ $uiImage->name }}</h1>
                <p class="text-sm text-gray-600 mt-1">Modifica la información de la imagen</p>
            </div>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    <form action="{{ route('superlinkiu.ui-images.update', $uiImage->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- SECTION: Contenido Principal --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- SECTION: Información Básica --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Información de la Imagen</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        {{-- Current Image Preview --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Imagen Actual</label>
                            <div class="border-2 border-gray-200 rounded-lg p-4 bg-gray-50">
                                <img src="{{ $uiImage->url }}" 
                                     alt="{{ $uiImage->name }}" 
                                     class="max-w-full max-h-64 mx-auto object-contain">
                                <p class="text-xs text-gray-500 mt-2 text-center">{{ $uiImage->file_name }} ({{ number_format($uiImage->file_size / 1024, 2) }} KB)</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Contexto <span class="text-red-500">*</span>
                            </label>
                            <select name="context" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('context') border-red-300 @enderror"
                                    required>
                                <option value="store" {{ old('context', $uiImage->context) === 'store' ? 'selected' : '' }}>Tiendas</option>
                                <option value="tenant_admin" {{ old('context', $uiImage->context) === 'tenant_admin' ? 'selected' : '' }}>Admin de Tiendas</option>
                                <option value="website" {{ old('context', $uiImage->context) === 'website' ? 'selected' : '' }}>Sitio Web</option>
                                <option value="super_admin" {{ old('context', $uiImage->context) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                            @error('context')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Categoría <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                @php
                                    $isCustomCategory = !in_array($uiImage->category, array_keys($categories));
                                    $currentCategory = old('category', $uiImage->category);
                                @endphp
                                <select name="category" 
                                        id="category-select"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('category') border-red-300 @enderror {{ $isCustomCategory ? 'hidden' : '' }}"
                                        onchange="handleCategoryChange(this)">
                                    <option value="">Selecciona una categoría...</option>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}" {{ $currentCategory === $key && !$isCustomCategory ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                    <option value="__custom__">➕ Agregar nueva categoría personalizada</option>
                                </select>
                                
                                <!-- Descripción de la categoría seleccionada -->
                                <div id="category-description" class="p-3 bg-blue-50 border border-blue-200 rounded-lg {{ !$isCustomCategory && $currentCategory && isset($categoriesInfo[$currentCategory]) ? '' : 'hidden' }}">
                                    @if(!$isCustomCategory && $currentCategory && isset($categoriesInfo[$currentCategory]))
                                        @php $info = $categoriesInfo[$currentCategory]; @endphp
                                        <p class="text-sm text-blue-900 font-medium mb-1" id="category-description-title">{{ $info['label'] }}</p>
                                        <p class="text-xs text-blue-700" id="category-description-text">{{ $info['description'] }}</p>
                                        <p class="text-xs text-blue-600 mt-1 font-medium" id="category-description-location">📍 {{ $info['location'] }}</p>
                                    @else
                                        <p class="text-sm text-blue-900 font-medium mb-1" id="category-description-title"></p>
                                        <p class="text-xs text-blue-700" id="category-description-text"></p>
                                        <p class="text-xs text-blue-600 mt-1 font-medium" id="category-description-location"></p>
                                    @endif
                                </div>
                                
                                <!-- Campo para categoría personalizada -->
                                <input type="text" 
                                       id="category-custom"
                                       name="category_custom" 
                                       value="{{ old('category_custom', $isCustomCategory ? $uiImage->category : '') }}"
                                       placeholder="Escribe el nombre de la nueva categoría (ej: mi_categoria)"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('category') border-red-300 @enderror {{ $isCustomCategory ? '' : 'hidden' }}"
                                       onchange="updateCategoryHidden(this)">
                                @if($isCustomCategory)
                                    <input type="hidden" name="category" id="category-hidden" value="{{ $currentCategory }}">
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                <strong>💡 Tip:</strong> La categoría determina dónde aparecerá la imagen. Selecciona según la ubicación donde quieres que se muestre.
                            </p>
                            @error('category')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $uiImage->name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('name') border-red-300 @enderror"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                URL (Opcional)
                            </label>
                            <input type="url" 
                                   name="url" 
                                   value="{{ old('url', $uiImage->url) }}"
                                   placeholder="https://ejemplo.com/enlace"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('url') border-red-300 @enderror">
                            <p class="text-xs text-gray-500 mt-1">URL de destino cuando se hace clic en la imagen</p>
                            @error('url')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Reemplazar Imagen (Opcional)
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 hover:bg-blue-50 transition-all">
                                <div id="upload-area" class="space-y-4">
                                    <div class="w-16 h-16 mx-auto bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i data-lucide="image" class="w-8 h-8 text-gray-400"></i>
                                    </div>
                                    <div>
                                        <label for="image" class="cursor-pointer">
                                            <span class="text-blue-600 hover:text-blue-700 font-medium">Selecciona un archivo</span>
                                            <span class="text-gray-600"> o arrastra y suelta aquí</span>
                                        </label>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        Formatos: SVG, WebP • Tamaño máximo: 5MB
                                    </p>
                                </div>

                                <div id="preview-area" class="space-y-4 hidden">
                                    <div class="relative">
                                        <div class="w-32 h-32 mx-auto bg-gray-100 rounded-lg p-4 flex items-center justify-center">
                                            <img id="preview-image" class="max-w-full max-h-full object-contain" alt="Preview">
                                        </div>
                                        <button type="button" 
                                                onclick="clearPreview()"
                                                class="absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors flex items-center justify-center">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                    <p id="file-name" class="text-sm font-medium text-gray-700"></p>
                                    <p class="text-xs text-green-600">✓ Archivo seleccionado</p>
                                </div>

                                <input id="image" 
                                       name="image" 
                                       type="file" 
                                       class="sr-only" 
                                       accept=".svg,.webp"
                                       onchange="handleFileSelect(this)">
                            </div>
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Orden
                            </label>
                            <input type="number" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', $uiImage->sort_order) }}"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('sort_order') border-red-300 @enderror">
                            @error('sort_order')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Información Básica --}}
            </div>
            {{-- End SECTION: Contenido Principal --}}

            {{-- SECTION: Sidebar --}}
            <div class="space-y-6">
                {{-- SECTION: Estado --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Estado</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       class="sr-only peer"
                                       {{ old('is_active', $uiImage->is_active) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer 
                                            peer-checked:after:translate-x-full peer-checked:after:border-white 
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                            after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all 
                                            peer-checked:bg-green-500"></div>
                            </label>
                            <div>
                                <span class="text-sm font-medium text-gray-900">Imagen activa</span>
                                <p class="text-xs text-gray-500">Las imágenes inactivas no se mostrarán en el sistema</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Estado --}}
            </div>
            {{-- End SECTION: Sidebar --}}
        </div>

        {{-- SECTION: Actions --}}
        <div class="flex items-center justify-between bg-white rounded-lg border border-gray-200 p-6">
            <a href="{{ route('superlinkiu.ui-images.index', ['context' => $uiImage->context]) }}" 
               class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Cancelar
            </a>
            
            <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center gap-2 font-medium transition-colors">
                <i data-lucide="save" class="w-4 h-4"></i>
                Actualizar Imagen
            </button>
        </div>
        {{-- End SECTION: Actions --}}
    </form>
</div>

@push('scripts')
<script>
    function handleCategoryChange(select) {
        const customInput = document.getElementById('category-custom');
        const hiddenInput = document.getElementById('category-hidden');
        
        if (select.value === '__custom__') {
            select.classList.add('hidden');
            customInput.classList.remove('hidden');
            customInput.required = true;
            customInput.focus();
            // Crear hidden input si no existe
            if (!hiddenInput) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'category';
                hidden.id = 'category-hidden';
                customInput.parentElement.appendChild(hidden);
            }
        } else {
            select.classList.remove('hidden');
            customInput.classList.add('hidden');
            customInput.required = false;
            customInput.value = '';
            // Remover hidden input si existe
            if (hiddenInput) {
                hiddenInput.remove();
            }
        }
    }

    function updateCategoryHidden(input) {
        const hiddenInput = document.getElementById('category-hidden');
        if (hiddenInput) {
            hiddenInput.value = input.value;
        }
    }

    function handleFileSelect(input) {
        const file = input.files[0];
        
        if (file && (file.type === 'image/svg+xml' || file.type === 'image/webp')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('upload-area').classList.add('hidden');
                document.getElementById('preview-area').classList.remove('hidden');
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('file-name').textContent = file.name;
            };
            reader.readAsDataURL(file);
        } else if (file) {
            alert('Por favor selecciona un archivo SVG o WebP');
            clearPreview();
        }
    }
    
    function clearPreview() {
        document.getElementById('image').value = '';
        document.getElementById('upload-area').classList.remove('hidden');
        document.getElementById('preview-area').classList.add('hidden');
        document.getElementById('preview-image').src = '';
        document.getElementById('file-name').textContent = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Mostrar descripción de la categoría actual si existe
        const select = document.getElementById('category-select');
        if (select && select.value && select.value !== '__custom__') {
            handleCategoryChange(select);
        }
    });
</script>
@endpush
@endsection
