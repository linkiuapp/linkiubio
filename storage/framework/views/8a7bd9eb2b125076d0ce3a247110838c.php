

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
    <?php $__env->startSection('title', 'Anuncios de Linkiu'); ?>

    <?php $__env->startSection('content'); ?>
    
    <?php
        $emptyStateSvg = 'base_ui_empty_anuncios.svg';
        $emptyStateTitle = 'No hay anuncios';
        $emptyStateMessage = request()->hasAny(['type', 'status', 'search']) 
            ? 'No se encontraron anuncios con los filtros aplicados.'
            : 'Aún no hay anuncios disponibles para tu tienda.';
    ?>
    

    
    <div 
        x-data="announcementsBoard()" 
        class="space-y-6"
        x-init="init()"
    >
        
        <div 
            x-show="showSuccessAlert" 
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertBordered','data' => ['type' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-bordered'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success']); ?>
                <h3 class="text-gray-800 font-semibold" x-text="successMessage"></h3>
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
            <div class="p-6 space-y-6">
                
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-lg font-semibold text-gray-800">Anuncios de Linkiu</h1>
                        <p class="text-sm text-gray-600 mt-1">Mantente informado sobre actualizaciones y novedades de la plataforma</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <?php if($stats['unread'] > 0): ?>
                            
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'info','icon' => 'check-circle-2','size' => 'md','text' => 'Marcar Todos como Leídos','htmlType' => 'button','@click' => 'markAllAsRead()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','icon' => 'check-circle-2','size' => 'md','text' => 'Marcar Todos como Leídos','html-type' => 'button','@click' => 'markAllAsRead()']); ?>
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
                

                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total</p>
                                <p class="text-2xl font-bold text-gray-800"><?php echo e($stats['total']); ?></p>
                            </div>
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="message-square" class="w-5 h-5 text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                    

                    
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Sin Leer</p>
                                <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['unread']); ?></p>
                            </div>
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="bell" class="w-5 h-5 text-yellow-600"></i>
                            </div>
                        </div>
                    </div>
                    

                    
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Banners</p>
                                <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['banners']); ?></p>
                            </div>
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="image" class="w-5 h-5 text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                    

                    
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Críticos</p>
                                <p class="text-2xl font-bold text-red-600"><?php echo e($stats['critical']); ?></p>
                            </div>
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-red-600"></i>
                            </div>
                        </div>
                    </div>
                    
                </div>
                

                
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-800 mb-2">Tipo</label>
                            
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'type','selectId' => 'type','options' => [
                                    '' => 'Todos los tipos',
                                    'critical' => 'Crítico',
                                    'important' => 'Importante',
                                    'info' => 'Información'
                                ],'selected' => request('type', ''),'placeholder' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'type','select-id' => 'type','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    '' => 'Todos los tipos',
                                    'critical' => 'Crítico',
                                    'important' => 'Importante',
                                    'info' => 'Información'
                                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('type', '')),'placeholder' => '']); ?>
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
                        

                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-800 mb-2">Estado de Lectura</label>
                            
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'status','selectId' => 'status','options' => [
                                    '' => 'Todos',
                                    'unread' => 'Sin leer',
                                    'read' => 'Leídos'
                                ],'selected' => request('status', ''),'placeholder' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'status','select-id' => 'status','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    '' => 'Todos',
                                    'unread' => 'Sin leer',
                                    'read' => 'Leídos'
                                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('status', '')),'placeholder' => '']); ?>
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
                        

                        
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-800 mb-2">Buscar</label>
                            
                            <?php if (isset($component)) { $__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithIcon','data' => ['type' => 'text','icon' => 'search','iconPosition' => 'left','placeholder' => 'Título o contenido...','name' => 'search','id' => 'search','value' => request('search', '')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','icon' => 'search','icon-position' => 'left','placeholder' => 'Título o contenido...','name' => 'search','id' => 'search','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('search', ''))]); ?>
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
                            
                        </div>
                        

                        
                        <div class="flex items-end gap-2">
                            
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'search','size' => 'sm','text' => 'Filtrar','htmlType' => 'submit','class' => 'flex-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'search','size' => 'sm','text' => 'Filtrar','html-type' => 'submit','class' => 'flex-1']); ?>
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
                            
                            <a href="<?php echo e(route('tenant.admin.announcements.index', $store->slug)); ?>" 
                               class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition-colors">
                                <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                            </a>
                        </div>
                        
                    </form>
                </div>
                

                
                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $isRead = $announcement->isReadBy($store->id);
                            $typeColors = [
                                'critical' => ['bg' => 'bg-red-50', 'border' => 'border-red-500', 'text' => 'text-red-700', 'badge' => 'error'],
                                'important' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-500', 'text' => 'text-yellow-700', 'badge' => 'warning'],
                                'info' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-500', 'text' => 'text-blue-700', 'badge' => 'info'],
                            ];
                            $colors = $typeColors[$announcement->type] ?? $typeColors['info'];
                        ?>
                        
                        
                        <?php
                            $ringClass = !$isRead ? 'ring-2 ' . str_replace('border-', 'ring-', str_replace('-500', '-100', $colors['border'])) : '';
                        ?>
                        <div class="bg-white rounded-lg border-l-4 <?php echo e($colors['border']); ?> p-0 overflow-hidden <?php echo e($ringClass); ?>">
                            <div class="p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        
                                        <div class="flex items-start gap-3 mb-3">
                                            <div class="w-10 h-10 <?php echo e($colors['bg']); ?> rounded-full flex items-center justify-center flex-shrink-0">
                                                <?php if($announcement->type === 'critical'): ?>
                                                    <i data-lucide="alert-triangle" class="w-5 h-5 <?php echo e($colors['text']); ?>"></i>
                                                <?php elseif($announcement->type === 'important'): ?>
                                                    <i data-lucide="star" class="w-5 h-5 <?php echo e($colors['text']); ?>"></i>
                                                <?php else: ?>
                                                    <i data-lucide="info" class="w-5 h-5 <?php echo e($colors['text']); ?>"></i>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                    <h3 class="text-lg font-semibold text-gray-800"><?php echo e($announcement->title); ?></h3>
                                                    <?php if(!$isRead): ?>
                                                        
                                                        <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'warning','text' => 'Nuevo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning','text' => 'Nuevo']); ?>
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
                                                    <?php if($announcement->show_as_banner): ?>
                                                        
                                                        <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'info','text' => 'Banner']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','text' => 'Banner']); ?>
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
                                                </div>
                                                
                                                <div class="flex items-center gap-4 text-sm text-gray-600 flex-wrap">
                                                    
                                                    <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => $colors['badge'],'text' => $announcement->type_label]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($colors['badge']),'text' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($announcement->type_label)]); ?>
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
                                                    
                                                    <span class="flex items-center gap-1">
                                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                                        <?php echo e($announcement->created_at->format('d/m/Y')); ?>

                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <i data-lucide="star" class="w-4 h-4"></i>
                                                        Prioridad <?php echo e($announcement->priority); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        
                                        <div class="ml-13">
                                            <p class="text-gray-700 leading-relaxed mb-4">
                                                <?php echo e(Str::limit($announcement->content, 200)); ?>

                                            </p>

                                            
                                            <?php if($announcement->banner_image): ?>
                                                <div class="mb-4">
                                                    <img src="<?php echo e($announcement->banner_image_url); ?>" 
                                                         alt="Banner" 
                                                         class="border border-gray-200 rounded"
                                                         style="width: 160px; height: 50px; object-fit: cover;">
                                                </div>
                                            <?php endif; ?>
                                            

                                            
                                            <div class="flex items-center gap-3 flex-wrap">
                                                <a href="<?php echo e(route('tenant.admin.announcements.show', ['store' => $store->slug, 'announcement' => $announcement])); ?>">
                                                    
                                                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'eye','size' => 'sm','text' => 'Leer Completo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'eye','size' => 'sm','text' => 'Leer Completo']); ?>
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

                                                <?php if(!$isRead): ?>
                                                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'outline','color' => 'success','icon' => 'check-circle','size' => 'md','text' => 'Marcar como Leído','htmlType' => 'button','@click' => 'markAsRead('.e($announcement->id).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'success','icon' => 'check-circle','size' => 'md','text' => 'Marcar como Leído','html-type' => 'button','@click' => 'markAsRead('.e($announcement->id).')']); ?>
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
                                                <?php else: ?>
                                                    
                                                    <?php if (isset($component)) { $__componentOriginal932d1bd2c37cb3241be132016b9435ec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal932d1bd2c37cb3241be132016b9435ec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Badges.BadgeSoft','data' => ['type' => 'success','text' => 'Leído']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('badge-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'success','text' => 'Leído']); ?>
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

                                                <?php if($announcement->banner_link): ?>
                                                    <a href="<?php echo e($announcement->banner_link); ?>" target="_blank">
                                                        
                                                        <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'outline','color' => 'info','icon' => 'external-link','size' => 'md','text' => 'Ver Enlace']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'info','icon' => 'external-link','size' => 'md','text' => 'Ver Enlace']); ?>
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
                                            
                                        </div>
                                        
                                    </div>

                                    
                                    <div class="text-right text-sm text-gray-600">
                                        <?php echo e($announcement->created_at->diffForHumans()); ?>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::EmptyStates.EmptyState','data' => ['svg' => $emptyStateSvg,'title' => $emptyStateTitle,'message' => $emptyStateMessage]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['svg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateSvg),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateTitle),'message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($emptyStateMessage)]); ?>
                    <?php if(request()->hasAny(['type', 'status', 'search'])): ?>
                        <a href="<?php echo e(route('tenant.admin.announcements.index', $store->slug)); ?>">
                            <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'primary','size' => 'md','text' => 'Limpiar Filtros']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'primary','size' => 'md','text' => 'Limpiar Filtros']); ?>
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
                    <?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
                
            <?php endif; ?>
                </div>
                

                
                <?php if($announcements->hasPages()): ?>
                    <div class="mt-6">
                        <?php echo e($announcements->links()); ?>

                    </div>
                <?php endif; ?>
                
            </div>
        </div>
        
    </div>
    

    <?php $__env->startPush('scripts'); ?>
    <script>
        function announcementsBoard() {
            return {
                showSuccessAlert: false,
                successMessage: '',
                
                init() {
                    // Inicializar iconos Lucide
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                },
                
                markAsRead(announcementId) {
                    fetch(`<?php echo e(route('tenant.admin.announcements.mark-as-read', ['store' => $store->slug, 'announcement' => ':id'])); ?>`.replace(':id', announcementId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.showSuccessMessage(data.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                },
                
                markAllAsRead() {
                    if (confirm('¿Marcar todos los anuncios como leídos?')) {
                        fetch(`<?php echo e(route('tenant.admin.announcements.mark-all-as-read', $store->slug)); ?>`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.showSuccessMessage(data.message);
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                    }
                },
                
                showSuccessMessage(message) {
                    this.successMessage = message;
                    this.showSuccessAlert = true;
                    setTimeout(() => {
                        this.showSuccessAlert = false;
                    }, 5000);
                }
            }
        }
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/announcements/index.blade.php ENDPATH**/ ?>