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
                                    @click="scrollToSection('section-header')">Sliders</h1>
                                <p class="text-sm text-gray-600 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                   @click="scrollToSection('section-header')">
                                    Usando 1 de 3 sliders disponibles en tu plan Master
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm cursor-pointer"
                                        @click="scrollToSection('section-button-delete-multiple')"
                                        style="display: none;">
                                    Eliminar 2 sliders
                                </button>
                                <button class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                        @click="scrollToSection('section-button-new')">
                                    <i data-lucide="plus" class="w-5 h-5"></i>
                                    Nuevo Slider
                                </button>
                            </div>
                        </div>

                        {{-- Filtros --}}
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="px-3 py-2 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filter-status')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todos los estados
                                </div>
                                <div class="px-3 py-2 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filter-scheduling')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todas las programaciones
                                </div>
                                <div class="text-sm text-gray-600 ml-auto">
                                    Mostrando 1 - 3 de 3 sliders
                                </div>
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
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-checkbox')">
                                                <div class="flex items-center justify-center gap-2">
                                                    <div class="w-4 h-4 bg-gray-200 rounded"></div>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-slider')">
                                                <div class="flex items-center gap-2">
                                                    <span>Slider</span>
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
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-toggle')">
                                                <div class="flex items-center gap-2">
                                                    <span>Activar y Desactivar</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-scheduling')">
                                                <div class="flex items-center gap-2">
                                                    <span>Programación</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-transition')">
                                                <div class="flex items-center gap-2">
                                                    <span>Transición</span>
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
                                            {{-- Wireframe: Checkbox --}}
                                            <td class="px-6 py-4 text-center">
                                                <div class="w-4 h-4 bg-gray-200 rounded"></div>
                                            </td>
                                            {{-- Wireframe: Slider --}}
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-16 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                                    </div>
                                                    <div class="space-y-1">
                                                        <div class="h-3 bg-gray-300 rounded w-32"></div>
                                                        <div class="h-2 bg-gray-200 rounded w-40"></div>
                                                        <div class="flex items-center gap-1 mt-1">
                                                            <i data-lucide="link" class="w-3 h-3 text-gray-400"></i>
                                                            <span class="text-xs text-gray-500">Interno</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- Wireframe: Estado --}}
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 text-xs rounded-full {{ ['bg-green-100 text-green-700', 'bg-red-100 text-red-700', 'bg-green-100 text-green-700'][$i] }}">
                                                    {{ ['Activo', 'Inactivo', 'Activo'][$i] }}
                                                </span>
                                            </td>
                                            {{-- Wireframe: Toggle --}}
                                            <td class="px-6 py-4">
                                                <div class="w-11 h-6 {{ ['bg-blue-600', 'bg-gray-300', 'bg-blue-600'][$i] }} rounded-full relative cursor-pointer"
                                                     @click.stop="scrollToSection('section-action-toggle')">
                                                    <div class="absolute top-0.5 {{ ['right-0.5', 'left-0.5', 'right-0.5'][$i] }} w-5 h-5 bg-white rounded-full transition-transform"></div>
                                                </div>
                                            </td>
                                            {{-- Wireframe: Programación --}}
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 text-xs rounded-full {{ ['bg-green-100 text-green-700', 'bg-yellow-100 text-yellow-700', 'bg-blue-100 text-blue-700'][$i] }}">
                                                    {{ ['Permanente', 'Programado', 'Siempre'][$i] }}
                                                </span>
                                            </td>
                                            {{-- Wireframe: Transición --}}
                                            <td class="px-6 py-4">
                                                <span class="text-sm text-gray-900">5s</span>
                                            </td>
                                            {{-- Wireframe: Acciones --}}
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <div class="w-6 h-6 bg-blue-200 rounded cursor-pointer hover:bg-blue-300 transition-colors"
                                                         @click.stop="scrollToSection('section-action-view')"></div>
                                                    <div class="w-6 h-6 bg-gray-200 rounded cursor-pointer hover:bg-gray-300 transition-colors"
                                                         @click.stop="scrollToSection('section-action-edit')"></div>
                                                    <div class="w-6 h-6 bg-gray-200 rounded cursor-pointer hover:bg-gray-300 transition-colors"
                                                         @click.stop="scrollToSection('section-action-duplicate')"></div>
                                                    <div class="w-6 h-6 bg-red-200 rounded cursor-pointer hover:bg-red-300 transition-colors"
                                                         @click.stop="scrollToSection('section-action-delete')"></div>
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
                            <p class="text-sm text-gray-600">Mostrando 1 - 3 de 3 sliders</p>
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
                                <p class="text-sm text-gray-700"><strong>Usa nombres descriptivos</strong> para tus sliders</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa el estado</strong> antes de publicar para asegurarte de que se muestren correctamente</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los sliders programados</strong> son útiles para promociones temporales</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Los sliders permanentes</strong> son ideales para banners informativos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa los filtros</strong> para encontrar rápidamente sliders específicos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>La duplicación es útil</strong> cuando quieres crear sliders similares con pequeñas variaciones</p>
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
                        text: '<strong>Título "Sliders":</strong> Muestra el nombre de la sección donde estás. Te indica que estás en la pantalla para administrar todos los sliders (banners) de tu tienda.<br><br><strong>Información del Plan:</strong> Debajo del título aparece un texto que dice cuántos sliders estás usando y cuántos tienes disponibles según tu plan. Por ejemplo: "Usando 1 de 3 sliders disponibles en tu plan Master". Indica cuántos sliders puedes crear según tu plan actual.'
                    },
                    'section-button-new': {
                        title: 'Botón "Nuevo Slider"',
                        text: 'Te permite crear un nuevo slider. Solo aparece si aún tienes espacios disponibles según tu plan. Si has alcanzado el límite, aparece un botón deshabilitado con el texto "Límite Alcanzado".'
                    },
                    'section-button-delete-multiple': {
                        title: 'Botón "Eliminar X sliders"',
                        text: 'Aparece cuando marcas uno o más sliders con los checkboxes. Te permite eliminar múltiples sliders a la vez. Muestra cuántos sliders has seleccionado. Al hacer clic, aparecerá un modal pidiendo confirmación.'
                    },
                    'section-filter-status': {
                        title: 'Filtro por estado',
                        text: 'Campo de selección con opciones: "Todos los estados" (muestra todos los sliders sin importar su estado), "Activos" (muestra solo los sliders que están activos y se muestran en la tienda), "Inactivos" (muestra solo los sliders que están desactivados).'
                    },
                    'section-filter-scheduling': {
                        title: 'Filtro por programación',
                        text: 'Campo de selección con opciones: "Todas las programaciones" (muestra todos los sliders), "Programados" (muestra solo los sliders que tienen programación - fechas/horarios), "Permanentes" (muestra solo los sliders que están siempre activos - sin programación).'
                    },
                    'section-table-checkbox': {
                        title: 'Columna de selección (checkbox)',
                        text: 'Checkbox en cada fila para seleccionar el slider. Checkbox en el encabezado para seleccionar todos los sliders. Al seleccionar sliders, aparece el botón "Eliminar X sliders" en el encabezado. Útil para realizar acciones en grupo.'
                    },
                    'section-table-slider': {
                        title: 'Columna "Slider"',
                        text: 'Miniatura de la imagen: Muestra una vista previa pequeña de la imagen del slider. Si no hay imagen, muestra un ícono de imagen gris. Nombre del slider: En negrita. Descripción: Si tiene descripción, aparece debajo del nombre en texto más pequeño y gris. Tipo de enlace: Si tiene enlace configurado, muestra un ícono de enlace y el tipo (Interno o Externo).'
                    },
                    'section-table-status': {
                        title: 'Columna "Estado"',
                        text: 'Badge que muestra el estado actual del slider: "Activo" (verde) - El slider está activo y se muestra en la tienda, "Inactivo" (rojo) - El slider está desactivado y no se muestra.'
                    },
                    'section-table-toggle': {
                        title: 'Columna "Activar y Desactivar"',
                        text: 'Interruptor (toggle) para activar o desactivar el slider rápidamente. Gris cuando está desactivado, azul cuando está activado. El cambio se aplica automáticamente al hacer clic. Aparecerá un mensaje de confirmación.'
                    },
                    'section-table-scheduling': {
                        title: 'Columna "Programación"',
                        text: 'Badge que muestra el tipo de programación: "Permanente" (verde) - El slider está siempre activo, "Programado" (amarillo) - El slider tiene fechas/horarios específicos, "Siempre" (azul) - El slider no tiene programación configurada.'
                    },
                    'section-table-transition': {
                        title: 'Columna "Transición"',
                        text: 'Muestra la duración de la transición entre sliders en segundos. Ejemplo: "5s" significa que la transición dura 5 segundos. Controla qué tan rápido cambia de un slider a otro cuando hay múltiples sliders activos.'
                    },
                    'section-table-actions': {
                        title: 'Columna "Acciones"',
                        text: 'Ícono de ojo (azul): Ver detalles del slider. Ícono de lápiz (gris): Editar el slider. Ícono de copiar (gris): Duplicar el slider (crea una copia). Solo aparece si no has alcanzado el límite de sliders. Si has alcanzado el límite, el botón aparece deshabilitado. Ícono de basurero (rojo): Eliminar el slider.'
                    },
                    'section-action-view': {
                        title: 'Acción: Ver Detalles',
                        text: 'Ícono de ojo azul. Te lleva a la página de detalles del slider donde puedes ver toda la información completa, imagen, enlace y programación.'
                    },
                    'section-action-edit': {
                        title: 'Acción: Editar',
                        text: 'Ícono de lápiz gris. Te lleva al formulario de edición del slider.'
                    },
                    'section-action-duplicate': {
                        title: 'Acción: Duplicar',
                        text: 'Ícono de copiar gris. Crea una copia exacta del slider. Importante: Solo puedes duplicar si no has alcanzado el límite de sliders de tu plan. Al duplicar, se copia la imagen, configuración y programación.'
                    },
                    'section-action-delete': {
                        title: 'Acción: Eliminar',
                        text: 'Ícono de basurero rojo. Te permite eliminar el slider. Aparecerá un modal pidiendo confirmación. También puedes eliminar múltiples sliders seleccionándolos con los checkboxes y usando el botón "Eliminar X sliders" en el encabezado.'
                    },
                    'section-action-toggle': {
                        title: 'Acción: Activar/Desactivar',
                        text: 'Interruptor en la columna "Activar y Desactivar". Permite activar o desactivar el slider rápidamente. El estado cambia automáticamente al hacer clic. Aparecerá un mensaje de confirmación.'
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
