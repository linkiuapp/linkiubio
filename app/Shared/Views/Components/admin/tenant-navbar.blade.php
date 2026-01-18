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
        {{-- SECTION: Mobile Menu Button --}}
        <button
            @click="toggleSidebar()"
            class="lg:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors shrink-0"
            aria-label="Toggle Menu"
        >
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        {{-- End SECTION: Mobile Menu Button --}}

        {{-- SECTION: Left Side - Greeting and Breadcrumbs --}}
        <div class="flex flex-col gap-1 min-w-0">
            <span class="hidden md:block text-sm font-medium text-gray-700 truncate">
                Hola, {{ auth()->user()->name }}! Bienvenido a {{ $store->name }}
            </span>
            
            <nav class="flex items-center gap-2 text-sm text-gray-600" aria-label="Breadcrumb">
                {{-- Desktop version --}}
                <div class="hidden md:flex items-center gap-2">
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
                </div>
                
                {{-- Mobile version - Solo página actual --}}
                <span class="md:hidden flex items-center gap-1.5 text-gray-800 font-medium">
                    <i data-lucide="{{ $currentPageIcon }}" class="w-4 h-4"></i>
                    <span class="truncate">{{ $currentPageTitle }}</span>
                </span>
            </nav>
        </div>
        {{-- End SECTION: Left Side --}}

        {{-- SECTION: Right Side - Badges, Button and Notifications --}}
        <div class="flex items-center gap-3">
            {{-- ITEM: Badge Verificado --}}
            <div 
                id="verification-badge-container"
                class="hidden md:block"
                x-data="{ 
                    verified: {{ $store->verified ? 'true' : 'false' }},
                    init() {
                        // Solo actualizar una vez al inicializar
                        this.$watch('verified', (value) => {
                            const badge = document.getElementById('verification-badge');
                            if (badge) {
                                badge.setAttribute('data-verified', value);
                            }
                        });
                    }
                }"
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
            <div class="hidden md:block">
                <x-badge-icon 
                    :type="$statusType"
                    :icon="$statusIcon"
                    :text="$statusText"
                />
            </div>
            {{-- End ITEM: Badge Estatus de Tienda --}}

            {{-- ITEM: Botón Ver Tienda --}}
            <a 
                href="{{ url('/' . $store->slug) }}" 
                target="_blank"
                class="hidden lg:flex xl:flex items-center gap-2 py-2 px-3 lg:px-4 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 focus:outline-none focus:bg-blue-700 transition-colors shrink-0"
            >
                <span>Ver mi tienda</span>
                <i data-lucide="external-link" class="w-4 h-4 shrink-0"></i>
            </a>
            {{-- End ITEM: Botón Ver Tienda --}}

            {{-- SECTION: Menú Ayuda --}}
            <div 
                x-data="{ helpMenuOpen: false }"
                @mouseenter="helpMenuOpen = true"
                @mouseleave="helpMenuOpen = false"
                class="relative hidden md:block"
            >
                <button
                    class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                    aria-label="Menú de Ayuda"
                >
                    <i data-lucide="help-circle" class="w-5 h-5"></i>
                    <span>Ayuda</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': helpMenuOpen }"></i>
                </button>

                {{-- Dropdown Menu --}}
                <div
                    x-show="helpMenuOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    x-cloak
                    class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                    style="display: none;"
                >
                    <a
                        href="{{ route('tutorials.index') }}"
                        target="_blank"
                        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        <i data-lucide="book-open" class="w-4 h-4 text-gray-500"></i>
                        <span>Tutoriales</span>
                        <i data-lucide="external-link" class="w-3 h-3 text-gray-400 ml-auto"></i>
                    </a>
                    <a
                        href="{{ route('tenant.admin.interactive-guide.index', ['store' => $store->slug]) }}"
                        target="_blank"
                        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
                    >
                        <i data-lucide="map" class="w-4 h-4 text-gray-500"></i>
                        <span>Guía Interactiva</span>
                        <i data-lucide="external-link" class="w-3 h-3 text-gray-400 ml-auto"></i>
                    </a>
                    <button
                        @click="$dispatch('open-error-report')"
                        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors w-full text-left"
                    >
                        <i data-lucide="bug" class="w-4 h-4 text-red-500"></i>
                        <span>Reportar Error</span>
                    </button>
                </div>
            </div>
            {{-- End SECTION: Menú Ayuda --}}

            {{-- SECTION: Notificaciones Unificadas --}}
            <div 
                id="notifications-dropdown-component"
                class="relative"
                x-data="{
                    open: false,
                    notifications: [],
                    unreadCount: 0,
                    init() {
                        // Inicializar desde localStorage si existe
                        const saved = localStorage.getItem('tenant_notifications');
                        if (saved) {
                            try {
                                this.notifications = JSON.parse(saved);
                                // Pre-calcular tiempos formateados
                                this.notifications.forEach(n => {
                                    if (!n.formattedTime) {
                                        n.formattedTime = this.formatTime(n.timestamp);
                                    }
                                });
                                this.updateUnreadCount();
                            } catch(e) {
                                this.notifications = [];
                            }
                        }
                        
                        // Escuchar eventos de nuevas notificaciones
                        const handleNewNotification = (e) => {
                            console.log('🔔 Alpine.js recibió evento new-notification:', e.detail);
                            this.addNotification(e.detail);
                        };
                        
                        window.addEventListener('new-notification', handleNewNotification);
                        
                        // Guardar referencia para poder removerlo si es necesario
                        this._notificationHandler = handleNewNotification;
                        
                        // Escuchar eventos para marcar como leída
                        const handleMarkRead = (e) => {
                            this.markAsRead(e.detail.id);
                        };
                        window.addEventListener('mark-notification-read', handleMarkRead);
                        this._markReadHandler = handleMarkRead;
                    },
                    addNotification(notification) {
                        // Agregar al inicio del array
                        this.notifications.unshift({
                            id: Date.now() + Math.random(),
                            type: notification.type,
                            title: notification.title,
                            message: notification.message,
                            url: notification.url,
                            icon: notification.icon,
                            color: notification.color,
                            read: false,
                            timestamp: new Date().toISOString(),
                            formattedTime: 'Ahora' // Pre-calcular el tiempo
                        });
                        
                        // Limitar a 50 notificaciones
                        if (this.notifications.length > 50) {
                            this.notifications = this.notifications.slice(0, 50);
                        }
                        
                        this.updateUnreadCount();
                        this.saveToLocalStorage();
                        
                        // Actualizar tiempos de notificaciones existentes (solo si el dropdown está abierto)
                        if (this.open) {
                            this.updateNotificationTimes();
                        }
                    },
                    updateNotificationTimes() {
                        // Actualizar tiempos formateados solo cuando sea necesario (una vez al abrir)
                        const now = new Date();
                        this.notifications.forEach(notification => {
                            const date = new Date(notification.timestamp);
                            const diff = now - date;
                            const minutes = Math.floor(diff / 60000);
                            const hours = Math.floor(diff / 3600000);
                            const days = Math.floor(diff / 86400000);
                            
                            if (minutes < 1) {
                                notification.formattedTime = 'Ahora';
                            } else if (minutes < 60) {
                                notification.formattedTime = `Hace ${minutes}m`;
                            } else if (hours < 24) {
                                notification.formattedTime = `Hace ${hours}h`;
                            } else if (days < 7) {
                                notification.formattedTime = `Hace ${days}d`;
                            } else {
                                notification.formattedTime = date.toLocaleDateString('es');
                            }
                        });
                    },
                    markAsRead(id) {
                        const notification = this.notifications.find(n => n.id === id);
                        if (notification) {
                            notification.read = true;
                            this.updateUnreadCount();
                            this.saveToLocalStorage();
                        }
                    },
                    handleNotificationClick(notification) {
                        // Marcar como leída
                        this.markAsRead(notification.id);
                        
                        // Si es una notificación de verificación, mostrar el modal
                        if (notification.type === 'store_verification_changed') {
                            // Extraer el estado de verificación del contenido de la notificación
                            const isVerified = notification.message.includes('verificada') || 
                                             notification.message.includes('badge oficial') ||
                                             notification.title.includes('Felicitaciones') ||
                                             notification.title.includes('Verificada');
                            
                            // Mostrar el modal de verificación
                            if (typeof window.showVerificationModal === 'function') {
                                window.showVerificationModal({
                                    verified: isVerified,
                                    message: notification.message,
                                    title: notification.title
                                });
                            }
                        }
                    },
                    markAllAsRead() {
                        this.notifications.forEach(n => n.read = true);
                        this.updateUnreadCount();
                        this.saveToLocalStorage();
                    },
                    removeNotification(id) {
                        const index = this.notifications.findIndex(n => n.id === id);
                        if (index !== -1) {
                            this.notifications.splice(index, 1);
                            this.updateUnreadCount();
                            this.saveToLocalStorage();
                            
                            // Reinicializar iconos después de eliminar
                            this.$nextTick(() => {
                                if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                    window.createIcons({ icons: window.lucideIcons });
                                }
                            });
                        }
                    },
                    updateUnreadCount() {
                        this.unreadCount = this.notifications.filter(n => !n.read).length;
                    },
                    saveToLocalStorage() {
                        // Debounce para evitar escrituras excesivas
                        if (this.saveTimeout) {
                            clearTimeout(this.saveTimeout);
                        }
                        this.saveTimeout = setTimeout(() => {
                            try {
                                localStorage.setItem('tenant_notifications', JSON.stringify(this.notifications));
                            } catch(e) {
                                console.warn('Error guardando notificaciones:', e);
                            }
                        }, 500);
                    },
                    getNotificationIcon(type) {
                        const icons = {
                            'order': 'party-popper',
                            'ticket': 'message-square-more',
                            'announcement': 'megaphone',
                            'release-note': 'rocket',
                            'release-note-item': 'sparkles',
                            'icon-request-approved': 'sparkles',
                            'error-report-resolved': 'check-circle',
                            'store_verification_changed': 'badge-check'
                        };
                        return icons[type] || 'bell';
                    },
                    getNotificationColor(type) {
                        const colors = {
                            'order': 'red',
                            'ticket': 'blue',
                            'store_verification_changed': 'green',
                            'announcement': 'yellow',
                            'release-note': 'purple',
                            'release-note-item': 'indigo',
                            'icon-request-approved': 'purple',
                            'error-report-resolved': 'green'
                        };
                        return colors[type] || 'gray';
                    },
                    formatTime(timestamp) {
                        // Función auxiliar para formatear tiempo (usar formattedTime cuando sea posible)
                        if (!timestamp) return '';
                        const date = new Date(timestamp);
                        const now = new Date();
                        const diff = now - date;
                        const minutes = Math.floor(diff / 60000);
                        const hours = Math.floor(diff / 3600000);
                        const days = Math.floor(diff / 86400000);
                        
                        if (minutes < 1) return 'Ahora';
                        if (minutes < 60) return `Hace ${minutes}m`;
                        if (hours < 24) return `Hace ${hours}h`;
                        if (days < 7) return `Hace ${days}d`;
                        return date.toLocaleDateString('es');
                    }
                }"
                x-on:click.outside="open = false"
            >
                {{-- Botón de Notificaciones --}}
                <button
                    type="button"
                    class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg border border-gray-200 transition-colors"
                    aria-label="Notificaciones"
                    @click="open = !open; if (open) { updateNotificationTimes(); setTimeout(() => { if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') { window.createIcons({ icons: window.lucideIcons }); } }, 100); }"
                >
                    <i data-lucide="bell" class="w-5 h-5 md:w-6 md:h-6"></i>
                    <span id="notifications-badge-container">
                        <span 
                            x-show="unreadCount > 0"
                            class="flex absolute top-0 end-0 -translate-y-1/2 translate-x-1/2"
                            id="notifications-badge"
                        >
                            <span class="animate-ping absolute inline-flex size-full rounded-full bg-red-400 opacity-75"></span>
                            <span 
                                class="relative inline-flex text-xs bg-red-500 text-white rounded-full py-0.5 px-1.5 font-medium min-w-[1.25rem] justify-center"
                                x-text="unreadCount > 99 ? '99+' : unreadCount"
                            ></span>
                        </span>
                    </span>
                </button>

                {{-- Dropdown de Notificaciones --}}
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    x-cloak
                    class="absolute right-0 mt-2 w-80 md:w-96 bg-white rounded-lg shadow-lg border border-gray-200 z-50 max-h-[32rem] flex flex-col"
                    style="display: none;"
                >
                    {{-- Header --}}
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900">Notificaciones</h3>
                        <div class="flex items-center gap-2">
                            <button
                                x-show="unreadCount > 0"
                                @click="markAllAsRead()"
                                class="text-xs text-blue-600 hover:text-blue-700 font-medium"
                            >
                                Marcar todas como leídas
                            </button>
                            <button
                                @click="open = false"
                                class="text-gray-400 hover:text-gray-600"
                            >
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Lista de Notificaciones --}}
                    <div class="overflow-y-auto flex-1">
                        <template x-if="notifications.length === 0">
                            <div class="p-8 text-center text-gray-500">
                                <i data-lucide="bell-off" class="w-12 h-12 mx-auto mb-2 text-gray-300"></i>
                                <p class="text-sm">No hay notificaciones</p>
                            </div>
                        </template>
                        
                        <template x-for="notification in notifications" :key="notification.id">
                            <div
                                class="flex items-start gap-3 p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors group"
                                :class="{ 'bg-blue-50': !notification.read }"
                            >
                                <a 
                                    :href="notification.type === 'store_verification_changed' ? '#' : (notification.url || '#')"
                                    @click="handleNotificationClick(notification); open = false"
                                    class="flex items-start gap-3 flex-1 min-w-0"
                                >
                                    <div 
                                        class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                                        :class="{
                                            'bg-red-100': notification.type === 'order',
                                            'bg-blue-100': notification.type === 'ticket',
                                            'bg-yellow-100': notification.type === 'announcement',
                                            'bg-purple-100': notification.type === 'release-note',
                                            'bg-indigo-100': notification.type === 'release-note-item',
                                            'bg-green-100': notification.type === 'error-report-resolved' || notification.type === 'store_verification_changed',
                                            'bg-purple-100': notification.type === 'icon-request-approved'
                                        }"
                                    >
                                        <i 
                                            :data-lucide="getNotificationIcon(notification.type)"
                                            class="w-5 h-5"
                                            :class="{
                                                'text-red-600': notification.type === 'order',
                                                'text-blue-600': notification.type === 'ticket',
                                                'text-yellow-600': notification.type === 'announcement',
                                                'text-purple-600': notification.type === 'release-note' || notification.type === 'icon-request-approved',
                                                'text-indigo-600': notification.type === 'release-note-item',
                                                'text-green-600': notification.type === 'error-report-resolved' || notification.type === 'store_verification_changed'
                                            }"
                                        ></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <p 
                                                class="text-sm font-medium text-gray-900"
                                                :class="{ 'font-semibold': !notification.read }"
                                                x-text="notification.title"
                                            ></p>
                                            <span 
                                                x-show="!notification.read"
                                                class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-1"
                                            ></span>
                                        </div>
                                        <p 
                                            class="text-xs text-gray-600 mt-1 line-clamp-2"
                                            x-html="notification.message"
                                        ></p>
                                        <p 
                                            class="text-xs text-gray-400 mt-1"
                                            x-text="notification.formattedTime || formatTime(notification.timestamp)"
                                        ></p>
                                    </div>
                                </a>
                                {{-- Delete Button --}}
                                <button
                                    @click.stop="removeNotification(notification.id)"
                                    class="flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity p-1 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded"
                                    title="Eliminar notificación"
                                >
                                    <i data-lucide="x" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </template>
                    </div>

                    {{-- Footer --}}
                    <div class="p-3 border-t border-gray-200 text-center">
                        <a
                            href="{{ route('tenant.admin.notifications.index', $store->slug) }}"
                            class="text-xs text-blue-600 hover:text-blue-700 font-medium"
                            @click="open = false"
                        >
                            Ver todas las notificaciones
                        </a>
                    </div>
                </div>
            </div>
            {{-- End SECTION: Notificaciones Unificadas --}}
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
        
        let verificationCheckInterval = null;
        let lastVerificationCheck = 0;
        
        function checkVerificationStatus() {
            // Evitar múltiples checks simultáneos
            const now = Date.now();
            if (now - lastVerificationCheck < 30000) {
                return;
            }
            lastVerificationCheck = now;
            
            const storeSlug = window.location.pathname.split('/')[1];
            if (!storeSlug) return;
            
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
        
        // Solo crear un intervalo si no existe
        if (!verificationCheckInterval) {
            verificationCheckInterval = setInterval(checkVerificationStatus, 30000);
            // Ejecutar una vez después de 5 segundos (no inmediatamente)
            setTimeout(checkVerificationStatus, 5000);
        }
    });
})();
</script>
@endpush
{{-- End SECTION: Scripts --}}

