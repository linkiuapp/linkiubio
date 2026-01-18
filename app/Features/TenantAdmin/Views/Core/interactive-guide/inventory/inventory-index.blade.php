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
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-header-title')">Gestión de Inventario</h1>
                                    <p class="text-sm text-gray-600 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-header-description')">Controla el stock de tus productos en tiempo real</p>
                                </div>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors cursor-pointer"
                                        @click="scrollToSection('section-button-view-products')">
                                    Ver Productos
                                </button>
                            </div>
                        </div>

                        {{-- Tarjetas de Estadísticas --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            {{-- Total Productos --}}
                            <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 hover:shadow-md transition-all"
                                 @click="scrollToSection('section-card-total-products')">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Total Productos</p>
                                        <p class="text-2xl font-bold text-gray-900">125</p>
                                        <p class="text-xs text-gray-500 mt-1">Con control de stock</p>
                                    </div>
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Unidades --}}
                            <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-green-300 hover:shadow-md transition-all"
                                 @click="scrollToSection('section-card-total-units')">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Total Unidades</p>
                                        <p class="text-2xl font-bold text-green-600">1.234</p>
                                        <p class="text-xs text-gray-500 mt-1">En inventario</p>
                                    </div>
                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="boxes" class="w-6 h-6 text-green-600"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Stock Bajo --}}
                            <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-yellow-300 hover:shadow-md transition-all"
                                 @click="scrollToSection('section-card-low-stock')">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Stock Bajo</p>
                                        <p class="text-2xl font-bold text-yellow-600">8</p>
                                        <p class="text-xs text-gray-500 mt-1">Productos con stock bajo</p>
                                        <a href="#" class="text-xs text-blue-600 hover:text-blue-700 mt-1 inline-block">Ver productos</a>
                                    </div>
                                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="alert-triangle" class="w-6 h-6 text-yellow-600"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Agotados --}}
                            <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-red-300 hover:shadow-md transition-all"
                                 @click="scrollToSection('section-card-out-of-stock')">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Agotados</p>
                                        <p class="text-2xl font-bold text-red-600">3</p>
                                        <p class="text-xs text-gray-500 mt-1">Productos agotados</p>
                                        <a href="#" class="text-xs text-blue-600 hover:text-blue-700 mt-1 inline-block">Ver productos</a>
                                    </div>
                                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i data-lucide="x-circle" class="w-6 h-6 text-red-600"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Productos con Stock Bajo --}}
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600"></i>
                                    <h3 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-low-stock')">Productos con Stock Bajo <span class="text-yellow-600">(8)</span></h3>
                                </div>
                                <button class="text-sm text-blue-600 hover:text-blue-700 cursor-pointer"
                                        @click="scrollToSection('section-low-stock-toggle')">Ver todos</button>
                            </div>

                            <div class="space-y-3">
                                @for($i = 0; $i < 3; $i++)
                                <div class="bg-white rounded-lg p-4 border border-gray-200 cursor-pointer hover:border-blue-300 transition-all"
                                     @click="scrollToSection('section-low-stock-item')">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg"></div>
                                        <div class="flex-1">
                                            <div class="h-4 bg-gray-300 rounded w-32 mb-2"></div>
                                            <div class="h-3 bg-gray-200 rounded w-24"></div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-yellow-600">5</p>
                                            <p class="text-xs text-gray-500">Umbral: 10</p>
                                        </div>
                                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                                @click.stop="scrollToSection('section-button-update-stock')">
                                            Actualizar Stock
                                        </button>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Sección: Productos Agotados --}}
                        <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
                                    <h3 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-out-of-stock')">Productos Agotados <span class="text-red-600">(3)</span></h3>
                                </div>
                                <button class="text-sm text-blue-600 hover:text-blue-700 cursor-pointer"
                                        @click="scrollToSection('section-out-of-stock-toggle')">Ver todos</button>
                            </div>

                            <div class="space-y-3">
                                @for($i = 0; $i < 2; $i++)
                                <div class="bg-white rounded-lg p-4 border border-gray-200 cursor-pointer hover:border-blue-300 transition-all opacity-75"
                                     @click="scrollToSection('section-out-of-stock-item')">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg"></div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <div class="h-4 bg-gray-300 rounded w-32"></div>
                                                <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded-full">Sin stock</span>
                                            </div>
                                            <div class="h-3 bg-gray-200 rounded w-24"></div>
                                        </div>
                                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                                @click.stop="scrollToSection('section-button-restock')">
                                            Reabastecer
                                        </button>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Sección: Movimientos Recientes --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-movements')">Movimientos Recientes</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-movements-date')">
                                                <div class="flex items-center gap-2">
                                                    <span>Fecha</span>
                                                    <i data-lucide="info" class="w-4 h-4 text-gray-400"></i>
                                                </div>
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-movements-product')">
                                                <div class="flex items-center gap-2">
                                                    <span>Producto</span>
                                                    <i data-lucide="info" class="w-4 h-4 text-gray-400"></i>
                                                </div>
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-movements-type')">
                                                <div class="flex items-center gap-2">
                                                    <span>Tipo</span>
                                                    <i data-lucide="info" class="w-4 h-4 text-gray-400"></i>
                                                </div>
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-movements-quantity')">
                                                <div class="flex items-center gap-2">
                                                    <span>Cantidad</span>
                                                    <i data-lucide="info" class="w-4 h-4 text-gray-400"></i>
                                                </div>
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-movements-user')">
                                                <div class="flex items-center gap-2">
                                                    <span>Usuario</span>
                                                    <i data-lucide="info" class="w-4 h-4 text-gray-400"></i>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @for($i = 0; $i < 5; $i++)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="h-3 bg-gray-200 rounded w-24"></div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gray-200 rounded"></div>
                                                    <div>
                                                        <div class="h-3 bg-gray-300 rounded w-32 mb-1"></div>
                                                        <div class="h-2 bg-gray-200 rounded w-20"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs rounded-full {{ ['bg-green-100 text-green-700', 'bg-red-100 text-red-700', 'bg-blue-100 text-blue-700'][$i % 3] }}">
                                                    {{ ['Entrada', 'Salida', 'Venta'][$i % 3] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="{{ $i % 2 === 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                                    {{ $i % 2 === 0 ? '+' : '-' }}{{ [10, 5, 15, 8, 12][$i] }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="h-3 bg-gray-200 rounded w-20"></div>
                                            </td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
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
                                <p class="text-sm text-gray-700"><strong>Revisa regularmente las tarjetas de estadísticas</strong> para tener una vista general rápida</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Presta atención a los productos con stock bajo</strong> para reabastecer antes de que se agoten</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa los productos agotados</strong> para reactivarlos cuando tengas nuevo stock</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa los botones "Actualizar Stock" o "Reabastecer"</strong> para ir directamente a editar el producto</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa los movimientos recientes</strong> para entender qué está pasando con tu inventario</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Esta pantalla es solo para visualizar</strong>, para actualizar stock debes ir a editar cada producto individualmente</p>
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
                        title: 'Título "Gestión de Inventario"',
                        text: 'Muestra el nombre de la sección donde estás. Te indica que estás en la pantalla para controlar el stock de tus productos.'
                    },
                    'section-header-description': {
                        title: 'Descripción',
                        text: 'Debajo del título aparece un texto que dice "Controla el stock de tus productos en tiempo real". Te explica que esta pantalla te ayuda a monitorear el inventario.'
                    },
                    'section-button-view-products': {
                        title: 'Botón "Ver Productos"',
                        text: 'Este botón te lleva a la lista completa de productos donde puedes editarlos y actualizar su stock.'
                    },
                    'section-card-total-products': {
                        title: 'Tarjeta "Total Productos"',
                        text: 'Muestra cuántos productos tienes que controlan stock (no incluye productos sin control de stock). Características: Número grande en color gris oscuro, icono de paquete en fondo azul claro, texto pequeño que dice "Con control de stock".'
                    },
                    'section-card-total-units': {
                        title: 'Tarjeta "Total Unidades"',
                        text: 'Muestra la suma total de todas las unidades que tienes en inventario de todos los productos. Características: Número grande en color verde, icono de cajas en fondo verde claro, texto pequeño que dice "En inventario", el número está formateado con separadores de miles (ej: 1.234).'
                    },
                    'section-card-low-stock': {
                        title: 'Tarjeta "Stock Bajo"',
                        text: 'Muestra cuántos productos tienen stock bajo o igual al umbral de alerta (generalmente 1 unidad o menos). Características: Número grande en color amarillo, icono de alerta en fondo amarillo claro, texto pequeño que dice cuántos productos tienen stock bajo. Si hay productos con stock bajo, aparece un enlace "Ver productos" que te lleva a la sección de productos con stock bajo.'
                    },
                    'section-card-out-of-stock': {
                        title: 'Tarjeta "Agotados"',
                        text: 'Muestra cuántos productos están completamente agotados (0 unidades). Características: Número grande en color rojo, icono de X en círculo en fondo rojo claro, texto pequeño que dice cuántos productos están agotados. Si hay productos agotados, aparece un enlace "Ver productos" que te lleva a la sección de productos agotados.'
                    },
                    'section-low-stock': {
                        title: 'Sección: Productos con Stock Bajo',
                        text: 'Esta sección solo aparece si tienes productos con stock bajo. Es una caja amarilla con borde amarillo a la izquierda. Muestra los productos que necesitan reabastecimiento urgente.'
                    },
                    'section-low-stock-toggle': {
                        title: 'Botón "Ver todos" o "Ver menos"',
                        text: 'Si hay más de 5 productos, aparece un botón para expandir o contraer la lista. Por defecto muestra los primeros 5 productos.'
                    },
                    'section-low-stock-item': {
                        title: 'Tarjeta de Producto con Stock Bajo',
                        text: 'Cada producto aparece en una tarjeta blanca con: Información del Producto (Imagen, Nombre, SKU), Información de Stock (Cantidad actual en color amarillo y texto grande, Umbral de alerta), Botón "Actualizar Stock" que te lleva directamente a la pantalla de edición del producto.'
                    },
                    'section-button-update-stock': {
                        title: 'Botón "Actualizar Stock"',
                        text: 'Un botón azul que te lleva directamente a la pantalla de edición del producto. Desde allí puedes actualizar la cantidad en stock.'
                    },
                    'section-out-of-stock': {
                        title: 'Sección: Productos Agotados',
                        text: 'Esta sección solo aparece si tienes productos completamente agotados. Es una caja roja con borde rojo a la izquierda. Muestra los productos que necesitan reabastecimiento inmediato.'
                    },
                    'section-out-of-stock-toggle': {
                        title: 'Botón "Ver todos" o "Ver menos"',
                        text: 'Si hay más de 5 productos, aparece un botón para expandir o contraer la lista. Por defecto muestra los primeros 5 productos.'
                    },
                    'section-out-of-stock-item': {
                        title: 'Tarjeta de Producto Agotado',
                        text: 'Cada producto aparece en una tarjeta blanca con: Información del Producto (Imagen con opacidad reducida más gris, Nombre, SKU, Badge "Sin stock" rojo), Botón "Reabastecer" que te lleva directamente a la pantalla de edición del producto.'
                    },
                    'section-button-restock': {
                        title: 'Botón "Reabastecer"',
                        text: 'Un botón azul que te lleva directamente a la pantalla de edición del producto. Desde allí puedes agregar stock al producto.'
                    },
                    'section-movements': {
                        title: 'Sección: Movimientos Recientes',
                        text: 'Esta sección muestra un historial de todos los cambios de stock que han ocurrido en tus productos. Te ayuda a entender qué está pasando con tu inventario.'
                    },
                    'section-movements-date': {
                        title: 'Columna "Fecha"',
                        text: 'Muestra cuándo ocurrió el movimiento de stock. Aparece en formato día/mes/año hora:minuto (ej: 08/01/2025 14:30).'
                    },
                    'section-movements-product': {
                        title: 'Columna "Producto"',
                        text: 'Muestra información del producto afectado: Imagen (una miniatura de la imagen principal del producto), Nombre (el nombre del producto), SKU (el código SKU del producto).'
                    },
                    'section-movements-type': {
                        title: 'Columna "Tipo"',
                        text: 'Muestra el tipo de movimiento con un badge de color: Badge verde "Entrada" (Stock que se agregó al inventario), Badge rojo "Salida" (Stock que se retiró del inventario), Badge azul "Venta" (Stock que se vendió), Badge verde "Devolución" (Stock que se devolvió), Badge amarillo "Ajuste" (Un ajuste manual de stock), Badge morado "Reserva" (Stock que se reservó), Badge gris "Liberación" (Stock que se liberó de una reserva).'
                    },
                    'section-movements-quantity': {
                        title: 'Columna "Cantidad"',
                        text: 'Muestra cuántas unidades se movieron: Número en verde con + si se agregó stock (ej: +10), Número en rojo sin + si se retiró stock (ej: -5).'
                    },
                    'section-movements-user': {
                        title: 'Columna "Usuario"',
                        text: 'Muestra quién realizó el movimiento: El nombre del usuario que hizo el cambio, Si fue automático (por el sistema), muestra "Sistema".'
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
