

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
    <?php $__env->startSection('title', 'Variables'); ?>

    <?php $__env->startSection('content'); ?>
    
    <?php
        // Personaliza estos valores para el estado vacío
        $emptyStateSvg = 'base_ui_empty_variables.svg';
        $emptyStateTitle = 'No hay variables disponibles';
        $emptyStateMessage = 'Comienza agregando variables para tus productos.';
    ?>
    

    
    <div 
        x-data="variableManagement" 
        class="space-y-4" 
        x-init="init()"
    >
        
        <div 
            x-show="showToggleError"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            style="display: none;"
        >
            <?php if (isset($component)) { $__componentOriginal4e12e3fb830c932c6bff0347987a4573 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e12e3fb830c932c6bff0347987a4573 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertBordered','data' => ['type' => 'error','title' => 'Error']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-bordered'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','title' => 'Error']); ?>
                <span x-text="toggleErrorMessage"></span>
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
        

        
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Variables</h2>
                        <p class="text-sm text-gray-600">
                            Usando <?php echo e($totalVariables); ?> de <?php echo e($variableLimit); ?> variables disponibles en tu plan <?php echo e($store->plan->name); ?>

                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div x-show="selectedVariables.length > 0" x-cloak style="display: none;">
                            
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'error','size' => 'md','icon' => 'trash-2','xText' => '\'Eliminar \' + selectedVariables.length + (selectedVariables.length === 1 ? \' variable\' : \' variables\')','@click' => 'deleteSelectedVariables()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'error','size' => 'md','icon' => 'trash-2','x-text' => '\'Eliminar \' + selectedVariables.length + (selectedVariables.length === 1 ? \' variable\' : \' variables\')','@click' => 'deleteSelectedVariables()']); ?>
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
                        <?php if($totalVariables < $variableLimit): ?>
                            <a href="<?php echo e(route('tenant.admin.variables.create', $store->slug)); ?>">
                                
                                <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','size' => 'md','icon' => 'plus-circle','text' => 'Nueva Variable','dataTour' => 'variable-button']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','size' => 'md','icon' => 'plus-circle','text' => 'Nueva Variable','data-tour' => 'variable-button']); ?>
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
                        <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'gestionar_variables','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'gestionar_variables','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
                    </div>
                </div>
            </div>
            

            
            <div class="px-6 py-3 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        
                        
                        <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'filterStatus','selectId' => 'filter-status','options' => [
                                '' => 'Todas',
                                'active' => 'Activas',
                                'inactive' => 'Inactivas'
                            ],'selected' => request('status', ''),'placeholder' => 'Filtrar por estado','xModel' => 'filterStatus','@change' => 'applyFilters()','class' => 'w-48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'filterStatus','select-id' => 'filter-status','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                '' => 'Todas',
                                'active' => 'Activas',
                                'inactive' => 'Inactivas'
                            ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('status', '')),'placeholder' => 'Filtrar por estado','x-model' => 'filterStatus','@change' => 'applyFilters()','class' => 'w-48']); ?>
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
                        
                        
                        
                        
                        
                        <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'filterType','selectId' => 'filter-type','options' => [
                                '' => 'Todos los tipos',
                                'radio' => 'Selección única',
                                'checkbox' => 'Selección múltiple',
                                'text' => 'Texto libre',
                                'numeric' => 'Numérico'
                            ],'selected' => request('type', ''),'placeholder' => 'Filtrar por tipo','xModel' => 'filterType','@change' => 'applyFilters()','class' => 'w-48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'filterType','select-id' => 'filter-type','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                '' => 'Todos los tipos',
                                'radio' => 'Selección única',
                                'checkbox' => 'Selección múltiple',
                                'text' => 'Texto libre',
                                'numeric' => 'Numérico'
                            ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('type', '')),'placeholder' => 'Filtrar por tipo','x-model' => 'filterType','@change' => 'applyFilters()','class' => 'w-48']); ?>
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

                    <div class="text-sm text-gray-600">
                        Mostrando <span data-variable-count="<?php echo e($variables->count()); ?>"><?php echo e($variables->firstItem() ?? 0); ?></span> - <?php echo e($variables->lastItem() ?? 0); ?> de <?php echo e($variables->total()); ?> variables
                    </div>
                </div>
            </div>
            

            
            <?php if (isset($component)) { $__componentOriginal2bbc4b653393378a27dff7bb44a4bc3f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2bbc4b653393378a27dff7bb44a4bc3f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Variables.VariablesTable','data' => ['variables' => $variables,'store' => $store,'emptyStateSvg' => $emptyStateSvg,'emptyStateTitle' => $emptyStateTitle,'emptyStateMessage' => $emptyStateMessage,'totalVariables' => $totalVariables,'variableLimit' => $variableLimit]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('variables-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variables' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($variables),'store' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store),'emptyStateSvg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateSvg),'emptyStateTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateTitle),'emptyStateMessage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateMessage),'totalVariables' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalVariables),'variableLimit' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($variableLimit)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2bbc4b653393378a27dff7bb44a4bc3f)): ?>
