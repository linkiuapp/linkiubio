

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
    <?php $__env->startSection('title', 'Sliders'); ?>

    <?php $__env->startSection('content'); ?>
    
    <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'gestionar_sliders','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'gestionar_sliders','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
    
    
    <?php
        $emptyStateSvg = 'base_ui_empty_sliders.svg';
        $emptyStateTitle = 'No hay sliders disponibles';
        $emptyStateMessage = 'Comienza agregando sliders para tu tienda.';
    ?>
    

    
    <div 
        x-data="sliderManagement" 
        class="space-y-4" 
        x-init="init()"
    >
        <?php if (isset($component)) { $__componentOriginalf98a32c06d8462f5513d0fb3554f9141 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf98a32c06d8462f5513d0fb3554f9141 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Notifications.ToastNotification','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toast-notification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf98a32c06d8462f5513d0fb3554f9141)): ?>
<?php $attributes = $__attributesOriginalf98a32c06d8462f5513d0fb3554f9141; ?>
<?php unset($__attributesOriginalf98a32c06d8462f5513d0fb3554f9141); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf98a32c06d8462f5513d0fb3554f9141)): ?>
<?php $component = $__componentOriginalf98a32c06d8462f5513d0fb3554f9141; ?>
<?php unset($__componentOriginalf98a32c06d8462f5513d0fb3554f9141); ?>
<?php endif; ?>

        
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Sliders</h2>
                        <p class="text-sm text-gray-600">
                            Usando <?php echo e($currentCount); ?> de <?php echo e($maxSliders); ?> sliders disponibles en tu plan <?php echo e($store->plan->name); ?>

                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div x-show="selectedSliders.length > 0" x-cloak style="display: none;">
                            <button
                                type="button"
                                @click="deleteSelectedSliders()"
                                class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-3 px-4 body-small bg-red-500 text-white hover:bg-red-600 focus:bg-red-600 border border-transparent"
                            >
                                <i data-lucide="trash-2" class="shrink-0 w-4 h-4"></i>
                                <span x-text="'Eliminar ' + selectedSliders.length + (selectedSliders.length === 1 ? ' slider' : ' sliders')"></span>
                            </button>
                        </div>
                        <?php if($currentCount < $maxSliders): ?>
                            <a href="<?php echo e(route('tenant.admin.sliders.create', $store->slug)); ?>" data-tour="slider-button">
                                
                                <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Nuevo Slider']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Nuevo Slider']); ?>
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
                        <?php else: ?>
                            
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'outline','color' => 'secondary','size' => 'md','icon' => 'plus-circle','text' => 'Límite Alcanzado','disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'secondary','size' => 'md','icon' => 'plus-circle','text' => 'Límite Alcanzado','disabled' => true]); ?>
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
                            
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            

            
            <div class="border-b border-gray-200 bg-gray-50 py-3 px-6">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4 flex-1">
                        
                        <div class="w-48">
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'status','options' => [
                                    '' => 'Todos los estados',
                                    'active' => 'Activos',
                                    'inactive' => 'Inactivos',
                                ],'value' => request('status', ''),'xModel' => 'filterStatus','@change' => 'applyFilters()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'status','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    '' => 'Todos los estados',
                                    'active' => 'Activos',
                                    'inactive' => 'Inactivos',
                                ]),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('status', '')),'x-model' => 'filterStatus','@change' => 'applyFilters()']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81)): ?>
<?php $attributes = $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81; ?>
<?php unset($__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81)): ?>
<?php $component = $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81; ?>
<?php unset($__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81); ?>
<?php endif; ?>
                        </div>
                        

                        
                        <div class="w-56">
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'scheduling','options' => [
                                    '' => 'Todas las programaciones',
                                    'scheduled' => 'Programados',
                                    'permanent' => 'Permanentes',
                                ],'value' => request('scheduling', ''),'xModel' => 'filterScheduled','@change' => 'applyFilters()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'scheduling','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    '' => 'Todas las programaciones',
                                    'scheduled' => 'Programados',
                                    'permanent' => 'Permanentes',
                                ]),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('scheduling', '')),'x-model' => 'filterScheduled','@change' => 'applyFilters()']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81)): ?>
