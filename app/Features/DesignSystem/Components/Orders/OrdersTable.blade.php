{{--
OrdersTable - Tabla de pedidos con badges de tipo
Uso: Mostrar lista de pedidos con información de tipo (delivery, pickup, dine_in, room_service)
Cuándo usar: Vista index de pedidos
Cuándo NO usar: Cuando se necesite otra estructura de tabla
Ejemplo: <x-orders-table :orders="$orders" :store="$store" />
--}}

@props([
    'orders' => [],
    'store' => null,
])

@php
    // Mapeo de tipos de orden a badges
    $orderTypeBadges = [
        'delivery' => ['type' => 'info', 'text' => 'Domicilio', 'icon' => 'truck'],
        'pickup' => ['type' => 'info', 'text' => 'Recoger', 'icon' => 'package'],
        'dine_in' => ['type' => 'success', 'text' => 'Consumo Local', 'icon' => 'utensils-crossed'],
        'room_service' => ['type' => 'warning', 'text' => 'Habitación', 'icon' => 'bed'],
    ];
@endphp

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Pedido
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Cliente
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Tipo
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Pago
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Total
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" 
                   x-data="ordersTable(@js($orders->getCollection()->map(function($order) {
                       return [
                           'id' => $order->id,
                           'order_number' => $order->order_number,
                           'customer_name' => $order->customer_name,
                           'customer_phone' => $order->customer_phone,
                           'order_type' => $order->order_type ?? 'delivery',
                           'table_number' => $order->table_number,
                           'room_number' => $order->room_number,
                           'status' => $order->status,
                           'payment_method' => $order->payment_method,
                           'payment_proof_path' => $order->payment_proof_path,
                           'payment_proof_url' => $order->payment_proof_url,
                           'total' => (float) $order->total,
                           'shipping_cost' => (float) ($order->shipping_cost ?? 0),
                           'created_at' => $order->created_at->toISOString(),
                           'items_count' => $order->items_count ?? 0,
                           'can_be_edited' => $order->canBeEdited(),
                       ];
                   })->values()->toArray()), '{{ $store->slug }}')">
            <template x-for="order in orders" :key="order.id">
                <tr class="hover:bg-gray-50 transition-colors" x-bind:data-order-id="order.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm">
                                <div class="w-10 h-10 mr-3 flex items-center justify-center rounded-lg"
                                     x-bind:class="getOrderIconBgClass(order.order_type)">
                                    <template x-if="order.order_type === 'delivery'">
                                        <i data-lucide="truck" x-bind:class="getOrderIconColorClass(order.order_type)" class="w-5 h-5"></i>
                                    </template>
                                    <template x-if="order.order_type === 'pickup'">
                                        <i data-lucide="package" x-bind:class="getOrderIconColorClass(order.order_type)" class="w-5 h-5"></i>
                                    </template>
                                    <template x-if="order.order_type === 'dine_in'">
                                        <i data-lucide="utensils-crossed" x-bind:class="getOrderIconColorClass(order.order_type)" class="w-5 h-5"></i>
                                    </template>
                                    <template x-if="order.order_type === 'room_service'">
                                        <i data-lucide="bed" x-bind:class="getOrderIconColorClass(order.order_type)" class="w-5 h-5"></i>
                                    </template>
                                    <template x-if="!['delivery', 'pickup', 'dine_in', 'room_service'].includes(order.order_type)">
                                        <i data-lucide="clipboard-list" x-bind:class="getOrderIconColorClass(order.order_type)" class="w-5 h-5"></i>
                                    </template>
                                </div>
                                <div>
                                    <a :href="getOrderUrl(order.id)" class="font-semibold text-blue-600 hover:text-blue-700 underline">
                                        #<span x-text="order.order_number"></span>
                                    </a>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <span x-text="order.items_count || 0"></span> 
                                        <span x-text="(order.items_count || 0) === 1 ? 'producto' : 'productos'"></span>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                <p class="font-semibold text-gray-900" x-text="order.customer_name"></p>
                                <p class="text-xs text-gray-500" x-text="order.customer_phone"></p>
                                <template x-if="order.table_number">
                                    <p class="text-xs text-gray-500 mt-1">
                                        Mesa #<span x-text="order.table_number"></span>
                                    </p>
                                </template>
                                <template x-if="order.room_number">
                                    <p class="text-xs text-gray-500 mt-1">
                                        Habitación #<span x-text="order.room_number"></span>
                                    </p>
                                </template>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium"
                                x-bind:class="getOrderTypeBadgeClass(order.order_type)"
                                x-text="getOrderTypeBadge(order.order_type).text">
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <select 
                                x-on:change="handleStatusChange(order.id, $event.target.value, $event.target, order.order_number)"
                                x-bind:data-original-status="order.status"
                                x-bind:class="getStatusSelectClass(order.status)"
                                class="w-full px-2 py-1 border border-gray-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary-500 cursor-pointer transition-colors">
                                <option value="pending" x-bind:selected="order.status === 'pending'">Pendiente</option>
                                <option value="confirmed" x-bind:selected="order.status === 'confirmed'">Confirmado</option>
                                <option value="preparing" x-bind:selected="order.status === 'preparing'">Preparando</option>
                                <option value="shipped" x-bind:selected="order.status === 'shipped'">Enviado</option>
                                <option value="delivered" x-bind:selected="order.status === 'delivered'">Entregado</option>
                                <option value="cancelled" x-bind:selected="order.status === 'cancelled'">Cancelado</option>
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                <p class="text-gray-900" x-text="getPaymentMethodLabel(order.payment_method)"></p>
                                <template x-if="order.payment_proof_url">
                                    <a :href="order.payment_proof_url" 
                                       target="_blank" 
                                       download
                                       class="text-xs text-blue-600 hover:text-blue-700 flex items-center gap-1 underline transition-colors mt-1">
                                        <i data-lucide="download" class="w-3 h-3"></i>
                                        Descargar comprobante
                                    </a>
                                </template>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                <p class="font-semibold text-gray-900">
                                    $<span x-text="formatCurrency(order.total)"></span>
                                </p>
                                <template x-if="order.shipping_cost > 0">
                                    <p class="text-xs text-gray-500">
                                        + $<span x-text="formatCurrency(order.shipping_cost)"></span> envío
                                    </p>
                                </template>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm">
                                <p class="text-gray-900" x-text="formatDate(order.created_at)"></p>
                                <p class="text-xs text-gray-500" x-text="formatTime(order.created_at)"></p>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-3">
                                <div class="relative inline-block" x-data="{ tooltipOpen: false }">
                                    <a :href="getOrderUrl(order.id)" 
                                       @mouseenter="tooltipOpen = true"
                                       @mouseleave="tooltipOpen = false"
                                       class="text-blue-600 hover:text-blue-700 transition-colors">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </a>
                                    <div x-show="tooltipOpen"
                                         x-transition:enter="transition-opacity duration-200"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition-opacity duration-150"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="absolute z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-lg whitespace-nowrap top-full left-1/2 -translate-x-1/2 mt-2"
                                         style="display: none;">
                                        Ver detalles
                                    </div>
                                </div>
                                <template x-if="order.can_be_edited">
                                    <div class="relative inline-block" x-data="{ tooltipOpen: false }">
                                        <a :href="getEditUrl(order.id)" 
                                           @mouseenter="tooltipOpen = true"
                                           @mouseleave="tooltipOpen = false"
                                           class="text-primary-600 hover:text-primary-700 transition-colors">
                                            <i data-lucide="pencil" class="w-5 h-5"></i>
                                        </a>
                                        <div x-show="tooltipOpen"
                                             x-transition:enter="transition-opacity duration-200"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="transition-opacity duration-150"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0"
                                             class="absolute z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-lg whitespace-nowrap top-full left-1/2 -translate-x-1/2 mt-2"
                                             style="display: none;">
                                            Editar pedido
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!['delivered', 'cancelled'].includes(order.status)">
                                    <div class="relative inline-block" x-data="{ tooltipOpen: false }">
                                        <button 
                                            x-on:click="handleCancelOrder(order.id, order.order_number)"
                                            @mouseenter="tooltipOpen = true"
                                            @mouseleave="tooltipOpen = false"
                                            class="text-red-600 hover:text-red-700 transition-colors">
                                            <i data-lucide="x-circle" class="w-5 h-5"></i>
                                        </button>
                                        <div x-show="tooltipOpen"
                                             x-transition:enter="transition-opacity duration-200"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="transition-opacity duration-150"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0"
                                             class="absolute z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-lg whitespace-nowrap top-full left-1/2 -translate-x-1/2 mt-2"
                                             style="display: none;">
                                            Cancelar pedido
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
    
    {{-- Empty state --}}
    @if($orders->isEmpty())
        <div class="text-center py-12">
            <i data-lucide="clipboard-list" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
            <p class="text-sm text-gray-500 mb-2">No hay pedidos</p>
            @if(request()->hasAny(['status', 'order_type', 'payment_method', 'search', 'date_from', 'date_to', 'amount_from', 'amount_to']))
                <p class="text-xs text-gray-400 mb-3">No se encontraron pedidos con los filtros aplicados</p>
                <a href="{{ route('tenant.admin.orders.index', $store->slug) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 text-white rounded-lg text-sm hover:bg-primary-600 transition-colors">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    Limpiar filtros
                </a>
            @else
                <a href="{{ route('tenant.admin.orders.create', $store->slug) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-primary-500 text-white rounded-lg text-sm hover:bg-primary-600 transition-colors mt-3">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Crear primer pedido
                </a>
            @endif
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('ordersTable', (orders, storeSlug) => ({
        orders: orders,
        
        // Función pública para actualizar el estado de un pedido
        updateOrderStatus(orderId, newStatus) {
            const orderIndex = this.orders.findIndex(o => o.id === orderId);
            if (orderIndex !== -1) {
                // Crear un nuevo objeto completamente nuevo para el pedido actualizado
                const updatedOrder = {
                    ...this.orders[orderIndex],
                    status: newStatus
                };
                
                // Crear un nuevo array completamente nuevo con el pedido actualizado
                const newOrders = this.orders.map((order, index) => {
                    if (index === orderIndex) {
                        return updatedOrder;
                    }
                    return order;
                });
                
                // Asignar el nuevo array - esto fuerza la reactividad de Alpine
                this.orders = newOrders;
                
                // Forzar actualización inmediata del DOM
                this.$nextTick(() => {
                    // Buscar la fila del pedido actualizado
                    const row = document.querySelector(`[data-order-id="${orderId}"]`);
                    if (row) {
                        // Actualizar el select manualmente
                        const select = row.querySelector('select');
                        if (select) {
                            select.value = newStatus;
                            // Actualizar las clases del select
                            const statusClasses = this.getStatusSelectClass(newStatus);
                            select.className = `w-full px-2 py-1 border border-gray-200 rounded-lg text-xs font-medium focus:outline-none focus:ring-2 focus:ring-primary-500 cursor-pointer transition-colors ${statusClasses}`;
                        }
                    }
                    
                    // Reinicializar iconos Lucide
                    if (typeof lucide !== 'undefined' && lucide.createIcons) {
                        lucide.createIcons();
                    }
                });
                
                // Forzar re-render de Alpine usando $dispatch
                this.$dispatch('order-updated', { orderId, newStatus });
            }
        },

        getOrderUrl(orderId) {
            return `/${storeSlug}/admin/orders/${orderId}`;
        },

        getEditUrl(orderId) {
            return `/${storeSlug}/admin/orders/${orderId}/edit`;
        },

        getOrderIcon(orderType) {
            const icons = {
                'delivery': 'truck',
                'pickup': 'package',
                'dine_in': 'utensils-crossed',
                'room_service': 'bed',
            };
            return icons[orderType] || 'clipboard-list';
        },

        getOrderIconBgClass(orderType) {
            const classMap = {
                'delivery': 'bg-blue-100',
                'pickup': 'bg-blue-100',
                'dine_in': 'bg-teal-100',
                'room_service': 'bg-yellow-100',
            };
            return classMap[orderType] || 'bg-gray-100';
        },

        getOrderIconColorClass(orderType) {
            const classMap = {
                'delivery': 'text-blue-600',
                'pickup': 'text-blue-600',
                'dine_in': 'text-teal-600',
                'room_service': 'text-yellow-600',
            };
            return classMap[orderType] || 'text-gray-600';
        },

        getOrderTypeBadge(orderType) {
            const badges = {
                'delivery': { type: 'info', text: 'Domicilio' },
                'pickup': { type: 'info', text: 'Recoger' },
                'dine_in': { type: 'success', text: 'Consumo Local' },
                'room_service': { type: 'warning', text: 'Habitación' },
            };
            return badges[orderType] || { type: 'secondary', text: orderType };
        },

        getOrderTypeBadgeClass(orderType) {
            const badge = this.getOrderTypeBadge(orderType);
            const classMap = {
                'info': 'bg-blue-100 text-blue-800',
                'success': 'bg-teal-100 text-teal-800',
                'warning': 'bg-yellow-100 text-yellow-800',
                'secondary': 'bg-gray-50 text-gray-500',
            };
            return classMap[badge.type] || classMap['secondary'];
        },

        getStatusSelectClass(status) {
            const classMap = {
                'pending': 'bg-yellow-50 text-yellow-800 border-yellow-200',
                'confirmed': 'bg-blue-50 text-blue-800 border-blue-200',
                'preparing': 'bg-gray-50 text-gray-600 border-gray-200',
                'shipped': 'bg-purple-50 text-purple-800 border-purple-200',
                'delivered': 'bg-teal-50 text-teal-800 border-teal-200',
                'cancelled': 'bg-red-50 text-red-800 border-red-200',
            };
            return classMap[status] || 'bg-gray-50 text-gray-600 border-gray-200';
        },

        getPaymentMethodLabel(method) {
            const labels = {
                'transferencia': 'Transferencia',
                'contra_entrega': 'Contra Entrega',
                'efectivo': 'Efectivo',
            };
            return labels[method] || method;
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('es-CO').format(Math.round(value || 0));
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-CO', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        },

        formatTime(dateString) {
            const date = new Date(dateString);
            return date.toLocaleTimeString('es-CO', {
                hour: '2-digit',
                minute: '2-digit'
            });
        },

        handleStatusChange(orderId, newStatus, selectElement, orderNumber) {
            // Llamar a la función global
            if (typeof window.handleStatusChange === 'function') {
                window.handleStatusChange(orderId, newStatus, selectElement, orderNumber);
            } else {
                console.error('handleStatusChange no está disponible');
            }
        },

        handleCancelOrder(orderId, orderNumber) {
            // Llamar directamente a la función global
            if (typeof window.cancelOrderHandler === 'function') {
                window.cancelOrderHandler(orderId, orderNumber);
            } else {
                // Fallback: intentar encontrar el componente Alpine
                if (window.ordersManagerInstance && typeof window.ordersManagerInstance.cancelOrderHandler === 'function') {
                    window.ordersManagerInstance.cancelOrderHandler(orderId, orderNumber);
                } else {
                    const component = document.querySelector('[x-data="ordersManager"]');
                    if (component && component.__x && component.__x.$data) {
                        component.__x.$data.cancelOrderHandler(orderId, orderNumber);
                    } else {
                        console.error('cancelOrderHandler no está disponible');
                    }
                }
            }
        }
    }));
});

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush

