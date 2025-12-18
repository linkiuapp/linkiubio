<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Configuración de Tienda - Linkiu</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    
    <div class="min-h-screen">
        {{-- Wizard Progress --}}
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-semibold">
                            3
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Paso 3 de 4</p>
                            <p class="text-xs text-gray-600">Configuración de Tienda</p>
                        </div>
                    </div>
                    <a href="{{ route('register.step2') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                        ← Volver
                    </a>
                </div>
                <div class="flex gap-2">
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                    <div class="flex-1 h-2 bg-blue-600 rounded-full"></div>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full"></div>
                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-slate-900 mb-3">Configura tu Tienda Online</h2>
                <p class="text-base font-normal text-slate-600">Personaliza la identidad de tu tienda</p>
            </div>

            <form method="POST" action="{{ route('register.step3.store') }}" enctype="multipart/form-data" x-data="storeConfig()">
                @csrf
                
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    
                    {{-- Sección: Identidad de la Tienda --}}
                    <div class="p-6 lg:p-8 border-b border-gray-200">
                        <h3 class="text-base md:text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <i data-lucide="store" class="w-5 h-5 text-blue-600"></i>
                            Identidad de tu Tienda
                        </h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Nombre de la Tienda <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="store_name"
                                       x-model="storeName"
                                       @input="generateSlug()"
                                       value="{{ old('store_name') }}"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('store_name') border-red-300 @enderror text-base"
                                       placeholder="Mi Tienda Online"
                                       required>
                                @error('store_name')
                                    <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    URL de tu Tienda <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:flex gap-2 items-center justify-start md:justify-end">
                                    <span class="text-slate-600 font-medium">linkiu.bio/</span>
                                    <input type="text"
                                           name="slug"
                                           x-model="slug"
                                           @input="onSlugInput()"
                                           value="{{ old('slug') }}"
                                           class="flex-1 px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('slug') border-red-300 @enderror text-base"
                                           placeholder="mi-tienda"
                                           pattern="[a-z0-9-]+"
                                           required>
                                </div>
                                <p class="text-xs font-normal text-slate-600 mt-2">
                                    Solo letras minúsculas, números y guiones. Sin espacios ni caracteres especiales.
                                </p>
                                @error('slug')
                                    <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Descripción de la Tienda
                                </label>
                                <textarea name="store_description"
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none @error('store_description') border-red-300 @enderror"
                                          placeholder="Describe tu tienda, productos o servicios...">{{ old('store_description') }}</textarea>
                                @error('store_description')
                                    <p class="text-xs font-normal text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección: SEO (Opcional) --}}
                    <div class="p-6 lg:p-8 bg-slate-50">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start justify-start mb-6">
                            <h3 class="text-base md:text-lg font-bold text-slate-900 flex items-start justify-start md:justify-start gap-2">
                                <i data-lucide="search" class="w-5 h-5 text-blue-600"></i>
                                Optimización SEO
                                <span class="text-xs font-normal text-slate-600">(Opcional)</span>
                            </h3>
                            <button type="button" 
                                    @click="showSeo = !showSeo"
                                    class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-start justify-start md:justify-end">
                                <span x-show="!showSeo">+ Configurar SEO</span>
                                <span x-show="showSeo">- Ocultar SEO</span>
                            </button>
                        </div>
                        
                        <div x-show="showSeo" x-collapse class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Meta Título
                                </label>
                                <input type="text"
                                       name="meta_title"
                                       value="{{ old('meta_title') }}"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                                       placeholder="Mi Tienda - Los mejores productos">
                                <p class="text-xs font-normal text-slate-600 mt-1">Aparecerá en los resultados de búsqueda de Google</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Meta Descripción
                                </label>
                                <textarea name="meta_description"
                                          rows="2"
                                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                                          placeholder="Breve descripción para motores de búsqueda...">{{ old('meta_description') }}</textarea>
                                <p class="text-xs font-normal text-slate-600 mt-1">Máximo 160 caracteres recomendados</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Palabras Clave
                                </label>
                                <input type="text"
                                       name="meta_keywords"
                                       value="{{ old('meta_keywords') }}"
                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                                       placeholder="tienda, online, productos, envíos">
                                <p class="text-xs font-normal text-slate-600 mt-1">Separa las palabras con comas</p>
                            </div>
                        </div>
                    </div>

                    {{-- Botones de Navegación --}}
                    <div class="p-6 lg:p-8 bg-slate-50 grid grid-cols-1 md:grid-cols-2 gap-4 items-center justify-center border-t border-gray-200">
                        <a href="{{ route('register.step2') }}" 
                           class="px-6 py-2.5 bg-white border border-gray-200 text-slate-600 rounded-lg font-medium hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Paso Anterior
                        </a>
                        <button type="submit" 
                                class="px-8 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                            <span>Continuar al Paso 4</span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('storeConfig', () => ({
            storeName: '{{ old('store_name') }}',
            slug: '{{ old('slug') }}',
            showSeo: false,
            slugManuallyEdited: {{ old('slug') ? 'true' : 'false' }}, // Track si el usuario editó manualmente
            
            generateSlug() {
                // Solo auto-generar si el usuario no ha editado manualmente el slug
                if (!this.storeName || this.slugManuallyEdited) return;
                
                this.slug = this.storeName
                    .toLowerCase()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Eliminar acentos
                    .replace(/[^a-z0-9\s-]/g, '') // Solo letras, números, espacios y guiones
                    .trim()
                    .replace(/\s+/g, '-') // Espacios a guiones
                    .replace(/-+/g, '-') // Múltiples guiones a uno
                    .slice(0, 50); // Limitar longitud
            },
            
            onSlugInput() {
                // Marcar que el usuario editó manualmente el slug
                this.slugManuallyEdited = true;
            }
        }));
    });

    // Inicializar iconos Lucide
    document.addEventListener('DOMContentLoaded', function() {
        if (window.createIcons && window.lucideIcons) {
            window.createIcons({ icons: window.lucideIcons });
        }
    });
    </script>
    
    <style>
    [x-cloak] { display: none !important; }
    </style>
</body>
</html>

