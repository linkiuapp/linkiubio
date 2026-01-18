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
                                        @click="scrollToSection('section-header-title')">Detalles del cupón</h1>
                                </div>
                            </div>
                        </div>

                        {{-- Información Principal --}}
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-name')">Descuento de bienvenida</h2>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs rounded-full cursor-pointer hover:bg-green-200 transition-colors"
                                              @click="scrollToSection('section-badge-status')">Activo</span>
                                        <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs rounded-full cursor-pointer hover:bg-blue-200 transition-colors"
                                              @click="scrollToSection('section-badge-public')">Público</span>
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-700 text-xs rounded-full cursor-pointer hover:bg-gray-200 transition-colors"
                                              @click="scrollToSection('section-badge-manual')">Manual</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="text-right">
                                        <span class="text-xs text-gray-500">Desactivar</span>
                                        <span class="text-xs text-gray-500 ml-2">Activar</span>
                                    </div>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle')">
                                        <input type="checkbox" class="peer sr-only" checked>
                                        <span class="absolute inset-0 bg-blue-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors"
                                 @click="scrollToSection('section-info')">
                                <p>Código: <span class="px-2 py-1 bg-gray-800 text-white text-xs rounded font-mono">BIENVENIDA20</span></p>
                                <p>Creado el 15 de Enero, 2025 a las 10:30 AM</p>
                                <p>Última actualización: 20 de Enero, 2025 a las 2:15 PM</p>
                            </div>
                        </div>

                        {{-- Resumen Rápido --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 cursor-pointer hover:bg-blue-100 transition-colors"
                                 @click="scrollToSection('section-card-type')">
                                <div class="flex items-center gap-2 mb-2">
                                    <i data-lucide="tag" class="w-5 h-5 text-blue-600"></i>
                                    <span class="text-sm font-medium text-gray-700">Tipo de cupón</span>
                                </div>
                                <p class="text-lg font-bold text-blue-600">Global</p>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 cursor-pointer hover:bg-green-100 transition-colors"
                                 @click="scrollToSection('section-card-discount')">
                                <div class="flex items-center gap-2 mb-2">
                                    <i data-lucide="percent" class="w-5 h-5 text-green-600"></i>
                                    <span class="text-sm font-medium text-gray-700">Valor del descuento</span>
                                </div>
                                <p class="text-lg font-bold text-green-600">15%</p>
                            </div>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 cursor-pointer hover:bg-purple-100 transition-colors"
                                 @click="scrollToSection('section-card-validity')">
                                <div class="flex items-center gap-2 mb-2">
                                    <i data-lucide="calendar" class="w-5 h-5 text-purple-600"></i>
                                    <span class="text-sm font-medium text-gray-700">Vigencia</span>
                                </div>
                                <p class="text-sm text-gray-900">Desde 01/01/2025</p>
                                <p class="text-sm text-gray-600">Hasta 31/01/2025</p>
                            </div>
                        </div>

                        {{-- Layout de dos columnas --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            {{-- Columna Principal (Izquierda) --}}
                            <div class="lg:col-span-2 space-y-6">
                                {{-- Información General --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-general')">Información General</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-code')">
                                            <span class="text-xs font-medium text-gray-500">Código:</span>
                                            <p class="text-sm font-mono text-gray-900 mt-0.5 px-2 py-1 bg-gray-100 rounded inline-block">BIENVENIDA20</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-description')">
                                            <span class="text-xs font-medium text-gray-500">Descripción:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Aprovecha este descuento especial para nuevos clientes</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-application')">
                                            <span class="text-xs font-medium text-gray-500">Aplicación:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Global</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-discount-type')">
                                            <span class="text-xs font-medium text-gray-500">Tipo de descuento:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Porcentaje</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Restricciones --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-restrictions')">Restricciones</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-restriction-min-purchase')">
                                            <span class="text-xs font-medium text-gray-500">Compra mínima:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">$30.000</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-restriction-max-discount')">
                                            <span class="text-xs font-medium text-gray-500">Descuento máximo:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">$10.000</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-restriction-total-uses')">
                                            <span class="text-xs font-medium text-gray-500">Usos totales:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">5/100</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-restriction-uses-per-customer')">
                                            <span class="text-xs font-medium text-gray-500">Usos por cliente:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">1</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Restricciones Horarias --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-time-restrictions')">Restricciones Horarias</h3>
                                    
                                    <div class="space-y-3 cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-time-details')">
                                        <div>
                                            <span class="text-xs font-medium text-gray-500">Días permitidos:</span>
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                @php
                                                    $allowedDays = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'];
                                                @endphp
                                                @foreach($allowedDays as $day)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">{{ $day }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div>
                                            <span class="text-xs font-medium text-gray-500">Horario:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">09:00 - 18:00</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Estadísticas de Uso --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-statistics')">Estadísticas de Uso</h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                             @click="scrollToSection('section-stat-total-uses')">
                                            <span class="text-xs font-medium text-gray-500">Total de usos</span>
                                            <p class="text-2xl font-bold text-gray-900 mt-1">5</p>
                                        </div>
                                        <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                             @click="scrollToSection('section-stat-remaining')">
                                            <span class="text-xs font-medium text-gray-500">Usos restantes</span>
                                            <p class="text-2xl font-bold text-gray-900 mt-1">95</p>
                                        </div>
                                        <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                             @click="scrollToSection('section-stat-percentage')">
                                            <span class="text-xs font-medium text-gray-500">Porcentaje de uso</span>
                                            <p class="text-2xl font-bold text-gray-900 mt-1">5%</p>
                                        </div>
                                        <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                             @click="scrollToSection('section-stat-total-discount')">
                                            <span class="text-xs font-medium text-gray-500">Total de descuento dado</span>
                                            <p class="text-2xl font-bold text-green-600 mt-1">$45.000</p>
                                        </div>
                                        <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                             @click="scrollToSection('section-stat-avg-discount')">
                                            <span class="text-xs font-medium text-gray-500">Descuento promedio</span>
                                            <p class="text-2xl font-bold text-gray-900 mt-1">$9.000</p>
                                        </div>
                                        <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                             @click="scrollToSection('section-stat-orders')">
                                            <span class="text-xs font-medium text-gray-500">Órdenes con cupón</span>
                                            <p class="text-2xl font-bold text-gray-900 mt-1">5</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Uso Reciente --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-recent-usage')">Uso Reciente</h3>
                                    
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                        @click="scrollToSection('section-table-date')">Fecha</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                        @click="scrollToSection('section-table-order')">Orden</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                        @click="scrollToSection('section-table-discount')">Descuento</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @for($i = 0; $i < 3; $i++)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-3 text-sm text-gray-900">
                                                        <div class="h-3 bg-gray-300 rounded w-32"></div>
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 cursor-pointer hover:underline"
                                                           @click.stop="scrollToSection('section-order-link')">
                                                            #{{ 1000 + $i }}
                                                        </a>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-900">
                                                        <div class="h-3 bg-gray-300 rounded w-20"></div>
                                                    </td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Columna Lateral (Derecha) --}}
                            <div class="space-y-6">
                                {{-- Acciones Rápidas --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-actions')">Acciones rápidas</h3>
                                    
                                    <div class="space-y-2">
                                        <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-button-edit')">
                                            <i data-lucide="edit" class="w-4 h-4 inline"></i>
                                            Editar cupón
                                        </button>
                                        <button class="w-full px-4 py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-button-delete')"
                                                style="display: none;">
                                            <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                            Eliminar cupón
                                        </button>
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
                                <p class="text-sm text-gray-700"><strong>Revisa las estadísticas regularmente</strong> para conocer el rendimiento de tus cupones</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa el historial de uso</strong> para identificar patrones de uso</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Verifica el porcentaje de uso</strong> para saber cuándo un cupón está por agotarse</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa las restricciones</strong> para asegurarte de que están configuradas correctamente</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si un cupón tiene muchos usos</strong>, considera crear uno nuevo en lugar de modificarlo</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los enlaces a órdenes</strong> te permiten ver los detalles de cada uso del cupón</p>
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
                        text: 'Te regresa al listado de cupones.'
                    },
                    'section-header-title': {
                        title: 'Título "Detalles del cupón"',
                        text: 'Muestra que estás viendo la información detallada de un cupón.'
                    },
                    'section-name': {
                        title: 'Nombre del cupón',
                        text: 'Muestra el nombre completo del cupón en negrita.'
                    },
                    'section-badge-status': {
                        title: 'Badge de estado',
                        text: 'Muestra el estado actual del cupón: "Activo" (verde) - El cupón está activo y disponible, "Inactivo" (rojo) - El cupón está desactivado, "Próximo" (azul) - El cupón aún no ha comenzado, "Expirado" (rojo) - El cupón ya expiró, "Agotado" (amarillo) - El cupón alcanzó su límite de usos.'
                    },
                    'section-badge-public': {
                        title: 'Badge "Público" o "Privado"',
                        text: 'Badge "Público" (azul) - Si el cupón es visible para todos los clientes en la tienda, Badge "Privado" (gris) - Si el cupón es privado y solo se puede usar con el código.'
                    },
                    'section-badge-manual': {
                        title: 'Badge "Automático" o "Manual"',
                        text: 'Badge "Automático" (verde) - Si el cupón se aplica automáticamente sin necesidad de código, Badge "Manual" (gris) - Si el cupón requiere código para aplicarse.'
                    },
                    'section-toggle': {
                        title: 'Interruptor Activar/Desactivar',
                        text: 'Permite activar o desactivar el cupón rápidamente. Muestra "Desactivar" a la izquierda y "Activar" a la derecha. El estado cambia automáticamente al hacer clic. Aparecerá un mensaje de confirmación.'
                    },
                    'section-info': {
                        title: 'Información adicional',
                        text: 'Código del cupón: Muestra el código en un badge gris con formato monoespaciado. Fecha de creación: "Creado el [fecha y hora]". Última actualización: "Última actualización [fecha y hora]".'
                    },
                    'section-card-type': {
                        title: 'Tarjeta "Tipo de cupón"',
                        text: 'Muestra el tipo de aplicación: "Global", "Categorías específicas", "Productos específicos".'
                    },
                    'section-card-discount': {
                        title: 'Tarjeta "Valor del descuento"',
                        text: 'Muestra el valor del descuento: Si es porcentaje: "15%", Si es monto fijo: "$5.000".'
                    },
                    'section-card-validity': {
                        title: 'Tarjeta "Vigencia"',
                        text: 'Muestra las fechas de inicio y fin: "Desde [fecha]" o "Inicia inmediatamente", "Hasta [fecha]" o "Sin fecha fin".'
                    },
                    'section-general': {
                        title: 'Sección: Información General',
                        text: 'Esta sección muestra la información básica del cupón: código, descripción, aplicación y tipo de descuento.'
                    },
                    'section-info-code': {
                        title: 'Código',
                        text: 'Muestra el código del cupón en formato monoespaciado con fondo gris. Si el cupón es automático, puede mostrar "CÓDIGO-AUTO".'
                    },
                    'section-info-description': {
                        title: 'Descripción',
                        text: 'Muestra la descripción si está configurada. Si no hay descripción, no aparece esta sección.'
                    },
                    'section-info-application': {
                        title: 'Aplicación',
                        text: 'Muestra dónde se aplica el cupón: "Global", "Categorías específicas", "Productos específicos".'
                    },
                    'section-info-discount-type': {
                        title: 'Tipo de descuento',
                        text: 'Muestra cómo se calcula: "Porcentaje", "Monto fijo".'
                    },
                    'section-restrictions': {
                        title: 'Sección: Restricciones',
                        text: 'Esta sección muestra todas las restricciones configuradas para el cupón: compra mínima, descuento máximo, límites de uso.'
                    },
                    'section-restriction-min-purchase': {
                        title: 'Compra mínima',
                        text: 'Muestra el monto mínimo requerido o "Sin límite" si no está configurado.'
                    },
                    'section-restriction-max-discount': {
                        title: 'Descuento máximo',
                        text: 'Muestra el monto máximo de descuento (solo para porcentajes) o "No aplica" si no está configurado.'
                    },
                    'section-restriction-total-uses': {
                        title: 'Usos totales',
                        text: 'Muestra cuántas veces se ha usado y el límite. Ejemplo: "5/100" o "10 (ilimitado)".'
                    },
                    'section-restriction-uses-per-customer': {
                        title: 'Usos por cliente',
                        text: 'Muestra cuántas veces puede usar el mismo cliente o "Ilimitado" si no hay límite.'
                    },
                    'section-time-restrictions': {
                        title: 'Sección: Restricciones Horarias',
                        text: 'Esta sección muestra las restricciones horarias si están configuradas.'
                    },
                    'section-time-details': {
                        title: 'Detalles de restricciones horarias',
                        text: 'Si hay restricciones configuradas: Rango de fechas: Muestra fecha de inicio y fin, Días permitidos: Muestra badges con los días de la semana (Dom, Lun, Mar, etc.), Horario: Muestra la hora de inicio y fin (ejemplo: "09:00 - 18:00"). Si no hay restricciones: Muestra "Sin restricciones configuradas".'
                    },
                    'section-statistics': {
                        title: 'Sección: Estadísticas de Uso',
                        text: 'Esta sección muestra estadísticas detalladas del uso del cupón. Solo aparece si el cupón se ha usado al menos una vez.'
                    },
                    'section-stat-total-uses': {
                        title: 'Total de usos',
                        text: 'Muestra cuántas veces se ha usado el cupón en total.'
                    },
                    'section-stat-remaining': {
                        title: 'Usos restantes',
                        text: 'Muestra cuántos usos quedan disponibles (o "∞" si es ilimitado).'
                    },
                    'section-stat-percentage': {
                        title: 'Porcentaje de uso',
                        text: 'Muestra qué porcentaje del límite se ha usado. Útil para saber cuándo un cupón está por agotarse.'
                    },
                    'section-stat-total-discount': {
                        title: 'Total de descuento dado',
                        text: 'Suma total de todos los descuentos aplicados. Te ayuda a conocer el impacto económico del cupón.'
                    },
                    'section-stat-avg-discount': {
                        title: 'Descuento promedio',
                        text: 'Promedio de descuento por uso. Te ayuda a entender el valor promedio de cada uso del cupón.'
                    },
                    'section-stat-orders': {
                        title: 'Órdenes con cupón',
                        text: 'Cuántas órdenes han usado este cupón. Te ayuda a conocer cuántos pedidos se beneficiaron del cupón.'
                    },
                    'section-recent-usage': {
                        title: 'Sección: Uso Reciente',
                        text: 'Esta sección muestra una tabla con las últimas veces que se usó el cupón. Solo aparece si el cupón se ha usado.'
                    },
                    'section-table-date': {
                        title: 'Columna "Fecha"',
                        text: 'Muestra cuándo se usó el cupón. Formato: fecha y hora.'
                    },
                    'section-table-order': {
                        title: 'Columna "Orden"',
                        text: 'Muestra el número de orden. Es clicable y te lleva a los detalles de esa orden.'
                    },
                    'section-table-discount': {
                        title: 'Columna "Descuento"',
                        text: 'Muestra cuánto se descontó en esa orden específica.'
                    },
                    'section-order-link': {
                        title: 'Enlace a orden',
                        text: 'Número de orden clicable. Al hacer clic, te lleva a los detalles de esa orden donde puedes ver toda la información del pedido que usó el cupón.'
                    },
                    'section-actions': {
                        title: 'Sección: Acciones rápidas',
                        text: 'Esta sección muestra botones para realizar acciones rápidas sobre el cupón.'
                    },
                    'section-button-edit': {
                        title: 'Botón "Editar cupón"',
                        text: 'Te lleva a la página de edición del cupón donde puedes modificar toda su configuración.'
                    },
                    'section-button-delete': {
                        title: 'Botón "Eliminar cupón"',
                        text: 'Solo visible si el cupón nunca se ha usado (0 usos). Abre un modal de confirmación para eliminar el cupón. Solo aparece si el cupón tiene 0 usos. Importante: Solo puedes eliminar cupones que nunca se han usado.'
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
