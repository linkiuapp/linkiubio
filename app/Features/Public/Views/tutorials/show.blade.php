<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $tutorial->description ?? $tutorial->title }}">
    <title>{{ $tutorial->title }} - Tutoriales Linkiu</title>
    
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

        /* Prose styles for content */
        .prose {
            max-width: none;
        }
        .prose p {
            margin-bottom: 1rem;
            line-height: 1.75;
        }
        .prose ul, .prose ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
            list-style-position: outside;
        }
        .prose ul {
            list-style-type: disc;
        }
        .prose ol {
            list-style-type: decimal;
        }
        .prose li {
            margin-bottom: 0.5rem;
            display: list-item;
        }
        .prose strong {
            font-weight: 600;
        }
        .prose a {
            color: #0007F7;
            text-decoration: underline;
        }
        .prose a:hover {
            color: #000684;
        }
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
            display: block;
        }
        .prose iframe {
            width: 100%;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
        .prose div[style*="padding-bottom"] {
            margin: 1rem 0;
        }
    </style>
</head>
<body class="font-inter antialiased bg-white text-gray-900" x-data="{ mobileMenu: false, productosOpen: false, funcionesOpen: false, recursosOpen: false, ayudaOpen: false, empresaOpen: false, calendlyOpen: false }">
    <x-public-navbar />

    <!-- Breadcrumbs -->
    <section class="pt-32 pb-4 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-gray-600">
                <a href="{{ route('tutorials.index') }}" class="hover:text-gray-900">Tutoriales</a>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                <span class="text-gray-900">{{ $tutorial->title }}</span>
            </nav>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="pb-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <article class="pt-8">
                <!-- Header -->
                <header class="mb-4">
                    <div class="flex items-center gap-3 mb-4 flex-wrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $tutorial->category->name }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                            {{ $tutorial->difficulty_level === 'beginner' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $tutorial->difficulty_level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $tutorial->difficulty_level === 'advanced' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $tutorial->difficulty_label }}
                        </span>
                        <span class="text-sm text-gray-500 flex items-center gap-1">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            {{ number_format($tutorial->views_count) }} vistas
                        </span>
                    </div>
                    
                    <h1 class="font-satoshi text-2xl sm:text-3xl lg:text-3xl font-black text-gray-900 mb-1">
                        {{ $tutorial->title }}
                    </h1>
                    
                    @if($tutorial->description)
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ $tutorial->description }}
                        </p>
                    @endif
                </header>

                <!-- Portada Image (Vista Individual - 830x200) -->
                @if($tutorial->portada_image)
                    <div class="mb-8 rounded-xl overflow-hidden">
                        <img src="{{ Storage::disk('public')->url($tutorial->portada_image) }}" 
                             alt="{{ $tutorial->title }}"
                             class="w-full h-auto"
                             style="width: 830px; max-width: 100%; height: 200px; object-fit: cover; object-position: center;">
                    </div>
                @elseif($tutorial->featured_image)
                    {{-- Fallback al cover si no hay portada --}}
                    <div class="mb-8 rounded-xl overflow-hidden">
                        <img src="{{ Storage::disk('public')->url($tutorial->featured_image) }}" 
                             alt="{{ $tutorial->title }}"
                             class="w-full h-auto object-cover"
                             style="max-height: 500px; width: 100%; object-fit: cover; object-position: center;">
                    </div>
                @endif

                <!-- Video -->
                @if($tutorial->video_url)
                    <div class="mb-8">
                        <h2 class="font-satoshi text-xl font-bold text-gray-900 mb-4">Video Tutorial</h2>
                        @include('public::components.embedded-video', ['url' => $tutorial->video_url])
                    </div>
                @endif

                <!-- Content -->
                <div class="prose prose-lg max-w-none mb-8">
                    {!! $tutorial->content !!}
                </div>

                <!-- Tags -->
                @if($tutorial->tags->isNotEmpty())
                    <div class="pt-8 border-t border-gray-200">
                        <h3 class="font-satoshi text-lg font-bold text-gray-900 mb-4">Etiquetas relacionadas</h3>
                        <div class="flex items-center gap-2 flex-wrap">
                            @foreach($tutorial->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Related Tutorials -->
                @if($relatedTutorials->isNotEmpty())
                    <div class="pt-8 border-t border-gray-200 mt-8">
                        <h3 class="font-satoshi text-xl font-bold text-gray-900 mb-6">Tutoriales relacionados</h3>
                        <div class="grid md:grid-cols-3 gap-4">
                            @foreach($relatedTutorials as $related)
                                <a href="{{ route('tutorials.show', $related->slug) }}" 
                                   class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all hover:border-gray-300 group">
                                    @if($related->featured_image)
                                        <div class="h-32 bg-gray-100 overflow-hidden">
                                            <img src="{{ Storage::disk('public')->url($related->featured_image) }}" 
                                                 alt="{{ $related->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>
                                    @endif
                                    
                                    <div class="p-4">
                                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $related->category->name }}
                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                {{ $related->difficulty_level === 'beginner' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $related->difficulty_level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $related->difficulty_level === 'advanced' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $related->difficulty_label }}
                                            </span>
                                        </div>
                                        
                                        <h4 class="font-satoshi text-base font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $related->title }}
                                        </h4>
                                        
                                        @if($related->description)
                                            <p class="text-gray-600 text-xs mb-3 line-clamp-2">
                                                {{ $related->description }}
                                            </p>
                                        @endif

                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <i data-lucide="eye" class="w-3 h-3"></i>
                                                {{ number_format($related->views_count) }} vistas
                                            </span>
                                            <span class="flex items-center gap-1 text-blue-600 font-medium">
                                                Ver
                                                <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </article>
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
