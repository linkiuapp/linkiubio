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
                                <div>
                                    <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                        @click="scrollToSection('section-header-title')">Detalles de la sede</h1>
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
                                {{-- Información Principal --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-200 transition-colors"
                                             @click="scrollToSection('section-avatar')">
                                            <span class="text-xl font-bold text-blue-600">SC</span>
                                        </div>
                                        <div class="flex-1">
                                            <h2 class="text-xl font-bold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-name')">Sede Centro</h2>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs rounded-full cursor-pointer hover:bg-green-200 transition-colors"
                                                      @click="scrollToSection('section-badge-active')">Activa</span>
                                                <span class="px-2.5 py-1 bg-blue-100 text-blue-700 text-xs rounded-full cursor-pointer hover:bg-blue-200 transition-colors"
                                                      @click="scrollToSection('section-badge-main')">Principal</span>
                                                <span class="px-2.5 py-1 bg-gray-100 text-gray-700 text-xs rounded-full cursor-pointer hover:bg-gray-200 transition-colors"
                                                      @click="scrollToSection('section-badge-location')">Bogotá, Cundinamarca</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 space-y-1 cursor-pointer hover:text-blue-600 transition-colors"
                                         @click="scrollToSection('section-dates')">
                                        <p>Creada el 15 de Enero, 2025 a las 10:30 AM</p>
                                        <p>Actualizada el 20 de Enero, 2025 a las 2:15 PM</p>
                                    </div>
                                </div>

                                {{-- Resumen Rápido --}}
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 cursor-pointer hover:bg-green-100 transition-colors"
                                         @click="scrollToSection('section-card-operational')">
                                        <div class="flex items-center gap-2 mb-2">
                                            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                                            <span class="text-sm font-medium text-gray-700">Estado operativo</span>
                                        </div>
                                        <p class="text-lg font-bold text-green-600">Abierto</p>
                                        <p class="text-xs text-gray-600 mt-1">Cierra a las 18:00</p>
                                    </div>
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 cursor-pointer hover:bg-blue-100 transition-colors"
                                         @click="scrollToSection('section-card-main')">
                                        <div class="flex items-center gap-2 mb-2">
                                            <i data-lucide="star" class="w-5 h-5 text-blue-600"></i>
                                            <span class="text-sm font-medium text-gray-700">Sede principal</span>
                                        </div>
                                        <p class="text-lg font-bold text-blue-600">Sí</p>
                                    </div>
                                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 cursor-pointer hover:bg-purple-100 transition-colors"
                                         @click="scrollToSection('section-card-clicks')">
                                        <div class="flex items-center gap-2 mb-2">
                                            <i data-lucide="message-circle" class="w-5 h-5 text-purple-600"></i>
                                            <span class="text-sm font-medium text-gray-700">Clics en WhatsApp</span>
                                        </div>
                                        <p class="text-lg font-bold text-purple-600">24</p>
                                    </div>
                                </div>

                                {{-- Información de Contacto --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-contact')">Información de Contacto</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-contact-phone')">
                                            <span class="text-xs font-medium text-gray-500">Teléfono:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">+57 1 234 5678</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-contact-whatsapp')">
                                            <span class="text-xs font-medium text-gray-500">WhatsApp:</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <p class="text-sm text-gray-900">+57 300 123 4567</p>
                                                <button class="px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-xs cursor-pointer"
                                                        @click.stop="scrollToSection('section-button-whatsapp')">
                                                    Abrir chat
                                                </button>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-contact-address')">
                                            <span class="text-xs font-medium text-gray-500">Dirección:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Calle 123 #45-67, Centro, Bogotá, Cundinamarca</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Descripción y Mensajes --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-description')">Descripción y Mensajes</h3>
                                    
                                    <div class="space-y-4">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-field-description')">
                                            <span class="text-xs font-medium text-gray-500">Descripción:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Nuestra sede principal ubicada en el centro de la ciudad</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-field-whatsapp-message')">
                                            <span class="text-xs font-medium text-gray-500">Mensaje de WhatsApp:</span>
                                            <p class="text-sm text-gray-900 mt-0.5">Hola, me interesa conocer más sobre sus productos en Sede Centro</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Horarios de Atención --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-schedules')">Horarios de atención</h3>
                                    
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                        @click="scrollToSection('section-schedule-day')">Día</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                        @click="scrollToSection('section-schedule-status')">Estado</th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                        @click="scrollToSection('section-schedule-hours')">Horario</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @php
                                                    $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                                    $currentDay = 'Lunes';
                                                @endphp
                                                @foreach($days as $day)
                                                <tr class="{{ $day === $currentDay ? 'bg-blue-50' : '' }}">
                                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                        {{ $day }}
                                                        @if($day === $currentDay)
                                                        <span class="ml-2 text-xs text-blue-600 font-medium">(Hoy)</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3">
                                                        <span class="px-2 py-1 text-xs rounded-full {{ $day === 'Domingo' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                            {{ $day === 'Domingo' ? 'Cerrado' : 'Abierto' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-900">
                                                        {{ $day === 'Domingo' ? 'No disponible' : '09:00 - 18:00' }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- Redes Sociales --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-social')">Redes sociales</h3>
                                    
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 cursor-pointer hover:border-blue-300 transition-colors"
                                             @click="scrollToSection('section-social-item')">
                                            <i data-lucide="facebook" class="w-5 h-5 text-blue-600"></i>
                                            <span class="text-sm text-gray-700">Facebook</span>
                                            <a href="#" class="ml-auto text-sm text-blue-600 hover:text-blue-700">https://facebook.com/mi-sede</a>
                                        </div>
                                        <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 cursor-pointer hover:border-blue-300 transition-colors"
                                             @click="scrollToSection('section-social-item')">
                                            <i data-lucide="instagram" class="w-5 h-5 text-pink-600"></i>
                                            <span class="text-sm text-gray-700">Instagram</span>
                                            <a href="#" class="ml-auto text-sm text-blue-600 hover:text-blue-700">https://instagram.com/mi_sede</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Columna Lateral (Derecha) --}}
                            <div class="space-y-6">
                                {{-- Estado en Tiempo Real --}}
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg border border-green-200 p-6 cursor-pointer hover:bg-green-100 transition-colors"
                                     @click="scrollToSection('section-realtime')">
                                    <div class="text-center mb-4">
                                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i data-lucide="check-circle" class="w-8 h-8 text-green-600"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-green-600 mb-1">Abierto</h3>
                                        <p class="text-sm text-gray-600">Bogotá, Cundinamarca</p>
                                    </div>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Día actual:</span>
                                            <span class="font-medium text-gray-900">Lunes</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Hora actual:</span>
                                            <span class="font-medium text-gray-900">14:30</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Clics WhatsApp:</span>
                                            <span class="font-medium text-gray-900">24</span>
                                        </div>
                                        <div class="pt-2 border-t border-green-200">
                                            <span class="text-xs text-gray-600">Último cambio:</span>
                                            <p class="text-xs text-gray-700 mt-1">Cierra a las 18:00</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Acciones Rápidas --}}
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-actions')">Acciones rápidas</h3>
                                    
                                    <div class="space-y-2">
                                        <button class="w-full px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-button-set-main')"
                                                style="display: none;">
                                            <i data-lucide="star" class="w-4 h-4 inline"></i>
                                            Establecer como principal
                                        </button>
                                        <button class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-button-deactivate')"
                                                style="display: none;">
                                            Desactivar sede
                                        </button>
                                        <button class="w-full px-4 py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm cursor-pointer"
                                                @click="scrollToSection('section-button-delete')"
                                                style="display: none;">
                                            <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                            Eliminar sede
                                        </button>
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
                                <p class="text-sm text-gray-700"><strong>Revisa regularmente el estado operativo</strong> para verificar que los horarios sean correctos</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa el contador de clics de WhatsApp</strong> para medir el interés de los clientes</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Verifica que los enlaces de redes sociales</strong> funcionen correctamente</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa los horarios especialmente el día actual</strong> para confirmar que están bien configurados</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El estado operativo se calcula en tiempo real</strong> y se actualiza automáticamente según la hora actual y los horarios</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>No puedes desactivar o eliminar la sede principal</strong>. Primero debes establecer otra sede como principal</p>
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
                        title: 'Botón "Volver"',
                        text: 'Te regresa al listado de sedes.'
                    },
                    'section-header-title': {
                        title: 'Título "Detalles de la sede"',
                        text: 'Muestra que estás viendo la información detallada de una sede.'
                    },
                    'section-header-edit': {
                        title: 'Botón "Editar"',
                        text: 'Te lleva a la página de edición de esta sede.'
                    },
                    'section-avatar': {
                        title: 'Avatar de la sede',
                        text: 'Círculo con las primeras dos letras del nombre de la sede en mayúsculas. Fondo azul.'
                    },
                    'section-name': {
                        title: 'Nombre de la sede',
                        text: 'Muestra el nombre completo de la sede. Aparece en negrita.'
                    },
                    'section-badge-active': {
                        title: 'Badge "Activa" o "Inactiva"',
                        text: 'Muestra el estado de la sede. Badge verde "Activa" o badge rojo "Inactiva".'
                    },
                    'section-badge-main': {
                        title: 'Badge "Principal"',
                        text: 'Si es la sede principal, aparece un badge azul con el texto "Principal".'
                    },
                    'section-badge-location': {
                        title: 'Badge de ubicación',
                        text: 'Muestra ciudad y departamento en un badge gris. Ejemplo: "Bogotá, Cundinamarca".'
                    },
                    'section-dates': {
                        title: 'Fechas',
                        text: 'Fecha de creación: "Creada el [fecha y hora]". Fecha de actualización: "Actualizada el [fecha y hora]".'
                    },
                    'section-card-operational': {
                        title: 'Tarjeta "Estado operativo"',
                        text: 'Muestra el estado actual de la sede según sus horarios: "Abierto" (verde) - La sede está abierta ahora, "Cerrado temporalmente" (amarillo) - Cerrada temporalmente, "Cerrado" (rojo) - Cerrada según horario o inactiva. Muestra un mensaje adicional con información sobre cuándo cambiará el estado.'
                    },
                    'section-card-main': {
                        title: 'Tarjeta "Sede principal"',
                        text: 'Indica si esta sede es la principal (Sí/No).'
                    },
                    'section-card-clicks': {
                        title: 'Tarjeta "Clics en WhatsApp"',
                        text: 'Muestra cuántas veces los clientes han hecho clic en el botón de WhatsApp de esta sede. Útil para medir el interés de los clientes.'
                    },
                    'section-contact': {
                        title: 'Sección: Información de Contacto',
                        text: 'Esta sección muestra toda la información de contacto de la sede.'
                    },
                    'section-contact-phone': {
                        title: 'Teléfono',
                        text: 'Muestra el número de teléfono de la sede.'
                    },
                    'section-contact-whatsapp': {
                        title: 'WhatsApp',
                        text: 'Muestra el número de WhatsApp si está configurado. Incluye un botón "Abrir chat" que abre WhatsApp con el número y mensaje configurado. Al hacer clic, se incrementa el contador de clics.'
                    },
                    'section-button-whatsapp': {
                        title: 'Botón "Abrir chat"',
                        text: 'Abre WhatsApp con el número y mensaje preconfigurado. El contador de clics se incrementa automáticamente.'
                    },
                    'section-contact-address': {
                        title: 'Dirección',
                        text: 'Muestra la dirección completa: dirección, ciudad, departamento.'
                    },
                    'section-description': {
                        title: 'Sección: Descripción y Mensajes',
                        text: 'Esta sección muestra la descripción y el mensaje de WhatsApp configurado.'
                    },
                    'section-field-description': {
                        title: 'Descripción',
                        text: 'Muestra la descripción de la sede si está configurada. Si no hay descripción, muestra "Sin descripción registrada".'
                    },
                    'section-field-whatsapp-message': {
                        title: 'Mensaje de WhatsApp',
                        text: 'Muestra el mensaje automático que se envía cuando un cliente hace clic en WhatsApp. Si no está configurado, muestra "Sin mensaje automático configurado".'
                    },
                    'section-schedules': {
                        title: 'Sección: Horarios de atención',
                        text: 'Esta sección muestra una tabla con los horarios configurados para cada día de la semana.'
                    },
                    'section-schedule-day': {
                        title: 'Columna "Día"',
                        text: 'Muestra el nombre del día (Lunes, Martes, etc.). Si es el día actual, aparece en azul con el texto "(Hoy)".'
                    },
                    'section-schedule-status': {
                        title: 'Columna "Estado"',
                        text: 'Badge "Abierto" (verde) o "Cerrado" (rojo). Muestra si la sede está abierta o cerrada ese día según los horarios configurados.'
                    },
                    'section-schedule-hours': {
                        title: 'Columna "Horario"',
                        text: 'Muestra los horarios configurados: Horario principal: "09:00 - 18:00", Horario adicional (si existe): "19:00 - 22:00", Si está cerrado: "No disponible". La fila del día actual aparece con fondo azul claro para destacarla.'
                    },
                    'section-social': {
                        title: 'Sección: Redes sociales',
                        text: 'Esta sección muestra todas las redes sociales configuradas para la sede.'
                    },
                    'section-social-item': {
                        title: 'Lista de enlaces',
                        text: 'Muestra todas las redes sociales configuradas. Para cada red muestra: Ícono de la red, Nombre de la plataforma, Enlace clicable que abre en una nueva pestaña. Si no hay redes configuradas, muestra un estado vacío con el mensaje "Sin redes registradas".'
                    },
                    'section-realtime': {
                        title: 'Tarjeta "Estado en tiempo real"',
                        text: 'Ícono grande que indica el estado actual (abierto/cerrado). Muestra el estado operativo en texto grande. Muestra la ciudad y departamento. Información adicional: Día actual (muestra qué día de la semana es hoy), Hora actual (muestra la hora actual), Clics WhatsApp (muestra el contador de clics si WhatsApp está configurado), Último cambio (información sobre cuándo cambiará el estado).'
                    },
                    'section-actions': {
                        title: 'Sección: Acciones rápidas',
                        text: 'Esta sección muestra botones para realizar acciones rápidas sobre la sede.'
                    },
                    'section-button-set-main': {
                        title: 'Botón "Establecer como principal"',
                        text: 'Solo aparece si esta sede NO es la principal. Al hacer clic, esta sede se convierte en la principal. La sede anterior dejará de ser principal.'
                    },
                    'section-button-deactivate': {
                        title: 'Botón "Desactivar sede" o "Activar sede"',
                        text: 'Cambia según el estado actual. No aparece deshabilitado si es la sede principal (no puedes desactivarla). Al hacer clic, cambia el estado de la sede.'
                    },
                    'section-button-delete': {
                        title: 'Botón "Eliminar sede"',
                        text: 'Solo aparece si esta sede NO es la principal. Al hacer clic, aparece un modal de confirmación. No puedes eliminar la sede principal.'
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
