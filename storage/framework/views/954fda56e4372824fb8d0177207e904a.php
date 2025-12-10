


<?php
    if (!function_exists('getCurrentPageIcon')) {
        function getCurrentPageIcon($store) {
            $routeIconMap = [
                'tenant.admin.dashboard' => 'layout-dashboard',
                'tenant.admin.orders.*' => 'party-popper',
                'tenant.admin.categories.*' => 'layout-list',
                'tenant.admin.variables.*' => 'tag',
                'tenant.admin.products.*' => 'package',
                'tenant.admin.simple-shipping.*' => 'truck',
                'tenant.admin.payment-methods.*' => 'dock',
                'tenant.admin.locations.*' => 'store',
                'tenant.admin.whatsapp-notifications.*' => 'message-circle',
                'tenant.admin.reservations.*' => 'utensils',
                'tenant.admin.dine-in.*' => 'scan-barcode',
                'tenant.admin.hotel.reservations.*' => 'bed',
                'tenant.admin.store-design.*' => 'palette',
                'tenant.admin.coupons.*' => 'ticket-percent',
                'tenant.admin.sliders.*' => 'images',
                'tenant.admin.tickets.*' => 'server-crash',
                'tenant.admin.announcements.*' => 'megaphone',
                'tenant.admin.profile.*' => 'user-circle',
                'tenant.admin.master-key.*' => 'lock-keyhole',
                'tenant.admin.business-profile.*' => 'store',
                'tenant.admin.billing.*' => 'credit-card',
            ];

            foreach ($routeIconMap as $routePattern => $icon) {
                if (request()->routeIs($routePattern)) {
                    return $icon;
                }
            }

            return 'layout-dashboard';
        }
    }

    $currentPageIcon = getCurrentPageIcon($store);
    $currentPageTitle = $__env->yieldContent('title') ?: 'Dashboard';
?>



<nav 
    data-tour="navbar"
    x-data="{
        left: '0px',
        width: '100%',
        initInterval: null,
        
        toggleSidebar() {
            // Verificar que Alpine esté disponible
            if (typeof Alpine === 'undefined' || !Alpine.store) {
                return;
            }
            
            // Crear store si no existe
            if (!Alpine.store('sidebar')) {
                Alpine.store('sidebar', {
                    isOpen: false,
                    isMinified: localStorage.getItem('sidebar_tenant-admin-sidebar_minified') === 'true',
                    isDesktop: window.innerWidth >= 1024
                });
            }
            
            // Toggle the sidebar
            const sidebar = Alpine.store('sidebar');
            if (!sidebar) {
                return;
            }
            
            sidebar.isOpen = !sidebar.isOpen;

            // Dispatch the state change event
            window.dispatchEvent(new CustomEvent('sidebar-state-changed', {
                detail: {
                    isOpen: sidebar.isOpen || false,
                    isMinified: sidebar.isMinified || false,
                    isDesktop: sidebar.isDesktop || false
                }
            }));
        },
        
        updatePosition() {
            const savedMinified = localStorage.getItem('sidebar_tenant-admin-sidebar_minified');
            const isMinified = savedMinified === 'true';
            const isDesktop = window.innerWidth >= 1024;
            
            if (typeof Alpine !== 'undefined' && Alpine.store) {
                const store = Alpine.store('sidebar');
                if (store && typeof store.isDesktop !== 'undefined') {
                    if (!store.isDesktop) {
                        this.left = '0px';
                        this.width = '100%';
                    } else if (store.isMinified) {
                        this.left = '65px';
                        this.width = 'calc(100% - 65px)';
                    } else {
                        this.left = '288px';
                        this.width = 'calc(100% - 288px)';
                    }
                    return;
                }
            }
            
            if (!isDesktop) {
                this.left = '0px';
                this.width = '100%';
            } else if (isMinified) {
                this.left = '65px';
                this.width = 'calc(100% - 65px)';
            } else {
                this.left = '288px';
                this.width = 'calc(100% - 288px)';
            }
        },
        
        init() {
            this.updatePosition();
            
            const trySync = () => {
                if (typeof Alpine !== 'undefined' && Alpine.store && Alpine.store('sidebar')) {
                    this.updatePosition();
                    if (this.initInterval) {
                        clearInterval(this.initInterval);
                        this.initInterval = null;
                    }
                }
            };
            
            let attempts = 0;
            this.initInterval = setInterval(() => {
                attempts++;
                if (attempts > 40) {
                    clearInterval(this.initInterval);
                    this.initInterval = null;
                }
                trySync();
            }, 50);
            
            window.addEventListener('sidebar-state-changed', () => {
                this.updatePosition();
            });
            
            document.addEventListener('alpine:initialized', () => {
                this.$nextTick(() => {
                    this.updatePosition();
                });
            });
            
            window.addEventListener('resize', () => {
                this.updatePosition();
            });
        }
    }"
    class="fixed top-0 bg-white border-b border-gray-200 z-50 h-20 transition-all duration-300"
    :style="`left: ${left}; width: ${width};`"
