<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Funciones de Linkiu - Descubre todas las características que incluye tu tienda online">
    <title>Funciones - Linkiu</title>
    
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
    <section class="pt-40 pb-16 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="font-satoshi text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 mb-4">
                    Todas las Funciones de Linkiu
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 font-inter max-w-3xl mx-auto">
                    Descubre todo lo que puedes hacer con tu tienda online. Desde gestión de productos hasta inteligencia artificial, todo lo que necesitas para vender más.
                </p>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="pb-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Sección: Kiubot - IA (Primera) -->
            <section id="kiubot" class="mb-20 scroll-mt-24">
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i data-lucide="bot" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900">
                            Kiubot - Inteligencia Artificial
                        </h2>
                    </div>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl">
                        Potencia tu tienda con inteligencia artificial. Automatiza procesos, mejora la experiencia del cliente y aumenta tus ventas.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Verificación de Comprobantes -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="shield-check" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Verificación de Comprobantes</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Con Kiubot verifica comprobantes de pago automáticamente. Reduce el tiempo de revisión manual y evita errores.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Reconocimiento automático de comprobantes</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Validación de datos bancarios</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Confirmación instantánea de pagos</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Atención Automática -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="message-square" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Atención Automática</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Chat inteligente disponible 24/7. Responde preguntas, ayuda con pedidos y brinda soporte automático a tus clientes.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Respuestas automáticas a consultas</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Asistencia con pedidos en tiempo real</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Integración con WhatsApp</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Recomendaciones Inteligentes -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="brain" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Recomendaciones Inteligentes</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Sugiere productos relevantes a tus clientes basándose en su historial de compras y preferencias.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Productos sugeridos personalizados</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Análisis de comportamiento de compra</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Aumenta el ticket promedio</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Búsqueda Inteligente -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="search" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Búsqueda Inteligente</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Encuentra productos fácilmente con búsqueda semántica. Entiende lo que el cliente busca aunque no use las palabras exactas.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Búsqueda por sinónimos y conceptos</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Autocompletado inteligente</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Corrección automática de errores</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Asistente Virtual -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="lightbulb" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Asistente Virtual</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Ayuda en tiempo real a tus clientes con información sobre productos, procesos de compra y soporte técnico.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Guiado paso a paso en compras</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Soporte contextual personalizado</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-purple-600 flex-shrink-0 mt-0.5"></i>
                                <span>Respuestas instantáneas 24/7</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Sección: Gestión -->
            <section id="gestion" class="mb-20 scroll-mt-24">
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-brand-200/10 rounded-xl flex items-center justify-center">
                            <i data-lucide="layout-grid" class="w-6 h-6 text-brand-200"></i>
                        </div>
                        <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900">
                            Gestión de Productos
                        </h2>
                    </div>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl">
                        Gestiona tu catálogo de productos de manera eficiente. Desde inventario hasta variantes, todo en un solo lugar.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Productos -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-200/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="package" class="w-6 h-6 text-brand-200"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Productos</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Catálogo ilimitado de productos. Agrega fotos, descripciones, precios y toda la información que necesites.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Catálogo sin límites</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Múltiples imágenes por producto</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Descripciones enriquecidas</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Inventario -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-200/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="box" class="w-6 h-6 text-brand-200"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Inventario</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Stock en tiempo real. Controla tu inventario automáticamente con cada venta y recibe alertas cuando se agote.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Actualización automática de stock</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Alertas de stock bajo</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Historial de movimientos</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Variantes -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-200/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="layers" class="w-6 h-6 text-brand-200"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Variantes</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Tallas, colores, opciones y más. Crea variantes de productos con precios e inventario independientes.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Múltiples variantes por producto</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Precios diferentes por variante</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Inventario por variante</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Categorías -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-200/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="folder" class="w-6 h-6 text-brand-200"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Categorías</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Organiza tu catálogo con categorías y subcategorías. Facilita la navegación y la búsqueda de productos.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Categorías ilimitadas</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Subcategorías anidadas</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Filtros automáticos</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Bajo Pedido -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-brand-200/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="clock" class="w-6 h-6 text-brand-200"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Bajo Pedido</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Vende productos hechos a medida sin necesidad de mantener stock. Define días de preparación y anticipos opcionales.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Productos personalizados</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Días de preparación configurables</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-brand-200 flex-shrink-0 mt-0.5"></i>
                                <span>Anticipos opcionales</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Sección: Ventas -->
            <section id="ventas" class="mb-20 scroll-mt-24">
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center">
                            <i data-lucide="shopping-cart" class="w-6 h-6 text-accent-300"></i>
                        </div>
                        <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900">
                            Ventas y Pagos
                        </h2>
                    </div>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl">
                        Gestiona pedidos, pagos y envíos de manera eficiente. Múltiples métodos de pago y opciones de envío.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Pedidos -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="shopping-bag" class="w-6 h-6 text-accent-300"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Pedidos</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Gestión completa de pedidos. Visualiza, procesa y organiza todos tus pedidos desde un solo lugar.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Estado de pedidos en tiempo real</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Notificaciones automáticas</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Historial completo</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Pagos -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="credit-card" class="w-6 h-6 text-accent-300"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Pagos</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Múltiples métodos de pago. Acepta transferencias bancarias, Nequi, Daviplata y más.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Transferencia bancaria</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Nequi y Daviplata</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Contra entrega</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Envíos -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="truck" class="w-6 h-6 text-accent-300"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Envíos</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Zonas y tarifas de envío configurables. Define tus propias zonas de entrega y calcula costos automáticamente.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Zonas personalizables</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Cálculo automático de tarifas</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Envió gratis configurable</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Cupones -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="tag" class="w-6 h-6 text-accent-300"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Cupones</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Descuentos y ofertas. Crea cupones de descuento por porcentaje o monto fijo con fechas de validez.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Descuentos por porcentaje o monto</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Fecha de validez configurable</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Uso limitado por cliente</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Promociones -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-accent-300/10 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="percent" class="w-6 h-6 text-accent-300"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Promociones</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Ofertas especiales. Crea promociones por tiempo limitado para aumentar tus ventas.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Promociones por tiempo limitado</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Descuentos automáticos</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-accent-300 flex-shrink-0 mt-0.5"></i>
                                <span>Banners promocionales</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Sección: Comunicación -->
            <section id="comunicacion" class="mb-20 scroll-mt-24">
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i data-lucide="zap" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900">
                            Comunicación y Marketing
                        </h2>
                    </div>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl">
                        Mantén comunicación constante con tus clientes. Notificaciones automáticas, diseño personalizado y herramientas de marketing.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- WhatsApp -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="message-circle" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">WhatsApp</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Notificaciones automáticas por WhatsApp. Informa a tus clientes sobre pedidos, pagos y más sin esfuerzo.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Confirmación de pedidos</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Actualizaciones de estado</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Plantillas personalizables</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Dashboard -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="bar-chart-3" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Dashboard</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Métricas y reportes en tiempo real. Visualiza ventas, productos más vendidos y tendencias.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Ventas en tiempo real</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Productos más vendidos</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Reportes exportables</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Diseño -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="palette" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Diseño</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Personaliza tu tienda. Logo, colores, fuentes y más. Crea una experiencia única para tus clientes.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Editor visual intuitivo</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Paleta de colores personalizada</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Plantillas profesionales</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- QR Mesas -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="qr-code" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">QR Mesas</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Para restaurantes. Genera códigos QR para cada mesa y permite a los clientes ver el menú y hacer pedidos.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Códigos QR por mesa</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Menú digital interactivo</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Pedidos directos desde la mesa</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Reservas -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                            <i data-lucide="calendar" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h3 class="font-satoshi font-bold text-gray-900 mb-2">Reservas</h3>
                        <p class="text-sm text-gray-600 font-inter mb-4">Agenda online. Permite a tus clientes reservar mesas, citas o servicios directamente desde tu tienda.</p>
                        <ul class="space-y-2 text-xs text-gray-500 font-inter">
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Calendario interactivo</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Confirmación automática</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i data-lucide="check" class="w-4 h-4 text-green-600 flex-shrink-0 mt-0.5"></i>
                                <span>Recordatorios por WhatsApp</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Sección: Verificación -->
            <section id="verificacion" class="mb-20 scroll-mt-24">
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-6 h-6 text-green-600"></i>
                        </div>
                        <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900">
                            Verificación de Tiendas
                        </h2>
                    </div>
                    <p class="text-lg text-gray-600 font-inter max-w-2xl">
                        El sello <strong class="text-green-600">&lt;Verificado por Linkiu&gt;</strong> reconoce a las tiendas que han superado nuestro proceso de validación y revisión interna. Genera confianza y credibilidad.
                    </p>
                </div>
                
                <div class="bg-white rounded-2xl p-8 md:p-12 border border-gray-200">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <div class="inline-flex items-center gap-2 bg-green-100 px-4 py-2 rounded-full mb-4">
                                <i data-lucide="shield-check" class="w-5 h-5 text-green-600"></i>
                                <span class="text-sm font-semibold text-green-600">Sello de Confianza</span>
                            </div>
                            <h3 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                                ¿Qué significa estar verificado?
                            </h3>
                            <p class="text-lg text-gray-600 font-inter mb-6">
                                Las tiendas verificadas han completado nuestro proceso de validación documental y cumplen con las políticas de uso responsable de Linkiu.
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
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                <p class="text-sm text-gray-700 font-inter">
                                    <strong class="text-green-700">Importante:</strong> Este sello no implica aval financiero ni garantía comercial sobre transacciones externas, pero sí respalda que el negocio ha completado un proceso de verificación documental y de cumplimiento básico.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Badge de verificación visual -->
                        <div class="flex items-center justify-center">
                            <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-green-200 max-w-md w-full">
                                <div class="text-center mb-6">
                                    <div class="inline-flex items-center gap-3 bg-green-50 border-2 border-green-300 rounded-full px-8 py-4 mb-6">
                                        <i data-lucide="shield-check" class="w-8 h-8 text-green-600"></i>
                                        <div>
                                            <div class="font-satoshi font-black text-green-600 text-lg">Verificado</div>
                                            <div class="text-xs text-green-600 font-semibold">por Linkiu</div>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="h-4 bg-gray-800 rounded w-48 mx-auto"></div>
                                        <div class="h-3 bg-gray-300 rounded w-36 mx-auto"></div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                        </div>
                                        <div class="h-3 bg-gray-800 rounded flex-1"></div>
                                    </div>
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                        </div>
                                        <div class="h-3 bg-gray-800 rounded flex-1"></div>
                                    </div>
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                        </div>
                                        <div class="h-3 bg-gray-800 rounded flex-1"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Final -->
            <section class="bg-gradient-to-br from-brand-200/5 to-accent-300/5 rounded-3xl p-8 md:p-12 text-center">
                <h2 class="font-satoshi text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                    ¿Listo para empezar?
                </h2>
                <p class="text-lg text-gray-600 font-inter mb-8 max-w-2xl mx-auto">
                    Todas estas funciones están incluidas en nuestros planes. Elige el que mejor se adapte a tu negocio.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register.step1') }}" class="bg-accent-300 hover:bg-accent-400 text-white px-8 py-4 rounded-xl font-bold text-lg transition-colors inline-flex items-center justify-center gap-2">
                        <span>Prueba Gratis</span>
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                    </a>
                    <a href="{{ route('plans.index') }}" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-4 rounded-xl font-semibold text-lg transition-colors border-2 border-gray-200 inline-flex items-center justify-center gap-2">
                        <span>Ver Planes</span>
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
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
