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
                        {{-- Replicación del Sidebar --}}
                        <div class="w-72 bg-white border-r border-gray-200 rounded-lg border">
                            {{-- Header con toggle --}}
                            <header class="py-2 px-4 flex items-center justify-end cursor-pointer hover:bg-gray-50 transition-colors"
                                    @click="scrollToSection('section-header')">
                                <button class="flex justify-center items-center size-9 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">
                                    <i data-lucide="panel-left-close" class="w-6 h-6"></i>
                                </button>
                            </header>
                            
                            {{-- Logo/Tienda --}}
                            <div class="px-4 py-3 mb-2 cursor-pointer hover:bg-gray-50 rounded-lg mx-2 transition-colors"
                                 @click="scrollToSection('section-logo')">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i data-lucide="store" class="w-4 h-4 text-gray-600"></i>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">Mi Tienda</span>
                                </div>
                            </div>
                            
                            {{-- Navegación --}}
                            <nav class="px-2 pb-2">
                                {{-- Sección: Favoritos --}}
                                <div class="mt-5 mb-2 first:mt-0">
                                    <p class="px-2.5 py-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-favorites')">Favoritos</p>
                                </div>
                                <ul class="space-y-1">
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-dashboard')">
                                            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-orders')">
                                            <i data-lucide="party-popper" class="w-5 h-5"></i>
                                            <span class="flex-1 flex items-center justify-between gap-x-2">
                                                <span>Pedidos</span>
                                                <span class="py-0.5 px-2 text-xs rounded-full font-semibold bg-red-500 text-white">5</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                
                                {{-- Sección: Tienda y productos --}}
                                <div class="mt-5 mb-2">
                                    <p class="px-2.5 py-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-store-products')">Tienda y productos</p>
                                </div>
                                <ul class="space-y-1">
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-categories')">
                                            <i data-lucide="layout-list" class="w-5 h-5"></i>
                                            <span class="flex-1 flex items-center justify-between gap-x-2">
                                                <span>Categorías</span>
                                                <span class="py-0.5 px-2 text-xs rounded-full font-semibold bg-gray-400 text-white">3/10</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-variables')">
                                            <i data-lucide="tag" class="w-5 h-5"></i>
                                            <span class="flex-1 flex items-center justify-between gap-x-2">
                                                <span>Variables</span>
                                                <span class="py-0.5 px-2 text-xs rounded-full font-semibold bg-gray-400 text-white">2/50</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-products')">
                                            <i data-lucide="package" class="w-5 h-5"></i>
                                            <span class="flex-1 flex items-center justify-between gap-x-2">
                                                <span>Productos</span>
                                                <span class="py-0.5 px-2 text-xs rounded-full font-semibold bg-gray-400 text-white">15/100</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[36px] w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-600 rounded-lg transition-all hover:bg-gray-50 hover:text-gray-900 cursor-pointer ml-4 border-l-2 border-gray-200 pl-2"
                                           @click.prevent="scrollToSection('section-menu-inventory')">
                                            <i data-lucide="warehouse" class="w-4 h-4"></i>
                                            <span>Inventario</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-shipping')">
                                            <i data-lucide="truck" class="w-5 h-5"></i>
                                            <span class="flex-1 flex items-center justify-between gap-x-2">
                                                <span>Gestión de Envíos</span>
                                                <span class="py-0.5 px-2 text-xs rounded-full font-semibold bg-gray-400 text-white">2/3</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-payment-methods')">
                                            <i data-lucide="dock" class="w-5 h-5"></i>
                                            <span class="flex-1 flex items-center justify-between gap-x-2">
                                                <span>Métodos de Pago</span>
                                                <span class="py-0.5 px-2 text-xs rounded-full font-semibold bg-gray-400 text-white">3/4</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-locations')">
                                            <i data-lucide="store" class="w-5 h-5"></i>
                                            <span class="flex-1 flex items-center justify-between gap-x-2">
                                                <span>Sedes</span>
                                                <span class="py-0.5 px-2 text-xs rounded-full font-semibold bg-gray-400 text-white">1/1</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                
                                {{-- Sección: Marketing --}}
                                <div class="mt-5 mb-2">
                                    <p class="px-2.5 py-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-marketing')">Marketing</p>
                                </div>
                                <ul class="space-y-1">
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-coupons')">
                                            <i data-lucide="ticket-percent" class="w-5 h-5"></i>
                                            <span class="flex-1 flex items-center justify-between gap-x-2">
                                                <span>Cupones</span>
                                                <span class="py-0.5 px-2 text-xs rounded-full font-semibold bg-gray-400 text-white">2/5</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-sliders')">
                                            <i data-lucide="images" class="w-5 h-5"></i>
                                            <span class="flex-1 flex items-center justify-between gap-x-2">
                                                <span>Sliders</span>
                                                <span class="py-0.5 px-2 text-xs rounded-full font-semibold bg-gray-400 text-white">1/3</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-tickers')">
                                            <i data-lucide="scroll-text" class="w-5 h-5"></i>
                                            <span>Tickers</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-store-design')">
                                            <i data-lucide="palette" class="w-5 h-5"></i>
                                            <span>Diseño de Tienda</span>
                                        </a>
                                    </li>
                                </ul>
                                
                                {{-- Sección: Anuncios y soporte --}}
                                <div class="mt-5 mb-2">
                                    <p class="px-2.5 py-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-support')">Anuncios y soporte</p>
                                </div>
                                <ul class="space-y-1">
                                    <li>
                                        <a href="#" class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                                           @click.prevent="scrollToSection('section-menu-whatsapp')">
                                            <i data-lucide="message-circle" class="w-5 h-5"></i>
                                            <span>Notificaciones WhatsApp</span>
                                        </a>
                                    </li>
                                </ul>
                                
                                {{-- Footer del Sidebar --}}
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="px-3 py-2 cursor-pointer hover:bg-gray-50 rounded-lg transition-colors"
                                         @click="scrollToSection('section-footer')">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                                JD
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">Juan Doe</p>
                                                <p class="text-xs text-gray-500 truncate">juan@example.com</p>
                                            </div>
                                            <i data-lucide="chevron-up" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </nav>
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
                                <p class="text-sm text-gray-700"><strong>Familiarízate con la estructura</strong> del menú para navegar más rápido</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Presta atención a los badges</strong> de notificación para no perder elementos importantes</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa la sección "Favoritos"</strong> para acceder rápidamente a funciones frecuentes</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El sidebar se adapta</strong> a tu plan, mostrando solo las funciones disponibles</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si no encuentras una función</strong>, usa la búsqueda o consulta el KiuBot Assistant</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El logo te lleva</strong> de vuelta al dashboard principal</p>
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
                    'section-header': {
                        title: 'Botón de Toggle',
                        text: 'Botón que permite minimizar o expandir el sidebar. En modo desktop, al minimizar el sidebar se convierte en modo mini mostrando solo los iconos. En modo móvil, permite abrir y cerrar el sidebar.'
                    },
                    'section-logo': {
                        title: 'Logo y Nombre de la Tienda',
                        text: 'Muestra el logo de tu tienda en la parte superior del sidebar. Al hacer clic, te lleva al dashboard. El nombre de tu tienda aparece junto al logo. Te ayuda a identificar en qué tienda estás trabajando.'
                    },
                    'section-favorites': {
                        title: 'Sección "Favoritos"',
                        text: 'Contiene las funciones más usadas y accesos rápidos. Dashboard: Panel principal con estadísticas. Pedidos: Listado de pedidos con badge de cantidad pendiente. Esta sección está siempre visible para acceso rápido.'
                    },
                    'section-menu-dashboard': {
                        title: 'Menú "Dashboard"',
                        text: 'Te lleva al panel principal donde puedes ver estadísticas de pedidos, pedidos recientes y acceder al KiuBot Assistant. Es la página principal que se muestra al iniciar sesión.'
                    },
                    'section-menu-orders': {
                        title: 'Menú "Pedidos"',
                        text: 'Te lleva al listado de pedidos donde puedes ver todos los pedidos, filtrarlos por estado, ver detalles y realizar acciones sobre ellos. El badge rojo muestra la cantidad de pedidos pendientes que requieren tu atención.'
                    },
                    'section-store-products': {
                        title: 'Sección "Tienda y productos"',
                        text: 'Contiene todas las funciones relacionadas con la gestión de productos y configuración de la tienda. Incluye: Categorías, Variables, Productos, Inventario (submenú), Gestión de Envíos, Métodos de Pago, y Sedes. Cada item muestra un badge con el uso actual y el límite según tu plan.'
                    },
                    'section-menu-categories': {
                        title: 'Menú "Categorías"',
                        text: 'Te lleva al listado de categorías donde puedes organizar tus productos en categorías y subcategorías. El badge muestra cuántas categorías estás usando del límite de tu plan (ejemplo: "3/10" significa 3 de 10 categorías disponibles).'
                    },
                    'section-menu-variables': {
                        title: 'Menú "Variables"',
                        text: 'Te lleva al listado de variables donde puedes crear variables para tus productos (tallas, colores, etc.). El badge muestra cuántas variables estás usando del límite de tu plan.'
                    },
                    'section-menu-products': {
                        title: 'Menú "Productos"',
                        text: 'Te lleva al listado de productos donde puedes gestionar todos tus productos, crear nuevos, editar existentes y controlar su disponibilidad. El badge muestra cuántos productos estás usando del límite de tu plan.'
                    },
                    'section-menu-inventory': {
                        title: 'Menú "Inventario"',
                        text: 'Te lleva al dashboard de inventario donde puedes ver el estado del stock de todos tus productos. Este item aparece indentado (con margen izquierdo) porque es un submenú de Productos.'
                    },
                    'section-menu-shipping': {
                        title: 'Menú "Gestión de Envíos"',
                        text: 'Te lleva a la configuración de envíos donde puedes configurar zonas de envío (recogida en tienda, envío local, envío nacional). El badge muestra cuántas zonas de envío estás usando del límite de tu plan.'
                    },
                    'section-menu-payment-methods': {
                        title: 'Menú "Métodos de Pago"',
                        text: 'Te lleva a la configuración de métodos de pago donde puedes activar o desactivar diferentes formas de pago (transferencia bancaria, efectivo, datáfono, contra entrega). El badge muestra cuántos métodos de pago estás usando del límite de tu plan.'
                    },
                    'section-menu-locations': {
                        title: 'Menú "Sedes"',
                        text: 'Te lleva a la gestión de sedes (ubicaciones) donde puedes configurar las diferentes ubicaciones físicas de tu tienda, horarios y contacto. El badge muestra cuántas sedes estás usando del límite de tu plan.'
                    },
                    'section-marketing': {
                        title: 'Sección "Marketing"',
                        text: 'Contiene funciones relacionadas con la promoción y marketing de tu tienda. Incluye: Cupones, Sliders, Tickers, y Diseño de Tienda. Estas herramientas te ayudan a promocionar tu tienda y atraer más clientes.'
                    },
                    'section-menu-coupons': {
                        title: 'Menú "Cupones"',
                        text: 'Te lleva a la gestión de cupones donde puedes crear, editar y gestionar descuentos y promociones. El badge muestra cuántos cupones estás usando del límite de tu plan.'
                    },
                    'section-menu-sliders': {
                        title: 'Menú "Sliders"',
                        text: 'Te lleva a la gestión de sliders (banners) donde puedes crear, editar y gestionar los banners promocionales que aparecen en tu tienda. El badge muestra cuántos sliders estás usando del límite de tu plan.'
                    },
                    'section-menu-tickers': {
                        title: 'Menú "Tickers"',
                        text: 'Te lleva a la configuración del ticker promocional donde puedes agregar textos que se desplazan en la parte superior de tu tienda. No tiene badge porque generalmente no hay límite de textos en el ticker.'
                    },
                    'section-menu-store-design': {
                        title: 'Menú "Diseño de Tienda"',
                        text: 'Te lleva a la configuración del diseño de tu tienda donde puedes personalizar colores, fuentes, logo y otros elementos visuales de tu tienda pública.'
                    },
                    'section-support': {
                        title: 'Sección "Anuncios y soporte"',
                        text: 'Contiene funciones relacionadas con comunicación y soporte. Incluye: Notificaciones de WhatsApp (si está habilitado en tu plan). Esta sección te ayuda a mantenerte comunicado con tus clientes y recibir soporte.'
                    },
                    'section-menu-whatsapp': {
                        title: 'Menú "Notificaciones WhatsApp"',
                        text: 'Te lleva a la configuración de notificaciones de WhatsApp donde puedes configurar mensajes automáticos para diferentes eventos (nuevo pedido, pedido confirmado, etc.). Solo aparece si tu plan incluye integración de WhatsApp.'
                    },
                    'section-footer': {
                        title: 'Footer del Sidebar',
                        text: 'Muestra tu información de usuario: Avatar o iniciales, nombre completo, y email. Al hacer clic, se despliega un menú con opciones: Mi cuenta, Configuración, Cerrar sesión. Te permite acceder rápidamente a tu perfil y cerrar sesión.'
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
