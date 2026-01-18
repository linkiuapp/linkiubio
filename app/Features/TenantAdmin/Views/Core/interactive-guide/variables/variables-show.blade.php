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
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-200">
                            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                    @click="scrollToSection('section-header-back')">
                                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            </button>
                            <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                @click="scrollToSection('section-header-title')">Detalles de Variable</h1>
                        </div>

                        {{-- Encabezado de Tarjeta --}}
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="w-12 h-12 bg-white rounded-lg border border-gray-200 p-2 flex items-center justify-center cursor-pointer hover:border-blue-300 transition-colors"
                                         @click="scrollToSection('section-header-icon')">
                                        <div class="w-6 h-6 bg-gray-200 rounded"></div>
                                    </div>
                                    <div class="flex-1 min-w-0 cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-header-info')">
                                        <h2 class="text-base font-semibold text-gray-900 truncate">Talla</h2>
                                        <div class="flex items-center gap-2 flex-wrap mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activa</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Requerida</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Selección única</span>
                                        </div>
                                    </div>
                                </div>
                                <button class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors text-sm cursor-pointer"
                                        @click="scrollToSection('section-header-edit')">
                                    <i data-lucide="edit" class="w-4 h-4 inline"></i>
                                    Editar
                                </button>
                            </div>
                        </div>

                        {{-- Información General --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <h3 class="text-sm font-semibold text-gray-900 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                    @click="scrollToSection('section-info-general')">Información General</h3>
                                <div class="space-y-2">
                                    <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-info-name')">
                                        <span class="text-xs font-medium text-gray-500">Nombre:</span>
                                        <p class="text-sm text-gray-900 mt-0.5">Talla</p>
                                    </div>
                                    <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-info-type')">
                                        <span class="text-xs font-medium text-gray-500">Tipo:</span>
                                        <p class="text-sm text-gray-900 mt-0.5">Selección única</p>
                                    </div>
                                    <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-info-status')">
                                        <span class="text-xs font-medium text-gray-500">Estado:</span>
                                        <p class="text-sm text-gray-900 mt-0.5">Activa</p>
                                    </div>
                                    <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-info-required')">
                                        <span class="text-xs font-medium text-gray-500">Requerida por defecto:</span>
                                        <p class="text-sm text-gray-900 mt-0.5">Sí</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-sm font-semibold text-gray-900 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                    @click="scrollToSection('section-info-config')">Configuración</h3>
                                <div class="space-y-2">
                                    <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-info-entry')">
                                        <span class="text-xs font-medium text-gray-500">Tipo de entrada:</span>
                                        <p class="text-sm text-gray-900 mt-0.5">Con opciones predefinidas</p>
                                    </div>
                                    <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-info-dates')">
                                        <span class="text-xs font-medium text-gray-500">Creado:</span>
                                        <p class="text-xs text-gray-900 mt-0.5">08/01/2025 14:30</p>
                                    </div>
                                    <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-info-dates')">
                                        <span class="text-xs font-medium text-gray-500">Actualizado:</span>
                                        <p class="text-xs text-gray-900 mt-0.5">08/01/2025 14:30</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Estadísticas --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-stats')">Estadísticas</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 cursor-pointer hover:bg-gray-100 transition-colors"
                                     @click="scrollToSection('section-stats-options')">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500">Opciones</p>
                                            <p class="text-lg font-bold text-gray-900 mt-0.5">5</p>
                                        </div>
                                        <i data-lucide="list" class="w-5 h-5 text-blue-600 shrink-0"></i>
                                    </div>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 cursor-pointer hover:bg-gray-100 transition-colors"
                                     @click="scrollToSection('section-stats-products')">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500">Productos</p>
                                            <p class="text-lg font-bold text-gray-900 mt-0.5">12</p>
                                        </div>
                                        <i data-lucide="package" class="w-5 h-5 text-blue-600 shrink-0"></i>
                                    </div>
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 cursor-pointer hover:bg-gray-100 transition-colors"
                                     @click="scrollToSection('section-stats-date')">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs font-medium text-gray-500">Creada</p>
                                            <p class="text-xs text-gray-900 mt-0.5">08/01/2025</p>
                                        </div>
                                        <i data-lucide="calendar" class="w-5 h-5 text-blue-600 shrink-0"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Opciones --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-options')">Opciones de la Variable</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @for($i = 0; $i < 5; $i++)
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 cursor-pointer hover:bg-gray-100 hover:border-gray-300 transition-all"
                                     @click="scrollToSection('section-option-item')">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="h-3 bg-gray-300 rounded w-16"></div>
                                        <span class="text-xs text-gray-500">#{{ $i + 1 }}</span>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="h-2 bg-gray-200 rounded w-20"></div>
                                        <div class="h-2 bg-gray-200 rounded w-24"></div>
                                    </div>
                                    <div class="pt-2 border-t border-gray-200 mt-2">
                                        <div class="h-2 bg-gray-200 rounded w-20"></div>
                                    </div>
                                </div>
                                @endfor
                            </div>
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
                                <p class="text-sm text-gray-700"><strong>Revisa las opciones:</strong> Asegúrate de que todas las opciones estén correctas y completas</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa los productos:</strong> Ve cuántos productos usan esta variable antes de hacer cambios importantes</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa el botón Editar:</strong> Para modificar cualquier información de la variable</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa las fechas:</strong> Te ayudan a saber cuándo se creó y cuándo se modificó por última vez</p>
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
                        title: 'Botón de Regreso',
                        text: 'Este botón te lleva de vuelta a la lista de todas las variables.'
                    },
                    'section-header-title': {
                        title: 'Título "Detalles de Variable"',
                        text: 'Muestra que estás viendo la información detallada de una variable.'
                    },
                    'section-header-icon': {
                        title: 'Ícono de la Variable',
                        text: 'Muestra un icono grande que representa el tipo de variable o su nombre. El icono aparece en un cuadro gris claro. Iconos según nombre: Si el nombre contiene "color": Aparece un icono de paleta. Si el nombre contiene "talla" o "size": Aparece un icono de regla. Otros: Aparece un icono según el tipo de variable.'
                    },
                    'section-header-info': {
                        title: 'Badges de Estado',
                        text: 'Aparecen varios badges de colores que muestran información importante: Badge de Estado (Verde o Rojo): Verde "Activa" - La variable está activa y se puede usar en productos. Rojo "Inactiva" - La variable está inactiva y no se puede usar en productos. Badge "Requerida" (Azul): Solo aparece si la variable está configurada como requerida por defecto. Indica que esta variable será obligatoria cuando crees productos nuevos. Badge de Tipo (Azul): Muestra el tipo de variable: "Selección única", "Selección múltiple", "Texto libre", "Numérico".'
                    },
                    'section-header-edit': {
                        title: 'Botón "Editar"',
                        text: 'En el lado derecho del encabezado hay un botón "Editar" que te lleva a la pantalla de edición donde puedes modificar los datos de la variable.'
                    },
                    'section-info-general': {
                        title: 'Información General',
                        text: 'Esta sección muestra los datos principales de la variable.'
                    },
                    'section-info-name': {
                        title: 'Nombre',
                        text: 'El nombre completo de la variable.'
                    },
                    'section-info-type': {
                        title: 'Tipo',
                        text: 'El tipo de variable con su nombre completo (no la abreviación técnica).'
                    },
                    'section-info-status': {
                        title: 'Estado',
                        text: 'Muestra si está activa o inactiva.'
                    },
                    'section-info-required': {
                        title: 'Requerida por defecto',
                        text: 'Solo aparece si está activada. Muestra "Sí" si la variable es requerida por defecto en productos nuevos.'
                    },
                    'section-info-config': {
                        title: 'Configuración',
                        text: 'Esta sección muestra la configuración específica de la variable según su tipo.'
                    },
                    'section-info-entry': {
                        title: 'Tipo de entrada',
                        text: 'Muestra: "Con opciones predefinidas" - Si es selección única o múltiple. "Entrada libre" - Si es texto libre.'
                    },
                    'section-info-dates': {
                        title: 'Fechas',
                        text: 'Muestra cuándo se creó y cuándo se modificó por última vez la variable.'
                    },
                    'section-stats': {
                        title: 'Estadísticas',
                        text: 'Esta sección muestra estadísticas importantes sobre la variable.'
                    },
                    'section-stats-options': {
                        title: 'Tarjeta "Opciones"',
                        text: 'Muestra cuántas opciones tiene la variable. Solo aparece si la variable es de tipo selección (radio o checkbox).'
                    },
                    'section-stats-products': {
                        title: 'Tarjeta "Productos"',
                        text: 'Muestra cuántos productos tienen asociada esta variable. Te ayuda a entender el impacto de esta variable en tu catálogo.'
                    },
                    'section-stats-date': {
                        title: 'Tarjeta "Creada"',
                        text: 'Muestra la fecha en que se creó la variable.'
                    },
                    'section-options': {
                        title: 'Opciones de la Variable',
                        text: 'Esta sección solo aparece si la variable es de tipo selección (radio o checkbox). Muestra todas las opciones que los clientes pueden elegir.'
                    },
                    'section-option-item': {
                        title: 'Cada opción muestra',
                        text: 'Nombre: El nombre de la opción. Modificador de Precio: Si la opción tiene un precio adicional o descuento, aparece aquí. Color (hex): Si la opción tiene un código de color, aparece un círculo de color y el código. Fecha de creación: Cuándo se creó la opción.'
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
