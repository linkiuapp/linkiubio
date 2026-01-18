{{--
Sidebar Content Push - Sidebar con modo mini y overlay
Implementado con Alpine.js para toggle y dropdown
Con dropdown mejorado (z-index alto) y tooltips en modo minified
--}}

@props([
    'sidebarId' => null,
    'items' => [],
    'footer' => null,
    'showToggle' => true,
])

@php
    $uniqueId = $sidebarId ?? 'sidebar-' . uniqid();
@endphp

<div 
    x-data="{
        isOpen: false,
        isMinified: false,
        openDropdown: false,
        isDesktop: window.innerWidth >= 1024,
        dropdownPosition: { top: 'auto', left: '0px', bottom: 'auto' },
        touchStartX: 0,
        touchEndX: 0,

        init() {
            // Verificar que Alpine esté disponible
            if (typeof Alpine === 'undefined' || !Alpine.store) {
                // Inicializar valores por defecto si Alpine no está disponible
                this.isDesktop = window.innerWidth >= 1024;
                this.isOpen = this.isDesktop;
                return;
            }
            
            // Inicializar Alpine store para compartir estado con navbar
            if (!Alpine.store('sidebar')) {
                Alpine.store('sidebar', {
                    isOpen: false,
                    isMinified: false,
                    isDesktop: window.innerWidth >= 1024
                });
            }

            // Verificar si el sidebar está minificado en el localStorage
            const savedMinified = localStorage.getItem('sidebar_{{ $uniqueId }}_minified');
            if (savedMinified !== null) {
                this.isMinified = savedMinified === 'true';
            }

            // Verificar si es desktop al inicializar
            this.isDesktop = window.innerWidth >= 1024;
            if (this.isDesktop) {
                this.isOpen = true;
            }

            // Sincronizar con store
            const sidebarStore = Alpine.store('sidebar');
            if (sidebarStore) {
                sidebarStore.isOpen = this.isOpen;
                sidebarStore.isMinified = this.isMinified;
                sidebarStore.isDesktop = this.isDesktop;
            }

            // Disparar evento inicial
            this.$nextTick(() => {
                this.dispatchStateChange();
            });

            // Escuchar cambios del store desde el navbar (para móvil)
            window.addEventListener('sidebar-state-changed', (event) => {
                if (event && event.detail && typeof event.detail.isOpen !== 'undefined' && !this.isDesktop) {
                    this.isOpen = event.detail.isOpen;
                }
            });

            // Escuchar cambios de tamaño de ventana
            window.addEventListener('resize', () => {
                this.isDesktop = window.innerWidth >= 1024;
                if (this.isDesktop) {
                    this.isOpen = true;
                } else {
                    this.isOpen = false;
                }

                // Asegurar que el store existe antes de actualizarlo
                if (!Alpine.store('sidebar')) {
                    Alpine.store('sidebar', {
                        isOpen: this.isOpen,
                        isMinified: this.isMinified,
                        isDesktop: this.isDesktop
                    });
                } else {
                    Alpine.store('sidebar').isOpen = this.isOpen;
                    Alpine.store('sidebar').isDesktop = this.isDesktop;
                }

                // Disparar evento
                this.dispatchStateChange();
            });

        },

        dispatchStateChange() {
            window.dispatchEvent(new CustomEvent('sidebar-state-changed', {
                detail: {
                    isMinified: this.isMinified,
                    isDesktop: this.isDesktop,
                    isOpen: this.isOpen
                }
            }));
        },

        toggleSidebar() {
            this.isOpen = !this.isOpen;
            
            // Asegurar que el store existe antes de actualizarlo
            if (!Alpine.store('sidebar')) {
                Alpine.store('sidebar', {
                    isOpen: this.isOpen,
                    isMinified: this.isMinified,
                    isDesktop: this.isDesktop
                });
            } else {
                Alpine.store('sidebar').isOpen = this.isOpen;
            }
            
            // 🔔 Disparar evento
            this.dispatchStateChange();
        },
        
        closeSidebar() {
            this.isOpen = false;
            
            // Asegurar que el store existe antes de actualizarlo
            if (!Alpine.store('sidebar')) {
                Alpine.store('sidebar', {
                    isOpen: false,
                    isMinified: this.isMinified,
                    isDesktop: this.isDesktop
                });
            } else {
                Alpine.store('sidebar').isOpen = false;
            }
            
            // 🔔 Disparar evento
            this.dispatchStateChange();
        },
        
        toggleMinified() {
            this.isMinified = !this.isMinified;
            localStorage.setItem('sidebar_{{ $uniqueId }}_minified', this.isMinified);
            
            // Asegurar que el store existe antes de actualizarlo
            if (!Alpine.store('sidebar')) {
                Alpine.store('sidebar', {
                    isOpen: this.isOpen,
                    isMinified: this.isMinified,
                    isDesktop: this.isDesktop
                });
            } else {
                Alpine.store('sidebar').isMinified = this.isMinified;
            }
            
            // 🔔 Disparar evento
            this.dispatchStateChange();
        },

        toggleDropdown() {
            if (!this.openDropdown) {
                this.calculateDropdownPosition();
            }
            this.openDropdown = !this.openDropdown;
        },

        closeDropdown() {
            this.openDropdown = false;
        },

        calculateDropdownPosition() {
            this.$nextTick(() => {
                const button = this.$refs.dropdownButton;
                if (button) {
                    const rect = button.getBoundingClientRect();
                    const dropdownHeight = 260; // Altura aproximada del dropdown
                    const viewportHeight = window.innerHeight;
                    const sidebarWidth = this.isMinified && this.isDesktop ? 65 : 288; // 288px = 72 * 4 (w-72)

                    if (this.isMinified && this.isDesktop) {
                        // Modo minified: dropdown a la derecha
                        // Calcular si cabe arriba o abajo
                        const spaceAbove = rect.top;
                        const spaceBelow = viewportHeight - rect.bottom;

                        if (spaceBelow >= dropdownHeight) {
                            // Hay espacio abajo
                            this.dropdownPosition = {
                                top: rect.top + 'px',
                                left: (rect.right + 8) + 'px',
                                bottom: 'auto'
                            };
                        } else {
                            // Mostrar arriba del botón
                            this.dropdownPosition = {
                                top: 'auto',
                                left: (rect.right + 8) + 'px',
                                bottom: (viewportHeight - rect.bottom) + 'px'
                            };
                        }
                    } else {
                        // Modo normal: dropdown arriba del botón
                        const spaceAbove = rect.top;

                        if (spaceAbove >= dropdownHeight) {
                            // Hay espacio arriba - mostrar arriba
                            this.dropdownPosition = {
                                top: 'auto',
                                left: '16px', // Margen desde el borde izquierdo
                                bottom: (viewportHeight - rect.top + 8) + 'px'
                            };
                        } else {
                            // Poco espacio arriba - mostrar abajo
                            this.dropdownPosition = {
                                top: (rect.bottom + 8) + 'px',
                                left: '16px',
                                bottom: 'auto'
                            };
                        }
                    }
                }
            });
        },

        handleTouchStart(event) {
            this.touchStartX = event.touches[0].clientX;
        },

        handleTouchEnd(event) {
            this.touchEndX = event.changedTouches[0].clientX;
            this.handleSwipe();
        },

        handleSwipe() {
            const swipeDistance = this.touchEndX - this.touchStartX;
            const minSwipeDistance = 50;

            // Swipe hacia la izquierda para cerrar (solo en móvil)
            if (!this.isDesktop && this.isOpen && swipeDistance < -minSwipeDistance) {
                this.closeSidebar();
            }
            // Swipe hacia la derecha para abrir (solo en móvil)
            else if (!this.isDesktop && !this.isOpen && swipeDistance > minSwipeDistance && this.touchStartX < 50) {
                this.toggleSidebar();
            }
        }
    }"
    x-on:click.away="closeDropdown()"
    class="sidebar-wrapper"
