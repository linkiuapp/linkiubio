<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Equipo - Linkiu - Conoce al equipo detrás de Linkiu">
    <title>Equipo - Linkiu</title>
    
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
    <section class="pt-40 pb-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="font-satoshi text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 mb-4">
                    Nuestro Equipo
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 font-inter max-w-3xl mx-auto">
                    Conoce al equipo que está detrás de Linkiu, trabajando cada día para hacer que tu negocio crezca en línea.
                </p>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="pb-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Sección Principal del Equipo -->
            <section class="mb-20">
                <div class="text-center mb-12">
                    <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Quiénes Somos
                    </h2>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto">
                        Somos un equipo apasionado por la tecnología y el emprendimiento, dedicados a crear la mejor plataforma para tu negocio.
                    </p>
                </div>

                <!-- Grid del Equipo -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Miembro del Equipo -->
                    <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center hover:shadow-lg transition-all">
                        <div class="w-24 h-24 bg-gradient-to-br from-accent-300 to-accent-400 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <i data-lucide="users" class="w-12 h-12 text-white"></i>
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-2">Equipo de Desarrollo</h3>
                        <p class="text-accent-300 font-semibold mb-4">Desarrolladores y Diseñadores</p>
                        <p class="text-gray-600 font-inter leading-relaxed text-sm">
                            Expertos en tecnología que construyen y mejoran continuamente la plataforma.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center hover:shadow-lg transition-all">
                        <div class="w-24 h-24 bg-gradient-to-br from-brand-200 to-brand-400 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <i data-lucide="headphones" class="w-12 h-12 text-white"></i>
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-2">Equipo de Soporte</h3>
                        <p class="text-brand-200 font-semibold mb-4">Atención al Cliente</p>
                        <p class="text-gray-600 font-inter leading-relaxed text-sm">
                            Siempre disponibles para ayudarte con cualquier duda o problema que tengas.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center hover:shadow-lg transition-all">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <i data-lucide="rocket" class="w-12 h-12 text-white"></i>
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-2">Equipo de Producto</h3>
                        <p class="text-green-600 font-semibold mb-4">Innovación y Estrategia</p>
                        <p class="text-gray-600 font-inter leading-relaxed text-sm">
                            Trabajamos constantemente en nuevas funcionalidades y mejoras para Linkiu.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Sección Valores del Equipo -->
            <section class="mb-20">
                <div class="text-center mb-12">
                    <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Nuestros Valores
                    </h2>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto">
                        Los principios que guían nuestro trabajo diario
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Valor 1 -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-6 border border-blue-200 text-center">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="heart" class="w-6 h-6 text-white"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Pasión</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Amamos lo que hacemos y nos apasiona ayudar a nuestros usuarios.
                        </p>
                    </div>

                    <!-- Valor 2 -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl p-6 border border-green-200 text-center">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="zap" class="w-6 h-6 text-white"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Innovación</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Constantemente buscamos nuevas formas de mejorar.
                        </p>
                    </div>

                    <!-- Valor 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-xl p-6 border border-purple-200 text-center">
                        <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="users" class="w-6 h-6 text-white"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Trabajo en Equipo</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Colaboramos para lograr mejores resultados.
                        </p>
                    </div>

                    <!-- Valor 4 -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100/50 rounded-xl p-6 border border-orange-200 text-center">
                        <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Compromiso</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Estamos comprometidos con el éxito de nuestros usuarios.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Sección Únete al Equipo -->
            <section class="bg-gradient-to-br from-brand-200/5 to-accent-300/5 rounded-3xl p-8 md:p-12 text-center">
                <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                    ¿Quieres Trabajar con Nosotros?
                </h2>
                <p class="text-lg text-gray-600 font-inter mb-8 max-w-2xl mx-auto">
                    Si te apasiona la tecnología y quieres formar parte de un equipo innovador, contáctanos.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact.index') }}" class="bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-colors inline-flex items-center justify-center gap-2">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                        <span>Contáctanos</span>
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
