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
                        {{-- Tarjeta de Envío Nacional --}}
                        <div class="border border-gray-200 rounded-lg p-6">
                            {{-- Encabezado de la Tarjeta --}}
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center cursor-pointer hover:bg-blue-200 transition-colors"
                                     @click="scrollToSection('section-card-header')">
                                    <i data-lucide="rocket" class="w-6 h-6 text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                            @click="scrollToSection('section-card-title')">Envío Nacional</h3>
                                        <span class="text-xs text-gray-500 cursor-pointer hover:text-blue-600 transition-colors"
                                              @click="scrollToSection('section-zone-counter')">(2/4 zonas configuradas)</span>
                                    </div>
                                    <p class="text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-card-description')">Configura zonas con diferentes tarifas</p>
                                </div>
                            </div>

                            {{-- Interruptor de Activación --}}
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-toggle')">Estado</label>
                                    <p class="text-xs text-gray-500">Activa o desactiva la opción de envío nacional</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm text-gray-600">Habilitado</span>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle')">
                                        <input type="checkbox" class="peer sr-only" checked>
                                        <span class="absolute inset-0 bg-blue-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </div>
                            </div>

                            {{-- Configuración General --}}
                            <div class="space-y-4 mb-6">
                                {{-- Envío Gratis Nacional por Monto --}}
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-free-shipping-toggle')">
                                            <input type="checkbox" class="w-5 h-5 text-green-600 rounded" checked>
                                            <span class="text-sm font-medium text-gray-800">Activar envío gratis nacional por monto</span>
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
                                                   value="100000"
                                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-free-shipping-amount')"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- Instrucciones Generales --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-general-instructions')">
                                        Instrucciones generales para envío nacional
                                    </label>
                                    <textarea rows="3" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                              @click="scrollToSection('section-general-instructions')"
                                              placeholder="Ejemplo: Empresas de mensajería que utilizas, tiempos estimados generales, políticas de envío..."
                                              readonly>Utilizamos empresas de mensajería confiables para entregas a nivel nacional. Los tiempos estimados varían según la zona. Para consultas sobre tu pedido, contáctanos.</textarea>
                                </div>
                            </div>

                            {{-- Zonas de Envío --}}
                            <div class="border-t border-gray-200 pt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-base font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-zones')">Zonas de Envío</h4>
                                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                            @click="scrollToSection('section-button-add-zone')">
                                        <i data-lucide="plus" class="w-4 h-4 inline"></i>
                                        Agregar Zona
                                    </button>
                                </div>

                                {{-- Lista de Zonas Configuradas --}}
                                <div class="space-y-4">
                                    @for($i = 0; $i < 2; $i++)
                                    <div class="border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-blue-300 transition-all"
                                         @click="scrollToSection('section-zone-item')">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex-1">
                                                <h5 class="font-semibold text-gray-900 mb-2">{{ ['Ciudades Principales', 'Costa'][$i] }}</h5>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full cursor-pointer hover:bg-green-200 transition-colors"
                                                          @click.stop="scrollToSection('section-zone-cost')">${{ [8000, 12000][$i] }}</span>
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full cursor-pointer hover:bg-blue-200 transition-colors"
                                                          @click.stop="scrollToSection('section-zone-time')">3-5 días</span>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors cursor-pointer"
                                                        @click.stop="scrollToSection('section-button-edit-zone')">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </button>
                                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                                        @click.stop="scrollToSection('section-button-delete-zone')">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach([['Bogotá', 'Medellín'], ['Barranquilla', 'Cartagena']][$i] as $city)
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded cursor-pointer hover:bg-gray-200 transition-colors"
                                                  @click.stop="scrollToSection('section-zone-cities')">{{ $city }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                            </div>

                            {{-- Configuración de Ciudades No Listadas --}}
                            <div class="border-t border-gray-200 pt-6 mt-6">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-unlisted-toggle')">
                                            <input type="checkbox" class="w-5 h-5 text-yellow-600 rounded">
                                            <span class="text-sm font-medium text-gray-800">Permitir pedidos de ciudades no listadas</span>
                                        </label>
                                    </div>
                                    
                                    <div class="ml-7 space-y-3" style="display: none;">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                   @click="scrollToSection('section-unlisted-cost')">
                                                Costo por defecto
                                            </label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                                <input type="number" 
                                                       value="12000"
                                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                       @click="scrollToSection('section-unlisted-cost')"
                                                       readonly>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                   @click="scrollToSection('section-unlisted-message')">
                                                Mensaje para el cliente
                                            </label>
                                            <input type="text" 
                                                   value="Contacta para confirmar disponibilidad"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-unlisted-message')"
                                                   readonly>
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
                                <p class="text-sm text-gray-700"><strong>Organiza por tarifas similares:</strong> Agrupa ciudades con costos de envío similares en la misma zona</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Nombres descriptivos:</strong> Usa nombres claros para tus zonas (ejemplo: "Costa", "Interior", "Ciudades Principales")</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Considera distancias:</strong> Agrupa ciudades que estén geográficamente cerca para facilitar la logística</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa costos reales:</strong> Asegúrate de que los costos de envío cubran tus gastos reales</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Límites según tu plan:</strong> Plan Explorer: 2 zonas, Plan Master: 3 zonas, Plan Legend: 4 zonas</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Máximo 20 ciudades por zona</strong> y no puedes duplicar ciudades entre zonas</p>
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
                        text: 'Muestra un ícono de cohete en un fondo azul. Identifica visualmente la sección de envío nacional.'
                    },
                    'section-card-title': {
                        title: 'Título "Envío Nacional"',
                        text: 'Muestra el nombre de la opción de envío. Es el título principal de esta sección.'
                    },
                    'section-zone-counter': {
                        title: 'Contador de Zonas',
                        text: 'Muestra cuántas zonas has configurado y el límite según tu plan (ejemplo: "2/4 zonas configuradas"). Te ayuda a saber cuántas zonas más puedes crear.'
                    },
                    'section-card-description': {
                        title: 'Descripción',
                        text: 'Texto que dice "Configura zonas con diferentes tarifas". Explica brevemente qué es esta opción.'
                    },
                    'section-toggle': {
                        title: 'Interruptor Habilitado/Deshabilitado',
                        text: 'Este interruptor activa o desactiva la opción de envío nacional. Cuando está activado, aparece el texto "Habilitado" en gris. Cuando está desactivado, aparece el texto "Deshabilitado" en gris. Solo cuando está activado, se muestran todas las opciones de configuración debajo.'
                    },
                    'section-free-shipping-toggle': {
                        title: 'Interruptor "Activar envío gratis nacional por monto"',
                        text: 'Este interruptor te permite ofrecer envío gratis a nivel nacional cuando el pedido supera cierto monto. Cuando lo activas, aparece un campo adicional para definir el monto mínimo.'
                    },
                    'section-free-shipping-amount': {
                        title: 'Campo "Envío gratis desde"',
                        text: 'Aquí defines el monto mínimo para que el envío nacional sea gratis. Ejemplo: Si escribes 100000, los pedidos de $100.000 o más tendrán envío gratis a nivel nacional. El campo tiene un símbolo de peso ($) al inicio. Puedes escribir números enteros (ejemplo: 100000, 150000).'
                    },
                    'section-general-instructions': {
                        title: 'Campo "Instrucciones generales para envío nacional"',
                        text: 'Aquí puedes escribir información general sobre tus envíos nacionales. Ejemplos: Empresas de mensajería que utilizas, tiempos estimados generales, políticas de envío, información de contacto para consultas. Este texto aparecerá cuando el cliente seleccione envío nacional. No hay límite de caracteres visible, pero se recomienda ser conciso.'
                    },
                    'section-zones': {
                        title: 'Sección: Zonas de Envío',
                        text: 'Aquí puedes crear diferentes zonas con diferentes tarifas. Cada zona puede incluir múltiples ciudades con el mismo costo de envío. Es la sección principal para gestionar tus zonas de envío nacional.'
                    },
                    'section-button-add-zone': {
                        title: 'Botón "Agregar Zona"',
                        text: 'Este botón te permite crear una nueva zona de envío. Se desactiva automáticamente cuando alcanzas el límite de zonas según tu plan. Al hacer clic, aparece un formulario para crear la nueva zona.'
                    },
                    'section-zone-item': {
                        title: 'Tarjeta de Zona Configurada',
                        text: 'Cada zona configurada muestra: Nombre de la zona (en negrita), Badge de costo (muestra el precio del envío en verde), Badge de tiempo (muestra el tiempo de entrega en azul), Ciudades incluidas (muestra todas las ciudades de la zona como etiquetas grises), Botón Editar (ícono de lápiz azul), Botón Eliminar (ícono de basurero rojo).'
                    },
                    'section-zone-cost': {
                        title: 'Badge de Costo',
                        text: 'Muestra el precio del envío para esta zona en color verde (ejemplo: "$8.000"). Este es el costo que pagará el cliente si su ciudad está en esta zona.'
                    },
                    'section-zone-time': {
                        title: 'Badge de Tiempo',
                        text: 'Muestra el tiempo de entrega para esta zona en color azul (ejemplo: "3-5 días"). Indica cuánto tiempo tardará el envío a las ciudades de esta zona.'
                    },
                    'section-zone-cities': {
                        title: 'Ciudades Incluidas',
                        text: 'Muestra todas las ciudades de la zona como etiquetas grises. Cada ciudad aparece como un badge pequeño. Una ciudad no puede estar en dos zonas diferentes.'
                    },
                    'section-button-edit-zone': {
                        title: 'Botón Editar Zona',
                        text: 'Botón con ícono de lápiz azul que te permite modificar la zona. Al hacer clic, la zona entra en modo de edición donde puedes cambiar: nombre, costo, tiempo de entrega, y agregar o eliminar ciudades.'
                    },
                    'section-button-delete-zone': {
                        title: 'Botón Eliminar Zona',
                        text: 'Botón con ícono de basurero rojo que te permite eliminar la zona. Al hacer clic, aparece un mensaje pidiendo confirmación. Si tu tienda tiene protección con clave maestra, primero te pedirá la clave maestra. La eliminación es permanente.'
                    },
                    'section-unlisted-toggle': {
                        title: 'Interruptor "Permitir pedidos de ciudades no listadas"',
                        text: 'Este interruptor te permite aceptar pedidos de ciudades que no has incluido en ninguna zona. Cuando lo activas, aparecen dos campos adicionales: costo por defecto y mensaje para el cliente.'
                    },
                    'section-unlisted-cost': {
                        title: 'Campo "Costo por defecto"',
                        text: 'Aquí defines el costo de envío para ciudades que no están en ninguna zona. Ejemplo: Si escribes 12000, los pedidos de ciudades no listadas costarán $12.000 de envío. El campo tiene un símbolo de peso ($) al inicio. Puedes escribir números enteros.'
                    },
                    'section-unlisted-message': {
                        title: 'Campo "Mensaje para el cliente"',
                        text: 'Aquí puedes escribir un mensaje que verá el cliente si su ciudad no está en ninguna zona. Ejemplo: "Contacta para confirmar disponibilidad". Este mensaje aparecerá en el proceso de compra cuando el cliente seleccione una ciudad no listada.'
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
