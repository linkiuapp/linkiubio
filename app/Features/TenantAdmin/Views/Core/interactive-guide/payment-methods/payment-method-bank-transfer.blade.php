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
                        {{-- Tarjeta de Transferencia Bancaria --}}
                        <div class="border-2 border-blue-500 rounded-lg p-6 shadow-md">
                            {{-- Encabezado --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center cursor-pointer hover:bg-blue-200 transition-colors"
                                         @click="scrollToSection('section-card-header')">
                                        <i data-lucide="building-2" class="w-6 h-6 text-blue-600"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-card-title')">Transferencia Bancaria</h3>
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full cursor-pointer hover:bg-blue-200 transition-colors"
                                                  @click="scrollToSection('section-badge-principal')">
                                                <i data-lucide="star" class="w-3 h-3 inline"></i> Principal
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-card-description')">Transferencia a cuentas bancarias</p>
                                    </div>
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

                            {{-- Badges de Disponibilidad --}}
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs rounded-full cursor-pointer hover:bg-blue-200 transition-colors"
                                      @click="scrollToSection('section-badge-recogida')">Recogida</span>
                                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs rounded-full cursor-pointer hover:bg-blue-200 transition-colors"
                                      @click="scrollToSection('section-badge-entrega')">Entrega</span>
                                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full cursor-pointer hover:bg-yellow-200 transition-colors"
                                      @click="scrollToSection('section-badge-comprobante')">Comprobante obligatorio</span>
                            </div>

                            {{-- Información de Cuentas Bancarias --}}
                            <div class="bg-gray-50 rounded-lg p-4 mb-4 cursor-pointer hover:bg-gray-100 transition-colors"
                                 @click="scrollToSection('section-accounts-info')">
                                <p class="text-sm font-medium text-gray-700 mb-2">2 cuenta(s) configurada(s)</p>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Bancolombia</span>
                                        <span class="text-gray-500">****1234</span>
                                    </div>
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600">Davivienda</span>
                                        <span class="text-gray-500">****5678</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Botones de Acción --}}
                            <div class="flex gap-2">
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors cursor-pointer"
                                        @click="scrollToSection('section-button-configure')">
                                    Configurar
                                </button>
                                <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                        @click="scrollToSection('section-button-accounts')">
                                    Cuentas
                                </button>
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
                                <p class="text-sm text-gray-700"><strong>Agrega todas las cuentas bancarias</strong> que uses para recibir pagos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Activa "Requerir comprobante de pago"</strong> para mayor seguridad y control</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Establece este método como principal</strong> si es el más usado por tus clientes</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Verifica que los datos de las cuentas</strong> bancarias sean correctos antes de activar el método</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Debes agregar al menos una cuenta bancaria</strong> para que los clientes puedan realizar transferencias</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Puedes tener múltiples cuentas bancarias</strong> para dar más opciones a tus clientes</p>
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
                        text: 'Muestra un ícono de banco en un fondo azul cuando está activado, o gris cuando está desactivado. Identifica visualmente el método de pago.'
                    },
                    'section-card-title': {
                        title: 'Título "Transferencia Bancaria"',
                        text: 'Muestra el nombre del método de pago. Es el título principal de esta tarjeta.'
                    },
                    'section-card-description': {
                        title: 'Descripción',
                        text: 'Texto que dice "Transferencia a cuentas bancarias". Explica brevemente qué es este método de pago.'
                    },
                    'section-badge-principal': {
                        title: 'Badge "Principal"',
                        text: 'Si este método es el predeterminado, aparece una estrella azul con el texto "Principal". El método principal es el que aparece seleccionado por defecto cuando el cliente hace un pedido. Solo un método puede ser principal a la vez.'
                    },
                    'section-toggle': {
                        title: 'Interruptor Habilitado/Deshabilitado',
                        text: 'Este interruptor activa o desactiva el método de pago de transferencia bancaria. Cuando está activado, el borde de la tarjeta se vuelve azul y aparece una sombra. Cuando está desactivado, el borde es gris y no hay sombra. Solo cuando está activado, se muestran las opciones de configuración y los botones.'
                    },
                    'section-badge-recogida': {
                        title: 'Badge "Recogida"',
                        text: 'Muestra si este método está disponible para pedidos que se recogen en tienda. Fondo azul con texto azul = Disponible. Fondo gris con texto gris = No disponible.'
                    },
                    'section-badge-entrega': {
                        title: 'Badge "Entrega"',
                        text: 'Muestra si este método está disponible para pedidos con envío a domicilio. Fondo azul con texto azul = Disponible. Fondo gris con texto gris = No disponible.'
                    },
                    'section-badge-comprobante': {
                        title: 'Badge "Comprobante obligatorio"',
                        text: 'Aparece si has configurado que el cliente debe subir un comprobante de pago. Fondo amarillo con texto amarillo. Solo aparece si está activada la opción de requerir comprobante.'
                    },
                    'section-accounts-info': {
                        title: 'Información de Cuentas Bancarias',
                        text: 'Muestra cuántas cuentas bancarias has configurado (ejemplo: "2 cuenta(s) configurada(s)"). Lista las primeras 2 cuentas con: Nombre del banco (ejemplo: "Bancolombia"), Últimos 4 dígitos de la cuenta (ejemplo: "****1234"). Si tienes más de 2 cuentas, muestra un texto adicional (ejemplo: "+1 más").'
                    },
                    'section-button-configure': {
                        title: 'Botón "Configurar"',
                        text: 'Te permite abrir un modal para configurar las opciones del método. Opciones disponibles: Disponible para recogida (activar/desactivar), Disponible para entrega (activar/desactivar), Requerir comprobante de pago (activar/desactivar).'
                    },
                    'section-button-accounts': {
                        title: 'Botón "Cuentas"',
                        text: 'Te lleva a la página de gestión de cuentas bancarias. Desde allí puedes agregar, editar o eliminar cuentas bancarias. Solo funciona si el método está activado.'
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
