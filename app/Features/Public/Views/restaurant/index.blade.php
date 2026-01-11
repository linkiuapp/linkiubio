<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Restaurante con Linkiu - Menú digital, reservas de mesas y pedidos online. Ideal para restaurantes, cafeterías, pizzerías y más.">
    <title>Restaurante - Linkiu</title>
    
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
        
        /* Hero gradient */
        .hero-gradient {
            background: #050506;
            position: relative;
        }
        .hero-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 50% 0%, rgba(0, 7, 247, 0.06) 0%, transparent 80%),
                radial-gradient(circle at 100% 50%, rgba(234, 0, 56, 0.04) 0%, transparent 80%),
                radial-gradient(circle at 0% 100%, rgba(0, 6, 132, 0.05) 0%, transparent 80%);
            pointer-events: none;
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        .float-animation-delay {
            animation: float 3s ease-in-out infinite;
            animation-delay: 1s;
        }
        .float-animation-delay-2 {
            animation: float 3s ease-in-out infinite;
            animation-delay: 2s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
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
        
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        /* Stores Carousel */
        .stores-carousel {
            overflow: hidden;
            mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        }
        
        .stores-carousel-track {
            display: flex;
            gap: 1rem;
            animation: scroll-horizontal 8s linear infinite;
            width: fit-content;
        }
        
        .stores-carousel-track:hover {
            animation-play-state: paused;
        }
        
        .stores-carousel-item {
            flex-shrink: 0;
        }
        
        @keyframes scroll-horizontal {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
        
        @media (max-width: 768px) {
            .stores-carousel-track {
                gap: 1.5rem;
                animation-duration: 8s;
            }
            
            .stores-carousel-item > div {
                width: 6rem;
                height: 6rem;
            }
        }
    </style>
</head>
<body class="font-inter antialiased bg-white text-gray-900" x-data="{ mobileMenu: false, productosOpen: false, funcionesOpen: false, recursosOpen: false, ayudaOpen: false, empresaOpen: false, calendlyOpen: false }">
    <x-public-navbar />

    <!-- Hero Section con Wireframes -->
    <section class="hero-gradient min-h-screen flex items-center relative overflow-hidden pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Texto -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full mb-6 border border-white/10">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-white/80 text-sm font-inter">Ideal para restaurantes, cafeterías, pizzerías y más</span>
                    </div>
                    
                    <h1 class="font-satoshi text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight mb-6">
                        Tu restaurante digital<br>
                        <span class="text-accent-300">siempre abierto</span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-gray-300 mb-8 max-w-xl mx-auto lg:mx-0 font-inter">
                        Menú digital, reservas de mesas y pedidos online. Con Linkiu tienes tu restaurante digital completo con pedidos, pagos y reservas <span class="text-accent-300 font-semibold">en minutos</span>.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register.step1') }}" class="bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all hover:scale-105 flex items-center justify-center gap-2">
                            <span>Crear mi restaurante</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                        <a href="{{ route('plans.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-colors flex items-center justify-center gap-2 border border-white/20">
                            <i data-lucide="eye" class="w-5 h-5"></i>
                            <span>Ver planes</span>
                        </a>
                    </div>
                    
                    <!-- Trust badges -->
                    <div class="flex flex-wrap items-center gap-6 mt-10 justify-center lg:justify-start">
                        <div class="flex items-center gap-2 text-gray-400">
                            <i data-lucide="check-circle" class="w-5 h-5 text-white"></i>
                            <span class="text-sm">Menú ilimitado</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400">
                            <i data-lucide="check-circle" class="w-5 h-5 text-white"></i>
                            <span class="text-sm">Sin comisiones ocultas</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-400">
                            <i data-lucide="check-circle" class="w-5 h-5 text-white"></i>
                            <span class="text-sm">15 días gratis</span>
                        </div>
                    </div>
                </div>
                
                <!-- Mockup con wireframes de restaurante -->
                <div class="relative">
                    <div class="rounded-3xl">
                        <!-- Browser mockup -->
                        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                            <div class="bg-gray-100 px-4 py-3 flex items-center gap-2">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 bg-accent-300 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                </div>
                                <div class="flex-1 bg-white rounded-lg px-3 py-1.5 text-xs text-gray-500 text-center font-medium">
                                    linkiu.bio/mitienda
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Header de la tienda -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="h-8 bg-brand-200/20 rounded-lg w-32"></div>
                                    <div class="flex gap-2">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                        <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    </div>
                                </div>
                                
                                <!-- Slider/Hero image -->
                                <div class="w-full h-32 bg-gradient-to-br from-brand-200/20 to-accent-300/20 rounded-xl mb-4"></div>
                                
                                <!-- Grid de platos del menú -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                                        <div class="w-full h-28 bg-gradient-to-br from-orange-200/40 to-amber-200/40 rounded-lg mb-2"></div>
                                        <div class="h-3 bg-gray-300 rounded w-full mb-1"></div>
                                        <div class="h-3 bg-gray-200 rounded w-2/3 mb-2"></div>
                                        <div class="h-4 bg-accent-300/30 rounded w-20"></div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                                        <div class="w-full h-28 bg-gradient-to-br from-red-200/40 to-pink-200/40 rounded-lg mb-2"></div>
                                        <div class="h-3 bg-gray-300 rounded w-full mb-1"></div>
                                        <div class="h-3 bg-gray-200 rounded w-2/3 mb-2"></div>
                                        <div class="h-4 bg-accent-300/30 rounded w-20"></div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                                        <div class="w-full h-28 bg-gradient-to-br from-green-200/40 to-emerald-200/40 rounded-lg mb-2"></div>
                                        <div class="h-3 bg-gray-300 rounded w-full mb-1"></div>
                                        <div class="h-3 bg-gray-200 rounded w-2/3 mb-2"></div>
                                        <div class="h-4 bg-accent-300/30 rounded w-20"></div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                                        <div class="w-full h-28 bg-gradient-to-br from-blue-200/40 to-cyan-200/40 rounded-lg mb-2"></div>
                                        <div class="h-3 bg-gray-300 rounded w-full mb-1"></div>
                                        <div class="h-3 bg-gray-200 rounded w-2/3 mb-2"></div>
                                        <div class="h-4 bg-accent-300/30 rounded w-20"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Cards -->
                    <div class="absolute -top-4 -right-4 bg-white rounded-xl shadow-xl p-3 float-animation border border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i data-lucide="shopping-cart" class="w-5 h-5 text-green-600"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Pedido activo</span>
                                <span class="text-xs text-gray-500">3 platos</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-8 -left-6 bg-white rounded-xl shadow-xl p-3 float-animation-delay border border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                <i data-lucide="utensils" class="w-5 h-5 text-orange-600"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Menú</span>
                                <span class="text-xs text-green-600 font-semibold">+80 platos</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute top-1/2 -left-8 bg-white rounded-xl shadow-xl p-3 float-animation-delay-2 border border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Reservas hoy</span>
                                <span class="text-xs text-blue-600 font-semibold">+12 mesas</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute bottom-1/3 -right-24 bg-white rounded-xl shadow-xl p-3 float-animation border border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-accent-300/10 rounded-full flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-5 h-5 text-accent-300"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Pago recibido</span>
                                <span class="text-xs text-green-600 font-semibold">$245.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carrusel de tiendas -->
    <x-featured-stores-carousel :stores="$featuredStores ?? collect([])" />

    <!-- Sección: Para quién es ideal -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-satoshi text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                    Perfecto para tu tipo de restaurante
                </h2>
                <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto">
                    Si tienes un restaurante, cafetería o negocio gastronómico, Linkiu Restaurante es tu solución ideal
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Restaurante Elegante -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-100 card-hover">
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="utensils-crossed" class="w-7 h-7 text-amber-600"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-xl text-gray-900 mb-2">Restaurante Elegante</h3>
                    <p class="text-gray-600 font-inter text-sm mb-4">Menú digital completo, reservas de mesas y pedidos online. Perfecto para restaurantes de alta cocina.</p>
                    <ul class="space-y-2 text-xs text-gray-600 font-inter">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5"></i>
                            <span>Reservas de mesas</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5"></i>
                            <span>Menú digital completo</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5"></i>
                            <span>Pedidos online</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Comida Rápida -->
                <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-2xl p-6 border border-red-100 card-hover">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="zap" class="w-7 h-7 text-red-600"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-xl text-gray-900 mb-2">Comida Rápida</h3>
                    <p class="text-gray-600 font-inter text-sm mb-4">Pedidos rápidos, menú digital y consumo en local. Ideal para hamburgueserías, pizzerías y comida rápida.</p>
                    <ul class="space-y-2 text-xs text-gray-600 font-inter">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-red-600 flex-shrink-0 mt-0.5"></i>
                            <span>Pedidos rápidos</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-red-600 flex-shrink-0 mt-0.5"></i>
                            <span>Consumo en local con QR</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-red-600 flex-shrink-0 mt-0.5"></i>
                            <span>Domicilios y para llevar</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Cafetería -->
                <div class="bg-gradient-to-br from-brown-50 to-amber-50 rounded-2xl p-6 border border-amber-100 card-hover">
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="coffee" class="w-7 h-7 text-amber-700"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-xl text-gray-900 mb-2">Cafetería</h3>
                    <p class="text-gray-600 font-inter text-sm mb-4">Perfecto para cafeterías, panaderías y pastelerías. Menú digital con productos frescos.</p>
                    <ul class="space-y-2 text-xs text-gray-600 font-inter">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-amber-700 flex-shrink-0 mt-0.5"></i>
                            <span>Productos frescos diarios</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-amber-700 flex-shrink-0 mt-0.5"></i>
                            <span>Pedidos anticipados</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-amber-700 flex-shrink-0 mt-0.5"></i>
                            <span>Consumo en local</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Pizzería -->
                <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl p-6 border border-orange-100 card-hover">
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="circle-dot" class="w-7 h-7 text-orange-600"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-xl text-gray-900 mb-2">Pizzería</h3>
                    <p class="text-gray-600 font-inter text-sm mb-4">Menú de pizzas personalizables, pedidos online y domicilios. Ideal para pizzerías y restaurantes de comida italiana.</p>
                    <ul class="space-y-2 text-xs text-gray-600 font-inter">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-orange-600 flex-shrink-0 mt-0.5"></i>
                            <span>Pizzas personalizables</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-orange-600 flex-shrink-0 mt-0.5"></i>
                            <span>Domicilios rápidos</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-orange-600 flex-shrink-0 mt-0.5"></i>
                            <span>Promociones y combos</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Comida Local -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100 card-hover">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="map-pin" class="w-7 h-7 text-green-600"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-xl text-gray-900 mb-2">Comida Local</h3>
                    <p class="text-gray-600 font-inter text-sm mb-4">Restaurantes de comida típica y tradicional. Menú digital auténtico con sabores locales.</p>
                    <ul class="space-y-2 text-xs text-gray-600 font-inter">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <span>Menú auténtico</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <span>Reservas de mesas</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                            <span>Domicilios</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Comida para Llevar -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-100 card-hover">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="package" class="w-7 h-7 text-blue-600"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-xl text-gray-900 mb-2">Comida para Llevar</h3>
                    <p class="text-gray-600 font-inter text-sm mb-4">Especializado en pedidos para llevar y domicilios. Perfecto para restaurantes sin comedor.</p>
                    <ul class="space-y-2 text-xs text-gray-600 font-inter">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                            <span>Pedidos online</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                            <span>Domicilios optimizados</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                            <span>Recogida en tienda</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Características principales con wireframes -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-satoshi text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                    Todo lo que necesitas para tu restaurante digital
                </h2>
                <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto">
                    Funcionalidades diseñadas específicamente para restaurantes
                </p>
            </div>
            
            <!-- Característica 1: Menú Digital -->
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <div class="inline-flex items-center gap-2 bg-orange-100 px-4 py-2 rounded-full mb-4">
                        <i data-lucide="utensils" class="w-5 h-5 text-orange-600"></i>
                        <span class="text-sm font-semibold text-orange-600">Gestión de Menú</span>
                    </div>
                    <h3 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Menú digital ilimitado
                    </h3>
                    <p class="text-lg text-gray-600 font-inter mb-6">
                        Crea tu menú digital con platos, bebidas y combos. Sin límites, sin restricciones. Tu menú crece contigo.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-orange-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Fotos y galerías</span>
                                <span class="text-sm text-gray-600">Múltiples imágenes por plato para mostrar presentación</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-orange-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Variantes y opciones</span>
                                <span class="text-sm text-gray-600">Tamaños, ingredientes, acompañamientos con precios personalizados</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-orange-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Categorías personalizadas</span>
                                <span class="text-sm text-gray-600">Organiza tu menú por tipo de comida, entradas, platos principales, postres</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-orange-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Combos y promociones</span>
                                <span class="text-sm text-gray-600">Crea combos especiales y promociones del día para aumentar ventas</span>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Wireframe de menú -->
                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200">
                        <!-- Header del admin -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-brand-200/10 rounded-lg"></div>
                                <div>
                                    <div class="h-4 bg-gray-800 rounded w-32 mb-1"></div>
                                    <div class="h-2 bg-gray-200 rounded w-24"></div>
                                </div>
                            </div>
                            <div class="h-8 bg-accent-300 rounded-lg w-24"></div>
                        </div>
                        
                        <!-- Grid de platos del menú -->
                        <div class="grid grid-cols-3 gap-3">
                            @for($i = 0; $i < 6; $i++)
                            <div class="bg-gray-50 rounded-lg p-2 border border-gray-100">
                                <div class="w-full h-16 bg-gradient-to-br from-orange-200/40 to-amber-200/40 rounded mb-2"></div>
                                <div class="h-2 bg-gray-300 rounded w-full mb-1"></div>
                                <div class="h-2 bg-gray-200 rounded w-2/3 mb-2"></div>
                                <div class="h-3 bg-accent-300/30 rounded w-16"></div>
                            </div>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Floating card -->
                    <div class="absolute -bottom-4 -right-4 bg-white rounded-xl shadow-lg p-3 border border-gray-100 float-animation">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Plato agregado</span>
                                <span class="text-[10px] text-gray-500">Menú actualizado</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Característica 2: Carrito y Pagos -->
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
                <!-- Wireframe de carrito -->
                <div class="relative order-2 lg:order-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                            <div class="h-5 bg-gray-800 rounded w-24"></div>
                            <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                        </div>
                        
                        <!-- Items del carrito -->
                        <div class="space-y-3 mb-4">
                            @for($i = 0; $i < 2; $i++)
                            <div class="flex gap-3 p-2 bg-gray-50 rounded-lg">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-100 rounded"></div>
                                <div class="flex-1">
                                    <div class="h-3 bg-gray-300 rounded w-3/4 mb-2"></div>
                                    <div class="h-2 bg-gray-200 rounded w-1/2 mb-2"></div>
                                    <div class="h-4 bg-accent-300/30 rounded w-20"></div>
                                </div>
                            </div>
                            @endfor
                        </div>
                        
                        <!-- Total -->
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <div class="h-3 bg-gray-300 rounded w-20"></div>
                                <div class="h-4 bg-gray-800 rounded w-24"></div>
                            </div>
                            <div class="h-10 bg-accent-300 rounded-lg w-full mt-4"></div>
                        </div>
                    </div>
                    
                    <!-- Floating card de pago -->
                    <div class="absolute -top-4 -left-4 bg-white rounded-xl shadow-lg p-3 border border-gray-100 float-animation-delay">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-brand-200/10 rounded-full flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-4 h-4 text-brand-200"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Pago recibido</span>
                                <span class="text-[10px] text-green-600 font-semibold">Transferencia</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 bg-accent-300/10 px-4 py-2 rounded-full mb-4">
                        <i data-lucide="shopping-cart" class="w-5 h-5 text-accent-300"></i>
                        <span class="text-sm font-semibold text-accent-300">Ventas y Pagos</span>
                    </div>
                    <h3 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Pedidos y pagos completos
                    </h3>
                    <p class="text-lg text-gray-600 font-inter mb-6">
                        Tus clientes agregan productos, seleccionan variantes y pagan fácilmente. Todo en un solo lugar, sin complicaciones.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-accent-300/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Múltiples métodos de pago</span>
                                <span class="text-sm text-gray-600">Transferencia bancaria, Nequi, Daviplata y contra entrega</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-accent-300/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Gestión de pedidos</span>
                                <span class="text-sm text-gray-600">Estados del pedido, historial completo y notificaciones automáticas</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-accent-300/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Comprobante de pago</span>
                                <span class="text-sm text-gray-600">Tus clientes suben su comprobante fácilmente. Verificación automática con IA</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-accent-300/10 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Cupones y promociones</span>
                                <span class="text-sm text-gray-600">Crea descuentos, ofertas especiales y campañas promocionales</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Característica 3: Reservas de Mesas -->
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 bg-blue-100 px-4 py-2 rounded-full mb-4">
                        <i data-lucide="calendar" class="w-5 h-5 text-blue-600"></i>
                        <span class="text-sm font-semibold text-blue-600">Reservas de Mesas</span>
                    </div>
                    <h3 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Sistema de reservas completo
                    </h3>
                    <p class="text-lg text-gray-600 font-inter mb-6">
                        Gestiona las reservas de mesas de forma automática. Tus clientes reservan online y tú controlas disponibilidad en tiempo real.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-blue-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Reservas online</span>
                                <span class="text-sm text-gray-600">Tus clientes reservan mesas directamente desde tu sitio web</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-blue-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Disponibilidad en tiempo real</span>
                                <span class="text-sm text-gray-600">Sistema automático que muestra solo las mesas disponibles</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-blue-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Gestión de mesas</span>
                                <span class="text-sm text-gray-600">Configura tus mesas, capacidad y horarios disponibles</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-blue-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Notificaciones automáticas</span>
                                <span class="text-sm text-gray-600">Recibe notificaciones de nuevas reservas por WhatsApp o email</span>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Wireframe de reservas -->
                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200">
                        <!-- Mapa o zonas -->
                        <div class="mb-4">
                            <div class="h-4 bg-gray-800 rounded w-32 mb-3"></div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-green-100 rounded p-2 border-2 border-green-300">
                                        <div class="h-2 bg-green-600 rounded w-full mb-1"></div>
                                        <div class="h-2 bg-green-500 rounded w-3/4"></div>
                                    </div>
                                    <div class="bg-blue-100 rounded p-2 border-2 border-blue-300">
                                        <div class="h-2 bg-blue-600 rounded w-full mb-1"></div>
                                        <div class="h-2 bg-blue-500 rounded w-3/4"></div>
                                    </div>
                                    <div class="bg-orange-100 rounded p-2 border-2 border-orange-300">
                                        <div class="h-2 bg-orange-600 rounded w-full mb-1"></div>
                                        <div class="h-2 bg-orange-500 rounded w-3/4"></div>
                                    </div>
                                    <div class="bg-purple-100 rounded p-2 border-2 border-purple-300">
                                        <div class="h-2 bg-purple-600 rounded w-full mb-1"></div>
                                        <div class="h-2 bg-purple-500 rounded w-3/4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Lista de zonas -->
                        <div class="space-y-2">
                            @for($i = 0; $i < 3; $i++)
                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                <div>
                                    <div class="h-3 bg-gray-800 rounded w-24 mb-1"></div>
                                    <div class="h-2 bg-gray-300 rounded w-32"></div>
                                </div>
                                <div class="h-3 bg-accent-300/30 rounded w-16"></div>
                            </div>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Floating card -->
                    <div class="absolute -bottom-4 -right-4 bg-white rounded-xl shadow-lg p-3 border border-gray-100 float-animation">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i data-lucide="truck" class="w-4 h-4 text-green-600"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Envío configurado</span>
                                <span class="text-[10px] text-gray-500">4 zonas activas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Característica 4: KiuBot - IA -->
            <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
                <!-- Wireframe de KiuBot -->
                <div class="relative order-2 lg:order-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200">
                        <!-- Chat interface mockup -->
                        <div class="mb-4">
                            <div class="h-4 bg-gray-800 rounded w-32 mb-3"></div>
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-4 border border-purple-200">
                                <!-- Chat messages -->
                                <div class="space-y-3">
                                    <div class="flex justify-end">
                                        <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-4 py-2 max-w-[70%]">
                                            <div class="h-2 bg-white/30 rounded w-20 mb-1"></div>
                                            <div class="h-2 bg-white/30 rounded w-16"></div>
                                        </div>
                                    </div>
                                    <div class="flex justify-start">
                                        <div class="bg-white border border-gray-200 rounded-2xl rounded-tl-none px-4 py-2 max-w-[70%]">
                                            <div class="h-2 bg-gray-800 rounded w-24 mb-1"></div>
                                            <div class="h-2 bg-gray-300 rounded w-32"></div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <div class="bg-purple-600 text-white rounded-2xl rounded-tr-none px-4 py-2 max-w-[70%]">
                                            <div class="h-2 bg-white/30 rounded w-28 mb-1"></div>
                                            <div class="h-2 bg-white/30 rounded w-20"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bot features -->
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-purple-100 rounded-lg p-2 border border-purple-200">
                                <div class="h-2 bg-purple-600 rounded w-full mb-1"></div>
                                <div class="h-2 bg-purple-400 rounded w-3/4"></div>
                            </div>
                            <div class="bg-indigo-100 rounded-lg p-2 border border-indigo-200">
                                <div class="h-2 bg-indigo-600 rounded w-full mb-1"></div>
                                <div class="h-2 bg-indigo-400 rounded w-3/4"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating card -->
                    <div class="absolute -top-4 -right-4 bg-white rounded-xl shadow-lg p-3 border border-gray-100 float-animation">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <i data-lucide="bot" class="w-4 h-4 text-purple-600"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">KiuBot activo</span>
                                <span class="text-[10px] text-gray-500">IA trabajando 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 bg-purple-100 px-4 py-2 rounded-full mb-4">
                        <i data-lucide="bot" class="w-5 h-5 text-purple-600"></i>
                        <span class="text-sm font-semibold text-purple-600">KiuBot - Inteligencia Artificial</span>
                    </div>
                    <h3 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Tu asistente virtual inteligente
                    </h3>
                    <p class="text-lg text-gray-600 font-inter mb-6">
                        KiuBot es tu asistente virtual con IA que automatiza procesos, verifica pagos y ayuda a tus clientes 24/7.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Verificación automática de pagos</span>
                                <span class="text-sm text-gray-600">KiuBot revisa comprobantes de pago automáticamente con IA para validar transferencias</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Atención al cliente 24/7</span>
                                <span class="text-sm text-gray-600">Chat inteligente que responde preguntas frecuentes y guía a tus clientes</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Recomendaciones inteligentes</span>
                                <span class="text-sm text-gray-600">Sugiere productos relacionados y aumenta tu conversión automáticamente</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Búsqueda inteligente</span>
                                <span class="text-sm text-gray-600">Entiende el lenguaje natural y encuentra productos aunque los nombres no coincidan exactamente</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Característica 5: Verificación -->
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center gap-2 bg-green-100 px-4 py-2 rounded-full mb-4">
                        <i data-lucide="shield-check" class="w-5 h-5 text-green-600"></i>
                        <span class="text-sm font-semibold text-green-600">Verificación de Tiendas</span>
                    </div>
                    <h3 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Sello de confianza y transparencia
                    </h3>
                    <p class="text-lg text-gray-600 font-inter mb-6">
                        El sello <strong class="text-green-600">&lt;Verificado por Linkiu&gt;</strong> reconoce a las tiendas que han superado nuestro proceso de validación y revisión interna. Genera confianza y credibilidad.
                    </p>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Verificación documental</span>
                                <span class="text-sm text-gray-600">Validamos identidad y datos de contacto para garantizar transparencia</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Cumplimiento de políticas</span>
                                <span class="text-sm text-gray-600">Revisamos que tu tienda cumpla con las políticas de uso responsable de Linkiu</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Mayor confianza</span>
                                <span class="text-sm text-gray-600">El sello genera credibilidad y aumenta la confianza de tus clientes en tu negocio</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-900 block">Revisión periódica</span>
                                <span class="text-sm text-gray-600">Realizamos revisiones continuas para mantener la integridad de la comunidad</span>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Wireframe de verificación -->
                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-200">
                        <!-- Badge de verificación -->
                        <div class="mb-4 text-center">
                            <div class="inline-flex items-center gap-2 bg-green-50 border-2 border-green-300 rounded-full px-6 py-3 mb-4">
                                <i data-lucide="shield-check" class="w-6 h-6 text-green-600"></i>
                                <div>
                                    <div class="h-3 bg-green-600 rounded w-32 mb-1"></div>
                                    <div class="h-2 bg-green-400 rounded w-24 mx-auto"></div>
                                </div>
                            </div>
                            <div class="h-4 bg-gray-800 rounded w-40 mx-auto mb-2"></div>
                            <div class="h-2 bg-gray-300 rounded w-32 mx-auto"></div>
                        </div>
                        
                        <!-- Lista de beneficios -->
                        <div class="space-y-2">
                            @for($i = 0; $i < 3; $i++)
                            <div class="flex items-center gap-3 p-2 bg-gray-50 rounded-lg">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="h-2 bg-gray-800 rounded w-full mb-1"></div>
                                    <div class="h-2 bg-gray-300 rounded w-3/4"></div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Floating card -->
                    <div class="absolute -bottom-4 -left-4 bg-white rounded-xl shadow-lg p-3 border border-gray-100 float-animation-delay">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i data-lucide="shield-check" class="w-4 h-4 text-green-600"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Verificado</span>
                                <span class="text-[10px] text-gray-500">Tienda confiable</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Ventajas con números -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-brand-200/10 rounded-2xl mb-4">
                        <i data-lucide="infinity" class="w-8 h-8 text-brand-200"></i>
                    </div>
                    <h3 class="font-satoshi text-3xl font-black text-gray-900 mb-2">Ilimitado</h3>
                    <p class="text-gray-600 font-inter">Productos, categorías, imágenes. Sin límites de ningún tipo.</p>
                </div>
                
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-accent-300/10 rounded-2xl mb-4">
                        <i data-lucide="zap" class="w-8 h-8 text-accent-300"></i>
                    </div>
                    <h3 class="font-satoshi text-3xl font-black text-gray-900 mb-2">Rápido</h3>
                    <p class="text-gray-600 font-inter">Tu tienda lista en minutos, no en semanas o meses.</p>
                </div>
                
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-2xl mb-4">
                        <i data-lucide="shield-check" class="w-8 h-8 text-green-600"></i>
                    </div>
                    <h3 class="font-satoshi text-3xl font-black text-gray-900 mb-2">Seguro</h3>
                    <p class="text-gray-600 font-inter">Pagos seguros, datos protegidos y respaldo automático.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-20 bg-gradient-to-br from-brand-200/5 to-accent-300/5">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-satoshi text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-6">
                ¿Listo para abrir tu restaurante digital?
            </h2>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto font-inter">
                Crea tu restaurante digital en minutos. Sin conocimientos técnicos. Sin complicaciones.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register.step1') }}" class="bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all hover:scale-105 inline-flex items-center justify-center gap-2">
                    <span>Crear mi restaurante gratis</span>
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
                <a href="{{ route('plans.index') }}" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-4 rounded-xl font-semibold text-lg transition-colors border-2 border-gray-200 inline-flex items-center justify-center gap-2">
                    <span>Ver planes y precios</span>
                    <i data-lucide="eye" class="w-5 h-5"></i>
                </a>
                <button @click="calendlyOpen = true" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-4 rounded-xl font-semibold text-lg transition-colors border-2 border-gray-200 inline-flex items-center justify-center gap-2">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                    <span>Agendar reunión</span>
                </button>
            </div>
            <p class="text-sm text-gray-500 mt-6">Sin tarjeta de crédito · 15 días gratis · Cancela cuando quieras</p>
        </div>
    </section>

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

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
    <style>
    [x-cloak] { display: none !important; }
    </style>
</body>
</html>
