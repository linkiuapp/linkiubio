@props([
    'store',
    'design'
])

{{-- Vista previa del header de la tienda --}}
<div
    class="mx-auto"
    x-data="(() => ({
        defaults: {
            name: @js($store->name),
            description: @js($store->description ?? 'Descripción de la tienda'),
            initials: @js(substr($store->name, 0, 2)),
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
    {{-- Header --}}
    <div 
        class="p-6 py-8 rounded-xl w-[480px]"
        :style="{ backgroundColor: preview.bgColor }"
    >
        {{-- Logo y Nombre --}}
        <div class="flex flex-col items-center gap-4 mb-4">
            {{-- Logo --}}
            <template x-if="preview.logo">
                <img :src="preview.logo" class="w-24 h-24 rounded-full object-cover" alt="Logo">
            </template>
            <template x-if="!preview.logo">
                <div class="size-24 rounded-full bg-accent-100 flex items-center justify-center">
                    <span class="text-black-300 text-xl font-bold" x-text="preview.initials"></span>
                </div>
            </template>

            {{-- Nombre --}}
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
</div> 