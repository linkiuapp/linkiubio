@extends('frontend.layouts.app')

@section('content')
<div class="p-4 space-y-4">
    <!-- Breadcrumb -->
    <nav class="flex text-xs text-info-300">
        <a href="{{ route('tenant.home', $store->slug) }}" class="hover:text-info-200 transition-colors">Inicio</a>
        <span class="mx-1">/</span>
        <a href="{{ route('tenant.catalog', $store->slug) }}" class="hover:text-info-200 transition-colors">Catálogo</a>
        <span class="mx-1">/</span>
        <span class="text-secondary-300 font-medium">{{ $product->name }}</span>
    </nav>

    <!-- Producto Principal -->
    <div class="bg-white rounded-lg p-4 space-y-4">
        <!-- Imagen Principal -->
        <div class="w-full aspect-square sm:h-72 bg-accent-100 rounded-xl overflow-hidden mb-3" id="main-image-container">
            @if($product->images->count() > 0)
                <img src="{{ $product->images->first()->image_url }}" 
                     alt="{{ $product->name }}" 
                     id="main-image"
                     class="w-full h-full object-cover transition-all duration-300">
            @elseif($product->main_image_url)
                <img src="{{ $product->main_image_url }}" 
                     alt="{{ $product->name }}" 
                     id="main-image"
                     class="w-full h-full object-cover transition-all duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center text-black-200">
                    <x-solar-gallery-outline class="w-16 h-16" />
                </div>
            @endif
        </div>

        <!-- Galería de miniaturas (solo si hay más de 1 imagen) -->
        @if($product->images->count() > 1)
            <div class="space-y-2">
                <p class="text-xs font-medium text-black-400">Imágenes ({{ $product->images->count() }})</p>
                <div class="flex gap-2 overflow-x-auto pb-2 -mx-4 px-4">
                    @foreach($product->images as $index => $image)
                        <div class="w-20 h-20 sm:w-16 sm:h-16 bg-accent-100 rounded-lg overflow-hidden flex-shrink-0 cursor-pointer border-2 transition-all duration-200 image-thumb {{ $index === 0 ? 'border-primary-300' : 'border-transparent hover:border-primary-200' }}" 
                             onclick="changeMainImage('{{ $image->image_url }}', {{ $index }})">
                            <img src="{{ $image->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Información del Producto -->
        <div class="space-y-3">
            <!-- Título, precio y compartir -->
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <h1 class="text-lg font-semibold text-black-400 mb-1">{{ $product->name }}</h1>
                    <div class="text-xl font-bold text-primary-300">
                        ${{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>
                
                <!-- Botón Compartir (solo si está permitido) -->
                @if($product->allow_sharing)
                <button onclick="shareProduct()" 
                        class="flex-shrink-0 flex items-center gap-2 bg-success-300 hover:bg-success-400 text-white px-3 py-2 rounded-lg text-xs font-medium transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <span class="hidden sm:inline">Compartir</span>
                </button>
                @endif
            </div>

            <!-- Categorías -->
            @if($product->categories->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($product->categories as $category)
                        <a href="{{ route('tenant.category', [$store->slug, $category->slug]) }}" 
                           class="flex items-center gap-1 px-2 py-1 bg-primary-50 text-primary-300 rounded-lg text-xs hover:bg-primary-100 transition-colors">
                            @if($category->icon && $category->icon->image_url)
                                <img src="{{ $category->icon->image_url }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-3 h-3 object-contain">
                            @endif
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Descripción -->
            @if($product->description)
                <div class="space-y-2">
                    <h3 class="text-sm font-medium text-black-400">Descripción</h3>
                    <p class="text-sm text-black-300 leading-relaxed">{{ $product->description }}</p>
                </div>
            @endif

            <!-- SKU -->
            @if($product->sku)
                <div class="text-xs text-black-200">
                    SKU: {{ $product->sku }}
                </div>
            @endif
        </div>

        <!-- Botón Agregar al Carrito -->
        <div class="pt-2">
            <button class="w-full bg-secondary-300 hover:bg-secondary-200 text-white py-3 rounded-lg font-medium transition-colors flex items-center justify-center gap-2 add-to-cart-btn"
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}"
                    data-product-price="{{ $product->price }}"
                    data-product-image="{{ $product->main_image_url }}">
                <x-solar-cart-plus-outline class="w-5 h-5" />
                Agregar al Carrito
            </button>
        </div>
    </div>

    <!-- Productos Relacionados -->
    @if($relatedProducts->count() > 0)
        <div class="space-y-3">
            <h2 class="text-base font-semibold text-black-400">Productos Relacionados</h2>
            
            <div class="grid grid-cols-2 gap-3">
                @foreach($relatedProducts as $relatedProduct)
                    <a href="{{ route('tenant.product', [$store->slug, $relatedProduct->slug]) }}" 
                       class="bg-white rounded-lg p-3 border border-accent-200 hover:border-primary-200 transition-colors">
                        <!-- Imagen -->
                        <div class="w-full h-24 bg-accent-100 rounded-lg overflow-hidden mb-2">
                            @if($relatedProduct->main_image_url)
                                <img src="{{ $relatedProduct->main_image_url }}" 
                                     alt="{{ $relatedProduct->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-black-200">
                                    <x-solar-gallery-outline class="w-6 h-6" />
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="space-y-1">
                            <h3 class="text-sm font-medium text-black-400 line-clamp-1">{{ $relatedProduct->name }}</h3>
                            <div class="text-sm font-bold text-primary-300">
                                ${{ number_format($relatedProduct->price, 0, ',', '.') }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function changeMainImage(imageUrl, index) {
        // Cambiar imagen principal
        const mainImage = document.getElementById('main-image');
        if (mainImage) {
            mainImage.style.opacity = '0.7';
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = '1';
            }, 150);
        }

        // Actualizar thumbnails activos
        document.querySelectorAll('.image-thumb').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.remove('border-transparent', 'hover:border-primary-200');
                thumb.classList.add('border-primary-300');
            } else {
                thumb.classList.remove('border-primary-300');
                thumb.classList.add('border-transparent', 'hover:border-primary-200');
            }
        });
    }

    // Navegación con teclado (opcional)
    document.addEventListener('keydown', function(e) {
        const thumbs = document.querySelectorAll('.image-thumb');
        if (thumbs.length <= 1) return;

        const currentActive = Array.from(thumbs).findIndex(thumb => 
            thumb.classList.contains('border-primary-300'));
        
        if (e.key === 'ArrowRight' && currentActive < thumbs.length - 1) {
            thumbs[currentActive + 1].click();
        } else if (e.key === 'ArrowLeft' && currentActive > 0) {
            thumbs[currentActive - 1].click();
        }
    });

    // Función para compartir producto por WhatsApp
    function shareProduct() {
        const productName = "{{ $product->name }}";
        const productPrice = "${{ number_format($product->price, 0, ',', '.') }}";
        const productUrl = "{{ url()->current() }}";
        const storeName = "{{ $store->name }}";
        
        const message = `🛍️ *${productName}*\n\n` +
                       `💰 Precio: ${productPrice}\n\n` +
                       `🏪 ${storeName}\n\n` +
                       `🔗 Ver producto: ${productUrl}`;
        
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    }
</script>
@endpush
@endsection
