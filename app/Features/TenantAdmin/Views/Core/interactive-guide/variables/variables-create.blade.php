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
                        <div class="flex items-center gap-3 pb-4 border-b border-gray-200">
                            <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer"
                                    @click="scrollToSection('section-header-back')">
                                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            </button>
                            <h1 class="text-lg font-semibold text-gray-900 cursor-pointer hover:text-blue-600 transition-colors" 
                                @click="scrollToSection('section-header-title')">Nueva Variable</h1>
                        </div>

                        {{-- Alerta Informativa --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 cursor-pointer hover:bg-blue-100 transition-colors"
                             @click="scrollToSection('section-alert')">
                            <p class="text-sm text-blue-800">
                                Estás usando <strong>3 de 10</strong> variables disponibles en tu plan Básico.
                            </p>
                        </div>

                        {{-- Formulario --}}
                        <div class="space-y-6">
                            {{-- Nombre --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-field-name')">
                                    Nombre de la Variable <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       placeholder="Ej: Talla, Color, Material"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                       @click="scrollToSection('section-field-name')"
                                       readonly>
                            </div>

                            {{-- Tipo --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-field-type')">
                                    Tipo <span class="text-red-500">*</span>
                                </label>
                                <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                     @click="scrollToSection('section-field-type')"
                                     style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                    Selecciona un tipo
                                </div>
                            </div>

                            {{-- Requerido por defecto --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-field-required')">
                                    Requerido por defecto
                                </label>
                                <label class="relative inline-block w-11 h-6 cursor-pointer"
                                       @click="scrollToSection('section-field-required')">
                                    <input type="checkbox" class="peer sr-only">
                                    <span class="absolute inset-0 bg-gray-300 rounded-full transition-colors duration-200 ease-in-out"></span>
                                    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out"></span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Esta variable será requerida al crear productos</p>
                            </div>

                            {{-- Campos Numéricos (condicionales) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-min')">
                                        Valor Mínimo
                                    </label>
                                    <input type="number" 
                                           placeholder="0.00"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-min')"
                                           readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-max')">
                                        Valor Máximo
                                    </label>
                                    <input type="number" 
                                           placeholder="100.00"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-max')"
                                           readonly>
                                </div>
                            </div>

                            {{-- Variable activa --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-field-active')">
                                    Variable activa
                                </label>
                                <label class="relative inline-block w-11 h-6 cursor-pointer"
                                       @click="scrollToSection('section-field-active')">
                                    <input type="checkbox" class="peer sr-only" checked>
                                    <span class="absolute inset-0 bg-blue-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Las variables inactivas no se muestran en la tienda</p>
                            </div>

                            {{-- Sección de Opciones (condicional) --}}
                            <div class="border-t border-gray-200 pt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-base font-semibold text-gray-800 cursor-pointer hover:text-blue-600 transition-colors"
                                        @click="scrollToSection('section-options')">Opciones de la Variable</h3>
                                    <button class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors text-sm cursor-pointer"
                                            @click="scrollToSection('section-options-add')">
                                        <i data-lucide="plus" class="w-4 h-4 inline"></i>
                                        Agregar Opción
                                    </button>
                                </div>

                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 cursor-pointer hover:bg-blue-100 transition-colors"
                                     @click="scrollToSection('section-options-alert')">
                                    <p class="text-sm text-blue-800">
                                        <strong>Importante:</strong> Si planeas usar Variantes (controlar stock por combinaciones), los precios que definas aquí serán ignorados. En ese caso, definirás el precio final directamente en cada variante.
                                    </p>
                                </div>

                                {{-- Tarjeta de Opción (ejemplo) --}}
                                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-sm font-semibold text-gray-800">Opción 1</h4>
                                        <button class="text-red-600 hover:text-red-700 transition-colors cursor-pointer"
                                                @click="scrollToSection('section-options-delete')">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-option-name')">
                                            <label class="block text-sm font-medium text-gray-800 mb-2">Nombre <span class="text-red-500">*</span></label>
                                            <input type="text" 
                                                   placeholder="Ej: Rojo, Talla M"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   readonly>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-option-price')">
                                            <label class="block text-sm font-medium text-gray-800 mb-2">Modificador de Precio</label>
                                            <input type="number" 
                                                   placeholder="0.00 (vacío = 0)"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   readonly>
                                            <p class="text-xs text-gray-500 mt-1">Solo aplica para productos simples</p>
                                        </div>
                                        <div class="cursor-pointer hover:text-blue-600 transition-colors"
                                             @click="scrollToSection('section-option-color')">
                                            <label class="block text-sm font-medium text-gray-800 mb-2">Color (hex)</label>
                                            <input type="text" 
                                                   placeholder="#FF0000"
                                                   maxlength="7"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Botones de Acción --}}
                            <div class="flex gap-3 justify-end pt-4 border-t border-gray-200">
                                <button type="button" 
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                        @click="scrollToSection('section-button-cancel')">
                                    Cancelar
                                </button>
                                <button type="button" 
                                        class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                        @click="scrollToSection('section-button-create')">
                                    Crear Variable
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
                                <p class="text-sm text-gray-700"><strong>Elige el tipo correcto:</strong> Piensa en cómo quieres que los clientes interactúen con esta variable</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa nombres claros:</strong> El nombre debe ser fácil de entender para tus clientes</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Agrega suficientes opciones:</strong> Para variables de selección, asegúrate de tener todas las opciones que necesitas</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Configura precios si es necesario:</strong> Los modificadores de precio son útiles para opciones que cambian el costo</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Usa códigos de color:</strong> Para variables de color, agrega el código hex para mejor visualización</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Ten cuidado con checkbox:</strong> Recuerda que no es compatible con variantes, úsala solo para opciones simples</p>
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
                        text: 'Este botón te lleva de vuelta a la lista de todas las variables sin guardar cambios.'
                    },
                    'section-header-title': {
                        title: 'Título "Nueva Variable"',
                        text: 'Muestra que estás creando una variable nueva.'
                    },
                    'section-alert': {
                        title: 'Alerta Informativa',
                        text: 'Aparece una caja azul en la parte superior que muestra: cuántas variables estás usando actualmente, cuántas variables tienes disponibles en tu plan, y el nombre de tu plan actual.'
                    },
                    'section-field-name': {
                        title: 'Campo "Nombre de la Variable"',
                        text: 'Un cuadro de texto donde escribes el nombre de la variable. Este campo es obligatorio (tiene un asterisco *). Máximo 255 caracteres. El nombre debe ser único en tu tienda. Usa nombres claros que tus clientes entiendan fácilmente. Ejemplos: "Talla", "Color", "Material", "Sabor", "Tamaño".'
                    },
                    'section-field-type': {
                        title: 'Campo "Tipo"',
                        text: 'Un menú desplegable donde eliges qué tipo de variable quieres crear. Este campo es obligatorio. Opciones disponibles: <strong>Selección única (Compatible con Variantes):</strong> El cliente elige una sola opción de una lista. Ejemplo: Talla (S, M, L). Compatible con variantes: Puedes controlar el stock por cada combinación. Requiere opciones. <strong>Selección múltiple (NO Compatible con Variantes):</strong> El cliente puede elegir varias opciones de una lista. Ejemplo: Toppings de pizza. NO compatible con variantes. Requiere opciones. Aparece una alerta amarilla explicando esta limitación. <strong>Texto libre:</strong> El cliente escribe cualquier texto que quiera. Ejemplo: Mensaje personalizado. No requiere opciones. <strong>Numérico:</strong> El cliente ingresa un número. Ejemplo: Cantidad de personas. No requiere opciones. Puedes configurar límites: Valor mínimo y máximo. Nota: Al seleccionar el tipo, aparecen o desaparecen campos automáticamente según lo que necesites.'
                    },
                    'section-field-required': {
                        title: 'Toggle "Requerido por defecto"',
                        text: 'Un interruptor que determina si esta variable será obligatoria cuando crees productos. Opciones: Activado - La variable será requerida automáticamente en todos los productos nuevos. Desactivado - La variable será opcional, puedes decidir si usarla o no en cada producto. Por defecto: Desactivado. Puedes activarlo si siempre quieres que esta variable sea obligatoria.'
                    },
                    'section-field-min': {
                        title: 'Campo "Valor Mínimo"',
                        text: 'Este campo solo aparece si seleccionas el tipo "Numérico". Te permite establecer el límite mínimo para los números que los clientes pueden ingresar. Es opcional. Si defines ambos (mínimo y máximo), el máximo debe ser mayor que el mínimo. Si no defines límites, el cliente puede ingresar cualquier número.'
                    },
                    'section-field-max': {
                        title: 'Campo "Valor Máximo"',
                        text: 'Este campo solo aparece si seleccionas el tipo "Numérico". Te permite establecer el límite máximo para los números que los clientes pueden ingresar. Es opcional. Si defines ambos (mínimo y máximo), el máximo debe ser mayor que el mínimo. Si no defines límites, el cliente puede ingresar cualquier número.'
                    },
                    'section-field-active': {
                        title: 'Toggle "Variable activa"',
                        text: 'Un interruptor que te permite activar o desactivar la variable al momento de crearla. Opciones: Activada (azul) - La variable se puede usar en productos. Desactivada (gris) - La variable no se puede usar en productos, pero queda guardada. Por defecto: La variable se crea activada. Puedes desactivarla si no quieres usarla todavía.'
                    },
                    'section-options': {
                        title: 'Sección de Opciones',
                        text: 'Esta sección solo aparece si seleccionas el tipo "Selección única" o "Selección múltiple". Aquí defines las opciones que los clientes podrán elegir. Debes tener al menos una opción para variables de selección.'
                    },
                    'section-options-add': {
                        title: 'Botón "Agregar Opción"',
                        text: 'Este botón te permite agregar una nueva opción a la lista. Cada vez que haces clic, aparece una nueva tarjeta para configurar una opción. Nota: Debes tener al menos una opción para variables de selección.'
                    },
                    'section-options-alert': {
                        title: 'Alerta Informativa',
                        text: 'Aparece una caja azul que explica: Si planeas usar Variantes (controlar stock por combinaciones), los precios que definas aquí serán ignorados. En ese caso, definirás el precio final directamente en cada variante del producto.'
                    },
                    'section-option-name': {
                        title: 'Campo "Nombre" (Opción)',
                        text: 'Un cuadro de texto donde escribes el nombre de la opción. Este campo es obligatorio. Ejemplos: Para variable "Color": "Rojo", "Azul", "Verde". Para variable "Talla": "S", "M", "L", "XL". Para variable "Material": "Algodón", "Poliester", "Lino".'
                    },
                    'section-option-price': {
                        title: 'Campo "Modificador de Precio"',
                        text: 'Un cuadro de número donde puedes definir si esta opción aumenta o disminuye el precio del producto. Es opcional (puedes dejarlo vacío, que será igual a 0). Si pones un número positivo (ej: 5000), aumenta el precio en esa cantidad. Si pones un número negativo (ej: -2000), disminuye el precio en esa cantidad. Solo aplica para productos simples (sin variantes combinadas). Si usas variantes, este precio se ignora.'
                    },
                    'section-option-color': {
                        title: 'Campo "Color (hex)"',
                        text: 'Un cuadro de texto donde puedes escribir un código de color en formato hexadecimal. Es opcional. Formato: # seguido de 6 caracteres (ej: #FF0000 para rojo, #0000FF para azul). Máximo 7 caracteres. Útil para variables de color, así puedes mostrar un círculo de color en la tienda.'
                    },
                    'section-options-delete': {
                        title: 'Botón de Eliminar Opción',
                        text: 'Cada tarjeta de opción tiene un icono de papelera en la esquina superior derecha. Al hacer clic, eliminas esa opción. Restricción: Debes tener al menos una opción. Si solo tienes una opción, el botón de eliminar no aparece.'
                    },
                    'section-button-cancel': {
                        title: 'Botón "Cancelar"',
                        text: 'Este botón (gris) te lleva de vuelta a la lista de variables sin guardar ningún cambio. Úsalo si cambiaste de opinión y no quieres crear la variable.'
                    },
                    'section-button-create': {
                        title: 'Botón "Crear Variable"',
                        text: 'Este botón (negro) guarda la variable con todos los datos que ingresaste. Después de hacer clic, te lleva de vuelta a la lista de variables y verás un mensaje de éxito.'
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
