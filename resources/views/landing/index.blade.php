<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Linkiu - Tu negocio online en minutos. Crea tu tienda digital sin complicaciones. Ideal para restaurantes y tiendas.">
    <meta name="keywords" content="tienda online, catálogo digital, menú digital, ecommerce, restaurantes, linkiu">
    <meta name="author" content="Linkiu">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Linkiu - Tu negocio online en minutos">
    <meta property="og:description" content="Olvídate de enviar fotos por WhatsApp. Con Linkiu tienes tu tienda lista para vender hoy.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://linkiu.bio">
    <meta property="og:image" content="{{ asset('assets/og-image.png') }}">
    
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
    
    <title>Linkiu - Tu negocio online en minutos</title>
    
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
                        // Grises de marca
                        'gray-brand': {
                            300: '#62748E',
                            600: '#050506',
                        },
                        // Azul de marca
                        brand: {
                            200: '#0007F7',
                            400: '#000684',
                        },
                        // Rojo de marca
                        accent: {
                            300: '#EA0038',
                            400: '#9E0024',
                        },
                        // Dark para fondos
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
    
    <style>
        /* Prevenir scroll horizontal en toda la página */
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }
        
        .font-satoshi { font-family: 'Satoshi', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        
        
        /* Hero gradient mejorado - muy sutil */
        .hero-gradient {
            background: #030712;
            position: relative;
        }
        .hero-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            background: #030712;
        }
        
        /* Steps gradient - mismo que hero */
        .steps-gradient {
            background: #030712;
            position: relative;
        }
        .steps-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            background: 
                radial-gradient(circle at 50% 0%, rgba(0, 7, 247, 0.06) 0%, transparent 80%),
                radial-gradient(circle at 100% 50%, rgba(234, 0, 56, 0.04) 0%, transparent 80%),
                radial-gradient(circle at 0% 100%, rgba(0, 6, 132, 0.05) 0%, transparent 80%);
            pointer-events: none;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
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
        
        /* Alpine.js x-cloak */
        [x-cloak] { display: none !important; }
        
        /* Dropdown menu */
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
        }
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
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
        
        /* Stores Carousel */
        .stores-carousel {
            overflow: hidden;
            mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        }
        
        .stores-carousel-track {
            display: flex;
            gap: 1rem;
            animation: scroll-horizontal 10s linear infinite;
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
                animation-duration: 10s;
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

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center relative overflow-hidden pb-72 lg:pb-96 pt-32">
        <!-- Video de fondo con mix-blend-lighten -->
        <video 
            autoplay 
            loop 
            muted 
            playsinline
            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 max-w-[600px] lg:max-w-[1300px] h-auto object-bottom mix-blend-lighten z-0"
            style="max-height: 70vh"
        >
            <source src="{{ asset('images-ui/bgherolinkiu2.mp4') }}" type="video/mp4">
        </video>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 lg:py-8 relative z-10">
            <div class="flex flex-col items-center">
                <!-- Texto Centrado -->
                <div class="text-center max-w-4xl lg:mb-8 w-full px-4 mt-8 lg:mt-0">
                    <div class="inline-flex items-center gap-2 bg-white/10 px-3 lg:px-4 py-1.5 lg:py-2 rounded-full mb-4 lg:mb-6 border border-white/10">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-white/80 text-sm lg:text-base font-inter">Más de 100 emprendedores ya venden con Linkiu</span>
                    </div>
                    
                    <h1 class="font-satoshi text-5xl sm:text-5xl lg:text-6xl font-black text-white mb-4 lg:mb-6">
                        Tu tienda online lista<br>
                        <span class="text-accent-300 mb-0 lg:mb-2">en 15 minutos. Sin código.</span>
                    </h1>
                    
                    <p class="text-sm sm:text-base lg:text-lg text-white mb-6 lg:mb-8 max-w-2xl mx-auto font-inter">
                        Deja de perder ventas por enviar fotos por WhatsApp. Crea tu tienda profesional, 
                        recibe pagos en línea y automatiza tus envíos. 
                        <span class="text-accent-300 font-semibold">Prueba gratis {{ $maxTrialDays }} días sin tarjeta</span>.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 lg:gap-4 justify-center mb-8 lg:mb-12 w-full sm:w-auto mx-auto">
                        <button onclick="if(typeof fbq !== 'undefined') { fbq('track', 'Lead', {value: 0, currency: 'COP'}); } window.location.href='{{ route('register.step1') }}';" class="bg-accent-300 hover:bg-accent-400 text-white px-6 lg:px-8 py-3 lg:py-4 rounded-xl font-bold text-base lg:text-lg transition-all hover:scale-105 flex items-center justify-center gap-2 w-full sm:w-auto">
                            <span>Crear mi tienda gratis</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </button>
                        <button @click="calendlyOpen = true" class="bg-white/10 hover:bg-white/20 text-white px-6 lg:px-8 py-3 lg:py-4 rounded-xl font-semibold text-base lg:text-lg transition-colors flex items-center justify-center gap-2 border border-white/20 backdrop-blur-none w-full sm:w-auto">
                            <i data-lucide="calendar" class="w-5 h-5"></i>
                            <span>Ver demo en vivo</span>
                        </button>
                    </div>
                </div>

                
                
            </div>
        </div>
    </section>

    <!-- Tiendas que confían - Después del Hero -->
    <x-featured-stores-carousel :stores="$featuredStores ?? collect([])" />

    <!-- Dolores Section -->
    <section class="py-8 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                    ¿Estás perdiendo ventas por esto?
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto font-inter">
                    Estos son los problemas que más frustran a los emprendedores que venden online
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Dolor 1 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200 card-hover">
                    <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="message-circle" class="w-6 h-6 text-accent-300"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-gray-900 mb-2">Pierdes clientes en WhatsApp</h3>
                    <p class="text-gray-600 text-sm font-inter">Envías 20 fotos y tu cliente se confunde. No puede comparar precios ni agregar al carrito.</p>
                </div>
                
                <!-- Dolor 2 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200 card-hover">
                    <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="file-text" class="w-6 h-6 text-accent-300"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-gray-900 mb-2">Tu catálogo PDF no funciona</h3>
                    <p class="text-gray-600 text-sm font-inter">Nadie lo descarga. Tarda mucho en abrir y se ve terrible en el celular. Pierdes ventas.</p>
                </div>
                
                <!-- Dolor 3 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200 card-hover">
                    <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="wallet" class="w-6 h-6 text-accent-300"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-gray-900 mb-2">Una web cuesta miles de pesos</h3>
                    <p class="text-gray-600 text-sm font-inter">Necesitas pagar a un diseñador, un programador y mantenerla cada mes. Es muy caro.</p>
                </div>
                
                <!-- Dolor 4 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-200 card-hover">
                    <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center mb-4">
                        <i data-lucide="brain" class="w-6 h-6 text-accent-300"></i>
                    </div>
                    <h3 class="font-satoshi font-bold text-gray-900 mb-2">Las plataformas son complicadas</h3>
                    <p class="text-gray-600 text-sm font-inter">Tienes que aprender a usarlas, configurar mil cosas y no tienes tiempo para eso.</p>
                </div>
            </div>
            
            <!-- Solución -->
            <div class="mt-12 bg-gradient-to-r from-brand-200 to-brand-400 rounded-3xl p-8 sm:p-12 text-center text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                <div class="relative z-10">
                    <h3 class="font-satoshi text-2xl sm:text-3xl font-black mb-4">Linkiu resuelve todo esto en minutos</h3>
                    <p class="text-lg text-blue-100 mb-6 max-w-2xl mx-auto font-inter">
                        Tu tienda profesional lista en 15 minutos. Sin código, sin complicaciones, sin gastos grandes. 
                        <span class="font-semibold">Empieza gratis y paga solo cuando vendas</span>.
                    </p>
                    <a href="{{ route('register.step1') }}" onclick="if(typeof fbq !== 'undefined') { fbq('track', 'Lead', {value: 0, currency: 'COP'}); }" class="inline-flex items-center gap-2 bg-white text-brand-400 px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-50 transition-all hover:scale-105">
                        <span>Crear mi tienda gratis</span>
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Funciones Section - Bento Grid Mejorado -->
    <section id="funciones" class="py-16 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block bg-brand-200/10 text-brand-200 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    Funcionalidades
                </span>
                <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                    Todo lo que necesitas para vender
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto font-inter">
                    Herramientas pensadas para emprendedores, no para ingenieros
                </p>
            </div>
            
            <!-- Bento Grid Mejorado -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <!-- Card 1 - Grande -->
                <div class="bg-gradient-to-br from-brand-200 to-brand-400 rounded-2xl p-6 text-white col-span-2 row-span-2 card-hover flex flex-col justify-between min-h-[320px]">
                    <div>
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-4">
                            <i data-lucide="package" class="w-7 h-7"></i>
                        </div>
                        <h3 class="font-satoshi text-2xl font-bold mb-2">Gestión de Productos</h3>
                        <p class="text-blue-100 font-inter">Catálogo ilimitado, fotos, variantes (tallas, colores), precios flexibles y categorías organizadas.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm">Ilimitados</span>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm">Variantes</span>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm">Bajo pedido</span>
                    </div>
                </div>
                
                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 card-hover flex flex-col justify-between min-h-[150px]">
                    <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center mb-3">
                        <i data-lucide="shopping-cart" class="w-5 h-5 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-1">Pedidos</h3>
                        <p class="text-gray-600 text-sm font-inter">Carrito y seguimiento</p>
                    </div>
                </div>
                
                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 card-hover flex flex-col justify-between min-h-[150px]">
                    <div class="w-11 h-11 bg-purple-100 rounded-xl flex items-center justify-center mb-3">
                        <i data-lucide="credit-card" class="w-5 h-5 text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-1">Pagos</h3>
                        <p class="text-gray-600 text-sm font-inter">Nequi, tarjetas, transferencias</p>
                    </div>
                </div>
                
                <!-- Card 4 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 card-hover flex flex-col justify-between min-h-[150px]">
                    <div class="w-11 h-11 bg-orange-100 rounded-xl flex items-center justify-center mb-3">
                        <i data-lucide="truck" class="w-5 h-5 text-orange-600"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-1">Envíos</h3>
                        <p class="text-gray-600 text-sm font-inter">Zonas y tarifas</p>
                    </div>
                </div>
                
                <!-- Card 5 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 card-hover flex flex-col justify-between min-h-[150px]">
                    <div class="w-11 h-11 bg-pink-100 rounded-xl flex items-center justify-center mb-3">
                        <i data-lucide="palette" class="w-5 h-5 text-pink-600"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-1">Diseño</h3>
                        <p class="text-gray-600 text-sm font-inter">Tu marca, tus colores</p>
                    </div>
                </div>
                
                <!-- Card 6 - WhatsApp (mediana) -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-5 text-white col-span-2 card-hover flex items-center gap-5 min-h-[150px]">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="message-circle" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi text-xl font-bold mb-1">Notificaciones WhatsApp</h3>
                        <p class="text-green-100 font-inter text-sm">Mantén a tus clientes informados automáticamente sobre sus pedidos</p>
                    </div>
                </div>
                
                <!-- Card 7 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 card-hover flex flex-col justify-between min-h-[150px]">
                    <div class="w-11 h-11 bg-cyan-100 rounded-xl flex items-center justify-center mb-3">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 text-cyan-600"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-1">Dashboard</h3>
                        <p class="text-gray-600 text-sm font-inter">Métricas y reportes</p>
                    </div>
                </div>
                
                <!-- Card 8 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 card-hover flex flex-col justify-between min-h-[150px]">
                    <div class="w-11 h-11 bg-yellow-100 rounded-xl flex items-center justify-center mb-3">
                        <i data-lucide="tag" class="w-5 h-5 text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-1">Cupones</h3>
                        <p class="text-gray-600 text-sm font-inter">Descuentos y promos</p>
                    </div>
                </div>
                
                <!-- Card 9 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 card-hover flex flex-col justify-between min-h-[150px]">
                    <div class="w-11 h-11 bg-indigo-100 rounded-xl flex items-center justify-center mb-3">
                        <i data-lucide="box" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-1">Inventario</h3>
                        <p class="text-gray-600 text-sm font-inter">Stock en tiempo real</p>
                    </div>
                </div>
                
                <!-- Card 10 -->
                <div class="bg-white rounded-2xl p-5 border border-gray-200 card-hover flex flex-col justify-between min-h-[150px]">
                    <div class="w-11 h-11 bg-rose-100 rounded-xl flex items-center justify-center mb-3">
                        <i data-lucide="qr-code" class="w-5 h-5 text-rose-600"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-1">QR Mesas</h3>
                        <p class="text-gray-600 text-sm font-inter">Restaurantes</p>
                    </div>
                </div>
                
                <!-- Card 11 - Accent (mediana) -->
                <div class="bg-gradient-to-br from-accent-300 to-accent-400 rounded-2xl p-5 text-white col-span-2 card-hover flex items-center gap-5 min-h-[150px]">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="calendar" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <h3 class="font-satoshi text-xl font-bold mb-1">Reservas Online</h3>
                        <p class="text-red-100 font-inter text-sm">Tus clientes reservan mesa sin necesidad de llamar</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview Section -->
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-16">
                <span class="inline-block bg-brand-200/10 text-brand-200 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    Todo en un solo lugar
                </span>
                <h2 class="font-satoshi text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                    Controla tus ventas sin complicarte
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto font-inter">
                    Ve todos tus pedidos, pagos recibidos y ventas del día en tiempo real. 
                    <span class="font-semibold text-gray-900">Sin abrir 5 apps diferentes</span>. 
                    Todo desde tu panel de Linkiu.
                </p>
            </div>
            
            <!-- Mockup con cards flotantes - Centrado -->
            <div class="relative max-w-2xl lg:max-w-7xl w-full mt-2 lg:mt-8 mx-auto">
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
                                    linkiu.bio/tutienda
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-14 bg-brand-200/10 rounded-xl flex items-center justify-center">
                                        <i data-lucide="store" class="w-7 h-7 text-brand-200"></i>
                                    </div>
                                    <div>
                                        <div class="h-4 bg-gray-800 rounded w-36 mb-2"></div>
                                        <div class="h-3 bg-gray-200 rounded w-28"></div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <div class="w-full h-24 bg-gradient-to-br from-gray-200 to-gray-100 rounded-lg mb-2"></div>
                                        <div class="h-3 bg-gray-300 rounded w-3/4 mb-1"></div>
                                        <div class="h-4 bg-accent-300/20 rounded w-1/2"></div>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl p-3">
                                        <div class="w-full h-24 bg-gradient-to-br from-gray-200 to-gray-100 rounded-lg mb-2"></div>
                                        <div class="h-3 bg-gray-300 rounded w-3/4 mb-1"></div>
                                        <div class="h-4 bg-accent-300/20 rounded w-1/2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Cards -->
                    <div class="absolute -top-4 -right-4 bg-white rounded-xl shadow-xl p-3 float-animation border border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i data-lucide="check" class="w-5 h-5 text-green-600"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">¡Nuevo pedido!</span>
                                <span class="text-xs text-gray-500">Hace 2 min</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-8 -left-6 bg-white rounded-xl shadow-xl p-3 float-animation-delay border border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-brand-200/10 rounded-full flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-5 h-5 text-brand-200"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Pago recibido</span>
                                <span class="text-xs text-green-600 font-semibold">$85.000</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute top-1/2 -left-8 bg-white rounded-xl shadow-xl p-3 float-animation-delay-2 border border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                <i data-lucide="trending-up" class="w-5 h-5 text-purple-600"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Ventas del día</span>
                                <span class="text-xs text-purple-600 font-semibold">+23%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute bottom-1/3 -right-24 bg-white rounded-xl shadow-xl p-3 float-animation border border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-accent-300/10 rounded-full flex items-center justify-center">
                                <i data-lucide="message-circle" class="w-5 h-5 text-accent-300"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">WhatsApp</span>
                                <span class="text-xs text-gray-500">Notificación enviada</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-6 -right-8 bg-white rounded-xl shadow-xl p-3 float-animation-delay border border-gray-100 hidden xl:block">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                <i data-lucide="package" class="w-5 h-5 text-orange-600"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Inventario</span>
                                <span class="text-xs text-gray-500">5 productos bajos</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -top-16 left-1/4 bg-white rounded-xl shadow-xl p-3 float-animation-delay-2 border border-gray-100 hidden xl:block">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-cyan-100 rounded-full flex items-center justify-center">
                                <i data-lucide="users" class="w-5 h-5 text-cyan-600"></i>
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900 block">Visitantes</span>
                                <span class="text-xs text-cyan-600 font-semibold">124 hoy</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Verticales Section -->
    <section class="py-12 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block bg-brand-200/10 text-brand-200 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    Para tu tipo de negocio
                </span>
                <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                    Hecho para negocios como el tuyo
                </h2>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Restaurantes -->
                <div id="restaurantes" class="bg-white rounded-3xl overflow-hidden border border-gray-200 card-hover">
                    <div class="bg-gradient-to-r from-accent-300 to-accent-400 p-8 text-white">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                <i data-lucide="utensils" class="w-8 h-8"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi text-2xl font-black">Restaurantes</h3>
                                <p class="text-red-100 font-inter">Menú digital + Pedidos + Reservas</p>
                            </div>
                        </div>
                        <p class="text-red-100 font-inter">
                            Tus clientes ven el menú, hacen su pedido y tú solo envías el pedido.
                        </p>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-accent-300/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="qr-code" class="w-5 h-5 text-accent-300"></i>
                                </div>
                                <div>
                                    <h4 class="font-satoshi font-bold text-gray-900">QR por mesa</h4>
                                    <p class="text-sm text-gray-600 font-inter">Cliente pide desde su celular</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-accent-300/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="calendar" class="w-5 h-5 text-accent-300"></i>
                                </div>
                                <div>
                                    <h4 class="font-satoshi font-bold text-gray-900">Reservas online</h4>
                                    <p class="text-sm text-gray-600 font-inter">Sin llamadas telefónicas</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-accent-300/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="refresh-cw" class="w-5 h-5 text-accent-300"></i>
                                </div>
                                <div>
                                    <h4 class="font-satoshi font-bold text-gray-900">Menú actualizado</h4>
                                    <p class="text-sm text-gray-600 font-inter">Cambia precios al instante</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-accent-300/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="bell" class="w-5 h-5 text-accent-300"></i>
                                </div>
                                <div>
                                    <h4 class="font-satoshi font-bold text-gray-900">Alertas de pedido</h4>
                                    <p class="text-sm text-gray-600 font-inter">Notificación instantánea</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Ecommerce -->
                <div id="tiendas" class="bg-white rounded-3xl overflow-hidden border border-gray-200 card-hover">
                    <div class="bg-gradient-to-r from-brand-200 to-brand-400 p-8 text-white">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                <i data-lucide="shopping-bag" class="w-8 h-8"></i>
                            </div>
                            <div>
                                <h3 class="font-satoshi text-2xl font-black">Ecommerce</h3>
                                <p class="text-blue-100 font-inter">Catálogo + Carrito + Inventario</p>
                            </div>
                        </div>
                        <p class="text-blue-100 font-inter">
                            Vende mientras duermes. Tu tienda online abierta 24/7 recibiendo pedidos y pagos automáticos. 
                            <span class="font-semibold">Sin estar pendiente del celular</span>.
                        </p>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-brand-200/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="box" class="w-5 h-5 text-brand-200"></i>
                                </div>
                                <div>
                                    <h4 class="font-satoshi font-bold text-gray-900">Inventario</h4>
                                    <p class="text-sm text-gray-600 font-inter">Sabe cuánto tienes en stock</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-brand-200/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="tag" class="w-5 h-5 text-brand-200"></i>
                                </div>
                                <div>
                                    <h4 class="font-satoshi font-bold text-gray-900">Cupones</h4>
                                    <p class="text-sm text-gray-600 font-inter">Aumenta ventas con descuentos</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-brand-200/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="layers" class="w-5 h-5 text-brand-200"></i>
                                </div>
                                <div>
                                    <h4 class="font-satoshi font-bold text-gray-900">Variantes</h4>
                                    <p class="text-sm text-gray-600 font-inter">Tallas, colores, todo en un producto</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-brand-200/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="clock" class="w-5 h-5 text-brand-200"></i>
                                </div>
                                <div>
                                    <h4 class="font-satoshi font-bold text-gray-900">Bajo pedido</h4>
                                    <p class="text-sm text-gray-600 font-inter">Vende sin tener inventario</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cómo Funciona Section - Con wireframes y mejor gradient -->
    <section id="como-funciona" class="py-12 lg:py-20 steps-gradient relative overflow-visible">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block bg-white/10 text-white px-4 py-1 rounded-full text-sm font-semibold mb-4 border border-white/20">
                    Súper fácil
                </span>
                <h2 class="font-satoshi text-5xl sm:text-4xl font-black text-white mb-4">
                    3 pasos para empezar a vender
                </h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Paso 1 -->
                <div class="bg-white/5 rounded-3xl p-6 border border-white/10">
                    <div class="bg-white rounded-2xl p-4 mb-6 shadow-xl">
                        <!-- Wireframe registro -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-8 h-8 bg-brand-200 rounded-lg"></div>
                                <div class="h-3 bg-gray-200 rounded w-20"></div>
                            </div>
                            <div class="h-10 bg-gray-100 rounded-lg border-2 border-gray-200"></div>
                            <div class="h-10 bg-gray-100 rounded-lg border-2 border-gray-200"></div>
                            <div class="h-10 bg-accent-300 rounded-lg"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-accent-300 rounded-full text-white font-bold mb-3">1</div>
                        <h3 class="font-satoshi text-3xl font-bold text-white mb-2">Regístrate</h3>
                        <p class="text-gray-400 font-inter">Datos básicos y elige tu plan. Solo 2 minutos.</p>
                    </div>
                </div>
                
                <!-- Paso 2 -->
                <div class="bg-white/5 backdrop-blur-sm rounded-3xl p-6 border border-white/10">
                    <div class="bg-white rounded-2xl p-4 mb-6 shadow-xl">
                        <!-- Wireframe personalización -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between mb-2">
                                <div class="h-3 bg-gray-300 rounded w-24"></div>
                                <div class="flex gap-1">
                                    <div class="w-4 h-4 bg-brand-200 rounded-full"></div>
                                    <div class="w-4 h-4 bg-accent-300 rounded-full"></div>
                                    <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                                </div>
                            </div>
                            <div class="w-16 h-16 bg-gray-200 rounded-xl mx-auto"></div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="h-16 bg-gray-100 rounded-lg"></div>
                                <div class="h-16 bg-gray-100 rounded-lg"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-accent-300 rounded-full text-white font-bold mb-3">2</div>
                        <h3 class="font-satoshi text-3xl font-bold text-white mb-2">Personaliza</h3>
                        <p class="text-gray-400 font-inter">Logo, colores y productos. En 10 minutos listo.</p>
                    </div>
                </div>
                
                <!-- Paso 3 -->
                <div class="bg-white/5 rounded-3xl p-6 border border-white/10">
                    <div class="bg-white rounded-2xl p-4 mb-6 shadow-xl">
                        <!-- Wireframe tienda funcionando -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="h-3 bg-gray-300 rounded w-20"></div>
                                <div class="flex items-center gap-1">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <div class="h-2 bg-green-200 rounded w-10"></div>
                                </div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-3 flex items-center gap-2">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <i data-lucide="check" class="w-4 h-4 text-white"></i>
                                </div>
                                <div>
                                    <div class="h-2 bg-green-300 rounded w-16 mb-1"></div>
                                    <div class="h-3 bg-green-600 rounded w-12"></div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="h-8 bg-gray-100 rounded flex-1"></div>
                                <div class="h-8 bg-accent-300 rounded w-20"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 bg-accent-300 rounded-full text-white font-bold mb-3">3</div>
                        <h3 class="font-satoshi text-3xl font-bold text-white mb-2">¡Vende!</h3>
                        <p class="text-gray-400 font-inter">Comparte tu link y empieza a recibir pedidos.</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('register.step1') }}" onclick="if(typeof fbq !== 'undefined') { fbq('track', 'Lead', {value: 0, currency: 'COP'}); }" class="inline-flex items-center gap-2 bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-colors">
                    <span>Crear mi tienda gratis</span>
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
                <p class="text-sm text-gray-500 mt-4">Sin tarjeta de crédito · 15 días gratis · Cancela cuando quieras</p>
            </div>
        </div>
    </section>

    <!-- Sección: Verificación de Tiendas -->
    <section class="py-12 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-4 lg:p-8 md:p-12 border border-gray-200 shadow-lg">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 bg-green-100 px-4 py-2 rounded-full mb-4">
                            <i data-lucide="shield-check" class="w-5 h-5 text-green-600"></i>
                            <span class="text-sm font-semibold text-green-600">Seguridad y Confianza</span>
                        </div>
                        <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                            Verificación de tiendas para mayor seguridad
                        </h2>
                        <p class="text-lg text-gray-600 font-inter mb-6">
                            Similar a las verificaciones de Facebook, Linkiu ofrece un proceso de verificación para tiendas que demuestren ser negocios legítimos. El sello <strong class="text-gray-900">Verificado por Linkiu</strong> representa transparencia, confianza y compromiso con el buen uso de la plataforma.
                        </p>
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                                <div>
                                    <p class="font-semibold text-blue-900 mb-1">Requisito para solicitar verificación</p>
                                    <p class="text-sm text-blue-700">Tu tienda debe estar activa con Linkiu mínimo <strong>5 meses</strong> antes de poder solicitar el proceso de verificación.</p>
                                </div>
                            </div>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900 block">Confirmación de identidad</span>
                                    <span class="text-sm text-gray-600">Verificamos que el negocio es real y legítimo mediante documentación</span>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900 block">Cumplimiento de políticas</span>
                                    <span class="text-sm text-gray-600">Aseguramos que cumple las políticas de publicación y uso responsable</span>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900 block">Mayor confianza</span>
                                    <span class="text-sm text-gray-600">El sello verificado genera más confianza en tus clientes</span>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900 block">Comunidad confiable</span>
                                    <span class="text-sm text-gray-600">Construimos una comunidad de negocios verificados y confiables</span>
                                </div>
                            </li>
                        </ul>
                        <p class="text-sm text-gray-500 font-inter mt-6 italic">
                            El sello verificado no implica aval financiero ni garantía comercial, pero sí respalda que el negocio ha completado un proceso de verificación documental y de cumplimiento básico.
                        </p>
                    </div>
                    <div class="relative">
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-2 lg:p-8 border border-green-100">
                            <div class="flex items-center justify-center mb-6">
                                <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center shadow-xl">
                                    <i data-lucide="shield-check" class="w-12 h-12 text-white"></i>
                                </div>
                            </div>
                            <div class="text-center space-y-4">
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                            </div>
                                            <div>
                                                <div class="h-3 bg-gray-800 rounded w-24 mb-1"></div>
                                                <div class="h-2 bg-gray-200 rounded w-16"></div>
                                            </div>
                                        </div>
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 font-inter">Tienda verificada</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                            </div>
                                            <div>
                                                <div class="h-3 bg-gray-800 rounded w-24 mb-1"></div>
                                                <div class="h-2 bg-gray-200 rounded w-16"></div>
                                            </div>
                                        </div>
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 font-inter">Tienda verificada</div>
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                            </div>
                                            <div>
                                                <div class="h-3 bg-gray-800 rounded w-24 mb-1"></div>
                                                <div class="h-2 bg-gray-200 rounded w-16"></div>
                                            </div>
                                        </div>
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 font-inter">Tienda verificada</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 lg:py-24 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block bg-brand-200/10 text-brand-200 px-4 py-1 rounded-full text-sm font-semibold mb-4">
                    Preguntas Frecuentes
                </span>
                <h2 class="font-satoshi text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                    Resolvemos tus dudas
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto font-inter">
                    Todo lo que necesitas saber sobre Linkiu antes de empezar
                </p>
            </div>

            <div class="space-y-4" x-data="{ openIndex: null }">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 0 ? null : 0" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Cuánto cuesta Linkiu?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 0 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 0" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">Linkiu tiene un planes accesibles para cualquier negocio. Todos los planes incluyen {{ $maxTrialDays ?? 15 }} días gratis para probar sin tarjeta de crédito. No hay comisiones por venta. <a href="{{ route('plans.index') }}" class="text-brand-200 font-semibold hover:underline">Ver todos los planes</a>.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 1 ? null : 1" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Necesito saber programar o tener conocimientos técnicos?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 1" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">No, para nada. Linkiu está diseñado para emprendedores, no para programadores. Puedes crear tu tienda completa en 15 minutos sin escribir una línea de código. Todo es visual y muy fácil de usar.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 2 ? null : 2" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Puedo probar antes de pagar?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 2" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">Sí, todos los planes incluyen {{ $maxTrialDays ?? 15 }} días gratis para probar todas las funcionalidades. No necesitas tarjeta de crédito para empezar. Si no te convence, puedes cancelar sin pagar nada.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 3 ? null : 3" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Cuánto tiempo tardo en tener mi tienda lista?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 3 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 3" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">En 15 minutos puedes tener tu tienda básica funcionando. Solo necesitas agregar tus productos, configurar pagos y envíos. La mayoría de nuestros usuarios tienen su tienda lista y vendiendo el mismo día.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 4 ? null : 4" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Linkiu cobra comisiones por mis ventas?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 4 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 4" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">No, Linkiu no cobra comisiones por venta. Solo pagas tu plan mensual fijo. El 100% de tus ventas es tuyo. Los costos de procesamiento de pagos dependen de los métodos que configures y son gestionados directamente por los proveedores de esos servicios.</p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 5 ? null : 5" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Puedo cancelar cuando quiera?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 5 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 5" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">Sí, puedes cancelar tu plan en cualquier momento sin penalizaciones ni preguntas. No hay contratos de permanencia. Si cancelas, tu tienda seguirá activa hasta el final del período que pagaste.</p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 6 ? null : 6" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Funciona para mi tipo de negocio?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 6 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 6" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">Linkiu funciona para cualquier negocio que venda productos o servicios: tiendas de ropa, restaurantes, cafeterías, tecnología, accesorios, artesanías, servicios profesionales y más. Tenemos funciones específicas para restaurantes (QR, reservas) y ecommerce.</p>
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 7 ? null : 7" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Cómo recibo los pagos de mis clientes?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 7 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 7" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">Tú eliges qué métodos de pago habilitar en tu tienda: Nequi, tarjetas de crédito/débito, transferencias bancarias, efectivo contra entrega, etc. Los pagos llegan directamente a las cuentas que configures. Puedes activar o desactivar métodos de pago desde tu panel de administración.</p>
                    </div>
                </div>

                <!-- FAQ 9 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 8 ? null : 8" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Qué pasa si tengo problemas o necesito ayuda?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 8 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 8" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">Tienes soporte por email y WhatsApp. Los planes pagos incluyen soporte prioritario con respuesta en menos de 48 horas. También tenemos guías paso a paso y videos tutoriales para ayudarte a configurar todo.</p>
                    </div>
                </div>

                <!-- FAQ 10 -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="openIndex = openIndex === 9 ? null : 9" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <span class="font-satoshi font-bold text-gray-900 text-lg">¿Mis datos y los de mis clientes están seguros?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500 transition-transform" :class="openIndex === 9 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openIndex === 9" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 font-inter">Sí, tomamos la seguridad muy en serio. Todos los datos están encriptados y protegidos. Los pagos se procesan de forma segura a través de los métodos que configures. Cumplimos con las normativas de protección de datos y nunca compartimos tu información.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-12 lg:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-satoshi text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-6">
                ¿Listo para <span class="text-accent-300">vender online</span>?
            </h2>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto font-inter">
                Tu competencia ya está vendiendo online. No te quedes atrás.
            </p>
            <a href="{{ route('register.step1') }}" onclick="if(typeof fbq !== 'undefined') { fbq('track', 'Lead', {value: 0, currency: 'COP'}); }" class="inline-flex items-center gap-2 bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-colors">
                <span>Empezar ahora</span>
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
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

    <!-- Footer -->
    <x-public-footer />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>