>
    <div class="h-full px-4 md:px-6 flex items-center justify-between gap-3">
        
        <button
            @click="toggleSidebar()"
            class="lg:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors shrink-0"
            aria-label="Toggle Menu"
        >
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        

        
        <div class="flex flex-col gap-1 min-w-0">
            <span class="hidden md:block text-sm font-medium text-gray-700 truncate">
                Hola, <?php echo e(auth()->user()->name); ?>! Bienvenido a <?php echo e($store->name); ?>

            </span>
            
            <nav class="flex items-center gap-2 text-sm text-gray-600" aria-label="Breadcrumb">
                
                <div class="hidden md:flex items-center gap-2">
                    <a 
                        href="<?php echo e(route('tenant.admin.dashboard', ['store' => $store->slug])); ?>" 
                        class="flex items-center gap-1.5 hover:text-blue-600 transition-colors"
                    >
                        <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                        <span>Dashboard</span>
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="flex items-center gap-1.5 text-gray-800 font-medium">
                        <i data-lucide="<?php echo e($currentPageIcon); ?>" class="w-3.5 h-3.5"></i>
                        <span><?php echo e($currentPageTitle); ?></span>
                    </span>
                </div>
                
                
                <span class="md:hidden flex items-center gap-1.5 text-gray-800 font-medium">
                    <i data-lucide="<?php echo e($currentPageIcon); ?>" class="w-4 h-4"></i>
                    <span class="truncate"><?php echo e($currentPageTitle); ?></span>
                </span>
            </nav>
        </div>
        

        
        <div class="flex items-center gap-3">
            
            <div 
                id="verification-badge-container"
                class="hidden md:block"
                x-data="{ verified: <?php echo e($store->verified ? 'true' : 'false'); ?> }"
                x-effect="
                    const badge = document.getElementById('verification-badge');
                    if (badge) {
                        badge.setAttribute('data-verified', verified);
                    }
                "
            >
                <?php if (isset($component)) { $__componentOriginal375a712a2300a078a8bd0da992c31f1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375a712a2300a078a8bd0da992c31f1b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeIcon','data' => ['type' => $store->verified ? 'info' : 'secondary','icon' => $store->verified ? 'badge-check' : 'shield-off','text' => $store->verified ? 'Verificado' : 'No Verificado','id' => 'verification-badge']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store->verified ? 'info' : 'secondary'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store->verified ? 'badge-check' : 'shield-off'),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store->verified ? 'Verificado' : 'No Verificado'),'id' => 'verification-badge']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375a712a2300a078a8bd0da992c31f1b)): ?>
<?php $attributes = $__attributesOriginal375a712a2300a078a8bd0da992c31f1b; ?>
<?php unset($__attributesOriginal375a712a2300a078a8bd0da992c31f1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375a712a2300a078a8bd0da992c31f1b)): ?>
<?php $component = $__componentOriginal375a712a2300a078a8bd0da992c31f1b; ?>
<?php unset($__componentOriginal375a712a2300a078a8bd0da992c31f1b); ?>
<?php endif; ?>
            </div>
            

            
            <?php
                $statusType = match($store->status) {
                    'active' => 'success',
                    'suspended' => 'warning',
                    default => 'secondary'
                };
                $statusIcon = match($store->status) {
                    'active' => 'shield-check',
                    default => 'shield-off'
                };
                $statusText = match($store->status) {
                    'active' => 'Tienda Activa',
                    'inactive' => 'Tienda Inactiva',
                    'suspended' => 'Tienda Suspendida',
                    default => 'Tienda Inactiva'
                };
            ?>
            <div class="hidden md:block">
                <?php if (isset($component)) { $__componentOriginal375a712a2300a078a8bd0da992c31f1b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375a712a2300a078a8bd0da992c31f1b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeIcon','data' => ['type' => $statusType,'icon' => $statusIcon,'text' => $statusText]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statusType),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statusIcon),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($statusText)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375a712a2300a078a8bd0da992c31f1b)): ?>
<?php $attributes = $__attributesOriginal375a712a2300a078a8bd0da992c31f1b; ?>
<?php unset($__attributesOriginal375a712a2300a078a8bd0da992c31f1b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375a712a2300a078a8bd0da992c31f1b)): ?>
<?php $component = $__componentOriginal375a712a2300a078a8bd0da992c31f1b; ?>
<?php unset($__componentOriginal375a712a2300a078a8bd0da992c31f1b); ?>
<?php endif; ?>
            </div>
            

            
            <a 
                href="<?php echo e(url('/' . $store->slug)); ?>" 
                target="_blank"
                class="hidden lg:flex xl:flex items-center gap-2 py-2 px-3 lg:px-4 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 focus:outline-none focus:bg-blue-700 transition-colors shrink-0"
            >
                <span>Ver mi tienda</span>
                <i data-lucide="external-link" class="w-4 h-4 shrink-0"></i>
            </a>
            

            
            <div class="flex items-center gap-2 md:gap-3">
                
                <?php
                    $pendingOrders = $store->pending_orders_count ?? 0;
                ?>
                <a 
                    href="<?php echo e(route('tenant.admin.orders.index', $store->slug)); ?>" 
                    class="z-10 relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                    aria-label="Pedidos pendientes"
                >
                    <i data-lucide="party-popper" class="w-5 h-5 md:w-6 md:h-6"></i>
                    <?php if($pendingOrders > 0): ?>
                        <?php if (isset($component)) { $__componentOriginal018a0d6a71a64a520834c42f653b07fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal018a0d6a71a64a520834c42f653b07fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgePositioned','data' => ['count' => $pendingOrders,'type' => 'notification','position' => 'top-right','color' => 'red','animated' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-positioned'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pendingOrders),'type' => 'notification','position' => 'top-right','color' => 'red','animated' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal018a0d6a71a64a520834c42f653b07fa)): ?>
