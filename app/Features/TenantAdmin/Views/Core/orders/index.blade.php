<x-tenant-admin-layout :store="$store">
@section('title', 'Pedidos')

@section('content')
<div x-data="ordersManager" 
     x-init="init(); initNotifications(); window.ordersManagerInstance = $data" 
     class="space-y-6">
    
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-900">Gestión de Pedidos</h1>
            <p class="text-sm text-gray-600 mt-1">
                Administra todos los pedidos de tu tienda (Domicilio, Recoger, Consumo Local, Habitación)
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="exportOrders()" 
                    class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" 
                    title="Exportar (Próximamente)">
                <i data-lucide="download" class="w-5 h-5"></i>
            </button>
            <a href="{{ route('tenant.admin.orders.create', $store->slug) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-sm">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Nuevo Pedido
            </a>
        </div>
    </div>

    {{-- Estadísticas --}}
    <x-orders-stats-widget :stats="$stats" />

    {{-- Filtros --}}
    <x-orders-filters-widget :store="$store" :currentFilters="$currentFilters" />

    {{-- Tabla de pedidos --}}
    <x-orders-table :orders="$orders" :store="$store" />

    {{-- Modal de Clave Maestra --}}
    <x-modal-master-key 
        modalId="master-key-modal"
        action="orders.cancel"
        actionLabel="Cancelar pedido"
    />

    {{-- Modal de confirmación de cancelación --}}
    <div x-show="showCancelModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[99999] overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm z-[99999]" 
                 @click="showCancelModal = false"></div>
            
            <div class="relative z-[99999] inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-semibold text-gray-900">
                                Cancelar Pedido
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">
                                    ¿Estás seguro de que deseas cancelar el pedido <strong x-text="cancelOrderNumber"></strong>? 
                                    Esta acción no se puede deshacer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="confirmCancelOrder()"
                            :disabled="cancelLoading"
                            class="w-full inline-flex justify-center items-center gap-2 rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                            :class="cancelLoading ? 'bg-red-400' : 'bg-red-600 hover:bg-red-700'">
                        <template x-if="cancelLoading">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="cancelLoading ? 'Cancelando...' : 'Sí, cancelar'"></span>
                    </button>
                    <button type="button" 
                            @click="showCancelModal = false; cancelOrderId = null; cancelOrderNumber = ''; cancelLoading = false"
                            :disabled="cancelLoading"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        No, mantener
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Paginación --}}
    @if($orders->hasPages())
        <div class="bg-white rounded-lg shadow-sm p-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('ordersManager', () => ({
        init() {
            // Inicialización silenciosa
        },

        // Handler para cancelar con clave maestra
        async cancelOrderHandler(orderId, orderNumber) {
            const isProtected = {{ $store->isActionProtected('orders', 'cancel') ? 'true' : 'false' }};
            
            if (isProtected) {
                // Guardar los datos del pedido antes de pedir la clave
                this.pendingCancelOrderId = orderId;
                this.pendingCancelOrderNumber = orderNumber;
                
                // Pedir clave maestra, cuando se verifique, mostrar el modal de confirmación
                requireMasterKey('orders.cancel', `Cancelar pedido #${orderNumber}`, () => {
                    // La clave fue verificada correctamente, ahora mostrar modal de confirmación
                    this.executeCancelOrder(this.pendingCancelOrderId, this.pendingCancelOrderNumber);
                    this.pendingCancelOrderId = null;
                    this.pendingCancelOrderNumber = '';
                });
            } else {
                await this.executeCancelOrder(orderId, orderNumber);
            }
        },

        // Ejecutar cancelación usando modal del DesignSystem
        async executeCancelOrder(orderId, orderNumber) {
            // Mostrar modal de confirmación
            this.showCancelModal = true;
            this.cancelOrderId = orderId;
            this.cancelOrderNumber = orderNumber;
        },
        
        pendingCancelOrderId: null,
        pendingCancelOrderNumber: '',

        // Confirmar cancelación
        async confirmCancelOrder() {
            if (!this.cancelOrderId) return;
            
            const orderId = this.cancelOrderId;
            const orderNumber = this.cancelOrderNumber;
            
            // Mostrar spinner en el modal
            this.cancelLoading = true;
            
            try {
                const response = await fetch(`{{ route('tenant.admin.orders.update-status', [$store->slug, ':id']) }}`.replace(':id', orderId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: 'cancelled' })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Cerrar modal primero
                    this.showCancelModal = false;
                    this.cancelLoading = false;
                    
                    // Actualización silenciosa de la tabla después de un pequeño delay
                    setTimeout(() => {
                        this.refreshOrdersTable();
                    }, 200);
                } else {
                    this.cancelLoading = false;
                    if (typeof window.showToast === 'function') {
                        window.showToast('error', 'Error', data.message || 'No se pudo cancelar el pedido');
                    }
                }
            } catch (error) {
                this.cancelLoading = false;
                if (typeof window.showToast === 'function') {
                    window.showToast('error', 'Error de conexión', 'No se pudo conectar con el servidor. Por favor, intenta nuevamente.');
                }
            } finally {
                this.cancelOrderId = null;
                this.cancelOrderNumber = '';
            }
        },

        // Actualizar pedido en la tabla sin recargar
        updateOrderInTable(orderId, newStatus) {
            // Buscar el componente OrdersTable y actualizar el estado
            const ordersTable = document.querySelector('[x-data*="ordersTable"]');
            if (ordersTable && ordersTable.__x && ordersTable.__x.$data) {
                const tableData = ordersTable.__x.$data;
                if (tableData.updateOrderStatus && typeof tableData.updateOrderStatus === 'function') {
                    // Llamar a la función de actualización del componente
                    tableData.updateOrderStatus(orderId, newStatus);
                    
                    // Forzar actualización adicional después de un pequeño delay
                    setTimeout(() => {
                        // Verificar que el cambio se aplicó
                        const order = tableData.orders?.find(o => o.id === orderId);
                        if (order && order.status !== newStatus) {
                            // Si no se actualizó, forzar manualmente
                            const orderIndex = tableData.orders.findIndex(o => o.id === orderId);
                            if (orderIndex !== -1) {
                                const updatedOrder = { ...tableData.orders[orderIndex], status: newStatus };
                                const newOrders = [...tableData.orders];
                                newOrders[orderIndex] = updatedOrder;
                                tableData.orders = newOrders;
                                
                                // Actualizar el select manualmente
                                const row = document.querySelector(`[data-order-id="${orderId}"]`);
                                if (row) {
                                    const select = row.querySelector('select');
                                    if (select) {
                                        select.value = newStatus;
                                        const statusClasses = tableData.getStatusSelectClass(newStatus);
                                        select.className = `w-full px-2 py-1 border border-gray-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary-500 cursor-pointer transition-colors ${statusClasses}`;
                                    }
                                }
                            }
                        }
                    }, 100);
                } else {
                    // Fallback: actualización manual
                    const orderIndex = tableData.orders?.findIndex(o => o.id === orderId);
                    if (orderIndex !== -1) {
                        const updatedOrder = { ...tableData.orders[orderIndex], status: newStatus };
                        const newOrders = [...tableData.orders];
                        newOrders[orderIndex] = updatedOrder;
                        tableData.orders = newOrders;
                        
                        // Actualizar el select manualmente
                        setTimeout(() => {
                            const row = document.querySelector(`[data-order-id="${orderId}"]`);
                            if (row) {
                                const select = row.querySelector('select');
                                if (select) {
                                    select.value = newStatus;
                                }
                            }
                        }, 50);
                    }
                }
            }
        },
        
        // Actualización silenciosa de la tabla y estadísticas
        async refreshOrdersTable() {
            try {
                // Obtener la URL actual con todos los parámetros de filtro
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('ajax', '1');
                
                // Hacer fetch de los datos en formato JSON
                const response = await fetch(currentUrl.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`Error ${response.status}: ${response.statusText}`);
                }
                
                const data = await response.json();
                
                if (!data.success) {
                    throw new Error('Error en la respuesta del servidor');
                }
                
                // Buscar el componente OrdersTable
                let ordersTableElement = document.querySelector('tbody[x-data*="ordersTable"]');
                if (!ordersTableElement) {
                    ordersTableElement = document.querySelector('[x-data*="ordersTable"]');
                }
                if (!ordersTableElement) {
                    const tableComponent = document.querySelector('x-orders-table');
                    if (tableComponent) {
                        ordersTableElement = tableComponent.querySelector('tbody[x-data*="ordersTable"]') || 
                                    tableComponent.querySelector('[x-data*="ordersTable"]');
                    }
                }
                
                // Acceder al componente Alpine
                let tableData = null;
                if (ordersTableElement) {
                    if (ordersTableElement.__x && ordersTableElement.__x.$data) {
                        tableData = ordersTableElement.__x.$data;
                    } else if (typeof Alpine !== 'undefined' && Alpine.$data) {
                        try {
                            tableData = Alpine.$data(ordersTableElement);
                        } catch (e) {
                            // Continuar con el siguiente método
                        }
                    }
                    
                    // Si aún no se encontró, esperar un momento
                    if (!tableData) {
                        await new Promise(resolve => setTimeout(resolve, 200));
                        
                        if (ordersTableElement.__x && ordersTableElement.__x.$data) {
                            tableData = ordersTableElement.__x.$data;
                        } else if (typeof Alpine !== 'undefined' && Alpine.$data) {
                            try {
                                tableData = Alpine.$data(ordersTableElement);
                            } catch (e) {
                                // Fallback: recargar página
                                window.location.reload();
                                return;
                            }
                        }
                    }
                }
                
                // Actualizar tabla de pedidos
                if (tableData && data.orders && Array.isArray(data.orders)) {
                    tableData.orders = [...data.orders];
                    
                    setTimeout(() => {
                        if (typeof lucide !== 'undefined' && lucide.createIcons) {
                            lucide.createIcons();
                        }
                    }, 100);
                } else {
                    window.location.reload();
                    return;
                }
                
                // Actualizar estadísticas sin recargar
                if (data.stats) {
                    const statsContainer = document.querySelector('.bg-white.rounded-lg.shadow-sm.p-4');
                    if (statsContainer) {
                        const statCards = statsContainer.querySelectorAll('.text-center.p-3');
                        
                        statCards.forEach(card => {
                            const label = card.querySelector('.text-xs')?.textContent?.trim();
                            const valueElement = card.querySelector('.text-xl, .text-lg');
                            
                            if (label && valueElement) {
                                const labelMap = {
                                    'Total': 'total',
                                    'Pendientes': 'pending',
                                    'Confirmados': 'confirmed',
                                    'Preparando': 'preparing',
                                    'Enviados': 'shipped',
                                    'Entregados': 'delivered',
                                    'Cancelados': 'cancelled',
                                    'Ingresos': 'total_revenue'
                                };
                                
                                const statKey = labelMap[label];
                                if (statKey && data.stats[statKey] !== undefined) {
                                    if (statKey === 'total_revenue') {
                                        valueElement.textContent = '$' + new Intl.NumberFormat('es-CO').format(data.stats[statKey]);
                                    } else {
                                        valueElement.textContent = data.stats[statKey];
                                    }
                                }
                            }
                        });
                    }
                }
                
            } catch (error) {
                // Fallback: recargar la página si falla la actualización silenciosa
                window.location.reload();
            }
        },
        
        cancelLoading: false,
        
        showCancelModal: false,
        cancelOrderId: null,
        cancelOrderNumber: '',

        initNotifications() {
            // Inicializar polling de notificaciones
            if (typeof lastOrderCount === 'undefined') {
                window.lastOrderCount = {{ $orders->total() }};
            }
            
            if (typeof pollingInterval === 'undefined') {
                window.pollingInterval = setInterval(checkForNewOrders, 30000); // Cada 30 segundos
            }
        }
    }));
});

