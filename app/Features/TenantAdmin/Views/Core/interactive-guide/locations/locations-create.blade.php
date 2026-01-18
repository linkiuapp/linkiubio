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
                            <div>
                                <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                    @click="scrollToSection('section-header-title')">Crear nueva sede</h1>
                                <p class="text-sm text-gray-600 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                   @click="scrollToSection('section-header-description')">Completa la información para agregar una nueva sede a tu tienda</p>
                            </div>
                            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                    @click="scrollToSection('section-header-back')">
                                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            </button>
                        </div>

                        {{-- Sección: Información de la sede --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-basic-info')">Información de la sede</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-name')">
                                        Nombre de la sede <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           placeholder="Ej: Sede Centro, Sede Norte, Tienda Principal"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-name')"
                                           readonly>
                                    <p class="text-xs text-gray-500 mt-1">Mínimo 3 caracteres, máximo 100 caracteres. No puede repetirse con otra sede.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-manager')">
                                        Encargado/Responsable
                                    </label>
                                    <input type="text" 
                                           placeholder="Ej: Juan Pérez, María González"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-manager')"
                                           readonly>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-description')">
                                        Descripción
                                    </label>
                                    <textarea rows="3" 
                                              placeholder="Ej: Nuestra sede principal ubicada en el centro de la ciudad"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                              @click="scrollToSection('section-field-description')"
                                              readonly></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-toggle-main')">Sede principal</label>
                                        <p class="text-xs text-gray-500">Solo puede haber una sede principal por tienda</p>
                                    </div>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle-main')">
                                        <input type="checkbox" class="peer sr-only">
                                        <span class="absolute inset-0 bg-gray-300 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out"></span>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-1 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-toggle-status')">Estado</label>
                                        <p class="text-xs text-gray-500">Las sedes inactivas no se mostrarán en el frontend</p>
                                    </div>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-toggle-status')">
                                        <input type="checkbox" class="peer sr-only" checked>
                                        <span class="absolute inset-0 bg-blue-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Contacto y ubicación --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-contact')">Contacto y ubicación</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-phone')">
                                        Teléfono <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           placeholder="Ej: +57 1 234 5678"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-phone')"
                                           readonly>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-whatsapp')">
                                        WhatsApp
                                    </label>
                                    <input type="text" 
                                           placeholder="Ej: +57 300 123 4567"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-whatsapp')"
                                           readonly>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-department')">
                                            Departamento <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               placeholder="Ej: Cundinamarca, Antioquia"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-department')"
                                               readonly>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                               @click="scrollToSection('section-field-city')">
                                            Ciudad <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               placeholder="Ej: Bogotá, Medellín"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                               @click="scrollToSection('section-field-city')"
                                               readonly>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-address')">
                                        Dirección <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           placeholder="Ej: Calle 123 #45-67, Centro"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-address')"
                                           readonly>
                                    <p class="text-xs text-gray-500 mt-1">Mínimo 10 caracteres, máximo 255 caracteres</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-whatsapp-message')">
                                        Mensaje de WhatsApp
                                    </label>
                                    <textarea rows="2" 
                                              placeholder="Ej: Hola, me interesa conocer más sobre sus productos en Sede Centro"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                              @click="scrollToSection('section-field-whatsapp-message')"
                                              readonly></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 255 caracteres</p>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Horarios de atención --}}
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-base font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors"
                                    @click="scrollToSection('section-schedules')">Horarios de atención</h3>
                            </div>

                            {{-- Presets rápidos --}}
                            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="px-4 py-2 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white flex-1"
                                         @click="scrollToSection('section-presets')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        Lunes a Viernes 9am-6pm
                                    </div>
                                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm cursor-pointer"
                                            @click="scrollToSection('section-button-apply-preset')">
                                        Aplicar preset
                                    </button>
                                </div>
                            </div>

                            {{-- Tabla de horarios --}}
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Día</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-schedule-closed')">Cerrado</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-schedule-main')">Horario principal</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-schedule-additional')">Horario adicional</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase cursor-pointer hover:text-blue-600 transition-colors"
                                                @click="scrollToSection('section-schedule-copy')">Copiar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @php
                                            $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                        @endphp
                                        @foreach($days as $day)
                                        <tr>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $day }}</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded cursor-pointer"
                                                       @click="scrollToSection('section-schedule-closed')"
                                                       {{ $day === 'Domingo' ? 'checked' : '' }}>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-2">
                                                    <input type="time" 
                                                           value="{{ $day === 'Domingo' ? '' : '09:00' }}"
                                                           class="px-3 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors"
                                                           @click="scrollToSection('section-schedule-main')"
                                                           {{ $day === 'Domingo' ? 'disabled' : '' }}
                                                           readonly>
                                                    <span class="text-gray-500">a</span>
                                                    <input type="time" 
                                                           value="{{ $day === 'Domingo' ? '' : '18:00' }}"
                                                           class="px-3 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors"
                                                           @click="scrollToSection('section-schedule-main')"
                                                           {{ $day === 'Domingo' ? 'disabled' : '' }}
                                                           readonly>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-2">
                                                    <input type="time" 
                                                           class="px-3 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors"
                                                           @click="scrollToSection('section-schedule-additional')"
                                                           disabled
                                                           readonly>
                                                    <span class="text-gray-500">a</span>
                                                    <input type="time" 
                                                           class="px-3 py-2 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors"
                                                           @click="scrollToSection('section-schedule-additional')"
                                                           disabled
                                                           readonly>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <button class="px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                                        @click="scrollToSection('section-schedule-copy')">
                                                    Copiar
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Sección: Redes sociales --}}
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-base font-semibold text-gray-900 mb-4 cursor-pointer hover:text-blue-600 transition-colors"
                                @click="scrollToSection('section-social')">Redes sociales</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @php
                                    $socialNetworks = ['Facebook', 'Instagram', 'Twitter/X', 'TikTok', 'YouTube', 'LinkedIn', 'WhatsApp Business'];
                                @endphp
                                @foreach($socialNetworks as $network)
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-social-{{ strtolower($network) }}')">
                                        {{ $network }}
                                    </label>
                                    <input type="url" 
                                           placeholder="https://{{ strtolower($network) }}.com/..."
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-social-{{ strtolower($network) }}')"
                                           readonly>
                                </div>
                                @endforeach
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
                                    @click="scrollToSection('section-button-save')">
                                Guardar sede
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
                                <p class="text-sm text-gray-700"><strong>Usa nombres descriptivos</strong> que identifiquen claramente cada sede</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Configura horarios realistas</strong> según el funcionamiento de cada sede</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa los presets</strong> para ahorrar tiempo si varias sedes tienen horarios similares</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Agrega enlaces de redes sociales</strong> para que los clientes puedan seguir a cada sede</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>El mensaje de WhatsApp personalizado</strong> ayuda a los clientes a contactarte más fácilmente</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Verifica que no hayas alcanzado</strong> el límite de sedes de tu plan antes de crear</p>
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
                    'section-header-title': {
                        title: 'Título "Crear nueva sede"',
                        text: 'Muestra que estás creando una nueva sede para tu tienda.'
                    },
                    'section-header-description': {
                        title: 'Descripción',
                        text: 'Texto que dice "Completa la información para agregar una nueva sede a tu tienda". Explica el propósito de esta página.'
                    },
                    'section-header-back': {
                        title: 'Botón "Volver"',
                        text: 'Te regresa al listado de sedes sin guardar cambios.'
                    },
                    'section-basic-info': {
                        title: 'Sección: Información de la sede',
                        text: 'Esta sección contiene los datos principales de la sede: nombre, encargado, descripción, si es principal y su estado.'
                    },
                    'section-field-name': {
                        title: 'Campo "Nombre de la sede"',
                        text: 'Escribe el nombre que identificará esta sede. Ejemplo: "Sede Centro", "Sede Norte", "Tienda Principal". Mínimo 3 caracteres, máximo 100 caracteres. No puede repetirse con otra sede de tu tienda. Este campo es obligatorio.'
                    },
                    'section-field-manager': {
                        title: 'Campo "Encargado/Responsable"',
                        text: 'Nombre de la persona encargada de esta sede. Ejemplo: "Juan Pérez", "María González". Máximo 100 caracteres. Este campo es opcional.'
                    },
                    'section-field-description': {
                        title: 'Campo "Descripción"',
                        text: 'Breve descripción de la sede. Ejemplo: "Nuestra sede principal ubicada en el centro de la ciudad". Máximo 500 caracteres. Este campo es opcional.'
                    },
                    'section-toggle-main': {
                        title: 'Interruptor "Sede principal"',
                        text: 'Activa este interruptor si quieres que esta sea la sede principal. Solo puede haber una sede principal por tienda. Si ya tienes una sede principal, esta nueva se convertirá en la principal y la anterior dejará de serlo.'
                    },
                    'section-toggle-status': {
                        title: 'Interruptor "Estado"',
                        text: 'Activa este interruptor para que la sede esté activa desde el inicio. Si está desactivado, la sede se creará como inactiva. Las sedes inactivas no se mostrarán en el frontend.'
                    },
                    'section-contact': {
                        title: 'Sección: Contacto y ubicación',
                        text: 'Esta sección contiene toda la información de contacto y ubicación física de la sede.'
                    },
                    'section-field-phone': {
                        title: 'Campo "Teléfono"',
                        text: 'Número de teléfono de la sede. Ejemplo: "+57 1 234 5678". Máximo 20 caracteres. Este campo es obligatorio.'
                    },
                    'section-field-whatsapp': {
                        title: 'Campo "WhatsApp"',
                        text: 'Número de WhatsApp de la sede. Ejemplo: "+57 300 123 4567". Máximo 20 caracteres. Este campo es opcional.'
                    },
                    'section-field-department': {
                        title: 'Campo "Departamento"',
                        text: 'Departamento donde está ubicada la sede. Ejemplo: "Cundinamarca", "Antioquia", "Valle del Cauca". Máximo 100 caracteres. Este campo es obligatorio.'
                    },
                    'section-field-city': {
                        title: 'Campo "Ciudad"',
                        text: 'Ciudad donde está ubicada la sede. Ejemplo: "Bogotá", "Medellín", "Cali". Máximo 100 caracteres. Este campo es obligatorio.'
                    },
                    'section-field-address': {
                        title: 'Campo "Dirección"',
                        text: 'Dirección completa de la sede. Ejemplo: "Calle 123 #45-67, Centro". Mínimo 10 caracteres, máximo 255 caracteres. Debe ser una dirección completa y específica. Este campo es obligatorio.'
                    },
                    'section-field-whatsapp-message': {
                        title: 'Campo "Mensaje de WhatsApp"',
                        text: 'Mensaje que se enviará automáticamente cuando un cliente haga clic en el botón de WhatsApp. Ejemplo: "Hola, me interesa conocer más sobre sus productos en Sede Centro". Máximo 255 caracteres. Este mensaje se usará cuando los clientes hagan clic en el botón de WhatsApp de esta sede. Este campo es opcional.'
                    },
                    'section-schedules': {
                        title: 'Sección: Horarios de atención',
                        text: 'Esta sección te permite configurar los horarios de atención de la sede para cada día de la semana.'
                    },
                    'section-presets': {
                        title: 'Presets rápidos',
                        text: 'Selector con opciones predefinidas para llenar los horarios rápidamente. Opciones: "Lunes a Viernes 9am-6pm", "Lunes a Sábado 10am-8pm", "Todos los días 8am-10pm", "24 horas / 7 días", "Nocturno (6pm-2am)". Selecciona un preset y haz clic en "Aplicar preset" para llenar automáticamente los horarios. Puedes ajustar los horarios después de aplicar un preset.'
                    },
                    'section-button-apply-preset': {
                        title: 'Botón "Aplicar preset"',
                        text: 'Aplica el preset seleccionado a todos los días de la semana. Los horarios se llenarán automáticamente según el preset elegido.'
                    },
                    'section-schedule-closed': {
                        title: 'Checkbox "Cerrado"',
                        text: 'Marca esta casilla si la sede está cerrada ese día. Si marcas un día como "Cerrado", no necesitas configurar horarios para ese día.'
                    },
                    'section-schedule-main': {
                        title: 'Horario principal',
                        text: 'Hora de apertura y cierre principal (ejemplo: 09:00 a 18:00). Define cuándo abre y cierra la sede en ese día.'
                    },
                    'section-schedule-additional': {
                        title: 'Horario adicional',
                        text: 'Horario opcional para un segundo turno (ejemplo: 19:00 a 22:00). Útil para horarios con descanso en el medio del día.'
                    },
                    'section-schedule-copy': {
                        title: 'Botón "Copiar"',
                        text: 'Copia el horario de este día a otros días seleccionados. Haz clic en "Copiar" en el día que quieres copiar, se abrirá un modal mostrando todos los demás días, selecciona los días a los que quieres copiar el horario, y haz clic en "Copiar horario". Los horarios se copiarán automáticamente.'
                    },
                    'section-social': {
                        title: 'Sección: Redes sociales',
                        text: 'Esta sección te permite agregar enlaces de redes sociales de la sede. Plataformas disponibles: Facebook, Instagram, Twitter/X, TikTok, YouTube, LinkedIn, WhatsApp Business. Cada campo acepta una URL completa. Ejemplo: "https://facebook.com/mi-sede", "https://instagram.com/mi_sede".'
                    },
                    'section-social-facebook': {
                        title: 'Campo "Facebook"',
                        text: 'URL completa de la página de Facebook de la sede. Ejemplo: "https://facebook.com/mi-sede".'
                    },
                    'section-social-instagram': {
                        title: 'Campo "Instagram"',
                        text: 'URL completa del perfil de Instagram de la sede. Ejemplo: "https://instagram.com/mi_sede".'
                    },
                    'section-social-twitter/x': {
                        title: 'Campo "Twitter/X"',
                        text: 'URL completa del perfil de Twitter/X de la sede.'
                    },
                    'section-social-tiktok': {
                        title: 'Campo "TikTok"',
                        text: 'URL completa del perfil de TikTok de la sede.'
                    },
                    'section-social-youtube': {
                        title: 'Campo "YouTube"',
                        text: 'URL completa del canal de YouTube de la sede.'
                    },
                    'section-social-linkedin': {
                        title: 'Campo "LinkedIn"',
                        text: 'URL completa del perfil de LinkedIn de la sede.'
                    },
                    'section-social-whatsapp business': {
                        title: 'Campo "WhatsApp Business"',
                        text: 'URL completa del perfil de WhatsApp Business de la sede.'
                    },
                    'section-button-cancel': {
                        title: 'Botón "Cancelar"',
                        text: 'Cancela la creación y regresa al listado de sedes. No guarda ningún cambio.'
                    },
                    'section-button-save': {
                        title: 'Botón "Guardar sede"',
                        text: 'Guarda la nueva sede con toda la información configurada. Valida que todos los campos obligatorios estén completos. Si hay errores, los mostrará en rojo debajo de cada campo.'
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
