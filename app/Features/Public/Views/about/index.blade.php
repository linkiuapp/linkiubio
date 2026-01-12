<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nosotros - Linkiu - Conoce más sobre Linkiu, nuestra misión, visión y valores">
    <title>Nosotros - Linkiu</title>
    
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

    <!-- Hero Section -->
    <section class="pt-40 pb-4 lg:pb-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="font-satoshi text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 mb-4">
                    Nosotros
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 font-inter max-w-3xl mx-auto">
                    Conoce más sobre Linkiu, nuestra misión, visión y el equipo que hace posible que tu negocio crezca en línea.
                </p>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="pb-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Sección Quiénes Somos -->
            <section class="mb-20">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-6">
                            Quiénes Somos
                        </h2>
                        <div class="space-y-4 px-2 lg:px-0 text-gray-600 font-inter leading-relaxed text-justify">
                            <p>
                                Linkiu es una plataforma innovadora diseñada para ayudar a negocios de todos los tamaños a crear y gestionar su presencia en línea. Nuestro objetivo es democratizar el comercio electrónico y hacer que cualquier persona pueda iniciar su tienda online sin necesidad de conocimientos técnicos complejos.
                            </p>
                            <p>
                                Fundada con la visión de simplificar el proceso de creación de tiendas online, Linkiu combina la facilidad de uso con funcionalidades potentes que permiten a nuestros usuarios destacar en el mercado digital.
                            </p>
                            <p>
                                Ya sea que tengas un restaurante, una tienda de ropa, accesorios o cualquier otro negocio, Linkiu te proporciona todas las herramientas necesarias para vender en línea de manera eficiente y profesional.
                            </p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-brand-200/10 to-accent-300/10 rounded-3xl p-2 lg:p-12 text-center">
                        <div class="bg-white rounded-2xl p-8 shadow-lg">
                            <!-- Wireframe de tienda online -->
                            <div class="mb-6">
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                    <!-- Browser mockup -->
                                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                        <div class="bg-gray-100 px-3 py-2 flex items-center gap-2">
                                            <div class="flex gap-1">
                                                <div class="w-2 h-2 bg-accent-300 rounded-full"></div>
                                                <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                            </div>
                                            <div class="flex-1 bg-white rounded px-2 py-1 text-[10px] text-gray-500 text-center">
                                                linkiu.bio/tutienda
                                            </div>
                                        </div>
                                        <div class="p-3 space-y-2">
                                            <!-- Header wireframe -->
                                            <div class="h-8 bg-gradient-to-r from-brand-200/20 to-accent-300/20 rounded"></div>
                                            <!-- Product grid wireframe -->
                                            <div class="grid grid-cols-2 gap-2">
                                                <div class="space-y-1">
                                                    <div class="h-16 bg-gray-200 rounded"></div>
                                                    <div class="h-2 bg-gray-300 rounded w-3/4"></div>
                                                    <div class="h-2 bg-accent-300/30 rounded w-1/2"></div>
                                                </div>
                                                <div class="space-y-1">
                                                    <div class="h-16 bg-gray-200 rounded"></div>
                                                    <div class="h-2 bg-gray-300 rounded w-3/4"></div>
                                                    <div class="h-2 bg-accent-300/30 rounded w-1/2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3 class="font-satoshi text-2xl font-black text-gray-900 mb-4">Tu Tienda Online</h3>
                            <p class="text-gray-600 font-inter">
                                Crea, gestiona y haz crecer tu negocio en línea con todas las herramientas que necesitas en un solo lugar.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Misión y Visión -->
            <section class="mb-20">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Misión -->
                    <div class="bg-gradient-to-br from-brand-200/5 to-brand-200/10 rounded-2xl p-8 border border-brand-200/20">
                        <div class="w-14 h-14 bg-brand-200 rounded-xl flex items-center justify-center mb-6">
                            <i data-lucide="target" class="w-7 h-7 text-white"></i>
                        </div>
                        <h3 class="font-satoshi text-2xl font-black text-gray-900 mb-4">Nuestra Misión</h3>
                        <p class="text-gray-600 font-inter leading-relaxed">
                            Facilitar el acceso al comercio electrónico para todos los negocios, independientemente de su tamaño o experiencia técnica. Queremos ser la plataforma que empodere a emprendedores y empresas para alcanzar el éxito en el mundo digital.
                        </p>
                    </div>

                    <!-- Visión -->
                    <div class="bg-gradient-to-br from-accent-300/5 to-accent-300/10 rounded-2xl p-8 border border-accent-300/20">
                        <div class="w-14 h-14 bg-accent-300 rounded-xl flex items-center justify-center mb-6">
                            <i data-lucide="eye" class="w-7 h-7 text-white"></i>
                        </div>
                        <h3 class="font-satoshi text-2xl font-black text-gray-900 mb-4">Nuestra Visión</h3>
                        <p class="text-gray-600 font-inter leading-relaxed">
                            Ser la plataforma líder en Latinoamérica para la creación y gestión de tiendas online, reconocida por su innovación, facilidad de uso y compromiso con el éxito de nuestros usuarios. Aspiramos a convertirnos en el socio tecnológico de confianza para miles de negocios.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Valores -->
            <section class="mb-20">
                <div class="text-center mb-12">
                    <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Nuestros Valores
                    </h2>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto">
                        Los principios que guían todo lo que hacemos en Linkiu
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Valor 1 -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="heart" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Pasión</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Amamos lo que hacemos y nos apasiona ayudar a nuestros usuarios a alcanzar sus objetivos.
                        </p>
                    </div>

                    <!-- Valor 2 -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="zap" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Innovación</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Constantemente buscamos nuevas formas de mejorar y ofrecer las mejores soluciones tecnológicas.
                        </p>
                    </div>

                    <!-- Valor 3 -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="users" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Compromiso</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Estamos comprometidos con el éxito de nuestros usuarios y su satisfacción es nuestra prioridad.
                        </p>
                    </div>

                    <!-- Valor 4 -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-gray-300 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                            <i data-lucide="shield-check" class="w-6 h-6 text-orange-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Confianza</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Construimos relaciones basadas en la transparencia, honestidad y confianza mutua.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Por qué elegirnos -->
            <section class="mb-20">
                <div class="text-center mb-12">
                    <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        ¿Por qué elegir Linkiu?
                    </h2>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto">
                        Descubre las ventajas de trabajar con nosotros
                    </p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Ventaja 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-accent-300/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="mouse-pointer-click" class="w-8 h-8 text-accent-300"></i>
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-3">Fácil de Usar</h3>
                        <p class="text-gray-600 font-inter leading-relaxed">
                            No necesitas conocimientos técnicos. Nuestra plataforma está diseñada para que cualquiera pueda crear su tienda en minutos.
                        </p>
                    </div>

                    <!-- Ventaja 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-brand-200/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="layers" class="w-8 h-8 text-brand-200"></i>
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-3">Todo en Uno</h3>
                        <p class="text-gray-600 font-inter leading-relaxed">
                            Gestión de productos, pedidos, inventario, pagos y más. Todo lo que necesitas en una sola plataforma integrada.
                        </p>
                    </div>

                    <!-- Ventaja 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <i data-lucide="headphones" class="w-8 h-8 text-green-500"></i>
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-3">Soporte Dedicado</h3>
                        <p class="text-gray-600 font-inter leading-relaxed">
                            Estamos aquí para ayudarte. Nuestro equipo de soporte está disponible para resolver cualquier duda que tengas.
                        </p>
                    </div>
                </div>
            </section>

            <!-- CTA Final -->
            <section class="bg-gradient-to-br from-brand-200/5 to-accent-300/5 rounded-3xl p-8 md:p-12 text-center">
                <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                    ¿Listo para empezar?
                </h2>
                <p class="text-lg text-gray-600 font-inter mb-8 max-w-2xl mx-auto">
                    Únete a los miles de negocios que confían en Linkiu para hacer crecer su presencia en línea.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('plans.index') }}" class="bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-colors inline-flex items-center justify-center gap-2">
                        <span>Ver Planes</span>
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                    <a href="{{ route('register.step1') }}" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-4 rounded-xl font-semibold text-lg transition-colors border-2 border-gray-200 inline-flex items-center justify-center gap-2">
                        <span>Prueba Gratis</span>
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                    </a>
                    <button @click="calendlyOpen = true" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-4 rounded-xl font-semibold text-lg transition-colors border-2 border-gray-200 inline-flex items-center justify-center gap-2">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                        <span>Agendar reunión</span>
                    </button>
                </div>
            </section>
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
