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
                            <h1 class="text-2xl font-bold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-header-title')">Notificaciones WhatsApp</h1>
                            <p class="text-sm text-gray-600 mt-2 cursor-pointer hover:text-blue-600 transition-colors"
                               @click="scrollToSection('section-header-description')">Configura tu número para recibir notificaciones automáticas sobre pedidos, reservas y pagos</p>
                        </div>

                        {{-- Sección: Configuración Principal --}}
                        <div class="bg-green-50 rounded-lg border border-green-200 p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center cursor-pointer hover:bg-green-200 transition-colors"
                                     @click="scrollToSection('section-card-whatsapp')">
                                    <i data-lucide="message-circle" class="w-6 h-6 text-green-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-card-whatsapp')">Número de WhatsApp</h3>
                                    <p class="text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-card-whatsapp')">Tu número para recibir notificaciones</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-phone')">
                                        Número de WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <div class="px-4 py-3 bg-gray-100 border border-gray-300 rounded-l-lg text-sm font-medium text-gray-700 cursor-pointer hover:bg-gray-200 transition-colors"
                                             @click="scrollToSection('section-prefix')">
                                            +57
                                        </div>
                                        <input type="text" 
                                               placeholder="3001234567"
                                               maxlength="10"
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-r-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-phone')"
                                               readonly>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-field-help')">Ingresa tu número de celular (10 dígitos) sin espacios ni guiones</p>
                                </div>

                                <button class="w-full px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                        @click="scrollToSection('section-button-save')">
                                    Guardar Configuración
                                </button>
                            </div>
                        </div>

                        {{-- Sección: Notificaciones que Recibirás --}}
                        <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center cursor-pointer hover:bg-blue-200 transition-colors"
                                     @click="scrollToSection('section-card-notifications-received')">
                                    <i data-lucide="bell" class="w-6 h-6 text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-card-notifications-received')">Notificaciones que recibirás</h3>
                                    <p class="text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-card-notifications-received')">Alertas automáticas en tu WhatsApp</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                {{-- Nuevo pedido --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-green-300 transition-colors"
                                     @click="scrollToSection('section-notification-new-order')">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="shopping-cart" class="w-5 h-5 text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Nuevo pedido</h4>
                                            <p class="text-xs text-gray-600 mb-1"><strong>Cuándo:</strong> Cuando un cliente realiza un pedido</p>
                                            <p class="text-xs text-gray-600"><strong>Qué recibes:</strong> Una notificación en tu WhatsApp informándote del nuevo pedido</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Comprobante recibido --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                     @click="scrollToSection('section-notification-receipt')">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="file-check" class="w-5 h-5 text-blue-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Comprobante recibido</h4>
                                            <p class="text-xs text-gray-600 mb-1"><strong>Cuándo:</strong> Cuando un cliente sube un comprobante de pago</p>
                                            <p class="text-xs text-gray-600"><strong>Qué recibes:</strong> Una notificación en tu WhatsApp informándote que hay un comprobante para revisar</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Nueva reserva --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-purple-300 transition-colors"
                                     @click="scrollToSection('section-notification-reservation')">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="calendar" class="w-5 h-5 text-purple-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Nueva reserva</h4>
                                            <p class="text-xs text-gray-600 mb-1"><strong>Cuándo:</strong> Cuando se solicita una reserva (mesas o habitaciones de hotel)</p>
                                            <p class="text-xs text-gray-600"><strong>Qué recibes:</strong> Una notificación en tu WhatsApp informándote de la nueva reserva</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Notificaciones Automáticas a Clientes --}}
                        <div class="bg-indigo-50 rounded-lg border border-indigo-200 p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center cursor-pointer hover:bg-indigo-200 transition-colors"
                                     @click="scrollToSection('section-card-notifications-clients')">
                                    <i data-lucide="users" class="w-6 h-6 text-indigo-600"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-card-notifications-clients')">Notificaciones automáticas a clientes</h3>
                                    <p class="text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-card-notifications-clients')">Mensajes que tus clientes recibirán automáticamente</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Confirmación de pedido --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-green-300 transition-colors"
                                     @click="scrollToSection('section-client-confirmation')">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Confirmación de pedido</h4>
                                            <p class="text-xs text-gray-600 mb-1"><strong>Cuándo:</strong> Al crear el pedido</p>
                                            <p class="text-xs text-gray-600"><strong>Qué recibe el cliente:</strong> Un mensaje confirmando que su pedido fue recibido</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Cambios de estado --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                     @click="scrollToSection('section-client-status')">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="refresh-cw" class="w-5 h-5 text-blue-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Cambios de estado</h4>
                                            <p class="text-xs text-gray-600 mb-1"><strong>Cuándo:</strong> Cuando el pedido cambia de estado</p>
                                            <p class="text-xs text-gray-600"><strong>Qué recibe el cliente:</strong> Un mensaje informándole del nuevo estado (confirmado, en preparación, en camino, entregado, cancelado)</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Confirmación de reserva --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-purple-300 transition-colors"
                                     @click="scrollToSection('section-client-reservation')">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="calendar-check" class="w-5 h-5 text-purple-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Confirmación de reserva</h4>
                                            <p class="text-xs text-gray-600 mb-1"><strong>Cuándo:</strong> Cuando se confirma una reserva</p>
                                            <p class="text-xs text-gray-600"><strong>Qué recibe el cliente:</strong> Un mensaje confirmando su reserva con los detalles</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Recordatorios --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-orange-300 transition-colors"
                                     @click="scrollToSection('section-client-reminders')">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="clock" class="w-5 h-5 text-orange-600"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Recordatorios</h4>
                                            <p class="text-xs text-gray-600 mb-1"><strong>Cuándo:</strong> 24 horas antes de reservas</p>
                                            <p class="text-xs text-gray-600"><strong>Qué recibe el cliente:</strong> Un mensaje recordándole su reserva próxima</p>
                                        </div>
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
                                <p class="text-sm text-gray-700"><strong>Usa el número principal</strong> que uses más frecuentemente para recibir notificaciones</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Mantén WhatsApp activo</strong> en ese número para recibir las notificaciones</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Verifica el número</strong> antes de guardar para asegurarte de que sea correcto</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa las notificaciones</strong> después de configurar haciendo una prueba con un pedido</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Las notificaciones son automáticas</strong>, no necesitas activarlas manualmente</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Sin costo adicional</strong>, las notificaciones están incluidas en tu plan</p>
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
                        title: 'Título "Notificaciones WhatsApp"',
                        text: 'Muestra el nombre de la sección donde estás. Te indica que estás en la pantalla para configurar las notificaciones de WhatsApp.'
                    },
                    'section-header-description': {
                        title: 'Descripción',
                        text: 'Texto que dice "Configura tu número para recibir notificaciones automáticas sobre pedidos, reservas y pagos". Explica el propósito de esta página.'
                    },
                    'section-card-whatsapp': {
                        title: 'Tarjeta "Número de WhatsApp"',
                        text: 'Tarjeta verde con ícono de mensaje. Contiene el título "Número de WhatsApp" y la descripción "Tu número para recibir notificaciones". Esta sección es donde configuras tu número de WhatsApp.'
                    },
                    'section-prefix': {
                        title: 'Prefijo "+57"',
                        text: 'Campo fijo que muestra el código de país de Colombia (+57). Aparece automáticamente y no necesitas escribirlo. El sistema lo agrega automáticamente a tu número.'
                    },
                    'section-field-phone': {
                        title: 'Campo "Número de WhatsApp"',
                        text: 'Campo de texto donde ingresas tu número de celular. Solo debes escribir los 10 dígitos de tu número (ejemplo: 3001234567). No incluyas el código de país (+57), ya aparece automáticamente. No uses espacios ni guiones. Formato requerido: Exactamente 10 dígitos numéricos, sin espacios ni guiones. Este campo es obligatorio.'
                    },
                    'section-field-help': {
                        title: 'Texto de ayuda',
                        text: 'Texto que dice "Ingresa tu número de celular (10 dígitos) sin espacios ni guiones". Te ayuda a entender el formato correcto del número.'
                    },
                    'section-button-save': {
                        title: 'Botón "Guardar Configuración"',
                        text: 'Guarda tu número de WhatsApp. Mientras guarda, muestra "Guardando..." y se deshabilita. Aparece un mensaje de éxito cuando se guarda correctamente. Una vez guardado, comenzarás a recibir notificaciones automáticamente.'
                    },
                    'section-card-notifications-received': {
                        title: 'Tarjeta "Notificaciones que recibirás"',
                        text: 'Tarjeta azul con ícono de campana. Contiene el título "Notificaciones que recibirás" y la descripción "Alertas automáticas en tu WhatsApp". Esta sección muestra qué notificaciones recibirás tú en tu WhatsApp.'
                    },
                    'section-notification-new-order': {
                        title: 'Notificación: Nuevo pedido',
                        text: 'Ícono verde de carrito. <strong>Cuándo:</strong> Cuando un cliente realiza un pedido. <strong>Qué recibes:</strong> Una notificación en tu WhatsApp informándote del nuevo pedido con los detalles del pedido.'
                    },
                    'section-notification-receipt': {
                        title: 'Notificación: Comprobante recibido',
                        text: 'Ícono azul de archivo con check. <strong>Cuándo:</strong> Cuando un cliente sube un comprobante de pago. <strong>Qué recibes:</strong> Una notificación en tu WhatsApp informándote que hay un comprobante para revisar. Debes revisar el comprobante en el sistema para aprobar o rechazar el pago.'
                    },
                    'section-notification-reservation': {
                        title: 'Notificación: Nueva reserva',
                        text: 'Ícono morado de calendario. <strong>Cuándo:</strong> Cuando se solicita una reserva (mesas o habitaciones de hotel). <strong>Qué recibes:</strong> Una notificación en tu WhatsApp informándote de la nueva reserva con los detalles de la reserva.'
                    },
                    'section-card-notifications-clients': {
                        title: 'Tarjeta "Notificaciones automáticas a clientes"',
                        text: 'Tarjeta índigo con ícono de usuarios. Contiene el título "Notificaciones automáticas a clientes" y la descripción "Mensajes que tus clientes recibirán automáticamente". Esta sección muestra qué notificaciones recibirán tus clientes automáticamente.'
                    },
                    'section-client-confirmation': {
                        title: 'Notificación a Cliente: Confirmación de pedido',
                        text: 'Ícono verde de check. <strong>Cuándo:</strong> Al crear el pedido. <strong>Qué recibe el cliente:</strong> Un mensaje confirmando que su pedido fue recibido. El mensaje incluye el número de pedido y los detalles del pedido.'
                    },
                    'section-client-status': {
                        title: 'Notificación a Cliente: Cambios de estado',
                        text: 'Ícono azul de refresh. <strong>Cuándo:</strong> Cuando el pedido cambia de estado. <strong>Qué recibe el cliente:</strong> Un mensaje informándole del nuevo estado (confirmado, en preparación, en camino, entregado, cancelado). El cliente recibe actualizaciones automáticas sobre el estado de su pedido.'
                    },
                    'section-client-reservation': {
                        title: 'Notificación a Cliente: Confirmación de reserva',
                        text: 'Ícono morado de calendario con check. <strong>Cuándo:</strong> Cuando se confirma una reserva. <strong>Qué recibe el cliente:</strong> Un mensaje confirmando su reserva con los detalles (fecha, hora, tipo de reserva, etc.).'
                    },
                    'section-client-reminders': {
                        title: 'Notificación a Cliente: Recordatorios',
                        text: 'Ícono naranja de reloj. <strong>Cuándo:</strong> 24 horas antes de reservas. <strong>Qué recibe el cliente:</strong> Un mensaje recordándole su reserva próxima. Esto ayuda a reducir las ausencias y mejorar la gestión de reservas.'
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
