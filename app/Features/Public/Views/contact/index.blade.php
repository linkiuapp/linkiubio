<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contacto - Linkiu - Contáctanos para resolver tus dudas o solicitar información">
    <title>Contacto - Linkiu</title>
    
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
    <section class="pt-40 pb-4 lg:pb-16 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="font-satoshi text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 mb-4">
                    Contáctanos
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 font-inter max-w-3xl mx-auto">
                    Estamos aquí para ayudarte. Envíanos un mensaje y te responderemos lo antes posible.
                </p>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="pb-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 mb-16">
                <!-- Información de Contacto -->
                <div class="space-y-8">
                    <div>
                        <h2 class="font-satoshi text-2xl font-black text-gray-900 mb-6">Información de Contacto</h2>
                        <p class="text-gray-600 font-inter mb-8">
                            Puedes contactarnos a través de cualquiera de estos medios. Estamos disponibles para responder tus preguntas y ayudarte con lo que necesites.
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-4 p-6 bg-gray-50 rounded-xl border border-gray-200 hover:border-gray-300 transition-colors">
                        <div class="flex-shrink-0 w-12 h-12 bg-accent-300/10 rounded-lg flex items-center justify-center">
                            <i data-lucide="mail" class="w-6 h-6 text-accent-300"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600 mb-2">Escríbenos por email</p>
                            <a href="mailto:soporte@linkiu.bio" class="text-accent-300 hover:text-accent-400 font-medium transition-colors inline-flex items-center gap-2">
                                soporte@linkiu.bio
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="flex items-start gap-4 p-6 bg-gray-50 rounded-xl border border-gray-200 hover:border-gray-300 transition-colors">
                        <div class="flex-shrink-0 w-12 h-12 bg-green-500/10 rounded-lg flex items-center justify-center">
                            <i data-lucide="message-circle" class="w-6 h-6 text-green-500"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">WhatsApp</h3>
                            <p class="text-gray-600 mb-2">Chatea con nosotros</p>
                            <a href="https://wa.me/573104594344" target="_blank" class="text-green-500 hover:text-green-600 font-medium transition-colors inline-flex items-center gap-2">
                                +57 310 459 4344
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Agendar Reunión -->
                    <div class="flex items-start gap-4 p-6 bg-gradient-to-br from-brand-200/5 to-accent-300/5 rounded-xl border border-gray-200">
                        <div class="flex-shrink-0 w-12 h-12 bg-brand-200/10 rounded-lg flex items-center justify-center">
                            <i data-lucide="calendar" class="w-6 h-6 text-brand-200"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Agendar Reunión</h3>
                            <p class="text-gray-600 mb-4">Programa una llamada con nuestro equipo</p>
                            <button @click="calendlyOpen = true" class="bg-accent-300 hover:bg-accent-400 text-white px-6 py-3 rounded-xl font-semibold transition-colors inline-flex items-center gap-2">
                                <i data-lucide="calendar" class="w-5 h-5"></i>
                                <span>Agendar ahora</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Contacto -->
                <div class="bg-white rounded-2xl border border-gray-200 p-4 lg:p-8 shadow-sm">
                    <h2 class="font-satoshi text-2xl font-black text-gray-900 mb-6">Envíanos un Mensaje</h2>
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-green-700 font-inter">{{ session('success') }}</p>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <p class="text-red-700 font-inter">{{ session('error') }}</p>
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
                                Nombre <span class="text-accent-300">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-300 focus:border-transparent transition-all font-inter"
                                placeholder="Tu nombre completo"
                            >
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                                Email <span class="text-accent-300">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-300 focus:border-transparent transition-all font-inter"
                                placeholder="tu@email.com"
                            >
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">
                                Teléfono
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-300 focus:border-transparent transition-all font-inter"
                                placeholder="+57 300 123 4567"
                            >
                        </div>

                        <!-- Asunto -->
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-900 mb-2">
                                Asunto <span class="text-accent-300">*</span>
                            </label>
                            <select 
                                id="subject" 
                                name="subject" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-300 focus:border-transparent transition-all font-inter bg-white"
                            >
                                <option value="">Selecciona un asunto</option>
                                <option value="soporte">Soporte Técnico</option>
                                <option value="ventas">Información de Ventas</option>
                                <option value="cuenta">Consultas sobre mi Cuenta</option>
                                <option value="facturacion">Facturación y Pagos</option>
                                <option value="funcionalidades">Funcionalidades</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <!-- Mensaje -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-900 mb-2">
                                Mensaje <span class="text-accent-300">*</span>
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="5" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-300 focus:border-transparent transition-all font-inter resize-none"
                                placeholder="Cuéntanos en qué podemos ayudarte..."
                            ></textarea>
                        </div>

                        <!-- Botón Enviar -->
                        <button 
                            type="submit"
                            class="w-full bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-colors inline-flex items-center justify-center gap-2"
                        >
                            <i data-lucide="send" class="w-5 h-5"></i>
                            <span>Enviar Mensaje</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Información Adicional -->
            <section class="bg-gradient-to-br from-brand-200/5 to-accent-300/5 rounded-3xl p-8 md:p-12">
                <div class="text-center mb-8">
                    <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                        ¿Prefieres una llamada?
                    </h2>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl mx-auto mb-8">
                        Agenda una reunión con nuestro equipo para resolver todas tus dudas y conocer cómo Linkiu puede ayudarte a hacer crecer tu negocio.
                    </p>
                    <button @click="calendlyOpen = true" class="bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-colors inline-flex items-center justify-center gap-2">
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
