<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product', 'store']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product', 'store']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $estaAgotado = $product->controlaStock() 
                   && !$product->tieneStockIlimitado() 
                   && $product->estaAgotado();
?>

<div class="flex-shrink-0 relative">
    <?php if($estaAgotado): ?>
        
        <button type="button"
                disabled
                class="bg-gray-300 text-gray-500 font-medium text-sm py-3 px-6 rounded-full transition-colors text-center cursor-not-allowed opacity-50">
                <span class="text-sm font-medium">agotado</span>
        </button>
    <?php elseif($product->type === 'variable'): ?>
        
        <button type="button"
                onclick="event.stopPropagation(); event.preventDefault(); window.location.href='<?php echo e(route('tenant.product', [$store->slug, $product->slug])); ?>';"
                class="bg-slate-900 hover:bg-slate-800 text-white font-medium text-sm py-2 px-3 md:py-3 md:px-4 rounded-full transition-colors text-center">
                <span class="text-sm font-medium">Ver producto</span>
        </button>
    <?php else: ?>
        
        <button type="button" 
                class="add-to-cart-btn bg-slate-900 hover:bg-slate-800 text-white font-medium text-sm py-3 px-6 rounded-full transition-colors text-center" 
                data-product-id="<?php echo e($product->id); ?>"
                data-product-name="<?php echo e($product->name); ?>"
                data-product-price="<?php echo e($product->price); ?>"
                data-product-image="<?php echo e($product->main_image_url); ?>"
                onclick="event.stopPropagation(); event.preventDefault();">
                <span class="text-sm font-medium">Agregar</span>
        </button>
    <?php endif; ?>
    
    
    <span class="product-quantity-badge hidden absolute -top-2 -right-2 bg-brandError-300 text-brandWhite-50 text-[11px] font-bold w-6 h-6 rounded-full flex items-center justify-center border-2 border-brandWhite-200 shadow-lg transition-all duration-300"
          data-product-badge="<?php echo e($product->id); ?>">
        0
    </span>
</div>

<?php /**PATH C:\laragon\www\Liniu_Final\resources\views/components/add-to-cart-button.blade.php ENDPATH**/ ?>