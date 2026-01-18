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
                            <div>
                                <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                    @click="scrollToSection('section-header-title')">Editar Pedido #1234</h1>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 cursor-pointer hover:bg-amber-200 transition-colors mt-1"
                                      @click="scrollToSection('section-header-badge')">
                                    Pendiente
                                </span>
                            </div>
                        </div>

                        {{-- Alerta de Edición Limitada --}}
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 cursor-pointer hover:bg-yellow-100 transition-colors"
                             @click="scrollToSection('section-alert')">
                            <div class="flex items-center gap-3">
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 flex-shrink-0"></i>
                                <div>
                                    <h3 class="text-sm font-medium text-yellow-800">Edición Limitada</h3>
                                    <div class="text-xs text-yellow-700 mt-1">
                                        Este pedido está en estado avanzado y solo se pueden editar algunos campos básicos.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Información del Cliente --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-client')">Información del Cliente</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-client-name')">
                                        Nombre Completo <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           placeholder="Nombre completo del cliente"
                                           @click="scrollToSection('section-client-name')"
                                           readonly>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-client-phone')">
                                        Teléfono / WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           placeholder="3001234567"
                                           @click="scrollToSection('section-client-phone')"
                                           readonly>
                                </div>

                                {{-- Campos condicionales --}}
                                <div x-show="false" class="lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Departamento</label>
                                    <div class="px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 text-sm">
                                        Selecciona departamento
                                    </div>
                                </div>
                                <div x-show="false">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                                    <div class="px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 text-sm">
                                        Selecciona ciudad
                                    </div>
                                </div>
                                <div x-show="false" class="lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección Completa</label>
                                    <textarea rows="3" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 text-sm"
                                              placeholder="Dirección completa, barrio y referencias"
                                              readonly></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Entrega y Pago --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-delivery-payment')">Entrega y Pago</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-delivery-type')">Tipo de Entrega</label>
                                    <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                         @click="scrollToSection('section-delivery-type')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        Recogida en Tienda (Gratis)
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-payment-method')">Método de Pago</label>
                                    <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                         @click="scrollToSection('section-payment-method')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        Transferencia Bancaria
                                    </div>
                                </div>

                                {{-- Comprobante de Pago --}}
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-payment-receipt')">Comprobante de Pago</label>
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-3">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="text-sm font-medium text-green-800">Comprobante actual subido</div>
                                                <a href="#" class="text-xs text-green-600 hover:text-green-700">Descargar</a>
                                            </div>
                                            <label class="flex items-center gap-2 text-sm text-green-700 cursor-pointer">
                                                <input type="checkbox" class="rounded">
                                                Eliminar
                                            </label>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer"
                                            @click="scrollToSection('section-payment-receipt')">
                                        Seleccionar archivo
                                    </button>
                                    <p class="text-xs text-gray-500 mt-2">Tamaño máximo: 5MB. Formatos: JPG, PNG, PDF</p>
                                </div>
                            </div>
                        </div>

                        {{-- Productos del Pedido --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-products')">Productos del Pedido</h3>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 cursor-pointer hover:bg-blue-100 transition-colors"
                                 @click="scrollToSection('section-products-alert')">
                                <div class="text-sm text-blue-800">
                                    <strong>IMPORTANTE:</strong> Los productos no se pueden editar desde aquí. Para modificar los productos, elimina este pedido y crea uno nuevo con los productos correctos.
                                </div>
                            </div>

                            <div class="space-y-4">
                                @for($i = 0; $i < 2; $i++)
                                <div class="flex items-start gap-4 p-4 bg-white rounded-lg border border-gray-200">
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <div class="w-12 h-12 bg-gray-300 rounded"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="h-4 bg-gray-300 rounded w-32 mb-2"></div>
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
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium text-gray-900">$50.000</span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Envío</span>
                                    <span class="text-gray-500">$5.000</span>
                                </div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Descuento</span>
                                    <span class="text-red-500">-$2.000</span>
                                </div>
                                <div class="flex justify-between text-base font-semibold pt-2 border-t border-gray-200">
                                    <span class="text-gray-900">Total</span>
                                    <span class="text-gray-900">$53.000</span>
                                </div>
                            </div>
                        </div>

                        {{-- Notas Adicionales --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-sm font-medium text-gray-700 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-notes')">Notas Adicionales</h3>
                            <textarea rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                      placeholder="Instrucciones especiales, observaciones, etc."
                                      @click="scrollToSection('section-notes')"
                                      readonly></textarea>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex gap-3 justify-end">
                            <button type="button" 
                                    class="px-4 py-2 border-2 border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors flex items-center gap-2 cursor-pointer"
                                    @click="scrollToSection('section-button-cancel')">
                                <i data-lucide="x-circle" class="w-5 h-5"></i>
                                Cancelar
                            </button>
                            <button type="button" 
                                    class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 shadow-sm cursor-pointer"
                                    @click="scrollToSection('section-button-update')">
                                <i data-lucide="check-circle" class="w-5 h-5"></i>
                                Actualizar Pedido
                            </button>
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
                                <p class="text-sm text-gray-700"><strong>No puedes editar productos:</strong> Si necesitas cambiar productos, cancela este pedido y crea uno nuevo</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa el comprobante:</strong> Si cambias el método de pago a transferencia, asegúrate de subir el comprobante</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa las notas:</strong> Agrega información importante en las notas para que otros usuarios la vean</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Valida antes de guardar:</strong> Revisa todos los campos antes de hacer clic en "Actualizar Pedido"</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El estado no se cambia aquí:</strong> Para cambiar el estado del pedido, usa la vista detallada o la lista de pedidos</p>
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
                        text: 'Este botón te lleva de vuelta a la vista detallada del pedido sin guardar cambios.'
                    },
                    'section-header-title': {
                        title: 'Título "Editar Pedido #[número]"',
                        text: 'Muestra que estás editando un pedido específico y su número.'
                    },
                    'section-header-badge': {
                        title: 'Badge de Estado',
                        text: 'Muestra el estado actual del pedido. El color indica: <strong>Amarillo:</strong> Pendiente, <strong>Azul:</strong> Confirmado, Preparando o Enviado, <strong>Verde:</strong> Entregado, <strong>Rojo:</strong> Cancelado.'
                    },
                    'section-alert': {
                        title: 'Alerta de Edición Limitada',
                        text: 'Si el pedido está en un estado avanzado (entregado o cancelado), aparece una alerta amarilla que dice "Edición Limitada". Esto significa que solo puedes editar algunos campos básicos, no todos.'
                    },
                    'section-client': {
                        title: 'Información del Cliente',
                        text: 'Esta sección te permite modificar los datos del cliente.'
                    },
                    'section-client-name': {
                        title: 'Campo "Nombre Completo"',
                        text: 'Un cuadro de texto donde puedes escribir o cambiar el nombre completo del cliente. Este campo es obligatorio (tiene un asterisco *).'
                    },
                    'section-client-phone': {
                        title: 'Campo "Teléfono / WhatsApp"',
                        text: 'Un cuadro de texto donde puedes escribir o cambiar el número de teléfono del cliente. Este campo es obligatorio. El formato puede ser con o sin código de país.'
                    },
                    'section-delivery-payment': {
                        title: 'Entrega y Pago',
                        text: 'Esta sección te permite cambiar cómo se entrega el pedido y cómo pagó el cliente.'
                    },
                    'section-delivery-type': {
                        title: 'Tipo de Entrega',
                        text: 'Puedes elegir entre diferentes opciones (solo aparecen las que tienes habilitadas en tu tienda): <strong>Recogida en Tienda (Gratis):</strong> El cliente recoge el pedido en tu tienda. No hay costo de envío. <strong>Envío Local:</strong> El pedido se entrega en la misma ciudad donde está tu tienda. Puede tener costo de envío. <strong>Envío Nacional:</strong> El pedido se envía a otra ciudad de Colombia. Requiere seleccionar departamento y ciudad, y tiene costo de envío. Al cambiar el tipo de entrega, los campos de dirección aparecen o desaparecen automáticamente según lo que necesites.'
                    },
                    'section-payment-method': {
                        title: 'Método de Pago',
                        text: 'Puedes elegir cómo pagó o pagará el cliente: <strong>Transferencia Bancaria:</strong> El cliente pagó o pagará por transferencia bancaria. Si seleccionas esta opción, aparece la sección para subir o reemplazar el comprobante. <strong>Pago Contra Entrega:</strong> El cliente pagará cuando reciba el pedido. No necesitas comprobante. <strong>Efectivo:</strong> El cliente pagará en efectivo. Solo aparece si el tipo de entrega es "Recoger en Tienda".'
                    },
                    'section-payment-receipt': {
                        title: 'Comprobante de Pago',
                        text: 'Esta sección solo aparece si el método de pago es "Transferencia Bancaria". Si ya hay un comprobante subido, aparece una caja verde que muestra: un mensaje que dice "Comprobante actual subido", un enlace "Descargar" para ver el comprobante actual, y una casilla "Eliminar" para quitar el comprobante actual. También puedes subir o reemplazar el comprobante usando el botón "Seleccionar archivo". Tamaño máximo: 5MB. Formatos permitidos: JPG, PNG, PDF. Si marcas la casilla "Eliminar" y subes un archivo nuevo, se elimina el anterior y se guarda el nuevo.'
                    },
                    'section-products': {
                        title: 'Productos del Pedido',
                        text: 'Esta sección muestra todos los productos del pedido. <strong>IMPORTANTE:</strong> Los productos no se pueden editar desde aquí.'
                    },
                    'section-products-alert': {
                        title: 'Alerta Informativa',
                        text: 'Si el pedido se puede editar, aparece una caja azul que explica: "Para modificar los productos, elimina este pedido y crea uno nuevo con los productos correctos."'
                    },
                    'section-notes': {
                        title: 'Notas Adicionales',
                        text: 'Esta sección te permite agregar o modificar notas sobre el pedido. Un cuadro de texto grande donde puedes escribir: instrucciones especiales, observaciones, notas internas, cualquier información relevante sobre el pedido. Este campo es opcional y no tiene límite de caracteres (aunque se recomienda ser breve).'
                    },
                    'section-button-cancel': {
                        title: 'Botón "Cancelar"',
                        text: 'Este botón (rojo) te lleva de vuelta a la vista detallada del pedido sin guardar ningún cambio. Úsalo si cambiaste de opinión y no quieres modificar nada.'
                    },
                    'section-button-update': {
                        title: 'Botón "Actualizar Pedido"',
                        text: 'Este botón (negro) guarda todos los cambios que hiciste y actualiza el pedido. Después de hacer clic, te lleva de vuelta a la vista detallada del pedido actualizado.'
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
