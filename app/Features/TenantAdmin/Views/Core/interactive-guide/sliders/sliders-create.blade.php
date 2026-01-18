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
                                <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                    @click="scrollToSection('section-header-title')">Crear Slider</h1>
                            </div>
                        </div>

                        {{-- Alerta Informativa --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 cursor-pointer hover:bg-blue-100 transition-colors"
                             @click="scrollToSection('section-alert')">
                            <p class="text-sm text-blue-800">
                                Las medidas recomendadas para el slider son de <strong>420x200px</strong>.
                            </p>
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
                                           placeholder="Ej: Promoción Navidad 2024, Banner de Bienvenida"
                                           maxlength="255"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-name')"
                                           readonly>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 255 caracteres</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-description')">
                                        Descripción
                                    </label>
                                    <textarea rows="3" 
                                              placeholder="Ej: Descuentos especiales en toda la tienda"
                                              maxlength="500"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                              @click="scrollToSection('section-field-description')"
                                              readonly></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres. Solo para referencia interna, no aparece en la tienda.</p>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-toggle-active')">Slider activo</label>
                                        <p class="text-xs text-gray-500">El slider se mostrará en la tienda inmediatamente después de crearlo</p>
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
                            
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-blue-400 transition-colors"
                                 @click="scrollToSection('section-image-upload')">
                                <i data-lucide="upload" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                                <p class="text-sm text-gray-600 mb-2">
                                    Arrastra y suelta la imagen aquí, o <span class="text-blue-600 font-medium">haz clic para buscarla</span>
                                </p>
                                <p class="text-xs text-gray-500">
                                    Medidas requeridas: 420x200px • Tamaño máximo: 2MB • Formatos: JPEG, PNG, JPG, GIF
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
                                        Sin enlace
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-url')">
                                        URL
                                    </label>
                                    <input type="text" 
                                           placeholder="Escribe al menos 3 caracteres para buscar (enlace interno) o URL completa (enlace externo)"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-url')"
                                           readonly>
                                    <p class="text-xs text-gray-500 mt-1">Para enlaces internos: escribe al menos 3 caracteres. Para enlaces externos: URL completa que comience con http:// o https://</p>
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
                                    <input type="checkbox" class="peer sr-only">
                                    <span class="absolute inset-0 bg-gray-300 rounded-full transition-colors duration-200 ease-in-out"></span>
                                    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out"></span>
                                </label>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 space-y-4" style="display: none;">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-toggle-permanent')">Slider permanente (sin fecha fin)</label>
                                        <p class="text-xs text-gray-500">El slider no tendrá fecha de fin y estará activo desde la fecha de inicio</p>
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
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-start-date')"
                                               readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-end-date')">Fecha fin</label>
                                        <input type="date" 
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
                                        <label class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors">
                                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded cursor-pointer"
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
                                    <p class="text-xs text-gray-500 mt-1">Valor por defecto: 5 segundos</p>
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
                                    @click="scrollToSection('section-button-create')">
                                Crear Slider
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
                                <p class="text-sm text-gray-700"><strong>Prepara la imagen</strong> con las medidas exactas (420x200px) antes de subirla</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa nombres descriptivos</strong> para identificar fácilmente tus sliders</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los enlaces internos</strong> son ideales para dirigir a categorías o productos específicos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los enlaces externos</strong> son útiles para redes sociales o páginas externas</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>La programación te permite</strong> mostrar sliders solo en fechas/horarios específicos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los sliders programados</strong> son perfectos para promociones temporales</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si no configuras programación</strong>, el slider estará siempre activo (si está activado)</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa la imagen</strong> antes de guardar para asegurarte de que se ve bien</p>
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
                        title: 'Título "Crear Slider"',
                        text: 'Muestra que estás creando un nuevo slider (banner) para tu tienda.'
                    },
                    'section-alert': {
                        title: 'Alerta informativa',
                        text: 'Muestra las medidas recomendadas para la imagen del slider. Mensaje: "Las medidas recomendadas para el slider son de 420x200px." Te ayuda a preparar la imagen con las dimensiones correctas antes de subirla.'
                    },
                    'section-basic-info': {
                        title: 'Sección: Información Básica',
                        text: 'Esta sección contiene los campos básicos del slider: nombre, descripción y estado activo/inactivo.'
                    },
                    'section-field-name': {
                        title: 'Campo "Nombre"',
                        text: 'Escribe un nombre descriptivo para el slider. Ejemplo: "Promoción Navidad 2024", "Banner de Bienvenida". Este nombre aparece en la lista de sliders y te ayuda a identificarlo. Máximo 255 caracteres. Este campo es obligatorio.'
                    },
                    'section-field-description': {
                        title: 'Campo "Descripción"',
                        text: 'Escribe una descripción del slider. Ejemplo: "Descuentos especiales en toda la tienda". Esta descripción es solo para referencia interna, no aparece en la tienda. Máximo 500 caracteres. Este campo es opcional.'
                    },
                    'section-toggle-active': {
                        title: 'Interruptor "Slider activo"',
                        text: 'Si está activado, el slider se mostrará en la tienda inmediatamente después de crearlo. Si está desactivado, el slider se creará como inactivo y deberás activarlo manualmente después. Por defecto está activado.'
                    },
                    'section-image': {
                        title: 'Sección: Imagen',
                        text: 'Esta sección te permite subir la imagen del slider. La imagen es obligatoria y debe tener medidas específicas.'
                    },
                    'section-image-upload': {
                        title: 'Campo de carga de imagen',
                        text: 'Área donde puedes arrastrar y soltar la imagen o hacer clic para buscarla. Medidas requeridas: Exactamente 420x200 píxeles. Tamaño máximo: 2MB. Formatos aceptados: JPEG, PNG, JPG, GIF. La imagen se redimensionará automáticamente si es necesario. Importante: La imagen debe tener las dimensiones correctas para verse bien en la tienda. Este campo es obligatorio.'
                    },
                    'section-link': {
                        title: 'Sección: Enlace',
                        text: 'Esta sección te permite configurar si el slider tendrá un enlace y a dónde llevará cuando los clientes hagan clic en él.'
                    },
                    'section-field-link-type': {
                        title: 'Campo "Tipo de enlace"',
                        text: 'Selecciona uno de los tres tipos: "Sin enlace" - El slider no tendrá enlace, solo se mostrará como imagen, "Enlace interno" - El slider llevará a una página dentro de tu tienda (categoría o producto), "Enlace externo" - El slider llevará a una página fuera de tu tienda (redes sociales, otra web, etc.). Este campo es obligatorio.'
                    },
                    'section-field-url': {
                        title: 'Campo "URL"',
                        text: 'Si seleccionaste "Sin enlace": El campo estará deshabilitado. Si seleccionaste "Enlace interno": Escribe al menos 3 caracteres para buscar. Aparecerá una lista de sugerencias con categorías y productos de tu tienda. Puedes hacer clic en una sugerencia para seleccionarla. Ejemplos: /categoria/ropa, /producto/camiseta. El sistema busca automáticamente mientras escribes. Si seleccionaste "Enlace externo": Escribe la URL completa. Ejemplo: https://instagram.com/mitienda, https://facebook.com/mitienda. Debe comenzar con http:// o https://.'
                    },
                    'section-scheduling': {
                        title: 'Sección: Programación',
                        text: 'Esta sección te permite configurar cuándo se mostrará el slider. Puedes programar fechas, horarios y días específicos.'
                    },
                    'section-toggle-schedule': {
                        title: 'Interruptor "Programar slider"',
                        text: 'Si está activado, aparecerán opciones para configurar cuándo se mostrará el slider. Si está desactivado, el slider estará siempre activo (si está activado). Por defecto está desactivado.'
                    },
                    'section-toggle-permanent': {
                        title: 'Interruptor "Slider permanente (sin fecha fin)"',
                        text: 'Si está activado, el slider no tendrá fecha de fin y estará activo desde la fecha de inicio. Si está desactivado, deberás configurar fecha de inicio y fin.'
                    },
                    'section-field-start-date': {
                        title: 'Campo "Fecha inicio"',
                        text: 'Selecciona la fecha desde la cual el slider comenzará a mostrarse. Si no configuras fecha, el slider comenzará inmediatamente. Este campo es opcional.'
                    },
                    'section-field-end-date': {
                        title: 'Campo "Fecha fin"',
                        text: 'Selecciona la fecha hasta la cual el slider se mostrará. Debe ser igual o posterior a la fecha de inicio. Si no configuras fecha fin y no es permanente, el slider no expirará. Este campo es opcional.'
                    },
                    'section-field-start-time': {
                        title: 'Campo "Hora inicio"',
                        text: 'Selecciona la hora del día desde la cual el slider comenzará a mostrarse. Ejemplo: 09:00 (9 de la mañana). Este campo es opcional.'
                    },
                    'section-field-end-time': {
                        title: 'Campo "Hora fin"',
                        text: 'Selecciona la hora del día hasta la cual el slider se mostrará. Debe ser posterior a la hora de inicio. Ejemplo: 18:00 (6 de la tarde). Este campo es opcional.'
                    },
                    'section-field-days': {
                        title: 'Días de la semana',
                        text: 'Marca los días de la semana en los que el slider será válido. Opciones: L (Lunes), M (Martes), X (Miércoles), J (Jueves), V (Viernes), S (Sábado), D (Domingo). Puedes marcar varios días. Si no marcas ningún día, el slider será válido todos los días. Este campo es opcional.'
                    },
                    'section-field-transition': {
                        title: 'Campo "Duración de transición"',
                        text: 'Define cuántos segundos durará la transición entre sliders. Valor por defecto: 5 segundos. Puedes ajustarlo según prefieras. Controla qué tan rápido cambia de un slider a otro cuando hay múltiples sliders activos.'
                    },
                    'section-button-cancel': {
                        title: 'Botón "Cancelar"',
                        text: 'Cancela la creación y regresa al listado de sliders. No guarda ningún cambio.'
                    },
                    'section-button-create': {
                        title: 'Botón "Crear Slider"',
                        text: 'Guarda el nuevo slider con toda la configuración. Valida que todos los campos obligatorios estén completos (nombre e imagen). Si hay errores, los mostrará en rojo debajo de cada campo.'
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
