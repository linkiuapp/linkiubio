{{--
Navbar Tenant Admin - Barra de navegación superior adaptativa
Se adapta automáticamente al estado del sidebar (abierto/minificado/cerrado)
--}}

{{-- SECTION: Helper Function - Obtener icono de página actual --}}
@php
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
@endphp
{{-- End SECTION: Helper Function --}}

{{-- SECTION: Navbar Container --}}
<nav 
    x-data="{
        left: '0px',
        width: '100%',
        initInterval: null,
        
        updatePosition() {
            const savedMinified = localStorage.getItem('sidebar_tenant-admin-sidebar_minified');
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
        {{-- SECTION: Left Side - Greeting and Breadcrumbs --}}
        <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-gray-700">
                Hola, {{ auth()->user()->name }}! Bienvenido a {{ $store->name }}
            </span>
            
            <nav class="flex items-center gap-2 text-sm text-gray-600" aria-label="Breadcrumb">
                <a 
                    href="{{ route('tenant.admin.dashboard', ['store' => $store->slug]) }}" 
                    class="flex items-center gap-1.5 hover:text-blue-600 transition-colors"
                >
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5"></i>
                    <span>Dashboard</span>
                </a>
                <span class="text-gray-400">/</span>
                <span class="flex items-center gap-1.5 text-gray-800 font-medium">
                    <i data-lucide="{{ $currentPageIcon }}" class="w-3.5 h-3.5"></i>
                    <span>{{ $currentPageTitle }}</span>
                </span>
            </nav>
        </div>
        {{-- End SECTION: Left Side --}}

        {{-- SECTION: Right Side - Badges, Button and Notifications --}}
        <div class="flex items-center gap-3">
            {{-- ITEM: Badge Verificado --}}
            <div 
                id="verification-badge-container"
                x-data="{ verified: {{ $store->verified ? 'true' : 'false' }} }"
                x-effect="
                    const badge = document.getElementById('verification-badge');
                    if (badge) {
                        badge.setAttribute('data-verified', verified);
                    }
                "
            >
                <x-badge-icon 
                    :type="$store->verified ? 'info' : 'secondary'"
                    :icon="$store->verified ? 'badge-check' : 'shield-off'"
                    :text="$store->verified ? 'Verificado' : 'No Verificado'"
                    id="verification-badge"
                />
            </div>
            {{-- End ITEM: Badge Verificado --}}

            {{-- ITEM: Badge Estatus de Tienda --}}
            @php
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
            @endphp
            <x-badge-icon 
                :type="$statusType"
                :icon="$statusIcon"
                :text="$statusText"
            />
            {{-- End ITEM: Badge Estatus de Tienda --}}

            {{-- ITEM: Botón Ver Tienda --}}
            <a 
                href="https://linkiu.bio/{{ $store->slug }}" 
                target="_blank"
                class="inline-flex items-center gap-2 py-2 px-4 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 focus:outline-none focus:bg-blue-700 transition-colors"
            >
                <span>Ver mi tienda</span>
                <i data-lucide="external-link" class="w-4 h-4"></i>
            </a>
            {{-- End ITEM: Botón Ver Tienda --}}

            {{-- SECTION: Notificaciones --}}
            <div class="flex items-center gap-3">
                {{-- ITEM: Pedidos Pendientes --}}
                @php
                    $pendingOrders = $store->pending_orders_count ?? 0;
                @endphp
                <a 
                    href="{{ route('tenant.admin.orders.index', $store->slug) }}" 
                    class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                    aria-label="Pedidos pendientes"
                >
                    <i data-lucide="party-popper" class="w-6 h-6"></i>
                    @if($pendingOrders > 0)
                        <x-badge-positioned 
                            :count="$pendingOrders"
                            type="notification"
                            position="top-right"
                            color="red"
                            :animated="true"
                        />
                    @endif
                </a>
                {{-- End ITEM: Pedidos Pendientes --}}

                {{-- ITEM: Tickets de Soporte --}}
                @php
                    $openTickets = $store->open_tickets_count ?? 0;
                @endphp
                <a 
                    href="{{ route('tenant.admin.tickets.index', $store->slug) }}" 
                    class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                    aria-label="Tickets de soporte"
                >
                    <i data-lucide="message-square-more" class="w-6 h-6"></i>
                    @if($openTickets > 0)
                        <x-badge-positioned 
                            :count="$openTickets"
                            type="notification"
                            position="top-right"
                            color="blue"
                            :animated="true"
                        />
                    @endif
                </a>
                {{-- End ITEM: Tickets de Soporte --}}

                {{-- ITEM: Anuncios --}}
                @php
                    $unreadAnnouncements = $store->unread_announcements_count ?? 0;
                @endphp
                <a 
                    href="{{ route('tenant.admin.announcements.index', $store->slug) }}" 
                    class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                    aria-label="Anuncios sin leer"
                >
                    <i data-lucide="megaphone" class="w-6 h-6"></i>
                    @if($unreadAnnouncements > 0)
                        <x-badge-positioned 
                            :count="$unreadAnnouncements"
                            type="notification"
                            position="top-right"
                            color="yellow"
                            :animated="true"
                        />
                    @endif
                </a>
                {{-- End ITEM: Anuncios --}}
            </div>
            {{-- End SECTION: Notificaciones --}}
        </div>
        {{-- End SECTION: Right Side --}}
    </div>
</nav>
{{-- End SECTION: Navbar Container --}}

{{-- SECTION: Scripts --}}
@push('scripts')
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
@endpush
{{-- End SECTION: Scripts --}}