>
    {{-- Navigation Toggle (Mobile) --}}
    <!--@if($showToggle)
        <div class="lg:hidden py-16 text-center">
            <button 
                type="button" 
                @click="toggleSidebar()"
                class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-gray-800 border border-gray-800 text-white text-sm font-medium rounded-lg shadow-2xs align-middle hover:bg-gray-950 focus:outline-hidden focus:bg-gray-900" 
                aria-label="Toggle navigation"
            >
                Abrir
            </button>
        </div>
    @endif-->
    {{-- End Navigation Toggle --}}

    {{-- Overlay (Mobile) con mejores transiciones --}}
    <div
        x-show="isOpen && !isDesktop"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeSidebar()"
        class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-[9998] lg:hidden"
        style="display: none;"
    ></div>
    {{-- End Overlay --}}

    {{-- Sidebar con soporte para gestos táctiles --}}
    <div
        id="{{ $uniqueId }}"
        :class="{
            'translate-x-0': isOpen || isDesktop,
            '-translate-x-full': !isOpen && !isDesktop,
            'w-[65px]': isMinified && isDesktop,
            'w-72': !isMinified || !isDesktop
        }"
        class="fixed top-0 start-0 bottom-0 z-[9999] bg-white border-e border-gray-200 transition-all duration-300 ease-out transform h-full overflow-hidden shadow-xl"
        role="dialog"
        tabindex="-1"
        aria-label="Sidebar"
        x-show="isOpen || isDesktop"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="-translate-x-full opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-250 transform"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="-translate-x-full opacity-0"
        @touchstart="handleTouchStart($event)"
        @touchend="handleTouchEnd($event)"
        style="display: none;"
    >
        <div class="relative flex flex-col h-full max-h-full">

            {{-- Header --}}
            <header class="py-2 px-4 flex items-center gap-x-2"
                :class="isMinified && isDesktop ? 'justify-center' : 'justify-end'">
                {{-- Close Button (Mobile) --}}
                <div class="lg:hidden">
                    <button 
                        type="button" 
                        @click="closeSidebar()"
                        class="flex justify-center items-center gap-x-3 size-6 bg-white border border-gray-200 text-sm text-gray-600 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100" 
                    >
                        <i data-lucide="x" class="shrink-0 size-4"></i>
                        <span class="sr-only">Cerrar</span>
                    </button>
                </div>
                {{-- End Close Button --}}
                
                {{-- Toggle Button (Desktop) --}}
                <div class="hidden lg:block">
                    <button 
                        type="button" 
                        @click="toggleMinified()"
                        class="flex justify-center items-center flex-none gap-x-3 size-9 text-sm text-gray-600 hover:bg-gray-100 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100" 
                        aria-label="Minify navigation"
                    >
                        <i data-lucide="panel-left-open" class="shrink-0 size-6" x-show="isMinified"></i>
                        <i data-lucide="panel-left-close" class="shrink-0 size-6" x-show="!isMinified"></i>
                        <span class="sr-only">Navigation Toggle</span>
                    </button>
                </div>
                {{-- End Toggle Button --}}
            </header>
            {{-- End Header --}}

            {{-- Body --}}
            <nav class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
                <div class="pb-0 px-2 w-full flex flex-col flex-wrap">
                    <ul class="space-y-1">
                        @foreach($items as $item)
                            @php
                                $itemType = $item['type'] ?? 'item';
                            @endphp

                            @if($itemType === 'section')
                                {{-- SECTION: Título de sección con mejor jerarquía visual --}}
                                <li class="mt-5 mb-2 first:mt-0" x-show="!isMinified || !isDesktop">
                                    <p class="px-2.5 py-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide">
                                        {{ $item['title'] ?? '' }}
                                    </p>
                                </li>
                            @elseif($itemType === 'separator')
                                {{-- SEPARATOR: Separador visual --}}
                                <li class="my-2 border-t border-gray-200"></li>
                            @elseif($itemType === 'custom')
                                {{-- CUSTOM: Contenido personalizado --}}
                                <li>
                                    {!! $item['content'] ?? '' !!}
                                </li>
                            @else
                                {{-- ITEM: Item de navegación normal o expandible --}}
                                @php
                                    $label = $item['label'] ?? '';
                                    $url = $item['url'] ?? '#';
                                    $icon = $item['icon'] ?? null;
                                    $active = $item['active'] ?? false;
                                    $badge = $item['badge'] ?? null;
                                    $badgeType = $item['badgeType'] ?? 'info';
                                    $badgeColor = $item['badgeColor'] ?? null;
                                    $children = $item['children'] ?? null;
                                    $hasChildren = !empty($children) && is_array($children);
                                    $uniqueItemId = 'item-' . uniqid();
                                @endphp
                                <li x-data="{ isExpanded: {{ $active ? 'true' : 'false' }} }">
                                    @if($hasChildren)
                                        {{-- ITEM EXPANDIBLE --}}
                                        <button
                                            type="button"
                                            @click="isExpanded = !isExpanded"
                                            class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all duration-200 ease-in-out hover:bg-gray-100 hover:text-gray-900 focus:outline-hidden focus:bg-gray-100 focus:text-gray-900 {{ $active ? 'bg-gray-100 text-gray-900' : '' }} group"
                                            :class="isMinified && isDesktop ? 'justify-center' : 'justify-start'"
                                        >
                                            @if($icon)
                                                <i data-lucide="{{ $icon }}" class="size-5 shrink-0 transition-colors duration-200"></i>
                                            @endif
                                            <span x-show="!isMinified || !isDesktop" class="{{ ($badge !== null && $badge !== '') ? 'flex-1 flex items-center justify-between gap-x-2' : 'flex-1 text-left' }}">
                                                {{ $label }}
                                                @if($badge !== null && $badge !== '')
                                                    @if($badgeColor)
                                                        <span class="ms-auto py-0.5 px-2 inline-flex items-center gap-x-1.5 text-xs rounded-full font-semibold {{ $badgeColor }} transition-all duration-200">
                                                            {{ $badge }}
                                                        </span>
                                                    @else
                                                        <span class="ms-auto py-0.5 px-2 inline-flex items-center gap-x-1.5 text-xs rounded-full font-semibold bg-gray-400 text-white transition-all duration-200">
                                                            {{ $badge }}
                                                        </span>
                                                    @endif
                                                @endif
                                            </span>
                                            <i data-lucide="chevron-down" 
                                               class="size-4 shrink-0 transition-transform duration-200"
                                               :class="{ 'rotate-180': isExpanded }"
                                               x-show="!isMinified || !isDesktop"></i>
                                        </button>
                                        {{-- CHILDREN --}}
                                        <ul x-show="isExpanded && (!isMinified || !isDesktop)" 
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 max-h-0"
                                            x-transition:enter-end="opacity-100 max-h-screen"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 max-h-screen"
                                            x-transition:leave-end="opacity-0 max-h-0"
                                            class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2 overflow-hidden"
                                            style="display: none;">
                                            @foreach($children as $child)
                                                @php
                                                    $childLabel = $child['label'] ?? '';
                                                    $childUrl = $child['url'] ?? '#';
                                                    $childIcon = $child['icon'] ?? null;
                                                    $childActive = $child['active'] ?? false;
                                                    $childBadge = $child['badge'] ?? null;
                                                    $childBadgeColor = $child['badgeColor'] ?? null;
                                                    $childChildren = $child['children'] ?? null;
                                                    $hasChildChildren = !empty($childChildren) && is_array($childChildren);
                                                @endphp
                                                @if($hasChildChildren)
                                                    {{-- CHILD CON CHILDREN (nested) --}}
                                                    <li x-data="{ isChildExpanded: {{ $childActive ? 'true' : 'false' }} }">
                                                        <button
                                                            type="button"
                                                            @click="isChildExpanded = !isChildExpanded"
                                                            class="min-h-[36px] w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-600 rounded-lg transition-all duration-200 ease-in-out hover:bg-gray-50 hover:text-gray-900 focus:outline-hidden {{ $childActive ? 'bg-gray-50 text-gray-900' : '' }}"
                                                        >
                                                            @if($childIcon)
                                                                <i data-lucide="{{ $childIcon }}" class="size-4 shrink-0"></i>
                                                            @endif
                                                            <span class="flex-1 text-left">{{ $childLabel }}</span>
                                                            <i data-lucide="chevron-down" 
                                                               class="size-3 shrink-0 transition-transform duration-200"
                                                               :class="{ 'rotate-180': isChildExpanded }"></i>
                                                        </button>
                                                        <ul x-show="isChildExpanded" 
                                                            x-transition:enter="transition ease-out duration-200"
                                                            x-transition:enter-start="opacity-0 max-h-0"
                                                            x-transition:enter-end="opacity-100 max-h-screen"
                                                            x-transition:leave="transition ease-in duration-150"
                                                            x-transition:leave-start="opacity-100 max-h-screen"
                                                            x-transition:leave-end="opacity-0 max-h-0"
                                                            class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 pl-2 overflow-hidden"
                                                            style="display: none;">
                                                            @foreach($childChildren as $grandChild)
                                                                @php
                                                                    $grandChildLabel = $grandChild['label'] ?? '';
                                                                    $grandChildUrl = $grandChild['url'] ?? '#';
                                                                    $grandChildIcon = $grandChild['icon'] ?? null;
                                                                    $grandChildActive = $grandChild['active'] ?? false;
                                                                @endphp
                                                                <li>
                                                                    <a href="{{ $grandChildUrl }}"
                                                                       class="min-h-[32px] w-full flex items-center gap-x-2 py-1.5 px-2.5 text-sm text-gray-600 rounded-lg transition-all duration-200 ease-in-out hover:bg-gray-50 hover:text-gray-900 focus:outline-hidden {{ $grandChildActive ? 'bg-gray-50 text-gray-900 font-medium' : '' }}">
                                                                        @if($grandChildIcon)
                                                                            <i data-lucide="{{ $grandChildIcon }}" class="size-4 shrink-0"></i>
                                                                        @endif
                                                                        <span>{{ $grandChildLabel }}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    {{-- CHILD SIMPLE --}}
                                                    <li>
                                                        <a href="{{ $childUrl }}"
                                                           class="min-h-[36px] w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-600 rounded-lg transition-all duration-200 ease-in-out hover:bg-gray-50 hover:text-gray-900 focus:outline-hidden {{ $childActive ? 'bg-gray-50 text-gray-900 font-medium' : '' }}">
                                                            @if($childIcon)
                                                                <i data-lucide="{{ $childIcon }}" class="size-4 shrink-0"></i>
                                                            @endif
                                                            <span class="{{ ($childBadge !== null && $childBadge !== '') ? 'flex-1 flex items-center justify-between gap-x-2' : '' }}">{{ $childLabel }}</span>
                                                            @if($childBadge !== null && $childBadge !== '')
                                                                @if($childBadgeColor)
                                                                    <span class="ms-auto py-0.5 px-2 inline-flex items-center gap-x-1.5 text-xs rounded-full font-semibold {{ $childBadgeColor }} transition-all duration-200">
                                                                        {{ $childBadge }}
                                                                    </span>
                                                                @else
                                                                    <span class="ms-auto py-0.5 px-2 inline-flex items-center gap-x-1.5 text-xs rounded-full font-semibold bg-gray-400 text-white transition-all duration-200">
                                                                        {{ $childBadge }}
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        {{-- ITEM SIMPLE --}}
                                        <a
                                            class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all duration-200 ease-in-out hover:bg-gray-100 hover:text-gray-900 focus:outline-hidden focus:bg-gray-100 focus:text-gray-900 {{ $active ? 'bg-gray-100 text-gray-900' : '' }} group"
                                            :class="isMinified && isDesktop ? 'justify-center' : 'justify-start'"
                                            href="{{ $url }}"
                                            x-data="{ showTooltip: false }"
                                            @mouseenter="showTooltip = true; $nextTick(() => {
                                                const rect = $el.getBoundingClientRect();
                                                const tooltip = $refs.tooltip;
                                                if (tooltip) {
                                                    tooltip.style.top = (rect.top + rect.height / 2) + 'px';
                                                    tooltip.style.left = (rect.right + 12) + 'px';
                                                    tooltip.style.transform = 'translateY(-50%)';
                                                }
                                            })"
                                            @mouseleave="showTooltip = false"
                                        >
                                            @if($icon)
                                                <i data-lucide="{{ $icon }}" class="size-5 shrink-0 transition-colors duration-200"></i>
                                            @endif
                                            <span x-show="!isMinified || !isDesktop" class="{{ ($badge !== null && $badge !== '') ? 'flex-1 flex items-center justify-between gap-x-2' : '' }}">
                                                {{ $label }}
                                                @if($badge !== null && $badge !== '')
                                                    @if($badgeColor)
                                                        <span class="ms-auto py-0.5 px-2 inline-flex items-center gap-x-1.5 text-xs rounded-full font-semibold {{ $badgeColor }} transition-all duration-200">
                                                            {{ $badge }}
                                                        </span>
                                                    @else
                                                        <span class="ms-auto transition-all duration-200">
                                                            <x-badge-soft type="{{ $badgeType }}" text="{{ $badge }}" />
                                                        </span>
                                                    @endif
                                                @endif
                                            </span>

                                            {{-- Tooltip para modo minified (Teleported) --}}
                                            <template x-teleport="body">
                                                <div
                                                    x-show="isMinified && isDesktop && showTooltip"
                                                    x-ref="tooltip"
                                                    x-transition:enter="transition ease-out duration-150"
                                                    x-transition:enter-start="opacity-0 scale-95 -translate-x-2"
                                                    x-transition:enter-end="opacity-100 scale-100 translate-x-0"
                                                    x-transition:leave="transition ease-in duration-100"
                                                    x-transition:leave-start="opacity-100 scale-100 translate-x-0"
                                                    x-transition:leave-end="opacity-0 scale-95 -translate-x-2"
                                                    class="fixed z-[99999] px-3 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg whitespace-nowrap pointer-events-none shadow-xl"
                                                    style="display: none;"
                                                >
                                                    {{ $label }}
                                                </div>
                                            </template>
                                        </a>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </nav>
            {{-- End Body --}}

            {{-- Footer --}}
            @if($footer)
                <footer class="mt-auto p-3 border-t border-gray-200">
                    {{-- Account Dropdown --}}
                    <div class="relative w-full inline-flex">
                        <button
                            x-ref="dropdownButton"
                            id="hs-sidebar-footer-{{ $uniqueId }}"
                            type="button"
                            @click="toggleDropdown()"
                            class="w-full inline-flex shrink-0 items-center text-start text-sm font-medium text-gray-800 rounded-lg transition-all duration-200 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100"
                            :class="isMinified && isDesktop ? 'p-2 justify-center' : 'p-2.5 gap-x-3'"
                            aria-haspopup="menu"
                            :aria-expanded="openDropdown"
                            aria-label="Menú de usuario"
                        >
                            @if(isset($footer['avatar']) && $footer['avatar'])
                                <div
                                    :class="{
                                        'size-9': isMinified && isDesktop,
                                        'size-11': !isMinified || !isDesktop
                                    }"
                                    class="shrink-0 rounded-full ring-2 ring-gray-100 transition-all duration-300 overflow-hidden"
                                >
                                    <img
                                        class="w-full h-full object-cover"
                                        src="{{ $footer['avatar'] }}"
                                        alt="Avatar"
                                    >
                                </div>
                            @elseif(isset($footer['initials']))
                                <div
                                    :class="{
                                        'size-9 text-xs': isMinified && isDesktop,
                                        'size-11 text-sm': !isMinified || !isDesktop
                                    }"
                                    class="shrink-0 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center font-bold text-white ring-2 ring-blue-100 transition-all duration-300"
                                >
                                    {{ $footer['initials'] }}
                                </div>
                            @endif
                            <span x-show="!isMinified || !isDesktop" class="flex-1 text-sm font-semibold text-gray-900 truncate">{{ $footer['name'] ?? 'Usuario' }}</span>
                            <i data-lucide="more-vertical" class="shrink-0 size-5 text-gray-500 transition-colors duration-200" :class="openDropdown ? 'text-gray-700' : ''" x-show="!isMinified || !isDesktop"></i>
                        </button>
                    </div>
                    {{-- End Account Dropdown --}}
                </footer>
            @endif
            {{-- End Footer --}}

        </div>
    </div>
    {{-- End Sidebar --}}

    {{-- Dropdown Menu (Teleported to body for proper z-index) --}}
    @if($footer && isset($footer['dropdown']) && is_array($footer['dropdown']) && count($footer['dropdown']) > 0)
        <div
            x-show="openDropdown"
            x-transition:enter="transition ease-out duration-200 transform"
            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
            class="fixed z-[99999] w-64 bg-white border border-gray-200 rounded-xl shadow-2xl"
            :style="{
                top: dropdownPosition.top,
                left: dropdownPosition.left,
                bottom: dropdownPosition.bottom
            }"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="hs-sidebar-footer-{{ $uniqueId }}"
            style="display: none;"
            @click.away="closeDropdown()"
        >
            <div class="p-2">
                @foreach($footer['dropdown'] as $dropdownItem)
                    @php
                        $dropdownLabel = $dropdownItem['label'] ?? '';
                        $dropdownUrl = $dropdownItem['url'] ?? '#';
                        $dropdownIcon = $dropdownItem['icon'] ?? null;
                        $dropdownMethod = $dropdownItem['method'] ?? 'GET';
                    @endphp
                    @if($dropdownMethod === 'POST')
                        <form method="POST" action="{{ $dropdownUrl }}" class="inline w-full">
                            @csrf
                            <button
                                type="submit"
                                @click="closeDropdown()"
                                class="w-full text-left flex items-center gap-x-3 py-2.5 px-3 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 hover:bg-gray-100 hover:text-gray-900 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 focus:text-gray-900"
                            >
                                @if($dropdownIcon)
                                    <i data-lucide="{{ $dropdownIcon }}" class="shrink-0 size-5 transition-colors duration-200"></i>
                                @endif
                                {{ $dropdownLabel }}
                            </button>
                        </form>
                    @else
                        <a
                            @click="closeDropdown()"
                            class="flex items-center gap-x-3 py-2.5 px-3 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 hover:bg-gray-100 hover:text-gray-900 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 focus:text-gray-900"
                            href="{{ $dropdownUrl }}"
                        >
                            @if($dropdownIcon)
                                <i data-lucide="{{ $dropdownIcon }}" class="shrink-0 size-5 transition-colors duration-200"></i>
                            @endif
                            {{ $dropdownLabel }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    {{-- End Dropdown Menu --}}
</div>

@push('scripts')
<script>
// Inicializar iconos de Lucide para este componente
(function() {
    'use strict';

    function initLucideIcons() {
        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
            window.createIcons({ icons: window.lucideIcons });
        } else if (typeof lucide !== 'undefined' && lucide.createIcons) {
            if (typeof lucide.icons !== 'undefined') {
                lucide.createIcons({ icons: lucide.icons });
            }
        }
    }

    // Inicializar iconos cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLucideIcons);
    } else {
        initLucideIcons();
    }

    // Re-inicializar iconos después de cambios en Alpine
    document.addEventListener('alpine:initialized', initLucideIcons);
})();
</script>
@endpush