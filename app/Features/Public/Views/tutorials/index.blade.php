<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tutoriales de Linkiu - Aprende a usar todas las funcionalidades de Linkiu paso a paso">
    <title>Tutoriales - Linkiu</title>
    
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
    <section class="pt-40 pb-8 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="font-satoshi text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 mb-4">
                    Tutoriales
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 font-inter max-w-3xl mx-auto">
                    Aprende a usar todas las funcionalidades de Linkiu paso a paso. Encuentra guías detalladas para cada característica.
                </p>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="pb-16 bg-white">
        <div class="max-w-8xl mx-auto px-4 sm:px-8 lg:px-32">
            <div class="grid lg:grid-cols-4 gap-4">
                <!-- Sidebar de Filtros -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl p-6 border border-gray-200 sticky top-24">
                        <!-- Índice -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h2 class="font-satoshi text-lg font-black text-gray-900 mb-4">Índice</h2>
                            <nav class="space-y-2 max-h-64 overflow-y-auto">
                                <a href="#tutoriales" class="block text-sm text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-2 py-1">
                                    <i data-lucide="book-open" class="w-4 h-4"></i>
                                    <span>Todos los tutoriales</span>
                                </a>
                                @foreach($categories as $category)
                                    @php
                                        $categoryCount = $tutorials->where('category_id', $category->id)->count();
                                    @endphp
                                    @if($categoryCount > 0)
                                        <a href="{{ route('tutorials.index', ['category' => $category->slug]) }}" 
                                           class="block text-sm text-gray-600 hover:text-gray-900 transition-colors pl-6 py-1 flex items-center justify-between">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-xs text-gray-400">({{ $categoryCount }})</span>
                                        </a>
                                    @endif
                                @endforeach
                            </nav>
                        </div>

                        <h2 class="font-satoshi text-lg font-black text-gray-900 mb-4">Filtros</h2>
                        
                        <form method="GET" action="{{ route('tutorials.index') }}" class="space-y-6">
                            <!-- Búsqueda -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Palabras clave..."
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                            </div>

                            <!-- Categoría -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                                <select name="category" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                                    <option value="">Todas las categorías</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dificultad -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nivel</label>
                                <select name="difficulty" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                                    <option value="">Todos los niveles</option>
                                    @foreach($difficulties as $key => $label)
                                        <option value="{{ $key }}" {{ request('difficulty') === $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit" 
                                        class="flex-1 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    Filtrar
                                </button>
                                <a href="{{ route('tutorials.index') }}" 
                                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de Tutoriales -->
                <div class="lg:col-span-3" id="tutoriales">
                    @if($tutorials->count() > 0)
                        <div class="grid md:grid-cols-3 gap-4">
                            @foreach($tutorials as $tutorial)
                                <a href="{{ route('tutorials.show', $tutorial->slug) }}" 
                                   class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all hover:border-gray-300 group">
                                    @if($tutorial->featured_image)
                                        <div class="h-48 bg-gray-100 overflow-hidden">
                                            <img src="{{ Storage::disk('public')->url($tutorial->featured_image) }}" 
                                                 alt="{{ $tutorial->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @endif
                                    
                                    <div class="p-6">
                                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $tutorial->category->name }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                                                {{ $tutorial->difficulty_level === 'beginner' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $tutorial->difficulty_level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $tutorial->difficulty_level === 'advanced' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $tutorial->difficulty_label }}
                                            </span>
                                        </div>
                                        
                                        <h3 class="font-satoshi text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                            {{ $tutorial->title }}
                                        </h3>
                                        
                                        @if($tutorial->description)
                                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                                {{ $tutorial->description }}
                                            </p>
                                        @endif

                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                                {{ number_format($tutorial->views_count) }} vistas
                                            </span>
                                            <span class="flex items-center gap-1 text-blue-600 font-medium">
                                                Ver tutorial
                                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Paginación -->
                        @if($tutorials->hasPages())
                            <div class="mt-8">
                                {{ $tutorials->links() }}
                            </div>
                        @endif
                    @else
                        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                            <i data-lucide="book-open" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                            <h3 class="font-satoshi text-xl font-bold text-gray-900 mb-2">No se encontraron tutoriales</h3>
                            <p class="text-gray-600">Intenta ajustar los filtros de búsqueda</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <x-public-footer />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
