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
                                @click="scrollToSection('section-header')">Dashboard</h1>
                        </div>

                        {{-- Estadísticas de Pedidos --}}
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-statistics')">Estadísticas de Pedidos</h3>
                            
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                                <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                     @click="scrollToSection('section-card-total')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-xl">
                                            <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">150</div>
                                            <div class="text-xs text-gray-500">Total</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                     @click="scrollToSection('section-card-pending')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex items-center justify-center bg-amber-100 text-amber-600 rounded-xl">
                                            <i data-lucide="clock" class="w-6 h-6"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">5</div>
                                            <div class="text-xs text-gray-500">Pendientes</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                     @click="scrollToSection('section-card-confirmed')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-600 rounded-xl">
                                            <i data-lucide="check-circle" class="w-6 h-6"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">25</div>
                                            <div class="text-xs text-gray-500">Confirmados</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                     @click="scrollToSection('section-card-preparing')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex items-center justify-center bg-purple-100 text-purple-600 rounded-xl">
                                            <i data-lucide="package" class="w-6 h-6"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">12</div>
                                            <div class="text-xs text-gray-500">Preparando</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                     @click="scrollToSection('section-card-sent')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-xl">
                                            <i data-lucide="truck" class="w-6 h-6"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">8</div>
                                            <div class="text-xs text-gray-500">Enviados</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer"
                                     @click="scrollToSection('section-card-delivered')">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 flex items-center justify-center bg-emerald-100 text-emerald-600 rounded-xl">
                                            <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">100</div>
                                            <div class="text-xs text-gray-500">Entregados</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pedidos Recientes --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-recent-orders')">Pedidos Recientes</h3>
                            
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                    @click="scrollToSection('section-table-order-number')">Número</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                    @click="scrollToSection('section-table-customer')">Cliente</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                    @click="scrollToSection('section-table-date')">Fecha</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                    @click="scrollToSection('section-table-status')">Estado</th>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                    @click="scrollToSection('section-table-total')">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @for($i = 0; $i < 3; $i++)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4">
                                                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 cursor-pointer hover:underline"
                                                       @click.stop="scrollToSection('section-order-link')">
                                                        #{{ 1000 + $i }}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="h-3 bg-gray-300 rounded w-24"></div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="h-3 bg-gray-300 rounded w-20"></div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Pendiente</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="h-3 bg-gray-300 rounded w-16"></div>
                                                </td>
                                            </tr>
                                            @endfor
                                        </tbody>
                                    </table>
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
                                <p class="text-sm text-gray-700"><strong>Revisa el dashboard regularmente</strong> para mantenerte informado del estado de tu tienda</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa las estadísticas</strong> para identificar tendencias y patrones</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Presta atención a los pedidos pendientes</strong> que requieren tu acción</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El KiuBot Assistant</strong> es una excelente herramienta para aprender sobre la plataforma</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los anuncios pueden contener</strong> información importante sobre actualizaciones o cambios</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Haz clic en los pedidos</strong> para ver sus detalles completos</p>
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
                        title: 'Título "Dashboard"',
                        text: 'Muestra que estás en el panel principal de tu tienda. El Dashboard es la página principal que se muestra cuando inicias sesión en el panel de administración. También puedes acceder desde el menú lateral en la sección "Favoritos".'
                    },
                    'section-statistics': {
                        title: 'Sección: Estadísticas de Pedidos',
                        text: 'El dashboard muestra tarjetas con estadísticas de tus pedidos. Cada tarjeta muestra un número y un ícono representativo. Los números se actualizan en tiempo real con la información más reciente.'
                    },
                    'section-card-total': {
                        title: 'Tarjeta "Total de pedidos"',
                        text: 'Muestra la cantidad total de pedidos recibidos en tu tienda. Incluye todos los estados de pedidos. Te da una visión general del volumen de pedidos de tu tienda.'
                    },
                    'section-card-pending': {
                        title: 'Tarjeta "Pendientes"',
                        text: 'Muestra los pedidos que aún no han sido confirmados. Requieren tu atención para ser procesados. Es importante revisar estos pedidos regularmente para no perder ventas.'
                    },
                    'section-card-confirmed': {
                        title: 'Tarjeta "Confirmados"',
                        text: 'Muestra los pedidos confirmados y listos para prepararse. Ya fueron aceptados y están en proceso. Estos pedidos están listos para ser preparados o empaquetados.'
                    },
                    'section-card-preparing': {
                        title: 'Tarjeta "Preparando"',
                        text: 'Muestra los pedidos que están siendo preparados. En proceso de empaque o preparación. Estos pedidos están en proceso activo de preparación.'
                    },
                    'section-card-sent': {
                        title: 'Tarjeta "Enviados"',
                        text: 'Muestra los pedidos que han sido enviados. Ya están en camino al cliente. Estos pedidos están en tránsito hacia el cliente.'
                    },
                    'section-card-delivered': {
                        title: 'Tarjeta "Entregados"',
                        text: 'Muestra los pedidos completados exitosamente. Ya fueron recibidos por el cliente. Estos pedidos están completamente finalizados.'
                    },
                    'section-recent-orders': {
                        title: 'Sección: Pedidos Recientes',
                        text: 'En la parte inferior del dashboard verás una lista de tus pedidos más recientes. Puedes hacer clic en cualquier pedido para ver sus detalles completos.'
                    },
                    'section-table-order-number': {
                        title: 'Columna "Número"',
                        text: 'Identificador único del pedido. Puedes hacer clic en el número para ver los detalles completos del pedido.'
                    },
                    'section-table-customer': {
                        title: 'Columna "Cliente"',
                        text: 'Nombre del cliente que realizó el pedido. Información de contacto disponible al ver los detalles del pedido.'
                    },
                    'section-table-date': {
                        title: 'Columna "Fecha"',
                        text: 'Fecha y hora en que se realizó el pedido. Formato: día/mes/año hora. Te ayuda a saber cuándo se recibió cada pedido.'
                    },
                    'section-table-status': {
                        title: 'Columna "Estado"',
                        text: 'Estado actual del pedido. Badge con color según el estado: Pendiente (amarillo), Confirmado (verde), Preparando (azul), Enviado (índigo), Entregado (verde).'
                    },
                    'section-table-total': {
                        title: 'Columna "Total"',
                        text: 'Monto total del pedido. Incluye productos, envío y descuentos. Te muestra el valor total de cada pedido.'
                    },
                    'section-order-link': {
                        title: 'Enlace a pedido',
                        text: 'Número de pedido clicable. Al hacer clic, te lleva a los detalles completos del pedido donde puedes ver toda la información, productos, cliente, dirección de envío y más.'
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
