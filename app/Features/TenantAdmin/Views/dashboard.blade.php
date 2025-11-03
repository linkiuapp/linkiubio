<x-tenant-admin-layout :store="$store">
    @section('title', 'Dashboard')
    @section('subtitle', 'Panel de administración de tu tienda')

    @section('content')
        {{-- Banner de Estado de Aprobación --}}
        @if($store->approval_status === 'pending_approval')
        <div class="mb-6 bg-gradient-to-r from-warning-100 to-warning-50 border-l-4 border-warning-300 rounded-lg p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-warning-300 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-warning-500 mb-2">⏰ Tu tienda está en revisión</h3>
                    <p class="text-sm text-black-400 mb-3">
                        Estamos revisando tu solicitud. Este proceso usualmente toma <strong>24-48 horas</strong>.
                        Te notificaremos por email cuando tu tienda esté aprobada y lista para publicar.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-6 grid-rows-7 gap-4">
            {{-- 1. Card Total --}}
            <div class="bg-gradient-to-r from-accent-200 to-accent-50 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-accent-300 flex items-center justify-center flex-shrink-0">
                        <x-lucide-shopping-cart class="w-5 h-5 text-accent-50" />
                    </div>
                    <h2 class="text-body-small text-black-400 mb-0 font-medium">Total</h2>
                </div>
                <h3 class="text-h3 text-black-300 mb-0 font-extrabold">{{ $stats['total'] }}</h3>
            </div>

            {{-- 2. Card Pendientes --}}
            <div class="bg-gradient-to-r from-warning-100 to-accent-50 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-warning-200 flex items-center justify-center flex-shrink-0">
                        <x-lucide-clock class="w-5 h-5 text-warning-300" />
                    </div>
                    <h2 class="text-body-small text-black-400 mb-0 font-medium">Pendientes</h2>
                </div>
                <h3 class="text-h3 text-black-300 mb-0 font-extrabold">{{ $stats['pending'] }}</h3>
            </div>

            {{-- 3. Card Confirmados --}}
            <div class="bg-gradient-to-r from-info-100 to-accent-50 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-info-200 flex items-center justify-center flex-shrink-0">
                        <x-lucide-check-circle class="w-5 h-5 text-info-300" />
                    </div>
                    <h2 class="text-body-small text-black-400 mb-0 font-medium">Confirmados</h2>
                </div>
                <h3 class="text-h3 text-black-300 mb-0 font-extrabold">{{ $stats['confirmed'] }}</h3>
            </div>

            {{-- 4. Card Preparando --}}
            <div class="bg-gradient-to-r from-secondary-100 to-accent-50 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-secondary-200 flex items-center justify-center flex-shrink-0">
                        <x-lucide-utensils-crossed class="w-5 h-5 text-secondary-300" />
                    </div>
                    <h2 class="text-body-small text-black-400 mb-0 font-medium">Preparando</h2>
                </div>
                <h3 class="text-h3 text-black-300 mb-0 font-extrabold">{{ $stats['preparing'] }}</h3>
            </div>

            {{-- 5. Card Enviado --}}
            <div class="bg-gradient-to-r from-primary-100 to-accent-50 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-primary-200 flex items-center justify-center flex-shrink-0">
                        <x-lucide-truck class="w-5 h-5 text-primary-300" />
                    </div>
                    <h2 class="text-body-small text-black-400 mb-0 font-medium">Enviados</h2>
                </div>
                <h3 class="text-h3 text-black-300 mb-0 font-extrabold">{{ $stats['shipped'] }}</h3>
            </div>

            {{-- 6. Card Entregado --}}
            <div class="bg-gradient-to-r from-success-100 to-accent-50 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-success-200 flex items-center justify-center flex-shrink-0">
                        <x-lucide-check-circle-2 class="w-5 h-5 text-success-300" />
                    </div>
                    <h2 class="text-body-small text-black-400 mb-0 font-medium">Entregados</h2>
                </div>
                <h3 class="text-h3 text-black-300 mb-0 font-extrabold">{{ $stats['delivered'] }}</h3>
            </div>

            {{-- 7. Crear Slider --}}
            <div class="col-start-1 row-start-2">
                <a href="{{ route('tenant.admin.sliders.create', ['store' => $store->slug]) }}" 
                   class="flex flex-col items-center justify-center h-full bg-warning-300 rounded-lg p-4 shadow-sm hover:bg-warning-200 transition-colors group">
                    <div class="w-12 h-12 rounded-lg bg-warning-200 flex items-center justify-center mb-2 group-hover:bg-warning-100 transition-colors">
                        <x-lucide-circle-plus class="w-6 h-6 text-warning-300 group-hover:text-warning-400" />
                    </div>
                    <span class="text-body-small font-medium text-black-300 text-center">Crear Slider</span>
                </a>
            </div>

            {{-- 8. Agregar Producto --}}
            <div class="col-start-6 row-start-2">
                <a href="{{ route('tenant.admin.products.create', ['store' => $store->slug]) }}" 
                   class="flex flex-col items-center justify-center h-full bg-primary-300 rounded-lg p-4 shadow-sm hover:bg-primary-400 transition-colors group">
                    <div class="w-12 h-12 rounded-lg bg-primary-200 flex items-center justify-center mb-2 group-hover:bg-primary-100 transition-colors">
                        <x-lucide-circle-plus class="w-6 h-6 text-primary-300 group-hover:text-primary-400" />
                    </div>
                    <span class="text-body-small font-medium text-accent-50 text-center">Agregar Producto</span>
                </a>
            </div>

            {{-- 9. Crear Pedido --}}
            <div class="col-start-1 row-start-3">
                <a href="{{ route('tenant.admin.orders.create', ['store' => $store->slug]) }}" 
                   class="flex flex-col items-center justify-center h-full bg-info-300 rounded-lg p-4 shadow-sm hover:bg-info-400 transition-colors group">
                    <div class="w-12 h-12 rounded-lg bg-info-200 flex items-center justify-center mb-2 group-hover:bg-info-100 transition-colors">
                        <x-lucide-circle-plus class="w-6 h-6 text-info-300 group-hover:text-info-400" />
                    </div>
                    <span class="text-body-small font-medium text-accent-50 text-center">Crear Pedido</span>
                </a>
            </div>

            {{-- 10. Crear Cupón --}}
            <div class="col-start-2 row-start-3">
                <a href="{{ route('tenant.admin.coupons.create', ['store' => $store->slug]) }}" 
                   class="flex flex-col items-center justify-center h-full bg-secondary-300 rounded-lg p-4 shadow-sm hover:bg-secondary-200 transition-colors group">
                    <div class="w-12 h-12 rounded-lg bg-secondary-200 flex items-center justify-center mb-2 group-hover:bg-secondary-100 transition-colors">
                        <x-lucide-circle-plus class="w-6 h-6 text-secondary-300 group-hover:text-secondary-400" />
                    </div>
                    <span class="text-body-small font-medium text-accent-50 text-center">Crear Cupón</span>
                </a>
            </div>

            {{-- 11. Crear Reserva Restaurante --}}
            <div class="col-start-3 row-start-2">
                @php
                    $hasTableReservations = featureEnabled($store, 'reservas_mesas');
                @endphp
                <a href="{{ $hasTableReservations ? route('tenant.admin.reservations.create', ['store' => $store->slug]) : '#' }}" 
                   class="flex flex-col items-center justify-center h-full bg-warning-300 rounded-lg p-4 shadow-sm transition-colors group {{ $hasTableReservations ? 'hover:bg-warning-200 cursor-pointer' : 'opacity-50 cursor-not-allowed' }}"
                   @if(!$hasTableReservations) onclick="event.preventDefault(); Swal.fire({ icon: 'info', title: 'Feature no disponible', text: 'Las reservas de mesa no están habilitadas en tu plan.' });" @endif>
                    <div class="w-12 h-12 rounded-lg bg-warning-200 flex items-center justify-center mb-2 group-hover:bg-warning-100 transition-colors">
                        <x-lucide-circle-plus class="w-6 h-6 text-warning-300 group-hover:text-warning-400" />
                    </div>
                    <span class="text-body-small font-medium text-black-300 text-center">Crear Reserva Restaurante</span>
                </a>
            </div>

            {{-- 12. Crear Reserva Hotel --}}
            <div class="col-start-3 row-start-3">
                @php
                    $hasHotelReservations = featureEnabled($store, 'reservas_hotel');
                @endphp
                <a href="{{ $hasHotelReservations ? route('tenant.admin.hotel.reservations.create', ['store' => $store->slug]) : '#' }}" 
                   class="flex flex-col items-center justify-center h-full bg-info-200 rounded-lg p-4 shadow-sm transition-colors group {{ $hasHotelReservations ? 'hover:bg-info-100 cursor-pointer' : 'opacity-50 cursor-not-allowed' }}"
                   @if(!$hasHotelReservations) onclick="event.preventDefault(); Swal.fire({ icon: 'info', title: 'Feature no disponible', text: 'Las reservas de hotel no están habilitadas en tu plan.' });" @endif>
                    <div class="w-12 h-12 rounded-lg bg-info-100 flex items-center justify-center mb-2 group-hover:bg-info-50 transition-colors">
                        <x-lucide-circle-plus class="w-6 h-6 text-info-200 group-hover:text-info-300" />
                    </div>
                    <span class="text-body-small font-medium text-black-300 text-center">Crear Reserva Hotel</span>
                </a>
            </div>

            {{-- 13. Anuncios --}}
            <div class="col-span-3 row-span-2 col-start-4 row-start-2">
                <div x-data="announcementBanners" x-init="loadBanners()" x-show="banners.length > 0">
                    <div class="relative overflow-hidden rounded-xl shadow-sm w-full h-full">
                        <div class="relative w-full h-full">
                            <template x-for="(banner, index) in banners" :key="banner.id">
                                <div x-show="currentSlide === index"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform translate-x-full"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 transform translate-x-0"
                                    x-transition:leave-end="opacity-0 transform -translate-x-full"
                                    class="absolute inset-0 w-full h-full">
                                    <a :href="banner.banner_link || banner.show_url" 
                                       class="block w-full h-full"
                                       :target="banner.banner_link ? '_blank' : '_self'">
                                        <img :src="banner.banner_image_url" 
                                             :alt="banner.title"
                                             class="w-full h-full object-cover rounded-xl">
                                    </a>
                                </div>
                            </template>
                        </div>
                        <div x-show="banners.length > 1" class="absolute inset-0 flex items-center justify-between pointer-events-none">
                            <button @click="previousSlide()" 
                                    class="ml-4 w-8 h-8 bg-black bg-opacity-40 hover:bg-opacity-60 rounded-full flex items-center justify-center text-accent-50 transition-all duration-200 pointer-events-auto">
                                <x-solar-arrow-left-outline class="w-4 h-4" />
                            </button>
                            <button @click="nextSlide()" 
                                    class="mr-4 w-8 h-8 bg-black bg-opacity-40 hover:bg-opacity-60 rounded-full flex items-center justify-center text-accent-50 transition-all duration-200 pointer-events-auto">
                                <x-solar-arrow-right-outline class="w-4 h-4" />
                            </button>
                        </div>
                        <div x-show="banners.length > 1" class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex gap-2">
                            <template x-for="(banner, index) in banners" :key="'dot-' + banner.id">
                                <button @click="goToSlide(index)"
                                        class="w-2 h-2 rounded-full transition-all duration-200"
                                        :class="currentSlide === index ? 'bg-accent-50' : 'bg-accent-50 bg-opacity-50'">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 14. Pedidos Delivery (lista completa) --}}
            <div class="col-span-2 row-span-4 row-start-4 bg-accent-50 rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-body-large text-black-500 mb-0 font-medium flex items-center gap-2">
                        <x-lucide-truck class="w-5 h-5 text-primary-300" />
                        Delivery
                    </h3>
                    <a href="{{ route('tenant.admin.orders.index', ['store' => $store->slug, 'type' => 'delivery']) }}" 
                       class="text-body-small text-secondary-300 hover:text-secondary-400">
                        Ver todos
                    </a>
                </div>
                <div class="space-y-2 max-h-[500px] overflow-y-auto" x-data="ordersListWidget({{ json_encode($deliveryOrders) }})">
                    <template x-for="order in orders" :key="order.id">
                        <a :href="`{{ url('/' . $store->slug . '/admin/orders') }}/${order.id}`" 
                           class="block p-3 border border-accent-100 rounded-lg hover:bg-accent-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-lg bg-secondary-100 flex items-center justify-center">
                                        <x-lucide-truck class="w-5 h-5 text-secondary-300" />
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="text-body-small font-bold text-black-300">#<span x-text="order.order_number"></span></p>
                                        <span class="text-small px-2 py-0.5 rounded-full" 
                                              :class="getStatusColorClass(order.status)"
                                              x-text="getStatusLabel(order.status)"></span>
                                    </div>
                                    <p class="text-caption text-black-300 truncate" x-text="order.customer_name"></p>
                                    <p class="text-caption text-black-300" x-text="formatDate(order.created_at)"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-body-small font-bold text-black-300">$<span x-text="formatCurrency(order.total)"></span></p>
                                </div>
                            </div>
                        </a>
                    </template>
                    <div x-show="orders.length === 0" class="text-center py-8">
                        <p class="text-body-small text-black-300">No hay pedidos</p>
                    </div>
                </div>
            </div>

            {{-- 15. Pedidos a la Habitación --}}
            <div class="col-span-2 row-span-4 col-start-3 row-start-4 bg-accent-50 rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-body-large text-black-500 mb-0 font-medium flex items-center gap-2">
                        <x-lucide-bed class="w-5 h-5 text-info-300" />
                        Habitación
                    </h3>
                    <a href="{{ route('tenant.admin.orders.index', ['store' => $store->slug, 'type' => 'room_service']) }}" 
                       class="text-body-small text-secondary-300 hover:text-secondary-400">
                        Ver todos
                    </a>
                </div>
                <div class="space-y-2 max-h-[500px] overflow-y-auto" x-data="ordersListWidget({{ json_encode($roomServiceOrders) }})">
                    <template x-for="order in orders" :key="order.id">
                        <a :href="`{{ url('/' . $store->slug . '/admin/orders') }}/${order.id}`" 
                           class="block p-3 border border-accent-100 rounded-lg hover:bg-accent-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-lg bg-info-100 flex items-center justify-center">
                                        <x-lucide-bed class="w-5 h-5 text-info-300" />
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="text-body-small font-bold text-black-300">#<span x-text="order.order_number"></span></p>
                                        <span class="text-small px-2 py-0.5 rounded-full" 
                                              :class="getStatusColorClass(order.status)"
                                              x-text="getStatusLabel(order.status)"></span>
                                    </div>
                                    <p class="text-caption text-black-300 truncate" x-text="order.customer_name"></p>
                                    <template x-if="order.room_number">
                                        <p class="text-caption text-black-300">Habitación #<span x-text="order.room_number"></span></p>
                                    </template>
                                    <p class="text-caption text-black-300" x-text="formatDate(order.created_at)"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-body-small font-bold text-black-300">$<span x-text="formatCurrency(order.total)"></span></p>
                                </div>
                            </div>
                        </a>
                    </template>
                    <div x-show="orders.length === 0" class="text-center py-8">
                        <p class="text-body-small text-black-300">No hay pedidos</p>
                    </div>
                </div>
            </div>

            {{-- 16. Pedidos Consumo en Local --}}
            <div class="col-span-2 row-span-4 col-start-5 row-start-4 bg-accent-50 rounded-lg p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-body-large text-black-500 mb-0 font-medium flex items-center gap-2">
                        <x-lucide-utensils-crossed class="w-5 h-5 text-primary-300" />
                        Consumo Local
                    </h3>
                    <a href="{{ route('tenant.admin.orders.index', ['store' => $store->slug, 'type' => 'dine_in']) }}" 
                       class="text-body-small text-secondary-300 hover:text-secondary-400">
                        Ver todos
                    </a>
                </div>
                <div class="space-y-2 max-h-[500px] overflow-y-auto" x-data="ordersListWidget({{ json_encode($dineInOrders) }})">
                    <template x-for="order in orders" :key="order.id">
                        <a :href="`{{ url('/' . $store->slug . '/admin/orders') }}/${order.id}`" 
                           class="block p-3 border border-accent-100 rounded-lg hover:bg-accent-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center">
                                        <x-lucide-utensils-crossed class="w-5 h-5 text-primary-300" />
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="text-body-small font-bold text-black-300">#<span x-text="order.order_number"></span></p>
                                        <span class="text-small px-2 py-0.5 rounded-full" 
                                              :class="getStatusColorClass(order.status)"
                                              x-text="getStatusLabel(order.status)"></span>
                                    </div>
                                    <p class="text-caption text-black-300 truncate" x-text="order.customer_name"></p>
                                    <template x-if="order.table_number">
                                        <p class="text-caption text-black-300">Mesa #<span x-text="order.table_number"></span></p>
                                    </template>
                                    <p class="text-caption text-black-300" x-text="formatDate(order.created_at)"></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-body-small font-bold text-black-300">$<span x-text="formatCurrency(order.total)"></span></p>
                                </div>
                            </div>
                        </a>
                    </template>
                    <div x-show="orders.length === 0" class="text-center py-8">
                        <p class="text-body-small text-black-300">No hay pedidos</p>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
    <script>
    document.addEventListener('alpine:init', () => {
        const getStatusLabel = (status) => {
            const statuses = @json(\App\Shared\Models\Order::STATUSES);
            return statuses[status] || status;
        };

        const getStatusColorClass = (status) => {
            const colorMap = {
                'pending': 'bg-warning-100 text-warning-400',
                'confirmed': 'bg-info-100 text-info-400',
                'preparing': 'bg-secondary-100 text-secondary-400',
                'shipped': 'bg-primary-100 text-primary-400',
                'delivered': 'bg-success-100 text-success-400',
                'cancelled': 'bg-error-100 text-error-400'
            };
            return colorMap[status] || 'bg-accent-200 text-black-300';
        };

        Alpine.data('ordersListWidget', (orders) => ({
            orders: orders,
            
            getStatusLabel,
            getStatusColorClass,
            
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
    
    document.addEventListener('alpine:init', () => {
        Alpine.data('announcementBanners', () => ({
            banners: [],
            currentSlide: 0,
            autoplayInterval: null,
            autoplayDelay: 4000,
            
            async loadBanners() {
                try {
                    const response = await fetch('{{ route("tenant.admin.announcements.api.banners", $store->slug) }}');
                    const data = await response.json();
                    this.banners = data;
                    
                    if (this.banners.length > 0) {
                        this.startAutoplay();
                    }
                } catch (error) {
                    // Error silencioso
                }
            },
            
            nextSlide() {
                this.currentSlide = (this.currentSlide + 1) % this.banners.length;
                this.resetAutoplay();
            },
            
            previousSlide() {
                this.currentSlide = this.currentSlide === 0 ? this.banners.length - 1 : this.currentSlide - 1;
                this.resetAutoplay();
            },
            
            goToSlide(index) {
                this.currentSlide = index;
                this.resetAutoplay();
            },
            
            startAutoplay() {
                if (this.banners.length <= 1) return;
                
                this.autoplayInterval = setInterval(() => {
                    this.nextSlide();
                }, this.autoplayDelay);
            },
            
            stopAutoplay() {
                if (this.autoplayInterval) {
                    clearInterval(this.autoplayInterval);
                    this.autoplayInterval = null;
                }
            },
            
            resetAutoplay() {
                this.stopAutoplay();
                this.startAutoplay();
            }
        }));
    });
    </script>
    @endpush
</x-tenant-admin-layout>
