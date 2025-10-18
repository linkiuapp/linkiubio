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
</head>
<body class="bg-accent-100 max-w-[480px] mx-auto overflow-x-hidden">

    <!-- Header -->
    <header class="relative overflow-hidden" style="background: {{ $store->design ? $store->design->header_background_color : '' }}">
        <div class="px-6 py-10 text-center">

            <!-- Logo -->
            <div class="mb-4">
                <div class="mx-auto flex items-center justify-center">
                    @if($store->design && $store->design->logo_url)
                        <img src="{{ $store->design->logo_url }}" 
                             alt="Logo" 
                             class="w-18 h-18 rounded-full object-cover"
                             style="width: 100px; height: 100px;">
                    @endif
                </div>
            </div>

            <!-- Badge Verificado -->
            <div class="mb-2" x-data="verificationBadge" x-init="startPolling()">
                @if($store->verified)
                    <div x-show="verified" class="inline-flex items-center bg-success-50 border border-success-300 text-success-400 px-2 py-1 rounded-full text-small font-regular">
                        <x-lucide-badge-check class="w-4 h-4 mr-2" />
                        Tienda Verificada
                    </div>
                @else
                    <div x-show="!verified" class="inline-flex items-center bg-secondary-50 border border-secondary-300 text-secondary-400 px-2 py-1 rounded-full text-small font-regular">
                        <x-lucide-shield-off class="w-4 h-4 mr-2" />
                        Tienda No Verificada
                    </div>
                @endif
            </div>

            <!-- Nombre de la tienda -->
            <h1 class="text-h6 font-bold text-center capitalize" style="color: {{ $store->design ? $store->design->header_text_color : '#ffffff' }}">
                {{ $store->name ?? 'Linkiu Rest' }}
            </h1>

            <!-- Descripción -->
            <p class="text-body-regular font-regular" style="color: {{ $store->design ? $store->design->header_description_color : '#e9d5ff' }}">
                {{ $store->description ?? 'Comidas Rápidas en Sincelejo' }}
            </p>
        </div>
    </header>

    <!-- Menu inferior -->
    <nav class="w-full max-w-[480px] bg-accent-50 rounded-b-3xl px-2 sm:px-4 py-4">
        <div class="flex justify-around items-center">

            <!-- Contacto -->
            <a href="{{ route('tenant.contact', $store->slug) }}" 
               class="flex flex-col items-center py-2 px-1 sm:px-4 {{ request()->routeIs('tenant.contact') ? 'text-accent-75 bg-primary-300 rounded-xl' : 'text-secondary-300 hover:text-secondary-300 hover:bg-accent-100 hover:rounded-xl' }} transition-colors">
                <x-lucide-store class="w-5 h-5 sm:w-6 sm:h-6 mb-1" />
                <span class="text-[10px] sm:text-caption font-regular">Sedes</span>
            </a>

            <!-- Catálogo -->
            <a href="{{ route('tenant.catalog', $store->slug) }}" 
               class="flex flex-col items-center py-2 px-1 sm:px-4 {{ request()->routeIs('tenant.catalog') ? 'text-accent-75 bg-primary-300 rounded-xl' : 'text-secondary-300 hover:text-secondary-300 hover:bg-accent-100 hover:rounded-xl' }} transition-colors">
                <x-lucide-shopping-basket class="w-5 h-5 sm:w-6 sm:h-6 mb-1" />
                <span class="text-[10px] sm:text-caption font-regular">Catálogo</span>
            </a>

            <!-- Inicio -->
            <a href="{{ route('tenant.home', $store->slug) }}" 
               class="flex flex-col items-center py-2 px-2 sm:px-5 {{ request()->routeIs('tenant.home') ? 'text-accent-75 bg-primary-300 rounded-xl' : 'text-secondary-300 hover:text-secondary-300 hover:bg-accent-100 hover:rounded-xl' }} transition-colors">
                <x-lucide-home class="w-6 h-6 sm:w-7 sm:h-7 mb-1" />
                <span class="text-[10px] sm:text-caption font-regular">Inicio</span>
            </a>

            <!-- Promos -->
            <a href="{{ route('tenant.promotions', $store->slug) }}" 
               class="flex flex-col items-center py-2 px-1 sm:px-4 {{ request()->routeIs('tenant.promotions') ? 'text-accent-75 bg-primary-300 rounded-xl' : 'text-secondary-300 hover:text-secondary-300 hover:bg-accent-100 hover:rounded-xl' }} transition-colors">
                <x-lucide-badge-percent class="w-5 h-5 sm:w-6 sm:h-6 mb-1" />
                <span class="text-[10px] sm:text-caption font-regular">Promos</span>
            </a>

            <!-- Reservas -->
            <a href="{{ route('tenant.coming-soon', $store->slug) }}" 
               class="flex flex-col items-center py-2 px-1 sm:px-4 {{ request()->routeIs('tenant.coming-soon') ? 'text-accent-75 bg-primary-300 rounded-xl' : 'text-secondary-300 hover:text-secondary-300 hover:bg-accent-100 hover:rounded-xl' }} transition-colors">
                <x-lucide-calendar-days class="w-5 h-5 sm:w-6 sm:h-6 mb-1" />
                <span class="text-[10px] sm:text-caption font-regular">Reservas</span>
            </a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="min-h-screen pb-20">
        @yield('content')
    </main>

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
                        console.log('Error checking verification status:', error);
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