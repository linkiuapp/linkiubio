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
    <?php $__env->startSection('title', 'Diseño de tienda'); ?>

    <?php $__env->startSection('content'); ?>
    <div
        class="space-y-6"
        x-data="storeDesignPage()"
        x-init="init()"
        x-effect="pushPreviewState()"
        x-cloak
    >
        
        <div class="flex flex-col-2 gap-3 items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">Diseño de tienda</h1>
                <p class="text-sm text-gray-500">Configura los textos, colores e identidad visual que verá tu clientela.</p>
            </div>
            <div class="flex items-center gap-2">
                <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'sparkles','text' => 'Publicar cambios','htmlType' => 'button','@click' => 'openPublishModal()','dataTour' => 'publish-button']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'sparkles','text' => 'Publicar cambios','html-type' => 'button','@click' => 'openPublishModal()','data-tour' => 'publish-button']); ?>
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
        
        
        <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'diseño_tienda','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'diseño_tienda','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

        
        <div class="grid gap-4 xl:grid-cols-12">
            
            <div class="xl:col-span-8">
                <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Información del encabezado','shadow' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Información del encabezado','shadow' => 'sm']); ?>
                    <div class="grid gap-6 pt-4 xl:grid-cols-3">
                        <div class="space-y-4 xl:col-span-2">
                            <?php if (isset($component)) { $__componentOriginalc088a413751f2bc7a99da19699d0dd5c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc088a413751f2bc7a99da19699d0dd5c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithLabel','data' => ['dataTour' => 'name-store','label' => 'Nombre de la tienda','name' => 'store_name','placeholder' => 'Nombre de tu tienda','value' => $store->name,'maxlength' => '40','containerClass' => 'w-full','xModel' => 'form.storeName','@input' => 'handleNameInput($event)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-tour' => 'name-store','label' => 'Nombre de la tienda','name' => 'store_name','placeholder' => 'Nombre de tu tienda','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store->name),'maxlength' => '40','container-class' => 'w-full','x-model' => 'form.storeName','@input' => 'handleNameInput($event)']); ?>
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

                            <?php if (isset($component)) { $__componentOriginal65bef31e5ffdae365eb3eeac0b74b718 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Textareas.TextareaWithLabel','data' => ['dataTour' => 'description-store','label' => 'Descripción breve','textareaName' => 'store_description','placeholder' => 'Describe brevemente qué ofrece tu tienda','rows' => '4','containerClass' => 'w-full','xModel' => 'form.storeDescription','@input' => 'handleDescriptionInput($event)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('textarea-with-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-tour' => 'description-store','label' => 'Descripción breve','textarea-name' => 'store_description','placeholder' => 'Describe brevemente qué ofrece tu tienda','rows' => '4','container-class' => 'w-full','x-model' => 'form.storeDescription','@input' => 'handleDescriptionInput($event)']); ?><?php echo e($store->description); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718)): ?>
