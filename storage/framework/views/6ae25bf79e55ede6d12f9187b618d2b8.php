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
    <?php $__env->startSection('title', 'Productos'); ?>

    <?php $__env->startSection('content'); ?>
    
    <div x-data="productManagement" class="space-y-4">
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
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Productos</h2>
                        <p class="text-sm text-gray-600">
                            Usando <?php echo e($currentCount); ?> de <?php echo e($maxProducts); ?> productos disponibles en tu plan <?php echo e($store->plan->name); ?>

                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <?php if($currentCount < $maxProducts): ?>
                            <a href="<?php echo e(route('tenant.admin.products.create', $store->slug)); ?>">
                                <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'plus-circle','size' => 'md','text' => 'Nuevo Producto','dataTour' => 'product-button']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'plus-circle','size' => 'md','text' => 'Nuevo Producto','data-tour' => 'product-button']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'outline','color' => 'secondary','icon' => 'plus-circle','size' => 'md','text' => 'Límite Alcanzado','disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'secondary','icon' => 'plus-circle','size' => 'md','text' => 'Límite Alcanzado','disabled' => true]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'gestionar_productos','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'gestionar_productos','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
            


            
            <div class="px-6 py-3 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        
                        <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'filterStatus','selectId' => 'filter-status','options' => [
                                '' => 'Todos',
                                'active' => 'Activos',
                                'inactive' => 'Inactivos'
                            ],'selected' => request('status', ''),'placeholder' => 'Filtrar por estado','xModel' => 'filterStatus','@change' => 'applyFilters()','class' => 'w-48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'filterStatus','select-id' => 'filter-status','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                '' => 'Todos',
                                'active' => 'Activos',
                                'inactive' => 'Inactivos'
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
                                'simple' => 'Productos simples',
                                'variable' => 'Productos variables'
                            ],'selected' => request('type', ''),'placeholder' => 'Filtrar por tipo','xModel' => 'filterType','@change' => 'applyFilters()','class' => 'w-48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'filterType','select-id' => 'filter-type','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                '' => 'Todos los tipos',
                                'simple' => 'Productos simples',
                                'variable' => 'Productos variables'
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
                        

                        
                        <?php if($categories->count() > 0): ?>
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'filterCategory','selectId' => 'filter-category','options' => $categories->pluck('name', 'id')->prepend('Todas las categorías', ''),'selected' => request('category', ''),'placeholder' => 'Filtrar por categoría','xModel' => 'filterCategory','@change' => 'applyFilters()','class' => 'w-48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'filterCategory','select-id' => 'filter-category','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories->pluck('name', 'id')->prepend('Todas las categorías', '')),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('category', '')),'placeholder' => 'Filtrar por categoría','x-model' => 'filterCategory','@change' => 'applyFilters()','class' => 'w-48']); ?>
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
                        <?php endif; ?>
                        
                    </div>
                    
                    <div class="flex items-center gap-3">
                        
                        <?php if (isset($component)) { $__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithIcon','data' => ['type' => 'text','icon' => 'search','iconPosition' => 'left','placeholder' => 'Buscar productos...','xModel' => 'searchTerm','@input.debounce.500ms' => 'applyFilters()','class' => 'w-64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','icon' => 'search','icon-position' => 'left','placeholder' => 'Buscar productos...','x-model' => 'searchTerm','@input.debounce.500ms' => 'applyFilters()','class' => 'w-64']); ?>
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
                        
                        
                        
                        <div x-show="selectedProducts.length > 0" x-cloak class="flex items-center gap-2" style="display: none;">
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'success','icon' => 'check-circle','size' => 'sm','text' => 'Activar','@click' => 'bulkActivate()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'success','icon' => 'check-circle','size' => 'sm','text' => 'Activar','@click' => 'bulkActivate()']); ?>
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
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'warning','icon' => 'x-circle','size' => 'sm','text' => 'Desactivar','@click' => 'bulkDeactivate()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'warning','icon' => 'x-circle','size' => 'sm','text' => 'Desactivar','@click' => 'bulkDeactivate()']); ?>
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
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'error','icon' => 'trash-2','size' => 'sm','text' => 'Eliminar','@click' => 'bulkDelete()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'error','icon' => 'trash-2','size' => 'sm','text' => 'Eliminar','@click' => 'bulkDelete()']); ?>
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
                        
                    </div>
                </div>
            </div>
            

            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">
                                <input 
                                    type="checkbox" 
                                    id="select-all-products" 
                                    @change="toggleAll($event.target.checked)"
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                >
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Producto
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Precio
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Stock
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Categorías
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Activar/Desactivar
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Compartir
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition-colors" data-id="<?php echo e($product->id); ?>">
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <input 
                                        type="checkbox" 
                                        class="product-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                        value="<?php echo e($product->id); ?>"
                                        @change="toggleProduct(<?php echo e($product->id); ?>, $event.target.checked)"
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm">
                                        <div class="w-12 h-12 mr-3 flex items-center justify-center bg-gray-100 rounded-lg overflow-hidden shrink-0">
                                            <?php if($product->images && $product->images->count() > 0): ?>
                                                <img 
                                                    src="<?php echo e($product->images->first()->image_url); ?>" 
                                                    alt="<?php echo e($product->name); ?>"
                                                    class="w-full h-full object-cover"
                                                    onerror="this.onerror=null; this.parentElement.innerHTML='<i data-lucide=\\'package\\' class=\\'w-6 h-6 text-gray-400\\'></i>';"
                                                >
                                            <?php else: ?>
                                                <i data-lucide="package" class="w-6 h-6 text-gray-400"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate"><?php echo e($product->name); ?></p>
                                            <p class="text-xs text-gray-500">
                                                SKU: <?php echo e($product->sku ?: 'Sin SKU'); ?>

                                            </p>
                                            <p class="text-xs text-gray-400">
                                                <?php echo e($product->type === 'variable' ? 'Variable' : 'Simple'); ?>

                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="font-semibold text-gray-900">
                                        $<?php echo e(number_format($product->price, 2)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <?php if($product->controla_stock && $product->tipo_stock === 'limitado'): ?>
                                        <?php
                                            $stockTotal = $product->type === 'simple' 
                                                ? ($product->cantidad_stock ?? 0) 
                                                : $product->variants->sum('stock');
                                            $umbral = $product->umbral_alerta_stock ?? 1;
                                        ?>
                                        <span class="font-semibold <?php echo e($stockTotal <= 0 ? 'text-red-600' : ($stockTotal <= $umbral ? 'text-yellow-600' : 'text-green-600')); ?>">
                                            <?php echo e($stockTotal); ?>

                                        </span>
                                        <span class="text-xs text-gray-500">uds</span>
                                    <?php elseif($product->controla_stock && $product->tipo_stock === 'ilimitado'): ?>
                                        <span class="text-xs text-gray-500">Ilimitado</span>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">Sin stock</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <?php if($product->categories && $product->categories->count() > 0): ?>
                                        <div class="flex flex-wrap gap-1">
                                            <?php $__currentLoopData = $product->categories->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => $category->name,'class' => 'text-xs']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($category->name),'class' => 'text-xs']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($product->categories->count() > 2): ?>
                                                <span class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">
                                                    <?php echo e($product->categories->count() - 2); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400">Sin categorías</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <?php if($product->is_active): ?>
                                        <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'success','text' => 'Activo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','text' => 'Activo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                                    <?php else: ?>
                                        <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'error','text' => 'Inactivo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','text' => 'Inactivo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $attributes = $__attributesOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__attributesOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal932d1bd2c37cb3241be132016b9435ec)): ?>
