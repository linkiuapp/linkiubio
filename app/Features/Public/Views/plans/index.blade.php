<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Planes de Linkiu - Elige el plan perfecto para tu negocio online">
    <title>Planes - Linkiu</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images-ui/favico_linkiu.svg') }}">
    
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1195832799421409');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1195832799421409&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Satoshi Font -->
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@900,700,500,400&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gray-brand': {
                            300: '#62748E',
                            600: '#050506',
                        },
                        brand: {
                            200: '#0007F7',
                            400: '#000684',
                        },
                        accent: {
                            300: '#EA0038',
                            400: '#9E0024',
                        },
                        dark: {
                            800: '#0a0a0f',
                            900: '#050506',
                        }
                    },
                    fontFamily: {
                        satoshi: ['Satoshi', 'sans-serif'],
                        inter: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .font-satoshi { font-family: 'Satoshi', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        
        /* Dropdown menu */
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu { display: none; }
        
        /* Megamenu */
        .megamenu {
            opacity: 0;
            visibility: hidden;
            transform: translateX(-50%) translateY(10px);
            transition: all 0.25s ease;
        }
        .megamenu-trigger:hover .megamenu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
    </style>
</head>
<body class="font-inter antialiased bg-white text-gray-900" x-data="{ mobileMenu: false, productosOpen: false, funcionesOpen: false, recursosOpen: false, ayudaOpen: false, empresaOpen: false, calendlyOpen: false }">
    <x-public-navbar />

    <!-- Contenido Principal -->
    <main class="pt-40 pb-16 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Título -->
            <div class="text-center mb-12">
                <h1 class="font-satoshi text-4xl sm:text-2xl lg:text-5xl font-black text-gray-900 mb-4">
                {{ $maxTrialDays ?? 15 }} días gratis para probar Linkiu.
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 font-inter max-w-2xl mx-auto">
                    Elige el Plan Perfecto <br> Sin contratos. Sin sorpresas. Cancela cuando quieras.
                </p>
            </div>

            <!-- Cards de Planes -->
            <div x-data="planSelection()">
                <!-- Selector de Período -->
                <div class="flex justify-center mb-8">
                    <div class="grid grid-cols-2 md:inline-flex items-center gap-2 md:gap-3 bg-white rounded-2xl md:rounded-full p-2 shadow-lg border border-gray-200 w-full max-w-md md:w-auto md:max-w-none">
                        <label class="cursor-pointer">
                            <input type="radio" name="billing_period" value="monthly" x-model="selectedPeriod" checked class="hidden">
                            <span class="block px-4 py-2 md:px-6 md:py-2 rounded-full transition-all font-medium text-sm md:text-base text-center"
                                  :class="selectedPeriod === 'monthly' ? 'bg-accent-300 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Mensual
                            </span>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="billing_period" value="quarterly" x-model="selectedPeriod" class="hidden">
                            <span class="absolute -top-2 -right-2 md:-top-3 md:-right-3 bg-orange-500 text-white text-xs px-1.5 py-0.5 md:px-2 md:py-0.5 rounded-full font-bold z-10">
                                <span x-text="getAverageDiscount('quarterly')">5</span>%
                            </span>
                            <span class="block px-4 py-2 md:px-6 md:py-2 rounded-full transition-all font-medium text-sm md:text-base text-center"
                                  :class="selectedPeriod === 'quarterly' ? 'bg-accent-300 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Trimestral
                            </span>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="billing_period" value="semester" x-model="selectedPeriod" class="hidden">
                            <span class="absolute -top-2 -right-2 md:-top-3 md:-right-3 bg-yellow-500 text-white text-xs px-1.5 py-0.5 md:px-2 md:py-0.5 rounded-full font-bold z-10">
                                <span x-text="getAverageDiscount('semester')">10</span>%
                            </span>
                            <span class="block px-4 py-2 md:px-6 md:py-2 rounded-full transition-all font-medium text-sm md:text-base text-center"
                                  :class="selectedPeriod === 'semester' ? 'bg-accent-300 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Semestral
                            </span>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" name="billing_period" value="annual" x-model="selectedPeriod" class="hidden">
                            <span class="absolute -top-2 -right-2 md:-top-3 md:-right-3 bg-green-500 text-white text-xs px-1.5 py-0.5 md:px-2 md:py-0.5 rounded-full font-bold z-10">
                                <span x-text="getAverageDiscount('annual')">15</span>%
                            </span>
                            <span class="block px-4 py-2 md:px-6 md:py-2 rounded-full transition-all font-medium text-sm md:text-base text-center"
                                  :class="selectedPeriod === 'annual' ? 'bg-accent-300 text-white' : 'text-gray-700 hover:bg-gray-100'">
                                Anual
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Grid de Planes -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-6 pt-4 lg:pt-24">
                    @foreach($plans as $index => $plan)
                        @php
                            $isFeatured = $plan->is_featured;
                            $planImages = [
                                'Explorer' => 'banner_planes_explorer_registre.svg',
                                'Master' => 'banner_planes_master_registre.svg',
                                'Legend' => 'banner_planes_legend_registre.svg',
                            ];
                            $bannerImage = $planImages[$plan->name] ?? 'banner_planes_explorer_registre.svg';
                        @endphp
                        
                        <div class="pricing-plan-wrapper {{ $isFeatured ? 'lg:-mt-[50px] lg:scale-105 z-10' : '' }}">
                            <form method="POST" action="{{ route('plans.select') }}" class="h-full" id="planForm{{ $plan->id }}">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <input type="hidden" name="billing_period" id="billingPeriod{{ $plan->id }}" value="monthly">
                                
                                <div class="relative rounded-3xl overflow-hidden border bg-white border-gray-200 py-0 transition-all duration-300 hover:shadow-xl h-full flex flex-col">
                                    <!-- Banner Superior -->
                                    <div class="relative h-[158px] md:h-[172px] flex items-center justify-between px-4 overflow-hidden">
                                        <div class="relative z-10 ml-2 md:ml-0">
                                            <h6 class="text-lg font-black text-slate-900 mb-1">
                                                {{ strtoupper($plan->name) }}
                                            </h6>
                                            @if($plan->trial_days > 0)
                                                <p class="text-sm md:text-base text-slate-900 font-medium mb-2">
                                                    {{ $plan->trial_days }} días gratis
                                                </p>
                                            @endif
                                            @if($isFeatured)
                                                <span class="absolute bg-white text-slate-900 rounded-full py-1 px-3 text-xs font-bold shadow-lg z-20">
                                                    POPULAR
                                                </span>
                                            @endif
                                        </div>
                                        <div class="absolute right-0 top-0 h-full w-full flex items-center justify-center">
                                            <img src="{{ asset('images-ui/' . $bannerImage) }}" alt="Plan {{ $plan->name }}" class="h-full w-auto object-contain">
                                        </div>
                                    </div>

                                    <!-- Contenido del Plan -->
                                    <div class="px-6 py-6 flex-1 flex flex-col">
                                        <!-- Precio Dinámico -->
                                        <div class="mb-2">
                                            <h3 class="text-xl font-bold text-slate-900">
                                                <span class="font-black" x-text="formatPrice({{ $plan->id }})">{{ $plan->getPriceFormatted() }}</span>
                                                <span class="text-base font-semibold text-slate-600">
                                                    <span x-text="getPeriodLabel()">/mes</span>
                                                </span>
                                            </h3>
                                        </div>

                                        <!-- Descripción -->
                                        @if($plan->description)
                                            <p class="text-sm mb-4 font-normal text-slate-600">
                                                {{ Str::limit($plan->description, 150) }}
                                            </p>
                                        @endif

                                        <!-- Botón de Selección -->
                                        <button type="button" 
                                                @click="if (typeof fbq !== 'undefined') { fbq('track', 'Lead', {value: {{ $plan->monthly_price ?? 70000 }}, currency: 'COP', content_name: '{{ $plan->name }}'}); } const periodInput = document.getElementById('billingPeriod{{ $plan->id }}'); const period = selectedPeriod || 'monthly'; if(periodInput) periodInput.value = period; document.getElementById('planForm{{ $plan->id }}').submit();"
                                                class="w-full py-3 rounded-lg font-semibold transition-all mb-4 bg-slate-900 hover:bg-slate-800 text-white border border-slate-800 shadow-md hover:shadow-lg transform hover:scale-[1.02] mt-auto">
                                            Elegir plan
                                        </button>

                                        <!-- Características principales -->
                                        <div class="mb-4">
                                            <span class="block mb-2 font-bold text-base text-slate-900">
                                                Lo que incluye:
                                            </span>
                                            <ul class="space-y-3">
                                                @php
                                                    $features = $plan->features_list ?? [];
                                                    $mainFeatures = array_slice($features, 0, 6);
                                                @endphp
                                                @foreach($mainFeatures as $feature)
                                                    <li class="flex items-center gap-2">
                                                        <i data-lucide="badge-check" class="w-4 h-4 text-slate-600 flex-shrink-0"></i>
                                                        <span class="text-sm font-normal text-slate-600">{{ $feature }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Todas las Funcionalidades -->
            <div id="funcionalidades" class="mt-12 lg:mt-32 scroll-mt-24">
                <div class="text-center mb-16">
                    <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Todas las Funcionalidades
                    </h2>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto">
                        Descubre todo lo que incluye cada plan de Linkiu
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Verificación de Comprobantes - IA -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="shield-check" class="w-6 h-6 text-purple-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Verificación de Comprobantes</h3>
                                <p class="text-sm text-gray-600 font-inter">Con Kiubot verifica comprobantes de pago automáticamente</p>
                            </div>
                        </div>
                    </div>

                    <!-- Atención Automática - IA -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="bot" class="w-6 h-6 text-purple-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Atención Automática</h3>
                                <p class="text-sm text-gray-600 font-inter">Chat inteligente 24/7 que responde preguntas de tus clientes</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recomendaciones Inteligentes - IA -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="brain" class="w-6 h-6 text-purple-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Recomendaciones Inteligentes</h3>
                                <p class="text-sm text-gray-600 font-inter">Sugiere productos similares basado en IA</p>
                            </div>
                        </div>
                    </div>

                    <!-- Búsqueda Inteligente - IA -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="search" class="w-6 h-6 text-purple-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Búsqueda Inteligente</h3>
                                <p class="text-sm text-gray-600 font-inter">Encuentra productos fácilmente con búsqueda semántica</p>
                            </div>
                        </div>
                    </div>

                    <!-- Asistente Virtual - IA -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="lightbulb" class="w-6 h-6 text-purple-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Asistente Virtual</h3>
                                <p class="text-sm text-gray-600 font-inter">Ayuda en tiempo real con Kiubot para resolver dudas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Categorías -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-brand-200/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="folder" class="w-6 h-6 text-brand-200"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Categorías</h3>
                                <p class="text-sm text-gray-600 font-inter">Crea categorías de forma rápida y organiza tu catálogo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Productos -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-brand-200/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="package" class="w-6 h-6 text-brand-200"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Productos</h3>
                                <p class="text-sm text-gray-600 font-inter">Gestiona productos ilimitados o limitados según tu plan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Variables -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="layers" class="w-6 h-6 text-purple-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Variables</h3>
                                <p class="text-sm text-gray-600 font-inter">Tallas, colores y opciones personalizables por producto</p>
                            </div>
                        </div>
                    </div>

                    <!-- Inventario -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-orange-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="box" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Inventario</h3>
                                <p class="text-sm text-gray-600 font-inter">Control de stock en tiempo real con actualizaciones automáticas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Productos Bajo Pedido -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="clock" class="w-6 h-6 text-yellow-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Productos Bajo Pedido</h3>
                                <p class="text-sm text-gray-600 font-inter">Vende sin stock, con anticipos y días de preparación</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sliders -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-pink-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="image" class="w-6 h-6 text-pink-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Sliders</h3>
                                <p class="text-sm text-gray-600 font-inter">Banners promocionales para destacar ofertas y productos</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cupones -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="tag" class="w-6 h-6 text-red-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Cupones</h3>
                                <p class="text-sm text-gray-600 font-inter">Descuentos y ofertas que impulsan tus ventas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pedidos -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="shopping-bag" class="w-6 h-6 text-blue-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Pedidos</h3>
                                <p class="text-sm text-gray-600 font-inter">Gestión completa de pedidos con historial extendido</p>
                            </div>
                        </div>
                    </div>

                    <!-- Métodos de Pago -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="credit-card" class="w-6 h-6 text-green-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Métodos de Pago</h3>
                                <p class="text-sm text-gray-600 font-inter">Transferencias bancarias, Nequi, Daviplata y múltiples opciones</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sedes -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="map-pin" class="w-6 h-6 text-indigo-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Sedes</h3>
                                <p class="text-sm text-gray-600 font-inter">Múltiples ubicaciones para gestionar tu negocio</p>
                            </div>
                        </div>
                    </div>

                    <!-- Zonas de Envío -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-cyan-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="truck" class="w-6 h-6 text-cyan-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Zonas de Envío</h3>
                                <p class="text-sm text-gray-600 font-inter">Configura zonas de reparto con cálculo automático de costos</p>
                            </div>
                        </div>
                    </div>

                    <!-- Administradores -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-violet-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="users" class="w-6 h-6 text-violet-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Administradores</h3>
                                <p class="text-sm text-gray-600 font-inter">Múltiples usuarios con diferentes permisos y roles</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dashboard -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-sky-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="bar-chart-3" class="w-6 h-6 text-sky-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Dashboard</h3>
                                <p class="text-sm text-gray-600 font-inter">Métricas, reportes y analíticas de tu negocio</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notificaciones WhatsApp -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="message-circle" class="w-6 h-6 text-green-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Notificaciones WhatsApp</h3>
                                <p class="text-sm text-gray-600 font-inter">Avisos automáticos de pedidos y actualizaciones a tus clientes</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kiubot -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="bot" class="w-6 h-6 text-emerald-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Kiubot</h3>
                                <p class="text-sm text-gray-600 font-inter">Asistente automático para atención y verificación de pagos</p>
                            </div>
                        </div>
                    </div>

                    <!-- Diseño Personalizado -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-rose-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="palette" class="w-6 h-6 text-rose-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Diseño Personalizado</h3>
                                <p class="text-sm text-gray-600 font-inter">Personaliza colores, logo y tema de tu tienda</p>
                            </div>
                        </div>
                    </div>

                    <!-- URL Personalizada -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-amber-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="link" class="w-6 h-6 text-amber-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">URL Personalizada</h3>
                                <p class="text-sm text-gray-600 font-inter">Dominio personalizado según tu plan (ej: mitienda.bio)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Reservas de Mesas -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-orange-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="calendar" class="w-6 h-6 text-orange-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Reservas de Mesas</h3>
                                <p class="text-sm text-gray-600 font-inter">Sistema de reservas para restaurantes con QR en mesas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Menú Digital -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="utensils" class="w-6 h-6 text-red-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Menú Digital</h3>
                                <p class="text-sm text-gray-600 font-inter">Menú interactivo para restaurantes con fotos y descripciones</p>
                            </div>
                        </div>
                    </div>

                    <!-- QR Mesas -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-teal-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="qr-code" class="w-6 h-6 text-teal-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">QR Mesas</h3>
                                <p class="text-sm text-gray-600 font-inter">Códigos QR para que clientes vean el menú y hagan pedidos</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tickets de Soporte -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i data-lucide="headphones" class="w-6 h-6 text-blue-500"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi font-bold text-gray-900 mb-1">Tickets de Soporte</h3>
                                <p class="text-sm text-gray-600 font-inter">Sistema de soporte con respuesta según tu plan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Final -->
            <div class="mt-20 text-center">
                <h2 class="font-satoshi text-3xl font-black text-gray-900 mb-4">
                    ¿Listo para comenzar?
                </h2>
                <p class="text-lg text-gray-600 mb-8 font-inter">
                    Crea tu tienda en minutos y comienza a vender hoy mismo
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register.step1') }}" onclick="if(typeof fbq !== 'undefined') { fbq('track', 'Lead', {value: 0, currency: 'COP'}); }" class="bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all hover:scale-105 inline-flex items-center justify-center gap-2">
                        <span>Empezar ahora</span>
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                    <button @click="calendlyOpen = true" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-4 rounded-xl font-semibold text-lg transition-colors border-2 border-gray-200 inline-flex items-center justify-center gap-2">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                        <span>Agendar reunión</span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Calendly Modal -->
    <div 
        x-show="calendlyOpen" 
        x-cloak
        x-transition
        @click.self="calendlyOpen = false"
        @keydown.escape.window="calendlyOpen = false"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        style="display: none;"
    >
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
            <!-- Close Button -->
            <button 
                @click="calendlyOpen = false"
                class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-lg transition-colors"
            >
                <i data-lucide="x" class="w-5 h-5 text-gray-600"></i>
            </button>
            
            <!-- Calendly Widget -->
            <div class="calendly-inline-widget" data-url="https://calendly.com/linkiucloud/30min?hide_event_type_details=1&hide_gdpr_banner=1&text_color=050506&primary_color=ea0038" style="min-width:320px;height:700px;"></div>
        </div>
    </div>
    
    <!-- Calendly Script -->
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>

    <x-public-footer />

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('planSelection', () => ({
            selectedPlan: null,
            selectedPeriod: 'monthly',
            @php
                $planData = [];
                foreach($plans as $plan) {
                    $planData[$plan->id] = [
                        'id' => $plan->id,
                        'name' => $plan->name,
                        'prices' => $plan->prices ?? [],
                        'price' => $plan->price
                    ];
                }
            @endphp
            plans: @json($planData),
            
            formatPrice(planId) {
                const plan = this.plans[planId];
                if (!plan) return '$0';
                
                const prices = plan.prices || {};
                let price = 0;
                
                switch(this.selectedPeriod) {
                    case 'monthly':
                        price = plan.price;
                        break;
                    case 'quarterly':
                        price = prices.quarterly || (plan.price * 3);
                        break;
                    case 'semester':
                        price = prices.semester || (plan.price * 6);
                        break;
                    case 'annual':
                        price = prices.annual || (plan.price * 12);
                        break;
                }
                
                return '$' + new Intl.NumberFormat('es-CO').format(price);
            },
            
            getPeriodLabel() {
                const labels = {
                    'monthly': '/mes',
                    'quarterly': '/3 meses',
                    'semester': '/6 meses',
                    'annual': '/año'
                };
                return labels[this.selectedPeriod] || '/mes';
            },
            
            getAverageDiscount(period) {
                if (period === 'monthly') return 0;
                
                let totalDiscount = 0;
                let count = 0;
                
                Object.values(this.plans).forEach(plan => {
                    const discount = this.calculateDiscountForPlan(plan, period);
                    if (discount > 0) {
                        totalDiscount += discount;
                        count++;
                    }
                });
                
                return count > 0 ? Math.round(totalDiscount / count) : 0;
            },
            
            calculateDiscountForPlan(plan, period) {
                const prices = plan.prices || {};
                const monthlyPrice = plan.price;
                let actualPrice = 0;
                let months = 1;
                
                switch(period) {
                    case 'quarterly':
                        actualPrice = prices.quarterly || 0;
                        months = 3;
                        break;
                    case 'semester':
                        actualPrice = prices.semester || 0;
                        months = 6;
                        break;
                    case 'annual':
                        actualPrice = prices.annual || 0;
                        months = 12;
                        break;
                }
                
                if (actualPrice === 0 || monthlyPrice === 0) return 0;
                
                const fullPrice = monthlyPrice * months;
                return ((fullPrice - actualPrice) / fullPrice) * 100;
            }
        }));
    });

    // Inicializar iconos Lucide
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
    </script>
    <style>
    [x-cloak] { display: none !important; }
    </style>
</body>
</html>
