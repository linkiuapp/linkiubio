<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nuevas Actualizaciones - Linkiu - Lista de actualizaciones y correcciones que realizamos para ti">
    <title>Nuevas Actualizaciones - Linkiu</title>
    
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

    <!-- Hero Section con Iconos Flotantes -->
    <section class="pt-40 pb-20 bg-gradient-to-br from-gray-50 to-white relative overflow-visible">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative">
            <!-- Iconos flotantes -->
            <div class="absolute top-0 left-0 right-0 pointer-events-none" style="z-index: 0;">
                <div class="max-w-4xl mx-auto">
                    <img src="{{ asset('images-ui/icons_note_release.svg') }}" alt="Iconos flotantes" class="w-full h-auto">
                </div>
            </div>
            
            <div class="relative text-center mb-12 mt-12" style="z-index: 1;">
                <h1 class="font-satoshi text-lg sm:text-2xl lg:text-3xl font-black text-gray-900 mb-4">
                    Nuevas Actualizaciones
                </h1>
                <p class="text-base sm:text-base text-gray-600 font-inter max-w-3xl mx-auto">
                    Lista de actualizaciones y correcciones que realizamos para ti. <br> Las notas de lanzamiento se presentan según la versión más reciente.
                </p>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="pb-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Timeline de Versiones -->
            <div class="relative">
                <!-- Línea vertical de la timeline -->
                <div class="absolute left-2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-blue-300 via-blue-200 to-blue-100"></div>
                
                <!-- Versiones -->
                <div class="space-y-6">
                    @foreach($versions as $index => $version)
                        <div class="relative flex gap-4">
                            <!-- Punto en la timeline -->
                            <div class="relative flex-shrink-0 z-10">
                                @if($version['is_current'])
                                    <!-- Punto versión actual -->
                                    <div class="w-5 h-5 bg-gradient-to-br from-accent-300 to-accent-400 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    </div>
                                @else
                                    <!-- Punto versión anterior -->
                                    <div class="w-5 h-5 bg-white border-3 border-blue-400 rounded-full shadow-md flex items-center justify-center">
                                        <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Contenido de la versión -->
                            <div class="flex-1 pb-6">
                                <!-- Card de la versión -->
                                <div class="bg-white rounded-lg border {{ $version['is_current'] ? 'border-accent-300 shadow-md' : 'border-gray-200 shadow-sm' }} hover:shadow-md transition-all overflow-hidden">
                                    <!-- Header de la versión -->
                                    <div class="bg-gradient-to-r {{ $version['is_current'] ? 'from-accent-300/10 to-accent-300/5' : 'from-gray-50 to-white' }} px-4 py-3 border-b border-gray-100">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                            <div class="flex items-center gap-2">
                                                <h2 class="font-satoshi text-xl font-black text-gray-900">
                                                    v {{ $version['version'] }}
                                                </h2>
                                                @if($version['is_current'])
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-accent-300 text-white shadow-sm">
                                                        Actual
                                                    </span>
                                                @endif
                                            </div>
                                            <span class="font-semibold text-gray-600 font-inter text-xs">
                                                {{ $version['date'] }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Items de la versión -->
                                    <div class="p-4 space-y-2.5">
                                        @foreach($version['items'] as $item)
                                            <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                                <!-- Etiqueta Fix o New -->
                                                @if($item['type'] === 'fix')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 whitespace-nowrap flex-shrink-0 mt-0.5">
                                                        Fix
                                                    </span>
                                                @elseif($item['type'] === 'new')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-50 text-green-700 border border-green-200 whitespace-nowrap flex-shrink-0 mt-0.5">
                                                        New
                                                    </span>
                                                @endif
                                                
                                                <!-- Descripción -->
                                                <p class="text-gray-700 font-inter leading-relaxed flex-1 text-sm">
                                                    {{ $item['description'] }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
