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

        init() {
            console.log('🎬 Sidebar inicializando...');
            
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
            if (Alpine.store('sidebar')) {
                Alpine.store('sidebar').isOpen = this.isOpen;
                Alpine.store('sidebar').isMinified = this.isMinified;
                Alpine.store('sidebar').isDesktop = this.isDesktop;
            }

            // 🔔 Disparar evento inicial
            this.$nextTick(() => {
                this.dispatchStateChange();
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
                
                // 🔔 Disparar evento
                this.dispatchStateChange();
            });
            
            console.log('✅ Sidebar inicializado:', { isDesktop: this.isDesktop, isMinified: this.isMinified, isOpen: this.isOpen });
        },

        dispatchStateChange() {
            window.dispatchEvent(new CustomEvent('sidebar-state-changed', {
                detail: {
                    isMinified: this.isMinified,
                    isDesktop: this.isDesktop,
                    isOpen: this.isOpen
                }
            }));
            console.log('🔔 Sidebar: evento disparado', { isMinified: this.isMinified, isDesktop: this.isDesktop });
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
                    if (this.isMinified && this.isDesktop) {
                        // Posición a la derecha del botón (modo minified)
                        this.dropdownPosition = {
                            top: (rect.top - 140) + 'px',
                            left: (rect.left + 60) + 'px',
                            bottom: 'auto'
                        };
                    } else {
                        // Posición arriba del botón (modo normal)
                        this.dropdownPosition = {
                            top: (rect.top - 100) + 'px',
                            bottom: 'auto',
                            left: (rect.left + 280) + 'px'
                        };
                    }
                }
            });
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

    {{-- Overlay (Mobile) --}}
    <div 
        x-show="isOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeSidebar()"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 lg:hidden"
        style="display: none;"
    ></div>
    {{-- End Overlay --}}

    {{-- Sidebar --}}
    <div 
        id="{{ $uniqueId }}"
        :class="{
            'translate-x-0': isOpen || isDesktop,
            '-translate-x-full': !isOpen && !isDesktop,
            'w-[65px]': isMinified && isDesktop,
            'w-72': !isMinified || !isDesktop
        }"
        class="fixed top-0 start-0 bottom-0 z-60 bg-white border-e border-gray-200 transition-all duration-300 transform h-full overflow-hidden"
        role="dialog"
        tabindex="-1"
        aria-label="Sidebar"
        x-show="isOpen || isDesktop"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
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
                                {{-- SECTION: Título de sección --}}
                                <li class="mt-4 mb-2 first:mt-0" x-show="!isMinified || !isDesktop">
                                    <p class="px-2.5 py-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">
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
                                {{-- ITEM: Item de navegación normal --}}
                                @php
                                    $label = $item['label'] ?? '';
                                    $url = $item['url'] ?? '#';
                                    $icon = $item['icon'] ?? null;
                                    $active = $item['active'] ?? false;
                                    $badge = $item['badge'] ?? null;
                                    $badgeType = $item['badgeType'] ?? 'info';
                                    $badgeColor = $item['badgeColor'] ?? null;
                                @endphp
                                <li>
                                    <a 
                                        class="min-h-[36px] w-full flex items-center gap-x-3.5 py-2 px-2.5 body-small text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 {{ $active ? 'bg-gray-100' : '' }} group" 
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
                                            <i data-lucide="{{ $icon }}" class="size-4 shrink-0"></i>
                                        @endif
                                        <span x-show="!isMinified || !isDesktop" class="{{ $badge ? 'text-nowrap flex-1 flex items-center justify-between' : '' }}">
                                            {{ $label }}
                                            @if($badge)
                                                @if($badgeColor)
                                                    <span class="ms-auto py-0.5 px-1.5 inline-flex items-center gap-x-1.5 text-xs rounded-full font-medium {{ $badgeColor }}">
                                                        {{ $badge }}
                                                    </span>
                                                @else
                                                    <span class="ms-auto">
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
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="fixed z-[99999] px-3 py-1.5 bg-gray-900 text-white text-sm rounded-md whitespace-nowrap pointer-events-none shadow-lg"
                                                style="display: none;"
                                            >
                                                {{ $label }}
                                            </div>
                                        </template>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </nav>
            {{-- End Body --}}

            {{-- Footer --}}
            @if($footer)
                <footer class="mt-auto p-2 border-t border-gray-200">
                    {{-- Account Dropdown --}}
                    <div class="relative w-full inline-flex">
                        <button 
                            x-ref="dropdownButton"
                            id="hs-sidebar-footer-{{ $uniqueId }}" 
                            type="button" 
                            @click="toggleDropdown()"
                            class="w-full inline-flex shrink-0 items-center text-start text-sm text-gray-800 rounded-md hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100" 
                            :class="isMinified && isDesktop ? '' : ' p-2 gap-x-2'"
                            aria-haspopup="menu" 
                            :aria-expanded="openDropdown"
                            aria-label="Dropdown"
                        >
                            @if(isset($footer['avatar']) && $footer['avatar'])
                                <img 
                                    :class="{
                                        'size-8': isMinified && isDesktop,
                                        'size-12': !isMinified || !isDesktop
                                    }"
                                    class="shrink-0 rounded-full transition-all duration-300" 
                                    src="{{ $footer['avatar'] }}" 
                                    alt="Avatar"
                                >
                            @elseif(isset($footer['initials']))
                                <div 
                                    :class="{
                                        'size-8': isMinified && isDesktop,
                                        'size-12': !isMinified || !isDesktop
                                    }"
                                    class="shrink-0 rounded-full bg-gray-200 flex items-center justify-center font-semibold text-gray-600 transition-all duration-300"
                                    :class="isMinified && isDesktop ? 'text-[10px]' : 'text-xs'"
                                >
                                    {{ $footer['initials'] }}
                                </div>
                            @endif
                            <span x-show="!isMinified || !isDesktop" class="caption">{{ $footer['name'] ?? 'Usuario' }}</span>
                            <i data-lucide="ellipsis-vertical" class="shrink-0 size-6 ms-auto" x-show="isMinified && isDesktop"></i>
                            <i data-lucide="ellipsis-vertical" class="shrink-0 size-6 ms-auto" x-show="!isMinified || !isDesktop"></i>
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
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed z-[9999] w-60 bg-white border border-gray-200 rounded-lg shadow-xl"
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
            <div class="p-1">
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
                                class="w-full text-left flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100"
                            >
                                @if($dropdownIcon)
                                    <i data-lucide="{{ $dropdownIcon }}" class="shrink-0 size-4"></i>
                                @endif
                                {{ $dropdownLabel }}
                            </button>
                        </form>
                    @else
                        <a 
                            @click="closeDropdown()"
                            class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100" 
                            href="{{ $dropdownUrl }}"
                        >
                            @if($dropdownIcon)
                                <i data-lucide="{{ $dropdownIcon }}" class="shrink-0 size-4"></i>
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