<?php $attributes = $__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718; ?>
<?php unset($__attributesOriginal65bef31e5ffdae365eb3eeac0b74b718); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bef31e5ffdae365eb3eeac0b74b718)): ?>
<?php $component = $__componentOriginal65bef31e5ffdae365eb3eeac0b74b718; ?>
<?php unset($__componentOriginal65bef31e5ffdae365eb3eeac0b74b718); ?>
<?php endif; ?>

                            <p class="text-xs text-gray-500">El nombre admite letras, números, guiones y acentos (máx. 40). La descripción admite hasta 50 caracteres.</p>
                        </div>

                        <div class="space-y-4 xl:col-span-1">
                            <div data-tour="background-color">
                                <?php if (isset($component)) { $__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::ColorPickers.ColorPickerBasic','data' => ['name' => 'header_background_color','label' => 'Color de fondo','value' => $design->header_background_color,'helper' => 'Formato #RRGGBB','xModel' => 'colors.bgColor']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('color-picker-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'header_background_color','label' => 'Color de fondo','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($design->header_background_color),'helper' => 'Formato #RRGGBB','x-model' => 'colors.bgColor']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77)): ?>
<?php $attributes = $__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77; ?>
<?php unset($__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77)): ?>
<?php $component = $__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77; ?>
<?php unset($__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77); ?>
<?php endif; ?>
                            </div>
                            <div data-tour="text-color">
                                <?php if (isset($component)) { $__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::ColorPickers.ColorPickerBasic','data' => ['name' => 'header_text_color','label' => 'Color del nombre','value' => $design->header_text_color,'helper' => 'Formato #RRGGBB','xModel' => 'colors.textColor']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('color-picker-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'header_text_color','label' => 'Color del nombre','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($design->header_text_color),'helper' => 'Formato #RRGGBB','x-model' => 'colors.textColor']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77)): ?>
<?php $attributes = $__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77; ?>
<?php unset($__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77)): ?>
<?php $component = $__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77; ?>
<?php unset($__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77); ?>
<?php endif; ?>
                            </div>
                            <div data-tour="description-color">
                                <?php if (isset($component)) { $__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::ColorPickers.ColorPickerBasic','data' => ['name' => 'header_description_color','label' => 'Color de la descripción','value' => $design->header_description_color,'helper' => 'Formato #RRGGBB','xModel' => 'colors.descriptionColor']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('color-picker-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'header_description_color','label' => 'Color de la descripción','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($design->header_description_color),'helper' => 'Formato #RRGGBB','x-model' => 'colors.descriptionColor']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77)): ?>
<?php $attributes = $__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77; ?>
<?php unset($__attributesOriginala1cdfc4a83bb8ab703e1c6ce6899cd77); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77)): ?>
<?php $component = $__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77; ?>
<?php unset($__componentOriginala1cdfc4a83bb8ab703e1c6ce6899cd77); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
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

            
            <div class="xl:col-span-4" >
                <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Vista previa','shadow' => 'sm','dataTour' => 'preview-header']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Vista previa','shadow' => 'sm','data-tour' => 'preview-header']); ?>
                    <div class="mt-4 overflow-hidden">
                        <?php if (isset($component)) { $__componentOriginal601f4ce8cd7d7d4ef0daf540c5204f5f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal601f4ce8cd7d7d4ef0daf540c5204f5f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'tenant-admin::components.Core.header-preview','data' => ['store' => $store,'design' => $design]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tenant-admin::Core.header-preview'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['store' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store),'design' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($design)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal601f4ce8cd7d7d4ef0daf540c5204f5f)): ?>
<?php $attributes = $__attributesOriginal601f4ce8cd7d7d4ef0daf540c5204f5f; ?>
<?php unset($__attributesOriginal601f4ce8cd7d7d4ef0daf540c5204f5f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal601f4ce8cd7d7d4ef0daf540c5204f5f)): ?>
<?php $component = $__componentOriginal601f4ce8cd7d7d4ef0daf540c5204f5f; ?>
<?php unset($__componentOriginal601f4ce8cd7d7d4ef0daf540c5204f5f); ?>
<?php endif; ?>
                    </div>
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
        </div>

        <div class="grid gap-4 xl:grid-cols-2">
            
            <div>
                <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Logo','shadow' => 'sm','dataTour' => 'logo-upload']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Logo','shadow' => 'sm','data-tour' => 'logo-upload']); ?>
                    <div class="space-y-4 pt-4" data-tour="logo-upload">
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

                        <?php if (isset($component)) { $__componentOriginal63bf74f65a888b5cd67d5d43a6382afd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal63bf74f65a888b5cd67d5d43a6382afd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::FileUploads.FileUploadWithValidation','data' => ['name' => 'store_logo','accept' => 'image/png,image/jpeg,image/webp','maxFileSize' => '2','helpText' => 'PNG, JPG o WebP. Máx. 2MB']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('file-upload-with-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'store_logo','accept' => 'image/png,image/jpeg,image/webp','max-file-size' => '2','help-text' => 'PNG, JPG o WebP. Máx. 2MB']); ?>
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

                        <div class="rounded-lg bg-blue-50 border border-blue-200 p-3">
                            <div class="flex items-start gap-2">
                                <i data-lucide="info" class="size-4 text-blue-600 mt-0.5 shrink-0"></i>
                                <p class="text-xs text-blue-800">
                                    <strong>Nota:</strong> Las imágenes se guardan automáticamente al subirlas.
                                </p>
                            </div>
                        </div>
                    </div>
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

            
            <div>
                <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['title' => 'Favicon','shadow' => 'sm','dataTour' => 'favicon-upload']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Favicon','shadow' => 'sm','data-tour' => 'favicon-upload']); ?>
                    <div class="space-y-4 pt-4" data-tour="favicon-upload">
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

                        <?php if (isset($component)) { $__componentOriginal63bf74f65a888b5cd67d5d43a6382afd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal63bf74f65a888b5cd67d5d43a6382afd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::FileUploads.FileUploadWithValidation','data' => ['name' => 'store_favicon','accept' => 'image/png,image/x-icon,image/vnd.microsoft.icon,image/svg+xml','maxFileSize' => '1','helpText' => 'PNG o ICO. Máx. 1MB']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('file-upload-with-validation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'store_favicon','accept' => 'image/png,image/x-icon,image/vnd.microsoft.icon,image/svg+xml','max-file-size' => '1','help-text' => 'PNG o ICO. Máx. 1MB']); ?>
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

                        <div class="rounded-lg bg-blue-50 border border-blue-200 p-3">
                            <div class="flex items-start gap-2">
                                <i data-lucide="info" class="size-4 text-blue-600 mt-0.5 shrink-0"></i>
                                <p class="text-xs text-blue-800">
                                    <strong>Nota:</strong> Las imágenes se guardan automáticamente al subirlas.
                                </p>
                            </div>
                        </div>
                    </div>
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
        </div>

        
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
                    <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'secondary','text' => 'Cancelar','htmlType' => 'button','xBind:disabled' => 'loading.publish','@click' => 'closePublishModal()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'secondary','text' => 'Cancelar','html-type' => 'button','x-bind:disabled' => 'loading.publish','@click' => 'closePublishModal()']); ?>
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
                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'success','icon' => 'send','text' => 'Publicar ahora','htmlType' => 'button','@click' => 'confirmPublish()','xBind:disabled' => 'loading.publish']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'success','icon' => 'send','text' => 'Publicar ahora','html-type' => 'button','@click' => 'confirmPublish()','x-bind:disabled' => 'loading.publish']); ?>
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

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('alpine:init', () => {
            const storeSlug = <?php echo \Illuminate\Support\Js::from($store->slug)->toHtml() ?>;
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

            const initialFromServer = <?php echo json_encode($initialDesign, 15, 512) ?>;
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
                storeName: initialDesign?.storeName ?? <?php echo json_encode($store->name, 15, 512) ?>,
                storeDescription: initialDesign?.storeDescription ?? <?php echo json_encode($store->description, 15, 512) ?>,
            });
        });

        function storeDesignPage() {
            return {
                storeSlug: <?php echo \Illuminate\Support\Js::from($store->slug)->toHtml() ?>,
                designCacheKey: window.__designCacheKey || null,
                colors: {
                    bgColor: window.__initialDesign?.bgColor ?? <?php echo json_encode($design->header_background_color ?? '#FFFFFF', 15, 512) ?>,
                    textColor: window.__initialDesign?.textColor ?? <?php echo json_encode($design->header_text_color ?? '#000000', 15, 512) ?>,
                    descriptionColor: window.__initialDesign?.descriptionColor ?? <?php echo json_encode($design->header_description_color ?? '#666666', 15, 512) ?>,
                },
                form: {
                    storeName: window.__initialDesign?.storeName ?? <?php echo json_encode($store->name, 15, 512) ?>,
                    storeDescription: window.__initialDesign?.storeDescription ?? <?php echo json_encode($store->description, 15, 512) ?>,
                },
                publishModalOpen: false,
                hasUnsavedChanges: false,
                loading: {
                    publish: false,
                    update: false,
                },
                toastCounter: 0,
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
                    
                    // Usar funciones con nombre para poder removerlos si es necesario
                    this.fileSelectedHandler = (event) => this.onFileSelected(event);
                    this.fileRemovedHandler = (event) => this.onFileRemoved(event);
                    
                    document.addEventListener('file-upload:selected', this.fileSelectedHandler);
                    document.addEventListener('file-upload:removed', this.fileRemovedHandler);
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
                        this.hasUnsavedChanges = true;
                        this.pushPreviewState();
                    });

                    this.$watch('form.storeDescription', (value) => {
                        this.form.storeDescription = this.sanitizeDescription(value).slice(0, 50);
                        this.hasUnsavedChanges = true;
                        this.pushPreviewState();
                    });

                    this.$watch('colors.bgColor', (value) => {
                        this.colors.bgColor = this.normalizeColor(value);
                        this.hasUnsavedChanges = true;
                        this.pushPreviewState();
                    });

                    this.$watch('colors.textColor', (value) => {
                        this.colors.textColor = this.normalizeColor(value);
                        this.hasUnsavedChanges = true;
                        this.pushPreviewState();
                    });

                    this.$watch('colors.descriptionColor', (value) => {
                        this.colors.descriptionColor = this.normalizeColor(value);
                        this.hasUnsavedChanges = true;
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
                    // Evitar llamadas duplicadas
                    if (this.loading.update) {
                        return;
                    }
                    
                    this.loading.update = true;
                    
                    // Para imágenes, NO incluir colores (solo guardar la imagen)
                    const isImageUpdate = extraPayload.logo_base64 || extraPayload.favicon_base64 || extraPayload.logo_url === '' || extraPayload.favicon_url === '';
                    const formData = this.buildFormData(extraPayload, !isImageUpdate);
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
                            if (isImageUpdate) {
                                // Para imágenes, mostrar mensaje específico
                                const assetName = meta.asset === 'logo' ? 'Logo' : 'Favicon';
                                if (window.toast) {
                                    this.toastCounter++;
                                    window.toast.success(
                                        'Imagen guardada',
                                        `${assetName} guardado correctamente.`,
                                        5000,
                                        'bottom-center'
                                    );
                                }
                            } else {
                                if (window.toast) {
                                    this.toastCounter++;
                                    window.toast.success(
                                        'Diseño actualizado',
                                        'Diseño actualizado correctamente.',
                                        5000,
                                        'bottom-center'
                                    );
                                }
                            }
                        }
                    } catch (error) {
                        if (window.toast) {
                            this.toastCounter++;
                            window.toast.error(
                                'Error',
                                error.message || 'Error al actualizar el diseño.',
                                5000,
                                'bottom-center'
                            );
                        }
                    } finally {
                        this.loading.update = false;
                    }
                },
                buildFormData(extraPayload = {}, includeColors = true) {
                    const formData = new FormData();
                    // Solo incluir colores si se especifica (para imágenes no se incluyen)
                    if (includeColors) {
                        formData.append('header_background_color', this.colors.bgColor);
                        formData.append('header_text_color', this.colors.textColor);
                        formData.append('header_description_color', this.colors.descriptionColor);
                    }
                    Object.entries(extraPayload).forEach(([key, value]) => {
                        formData.append(key, value ?? '');
                    });
                    return formData;
                },
                async confirmPublish() {
                    this.loading.publish = true;
                    // Al publicar, SÍ incluir colores y texto
                    const formData = this.buildFormData({
                        store_name: this.form.storeName,
                        store_description: this.form.storeDescription,
                    }, true);

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
                        this.hasUnsavedChanges = false;
                        if (window.toast) {
                            this.toastCounter++;
                            window.toast.success(
                                'Diseño publicado',
                                data?.message || 'Diseño publicado correctamente.',
                                5000,
                                'bottom-center'
                            );
                        }
                        this.publishModalOpen = false;
                        this.persistDesignCache();
                    } catch (error) {
                        if (window.toast) {
                            this.toastCounter++;
                            window.toast.error(
                                'Error',
                                error.message || 'Error al publicar el diseño.',
                                5000,
                                'bottom-center'
                            );
                        }
                    } finally {
                        this.loading.publish = false;
                    }
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
<?php endif; ?> <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/store-design/index.blade.php ENDPATH**/ ?>