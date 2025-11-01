@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-6">
    <!-- Header -->
    <div class="space-y-3">
        <nav class="flex caption text-brandInfo-300">
            <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-brandInfo-400 transition-colors">Inicio</a>
            <span class="mx-2">/</span>
            <span class="text-brandNeutral-400 caption">Catálogo</span>
        </nav>
        
        <div class="space-y-1">
            <h1 class="h3 text-brandNeutral-400">Catálogo</h1>
            <p class="caption text-brandNeutral-400">Encuentra todos nuestros productos</p>
        </div>
    </div>

    <!-- Buscador con Auto-resultados -->
    <div class="bg-brandWhite-100 rounded-full p-4">
        <form method="GET" action="{{ route('tenant.catalog', $store->slug) }}">
            <!-- Input con autocomplete -->
            <div class="relative" id="search-container">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-16px h-16px text-brandNeutral-400 pr-2"></i>
                </div>
                <input type="text" 
                       name="search" 
                       id="search-input"
                       value="{{ request('search') }}"
                       placeholder="Buscar productos..."
                       autocomplete="off"
                       class="w-full pl-10 pr-3 py-2.5 bg-brandWhite-300 rounded-full text-body-lg-regular text-brandNeutral-400 placeholder-brandNeutral-400 focus:outline-none focus:ring-1 focus:ring-brandPrimary-200 focus:border-transparent transition-all">
                
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

    <!-- Grid de Categorías -->
    <div>
        <h3 class="h3 text-brandNeutral-400 mb-4">Categorías</h3>
        
        @if($categories->count() > 0)
            <div class="grid grid-cols-4 gap-2">
                @foreach($categories as $category)
                    <a href="{{ route('tenant.category', ['store' => $store->slug, 'categorySlug' => $category->slug]) }}" 
                       class="flex flex-col items-center group">
                        
                        <!-- Icono de la categoría con fondo colorido -->
                        <div class="w-78px h-78 mb-2 p-2 flex items-center justify-center rounded-2xl bg-gradient-to-br from-brandWhite-100 to-brandWhite-100 hover:from-brandPrimary-100 hover:to-brandWhite-100 transition-all duration-200">
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
                        <span class="caption text-center text-brandNeutral-400 transition-colors leading-tight">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-8">
                <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_gallery.svg" alt="img_linkiu_v1_gallery" class="h-32 w-auto" loading="lazy">
                <p class="body-lg-bold text-center text-brandNeutral-400">No hay categorías disponibles</p>
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
            <div class="space-y-6">
                @foreach($products as $product)
                    <a href="{{ route('tenant.product', [$store->slug, $product->slug]) }}" 
                       class="bg-brandWhite-100 hover:bg-brandPrimary-50 rounded-lg p-4 hover:shadow-sm transition-all duration-200 block relative">

                        <div class="flex items-center gap-3">
                            <!-- Imagen del producto -->
                            <div class="w-[78px] h-[78px] rounded-lg flex-shrink-0 overflow-hidden">
                                @if($product->main_image_url)
                                    <img src="{{ $product->main_image_url }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-brandNeutral-400">
                                        <i data-lucide="image" class="w-56px h-56px text-brandNeutral-400"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Información del producto -->
                            <div class="flex-1 min-w-0">
                                <h3 class="body-lg-bold text-brandNeutral-400 line-clamp-1">{{ $product->name }}</h3>
                                
                                @if($product->description)
                                    <p class="caption text-brandNeutral-400 line-clamp-1">{{ $product->description }}</p>
                                @endif

                                <!-- Precio prominente -->
                                <div class="body-lg-bold text-brandNeutral-400 mb-1">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </div>

                                <!-- Categorías pequeñas -->
                                @if($product->categories->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($product->categories->take(1) as $category)
                                            <span class="px-2 py-0.5 bg-brandSuccess-50 text-brandSuccess-400 rounded-full caption">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                        @if($product->categories->count() > 1)
                                            <span class="bg-brandSuccess-50 px-2 py-0.5 caption items-center text-brandSuccess-400 rounded-full">+{{ $product->categories->count() - +1 }}</span>
                                        @endif
                                    </div>
                                @endif

                            </div>

                            <!-- Botón agregar al carrito -->
                             <div class="flex flex-col gap-2">
                                <x-add-to-cart-button :product="$product" :store="$store" />
                                <div class="bg-brandError-50 p-2 rounded-lg">
                                <i data-lucide="heart-plus" class="w-16px h-16px text-brandError-400"></i>
                                </div>
                             </div>

                            
                        </div>
                    </a>
                @endforeach
            </div>
        @else
        <div class="flex flex-col items-center justify-center">
            <img src="https://cdn.jsdelivr.net/gh/linkiuapp/medialink@main/Assets_Fronted/img_linkiu_v1_ghost.svg" alt="img_linkiu_v1_ghost" class="h-32 w-auto" loading="lazy">
            <p class="body-lg-bold text-center text-brandNeutral-400">No hay productos disponibles</p>
        </div>
        @endif
</div>

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