// Manejar cambio de estado con protección de clave maestra
async function handleStatusChange(orderId, newStatus, selectElement, orderNumber) {
    // Verificar si el cambio a "delivered" está protegido
    const isProtected = newStatus === 'delivered' && {{ $store->isActionProtected('orders', 'mark_delivered') ? 'true' : 'false' }};
    
    if (isProtected) {
        requireMasterKey(
            'orders.mark_delivered',
            `Marcar pedido #${orderNumber} como entregado`,
            () => updateOrderStatus(orderId, newStatus, selectElement)
        );
    } else {
        updateOrderStatus(orderId, newStatus, selectElement);
    }
}

// Función para mostrar modal de cambio de estado
function showStatusChangeModal(orderId, newStatus, selectElement, orderNumber) {
    const statusLabels = {
        'pending': 'Pendiente',
        'confirmed': 'Confirmado',
        'preparing': 'Preparando',
        'shipped': 'Enviado',
        'delivered': 'Entregado',
        'cancelled': 'Cancelado'
    };

    const originalStatus = selectElement ? selectElement.getAttribute('data-original-status') : null;
    
    // Crear modal si no existe
    let modal = document.getElementById('status-change-modal');
    if (!modal) {
        modal = document.createElement('div');
        modal.id = 'status-change-modal';
        modal.className = 'fixed inset-0 z-[9999] overflow-y-auto';
        modal.style.display = 'none';
        modal.innerHTML = `
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" id="status-modal-backdrop"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" id="status-modal-content">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="info" class="h-6 w-6 text-blue-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-2">
                                    ¿Cambiar estado del pedido?
                                </h3>
                                <p class="text-sm text-gray-600 mb-4">
                                    El estado cambiará a: <strong id="status-label"></strong>
                                </p>
                                <textarea id="status-notes-input" 
                                          class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" 
                                          placeholder="Notas adicionales (opcional)" 
                                          rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="status-confirm-btn"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-500 text-base font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Cambiar Estado
                        </button>
                        <button type="button" id="status-cancel-btn"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        
        // Inicializar iconos
        setTimeout(() => {
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                lucide.createIcons();
            }
        }, 100);
    }
    
    // Configurar modal
    document.getElementById('status-label').textContent = statusLabels[newStatus];
    document.getElementById('status-notes-input').value = '';
    
    // Mostrar modal
    modal.style.display = 'block';
    
    // Event listeners
    const confirmBtn = document.getElementById('status-confirm-btn');
    const cancelBtn = document.getElementById('status-cancel-btn');
    const backdrop = document.getElementById('status-modal-backdrop');
    
    const closeModal = () => {
        modal.style.display = 'none';
        if (selectElement && originalStatus) {
            selectElement.value = originalStatus;
        }
    };
    
    const confirmChange = async () => {
        const notes = document.getElementById('status-notes-input').value;
        closeModal();
        await executeStatusChange(orderId, newStatus, notes);
    };
    
    // Remover listeners anteriores
    const newConfirmBtn = confirmBtn.cloneNode(true);
    const newCancelBtn = cancelBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
    
    newConfirmBtn.addEventListener('click', confirmChange);
    newCancelBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);
};

async function executeStatusChange(orderId, newStatus, notes) {
    
    try {
        const response = await fetch(`{{ route('tenant.admin.orders.update-status', [$store->slug, ':id']) }}`.replace(':id', orderId), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus,
                notes: notes
            })
        });

        const data = await response.json();

        if (data.success) {
            if (typeof window.showToast === 'function') {
                window.showToast('success', '¡Estado actualizado!', 'El estado del pedido ha sido cambiado correctamente');
            }
            setTimeout(() => location.reload(), 1500);
        } else {
            if (typeof window.showToast === 'function') {
                window.showToast('error', 'Error', data.message || 'No se pudo cambiar el estado del pedido');
            }
        }
    } catch (error) {
        if (typeof window.showToast === 'function') {
            window.showToast('error', 'Error de conexión', 'No se pudo conectar con el servidor');
        }
    }
}

async function updateOrderStatus(orderId, newStatus, selectElement) {
    showStatusChangeModal(orderId, newStatus, selectElement, '');
}

async function exportOrders() {
    if (typeof window.showToast === 'function') {
        window.showToast('info', 'Próximamente', 'La funcionalidad de exportación estará disponible pronto');
    }
}

// Función global para cancelOrderHandler
window.cancelOrderHandler = function(orderId, orderNumber) {
    // Intentar usar la instancia directa primero
    if (window.ordersManagerInstance && typeof window.ordersManagerInstance.cancelOrderHandler === 'function') {
        window.ordersManagerInstance.cancelOrderHandler(orderId, orderNumber);
        return;
    }
    
    // Fallback: buscar el componente Alpine
    const component = document.querySelector('[x-data="ordersManager"]');
    if (component && component.__x && component.__x.$data) {
        component.__x.$data.cancelOrderHandler(orderId, orderNumber);
    } else {
        console.error('No se pudo encontrar ordersManager');
    }
};

// Verificar nuevos pedidos
async function checkForNewOrders() {
    try {
        const response = await fetch('{{ route("tenant.admin.orders.api.count", $store->slug) }}');
        
        if (response.ok) {
            const data = await response.json();
            
            if (data.success) {
                const currentCount = data.count;
                
                if (currentCount > (window.lastOrderCount || 0)) {
                    const newOrders = currentCount - (window.lastOrderCount || 0);
                    showNewOrderNotification(newOrders, data.latest_order);
                    showNewOrderAlert(data.latest_order);
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 4000);
                }
                
                window.lastOrderCount = currentCount;
            }
        }
    } catch (error) {
        // Error silencioso
    }
}

function showNewOrderNotification(count, latestOrder) {
    if (Notification.permission !== 'granted') return;
    
    const title = count === 1 ? '🔔 ¡Nuevo pedido!' : `🔔 ¡${count} pedidos nuevos!`;
    const body = latestOrder ? 
        `Pedido #${latestOrder.order_number} - $${formatPrice(latestOrder.total)}\nCliente: ${latestOrder.customer_name}\n\n👆 Click para ver detalles` :
        'Revisa el panel de pedidos\n\n👆 Click para ver detalles';
    
    const notification = new Notification(title, {
        body: body,
        icon: '/favicon.ico',
        tag: 'new-order',
        requireInteraction: true
    });
    
    try {
        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmIePjuVvDY=');
        audio.volume = 0.3;
        audio.play().catch(() => {});
    } catch (e) {}
    
    notification.onclick = function() {
        window.focus();
        notification.close();
        
        if (latestOrder && latestOrder.id) {
            const orderUrl = `{{ route('tenant.admin.orders.index', $store->slug) }}`.replace('/orders', `/orders/${latestOrder.id}`);
            window.location.href = orderUrl;
        } else {
            window.location.reload();
        }
    };
}

function formatPrice(price) {
    return new Intl.NumberFormat('es-CO', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(price);
}

function showNewOrderAlert(latestOrder) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50 max-w-sm transform transition-all duration-300';
    alertDiv.style.transform = 'translateX(100%)';
    
    alertDiv.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    🔔
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="font-semibold text-sm">¡Nuevo pedido!</h4>
                <p class="text-xs opacity-90 mt-1">
                    ${latestOrder ? `#${latestOrder.order_number} - $${formatPrice(latestOrder.total)}` : 'Revisa el panel'}
                </p>
                <p class="text-xs opacity-75 mt-1">
                    ${latestOrder ? latestOrder.customer_name : ''}
                </p>
            </div>
            <div class="flex-shrink-0 flex flex-col gap-1">
                ${latestOrder ? `<button onclick="goToOrder(${latestOrder.id})" class="text-xs bg-white bg-opacity-20 hover:bg-opacity-30 px-2 py-1 rounded text-white transition-colors">Ver</button>` : ''}
                <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-xs text-white opacity-75 hover:opacity-100">✕</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        if (alertDiv.parentElement) {
            alertDiv.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (alertDiv.parentElement) {
                    alertDiv.remove();
                }
            }, 300);
        }
    }, 8000);
}