<?php $attributes = $__attributesOriginal018a0d6a71a64a520834c42f653b07fa; ?>
<?php unset($__attributesOriginal018a0d6a71a64a520834c42f653b07fa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal018a0d6a71a64a520834c42f653b07fa)): ?>
<?php $component = $__componentOriginal018a0d6a71a64a520834c42f653b07fa; ?>
<?php unset($__componentOriginal018a0d6a71a64a520834c42f653b07fa); ?>
<?php endif; ?>
                    <?php endif; ?>
                </a>
                

                
                <?php
                    $openTickets = $store->open_tickets_count ?? 0;
                ?>
                <a
                    href="<?php echo e(route('tenant.admin.tickets.index', $store->slug)); ?>"
                    class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                    aria-label="Tickets de soporte"
                >
                    <i data-lucide="message-square-more" class="w-5 h-5 md:w-6 md:h-6"></i>
                    <?php if($openTickets > 0): ?>
                        <?php if (isset($component)) { $__componentOriginal018a0d6a71a64a520834c42f653b07fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal018a0d6a71a64a520834c42f653b07fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgePositioned','data' => ['count' => $openTickets,'type' => 'notification','position' => 'top-right','color' => 'blue','animated' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-positioned'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($openTickets),'type' => 'notification','position' => 'top-right','color' => 'blue','animated' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal018a0d6a71a64a520834c42f653b07fa)): ?>
