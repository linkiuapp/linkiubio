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
                <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i data-lucide="info" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 mb-2">Restricción Importante: No se Pueden Eliminar Variables con Productos</h2>
                            <p class="text-sm font-regular text-gray-700 leading-relaxed mb-3">
                                <strong>Solo puedes eliminar variables que NO tengan productos asociados.</strong>
                            </p>
                            <p class="text-sm font-regular text-gray-700 leading-relaxed">
                                Si una variable tiene productos, <strong>NO podrás eliminarla</strong>. Primero debes quitar la variable de todos los productos que la usan o eliminar o modificar los productos que usan esta variable.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ¿Qué es Eliminar una Variable? --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">¿Qué es Eliminar una Variable?</h2>
                    <p class="text-sm text-gray-700 leading-relaxed mb-4">
                        Eliminar una variable significa borrarla completamente del sistema. Una vez eliminada, no podrás recuperarla ni verla nuevamente.
                    </p>
                </div>

                {{-- ¿Dónde se Puede Eliminar? --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">¿Dónde se Puede Eliminar?</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Desde la Vista de Edición (Edit)</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                En la pantalla de edición, hay un botón "Eliminar" en la parte inferior izquierda. Solo aparece si la variable no tiene productos. Al hacer clic, aparece un cuadro de confirmación.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Desde la Lista de Variables (Index)</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                En la tabla de variables, cada fila tiene un icono de papelera en la columna de acciones. Si la variable tiene productos, el icono aparece gris y deshabilitado. Si no tiene productos, puedes hacer clic para eliminar.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Eliminación Múltiple</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                En la lista de variables, puedes seleccionar varias variables usando las casillas de verificación y luego hacer clic en "Eliminar [X] variables". Solo se eliminarán las variables que no tengan productos.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ¿Qué Pasa con las Opciones? --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">¿Qué Pasa con las Opciones?</h2>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <h3 class="text-sm font-medium text-gray-800 mb-2">Si Eliminas una Variable</h3>
                        <p class="text-sm text-gray-700 leading-relaxed mb-2">
                            Cuando eliminas una variable:
                        </p>
                        <ul class="list-disc list-inside text-sm text-gray-700 space-y-1 ml-4">
                            <li>Todas sus opciones se eliminan automáticamente</li>
                            <li>Las opciones no se pueden recuperar</li>
                            <li>Si algún producto estaba usando esas opciones, se quitarán automáticamente</li>
                        </ul>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        <strong>Importante:</strong> Si eliminas una variable que tiene opciones usadas en productos, esas opciones desaparecerán de los productos. Esto puede afectar cómo se muestran los productos en tu tienda.
                    </p>
                </div>

                {{-- ¿Qué se Elimina? --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">¿Qué se Elimina?</h2>
                    <div class="space-y-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Cuando eliminas una variable, se borra:</h3>
                            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1 ml-4">
                                <li>El registro de la variable</li>
                                <li>Todas las opciones asociadas a la variable</li>
                                <li>La relación con los productos (se quita de los productos automáticamente)</li>
                                <li>Toda la información de la variable (nombre, tipo, configuración, etc.)</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-800 mb-2">NO se elimina:</h3>
                            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1 ml-4">
                                <li>Los productos que usaban la variable (solo se les quita la variable)</li>
                                <li>Otras variables</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Alternativas Recomendadas --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">Alternativas Recomendadas</h2>
                    <p class="text-sm text-gray-700 leading-relaxed mb-4">
                        En lugar de eliminar, considera:
                    </p>
                    <div class="space-y-4">
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Desactivar la Variable</h3>
                            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1 ml-4">
                                <li>Cambia el estado a "Inactiva"</li>
                                <li>La variable no se puede usar en productos nuevos</li>
                                <li>Mantiene el registro y las opciones</li>
                                <li>Los productos existentes que la usan siguen funcionando</li>
                                <li>Puedes reactivarla cuando quieras</li>
                                <li><strong>Más seguro:</strong> No pierdes información</li>
                            </ul>
                        </div>
                        <div class="border-l-4 border-green-500 pl-4">
                            <h3 class="text-sm font-medium text-gray-800 mb-2">Quitar de Productos</h3>
                            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1 ml-4">
                                <li>Quita la variable de todos los productos que la usan</li>
                                <li>Luego elimina la variable vacía</li>
                                <li>Mantienes todos tus productos funcionando correctamente</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Advertencia Final --}}
                <div class="bg-red-50 rounded-lg border border-red-200 p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 mb-2">Advertencia Final</h2>
                            <p class="text-sm font-regular text-gray-700 leading-relaxed">
                                <strong>Eliminar una variable es una acción permanente e irreversible.</strong> Asegúrate de estar completamente seguro antes de eliminar cualquier variable. En la mayoría de los casos, es mejor desactivar la variable en lugar de eliminarla.
                            </p>
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
                selectedGuideText: ''
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
