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
                        <div class="pb-4 border-b border-gray-200">
                            <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                @click="scrollToSection('section-header-title')">Ticker de Promociones</h1>
                            <p class="text-sm text-gray-600 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                               @click="scrollToSection('section-header-subtitle')">
                                Textos promocionales que se mostrarán en la página de inicio de tu tienda
                            </p>
                        </div>

                        {{-- Configuración Global --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-global-config')">Configuración Global</h3>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-bg-color')">
                                            Color de fondo
                                        </label>
                                        <div class="flex items-center gap-3">
                                            <input type="color" 
                                                   value="#1e293b"
                                                   class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-field-bg-color')"
                                                   readonly>
                                            <input type="text" 
                                                   value="#1e293b"
                                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors font-mono"
                                                   @click="scrollToSection('section-field-bg-color')"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-text-color')">
                                            Color del texto
                                        </label>
                                        <div class="flex items-center gap-3">
                                            <input type="color" 
                                                   value="#ffffff"
                                                   class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-field-text-color')"
                                                   readonly>
                                            <input type="text" 
                                                   value="#ffffff"
                                                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors font-mono"
                                                   @click="scrollToSection('section-field-text-color')"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-speed')">
                                        Velocidad de desplazamiento
                                    </label>
                                    <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                         @click="scrollToSection('section-field-speed')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        Medio
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Textos del Ticker --}}
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                    @click="scrollToSection('section-texts')">Textos del Ticker</h3>
                                <span class="text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors"
                                      @click="scrollToSection('section-texts-counter')">3/8</span>
                            </div>
                            
                            <button class="mb-4 inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors text-sm cursor-pointer"
                                    @click="scrollToSection('section-button-add-text')">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Agregar Texto
                            </button>

                            <div class="space-y-3">
                                @for($i = 0; $i < 3; $i++)
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-5 h-5 text-gray-400 cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-drag-handle')">
                                            <i data-lucide="grip-vertical" class="w-5 h-5"></i>
                                        </div>
                                        <input type="text" 
                                               value="{{ ['🎉 ¡Descuentos del 50% en toda la tienda! 🎉', '🚚 Envío gratis en compras mayores a $50.000', '⭐ Nuevos productos disponibles'][$i] }}"
                                               maxlength="100"
                                               placeholder="Escribe el texto promocional..."
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-text-field')"
                                               readonly>
                                        <button class="px-3 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:bg-gray-50 transition-colors"
                                                @click="scrollToSection('section-button-emoji')">
                                            😀
                                        </button>
                                        <label class="relative inline-block w-11 h-6 cursor-pointer"
                                               @click="scrollToSection('section-text-toggle')">
                                            <input type="checkbox" class="peer sr-only" {{ $i < 2 ? 'checked' : '' }}>
                                            <span class="absolute inset-0 {{ $i < 2 ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full transition-colors duration-200 ease-in-out"></span>
                                            <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out {{ $i < 2 ? 'peer-checked:translate-x-full' : '' }}"></span>
                                        </label>
                                        <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-button-save')">
                                            <i data-lucide="save" class="w-4 h-4"></i>
                                        </button>
                                        <button class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-button-delete-text')">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Vista Previa --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-preview')">Vista Previa</h3>
                            
                            <div class="bg-gray-800 rounded-lg p-4 overflow-hidden cursor-pointer hover:bg-gray-700 transition-colors"
                                 @click="scrollToSection('section-preview-ticker')">
                                <div class="flex items-center gap-4 text-white text-sm whitespace-nowrap animate-scroll">
                                    <span>🎉 ¡Descuentos del 50% en toda la tienda! 🎉</span>
                                    <span class="text-gray-400">•</span>
                                    <span>🚚 Envío gratis en compras mayores a $50.000</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">La vista previa muestra solo los textos que están activos</p>
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
                                <p class="text-sm text-gray-700"><strong>Usa textos cortos y claros</strong> para que sean fáciles de leer mientras se desplazan</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Combina textos informativos</strong> y promocionales para mantener el interés</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa emojis con moderación</strong> para hacer los textos más atractivos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa la vista previa</strong> siempre antes de publicar</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Mantén los textos actualizados</strong> para mantener el interés</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Elige colores contrastantes</strong> para que el texto sea visible sobre el fondo</p>
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
                        title: 'Título "Ticker de Promociones"',
                        text: 'Muestra que estás en la sección de configuración del ticker promocional. El ticker es una cinta animada que se muestra en la parte superior de tu tienda, justo debajo del menú principal.'
                    },
                    'section-header-subtitle': {
                        title: 'Subtítulo',
                        text: 'Explica que los textos promocionales se mostrarán en la página de inicio de tu tienda. Muestra textos que se desplazan continuamente de izquierda a derecha, creando un efecto visual atractivo para comunicar ofertas, promociones o mensajes importantes.'
                    },
                    'section-global-config': {
                        title: 'Sección: Configuración Global',
                        text: 'Esta sección controla la apariencia general del ticker. Los cambios se aplican a todos los textos. Incluye color de fondo, color del texto y velocidad de desplazamiento.'
                    },
                    'section-field-bg-color': {
                        title: 'Campo "Color de fondo"',
                        text: 'Selector de color para elegir el color de fondo de la cinta. Por defecto: Gris oscuro (#1e293b). Puedes hacer clic en el selector para elegir cualquier color. El color se aplica a toda la cinta del ticker. También puedes escribir el código hexadecimal directamente.'
                    },
                    'section-field-text-color': {
                        title: 'Campo "Color del texto"',
                        text: 'Selector de color para elegir el color del texto. Por defecto: Blanco (#ffffff). Puedes hacer clic en el selector para elegir cualquier color. El color se aplica a todos los textos del ticker. También puedes escribir el código hexadecimal directamente.'
                    },
                    'section-field-speed': {
                        title: 'Campo "Velocidad de desplazamiento"',
                        text: 'Selector con tres opciones: "Lento" - El texto se desplaza más despacio, "Medio" - Velocidad intermedia (recomendado), "Rápido" - El texto se desplaza más rápido. Por defecto: Medio. La velocidad afecta a todos los textos del ticker.'
                    },
                    'section-texts': {
                        title: 'Sección: Textos del Ticker',
                        text: 'Esta sección te permite gestionar los textos promocionales que aparecerán en el ticker. Puedes agregar hasta 8 textos diferentes.'
                    },
                    'section-texts-counter': {
                        title: 'Contador de textos',
                        text: 'Muestra cuántos textos tienes de un máximo de 8. Ejemplo: "3/8" significa que tienes 3 textos configurados de un máximo de 8 disponibles.'
                    },
                    'section-button-add-text': {
                        title: 'Botón "Agregar Texto"',
                        text: 'Te permite agregar un nuevo texto al ticker. Solo aparece si tienes menos de 8 textos. Si has alcanzado el límite de 8, el botón aparece deshabilitado.'
                    },
                    'section-drag-handle': {
                        title: 'Ícono de arrastrar',
                        text: 'Ícono de grip vertical que aparece a la izquierda de cada texto. Permite arrastrar y soltar para reordenar los textos. El orden determina en qué secuencia aparecen en el ticker.'
                    },
                    'section-text-field': {
                        title: 'Campo de texto',
                        text: 'Campo donde escribes el texto promocional. Máximo 100 caracteres. Puedes incluir emojis directamente en el texto. Ejemplo: "🎉 ¡Descuentos del 50% en toda la tienda! 🎉".'
                    },
                    'section-button-emoji': {
                        title: 'Botón de emoji',
                        text: 'Botón que abre un selector de emojis. Al hacer clic, aparece un panel con emojis comunes. Puedes hacer clic en un emoji para agregarlo al texto. También puedes escribir un emoji directamente en el campo de texto que aparece en el panel. El panel se cierra automáticamente al seleccionar un emoji.'
                    },
                    'section-text-toggle': {
                        title: 'Interruptor Activo/Inactivo',
                        text: 'Toggle para activar o desactivar cada texto individualmente. Si está activado (azul), el texto se mostrará en el ticker. Si está desactivado (gris), el texto no se mostrará. Por defecto, los nuevos textos están activados.'
                    },
                    'section-button-save': {
                        title: 'Botón Guardar',
                        text: 'Ícono de guardar. Guarda los cambios del texto. Solo está habilitado si el texto no está vacío. Aparece un mensaje de confirmación al guardar.'
                    },
                    'section-button-delete-text': {
                        title: 'Botón Eliminar',
                        text: 'Ícono de basurero. Elimina el texto del ticker. Aparece un modal pidiendo confirmación antes de eliminar.'
                    },
                    'section-preview': {
                        title: 'Sección: Vista Previa',
                        text: 'Esta sección muestra cómo se verá el ticker en tu tienda. Usa los colores configurados (fondo y texto) y muestra solo los textos que están activos.'
                    },
                    'section-preview-ticker': {
                        title: 'Cinta de vista previa',
                        text: 'Muestra cómo se verá el ticker en tu tienda. Usa los colores configurados (fondo y texto). Muestra solo los textos que están activos. Se desplaza automáticamente mostrando la velocidad configurada. Los textos aparecen separados por un punto (•). Si no hay textos activos, la cinta aparece vacía.'
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