<?php $attributes = $__attributesOriginal2bbc4b653393378a27dff7bb44a4bc3f; ?>
<?php unset($__attributesOriginal2bbc4b653393378a27dff7bb44a4bc3f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2bbc4b653393378a27dff7bb44a4bc3f)): ?>
<?php $component = $__componentOriginal2bbc4b653393378a27dff7bb44a4bc3f; ?>
<?php unset($__componentOriginal2bbc4b653393378a27dff7bb44a4bc3f); ?>
<?php endif; ?>
            

            
            <?php if($variables->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($variables->links()); ?>

                </div>
            <?php endif; ?>
            
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
                            ¿Eliminar variables?
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
                                    Se eliminarán <strong><span x-text="selectedVariables.length"></span> <span x-text="selectedVariables.length === 1 ? 'variable' : 'variables'"></span></strong> de forma permanente.
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
    

    
    <div 
        x-data="deleteModalData()"
        x-on:keydown.escape.window="closeModal()"
        @delete-variable.window="openModal($event.detail.id, $event.detail.name, $event.detail.rowElement)"
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
                            ¿Eliminar variable?
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
                                    Se eliminará la variable <strong>"<span x-text="variableName"></span>"</strong> de forma permanente.
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Esta acción no se puede deshacer.
                                </p>
                                
                                
                                <div x-show="error" class="mt-3" x-cloak>
                                    <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                        <div class="flex">
                                            <div class="shrink-0">
                                                <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                            </div>
                                            <div class="ms-2">
                                                <h3 class="text-sm font-medium">
                                                    Error: <span x-text="error"></span>
                                                </h3>
                                            </div>
                                            <div class="ps-3 ms-auto">
                                                <div class="-mx-1.5 -my-1.5">
                                                    <button 
                                                        type="button" 
                                                        class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100" 
                                                        @click="error = null"
                                                    >
                                                        <span class="sr-only">Descartar</span>
                                                        <i data-lucide="x" class="shrink-0 size-4"></i>
                                                    </button>
                                                </div>
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
    

    <?php $__env->startPush('scripts'); ?>
    <script>
        function deleteModalData() {
            return {
                open: false,
                variableId: null,
                variableName: '',
                variableRow: null,
                loading: false,
                error: null,
                
                openModal(id, name, rowElement) {
                    this.variableId = id;
                    this.variableName = name;
                    this.variableRow = rowElement;
                    this.error = null;
                    this.open = true;
                },
                
                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.variableId = null;
                        this.variableName = '';
                        this.variableRow = null;
                        this.error = null;
                    }
                },
                
                async confirmDelete() {
                    if (!this.variableId) return;
                    
                    this.loading = true;
                    this.error = null;
                    
                    try {
                        const storeSlug = '<?php echo e($store->slug); ?>';
                        const response = await fetch('/' + storeSlug + '/admin/variables/' + this.variableId, {
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
                            throw new Error(data.error || 'Error al eliminar la variable');
                        }

                        if (data.error) {
                            throw new Error(data.error);
                        }

                        this.loading = false;
                        
                        const rowToDelete = this.variableRow;
                        const variableName = this.variableName;
                        
                        this.closeModal();
                        
                        if (rowToDelete && rowToDelete.parentNode) {
                            rowToDelete.style.transition = 'opacity 0.3s ease-out';
                            rowToDelete.style.opacity = '0';
                            setTimeout(() => {
                                if (rowToDelete.parentNode) {
                                    rowToDelete.remove();
                                    this.updateVariableCount();
                                    
                                    // Verificar si quedan variables y mostrar EmptyState si es necesario
                                    const variableManagement = Alpine.$data(document.querySelector('[x-data="variableManagement"]'));
                                    if (variableManagement && variableManagement.checkAndShowEmptyState) {
                                        variableManagement.checkAndShowEmptyState();
                                    }
                                    
                                    window.dispatchEvent(new CustomEvent('show-success-alert'));
                                }
                            }, 300);
                        } else {
                            window.location.reload();
                            return;
                        }
                    } catch (error) {
                        this.error = error.message || 'Error al eliminar la variable';
                        this.loading = false;
                    }
                },
                
                updateVariableCount() {
                    const totalCount = document.querySelectorAll('tbody tr[data-variable-id]').length;
                    const countElement = document.querySelector('[data-variable-count]');
                    if (countElement) {
                        countElement.textContent = totalCount;
                    }
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('variableManagement', () => ({
                filterStatus: '<?php echo e(request('status', '')); ?>',
                filterType: '<?php echo e(request('type', '')); ?>',
                showSuccessAlert: false,
                selectedVariables: [],
                selectAll: false,
                showBulkDeleteModal: false,
                bulkDeleteLoading: false,
                bulkDeleteError: null,
                bulkDeleteSuccessCount: 0,
                showBulkDeleteSuccessAlert: false,
                showToggleError: false,
                toggleErrorMessage: '',

                init() {
                    window.addEventListener('show-success-alert', () => {
                        if (window.toast) {
                            window.toast.success('¡Listo!', 'Variable eliminada correctamente', 5000, 'bottom-center');
                        }
                        this.$nextTick(() => {
                            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                                lucide.createIcons();
                            }
                        });
                    });

                    // Inicializar iconos Lucide
                    if (typeof lucide !== 'undefined' && lucide.createIcons) {
                        lucide.createIcons();
                    }
                },

                deleteVariable(id, name, event) {
                    const rowElement = event.target.closest('tr');
                    if (!rowElement) {
                        return;
                    }
                    window.dispatchEvent(new CustomEvent('delete-variable', {
                        detail: { id, name, rowElement }
                    }));
                },

                applyFilters() {
                    const params = new URLSearchParams(window.location.search);
                    
                    if (this.filterStatus) {
                        params.set('status', this.filterStatus);
                    } else {
                        params.delete('status');
                    }
                    
                    if (this.filterType) {
                        params.set('type', this.filterType);
                    } else {
                        params.delete('type');
                    }
                    
                    window.location.search = params.toString();
                },

                toggleSelectAll() {
                    const selectAllCheckbox = document.getElementById('select-all-variables');
                    if (!selectAllCheckbox) return;
                    
                    const isChecked = selectAllCheckbox.checked;
                    this.selectAll = isChecked;
                    
                    const checkboxes = document.querySelectorAll('.variable-checkbox');
                    checkboxes.forEach(checkbox => {
                        const variableId = parseInt(checkbox.value);
                        const productsCount = parseInt(checkbox.closest('tr').dataset.productsCount || '0');
                        
                        // Solo seleccionar si no tiene productos
                        if (productsCount === 0) {
                            checkbox.checked = isChecked;
                            if (isChecked) {
                                if (!this.selectedVariables.includes(variableId)) {
                                    this.selectedVariables.push(variableId);
                                }
                            } else {
                                this.selectedVariables = this.selectedVariables.filter(id => id !== variableId);
                            }
                        }
                    });
                },

                toggleVariable(checkbox) {
                    if (!checkbox) return;
                    const variableId = parseInt(checkbox.value);
                    const productsCount = parseInt(checkbox.closest('tr').dataset.productsCount || '0');
                    
                    // Solo permitir seleccionar si no tiene productos
                    if (productsCount > 0) {
                        checkbox.checked = false;
                        return;
                    }
                    
                    if (checkbox.checked) {
                        if (!this.selectedVariables.includes(variableId)) {
                            this.selectedVariables.push(variableId);
                        }
                    } else {
                        this.selectedVariables = this.selectedVariables.filter(id => id !== variableId);
                    }
                    this.updateSelectAllState();
                },

                updateSelectAllState() {
                    const checkboxes = document.querySelectorAll('.variable-checkbox');
                    const selectAllCheckbox = document.getElementById('select-all-variables');
                    if (!checkboxes.length || !selectAllCheckbox) return;
                    
                    const selectableCheckboxes = Array.from(checkboxes).filter(cb => {
                        const productsCount = parseInt(cb.closest('tr').dataset.productsCount || '0');
                        return productsCount === 0;
                    });
                    
                    const checkedCount = selectableCheckboxes.filter(cb => cb.checked).length;
                    this.selectAll = selectableCheckboxes.length > 0 && checkedCount === selectableCheckboxes.length;
                    selectAllCheckbox.checked = this.selectAll;
                },

                deleteSelectedVariables() {
                    if (this.selectedVariables.length === 0) return;
                    this.showBulkDeleteModal = true;
                },

                closeBulkDeleteModal() {
                    if (!this.bulkDeleteLoading) {
                        this.showBulkDeleteModal = false;
                        this.bulkDeleteError = null;
                    }
                },

                async confirmBulkDelete() {
                    if (this.selectedVariables.length === 0) return;
                    
                    this.bulkDeleteLoading = true;
                    this.bulkDeleteError = null;
                    
                    const storeSlug = '<?php echo e($store->slug); ?>';
                    const variableIdsToDelete = [...this.selectedVariables];
                    let successCount = 0;
                    let errorCount = 0;
                    
                    for (const variableId of variableIdsToDelete) {
                        try {
                            const response = await fetch('/' + storeSlug + '/admin/variables/' + variableId, {
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
                                const row = document.querySelector(`tr[data-variable-id="${variableId}"]`);
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
                    this.selectedVariables = [];
                    this.selectAll = false;
                    const selectAllCheckbox = document.getElementById('select-all-variables');
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = false;
                    }
                    
                    // Esperar un poco para que las animaciones de eliminación terminen
                    setTimeout(() => {
                        this.updateSelectAllState();
                        
                        // Verificar si quedan variables y mostrar EmptyState si es necesario
                        this.checkAndShowEmptyState();
                        
                        if (errorCount === 0) {
                            this.bulkDeleteSuccessCount = successCount;
                            
                            // Mostrar toast de éxito
                            if (window.toast) {
                                window.toast.success('¡Listo!', `Se eliminaron ${successCount} ${successCount === 1 ? 'variable' : 'variables'} correctamente`, 5000, 'bottom-center');
                            }
                            
                            // Inicializar iconos Lucide después de mostrar el toast
                            this.$nextTick(() => {
                                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                                    lucide.createIcons();
                                }
                            });
                        } else {
                            this.bulkDeleteError = `Se eliminaron ${successCount} variables. ${errorCount > 0 ? `${errorCount} variables no pudieron ser eliminadas.` : ''}`;
                            this.showBulkDeleteModal = true;
                        }
                    }, 350);
                },

                checkAndShowEmptyState() {
                    // Esperar un poco para que las animaciones de eliminación terminen
                    setTimeout(() => {
                        const tbody = document.querySelector('tbody');
                        if (!tbody) return;
                        
                        // Contar filas visibles (excluyendo el empty state dinámico)
                        const variableRows = tbody.querySelectorAll('tr[data-variable-id]');
                        const visibleRows = Array.from(variableRows).filter(row => {
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
                            const bladeEmptyStateRows = tbody.querySelectorAll('tr:not([data-variable-id]):not(#dynamic-empty-state)');
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
            if (e.target.id === 'select-all-variables') {
                const variableManagement = Alpine.$data(document.querySelector('[x-data="variableManagement"]'));
                if (variableManagement) {
                    variableManagement.toggleSelectAll();
                }
            }
            
            // Individual checkboxes
            if (e.target.classList.contains('variable-checkbox')) {
                const variableManagement = Alpine.$data(document.querySelector('[x-data="variableManagement"]'));
                if (variableManagement) {
                    variableManagement.toggleVariable(e.target);
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }

            // Función para actualizar el estado del botón eliminar según el conteo de productos
            function updateDeleteButtonState(variableId, productsCount) {
                const row = document.querySelector(`tr[data-variable-id="${variableId}"]`);
                if (!row) return;

                const deleteButton = row.querySelector('.variable-delete-btn');
                if (!deleteButton) return;

                // Actualizar el atributo data-products-count
                row.setAttribute('data-products-count', productsCount);
                deleteButton.setAttribute('data-products-count', productsCount);

                // Habilitar o deshabilitar el botón
                if (productsCount > 0) {
                    deleteButton.disabled = true;
                    deleteButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    deleteButton.disabled = false;
                    deleteButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }

            // Escuchar eventos de actualización de conteo de productos
            window.addEventListener('update-variable-products-count', function(event) {
                const { variableId, productsCount } = event.detail;
                updateDeleteButtonState(variableId, productsCount);
            });
        });

        // Mostrar toast de sesión si existe
        <?php if(session('variable_created')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.toast) {
                window.toast.success('¡Listo!', 'Variable creada exitosamente', 5000, 'bottom-center');
            }
        });
        <?php endif; ?>
        
        <?php if(session('variable_updated')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.toast) {
                window.toast.success('¡Listo!', 'Variable actualizada exitosamente', 5000, 'bottom-center');
            }
        });
        <?php endif; ?>
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/variables/index.blade.php ENDPATH**/ ?>