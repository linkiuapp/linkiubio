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
                        {{-- Replicación del Navbar --}}
                        <div class="bg-white border-b border-gray-200 rounded-lg border p-4 h-20">
                            <div class="h-full flex items-center justify-between gap-3">
                                {{-- Left Side - Greeting and Breadcrumbs --}}
                                <div class="flex flex-col gap-1 min-w-0 flex-1">
                                    <span class="hidden md:block text-sm font-medium text-gray-700 truncate cursor-pointer hover:text-blue-600 transition-colors"
                                          @click="scrollToSection('section-greeting')">
                                        Hola, Juan! Bienvenido a Mi Tienda
                                    </span>
                                    
                                    <nav class="flex items-center gap-2 text-sm text-gray-600" aria-label="Breadcrumb">
                                        <div class="hidden md:flex items-center gap-2">
                                            <a href="#" class="flex items-center gap-1.5 hover:text-blue-600 transition-colors cursor-pointer"
                                               @click.prevent="scrollToSection('section-breadcrumb-dashboard')">
                                                <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                                                <span>Dashboard</span>
                                            </a>
                                            <span class="text-gray-400">/</span>
                                            <span class="flex items-center gap-1.5 text-gray-800 font-medium cursor-pointer hover:text-blue-600 transition-colors"
                                                  @click="scrollToSection('section-breadcrumb-current')">
                                                <i data-lucide="package" class="w-3.5 h-3.5"></i>
                                                <span>Productos</span>
                                            </span>
                                        </div>
                                        
                                        <span class="md:hidden flex items-center gap-1.5 text-gray-800 font-medium">
                                            <i data-lucide="package" class="w-4 h-4"></i>
                                            <span class="truncate">Productos</span>
                                        </span>
                                    </nav>
                                </div>
                                
                                {{-- Right Side - Badges, Button and Notifications --}}
                                <div class="flex items-center gap-3">
                                    {{-- Badge Verificado --}}
                                    <div class="hidden md:block px-3 py-1.5 bg-blue-100 text-blue-800 text-xs font-medium rounded-lg cursor-pointer hover:bg-blue-200 transition-colors"
                                         @click="scrollToSection('section-badge-verified')">
                                        <div class="flex items-center gap-1.5">
                                            <i data-lucide="badge-check" class="w-3.5 h-3.5"></i>
                                            <span>Verificado</span>
                                        </div>
                                    </div>
                                    
                                    {{-- Badge Estatus de Tienda --}}
                                    <div class="hidden md:block px-3 py-1.5 bg-green-100 text-green-800 text-xs font-medium rounded-lg cursor-pointer hover:bg-green-200 transition-colors"
                                         @click="scrollToSection('section-badge-status')">
                                        <div class="flex items-center gap-1.5">
                                            <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                                            <span>Tienda Activa</span>
                                        </div>
                                    </div>
                                    
                                    {{-- Botón Ver Tienda --}}
                                    <a href="#" class="hidden lg:flex items-center gap-2 py-2 px-3 lg:px-4 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-colors cursor-pointer"
                                       @click.prevent="scrollToSection('section-button-view-store')">
                                        <span>Ver mi tienda</span>
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                    
                                    {{-- Menú Ayuda --}}
                                    <div class="relative hidden md:block cursor-pointer"
                                         @click="scrollToSection('section-help-menu')"
                                         x-data="{ helpMenuOpen: false }"
                                         @mouseenter="helpMenuOpen = true"
                                         @mouseleave="helpMenuOpen = false">
                                        <button class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors">
                                            <i data-lucide="help-circle" class="w-5 h-5"></i>
                                            <span>Ayuda</span>
                                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': helpMenuOpen }"></i>
                                        </button>
                                    </div>
                                    
                                    {{-- Notificaciones --}}
                                    <div class="flex items-center gap-2 md:gap-3">
                                        {{-- Pedidos Pendientes --}}
                                        <a href="#" class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors cursor-pointer"
                                           @click.prevent="scrollToSection('section-notification-orders')">
                                            <i data-lucide="party-popper" class="w-5 h-5 md:w-6 md:h-6"></i>
                                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-semibold">5</span>
                                        </a>
                                        
                                        {{-- Tickets de Soporte --}}
                                        <a href="#" class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors cursor-pointer"
                                           @click.prevent="scrollToSection('section-notification-tickets')">
                                            <i data-lucide="message-square-more" class="w-5 h-5 md:w-6 md:h-6"></i>
                                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-blue-500 text-white text-xs rounded-full flex items-center justify-center font-semibold">2</span>
                                        </a>
                                        
                                        {{-- Anuncios --}}
                                        <a href="#" class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors cursor-pointer"
                                           @click.prevent="scrollToSection('section-notification-announcements')">
                                            <i data-lucide="megaphone" class="w-5 h-5 md:w-6 md:h-6"></i>
                                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-yellow-500 text-white text-xs rounded-full flex items-center justify-center font-semibold">1</span>
                                        </a>
                                    </div>
                                </div>
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
                                <p class="text-sm text-gray-700"><strong>Revisa las notificaciones regularmente</strong> para no perder información importante</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa la búsqueda global</strong> para acceder rápidamente a productos o pedidos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El menú de usuario</strong> es el acceso más rápido a tu configuración personal</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>La ayuda está siempre disponible</strong> desde el navbar</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El logo siempre te lleva</strong> de vuelta al dashboard</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si gestionas múltiples tiendas</strong>, usa el selector para cambiar entre ellas fácilmente</p>
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
                    'section-greeting': {
                        title: 'Saludo',
                        text: 'Muestra un saludo personalizado: "Hola, [Tu nombre]! Bienvenido a [Nombre de la tienda]". Te da la bienvenida al panel y te recuerda en qué tienda estás trabajando. Solo visible en pantallas medianas y grandes (md y superiores).'
                    },
                    'section-breadcrumb-dashboard': {
                        title: 'Breadcrumb: Dashboard',
                        text: 'Enlace al dashboard principal. Forma parte del breadcrumb (miga de pan) que muestra tu ubicación actual en el panel. Al hacer clic, te lleva al dashboard. Solo visible en pantallas medianas y grandes.'
                    },
                    'section-breadcrumb-current': {
                        title: 'Breadcrumb: Página Actual',
                        text: 'Muestra la página actual en la que te encuentras. Incluye un ícono representativo y el nombre de la página. Forma parte del breadcrumb que te ayuda a saber dónde estás en el panel.'
                    },
                    'section-badge-verified': {
                        title: 'Badge "Verificado"',
                        text: 'Badge azul que indica si tu tienda está verificada. Muestra "Verificado" (azul) si tu tienda ha sido verificada por el equipo de Linkiu, o "No Verificado" (gris) si aún no ha sido verificada. Solo visible en pantallas medianas y grandes.'
                    },
                    'section-badge-status': {
                        title: 'Badge "Estatus de Tienda"',
                        text: 'Badge que muestra el estado actual de tu tienda. Puede mostrar: "Tienda Activa" (verde) - Tu tienda está activa y funcionando, "Tienda Inactiva" (gris) - Tu tienda está inactiva, "Tienda Suspendida" (amarillo) - Tu tienda está suspendida. Solo visible en pantallas medianas y grandes.'
                    },
                    'section-button-view-store': {
                        title: 'Botón "Ver mi tienda"',
                        text: 'Botón azul redondeado que te permite ver tu tienda pública. Al hacer clic, se abre tu tienda en una nueva pestaña. Útil para ver cómo se ve tu tienda para los clientes. Solo visible en pantallas grandes (lg y superiores).'
                    },
                    'section-help-menu': {
                        title: 'Menú "Ayuda"',
                        text: 'Botón con menú desplegable que se activa al pasar el mouse. Contiene: "Tutoriales" - Enlace a los tutoriales públicos, "Guía Interactiva" - Enlace a esta guía interactiva. Ambos enlaces se abren en una nueva pestaña. La ayuda está siempre disponible desde el navbar.'
                    },
                    'section-notification-orders': {
                        title: 'Notificación: Pedidos Pendientes',
                        text: 'Ícono de party-popper que muestra los pedidos pendientes. Badge rojo con el número de pedidos pendientes (ejemplo: "5" significa 5 pedidos pendientes). Al hacer clic, te lleva al listado de pedidos. Los pedidos pendientes requieren tu atención para ser procesados.'
                    },
                    'section-notification-tickets': {
                        title: 'Notificación: Tickets de Soporte',
                        text: 'Ícono de mensaje que muestra los tickets de soporte abiertos. Badge azul con el número de tickets abiertos (ejemplo: "2" significa 2 tickets abiertos). Al hacer clic, te lleva al listado de tickets de soporte.'
                    },
                    'section-notification-announcements': {
                        title: 'Notificación: Anuncios',
                        text: 'Ícono de megáfono que muestra los anuncios sin leer. Badge amarillo con el número de anuncios sin leer (ejemplo: "1" significa 1 anuncio sin leer). Al hacer clic, te lleva al listado de anuncios. Los anuncios pueden contener información importante sobre actualizaciones o cambios.'
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
