<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->name ?? 'Linkiu Store' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="store-slug" content="{{ $store->slug }}">
    <meta name="asset-url" content="{{ asset('') }}">

    @if($store->design && $store->design->favicon_url)
        <link rel="icon" type="image/x-icon" href="{{ $store->design->favicon_url }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Lordicon -->
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    
    {{-- SECTION: Additional Styles --}}
    @stack('styles')
    {{-- End SECTION: Additional Styles --}}
    
    <style>
        body {
            position: relative;
            background: #ffffff;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 480px;
            height: 100vh;
            background: linear-gradient(to bottom, @php
                $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
                // Convertir hex a rgba con opacidad 50%
                if (strpos($bgColor, '#') === 0) {
                    $hex = str_replace('#', '', $bgColor);
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    echo "rgba($r, $g, $b, 0.2)";
                } else {
                    echo $bgColor;
                }
            @endphp, #ffffff);
            filter: blur(180px);
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body class="md:max-w-[480px] max-w-full mx-auto overflow-x-hidden">
    {{-- Maintenance Notice --}}
    <x-maintenance-notice variant="tenant" />

    <!-- Header -->
    <header class="z-[9999] overflow-hidden max-w-[348px] md:max-w-[450px] mx-auto rounded-t-3xl mt-[40px]" style="background: {{ $store->design ? $store->design->header_background_color : '' }}">
        <div class="px-2 py-8 flex items-center justify-center gap-2 md:gap-6">
            <!-- Logo -->
            <div class="flex-shrink-0">
                @if($store->design && $store->design->logo_url)
                    <div class="relative inline-block border-4 border-white rounded-full">
                        <img src="{{ $store->design->logo_url }}" 
                             alt="Logo" 
                             class="w-[80px] h-[80px] rounded-full object-cover border-6 border-brandWhite-300">
                    </div>
                @endif
            </div>

            <!-- Contenido: Nombre, Badge y Descripción -->
            <div class="flex flex-col min-w-0">
                <!-- Nombre de la tienda y badge de verificación -->
                <div class="flex items-center gap-1">
                    <h1 class="text-[24px] font-extrabold capitalize truncate" style="color: {{ $store->design ? $store->design->header_text_color : '#ffffff' }}">
                        {{ $store->name ?? 'Nombre de la tienda' }}
                    </h1>
                    @if($store->verified)
                        <a href="{{ route('tenant.verified', $store->slug) }}" 
                           class="flex-shrink-0" 
                           title="Tienda verificada">
                            <svg class="w-[24px] h-[24px] text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('tenant.verified', $store->slug) }}" 
                           class="flex-shrink-0" 
                           title="Tienda no verificada">
                           <svg class="w-[24px] h-[24px] text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                            </svg>

                        </a>
                    @endif
                </div>

                <!-- Descripción -->
                <p class="text-[14px] truncate" style="color: {{ $store->design ? $store->design->header_description_color : '#e9d5ff' }}">
                    {{ $store->description ?? 'Descripción de la tienda' }}
                </p>
            </div>
        </div>
    </header>

    <!-- Menu inferior -->
    <nav class="max-w-[348px] md:max-w-[450px] w-full mx-auto bg-white rounded-b-3xl px-4 py-4 flex items-center justify-around">
        <!-- Contacto (Sedes) -->
        <a href="{{ route('tenant.contact', $store->slug) }}" 
           class="flex items-center justify-center p-2 {{ request()->routeIs('tenant.contact') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900' }} transition-colors">
            @if(request()->routeIs('tenant.contact'))
                <i data-lucide="store" class="w-6 h-6 mr-2"></i>
                <span class="text-sm font-medium">Sedes</span>
            @else
                <i data-lucide="store" class="w-6 h-6"></i>
            @endif
        </a>

        <!-- Catálogo / Menú -->
        <a href="{{ route('tenant.catalog', $store->slug) }}" 
           class="flex items-center justify-center p-2 {{ request()->routeIs('tenant.catalog') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900' }} transition-colors">
            @if(request()->routeIs('tenant.catalog'))
                @if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant')
                    <i data-lucide="utensils-crossed" class="w-6 h-6 mr-2"></i>
                    <span class="text-sm font-medium">Menú</span>
                @else
                    <i data-lucide="shopping-bag" class="w-6 h-6 mr-2"></i>
                    <span class="text-sm font-medium">Catálogo</span>
                @endif
            @else
                @if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant')
                    <i data-lucide="utensils-crossed" class="w-6 h-6"></i>
                @else
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                @endif
            @endif
        </a>

        <!-- Inicio -->
        <a href="{{ route('tenant.home', $store->slug) }}" 
           class="flex items-center justify-center p-2 {{ request()->routeIs('tenant.home') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900' }} transition-colors">
            @if(request()->routeIs('tenant.home'))
                <i data-lucide="layout-grid" class="w-6 h-6 mr-2"></i>
                <span class="text-sm font-medium">Inicio</span>
            @else
                <i data-lucide="layout-grid" class="w-6 h-6"></i>
            @endif
        </a>

        <!-- Promos -->
        <a href="{{ route('tenant.promotions', $store->slug) }}" 
           class="flex items-center justify-center p-2 {{ request()->routeIs('tenant.promotions') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900' }} transition-colors">
            @if(request()->routeIs('tenant.promotions'))
                <i data-lucide="party-popper" class="w-6 h-6 mr-2"></i>
                <span class="text-sm font-medium">Promos</span>
            @else
                <i data-lucide="party-popper" class="w-6 h-6"></i>
            @endif
        </a>

        <!-- Reservas o Favoritos (cambia según categoría de negocio) -->
        @if(featureEnabled($store, 'reservas_mesas') && featureEnabled($store, 'reservas_hotel'))
            <a href="{{ route('tenant.reservations.select-type', $store->slug) }}" 
               class="flex items-center justify-center p-2 {{ request()->routeIs('tenant.reservations.*') || request()->routeIs('tenant.hotel-reservations.*') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900' }} transition-colors">
                @if(request()->routeIs('tenant.reservations.*') || request()->routeIs('tenant.hotel-reservations.*'))
                    @if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant')
                        <i data-lucide="concierge-bell" class="w-6 h-6 mr-2"></i>
                    @else
                        <i data-lucide="calendar-heart" class="w-6 h-6 mr-2"></i>
                    @endif
                    <span class="text-sm font-medium">Reservas</span>
                @else
                    @if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant')
                        <i data-lucide="concierge-bell" class="w-6 h-6"></i>
                    @else
                        <i data-lucide="calendar-heart" class="w-6 h-6"></i>
                    @endif
                @endif
            </a>
        @elseif(featureEnabled($store, 'reservas_mesas'))
            <a href="{{ route('tenant.reservations.index', $store->slug) }}" 
               class="flex items-center justify-center p-2 {{ request()->routeIs('tenant.reservations.*') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900' }} transition-colors">
                @if(request()->routeIs('tenant.reservations.*'))
                    @if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant')
                        <i data-lucide="concierge-bell" class="w-6 h-6 mr-2"></i>
                    @else
                        <i data-lucide="calendar-heart" class="w-6 h-6 mr-2"></i>
                    @endif
                    <span class="text-sm font-medium">Reservas</span>
                @else
                    @if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant')
                        <i data-lucide="concierge-bell" class="w-6 h-6"></i>
                    @else
                        <i data-lucide="calendar-heart" class="w-6 h-6"></i>
                    @endif
                @endif
            </a>
        @elseif(featureEnabled($store, 'reservas_hotel'))
            <a href="{{ route('tenant.hotel-reservations.index', $store->slug) }}" 
               class="flex items-center justify-center p-2 {{ request()->routeIs('tenant.hotel-reservations.*') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900' }} transition-colors">
                @if(request()->routeIs('tenant.hotel-reservations.*'))
                    @if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant')
                        <i data-lucide="concierge-bell" class="w-6 h-6 mr-2"></i>
                    @else
                        <i data-lucide="calendar-heart" class="w-6 h-6 mr-2"></i>
                    @endif
                    <span class="text-sm font-medium">Reservas</span>
                @else
                    @if(($store->businessCategory?->vertical ?? 'ecommerce') === 'restaurant')
                        <i data-lucide="concierge-bell" class="w-6 h-6"></i>
                    @else
                        <i data-lucide="calendar-heart" class="w-6 h-6"></i>
                    @endif
                @endif
            </a>
        @elseif(featureEnabled($store, 'favoritos'))
            <a href="{{ route('tenant.favorites.index', $store->slug) }}" 
               class="flex items-center justify-center p-2 relative {{ request()->routeIs('tenant.favorites.*') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900' }} transition-colors">
                @if(request()->routeIs('tenant.favorites.*'))
                    <i data-lucide="heart" class="w-6 h-6 mr-2"></i>
                    <span class="text-sm font-medium">Favoritos</span>
                @else
                    <i data-lucide="heart" class="w-6 h-6"></i>
                @endif
                {{-- Badge contador --}}
                <span id="favorites-menu-badge" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">0</span>
            </a>
        @else
            <!-- Fallback: coming soon si no tiene ningún feature -->
            <a href="{{ route('tenant.coming-soon', $store->slug) }}" 
               class="flex items-center justify-center p-2 {{ request()->routeIs('tenant.coming-soon') ? 'bg-slate-900 text-white rounded-full px-3 py-2' : 'text-slate-900' }} transition-colors">
                @if(request()->routeIs('tenant.coming-soon'))
                    <i data-lucide="app-window" class="w-6 h-6 mr-2"></i>
                    <span class="text-sm font-medium">Apps</span>
                @else
                    <i data-lucide="app-window" class="w-6 h-6"></i>
                @endif
            </a>
        @endif
    </nav>

    <!-- Contenido principal -->
    <main class="relative z-0">
        @yield('content')
        
        <!-- Footer -->
        @include('frontend.components.footer')
    </main>

    <!-- Verificación de la tienda -->
    <script>
        function verificationBadge() {
            return {
                verified: {{ $store->verified ? 'true' : 'false' }},

                startPolling() {
                    // Consultar cada 3 segundos
                    setInterval(() => {
                        this.checkVerificationStatus();
                    }, 3000);
                },

                async checkVerificationStatus() {
                    try {
                        const response = await fetch('{{ route("tenant.verification-status", $store->slug) }}');
                        const data = await response.json();
                        this.verified = data.verified;
                    } catch (error) {
                        // Error silencioso - no afecta funcionalidad
                    }
                }
            }
        }
    </script>

    <!-- Carrito flotante (solo en páginas de navegación) -->
    @unless(request()->routeIs(['tenant.cart.index', 'tenant.checkout.*']))
        <x-cart-float :store="$store" />
    @endunless

    @stack('scripts')

</body>
</html> 