<?php $component = $__componentOriginal932d1bd2c37cb3241be132016b9435ec; ?>
<?php unset($__componentOriginal932d1bd2c37cb3241be132016b9435ec); ?>
<?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <label for="toggle-status-<?php echo e($product->id); ?>" class="relative inline-block w-11 h-6 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            id="toggle-status-<?php echo e($product->id); ?>"
                                            class="peer sr-only product-toggle"
                                            data-product-id="<?php echo e($product->id); ?>"
                                            data-url="<?php echo e(route('tenant.admin.products.toggle-status', [$store->slug, $product->id])); ?>"
                                            <?php echo e($product->is_active ? 'checked' : ''); ?>

                                        >
                                        <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <label for="toggle-sharing-<?php echo e($product->id); ?>" class="relative inline-block w-11 h-6 cursor-pointer">
                                        <input 
                                            type="checkbox" 
                                            id="toggle-sharing-<?php echo e($product->id); ?>"
                                            class="peer sr-only sharing-toggle"
                                            data-product-id="<?php echo e($product->id); ?>"
                                            data-url="<?php echo e(route('tenant.admin.products.toggle-sharing', [$store->slug, $product->id])); ?>"
                                            <?php echo e($product->allow_sharing ? 'checked' : ''); ?>

                                        >
                                        <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                    </label>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center justify-center gap-2">
                                        <?php if (isset($component)) { $__componentOriginal38d2bc333cb742f7d6dcccf5229980de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Tooltips.TooltipTop','data' => ['text' => 'Ver detalles']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tooltip-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => 'Ver detalles']); ?>
                                            <a 
                                                href="<?php echo e(route('tenant.admin.products.show', [$store->slug, $product->id])); ?>"
                                                class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                aria-label="Ver detalles"
                                            >
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $attributes = $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $component = $__componentOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>

                                        <?php if (isset($component)) { $__componentOriginal38d2bc333cb742f7d6dcccf5229980de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Tooltips.TooltipTop','data' => ['text' => 'Editar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tooltip-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => 'Editar']); ?>
                                            <a 
                                                href="<?php echo e(route('tenant.admin.products.edit', [$store->slug, $product->id])); ?>"
                                                class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                                aria-label="Editar"
                                            >
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $attributes = $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $component = $__componentOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>

                                        <?php if (isset($component)) { $__componentOriginal38d2bc333cb742f7d6dcccf5229980de = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Tooltips.TooltipTop','data' => ['text' => 'Eliminar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tooltip-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => 'Eliminar']); ?>
                                            <button 
                                                type="button"
                                                @click="<?php if($store->isActionProtected('products', 'delete')): ?>
                                                            requireMasterKey('products.delete', 'Eliminar producto: <?php echo e(addslashes($product->name)); ?>', () => deleteProduct(<?php echo e($product->id); ?>, '<?php echo e(addslashes($product->name)); ?>'))
                                                        <?php else: ?>
                                                            deleteProduct(<?php echo e($product->id); ?>, '<?php echo e(addslashes($product->name)); ?>')
                                                        <?php endif; ?>"
                                                class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                aria-label="Eliminar"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $attributes = $__attributesOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__attributesOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de)): ?>
