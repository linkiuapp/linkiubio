<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sectionTitle }} - Guía Interactiva - {{ $store->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="interactiveGuide()">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-200 fixed left-0 top-0 bottom-0 overflow-y-auto z-30">
            <div class="p-4">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">Guía Interactiva</h2>
                    <p class="text-xs text-gray-600">Navegación</p>
                </div>
                
                <nav class="space-y-1" x-data="{ 
                    openSections: { 
                        @foreach($navigation as $pIndex => $p)
                            @php
                                $isCurrentP = false;
                                foreach ($p['children'] ?? [] as $c) {
                                    if ($c['slug'] === $fullSlug) {
                                        $isCurrentP = true;
                                        break;
                                    }
                                }
                            @endphp
                            @if($isCurrentP)
                                '{{ $pIndex }}': true,
                            @endif
                        @endforeach
                    } 
                }">
                    <a 
                        href="{{ route('tenant.admin.interactive-guide.index', ['store' => $store->slug]) }}"
                        class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-lg mb-4 transition-colors"
                    >
                        <i data-lucide="home" class="w-4 h-4"></i>
                        <span>Inicio</span>
                    </a>
                    
                    @foreach($navigation as $parentIndex => $parent)
                        @php
                            if (!in_array($parent['title'], ['Pedidos', 'Categorías', 'Variables', 'Productos', 'Inventario', 'Gestión de Envíos', 'Métodos de Pago', 'Sedes', 'Notificaciones de WhatsApp', 'Diseño de Tienda', 'Cupones', 'Sliders', 'Tickers Promocionales', 'Dashboard', 'Sidebar', 'Navbar', 'Footer'])) continue;
                            
                            // Si tiene solo un hijo, no mostrar desplegable
                            $hasSingleChild = count($parent['children'] ?? []) === 1;
                            $singleChild = $hasSingleChild ? ($parent['children'][0] ?? null) : null;
                        @endphp
                        @if($hasSingleChild && $singleChild)
                            {{-- Elemento con una sola opción: mostrar como enlace directo --}}
                            <a 
                                href="{{ route($singleChild['route'], array_merge(['store' => $store->slug], $singleChild['params'] ?? [])) }}"
                                class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-lg transition-colors mb-2"
                            >
                                <i data-lucide="{{ $parent['icon'] }}" class="w-4 h-4"></i>
                                <span>{{ $parent['title'] }}</span>
                            </a>
                        @else
                            {{-- Elemento con múltiples opciones: mostrar con desplegable --}}
                            <div class="mb-2">
                                <button
                                    @click="openSections['{{ $parentIndex }}'] = !openSections['{{ $parentIndex }}']"
                                    class="w-full flex items-center justify-between gap-2 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                                >
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="{{ $parent['icon'] }}" class="w-4 h-4"></i>
                                        <span>{{ $parent['title'] }}</span>
                                    </div>
                                    <i 
                                        data-lucide="chevron-down" 
                                        class="w-4 h-4 transition-transform"
                                        :class="{ 'rotate-180': openSections['{{ $parentIndex }}'] }"
                                    ></i>
                                </button>
                                <ul 
                                    x-show="openSections['{{ $parentIndex }}']"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                                    x-cloak
                                    class="ml-6 mt-1 space-y-1"
                                >
                                    @foreach($parent['children'] ?? [] as $child)
                                        <li>
                                            <a 
                                                href="{{ route($child['route'], array_merge(['store' => $store->slug], $child['params'] ?? [])) }}"
                                                class="block px-3 py-2 text-sm rounded-lg transition-colors {{ $child['slug'] === $fullSlug ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}"
                                            >
                                                {{ $child['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </nav>
            </div>
        </aside>

        <main class="flex-1 ml-64">
            <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
                <div class="px-6 py-4">
                    <nav class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                        @foreach($breadcrumbs as $index => $crumb)
                            @if($crumb['url'])
                                <a href="{{ $crumb['url'] }}" class="hover:text-gray-900 transition-colors">{{ $crumb['title'] }}</a>
                            @else
                                <span class="text-gray-900 font-medium">{{ $crumb['title'] }}</span>
                            @endif
                            @if($index < count($breadcrumbs) - 1)
                                <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
                            @endif
                        @endforeach
                    </nav>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-lg font-bold text-gray-900">{{ $sectionTitle }}</h1>
                            <p class="text-sm text-gray-600 mt-1">{{ $parentTitle }}</p>
                        </div>
                        <a 
                            href="{{ route('tenant.admin.dashboard', ['store' => $store->slug]) }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                        >
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Volver al Panel</span>
                        </a>
                    </div>
                </div>
            </header>

            <div class="p-6 space-y-6 pb-32">
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                    <h2 class="text-base font-semibold text-blue-600 mb-4 flex items-center gap-2">
                        <i data-lucide="mouse-pointer-click" class="w-5 h-5 text-blue-600"></i>
                        <span>Vista Interactiva - Haz clic sobre los elementos para saber su funcionalidad</span>
                    </h2>
                    
                    <div class="space-y-6 bg-white rounded-lg p-6">
                        {{-- Encabezado --}}
                        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                    @click="scrollToSection('section-header-title')">Diseño de tienda</h1>
                                <p class="text-sm text-gray-600 mt-2 cursor-pointer hover:text-blue-600 transition-colors"
                                   @click="scrollToSection('section-header-description')">Configura los textos, colores e identidad visual que verá tu clientela</p>
                            </div>
                            <button class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                    @click="scrollToSection('section-button-publish')">
                                Publicar cambios
                            </button>
                        </div>

                        {{-- Sección: Información del Encabezado --}}
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-header-info')">Información del encabezado</h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                {{-- Columna Izquierda (2/3) --}}
                                <div class="lg:col-span-2 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-name')">
                                            Nombre de la tienda <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               value="Mi Tienda"
                                               maxlength="40"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-name')"
                                               readonly>
                                        <p class="text-xs text-gray-500 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-name-help')">Máximo 40 caracteres. Solo letras, números, espacios, guiones, acentos y puntos.</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-description')">
                                            Descripción breve
                                        </label>
                                        <textarea rows="2" 
                                                  maxlength="50"
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                  @click="scrollToSection('section-field-description')"
                                                  readonly>Tu tienda de confianza</textarea>
                                        <p class="text-xs text-gray-500 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-description-help')">Máximo 50 caracteres. Aparece debajo del nombre en el encabezado.</p>
                                    </div>

                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 cursor-pointer hover:bg-blue-100 transition-colors"
                                         @click="scrollToSection('section-help-text')">
                                        <p class="text-xs text-blue-800">El nombre admite letras, números, guiones y acentos (máx. 40). La descripción admite hasta 50 caracteres.</p>
                                    </div>
                                </div>

                                {{-- Columna Derecha (1/3) --}}
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-color-background')">
                                            Color de fondo
                                        </label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" 
                                                   value="#FFFFFF"
                                                   class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-color-background')"
                                                   readonly>
                                            <input type="text" 
                                                   value="#FFFFFF"
                                                   maxlength="7"
                                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-color-background')"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-color-name')">
                                            Color del nombre
                                        </label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" 
                                                   value="#000000"
                                                   class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-color-name')"
                                                   readonly>
                                            <input type="text" 
                                                   value="#000000"
                                                   maxlength="7"
                                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-color-name')"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-color-description')">
                                            Color de la descripción
                                        </label>
                                        <div class="flex items-center gap-2">
                                            <input type="color" 
                                                   value="#666666"
                                                   class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-color-description')"
                                                   readonly>
                                            <input type="text" 
                                                   value="#666666"
                                                   maxlength="7"
                                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm font-mono cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-color-description')"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Vista Previa --}}
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-preview')">Vista previa</h3>
                            
                            <div class="bg-white rounded-lg border-2 border-dashed border-gray-300 p-6 cursor-pointer hover:border-blue-300 transition-colors"
                                 @click="scrollToSection('section-preview-content')"
                                 style="background-color: #FFFFFF;">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-xl font-bold text-blue-600">MT</span>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold" style="color: #000000;">Mi Tienda</h2>
                                        <p class="text-sm mt-1" style="color: #666666;">Tu tienda de confianza</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 cursor-pointer hover:text-blue-600 transition-colors"
                               @click="scrollToSection('section-preview-note')">La vista previa se actualiza automáticamente mientras haces cambios</p>
                        </div>

                        {{-- Sección: Logo --}}
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-logo')">Logo</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center border-2 border-dashed border-gray-300 cursor-pointer hover:border-blue-300 transition-colors"
                                         @click="scrollToSection('section-logo-preview')">
                                        <div class="text-center">
                                            <i data-lucide="image" class="w-8 h-8 text-gray-400 mx-auto mb-1"></i>
                                            <p class="text-xs text-gray-500">Sin logo cargado</p>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-logo-upload')">
                                            Subir logo
                                        </label>
                                        <div class="flex items-center gap-2">
                                            <input type="file" 
                                                   accept="image/png,image/jpeg,image/webp"
                                                   class="hidden"
                                                   id="logo-upload">
                                            <label for="logo-upload" 
                                                   class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer text-sm">
                                                Seleccionar archivo
                                            </label>
                                            <span class="text-xs text-gray-500">PNG, JPG o WebP (máx. 2MB)</span>
                                        </div>
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-3 cursor-pointer hover:bg-blue-100 transition-colors"
                                             @click="scrollToSection('section-logo-info')">
                                            <p class="text-xs text-blue-800">Las imágenes se guardan automáticamente al subirlas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Favicon --}}
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-favicon')">Favicon</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300 cursor-pointer hover:border-blue-300 transition-colors"
                                         @click="scrollToSection('section-favicon-preview')">
                                        <div class="text-center">
                                            <i data-lucide="image" class="w-6 h-6 text-gray-400 mx-auto mb-1"></i>
                                            <p class="text-xs text-gray-500">Sin favicon</p>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-favicon-upload')">
                                            Subir favicon
                                        </label>
                                        <div class="flex items-center gap-2">
                                            <input type="file" 
                                                   accept="image/png,image/x-icon,image/svg+xml"
                                                   class="hidden"
                                                   id="favicon-upload">
                                            <label for="favicon-upload" 
                                                   class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer text-sm">
                                                Seleccionar archivo
                                            </label>
                                            <span class="text-xs text-gray-500">PNG, ICO o SVG (máx. 1MB)</span>
                                        </div>
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-3 cursor-pointer hover:bg-blue-100 transition-colors"
                                             @click="scrollToSection('section-favicon-info')">
                                            <p class="text-xs text-blue-800">Las imágenes se guardan automáticamente al subirlas</p>
                                        </div>
                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mt-3 cursor-pointer hover:bg-gray-100 transition-colors"
                                             @click="scrollToSection('section-favicon-what')">
                                            <p class="text-xs text-gray-700"><strong>¿Qué es un favicon?</strong> Es el pequeño ícono que aparece en la pestaña del navegador junto al nombre de tu sitio. También aparece cuando alguien guarda tu sitio en favoritos.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal de Confirmación (simulado) --}}
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6" style="display: none;">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Modal: Confirmar Publicación</h3>
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h4 class="text-base font-semibold text-gray-900 mb-2">Confirmar publicación</h4>
                        <p class="text-sm text-gray-700 mb-4">Se actualizará el encabezado de tu tienda con los colores, nombre y descripción actuales.</p>
                        <ul class="list-disc list-inside text-sm text-gray-700 mb-4 space-y-1">
                            <li>El logo y el favicon se publicarán si fueron reemplazados.</li>
                            <li>Los cambios serán visibles inmediatamente.</li>
                        </ul>
                        <div class="flex gap-3">
                            <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                    @click="scrollToSection('section-modal-cancel')">
                                Cancelar
                            </button>
                            <button class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors cursor-pointer"
                                    @click="scrollToSection('section-modal-confirm')">
                                Publicar ahora
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Consejos Rápidos --}}
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg border border-amber-200 p-6">
                    <div class="flex-1">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Consejos Rápidos</h2>
                        <div class="grid md:grid-cols-2 gap-3">
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa colores contrastantes</strong> para que el texto sea visible sobre el fondo</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Mantén el nombre corto</strong>, un nombre más corto se ve mejor en el encabezado</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Descripción concisa</strong>, una descripción breve y clara es más efectiva</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Logo de buena calidad</strong>, usa un logo de alta resolución pero optimizado</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Favicon simple</strong>, debe ser simple y reconocible en tamaños pequeños</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa la vista previa</strong> antes de publicar para asegurarte de que todo se ve bien</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Las imágenes se guardan automáticamente</strong>, no necesitas publicar para guardar logos y favicons</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Colores de marca</strong>, usa los colores de tu marca para mantener consistencia visual</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function interactiveGuide() {
            return {
                selectedGuide: null,
                selectedGuideTitle: '',
                selectedGuideText: '',
                
                guides: {
                    'section-header-title': {
                        title: 'Título "Diseño de tienda"',
                        text: 'Muestra el nombre de la sección donde estás. Te indica que estás en la pantalla para personalizar el aspecto visual de tu tienda.'
                    },
                    'section-header-description': {
                        title: 'Descripción',
                        text: 'Texto que dice "Configura los textos, colores e identidad visual que verá tu clientela". Explica el propósito de esta página.'
                    },
                    'section-button-publish': {
                        title: 'Botón "Publicar cambios"',
                        text: 'Botón principal para aplicar todos los cambios. Al hacer clic, aparece un modal de confirmación. Solo después de publicar, los cambios serán visibles para tus clientes. Los textos y colores requieren publicación, pero las imágenes (logo y favicon) se guardan automáticamente al subirlas.'
                    },
                    'section-header-info': {
                        title: 'Sección: Información del encabezado',
                        text: 'Esta sección contiene los campos para configurar el nombre, descripción y colores del encabezado de tu tienda.'
                    },
                    'section-field-name': {
                        title: 'Campo "Nombre de la tienda"',
                        text: 'Campo de texto para el nombre que aparecerá en el encabezado. Muestra el nombre actual de tu tienda. Puedes modificarlo aquí. <strong>Límites:</strong> Máximo 40 caracteres. Solo permite letras, números, espacios, guiones, acentos y puntos. Se actualiza automáticamente en la vista previa mientras escribes. Este campo es obligatorio.'
                    },
                    'section-field-name-help': {
                        title: 'Ayuda del campo nombre',
                        text: 'Texto que indica: "Máximo 40 caracteres. Solo letras, números, espacios, guiones, acentos y puntos." Te ayuda a entender las restricciones del campo.'
                    },
                    'section-field-description': {
                        title: 'Campo "Descripción breve"',
                        text: 'Campo de texto largo para una descripción corta de tu tienda. Aparece debajo del nombre en el encabezado. <strong>Límites:</strong> Máximo 50 caracteres. Solo permite letras, números, espacios, guiones, acentos, puntos, comas, signos de interrogación y exclamación, y dos puntos. Se actualiza automáticamente en la vista previa mientras escribes.'
                    },
                    'section-field-description-help': {
                        title: 'Ayuda del campo descripción',
                        text: 'Texto que indica: "Máximo 50 caracteres. Aparece debajo del nombre en el encabezado." Te ayuda a entender el propósito y límites del campo.'
                    },
                    'section-help-text': {
                        title: 'Texto de ayuda general',
                        text: 'Mensaje azul que dice: "El nombre admite letras, números, guiones y acentos (máx. 40). La descripción admite hasta 50 caracteres." Proporciona información general sobre los límites de los campos.'
                    },
                    'section-color-background': {
                        title: 'Selector "Color de fondo"',
                        text: 'Te permite elegir el color de fondo del encabezado. Incluye un selector visual de color y un campo de texto para escribir el código hexadecimal. Formato: #RRGGBB (ejemplo: #FFFFFF para blanco, #000000 para negro). Puedes escribir el código hexadecimal o usar el selector visual. Se actualiza automáticamente en la vista previa.'
                    },
                    'section-color-name': {
                        title: 'Selector "Color del nombre"',
                        text: 'Te permite elegir el color del texto del nombre de la tienda. Incluye un selector visual de color y un campo de texto para escribir el código hexadecimal. Formato: #RRGGBB. Se actualiza automáticamente en la vista previa.'
                    },
                    'section-color-description': {
                        title: 'Selector "Color de la descripción"',
                        text: 'Te permite elegir el color del texto de la descripción. Incluye un selector visual de color y un campo de texto para escribir el código hexadecimal. Formato: #RRGGBB. Se actualiza automáticamente en la vista previa.'
                    },
                    'section-preview': {
                        title: 'Sección: Vista previa',
                        text: 'Esta sección muestra cómo se verá el encabezado de tu tienda en tiempo real. Se actualiza automáticamente mientras haces cambios.'
                    },
                    'section-preview-content': {
                        title: 'Panel de vista previa',
                        text: 'Muestra cómo se verá el encabezado de tu tienda: <strong>Logo:</strong> Si tienes logo cargado, aparece en un círculo. Si no, aparecen las primeras dos letras del nombre. <strong>Nombre de la tienda:</strong> Con el color que seleccionaste. <strong>Descripción:</strong> Con el color que seleccionaste. <strong>Fondo:</strong> Con el color de fondo que seleccionaste. La vista previa se actualiza en tiempo real mientras modificas los campos.'
                    },
                    'section-preview-note': {
                        title: 'Nota de vista previa',
                        text: 'Texto que dice: "La vista previa se actualiza automáticamente mientras haces cambios". Te indica que puedes ver los cambios en tiempo real antes de publicarlos.'
                    },
                    'section-logo': {
                        title: 'Sección: Logo',
                        text: 'Esta sección te permite subir y gestionar el logo de tu tienda.'
                    },
                    'section-logo-preview': {
                        title: 'Vista previa del logo',
                        text: 'Si tienes un logo cargado, aparece una imagen circular. Si no tienes logo, aparece un ícono de imagen con el texto "Sin logo cargado".'
                    },
                    'section-logo-upload': {
                        title: 'Campo de subida de logo',
                        text: 'Botón para seleccionar y subir un archivo de imagen. <strong>Formatos aceptados:</strong> PNG, JPG o WebP. <strong>Tamaño máximo:</strong> 2MB. <strong>Nota importante:</strong> Las imágenes se guardan automáticamente al subirlas (no necesitas hacer clic en "Publicar cambios" para guardar el logo).'
                    },
                    'section-logo-info': {
                        title: 'Información sobre el logo',
                        text: 'Mensaje azul que dice: "Las imágenes se guardan automáticamente al subirlas". Te indica que el logo se guarda inmediatamente al subirlo, sin necesidad de publicar los cambios.'
                    },
                    'section-favicon': {
                        title: 'Sección: Favicon',
                        text: 'Esta sección te permite subir y gestionar el favicon de tu tienda.'
                    },
                    'section-favicon-preview': {
                        title: 'Vista previa del favicon',
                        text: 'Si tienes un favicon cargado, aparece una imagen cuadrada pequeña. Si no tienes favicon, aparece un ícono con el texto "Sin favicon cargado".'
                    },
                    'section-favicon-upload': {
                        title: 'Campo de subida de favicon',
                        text: 'Botón para seleccionar y subir un archivo de imagen. <strong>Formatos aceptados:</strong> PNG, ICO o SVG. <strong>Tamaño máximo:</strong> 1MB. <strong>Nota importante:</strong> Las imágenes se guardan automáticamente al subirlas (no necesitas hacer clic en "Publicar cambios" para guardar el favicon).'
                    },
                    'section-favicon-info': {
                        title: 'Información sobre el favicon',
                        text: 'Mensaje azul que dice: "Las imágenes se guardan automáticamente al subirlas". Te indica que el favicon se guarda inmediatamente al subirlo, sin necesidad de publicar los cambios.'
                    },
                    'section-favicon-what': {
                        title: '¿Qué es un favicon?',
                        text: 'Es el pequeño ícono que aparece en la pestaña del navegador junto al nombre de tu sitio. También aparece cuando alguien guarda tu sitio en favoritos. Debe ser una imagen pequeña y simple, idealmente cuadrada.'
                    },
                    'section-modal-cancel': {
                        title: 'Botón "Cancelar" del modal',
                        text: 'Cierra el modal sin publicar los cambios. Te regresa a la vista de configuración sin aplicar los cambios.'
                    },
                    'section-modal-confirm': {
                        title: 'Botón "Publicar ahora" del modal',
                        text: 'Confirma y publica los cambios. Se actualizará el encabezado de tu tienda con los colores, nombre y descripción actuales. El logo y el favicon se publicarán si fueron reemplazados. Los cambios serán visibles inmediatamente para tus clientes.'
                    }
                },

                scrollToSection(sectionId) {
                    if (this.guides[sectionId]) {
                        this.selectedGuide = sectionId;
                        this.selectedGuideTitle = this.guides[sectionId].title;
                        this.selectedGuideText = this.guides[sectionId].text;
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

    {{-- Footer Fijo --}}
    <footer class="fixed bottom-0 left-0 right-0 z-50 bg-slate-950 border-t border-gray-200 shadow-lg"
            x-show="selectedGuide"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform translate-y-full"
            x-transition:enter-end="transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="transform translate-y-0"
            x-transition:leave-end="transform translate-y-full">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-white mb-1" x-text="selectedGuideTitle"></h3>
                    <p class="text-sm text-white leading-relaxed" x-html="selectedGuideText"></p>
                </div>
                <button @click="selectedGuide = null" 
                        class="bg-red-50 rounded-full text-red-600 hover:text-red-700 transition-colors p-1 hover:bg-red-100">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
    </footer>
</body>
</html>
