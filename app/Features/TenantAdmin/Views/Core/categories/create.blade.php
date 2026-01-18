{{--
Vista Create - Formulario de creación de categorías
Layout de 2 columnas: Selector de íconos a la izquierda, formulario a la derecha
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Nueva Categoría')

    @section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- SECTION: Header --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.categories.index', $store->slug) }}" class="inline-flex items-center justify-center">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
                </a>
                <h1 class="text-lg font-bold text-gray-800">Nueva Categoría</h1>
            </div>
        </div>
        {{-- End SECTION: Header --}}
        
        {{-- Auto-iniciar tour si es primera categoría o viene de diseño de tienda --}}
        @php
            $autoStartTour = session()->has('auto_start_create_category_tour') || 
                           (isset($totalCategories) && $totalCategories === 0);
        @endphp
        @if($autoStartTour)
            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Verificar si el tour ya fue completado
                    const tourCompleted = localStorage.getItem('tour_crear_categoria_completed') === 'true';
                    
                    // Solo auto-iniciar si no ha sido completado
                    if (!tourCompleted) {
                        const shouldAutoStart = sessionStorage.getItem('auto_start_create_category_tour') === '1' || 
                                              {{ ($totalCategories ?? 0) === 0 ? 'true' : 'false' }};
                        
                        if (shouldAutoStart) {
                            sessionStorage.removeItem('auto_start_create_category_tour');
                            
                            setTimeout(function() {
                                if (window.LinkiuTours && window.LinkiuTours.start) {
                                    window.LinkiuTours.start('crear_categoria', false);
                                } else if (window.startTour) {
                                    window.startTour('crear_categoria', false);
                                }
                            }, 800);
                        }
                    }
                });
            </script>
            @endpush
        @endif

        {{-- SECTION: Info Alert --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-800 text-sm rounded-lg px-4 py-3" role="alert" data-tour="consumo">
            Estás usando <strong>{{ $totalCategories }} de {{ $categoryLimit }}</strong> categorías disponibles en tu plan {{ e($store->plan->name) }}.@if($parentCategories->count() > 0) Crear una subcategoría también cuenta para el límite.@endif
        </div>
        {{-- End SECTION: Info Alert --}}

        {{-- SECTION: Form Card --}}
        <form action="{{ route('tenant.admin.categories.store', $store->slug) }}" method="POST">
            @csrf

            {{-- Grid: 1 columna en mobile/tablet, 2 columnas en desktop (1024px+) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- CARD IZQUIERDA: Selector de Ícono --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6" data-tour="icon-selector">
                    <label class="block text-sm font-medium text-gray-800 mb-3">
                        Ícono de la categoría <span class="text-red-500">*</span>
                    </label>
                    
                    {{-- Icon Selector Grid --}}
                    <div 
                        x-data="{ 
                            searchIcon: '',
                            get visibleCount() {
                                return Array.from(this.$el.querySelectorAll('.icon-option'))
                                    .filter(el => window.getComputedStyle(el).display !== 'none').length;
                            }
                        }"
                        class="icon-selector-container"
                    >
                        {{-- Search Input --}}
                        <div class="relative mb-4">
                            <input 
                                type="text"
                                id="icon-search-input"
                                placeholder="Buscar ícono..."
                                x-model="searchIcon"
                                class="py-2.5 ps-11 pe-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                <i data-lucide="search" class="flex-shrink-0 size-4 text-gray-400"></i>
                            </div>
                        </div>

                        {{-- Icons Grid --}}
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2">
                                @foreach($icons as $icon)
                                    <label 
                                        class="relative cursor-pointer icon-option"
                                        x-show="searchIcon === '' || '{{ Str::lower(e($icon->display_name ?? $icon->name ?? '')) }}'.includes(searchIcon.toLowerCase())"
                                    >
                                        <input 
                                            type="radio" 
                                            name="icon_id" 
                                            value="{{ $icon->id }}" 
                                            class="sr-only peer"
                                            {{ (old('icon_id') == $icon->id) ? 'checked' : '' }}
                                            required
                                        >
                                        {{-- Contenedor del ícono con mejor feedback visual --}}
                                        <div class="w-full aspect-square bg-white rounded-lg p-3 border-2 border-transparent
                                                    peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:border-2 hover:border-blue-300
                                                    hover:bg-gray-50
                                                    transition-all duration-200 flex items-center justify-center relative">
                                            @if(isset($icon->image_url))
                                                <img 
                                                    src="{{ $icon->image_url }}" 
                                                    alt="{{ e($icon->display_name ?? $icon->name ?? 'Icono') }}" 
                                                    class="max-w-full max-h-full object-contain"
                                                    loading="lazy"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                                                >
                                                <i data-lucide="image" class="w-6 h-6 text-gray-400" style="display: none;"></i>
                                            @elseif(isset($icon->icon))
                                                <i data-lucide="{{ e($icon->icon) }}" class="w-6 h-6 text-gray-400"></i>
                                            @else
                                                <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                            @endif
                                        </div>
                                        
                                        {{-- Check mark con animación - hermano del input para que peer-checked funcione --}}
                                        <div class="absolute -top-1.5 -right-1.5 bg-blue-600 rounded-full p-1 shadow-lg opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200 pointer-events-none">
                                            <i data-lucide="check" class="w-3 h-3 text-white stroke-[3]"></i>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Empty State --}}
                            <div 
                                x-show="searchIcon !== '' && visibleCount === 0" 
                                class="text-center py-8"
                                x-cloak
                            >
                                <p class="text-sm text-gray-500">No se encontraron iconos con ese nombre</p>
                            </div>

                            <div class="flex flex-col items-center gap-3 mt-4">
                                <p class="text-xs text-gray-500 text-center">
                                    Mostrando {{ $icons->count() }} ícono(s) disponibles para tu categoría de negocio
                                </p>
                                
                                <button 
                                    type="button"
                                    @click="$dispatch('open-icon-modal')"
                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-purple-700 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors border border-purple-200"
                                >
                                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                                    <span>Solicitar Ícono Personalizado</span>
                                    <span class="px-2 py-0.5 text-xs font-bold text-white bg-gradient-to-r from-purple-600 to-pink-600 rounded-full animate-pulse">NUEVO</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- End Icon Selector Grid --}}

                    @error('icon_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- End CARD IZQUIERDA --}}

                {{-- CARD DERECHA: Formulario --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="space-y-5">
                        
                        {{-- Nombre --}}
                        <div data-tour="category-name">
                            <label for="name" class="block text-sm font-medium text-gray-800 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Ej: Hamburguesas"
                                value="{{ old('name') }}"
                                maxlength="255"
                                required
                                class="py-2.5 px-4 block w-full border {{ $errors->first('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500' }} rounded-lg text-sm"
                            >
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div data-tour="slug-input">
                            <label for="slug" class="block text-sm font-medium text-gray-800 mb-2">
                                Slug (URL)
                            </label>
                            <input 
                                type="text"
                                id="slug"
                                name="slug"
                                placeholder="Se genera automáticamente"
                                value="{{ old('slug') }}"
                                maxlength="255"
                                pattern="[a-z0-9\-]*"
                                title="Solo letras minúsculas, números y guiones"
                                class="py-2.5 px-4 block w-full border {{ $errors->first('slug') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500' }} rounded-lg text-sm"
                            >
                            @error('slug')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">
                                URL: {{ config('app.url') }}/{{ e($store->slug) }}/categoria/<span id="slug-preview">slug</span>
                            </p>
                        </div>

                        {{-- Descripción --}}
                        <div data-tour="category-description">
                            <label for="description" class="block text-sm font-medium text-gray-800 mb-2">
                                Descripción
                            </label>
                            <textarea 
                                id="description"
                                name="description"
                                rows="3"
                                maxlength="500"
                                placeholder="Descripción opcional de la categoría"
                                class="py-2.5 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 resize-none"
                            >{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1 text-right">
                                <span id="char-count">0</span>/500 caracteres
                            </p>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Categoría padre --}}
                        @if($parentCategories->count() > 0)
                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-800 mb-2">
                                Categoría padre (opcional)
                            </label>
                            <select 
                                id="parent_id"
                                name="parent_id"
                                class="py-2.5 px-4 pe-9 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 bg-white"
                            >
                                <option value="">Ninguna (será categoría principal)</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ e($parent->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @else
                        <div data-tour="parent-category" style="display: none;"></div>
                        @endif

                        {{-- Toggle Categoría activa --}}
                        <div class="border border-gray-200 rounded-lg p-4">
                            <input type="hidden" name="is_active" value="0">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <div class="relative inline-block w-11 h-6">
                                    <input 
                                        type="checkbox" 
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="peer sr-only"
                                    >
                                    <span class="absolute inset-0 bg-gray-300 rounded-full transition-colors peer-checked:bg-blue-600"></span>
                                    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-full"></span>
                                </div>
                                <div class="flex-1">
                                    <span class="block text-sm font-medium text-gray-800">Categoría activa</span>
                                    <p class="text-xs text-gray-500">
                                        Las categorías inactivas no se muestran en la tienda
                                    </p>
                                </div>
                            </label>
                        </div>

                        {{-- Botones --}}
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('tenant.admin.categories.index', $store->slug) }}">
                                <button type="button" 
                                        class="inline-flex items-center gap-x-2 py-2.5 px-6 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                    Cancelar
                                </button>
                            </a>
                            <button type="submit" 
                                    data-tour="save-button"
                                    class="inline-flex items-center gap-x-2 py-2.5 px-6 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors text-sm font-medium">
                                <i data-lucide="plus" class="shrink-0 size-4"></i>
                                Crear Categoría
                            </button>
                        </div>
                    </div>
                </div>
                {{-- End CARD DERECHA --}}
            </div>
        </form>
        {{-- End SECTION: Form Card --}}
    </div>

    {{-- SECTION: Icon Request Modal --}}
    <div 
        x-data="iconRequestModal()" 
        @open-icon-modal.window="openModal()"
    >
        {{-- Overlay --}}
        <div 
            x-show="isOpen"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="closeModal()"
            style="display: none;"
            x-cloak
        ></div>

        {{-- Modal Container --}}
        <div 
            x-show="isOpen"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            aria-labelledby="icon-request-modal-label"
            style="display: none;"
            x-cloak
        >
            <div class="sm:max-w-2xl sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
            <div 
                @click.stop
                class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
            >
                {{-- Header --}}
                <div class="flex justify-between items-center py-3 px-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-t-xl">
                    <div class="flex items-center gap-3">
                        <i data-lucide="sparkles" class="w-6 h-6"></i>
                        <div>
                            <h3 id="icon-request-modal-label" class="text-lg font-bold">Solicitar Ícono Personalizado</h3>
                            <p class="text-sm text-purple-100 mt-0.5">Cuéntanos qué ícono necesitas</p>
                        </div>
                    </div>
                    <button 
                        type="button"
                        @click="closeModal()"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full bg-white/10 text-white hover:bg-white/20 focus:outline-none focus:bg-white/20 transition-colors"
                        aria-label="Cerrar"
                        :disabled="loading"
                    >
                        <span class="sr-only">Cerrar</span>
                        <i data-lucide="x" class="size-4"></i>
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-6">
                    <div class="space-y-4">
                        
                        {{-- Nombre de categoría --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre de la categoría
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                x-model="categoryName"
                                placeholder="Ej: Pasteles artesanales"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                :disabled="loading"
                            >
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción del ícono que necesitas
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                x-model="description"
                                rows="3"
                                placeholder="Ej: Necesito un ícono de un pastel con velas..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                :disabled="loading"
                            ></textarea>
                        </div>

                        {{-- Imagen de referencia --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Imagen de referencia del producto
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-3 mb-2">
                                <div class="flex gap-2">
                                    <i data-lucide="lightbulb" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                    <p class="text-xs text-purple-700">
                                        <strong>Tip:</strong> Sube una foto clara del producto para que podamos crear un ícono más preciso.
                                    </p>
                                </div>
                            </div>
                            <label class="flex flex-col items-center justify-center h-40 px-4 py-3 border-2 border-dashed border-purple-300 rounded-lg cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition-all">
                                <div x-show="!imagePreview" class="text-center">
                                    <i data-lucide="image-plus" class="w-10 h-10 text-purple-400 mx-auto mb-2"></i>
                                    <p class="text-sm text-gray-700 font-medium">Click para subir imagen</p>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP (Max 5MB)</p>
                                </div>
                                <div x-show="imagePreview" class="w-full h-full">
                                    <img :src="imagePreview" class="w-full h-full object-contain rounded-lg">
                                </div>
                                <input 
                                    type="file" 
                                    @change="handleImageUpload($event)"
                                    accept="image/*"
                                    class="hidden"
                                    :disabled="loading"
                                >
                            </label>
                        </div>

                        {{-- Mensaje de éxito --}}
                        <div x-show="success" class="bg-green-50 border border-green-200 rounded-lg p-3">
                            <div class="flex gap-2">
                                <i data-lucide="check-circle" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <p class="text-sm text-green-700">
                                    ¡Solicitud enviada! Te notificaremos cuando tu ícono esté listo.
                                </p>
                            </div>
                        </div>

                        {{-- Mensaje de error --}}
                        <div x-show="error" class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <div class="flex gap-2">
                                <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"></i>
                                <p class="text-sm text-red-700" x-text="error"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 bg-gray-50">
                    <button
                        type="button"
                        @click="closeModal()"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                        :disabled="loading"
                    >
                        Cancelar
                    </button>
                    <button
                        type="button"
                        @click="submit()"
                        :disabled="loading || !categoryName || !description || !imageFile"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-gradient-to-r from-purple-600 to-pink-600 text-white hover:from-purple-700 hover:to-pink-700 focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                    >
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span x-text="loading ? 'Enviando...' : 'Enviar Solicitud'"></span>
                    </button>
                </div>
            </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Alpine component para el modal de solicitud de ícono
        function iconRequestModal() {
            return {
                isOpen: false,
                loading: false,
                categoryName: '',
                description: '',
                imageFile: null,
                imagePreview: null,
                success: false,
                error: null,

                openModal() {
                    this.isOpen = true;
                    this.resetForm();
                },

                closeModal() {
                    this.isOpen = false;
                    setTimeout(() => this.resetForm(), 300);
                },

                resetForm() {
                    this.categoryName = '';
                    this.description = '';
                    this.imageFile = null;
                    this.imagePreview = null;
                    this.success = false;
                    this.error = null;
                    this.loading = false;
                },

                handleImageUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        if (file.size > 5 * 1024 * 1024) {
                            this.error = 'La imagen es muy grande. Máximo 5MB.';
                            return;
                        }
                        
                        this.imageFile = file;
                        this.error = null;
                        
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                async submit() {
                    if (!this.categoryName || !this.description || !this.imageFile) {
                        this.error = 'Por favor completa todos los campos requeridos';
                        return;
                    }

                    this.loading = true;
                    this.error = null;
                    this.success = false;

                    const formData = new FormData();
                    formData.append('category_name', this.categoryName);
                    formData.append('description', this.description);
                    formData.append('reference_image', this.imageFile);

                    try {
                        const response = await fetch('{{ route("tenant.admin.icon-requests.store", ["store" => $store->slug]) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.success = true;
                            setTimeout(() => this.closeModal(), 2000);
                        } else {
                            this.error = data.message || 'Error al enviar la solicitud';
                        }
                    } catch (error) {
                        this.error = 'Error de conexión. Por favor intenta nuevamente.';
                        console.error('Error:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const slugPreview = document.getElementById('slug-preview');
            const descriptionTextarea = document.getElementById('description');
            const charCount = document.getElementById('char-count');

            if (!nameInput || !slugInput || !slugPreview) return;

            // Auto-generar slug desde el nombre
            nameInput.addEventListener('input', function(e) {
                const slug = e.target.value
                    .toLowerCase()
                    .replace(/[áàäâ]/g, 'a')
                    .replace(/[éèëê]/g, 'e')
                    .replace(/[íìïî]/g, 'i')
                    .replace(/[óòöô]/g, 'o')
                    .replace(/[úùüû]/g, 'u')
                    .replace(/ñ/g, 'n')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                
                if (!slugInput.value || slugInput.dataset.autoGenerated) {
                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                    slugPreview.textContent = slug || 'slug';
                }
            });

            // Actualizar preview del slug
            slugInput.addEventListener('input', function(e) {
                slugPreview.textContent = e.target.value || 'slug';
                if (e.target.value) {
                    e.target.dataset.autoGenerated = 'false';
                }
            });

            // Contador de caracteres para descripción
            if (descriptionTextarea && charCount) {
                const updateCharCount = () => {
                    const count = descriptionTextarea.value.length;
                    charCount.textContent = count;
                    
                    // Cambiar color si se acerca al límite
                    if (count >= 450) {
                        charCount.classList.add('text-red-600', 'font-semibold');
                    } else if (count >= 400) {
                        charCount.classList.add('text-yellow-600', 'font-semibold');
                        charCount.classList.remove('text-red-600');
                    } else {
                        charCount.classList.remove('text-red-600', 'text-yellow-600', 'font-semibold');
                    }
                };
                
                // Actualizar al cargar (por si hay old value)
                updateCharCount();
                
                descriptionTextarea.addEventListener('input', updateCharCount);
            }

            // Inicializar iconos Lucide
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>