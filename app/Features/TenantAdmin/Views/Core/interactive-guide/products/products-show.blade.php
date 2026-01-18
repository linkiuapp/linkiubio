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
                                <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                     @click="scrollToSection('section-header-name')">
                                    <h1 class="text-lg font-semibold text-gray-900">Camiseta Básica Blanca</h1>
                                    <p class="text-xs font-mono text-gray-500 mt-1">SKU: CAM-BAS-001</p>
                                </div>
                            </div>
                            <button class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors text-sm cursor-pointer"
                                    @click="scrollToSection('section-header-edit')">
                                <i data-lucide="edit" class="w-4 h-4 inline"></i>
                                Editar
                            </button>
                        </div>

                        {{-- Layout de dos columnas --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            {{-- Columna Principal (Izquierda) --}}
                            <div class="lg:col-span-2 space-y-6">
                                {{-- Información del Producto --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-info-card')">Información del Producto</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-name')">
                                            <span class="text-xs font-medium text-gray-500">Nombre:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Camiseta Básica Blanca</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-sku')">
                                            <span class="text-xs font-medium text-gray-500">SKU:</span>
                                            <p class="text-sm font-mono text-gray-900 mt-0.5">CAM-BAS-001</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-description')">
                                            <span class="text-xs font-medium text-gray-500">Descripción:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Camiseta básica de algodón 100%, perfecta para uso diario.</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-price')">
                                            <span class="text-xs font-medium text-gray-500">Precio:</span>
                                            <p class="text-2xl font-bold text-blue-600 mt-0.5">$15.000</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-type')">
                                            <span class="text-xs font-medium text-gray-500">Tipo:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Producto Simple</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-stock')">
                                            <span class="text-xs font-medium text-gray-500">Stock:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Ilimitado</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-categories')">
                                            <span class="text-xs font-medium text-gray-500">Categorías:</span>
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Ropa</span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Básicos</span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 pt-2 border-t border-gray-200">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 cursor-pointer hover:bg-green-200 transition-colors"
                                                  @click="scrollToSection('section-info-status')">Activo</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 cursor-pointer hover:bg-blue-200 transition-colors"
                                                  @click="scrollToSection('section-info-type-badge')">Simple</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Imágenes --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-images-card')">Imágenes</h3>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @for($i = 0; $i < 4; $i++)
                                        <div class="relative group cursor-pointer hover:opacity-80 transition-opacity"
                                             @click="scrollToSection('section-image-item')">
                                            <div class="w-full h-32 bg-gray-200 rounded-lg"></div>
                                            @if($i === 0)
                                            <span class="absolute top-2 left-2 px-2 py-0.5 bg-blue-600 text-white text-xs rounded cursor-pointer"
                                                  @click="scrollToSection('section-image-main')">Principal</span>
                                            @endif
                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/20 rounded-lg">
                                                <i data-lucide="eye" class="w-6 h-6 text-white"></i>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            {{-- Columna Lateral (Derecha) --}}
                            <div class="space-y-6">
                                {{-- Acciones --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-actions-card')">Acciones</h3>
                                    
                                    <div class="space-y-3">
                                        <button class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-action-edit')">
                                            <i data-lucide="edit" class="w-4 h-4 inline"></i>
                                            Editar Producto
                                        </button>
                                        <button class="w-full px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-action-toggle')">
                                            Desactivar
                                        </button>
                                        <button class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-action-delete')">
                                            <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>

                                {{-- Variables (condicional) --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-variables-card')">Variables del Producto</h3>
                                    
                                    <div class="space-y-3">
                                        @for($i = 0; $i < 2; $i++)
                                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all"
                                             @click="scrollToSection('section-variable-item')">
                                            <div class="w-8 h-8 bg-gray-200 rounded-lg"></div>
                                            <div class="flex-1">
                                                <div class="h-3 bg-gray-300 rounded w-20 mb-1"></div>
                                                <div class="h-2 bg-gray-200 rounded w-16"></div>
                                            </div>
                                        </div>
                                        @endfor
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
                                <p class="text-sm text-gray-700"><strong>Revisa toda la información:</strong> Asegúrate de que todos los datos estén correctos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa el botón Editar:</strong> Para modificar cualquier información del producto</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa las imágenes:</strong> Haz clic en cada imagen para verla en tamaño completo</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa el stock:</strong> Verifica que el stock esté correcto antes de activar el producto</p>
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
                        text: 'Este botón te lleva de vuelta a la lista de todos los productos.'
                    },
                    'section-header-name': {
                        title: 'Nombre del Producto y SKU',
                        text: 'Muestra el nombre completo del producto en texto grande. Si el producto tiene SKU, aparece debajo del nombre en texto pequeño y con fuente monoespaciada.'
                    },
                    'section-header-edit': {
                        title: 'Botón "Editar"',
                        text: 'En el lado derecho hay un botón "Editar" que te lleva a la pantalla de edición donde puedes modificar todos los datos del producto.'
                    },
                    'section-info-card': {
                        title: 'Tarjeta "Información del Producto"',
                        text: 'Esta tarjeta muestra todos los datos principales del producto.'
                    },
                    'section-info-name': {
                        title: 'Nombre',
                        text: 'El nombre completo del producto.'
                    },
                    'section-info-sku': {
                        title: 'SKU',
                        text: 'El código SKU del producto (solo aparece si tiene).'
                    },
                    'section-info-description': {
                        title: 'Descripción',
                        text: 'La descripción completa del producto. Si no tiene descripción, este campo no aparece.'
                    },
                    'section-info-price': {
                        title: 'Precio',
                        text: 'El precio del producto en formato de moneda, mostrado en color azul y texto grande.'
                    },
                    'section-info-type': {
                        title: 'Tipo',
                        text: 'Muestra si es "Producto Simple" o "Producto Variable".'
                    },
                    'section-info-stock': {
                        title: 'Gestión de Stock',
                        text: 'Solo aparece si el producto controla stock. Muestra: Tipo de inventario (Ilimitado o Limitado), Stock disponible (la cantidad actual con colores: rojo si está agotado, amarillo si está bajo, verde si está normal), Umbral de alerta (la cantidad mínima antes de recibir alertas), Stock por variantes (si es producto variable, muestra el stock total y cuántas variantes tiene).'
                    },
                    'section-info-categories': {
                        title: 'Categorías',
                        text: 'Muestra todas las categorías asignadas al producto como badges azules. Si no tiene categorías, este campo no aparece.'
                    },
                    'section-info-status': {
                        title: 'Badge de Estado',
                        text: 'Verde "Activo" o Rojo "Inactivo".'
                    },
                    'section-info-type-badge': {
                        title: 'Badge de Tipo',
                        text: 'Azul "Simple" o Amarillo "Variable".'
                    },
                    'section-images-card': {
                        title: 'Tarjeta "Imágenes"',
                        text: 'Esta tarjeta solo aparece si el producto tiene imágenes. Muestra todas las imágenes del producto en un grid.'
                    },
                    'section-image-item': {
                        title: 'Imagen del Producto',
                        text: 'Cada imagen es clickeable para verla en tamaño completo. Al pasar el mouse sobre una imagen, aparece un icono de ojo indicando que puedes hacer clic para ampliarla.'
                    },
                    'section-image-main': {
                        title: 'Badge "Principal"',
                        text: 'La imagen principal tiene un badge azul que dice "Principal". Esta es la imagen que se muestra primero en la tienda.'
                    },
                    'section-actions-card': {
                        title: 'Tarjeta "Acciones"',
                        text: 'Esta tarjeta contiene botones para realizar acciones rápidas sobre el producto.'
                    },
                    'section-action-edit': {
                        title: 'Botón "Editar Producto"',
                        text: 'Este botón te lleva a la pantalla de edición donde puedes modificar todos los datos del producto.'
                    },
                    'section-action-toggle': {
                        title: 'Botón "Desactivar" o "Activar"',
                        text: 'Este botón cambia según el estado actual: Si está activo, muestra "Desactivar" (botón amarillo). Si está inactivo, muestra "Activar" (botón verde). Al hacer clic, aparece un modal de confirmación antes de cambiar el estado.'
                    },
                    'section-action-delete': {
                        title: 'Botón "Eliminar"',
                        text: 'Este botón (rojo) te permite eliminar el producto. Al hacer clic: Si tu tienda tiene protección con clave maestra, primero te pedirá la clave maestra. Luego aparece un modal de confirmación. Después de confirmar, el producto se elimina permanentemente.'
                    },
                    'section-variables-card': {
                        title: 'Tarjeta "Variables del Producto"',
                        text: 'Esta tarjeta solo aparece si el producto es tipo "Variable" y tiene variables asignadas. Muestra todas las variables del producto.'
                    },
                    'section-variable-item': {
                        title: 'Variable del Producto',
                        text: 'Para cada variable muestra: Icono que representa el tipo de variable, nombre de la variable (o nombre personalizado si tiene), cantidad de opciones disponibles, badges que muestran el tipo y estado de la variable.'
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
