<x-tenant-admin-layout :store="$store">
@section('title', 'Pedidos')

@section('content')
<div x-data="ordersManager" x-init="init(); initNotifications()" class="space-y-4">
    
    <!-- Header con estadísticas -->
    <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
        <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-black-500 mb-2">Gestión de Pedidos</h2>
                    <p class="text-sm text-black-300">
                        Administra todos los pedidos de tu tienda
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="exportOrders()" class="text-black-300 hover:text-black-400 p-2 rounded-lg hover:bg-accent-100" title="Exportar (Próximamente)">
                        <x-solar-download-outline class="w-5 h-5" />
                    </button>
                    <a href="{{ route('tenant.admin.orders.create', $store->slug) }}" 
                       class="btn-primary flex items-center gap-2">
                        <x-solar-add-circle-outline class="w-5 h-5" />
                        Nuevo Pedido
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas Grid -->
        <div class="px-6 py-3 border-b border-accent-100 bg-accent-50">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
                <div class="text-center p-3 bg-gradient-to-r from-accent-400 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-black-500">{{ $stats['total'] }}</div>
                    <div class="text-caption text-black-300">Total</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-warning-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-black-500">{{ $stats['pending'] }}</div>
                    <div class="text-caption text-black-500">Pendientes</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-info-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-info-200">{{ $stats['confirmed'] }}</div>
                    <div class="text-caption text-info-200">Confirmados</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-secondary-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-secondary-200">{{ $stats['preparing'] }}</div>
                    <div class="text-caption text-secondary-200">Preparando</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-primary-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-primary-200">{{ $stats['shipped'] }}</div>
                    <div class="text-caption text-primary-200">Enviados</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-success-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-black-500">{{ $stats['delivered'] }}</div>
                    <div class="text-caption text-black-500">Entregados</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-error-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-error-300">{{ $stats['cancelled'] }}</div>
                    <div class="text-caption text-error-300">Cancelados</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-success-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-black-500">${{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                    <div class="text-caption text-black-500">Ingresos</div>
                </div>
            </div>
        </div>

        <!-- Barra de herramientas y filtros -->
        <div class="px-6 py-3 border-b border-accent-100 bg-accent-50">
            <form method="GET" action="{{ route('tenant.admin.orders.index', $store->slug) }}">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-4">
                        <!-- Filtros rápidos -->
                        <select name="status" class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                            <option value="">Todos los estados</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                            <option value="preparing" {{ request('status') === 'preparing' ? 'selected' : '' }}>Preparando</option>
                            <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Enviado</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Entregado</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        </select>

                        <select name="payment_method" class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                            <option value="">Todos los métodos</option>
                            <option value="transferencia" {{ request('payment_method') === 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="contra_entrega" {{ request('payment_method') === 'contra_entrega' ? 'selected' : '' }}>Contra Entrega</option>
                            <option value="efectivo" {{ request('payment_method') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        </select>

                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Buscar por número, cliente..." 
                               class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">

                        <button type="submit" class="px-3 py-1.5 bg-primary-200 text-accent-50 rounded-lg text-sm hover:bg-primary-300 transition-colors">
                            <x-solar-magnifer-outline class="w-4 h-4" />
                        </button>

                        <a href="{{ route('tenant.admin.orders.index', $store->slug) }}" class="px-3 py-1.5 bg-accent-100 text-black-300 rounded-lg text-sm hover:bg-accent-200 transition-colors">
                            <x-solar-restart-outline class="w-4 h-4" />
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-black-300">{{ $orders->total() }} pedidos</span>
                    </div>
                </div>

                <!-- Filtros avanzados expandibles -->
                <div x-data="{ showAdvanced: false }">
                    <button type="button" @click="showAdvanced = !showAdvanced" 
                            class="text-sm text-primary-200 hover:text-primary-300 flex items-center gap-1">
                        <span x-text="showAdvanced ? 'Ocultar filtros avanzados' : 'Mostrar filtros avanzados'"></span>
                        <x-solar-alt-arrow-down-outline class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': showAdvanced }" />
                    </button>
                    
                    <div x-show="showAdvanced" x-transition class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Fecha Desde</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                   class="w-full px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                        </div>
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Fecha Hasta</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                   class="w-full px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                        </div>
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Monto Desde</label>
                            <input type="number" name="amount_from" value="{{ request('amount_from') }}" 
                                   placeholder="0" min="0" step="1000"
                                   class="w-full px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                        </div>
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Monto Hasta</label>
                            <input type="number" name="amount_to" value="{{ request('amount_to') }}" 
                                   placeholder="Sin límite" min="0" step="1000"
                                   class="w-full px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-accent-100">
                    <tr class="text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                        <th class="px-6 py-3">Pedido</th>
                        <th class="px-6 py-3">Cliente</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Pago</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-accent-50 divide-y divide-accent-100">
                    @forelse($orders as $order)
                        <tr class="text-black-400 hover:bg-accent-100">
                            <td class="px-6 py-4">
                                <div class="flex items-center text-sm">
                                    <div class="w-10 h-10 mr-3 flex items-center justify-center bg-primary-50 rounded-lg">
                                        <x-solar-clipboard-list-outline class="w-5 h-5 text-primary-200" />
                                    </div>
                                    <div>
                                        <a href="{{ route('tenant.admin.orders.show', [$store->slug, $order->id]) }}" class="font-semibold text-info-300 underline">{{ $order->order_number }}</a>
                                        <p class="text-caption text-black-200">{{ $order->items_count }} {{ $order->items_count == 1 ? 'producto' : 'productos' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    <p class="font-semibold text-black-500">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-black-200">{{ $order->customer_phone }}</p>
                                    <p class="text-xs text-black-200">{{ $order->delivery_type_label }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <select onchange="handleStatusChange({{ $order->id }}, this.value, this, '{{ $order->order_number }}')" 
                                        data-original-status="{{ $order->status }}"
                                        class="w-full px-2 py-1 border border-accent-200 rounded-lg text-caption font-medium focus:outline-none focus:ring-2 focus:ring-primary-200 {{ $order->status_color }} {{ $order->status === 'delivered' ? 'text-black-500' : '' }} cursor-pointer transition-colors">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                                    <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparando</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Enviado</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Entregado</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    <p class="text-black-500">{{ $order->payment_method_label }}</p>
                                    @if($order->payment_proof_path)
                                        <a href="{{ $order->payment_proof_url }}" 
                                           target="_blank" 
                                           download
                                           class="text-xs text-success-300 hover:text-success-400 flex items-center underline transition-colors">
                                            <x-solar-download-outline class="w-3 h-3 mr-1" />
                                            Descargar comprobante
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    <p class="font-semibold text-black-500">${{ number_format($order->total, 0, ',', '.') }}</p>
                                    @if($order->shipping_cost > 0)
                                        <p class="text-xs text-black-200">+ ${{ number_format($order->shipping_cost, 0, ',', '.') }} envío</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    <p class="text-black-500">{{ $order->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-black-200">{{ $order->created_at->format('H:i') }}</p>
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center justify-center gap-4">
                                    <!-- Ver -->
                                    <a href="{{ route('tenant.admin.orders.show', [$store->slug, $order->id]) }}" 
                                       class="text-info-200 hover:text-info-300" title="Ver">
                                        <x-solar-eye-outline class="w-5 h-5" />
                                    </a>

                                    <!-- Editar (solo estados tempranos) -->
                                    @if($order->canBeEdited())
                                        <a href="{{ route('tenant.admin.orders.edit', [$store->slug, $order->id]) }}" 
                                           class="text-primary-200 hover:text-primary-300" title="Editar">
                                            <x-solar-pen-new-square-outline class="w-5 h-5" />
                                        </a>
                                    @endif

                                    <!-- Cancelar (en lugar de eliminar) -->
                                    @if(!in_array($order->status, ['delivered', 'cancelled']))
                                        <button @click="cancelOrderHandler({{ $order->id }}, '{{ $order->order_number }}')" 
                                                class="text-error-300 hover:text-error-400" 
                                                title="Cancelar pedido">
                                            <x-solar-close-circle-outline class="w-5 h-5" />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <x-solar-clipboard-list-outline class="w-12 h-12 text-black-200 mb-3" />
                                    <p class="text-black-300">No hay pedidos</p>
                                    @if(request()->hasAny(['status', 'payment_method', 'delivery_type', 'search', 'date_from', 'date_to', 'amount_from', 'amount_to']))
                                        <p class="text-sm text-black-200 mb-3">No se encontraron pedidos con los filtros aplicados</p>
                                        <a href="{{ route('tenant.admin.orders.index', $store->slug) }}" class="btn-primary text-sm">
                                            Limpiar filtros
                                        </a>
                                    @else
                                        <a href="{{ route('tenant.admin.orders.create', $store->slug) }}" class="btn-primary mt-3 text-sm">
                                            Crear primer pedido
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-accent-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div x-show="showDeleteModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showDeleteModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity" 
                 @click="closeDeleteModal()">
                <div class="absolute inset-0 bg-black-500/75 backdrop-blur-sm"></div>
            </div>

            <!-- Modal -->
            <div x-show="showDeleteModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-accent-50 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <div class="bg-accent-50 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-error-50 sm:mx-0 sm:h-10 sm:w-10">
                            <x-solar-trash-bin-trash-bold class="h-6 w-6 text-error-300" />
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-black-400">
                                Cancelar Pedido
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-black-300">
                                    ¿Estás seguro de que deseas cancelar el pedido <span class="font-semibold" x-text="cancelOrderNumber"></span>? 
                                    Esta acción no se puede deshacer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-accent-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            @click="confirmDelete()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-error-200 text-base font-medium text-accent-50 hover:bg-error-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-error-200 sm:ml-3 sm:w-auto sm:text-sm">
                        Eliminar
                    </button>
                    <button type="button" 
                            @click="closeDeleteModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-accent-300 shadow-sm px-4 py-2 bg-accent-50 text-base font-medium text-black-400 hover:bg-accent-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('ordersManager', () => ({
        showDeleteModal: false,
        cancelOrderId: null,
        cancelOrderNumber: '',

        init() {
            // Inicialización silenciosa
        },

        cancelOrder(orderId, orderNumber) {
            this.cancelOrderId = orderId;
            this.cancelOrderNumber = orderNumber;
            this.showDeleteModal = true;
        },

        closeDeleteModal() {
            this.showDeleteModal = false;
            this.cancelOrderId = null;
            this.cancelOrderNumber = '';
        },

        // Handler para cancelar con clave maestra
        async cancelOrderHandler(orderId, orderNumber) {
            const isProtected = {{ $store->isActionProtected('orders', 'cancel') ? 'true' : 'false' }};
            
            if (isProtected) {
                requireMasterKey('orders.cancel', `Cancelar pedido #${orderNumber}`, async () => {
                    await this.executeCancelOrder(orderId, orderNumber);
                });
            } else {
                this.cancelOrder(orderId, orderNumber);
            }
        },

        // Ejecutar cancelación directa (sin modal)
        async executeCancelOrder(orderId, orderNumber) {
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
                    await Swal.fire({
                        title: '¡Pedido cancelado!',
                        text: 'El pedido ha sido cancelado correctamente',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#da27a7',
                        timer: 3000,
                        timerProgressBar: true
                    });
                    location.reload();
                } else {
                    await Swal.fire({
                        title: 'Error',
                        text: data.message || 'No se pudo cancelar el pedido',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#da27a7'
                    });
                }
            } catch (error) {
                await Swal.fire({
                    title: 'Error de conexión',
                    text: 'No se pudo conectar con el servidor',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#da27a7'
                });
            }
        },

        async confirmDelete() {
            if (this.cancelOrderId) {
                this.closeDeleteModal();
                
                // Cambiar estado a cancelled en lugar de eliminar
                try {
                    const response = await fetch(`{{ route('tenant.admin.orders.update-status', [$store->slug, ':id']) }}`.replace(':id', this.cancelOrderId), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            status: 'cancelled'
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        await Swal.fire({
                            title: '¡Pedido cancelado!',
                            text: 'El pedido ha sido cancelado correctamente',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#da27a7',
                            timer: 3000,
                            timerProgressBar: true
                        });
                        location.reload();
                    } else {
                        await Swal.fire({
                            title: 'Error',
                            text: data.message || 'No se pudo cancelar el pedido',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#da27a7'
                        });
                    }
                } catch (error) {
                    await Swal.fire({
                        title: 'Error de conexión',
                        text: 'No se pudo conectar con el servidor',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#da27a7'
                    });
                }
            }
        }
    }));
});

// Manejar cambio de estado con protección de clave maestra
async function handleStatusChange(orderId, newStatus, selectElement, orderNumber) {
    // Verificar si el cambio a "delivered" está protegido
    const isProtected = newStatus === 'delivered' && {{ $store->isActionProtected('orders', 'mark_delivered') ? 'true' : 'false' }};
    
    if (isProtected) {
        // Solicitar clave maestra
        requireMasterKey(
            'orders.mark_delivered',
            `Marcar pedido #${orderNumber} como entregado`,
            () => updateOrderStatus(orderId, newStatus, selectElement)
        );
    } else {
        // Ejecutar directamente
        updateOrderStatus(orderId, newStatus, selectElement);
    }
}

async function updateOrderStatus(orderId, newStatus, selectElement) {
    const statusLabels = {
        'pending': 'Pendiente',
        'confirmed': 'Confirmado',
        'preparing': 'Preparando',
        'shipped': 'Enviado',
        'delivered': 'Entregado',
        'cancelled': 'Cancelado'
    };

    // Guardar el valor original del select
    const originalStatus = selectElement ? selectElement.getAttribute('data-original-status') : null;

    const result = await Swal.fire({
        title: '¿Cambiar estado del pedido?',
        html: `
            <p class="text-body-small text-black-400 mb-4">
                El estado cambiará a: <strong>${statusLabels[newStatus]}</strong>
            </p>
            <textarea id="status-notes" class="w-full px-3 py-2 border border-accent-200 rounded-lg text-body-small focus:outline-none focus:ring-2 focus:ring-primary-200" 
                      placeholder="Notas adicionales (opcional)" rows="3"></textarea>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Cambiar Estado',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#da27a7',
        cancelButtonColor: '#001b48',
        preConfirm: () => {
            return document.getElementById('status-notes').value;
        }
    });

    if (!result.isConfirmed) {
        // Revertir el select al valor original
        if (selectElement && originalStatus) {
            selectElement.value = originalStatus;
        }
        return;
    }

    const notes = result.value;
    
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
            await Swal.fire({
                title: '¡Estado actualizado!',
                text: 'El estado del pedido ha sido cambiado correctamente',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#da27a7',
                timer: 3000,
                timerProgressBar: true
            });
            location.reload();
        } else {
            await Swal.fire({
                title: 'Error',
                text: data.message || 'No se pudo cambiar el estado del pedido',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#da27a7'
            });
        }
    } catch (error) {
        await Swal.fire({
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#da27a7'
        });
    }
}

async function duplicateOrder(orderId) {
    const result = await Swal.fire({
        title: '¿Duplicar este pedido?',
        text: 'Se creará una copia exacta del pedido',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Duplicar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#da27a7',
        cancelButtonColor: '#efefef'
    });

    if (!result.isConfirmed) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ route('tenant.admin.orders.duplicate', [$store->slug, ':id']) }}`.replace(':id', orderId);
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    form.appendChild(csrfToken);
    
    document.body.appendChild(form);
    form.submit();
}

async function exportOrders() {
    await Swal.fire({
        title: 'Próximamente',
        text: 'La funcionalidad de exportación estará disponible pronto',
        icon: 'info',
        confirmButtonText: 'OK',
        confirmButtonColor: '#da27a7'
    });
}

// Función global para cancelOrder desde botones
window.cancelOrder = function(orderId, orderNumber) {
    const component = document.querySelector('[x-data="ordersManager"]');
    if (component && component.__x) {
        component.__x.$data.cancelOrder(orderId, orderNumber);
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
                
                // Si hay más pedidos que antes
                if (currentCount > lastOrderCount) {
                    const newOrders = currentCount - lastOrderCount;
                    showNewOrderNotification(newOrders, data.latest_order);
                    showNewOrderAlert(data.latest_order);
                    
                    // Actualizar la página automáticamente
                    setTimeout(() => {
                        window.location.reload();
                    }, 4000);
                }
                
                lastOrderCount = currentCount;
            }
        }
    } catch (error) {
        // Error silencioso
    }
}

// Mostrar notificación de nuevo pedido
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
        requireInteraction: true // Mantener hasta que el usuario la cierre
    });
    
    // Sonido opcional (si el navegador lo permite)
    try {
        const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmIePjuVvDY=');
        audio.volume = 0.3;
        audio.play().catch(() => {}); // Ignorar errores de audio
    } catch (e) {}
    
    // Click en notificación para ir al pedido específico
    notification.onclick = function() {
        window.focus();
        notification.close();
        
        // Si hay un pedido específico, ir a su vista de detalle
        if (latestOrder && latestOrder.id) {
            const orderUrl = `{{ route('tenant.admin.orders.index', $store->slug) }}`.replace('/orders', `/orders/${latestOrder.id}`);
            window.location.href = orderUrl;
        } else {
            // Si no hay pedido específico, solo recargar la página
            window.location.reload();
        }
    };
}

// Formatear precio
function formatPrice(price) {
    return new Intl.NumberFormat('es-CO', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(price);
}

// Mostrar alert flotante en la página para nuevo pedido
function showNewOrderAlert(latestOrder) {
    // Crear alert flotante
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 bg-success-300 text-white p-4 rounded-lg shadow-lg z-50 max-w-sm transform transition-all duration-300';
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
    
    // Animación de entrada
    setTimeout(() => {
        alertDiv.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto-remover después de 8 segundos
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

// Ir a un pedido específico
function goToOrder(orderId) {
    const orderUrl = `{{ route('tenant.admin.orders.index', $store->slug) }}`.replace('/orders', `/orders/${orderId}`);
    window.location.href = orderUrl;
}


// Detener polling al salir de la página
window.addEventListener('beforeunload', () => {
    if (pollingInterval) {
        clearInterval(pollingInterval);
    }
});
</script>
@endpush
@endsection
</x-tenant-admin-layout> 