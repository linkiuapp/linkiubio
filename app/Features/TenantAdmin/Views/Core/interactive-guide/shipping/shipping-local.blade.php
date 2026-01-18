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
                        {{-- Tarjeta de Envío Local --}}
                        <div class="border border-gray-200 rounded-lg p-6">
                            {{-- Encabezado de la Tarjeta --}}
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center cursor-pointer hover:bg-green-200 transition-colors"
                                     @click="scrollToSection('section-card-header')">
                                    <i data-lucide="truck" class="w-6 h-6 text-green-600"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-card-title')">Envío Local</h3>
                                    <p class="text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-card-description')">Entregas dentro de tu ciudad principal</p>
                                </div>
                            </div>

                            {{-- Interruptor de Activación --}}
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-toggle')">Estado</label>
                                    <p class="text-xs text-gray-500">Activa o desactiva la opción de envío local</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm text-gray-600">Habilitado</span>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle')">
                                        <input type="checkbox" class="peer sr-only" checked>
                                        <span class="absolute inset-0 bg-green-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </div>
                            </div>

                            {{-- Campos de Configuración --}}
                            <div class="space-y-4">
                                {{-- Tu Ciudad Principal --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-city')">
                                        Tu ciudad principal
                                    </label>
                                    <input type="text" 
                                           value="Sincelejo"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-city')"
                                           readonly>
                                    <p class="text-xs text-gray-500 mt-1">Los clientes de esta ciudad pagarán tarifa local</p>
                                </div>

                                {{-- Costo del Envío --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-cost')">
                                        Costo del envío
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                        <input type="number" 
                                               value="5000"
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-cost')"
                                               readonly>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">El sistema acepta incrementos de 500 pesos</p>
                                </div>

                                {{-- Tiempo de Entrega --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-delivery-time')">
                                        Tiempo de entrega
                                    </label>
                                    <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                         @click="scrollToSection('section-delivery-time')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        2 horas
                                    </div>
                                </div>

                                {{-- Envío Gratis por Monto --}}
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-free-shipping-toggle')">
                                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded" checked>
                                            <span class="text-sm font-medium text-gray-800">Activar envío gratis por monto</span>
                                        </label>
                                    </div>
                                    
                                    <div class="ml-7">
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-free-shipping-amount')">
                                            Envío gratis desde
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                            <input type="number" 
                                                   value="50000"
                                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-free-shipping-amount')"
                                                   readonly>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Los pedidos de este monto o más tendrán envío gratis</p>
                                    </div>
                                </div>

                                {{-- Instrucciones para el Cliente --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-instructions')">
                                        Instrucciones para el cliente
                                    </label>
                                    <textarea rows="4" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                              @click="scrollToSection('section-instructions')"
                                              placeholder="Ejemplo: Horarios de entrega, zonas específicas donde entregas, tiempo estimado de entrega, requisitos especiales..."
                                              readonly>Entregamos de lunes a viernes de 9:00 AM a 6:00 PM. Zonas de cobertura: Centro, Norte y Sur de la ciudad. Tiempo estimado: 2 horas después de confirmar el pedido.</textarea>
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
                                <p class="text-sm text-gray-700"><strong>Define un costo razonable</strong> que cubra tus gastos de entrega</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si ofreces envío gratis</strong>, asegúrate de que el monto mínimo sea alcanzable pero no muy bajo</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Sé claro en las instrucciones</strong> sobre horarios y zonas de entrega</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Considera el tiempo real</strong> que te toma hacer las entregas al configurar el tiempo de entrega</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El envío local solo aplica</strong> para clientes que vivan en la ciudad que definas</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El costo del envío se suma</strong> al total del pedido automáticamente</p>
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
                    'section-card-header': {
                        title: 'Encabezado de la Tarjeta',
                        text: 'Muestra un ícono de camión en un fondo verde. Identifica visualmente la sección de envío local.'
                    },
                    'section-card-title': {
                        title: 'Título "Envío Local"',
                        text: 'Muestra el nombre de la opción de envío. Es el título principal de esta sección.'
                    },
                    'section-card-description': {
                        title: 'Descripción',
                        text: 'Texto que dice "Entregas dentro de tu ciudad principal". Explica brevemente qué es esta opción.'
                    },
                    'section-toggle': {
                        title: 'Interruptor Habilitado/Deshabilitado',
                        text: 'Este interruptor activa o desactiva la opción de envío local. Cuando está activado, aparece el texto "Habilitado" en gris. Cuando está desactivado, aparece el texto "Deshabilitado" en gris. Solo cuando está activado, se muestran los campos de configuración debajo.'
                    },
                    'section-city': {
                        title: 'Campo "Tu ciudad principal"',
                        text: 'Aquí escribes el nombre de la ciudad donde haces entregas locales. Ejemplo: "Sincelejo", "Bogotá", "Medellín". Los clientes que vivan en esta ciudad verán la tarifa de envío local. Texto de ayuda: "Los clientes de esta ciudad pagarán tarifa local".'
                    },
                    'section-cost': {
                        title: 'Campo "Costo del envío"',
                        text: 'Aquí defines cuánto cuesta el envío local. El campo tiene un símbolo de peso ($) al inicio. Puedes escribir números enteros (ejemplo: 3000, 5000, 10000). El sistema acepta incrementos de 500 pesos. Este es el costo que pagará el cliente por el envío local.'
                    },
                    'section-delivery-time': {
                        title: 'Campo "Tiempo de entrega"',
                        text: 'Este campo te permite elegir cuánto tiempo tardas en entregar el pedido. Opciones disponibles: 30 minutos, 1 hora, 2 horas, 4 horas, 1 día, 2-3 días. Selecciona el tiempo que mejor refleje tu capacidad de entrega.'
                    },
                    'section-free-shipping-toggle': {
                        title: 'Interruptor "Activar envío gratis por monto"',
                        text: 'Este interruptor te permite ofrecer envío gratis cuando el pedido supera cierto monto. Cuando lo activas, aparece un campo adicional para definir el monto mínimo.'
                    },
                    'section-free-shipping-amount': {
                        title: 'Campo "Envío gratis desde"',
                        text: 'Aquí defines el monto mínimo para que el envío sea gratis. Ejemplo: Si escribes 50000, los pedidos de $50.000 o más tendrán envío gratis. El campo tiene un símbolo de peso ($) al inicio. Puedes escribir números enteros (ejemplo: 50000, 100000).'
                    },
                    'section-instructions': {
                        title: 'Campo "Instrucciones para el cliente"',
                        text: 'Aquí puedes escribir información importante sobre el envío local. Ejemplos: Horarios de entrega, zonas específicas donde entregas, tiempo estimado de entrega, requisitos especiales. Este texto aparecerá cuando el cliente seleccione esta opción de envío. No hay límite de caracteres visible, pero se recomienda ser conciso.'
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
