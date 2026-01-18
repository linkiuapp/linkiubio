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
        {{-- Sidebar Fijo --}}
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
                    {{-- Enlace al inicio --}}
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

        {{-- Main Content --}}
        <main class="flex-1 ml-64">
            {{-- Header --}}
            <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
                <div class="px-6 py-4">
                    {{-- Breadcrumbs --}}
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

            {{-- Content Area --}}
            <div class="p-6 space-y-6 pb-32">
                {{-- Vista Real Interactiva --}}
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
                                    @click="scrollToSection('section-header')">Categorías</h1>
                                <p class="text-sm text-gray-600 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                   @click="scrollToSection('section-header')">
                                    Usando 5 de 10 categorías disponibles en tu plan Básico
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm cursor-pointer"
                                        @click="scrollToSection('section-buttons-delete')"
                                        style="display: none;">
                                    Eliminar 2 categorías
                                </button>
                                <a href="#" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                   @click.prevent="scrollToSection('section-buttons-new')">
                                    <i data-lucide="plus" class="w-5 h-5"></i>
                                    Nueva Categoría
                                </a>
                            </div>
                        </div>

                        {{-- Filtros --}}
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="px-3 py-2 pr-8 border border-gray-200 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filters-status')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todos los estados (5)
                                </div>
                                <div class="px-3 py-2 pr-8 border border-gray-200 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-filters-type')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Todas las categorías
                                </div>
                                <div class="text-sm text-gray-600 ml-auto">
                                    Mostrando 1 - 5 de 5 categorías
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
                                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase">
                                                <div class="w-4 h-4 bg-gray-200 rounded"></div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-category')">
                                                <div class="flex items-center gap-2">
                                                    <span>Categoría</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-type')">
                                                <div class="flex items-center gap-2">
                                                    <span>Tipo</span>
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
                                                    <span>Activar/Desactivar</span>
                                                    <i data-lucide="info" class="w-3 h-3 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                                                </div>
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 hover:bg-blue-50 transition-colors group relative"
                                                @click="scrollToSection('section-table-products')">
                                                <div class="flex items-center gap-2">
                                                    <span>Productos</span>
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
                                        @for($i = 0; $i < 1; $i++)
                                        <tr class="hover:bg-gray-50">
                                            {{-- Wireframe: Checkbox --}}
                                            <td class="px-6 py-4 text-center">
                                                <div class="w-4 h-4 bg-gray-200 rounded"></div>
                                            </td>
                                            {{-- Wireframe: Categoría --}}
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <div class="w-6 h-6 bg-gray-300 rounded"></div>
                                                    </div>
                                                    <div class="space-y-1.5">
                                                        <div class="h-3 bg-gray-300 rounded w-24"></div>
                                                        <div class="h-2 bg-gray-200 rounded w-20"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- Wireframe: Tipo --}}
                                            <td class="px-6 py-4">
                                                <div class="h-5 bg-gray-200 rounded-full w-28"></div>
                                            </td>
                                            {{-- Wireframe: Estado --}}
                                            <td class="px-6 py-4">
                                                <div class="h-5 bg-gray-200 rounded-full w-16"></div>
                                            </td>
                                            {{-- Wireframe: Toggle --}}
                                            <td class="px-6 py-4">
                                                <div class="w-11 h-6 bg-gray-200 rounded-full"></div>
                                            </td>
                                            {{-- Wireframe: Productos --}}
                                            <td class="px-6 py-4">
                                                <div class="h-5 bg-gray-200 rounded-full w-8"></div>
                                            </td>
                                            {{-- Wireframe: Acciones --}}
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                                                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                                                    <div class="w-6 h-6 bg-gray-200 rounded"></div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
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
                                <p class="text-sm text-gray-700"><strong>Usa los filtros</strong> para encontrar categorías específicas rápidamente</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Activa/desactiva categorías</strong> usando el interruptor sin necesidad de editarlas</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Organiza tus categorías</strong> creando subcategorías para mejor organización</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa cuántos productos tiene</strong> cada categoría antes de intentar eliminarla</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Las categorías inactivas</strong> no se muestran en tu tienda pero siguen existiendo</p>
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
                        text: '<strong>Título "Categorías":</strong> Muestra el nombre de la sección donde estás. Te indica que estás en la pantalla para administrar todas las categorías de tus productos.<br><br><strong>Información del Plan:</strong> Debajo del título aparece un texto que dice cuántas categorías estás usando y cuántas tienes disponibles según tu plan. Por ejemplo: "Usando 5 de 10 categorías disponibles en tu plan Básico".'
                    },
                    'section-buttons-delete': {
                        title: 'Botón "Eliminar [X] categorías"',
                        text: 'Este botón aparece cuando seleccionas una o más categorías usando las casillas de verificación. Te permite eliminar varias categorías a la vez. Solo puedes eliminar categorías que no tengan productos asociados.'
                    },
                    'section-buttons-new': {
                        title: 'Botón "Nueva Categoría"',
                        text: 'Este botón te lleva a la pantalla para crear una categoría nueva. Si ya alcanzaste el límite de categorías de tu plan, el botón aparece deshabilitado y dice "Límite Alcanzado".'
                    },
                    'section-filters-status': {
                        title: 'Select "Todos los estados"',
                        text: 'Te permite filtrar las categorías por su estado: <strong>Todos los estados:</strong> Muestra todas las categorías (activas e inactivas), <strong>Activas:</strong> Solo muestra las categorías que están activas y visibles en tu tienda, <strong>Inactivas:</strong> Solo muestra las categorías que están desactivadas y no se ven en la tienda. Cada opción muestra entre paréntesis cuántas categorías hay en ese estado.'
                    },
                    'section-filters-type': {
                        title: 'Select "Todas las categorías"',
                        text: 'Te permite filtrar las categorías por su tipo: <strong>Todas las categorías:</strong> Muestra todas (principales y subcategorías), <strong>Solo principales:</strong> Solo muestra las categorías principales (que no tienen categoría padre), <strong>Solo subcategorías:</strong> Solo muestra las subcategorías (que tienen una categoría padre).'
                    },
                    'section-table-category': {
                        title: 'Columna "Categoría"',
                        text: 'Muestra la información principal de cada categoría: <strong>Ícono:</strong> La imagen o icono que representa la categoría, <strong>Nombre:</strong> El nombre de la categoría (en negrita), <strong>Slug:</strong> La URL amigable de la categoría (aparece en texto pequeño y gris), <strong>Descripción:</strong> Si la categoría tiene descripción, aparece debajo del slug (en texto pequeño y gris).'
                    },
                    'section-table-type': {
                        title: 'Columna "Tipo"',
                        text: 'Muestra si la categoría es principal o subcategoría: <strong>Badge azul "Principal":</strong> Es una categoría principal, no tiene categoría padre, <strong>Badge amarillo "Subcategoría de [nombre]":</strong> Es una subcategoría y muestra el nombre de su categoría padre.'
                    },
                    'section-table-status': {
                        title: 'Columna "Estado"',
                        text: 'Muestra si la categoría está activa o inactiva: <strong>Badge verde "Activa":</strong> La categoría está activa y se muestra en tu tienda, <strong>Badge rojo "Inactiva":</strong> La categoría está inactiva y no se muestra en tu tienda.'
                    },
                    'section-table-toggle': {
                        title: 'Columna "Activar/Desactivar"',
                        text: 'Tiene un interruptor (switch) que te permite activar o desactivar la categoría rápidamente sin tener que editarla. Solo haz clic en el interruptor y el estado cambia automáticamente.'
                    },
                    'section-table-products': {
                        title: 'Columna "Productos"',
                        text: 'Muestra cuántos productos tiene asociados esa categoría. Aparece como un badge azul con el número.'
                    },
                    'section-table-actions': {
                        title: 'Columna "Acciones"',
                        text: 'Contiene tres iconos para realizar acciones sobre cada categoría:<br><br><strong>Icono de Ojo (Ver detalles):</strong> Este icono te lleva a la vista detallada de la categoría. Allí puedes ver toda la información completa de la categoría.<br><strong>Icono de Lápiz (Editar):</strong> Este icono te lleva a la pantalla de edición donde puedes modificar los datos de la categoría.<br><strong>Icono de Papelera (Eliminar):</strong> Este icono te permite eliminar la categoría. Solo aparece habilitado si la categoría no tiene productos asociados. Si tiene productos, el icono aparece gris y deshabilitado. Al hacer clic, aparece un cuadro de confirmación.'
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
