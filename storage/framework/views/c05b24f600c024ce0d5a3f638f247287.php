<?php if (isset($component)) { $__componentOriginale3fed8e3baf4b125052637cf7db5dbc1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1 = $attributes; } ?>
<?php $component = App\Shared\Views\Components\TenantAdminLayout::resolve(['store' => $store] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tenant-admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\Shared\Views\Components\TenantAdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php $__env->startSection('title', 'Crear Slider'); ?>

    <?php $__env->startSection('content'); ?>
    <div
        class="max-w-4xl mx-auto"
        x-data="(() => ({
            isScheduled: <?php echo e(json_encode((bool) old('is_scheduled'))); ?>,
            isPermanent: <?php echo e(json_encode((bool) old('is_permanent'))); ?>,
            urlType: <?php echo e(json_encode(old('url_type', 'none'))); ?>,
            urlValue: <?php echo e(json_encode(old('url'))); ?>,
            selectedInternalLabel: '',
            suggestions: [],
            isLoadingSuggestions: false,
            highlightedIndex: -1,
            feedbackMessage: '',
            minSearchLength: 3,
            shouldDisplaySuggestions: false,
            searchDelay: 300,
            searchTimeout: null,
            internalSearchEndpoint: <?php echo e(json_encode(route('tenant.admin.sliders.internal-links', $store->slug))); ?>,

            init() {
                this.applyUrlState();
                this.$nextTick(() => {
                    this.initializeLucideIcons();
                });
            },

            initializeLucideIcons() {
                const hasCreateIcons = typeof window.createIcons !== 'undefined';
                const hasLucideIcons = typeof window.lucideIcons !== 'undefined';

                if (hasCreateIcons && hasLucideIcons) {
                    window.createIcons({ icons: window.lucideIcons });
                }
            },

            get isUrlDisabled() {
                return this.urlType === 'none';
            },

            setUrlType(type) {
                this.urlType = type;
                this.applyUrlState();
            },

            applyUrlState() {
                if (this.urlType === 'none') {
                    this.urlValue = '';
                    this.selectedInternalLabel = '';
                    this.closeSuggestions();
                    return;
                }

                if (this.urlType !== 'internal') {
                    this.closeSuggestions();
                    this.selectedInternalLabel = '';
                    return;
                }

                if (this.urlValue && !this.selectedInternalLabel) {
                    this.selectedInternalLabel = this.urlValue;
                }
            },

            handleUrlFocus() {
                if (this.urlType !== 'internal') {
                    return;
                }

                if (this.urlValue && this.urlValue.trim().length > 0) {
                    if (this.suggestions.length > 0) {
                        this.shouldDisplaySuggestions = true;
                    }
                    return;
                }

                this.feedbackMessage = `Escribe al menos ${this.minSearchLength} caracteres para buscar.`;
                this.shouldDisplaySuggestions = true;
            },

            handleUrlInput(value) {
                this.urlValue = value;

                if (this.urlType !== 'internal') {
                    return;
                }

                this.selectedInternalLabel = '';

                const trimmed = value.trim();

                if (this.searchTimeout) {
                    clearTimeout(this.searchTimeout);
                }

                if (trimmed.length === 0) {
                    this.suggestions = [];
                    this.feedbackMessage = `Escribe al menos ${this.minSearchLength} caracteres para buscar.`;
                    this.shouldDisplaySuggestions = true;
                    return;
                }

                if (trimmed.length < this.minSearchLength) {
                    this.suggestions = [];
                    this.feedbackMessage = `Escribe al menos ${this.minSearchLength} caracteres para buscar.`;
                    this.shouldDisplaySuggestions = true;
                    return;
                }

                this.shouldDisplaySuggestions = true;
                this.isLoadingSuggestions = true;
                this.feedbackMessage = '';
                this.highlightedIndex = -1;

                this.searchTimeout = setTimeout(() => {
                    this.fetchInternalLinks(trimmed);
                }, this.searchDelay);
            },

            async fetchInternalLinks(query) {
                try {
                    const response = await fetch(`${this.internalSearchEndpoint}?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Error al obtener resultados');
                    }

                    const data = await response.json();

                    if (this.urlType !== 'internal') {
                        this.closeSuggestions();
                        return;
                    }

                    this.suggestions = Array.isArray(data.results) ? data.results : [];
                    this.feedbackMessage = this.suggestions.length === 0
                        ? 'Sin coincidencias. Ajusta tu búsqueda.'
                        : '';

                    this.$nextTick(() => this.initializeLucideIcons());
                } catch (error) {
                    this.suggestions = [];
                    this.feedbackMessage = 'No se pudieron cargar los enlaces. Intenta nuevamente.';
                } finally {
                    this.isLoadingSuggestions = false;
                }
            },

            selectSuggestion(suggestion) {
                this.urlValue = suggestion.url;
                this.selectedInternalLabel = `${suggestion.type_label} • ${suggestion.label}`;
                this.closeSuggestions();

                this.$nextTick(() => {
                    if (this.$refs.urlInput) {
                        this.$refs.urlInput.focus();
                    }
                });
            },

            highlightNextSuggestion() {
                if (!this.shouldDisplaySuggestions || this.suggestions.length === 0) {
                    return;
                }

                const nextIndex = this.highlightedIndex + 1;
                this.highlightedIndex = nextIndex % this.suggestions.length;
            },

            highlightPreviousSuggestion() {
                if (!this.shouldDisplaySuggestions || this.suggestions.length === 0) {
                    return;
                }

                if (this.highlightedIndex <= 0) {
                    this.highlightedIndex = this.suggestions.length - 1;
                    return;
                }

                this.highlightedIndex = this.highlightedIndex - 1;
            },

            selectHighlightedSuggestion() {
                const isOutOfRange = this.highlightedIndex < 0 || this.highlightedIndex >= this.suggestions.length;

                if (isOutOfRange) {
                    return;
                }

                this.selectSuggestion(this.suggestions[this.highlightedIndex]);
            },

            closeSuggestions() {
                this.shouldDisplaySuggestions = false;
                this.isLoadingSuggestions = false;
                this.highlightedIndex = -1;
                this.feedbackMessage = '';
            }
        }))()"
    >
        <!-- Header con botón de volver -->
        <div class="mb-6">
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('tenant.admin.sliders.index', $store->slug)); ?>">
                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'ghost','color' => 'secondary','icon' => 'arrow-left','text' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'ghost','color' => 'secondary','icon' => 'arrow-left','text' => '']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal30e169a586a2bd405d6a25d5afef85c0)): ?>
<?php $attributes = $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0; ?>
<?php unset($__attributesOriginal30e169a586a2bd405d6a25d5afef85c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal30e169a586a2bd405d6a25d5afef85c0)): ?>
<?php $component = $__componentOriginal30e169a586a2bd405d6a25d5afef85c0; ?>
<?php unset($__componentOriginal30e169a586a2bd405d6a25d5afef85c0); ?>
<?php endif; ?>
                </a>
                <h1 class="text-lg font-semibold text-gray-800">Crear Slider</h1>
            </div>
        </div>
        
        
        <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'crear_slider','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'crear_slider','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal214c6f8b7c938c390f16ac62b88da20d)): ?>
<?php $attributes = $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d; ?>
<?php unset($__attributesOriginal214c6f8b7c938c390f16ac62b88da20d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal214c6f8b7c938c390f16ac62b88da20d)): ?>
<?php $component = $__componentOriginal214c6f8b7c938c390f16ac62b88da20d; ?>
<?php unset($__componentOriginal214c6f8b7c938c390f16ac62b88da20d); ?>
<?php endif; ?>

        <!-- Alerta informativa -->
        <div class="mb-6">
            <?php if (isset($component)) { $__componentOriginal41ce05244c62d53131dc2872106fd4c6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41ce05244c62d53131dc2872106fd4c6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertSoft','data' => ['type' => 'info','message' => 'Las medidas recomendadas para el slider son de 420x200px.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','message' => 'Las medidas recomendadas para el slider son de 420x200px.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41ce05244c62d53131dc2872106fd4c6)): ?>
<?php $attributes = $__attributesOriginal41ce05244c62d53131dc2872106fd4c6; ?>
<?php unset($__attributesOriginal41ce05244c62d53131dc2872106fd4c6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41ce05244c62d53131dc2872106fd4c6)): ?>
<?php $component = $__componentOriginal41ce05244c62d53131dc2872106fd4c6; ?>
<?php unset($__componentOriginal41ce05244c62d53131dc2872106fd4c6); ?>
<?php endif; ?>
        </div>

        <!-- Formulario dentro de Card -->
        <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['size' => 'lg','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'lg','shadow' => 'sm']); ?>
            <form action="<?php echo e(route('tenant.admin.sliders.store', $store->slug)); ?>" method="POST" enctype="multipart/form-data" id="slider-form">
                <?php echo csrf_field(); ?>

                <!-- Errores de validación -->
                <?php if($errors->any()): ?>
                    <div class="mb-6">
                        <?php if (isset($component)) { $__componentOriginal4e12e3fb830c932c6bff0347987a4573 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e12e3fb830c932c6bff0347987a4573 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertBordered','data' => ['type' => 'error','title' => 'Errores de validación']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-bordered'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','title' => 'Errores de validación']); ?>
                            <ul class="list-disc list-inside space-y-1 mt-2">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="text-sm"><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e12e3fb830c932c6bff0347987a4573)): ?>
<?php $attributes = $__attributesOriginal4e12e3fb830c932c6bff0347987a4573; ?>
<?php unset($__attributesOriginal4e12e3fb830c932c6bff0347987a4573); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e12e3fb830c932c6bff0347987a4573)): ?>
<?php $component = $__componentOriginal4e12e3fb830c932c6bff0347987a4573; ?>
<?php unset($__componentOriginal4e12e3fb830c932c6bff0347987a4573); ?>
<?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Información Básica -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Información Básica</h3>
                    <p class="text-sm text-gray-600 mb-6">Configura los datos principales del slider</p>
                    
                    <div class="mb-6" data-tour="slider-name">
                        <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Nombre','name' => 'name','placeholder' => 'Promoción Navidad 2024','value' => old('name'),'required' => true,'containerClass' => 'w-full','class' => 'border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Nombre','name' => 'name','placeholder' => 'Promoción Navidad 2024','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name')),'required' => true,'container-class' => 'w-full','class' => 'border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mb-6" data-tour="slider-description">
                        <label for="description" class="block text-sm font-medium mb-2">Descripción</label>
                        <textarea 
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="Descuentos especiales en toda la tienda"
                            class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        ><?php echo e(old('description')); ?></textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'is_active','checked' => old('is_active', true),'switchId' => 'is_active','value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'is_active','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_active', true)),'switch-id' => 'is_active','value' => '1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $attributes = $__attributesOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $component = $__componentOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__componentOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
                        <label for="is_active" class="text-sm font-medium text-gray-700">Slider activo</label>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="mb-8" data-tour="slider-image">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Imagen</h3>
                    <p class="text-sm text-gray-600 mb-6">Sube la imagen del slider (debe ser exactamente 420x200px)</p>
                    
                    <?php if (isset($component)) { $__componentOriginal63bf74f65a888b5cd67d5d43a6382afd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal63bf74f65a888b5cd67d5d43a6382afd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::FileUploads.FileUploadWithValidation','data' => ['name' => 'image','maxFileSize' => '2','accept' => 'image/*','label' => 'Arrastra tu archivo aquí o','browseText' => 'buscar','helpText' => 'Debe ser exactamente 420x200px, máximo 2MB','requiredWidth' => '420','requiredHeight' => '200']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('file-upload-with-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'image','max-file-size' => '2','accept' => 'image/*','label' => 'Arrastra tu archivo aquí o','browse-text' => 'buscar','help-text' => 'Debe ser exactamente 420x200px, máximo 2MB','required-width' => '420','required-height' => '200']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal63bf74f65a888b5cd67d5d43a6382afd)): ?>
<?php $attributes = $__attributesOriginal63bf74f65a888b5cd67d5d43a6382afd; ?>
<?php unset($__attributesOriginal63bf74f65a888b5cd67d5d43a6382afd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal63bf74f65a888b5cd67d5d43a6382afd)): ?>
<?php $component = $__componentOriginal63bf74f65a888b5cd67d5d43a6382afd; ?>
<?php unset($__componentOriginal63bf74f65a888b5cd67d5d43a6382afd); ?>
<?php endif; ?>
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Enlace -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Enlace</h3>
                    <p class="text-sm text-gray-600 mb-6">Configura hacia dónde dirigirá el slider</p>
                    
                    <div class="mb-6" data-tour="slider-link-type">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de enlace</label>
                        <div class="space-y-3">
                            <?php if (isset($component)) { $__componentOriginal3f698e1eb1ec3d65607261c560621fc6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f698e1eb1ec3d65607261c560621fc6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Radios.RadioBasic','data' => ['radioName' => 'url_type','label' => 'Sin enlace','checked' => old('url_type', 'none') == 'none','radioId' => 'url_type_none','value' => 'none','xOn:change' => 'setUrlType(\'none\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('radio-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['radio-name' => 'url_type','label' => 'Sin enlace','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('url_type', 'none') == 'none'),'radio-id' => 'url_type_none','value' => 'none','x-on:change' => 'setUrlType(\'none\')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f698e1eb1ec3d65607261c560621fc6)): ?>
<?php $attributes = $__attributesOriginal3f698e1eb1ec3d65607261c560621fc6; ?>
<?php unset($__attributesOriginal3f698e1eb1ec3d65607261c560621fc6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f698e1eb1ec3d65607261c560621fc6)): ?>
<?php $component = $__componentOriginal3f698e1eb1ec3d65607261c560621fc6; ?>
<?php unset($__componentOriginal3f698e1eb1ec3d65607261c560621fc6); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal3f698e1eb1ec3d65607261c560621fc6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f698e1eb1ec3d65607261c560621fc6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Radios.RadioBasic','data' => ['radioName' => 'url_type','label' => 'Enlace interno','checked' => old('url_type') == 'internal','radioId' => 'url_type_internal','value' => 'internal','xOn:change' => 'setUrlType(\'internal\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('radio-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['radio-name' => 'url_type','label' => 'Enlace interno','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('url_type') == 'internal'),'radio-id' => 'url_type_internal','value' => 'internal','x-on:change' => 'setUrlType(\'internal\')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f698e1eb1ec3d65607261c560621fc6)): ?>
<?php $attributes = $__attributesOriginal3f698e1eb1ec3d65607261c560621fc6; ?>
<?php unset($__attributesOriginal3f698e1eb1ec3d65607261c560621fc6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f698e1eb1ec3d65607261c560621fc6)): ?>
<?php $component = $__componentOriginal3f698e1eb1ec3d65607261c560621fc6; ?>
<?php unset($__componentOriginal3f698e1eb1ec3d65607261c560621fc6); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal3f698e1eb1ec3d65607261c560621fc6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f698e1eb1ec3d65607261c560621fc6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Radios.RadioBasic','data' => ['radioName' => 'url_type','label' => 'Enlace externo','checked' => old('url_type') == 'external','radioId' => 'url_type_external','value' => 'external','xOn:change' => 'setUrlType(\'external\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('radio-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['radio-name' => 'url_type','label' => 'Enlace externo','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('url_type') == 'external'),'radio-id' => 'url_type_external','value' => 'external','x-on:change' => 'setUrlType(\'external\')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f698e1eb1ec3d65607261c560621fc6)): ?>
<?php $attributes = $__attributesOriginal3f698e1eb1ec3d65607261c560621fc6; ?>
<?php unset($__attributesOriginal3f698e1eb1ec3d65607261c560621fc6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f698e1eb1ec3d65607261c560621fc6)): ?>
<?php $component = $__componentOriginal3f698e1eb1ec3d65607261c560621fc6; ?>
<?php unset($__componentOriginal3f698e1eb1ec3d65607261c560621fc6); ?>
<?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="relative" data-tour="slider-url">
                        <?php if (isset($component)) { $__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithIcon','data' => ['name' => 'url','icon' => 'link','placeholder' => 'https://ejemplo.com o /categoria/ropa','value' => old('url'),'xModel' => 'urlValue','xRef' => 'urlInput','xOn:input' => 'handleUrlInput($event.target.value)','xOn:focus' => 'handleUrlFocus()','xOn:keydown.arrowDown.prevent' => 'highlightNextSuggestion()','xOn:keydown.arrowUp.prevent' => 'highlightPreviousSuggestion()','xOn:keydown.enter.prevent' => 'selectHighlightedSuggestion()','xOn:keydown.escape' => 'closeSuggestions()','xBind:disabled' => 'isUrlDisabled','xBind:class' => 'isUrlDisabled ? \'bg-gray-100 cursor-not-allowed\' : \'bg-white\'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'url','icon' => 'link','placeholder' => 'https://ejemplo.com o /categoria/ropa','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('url')),'x-model' => 'urlValue','x-ref' => 'urlInput','x-on:input' => 'handleUrlInput($event.target.value)','x-on:focus' => 'handleUrlFocus()','x-on:keydown.arrow-down.prevent' => 'highlightNextSuggestion()','x-on:keydown.arrow-up.prevent' => 'highlightPreviousSuggestion()','x-on:keydown.enter.prevent' => 'selectHighlightedSuggestion()','x-on:keydown.escape' => 'closeSuggestions()','x-bind:disabled' => 'isUrlDisabled','x-bind:class' => 'isUrlDisabled ? \'bg-gray-100 cursor-not-allowed\' : \'bg-white\'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34)): ?>
<?php $attributes = $__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34; ?>
<?php unset($__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34)): ?>
<?php $component = $__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34; ?>
<?php unset($__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34); ?>
<?php endif; ?>
                        <div 
                            x-show="shouldDisplaySuggestions"
                            x-cloak
                            x-transition
                            x-on:click.outside="closeSuggestions()"
                            class="absolute z-50 mt-2 w-full rounded-lg border border-gray-200 bg-white shadow-lg"
                        >
                            <template x-if="isLoadingSuggestions">
                                <div class="flex items-center gap-2 px-4 py-3 text-sm text-gray-500">
                                    <span class="inline-flex size-4 animate-spin rounded-full border-2 border-gray-200 border-t-transparent"></span>
                                    Buscando resultados...
                                </div>
                            </template>

                            <template x-if="!isLoadingSuggestions && suggestions.length === 0 && feedbackMessage">
                                <div class="px-4 py-3 text-sm text-gray-500" x-text="feedbackMessage"></div>
                            </template>

                            <template x-if="!isLoadingSuggestions && suggestions.length > 0">
                                <ul class="py-2">
                                    <template x-for="(suggestion, index) in suggestions" :key="suggestion.id">
                                        <li>
                                            <button 
                                                type="button"
                                                class="flex w-full flex-col gap-1 px-4 py-2 text-left transition hover:bg-gray-50"
                                                :class="highlightedIndex === index ? 'bg-gray-50' : ''"
                                                x-on:mouseenter="highlightedIndex = index"
                                                x-on:mousedown.prevent="selectSuggestion(suggestion)"
                                            >
                                                <span class="text-sm font-medium text-gray-700" x-text="suggestion.label"></span>
                                                <span class="text-xs text-gray-500 flex items-center gap-2">
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-[11px] font-medium text-gray-600">
                                                        <i data-lucide="hash" class="size-3 text-gray-400"></i>
                                                        <span x-text="suggestion.type_label"></span>
                                                    </span>
                                                    <span x-text="suggestion.url"></span>
                                                </span>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </template>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        Interna: /categoria/ropa, /producto/camiseta. Escribe al menos 3 caracteres para buscar.<br>
                        Externa: https://instagram.com/mitienda
                    </p>
                    <p 
                        class="text-xs text-blue-600 mt-2 font-medium flex items-center gap-1"
                        x-show="selectedInternalLabel"
                        x-text="'Recurso seleccionado: ' + selectedInternalLabel"
                    ></p>
                    <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Programación -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Programación</h3>
                    <p class="text-sm text-gray-600 mb-6">Configura cuándo se mostrará el slider (opcional)</p>
                    
                    <div class="mb-6" data-tour="slider-schedule-toggle">
                        <div class="flex items-center gap-3 mb-6">
                            <input type="hidden" name="is_scheduled" value="0">
                            <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'is_scheduled','checked' => old('is_scheduled'),'switchId' => 'is_scheduled','value' => '1','xModel' => 'isScheduled']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'is_scheduled','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_scheduled')),'switch-id' => 'is_scheduled','value' => '1','x-model' => 'isScheduled']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $attributes = $__attributesOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $component = $__componentOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__componentOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
                            <label for="is_scheduled" class="text-sm font-medium text-gray-700">Programar slider</label>
                        </div>
                    </div>

                    <div x-show="isScheduled" x-cloak style="display: none;" class="space-y-6">
                        <div class="flex items-center gap-3" data-tour="slider-permanent-toggle">
                            <input type="hidden" name="is_permanent" value="0">
                            <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'is_permanent','checked' => old('is_permanent'),'switchId' => 'is_permanent','value' => '1','xModel' => 'isPermanent']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'is_permanent','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_permanent')),'switch-id' => 'is_permanent','value' => '1','x-model' => 'isPermanent']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $attributes = $__attributesOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $component = $__componentOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__componentOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
                            <label for="is_permanent" class="text-sm font-medium text-gray-700">Slider permanente (sin fecha fin)</label>
                        </div>

                        <div x-show="!isPermanent" x-cloak style="display: none;" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div data-tour="slider-start-date">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Fecha inicio','name' => 'start_date','type' => 'date','value' => old('start_date')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fecha inicio','name' => 'start_date','type' => 'date','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('start_date'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                            </div>
                            <div data-tour="slider-end-date">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Fecha fin','name' => 'end_date','type' => 'date','value' => old('end_date')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Fecha fin','name' => 'end_date','type' => 'date','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('end_date'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div data-tour="slider-start-time">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Hora inicio','name' => 'start_time','type' => 'time','value' => old('start_time')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Hora inicio','name' => 'start_time','type' => 'time','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('start_time'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                            </div>
                            <div data-tour="slider-end-time">
                                <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['label' => 'Hora fin','name' => 'end_time','type' => 'time','value' => old('end_time')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Hora fin','name' => 'end_time','type' => 'time','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('end_time'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $attributes = $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__attributesOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c)): ?>
<?php $component = $__componentOriginalc088a413751f2bc7a99da19699d0dd5c; ?>
<?php unset($__componentOriginalc088a413751f2bc7a99da19699d0dd5c); ?>
<?php endif; ?>
                            </div>
                        </div>

                        <div data-tour="slider-days">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Días de la semana</label>
                            <div class="grid grid-cols-7 gap-2">
                                <?php $__currentLoopData = ['monday' => 'L', 'tuesday' => 'M', 'wednesday' => 'X', 'thursday' => 'J', 'friday' => 'V', 'saturday' => 'S', 'sunday' => 'D']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500">
                                        <input type="checkbox" 
                                               name="scheduled_days[<?php echo e($day); ?>]" 
                                               value="1" 
                                               <?php echo e(old("scheduled_days.{$day}") ? 'checked' : ''); ?>

                                               class="sr-only peer">
                                        <span class="text-sm font-medium text-gray-700 peer-checked:text-blue-600"><?php echo e($label); ?></span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <a href="<?php echo e(route('tenant.admin.sliders.index', $store->slug)); ?>">
                        <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'error','text' => 'Cancelar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'error','text' => 'Cancelar']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe)): ?>
<?php $attributes = $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe; ?>
<?php unset($__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal04708fbebc5edddfdc2817d72c5db4fe)): ?>
<?php $component = $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe; ?>
<?php unset($__componentOriginal04708fbebc5edddfdc2817d72c5db4fe); ?>
<?php endif; ?>
                    </a>
                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'plus','text' => 'Crear Slider','htmlType' => 'submit','dataTour' => 'save-button']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'plus','text' => 'Crear Slider','html-type' => 'submit','data-tour' => 'save-button']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal30e169a586a2bd405d6a25d5afef85c0)): ?>
<?php $attributes = $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0; ?>
<?php unset($__attributesOriginal30e169a586a2bd405d6a25d5afef85c0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal30e169a586a2bd405d6a25d5afef85c0)): ?>
<?php $component = $__componentOriginal30e169a586a2bd405d6a25d5afef85c0; ?>
<?php unset($__componentOriginal30e169a586a2bd405d6a25d5afef85c0); ?>
<?php endif; ?>
                </div>
            </form>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale7abd09368360b706a1fc8b7cc9ba036)): ?>
<?php $attributes = $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036; ?>
<?php unset($__attributesOriginale7abd09368360b706a1fc8b7cc9ba036); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale7abd09368360b706a1fc8b7cc9ba036)): ?>
<?php $component = $__componentOriginale7abd09368360b706a1fc8b7cc9ba036; ?>
<?php unset($__componentOriginale7abd09368360b706a1fc8b7cc9ba036); ?>
<?php endif; ?>
    </div>

    <?php $__env->stopSection(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1)): ?>
<?php $attributes = $__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1; ?>
<?php unset($__attributesOriginale3fed8e3baf4b125052637cf7db5dbc1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3fed8e3baf4b125052637cf7db5dbc1)): ?>
<?php $component = $__componentOriginale3fed8e3baf4b125052637cf7db5dbc1; ?>
<?php unset($__componentOriginale3fed8e3baf4b125052637cf7db5dbc1); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/sliders/create.blade.php ENDPATH**/ ?>