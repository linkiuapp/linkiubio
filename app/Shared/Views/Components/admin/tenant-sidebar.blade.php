@php
    use Illuminate\Support\Facades\Storage;
@endphp



<!-- Sidebar Admin de Tienda -->
<aside class="fixed left-0 top-0 z-40 h-screen sidebar bg-accent-75 shadow-2xl transition-transform duration-300 ease-in-out flex flex-col" 
       x-data="{ sidebarOpen: true }"
       :class="{ '-translate-x-full': !sidebarOpen }">
       

    <!-- User section -->
    <div class="px-6 pt-6 pb-2 flex-shrink-0">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                @php
                    // Obtener la imagen de perfil del store design (logo de la tienda)
                    $profileImage = $store->design?->logo_url ?? $store->logo_url;
                @endphp
                
                @if($profileImage)
                    <img src="{{ $profileImage }}" 
                        alt="Perfil" 
                        class="w-18 h-18 rounded-full object-cover border-2 border-accent-200"
                        style="width: 56px; height: 56px;">
                @else
                    <div class="w-18 h-18 bg-primary-300 rounded-full flex items-center justify-center" style="width: 56px; height: 56px;">
                        <span class="text-accent-50 text-xl font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="ml-3 flex-1 min-w-0">
                <p class="text-body-small font-bold text-black-300 truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-caption text-regular text-black-300 truncate">
                    Admin de Tienda
                </p>
            </div>
            <div class="flex-shrink-0 items-center justify-center">
                <form method="POST" action="{{ route('tenant.admin.logout', $store->slug) }}">
                    @csrf
                    <button type="submit" 
                            class="text-error-300 hover:text-error-400 transition-colors duration-200"
                            title="Cerrar sesión">
                            <x-lucide-log-out class="w-5 h-5" />
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!--End User section -->
    
    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-6 py-4" x-data="sidebarSections()">
        <ul class="space-y-1">
            @php
                use App\Shared\Models\StoreOnboardingStep;
                
                // Calcular progreso del onboarding usando memoria
                $onboardingSteps = [
                    'design' => StoreOnboardingStep::isCompleted($store->id, 'design'),
                    'slider' => StoreOnboardingStep::isCompleted($store->id, 'slider'),
                    'locations' => StoreOnboardingStep::isCompleted($store->id, 'locations'),
                    'payments' => StoreOnboardingStep::isCompleted($store->id, 'payments'),
                    'shipping' => StoreOnboardingStep::isCompleted($store->id, 'shipping'),
                    'categories' => StoreOnboardingStep::isCompleted($store->id, 'categories'),
                    'variables' => StoreOnboardingStep::isCompleted($store->id, 'variables'),
                    'products' => StoreOnboardingStep::isCompleted($store->id, 'products'),
                    'coupons' => StoreOnboardingStep::isCompleted($store->id, 'coupons'),
                ];
                
                $completedSteps = count(array_filter($onboardingSteps));
                $totalSteps = count($onboardingSteps);
                $allCompleted = $completedSteps === $totalSteps;
            @endphp
            
            <!-- Primeros pasos (solo mostrar si no está todo completo) -->
            @if(!$allCompleted)
            <li class="mb-4 bg-accent-200 rounded-lg p-3 border border-dashed border-info-200">
                <!-- Título fijo sin colapsable -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <x-lucide-rocket class="w-5 h-5 text-info-300" />
                        <span class="text-body-regular font-bold text-info-300">Primeros pasos</span>
                    </div>
                    <span class="text-body-small bg-info-300 text-accent-300 px-3 py-1 rounded-full font-bold">
                        {{ $completedSteps }}/{{ $totalSteps }}
                    </span>
                </div>
                
                <!-- Lista siempre visible -->
                <ul class="space-y-1">
                    <!-- Diseño de la tienda -->
                    <li>
                        <a href="{{ route('tenant.admin.store-design.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.store-design.*') ? 'item-sidebar-active' : '' }} {{ $onboardingSteps['design'] ? 'opacity-95' : '' }}">
                            @if($onboardingSteps['design'])
                                <x-lucide-check-circle class="w-4 h-4 mr-2 text-success-500" />
                            @else
                                <x-solar-pallete-2-outline class="w-4 h-4 mr-2" />
                            @endif
                            <span class="{{ $onboardingSteps['design'] ? 'line-through' : '' }}">Personalizar tu tienda</span>
                        </a>
                    </li>
                    
                    <!-- Slider -->
                    <li>
                        <a href="{{ route('tenant.admin.sliders.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.sliders.*') ? 'item-sidebar-active' : '' }} {{ $onboardingSteps['slider'] ? 'opacity-95' : '' }}">
                            @if($onboardingSteps['slider'])
                                <x-lucide-check-circle class="w-4 h-4 mr-2 text-success-500" />
                            @else
                                <x-lucide-images class="w-4 h-4 mr-2" />
                            @endif
                            <span class="{{ $onboardingSteps['slider'] ? 'line-through' : '' }}">Slider</span>
                        </a>
                    </li>
                    
                    <!-- Sedes -->
                    <li>
                        <a href="{{ route('tenant.admin.locations.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.locations.*') ? 'item-sidebar-active' : '' }} {{ $onboardingSteps['locations'] ? 'opacity-95' : '' }}">
                            @if($onboardingSteps['locations'])
                                <x-lucide-check-circle class="w-4 h-4 mr-2 text-success-500" />
                            @else
                                <x-lucide-store class="w-4 h-4 mr-2" />
                            @endif
                            <span class="{{ $onboardingSteps['locations'] ? 'line-through' : '' }}">Sedes</span>
                        </a>
                    </li>
                    
                    <!-- Métodos de pago -->
                    <li>
                        <a href="{{ route('tenant.admin.payment-methods.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.payment-methods.*') ? 'item-sidebar-active' : '' }} {{ $onboardingSteps['payments'] ? 'opacity-95' : '' }}">
                            @if($onboardingSteps['payments'])
                                <x-lucide-check-circle class="w-4 h-4 mr-2 text-success-500" />
                            @else
                                <x-lucide-dock class="w-4 h-4 mr-2" />
                            @endif
                            <span class="{{ $onboardingSteps['payments'] ? 'line-through' : '' }}">Métodos de Pago</span>
                        </a>
                    </li>
                    
                    {{-- Gestión de envíos - Solo si el feature está habilitado --}}
                    @if(featureEnabled($store, 'shipping'))
                    <li>
                        <a href="{{ route('tenant.admin.simple-shipping.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.simple-shipping.*') ? 'item-sidebar-active' : '' }} {{ $onboardingSteps['shipping'] ? 'opacity-95' : '' }}">
                            @if($onboardingSteps['shipping'])
                                <x-lucide-check-circle class="w-4 h-4 mr-2 text-success-500" />
                            @else
                                <x-lucide-truck class="w-4 h-4 mr-2" />
                            @endif
                            <span class="{{ $onboardingSteps['shipping'] ? 'line-through' : '' }}">Gestión de Envíos</span>
                        </a>
                    </li>
                    @endif
                    
                    <!-- Categorías -->
                    <li>
                        <a href="{{ route('tenant.admin.categories.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.categories.*') ? 'item-sidebar-active' : '' }} {{ $onboardingSteps['categories'] ? 'opacity-95' : '' }}">
                            @if($onboardingSteps['categories'])
                                <x-lucide-check-circle class="w-4 h-4 mr-2 text-success-500" />
                            @else
                                <x-lucide-layout-list class="w-4 h-4 mr-2" />
                            @endif
                            <span class="{{ $onboardingSteps['categories'] ? 'line-through' : '' }}">Categorías</span>
                        </a>
                    </li>
                    
                    <!-- Variables -->
                    <li>
                        <a href="{{ route('tenant.admin.variables.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.variables.*') ? 'item-sidebar-active' : '' }} {{ $onboardingSteps['variables'] ? 'opacity-95' : '' }}">
                            @if($onboardingSteps['variables'])
                                <x-lucide-check-circle class="w-4 h-4 mr-2 text-success-500" />
                            @else
                                <x-lucide-tag class="w-4 h-4 mr-2" />
                            @endif
                            <span class="{{ $onboardingSteps['variables'] ? 'line-through' : '' }}">Variables</span>
                        </a>
                    </li>
                    
                    <!-- Productos -->
                    <li>
                        <a href="{{ route('tenant.admin.products.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.products.*') ? 'item-sidebar-active' : '' }} {{ $onboardingSteps['products'] ? 'opacity-95' : '' }}">
                            @if($onboardingSteps['products'])
                                <x-lucide-check-circle class="w-4 h-4 mr-2 text-success-500" />
                            @else
                                <x-lucide-package class="w-4 h-4 mr-2" />
                            @endif
                            <span class="{{ $onboardingSteps['products'] ? 'line-through' : '' }}">Productos</span>
                        </a>
                    </li>
                    
                    <!-- Cupones -->
                    <li>
                        <a href="{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.coupons.*') ? 'item-sidebar-active' : '' }} {{ $onboardingSteps['coupons'] ? 'opacity-95' : '' }}">
                            @if($onboardingSteps['coupons'])
                                <x-lucide-check-circle class="w-4 h-4 mr-2 text-success-500" />
                            @else
                                <x-lucide-ticket-percent class="w-4 h-4 mr-2" />
                            @endif
                            <span class="{{ $onboardingSteps['coupons'] ? 'line-through' : '' }}">Cupones</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- Separador visual -->
            <li class="my-4 border-t border-disabled-200"></li>
            @endif
            
            <!-- Favoritos-->
             
                <p class="title-group-sidebar w-full flex justify-between items-center px-2 py-1 rounded transition-colors">Favoritos</p>

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('tenant.admin.dashboard', ['store' => $store->slug]) }}" 
                    class="item-sidebar {{ request()->routeIs('tenant.admin.dashboard') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-layout-dashboard class="w-4 h-4 mr-2" />
                        Dashboard
                    </a>
                </li>

                <!-- Pedidos (Prioritario) -->
                <li>
                    <a href="{{ route('tenant.admin.orders.index', ['store' => $store->slug]) }}" 
                        class="item-sidebar {{ request()->routeIs('tenant.admin.orders.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-party-popper class="w-4 h-4 mr-2" />
                        Pedidos
                        @if(($store->pending_orders_count ?? 0) > 0)
                            <span class="ml-auto text-caption bg-error-300 text-accent-300 px-2 py-1 rounded-full font-medium">
                                {{ $store->pending_orders_count }}
                            </span>
                        @else
                            <span class="ml-auto text-small bg-black-50 text-black-500 px-2 py-1 rounded-full font-medium">
                                0
                            </span>
                        @endif
                    </a>
                </li>


            <!-- Tienda y productos-->
                <p class="title-group-sidebar w-full flex justify-between items-center px-2 py-1 rounded transition-colors">Tienda y productos</p>
                
                <!-- Categorías -->
                <li>
                    <a href="{{ route('tenant.admin.categories.index', ['store' => $store->slug]) }}" 
                        class="item-sidebar {{ request()->routeIs('tenant.admin.categories.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-layout-list class="w-4 h-4 mr-2" />
                        Categorías
                        @php
                            $categoriesUsed = $store->categories_count ?? 0;
                            $categoriesLimit = $store->plan->max_categories;
                            $categoriesPercent = $categoriesLimit > 0 ? ($categoriesUsed / $categoriesLimit) * 100 : 0;
                            $categoriesBadgeColor = $categoriesPercent >= 90 ? 'bg-error-300 text-accent-300' : ($categoriesPercent >= 70 ? 'bg-warning-300 text-black-500' : 'bg-black-50 text-black-500');
                        @endphp
                        <span class="ml-auto text-small {{ $categoriesBadgeColor }} px-2 py-1 rounded-full font-medium tracking-widest">
                            {{ $categoriesUsed }}/{{ $categoriesLimit }}
                        </span>
                    </a>
                </li>

                <!-- Variables -->
                <li>
                    <a href="{{ route('tenant.admin.variables.index', ['store' => $store->slug]) }}" 
                        class="item-sidebar {{ request()->routeIs('tenant.admin.variables.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-tag class="w-4 h-4 mr-2" />
                        Variables
                        @php
                            $variablesUsed = $store->variables_count ?? 0;
                            $variablesLimit = $store->plan->max_variables ?? 50;
                            $variablesPercent = $variablesLimit > 0 ? ($variablesUsed / $variablesLimit) * 100 : 0;
                            $variablesBadgeColor = $variablesPercent >= 90 ? 'bg-error-300 text-accent-300' : ($variablesPercent >= 70 ? 'bg-warning-300 text-black-500' : 'bg-black-50 text-black-500');
                        @endphp
                        <span class="ml-auto text-small {{ $variablesBadgeColor }} px-2 py-1 rounded-full font-medium tracking-widest">
                            {{ $variablesUsed }}/{{ $variablesLimit }}
                        </span>
                    </a>
                </li>

                <!-- Productos -->
                <li>
                    <a href="{{ route('tenant.admin.products.index', ['store' => $store->slug]) }}" 
                        class="item-sidebar {{ request()->routeIs('tenant.admin.products.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-package class="w-4 h-4 mr-2" />
                        Productos
                        @php
                            $productsUsed = $store->products_count ?? 0;
                            $productsLimit = $store->plan->max_products;
                            $productsPercent = $productsLimit > 0 ? ($productsUsed / $productsLimit) * 100 : 0;
                            $productsBadgeColor = $productsPercent >= 90 ? 'bg-error-300 text-accent-300' : ($productsPercent >= 70 ? 'bg-warning-300 text-black-500' : 'bg-black-50 text-black-500');
                        @endphp
                        <span class="ml-auto text-small {{ $productsBadgeColor }} px-2 py-1 rounded-full font-medium tracking-widest">
                            {{ $productsUsed }}/{{ $productsLimit }}
                        </span>
                    </a>
                </li>

                {{-- Configuración de Envíos - Solo si el feature está habilitado --}}
                @if(featureEnabled($store, 'shipping'))
                <li>
                    <a href="{{ route('tenant.admin.simple-shipping.index', ['store' => $store->slug]) }}" 
                        class="item-sidebar {{ request()->routeIs('tenant.admin.simple-shipping.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-truck class="w-4 h-4 mr-2" />
                        Gestión de Envíos
                        @php
                            // Obtener zonas de envío actuales del nuevo sistema
                            $simpleShipping = \App\Features\TenantAdmin\Models\SimpleShipping::where('store_id', $store->id)->first();
                            $currentZones = $simpleShipping ? $simpleShipping->zones()->count() : 0;
                            
                            // Límites según el plan desde SuperAdmin
                            $zoneLimits = [
                                'explorer' => 2,
                                'master' => 3, 
                                'legend' => 4
                            ];
                            $planSlug = strtolower($store->plan->slug ?? 'explorer');
                            $maxZones = $zoneLimits[$planSlug] ?? 2;
                            
                            $zonesPercent = $maxZones > 0 ? ($currentZones / $maxZones) * 100 : 0;
                            $zonesBadgeColor = $zonesPercent >= 90 ? 'bg-error-300 text-accent-300' : ($zonesPercent >= 70 ? 'bg-warning-300 text-black-500' : 'bg-black-50 text-black-500');
                        @endphp
                        <span class="ml-auto text-small {{ $zonesBadgeColor }} px-2 py-1 rounded-full font-medium tracking-widest">
                            {{ $currentZones }}/{{ $maxZones }}
                        </span>
                    </a>
                </li>
                @endif

                <!-- Métodos de Pago -->
                <li>
                    <a href="{{ route('tenant.admin.payment-methods.index', ['store' => $store->slug]) }}" 
                        class="item-sidebar {{ request()->routeIs('tenant.admin.payment-methods.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-dock class="w-4 h-4 mr-2" />
                        Métodos de Pago
                    </a>
                </li>

                <!-- Sedes -->
                <li>
                    <a href="{{ route('tenant.admin.locations.index', ['store' => $store->slug]) }}" 
                        class="item-sidebar {{ request()->routeIs('tenant.admin.locations.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-store class="w-4 h-4 mr-2" />
                        Sedes
                        @php
                            $locationsUsed = $store->locations_count ?? 0;
                            $locationsLimit = $store->plan->max_locations ?? $store->plan->max_sedes ?? 1;
                            $locationsPercent = $locationsLimit > 0 ? ($locationsUsed / $locationsLimit) * 100 : 0;
                            $locationsBadgeColor = $locationsPercent >= 90 ? 'bg-error-300 text-accent-300' : ($locationsPercent >= 70 ? 'bg-warning-300 text-black-500' : 'bg-black-50 text-black-500');
                        @endphp
                        <span class="ml-auto text-small {{ $locationsBadgeColor }} px-2 py-1 rounded-full font-medium tracking-widest">
                            {{ $locationsUsed }}/{{ $locationsLimit }}
                        </span>
                    </a>
                </li>

            <!-- Reservas y Servicios (según categoría) -->
            @if(featureEnabled($store, 'reservas_mesas') || featureEnabled($store, 'consumo_local') || featureEnabled($store, 'reservas_hotel') || featureEnabled($store, 'consumo_hotel') || featureEnabled($store, 'notificaciones_whatsapp'))
                <p class="title-group-sidebar w-full flex justify-between items-center px-2 py-1 rounded transition-colors">Reservas y Servicios</p>

                {{-- Notificaciones WhatsApp --}}
                @if(featureEnabled($store, 'notificaciones_whatsapp'))
                <li>
                    <a href="{{ route('tenant.admin.whatsapp-notifications.index', ['store' => $store->slug]) }}" 
                       class="item-sidebar {{ request()->routeIs('tenant.admin.whatsapp-notifications.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-message-circle class="w-4 h-4 mr-2" />
                        Notificaciones WhatsApp
                    </a>
                </li>
                @endif

                {{-- Reservas de Mesas (Restaurantes) --}}
                @if(featureEnabled($store, 'reservas_mesas'))
                <li>
                    <a href="{{ route('tenant.admin.reservations.index', ['store' => $store->slug]) }}" 
                       class="item-sidebar {{ request()->routeIs('tenant.admin.reservations.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-utensils class="w-4 h-4 mr-2" />
                        Reservas de Mesas
                    </a>
                </li>
                @endif

                {{-- Consumo en Local (Restaurantes) --}}
                @if(featureEnabled($store, 'consumo_local'))
                <li>
                    <a href="{{ route('tenant.admin.dine-in.tables.index', ['store' => $store->slug, 'type' => 'mesa']) }}" 
                       class="item-sidebar {{ request()->routeIs('tenant.admin.dine-in.*') && request()->get('type') === 'mesa' ? 'item-sidebar-active' : '' }}">
                        <x-lucide-scan-barcode class="w-4 h-4 mr-2" />
                        Consumo en Local
                    </a>
                </li>
                @endif

                {{-- Reservas de Hotel (Hoteles) --}}
                @if(featureEnabled($store, 'reservas_hotel'))
                <li>
                    <a href="{{ route('tenant.admin.hotel.reservations.index', ['store' => $store->slug]) }}" 
                       class="item-sidebar {{ request()->routeIs('tenant.admin.hotel.reservations.*') ? 'item-sidebar-active' : '' }}">
                        <x-lucide-bed class="w-4 h-4 mr-2" />
                        Reservas de Hotel
                    </a>
                </li>
                @endif

                {{-- Servicio a Habitación (Hoteles) - Requiere consumo_hotel Y reservas_hotel --}}
                @if(featureEnabled($store, 'consumo_hotel') && featureEnabled($store, 'reservas_hotel'))
                <li>
                    <a href="{{ route('tenant.admin.dine-in.tables.index', ['store' => $store->slug, 'type' => 'habitacion']) }}" 
                       class="item-sidebar {{ request()->routeIs('tenant.admin.dine-in.*') && request()->get('type') === 'habitacion' ? 'item-sidebar-active' : '' }}">
                        <x-lucide-concierge-bell class="w-4 h-4 mr-2" />
                        Servicio a Habitación
                    </a>
                </li>
                @endif
            @endif

            <!-- Marketing-->
                <p class="title-group-sidebar w-full flex justify-between items-center px-2 py-1 rounded transition-colors">Marketing</p>
                
                    <!-- Cupones -->
                    <li>
                        <a href="{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.coupons.*') ? 'item-sidebar-active' : '' }}">
                            <x-lucide-ticket-percent class="w-4 h-4 mr-2" />
                            Cupones
                            @php
                                $couponsUsed = $store->active_coupons_count ?? 0;
                                $couponsLimit = $store->plan->max_active_coupons;
                                $couponsPercent = $couponsLimit > 0 ? ($couponsUsed / $couponsLimit) * 100 : 0;
                                $couponsBadgeColor = $couponsPercent >= 90 ? 'bg-error-300 text-accent-300' : ($couponsPercent >= 70 ? 'bg-warning-300 text-black-500' : 'bg-black-50 text-black-500');
                            @endphp
                            <span class="ml-auto text-small {{ $couponsBadgeColor }} px-2 py-1 rounded-full font-medium tracking-widest">
                                {{ $couponsUsed }}/{{ $couponsLimit }}
                            </span>
                        </a>
                    </li>

                    <!-- Slider -->
                    <li>
                        <a href="{{ route('tenant.admin.sliders.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.sliders.*') ? 'item-sidebar-active' : '' }}">
                            <x-lucide-images class="w-4 h-4 mr-2" />
                            Slider
                            @php
                                $slidersUsed = $store->sliders_count ?? 0;
                                $slidersLimit = $store->plan->max_sliders ?? $store->plan->max_slider ?? 1;
                                $slidersPercent = $slidersLimit > 0 ? ($slidersUsed / $slidersLimit) * 100 : 0;
                                $slidersBadgeColor = $slidersPercent >= 90 ? 'bg-error-300 text-accent-300' : ($slidersPercent >= 70 ? 'bg-warning-300 text-black-500' : 'bg-black-50 text-black-500');
                            @endphp
                            <span class="ml-auto text-small {{ $slidersBadgeColor }} px-2 py-1 rounded-full font-medium tracking-widest">
                                {{ $slidersUsed }}/{{ $slidersLimit }}
                            </span>
                        </a>
                    </li>

                    <!-- Integrcion ADS -->
                    <!-- <li>
                        <a href="#" 
                           class="item-sidebar">
                            <x-lucide-unplug class="w-4 h-4 mr-2" />
                            Integración ADS
                        </a>
                    </li> -->

            <!-- Perfil y facturación-->
                <p class="title-group-sidebar w-full flex justify-between items-center px-2 py-1 rounded transition-colors">Perfil y facturación</p>
                    <!-- Mi Cuenta -->
                    <li>
                        <a href="{{ route('tenant.admin.profile.index', ['store' => $store->slug]) }}"
                           class="item-sidebar {{ request()->routeIs('tenant.admin.profile.*') ? 'item-sidebar-active' : '' }}">
                            <x-solar-user-circle-outline class="w-4 h-4 mr-2" />
                            Mi Cuenta
                        </a>
                    </li>

                    <!-- Clave Maestra -->
                    <li>
                        <a href="{{ route('tenant.admin.master-key.index', ['store' => $store->slug]) }}"
                           class="item-sidebar {{ request()->routeIs('tenant.admin.master-key.*') ? 'item-sidebar-active' : '' }}">
                            <x-solar-lock-keyhole-outline class="w-4 h-4 mr-2" />
                            Clave Maestra
                        </a>
                    </li>

                    <!-- Perfil del Negocio -->
                    <li>
                        <a href="{{ route('tenant.admin.business-profile.index', ['store' => $store->slug]) }}"
                           class="item-sidebar {{ request()->routeIs('tenant.admin.business-profile.*') ? 'item-sidebar-active' : '' }}">
                            <x-solar-shop-outline class="w-4 h-4 mr-2" />
                            Perfil del Negocio
                        </a>
                    </li>

                    <!-- Diseño de la Tienda -->
                    <li>
                        <a href="{{ route('tenant.admin.store-design.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.store-design.*') ? 'item-sidebar-active' : '' }}">
                            <x-solar-pallete-2-outline class="w-4 h-4 mr-2" />
                            Diseño de la Tienda
                        </a>
                    </li>

                    <!-- Plan y Facturación -->
                    <li>
                        <a href="{{ route('tenant.admin.billing.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.billing.*') ? 'item-sidebar-active' : '' }}">
                            <x-solar-card-outline class="w-4 h-4 mr-2" />
                            Plan y Facturación
                        </a>
                    </li>

            <!-- Anuncios y soporte-->
                <p class="title-group-sidebar w-full flex justify-between items-center px-2 py-1 rounded transition-colors">Anuncios y soporte</p>
                    <!-- Soporte y Tickets -->
                    <li>
                        <a href="{{ route('tenant.admin.tickets.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.tickets.*') ? 'item-sidebar-active' : '' }}">
                            <x-lucide-server-crash class="w-4 h-4 mr-2" />
                            Soporte y Tickets
                            @php
                                $openTicketsCount = $store->tickets()->whereIn('status', ['open', 'in_progress'])->count();
                            @endphp
                            @if($openTicketsCount > 0)
                                <span class="ml-auto text-xs bg-error-300 text-accent-50 px-2 py-1 rounded-full font-medium">
                                    {{ $openTicketsCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- Anuncios de Linkiu -->
                    <li>
                        <a href="{{ route('tenant.admin.announcements.index', ['store' => $store->slug]) }}" 
                           class="item-sidebar {{ request()->routeIs('tenant.admin.announcements.*') ? 'item-sidebar-active' : '' }}">
                            <x-lucide-megaphone class="w-4 h-4 mr-2" />
                            Anuncios de Linkiu
                            @if(($store->unread_announcements_count ?? 0) > 0)
                                <span class="ml-auto text-xs bg-warning-300 text-black-500 px-2 py-1 rounded-full font-medium">
                                    {{ $store->unread_announcements_count }}
                                </span>
                            @endif
                        </a>
                    </li>
        </ul>
    </nav>
</aside>

<!-- Mobile sidebar overlay -->
<div x-show="!sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-30 bg-gray-600 bg-opacity-75 lg:hidden"
     @click="sidebarOpen = true">
</div>

<script>
function sidebarSections() {
    return {
        sections: {
            favoritos: true,  // Favoritos siempre abierto
            tienda: false,
            marketing: false,
            perfil: false,
            soporte: false
        },
        
        init() {
            // Cargar estado del localStorage
            const saved = localStorage.getItem('sidebarSections');
            if (saved) {
                this.sections = { ...this.sections, ...JSON.parse(saved) };
            }
            
            // Auto-expandir sección activa
            this.expandActiveSection();
        },
        
        toggleSection(section) {
            this.sections[section] = !this.sections[section];
            this.saveState();
        },
        
        saveState() {
            localStorage.setItem('sidebarSections', JSON.stringify(this.sections));
        },
        
        expandActiveSection() {
            const currentRoute = window.location.pathname;
            
            // Mapear rutas a secciones
            if (currentRoute.includes('/categories') || currentRoute.includes('/variables') || 
                currentRoute.includes('/products') || currentRoute.includes('/simple-shipping')) {
                this.sections.tienda = true;
            } else if (currentRoute.includes('/coupons') || currentRoute.includes('/sliders')) {
                this.sections.marketing = true;
            } else if (currentRoute.includes('/business-profile') || currentRoute.includes('/store-design') || 
                      currentRoute.includes('/billing')) {
                this.sections.perfil = true;
            } else if (currentRoute.includes('/tickets') || currentRoute.includes('/announcements')) {
                this.sections.soporte = true;
            }
            
            this.saveState();
        }
    }
}
</script>