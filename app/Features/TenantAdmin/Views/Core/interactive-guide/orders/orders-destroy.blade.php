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
                {{-- Contenido Informativo --}}
                <div class="max-w-4xl mx-auto space-y-6">
                    {{-- Información Importante --}}
                    <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i data-lucide="info" class="w-6 h-6 text-blue-600"></i>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-gray-900 mb-2">Importante: Los Admins NO Eliminan Pedidos</h2>
                                <p class="text-sm font-regular text-gray-700 leading-relaxed mb-3">
                                    <strong>Como administrador de tienda, NO puedes eliminar pedidos directamente.</strong> Solo puedes <strong>cancelar</strong> pedidos cambiando su estado a "Cancelado".
                                </p>
                                <p class="text-sm font-regular text-gray-700 leading-relaxed">
                                    Si necesitas eliminar un pedido completamente del sistema (por ejemplo, pedidos de prueba o duplicados), debes <strong>solicitar al equipo de soporte</strong> que lo haga por ti.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- ¿Qué es Eliminar? --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i data-lucide="trash-2" class="w-6 h-6 text-red-600"></i>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-gray-900 mb-2">¿Qué es Eliminar un Pedido?</h2>
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Eliminar un pedido significa borrarlo completamente del sistema. Una vez eliminado, no podrás recuperarlo ni verlo nuevamente. Esta acción solo puede ser realizada por el equipo de soporte.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Diferencia entre Cancelar y Eliminar --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Diferencia Entre Cancelar y Eliminar</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                <h3 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                    <i data-lucide="x-circle" class="w-5 h-5 text-green-600"></i>
                                    Cancelar un Pedido
                                </h3>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>• Cambia el estado del pedido a "Cancelado"</li>
                                    <li>• El pedido sigue existiendo en el sistema</li>
                                    <li>• Puedes verlo en la lista de pedidos cancelados</li>
                                    <li>• Mantiene un registro histórico</li>
                                    <li><strong>Recomendado:</strong> Usa esta opción para la mayoría de casos</li>
                                </ul>
                            </div>
                            <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                                <h3 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                    <i data-lucide="trash-2" class="w-5 h-5 text-red-600"></i>
                                    Eliminar un Pedido
                                </h3>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>• Borra el pedido completamente del sistema</li>
                                    <li>• No queda ningún registro</li>
                                    <li>• No puedes recuperarlo</li>
                                    <li>• Solo puede ser realizado por el equipo de soporte</li>
                                    <li>• Requiere solicitud previa del admin de tienda</li>
                                    <li><strong>Usar con precaución:</strong> Solo solicita eliminación si realmente no necesitas ningún registro</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- ¿Qué se Elimina? --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">¿Qué se Elimina?</h2>
                        <p class="text-sm text-gray-700 mb-3">
                            Cuando se elimina un pedido, se borra:
                        </p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>El registro del pedido</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>Todos los productos asociados al pedido</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>El comprobante de pago (si había uno subido)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>Toda la información relacionada</span>
                            </li>
                        </ul>
                        <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                            <p class="text-sm font-semibold text-red-800">
                                <strong>IMPORTANTE:</strong> Esta acción no se puede deshacer. Una vez eliminado, no hay forma de recuperar la información.
                            </p>
                        </div>
                    </div>

                    {{-- Cuándo Solicitar Eliminación --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Cuándo Solicitar la Eliminación de un Pedido</h2>
                        <p class="text-sm text-gray-700 mb-3">
                            Solicita al equipo de soporte que elimine un pedido solo si:
                        </p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0"></i>
                                <span>Es un pedido de prueba que creaste durante la configuración</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0"></i>
                                <span>Es un pedido duplicado por error</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0"></i>
                                <span>No necesitas ningún registro de ese pedido</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0"></i>
                                <span>Estás completamente seguro de que no lo necesitarás en el futuro</span>
                            </li>
                        </ul>
                        <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
                            <p class="text-sm text-amber-800">
                                <strong>Recuerda:</strong> En la mayoría de casos, es mejor cancelar el pedido en lugar de solicitarlo para eliminación. Solo solicita eliminación cuando realmente necesites borrar completamente el registro.
                            </p>
                        </div>
                    </div>

                    {{-- Cuándo NO Solicitar Eliminación --}}
                    <div class="bg-red-50 rounded-lg border border-red-200 p-6">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Cuándo NO Solicitar la Eliminación de un Pedido</h2>
                        <p class="text-sm text-gray-700 mb-3 font-semibold">
                            <strong>NO solicites la eliminación de un pedido si</strong>:
                        </p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>Ya está confirmado o en proceso de preparación</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>Ya fue entregado o cancelado</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>Necesitas mantener un registro histórico</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>El cliente ya pagó</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>Quieres mantener estadísticas precisas</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="x" class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"></i>
                                <span>Solo necesitas cambiar algunos datos (usa "Editar" o "Cancelar")</span>
                            </li>
                        </ul>
                        <div class="mt-4 bg-white rounded-lg p-4 border border-red-200">
                            <p class="text-sm text-gray-700">
                                En estos casos, usa la opción <strong>"Cancelar"</strong> en lugar de solicitar la eliminación. Cancelar mantiene el registro y es más seguro.
                            </p>
                        </div>
                    </div>

                    {{-- Qué Hace el Equipo de Soporte --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Qué Hace el Equipo de Soporte</h2>
                        <p class="text-sm text-gray-700 mb-4">
                            Cuando solicitas la eliminación de un pedido, el equipo de soporte:
                        </p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0"></i>
                                <span>Busca el pedido usando el número que le proporcionaste</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0"></i>
                                <span>Verifica que sea el pedido correcto</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0"></i>
                                <span>Elimina el pedido del sistema permanentemente</span>
                            </li>
                        </ul>
                        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800">
                                Todas las eliminaciones quedan registradas para mantener un historial completo.
                            </p>
                        </div>
                    </div>

                    {{-- Qué Información Proporcionar --}}
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Qué Información Proporcionar</h2>
                        <p class="text-sm text-gray-700 mb-4">
                            Cuando solicites la eliminación de un pedido, proporciona al equipo de soporte:
                        </p>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0"></i>
                                <span><strong>Número del pedido:</strong> El número completo del pedido (por ejemplo: #1234 o simplemente 1234)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0"></i>
                                <span><strong>Si son varios pedidos:</strong> Lista todos los números de pedido que necesitas eliminar</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0"></i>
                                <span><strong>Motivo (opcional pero recomendado):</strong> Explica brevemente por qué necesitas eliminar el pedido (ej: "pedido de prueba", "pedido duplicado")</span>
                            </li>
                        </ul>
                        <div class="mt-4 bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-sm text-gray-700 font-medium mb-2">Ejemplo de solicitud:</p>
                            <p class="text-sm text-gray-600 italic">
                                "Hola, necesito eliminar los pedidos #1234, #1235 y #1236. Son pedidos de prueba que creé durante la configuración inicial de la tienda."
                            </p>
                        </div>
                    </div>

                    {{-- Alternativas Recomendadas --}}
                    <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
                        <h2 class="text-base font-semibold text-gray-900 mb-4">Alternativas Recomendadas</h2>
                        <p class="text-sm text-gray-700 mb-4">
                            En lugar de eliminar, considera:
                        </p>
                        <div class="space-y-4">
                            <div class="bg-white rounded-lg p-4 border border-blue-200">
                                <h3 class="font-semibold text-gray-900 mb-2">Cancelar el Pedido</h3>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>• Cambia el estado a "Cancelado"</li>
                                    <li>• Mantiene el registro</li>
                                    <li>• Puedes verlo después</li>
                                    <li>• Más seguro</li>
                                </ul>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-blue-200">
                                <h3 class="font-semibold text-gray-900 mb-2">Editar el Pedido</h3>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>• Si solo necesitas cambiar algunos datos</li>
                                    <li>• No pierdes el registro</li>
                                    <li>• Más flexible</li>
                                </ul>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-blue-200">
                                <h3 class="font-semibold text-gray-900 mb-2">Crear un Pedido Nuevo</h3>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>• Si el pedido original tiene errores</li>
                                    <li>• Puedes crear uno correcto</li>
                                    <li>• Mantienes el original como referencia</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Advertencia Final --}}
                    <div class="bg-red-50 rounded-lg border-2 border-red-300 p-6">
                        <div class="flex items-start gap-4">
                            <i data-lucide="alert-circle" class="w-6 h-6 text-red-600 flex-shrink-0 mt-1"></i>
                            <div>
                                <h2 class="text-base font-semibold text-gray-900 mb-2">Advertencia Final</h2>
                                <p class="text-sm text-gray-700 font-semibold mb-3">
                                    <strong>Eliminar un pedido es una acción permanente e irreversible</strong>. Una vez eliminado por el equipo de soporte, no podrás recuperarlo ni verlo nuevamente.
                                </p>
                                <p class="text-sm text-gray-700">
                                    <strong>En la mayoría de los casos, es mejor cancelar el pedido en lugar de solicitarlo para eliminación.</strong> Solo solicita la eliminación si realmente necesitas borrar completamente el registro (por ejemplo, pedidos de prueba o duplicados).
                                </p>
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
                // Esta vista es principalmente informativa, no necesita interactividad
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
