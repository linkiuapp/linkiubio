@props(['product', 'store'])

<div class="flex-shrink-0 relative">
    @if($product->type === 'variable')
        {{-- Producto con variantes: Ver opciones --}}
        <button type="button"
                onclick="event.stopPropagation(); event.preventDefault(); window.location.href='{{ route('tenant.product', [$store->slug, $product->slug]) }}';"
                class="bg-brandPrimary-300 hover:bg-brandPrimary-400 w-11 h-11 rounded-lg flex items-center justify-center transition-colors">
                <i data-lucide="eye" class="w-16px h-16px text-brandWhite-200"></i>
        </button>
    @else
        {{-- Producto simple: Agregar directo --}}
        <button type="button" 
                class="add-to-cart-btn bg-brandPrimary-300 hover:bg-brandPrimary-400 w-11 h-11 rounded-lg flex items-center justify-center transition-colors" 
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                data-product-price="{{ $product->price }}"
                data-product-image="{{ $product->main_image_url }}"
                onclick="event.stopPropagation(); event.preventDefault();">
                <i data-lucide="badge-plus" class="w-16px h-16px text-brandWhite-200"></i>
        </button>
    @endif
    
    {{-- Badge de cantidad en carrito (aparece en TODOS los productos) --}}
    <span class="product-quantity-badge hidden absolute -top-2 -right-2 bg-brandError-300 text-brandWhite-50 text-[11px] font-bold w-6 h-6 rounded-full flex items-center justify-center border-2 border-brandWhite-200 shadow-lg transition-all duration-300"
          data-product-badge="{{ $product->id }}">
        0
    </span>
</div>

