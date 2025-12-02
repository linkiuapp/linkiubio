<x-tenant-admin-layout :store="$store">
@section('title', $type === 'mesa' ? 'Consumo en Local - Vista en Vivo' : 'Servicio a Habitación - Vista en Vivo')

@section('content')
<div class="space-y-4">
    <div x-data="dineInDashboard({{ json_encode([
        'storeSlug' => $store->slug,
        'type' => $type,
        'apiUrl' => route('tenant.admin.dine-in.api.status', ['store' => $store->slug, 'type' => $type])
    ]) }})">
        <!-- Header -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-black-500 mb-2">
                            {{ $type === 'mesa' ? '🍽️ Consumo en Local' : '🏨 Servicio a Habitación' }} - Vista en Vivo
                        </h2>
                        <p class="text-sm text-black-300">
                            Monitorea el estado de todas tus {{ $type === 'mesa' ? 'mesas' : 'habitaciones' }} en tiempo real
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button 
                            @click="refreshStatus"
                            class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-2 px-3 body-small bg-gray-100 text-gray-500 hover:bg-gray-200 focus:bg-gray-200 border border-transparent"
                            x-bind:disabled="loading"
                        >
                            <i data-lucide="refresh-cw" class="w-5 h-5" x-bind:class="{ 'animate-spin': loading }"></i>
                            <span x-text="loading ? 'Actualizando...' : 'Actualizar'"></span>
                        </button>
                        <a 
                            href="{{ route('tenant.admin.dine-in.tables.index', ['store' => $store->slug, 'type' => $type]) }}" 
                            class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-2 px-3 body-small bg-gray-100 text-gray-500 hover:bg-gray-200 focus:bg-gray-200 border border-transparent"
                        >
                            <i data-lucide="settings" class="w-5 h-5"></i>
                            Gestión
                        </a>
                    </div>
                </div>
            </div>

            <!-- Resumen -->
            <div class="px-6 py-4 bg-accent-50 border-b border-accent-100">
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <x-stat-card 
                            title="Total {{ ucfirst($type) }}s"
                            :value="$stats['total']"
                            icon="{{ $type === 'mesa' ? 'utensils' : 'bed' }}"
                            color="accent"
                        >
                            <h3 class="text-3xl font-bold text-gray-900 mb-0" x-text="stats.total"></h3>
                        </x-stat-card>
                    </div>
                    <div>
                        <x-stat-card 
                            title="Disponibles"
                            :value="$stats['available']"
                            icon="check-circle"
                            color="success"
                        >
                            <h3 class="text-3xl font-bold text-gray-900 mb-0" x-text="stats.available"></h3>
                        </x-stat-card>
                    </div>
                    <div>
                        <x-stat-card 
                            title="Ocupadas"
                            :value="$stats['occupied']"
                            icon="clock"
                            color="warning"
                        >
                            <h3 class="text-3xl font-bold text-gray-900 mb-0" x-text="stats.occupied"></h3>
                        </x-stat-card>
                    </div>
                    <div>
                        <x-stat-card 
                            title="En Proceso"
                            :value="number_format($stats['total_revenue'], 0, ',', '.')"
                            icon="dollar-sign"
                            color="primary"
                        >
                            <h3 class="text-3xl font-bold text-gray-900 mb-0" x-text="formatCurrency(stats.total_revenue)"></h3>
                        </x-stat-card>
                    </div>
                </div>
            </div>

            <!-- Mesas/Habitaciones Activas -->
            <div class="p-6">
                <h3 class="text-sm font-semibold text-black-500 mb-4">
                    {{ ucfirst($type === 'mesa' ? 'Mesas' : 'Habitaciones') }} Activas
                    <span class="text-black-300 font-normal" x-text="'( ' + activeTables.length + ' )'"></span>
                </h3>
                
                <div class="space-y-4" x-show="activeTables.length > 0">
                    <template x-for="table in activeTables" :key="table.id">
                        <div class="bg-white rounded-lg p-4 border border-accent-200 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 flex items-center justify-center rounded-lg"
                                         :class="table.status === 'occupied' ? 'bg-error-50' : 'bg-warning-50'">
                                        <i data-lucide="{{ $type === 'mesa' ? 'utensils' : 'bed' }}" 
                                           class="w-6 h-6"
                                           :class="table.status === 'occupied' ? 'text-error-400' : 'text-warning-400'"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-black-500">
                                            {{ ucfirst($type) }} #<span x-text="table.table_number"></span>
                                        </h4>
                                        <p class="text-xs text-black-300" x-text="table.status === 'occupied' ? '🔴 OCUPADA' : '🟡 RESERVADA'"></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-black-500" x-text="table.order.order_number"></p>
                                    <p class="text-xs text-black-300" x-text="formatCurrency(table.order.total)"></p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-3">
                                <div>
                                    <p class="text-xs text-black-300 mb-1">Estado del Pedido</p>
                                    <p class="text-sm font-medium text-black-500">
                                        <span x-text="getOrderStatusIcon(table.order.status)"></span>
                                        <span x-text="getOrderStatusLabel(table.order.status)"></span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-black-300 mb-1">Tiempo</p>
                                    <p class="text-sm font-medium text-black-500" x-text="table.order.time_elapsed_formatted"></p>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <p class="text-xs text-black-300 mb-1">Items:</p>
                                <p class="text-sm text-black-400" x-text="formatOrderItems(table.order.items)"></p>
                            </div>
                            
                            <div class="flex items-center justify-between pt-3 border-t border-accent-100">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-black-300">Propina:</span>
                                    <span class="text-sm font-medium text-black-500" x-text="formatCurrency(table.order.tip_amount)"></span>
                                    <template x-if="table.order.tip_amount > 0">
                                        <span class="text-xs text-black-300" x-text="'( ' + calculateTipPercentage(table.order.tip_amount, table.order.total) + '% )'"></span>
                                    </template>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a 
                                        x-bind:href="'/{{ $store->slug }}/admin/orders/' + table.order.id"
                                        class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-1.5 px-3 text-xs bg-primary-50 text-primary-300 hover:bg-primary-100 focus:bg-primary-100 border border-transparent"
                                    >
                                        Ver Detalles
                                    </a>
                                    <template x-if="table.order.status === 'preparing' || table.order.status === 'confirmed'">
                                        <x-button-base 
                                            type="soft" 
                                            color="success" 
                                            size="sm"
                                            htmlType="button"
                                            text="Marcar Listo"
                                            @click="markAsReady(table.order.id)"
                                        />
                                    </template>
                                    <template x-if="table.order.status === 'delivered'">
                                        <x-button-base 
                                            type="solid" 
                                            color="primary" 
                                            size="sm"
                                            htmlType="button"
                                            text="Cobrar"
                                            @click="markAsPaid(table.order.id, table.id)"
                                        />
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div x-show="activeTables.length === 0" class="text-center py-12">
                    <i data-lucide="{{ $type === 'mesa' ? 'utensils' : 'bed' }}" class="w-16 h-16 mx-auto mb-3 text-black-200"></i>
                    <p class="text-black-300">No hay {{ $type === 'mesa' ? 'mesas' : 'habitaciones' }} activas en este momento</p>
                </div>
            </div>

            <!-- Mesas/Habitaciones Libres -->
            <div class="px-6 pb-6">
                <h3 class="text-sm font-semibold text-black-500 mb-3">
                    {{ ucfirst($type === 'mesa' ? 'Mesas' : 'Habitaciones') }} Libres
                </h3>
                <div class="flex flex-wrap gap-2">
                    <template x-for="table in availableTables" :key="table.id">
                        <span class="px-3 py-1.5 bg-success-50 text-success-400 rounded-lg text-xs font-medium">
                            #<span x-text="table.table_number"></span>
                        </span>
                    </template>
                    <span x-show="availableTables.length === 0" class="text-xs text-black-300">No hay {{ $type === 'mesa' ? 'mesas' : 'habitaciones' }} disponibles</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- SECTION: Notificaciones en Tiempo Real -->
    <template x-if="notifications.length > 0">
        <div class="fixed top-4 right-4 z-[9999] space-y-2 max-w-md w-full">
            <template x-for="(notification, index) in notifications" :key="notification.id">
                <div 
                    x-show="true"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform translate-x-full"
                    class="cursor-pointer"
                    @click="removeNotification(notification.id)"
                >
                    <x-alert-bordered 
                        :type="notification.type" 
                        :title="notification.title" 
                        :message="notification.message"
                    />
                </div>
            </template>
        </div>
    </template>
    {{-- End SECTION: Notificaciones en Tiempo Real --}}
