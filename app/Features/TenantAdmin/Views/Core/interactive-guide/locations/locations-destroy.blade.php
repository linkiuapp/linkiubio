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
                {{-- Información Importante --}}
                <div class="bg-red-50 rounded-lg border border-red-200 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 cursor-pointer hover:bg-red-200 transition-colors"
                             @click="scrollToSection('section-restriction')">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-restriction')">Restricción Importante: No se Puede Eliminar la Sede Principal</h2>
                            <p class="text-sm font-regular text-gray-700 leading-relaxed mb-3">
                                <strong>NO puedes eliminar la sede principal.</strong>
                            </p>
                            <p class="text-sm font-regular text-gray-700 leading-relaxed">
                                La sede principal es la sede más importante de tu tienda. Para poder eliminar la sede principal, primero debes establecer otra sede como principal. Luego podrás eliminar la sede que ya no es principal.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                    <h2 class="text-base font-semibold text-blue-600 mb-4 flex items-center gap-2">
                        <i data-lucide="mouse-pointer-click" class="w-5 h-5 text-blue-600"></i>
                        <span>Vista Interactiva - Haz clic sobre los elementos para saber su funcionalidad</span>
                    </h2>
                    
                    <div class="space-y-6 bg-white rounded-lg p-6">
                        {{-- Dónde Puedes Eliminar una Sede --}}
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-where')">Dónde Puedes Eliminar una Sede</h3>
                            
                            <div class="space-y-4">
                                {{-- Desde el Listado --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                     @click="scrollToSection('section-from-list')">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i data-lucide="list" class="w-5 h-5 text-blue-600"></i>
                                        </div>
                                        <h4 class="text-sm font-semibold text-gray-900">Desde el Listado de Sedes</h4>
                                    </div>
                                    <div class="ml-13 space-y-2 text-sm text-gray-700">
                                        <p>1. Ve al listado de sedes</p>
                                        <p>2. En la columna "Acciones", haz clic en el ícono de basurero (rojo)</p>
                                        <p>3. Aparecerá un modal pidiendo confirmación</p>
                                        <p>4. Confirma la eliminación</p>
                                    </div>
                                </div>

                                {{-- Desde los Detalles --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                     @click="scrollToSection('section-from-details')">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i data-lucide="eye" class="w-5 h-5 text-blue-600"></i>
                                        </div>
                                        <h4 class="text-sm font-semibold text-gray-900">Desde los Detalles de la Sede</h4>
                                    </div>
                                    <div class="ml-13 space-y-2 text-sm text-gray-700">
                                        <p>1. Ve a los detalles de la sede que quieres eliminar</p>
                                        <p>2. En la columna lateral "Acciones rápidas", haz clic en "Eliminar sede"</p>
                                        <p>3. Aparecerá un modal pidiendo confirmación</p>
                                        <p>4. Confirma la eliminación</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Proceso de Eliminación --}}
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-process')">Proceso de Eliminación</h3>
                            
                            <div class="space-y-4">
                                {{-- Paso 1 --}}
                                <div class="flex gap-4">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 cursor-pointer hover:bg-blue-200 transition-colors"
                                         @click="scrollToSection('section-step-1')">
                                        <span class="text-sm font-bold text-blue-600">1</span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                            @click="scrollToSection('section-step-1')">Hacer Clic en Eliminar</h4>
                                        <p class="text-sm text-gray-700">Haz clic en el ícono de basurero o en el botón "Eliminar sede". Aparecerá un modal de confirmación.</p>
                                    </div>
                                </div>

                                {{-- Paso 2 --}}
                                <div class="flex gap-4">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 cursor-pointer hover:bg-blue-200 transition-colors"
                                         @click="scrollToSection('section-step-2')">
                                        <span class="text-sm font-bold text-blue-600">2</span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                            @click="scrollToSection('section-step-2')">Modal de Confirmación</h4>
                                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 mt-2">
                                            <p class="text-sm font-semibold text-gray-900 mb-2">¿Eliminar sede?</p>
                                            <p class="text-sm text-gray-700 mb-2">Se eliminará la sede 'Sede Centro' de forma permanente.</p>
                                            <p class="text-sm text-red-600 font-medium">Esta acción no se puede deshacer.</p>
                                            <div class="flex gap-2 mt-4">
                                                <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm cursor-pointer"
                                                        @click.stop="scrollToSection('section-modal-cancel')">
                                                    Cancelar
                                                </button>
                                                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm cursor-pointer"
                                                        @click.stop="scrollToSection('section-modal-confirm')">
                                                    Sí, eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Paso 3 --}}
                                <div class="flex gap-4">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 cursor-pointer hover:bg-blue-200 transition-colors"
                                         @click="scrollToSection('section-step-3')">
                                        <span class="text-sm font-bold text-blue-600">3</span>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                            @click="scrollToSection('section-step-3')">Confirmar Eliminación</h4>
                                        <p class="text-sm text-gray-700">Lee cuidadosamente el mensaje de confirmación. Verifica que es la sede correcta. Haz clic en "Sí, eliminar". La sede se eliminará permanentemente. Aparecerá un mensaje de éxito. Serás redirigido al listado de sedes.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Qué se Elimina --}}
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-what-deletes')">Qué se Elimina</h3>
                            
                            <div class="bg-red-50 rounded-lg border border-red-200 p-4">
                                <p class="text-sm text-gray-700 mb-3">Cuando eliminas una sede, se borra permanentemente:</p>
                                <ul class="space-y-2 text-sm text-gray-700 ml-4">
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="check" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0"></i>
                                        <span>Información de la sede: Nombre, descripción, encargado</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="check" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0"></i>
                                        <span>Contacto: Teléfono, WhatsApp, mensaje de WhatsApp</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="check" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0"></i>
                                        <span>Ubicación: Dirección, ciudad, departamento, coordenadas</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="check" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0"></i>
                                        <span>Horarios: Todos los horarios de atención configurados</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="check" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0"></i>
                                        <span>Redes sociales: Todos los enlaces de redes sociales</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="check" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0"></i>
                                        <span>Estado: Configuración de activa/inactiva, principal</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i data-lucide="check" class="w-4 h-4 text-red-600 mt-0.5 flex-shrink-0"></i>
                                        <span>Estadísticas: Contador de clics de WhatsApp</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Alternativas a la Eliminación --}}
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-alternatives')">Alternativas a la Eliminación</h3>
                            
                            <div class="space-y-3">
                                <div class="bg-blue-50 rounded-lg border border-blue-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                     @click="scrollToSection('section-alternative-deactivate')">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i data-lucide="toggle-left" class="w-5 h-5 text-blue-600"></i>
                                        <h4 class="text-sm font-semibold text-gray-900">Desactivar la Sede</h4>
                                    </div>
                                    <p class="text-sm text-gray-700">En lugar de eliminar, puedes desactivar la sede. La sede dejará de aparecer en el frontend pero se mantendrá en el sistema. Puedes reactivarla más tarde si la necesitas. Ventaja: No pierdes la información.</p>
                                </div>

                                <div class="bg-blue-50 rounded-lg border border-blue-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                     @click="scrollToSection('section-alternative-rename')">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i data-lucide="edit" class="w-5 h-5 text-blue-600"></i>
                                        <h4 class="text-sm font-semibold text-gray-900">Cambiar el Nombre</h4>
                                    </div>
                                    <p class="text-sm text-gray-700">Si el problema es solo el nombre, puedes editarlo. No necesitas eliminar y crear una nueva sede.</p>
                                </div>

                                <div class="bg-blue-50 rounded-lg border border-blue-200 p-4 cursor-pointer hover:border-blue-300 transition-colors"
                                     @click="scrollToSection('section-alternative-update')">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i data-lucide="refresh-cw" class="w-5 h-5 text-blue-600"></i>
                                        <h4 class="text-sm font-semibold text-gray-900">Actualizar la Información</h4>
                                    </div>
                                    <p class="text-sm text-gray-700">Si la sede cambió de ubicación o contacto, puedes actualizar la información. No necesitas eliminar la sede.</p>
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
                                <p class="text-sm text-gray-700"><strong>Antes de eliminar</strong>, exporta o anota la información importante si la necesitas</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Si no estás seguro</strong>, desactiva la sede en lugar de eliminarla</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Verifica siempre</strong> que no sea la sede principal antes de intentar eliminarla</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa si hay pedidos</strong> o información importante asociada a la sede</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Considera el impacto</strong> en tus clientes antes de eliminar una sede activa</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>La eliminación es permanente</strong> e irreversible. Asegúrate de que realmente quieres eliminar la sede</p>
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
                    'section-restriction': {
                        title: 'Restricción Importante',
                        text: 'NO puedes eliminar la sede principal. La sede principal es la sede más importante de tu tienda. Para poder eliminar la sede principal, primero debes establecer otra sede como principal. Luego podrás eliminar la sede que ya no es principal.'
                    },
                    'section-where': {
                        title: 'Dónde Puedes Eliminar una Sede',
                        text: 'Puedes eliminar una sede desde dos lugares: Desde el listado de sedes o desde los detalles de la sede. No hay un botón de eliminar en la edición.'
                    },
                    'section-from-list': {
                        title: 'Desde el Listado de Sedes',
                        text: 'Ve al listado de sedes. En la columna "Acciones", haz clic en el ícono de basurero (rojo). Aparecerá un modal pidiendo confirmación. Confirma la eliminación.'
                    },
                    'section-from-details': {
                        title: 'Desde los Detalles de la Sede',
                        text: 'Ve a los detalles de la sede que quieres eliminar. En la columna lateral "Acciones rápidas", haz clic en "Eliminar sede". Aparecerá un modal pidiendo confirmación. Confirma la eliminación.'
                    },
                    'section-process': {
                        title: 'Proceso de Eliminación',
                        text: 'El proceso de eliminación consta de 3 pasos: Hacer clic en eliminar, revisar el modal de confirmación, y confirmar la eliminación.'
                    },
                    'section-step-1': {
                        title: 'Paso 1: Hacer Clic en Eliminar',
                        text: 'Haz clic en el ícono de basurero o en el botón "Eliminar sede". Aparecerá un modal de confirmación.'
                    },
                    'section-step-2': {
                        title: 'Paso 2: Modal de Confirmación',
                        text: 'El modal muestra: Título "¿Eliminar sede?", Mensaje "Se eliminará la sede \'[Nombre de la sede]\' de forma permanente.", Advertencia "Esta acción no se puede deshacer.", Botones "Cancelar" (cierra el modal sin eliminar) y "Sí, eliminar" (confirma la eliminación).'
                    },
                    'section-modal-cancel': {
                        title: 'Botón "Cancelar"',
                        text: 'Cierra el modal sin eliminar la sede. Te regresa a la vista anterior sin hacer ningún cambio.'
                    },
                    'section-modal-confirm': {
                        title: 'Botón "Sí, eliminar"',
                        text: 'Confirma la eliminación de la sede. La sede se eliminará permanentemente después de hacer clic en este botón.'
                    },
                    'section-step-3': {
                        title: 'Paso 3: Confirmar Eliminación',
                        text: 'Lee cuidadosamente el mensaje de confirmación. Verifica que es la sede correcta. Haz clic en "Sí, eliminar". La sede se eliminará permanentemente. Aparecerá un mensaje de éxito. Serás redirigido al listado de sedes.'
                    },
                    'section-what-deletes': {
                        title: 'Qué se Elimina',
                        text: 'Cuando eliminas una sede, se borra permanentemente: Información de la sede (nombre, descripción, encargado), Contacto (teléfono, WhatsApp, mensaje de WhatsApp), Ubicación (dirección, ciudad, departamento, coordenadas), Horarios (todos los horarios de atención configurados), Redes sociales (todos los enlaces de redes sociales), Estado (configuración de activa/inactiva, principal), Estadísticas (contador de clics de WhatsApp).'
                    },
                    'section-alternatives': {
                        title: 'Alternativas a la Eliminación',
                        text: 'Antes de eliminar una sede, considera estas alternativas: Desactivar la sede, cambiar el nombre, o actualizar la información.'
                    },
                    'section-alternative-deactivate': {
                        title: 'Desactivar la Sede',
                        text: 'En lugar de eliminar, puedes desactivar la sede. La sede dejará de aparecer en el frontend pero se mantendrá en el sistema. Puedes reactivarla más tarde si la necesitas. Ventaja: No pierdes la información.'
                    },
                    'section-alternative-rename': {
                        title: 'Cambiar el Nombre',
                        text: 'Si el problema es solo el nombre, puedes editarlo. No necesitas eliminar y crear una nueva sede.'
                    },
                    'section-alternative-update': {
                        title: 'Actualizar la Información',
                        text: 'Si la sede cambió de ubicación o contacto, puedes actualizar la información. No necesitas eliminar la sede.'
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
