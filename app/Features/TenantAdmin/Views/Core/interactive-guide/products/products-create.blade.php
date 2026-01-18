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
                                <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                    @click="scrollToSection('section-header-title')">Nuevo Producto</h1>
                            </div>
                            <div class="px-3 py-1.5 bg-gray-100 rounded-lg text-sm cursor-pointer hover:bg-gray-200 transition-colors"
                                 @click="scrollToSection('section-header-counter')">
                                15/50 productos
                            </div>
                        </div>

                        {{-- Alerta Informativa --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 cursor-pointer hover:bg-blue-100 transition-colors"
                             @click="scrollToSection('section-alert')">
                            <p class="text-sm text-blue-800">
                                Estás usando <strong>15 de 50</strong> productos disponibles en tu plan Básico.
                            </p>
                        </div>

                        {{-- Información Básica --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-basic-info')">Información Básica</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-name')">
                                        Nombre del Producto <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           placeholder="Ej: Camiseta Básica Blanca"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-name')"
                                           readonly>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-sku')">
                                            SKU (Código)
                                        </label>
                                        <input type="text" 
                                               placeholder="Ej: CAM-BAS-001"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-sku')"
                                               readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-price')">
                                            Precio <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                            <input type="number" 
                                                   placeholder="15000.00"
                                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-field-price')"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-description')">
                                        Descripción
                                    </label>
                                    <textarea rows="4" 
                                              placeholder="Describe las características principales del producto..."
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                              @click="scrollToSection('section-field-description')"
                                              readonly></textarea>
                                    <button class="mt-2 px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-sm hover:bg-blue-200 transition-colors cursor-pointer"
                                            @click="scrollToSection('section-button-kiubot')">
                                        Mejorar con KiuBot
                                    </button>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-type')">
                                        Tipo de Producto <span class="text-red-500">*</span>
                                    </label>
                                    <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                         @click="scrollToSection('section-field-type')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        Selecciona un tipo
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-active')">
                                        Producto activo
                                    </label>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-field-active')">
                                        <input type="checkbox" class="peer sr-only" checked>
                                        <span class="absolute inset-0 bg-blue-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1">El producto se puede ver en tu tienda</p>
                                </div>
                            </div>
                        </div>

                        {{-- Precio Promocional --}}
                        <div class="border-t border-gray-200 pt-6">
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                <label class="flex items-center gap-3 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-promo-toggle')">
                                    <input type="checkbox" class="w-5 h-5 text-orange-600 rounded">
                                    <span class="text-sm font-medium text-gray-800">Precio Promocional</span>
                                </label>
                                <div class="mt-4 space-y-3" style="display: none;">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-promo-price')">
                                            Precio Oferta
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                            <input type="number" 
                                                   placeholder="12000.00"
                                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-promo-price')"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                   @click="scrollToSection('section-promo-start')">
                                                Fecha Inicio
                                            </label>
                                            <input type="date" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-promo-start')"
                                                   readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                   @click="scrollToSection('section-promo-end')">
                                                Fecha Fin
                                            </label>
                                            <input type="date" 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-promo-end')"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Gestión de Inventario --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-inventory')">Gestión de Inventario</h3>
                            
                            <div class="space-y-4">
                                <label class="flex items-center gap-3 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-inventory-control')">
                                    <input type="checkbox" class="w-5 h-5 text-blue-600 rounded">
                                    <span class="text-sm font-medium text-gray-800">Controlar inventario de este producto</span>
                                </label>
                                
                                <div class="ml-8 space-y-3" style="display: none;">
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-inventory-unlimited')">
                                            <input type="radio" name="inventory-type" class="w-4 h-4 text-blue-600" checked>
                                            <span class="text-sm text-gray-700">Ilimitado</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-inventory-limited')">
                                            <input type="radio" name="inventory-type" class="w-4 h-4 text-blue-600">
                                            <span class="text-sm text-gray-700">Limitado</span>
                                        </label>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                   @click="scrollToSection('section-inventory-quantity')">
                                                Cantidad en stock
                                            </label>
                                            <input type="number" 
                                                   placeholder="100"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-inventory-quantity')"
                                                   readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                   @click="scrollToSection('section-inventory-threshold')">
                                                Alerta de stock bajo
                                            </label>
                                            <input type="number" 
                                                   placeholder="10"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-inventory-threshold')"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Producto Bajo Pedido --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-made-to-order')">Producto Bajo Pedido</h3>
                            
                            <div class="space-y-4">
                                <label class="flex items-center gap-3 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-mto-checkbox')">
                                    <input type="checkbox" class="w-5 h-5 text-blue-600 rounded">
                                    <span class="text-sm font-medium text-gray-800">Este producto se fabrica/prepara bajo pedido</span>
                                </label>
                                
                                <div class="ml-8 space-y-3" style="display: none;">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-mto-days')">
                                            Días de preparación
                                        </label>
                                        <input type="number" 
                                               placeholder="7"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-mto-days')"
                                               readonly>
                                    </div>
                                    
                                    <label class="flex items-center gap-3 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-mto-deposit')">
                                        <input type="checkbox" class="w-5 h-5 text-blue-600 rounded">
                                        <span class="text-sm font-medium text-gray-800">Requiere anticipo</span>
                                    </label>
                                    
                                    <div class="ml-8 space-y-3" style="display: none;">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                   @click="scrollToSection('section-mto-deposit-type')">
                                                Tipo de anticipo
                                            </label>
                                            <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                                 @click="scrollToSection('section-mto-deposit-type')"
                                                 style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                                Porcentaje del precio
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                   @click="scrollToSection('section-mto-deposit-value')">
                                                Valor del anticipo
                                            </label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">%</span>
                                                <input type="number" 
                                                       placeholder="50"
                                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                       @click="scrollToSection('section-mto-deposit-value')"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Imágenes --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-images')">Imágenes del Producto</h3>
                            
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all"
                                 @click="scrollToSection('section-images-upload')">
                                <i data-lucide="upload" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                                <p class="text-sm text-gray-600 mb-1">Arrastra y suelta imágenes aquí</p>
                                <p class="text-xs text-gray-500">o haz clic para seleccionar</p>
                            </div>
                        </div>

                        {{-- Categorías --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-categories')">Categorías</h3>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @for($i = 0; $i < 6; $i++)
                                <label class="flex items-start gap-2 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all"
                                       @click="scrollToSection('section-category-item')">
                                    <input type="checkbox" class="mt-1 w-4 h-4 text-blue-600 rounded">
                                    <div class="flex-1">
                                        <div class="h-3 bg-gray-300 rounded w-20 mb-1"></div>
                                        <div class="h-2 bg-gray-200 rounded w-32"></div>
                                    </div>
                                </label>
                                @endfor
                            </div>
                        </div>

                        {{-- Variables (condicional) --}}
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                    @click="scrollToSection('section-variables')">Variables del Producto</h3>
                                <div class="flex gap-2">
                                    <button class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                            @click="scrollToSection('section-variables-select-all')">
                                        Seleccionar todas
                                    </button>
                                    <button class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                            @click="scrollToSection('section-variables-deselect-all')">
                                        Deseleccionar todas
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <input type="text" 
                                       placeholder="Buscar variables..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                       @click="scrollToSection('section-variables-search')"
                                       readonly>
                            </div>
                            
                            <div class="space-y-2">
                                @for($i = 0; $i < 3; $i++)
                                <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all"
                                     @click="scrollToSection('section-variable-item')">
                                    <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                                    <div class="w-8 h-8 bg-gray-200 rounded-lg"></div>
                                    <div class="flex-1">
                                        <div class="h-3 bg-gray-300 rounded w-24 mb-1"></div>
                                        <div class="h-2 bg-gray-200 rounded w-16"></div>
                                    </div>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                                        <span class="text-xs text-gray-600">Obligatorio</span>
                                    </label>
                                </div>
                                @endfor
                            </div>
                        </div>

                        {{-- Variaciones del Producto (condicional) --}}
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                    @click="scrollToSection('section-variations')">Variaciones del Producto</h3>
                                <div class="flex gap-2">
                                    <button class="px-3 py-1.5 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors cursor-pointer"
                                            @click="scrollToSection('section-variations-generate-all')">
                                        <i data-lucide="zap" class="w-4 h-4 inline"></i>
                                        Generar Todas las Combinaciones
                                    </button>
                                    <button class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                            @click="scrollToSection('section-variations-add')">
                                        <i data-lucide="plus" class="w-4 h-4 inline"></i>
                                        Agregar Variación
                                    </button>
                                </div>
                            </div>

                            {{-- Tarjeta de Variación (ejemplo) --}}
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 mb-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-sm font-semibold text-gray-800">Variación 1</h4>
                                    <button class="text-red-600 hover:text-red-700 transition-colors cursor-pointer"
                                            @click="scrollToSection('section-variation-delete')">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                                
                                <div class="space-y-4">
                                    {{-- Selects de Variables --}}
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-variation-selects')">
                                            <label class="block text-sm font-medium text-gray-800 mb-2">Talla</label>
                                            <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                                 style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                                M
                                            </div>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-variation-selects')">
                                            <label class="block text-sm font-medium text-gray-800 mb-2">Color</label>
                                            <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                                 style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                                Rojo
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Stock, Precio y SKU --}}
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-variation-stock')">
                                            <label class="block text-sm font-medium text-gray-800 mb-2">Stock</label>
                                            <input type="number" 
                                                   placeholder="50"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-variation-stock')"
                                                   readonly>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-variation-price')">
                                            <label class="block text-sm font-medium text-gray-800 mb-2">Precio Adicional</label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                                <input type="number" 
                                                       placeholder="0.00"
                                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                       @click="scrollToSection('section-variation-price')"
                                                       readonly>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-variation-sku')">
                                            <label class="block text-sm font-medium text-gray-800 mb-2">SKU (Opcional)</label>
                                            <input type="text" 
                                                   placeholder="CAM-M-ROJO"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-variation-sku')"
                                                   readonly>
                                        </div>
                                    </div>

                                    {{-- Vista Previa del Precio --}}
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 cursor-pointer hover:bg-blue-100 transition-colors"
                                         @click="scrollToSection('section-variation-price-preview')">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Precio base:</span>
                                            <span class="font-medium text-gray-900">$15.000</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm mt-1">
                                            <span class="text-gray-600">Precio adicional:</span>
                                            <span class="font-medium text-gray-900">$0</span>
                                        </div>
                                        <div class="flex items-center justify-between text-base font-bold mt-2 pt-2 border-t border-blue-300">
                                            <span class="text-gray-900">Precio final:</span>
                                            <span class="text-blue-600">$15.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                            <button type="button" 
                                    class="px-4 py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition-colors cursor-pointer"
                                    @click="scrollToSection('section-button-cancel')">
                                Cancelar
                            </button>
                            <button type="button" 
                                    class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                    @click="scrollToSection('section-button-create')">
                                Crear Producto
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
                                <p class="text-sm text-gray-700"><strong>Completa toda la información básica</strong> antes de avanzar a otras secciones</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Sube buenas imágenes</strong> - son muy importantes para vender</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa KiuBot</strong> para mejorar tu descripción si está disponible</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Configura el stock correctamente</strong> para evitar vender productos agotados</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Para productos variables</strong>, primero selecciona las variables, luego crea las variaciones</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa los precios</strong> de cada variación antes de guardar</p>
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
                        text: 'Este botón te lleva de vuelta a la lista de todos los productos sin guardar cambios.'
                    },
                    'section-header-title': {
                        title: 'Título "Nuevo Producto"',
                        text: 'Muestra que estás creando un producto nuevo.'
                    },
                    'section-header-counter': {
                        title: 'Contador de Productos',
                        text: 'En el lado derecho aparece un cuadro que muestra cuántos productos estás usando y cuántos tienes disponibles (ej: "15/50 productos").'
                    },
                    'section-alert': {
                        title: 'Alerta Informativa',
                        text: 'Aparece una caja azul en la parte superior que muestra: cuántos productos estás usando actualmente, cuántos productos tienes disponibles en tu plan, y el nombre de tu plan actual.'
                    },
                    'section-basic-info': {
                        title: 'Sección: Información Básica',
                        text: 'Esta sección contiene los datos principales del producto.'
                    },
                    'section-field-name': {
                        title: 'Campo "Nombre del Producto"',
                        text: 'Un cuadro de texto donde escribes el nombre del producto. Este campo es obligatorio (tiene un asterisco *). Máximo 255 caracteres. Usa nombres claros que tus clientes entiendan fácilmente. Ejemplos: "Camiseta Básica Blanca", "Pizza Margarita", "Servicio de Consultoría".'
                    },
                    'section-field-sku': {
                        title: 'Campo "SKU (Código)"',
                        text: 'Un cuadro de texto donde puedes escribir un código único para identificar el producto. Este campo es opcional. Ejemplos: "CAM-BAS-001", "PIZ-MAR-001". Es útil para control de inventario. Debe ser único en tu tienda.'
                    },
                    'section-field-price': {
                        title: 'Campo "Precio"',
                        text: 'Un cuadro de número donde escribes el precio del producto. Este campo es obligatorio. Aparece un símbolo $ al inicio. Puedes usar decimales (ej: 15000.50). No puede ser negativo. Este es el precio base del producto.'
                    },
                    'section-field-description': {
                        title: 'Campo "Descripción"',
                        text: 'Un área de texto grande donde describes las características principales del producto. Este campo es opcional. Puedes escribir varias líneas. Útil para explicar detalles, características, beneficios. Aparece en la página del producto en tu tienda.'
                    },
                    'section-button-kiubot': {
                        title: 'Botón "Mejorar con KiuBot"',
                        text: 'Si tu plan tiene KiuBot habilitado, aparece un botón especial que puede mejorar automáticamente tu descripción usando inteligencia artificial. Solo haz clic y KiuBot mejorará el texto por ti.'
                    },
                    'section-field-type': {
                        title: 'Campo "Tipo de Producto"',
                        text: 'Un menú desplegable donde eliges qué tipo de producto quieres crear. Este campo es obligatorio. Opciones: <strong>Simple:</strong> Un producto sin variantes. Ejemplo: Una pizza que siempre tiene el mismo precio y características. <strong>Variable:</strong> Un producto con variantes. Ejemplo: Una camiseta que viene en diferentes tallas y colores, cada una con su propio precio y stock. Importante: Si seleccionas "Variable", aparecerán secciones adicionales más abajo para configurar las variables y variaciones.'
                    },
                    'section-field-active': {
                        title: 'Toggle "Producto activo"',
                        text: 'Un interruptor que te permite activar o desactivar el producto al momento de crearlo. Opciones: Activado (azul) - El producto se puede ver en tu tienda. Desactivado (gris) - El producto no se puede ver en tu tienda, pero queda guardado. Por defecto: El producto se crea activado.'
                    },
                    'section-promo-toggle': {
                        title: 'Toggle "Precio Promocional"',
                        text: 'Un interruptor que activa o desactiva el precio promocional. Cuando está activado, aparecen campos adicionales.'
                    },
                    'section-promo-price': {
                        title: 'Campo "Precio Oferta"',
                        text: 'El precio con descuento (debe ser menor al precio original).'
                    },
                    'section-promo-start': {
                        title: 'Campo "Fecha Inicio"',
                        text: 'Cuándo comienza la promoción (opcional).'
                    },
                    'section-promo-end': {
                        title: 'Campo "Fecha Fin"',
                        text: 'Cuándo termina la promoción (opcional). Nota: Si no defines fechas, la promoción estará activa indefinidamente mientras el toggle esté encendido.'
                    },
                    'section-inventory': {
                        title: 'Sección: Gestión de Inventario',
                        text: 'Esta sección te permite controlar el stock del producto.'
                    },
                    'section-inventory-control': {
                        title: 'Checkbox "Controlar inventario de este producto"',
                        text: 'Una casilla que activa o desactiva el control de stock. Si la marcas, aparecen opciones adicionales.'
                    },
                    'section-inventory-unlimited': {
                        title: 'Radio "Ilimitado"',
                        text: 'El producto siempre estará disponible. No necesitas preocuparte por la cantidad.'
                    },
                    'section-inventory-limited': {
                        title: 'Radio "Limitado"',
                        text: 'Controlas la cantidad exacta disponible. Aparecen campos adicionales para definir la cantidad en stock y la alerta de stock bajo.'
                    },
                    'section-inventory-quantity': {
                        title: 'Campo "Cantidad en stock"',
                        text: 'Cuántas unidades tienes disponibles. Solo aparece si seleccionaste "Limitado".'
                    },
                    'section-inventory-threshold': {
                        title: 'Campo "Alerta de stock bajo"',
                        text: 'Te notificará cuando el stock llegue a esta cantidad o menos. Solo aparece si seleccionaste "Limitado".'
                    },
                    'section-made-to-order': {
                        title: 'Sección: Producto Bajo Pedido',
                        text: 'Esta sección es para productos que no tienes en stock pero puedes producir cuando el cliente los solicite.'
                    },
                    'section-mto-checkbox': {
                        title: 'Checkbox "Este producto se fabrica/prepara bajo pedido"',
                        text: 'Una casilla que activa esta funcionalidad. Si la marcas, aparecen opciones adicionales.'
                    },
                    'section-mto-days': {
                        title: 'Campo "Días de preparación"',
                        text: 'Cuántos días necesitas para tener listo el producto (este tiempo se suma al tiempo de envío).'
                    },
                    'section-mto-deposit': {
                        title: 'Checkbox "Requiere anticipo"',
                        text: 'Si el cliente debe pagar un adelanto al ordenar. Si lo marcas, aparecen más campos.'
                    },
                    'section-mto-deposit-type': {
                        title: 'Campo "Tipo de anticipo"',
                        text: 'Opciones: <strong>Porcentaje del precio:</strong> El cliente paga un porcentaje (ej: 50%). <strong>Monto fijo:</strong> El cliente paga una cantidad fija (ej: $50.000).'
                    },
                    'section-mto-deposit-value': {
                        title: 'Campo "Valor del anticipo"',
                        text: 'El porcentaje o monto que debe pagar. Importante: El anticipo fijo debe ser menor al precio del producto.'
                    },
                    'section-images': {
                        title: 'Sección: Imágenes del Producto',
                        text: 'Esta sección te permite subir imágenes del producto.'
                    },
                    'section-images-upload': {
                        title: 'Área de Carga de Imágenes',
                        text: 'Un área grande con borde punteado donde puedes: Arrastrar y soltar imágenes desde tu computadora, o hacer clic para abrir el explorador de archivos y seleccionar imágenes. Características: Puedes subir múltiples imágenes a la vez. Soporta formatos: JPG, PNG, WEBP. La primera imagen será la imagen principal del producto.'
                    },
                    'section-categories': {
                        title: 'Sección: Categorías',
                        text: 'Esta sección solo aparece si tienes categorías creadas. Te permite asignar el producto a una o más categorías.'
                    },
                    'section-category-item': {
                        title: 'Grid de Categorías',
                        text: 'Aparecen todas tus categorías en un cuadrícula. Cada categoría tiene: Una casilla de verificación para seleccionarla, el nombre de la categoría, la descripción de la categoría (si tiene). Características: Puedes seleccionar múltiples categorías. El producto aparecerá en todas las categorías seleccionadas. Si no tienes categorías, aparece un enlace para crear una nueva.'
                    },
                    'section-variables': {
                        title: 'Sección: Variables del Producto',
                        text: 'Esta sección solo aparece si seleccionaste "Variable" como tipo de producto. Aquí asignas las variables personalizables (como Talla, Color, etc.).'
                    },
                    'section-variables-select-all': {
                        title: 'Botón "Seleccionar todas"',
                        text: 'Marca todas las variables disponibles.'
                    },
                    'section-variables-deselect-all': {
                        title: 'Botón "Deseleccionar todas"',
                        text: 'Desmarca todas las variables.'
                    },
                    'section-variables-search': {
                        title: 'Campo de Búsqueda',
                        text: 'Un cuadro de texto para buscar variables por nombre rápidamente.'
                    },
                    'section-variable-item': {
                        title: 'Lista de Variables',
                        text: 'Las variables se agrupan por tipo y cada una muestra: Casilla de verificación para seleccionar la variable, icono que representa el tipo de variable, nombre de la variable, cantidad de opciones disponibles, toggle "Obligatorio" si esta variable es obligatoria para el cliente, campo "Nombre personalizado" para un nombre diferente en este producto, badges que muestran el tipo y estado de la variable. Importante: Debes seleccionar al menos una variable para productos variables.'
                    },
                    'section-variations': {
                        title: 'Sección: Variaciones del Producto',
                        text: 'Esta sección solo aparece si seleccionaste "Variable" como tipo de producto. Aquí defines las combinaciones específicas que venderás (ej: Talla M + Color Rojo).'
                    },
                    'section-variations-generate-all': {
                        title: 'Botón "Generar Todas las Combinaciones"',
                        text: 'Este botón crea automáticamente todas las combinaciones posibles basándose en las variables y opciones que seleccionaste. Útil si quieres vender todas las combinaciones. Por ejemplo, si tienes Talla (S, M, L) y Color (Rojo, Azul), generará: S-Rojo, S-Azul, M-Rojo, M-Azul, L-Rojo, L-Azul.'
                    },
                    'section-variations-add': {
                        title: 'Botón "Agregar Variación"',
                        text: 'Este botón te permite crear una variación manualmente. Útil si solo quieres vender ciertas combinaciones específicas. Cada vez que haces clic, aparece una nueva tarjeta para configurar una variación.'
                    },
                    'section-variation-selects': {
                        title: 'Selects de Variables',
                        text: 'Un menú desplegable por cada variable seleccionada. Puedes elegir una opción específica o dejarlo en "Cualquiera". Si eliges opciones específicas, defines una combinación única. Por ejemplo, si seleccionas Talla "M" y Color "Rojo", esa variación solo se aplicará a esa combinación específica.'
                    },
                    'section-variation-stock': {
                        title: 'Campo "Stock"',
                        text: 'La cantidad disponible de esta combinación específica. Solo aparece si el producto controla stock limitado. Por ejemplo, puedes tener 50 unidades de Talla M en Color Rojo, pero solo 10 unidades de Talla L en Color Azul.'
                    },
                    'section-variation-price': {
                        title: 'Campo "Precio Adicional"',
                        text: 'Puedes aumentar o disminuir el precio para esta variación. Usa valores positivos para aumentar (ej: +5000). Usa valores negativos para disminuir (ej: -2000). Este precio se suma o resta al precio base del producto. Por ejemplo, si el producto base cuesta $15.000 y pones +5000, esta variación costará $20.000.'
                    },
                    'section-variation-sku': {
                        title: 'Campo "SKU (Opcional)"',
                        text: 'Un código único para esta variación específica. Es opcional pero útil para control de inventario. Por ejemplo, puedes usar "CAM-M-ROJO" para identificar la variación de Camiseta Talla M Color Rojo.'
                    },
                    'section-variation-price-preview': {
                        title: 'Vista Previa del Precio',
                        text: 'Muestra el precio base del producto, el precio adicional (si hay), y el precio final de esta variación. Te ayuda a verificar que el precio esté correcto antes de guardar. El precio final se calcula automáticamente: Precio base + Precio adicional = Precio final.'
                    },
                    'section-variation-delete': {
                        title: 'Botón de Eliminar Variación',
                        text: 'Cada tarjeta tiene un icono de papelera para eliminar esa variación. Al hacer clic, la variación se elimina inmediatamente.'
                    },
                    'section-button-cancel': {
                        title: 'Botón "Cancelar"',
                        text: 'Este botón (rojo con borde) te lleva de vuelta a la lista de productos sin guardar ningún cambio.'
                    },
                    'section-button-create': {
                        title: 'Botón "Crear Producto"',
                        text: 'Este botón (negro) guarda el producto con todos los datos que ingresaste. Después de hacer clic, te lleva de vuelta a la lista de productos y verás un mensaje de éxito.'
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