<?php $attributes = $__attributesOriginal018a0d6a71a64a520834c42f653b07fa; ?>
<?php unset($__attributesOriginal018a0d6a71a64a520834c42f653b07fa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal018a0d6a71a64a520834c42f653b07fa)): ?>
<?php $component = $__componentOriginal018a0d6a71a64a520834c42f653b07fa; ?>
<?php unset($__componentOriginal018a0d6a71a64a520834c42f653b07fa); ?>
<?php endif; ?>
                    <?php endif; ?>
                </a>
                

                
                <?php
                    $unreadAnnouncements = $store->unread_announcements_count ?? 0;
                ?>
                <a 
                    href="<?php echo e(route('tenant.admin.announcements.index', $store->slug)); ?>" 
                    class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                    aria-label="Anuncios sin leer"
                >
                    <i data-lucide="megaphone" class="w-5 h-5 md:w-6 md:h-6"></i>
                    <?php if($unreadAnnouncements > 0): ?>
                        <?php if (isset($component)) { $__componentOriginal018a0d6a71a64a520834c42f653b07fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal018a0d6a71a64a520834c42f653b07fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgePositioned','data' => ['count' => $unreadAnnouncements,'type' => 'notification','position' => 'top-right','color' => 'yellow','animated' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-positioned'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($unreadAnnouncements),'type' => 'notification','position' => 'top-right','color' => 'yellow','animated' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal018a0d6a71a64a520834c42f653b07fa)): ?>
<?php $attributes = $__attributesOriginal018a0d6a71a64a520834c42f653b07fa; ?>
<?php unset($__attributesOriginal018a0d6a71a64a520834c42f653b07fa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal018a0d6a71a64a520834c42f653b07fa)): ?>
<?php $component = $__componentOriginal018a0d6a71a64a520834c42f653b07fa; ?>
<?php unset($__componentOriginal018a0d6a71a64a520834c42f653b07fa); ?>
<?php endif; ?>
                    <?php endif; ?>
                </a>
                
            </div>
            
        </div>
        
    </div>
</nav>



<?php $__env->startPush('scripts'); ?>
<script>
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
            window.createIcons({ icons: window.lucideIcons });
        }
        
        function updateVerificationBadge(verified) {
            const container = document.getElementById('verification-badge-container');
            if (!container || !container.__x) return;
            
            container.__x.$data.verified = verified;
            
            const badge = document.getElementById('verification-badge');
            if (badge) {
                const type = verified ? 'info' : 'secondary';
                const icon = verified ? 'badge-check' : 'shield-off';
                const text = verified ? 'Verificado' : 'No Verificado';
                
                badge.className = badge.className.replace(/bg-(teal|blue|gray)-100/g, '');
                badge.className = badge.className.replace(/text-(teal|blue|gray)-(800|500)/g, '');
                badge.className += verified 
                    ? ' bg-blue-100 text-blue-800' 
                    : ' bg-gray-50 text-gray-500';
                
                const iconEl = badge.querySelector('i[data-lucide]');
                if (iconEl) {
                    iconEl.setAttribute('data-lucide', icon);
                    if (typeof window.createIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                }
                
                const textEl = badge.querySelector('span:not([class*="size"])');
                if (textEl && textEl.textContent) {
                    textEl.textContent = text;
                }
            }
        }
        
        function checkVerificationStatus() {
            const storeSlug = window.location.pathname.split('/')[1];
            
            fetch(`/api/store/${storeSlug}/status`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.verified !== undefined) {
                    updateVerificationBadge(data.verified);
                }
            })
            .catch(() => {
                // Error silencioso
            });
        }
        
        setInterval(checkVerificationStatus, 30000);
        checkVerificationStatus();
    });
})();
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Shared/Views/Components/admin/tenant-navbar.blade.php ENDPATH**/ ?>