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
                        {{-- Encabezado del Pedido --}}
                        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                            <div class="flex items-center gap-4">
                                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                        @click="scrollToSection('section-header-back')">
                                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                                </button>
                                <div>
                                    <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                        @click="scrollToSection('section-header-title')">Pedido #1234</h1>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 cursor-pointer hover:bg-amber-200 transition-colors"
                                              @click="scrollToSection('section-header-badge')">
                                            Pendiente
                                        </span>
                                        <span class="text-xs text-gray-500 cursor-pointer hover:text-blue-600 transition-colors"
                                              @click="scrollToSection('section-header-date')">
                                            Creado el 08/01/2025 a las 14:30 (hace 2 horas)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            {{-- Columna Principal --}}
                            <div class="lg:col-span-2 space-y-6">
                                {{-- Información del Cliente --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-client')">Información del Cliente</h2>
                                    <div class="space-y-3">
                                        <div class="flex items-start gap-3">
                                            <i data-lucide="user" class="w-5 h-5 text-gray-400 mt-0.5"></i>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">Juan Pérez</div>
                                                <div class="text-xs text-gray-500">Cliente</div>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <i data-lucide="phone" class="w-5 h-5 text-gray-400 mt-0.5"></i>
                                            <div>
                                                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 cursor-pointer"
                                                   @click.prevent="scrollToSection('section-client-phone')">300 123 4567</a>
                                                <div class="text-xs text-gray-500">Teléfono</div>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <i data-lucide="map-pin" class="w-5 h-5 text-gray-400 mt-0.5"></i>
                                            <div>
                                                <div class="text-sm text-gray-900">Calle 123 #45-67</div>
                                                <div class="text-xs text-gray-500">Dirección</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Productos del Pedido --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-products')">
                                        3 Productos
                                    </h2>
                                    <div class="space-y-4">
                                        @for($i = 0; $i < 2; $i++)
                                        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                            {{-- Wireframe: Imagen --}}
                                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <div class="w-12 h-12 bg-gray-300 rounded"></div>
                                            </div>
                                            <div class="flex-1">
                                                {{-- Wireframe: Nombre --}}
                                                <div class="h-4 bg-gray-300 rounded w-32 mb-2"></div>
                                                {{-- Wireframe: Variantes --}}
                                                <div class="h-3 bg-gray-200 rounded w-24 mb-3"></div>
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-4">
                                                        <div>
                                                            <div class="text-xs text-gray-500">Cantidad</div>
                                                            <div class="h-4 bg-gray-300 rounded w-8"></div>
                                                        </div>
                                                        <div>
                                                            <div class="text-xs text-gray-500">Precio unitario</div>
                                                            <div class="h-4 bg-gray-300 rounded w-16"></div>
                                                        </div>
                                                        <div>
                                                            <div class="text-xs text-gray-500">Total</div>
                                                            <div class="h-4 bg-gray-300 rounded w-20"></div>
                                                        </div>
                                                    </div>
                                                    <a href="#" class="text-xs text-blue-600 hover:text-blue-700 cursor-pointer"
                                                       @click.prevent="scrollToSection('section-products-link')">Ver producto</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>

                                {{-- Resumen del Pedido --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-summary')">Resumen del Pedido</h2>
                                    <div class="space-y-2">
                                        <div class="flex justify-between text-sm cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-summary-products')">
                                            <span class="text-gray-600">Productos</span>
                                            <span class="font-medium text-gray-900">$50.000</span>
                                        </div>
                                        <div class="flex justify-between text-sm cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-summary-shipping')">
                                            <span class="text-gray-600">Envío</span>
                                            <span class="font-medium text-gray-900">$5.000</span>
                                        </div>
                                        <div class="flex justify-between text-sm cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-summary-discount')">
                                            <span class="text-gray-600">Descuento</span>
                                            <span class="font-medium text-green-600">-$2.000</span>
                                        </div>
                                        <div class="pt-3 border-t border-gray-200">
                                            <div class="flex justify-between items-center cursor-pointer hover:text-blue-600 transition-colors"
                                                 @click="scrollToSection('section-summary-total')">
                                                <span class="text-base font-semibold text-gray-900">Total Cobrado</span>
                                                <span class="text-lg font-bold text-gray-900">$53.000</span>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                                 @click="scrollToSection('section-summary-income')">
                                                Tu ingreso real: $50.000
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Historial de Estados --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-history')">Historial de Estados</h2>
                                    <div class="space-y-3">
                                        @for($i = 0; $i < 2; $i++)
                                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                            <div class="flex-1">
                                                <div class="text-sm text-gray-900">Pendiente → Confirmado</div>
                                                <div class="text-xs text-gray-500 mt-1">Sin notas</div>
                                                <div class="text-xs text-gray-400 mt-1">Admin • hace 1 hora</div>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            {{-- Barra Lateral --}}
                            <div class="space-y-6">
                                {{-- Información de Entrega --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-delivery')">Información de Entrega</h2>
                                    <div class="space-y-3">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-delivery-type')">
                                            <div class="text-sm text-gray-600">Tipo</div>
                                            <div class="text-sm font-medium text-gray-900">Domicilio</div>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-delivery-cost')">
                                            <div class="text-sm text-gray-600">Costo de Envío</div>
                                            <div class="text-sm font-medium text-gray-900">$5.000</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Información de Pago --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-payment')">Información de Pago</h2>
                                    <div class="space-y-3">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-payment-method')">
                                            <div class="text-sm text-gray-600">Método</div>
                                            <div class="text-sm font-medium text-gray-900">Transferencia Bancaria</div>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-payment-receipt')">
                                            <a href="#" class="text-sm text-blue-600 hover:text-blue-700">Ver comprobante</a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Cambiar Estado --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-change-status')">Cambiar Estado</h2>
                                    <div class="px-3 py-2 pr-8 border border-gray-200 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                         @click="scrollToSection('section-change-status-select')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        Pendiente
                                    </div>
                                </div>

                                {{-- Acciones Rápidas --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-actions')">Acciones Rápidas</h2>
                                    <div class="space-y-2">
                                        <button class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                                @click="scrollToSection('section-actions-edit')">
                                            <i data-lucide="pencil" class="w-4 h-4 inline mr-2"></i>
                                            Editar Pedido
                                        </button>
                                        <button class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                                @click="scrollToSection('section-actions-pdf')">
                                            <i data-lucide="download" class="w-4 h-4 inline mr-2"></i>
                                            Descargar PDF
                                        </button>
                                        <button class="w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                                @click="scrollToSection('section-actions-whatsapp')">
                                            <i data-lucide="message-circle" class="w-4 h-4 inline mr-2"></i>
                                            Contactar por WhatsApp
                                        </button>
                                        <button class="w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                                @click="scrollToSection('section-actions-cancel')">
                                            <i data-lucide="x-circle" class="w-4 h-4 inline mr-2"></i>
                                            Cancelar Pedido
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
                                <p class="text-sm text-gray-700"><strong>Usa el botón de WhatsApp</strong> para contactar rápidamente al cliente</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa el comprobante</strong> antes de marcar como entregado si el pago fue por transferencia</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Valida comprobantes dudosos</strong> con KiuBot antes de confirmar el pago</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Agrega notas</strong> cuando cambies el estado para tener un registro claro</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Descarga el PDF</strong> para tener un comprobante del pedido</p>
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
                    'section-header-back': {
                        title: 'Botón de Regreso',
                        text: 'Este botón te lleva de vuelta a la lista de todos los pedidos. Es útil cuando quieres volver a ver todos tus pedidos.'
                    },
                    'section-header-title': {
                        title: 'Título "Pedido #[número]"',
                        text: 'Muestra el número único del pedido que estás viendo. Este número identifica específicamente este pedido.'
                    },
                    'section-header-badge': {
                        title: 'Badge de Estado',
                        text: 'Muestra el estado actual del pedido con un color: <strong>Amarillo:</strong> Pendiente, <strong>Azul:</strong> Confirmado, Preparando o Enviado, <strong>Verde:</strong> Entregado, <strong>Rojo:</strong> Cancelado.'
                    },
                    'section-header-date': {
                        title: 'Fecha de Creación',
                        text: 'Muestra cuándo se creó el pedido en formato de fecha y hora, y también dice hace cuánto tiempo (por ejemplo, "hace 2 horas").'
                    },
                    'section-client': {
                        title: 'Información del Cliente',
                        text: 'Esta sección muestra todos los datos del cliente que hizo el pedido.'
                    },
                    'section-client-phone': {
                        title: 'Teléfono',
                        text: 'El número de teléfono del cliente. Si haces clic en él, se abre WhatsApp para contactarlo directamente.'
                    },
                    'section-products': {
                        title: 'Productos del Pedido',
                        text: 'Esta sección muestra todos los productos que el cliente pidió. En el título aparece cuántos productos diferentes tiene el pedido.'
                    },
                    'section-products-link': {
                        title: 'Enlace "Ver producto"',
                        text: 'Te lleva a la página de administración de ese producto donde puedes ver y editar toda su información.'
                    },
                    'section-summary': {
                        title: 'Resumen del Pedido',
                        text: 'Esta sección muestra el desglose de precios del pedido.'
                    },
                    'section-summary-products': {
                        title: 'Productos',
                        text: 'El total de dinero que cuestan todos los productos juntos (sin incluir envío ni descuentos).'
                    },
                    'section-summary-shipping': {
                        title: 'Envío',
                        text: 'El costo del envío a domicilio. Si dice "Gratis", significa que el cliente no pagó por el envío. Solo aparece si el pedido es a domicilio.'
                    },
                    'section-summary-discount': {
                        title: 'Descuento',
                        text: 'Si el cliente usó un cupón de descuento, aquí aparece cuánto se descontó. Solo aparece si hubo descuento.'
                    },
                    'section-summary-total': {
                        title: 'Total Cobrado',
                        text: 'El monto total que pagó el cliente (productos + envío - descuento).'
                    },
                    'section-summary-income': {
                        title: 'Tu Ingreso Real',
                        text: 'Si hay envío, aparece un texto que muestra cuánto dinero realmente recibes por los productos (sin contar el envío, porque ese es para el repartidor).'
                    },
                    'section-history': {
                        title: 'Historial de Estados',
                        text: 'Esta sección muestra todos los cambios de estado que ha tenido el pedido. Solo aparece si el pedido ha cambiado de estado al menos una vez. Cada cambio muestra: el estado anterior y nuevo, notas adicionales (si las hay), quién lo cambió y cuándo.'
                    },
                    'section-delivery': {
                        title: 'Información de Entrega',
                        text: 'Esta sección está en la parte derecha de la pantalla y muestra información sobre cómo se entregará el pedido.'
                    },
                    'section-delivery-type': {
                        title: 'Tipo',
                        text: 'Muestra el tipo de entrega: <strong>Domicilio:</strong> Se envía a la dirección del cliente, <strong>Pickup en Tienda:</strong> El cliente recoge en tu tienda, <strong>Envío Nacional:</strong> Se envía a otra ciudad.'
                    },
                    'section-delivery-cost': {
                        title: 'Costo de Envío',
                        text: 'Muestra cuánto cuesta el envío. Si dice "Gratis", el cliente no pagó por el envío.'
                    },
                    'section-payment': {
                        title: 'Información de Pago',
                        text: 'Esta sección muestra cómo pagó el cliente.'
                    },
                    'section-payment-method': {
                        title: 'Método',
                        text: 'Muestra el método de pago: <strong>Transferencia Bancaria:</strong> El cliente pagó por transferencia, <strong>Pago Contra Entrega:</strong> El cliente pagará cuando reciba el pedido, <strong>Efectivo:</strong> El cliente pagará en efectivo.'
                    },
                    'section-payment-receipt': {
                        title: 'Comprobante',
                        text: 'Si el cliente subió un comprobante de pago (imagen del recibo de transferencia), aparece un enlace "Ver comprobante". Al hacer clic, puedes: ver la imagen del comprobante, validar el comprobante con KiuBot (inteligencia artificial que verifica si es real o falso), y descargar el comprobante. Si el comprobante ya fue validado, verás un badge de color: Verde "Validado IA", Amarillo "Revisar", o Rojo "Sospechoso".'
                    },
                    'section-change-status': {
                        title: 'Cambiar Estado',
                        text: 'Esta sección te permite cambiar el estado del pedido directamente desde esta vista.'
                    },
                    'section-change-status-select': {
                        title: 'Select de Estado',
                        text: 'Un menú desplegable donde puedes elegir el nuevo estado: Pendiente, Confirmado, Preparando, Enviado, Entregado, Cancelado. Al cambiar el estado, aparece un cuadro donde puedes agregar notas sobre el cambio (opcional). Por ejemplo, puedes escribir "Pedido listo para recoger" o "Cliente confirmó recepción".'
                    },
                    'section-actions': {
                        title: 'Acciones Rápidas',
                        text: 'Esta sección tiene botones para realizar acciones sobre el pedido.'
                    },
                    'section-actions-edit': {
                        title: 'Botón "Editar Pedido"',
                        text: 'Te lleva a la pantalla de edición donde puedes modificar los datos del pedido. Solo aparece si el pedido aún se puede editar (no está entregado ni cancelado).'
                    },
                    'section-actions-pdf': {
                        title: 'Botón "Descargar PDF"',
                        text: 'Genera y descarga un archivo PDF con el recibo del pedido. Es útil para imprimir o guardar como comprobante.'
                    },
                    'section-actions-whatsapp': {
                        title: 'Botón "Contactar por WhatsApp"',
                        text: 'Abre WhatsApp con un mensaje pre-escrito para contactar al cliente sobre este pedido. El mensaje incluye el número del pedido.'
                    },
                    'section-actions-cancel': {
                        title: 'Botón "Cancelar Pedido"',
                        text: 'Cancela el pedido. Solo aparece si el pedido no está entregado ni cancelado. Al hacer clic, aparece un cuadro de confirmación. Si tu tienda tiene protección con clave maestra, te pedirá la clave antes de cancelar.'
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