<?php $component = $__componentOriginal38d2bc333cb742f7d6dcccf5229980de; ?>
<?php unset($__componentOriginal38d2bc333cb742f7d6dcccf5229980de); ?>
<?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-12">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <?php
                                            $emptyStateSvg = 'base_ui_empty_productos.svg';
                                        ?>
                                        <img src="<?php echo e(asset('images-ui/' . $emptyStateSvg)); ?>" alt="Empty state" class="w-32 h-32 mb-4" />
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay productos</h3>
                                        <p class="text-sm text-gray-600 mb-6">Comienza agregando tu primer producto</p>
                                        <?php if($currentCount < $maxProducts): ?>
                                            <a href="<?php echo e(route('tenant.admin.products.create', $store->slug)); ?>">
                                                <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'plus-circle','size' => 'md','text' => 'Crear Producto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'plus-circle','size' => 'md','text' => 'Crear Producto']); ?>
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
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        
                        
                        <tr id="dynamic-empty-state" style="display: none;">
                            <td colspan="8" class="px-6 py-12">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <img src="<?php echo e(asset('images-ui/base_ui_empty_productos.svg')); ?>" alt="Empty state" class="w-32 h-32 mb-4" />
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay productos</h3>
                                    <p class="text-sm text-gray-600 mb-6">Comienza agregando tu primer producto</p>
                                    <?php if($currentCount < $maxProducts): ?>
                                        <a href="<?php echo e(route('tenant.admin.products.create', $store->slug)); ?>">
                                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'plus-circle','size' => 'md','text' => 'Crear Producto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'plus-circle','size' => 'md','text' => 'Crear Producto']); ?>
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
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            

            
            <?php if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($products->links()); ?>

                </div>
            <?php endif; ?>
            
        </div>
        
    </div>
    

    
    <?php if (isset($component)) { $__componentOriginaleab9e69d89a840e99f42ef0b1a9d8e55 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleab9e69d89a840e99f42ef0b1a9d8e55 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Modals.ModalMasterKey','data' => ['modalId' => 'master-key-modal','action' => 'products.delete','actionLabel' => 'Eliminar producto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal-master-key'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['modalId' => 'master-key-modal','action' => 'products.delete','actionLabel' => 'Eliminar producto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleab9e69d89a840e99f42ef0b1a9d8e55)): ?>
