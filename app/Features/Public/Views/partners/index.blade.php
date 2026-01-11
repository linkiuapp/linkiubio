<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Partners - Linkiu - Trabaja con nosotros y ayuda a más negocios a crecer en línea">
    <title>Partners - Linkiu</title>
    
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
                    Programa de Partners
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 font-inter max-w-3xl mx-auto">
                    Únete a nuestro programa de partners y ayuda a más negocios a crecer en línea mientras ganas comisiones.
                </p>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="pb-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Sección Qué es el Programa de Partners -->
            <section class="mb-20">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-6">
                            ¿Qué es el Programa de Partners?
                        </h2>
                        <div class="space-y-4 text-gray-600 font-inter leading-relaxed">
                            <p>
                                El Programa de Partners de Linkiu te permite recomendar nuestra plataforma a otros negocios y ganar comisiones por cada cliente que se registre a través de tu enlace único.
                            </p>
                            <p>
                                Es ideal para agencias de marketing, consultores, desarrolladores web, o cualquier persona que trabaje con negocios y quiera ofrecerles una solución completa para vender en línea.
                            </p>
                            <p>
                                Como partner, tendrás acceso a recursos, materiales de marketing y soporte dedicado para ayudarte a promocionar Linkiu.
                            </p>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-brand-200/10 to-accent-300/10 rounded-3xl p-12 text-center">
                        <div class="bg-white rounded-2xl p-8 shadow-lg">
                            <i data-lucide="handshake" class="w-20 h-20 text-accent-300 mx-auto mb-6"></i>
                            <h3 class="font-satoshi text-2xl font-black text-gray-900 mb-4">Trabaja con Nosotros</h3>
                            <p class="text-gray-600 font-inter">
                                Ayuda a más negocios a crecer en línea y gana comisiones recurrentes.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Beneficios -->
            <section class="mb-20">
                <div class="text-center mb-12">
                    <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        Beneficios del Programa
                    </h2>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto">
                        Todo lo que necesitas para tener éxito como partner
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Beneficio 1 -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="dollar-sign" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Comisiones Recurrentes</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Gana comisiones mensuales por cada cliente que se registre a través de tu enlace único.
                        </p>
                    </div>

                    <!-- Beneficio 2 -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="bar-chart-3" class="w-6 h-6 text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Panel de Seguimiento</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Accede a un panel personalizado para ver tus referidos, comisiones y estadísticas en tiempo real.
                        </p>
                    </div>

                    <!-- Beneficio 3 -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="presentation" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Materiales de Marketing</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Recibe banners, videos, presentaciones y otros materiales profesionales para promocionar Linkiu.
                        </p>
                    </div>

                    <!-- Beneficio 4 -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="headphones" class="w-6 h-6 text-orange-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Soporte Dedicado</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Acceso a soporte prioritario y un equipo dedicado para ayudarte con tus dudas y necesidades.
                        </p>
                    </div>

                    <!-- Beneficio 5 -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="gift" class="w-6 h-6 text-red-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Bonos por Volumen</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Obtén bonos adicionales cuando alcances metas de referidos mensuales o trimestrales.
                        </p>
                    </div>

                    <!-- Beneficio 6 -->
                    <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="users" class="w-6 h-6 text-indigo-600"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">Comunidad de Partners</h3>
                        <p class="text-gray-600 font-inter text-sm leading-relaxed">
                            Únete a nuestra comunidad exclusiva de partners para compartir experiencias y mejores prácticas.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Cómo Funciona -->
            <section class="mb-20">
                <div class="text-center mb-12">
                    <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        ¿Cómo Funciona?
                    </h2>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto">
                        Proceso simple en 4 pasos
                    </p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Paso 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-accent-300 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                            1
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-3">Únete al Programa</h3>
                        <p class="text-gray-600 font-inter leading-relaxed text-sm">
                            Completa el formulario de registro y recibe la aprobación de nuestro equipo.
                        </p>
                    </div>

                    <!-- Paso 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-brand-200 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                            2
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-3">Obtén tu Enlace Único</h3>
                        <p class="text-gray-600 font-inter leading-relaxed text-sm">
                            Recibe tu enlace de afiliado personalizado y materiales de marketing.
                        </p>
                    </div>

                    <!-- Paso 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                            3
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-3">Comparte y Refiere</h3>
                        <p class="text-gray-600 font-inter leading-relaxed text-sm">
                            Comparte Linkiu con negocios y ayuda a que se registren usando tu enlace.
                        </p>
                    </div>

                    <!-- Paso 4 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 text-white font-bold text-xl">
                            4
                        </div>
                        <h3 class="font-satoshi text-xl font-black text-gray-900 mb-3">Gana Comisiones</h3>
                        <p class="text-gray-600 font-inter leading-relaxed text-sm">
                            Recibe comisiones recurrentes por cada cliente que se registre y mantenga activo.
                        </p>
                    </div>
                </div>
            </section>

            <!-- CTA Final -->
            <section class="bg-gradient-to-br from-brand-200/5 to-accent-300/5 rounded-3xl p-8 md:p-12 text-center">
                <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                    ¿Listo para ser Partner?
                </h2>
                <p class="text-lg text-gray-600 font-inter mb-8 max-w-2xl mx-auto">
                    Únete a nuestro programa de partners y comienza a ganar comisiones mientras ayudas a más negocios a crecer en línea.
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
