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
                                    @click="scrollToSection('section-header-title')">Nuevo cupón</h1>
                            </div>
                        </div>

                        {{-- Alerta Informativa --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 cursor-pointer hover:bg-blue-100 transition-colors"
                             @click="scrollToSection('section-alert')">
                            <p class="text-sm text-blue-800">
                                Estás usando <strong>2 de 5</strong> cupones disponibles en tu plan Master.
                            </p>
                        </div>

                        {{-- Sección: Información Básica --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-basic-info')">Información Básica</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-name')">
                                        Nombre del cupón <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           placeholder="Ej: Descuento de bienvenida, Promoción de verano"
                                           maxlength="120"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-name')"
                                           readonly>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 120 caracteres</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-code')">
                                        Código del cupón
                                    </label>
                                    <input type="text" 
                                           placeholder="Ej: BIENVENIDA20, VERANO2025"
                                           maxlength="20"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors uppercase"
                                           @click="scrollToSection('section-field-code')"
                                           readonly>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 20 caracteres. Solo letras, números y guiones. Se convierte a mayúsculas automáticamente.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-description')">
                                        Descripción
                                    </label>
                                    <textarea rows="3" 
                                              placeholder="Ej: Aprovecha este descuento especial para nuevos clientes"
                                              maxlength="500"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                              @click="scrollToSection('section-field-description')"
                                              readonly></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Descuento y Alcance --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-discount')">Descuento y Alcance</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-apply-to')">
                                        Aplicar a <span class="text-red-500">*</span>
                                    </label>
                                    <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                         @click="scrollToSection('section-field-apply-to')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        Global
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-discount-type')">
                                            Tipo de descuento <span class="text-red-500">*</span>
                                        </label>
                                        <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                             @click="scrollToSection('section-field-discount-type')"
                                             style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                            Porcentaje
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-discount-value')">
                                            Valor del descuento <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500" x-show="discountType === 'percentage'">%</span>
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500" x-show="discountType === 'fixed'">$</span>
                                            <input type="number" 
                                                   placeholder="15"
                                                   step="0.01"
                                                   min="0.01"
                                                   class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   @click="scrollToSection('section-field-discount-value')"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-max-discount')">
                                        Descuento máximo ($)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                        <input type="number" 
                                               placeholder="10000"
                                               step="0.01"
                                               min="0"
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-max-discount')"
                                               readonly>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Solo visible si el descuento es porcentaje. Limita el monto máximo del descuento.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-min-purchase')">
                                        Compra mínima ($)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                        <input type="number" 
                                               placeholder="30000"
                                               step="0.01"
                                               min="0"
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-min-purchase')"
                                               readonly>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Monto mínimo que el cliente debe comprar para usar el cupón</p>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Aplicabilidad (condicional) --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-applicability')">Aplicabilidad</h3>
                            
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                                <p class="text-sm text-gray-600 mb-3">Selecciona las categorías donde se aplicará el cupón:</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @for($i = 0; $i < 4; $i++)
                                    <div class="bg-white rounded-lg border border-gray-200 p-3 cursor-pointer hover:border-blue-300 transition-colors"
                                         @click="scrollToSection('section-category-item')">
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded cursor-pointer">
                                            <span class="text-sm text-gray-900">Categoría {{ $i + 1 }}</span>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                                <p class="text-xs text-gray-500 mt-3">Debes seleccionar al menos una categoría</p>
                            </div>
                        </div>

                        {{-- Sección: Restricciones y Límites --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-restrictions')">Restricciones y Límites</h3>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-total-uses')">
                                            Límite total de usos
                                        </label>
                                        <input type="number" 
                                               placeholder="100"
                                               min="1"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-total-uses')"
                                               readonly>
                                        <p class="text-xs text-gray-500 mt-1">Cuántas veces se puede usar el cupón en total</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-uses-per-customer')">
                                            Usos por cliente
                                        </label>
                                        <input type="number" 
                                               placeholder="1"
                                               min="1"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-uses-per-customer')"
                                               readonly>
                                        <p class="text-xs text-gray-500 mt-1">Cuántas veces el mismo cliente puede usar el cupón</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-start-date')">
                                            Fecha de inicio
                                        </label>
                                        <input type="datetime-local" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-start-date')"
                                               readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-end-date')">
                                            Fecha de fin
                                        </label>
                                        <input type="datetime-local" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-end-date')"
                                               readonly>
                                    </div>
                                </div>

                                {{-- Restricciones Horarias --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-sm font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                            @click="scrollToSection('section-time-restrictions')">Restricciones horarias</h4>
                                        <button class="px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-button-configure-time')">
                                            Configurar
                                        </button>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                   @click="scrollToSection('section-field-allowed-days')">Días permitidos</label>
                                            <div class="flex flex-wrap gap-2">
                                                @php
                                                    $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                                @endphp
                                                @foreach($days as $day)
                                                <label class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors">
                                                    <input type="checkbox" class="w-4 h-4 text-blue-600 rounded cursor-pointer"
                                                           @click="scrollToSection('section-field-allowed-days')">
                                                    <span class="text-sm text-gray-700">{{ $day }}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                       @click="scrollToSection('section-field-start-time')">Hora de inicio</label>
                                                <input type="time" 
                                                       value="09:00"
                                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                       @click="scrollToSection('section-field-start-time')"
                                                       readonly>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                                       @click="scrollToSection('section-field-end-time')">Hora de fin</label>
                                                <input type="time" 
                                                       value="18:00"
                                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                       @click="scrollToSection('section-field-end-time')"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Configuración Rápida --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-config')">Configuración Rápida</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-toggle-active')">Activar al guardar</label>
                                        <p class="text-xs text-gray-500">El cupón estará disponible inmediatamente después de crearlo</p>
                                    </div>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle-active')">
                                        <input type="checkbox" class="peer sr-only" checked>
                                        <span class="absolute inset-0 bg-blue-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-toggle-public')">Cupón público</label>
                                        <p class="text-xs text-gray-500">El cupón será visible para todos los clientes en la tienda</p>
                                    </div>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle-public')">
                                        <input type="checkbox" class="peer sr-only">
                                        <span class="absolute inset-0 bg-gray-300 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out"></span>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-toggle-auto')">Aplicación automática</label>
                                        <p class="text-xs text-gray-500">El cupón se aplicará automáticamente sin necesidad de código</p>
                                    </div>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle-auto')">
                                        <input type="checkbox" class="peer sr-only">
                                        <span class="absolute inset-0 bg-gray-300 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Vista Previa --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-preview')">Vista Previa</h3>
                            
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border-2 border-blue-200 p-6 cursor-pointer hover:border-blue-300 transition-colors"
                                 @click="scrollToSection('section-preview-card')">
                                <div class="text-center">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Descuento de bienvenida</h3>
                                    <div class="flex items-center justify-center gap-2 mb-3">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Global</span>
                                        <span class="px-3 py-1 bg-blue-600 text-white text-lg font-bold rounded">15%</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">Código: BIENVENIDA20</p>
                                    <p class="text-xs text-gray-500">Descuento estimado sobre el subtotal elegible</p>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex gap-3 justify-between pt-4 border-t border-gray-200">
                            <button type="button" 
                                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                    @click="scrollToSection('section-button-cancel')">
                                Cancelar
                            </button>
                            <button type="button" 
                                    class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                    @click="scrollToSection('section-button-create')">
                                Crear cupón
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
                                <p class="text-sm text-gray-700"><strong>Usa nombres claros</strong> y descriptivos para tus cupones</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los códigos deben ser fáciles</strong> de recordar pero difíciles de adivinar</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Define límites de uso</strong> para controlar el presupuesto de tus promociones</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa restricciones horarias</strong> para promociones de días específicos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los cupones públicos</strong> son ideales para promociones generales</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los cupones automáticos</strong> son útiles para descuentos que quieres aplicar siempre</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa la vista previa</strong> antes de guardar para asegurarte de que todo esté correcto</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Considera establecer</strong> una compra mínima para evitar abusos</p>
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
                discountType: 'percentage',
                
                guides: {
                    'section-header-back': {
                        title: 'Botón "Volver"',
                        text: 'Te regresa al listado de cupones sin guardar cambios.'
                    },
                    'section-header-title': {
                        title: 'Título "Nuevo cupón"',
                        text: 'Muestra que estás creando un nuevo cupón de descuento.'
                    },
                    'section-alert': {
                        title: 'Alerta informativa',
                        text: 'Muestra cuántos cupones estás usando del total disponible según tu plan. Ejemplo: "Estás usando 2 de 5 cupones disponibles en tu plan Master". Te ayuda a saber si puedes crear más cupones.'
                    },
                    'section-basic-info': {
                        title: 'Sección: Información Básica',
                        text: 'Esta sección contiene los campos básicos del cupón: nombre, código y descripción.'
                    },
                    'section-field-name': {
                        title: 'Campo "Nombre del cupón"',
                        text: 'Escribe un nombre descriptivo para el cupón. Ejemplo: "Descuento de bienvenida", "Promoción de verano". Máximo 120 caracteres. Este nombre aparece en la lista de cupones y en los detalles. Este campo es obligatorio.'
                    },
                    'section-field-code': {
                        title: 'Campo "Código del cupón"',
                        text: 'Escribe un código que los clientes usarán para aplicar el descuento. Ejemplo: "BIENVENIDA20", "VERANO2025". Se convierte automáticamente a mayúsculas mientras escribes. Máximo 20 caracteres. Solo letras, números y guiones. Si no escribes un código y el cupón es automático, se generará uno automáticamente. Importante: El código debe ser único en tu tienda. Este campo es opcional.'
                    },
                    'section-field-description': {
                        title: 'Campo "Descripción"',
                        text: 'Escribe una descripción que explique el beneficio del cupón. Aparecerá cuando los clientes vean el cupón. Máximo 500 caracteres. Ejemplo: "Aprovecha este descuento especial para nuevos clientes". Este campo es opcional.'
                    },
                    'section-discount': {
                        title: 'Sección: Descuento y Alcance',
                        text: 'Esta sección te permite configurar dónde y cómo se aplicará el descuento del cupón.'
                    },
                    'section-field-apply-to': {
                        title: 'Campo "Aplicar a"',
                        text: 'Selecciona dónde se aplicará el cupón: "Global" - Se aplica a todos los productos de la tienda, "Categorías específicas" - Solo se aplica a productos de ciertas categorías (aparecerá una lista para seleccionar), "Productos específicos" - Solo se aplica a ciertos productos (aparecerá una lista para seleccionar). Este campo es obligatorio.'
                    },
                    'section-field-discount-type': {
                        title: 'Campo "Tipo de descuento"',
                        text: 'Selecciona cómo se calculará el descuento: "Porcentaje" - Descuento porcentual (ejemplo: 15% de descuento), "Valor Fijo" - Descuento de monto fijo (ejemplo: $5.000 de descuento). Este campo es obligatorio.'
                    },
                    'section-field-discount-value': {
                        title: 'Campo "Valor del descuento"',
                        text: 'Escribe el valor del descuento. Si es porcentaje: Escribe un número del 0 al 100 (ejemplo: 15 para 15%). Si es monto fijo: Escribe el monto en pesos (ejemplo: 5000 para $5.000). Mínimo: 0.01. Este campo es obligatorio.'
                    },
                    'section-field-max-discount': {
                        title: 'Campo "Descuento máximo ($)"',
                        text: 'Si el descuento es porcentual, puedes limitar el monto máximo. Ejemplo: Si el descuento es 20% pero quieres que máximo sea $10.000. Si el cliente compra $100.000, el descuento sería $20.000, pero con máximo de $10.000, solo se aplican $10.000. Solo visible si el descuento es porcentaje. Este campo es opcional.'
                    },
                    'section-field-min-purchase': {
                        title: 'Campo "Compra mínima ($)"',
                        text: 'Define el monto mínimo que el cliente debe comprar para usar el cupón. Ejemplo: Si escribes 30000, el cupón solo aplicará en pedidos de $30.000 o más. Si no defines un monto mínimo, el cupón aplicará a cualquier pedido. Este campo es opcional.'
                    },
                    'section-applicability': {
                        title: 'Sección: Aplicabilidad',
                        text: 'Esta sección solo es visible si "Aplicar a" no es "Global". Te permite seleccionar las categorías o productos específicos donde se aplicará el cupón.'
                    },
                    'section-category-item': {
                        title: 'Lista de categorías/productos',
                        text: 'Si seleccionaste "Categorías específicas": Aparece una lista de todas tus categorías activas. Marca las categorías donde quieres que el cupón sea válido. Debes seleccionar al menos una categoría. Cada categoría aparece en una tarjeta con su nombre. Si seleccionaste "Productos específicos": Aparece una lista de todos tus productos activos. Marca los productos donde quieres que el cupón sea válido. Debes seleccionar al menos un producto. Cada producto aparece en una tarjeta con su nombre y precio.'
                    },
                    'section-restrictions': {
                        title: 'Sección: Restricciones y Límites',
                        text: 'Esta sección te permite configurar límites de uso, fechas de vigencia y restricciones horarias para el cupón.'
                    },
                    'section-field-total-uses': {
                        title: 'Campo "Límite total de usos"',
                        text: 'Define cuántas veces se puede usar el cupón en total. Ejemplo: Si escribes 100, el cupón solo se podrá usar 100 veces. Si no defines un límite, el cupón tendrá usos ilimitados. Mínimo: 1 uso. Este campo es opcional.'
                    },
                    'section-field-uses-per-customer': {
                        title: 'Campo "Usos por cliente"',
                        text: 'Define cuántas veces el mismo cliente puede usar el cupón. Ejemplo: Si escribes 1, cada cliente solo podrá usar el cupón una vez. Si no defines un límite, cada cliente podrá usarlo ilimitadas veces. Mínimo: 1 uso. Este campo es opcional.'
                    },
                    'section-field-start-date': {
                        title: 'Campo "Fecha de inicio"',
                        text: 'Define cuándo comenzará a estar disponible el cupón. Puedes seleccionar fecha y hora. Si no defines una fecha, el cupón estará disponible inmediatamente. Debe ser una fecha futura o de hoy. Este campo es opcional.'
                    },
                    'section-field-end-date': {
                        title: 'Campo "Fecha de fin"',
                        text: 'Define cuándo dejará de estar disponible el cupón. Puedes seleccionar fecha y hora. Si no defines una fecha, el cupón no expirará. Debe ser igual o posterior a la fecha de inicio. Este campo es opcional.'
                    },
                    'section-time-restrictions': {
                        title: 'Sección: Restricciones horarias',
                        text: 'Esta sección te permite configurar días y horarios específicos en los que el cupón será válido. Es una sección expandible que se muestra al hacer clic en "Configurar".'
                    },
                    'section-button-configure-time': {
                        title: 'Botón "Configurar"',
                        text: 'Muestra u oculta las opciones de restricciones horarias. Al hacer clic, se despliega la sección con los campos de días permitidos, hora de inicio y hora de fin.'
                    },
                    'section-field-allowed-days': {
                        title: 'Días permitidos',
                        text: 'Marca los días de la semana en los que el cupón será válido. Domingo, Lunes, Martes, Miércoles, Jueves, Viernes, Sábado. Puedes marcar varios días. Si no configuras restricciones horarias, el cupón será válido todos los días y a cualquier hora.'
                    },
                    'section-field-start-time': {
                        title: 'Hora de inicio',
                        text: 'Define la hora del día desde la cual el cupón será válido. Ejemplo: 09:00 (9 de la mañana).'
                    },
                    'section-field-end-time': {
                        title: 'Hora de fin',
                        text: 'Define la hora del día hasta la cual el cupón será válido. Ejemplo: 18:00 (6 de la tarde). Debe ser posterior a la hora de inicio.'
                    },
                    'section-config': {
                        title: 'Sección: Configuración Rápida',
                        text: 'Esta sección contiene interruptores para configurar rápidamente el estado del cupón, si es público y si se aplica automáticamente.'
                    },
                    'section-toggle-active': {
                        title: 'Interruptor "Activar al guardar"',
                        text: 'Si está activado, el cupón estará disponible inmediatamente después de crearlo. Si está desactivado, el cupón se creará como inactivo y deberás activarlo manualmente después. Por defecto está activado.'
                    },
                    'section-toggle-public': {
                        title: 'Interruptor "Cupón público"',
                        text: 'Si está activado, el cupón será visible para todos los clientes en la tienda. Los clientes podrán verlo y usarlo sin necesidad de que se lo compartas. Si está desactivado, el cupón será privado y solo se podrá usar con el código. Por defecto está desactivado.'
                    },
                    'section-toggle-auto': {
                        title: 'Interruptor "Aplicación automática"',
                        text: 'Si está activado, el cupón se aplicará automáticamente sin necesidad de código. Útil para descuentos que quieres aplicar siempre (ejemplo: descuento por primera compra). Si está desactivado, el cliente debe ingresar el código manualmente. Por defecto está desactivado.'
                    },
                    'section-preview': {
                        title: 'Sección: Vista Previa',
                        text: 'Esta sección muestra cómo se verá el cupón con la configuración actual. Se actualiza automáticamente mientras completas el formulario.'
                    },
                    'section-preview-card': {
                        title: 'Tarjeta de vista previa',
                        text: 'Muestra cómo se verá el cupón: Nombre del cupón, Código (o "CÓDIGO-AUTO" si es automático), Badge con el alcance (Global, Categorías o Productos), Valor del descuento en grande: Si es porcentaje: "15%", Si es monto fijo: "$5.000", Texto: "Descuento estimado sobre el subtotal elegible".'
                    },
                    'section-button-cancel': {
                        title: 'Botón "Cancelar"',
                        text: 'Cancela la creación y regresa al listado de cupones. No guarda ningún cambio.'
                    },
                    'section-button-create': {
                        title: 'Botón "Crear cupón"',
                        text: 'Guarda el nuevo cupón con toda la configuración. Valida que todos los campos obligatorios estén completos. Si hay errores, los mostrará en rojo debajo de cada campo.'
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
