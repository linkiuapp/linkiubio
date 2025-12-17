@props(['product', 'store'])

@php
    $estaAgotado = $product->controlaStock() 
                   && !$product->tieneStockIlimitado() 
                   && $product->estaAgotado();
@endphp

<div class="flex-shrink-0 relative">
    @if($estaAgotado)
        {{-- Producto agotado: Botón deshabilitado --}}
        <button type="button"
                disabled
                class="bg-gray-300 text-gray-500 font-medium text-sm py-3 px-6 rounded-full transition-colors text-center cursor-not-allowed opacity-50">
                <span class="text-sm font-medium">Producto agotado</span>
        </button>
    @elseif($product->type === 'variable')
        {{-- Producto con variantes: Ver opciones --}}
        <button type="button"
                onclick="event.stopPropagation(); event.preventDefault(); window.location.href='{{ route('tenant.product', [$store->slug, $product->slug]) }}';"
                class="bg-slate-900 hover:bg-slate-800 text-white font-medium text-sm py-2 px-3 md:py-3 md:px-4 rounded-full transition-colors text-center">
                <span class="text-sm font-medium">Ver producto</span>
        </button>
    @else
        {{-- Producto simple: Agregar directo --}}
        <button type="button" 
                class="add-to-cart-btn bg-slate-900 hover:bg-slate-800 text-white font-medium text-sm py-3 px-6 rounded-full transition-colors text-center" 
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                data-product-price="{{ $product->price }}"
                data-product-image="{{ $product->main_image_url }}"
                onclick="event.stopPropagation(); event.preventDefault();">
                <span class="text-sm font-medium">Agregar</span>
        </button>
    @endif
    
    {{-- Badge de cantidad en carrito (aparece en TODOS los productos) --}}
    <span class="product-quantity-badge hidden absolute -top-2 -right-2 bg-brandError-300 text-brandWhite-50 text-[11px] font-bold w-6 h-6 rounded-full flex items-center justify-center border-2 border-brandWhite-200 shadow-lg transition-all duration-300"
          data-product-badge="{{ $product->id }}">
        0
    </span>
</div>

