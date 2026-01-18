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
                            <div class="flex items-center gap-4">
                                <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                        @click="scrollToSection('section-header-back')">
                                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                                </button>
                                <div>
                                    <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                        @click="scrollToSection('section-header-title')">Detalles de Categoría</h1>
                                    <p class="text-sm text-gray-500 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-header-description')">Información completa de la categoría</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="px-4 py-2 border border-gray-500 text-gray-600 rounded-lg hover:bg-blue-700 hover:text-white hover:border-blue-700 transition-colors text-sm font-medium cursor-pointer"
                                        @click="scrollToSection('section-header-edit')">
                                    <i data-lucide="edit" class="w-4 h-4 inline"></i>
                                    Editar
                                </button>
                                <button class="px-4 py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-700 hover:text-white hover:border-red-700 transition-colors text-sm font-medium cursor-pointer"
                                        @click="scrollToSection('section-header-delete')">
                                    <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                    Eliminar
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            {{-- Columna Izquierda --}}
                            <div class="space-y-6">
                                {{-- Ícono --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-icon')">Ícono</h2>
                                    <div class="flex items-center justify-center rounded-lg border-2 border-blue-100 bg-blue-50 p-12">
                                        <div class="w-28 h-28 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-300 rounded"></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Estado --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-status')">Estado</h2>
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-status-visibility')">
                                            <span class="text-sm text-gray-600">Visibilidad</span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                <i data-lucide="eye" class="w-3 h-3"></i>
                                                Activa
                                            </span>
                                        </div>
                                        <div class="border-t border-gray-200"></div>
                                        <div class="flex items-center justify-between cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-status-products')">
                                            <span class="text-sm text-gray-600">Productos</span>
                                            <span class="text-sm font-semibold text-gray-900">12</span>
                                        </div>
                                        <div class="border-t border-gray-200"></div>
                                        <div class="flex items-center justify-between cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-status-children')">
                                            <span class="text-sm text-gray-600">Subcategorías</span>
                                            <span class="text-sm font-semibold text-gray-900">3</span>
                                        </div>
                                        <div class="border-t border-gray-200"></div>
                                        <div class="space-y-2 cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-status-dates')">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-600">Creada</span>
                                                <span class="text-sm text-gray-900">8 Ene 2025</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-600">Actualizada</span>
                                                <span class="text-sm text-gray-900">8 Ene 2025</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Columna Derecha --}}
                            <div class="lg:col-span-2 space-y-6">
                                {{-- Información General --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <div class="mb-6">
                                        <h2 class="text-base font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                            @click="scrollToSection('section-info')">Información General</h2>
                                        <p class="text-xs text-gray-500 mt-1">Detalles y configuración de la categoría</p>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-name')">
                                            <label class="block text-xs font-medium text-gray-600 mb-2">Nombre</label>
                                            <p class="text-sm font-semibold text-gray-900">Hamburguesas</p>
                                        </div>
                                        <div class="border-t border-gray-200"></div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-slug')">
                                            <label class="block text-xs font-medium text-gray-600 mb-2">Slug (URL)</label>
                                            <div class="bg-gray-50 rounded-lg px-4 py-3 border border-gray-200">
                                                <code class="text-sm text-gray-900 break-all">
                                                    mi-tienda.com/categoria/<span class="font-semibold text-blue-600">hamburguesas</span>
                                                </code>
                                            </div>
                                        </div>
                                        <div class="border-t border-gray-200"></div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-description')">
                                            <label class="block text-xs font-medium text-gray-600 mb-2">Descripción</label>
                                            <p class="text-sm text-gray-900 leading-relaxed">Deliciosas hamburguesas artesanales con ingredientes frescos.</p>
                                        </div>
                                        <div class="border-t border-gray-200"></div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-info-parent')">
                                            <label class="block text-xs font-medium text-gray-600 mb-2">Categoría Padre</label>
                                            <p class="text-sm text-gray-600">Categoría principal (sin padre)</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Vista Previa SEO --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <div class="mb-6">
                                        <h2 class="text-base font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                            @click="scrollToSection('section-seo')">Vista Previa SEO</h2>
                                        <p class="text-xs text-gray-500 mt-1">Cómo se verá en buscadores</p>
                                    </div>
                                    <div class="space-y-2 rounded-lg border border-gray-200 bg-gray-50 p-5 cursor-pointer hover:bg-gray-100 transition-colors"
                                         @click="scrollToSection('section-seo-preview')">
                                        <div class="flex items-center gap-2 text-xs text-gray-600">
                                            <span class="inline-flex items-center gap-1.5">
                                                <span class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-[10px] font-bold">
                                                    <i data-lucide="globe" class="w-4 h-4 text-white"></i>
                                                </span>
                                                <span>Mi Tienda</span>
                                            </span>
                                            <span>›</span>
                                            <span>Categorías</span>
                                            <span>›</span>
                                            <span>Hamburguesas</span>
                                        </div>
                                        <h3 class="text-sm font-medium text-blue-600 hover:underline">Hamburguesas - Mi Tienda</h3>
                                        <p class="text-xs text-gray-700 leading-relaxed">Deliciosas hamburguesas artesanales con ingredientes frescos.</p>
                                    </div>
                                </div>

                                {{-- Subcategorías --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <div class="mb-4">
                                        <h2 class="text-base font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                            @click="scrollToSection('section-children')">Subcategorías</h2>
                                        <p class="text-xs text-gray-500 mt-1">3 subcategorías en esta categoría</p>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @for($i = 0; $i < 3; $i++)
                                        <div class="block bg-gray-50 border border-gray-200 rounded-lg p-4 hover:bg-gray-100 hover:border-gray-300 transition-all cursor-pointer"
                                             @click="scrollToSection('section-children-item')">
                                            <div class="flex items-center gap-3">
                                                <div class="shrink-0 w-10 h-10 bg-white rounded-lg border border-gray-200 p-1.5 flex items-center justify-center">
                                                    <div class="w-full h-full bg-gray-200 rounded"></div>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="h-3 bg-gray-300 rounded w-24 mb-1"></div>
                                                    <div class="h-2 bg-gray-200 rounded w-16"></div>
                                                </div>
                                                <div class="shrink-0">
                                                    <span class="w-2 h-2 bg-green-500 rounded-full block"></span>
                                                </div>
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
                                <p class="text-sm text-gray-700"><strong>Revisa la vista previa SEO:</strong> Te ayuda a entender cómo los clientes encontrarán tu categoría</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Navega a subcategorías:</strong> Haz clic en las subcategorías para ver sus detalles</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa las fechas:</strong> Te ayudan a saber cuándo se creó y cuándo se modificó por última vez</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa el botón Editar:</strong> Para modificar cualquier información de la categoría</p>
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
                        text: 'Este botón te lleva de vuelta a la lista de todas las categorías.'
                    },
                    'section-header-title': {
                        title: 'Título "Detalles de Categoría"',
                        text: 'Muestra que estás viendo la información detallada de una categoría.'
                    },
                    'section-header-description': {
                        title: 'Descripción',
                        text: 'Un texto pequeño que dice "Información completa de la categoría".'
                    },
                    'section-header-edit': {
                        title: 'Botón "Editar"',
                        text: 'Este botón (gris con borde) te lleva a la pantalla de edición donde puedes modificar los datos de la categoría.'
                    },
                    'section-header-delete': {
                        title: 'Botón "Eliminar"',
                        text: 'Este botón (rojo con borde) te permite eliminar la categoría. Al hacer clic, aparece un cuadro de confirmación. Solo puedes eliminar si la categoría no tiene productos.'
                    },
                    'section-icon': {
                        title: 'Tarjeta "Ícono"',
                        text: 'Muestra el ícono grande de la categoría en un cuadro azul claro. El ícono aparece centrado y grande para que puedas verlo claramente.'
                    },
                    'section-status': {
                        title: 'Tarjeta "Estado"',
                        text: 'Muestra información sobre el estado y estadísticas de la categoría.'
                    },
                    'section-status-visibility': {
                        title: 'Visibilidad',
                        text: 'Muestra si la categoría está activa o inactiva: Badge verde "Activa" con icono de ojo: La categoría está activa y se muestra en tu tienda. Badge gris "Inactiva" con icono de ojo cerrado: La categoría está inactiva y no se muestra en tu tienda.'
                    },
                    'section-status-products': {
                        title: 'Productos',
                        text: 'Muestra cuántos productos tiene asociados esta categoría. Aparece como un número en negrita.'
                    },
                    'section-status-children': {
                        title: 'Subcategorías',
                        text: 'Solo aparece si la categoría es principal (no tiene padre). Muestra cuántas subcategorías tiene esta categoría.'
                    },
                    'section-status-dates': {
                        title: 'Fechas',
                        text: 'Muestra dos fechas: Creada: La fecha en que se creó la categoría. Actualizada: La fecha en que se modificó por última vez.'
                    },
                    'section-info': {
                        title: 'Tarjeta "Información General"',
                        text: 'Muestra todos los datos principales de la categoría.'
                    },
                    'section-info-name': {
                        title: 'Nombre',
                        text: 'El nombre completo de la categoría en texto grande y negrita.'
                    },
                    'section-info-slug': {
                        title: 'Slug (URL)',
                        text: 'Muestra la URL completa de la categoría. El slug aparece destacado en azul para que sea fácil de identificar. Esta es la dirección que los clientes usarán para acceder a esta categoría en tu tienda.'
                    },
                    'section-info-description': {
                        title: 'Descripción',
                        text: 'Muestra la descripción de la categoría si tiene una. Si no tiene descripción, aparece un texto en gris que dice "No hay descripción disponible".'
                    },
                    'section-info-parent': {
                        title: 'Categoría Padre',
                        text: 'Muestra si esta categoría es principal o subcategoría: Si es subcategoría: Aparece un badge con el nombre de su categoría padre. Puedes hacer clic en el badge para ver los detalles de la categoría padre. También aparece un texto que dice "(Subcategoría)". Si es principal: Aparece un texto que dice "Categoría principal (sin padre)".'
                    },
                    'section-seo': {
                        title: 'Tarjeta "Vista Previa SEO"',
                        text: 'Muestra cómo se verá esta categoría en los buscadores (como Google). Esto te ayuda a entender cómo los clientes encontrarán tu categoría cuando busquen en internet.'
                    },
                    'section-seo-preview': {
                        title: 'Elementos de la vista previa',
                        text: 'Breadcrumb (Ruta de navegación): Muestra la ruta completa: Nombre de tu tienda > Categorías > Nombre de la categoría. Título: Muestra cómo aparecerá el título en los resultados de búsqueda (Nombre de categoría - Nombre de tienda). Descripción: Muestra la descripción de la categoría (o un texto por defecto si no tiene descripción). Los buscadores muestran aproximadamente 160 caracteres.'
                    },
                    'section-children': {
                        title: 'Tarjeta "Subcategorías"',
                        text: 'Esta tarjeta solo aparece si la categoría tiene subcategorías. Muestra todas las subcategorías de esta categoría en una cuadrícula.'
                    },
                    'section-children-item': {
                        title: 'Cada subcategoría muestra',
                        text: 'Ícono: El ícono de la subcategoría. Nombre: El nombre de la subcategoría. Cantidad de productos: Cuántos productos tiene esa subcategoría. Indicador de estado: Un punto verde si está activa, gris si está inactiva. Puedes hacer clic en cualquier subcategoría para ver sus detalles completos.'
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
