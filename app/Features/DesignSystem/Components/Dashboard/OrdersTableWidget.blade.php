{{--
OrdersTableWidget - Tabla única de pedidos con badges de tipo
Uso: Mostrar todos los pedidos en una sola tabla con badges que indican el tipo/origen
Cuándo usar: Dashboards, paneles de control donde se necesitan ver todos los pedidos juntos
Cuándo NO usar: Cuando se necesita separar por tipo en diferentes secciones
Ejemplo: <x-orders-table-widget :orders="$allOrders" title="Pedidos Recientes" :viewAllUrl="route('orders.index')" />
--}}

@props([
    'title' => 'Pedidos Recientes',
    'orders' => [],
    'viewAllUrl' => '#',
    'maxItems' => 10,
    'storeSlug' => '',
    'perPage' => 10,
])

@php
    // Mapeo de tipos de orden a badges
    $orderTypeBadges = [
        'delivery' => ['type' => 'info', 'text' => 'Domicilio', 'icon' => 'truck'],
        'pickup' => ['type' => 'info', 'text' => 'Recoger', 'icon' => 'package'],
        'dine_in' => ['type' => 'success', 'text' => 'Consumo Local', 'icon' => 'utensils-crossed'],
        'room_service' => ['type' => 'warning', 'text' => 'Habitación', 'icon' => 'bed'],
    ];
    
    // Mapeo de estados a colores
    $statusColors = [
        'pending' => 'warning',
        'confirmed' => 'info',
        'preparing' => 'secondary',
        'shipped' => 'primary',
        'delivered' => 'success',
        'cancelled' => 'error',
    ];
    
    // Convertir a array si es Collection
    if (is_array($orders)) {
        $ordersArray = $orders;
    } else {
        $ordersArray = $orders->toArray();
    }
    
    // Limitar total de pedidos a mostrar (ya vienen ordenados del controlador)
    $totalOrders = array_slice($ordersArray, 0, $maxItems);
@endphp

<div {{ $attributes }}>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-0 flex items-center gap-2">
            <i data-lucide="shopping-cart" class="w-5 h-5 text-primary-400"></i>
            {{ $title }}
        </h3>
        <a href="{{ $viewAllUrl }}" 
           class="text-sm font-medium text-primary-400 hover:text-primary-500 transition-colors">
            Ver todos →
        </a>
    </div>
    
    @if(count($totalOrders) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            # Pedido
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Total
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Fecha
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" x-data="ordersTableWidget({{ json_encode($totalOrders) }}, '{{ $storeSlug }}', {{ $perPage }})">
                    <template x-for="order in paginatedOrders" :key="order.id">
                        <tr class="hover:bg-gray-50 transition-colors cursor-pointer" 
                            @click="window.location.href = getOrderUrl(order.id)">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">#<span x-text="order.order_number"></span></span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <span class="font-medium" x-text="order.customer_name"></span>
                                    <template x-if="order.table_number">
                                        <span class="text-xs text-gray-500 block mt-1">Mesa #<span x-text="order.table_number"></span></span>
                                    </template>
                                    <template x-if="order.room_number">
                                        <span class="text-xs text-gray-500 block mt-1">Habitación #<span x-text="order.room_number"></span></span>
                                    </template>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span 
                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium"
                                    x-bind:class="getOrderTypeBadgeClass(order.order_type)"
                                    x-text="getOrderTypeBadge(order.order_type).text">
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span 
                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium"
                                    x-bind:class="getStatusBadgeClass(order.status)"
                                    x-text="getStatusLabel(order.status)">
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">$<span x-text="formatCurrency(order.total)"></span></span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-xs text-gray-500" x-text="formatDate(order.created_at)"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        
        {{-- Paginación --}}
        <div x-show="totalPages > 1" class="mt-4 flex items-center justify-between border-t border-gray-200 pt-4">
            <div class="text-sm text-gray-700">
                Mostrando <span x-text="startIndex + 1"></span> a <span x-text="endIndex"></span> de <span x-text="orders.length"></span> pedidos
            </div>
            <nav class="flex items-center gap-1" aria-label="Paginación">
                <button 
                    @click="previousPage()"
                    :disabled="currentPage === 1"
                    class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    aria-label="Página anterior">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <template x-for="page in totalPages" :key="page">
                    <button 
                        @click="goToPage(page)"
                        :class="currentPage === page ? 'bg-primary-100 text-primary-600 font-semibold' : 'text-gray-600 hover:bg-gray-100'"
                        class="min-w-10 h-10 flex items-center justify-center rounded-lg transition-colors"
                        x-text="page">
                    </button>
                </template>
                <button 
                    @click="nextPage()"
                    :disabled="currentPage === totalPages"
                    class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    aria-label="Página siguiente">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </nav>
        </div>
    @else
        <div class="text-center py-12">
            <i data-lucide="inbox" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
            <p class="text-sm text-gray-500">No hay pedidos</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('ordersTableWidget', (orders, storeSlug, perPage = 10) => ({
        orders: orders,
        currentPage: 1,
        perPage: perPage,
        
        get totalPages() {
            return Math.ceil(this.orders.length / this.perPage);
        },
        
        get paginatedOrders() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.orders.slice(start, end);
        },
        
        get startIndex() {
            return (this.currentPage - 1) * this.perPage;
        },
        
        get endIndex() {
            return Math.min(this.startIndex + this.perPage, this.orders.length);
        },
        
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        
        goToPage(page) {
            this.currentPage = page;
        },
        
        getOrderUrl(orderId) {
            return `/${storeSlug}/admin/orders/${orderId}`;
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
        
        getStatusLabel(status) {
            const statuses = @json(\App\Shared\Models\Order::STATUSES);
            return statuses[status] || status;
        },
        
        getStatusColor(status) {
            const colorMap = {
                'pending': 'warning',
                'confirmed': 'info',
                'preparing': 'secondary',
                'shipped': 'primary',
                'delivered': 'success',
                'cancelled': 'error',
            };
            return colorMap[status] || 'secondary';
        },
        
        getStatusBadgeClass(status) {
            const colorMap = {
                'pending': 'bg-yellow-100 text-yellow-800',
                'confirmed': 'bg-blue-100 text-blue-800',
                'preparing': 'bg-gray-50 text-gray-500',
                'shipped': 'bg-purple-100 text-purple-800',
                'delivered': 'bg-teal-100 text-teal-800',
                'cancelled': 'bg-red-100 text-red-800',
            };
            return colorMap[status] || 'bg-gray-50 text-gray-500';
        },
        
        formatCurrency(value) {
            return new Intl.NumberFormat('es-CO').format(Math.round(value || 0));
        },
        
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('es-CO', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }));
});

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});

// Reinicializar iconos cuando cambie la página (para los iconos de paginación)
document.addEventListener('alpine:init', () => {
    Alpine.effect(() => {
        // Observar cambios en la paginación y reinicializar iconos
        setTimeout(() => {
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                lucide.createIcons();
            }
        }, 100);
    });
});
</script>
@endpush

