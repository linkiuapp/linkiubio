@props(['product', 'store'])

<div class="flex-shrink-0 relative">
    @if($product->type === 'variable')
        {{-- Producto con variantes: Ver opciones --}}
        <a href="{{ route('tenant.product', [$store->slug, $product->slug]) }}" 
           class="bg-secondary-300 hover:bg-secondary-200 text-white w-11 h-11 rounded-lg flex items-center justify-center transition-colors"
           onclick="event.stopPropagation();">
            <x-solar-eye-outline class="w-5 h-5" />
        </a>
    @else
        {{-- Producto simple: Agregar directo --}}
        <button type="button" 
                class="add-to-cart-btn bg-secondary-300 hover:bg-secondary-200 text-white w-11 h-11 rounded-lg flex items-center justify-center transition-colors" 
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                data-product-price="{{ $product->price }}"
                data-product-image="{{ $product->main_image_url }}">
            <x-solar-cart-plus-outline class="w-5 h-5" />
        </button>
    @endif
    
    {{-- Badge de cantidad en carrito (aparece en TODOS los productos) --}}
    <span class="product-quantity-badge hidden absolute -top-2 -right-2 bg-success-300 text-white text-[11px] font-bold w-6 h-6 rounded-full flex items-center justify-center border-2 border-white shadow-lg transition-all duration-300"
          data-product-badge="{{ $product->id }}">
        0
    </span>
</div>

