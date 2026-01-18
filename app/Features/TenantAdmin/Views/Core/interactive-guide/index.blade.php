<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía Interactiva - {{ $store->name }}</title>
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
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        {{-- Sidebar Fijo --}}
        <aside class="w-64 bg-white border-r border-gray-200 fixed left-0 top-0 bottom-0 overflow-y-auto z-30">
            <div class="p-4">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">Guía Interactiva</h2>
                    <p class="text-xs text-gray-600">Navegación</p>
                </div>
                
                <nav class="space-y-1" x-data="{ openSections: {} }">
                    {{-- Enlace al inicio --}}
                    <a 
                        href="{{ route('tenant.admin.interactive-guide.index', ['store' => $store->slug]) }}"
                        class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-blue-600 bg-blue-50 rounded-lg mb-4 transition-colors hover:bg-blue-100"
                    >
                        <i data-lucide="home" class="w-4 h-4"></i>
                        <span>Inicio</span>
                    </a>
                    
                    @foreach($navigation as $parentIndex => $parent)
                        @php
                            // Mostrar Pedidos, Categorías, Variables, Productos, Inventario y Gestión de Envíos
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
                                    style="display: none;"
                                >
                                    @foreach($parent['children'] ?? [] as $child)
                                        <li>
                                            <a 
                                                href="{{ route($child['route'], array_merge(['store' => $store->slug], $child['params'] ?? [])) }}"
                                                class="block px-3 py-2 text-sm rounded-lg transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900"
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

        {{-- Main Content --}}
        <main class="flex-1 ml-64">
            {{-- Header --}}
            <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Guía Interactiva</h1>
                            <p class="text-sm text-gray-600 mt-1">Conoce cada elemento de tu panel de administración</p>
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

            {{-- Content Area --}}
            <div class="p-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Funciones Disponibles</h2>
                    <p class="text-gray-600 mb-6">Selecciona una función para ver su guía interactiva con wireframes explicativos.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" x-data="{ openCards: {} }">
                        @foreach($navigation as $parentIndex => $parent)
                        @php
                            // Mostrar Pedidos, Categorías, Variables, Productos, Inventario y Gestión de Envíos
                            if (!in_array($parent['title'], ['Pedidos', 'Categorías', 'Variables', 'Productos', 'Inventario', 'Gestión de Envíos', 'Métodos de Pago', 'Sedes', 'Notificaciones de WhatsApp', 'Diseño de Tienda', 'Cupones', 'Sliders', 'Tickers Promocionales', 'Dashboard', 'Sidebar', 'Navbar', 'Footer'])) continue;
                            
                            // Definir colores e iconos según el tipo
                            $cardConfig = [
                                'Pedidos' => [
                                    'gradient' => 'from-purple-100 to-purple-200',
                                    'iconColor' => '#C084FC',
                                    'icon' => 'shopping-cart'
                                ],
                                'Categorías' => [
                                    'gradient' => 'from-blue-100 to-blue-200',
                                    'iconColor' => '#60A5FA',
                                    'icon' => 'folder'
                                ],
                                'Variables' => [
                                    'gradient' => 'from-green-100 to-green-200',
                                    'iconColor' => '#10B981',
                                    'icon' => 'tag'
                                ],
                                'Productos' => [
                                    'gradient' => 'from-orange-100 to-orange-200',
                                    'iconColor' => '#F97316',
                                    'icon' => 'package'
                                ],
                                'Inventario' => [
                                    'gradient' => 'from-indigo-100 to-indigo-200',
                                    'iconColor' => '#6366F1',
                                    'icon' => 'package-search'
                                ],
                                'Gestión de Envíos' => [
                                    'gradient' => 'from-teal-100 to-teal-200',
                                    'iconColor' => '#14B8A6',
                                    'icon' => 'truck'
                                ],
                                'Métodos de Pago' => [
                                    'gradient' => 'from-pink-100 to-pink-200',
                                    'iconColor' => '#EC4899',
                                    'icon' => 'credit-card'
                                ],
                                'Sedes' => [
                                    'gradient' => 'from-cyan-100 to-cyan-200',
                                    'iconColor' => '#06B6D4',
                                    'icon' => 'map-pin'
                                ],
                                'Notificaciones de WhatsApp' => [
                                    'gradient' => 'from-green-100 to-green-200',
                                    'iconColor' => '#10B981',
                                    'icon' => 'message-circle'
                                ],
                                'Diseño de Tienda' => [
                                    'gradient' => 'from-purple-100 to-purple-200',
                                    'iconColor' => '#A855F7',
                                    'icon' => 'palette'
                                ],
                                'Cupones' => [
                                    'gradient' => 'from-orange-100 to-orange-200',
                                    'iconColor' => '#F97316',
                                    'icon' => 'ticket'
                                ],
                                'Sliders' => [
                                    'gradient' => 'from-pink-100 to-pink-200',
                                    'iconColor' => '#EC4899',
                                    'icon' => 'image'
                                ],
                                'Tickers Promocionales' => [
                                    'gradient' => 'from-cyan-100 to-cyan-200',
                                    'iconColor' => '#06B6D4',
                                    'icon' => 'scroll-text'
                                ],
                                'Dashboard' => [
                                    'gradient' => 'from-indigo-100 to-indigo-200',
                                    'iconColor' => '#6366F1',
                                    'icon' => 'layout-dashboard'
                                ],
                                'Sidebar' => [
                                    'gradient' => 'from-slate-100 to-slate-200',
                                    'iconColor' => '#64748B',
                                    'icon' => 'sidebar'
                                ],
                                'Navbar' => [
                                    'gradient' => 'from-gray-100 to-gray-200',
                                    'iconColor' => '#6B7280',
                                    'icon' => 'menu'
                                ],
                                'Footer' => [
                                    'gradient' => 'from-zinc-100 to-zinc-200',
                                    'iconColor' => '#71717A',
                                    'icon' => 'layout'
                                ],
                                'Gestión de Envíos' => [
                                    'gradient' => 'from-teal-100 to-teal-200',
                                    'iconColor' => '#14B8A6',
                                    'icon' => 'truck'
                                ]
                            ];
                            $config = $cardConfig[$parent['title']] ?? $cardConfig['Pedidos'];
                        @endphp
                            <div class="border border-gray-200 rounded-lg p-6 hover:border-blue-300 hover:shadow-lg transition-all">
                                <div class="flex flex-col items-center text-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br {{ $config['gradient'] }} rounded-xl flex items-center justify-center mb-4 p-2">
                                        {{-- Icono tipo wireframe --}}
                                        <svg class="w-full h-full" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            {{-- Fondo blanco (página) --}}
                                            <rect x="6" y="6" width="28" height="28" rx="3" fill="white"/>
                                            {{-- Header bar --}}
                                            <rect x="10" y="10" width="18" height="4" rx="2" fill="{{ $config['iconColor'] }}"/>
                                            {{-- Columna izquierda --}}
                                            <rect x="10" y="18" width="12" height="12" rx="2" fill="{{ $config['iconColor'] }}"/>
                                            {{-- Columna derecha --}}
                                            <rect x="24" y="18" width="4" height="12" rx="2" fill="{{ $config['iconColor'] }}"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-900 mb-2">{{ $parent['title'] }}</h3>
                                    <p class="text-sm text-gray-600 mb-3">{{ count($parent['children'] ?? []) }} secciones disponibles</p>
                                </div>
                                
                                {{-- Botón para desplegar --}}
                                <button
                                    @click="openCards['{{ $parentIndex }}'] = !openCards['{{ $parentIndex }}']"
                                    class="w-full flex items-center justify-between px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors"
                                >
                                    <span>Ver secciones</span>
                                    <i 
                                        data-lucide="chevron-down" 
                                        class="w-4 h-4 transition-transform"
                                        :class="{ 'rotate-180': openCards['{{ $parentIndex }}'] }"
                                    ></i>
                                </button>
                                
                                {{-- Lista desplegable de secciones --}}
                                <div
                                    x-show="openCards['{{ $parentIndex }}']"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                                    x-cloak
                                    class="mt-3 space-y-1"
                                    style="display: none;"
                                >
                                    @foreach($parent['children'] ?? [] as $child)
                                        <a 
                                            href="{{ route($child['route'], array_merge(['store' => $store->slug], $child['params'] ?? [])) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors"
                                        >
                                            <div class="flex items-center gap-2">
                                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                                <span>{{ $child['title'] }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