{{-- SECTION: Error Report Modal --}}
<template x-teleport="body">
<div 
    x-data="errorReportModal()"
    @open-error-report.window="openModal()"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-[99999]"
    style="display: none;"
>
    {{-- Overlay --}}
    <div 
        class="fixed inset-0 bg-black/50"
        @click="closeModal()"
        x-show="isOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    {{-- Modal --}}
    <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
        <div 
            class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full"
            @click.away="closeModal()"
            x-show="isOpen"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            {{-- Header --}}
            <div class="bg-gradient-to-r from-red-600 to-orange-600 text-white px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i data-lucide="bug" class="w-6 h-6"></i>
                        <div>
                            <h3 class="text-lg font-bold">Reportar Error</h3>
                            <p class="text-sm text-red-100 mt-0.5">Ayúdanos a mejorar reportando problemas</p>
                        </div>
                    </div>
                    <button 
                        @click="closeModal()"
                        class="text-white hover:text-red-100 transition-colors"
                    >
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-6 py-6">
                <div class="space-y-4">
                    
                    {{-- Título --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Título del error
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            x-model="title"
                            placeholder="Ej: No puedo guardar productos"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            :disabled="loading"
                        >
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Describe el error
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            x-model="description"
                            rows="4"
                            placeholder="Describe qué estabas haciendo cuando ocurrió el error..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            :disabled="loading"
                        ></textarea>
                    </div>

                    {{-- Screenshot (opcional) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Captura de pantalla (opcional)
                        </label>
                        <label class="flex flex-col items-center justify-center h-32 px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-500 hover:bg-red-50 transition-all">
                            <div x-show="!screenshotPreview" class="text-center">
                                <i data-lucide="image-plus" class="w-8 h-8 text-gray-400 mx-auto mb-1"></i>
                                <p class="text-sm text-gray-600">Click para subir captura</p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG (Max 5MB)</p>
                            </div>
                            <div x-show="screenshotPreview" class="w-full h-full">
                                <img :src="screenshotPreview" class="w-full h-full object-contain">
                            </div>
                            <input 
                                type="file" 
                                @change="handleScreenshotUpload($event)"
                                accept="image/*"
                                class="hidden"
                                :disabled="loading"
                            >
                        </label>
                    </div>

                    {{-- Mensaje de éxito --}}
                    <div x-show="success" class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <div class="flex gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <p class="text-sm text-green-700">
                                ¡Reporte enviado exitosamente! Revisaremos el error lo antes posible.
                            </p>
                        </div>
                    </div>

                    {{-- Mensaje de error --}}
                    <div x-show="error" class="bg-red-50 border border-red-200 rounded-lg p-3">
                        <div class="flex gap-2">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5"></i>
                            <p class="text-sm text-red-700" x-text="error"></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-gray-200">
                <button
                    @click="closeModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors"
                    :disabled="loading"
                >
                    Cancelar
                </button>
                <button
                    @click="submit()"
                    :disabled="loading || !title || !description"
                    class="flex items-center gap-2 px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                >
                    <i data-lucide="send" class="w-4 h-4"></i>
                    <span x-text="loading ? 'Enviando...' : 'Enviar Reporte'"></span>
                </button>
            </div>
        </div>
        </div>
    </div>
</div>
</template>

@push('scripts')
<script>
function errorReportModal() {
    return {
        isOpen: false,
        loading: false,
        title: '',
        description: '',
        screenshotFile: null,
        screenshotPreview: null,
        success: false,
        error: null,

        openModal() {
            this.isOpen = true;
            this.resetForm();
        },

        closeModal() {
            this.isOpen = false;
            setTimeout(() => this.resetForm(), 300);
        },

        resetForm() {
            this.title = '';
            this.description = '';
            this.screenshotFile = null;
            this.screenshotPreview = null;
            this.success = false;
            this.error = null;
            this.loading = false;
        },

        handleScreenshotUpload(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    this.error = 'La imagen es muy grande. Máximo 5MB.';
                    return;
                }
                
                this.screenshotFile = file;
                this.error = null;
                
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.screenshotPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        async submit() {
            if (!this.title || !this.description) {
                this.error = 'Por favor completa todos los campos requeridos';
                return;
            }

            this.loading = true;
            this.error = null;
            this.success = false;

            const formData = new FormData();
            formData.append('title', this.title);
            formData.append('description', this.description);
            formData.append('page_url', window.location.href);
            if (this.screenshotFile) {
                formData.append('screenshot', this.screenshotFile);
            }

            try {
                const response = await fetch('{{ route("tenant.admin.error-reports.store", ["store" => $store->slug]) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    this.success = true;
                    setTimeout(() => this.closeModal(), 2000);
                } else {
                    this.error = data.message || 'Error al enviar el reporte';
                }
            } catch (error) {
                this.error = 'Error de conexión. Por favor intenta nuevamente.';
                console.error('Error:', error);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endpush
{{-- End SECTION: Error Report Modal --}}