</div>

@push('scripts')
<script>
function dineInDashboard(config) {
    return {
        apiUrl: config.apiUrl,
        loading: false,
        stats: {
            total: 0,
            available: 0,
            occupied: 0,
            reserved: 0,
            total_revenue: 0
        },
        activeTables: [],
        availableTables: [],
        refreshInterval: null,
        previousActiveTablesCount: 0,
        notifications: [],
        
        init() {
            this.loadStatus();
            // Auto-refresh cada 30 segundos
            this.refreshInterval = setInterval(() => {
                this.loadStatus();
            }, 30000);
            
            // Inicializar notificaciones en tiempo real
            this.initRealtimeNotifications();
        },
        
        destroy() {
            if (this.refreshInterval) {
                clearInterval(this.refreshInterval);
            }
        },
        
        loadStatus() {
            this.loading = true;
            
            fetch(this.apiUrl)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const previousCount = this.activeTables.length;
                        this.stats = data.stats;
                        this.activeTables = data.active_tables || [];
                        this.availableTables = (data.tables || []).filter(t => t.status === 'available');
                        
                        // Detectar nuevos pedidos
                        if (previousCount > 0 && this.activeTables.length > previousCount) {
                            const newOrders = this.activeTables.slice(previousCount);
                            newOrders.forEach(order => {
                                this.showNewOrderNotification(order);
                            });
                        }
                        
                        this.previousActiveTablesCount = this.activeTables.length;
                    }
                })
                .catch(err => {
                    console.error('Error loading status:', err);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        
        initRealtimeNotifications() {
            // Verificar si Pusher/Echo está disponible
            if (typeof window.Echo === 'undefined') {
                console.warn('⚠️ Pusher/Echo no disponible, usando polling únicamente');
                return;
            }
            
            try {
                const storeId = document.body.dataset.storeId;
                if (!storeId) {
                    console.warn('⚠️ No se encontró storeId para notificaciones');
                    return;
                }
                
                // Escuchar nuevos pedidos de dine-in/room-service
                window.Echo.channel(`store.${storeId}.orders`)
                    .listen('new.order', (data) => {
                        // Solo mostrar si es pedido de dine-in o room-service
                        if (data.order_type === 'dine_in' || data.order_type === 'room_service') {
                            this.showNewOrderNotification(data);
                            this.loadStatus(); // Refrescar estado
                        }
                    });
                
                console.log('✅ Notificaciones en tiempo real configuradas para dine-in');
            } catch (error) {
                console.error('❌ Error configurando notificaciones:', error);
            }
        },
        
        showNewOrderNotification(order) {
            const orderNumber = order.order_number || order.id;
            const customerName = order.customer_name || 'Cliente';
            const total = this.formatCurrency(order.total || 0);
            const tableNumber = order.table_number || '';
            
            // Notificación de escritorio
            if (Notification.permission === 'granted') {
                new Notification(`📦 Nuevo Pedido - ${this.type === 'mesa' ? 'Mesa' : 'Habitación'} ${tableNumber}`, {
                    body: `Pedido #${orderNumber}\n${customerName}\nTotal: ${total}`,
                    icon: '/favicon.ico',
                    tag: `dine-in-order-${order.id}`,
                    requireInteraction: false
                });
            }
            
            // Notificación in-app (alert-bordered)
            this.notifications.push({
                id: Date.now(),
                type: 'success',
                title: `📦 Nuevo Pedido - ${this.type === 'mesa' ? 'Mesa' : 'Habitación'} ${tableNumber}`,
                message: `Pedido #${orderNumber} de ${customerName} - Total: ${total}`,
                orderId: order.id
            });
            
            // Auto-eliminar después de 8 segundos
            setTimeout(() => {
                const index = this.notifications.findIndex(n => n.id === this.notifications[this.notifications.length - 1].id);
                if (index !== -1) {
                    this.notifications.splice(index, 1);
                }
            }, 8000);
            
            // Sonido de notificación
            this.playNotificationSound();
        },
        
        playNotificationSound() {
            try {
                const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmIePjuVvDY=');
                audio.volume = 0.5;
                audio.play().catch(() => {});
            } catch (e) {
                // Sin sonido disponible
            }
        },
        
        removeNotification(id) {
            const index = this.notifications.findIndex(n => n.id === id);
            if (index !== -1) {
                this.notifications.splice(index, 1);
            }
        },
        
        refreshStatus() {
            this.loadStatus();
        },
        
        formatCurrency(amount) {
            return '$' + new Intl.NumberFormat('es-CO').format(Math.round(amount || 0));
        },
        
        getOrderStatusIcon(status) {
            const icons = {
                'pending': '⏳',
                'confirmed': '✅',
                'preparing': '🔥',
                'ready_for_pickup': '📦',
                'delivered': '💰',
            };
            return icons[status] || '📋';
        },
        
        getOrderStatusLabel(status) {
            const labels = {
                'pending': 'Recibido',
                'confirmed': 'Confirmado',
                'preparing': 'En cocina',
                'ready_for_pickup': 'Listo',
                'delivered': 'Entregado',
            };
            return labels[status] || status;
        },
        
        formatOrderItems(items) {
            if (!items || items.length === 0) return 'Sin items';
            return items.map(item => `${item.quantity}x ${item.name}`).join(', ');
        },
        
        calculateTipPercentage(tipAmount, total) {
            if (!tipAmount || !total || total === 0) return 0;
            return Math.round((tipAmount / (total - tipAmount)) * 100);
        },
        
        async markAsReady(orderId) {
            // TODO: Implementar cambio de estado a "ready_for_pickup"
            Swal.fire({
                icon: 'info',
                title: 'En desarrollo',
                text: 'Marcar como listo - En desarrollo',
                confirmButtonColor: '#da27a7'
            });
        },
        
        async markAsPaid(orderId, tableId) {
            // TODO: Implementar marcado como pagado y liberar mesa
            const result = await Swal.fire({
                title: '¿Marcar como pagado?',
                text: 'Se marcará como pagado y se liberará ' + config.type,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00c76f',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: '✓ Sí, marcar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!result.isConfirmed) return;
            
            if (result.isConfirmed) {
                fetch(`/${config.storeSlug}/admin/dine-in/tables/${tableId}/liberate`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.loadStatus();
                    }
                });
            }
        }
    };
}
</script>
@endpush
@endsection
</x-tenant-admin-layout>

