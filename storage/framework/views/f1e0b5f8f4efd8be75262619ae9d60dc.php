


<?php
    if (!function_exists('getSuperAdminCurrentPageIcon')) {
        function getSuperAdminCurrentPageIcon() {
            $routeIconMap = [
                'superlinkiu.dashboard' => 'layout-dashboard',
                'superlinkiu.stores.*' => 'store',
                'superlinkiu.store-requests.*' => 'file-text',
                'superlinkiu.user-management.*' => 'users',
                'superlinkiu.master-key-recovery.*' => 'lock-keyhole',
                'superlinkiu.store-reports.*' => 'alert-triangle',
                'superlinkiu.plans.*' => 'award',
                'superlinkiu.invoices.*' => 'receipt',
                'superlinkiu.billing-settings.*' => 'settings',
                'superlinkiu.tickets.*' => 'ticket',
                'superlinkiu.tools.*' => 'wrench',
                'superlinkiu.announcements.*' => 'megaphone',
                'superlinkiu.email.*' => 'mail',
                'superlinkiu.business-categories.*' => 'tag',
                'superlinkiu.category-icons.*' => 'image',
                'superlinkiu.profile.show' => 'user-circle',
                'superlinkiu.monitoring.*' => 'activity',
            ];

            foreach ($routeIconMap as $routePattern => $icon) {
                if (request()->routeIs($routePattern)) {
                    return $icon;
                }
            }

            return 'layout-dashboard';
        }
    }

    $currentPageIcon = getSuperAdminCurrentPageIcon();
    $currentPageTitle = $__env->yieldContent('title') ?: 'Dashboard';
?>



<nav 
    x-data="{
        left: '0px',
        width: '100%',
        initInterval: null,
        
        updatePosition() {
            const savedMinified = localStorage.getItem('sidebar_super-admin-sidebar_minified');
            const isMinified = savedMinified === 'true';
            const isDesktop = window.innerWidth >= 1024;
            
            if (typeof Alpine !== 'undefined' && Alpine.store) {
                const store = Alpine.store('sidebar');
                if (store) {
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
    <div class="h-full px-6 flex items-center justify-between">
        
        <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-gray-700">
                Hola, <?php echo e(auth()->user()->name); ?>! Bienvenido a Super Linkiu
            </span>
            
            <nav class="flex items-center gap-2 text-sm text-gray-600" aria-label="Breadcrumb">
                <a 
                    href="<?php echo e(route('superlinkiu.dashboard')); ?>" 
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
            </nav>
        </div>
        

        
        <div class="flex items-center gap-3">
            
            <?php
                $openTicketsCount = \App\Shared\Models\Ticket::whereIn('status', ['open', 'in_progress'])->count();
            ?>
            <a 
                href="<?php echo e(route('superlinkiu.tickets.index')); ?>" 
                class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                aria-label="Tickets de soporte"
            >
                <i data-lucide="message-square-more" class="w-6 h-6"></i>
                <?php if($openTicketsCount > 0): ?>
                    <?php if (isset($component)) { $__componentOriginal018a0d6a71a64a520834c42f653b07fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal018a0d6a71a64a520834c42f653b07fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgePositioned','data' => ['count' => $openTicketsCount,'type' => 'notification','position' => 'top-right','color' => 'blue','animated' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-positioned'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($openTicketsCount),'type' => 'notification','position' => 'top-right','color' => 'blue','animated' => true]); ?>
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
                $newMessagesCount = \App\Shared\Models\TicketResponse::whereHas('user', function($query) {
                        $query->where('role', 'store_admin');
                    })
                    ->where('created_at', '>=', now()->subDays(7))
                    ->count();
            ?>
            <a 
                href="<?php echo e(route('superlinkiu.tickets.index')); ?>" 
                class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                aria-label="Mensajes de tiendas"
            >
                <i data-lucide="message-circle-more" class="w-6 h-6"></i>
                <?php if($newMessagesCount > 0): ?>
                    <?php if (isset($component)) { $__componentOriginal018a0d6a71a64a520834c42f653b07fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal018a0d6a71a64a520834c42f653b07fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgePositioned','data' => ['count' => $newMessagesCount,'type' => 'notification','position' => 'top-right','color' => 'purple','animated' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-positioned'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($newMessagesCount),'type' => 'notification','position' => 'top-right','color' => 'purple','animated' => true]); ?>
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
            

            
            <a 
                href="<?php echo e(route('superlinkiu.tools.delete-order')); ?>" 
                class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                aria-label="Herramientas"
                title="Herramientas"
            >
                <i data-lucide="wrench" class="w-6 h-6"></i>
            </a>
            
        </div>
        
    </div>
</nav>



<?php $__env->startPush('scripts'); ?>
<script>
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar iconos de Lucide
        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
            window.createIcons({ icons: window.lucideIcons });
        }
        
        // Función para actualizar los badges de SuperLinkiu
        function updateNotificationBadges(data) {
            // Actualizar badge de tickets abiertos
            const ticketBadge = document.querySelector('[aria-label="Tickets de soporte"] x-badge-positioned');
            if (ticketBadge && data.open_tickets !== undefined) {
                // El componente badge-positioned maneja su propia actualización
            }
            
            // Actualizar badge de mensajes nuevos
            const messageBadge = document.querySelector('[aria-label="Mensajes de tiendas"] x-badge-positioned');
            if (messageBadge && data.new_messages !== undefined) {
                // El componente badge-positioned maneja su propia actualización
            }
        }
        
        // Configurar WebSocket para SuperLinkiu
        function setupWebSocket() {
            if (window.Echo) {
                // Escuchar en el canal de SuperLinkiu
                window.Echo.channel('superlinkiu-notifications')
                    .listen('.ticket.response.added', (e) => {
                        // Actualizar contadores inmediatamente
                        refreshNotificationCounts();
                        
                        // Mostrar notificación destacada
                        if (e.response_from === 'store_admin') {
                            console.log(`🔔 Nueva respuesta en ticket ${e.ticket_number}`);
                        }
                    });
            } else if (window.pusher) {
                // Fallback: Usar Pusher directamente
                const channel = window.pusher.subscribe('superlinkiu-notifications');
                channel.bind('ticket.response.added', function(e) {
                    refreshNotificationCounts();
                });
            }
        }
        
        // Función para refrescar contadores via API
        function refreshNotificationCounts() {
            fetch('/api/superlinkiu/notifications', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                updateNotificationBadges(data);
            })
            .catch(() => {
                // Error silencioso
            });
        }
        
        // Inicializar WebSocket
        setupWebSocket();
        
        // Cargar contadores inicial
        refreshNotificationCounts();
    });
})();
</script>
<?php $__env->stopPush(); ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Shared/Views/Components/admin/navbar.blade.php ENDPATH**/ ?>