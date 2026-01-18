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
                                @click="scrollToSection('section-header-title')">Editar Categoría</h1>
                        </div>

                        {{-- Alerta Informativa --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 cursor-pointer hover:bg-blue-100 transition-colors"
                             @click="scrollToSection('section-alert')">
                            <p class="text-sm text-blue-800">
                                Estás usando <strong>5 de 10</strong> categorías disponibles en tu plan Básico.
                            </p>
                        </div>

                        {{-- Grid de 2 columnas --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            {{-- Selector de Ícono (Izquierda) --}}
                            <div class="bg-white rounded-lg border border-gray-200 p-6">
                                <label class="block text-sm font-medium text-gray-800 mb-3 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-icon-selector')">
                                    Ícono de la categoría <span class="text-red-500">*</span>
                                </label>
                                
                                {{-- Campo de Búsqueda --}}
                                <div class="relative mb-4">
                                    <input type="text"
                                           placeholder="Buscar ícono..."
                                           class="w-full py-2.5 pl-11 pr-4 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-icon-search')"
                                           readonly>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                </div>

                                {{-- Grid de Íconos (Wireframe) --}}
                                <div class="grid grid-cols-4 gap-3 max-h-96 overflow-y-auto">
                                    @for($i = 0; $i < 12; $i++)
                                    <div class="w-full aspect-square bg-gray-100 rounded-lg border-2 {{ $i === 2 ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }} cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors flex items-center justify-center relative"
                                         @click="scrollToSection('section-icon-grid')">
                                        <div class="w-8 h-8 bg-gray-300 rounded"></div>
                                        @if($i === 2)
                                        <div class="absolute -top-1.5 -right-1.5 bg-blue-600 rounded-full p-1 shadow-lg">
                                            <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                        </div>
                                        @endif
                                    </div>
                                    @endfor
                                </div>

                                <p class="text-xs text-gray-500 mt-4">45 íconos disponibles para tu categoría de negocio</p>
                            </div>

                            {{-- Formulario (Derecha) --}}
                            <div class="bg-white rounded-lg border border-gray-200 p-6 space-y-6">
                                {{-- Nombre --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-name')">
                                        Nombre <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           value="Hamburguesas"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-name')"
                                           readonly>
                                </div>

                                {{-- Slug --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-slug')">
                                        Slug (URL)
                                    </label>
                                    <input type="text" 
                                           value="hamburguesas"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                           @click="scrollToSection('section-field-slug')"
                                           readonly>
                                    <p class="text-xs text-gray-500 mt-1 cursor-pointer hover:text-blue-600 transition-colors"
                                       @click="scrollToSection('section-field-slug')">
                                        URL: mi-tienda.com/categoria/hamburguesas
                                    </p>
                                </div>

                                {{-- Descripción --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-description')">
                                        Descripción
                                    </label>
                                    <textarea rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-300 transition-colors resize-none"
                                              @click="scrollToSection('section-field-description')"
                                              readonly>Deliciosas hamburguesas artesanales con ingredientes frescos.</textarea>
                                    <p class="text-xs text-gray-500 mt-1">65 / 500 caracteres</p>
                                </div>

                                {{-- Categoría padre --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-parent')">
                                        Categoría padre (opcional)
                                    </label>
                                    <div class="px-4 py-3 pr-8 border border-gray-300 rounded-lg text-sm cursor-pointer hover:border-blue-300 transition-colors bg-white"
                                         @click="scrollToSection('section-field-parent')"
                                         style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-size: 16px 16px; background-position: right 0.5rem center; background-repeat: no-repeat;">
                                        Ninguna (será categoría principal)
                                    </div>
                                </div>

                                {{-- Toggle Activa --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-800 mb-2 cursor-pointer hover:text-blue-600 transition-colors"
                                           @click="scrollToSection('section-field-active')">
                                        Categoría activa
                                    </label>
                                    <label class="relative inline-block w-11 h-6 cursor-pointer"
                                           @click="scrollToSection('section-field-active')">
                                        <input type="checkbox" class="peer sr-only" checked>
                                        <span class="absolute inset-0 bg-blue-600 rounded-full transition-colors duration-200 ease-in-out"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex gap-3 justify-between pt-4 border-t border-gray-200">
                            <div class="flex gap-3">
                                <button type="button" 
                                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                                        @click="scrollToSection('section-button-cancel')">
                                    Cancelar
                                </button>
                                <button type="button" 
                                        class="px-4 py-2 border border-red-500 text-red-600 rounded-lg hover:bg-red-50 transition-colors cursor-pointer"
                                        @click="scrollToSection('section-button-delete')">
                                    Eliminar
                                </button>
                            </div>
                            <button type="button" 
                                    class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm cursor-pointer"
                                    @click="scrollToSection('section-button-save')">
                                Guardar Cambios
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
                                <p class="text-sm text-gray-700"><strong>Cambia el ícono si es necesario:</strong> Un ícono más representativo puede mejorar la identificación de la categoría</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Ten cuidado al cambiar el slug:</strong> Si cambias la URL, los enlaces antiguos dejarán de funcionar</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>Revisa las alertas:</strong> Las alertas te informan sobre posibles consecuencias de tus cambios</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i data-lucide="check-circle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                                <p class="text-sm text-gray-700"><strong>No puedes eliminar si tiene productos:</strong> Primero debes quitar o mover los productos a otra categoría</p>
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
                        text: 'Este botón te lleva de vuelta a la lista de todas las categorías sin guardar cambios.'
                    },
                    'section-header-title': {
                        title: 'Título "Editar Categoría"',
                        text: 'Muestra que estás editando una categoría existente.'
                    },
                    'section-alert': {
                        title: 'Alerta Informativa',
                        text: 'Aparece una caja azul en la parte superior que muestra: cuántas categorías estás usando actualmente, cuántas categorías tienes disponibles en tu plan, y el nombre de tu plan actual.'
                    },
                    'section-icon-selector': {
                        title: 'Selector de Ícono',
                        text: 'Esta sección es igual que en crear categoría. Te permite cambiar el ícono de la categoría. El ícono actualmente seleccionado aparece con un borde azul y una marca de verificación. Para cambiar el ícono: haz clic en el cuadro del nuevo ícono que quieres, el cuadro se pondrá azul y aparecerá la marca de verificación, y el ícono anterior se desmarcará automáticamente. Debes tener un ícono seleccionado. Este campo es obligatorio.'
                    },
                    'section-icon-search': {
                        title: 'Campo de Búsqueda',
                        text: 'Un cuadro de texto donde puedes buscar íconos por nombre.'
                    },
                    'section-icon-grid': {
                        title: 'Grid de Íconos',
                        text: 'Una cuadrícula con todos los íconos disponibles. El ícono actualmente seleccionado aparece con un borde azul y una marca de verificación.'
                    },
                    'section-field-name': {
                        title: 'Campo "Nombre"',
                        text: 'Un cuadro de texto con el nombre actual de la categoría. Puedes cambiarlo escribiendo un nuevo nombre. Este campo es obligatorio. Máximo 255 caracteres. El nombre debe ser único en tu tienda (excepto el nombre actual de esta categoría). Si cambias el nombre, el slug se actualiza automáticamente (a menos que lo hayas editado manualmente).'
                    },
                    'section-field-slug': {
                        title: 'Campo "Slug (URL)"',
                        text: 'Un cuadro de texto con el slug actual. Puedes cambiarlo si quieres modificar la URL de la categoría. Importante: Si cambias el slug, la URL de la categoría cambiará. Si ya tienes productos o enlaces que apuntan a la URL antigua, esos enlaces dejarán de funcionar. Debajo del campo aparece una vista previa de cómo se verá la nueva URL.'
                    },
                    'section-field-description': {
                        title: 'Campo "Descripción"',
                        text: 'Un cuadro de texto grande con la descripción actual (si tiene). Puedes modificarla o agregar una si no tenía. Máximo 500 caracteres. Aparece un contador que muestra cuántos caracteres has usado. El contador cambia de color cuando te acercas al límite.'
                    },
                    'section-field-parent': {
                        title: 'Campo "Categoría padre (opcional)"',
                        text: 'Un menú desplegable donde puedes cambiar si la categoría es principal o subcategoría. Opciones: "Ninguna (será categoría principal)" - Convierte la categoría en una categoría principal, o Lista de categorías principales - Puedes seleccionar otra categoría como padre para convertirla en subcategoría. Restricciones: No puedes seleccionar la misma categoría como padre. No puedes seleccionar una de sus subcategorías como padre. Si la categoría tiene subcategorías y la conviertes en subcategoría, sus subcategorías actuales se convertirán en categorías principales.'
                    },
                    'section-field-active': {
                        title: 'Toggle "Categoría activa"',
                        text: 'Un interruptor que te permite activar o desactivar la categoría. Estados: Activada (azul) - La categoría se muestra en tu tienda. Desactivada (gris) - La categoría no se muestra en tu tienda.'
                    },
                    'section-button-cancel': {
                        title: 'Botón "Cancelar"',
                        text: 'Este botón (gris) te lleva de vuelta a la lista de categorías sin guardar ningún cambio.'
                    },
                    'section-button-delete': {
                        title: 'Botón "Eliminar"',
                        text: 'Este botón (rojo) aparece solo si la categoría no tiene productos asociados. Te permite eliminar la categoría directamente desde la edición. Al hacer clic, aparece un cuadro de confirmación. Nota: Si la categoría tiene productos, este botón no aparece porque no se puede eliminar.'
                    },
                    'section-button-save': {
                        title: 'Botón "Guardar Cambios"',
                        text: 'Este botón (negro) guarda todos los cambios que hiciste. Después de hacer clic, te lleva de vuelta a la lista de categorías y verás un mensaje de éxito.'
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
