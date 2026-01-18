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
                            <div class="flex items-center gap-3">
                                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                        @click="scrollToSection('section-header-back')">
                                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                                </button>
                                <div>
                                    <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                        @click="scrollToSection('section-header-title')">Editar Slider</h1>
                                    <p class="text-sm text-gray-600 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-header-subtitle')">Promoción Navidad 2024</p>
                                </div>
                            </div>
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                    @click="scrollToSection('section-button-view')">
                                Ver detalles
                            </button>
                        </div>

                        {{-- Sección: Información Básica --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-basic-info')">Información Básica</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-name')">
                                        Nombre <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           value="Promoción Navidad 2024"
                                           maxlength="255"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-name')"
                                           readonly>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-description')">
                                        Descripción
                                    </label>
                                    <textarea rows="3" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                              @click="scrollToSection('section-field-description')"
                                              readonly>Descuentos especiales en toda la tienda</textarea>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-toggle-active')">Slider activo</label>
                                        <p class="text-xs text-gray-500">El slider se mostrará en la tienda</p>
                                    </div>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle-active')">
                                        <input type="checkbox" class="peer sr-only" checked>
                                        <span class="absolute inset-0 bg-blue-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Imagen --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-image')">Imagen</h3>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                   @click="scrollToSection('section-image-current')">Imagen actual:</p>
                                <div class="w-full max-w-md border border-gray-300 rounded-lg overflow-hidden">
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <i data-lucide="image" class="w-16 h-16 text-gray-400"></i>
                                    </div>
                                    <div class="px-4 py-2 bg-gray-50 border-t border-gray-200">
                                        <p class="text-xs text-gray-600">420x200px</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-blue-400 transition-colors"
                                 @click="scrollToSection('section-image-upload')">
                                <i data-lucide="upload" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                                <p class="text-sm text-gray-600 mb-2">
                                    Arrastra y suelta una nueva imagen aquí, o <span class="text-blue-600 font-medium">haz clic para buscarla</span>
                                </p>
                                <p class="text-xs text-gray-500">
                                    Si subes una nueva imagen, reemplazará la anterior. Medidas: 420x200px • Máx: 2MB
                                </p>
                            </div>
                        </div>

                        {{-- Sección: Enlace --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-link')">Enlace</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-link-type')">
                                        Tipo de enlace <span class="text-red-500">*</span>
                                    </label>
                                    <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                         @click="scrollToSection('section-field-link-type')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        Enlace interno
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-url')">
                                        URL
                                    </label>
                                    <input type="text" 
                                           value="/categoria/ropa"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-url')"
                                           readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Programación --}}
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                    @click="scrollToSection('section-scheduling')">Programación</h3>
                                <label class="relative inline-block w-11 h-6 cursor-pointer"
                                       @click="scrollToSection('section-toggle-schedule')">
                                    <input type="checkbox" class="peer sr-only" checked>
                                    <span class="absolute inset-0 bg-blue-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                </label>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-toggle-permanent')">Slider permanente (sin fecha fin)</label>
                                        <p class="text-xs text-gray-500">El slider no tendrá fecha de fin</p>
                                    </div>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle-permanent')">
                                        <input type="checkbox" class="peer sr-only">
                                        <span class="absolute inset-0 bg-gray-300 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out"></span>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-start-date')">Fecha inicio</label>
                                        <input type="date" 
                                               value="2025-01-01"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-start-date')"
                                               readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-end-date')">Fecha fin</label>
                                        <input type="date" 
                                               value="2025-01-31"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-end-date')"
                                               readonly>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-start-time')">Hora inicio</label>
                                        <input type="time" 
                                               value="09:00"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-start-time')"
                                               readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-end-time')">Hora fin</label>
                                        <input type="time" 
                                               value="18:00"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-end-time')"
                                               readonly>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-days')">Días de la semana</label>
                                    <div class="flex flex-wrap gap-2">
                                        @php
                                            $days = ['L' => 'Lunes', 'M' => 'Martes', 'X' => 'Miércoles', 'J' => 'Jueves', 'V' => 'Viernes', 'S' => 'Sábado', 'D' => 'Domingo'];
                                        @endphp
                                        @foreach($days as $letter => $name)
                                        <label class="flex items-center gap-2 px-3 py-2 bg-white border {{ in_array($letter, ['L', 'M', 'X', 'J', 'V']) ? 'border-blue-200' : 'border-gray-300' }} rounded-lg cursor-pointer hover:border-blue-300 transition-colors">
                                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded cursor-pointer" 
                                                   {{ in_array($letter, ['L', 'M', 'X', 'J', 'V']) ? 'checked' : '' }}
                                                   @click="scrollToSection('section-field-days')">
                                            <span class="text-sm text-gray-700">{{ $letter }}</span>
                                            <span class="text-xs text-gray-500">({{ $name }})</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-transition')">
                                        Duración de transición (segundos)
                                    </label>
                                    <input type="number" 
                                           value="5"
                                           min="1"
                                           max="60"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-transition')"
                                           readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex gap-3 justify-between pt-4 border-t border-gray-200">
                            <button type="button" 
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                    @click="scrollToSection('section-button-cancel')">
                                Cancelar
                            </button>
                            <button type="button" 
                                    class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                    @click="scrollToSection('section-button-save')">
                                Guardar cambios
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
                                <p class="text-sm text-gray-700"><strong>Revisa los valores actuales</strong> antes de modificarlos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si solo quieres cambiar la imagen</strong>, no necesitas modificar otros campos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los cambios en la programación</strong> afectarán cuándo se muestra el slider</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si desactivas la programación</strong>, el slider estará siempre activo (si está activado)</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa la vista previa de la imagen</strong> para verificar que sea la correcta</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si cambias el tipo de enlace</strong>, verifica que la nueva URL sea correcta</p>
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
                    'section-header-back': {
                        title: 'Botón "Volver"',
                        text: 'Te regresa al listado de sliders sin guardar cambios.'
                    },
                    'section-header-title': {
                        title: 'Título "Editar Slider"',
                        text: 'Muestra que estás editando un slider existente.'
                    },
                    'section-header-subtitle': {
                        title: 'Subtítulo',
                        text: 'Muestra el nombre del slider que estás editando. Ejemplo: "Promoción Navidad 2024". Te ayuda a identificar qué slider estás editando.'
                    },
                    'section-button-view': {
                        title: 'Botón "Ver detalles"',
                        text: 'Te lleva a la página de detalles del slider donde puedes ver toda la información completa, imagen, enlace y programación.'
                    },
                    'section-basic-info': {
                        title: 'Sección: Información Básica',
                        text: 'Todos los campos son iguales a la creación, pero muestran los valores actuales. Puedes modificar cualquier campo.'
                    },
                    'section-field-name': {
                        title: 'Campo "Nombre"',
                        text: 'Muestra el nombre actual del slider. Puedes modificarlo. Máximo 255 caracteres.'
                    },
                    'section-field-description': {
                        title: 'Campo "Descripción"',
                        text: 'Muestra la descripción actual si está configurada. Puedes modificarla o dejarla vacía. Máximo 500 caracteres.'
                    },
                    'section-toggle-active': {
                        title: 'Interruptor "Slider activo"',
                        text: 'Muestra el estado activo/inactivo actual. Puedes cambiar el estado activo/inactivo del slider.'
                    },
                    'section-image': {
                        title: 'Sección: Imagen',
                        text: 'Esta sección muestra la imagen actual y te permite subir una nueva imagen para reemplazarla.'
                    },
                    'section-image-current': {
                        title: 'Vista previa de la imagen actual',
                        text: 'Muestra la imagen que tiene el slider actualmente. Puedes ver las dimensiones y el tamaño. Te ayuda a verificar qué imagen tiene antes de cambiarla.'
                    },
                    'section-image-upload': {
                        title: 'Campo de carga de nueva imagen',
                        text: 'Si subes una nueva imagen, reemplazará la anterior. La imagen anterior se eliminará automáticamente. Medidas requeridas: Exactamente 420x200 píxeles. Tamaño máximo: 2MB. Formatos aceptados: JPEG, PNG, JPG, GIF. Si no subes una nueva imagen, se mantendrá la actual. Este campo es opcional.'
                    },
                    'section-link': {
                        title: 'Sección: Enlace',
                        text: 'Todos los campos son iguales a la creación, pero muestran los valores actuales. Puedes cambiar cualquier configuración de enlace.'
                    },
                    'section-field-link-type': {
                        title: 'Campo "Tipo de enlace"',
                        text: 'Muestra el tipo actual. Puedes cambiarlo. Si cambias a "Enlace interno", puedes buscar nuevamente. Si cambias a "Enlace externo", puedes escribir una nueva URL. Si cambias a "Sin enlace", el campo se deshabilitará.'
                    },
                    'section-field-url': {
                        title: 'Campo "URL"',
                        text: 'Muestra la URL actual. Puedes modificarla. Si cambias el tipo de enlace, deberás buscar y seleccionar nuevamente (enlace interno) o escribir una nueva URL (enlace externo).'
                    },
                    'section-scheduling': {
                        title: 'Sección: Programación',
                        text: 'Todos los campos son iguales a la creación, pero muestran los valores actuales. Puedes modificar cualquier restricción de programación.'
                    },
                    'section-toggle-schedule': {
                        title: 'Interruptor "Programar slider"',
                        text: 'Muestra si la programación está activada. Puedes activar o desactivar la programación. Si desactivas la programación, el slider estará siempre activo (si está activado).'
                    },
                    'section-toggle-permanent': {
                        title: 'Interruptor "Slider permanente"',
                        text: 'Muestra si el slider es permanente. Puedes cambiarlo. Si está activado, el slider no tendrá fecha de fin.'
                    },
                    'section-field-start-date': {
                        title: 'Campo "Fecha inicio"',
                        text: 'Muestra la fecha de inicio actual si está configurada. Puedes modificarla. Si no configuras fecha, el slider comenzará inmediatamente.'
                    },
                    'section-field-end-date': {
                        title: 'Campo "Fecha fin"',
                        text: 'Muestra la fecha de fin actual si está configurada. Puedes modificarla. Debe ser igual o posterior a la fecha de inicio.'
                    },
                    'section-field-start-time': {
                        title: 'Campo "Hora inicio"',
                        text: 'Muestra la hora de inicio actual si está configurada. Puedes modificarla.'
                    },
                    'section-field-end-time': {
                        title: 'Campo "Hora fin"',
                        text: 'Muestra la hora de fin actual si está configurada. Puedes modificarla. Debe ser posterior a la hora de inicio.'
                    },
                    'section-field-days': {
                        title: 'Días de la semana',
                        text: 'Muestra los días actualmente seleccionados. Puedes marcar o desmarcar días. Si no marcas ningún día, el slider será válido todos los días.'
                    },
                    'section-field-transition': {
                        title: 'Campo "Duración de transición"',
                        text: 'Muestra la duración actual. Puedes modificarla. Controla qué tan rápido cambia de un slider a otro.'
                    },
                    'section-button-cancel': {
                        title: 'Botón "Cancelar"',
                        text: 'Cancela la edición y regresa al listado de sliders. No guarda ningún cambio.'
                    },
                    'section-button-save': {
                        title: 'Botón "Guardar cambios"',
                        text: 'Guarda todas las modificaciones realizadas. Valida que todos los campos obligatorios estén completos. Si hay errores, los mostrará en rojo debajo de cada campo. La imagen anterior se elimina si subes una nueva.'
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
