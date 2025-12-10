<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'store',
    'design'
]));

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

foreach (array_filter(([
    'store',
    'design'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>


<div
    class="w-full max-w-full overflow-hidden"
    x-data="(() => ({
        defaults: {
            name: <?php echo \Illuminate\Support\Js::from($store->name)->toHtml() ?>,
            description: <?php echo \Illuminate\Support\Js::from($store->description ?? 'Descripción de la tienda')->toHtml() ?>,
            initials: <?php echo \Illuminate\Support\Js::from(substr($store->name, 0, 2))->toHtml() ?>,
            bgColor: '#FFFFFF',
            textColor: '#000000',
            descriptionColor: '#666666',
        },
        preview: {
            name: '',
            description: '',
            initials: '',
            bgColor: '',
            textColor: '',
            descriptionColor: '',
            logo: null,
        },
        listener: null,
        apply(data = {}) {
            const safeName = (data.storeName ?? '').toString().trim();
            const safeDescription = (data.storeDescription ?? '').toString().trim();
            const safeBg = (data.bgColor ?? '').toString().toUpperCase();
            const safeText = (data.textColor ?? '').toString().toUpperCase();
            const safeDescriptionColor = (data.descriptionColor ?? '').toString().toUpperCase();
            this.preview.name = safeName !== '' ? safeName : this.defaults.name;
            this.preview.description = safeDescription !== '' ? safeDescription : this.defaults.description;
            this.preview.initials = this.preview.name.substring(0, 2).toUpperCase();
            this.preview.bgColor = /^#[0-9A-F]{6}$/i.test(safeBg) ? safeBg : this.defaults.bgColor;
            this.preview.textColor = /^#[0-9A-F]{6}$/i.test(safeText) ? safeText : this.defaults.textColor;
            this.preview.descriptionColor = /^#[0-9A-F]{6}$/i.test(safeDescriptionColor) ? safeDescriptionColor : this.defaults.descriptionColor;
            this.preview.logo = data.logo ?? null;
        },
        init() {
            const currentStore = Alpine.store('design');
            if (currentStore) {
                this.apply({
                    storeName: currentStore.storeName,
                    storeDescription: currentStore.storeDescription,
                    bgColor: currentStore.bgColor,
                    textColor: currentStore.textColor,
                    descriptionColor: currentStore.descriptionColor,
                    logo: currentStore.logo,
                });
            } else {
                this.apply();
            }
            this.listener = (event) => {
                const detail = event?.detail || {};
                this.apply(detail);
            };
            document.addEventListener('store-preview:update', this.listener);
        },
    }))()"
    x-init="init()"
>
    
    <div 
        class="p-6 py-8 rounded-xl w-full max-w-full mx-auto"
        :style="{ backgroundColor: preview.bgColor }"
    >
        
        <div class="flex flex-col items-center gap-4 mb-4">
            
            <template x-if="preview.logo">
                <img :src="preview.logo" class="w-24 h-24 rounded-full object-cover" alt="Logo">
            </template>
            <template x-if="!preview.logo">
                <div class="size-24 rounded-full bg-accent-100 flex items-center justify-center">
                    <span class="text-black-300 text-xl font-bold" x-text="preview.initials"></span>
                </div>
            </template>

            
            <div>
                <h1 
                    class="text-xl text-center font-black mb-1 capitalize"
                    :style="{ color: preview.textColor }"
                    x-text="preview.name"
                ></h1>
                <p 
                    class="text-base font-semibold text-center"
                    :style="{ color: preview.descriptionColor }"
                    x-text="preview.description"
                ></p>
            </div>
        </div>
    </div>
</div> <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/components/Core/header-preview.blade.php ENDPATH**/ ?>