function goToOrder(orderId) {
    const orderUrl = `{{ route('tenant.admin.orders.index', $store->slug) }}`.replace('/orders', `/orders/${orderId}`);
    window.location.href = orderUrl;
}

window.addEventListener('beforeunload', () => {
    if (window.pollingInterval) {
        clearInterval(window.pollingInterval);
    }
});

// Función global para mostrar toast notifications
window.showToast = function(type, title, message, duration = 3000) {
    // Crear elemento toast si no existe
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'fixed top-4 right-4 z-[10000] space-y-2';
        document.body.appendChild(toastContainer);
    }
    
    // Crear toast
    const toast = document.createElement('div');
    const toastId = 'toast-' + Date.now();
    toast.id = toastId;
    
    const typeClasses = {
        'success': { bg: 'bg-teal-50', border: 'border-teal-200', icon: 'check-circle', iconColor: 'text-teal-600', iconBg: 'bg-teal-100' },
        'error': { bg: 'bg-red-50', border: 'border-red-200', icon: 'x-circle', iconColor: 'text-red-600', iconBg: 'bg-red-100' },
        'info': { bg: 'bg-blue-50', border: 'border-blue-200', icon: 'info', iconColor: 'text-blue-600', iconBg: 'bg-blue-100' },
        'warning': { bg: 'bg-yellow-50', border: 'border-yellow-200', icon: 'alert-triangle', iconColor: 'text-yellow-600', iconBg: 'bg-yellow-100' },
    };
    
    const config = typeClasses[type] || typeClasses['info'];
    
    toast.className = `${config.bg} ${config.border} border rounded-lg shadow-lg p-4 max-w-sm w-full transform transition-all duration-300 translate-x-full`;
    toast.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 rounded-full ${config.iconBg} flex items-center justify-center">
                    <i data-lucide="${config.icon}" class="w-5 h-5 ${config.iconColor}"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-gray-900">${title}</h4>
                <p class="text-sm text-gray-600 mt-1">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" 
                    class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Inicializar iconos Lucide
    setTimeout(() => {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
    }, 100);
    
    // Animación de entrada
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
        toast.classList.add('translate-x-0');
    }, 10);
    
    // Auto-remover
    setTimeout(() => {
        toast.classList.remove('translate-x-0');
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 300);
    }, duration);
};

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush
@endsection
</x-tenant-admin-layout>
