{{--
Vista Create - Formulario de creación de categorías
Layout de 2 columnas: Selector de íconos a la izquierda, formulario a la derecha
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Nueva Categoría')

    @section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- SECTION: Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.admin.categories.index', $store->slug) }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-bold text-gray-800">Nueva Categoría</h1>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Info Alert --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-800 text-sm rounded-lg px-4 py-3" role="alert">
            Estás usando <strong>{{ $totalCategories }} de {{ $categoryLimit }}</strong> categorías disponibles en tu plan {{ e($store->plan->name) }}.@if($parentCategories->count() > 0) Crear una subcategoría también cuenta para el límite.@endif
        </div>
        {{-- End SECTION: Info Alert --}}

        {{-- SECTION: Form Card --}}
        <form action="{{ route('tenant.admin.categories.store', $store->slug) }}" method="POST">
            @csrf

            {{-- Grid: 1 columna en mobile/tablet, 2 columnas en desktop (1024px+) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- CARD IZQUIERDA: Selector de Ícono --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6">
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

                            <p class="text-xs text-gray-500 text-center mt-4">
                                Mostrando {{ $icons->count() }} ícono(s) disponibles para tu categoría de negocio
                            </p>
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
                        <div>
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
                        <div>
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
                        <div>
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

    @push('scripts')
    <script>
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