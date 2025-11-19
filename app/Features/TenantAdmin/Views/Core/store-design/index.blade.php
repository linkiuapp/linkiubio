<x-tenant-admin-layout :store="$store">
    @section('title', 'Diseño de tienda')

    @section('content')
    <div
        class="space-y-6"
        x-data="storeDesignPage()"
        x-init="init()"
        x-effect="pushPreviewState()"
        x-cloak
    >
        {{-- SECTION: Header --}}
        <div class="flex flex-col-2 gap-3 items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">Diseño de tienda</h1>
                <p class="text-sm text-gray-500">Configura los textos, colores e identidad visual que verá tu clientela.</p>
            </div>
            <div class="flex items-center gap-2">
                <x-button-icon
                    type="solid"
                    color="dark"
                    icon="sparkles"
                    text="Publicar cambios"
                    html-type="button"
                    @click="openPublishModal()"
                />
            </div>
        </div>

        {{-- SECTION: Feedback Alert --}}
        <template x-if="feedback.show && feedback.type === 'success'">
            <x-alert-bordered
                type="success"
                title="Cambios guardados"
                class="mt-2"
            >
                <span x-text="feedback.message"></span>
            </x-alert-bordered>
        </template>

        <template x-if="feedback.show && feedback.type === 'error'">
            <x-alert-bordered
                type="error"
                title="Ocurrió un error"
                class="mt-2"
            >
                <span x-text="feedback.message"></span>
            </x-alert-bordered>
        </template>

        {{-- SECTION: Main Layout --}}
        <div class="grid gap-4 xl:grid-cols-12">
            {{-- REGION: Información y colores (card única) --}}
            <div class="xl:col-span-8">
                <x-card-base title="Información del encabezado" shadow="sm">
                    <div class="grid gap-6 pt-4 xl:grid-cols-3">
                        <div class="space-y-4 xl:col-span-2">
                            <x-input-with-label
                                label="Nombre de la tienda"
                                name="store_name"
                                placeholder="Nombre de tu tienda"
                                :value="$store->name"
                                maxlength="40"
                                container-class="w-full"
                                x-model="form.storeName"
                                @input="handleNameInput($event)"
                            />

                            <x-textarea-with-label
                                label="Descripción breve"
                                textarea-name="store_description"
                                placeholder="Describe brevemente qué ofrece tu tienda"
                                rows="4"
                                container-class="w-full"
                                x-model="form.storeDescription"
                                @input="handleDescriptionInput($event)"
                            >{{ $store->description }}</x-textarea-with-label>

                            <p class="text-xs text-gray-500">El nombre admite letras, números, guiones y acentos (máx. 40). La descripción admite hasta 50 caracteres.</p>
                        </div>

                        <div class="space-y-4 xl:col-span-1">
                            <x-color-picker-basic
                                name="header_background_color"
                                label="Color de fondo"
                                :value="$design->header_background_color"
                                helper="Formato #RRGGBB"
                                x-model="colors.bgColor"
                            />
                            <x-color-picker-basic
                                name="header_text_color"
                                label="Color del nombre"
                                :value="$design->header_text_color"
                                helper="Formato #RRGGBB"
                                x-model="colors.textColor"
                            />
                            <x-color-picker-basic
                                name="header_description_color"
                                label="Color de la descripción"
                                :value="$design->header_description_color"
                                helper="Formato #RRGGBB"
                                x-model="colors.descriptionColor"
                            />
                        </div>
                    </div>
                </x-card-base>
            </div>

            {{-- REGION: Vista previa --}}
            <div class="xl:col-span-4">
                <x-card-base title="Vista previa" shadow="sm">
                    <div class="mx-auto mt-4 w-[480px]">
                        <x-tenant-admin::core.header-preview :store="$store" :design="$design" />
                    </div>
                </x-card-base>
            </div>
        </div>

        <div class="grid gap-4 xl:grid-cols-2">
            {{-- ITEM: Logo --}}
            <div>
                <x-card-base title="Logo" shadow="sm">
                    <div class="space-y-4 pt-4">
                        <div class="flex flex-col items-center justify-center gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4 text-center" x-data>
                            <template x-if="Alpine.store('design').logo">
                                <img :src="Alpine.store('design').logo" alt="Logo actual" class="h-16 w-16 rounded-full object-contain" />
                            </template>
                            <template x-if="!Alpine.store('design').logo">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <i data-lucide="image" class="size-8"></i>
                                    <span class="text-sm">Sin logo cargado</span>
                                </div>
                            </template>
                        </div>

                        <x-file-upload-with-validation
                            name="store_logo"
                            accept="image/png,image/jpeg,image/webp"
                            max-file-size="2"
                            help-text="PNG, JPG o WebP. Máx. 2MB"
                        />
                    </div>
                </x-card-base>
            </div>

            {{-- ITEM: Favicon --}}
            <div>
                <x-card-base title="Favicon" shadow="sm">
                    <div class="space-y-4 pt-4">
                        <div class="flex flex-col items-center justify-center gap-3 rounded-xl border border-gray-200 bg-gray-50 p-4 text-center" x-data>
                            <template x-if="Alpine.store('design').favicon">
                                <img :src="Alpine.store('design').favicon" alt="Favicon actual" class="h-16 w-16 rounded-lg object-contain" />
                            </template>
                            <template x-if="!Alpine.store('design').favicon">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <i data-lucide="sparkles" class="size-6"></i>
                                    <span class="text-sm">Sin favicon cargado</span>
                                </div>
                            </template>
                        </div>

                        <x-file-upload-with-validation
                            name="store_favicon"
                            accept="image/png,image/x-icon,image/vnd.microsoft.icon,image/svg+xml"
                            max-file-size="1"
                            help-text="PNG o ICO. Máx. 1MB"
                        />
                    </div>
                </x-card-base>
            </div>
        </div>

        {{-- SECTION: Publish Modal --}}
        <div
            x-show="publishModalOpen"
            class="fixed inset-0 z-[90] flex items-center justify-center"
            style="display: none;"
        >
            <div
                class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
                @click="closePublishModal()"
            ></div>
            <div
                class="relative w-full max-w-lg rounded-2xl border border-gray-200 bg-white shadow-lg"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
            >
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Confirmar publicación</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600" @click="closePublishModal()">
                        <span class="sr-only">Cerrar</span>
                        <i data-lucide="x" class="size-5"></i>
                    </button>
                </div>
                <div class="space-y-3 px-6 py-4 text-sm text-gray-600">
                    <p>Se actualizará el encabezado de tu tienda con los colores, nombre y descripción actuales.</p>
                    <ul class="list-inside list-disc text-gray-500">
                        <li>El logo y el favicon se publicarán si fueron reemplazados.</li>
                        <li>Los cambios serán visibles inmediatamente.</li>
                    </ul>
                </div>
                <div class="flex items-center justify-end gap-2 border-t border-gray-200 px-6 py-4">
                    <x-button-base
                        type="outline"
                        color="secondary"
                        text="Cancelar"
                        html-type="button"
                        x-bind:disabled="loading.publish"
                        @click="closePublishModal()"
                    />
                    <x-button-icon
                        type="solid"
                        color="success"
                        icon="send"
                        text="Publicar ahora"
                        html-type="button"
                        @click="confirmPublish()"
                        x-bind:disabled="loading.publish"
                    />
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            const storeSlug = @js($store->slug);
            const cacheKey = `store-design-${storeSlug}`;

            const readCachedDesign = () => {
                if (!window.localStorage) {
                    return null;
                }
                try {
                    const raw = window.localStorage.getItem(cacheKey);
                    return raw ? JSON.parse(raw) : null;
                } catch (error) {
                    console.warn('[StoreDesign] No se pudo leer el cache local', error);
                    return null;
                }
            };

            const initialFromServer = @json($initialDesign);
            const cachedDesign = readCachedDesign();
            const initialDesign = cachedDesign ? { ...initialFromServer, ...cachedDesign } : initialFromServer;

            window.__initialDesign = initialDesign;
            window.__designCacheKey = cacheKey;

            const normalizeAsset = (url) => {
                if (!url) {
                    return null;
                }
                try {
                    const currentProtocol = window.location.protocol;
                    const assetUrl = new URL(url, window.location.origin);
                    if (currentProtocol === 'https:' && assetUrl.protocol === 'http:') {
                        const insecureHosts = ['127.0.0.1', 'localhost'];
                        if (!insecureHosts.includes(assetUrl.hostname)) {
                            assetUrl.protocol = 'https:';
                            return assetUrl.toString();
                        }
                    }
                    return assetUrl.toString();
                } catch (error) {
                    return url;
                }
            };

            Alpine.store('design', {
                bgColor: initialDesign?.bgColor || '#FFFFFF',
                textColor: initialDesign?.textColor || '#000000',
                descriptionColor: initialDesign?.descriptionColor || '#666666',
                logo: normalizeAsset(initialDesign?.logo) || null,
                favicon: normalizeAsset(initialDesign?.favicon) || null,
                storeName: initialDesign?.storeName ?? @json($store->name),
                storeDescription: initialDesign?.storeDescription ?? @json($store->description),
            });
        });

        function storeDesignPage() {
            return {
                storeSlug: @js($store->slug),
                designCacheKey: window.__designCacheKey || null,
                colors: {
                    bgColor: window.__initialDesign?.bgColor ?? @json($design->header_background_color ?? '#FFFFFF'),
                    textColor: window.__initialDesign?.textColor ?? @json($design->header_text_color ?? '#000000'),
                    descriptionColor: window.__initialDesign?.descriptionColor ?? @json($design->header_description_color ?? '#666666'),
                },
                form: {
                    storeName: window.__initialDesign?.storeName ?? @json($store->name),
                    storeDescription: window.__initialDesign?.storeDescription ?? @json($store->description),
                },
                publishModalOpen: false,
                loading: {
                    publish: false,
                },
                feedback: {
                    show: false,
                    type: 'success',
                    message: '',
                },
                feedbackTimeout: null,
                init() {
                    this.syncPreview();
                    if (Alpine.store('design')) {
                        Alpine.store('design').storeName = this.form.storeName;
                        Alpine.store('design').storeDescription = this.form.storeDescription;
                        Alpine.store('design').bgColor = this.colors.bgColor;
                        Alpine.store('design').textColor = this.colors.textColor;
                        Alpine.store('design').descriptionColor = this.colors.descriptionColor;
                    }
                    this.persistDesignCache();
                    document.addEventListener('file-upload:selected', (event) => this.onFileSelected(event));
                    document.addEventListener('file-upload:removed', (event) => this.onFileRemoved(event));
                    document.addEventListener('color-changed', (event) => {
                        const { name, value } = event.detail || {};
                        if (!name || !value) {
                            return;
                        }
                        const normalized = this.normalizeColor(value);
                        if (!this.isValidColor(normalized)) {
                            return;
                        }
                        if (name === 'header_background_color') {
                            this.colors.bgColor = normalized;
                        } else if (name === 'header_text_color') {
                            this.colors.textColor = normalized;
                        } else if (name === 'header_description_color') {
                            this.colors.descriptionColor = normalized;
                        }
                        this.pushPreviewState();
                    });

                    this.$watch('form.storeName', (value) => {
                        this.form.storeName = this.sanitizeName(value).slice(0, 40);
                        this.pushPreviewState();
                    });

                    this.$watch('form.storeDescription', (value) => {
                        this.form.storeDescription = this.sanitizeDescription(value).slice(0, 50);
                        this.pushPreviewState();
                    });

                    this.$watch('colors.bgColor', (value) => {
                        this.colors.bgColor = this.normalizeColor(value);
                        this.pushPreviewState();
                    });

                    this.$watch('colors.textColor', (value) => {
                        this.colors.textColor = this.normalizeColor(value);
                        this.pushPreviewState();
                    });

                    this.$watch('colors.descriptionColor', (value) => {
                        this.colors.descriptionColor = this.normalizeColor(value);
                        this.pushPreviewState();
                    });
                },
                handleNameInput(event) {
                    const clean = this.sanitizeName(event.target.value).slice(0, 40);
                    this.form.storeName = clean;
                    if (Alpine.store('design')) {
                        Alpine.store('design').storeName = clean;
                    }
                    this.syncPreview();
                },
                handleDescriptionInput(event) {
                    const clean = this.sanitizeDescription(event.target.value).slice(0, 50);
                    this.form.storeDescription = clean;
                    if (Alpine.store('design')) {
                        Alpine.store('design').storeDescription = clean;
                    }
                    this.syncPreview();
                },
                syncPreview() {
                    this.pushPreviewState();
                },
                pushPreviewState() {
                    const store = Alpine.store('design');
                    if (!store) {
                        console.warn('[StoreDesign] Alpine store no disponible');
                        return;
                    }
                    store.storeName = this.form.storeName;
                    store.storeDescription = this.form.storeDescription;
                    store.bgColor = this.colors.bgColor;
                    store.textColor = this.colors.textColor;
                    store.descriptionColor = this.colors.descriptionColor;
                    const payload = {
                        storeName: store.storeName,
                        storeDescription: store.storeDescription,
                        bgColor: store.bgColor,
                        textColor: store.textColor,
                        descriptionColor: store.descriptionColor,
                        logo: store.logo ?? null,
                        favicon: store.favicon ?? null,
                    };
                    document.dispatchEvent(new CustomEvent('store-preview:update', { detail: payload }));
                    this.persistDesignCache();
                },
                sanitizeName(text) {
                    const safe = (text ?? '').toString();
                    return safe.replace(/[^a-zA-Z0-9\s\-áéíóúñÁÉÍÓÚÑüÜ\.]/g, '');
                },
                sanitizeDescription(text) {
                    const safe = (text ?? '').toString();
                    return safe.replace(/[^a-zA-Z0-9\s\-áéíóúñÁÉÍÓÚÑüÜ\.,¿?!:]/g, '');
                },
                normalizeColor(value) {
                    if (!value) {
                        return '#FFFFFF';
                    }
                    let formatted = value.toString().trim().toUpperCase();
                    if (!formatted.startsWith('#')) {
                        formatted = '#' + formatted.replace('#', '');
                    }
                    if (formatted.length === 4) {
                        const r = formatted[1];
                        const g = formatted[2];
                        const b = formatted[3];
                        formatted = `#${r}${r}${g}${g}${b}${b}`;
                    }
                    if (formatted.length > 7) {
                        formatted = formatted.slice(0, 7);
                    }
                    return formatted;
                },
                isValidColor(value) {
                    return /^#[0-9A-F]{6}$/.test(value ?? '');
                },
                openPublishModal() {
                    this.publishModalOpen = true;
                },
                closePublishModal() {
                    if (!this.loading.publish) {
                        this.publishModalOpen = false;
                    }
                },
                onFileSelected(event) {
                    const { name, file } = event.detail || {};
                    const asset = this.resolveAsset(name);
                    if (!asset || !file) {
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = async (e) => {
                        const base64 = e.target?.result;
                        if (!base64) {
                            return;
                        }
                        if (asset === 'logo') {
                            Alpine.store('design').logo = base64;
                        } else if (asset === 'favicon') {
                            Alpine.store('design').favicon = base64;
                        }
                        await this.sendUpdate({ [`${asset}_base64`]: base64 }, {
                            asset,
                            fileName: file.name,
                            preview: base64,
                        });
                    };
                    reader.readAsDataURL(file);
                },
                onFileRemoved(event) {
                    const { name } = event.detail || {};
                    const asset = this.resolveAsset(name);
                    if (!asset) {
                        return;
                    }
                    if (asset === 'logo') {
                        Alpine.store('design').logo = null;
                    } else if (asset === 'favicon') {
                        Alpine.store('design').favicon = null;
                    }
                    this.sendUpdate({ [`${asset}_url`]: '' }, { asset });
                },
                resolveAsset(name) {
                    if (name === 'store_logo') {
                        return 'logo';
                    }
                    if (name === 'store_favicon') {
                        return 'favicon';
                    }
                    return null;
                },
                async sendUpdate(extraPayload = {}, meta = {}) {
                    const formData = this.buildFormData(extraPayload);
                    try {
                        const response = await fetch(`/${this.storeSlug}/admin/store-design/update`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });

                        if (!response.ok) {
                            throw new Error('No se pudo actualizar el diseño.');
                        }

                        const data = await response.json();
                        if (data?.design) {
                            this.applyDesign(data.design, meta);
                            this.setFeedback('success', 'Diseño actualizado correctamente.');
                        }
                    } catch (error) {
                        this.setFeedback('error', error.message || 'Error al actualizar el diseño.');
                    }
                },
                buildFormData(extraPayload = {}) {
                    const formData = new FormData();
                    formData.append('header_background_color', this.colors.bgColor);
                    formData.append('header_text_color', this.colors.textColor);
                    formData.append('header_description_color', this.colors.descriptionColor);
                    Object.entries(extraPayload).forEach(([key, value]) => {
                        formData.append(key, value ?? '');
                    });
                    return formData;
                },
                async confirmPublish() {
                    this.feedback.show = false;
                    this.loading.publish = true;
                    const formData = this.buildFormData({
                        store_name: this.form.storeName,
                        store_description: this.form.storeDescription,
                    });

                    try {
                        const response = await fetch(`/${this.storeSlug}/admin/store-design/publish`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });

                        if (!response.ok) {
                            throw new Error('No se pudo publicar el diseño.');
                        }

                        const data = await response.json();
                        if (data?.design) {
                            this.applyDesign(data.design);
                        }
                        if (data?.store) {
                            this.form.storeName = data.store.name ?? this.form.storeName;
                            this.form.storeDescription = data.store.description ?? this.form.storeDescription;
                            Alpine.store('design').storeName = this.form.storeName;
                            Alpine.store('design').storeDescription = this.form.storeDescription;
                        }
                        this.setFeedback('success', data?.message || 'Diseño publicado correctamente.');
                        this.publishModalOpen = false;
                        this.persistDesignCache();
                    } catch (error) {
                        this.setFeedback('error', error.message || 'Error al publicar el diseño.');
                    } finally {
                        this.loading.publish = false;
                    }
                },
                setFeedback(type, message) {
                    this.feedback.type = type === 'error' ? 'error' : 'success';
                    this.feedback.message = message;
                    this.feedback.show = true;
                    if (this.feedbackTimeout) {
                        clearTimeout(this.feedbackTimeout);
                    }
                    this.feedbackTimeout = setTimeout(() => {
                        this.feedback.show = false;
                        this.feedbackTimeout = null;
                    }, 4000);
                },
                applyDesign(design, meta = {}) {
                    if (!design) {
                        return;
                    }

                    if (design.header_background_color) {
                        this.colors.bgColor = design.header_background_color;
                    }
                    if (design.header_text_color) {
                        this.colors.textColor = design.header_text_color;
                    }
                    if (design.header_description_color) {
                        this.colors.descriptionColor = design.header_description_color;
                    }

                    if (design.store_name !== undefined) {
                        this.form.storeName = design.store_name ?? this.form.storeName;
                        Alpine.store('design').storeName = this.form.storeName;
                    }
                    if (design.store_description !== undefined) {
                        this.form.storeDescription = design.store_description ?? this.form.storeDescription;
                        Alpine.store('design').storeDescription = this.form.storeDescription;
                    }

                    if (design.logo_url !== undefined) {
                        const preview = meta?.asset === 'logo' ? meta.preview : null;
                        Alpine.store('design').logo = preview ?? this.formatAssetUrl(design.logo_url);
                        window.dispatchEvent(new CustomEvent('image-updated', {
                            detail: {
                                name: 'store_logo',
                                url: Alpine.store('design').logo,
                                fileName: meta.fileName || null,
                            },
                        }));
                    }

                    if (design.favicon_url !== undefined) {
                        const preview = meta?.asset === 'favicon' ? meta.preview : null;
                        Alpine.store('design').favicon = preview ?? this.formatAssetUrl(design.favicon_url);
                        window.dispatchEvent(new CustomEvent('image-updated', {
                            detail: {
                                name: 'store_favicon',
                                url: Alpine.store('design').favicon,
                                fileName: meta.fileName || null,
                            },
                        }));
                    }

                    this.syncPreview();
                    this.persistDesignCache();
                },
                formatAssetUrl(url) {
                    if (!url) {
                        return null;
                    }
                    try {
                        const currentProtocol = window.location.protocol;
                        const assetUrl = new URL(url, window.location.origin);
                        if (currentProtocol === 'https:' && assetUrl.protocol === 'http:') {
                            const insecureHosts = ['127.0.0.1', 'localhost'];
                            if (!insecureHosts.includes(assetUrl.hostname)) {
                                assetUrl.protocol = 'https:';
                                return assetUrl.toString();
                            }
                        }
                        return assetUrl.toString();
                    } catch (error) {
                        return url;
                    }
                },
                normalizeColor(color) {
                    if (color.startsWith('#')) {
                        return color;
                    }
                    return `#${color}`;
                },
                isValidColor(color) {
                    const hex = color.replace('#', '');
                    return /^[0-9A-Fa-f]{6}$/.test(hex);
                },
                persistDesignCache() {
                    if (!this.designCacheKey) {
                        return;
                    }
                    const snapshot = {
                        bgColor: this.colors.bgColor,
                        textColor: this.colors.textColor,
                        descriptionColor: this.colors.descriptionColor,
                        storeName: this.form.storeName,
                        storeDescription: this.form.storeDescription,
                        logo: Alpine.store('design')?.logo ?? null,
                        favicon: Alpine.store('design')?.favicon ?? null,
                    };
                    if (!window.localStorage) {
                        return;
                    }
                    try {
                        window.localStorage.setItem(this.designCacheKey, JSON.stringify(snapshot));
                        window.__initialDesign = { ...(window.__initialDesign || {}), ...snapshot };
                    } catch (error) {
                        console.warn('[StoreDesign] No se pudo guardar el cache local', error);
                    }
                }
            };
        }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 