<?php $attributes = $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81; ?>
<?php unset($__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81)): ?>
<?php $component = $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81; ?>
<?php unset($__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81); ?>
<?php endif; ?>
                        </div>
                        
                    </div>

                    <div class="text-sm text-gray-600">
                        Mostrando <?php echo e($sliders->firstItem() ?? 0); ?> - <?php echo e($sliders->lastItem() ?? 0); ?> de <?php echo e($sliders->total()); ?> sliders
                    </div>
                </div>
            </div>
            

            
            <?php echo $__env->make('tenant-admin::Core/sliders/components/table-view', [
                'sliders' => $sliders,
                'store' => $store,
                'currentCount' => $currentCount,
                'maxSliders' => $maxSliders,
                'emptyStateSvg' => $emptyStateSvg,
                'emptyStateTitle' => $emptyStateTitle,
                'emptyStateMessage' => $emptyStateMessage,
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            

            
            <?php if($sliders->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($sliders->links()); ?>

                </div>
            <?php endif; ?>
            
        </div>
        

        
        <div 
            x-data="deleteModalData()"
            x-on:keydown.escape.window="closeModal()"
            @delete-slider.window="openModal($event.detail.id, $event.detail.name, $event.detail.rowElement)"
        >
            
            <div 
                x-show="open"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
                @click="closeModal()"
                style="display: none;"
            ></div>

            
            <div 
                x-show="open"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
                role="dialog"
                tabindex="-1"
                aria-labelledby="delete-modal-label"
                style="display: none;"
            >
                <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                    <div 
                        @click.stop
                        class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                    >
                        
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <h3 id="delete-modal-label" class="font-bold text-gray-800">
                                ¿Eliminar slider?
                            </h3>
                            <button 
                                type="button" 
                                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                                aria-label="Cerrar"
                                @click="closeModal()"
                                :disabled="loading"
                            >
                                <span class="sr-only">Cerrar</span>
                                <i data-lucide="x" class="shrink-0 size-4"></i>
                            </button>
                        </div>
                        

                        
                        <div class="p-4 overflow-y-auto">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800">
                                        Se eliminará el slider <strong>"<span x-text="sliderName"></span>"</strong> de forma permanente.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Esta acción no se puede deshacer.
                                    </p>
                                    
                                    
                                    <div x-show="error" class="mt-3" x-cloak>
                                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                            <div class="flex">
                                                <div class="shrink-0">
                                                    <i data-lucide="alert-circle" class="size-5"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p x-text="error"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        

                        
                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                            <button 
                                type="button" 
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
                                @click="closeModal()"
                                :disabled="loading"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="button" 
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                                @click="confirmDelete()"
                                :disabled="loading"
                            >
                                <span x-show="!loading">Sí, eliminar</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <i data-lucide="loader" class="size-4 animate-spin"></i>
                                    Eliminando...
                                </span>
                            </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        

        
        <div 
            x-data="{ 
                open: false, 
                sliderId: null, 
                sliderName: '', 
                newSliderName: '',
                loading: false,
                error: null,
                openModal(id, name) {
                    this.sliderId = id;
                    this.sliderName = name;
                    this.newSliderName = name + ' (Copia)';
                    this.error = null;
                    this.open = true;
                },
                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.sliderId = null;
                        this.sliderName = '';
                    this.newSliderName = '';
                        this.error = null;
                    }
                },
                async confirmDuplicate() {
                    if (!this.sliderId) return;
                    
                    if (!this.newSliderName.trim()) {
                        this.error = 'El nombre del slider es requerido';
                        return;
                    }
                    
                    this.loading = true;
                    this.error = null;
                    
                    try {
                        const storeSlug = '<?php echo e($store->slug); ?>';
                        const response = await fetch('/' + storeSlug + '/admin/sliders/' + this.sliderId + '/duplicate', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                name: this.newSliderName.trim()
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.error || 'Error al duplicar el slider');
                        }
                        
                        window.location.reload();
                    } catch (error) {
                        this.error = error.message || 'Error al duplicar el slider';
                        this.loading = false;
                    }
                },
            }"
            x-on:keydown.escape.window="closeModal()"
            @duplicate-slider.window="openModal($event.detail.id, $event.detail.name)"
            x-cloak
        >
            
            <div 
                x-show="open"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
                @click="closeModal()"
                style="display: none;"
            ></div>

            
            <div 
                x-show="open"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
                role="dialog"
                tabindex="-1"
                aria-labelledby="duplicate-modal-label"
                style="display: none;"
            >
                <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                    <div 
                        @click.stop
                        class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                    >
                        
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <h3 id="duplicate-modal-label" class="font-bold text-gray-800">
                                Duplicar Slider
                            </h3>
                            <button 
                                type="button" 
                                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                                aria-label="Cerrar"
                                @click="closeModal()"
                                :disabled="loading"
                            >
                                <span class="sr-only">Cerrar</span>
                                <i data-lucide="x" class="shrink-0 size-4"></i>
                            </button>
                        </div>
                        

                        
                        <div class="p-4 overflow-y-auto">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="size-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="copy" class="size-5 text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800 mb-4">
                                        Ingresa el nombre para la copia de <strong>"<span x-text="sliderName"></span>"</strong>
                                    </p>
                                    
                                    <div>
                                        <label for="new-slider-name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nombre del nuevo slider
                                        </label>
                                        <input 
                                            type="text" 
                                            id="new-slider-name"
                                            x-model="newSliderName"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Nombre del nuevo slider"
                                            @keydown.enter="confirmDuplicate()"
                                        >
                                    </div>
                                    
                                    
                                    <div x-show="error" class="mt-3" x-cloak>
                                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                            <div class="flex">
                                                <div class="shrink-0">
                                                    <i data-lucide="alert-circle" class="size-5"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p x-text="error"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        

                        
                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                            <button 
                                type="button" 
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
                                @click="closeModal()"
                                :disabled="loading"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="button" 
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                @click="confirmDuplicate()"
                                :disabled="loading"
                            >
                                <span x-show="!loading">Duplicar</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <i data-lucide="loader" class="size-4 animate-spin"></i>
                                    Duplicando...
                                </span>
                            </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        

        
        <div 
            x-show="showBulkDeleteModal"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="closeBulkDeleteModal()"
            style="display: none;"
            x-cloak
            x-on:keydown.escape.window="closeBulkDeleteModal()"
        ></div>

        <div 
            x-show="showBulkDeleteModal"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            aria-labelledby="bulk-delete-modal-label"
            style="display: none;"
            x-cloak
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 id="bulk-delete-modal-label" class="font-bold text-gray-800">
                            ¿Eliminar sliders?
                        </h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                            aria-label="Cerrar"
                            @click="closeBulkDeleteModal()"
                            :disabled="bulkDeleteLoading"
                        >
                            <span class="sr-only">Cerrar</span>
                            <i data-lucide="x" class="shrink-0 size-4"></i>
                        </button>
                    </div>
                    

                    
                    <div class="p-4 overflow-y-auto">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-800">
                                    Se eliminarán <strong><span x-text="selectedSliders.length"></span> <span x-text="selectedSliders.length === 1 ? 'slider' : 'sliders'"></span></strong> de forma permanente.
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Esta acción no se puede deshacer.
                                </p>
                                
                                
                                <div x-show="bulkDeleteError" class="mt-3" x-cloak>
                                    <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                        <div class="flex">
                                            <div class="shrink-0">
                                                <i data-lucide="alert-circle" class="size-5"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p x-text="bulkDeleteError"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    

                    
                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
                            @click="closeBulkDeleteModal()"
                            :disabled="bulkDeleteLoading"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                            @click="confirmBulkDelete()"
                            :disabled="bulkDeleteLoading"
                        >
                            <span x-show="!bulkDeleteLoading">Sí, eliminar</span>
                            <span x-show="bulkDeleteLoading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Eliminando...
                            </span>
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
    

    <?php $__env->startPush('scripts'); ?>
    <script>
        function deleteModalData() {
            return {
                open: false,
                sliderId: null,
                sliderName: '',
                sliderRow: null,
                loading: false,
                error: null,
                
                openModal(id, name, rowElement) {
                    this.sliderId = id;
                    this.sliderName = name;
                    this.sliderRow = rowElement;
                    this.error = null;
                    this.open = true;
                },
                
                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.sliderId = null;
                        this.sliderName = '';
                        this.sliderRow = null;
                        this.error = null;
                    }
                },
                
                async confirmDelete() {
                    if (!this.sliderId) return;
                    
                    this.loading = true;
                    this.error = null;
                    
                    try {
                        const storeSlug = '<?php echo e($store->slug); ?>';
                        const response = await fetch('/' + storeSlug + '/admin/sliders/' + this.sliderId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            }
                        });

                        let data;
                        try {
                            data = await response.json();
                        } catch (e) {
                            throw new Error('Error al procesar la respuesta del servidor');
                        }

                        if (!response.ok) {
                            throw new Error(data.error || 'Error al eliminar el slider');
                        }

                        if (data.error) {
                            throw new Error(data.error);
                        }

                        this.loading = false;
                        
                        const rowToDelete = this.sliderRow;
                        const sliderIdToRemove = this.sliderId;
                        const sliderName = this.sliderName;
                        
                        // Remover de la selección ANTES de eliminar el elemento del DOM
                        const sliderManagement = Alpine.$data(document.querySelector('[x-data="sliderManagement"]'));
                        if (sliderManagement) {
                            // Desmarcar el checkbox si existe ANTES de remover del array
                            if (rowToDelete) {
                                const checkbox = rowToDelete.querySelector('.slider-checkbox');
                                if (checkbox) {
                                    checkbox.checked = false;
                                }
                            }
                            
                            // Remover el slider del array de selección usando una nueva referencia para forzar reactividad
                            const currentSelected = [...sliderManagement.selectedSliders];
                            sliderManagement.selectedSliders = currentSelected.filter(id => id !== sliderIdToRemove);
                            
                            // Si no quedan seleccionados, limpiar también el selectAll
                            if (sliderManagement.selectedSliders.length === 0) {
                                sliderManagement.selectAll = false;
                                const selectAllCheckbox = document.getElementById('select-all-sliders');
                                if (selectAllCheckbox) {
                                    selectAllCheckbox.checked = false;
                                }
                            }
                            
                            // Actualizar el estado del select all
                            sliderManagement.updateSelectAllState();
                        }
                        
                        this.closeModal();
                        
                        if (rowToDelete && rowToDelete.parentNode) {
                            rowToDelete.style.transition = 'opacity 0.3s ease-out';
                            rowToDelete.style.opacity = '0';
                            setTimeout(() => {
                                if (rowToDelete.parentNode) {
                                    rowToDelete.remove();
                                    
                                    // Verificar si quedan sliders y mostrar EmptyState si es necesario
                                    if (sliderManagement && sliderManagement.checkAndShowEmptyState) {
                                        sliderManagement.checkAndShowEmptyState();
                                    }
                                    
                                    window.dispatchEvent(new CustomEvent('show-success-alert'));
                                }
                            }, 300);
                        } else {
                            window.location.reload();
                            return;
                        }
                    } catch (error) {
                        this.error = error.message || 'Error al eliminar el slider';
                        this.loading = false;
                    }
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('sliderManagement', () => ({
                filterStatus: '<?php echo e(request('status', '')); ?>',
                filterScheduled: '<?php echo e(request('scheduling', '')); ?>',
                selectedSliders: [],
                selectAll: false,
                showBulkDeleteModal: false,
                bulkDeleteLoading: false,
                bulkDeleteError: null,
                bulkDeleteSuccessCount: 0,

                init() {
                    <?php if(session('slider_created')): ?>
                    if (window.toast) {
                        window.toast.success(
                            'Actualización exitosa',
                            'El slider se ha creado correctamente.',
                            5000,
                            'bottom-center'
                        );
                    }
                    <?php endif; ?>

                    <?php if(session('slider_updated')): ?>
                    if (window.toast) {
                        window.toast.success(
                            'Actualización exitosa',
                            'El slider se ha actualizado correctamente.',
                            5000,
                            'bottom-center'
                        );
                    }
                    <?php endif; ?>

                    window.addEventListener('show-success-alert', () => {
                        if (window.toast) {
                            window.toast.success(
                                'Actualización exitosa',
                                'El slider se ha eliminado correctamente.',
                                5000,
                                'bottom-center'
                            );
                        }
                    });

                    // Inicializar iconos Lucide
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                },

                applyFilters() {
                    const params = new URLSearchParams(window.location.search);
                    
                    if (this.filterStatus) {
                        params.set('status', this.filterStatus);
                    } else {
                        params.delete('status');
                    }
                    
                    if (this.filterScheduled) {
                        params.set('scheduling', this.filterScheduled);
                    } else {
                        params.delete('scheduling');
                    }
                    
                    window.location.search = params.toString();
                },

                toggleSelectAll() {
                    const selectAllCheckbox = document.getElementById('select-all-sliders');
                    if (!selectAllCheckbox) return;
                    
                    const isChecked = selectAllCheckbox.checked;
                    this.selectAll = isChecked;
                    
                    const checkboxes = document.querySelectorAll('.slider-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                        const sliderId = parseInt(checkbox.value);
                        if (isChecked) {
                            if (!this.selectedSliders.includes(sliderId)) {
                                this.selectedSliders.push(sliderId);
                            }
                        } else {
                            this.selectedSliders = this.selectedSliders.filter(id => id !== sliderId);
                        }
                    });
                },

                toggleSlider(checkbox) {
                    if (!checkbox) return;
                    const sliderId = parseInt(checkbox.value);
                    if (checkbox.checked) {
                        if (!this.selectedSliders.includes(sliderId)) {
                            this.selectedSliders.push(sliderId);
                        }
                    } else {
                        this.selectedSliders = this.selectedSliders.filter(id => id !== sliderId);
                    }
                    this.updateSelectAllState();
                },

                updateSelectAllState() {
                    const checkboxes = document.querySelectorAll('.slider-checkbox');
                    const selectAllCheckbox = document.getElementById('select-all-sliders');
                    if (!checkboxes.length || !selectAllCheckbox) return;
                    
                    const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                    this.selectAll = checkedCount === checkboxes.length;
                    selectAllCheckbox.checked = this.selectAll;
                },

                deleteSelectedSliders() {
                    if (this.selectedSliders.length === 0) return;
                    this.showBulkDeleteModal = true;
                },

                closeBulkDeleteModal() {
                    if (!this.bulkDeleteLoading) {
                        this.showBulkDeleteModal = false;
                        this.bulkDeleteError = null;
                    }
                },

                async confirmBulkDelete() {
                    if (this.selectedSliders.length === 0) return;
                    
                    this.bulkDeleteLoading = true;
                    this.bulkDeleteError = null;
                    
                    const storeSlug = '<?php echo e($store->slug); ?>';
                    const sliderIdsToDelete = [...this.selectedSliders];
                    let successCount = 0;
                    let errorCount = 0;
                    
                    for (const sliderId of sliderIdsToDelete) {
                        try {
                            const response = await fetch('/' + storeSlug + '/admin/sliders/' + sliderId, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                                    'Accept': 'application/json',
                                }
                            });
                            
                            const data = await response.json();
                            if (response.ok && data.success) {
                                successCount++;
                                
                                // Eliminar fila del DOM
                                const row = document.querySelector(`tr[data-slider-id="${sliderId}"]`);
                                if (row) {
                                    row.style.transition = 'opacity 0.3s ease-out';
                                    row.style.opacity = '0';
                                    setTimeout(() => {
                                        if (row.parentNode) {
                                            row.remove();
                                        }
                                    }, 300);
                                }
                            } else {
                                errorCount++;
                            }
                        } catch (error) {
                            errorCount++;
                        }
                    }
                    
                    this.bulkDeleteLoading = false;
                    this.closeBulkDeleteModal();
                    this.selectedSliders = [];
                    this.selectAll = false;
                    const selectAllCheckbox = document.getElementById('select-all-sliders');
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = false;
                    }
                    
                    // Esperar un poco para que las animaciones de eliminación terminen
                    setTimeout(() => {
                        this.updateSelectAllState();
                        
                        // Verificar si quedan sliders y mostrar EmptyState si es necesario
                        this.checkAndShowEmptyState();
                        
                        if (errorCount === 0) {
                            // Mostrar toast de éxito
                            if (window.toast) {
                                const message = successCount === 1 
                                    ? 'Se eliminó 1 slider correctamente.'
                                    : `Se eliminaron ${successCount} sliders correctamente.`;
                                window.toast.success(
                                    'Actualización exitosa',
                                    message,
                                    5000,
                                    'bottom-center'
                                );
                            }
                        } else {
                            // Mostrar toast de advertencia si hubo errores
                            const errorMessage = `Se eliminaron ${successCount} sliders. ${errorCount > 0 ? `${errorCount} sliders no pudieron ser eliminados.` : ''}`;
                            
                            if (window.toast) {
                                window.toast.warning(
                                    'Eliminación parcial',
                                    errorMessage,
                                    5000,
                                    'bottom-center'
                                );
                            }
                        }
                    }, 350);
                },

                checkAndShowEmptyState() {
                    // Esperar un poco para que las animaciones de eliminación terminen
                    setTimeout(() => {
                        const tbody = document.querySelector('tbody');
                        if (!tbody) return;
                        
                        // Contar filas visibles (excluyendo el empty state dinámico)
                        const sliderRows = tbody.querySelectorAll('tr[data-slider-id]');
                        const visibleRows = Array.from(sliderRows).filter(row => {
                            // Verificar si la fila está realmente visible en el DOM
                            const style = window.getComputedStyle(row);
                            return style.display !== 'none' && 
                                   row.style.opacity !== '0' && 
                                   row.offsetParent !== null &&
                                   !row.classList.contains('removing');
                        });
                        
                        const dynamicEmptyState = document.getElementById('dynamic-empty-state');
                        
                        if (visibleRows.length === 0 && dynamicEmptyState) {
                            // Ocultar el thead de la tabla
                            const thead = document.querySelector('thead');
                            if (thead) {
                                thead.style.display = 'none';
                            }
                            
                            // Ocultar cualquier empty state de Blade que pueda estar visible
                            const bladeEmptyStateRows = tbody.querySelectorAll('tr:not([data-slider-id]):not(#dynamic-empty-state)');
                            bladeEmptyStateRows.forEach(row => {
                                if (row.id !== 'dynamic-empty-state') {
                                    row.style.display = 'none';
                                }
                            });
                            
                            // Mostrar el empty state dinámico
                            dynamicEmptyState.style.display = '';
                            
                            // Inicializar iconos Lucide en el empty state
                            this.$nextTick(() => {
                                if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                    window.createIcons({ icons: window.lucideIcons });
                                }
                            });
                        } else {
                            // Mostrar el thead si hay filas
                            const thead = document.querySelector('thead');
                            if (thead) {
                                thead.style.display = '';
                            }
                            
                            // Ocultar el empty state dinámico
                            if (dynamicEmptyState) {
                                dynamicEmptyState.style.display = 'none';
                            }
                        }
                    }, 400); // Esperar un poco más que la animación de eliminación (300ms)
                }
            }));
        });

        // Checkbox functionality
        document.addEventListener('change', function(e) {
            // Select all checkbox
            if (e.target.id === 'select-all-sliders') {
                const sliderManagement = Alpine.$data(document.querySelector('[x-data="sliderManagement"]'));
                if (sliderManagement) {
                    sliderManagement.toggleSelectAll();
                }
            }
            
            // Individual checkboxes
            if (e.target.classList.contains('slider-checkbox')) {
                const sliderManagement = Alpine.$data(document.querySelector('[x-data="sliderManagement"]'));
                if (sliderManagement) {
                    sliderManagement.toggleSlider(e.target);
                }
            }
            
            // Toggle de estado de slider
            if (e.target.classList.contains('slider-toggle')) {
                e.stopPropagation(); // Prevenir que otros listeners capturen el evento
                
                const sliderId = e.target.dataset.sliderId;
                const url = e.target.dataset.url;
                const originalChecked = e.target.checked;
                const row = e.target.closest('tr');
                
                // Verificar que la URL sea para sliders
                if (!url || !url.includes('sliders')) {
                    console.error('URL incorrecta para toggle de slider:', url);
                    e.target.checked = !originalChecked;
                    return;
                }
                
                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Actualizar el badge de estado en la misma fila
                        if (row) {
                            // El badge de estado está en la tercera columna (después de checkbox y slider info)
                            const statusCell = row.querySelector('td:nth-child(3)');
                            if (statusCell) {
                                if (data.is_active) {
                                    statusCell.innerHTML = '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-green-100 text-green-800">Activo</span>';
                                } else {
                                    statusCell.innerHTML = '<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-red-100 text-red-800">Inactivo</span>';
                                }
                            }
                        }
                        
                        // Mostrar toast de éxito
                        if (window.toast) {
                            const message = data.is_active
                                ? 'El slider se ha activado correctamente.'
                                : 'El slider se ha desactivado correctamente.';
                            window.toast.success(
                                'Estado actualizado',
                                message,
                                5000,
                                'bottom-center'
                            );
                        }
                    } else {
                        e.target.checked = !originalChecked;
                        // Mostrar error con toast
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                data.error || 'Error al cambiar el estado del slider',
                                5000,
                                'bottom-center'
                            );
                        }
                    }
                })
                .catch(error => {
                    console.error('Error al cambiar estado del slider:', error);
                    e.target.checked = !originalChecked;
                    // Mostrar error con toast
                    if (window.toast) {
                        window.toast.error(
                            'Error',
                            'Error al cambiar el estado del slider',
                            5000,
                            'bottom-center'
                        );
                    }
                });
                
                return false; // Prevenir propagación adicional
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/sliders/index.blade.php ENDPATH**/ ?>