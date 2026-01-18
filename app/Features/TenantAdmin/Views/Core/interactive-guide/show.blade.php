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
        
        /* Tooltip styles */
        .tooltip-area {
            position: absolute;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .tooltip-area:hover {
            background-color: rgba(59, 130, 246, 0.1);
            border: 2px solid rgba(59, 130, 246, 0.5);
        }
        
        .tooltip-content {
            position: absolute;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 50;
            min-width: 200px;
            max-width: 300px;
            pointer-events: none;
        }
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
                
                <nav class="space-y-1" x-data="{ openSections: {} }">
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
                            // Por ahora solo mostrar Pedidos
                            if ($parent['title'] !== 'Pedidos') continue;
                            
                            // Determinar si esta sección debe estar abierta
                            $isCurrentParent = false;
                            foreach ($parent['children'] ?? [] as $child) {
                                if ($child['slug'] === $fullSlug) {
                                    $isCurrentParent = true;
                                    break;
                                }
                            }
                            
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
                                    x-show="openSections['{{ $parentIndex }}'] || {{ $isCurrentParent ? 'true' : 'false' }}"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                                    x-cloak
                                    class="ml-6 mt-1 space-y-1"
                                    style="display: {{ $isCurrentParent ? 'block' : 'none' }};"
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
                            <h1 class="text-2xl font-bold text-gray-900">{{ $sectionTitle }}</h1>
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
            <div class="p-6">
                {{-- Descripción Principal --}}
                @if(!empty($parsedContent['description']))
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-6 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-2">Acerca de esta Vista</h2>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $parsedContent['description'] }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Wireframe con Tooltips --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i data-lucide="layout-template" class="w-5 h-5 text-blue-600"></i>
                        <span>Wireframe de la Interfaz</span>
                    </h2>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-gray-50 min-h-[400px]" id="wireframe-container">
                        {{-- Placeholder para wireframe --}}
                        <div class="p-8 text-center text-gray-500">
                            <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="6" y="6" width="28" height="28" rx="3" fill="white"/>
                                    <rect x="10" y="10" width="18" height="4" rx="2" fill="#C084FC"/>
                                    <rect x="10" y="18" width="12" height="12" rx="2" fill="#C084FC"/>
                                    <rect x="24" y="18" width="4" height="12" rx="2" fill="#C084FC"/>
                                </svg>
                            </div>
                            <p class="font-medium text-gray-700 mb-2">Wireframe de {{ $sectionTitle }}</p>
                            <p class="text-sm text-gray-600 mb-1">Pasa el mouse sobre los elementos para ver su descripción</p>
                            <p class="text-xs text-gray-500 mt-2">El wireframe interactivo se implementará próximamente</p>
                        </div>
                    </div>
                </div>

                {{-- Secciones y Elementos --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                        <i data-lucide="list" class="w-5 h-5 text-blue-600"></i>
                        <span>Guía Completa de Elementos</span>
                    </h2>
                    <div class="space-y-8">
                        @foreach($parsedContent['sections'] ?? [] as $sectionIndex => $sectionItem)
                            <div class="border-l-4 border-blue-500 pl-6 pb-6 {{ $loop->last ? '' : 'border-b border-gray-200 pb-8' }}">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $loop->iteration }}
                                    </span>
                                    <span>{{ $sectionItem['title'] }}</span>
                                </h3>
                                <div class="space-y-3">
                                    @foreach($sectionItem['elements'] ?? [] as $elementIndex => $element)
                                        <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all">
                                            <h4 class="font-semibold text-gray-900 mb-3 text-base flex items-center gap-2">
                                                <i data-lucide="circle" class="w-2 h-2 text-blue-500 fill-blue-500"></i>
                                                <span>{{ $element['title'] }}</span>
                                            </h4>
                                            @if(!empty($element['description']))
                                                <div class="text-sm text-gray-700 leading-relaxed ml-4">
                                                    {!! nl2br(e($element['description'])) !!}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    
                                    @if(empty($sectionItem['elements']))
                                        <p class="text-sm text-gray-500 italic ml-4">No hay elementos documentados en esta sección.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        @if(empty($parsedContent['sections']))
                            <div class="text-center py-12 text-gray-500">
                                <i data-lucide="info" class="w-16 h-16 mx-auto mb-4 text-gray-400"></i>
                                <p class="text-lg font-medium mb-2">Contenido no disponible</p>
                                <p class="text-sm">Esta sección aún no tiene documentación disponible.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function interactiveGuide() {
            return {
                activeTooltip: null,
                
                showTooltip(elementId, event) {
                    this.activeTooltip = {
                        id: elementId,
                        x: event.clientX,
                        y: event.clientY
                    };
                },
                
                hideTooltip() {
                    this.activeTooltip = null;
                }
            }
        }

        // Inicializar iconos
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
