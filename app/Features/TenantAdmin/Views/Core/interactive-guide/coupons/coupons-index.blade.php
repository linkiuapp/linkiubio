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
                        {{-- Header --}}
                        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                            <div>
                                <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                    @click="scrollToSection('section-header')">Cupones</h1>
                                <p class="text-sm text-gray-600 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                   @click="scrollToSection('section-header')">
                                    Usando 2 de 5 cupones disponibles en tu plan Master
                                </p>
                            </div>
                            <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                    @click="scrollToSection('section-button-new')">
                                <i data-lucide="plus" class="w-5 h-5"></i>
                                Nuevo cupón
                            </button>
                        </div>

                        {{-- Filtros --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <input type="text" 
                                       placeholder="Buscar por nombre o código..."
                                       class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors"
                                       @click="scrollToSection('section-filter-search')"
                                       readonly>
                                <div class="px-3 py-2 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filter-status')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todos los estados
                                </div>
                                <div class="px-3 py-2 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filter-type')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todos los tipos
                                </div>
                                <div class="px-3 py-2 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filter-discount')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todos los descuentos
                                </div>
                                <div class="text-sm text-gray-600 ml-auto">
                                    Mostrando 5 cupones
                                </div>
                                <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm cursor-pointer"
                                        @click="scrollToSection('section-button-clear')">
                                    Limpiar filtros
                                </button>
                            </div>
                        </div>

                        {{-- Tabla --}}
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="px-4 pt-4 pb-2">
                                <p class="text-sm text-gray-600 flex items-center gap-2">
                                    <i data-lucide="mouse-pointer-click" class="w-3 h-3 text-blue-600"></i>
                                    <span><strong>Haz clic en los encabezados de columna</strong> para conocer qué información muestra cada una</span>
                                </p>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-coupon')">
                                                <div class="flex items-center gap-2">
                                                    <span>Cupón</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-code')">
                                                <div class="flex items-center gap-2">
                                                    <span>Código</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-discount')">
                                                <div class="flex items-center gap-2">
                                                    <span>Tipo y descuento</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-validity')">
                                                <div class="flex items-center gap-2">
                                                    <span>Validez</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-usage')">
                                                <div class="flex items-center gap-2">
                                                    <span>Uso</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-status')">
                                                <div class="flex items-center gap-2">
                                                    <span>Estado</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-actions')">
                                                <div class="flex items-center justify-center gap-2">
                                                    <span>Acciones</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @for($i = 0; $i < 3; $i++)
                                        <tr class="hover:bg-gray-50">
                                            {{-- Wireframe: Cupón --}}
                                            <td class="px-6 py-4">
                                                <div class="space-y-1.5">
                                                    <div class="flex items-center gap-2">
                                                        <div class="h-3 bg-gray-300 rounded w-32"></div>
                                                        @if($i === 0)
                                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">Público</span>
                                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full">Automático</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- Wireframe: Código --}}
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 bg-gray-800 text-white text-xs rounded font-mono">BIENVENIDA20</span>
                                            </td>
                                            {{-- Wireframe: Tipo y descuento --}}
                                            <td class="px-6 py-4">
                                                <div class="space-y-1">
                                                    <div class="flex items-center gap-2">
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">Global</span>
                                                        <span class="text-sm font-semibold text-gray-900">15%</span>
                                                    </div>
                                                    <div class="text-xs text-gray-500">Compra mínima: $30.000</div>
                                                </div>
                                            </td>
                                            {{-- Wireframe: Validez --}}
                                            <td class="px-6 py-4">
                                                <div class="space-y-1 text-sm">
                                                    <div class="text-gray-900">Desde 01/01/2025</div>
                                                    <div class="text-gray-600">Hasta 31/01/2025</div>
                                                </div>
                                            </td>
                                            {{-- Wireframe: Uso --}}
                                            <td class="px-6 py-4">
                                                <div class="space-y-1">
                                                    <div class="text-sm text-gray-900">5 / 100 usos</div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="bg-green-600 h-2 rounded-full" style="width: 5%"></div>
                                                    </div>
                                                    <div class="text-xs text-gray-500">5% usado</div>
                                                </div>
                                            </td>
                                            {{-- Wireframe: Estado --}}
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 text-xs rounded-full {{ ['bg-green-100 text-green-700', 'bg-red-100 text-red-700', 'bg-blue-100 text-blue-700'][$i] }}">
                                                    {{ ['Activo', 'Inactivo', 'Próximo'][$i] }}
                                                </span>
                                            </td>
                                            {{-- Wireframe: Acciones --}}
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <div class="w-6 h-6 bg-blue-200 rounded cursor-pointer hover:bg-blue-300 transition-colors"
                                                         @click.stop="scrollToSection('section-action-view')"></div>
                                                    <div class="w-6 h-6 bg-gray-200 rounded cursor-pointer hover:bg-gray-300 transition-colors"
                                                         @click.stop="scrollToSection('section-action-edit')"></div>
                                                    <div class="w-6 h-6 bg-yellow-200 rounded cursor-pointer hover:bg-yellow-300 transition-colors"
                                                         @click.stop="scrollToSection('section-action-toggle')"></div>
                                                    @if($i === 2)
                                                    <div class="w-6 h-6 bg-red-200 rounded cursor-pointer hover:bg-red-300 transition-colors"
                                                         @click.stop="scrollToSection('section-action-delete')"></div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Paginación --}}
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">Mostrando 1 - 3 de 3 cupones</p>
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                        @click="scrollToSection('section-pagination-prev')"
                                        disabled>
                                    Anterior
                                </button>
                                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                        @click="scrollToSection('section-pagination-page')">
                                    1
                                </button>
                                <button class="px-3 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                        @click="scrollToSection('section-pagination-next')"
                                        disabled>
                                    Siguiente
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
                                <p class="text-sm text-gray-700"><strong>Usa nombres descriptivos</strong> para tus cupones</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa el porcentaje de uso</strong> para saber cuándo un cupón está por agotarse</p>
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
                                <p class="text-sm text-gray-700"><strong>Usa los filtros</strong> para encontrar rápidamente cupones específicos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa regularmente</strong> los cupones expirados o agotados</p>
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
                    'section-header': {
                        title: 'Encabezado de la Página',
                        text: '<strong>Título "Cupones":</strong> Muestra el nombre de la sección donde estás. Te indica que estás en la pantalla para administrar todos los cupones de descuento de tu tienda.<br><br><strong>Información del Plan:</strong> Debajo del título aparece un texto que dice cuántos cupones estás usando y cuántos tienes disponibles según tu plan. Por ejemplo: "Usando 2 de 5 cupones disponibles en tu plan Master". Indica cuántos cupones puedes crear según tu plan actual.'
                    },
                    'section-button-new': {
                        title: 'Botón "Nuevo cupón"',
                        text: 'Te permite crear un nuevo cupón de descuento. Solo aparece si aún tienes espacios disponibles según tu plan. Si has alcanzado el límite, aparece un botón deshabilitado con el texto "Límite alcanzado".'
                    },
                    'section-filter-search': {
                        title: 'Campo de búsqueda',
                        text: 'Te permite buscar cupones por nombre o código. Escribe cualquier palabra y se filtrarán los cupones que coincidan. La búsqueda se ejecuta automáticamente mientras escribes (con un pequeño retraso).'
                    },
                    'section-filter-status': {
                        title: 'Filtro por estado',
                        text: 'Campo de selección con opciones: "Todos los estados" (muestra todos los cupones sin importar su estado), "Activos" (muestra solo los cupones que están activos y disponibles), "Inactivos" (muestra solo los cupones que están desactivados), "Expirados" (muestra solo los cupones cuya fecha de fin ya pasó), "Próximos" (muestra solo los cupones que aún no han comenzado - fecha de inicio futura).'
                    },
                    'section-filter-type': {
                        title: 'Filtro por tipo',
                        text: 'Campo de selección con opciones: "Global" (cupones que aplican a toda la tienda), "Categorías específicas" (cupones que solo aplican a ciertas categorías), "Productos específicos" (cupones que solo aplican a ciertos productos).'
                    },
                    'section-filter-discount': {
                        title: 'Filtro por descuento',
                        text: 'Campo de selección con opciones: "Porcentaje" (cupones que dan un descuento porcentual), "Valor Fijo" (cupones que dan un descuento de monto fijo).'
                    },
                    'section-button-clear': {
                        title: 'Botón "Limpiar filtros"',
                        text: 'Aparece cuando tienes filtros activos. Elimina todos los filtros y muestra todos los cupones nuevamente.'
                    },
                    'section-table-coupon': {
                        title: 'Columna "Cupón"',
                        text: 'Muestra el nombre del cupón en negrita. Badges adicionales: Badge "Público" (azul) - Si el cupón es visible para todos los clientes, Badge "Automático" (verde) - Si el cupón se aplica automáticamente sin código.'
                    },
                    'section-table-code': {
                        title: 'Columna "Código"',
                        text: 'Muestra el código del cupón en un badge gris oscuro con formato monoespaciado. Ejemplo: "BIENVENIDA20". Si el cupón es automático, puede no tener código visible.'
                    },
                    'section-table-discount': {
                        title: 'Columna "Tipo y descuento"',
                        text: 'Badge que indica el tipo de aplicación: "Global" (gris), "Categorías específicas" (gris), "Productos específicos" (gris). Valor del descuento: Si es porcentaje: "15% de descuento", Si es monto fijo: "$5.000 de descuento". Compra mínima (si está configurada): "Compra mínima: $30.000" (en texto más pequeño y gris).'
                    },
                    'section-table-validity': {
                        title: 'Columna "Validez"',
                        text: 'Muestra las fechas de inicio y fin del cupón. Ejemplo: "Desde 01/01/2025" y "Hasta 31/01/2025". Si no hay fechas configuradas, muestra "Sin límite definido".'
                    },
                    'section-table-usage': {
                        title: 'Columna "Uso"',
                        text: 'Muestra cuántas veces se ha usado el cupón. Ejemplo: "5 / 100 usos" o "10 usos ilimitados". Barra de progreso que muestra el porcentaje de uso: Verde (menos del 60% usado), Amarillo (entre 60% y 80% usado), Rojo (más del 80% usado). Porcentaje de uso debajo de la barra.'
                    },
                    'section-table-status': {
                        title: 'Columna "Estado"',
                        text: 'Badge que muestra el estado actual del cupón: "Activo" (verde) - El cupón está activo y disponible, "Inactivo" (rojo) - El cupón está desactivado, "Próximo" (azul) - El cupón aún no ha comenzado, "Expirado" (rojo) - El cupón ya expiró, "Agotado" (amarillo) - El cupón alcanzó su límite de usos.'
                    },
                    'section-table-actions': {
                        title: 'Columna "Acciones"',
                        text: 'Ícono de ojo (azul): Ver detalles del cupón. Ícono de lápiz (gris): Editar el cupón. Ícono de pausa/play (amarillo/verde): Activar o desactivar el cupón. Pausa (amarillo): Si está activo, para desactivarlo. Play (verde): Si está inactivo, para activarlo. Ícono de basurero (rojo): Eliminar el cupón (solo aparece si el cupón nunca se ha usado).'
                    },
                    'section-action-view': {
                        title: 'Acción: Ver Detalles',
                        text: 'Ícono de ojo azul. Te lleva a la página de detalles del cupón donde puedes ver toda la información completa, estadísticas de uso y restricciones.'
                    },
                    'section-action-edit': {
                        title: 'Acción: Editar',
                        text: 'Ícono de lápiz gris. Te lleva al formulario de edición del cupón.'
                    },
                    'section-action-toggle': {
                        title: 'Acción: Activar/Desactivar',
                        text: 'Ícono de pausa (amarillo) si está activo, o play (verde) si está inactivo. Permite activar o desactivar el cupón rápidamente. El estado cambia automáticamente al hacer clic. Aparecerá un mensaje de confirmación.'
                    },
                    'section-action-delete': {
                        title: 'Acción: Eliminar',
                        text: 'Ícono de basurero rojo. Solo aparece si el cupón nunca se ha usado (0 usos). Te permite eliminar el cupón. Aparecerá un modal pidiendo confirmación. Importante: No puedes eliminar cupones que ya se han usado.'
                    },
                    'section-pagination-prev': {
                        title: 'Botón "Anterior"',
                        text: 'Te lleva a la página anterior de resultados. Se desactiva cuando estás en la primera página.'
                    },
                    'section-pagination-page': {
                        title: 'Número de Página',
                        text: 'Muestra el número de página actual. Puedes hacer clic en diferentes números para navegar entre páginas.'
                    },
                    'section-pagination-next': {
                        title: 'Botón "Siguiente"',
                        text: 'Te lleva a la página siguiente de resultados. Se desactiva cuando estás en la última página.'
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
