<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->name ?? 'Linkiu Store' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="store-slug" content="{{ $store->slug }}">

    @if($store->design && $store->design->favicon_url)
        <link rel="icon" type="image/x-icon" href="{{ $store->design->favicon_url }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-brandWhite-50 md:max-w-[480px] max-w-full mx-auto overflow-x-hidden">

    <!-- Header -->
    <header class="relative overflow-hidden" style="background: {{ $store->design ? $store->design->header_background_color : '' }}">
        <div class="px-6 py-16 text-center">

            <!-- Logo -->
            <div class="mb-2">
                <div class="mx-auto flex items-center justify-center">
                    @if($store->design && $store->design->logo_url)
                        <img src="{{ $store->design->logo_url }}" 
                             alt="Logo" 
                             class="w-18 h-18 rounded-full object-cover border-4 border-brandWhite-300"
                             style="width: 130px; height: 130px; md:width: 150px; md:height: 150px;">
                    @endif
                </div>
            </div>

            <!-- Nombre de la tienda y badge de verificación -->
            <div x-data="verificationBadge" x-init="startPolling()" class="flex items-center gap-2 justify-center mb-2">
                <h1 class="h1 capitalize" style="color: {{ $store->design ? $store->design->header_text_color : '#ffffff' }}">
                    {{ $store->name ?? 'Linkiu Store' }}
                </h1>
                @if($store->verified)
                <div x-show="verified" x-init="startPolling()" class="bg-brandSuccess-50 rounded-full p-1">
                    <i data-lucide="badge-check" class="w-16px h-16px text-brandSuccess-400"></i>
                </div>
                @else
                    <div x-show="!verified" x-init="startPolling()" class="bg-brandError-50 rounded-full p-2">
                        <i data-lucide="shield-off"></i>
                    </div>
                @endif
            </div>
            

            <!-- Descripción -->
            <p class="body-small text-center" style="color: {{ $store->design ? $store->design->header_description_color : '#e9d5ff' }}">
                {{ $store->description ?? 'Comidas Rápidas en Sincelejo' }}
            </p>
        </div>
    </header>

    <!-- Menu inferior -->
    <nav class="w-full max-w-[480px] bg-brandWhite-100 rounded-b-3xl px-4 sm:px-4 py-4 items-center justify-center">
        <div class="flex justify-center items-center gap-2">

            <!-- Contacto (Sedes) -->
            <a href="{{ route('tenant.contact', $store->slug) }}" 
               class="flex flex-col items-center py-3 px-3 min-w-[72px] {{ request()->routeIs('tenant.contact') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl' }} transition-colors">
                <i data-lucide="building-2" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                <span class="body-small sm:body-lg">Sedes</span>
            </a>

            <!-- Catálogo -->
            <a href="{{ route('tenant.catalog', $store->slug) }}" 
               class="flex flex-col items-center py-3 px-3 min-w-[72px] {{ request()->routeIs('tenant.catalog') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl' }} transition-colors">
                <i data-lucide="shopping-basket" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                <span class="body-small sm:body-lg">Catálogo</span>
            </a>

            <!-- Inicio -->
            <a href="{{ route('tenant.home', $store->slug) }}" 
               class="flex flex-col items-center py-3 px-3 min-w-[72px] {{ request()->routeIs('tenant.home') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl' }} transition-colors">
                <i data-lucide="store" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                <span class="body-small sm:body-lg">Inicio</span>
            </a>

            <!-- Promos -->
            <a href="{{ route('tenant.promotions', $store->slug) }}" 
               class="flex flex-col items-center py-3 px-3 min-w-[72px] {{ request()->routeIs('tenant.promotions') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl' }} transition-colors">
                <i data-lucide="badge-percent" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                <span class="body-small sm:body-lg">Promos</span>
            </a>

            <!-- Reservas -->
            <a href="{{ route('tenant.coming-soon', $store->slug) }}" 
               class="flex flex-col items-center py-3 px-3 min-w-[72px] {{ request()->routeIs('tenant.coming-soon') ? 'text-brandWhite-300 bg-brandPrimary-300 rounded-xl' : 'text-brandNeutral-400 hover:text-brandWhite-300 hover:bg-brandPrimary-300 hover:rounded-xl' }} transition-colors">
                <i data-lucide="calendar-heart" class="w-32px h-32px sm:w-40px sm:h-40px"></i>
                <span class="body-small sm:body-lg">Reservas</span>
            </a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main>
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