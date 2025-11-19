<x-tenant-admin-layout :store="$store">
    @section('title', 'Dashboard')
    @section('subtitle', 'Panel de administración de tu tienda')

    @section('content')
        {{-- Banner de Estado de Aprobación --}}
        @if($store->approval_status === 'pending_approval')
        <div class="mb-6 bg-white border-l-4 border-warning-400 rounded-lg p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-warning-100 rounded-full flex items-center justify-center">
                        <i data-lucide="clock" class="w-6 h-6 text-warning-500"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">⏰ Tu tienda está en revisión</h3>
                    <p class="text-sm text-gray-600 mb-3">
                        Estamos revisando tu solicitud. Este proceso usualmente toma <strong>24-48 horas</strong>.
                        Te notificaremos por email cuando tu tienda esté aprobada y lista para publicar.
                    </p>
                </div>
            </div>
        </div>
        @endif

        {{-- SECTION: Anuncios (solo aparece cuando hay anuncios) --}}
        <div class="mb-6" 
             x-data="{ 
                hasBanners: false,
                async init() {
                    try {
                        const response = await fetch('{{ route('tenant.admin.announcements.api.banners', $store->slug) }}');
                        const data = await response.json();
                        this.hasBanners = data && data.length > 0;
                    } catch (error) {
                        this.hasBanners = false;
                    }
                }
             }"
             x-init="init()"
             x-show="hasBanners"
             x-transition>
            <div class="bg-white rounded-lg shadow-sm p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Anuncios</h3>
                <x-announcement-carousel 
                    :apiUrl="route('tenant.admin.announcements.api.banners', $store->slug)"
                    height="h-64"
                />
            </div>
        </div>

        {{-- SECTION: Estadísticas Principales --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
            <x-stat-card title="Total" :value="$stats['total']" icon="shopping-cart" color="accent" />
            <x-stat-card title="Pendientes" :value="$stats['pending']" icon="clock" color="warning" />
            <x-stat-card title="Confirmados" :value="$stats['confirmed']" icon="check-circle" color="info" />
            <x-stat-card title="Preparando" :value="$stats['preparing']" icon="utensils-crossed" color="secondary" />
            <x-stat-card title="Enviados" :value="$stats['shipped']" icon="truck" color="primary" />
            <x-stat-card title="Entregados" :value="$stats['delivered']" icon="check-circle-2" color="success" />
        </div>

        {{-- SECTION: Acciones Rápidas --}}
        <div class="bg-white rounded-lg shadow-sm p-5 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                <x-quick-action-button 
                    :href="route('tenant.admin.sliders.create', ['store' => $store->slug])"
                    label="Crear Slider"
                    icon="image"
                    color="warning"
                />
                <x-quick-action-button 
                    :href="route('tenant.admin.products.create', ['store' => $store->slug])"
                    label="Agregar Producto"
                    icon="plus"
                    color="primary"
                />
                <x-quick-action-button 
                    :href="route('tenant.admin.orders.create', ['store' => $store->slug])"
                    label="Crear Pedido"
                    icon="shopping-cart"
                    color="info"
                />
                <x-quick-action-button 
                    :href="route('tenant.admin.coupons.create', ['store' => $store->slug])"
                    label="Crear Cupón"
                    icon="tag"
                    color="success"
                />
                @php
                    $hasTableReservations = featureEnabled($store, 'reservas_mesas');
                @endphp
                <x-quick-action-button 
                    :href="$hasTableReservations ? route('tenant.admin.reservations.create', ['store' => $store->slug]) : '#'"
                    label="Reserva Restaurante"
                    icon="calendar"
                    color="warning"
                    :disabled="!$hasTableReservations"
                />
                @php
                    $hasHotelReservations = featureEnabled($store, 'reservas_hotel');
                @endphp
                <x-quick-action-button 
                    :href="$hasHotelReservations ? route('tenant.admin.hotel.reservations.create', ['store' => $store->slug]) : '#'"
                    label="Reserva Hotel"
                    icon="bed"
                    color="info"
                    :disabled="!$hasHotelReservations"
                />
            </div>
        </div>

        {{-- SECTION: Pedidos Recientes --}}
        <div class="bg-white rounded-lg shadow-sm p-5">
            <x-orders-table-widget 
                title="Pedidos Recientes"
                :orders="$allOrders"
                :viewAllUrl="route('tenant.admin.orders.index', ['store' => $store->slug])"
                :maxItems="20"
                :perPage="10"
                :storeSlug="$store->slug"
            />
        </div>
    @endsection
</x-tenant-admin-layout>

