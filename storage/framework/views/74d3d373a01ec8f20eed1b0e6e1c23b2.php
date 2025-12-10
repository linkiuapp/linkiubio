

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'sidebarId' => null,
    'items' => [],
    'footer' => null,
    'showToggle' => true,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'sidebarId' => null,
    'items' => [],
    'footer' => null,
    'showToggle' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $uniqueId = $sidebarId ?? 'sidebar-' . uniqid();
?>

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
            const savedMinified = localStorage.getItem('sidebar_<?php echo e($uniqueId); ?>_minified');
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
            localStorage.setItem('sidebar_<?php echo e($uniqueId); ?>_minified', this.isMinified);
            
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
    
    <!--<?php if($showToggle): ?>
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
    <?php endif; ?>-->
    

    
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
    

    
    <div
        id="<?php echo e($uniqueId); ?>"
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

            
            <header class="py-2 px-4 flex items-center gap-x-2"
                :class="isMinified && isDesktop ? 'justify-center' : 'justify-end'">
                
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
                
            </header>
            

            
            <nav class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
                <div class="pb-0 px-2 w-full flex flex-col flex-wrap">
                    <ul class="space-y-1">
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $itemType = $item['type'] ?? 'item';
                            ?>

                            <?php if($itemType === 'section'): ?>
                                
                                <li class="mt-5 mb-2 first:mt-0" x-show="!isMinified || !isDesktop">
                                    <p class="px-2.5 py-1.5 text-xs font-bold text-gray-600 uppercase tracking-wide">
                                        <?php echo e($item['title'] ?? ''); ?>

                                    </p>
                                </li>
                            <?php elseif($itemType === 'separator'): ?>
                                
                                <li class="my-2 border-t border-gray-200"></li>
                            <?php elseif($itemType === 'custom'): ?>
                                
                                <li>
                                    <?php echo $item['content'] ?? ''; ?>

                                </li>
                            <?php else: ?>
                                
                                <?php
                                    $label = $item['label'] ?? '';
                                    $url = $item['url'] ?? '#';
                                    $icon = $item['icon'] ?? null;
                                    $active = $item['active'] ?? false;
                                    $badge = $item['badge'] ?? null;
                                    $badgeType = $item['badgeType'] ?? 'info';
                                    $badgeColor = $item['badgeColor'] ?? null;
                                ?>
                                <li>
                                    <a
                                        class="min-h-[40px] w-full flex items-center gap-x-3 py-2.5 px-3 text-sm font-medium text-gray-700 rounded-lg transition-all duration-200 ease-in-out hover:bg-gray-100 hover:text-gray-900 focus:outline-hidden focus:bg-gray-100 focus:text-gray-900 <?php echo e($active ? 'bg-gray-100 text-gray-900' : ''); ?> group"
                                        :class="isMinified && isDesktop ? 'justify-center' : 'justify-start'"
                                        href="<?php echo e($url); ?>"
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
                                        <?php if($icon): ?>
                                            <i data-lucide="<?php echo e($icon); ?>" class="size-5 shrink-0 transition-colors duration-200"></i>
                                        <?php endif; ?>
                                        <span x-show="!isMinified || !isDesktop" class="<?php echo e($badge ? 'flex-1 flex items-center justify-between gap-x-2' : ''); ?>">
                                            <?php echo e($label); ?>

                                            <?php if($badge): ?>
                                                <?php if($badgeColor): ?>
                                                    <span class="ms-auto py-0.5 px-2 inline-flex items-center gap-x-1.5 text-xs rounded-full font-semibold <?php echo e($badgeColor); ?> transition-all duration-200">
                                                        <?php echo e($badge); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="ms-auto transition-all duration-200">
                                                        <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => ''.e($badgeType).'','text' => ''.e($badge).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => ''.e($badgeType).'','text' => ''.e($badge).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                                                    </span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </span>

                                        
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
                                                <?php echo e($label); ?>

                                            </div>
                                        </template>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </nav>
            

            
            <?php if($footer): ?>
                <footer class="mt-auto p-3 border-t border-gray-200">
                    
                    <div class="relative w-full inline-flex">
                        <button
                            x-ref="dropdownButton"
                            id="hs-sidebar-footer-<?php echo e($uniqueId); ?>"
                            type="button"
                            @click="toggleDropdown()"
                            class="w-full inline-flex shrink-0 items-center text-start text-sm font-medium text-gray-800 rounded-lg transition-all duration-200 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100"
                            :class="isMinified && isDesktop ? 'p-2 justify-center' : 'p-2.5 gap-x-3'"
                            aria-haspopup="menu"
                            :aria-expanded="openDropdown"
                            aria-label="Menú de usuario"
                        >
                            <?php if(isset($footer['avatar']) && $footer['avatar']): ?>
                                <div
                                    :class="{
                                        'size-9': isMinified && isDesktop,
                                        'size-11': !isMinified || !isDesktop
                                    }"
                                    class="shrink-0 rounded-full ring-2 ring-gray-100 transition-all duration-300 overflow-hidden"
                                >
                                    <img
                                        class="w-full h-full object-cover"
                                        src="<?php echo e($footer['avatar']); ?>"
                                        alt="Avatar"
                                    >
                                </div>
                            <?php elseif(isset($footer['initials'])): ?>
                                <div
                                    :class="{
                                        'size-9 text-xs': isMinified && isDesktop,
                                        'size-11 text-sm': !isMinified || !isDesktop
                                    }"
                                    class="shrink-0 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center font-bold text-white ring-2 ring-blue-100 transition-all duration-300"
                                >
                                    <?php echo e($footer['initials']); ?>

                                </div>
                            <?php endif; ?>
                            <span x-show="!isMinified || !isDesktop" class="flex-1 text-sm font-semibold text-gray-900 truncate"><?php echo e($footer['name'] ?? 'Usuario'); ?></span>
                            <i data-lucide="more-vertical" class="shrink-0 size-5 text-gray-500 transition-colors duration-200" :class="openDropdown ? 'text-gray-700' : ''" x-show="!isMinified || !isDesktop"></i>
                        </button>
                    </div>
                    
                </footer>
            <?php endif; ?>
            

        </div>
    </div>
    

    
    <?php if($footer && isset($footer['dropdown']) && is_array($footer['dropdown']) && count($footer['dropdown']) > 0): ?>
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
            aria-labelledby="hs-sidebar-footer-<?php echo e($uniqueId); ?>"
            style="display: none;"
            @click.away="closeDropdown()"
        >
            <div class="p-2">
                <?php $__currentLoopData = $footer['dropdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dropdownItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $dropdownLabel = $dropdownItem['label'] ?? '';
                        $dropdownUrl = $dropdownItem['url'] ?? '#';
                        $dropdownIcon = $dropdownItem['icon'] ?? null;
                        $dropdownMethod = $dropdownItem['method'] ?? 'GET';
                    ?>
                    <?php if($dropdownMethod === 'POST'): ?>
                        <form method="POST" action="<?php echo e($dropdownUrl); ?>" class="inline w-full">
                            <?php echo csrf_field(); ?>
                            <button
                                type="submit"
                                @click="closeDropdown()"
                                class="w-full text-left flex items-center gap-x-3 py-2.5 px-3 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 hover:bg-gray-100 hover:text-gray-900 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 focus:text-gray-900"
                            >
                                <?php if($dropdownIcon): ?>
                                    <i data-lucide="<?php echo e($dropdownIcon); ?>" class="shrink-0 size-5 transition-colors duration-200"></i>
                                <?php endif; ?>
                                <?php echo e($dropdownLabel); ?>

                            </button>
                        </form>
                    <?php else: ?>
                        <a
                            @click="closeDropdown()"
                            class="flex items-center gap-x-3 py-2.5 px-3 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 hover:bg-gray-100 hover:text-gray-900 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 focus:text-gray-900"
                            href="<?php echo e($dropdownUrl); ?>"
                        >
                            <?php if($dropdownIcon): ?>
                                <i data-lucide="<?php echo e($dropdownIcon); ?>" class="shrink-0 size-5 transition-colors duration-200"></i>
                            <?php endif; ?>
                            <?php echo e($dropdownLabel); ?>

                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
    
</div>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features/DesignSystem/Components/Sidebar/SidebarContentPush.blade.php ENDPATH**/ ?>