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
        
        .tooltip-area {
            position: relative;
            cursor: help;
            transition: all 0.2s ease;
        }
        
        .tooltip-area:hover {
            background-color: rgba(59, 130, 246, 0.1) !important;
            border-color: rgba(59, 130, 246, 0.5) !important;
            transform: scale(1.01);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50" x-data="interactiveGuide()">
    <div class="flex min-h-screen">
        {{-- Sidebar Fijo --}}
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
                    {{-- Enlace al inicio --}}
                    <a 
                        href="{{ route('tenant.admin.interactive-guide.index', ['store' => $store->slug]) }}"
                        class="flex items-center gap-2 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 rounded-lg mb-4 transition-colors"
                    >
                        <i data-lucide="home" class="w-4 h-4"></i>
                        <span>Inicio</span>
                    </a>
                    
                    @foreach($navigation as $parentIndex => $parent)
                        @php
                            // Mostrar Pedidos, Categorías, Variables y Productos
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

        {{-- Main Content --}}
        <main class="flex-1 ml-64">
            {{-- Header --}}
            <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
                <div class="px-6 py-4">
                    {{-- Breadcrumbs --}}
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

            {{-- Content Area --}}
            <div class="p-6 space-y-6 pb-32">
                {{-- Vista Real Interactiva --}}
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                    <h2 class="text-base font-semibold text-blue-600 mb-4 flex items-center gap-2">
                        <i data-lucide="mouse-pointer-click" class="w-5 h-5 text-blue-600"></i>
                        <span>Vista Interactiva - Haz clic sobre los elementos para saber su funcionalidad</span>
                    </h2>
                    
                    <div class="space-y-6 bg-white rounded-lg p-6">
                        {{-- Header --}}
                        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                            <div>
                                <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                    @click="scrollToSection('section-header')">Gestión de Pedidos</h1>
                                <p class="text-sm text-gray-600 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                   @click="scrollToSection('section-header')">
                                    Administra todos los pedidos de tu tienda (Domicilio, Recoger, Consumo Local, Habitación)
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                        @click="scrollToSection('section-buttons')"
                                        title="Exportar (Próximamente)">
                                    <i data-lucide="download" class="w-5 h-5"></i>
                                </button>
                                <a href="{{ route('tenant.admin.orders.create', $store->slug) }}" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                   @click.prevent="scrollToSection('section-buttons')">
                                    <i data-lucide="plus" class="w-5 h-5"></i>
                                    Nuevo Pedido
                                </a>
                            </div>
                        </div>

                        {{-- Tarjetas de Estadísticas --}}
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                            @php
                                $exampleStats = [
                                    ['id' => 'stat-total', 'icon' => 'shopping-cart', 'color' => 'blue', 'label' => 'Total', 'value' => '42', 'section' => 'section-stats-total'],
                                    ['id' => 'stat-pending', 'icon' => 'clock', 'color' => 'amber', 'label' => 'Pendientes', 'value' => '8', 'section' => 'section-stats-pending'],
                                    ['id' => 'stat-confirmed', 'icon' => 'check-circle', 'color' => 'green', 'label' => 'Confirmados', 'value' => '12', 'section' => 'section-stats-confirmed'],
                                    ['id' => 'stat-preparing', 'icon' => 'package', 'color' => 'purple', 'label' => 'Preparando', 'value' => '5', 'section' => 'section-stats-preparing'],
                                    ['id' => 'stat-shipped', 'icon' => 'truck', 'color' => 'indigo', 'label' => 'Enviados', 'value' => '7', 'section' => 'section-stats-shipped'],
                                    ['id' => 'stat-delivered', 'icon' => 'check-circle-2', 'color' => 'green', 'label' => 'Entregados', 'value' => '9', 'section' => 'section-stats-delivered'],
                                    ['id' => 'stat-cancelled', 'icon' => 'x-circle', 'color' => 'red', 'label' => 'Cancelados', 'value' => '1', 'section' => 'section-stats-cancelled'],
                                    ['id' => 'stat-income', 'icon' => 'banknote', 'color' => 'green', 'label' => 'Ingresos', 'value' => '$1.2M', 'section' => 'section-stats-income'],
                                    ['id' => 'stat-shipping', 'icon' => 'package-check', 'color' => 'gray', 'label' => 'Envíos', 'value' => '$45K', 'section' => 'section-stats-shipping'],
                                ];
                            @endphp
                            @foreach($exampleStats as $stat)
                                <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer hover:scale-105"
                                     @click="scrollToSection('{{ $stat['section'] }}')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex items-center justify-center bg-{{ $stat['color'] }}-100 text-{{ $stat['color'] }}-600 rounded-xl">
                                            <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</div>
                                            <div class="text-xs text-gray-500">{{ $stat['label'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Filtros --}}
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="px-3 py-2 pr-8 border border-gray-200 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filters-status')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todos los estados
                                </div>
                                <div class="px-3 py-2 pr-8 border border-gray-200 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filters-type')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todos los tipos
                                </div>
                                <div class="px-3 py-2 pr-8 border border-gray-200 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filters-payment')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todos los métodos
                                </div>
                                <div class="relative flex-1 min-w-[200px]">
                                    <input type="text" 
                                           placeholder="Buscar por número, cliente..." 
                                           class="w-full px-3 py-2 pl-10 pr-3 border border-gray-200 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-filters-search')"
                                           readonly>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                </div>
                                <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 transition-colors flex items-center gap-2 cursor-pointer"
                                        @click="scrollToSection('section-filters-buttons')">
                                    <i data-lucide="search" class="w-4 h-4"></i>
                                    Buscar
                                </button>
                                <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors flex items-center gap-2 cursor-pointer"
                                        @click="scrollToSection('section-filters-buttons')">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                    Limpiar
                                </button>
                            </div>
                        </div>

                        {{-- Tabla --}}
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 pt-4 pb-2">
                                <p class="text-sm text-gray-600 flex items-center gap-2">
                                    <i data-lucide="mouse-pointer-click" class="w-3 h-3 text-blue-600"></i>
                                    <span><strong>Haz clic en los encabezados de columna</strong> para conocer qué información muestra cada una</span>
                                </p>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-order')">
                                                <div class="flex items-center gap-2">
                                                    <span>Pedido</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-client')">
                                                <div class="flex items-center gap-2">
                                                    <span>Cliente</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-type')">
                                                <div class="flex items-center gap-2">
                                                    <span>Tipo</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-status')">
                                                <div class="flex items-center gap-2">
                                                    <span>Estado</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-payment')">
                                                <div class="flex items-center gap-2">
                                                    <span>Pago</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-income')">
                                                <div class="flex items-center gap-2">
                                                    <span>Ingresos</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-date')">
                                                <div class="flex items-center gap-2">
                                                    <span>Fecha</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-actions')">
                                                <div class="flex items-center justify-center gap-2">
                                                    <span>Acciones</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @for($i = 0; $i < 1; $i++)
                                        <tr class="hover:bg-gray-50">
                                            {{-- Wireframe: Pedido --}}
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <div class="w-5 h-5 bg-gray-300 rounded"></div>
                                                    </div>
                                                    <div class="space-y-1.5">
                                                        <div class="h-3 bg-gray-300 rounded w-16"></div>
                                                        <div class="h-2 bg-gray-200 rounded w-20"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- Wireframe: Cliente --}}
                                            <td class="px-6 py-4">
                                                <div class="space-y-1.5">
                                                    <div class="h-3 bg-gray-300 rounded w-24"></div>
                                                    <div class="h-2 bg-gray-200 rounded w-28"></div>
                                                </div>
                                            </td>
                                            {{-- Wireframe: Tipo --}}
                                            <td class="px-6 py-4">
                                                <div class="h-5 bg-gray-200 rounded-full w-20"></div>
                                            </td>
                                            {{-- Wireframe: Estado --}}
                                            <td class="px-6 py-4">
                                                <div class="h-6 bg-gray-200 rounded border border-gray-300 w-24"></div>
                                            </td>
                                            {{-- Wireframe: Pago --}}
                                            <td class="px-6 py-4">
                                                <div class="h-3 bg-gray-300 rounded w-20"></div>
                                            </td>
                                            {{-- Wireframe: Ingresos --}}
                                            <td class="px-6 py-4">
                                                <div class="h-3 bg-gray-300 rounded w-16"></div>
                                            </td>
                                            {{-- Wireframe: Fecha --}}
                                            <td class="px-6 py-4">
                                                <div class="h-3 bg-gray-300 rounded w-24"></div>
                                            </td>
                                            {{-- Wireframe: Acciones --}}
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                                                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                                                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Paginación --}}
                        <div class="flex items-center justify-center gap-2 cursor-pointer"
                             @click="scrollToSection('section-pagination')">
                            <button class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            </button>
                            <button class="px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded">1</button>
                            <button class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">2</button>
                            <button class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded">3</button>
                            <button class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded">4</button>
                            <span class="px-2 text-sm text-gray-500">...</span>
                            <button class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded">10</button>
                            <button class="px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded transition-colors">
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 3. Consejos Rápidos --}}
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg border border-amber-200 p-6">
                        <div class="flex-1">
                            <h2 class="text-base font-semibold text-gray-900 mb-4">Consejos Rápidos</h2>
                            <div class="grid md:grid-cols-2 gap-3">
                                <div class="flex items-start gap-3">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                    <p class="text-sm text-gray-700"><strong>Usa los filtros</strong> para encontrar pedidos específicos rápidamente</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                    <p class="text-sm text-gray-700"><strong>Cambia el estado</strong> de los pedidos conforme avances en el proceso</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                    <p class="text-sm text-gray-700"><strong>Revisa los comprobantes</strong> de pago antes de marcar como entregado</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                    <p class="text-sm text-gray-700"><strong>Las estadísticas</strong> se actualizan automáticamente cuando cambias estados</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                    <p class="text-sm text-gray-700"><strong>Los pedidos nuevos</strong> aparecen automáticamente sin necesidad de refrescar la página</p>
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
                activeTooltip: null,
                highlightedSection: null,
                selectedGuide: null,
                selectedGuideTitle: '',
                selectedGuideText: '',
                
                guides: {
                    'section-stats-total': {
                        title: 'Tarjeta "Total"',
                        text: 'Muestra el número total de pedidos que tienes en este momento. Incluye todos los pedidos sin importar su estado (pendientes, confirmados, entregados, cancelados, etc.).'
                    },
                    'section-stats-pending': {
                        title: 'Tarjeta "Pendientes"',
                        text: 'Muestra cuántos pedidos están esperando que los confirmes o proceses. Son pedidos que acaban de llegar y necesitan tu atención.'
                    },
                    'section-stats-confirmed': {
                        title: 'Tarjeta "Confirmados"',
                        text: 'Muestra cuántos pedidos ya confirmaste. Estos son pedidos que aceptaste y que están listos para preparar o procesar.'
                    },
                    'section-stats-preparing': {
                        title: 'Tarjeta "Preparando"',
                        text: 'Muestra cuántos pedidos están en proceso de preparación. Son pedidos que ya estás trabajando para completar.'
                    },
                    'section-stats-shipped': {
                        title: 'Tarjeta "Enviados"',
                        text: 'Muestra cuántos pedidos ya enviaste o entregaste al repartidor. Son pedidos que están en camino al cliente.'
                    },
                    'section-stats-delivered': {
                        title: 'Tarjeta "Entregados"',
                        text: 'Muestra cuántos pedidos ya completaste y entregaste al cliente. Son pedidos que ya terminaron exitosamente.'
                    },
                    'section-stats-cancelled': {
                        title: 'Tarjeta "Cancelados"',
                        text: 'Muestra cuántos pedidos cancelaste o que el cliente canceló. Son pedidos que no se completaron.'
                    },
                    'section-stats-income': {
                        title: 'Tarjeta "Total ingresos por productos"',
                        text: 'Muestra cuánto dinero has recibido en total por la venta de productos. No incluye el costo de envío.'
                    },
                    'section-stats-shipping': {
                        title: 'Tarjeta "Total ingresos por envíos"',
                        text: 'Muestra cuánto dinero has recibido en total por los costos de envío de los pedidos a domicilio.'
                    },
                    'section-filters-status': {
                        title: 'Select "Todos los estados"',
                        text: 'Te permite filtrar los pedidos por su estado. Puedes elegir ver solo pendientes, confirmados, preparando, enviados, entregados o cancelados. Si no seleccionas nada, verás todos.'
                    },
                    'section-filters-type': {
                        title: 'Select "Todos los tipos"',
                        text: 'Te permite filtrar los pedidos por su tipo. Puedes elegir ver solo pedidos a domicilio, para recoger, de consumo local o de habitación. Si no seleccionas nada, verás todos los tipos.'
                    },
                    'section-filters-payment': {
                        title: 'Select "Todos los métodos"',
                        text: 'Te permite filtrar los pedidos por cómo pagó el cliente. Puedes elegir ver solo transferencias, contra entrega o efectivo. Si no seleccionas nada, verás todos.'
                    },
                    'section-filters-search': {
                        title: 'Campo de Búsqueda',
                        text: 'Un cuadro de texto donde puedes escribir para buscar pedidos. Puedes buscar por número de pedido o nombre del cliente. Escribe lo que buscas y presiona "Buscar".'
                    },
                    'section-filters-buttons': {
                        title: 'Botones de Filtros',
                        text: '<strong>Botón "Buscar":</strong> Aplica los filtros que seleccionaste y la búsqueda que escribiste. Al hacer clic, la tabla se actualiza mostrando solo los pedidos que coinciden con tus filtros.<br><br><strong>Botón "Limpiar":</strong> Quita todos los filtros que aplicaste y muestra todos los pedidos nuevamente. Es útil cuando quieres volver a ver la lista completa.'
                    },
                    'section-table-order': {
                        title: 'Columna "Pedido"',
                        text: 'Muestra el número del pedido (por ejemplo, #1234) y cuántos productos tiene ese pedido. El número del pedido es un enlace que te lleva a ver los detalles completos.'
                    },
                    'section-table-client': {
                        title: 'Columna "Cliente"',
                        text: 'Muestra el nombre y teléfono del cliente que hizo el pedido. Si es un pedido de consumo local, también muestra el número de mesa. Si es de habitación, muestra el número de habitación.'
                    },
                    'section-table-type': {
                        title: 'Columna "Tipo"',
                        text: 'Muestra un badge de color que indica el tipo de pedido: <strong>Domicilio</strong> (azul), <strong>Recoger</strong> (azul), <strong>Consumo Local</strong> (verde) o <strong>Habitación</strong> (amarillo).'
                    },
                    'section-table-status': {
                        title: 'Columna "Estado"',
                        text: 'Muestra un menú desplegable donde puedes cambiar el estado del pedido. Los estados disponibles son: Pendiente, Confirmado, Preparando, Enviado, Entregado, Cancelado. Al cambiar el estado, aparece un cuadro de confirmación donde puedes agregar notas adicionales.'
                    },
                    'section-table-payment': {
                        title: 'Columna "Pago"',
                        text: 'Muestra el método de pago que usó el cliente (Transferencia, Contra Entrega o Efectivo). Si el cliente subió un comprobante de pago, aparece un enlace "Ver comprobante" que te permite ver la imagen del comprobante y validarla con KiuBot.'
                    },
                    'section-table-income': {
                        title: 'Columna "Ingresos"',
                        text: 'Muestra cuánto dinero generó ese pedido: <strong>Ingreso por productos:</strong> El monto de los productos vendidos, <strong>Envío:</strong> El costo del envío (solo si aplica), <strong>Total:</strong> La suma de productos más envío.'
                    },
                    'section-table-date': {
                        title: 'Columna "Fecha"',
                        text: 'Muestra cuándo se creó el pedido. Muestra la fecha y la hora en que el cliente hizo el pedido.'
                    },
                    'section-table-actions': {
                        title: 'Columna "Acciones"',
                        text: 'Contiene iconos para realizar acciones sobre cada pedido:<br><br><strong>Icono de Ojo (Ver detalles):</strong> Te lleva a la vista detallada del pedido.<br><strong>Icono de Lápiz (Editar):</strong> Te permite editar el pedido. Solo aparece si el pedido aún se puede modificar.<br><strong>Icono de X (Cancelar):</strong> Te permite cancelar el pedido. Solo aparece si el pedido no está entregado ni cancelado.'
                    },
                    'section-header': {
                        title: 'Encabezado de la Página',
                        text: '<strong>Título "Gestión de Pedidos":</strong> Muestra el nombre de la sección donde estás. Te indica que estás en la pantalla para administrar todos los pedidos de tu tienda.<br><br><strong>Descripción:</strong> Texto que aparece debajo del título explicando que puedes administrar todos los tipos de pedidos: Domicilio, Recoger, Consumo Local y Habitación.'
                    },
                    'section-buttons': {
                        title: 'Botones del Encabezado',
                        text: '<strong>Botón "Exportar" (Icono de descarga):</strong> Este botón está preparado para exportar los pedidos, pero aún no está disponible. Cuando esté listo, te permitirá descargar un archivo con todos los pedidos.<br><br><strong>Botón "Nuevo Pedido":</strong> Este botón te lleva a la pantalla para crear un pedido nuevo. Al hacer clic, puedes agregar productos y crear un pedido manualmente.'
                    },
                    'section-pagination': {
                        title: 'Paginación',
                        text: 'Te permite navegar entre las diferentes páginas de pedidos cuando tienes muchos pedidos. <strong>Botón "Anterior" (flecha izquierda):</strong> Te lleva a la página anterior de pedidos. Está deshabilitado si estás en la primera página.<br><br><strong>Números de página:</strong> Cada número representa una página. El número resaltado en azul indica la página actual. Haz clic en cualquier número para ir a esa página.<br><br><strong>Botón "Siguiente" (flecha derecha):</strong> Te lleva a la página siguiente de pedidos. Está deshabilitado si estás en la última página.'
                    }
                },
                
                showTooltip(elementId, event) {
                    this.activeTooltip = {
                        id: elementId,
                        x: event.clientX,
                        y: event.clientY
                    };
                },
                
                hideTooltip() {
                    this.activeTooltip = null;
                },

                scrollToSection(sectionId) {
                    // Mostrar guía rápida si existe
                    if (this.guides[sectionId]) {
                        this.selectedGuide = sectionId;
                        this.selectedGuideTitle = this.guides[sectionId].title;
                        this.selectedGuideText = this.guides[sectionId].text;
                    }
                    
                    const element = document.getElementById(sectionId);
                    
                    if (element) {
                        // Highlight la sección
                        this.highlightedSection = sectionId;
                        
                        // Scroll suave con offset para el header fijo
                        const offset = 120;
                        const elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
                        const offsetPosition = elementPosition - offset;
                        
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Quitar highlight después de 3 segundos
                        setTimeout(() => {
                            this.highlightedSection = null;
                        }, 3000);
                    }
                }
            }
        }


        // Inicializar iconos
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

    {{-- Footer Fijo con Guía Rápida --}}
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
