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
                                        @click="scrollToSection('section-header-title')">Detalles del Slider</h1>
                                    <p class="text-sm text-gray-600 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-header-subtitle')">Visualiza la configuración actual del slider</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                        @click="scrollToSection('section-button-edit')">
                                    Editar
                                </button>
                                <button class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors text-sm cursor-pointer"
                                        @click="scrollToSection('section-button-deactivate')">
                                    Desactivar
                                </button>
                            </div>
                        </div>

                        {{-- Alerta de Estado --}}
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 cursor-pointer hover:bg-yellow-100 transition-colors"
                             @click="scrollToSection('section-alert-inactive')"
                             style="display: none;">
                            <p class="text-sm text-yellow-800">
                                Este slider está <strong>desactivado</strong> y no se mostrará en tu tienda.
                            </p>
                        </div>

                        {{-- Alerta de Programación --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 cursor-pointer hover:bg-blue-100 transition-colors"
                             @click="scrollToSection('section-alert-scheduling')">
                            <p class="text-sm text-blue-800">
                                Este slider cuenta con <strong>programación activa</strong>.
                            </p>
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
                                             @click="scrollToSection('section-info-name')">
                                            <span class="text-xs font-medium text-gray-500">Nombre:</span>
                                            <p class="text-sm font-semibold text-gray-900 mt-0.5">Promoción Navidad 2024</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-order')">
                                            <span class="text-xs font-medium text-gray-500">Orden:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">#1</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-status')">
                                            <span class="text-xs font-medium text-gray-500">Estado:</span>
                                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full mt-0.5 inline-block">Activo</span>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-description')">
                                            <span class="text-xs font-medium text-gray-500">Descripción:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Descuentos especiales en toda la tienda</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Configuración de Enlace --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-link-config')">Configuración de Enlace</h3>
                                    
                                    <div class="space-y-3 cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-link-type')">
                                        <span class="text-xs font-medium text-gray-500">Tipo:</span>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">Enlace interno</span>
                                    </div>
                                    <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-link-url')">
                                        <span class="text-xs font-medium text-gray-500">URL:</span>
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 hover:underline mt-0.5 inline-flex items-center gap-1">
                                            https://mitienda.com/categoria/ropa
                                            <i data-lucide="external-link" class="w-3 h-3"></i>
                                        </a>
                                    </div>
                                </div>

                                {{-- Programación --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-scheduling')">Programación</h3>
                                    
                                    <div class="space-y-3">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-scheduling-status')">
                                            <span class="text-xs font-medium text-gray-500">Estado:</span>
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Programado</span>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-scheduling-type')">
                                            <span class="text-xs font-medium text-gray-500">Tipo:</span>
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Con fecha fin</span>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-scheduling-start-date')">
                                            <span class="text-xs font-medium text-gray-500">Fecha inicio:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">01/01/2025</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-scheduling-end-date')">
                                            <span class="text-xs font-medium text-gray-500">Fecha fin:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">31/01/2025</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-scheduling-start-time')">
                                            <span class="text-xs font-medium text-gray-500">Hora inicio:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">09:00</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-scheduling-end-time')">
                                            <span class="text-xs font-medium text-gray-500">Hora fin:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">18:00</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-scheduling-days')">
                                            <span class="text-xs font-medium text-gray-500">Días activos:</span>
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                @php
                                                    $activeDays = ['L', 'M', 'X', 'J', 'V'];
                                                @endphp
                                                @foreach($activeDays as $day)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">{{ $day }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Columna Lateral (Derecha) --}}
                            <div class="space-y-6">
                                {{-- Imagen del Slider --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-image')">Imagen del Slider</h3>
                                    
                                    <div class="relative cursor-pointer hover:opacity-90 transition-opacity"
                                         @click="scrollToSection('section-image-preview')">
                                        <div class="w-full aspect-[420/200] bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                            <i data-lucide="image" class="w-16 h-16 text-gray-400"></i>
                                        </div>
                                        <div class="absolute bottom-2 right-2 px-2 py-1 bg-gray-900 bg-opacity-75 text-white text-xs rounded">
                                            420x200px
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
                                <p class="text-sm text-gray-700"><strong>Revisa el estado</strong> antes de publicar para asegurarte de que se muestre correctamente</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Verifica que el enlace funcione</strong> correctamente haciendo clic en él</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa la programación</strong> para saber cuándo se mostrará el slider</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>La imagen te permite</strong> verificar que se ve bien antes de publicar</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si el slider está inactivo</strong>, no se mostrará en la tienda aunque tenga programación</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa esta vista</strong> para verificar toda la configuración antes de hacer cambios</p>
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
                        text: 'Te regresa al listado de sliders.'
                    },
                    'section-header-title': {
                        title: 'Título "Detalles del Slider"',
                        text: 'Muestra que estás viendo la información detallada de un slider.'
                    },
                    'section-header-subtitle': {
                        title: 'Subtítulo',
                        text: 'Muestra: "Visualiza la configuración actual del slider". Te indica que puedes ver toda la configuración del slider en esta vista.'
                    },
                    'section-button-edit': {
                        title: 'Botón "Editar"',
                        text: 'Te lleva a la página de edición del slider donde puedes modificar toda su configuración.'
                    },
                    'section-button-deactivate': {
                        title: 'Botón "Desactivar" o "Activar"',
                        text: 'Si el slider está activo, aparece el botón "Desactivar" (amarillo) para desactivarlo. Si el slider está inactivo, aparece el botón "Activar" (verde) para activarlo. El estado cambia automáticamente al hacer clic. Muestra "Procesando…" mientras se actualiza el estado. Aparecerá un mensaje de confirmación.'
                    },
                    'section-alert-inactive': {
                        title: 'Alerta de estado inactivo',
                        text: 'Si el slider está desactivado, aparece una alerta amarilla de advertencia. Mensaje: "Este slider está desactivado y no se mostrará en tu tienda." Te indica que el slider no se mostrará aunque tenga programación.'
                    },
                    'section-alert-scheduling': {
                        title: 'Alerta de programación activa',
                        text: 'Si el slider tiene programación, aparece una alerta azul informativa. Mensaje: "Este slider cuenta con programación activa." Te indica que el slider tiene restricciones de fecha/horario configuradas.'
                    },
                    'section-general': {
                        title: 'Tarjeta "Información General"',
                        text: 'Muestra la información básica del slider: nombre, orden, estado y descripción.'
                    },
                    'section-info-name': {
                        title: 'Nombre',
                        text: 'Muestra el nombre completo del slider. Ejemplo: "Promoción Navidad 2024".'
                    },
                    'section-info-order': {
                        title: 'Orden',
                        text: 'Muestra el número de orden del slider (ejemplo: #1, #2). Indica en qué posición aparece el slider cuando hay múltiples sliders activos.'
                    },
                    'section-info-status': {
                        title: 'Estado',
                        text: 'Badge que muestra si está "Activo" (verde) o "Inactivo" (rojo). Indica si el slider se está mostrando actualmente en la tienda.'
                    },
                    'section-info-description': {
                        title: 'Descripción',
                        text: 'Muestra la descripción del slider si está configurada. Esta descripción es solo para referencia interna, no aparece en la tienda.'
                    },
                    'section-link-config': {
                        title: 'Tarjeta "Configuración de enlace"',
                        text: 'Muestra la configuración del enlace del slider: tipo de enlace y URL.'
                    },
                    'section-link-type': {
                        title: 'Tipo de enlace',
                        text: 'Badge que muestra el tipo de enlace: "Enlace interno" (azul) - Lleva a una página dentro de tu tienda, "Enlace externo" (azul claro) - Lleva a una página fuera de tu tienda, "Sin enlace" (gris) - No tiene enlace configurado.'
                    },
                    'section-link-url': {
                        title: 'URL',
                        text: 'Si tiene enlace, muestra la URL completa. Si es interno, muestra la URL completa de tu tienda. Si es externo, muestra la URL externa. El enlace es clicable y se abre en una nueva pestaña. Tiene un ícono de enlace externo. Puedes hacer clic para verificar que funciona correctamente.'
                    },
                    'section-scheduling': {
                        title: 'Tarjeta "Programación"',
                        text: 'Muestra toda la configuración de programación del slider: estado, tipo, fechas, horarios y días activos.'
                    },
                    'section-scheduling-status': {
                        title: 'Estado de programación',
                        text: 'Badge que muestra: "Programado" (amarillo) - Si tiene programación configurada, "Siempre activo" (verde) - Si no tiene programación.'
                    },
                    'section-scheduling-type': {
                        title: 'Tipo de programación',
                        text: 'Si está programado, muestra: "Permanente" (verde) - Si no tiene fecha de fin, "Con fecha fin" (amarillo) - Si tiene fecha de fin configurada.'
                    },
                    'section-scheduling-start-date': {
                        title: 'Fecha inicio',
                        text: 'Si está configurada, muestra la fecha de inicio. Indica desde cuándo comenzará a mostrarse el slider.'
                    },
                    'section-scheduling-end-date': {
                        title: 'Fecha fin',
                        text: 'Si está configurada, muestra la fecha de fin. Indica hasta cuándo se mostrará el slider.'
                    },
                    'section-scheduling-start-time': {
                        title: 'Hora inicio',
                        text: 'Si está configurada, muestra la hora de inicio. Indica desde qué hora del día comenzará a mostrarse el slider.'
                    },
                    'section-scheduling-end-time': {
                        title: 'Hora fin',
                        text: 'Si está configurada, muestra la hora de fin. Indica hasta qué hora del día se mostrará el slider.'
                    },
                    'section-scheduling-days': {
                        title: 'Días activos',
                        text: 'Si hay días configurados, muestra badges con las iniciales: L (Lunes), M (Martes), X (Miércoles), J (Jueves), V (Viernes), S (Sábado), D (Domingo). Indica en qué días de la semana el slider será válido.'
                    },
                    'section-image': {
                        title: 'Tarjeta "Imagen del slider"',
                        text: 'Muestra la imagen completa del slider con sus dimensiones.'
                    },
                    'section-image-preview': {
                        title: 'Vista previa de la imagen',
                        text: 'Muestra la imagen completa del slider. Badge de dimensiones: Muestra "420x200px" en la esquina inferior derecha. Si no hay imagen, muestra un estado vacío con el mensaje "Sin imagen". Te permite verificar cómo se verá en la tienda.'
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
