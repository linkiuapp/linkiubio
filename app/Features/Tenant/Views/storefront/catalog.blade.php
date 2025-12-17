@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Banner de Mesa/Habitación Activa -->
    @php
        $dineInTableId = session('dine_in_table_id');
        $dineInTableNumber = session('dine_in_table_number');
        $dineInType = session('dine_in_type');
    @endphp
    
    @if($dineInTableId && $dineInTableNumber)
        <div class="bg-brandPrimary-50 border border-brandPrimary-300 rounded-lg p-4 mb-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 justify-center">
                <div class="flex items-center gap-3 flex-1 min-w-0 justify-center">
                    @if($dineInType === 'mesa')
                        <i data-lucide="utensils" class="w-6 h-6 text-brandPrimary-300 flex-shrink-0"></i>
                    @else
                        <i data-lucide="bed" class="w-6 h-6 text-brandPrimary-300 flex-shrink-0"></i>
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="caption-strong text-brandPrimary-400">
                            Ordenando para {{ $dineInType === 'mesa' ? 'Mesa' : 'Habitación' }} #{{ $dineInTableNumber }}
                        </p>
                        <p class="caption text-brandNeutral-400">Tu pedido será entregado en tu {{ $dineInType === 'mesa' ? 'mesa' : 'habitación' }}</p>
                    </div>
                </div>
                <a 
                    href="{{ route('tenant.dine-in.checkout', $store->slug) }}" 
                    class="flex items-center justify-center bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 px-4 py-2 rounded-full caption-strong transition-colors whitespace-nowrap flex-shrink-0 w-full sm:w-auto text-center">
                    Ver Pedido
                </a>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="space-y-2">
        <nav class="flex text-xs md:text-sm font-medium text-slate-900">
            <a href="{{ route('tenant.home', $store->slug) }}" class="text-blue-600 hover:text-blue-900 transition-colors">Inicio</a>
            <span class="mx-2">/</span>
            <span class="text-xs md:text-sm font-medium text-slate-900">Catálogo</span>
        </nav>
        
        <p class="text-base font-medium text-slate-900">Encuentra todos nuestros productos</p>
    </div>

    <!-- Buscador con Auto-resultados -->
    <div class="bg-white rounded-full">
        <form method="GET" action="{{ route('tenant.catalog', $store->slug) }}">
            <!-- Input con autocomplete -->
            <div class="relative" id="search-container">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-16px h-16px text-slate-900 pr-2"></i>
                </div>
                <input type="text" 
                       name="search" 
                       id="search-input"
                       value="{{ request('search') }}"
                       placeholder="Buscar productos..."
                       autocomplete="off"
                       class="w-full pl-10 pr-3 py-4 bg-white rounded-full text-sm text-slate-900 placeholder-slate-900 focus:outline-none focus:ring-1 focus:ring-brandPrimary-200 focus:border-transparent transition-all">
                
                <!-- Botón limpiar solo si hay búsqueda -->
                @if(request('search'))
                    <button type="button" 
                            onclick="clearSearch()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i data-lucide="circle-x" class="w-16px h-16px text-brandNeutral-400 hover:text-brandNeutral-500"></i>
                    </button>
                @endif

                <!-- Dropdown de resultados -->
                <div id="search-results" 
                     class="absolute top-full left-0 right-0 mt-1 bg-brandWhite-100 border border-brandNeutral-200 rounded-full shadow-lg z-10 hidden max-h-64 overflow-y-auto">
                </div>
            </div>
        </form>
    </div>

    <!-- Ticker de Promociones -->
    @if($tickers && $tickers->count() > 0 && $tickerConfig)
        @php
            $scrollSpeeds = [
                'slow' => 20,
                'medium' => 15,
                'fast' => 10
            ];
            $scrollDuration = $scrollSpeeds[$tickerConfig['scroll_speed']] ?? 15;
        @endphp
        <div class="ticker-wrapper" 
             style="background-color: {{ $tickerConfig['background_color'] }}; color: {{ $tickerConfig['text_color'] }};">
            <div class="ticker-container">
                <div class="flex items-center gap-2 py-3 px-4 whitespace-nowrap ticker-scroll" 
                     data-duration="{{ $scrollDuration }}">
                    @foreach($tickers as $ticker)
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-base font-semibold">{{ $ticker->text }}</span>
                            <span class="mx-2 text-base font-medium">•</span>
                        </div>
                    @endforeach
                    {{-- Duplicar para efecto continuo --}}
                    @foreach($tickers as $ticker)
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="text-base font-semibold">{{ $ticker->text }}</span>
                            <span class="mx-2 text-base font-medium">•</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Categorías -->
    <div class="space-y-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-slate-900">Categorías</h3>
            <a href="{{ route('tenant.categories', $store->slug) }}" 
               class="flex items-center gap-1 text-blue-700 hover:text-blue-800 transition-colors">
                <span class="text-base font-medium">Ver más</span>
                <i data-lucide="arrow-up-right" class="w-4 h-4 text-blue-700"></i>
            </a>
        </div>
        
        @if($categories->count() > 0)
            @php
                // Calcular el color de fondo de las categorías una sola vez
                $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
                // Convertir hex a rgba con opacidad
                if (strpos($bgColor, '#') === 0) {
                    $hex = str_replace('#', '', $bgColor);
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    $categoryBgColor = "rgba($r, $g, $b, 0.1)";
                } else {
                    $categoryBgColor = $bgColor;
                }
            @endphp
            <div class="grid grid-cols-4 gap-2">
                @foreach($categories as $category)
                    <a href="{{ route('tenant.category', ['store' => $store->slug, 'categorySlug' => $category->slug]) }}" 
                       class="flex flex-col items-center group">
                        
                        <!-- Icono de la categoría con fondo colorido -->
                        <div class="w-72px h-72px mb-2 p-2 flex items-center justify-center rounded-2xl transition-all duration-200 hover:opacity-80" 
                             style="background-color: {{ $categoryBgColor }};">
                             @if($category->icon && $category->icon->image_url)
                                 <img src="{{ $category->icon->image_url }}" 
                                      alt="{{ $category->name }}" 
                                      class="w-56px h-56px object-contain aspect-square"
                                      style="aspect-ratio: 1 / 1;">
                             @else
                                 <i data-lucide="image" class="w-56px h-56px text-brandNeutral-400 group-hover:text-brandPrimary-300"></i>
                             @endif
                        </div>
                        
                        <!-- Nombre de la categoría -->
                        <span class="text-xs font-normal text-slate-900 transition-colors leading-tight">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8">
                <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_gallery.svg" alt="img_linkiu_v1_gallery" class="h-32 w-auto" loading="lazy">
                <p class="body-lg-bold text-center text-brandNeutral-400">No hay categorías disponibles</p>
                <a href="{{ route('tenant.categories', $store->slug) }}" 
                   class="gap-2 inline-flex mt-3 px-4 py-2 bg-brandPrimary-300 text-brandWhite-100 rounded-lg text-body-lg-medium hover:bg-brandPrimary-400 transition-colors">
                    Ver todas las categorías
                    <i data-lucide="arrow-up-right" class="w-24px h-24px sm:w-32px sm:h-32px"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- Resultados -->
    @if(request('search'))
        <div class="bg-brandInfo-50 rounded-lg p-3">
            <p class="caption text-brandInfo-300">
                Resultados para "<span class="caption-strong text-brandInfo-400">{{ request('search') }}</span>" - {{ $products->total() }} productos
            </p>
        </div>
    @endif

    <!-- Grid de Productos -->
    @if($products->count() > 0)
        @php
            // Calcular el color de fondo de las cards una sola vez
            $bgColor = $store->design && $store->design->header_background_color ? $store->design->header_background_color : '#f9fafb';
            // Convertir hex a rgba con opacidad
            if (strpos($bgColor, '#') === 0) {
                $hex = str_replace('#', '', $bgColor);
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                $cardBgColor = "rgba($r, $g, $b, 0.1)";
            } else {
                $cardBgColor = $bgColor;
            }
        @endphp
        <div class="space-y-4">
            @foreach($products as $product)
                @php
                    $estaAgotado = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->estaAgotado();
                    $tieneStockBajo = $product->controlaStock() && !$product->tieneStockIlimitado() && $product->tieneStockBajo();
                    $stockDisponible = $product->stock_disponible ?? 0;
                @endphp
                <div class="flex gap-2 md:gap-4 rounded-xl p-4 md:p-4 transition-all duration-200 hover:shadow-sm relative" 
                     style="background-color: {{ $cardBgColor }};">
                    <div class="flex items-center gap-4">
                        <!-- Imagen del producto -->
                        <div class="w-[120px] h-[120px] md:w-[126px] md:h-[126px] rounded-lg flex-shrink-0 overflow-hidden">
                            @if($product->main_image_url)
                                <img src="{{ $product->main_image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Información del producto -->
                        <div class="flex-1 min-w-0 flex flex-col md:gap-1 gap-0">
                            <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                                <!-- Badge de Stock bajo -->
                                @if($tieneStockBajo && $stockDisponible > 0)
                                    <div class="flex items-center gap-1.5 w-fit md:mb-0 mb-1">
                                        <span class="bg-red-50 text-red-600 rounded-full px-2 py-1 text-xs font-semibold text-red-600">
                                            Queda {{ $stockDisponible }} unidad{{ $stockDisponible > 1 ? 'es' : '' }}
                                        </span>
                                    </div>
                                @elseif($estaAgotado)
                                    <div class="flex items-center gap-1.5 w-fit">
                                        <span class="text-xs font-medium text-white bg-red-500 px-2 py-0.5 rounded-full">
                                            Agotado
                                        </span>
                                    </div>
                                @endif
                                @if($product->categories->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($product->categories->take(1) as $category)
                                            <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-50 rounded-full">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Título del producto -->
                            <h3 class="text-base font-bold text-slate-900 leading-tight">{{ $product->name }}</h3>
                            
                            <!-- Descripción -->
                            @if($product->description)
                                <p class="text-xs font-normal text-slate-900 leading-tight line-clamp-1">{{ $product->description }}</p>
                            @endif

                            <!-- Precios -->
                            <div class="flex items-center gap-2">
                                @if($product->tienePromocionActiva())
                                    <span class="text-base font-normal text-slate-900 line-through">${{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-base font-bold text-slate-900">${{ number_format($product->precio_promocional, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-base font-bold text-slate-900">${{ number_format($product->price, 0, ',', '.') }}</span>
                                @endif
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex gap-2 items-center md:mt-0 mt-2">
                                <x-add-to-cart-button :product="$product" :store="$store" />
                                @if(featureEnabled($store, 'favoritos'))
                                    <button class="p-3 flex items-center justify-center transition-transform bg-red-50 hover:bg-red-100 rounded-full hover:scale-110" 
                                            data-favorite-btn
                                            data-product-id="{{ $product->id }}">
                                        <i data-lucide="heart" class="w-6 h-6 text-red-500 hover:text-red-600" style="fill: currentColor;"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" alt="img_linkiu_v1_ghost" class="h-32 w-auto" loading="lazy">
            <p class="body-lg-bold text-center text-brandNeutral-400">No hay productos disponibles</p>
        </div>
    @endif
</div>

@push('styles')
<style>
    .ticker-wrapper {
        margin-bottom: 24px;
    }
    .ticker-container {
        overflow: hidden;
        width: 100%;
    }
    /* Asegurar que los margins se apliquen correctamente */
    .ticker-container {
        margin: inherit;
    }
    .ticker-scroll {
        display: inline-flex;
        white-space: nowrap;
        will-change: transform;
        animation: ticker-move linear infinite;
        width: max-content;
        box-sizing: content-box;
    }
    .ticker-scroll[data-duration="10"] {
        animation-duration: 10s;
    }
    .ticker-scroll[data-duration="15"] {
        animation-duration: 15s;
    }
    .ticker-scroll[data-duration="20"] {
        animation-duration: 20s;
    }
    @keyframes ticker-move {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let searchTimeout;
    const searchInput = document.getElementById('search-input');
    const searchResults = document.getElementById('search-results');

    function clearSearch() {
        searchInput.value = '';
        searchResults.classList.add('hidden');
        searchInput.form.submit();
    }

    function performSearch(query) {
        if (query.length < 3) {
            searchResults.classList.add('hidden');
            return;
        }

        fetch(`{{ route('tenant.search.api', $store->slug) }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(products => {
                if (products.length === 0) {
                    searchResults.classList.add('hidden');
                    return;
                }

                const html = products.map(product => `
                    <a href="${product.url}" class="flex items-center gap-3 p-3 hover:bg-accent-50 transition-colors border-b border-accent-100 last:border-b-0">
                        <div class="w-12 h-12 bg-accent-100 rounded-lg overflow-hidden flex-shrink-0">
                            ${product.image ? 
                                `<img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">` :
                                `<div class="w-full h-full flex items-center justify-center text-black-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-medium text-sm text-black-400 line-clamp-1">${product.name}</h4>
                            <p class="text-sm font-bold text-primary-300">$${product.price}</p>
                        </div>
                    </a>
                `).join('');

                searchResults.innerHTML = html;
                searchResults.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error en búsqueda:', error);
                searchResults.classList.add('hidden');
            });
    }

    // Eventos del input
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
        if (e.key === 'Escape') {
            clearSearch();
        }
    });

    // Cerrar dropdown al hacer click fuera
    document.addEventListener('click', function(e) {
        if (!document.getElementById('search-container').contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection

