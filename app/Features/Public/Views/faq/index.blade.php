<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Preguntas Frecuentes - Linkiu - Encuentra respuestas a las preguntas más comunes sobre Linkiu">
    <title>Preguntas Frecuentes - Linkiu</title>
    
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
<body class="font-inter antialiased bg-white text-gray-900" x-data="{ mobileMenu: false, productosOpen: false, funcionesOpen: false, recursosOpen: false, ayudaOpen: false, empresaOpen: false, calendlyOpen: false, activeCategory: 'general', openQuestion: null }">
    <x-public-navbar />

    <!-- Hero Section -->
    <section class="pt-40 pb-16 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="font-satoshi text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 mb-4">
                    Preguntas Frecuentes
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 font-inter max-w-3xl mx-auto">
                    Encuentra respuestas a las preguntas más comunes sobre Linkiu. Si no encuentras lo que buscas, no dudes en contactarnos.
                </p>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="pb-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-4 gap-8">
                <!-- Sidebar de Categorías -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl p-6 border border-gray-200 sticky top-24">
                        <h2 class="font-satoshi text-lg font-black text-gray-900 mb-4">Categorías</h2>
                        <nav class="space-y-2">
                            <button 
                                @click="activeCategory = 'general'; openQuestion = null"
                                :class="activeCategory === 'general' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-3 rounded-lg font-medium transition-colors flex items-center gap-2">
                                <i data-lucide="help-circle" class="w-5 h-5"></i>
                                <span>General</span>
                            </button>
                            <button 
                                @click="activeCategory = 'planes'; openQuestion = null"
                                :class="activeCategory === 'planes' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-3 rounded-lg font-medium transition-colors flex items-center gap-2">
                                <i data-lucide="credit-card" class="w-5 h-5"></i>
                                <span>Planes y Precios</span>
                            </button>
                            <button 
                                @click="activeCategory = 'funcionalidades'; openQuestion = null"
                                :class="activeCategory === 'funcionalidades' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-3 rounded-lg font-medium transition-colors flex items-center gap-2">
                                <i data-lucide="zap" class="w-5 h-5"></i>
                                <span>Funcionalidades</span>
                            </button>
                            <button 
                                @click="activeCategory = 'soporte'; openQuestion = null"
                                :class="activeCategory === 'soporte' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-3 rounded-lg font-medium transition-colors flex items-center gap-2">
                                <i data-lucide="headphones" class="w-5 h-5"></i>
                                <span>Soporte</span>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Contenido de Preguntas -->
                <div class="lg:col-span-3">
                    <!-- Categoría: General -->
                    <div x-show="activeCategory === 'general'" x-transition class="space-y-4">
                        <h2 class="font-satoshi text-2xl font-black text-gray-900 mb-6">Preguntas Generales</h2>
                        
                        <!-- Pregunta 1 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'general-1' ? null : 'general-1'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Qué es Linkiu?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'general-1' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'general-1'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Linkiu es una plataforma completa para crear y gestionar tu tienda online. Ideal para restaurantes, tiendas de ropa, accesorios y más. Te permite vender productos, gestionar pedidos, aceptar pagos y mucho más, todo desde un solo lugar.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 2 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'general-2' ? null : 'general-2'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Necesito conocimientos técnicos para usar Linkiu?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'general-2' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'general-2'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    No, Linkiu está diseñado para ser fácil de usar. No necesitas conocimientos técnicos ni experiencia en programación. Nuestra interfaz intuitiva te permite configurar tu tienda en minutos.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 3 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'general-3' ? null : 'general-3'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Puedo probar Linkiu antes de pagar?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'general-3' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'general-3'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Sí, ofrecemos 30 días gratis para que pruebes todas las funcionalidades de Linkiu. No necesitas tarjeta de crédito para empezar.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 4 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'general-4' ? null : 'general-4'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Linkiu es solo para tiendas online?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'general-4' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'general-4'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    No, Linkiu también es perfecto para restaurantes. Incluye funcionalidades especiales como menú digital, reservas de mesas, códigos QR para mesas, y más.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Categoría: Planes y Precios -->
                    <div x-show="activeCategory === 'planes'" x-transition class="space-y-4">
                        <h2 class="font-satoshi text-2xl font-black text-gray-900 mb-6">Planes y Precios</h2>
                        
                        <!-- Pregunta 1 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'planes-1' ? null : 'planes-1'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Puedo cambiar mi plan más adelante?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'planes-1' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'planes-1'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Por supuesto. Puedes actualizar o cambiar tu plan en cualquier momento desde la configuración de tu cuenta. Los cambios se aplicarán en tu próximo ciclo de facturación.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 2 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'planes-2' ? null : 'planes-2'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Cuál es su política de cancelación?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'planes-2' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'planes-2'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Puedes cancelar tu suscripción en cualquier momento. No hay penalizaciones por cancelación temprana. Tu acceso continuará hasta el final del período de facturación actual.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 3 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'planes-3' ? null : 'planes-3'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Cómo funciona la facturación?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'planes-3' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'planes-3'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    La facturación es automática y se realiza mensual, trimestral, semestral o anualmente según el plan que elijas. Aceptamos transferencias bancarias, Nequi, Daviplata y más.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 4 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'planes-4' ? null : 'planes-4'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Hay descuentos por pago anual?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'planes-4' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'planes-4'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Sí, ofrecemos descuentos cuando pagas por períodos más largos. El pago anual ofrece el mayor descuento. Puedes ver todos los precios y descuentos en nuestra página de planes.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Categoría: Funcionalidades -->
                    <div x-show="activeCategory === 'funcionalidades'" x-transition class="space-y-4">
                        <h2 class="font-satoshi text-2xl font-black text-gray-900 mb-6">Funcionalidades</h2>
                        
                        <!-- Pregunta 1 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'func-1' ? null : 'func-1'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Puedo personalizar el diseño de mi tienda?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'func-1' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'func-1'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Sí, puedes personalizar colores, logo, fuentes y más. También ofrecemos plantillas profesionales para que puedas comenzar rápidamente.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 2 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'func-2' ? null : 'func-2'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Qué métodos de pago acepta Linkiu?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'func-2' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'func-2'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Linkiu acepta transferencias bancarias, Nequi, Daviplata, contra entrega y más. Puedes configurar múltiples métodos de pago según tus necesidades.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 3 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'func-3' ? null : 'func-3'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Linkiu incluye inteligencia artificial?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'func-3' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'func-3'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Sí, Kiubot es nuestro asistente con IA que incluye verificación automática de comprobantes de pago, atención al cliente 24/7, recomendaciones inteligentes y más.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 4 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'func-4' ? null : 'func-4'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Puedo gestionar inventario con Linkiu?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'func-4' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'func-4'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Sí, puedes gestionar tu inventario en tiempo real. El stock se actualiza automáticamente con cada venta y recibirás alertas cuando esté bajo.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Categoría: Soporte -->
                    <div x-show="activeCategory === 'soporte'" x-transition class="space-y-4">
                        <h2 class="font-satoshi text-2xl font-black text-gray-900 mb-6">Soporte</h2>
                        
                        <!-- Pregunta 1 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'soporte-1' ? null : 'soporte-1'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Cómo puedo contactar al soporte?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'soporte-1' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'soporte-1'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Puedes contactarnos por email a soporte@linkiu.bio o a través del sistema de tickets dentro de tu panel de administración. También ofrecemos soporte prioritario según tu plan.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 2 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'soporte-2' ? null : 'soporte-2'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Hay tutoriales disponibles?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'soporte-2' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'soporte-2'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Sí, estamos trabajando en crear tutoriales completos. Por ahora, nuestra interfaz es intuitiva y fácil de usar. Si necesitas ayuda, no dudes en contactarnos.
                                </p>
                            </div>
                        </div>

                        <!-- Pregunta 3 -->
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <button 
                                @click="openQuestion = openQuestion === 'soporte-3' ? null : 'soporte-3'"
                                class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                <span class="font-semibold text-gray-900">¿Ofrecen capacitación?</span>
                                <i data-lucide="chevron-down" class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="openQuestion === 'soporte-3' && 'rotate-180'"></i>
                            </button>
                            <div x-show="openQuestion === 'soporte-3'" x-transition class="px-6 pb-4">
                                <p class="text-gray-600 font-inter leading-relaxed">
                                    Ofrecemos sesiones de incorporación personalizadas según tu plan. También puedes agendar una reunión con nuestro equipo para resolver cualquier duda.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Final -->
            <section class="mt-20 bg-gradient-to-br from-brand-200/5 to-accent-300/5 rounded-3xl p-8 md:p-12 text-center">
                <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                    ¿No encuentras tu respuesta?
                </h2>
                <p class="text-lg text-gray-600 font-inter mb-8 max-w-2xl mx-auto">
                    Si tienes más preguntas, no dudes en contactarnos. Estamos aquí para ayudarte.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:soporte@linkiu.bio" class="bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-colors inline-flex items-center justify-center gap-2">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                        <span>Contactar Soporte</span>
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