<?php $attributes = $__attributesOriginaleab9e69d89a840e99f42ef0b1a9d8e55; ?>
<?php unset($__attributesOriginaleab9e69d89a840e99f42ef0b1a9d8e55); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleab9e69d89a840e99f42ef0b1a9d8e55)): ?>
<?php $component = $__componentOriginaleab9e69d89a840e99f42ef0b1a9d8e55; ?>
<?php unset($__componentOriginaleab9e69d89a840e99f42ef0b1a9d8e55); ?>
<?php endif; ?>
    

    
    <div 
        x-data="deleteModalData()"
        x-on:keydown.escape.window="closeModal()"
        @delete-product.window="openModal($event.detail.id, $event.detail.name, $event.detail.rowElement)"
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
            x-cloak
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
            x-cloak
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 id="delete-modal-label" class="font-bold text-gray-800">
                            ¿Eliminar producto?
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
                                    Se eliminará el producto <strong>"<span x-text="productName"></span>"</strong> de forma permanente.
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
        // Mostrar toast de éxito si hay mensaje
        <?php if(session('success')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.toast) {
                window.toast.success(
                    '¡Hey! felicidades',
                    '<?php echo e(session('success')); ?>',
                    5000,
                    'bottom-center'
                );
            }
        });
        <?php endif; ?>

        // Mostrar toast de error si hay mensaje
        <?php if(session('error')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.toast) {
                window.toast.error(
                    '¡Ups! algo salió mal',
                    '<?php echo e(session('error')); ?>',
                    5000,
                    'bottom-center'
                );
            }
        });
        <?php endif; ?>

        document.addEventListener('alpine:init', () => {
            Alpine.data('productManagement', () => ({
                selectedProducts: [],
                filterStatus: '',
                filterType: '',
                filterCategory: '',
                searchTerm: '',

                init() {
                    // Inicializar Sortable.js para drag & drop si está disponible
                    if (typeof Sortable !== 'undefined') {
                        new Sortable(document.getElementById('sortableProducts'), {
                            handle: '.drag-handle',
                            animation: 150,
                            onEnd: () => {
                                this.updateOrder();
                            }
                        });
                    }
                },

                deleteProduct(id, name) {
                    const rowElement = document.querySelector(`tr[data-id="${id}"]`);
                    window.dispatchEvent(new CustomEvent('delete-product', {
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

                    if (this.filterCategory) {
                        params.set('category', this.filterCategory);
                    } else {
                        params.delete('category');
                    }

                    if (this.searchTerm) {
                        params.set('search', this.searchTerm);
                    } else {
                        params.delete('search');
                    }
                    
                    window.location.search = params.toString();
                },

            }));
        });

        // Toggle de estado de producto
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-toggle')) {
                e.stopPropagation(); // Prevenir que otros listeners capturen el evento
                
                const productId = e.target.dataset.productId;
                const url = e.target.dataset.url;
                const originalChecked = e.target.checked;
                const row = e.target.closest('tr');
                
                // Verificar que la URL sea para productos, no categorías
                if (!url || !url.includes('products')) {
                    console.error('URL incorrecta para toggle de producto:', url);
                    e.target.checked = !originalChecked;
                    return;
                }
                
                fetch(url, {
                    method: 'POST',
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
                            const statusCell = row.querySelector('td:nth-child(5)');
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
                                ? 'El producto se ha activado correctamente.'
                                : 'El producto se ha desactivado correctamente.';
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
                                data.error || 'Error al cambiar el estado del producto',
                                5000,
                                'bottom-center'
                            );
                        }
                    }
                })
                .catch(error => {
                    console.error('Error al cambiar estado del producto:', error);
                    e.target.checked = !originalChecked;
                    // Mostrar error con toast
                    if (window.toast) {
                        window.toast.error(
                            'Error',
                            'Error al cambiar el estado del producto',
                            5000,
                            'bottom-center'
                        );
                    }
                });
                
                return false; // Prevenir propagación adicional
            }
        });

        // Toggle de compartir
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('sharing-toggle')) {
                const url = e.target.dataset.url;
                const originalChecked = e.target.checked;
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ allow_sharing: originalChecked })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar toast de éxito
                        if (window.toast) {
                            const message = data.allow_sharing
                                ? 'El compartir se ha activado correctamente.'
                                : 'El compartir se ha desactivado correctamente.';
                            window.toast.success(
                                'Estado actualizado',
                                message,
                                5000,
                                'bottom-center'
                            );
                        }
                    } else {
                        e.target.checked = !originalChecked;
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                data.error || 'Error al actualizar',
                                5000,
                                'bottom-center'
                            );
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    e.target.checked = !originalChecked;
                    if (window.toast) {
                        window.toast.error(
                            'Error',
                            'Error al actualizar',
                            5000,
                            'bottom-center'
                        );
                    }
                });
            }
        });

        // Función para el modal de eliminación
        function deleteModalData() {
            return {
                open: false,
                productId: null,
                productName: '',
                productRow: null,
                loading: false,
                error: null,
                
                openModal(id, name, rowElement) {
                    this.productId = id;
                    this.productName = name;
                    this.productRow = rowElement;
                    this.error = null;
                    this.open = true;
                },
                
                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.productId = null;
                        this.productName = '';
                        this.productRow = null;
                        this.error = null;
                    }
                },
                
                async confirmDelete() {
                    if (!this.productId) return;
                    
                    this.loading = true;
                    this.error = null;
                    
                    try {
                        const storeSlug = '<?php echo e($store->slug); ?>';
                        const response = await fetch('/' + storeSlug + '/admin/products/' + this.productId, {
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
                            throw new Error(data.error || 'Error al eliminar el producto');
                        }

                        if (data.error) {
                            throw new Error(data.error);
                        }

                        this.loading = false;
                        
                        const rowToDelete = this.productRow;
                        const productName = this.productName;
                        
                        this.closeModal();
                        
                        if (rowToDelete && rowToDelete.parentNode) {
                            rowToDelete.style.transition = 'opacity 0.3s ease-out';
                            rowToDelete.style.opacity = '0';
                            setTimeout(() => {
                                if (rowToDelete.parentNode) {
                                    rowToDelete.remove();
                                    
                                    // Verificar si quedan productos después de eliminar
                                    setTimeout(() => {
                                        const tbody = document.querySelector('tbody');
                                        if (!tbody) return;
                                        
                                        const productRows = tbody.querySelectorAll('tr[data-id]');
                                        const visibleRows = Array.from(productRows).filter(row => {
                                            const style = window.getComputedStyle(row);
                                            return style.display !== 'none' && 
                                                   row.style.opacity !== '0' && 
                                                   row.offsetParent !== null &&
                                                   !row.classList.contains('removing');
                                        });
                                        
                                        const dynamicEmptyState = document.getElementById('dynamic-empty-state');
                                        
                                        // Si no quedan productos, mostrar empty state
                                        if (visibleRows.length === 0 && dynamicEmptyState) {
                                            const thead = document.querySelector('thead');
                                            if (thead) {
                                                thead.style.display = 'none';
                                            }
                                            
                                            // Ocultar cualquier empty state de Blade que pueda estar visible
                                            const bladeEmptyStateRows = tbody.querySelectorAll('tr:not([data-id]):not(#dynamic-empty-state)');
                                            bladeEmptyStateRows.forEach(row => {
                                                if (row.id !== 'dynamic-empty-state') {
                                                    row.style.display = 'none';
                                                }
                                            });
                                            
                                            // Mostrar el empty state dinámico
                                            dynamicEmptyState.style.display = '';
                                            
                                            // Re-inicializar iconos Lucide
                                            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                                window.createIcons({ icons: window.lucideIcons });
                                            }
                                        } else {
                                            // Si hay productos, mostrar thead y ocultar empty state
                                            const thead = document.querySelector('thead');
                                            if (thead) {
                                                thead.style.display = '';
                                            }
                                            
                                            if (dynamicEmptyState) {
                                                dynamicEmptyState.style.display = 'none';
                                            }
                                        }
                                    }, 350);
                                    
                                    if (window.toast) {
                                        window.toast.success(
                                            'Actualización exitosa',
                                            'El producto se ha eliminado correctamente.',
                                            5000,
                                            'bottom-center'
                                        );
                                    }
                                }
                            }, 300);
                        } else {
                            window.location.reload();
                            return;
                        }
                    } catch (error) {
                        this.error = error.message || 'Error al eliminar el producto';
                        this.loading = false;
                    }
                }
            };
        }

        // Inicializar iconos Lucide
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
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
<?php endif; ?> <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/products/index.blade.php ENDPATH**/ ?>