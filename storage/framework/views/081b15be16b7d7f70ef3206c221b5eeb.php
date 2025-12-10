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
    <?php $__env->startSection('title', 'Perfil del Negocio'); ?>
    <?php $__env->startSection('subtitle', 'Información básica, SEO y políticas de tu tienda'); ?>

    <?php $__env->startSection('content'); ?>
    <div x-data="businessProfileManager" x-init="init()" class="space-y-4 lg:space-y-6">
        
        <!-- Header con navegación de tabs -->
        <div class="bg-accent-50 rounded-lg overflow-hidden">
            <div class="border-b border-accent-100 bg-accent-50 py-3 lg:py-4 px-4 lg:px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-black-500 mb-2">📋 Perfil del Negocio</h2>
                        <p class="text-sm text-black-300">
                            Información básica, SEO y políticas legales de tu tienda
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Navegación de tabs -->
            <div class="px-4 lg:px-6 py-3 bg-accent-50">
                <nav class="flex flex-wrap gap-2 lg:gap-4">
                    <button @click="activeTab = 'info'" 
                            :class="activeTab === 'info' ? 'bg-primary-200 text-white' : 'bg-white text-black-400 hover:bg-primary-50'"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-info-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        <span class="hidden sm:inline">Información Básica</span>
                        <span class="sm:hidden">Info</span>
                    </button>
                    <button @click="activeTab = 'seo'" 
                            :class="activeTab === 'seo' ? 'bg-primary-200 text-white' : 'bg-white text-black-400 hover:bg-primary-50'"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-chart-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        <span class="hidden sm:inline">SEO y Marketing</span>
                        <span class="sm:hidden">SEO</span>
                    </button>
                    <button @click="activeTab = 'policies'" 
                            :class="activeTab === 'policies' ? 'bg-primary-200 text-white' : 'bg-white text-black-400 hover:bg-primary-50'"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-shield-check-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        <span class="hidden sm:inline">Políticas Legales</span>
                        <span class="sm:hidden">Políticas</span>
                    </button>
                    <button @click="activeTab = 'about'" 
                            :class="activeTab === 'about' ? 'bg-primary-200 text-white' : 'bg-white text-black-400 hover:bg-primary-50'"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-info-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                        <span class="hidden sm:inline">Acerca de Nosotros</span>
                        <span class="sm:hidden">Acerca de</span>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Contenido de las pestañas -->
        <div class="bg-white rounded-lg border border-accent-200 overflow-hidden">
            
            <!-- TAB 1: INFORMACIÓN BÁSICA (Solo lectura) -->
            <div x-show="activeTab === 'info'" x-transition class="p-4 lg:p-6">
                <div class="space-y-6">
                    
                    <!-- Propietario -->
                    <div class="bg-gradient-to-r from-primary-50 to-info-50 rounded-lg p-4 lg:p-6">
                        <h3 class="text-lg font-semibold text-black-500 mb-4 flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-user-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            Información del Propietario
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">Nombre</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e(auth()->user()->name ?? 'No registrado'); ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">Email</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e(auth()->user()->email ?? 'No registrado'); ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">Documento</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e($store->document_type ?? 'No registrado'); ?> <?php echo e($store->document_number ?? ''); ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">Teléfono</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e($store->phone ?? 'No registrado'); ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">País</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e($store->country ?? 'No registrado'); ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">Ciudad</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e($store->city ?? 'No registrado'); ?>, <?php echo e($store->department ?? ''); ?></p>
                            </div>
                        </div>
                        <?php if($store->address): ?>
                        <div class="mt-4">
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">Dirección</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e($store->address); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Información Fiscal -->
                    <div class="bg-gradient-to-r from-secondary-50 to-warning-50 rounded-lg p-4 lg:p-6">
                        <h3 class="text-lg font-semibold text-black-500 mb-4 flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-document-text-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            Información Fiscal
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">Razón Social</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e($store->header_text_title ?? $store->name ?? 'No registrado'); ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">NIT/RUT</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e($store->document_number ?? 'No registrado'); ?></p>
                            </div>
                        </div>
                        
                        <div class="mt-4 bg-info-50 border border-info-200 rounded-lg p-3">
                            <p class="text-sm text-info-400 flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-info-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Esta información fue configurada desde el SuperAdmin y no puede editarse desde aquí.
                            </p>
                        </div>
                    </div>

                    <!-- Información de la Tienda -->
                    <div class="bg-gradient-to-r from-success-50 to-primary-50 rounded-lg p-4 lg:p-6">
                        <h3 class="text-lg font-semibold text-black-500 mb-4 flex items-center gap-2">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-shop-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            Información de la Tienda
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">Nombre de la Tienda</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e($store->name ?? 'No registrado'); ?></p>
                            </div>
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">URL de la Tienda</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e(url('')); ?>/<?php echo e($store->slug); ?></p>
                            </div>
                        </div>
                        <?php if($store->description): ?>
                        <div class="mt-4">
                            <div class="bg-white rounded-lg p-3">
                                <label class="text-xs text-black-300 uppercase tracking-wide">Descripción</label>
                                <p class="text-sm font-medium text-black-500"><?php echo e($store->description); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mt-4 bg-warning-50 border border-warning-200 rounded-lg p-3">
                            <p class="text-sm text-warning-400 flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-settings-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                El nombre, descripción y logo se editan desde "Diseño de Tienda".
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: SEO Y MARKETING -->
            <div x-show="activeTab === 'seo'" x-transition class="p-4 lg:p-6">
                <form action="<?php echo e(route('tenant.admin.business-profile.update-seo', ['store' => $store->slug])); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-6">
                        
                        <div class="bg-gradient-to-r from-info-50 to-primary-50 rounded-lg p-4 lg:p-6">
                            <h3 class="text-lg font-semibold text-black-500 mb-4 flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-chart-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Optimización SEO
                            </h3>
                            
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-black-400 mb-2">Título SEO (Meta Title)</label>
                                    <input type="text" name="meta_title" value="<?php echo e(old('meta_title', $store->meta_title)); ?>" 
                                           placeholder="Ej: Tienda <?php echo e($store->name); ?> - Los mejores productos online"
                                           class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-transparent">
                                    <p class="text-xs text-black-300 mt-1">Máximo 60 caracteres. Aparece en los resultados de Google.</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-black-400 mb-2">Descripción SEO (Meta Description)</label>
                                    <textarea name="meta_description" rows="3" 
                                              placeholder="Describe tu tienda para aparecer en Google..."
                                              class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-transparent resize-none"><?php echo e(old('meta_description', $store->meta_description)); ?></textarea>
                                    <p class="text-xs text-black-300 mt-1">Máximo 160 caracteres. Aparece bajo el título en Google.</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-black-400 mb-2">Palabras Clave (Keywords)</label>
                                    <input type="text" name="meta_keywords" value="<?php echo e(old('meta_keywords', $store->meta_keywords)); ?>" 
                                           placeholder="tienda online, productos, <?php echo e(strtolower($store->name)); ?>"
                                           class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-transparent">
                                    <p class="text-xs text-black-300 mt-1">Separadas por comas. Ayudan a Google a entender tu contenido.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-secondary-50 to-success-50 rounded-lg p-4 lg:p-6">
                            <h3 class="text-lg font-semibold text-black-500 mb-4 flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-share-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Redes Sociales
                            </h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-black-400 mb-2">Imagen para Redes Sociales (Open Graph)</label>
                                <input type="file" name="og_image" accept="image/*"
                                       class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-200 focus:border-transparent">
                                <p class="text-xs text-black-300 mt-1">Tamaño recomendado: 1200x630px. Se mostrará cuando compartan tu tienda.</p>
                                
                                <?php if($store->header_short_description && str_contains($store->header_short_description, 'og-images')): ?>
                                <div class="mt-3 p-3 bg-white rounded-lg border border-accent-200">
                                    <p class="text-sm text-black-400 mb-2">Imagen actual:</p>
                                    <img src="<?php echo e(asset('storage/' . $store->header_short_description)); ?>" 
                                         alt="Open Graph" class="h-20 object-cover rounded">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-warning-50 to-error-50 rounded-lg p-4 lg:p-6">
                            <h3 class="text-lg font-semibold text-black-500 mb-4 flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-graph-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Analytics y Seguimiento
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-black-400 mb-2">Google Analytics ID</label>
                                    <input type="text" name="google_analytics" value="<?php echo e(old('google_analytics')); ?>" 
                                           placeholder="GA-XXXXXXXXX-X"
                                           class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-warning-200 focus:border-transparent">
                                    <p class="text-xs text-black-300 mt-1">Para rastrear visitantes y ventas.</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-black-400 mb-2">Facebook Pixel ID</label>
                                    <input type="text" name="facebook_pixel" value="<?php echo e(old('facebook_pixel')); ?>" 
                                           placeholder="123456789012345"
                                           class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-warning-200 focus:border-transparent">
                                    <p class="text-xs text-black-300 mt-1">Para crear audiencias en Facebook Ads.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary-200 text-white px-6 py-2 rounded-lg hover:bg-primary-300 transition-colors flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-diskette-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Guardar SEO
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TAB 3: POLÍTICAS LEGALES -->
            <div x-show="activeTab === 'policies'" x-transition class="p-4 lg:p-6">
                <form action="<?php echo e(route('tenant.admin.business-profile.update-policies', ['store' => $store->slug])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-6">
                        
                        <div class="bg-gradient-to-r from-success-50 to-info-50 rounded-lg p-4 lg:p-6">
                            <h3 class="text-lg font-semibold text-black-500 mb-4 flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-shield-check-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Políticas Legales
                            </h3>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-black-400 mb-2">Política de Privacidad</label>
                                    <textarea name="privacy_policy" rows="6" 
                                              placeholder="Describe cómo manejas los datos de tus clientes..."
                                              class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-success-200 focus:border-transparent resize-none"><?php echo e(old('privacy_policy', $policies->privacy_policy)); ?></textarea>
                                </div>
                                
                                
                                <div>
                                    <label class="block text-sm font-medium text-black-400 mb-2">Términos y Condiciones</label>
                                    <textarea name="terms_conditions" rows="6" 
                                              placeholder="Establece las reglas de uso de tu tienda..."
                                              class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-success-200 focus:border-transparent resize-none"><?php echo e(old('terms_conditions', $policies->terms_conditions)); ?></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-black-400 mb-2">Política de Envíos</label>
                                    <textarea name="shipping_policy" rows="6" 
                                              placeholder="Explica cómo funcionan tus envíos y tiempos de entrega..."
                                              class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-success-200 focus:border-transparent resize-none"><?php echo e(old('shipping_policy', $policies->shipping_policy)); ?></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-black-400 mb-2">Política de Devoluciones</label>
                                    <textarea name="return_policy" rows="6" 
                                              placeholder="Define las condiciones para devoluciones y cambios..."
                                              class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-success-200 focus:border-transparent resize-none"><?php echo e(old('return_policy', $policies->return_policy)); ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary-200 text-white px-6 py-2 rounded-lg hover:bg-primary-300 transition-colors flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-shield-check-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Guardar Políticas
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TAB 4: ACERCA DE NOSOTROS -->
            <div x-show="activeTab === 'about'" x-transition class="p-4 lg:p-6">
                <form action="<?php echo e(route('tenant.admin.business-profile.update-about', ['store' => $store->slug])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-6">
                        
                        <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-lg p-4 lg:p-6">
                            <h3 class="text-lg font-semibold text-black-500 mb-4 flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-info-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Acerca de Nosotros
                            </h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-black-400 mb-2">Nuestra Historia</label>
                                <textarea name="about_us" rows="10" 
                                          placeholder="Cuenta la historia de tu empresa, misión, visión, valores y qué te hace especial..."
                                          class="w-full px-3 py-2 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-transparent resize-none"><?php echo e(old('about_us', $policies->about_us)); ?></textarea>
                                <p class="text-xs text-black-300 mt-1">Esta información aparecerá en la página "Acerca de nosotros" de tu tienda.</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-primary-200 text-white px-6 py-2 rounded-lg hover:bg-primary-300 transition-colors flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-info-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Guardar Información
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TAB WHATSAPP MOVIDO A: Reservas y Servicios → Notificaciones WhatsApp -->
            <!-- (Ya no está aquí, ahora es un item independiente del menú) -->
            <div x-show="false" style="display:none;">
                <form action="<?php echo e(route('tenant.admin.business-profile.update-whatsapp', ['store' => $store->slug])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-6">
                        <div class="flex items-start gap-3 bg-info-50 border border-info-200 rounded-lg p-4">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-info-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-info-400 flex-shrink-0 mt-0.5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            <div class="text-sm text-info-400">
                                <p class="font-medium mb-1">📱 Configuración de Notificaciones WhatsApp</p>
                                <p class="text-info-300">Configura tu número de WhatsApp para recibir notificaciones automáticas sobre pedidos y pagos. Los clientes también recibirán confirmaciones y actualizaciones.</p>
                            </div>
                        </div>

                        <div class="bg-accent-50 rounded-lg p-6 space-y-6">
                            <h3 class="text-lg font-semibold text-black-500 flex items-center gap-2">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-chat-round-call-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Número de WhatsApp del Propietario
                            </h3>
                            
                            <div>
                                <label for="owner_phone" class="block text-sm font-medium text-black-400 mb-2">
                                    Número de WhatsApp <span class="text-error-400">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-black-300 font-medium">+57</span>
                                    <input type="text" 
                                           id="owner_phone" 
                                           name="owner_phone" 
                                           value="<?php echo e(old('owner_phone', $store->owner_phone)); ?>"
                                           placeholder="3001234567"
                                           maxlength="10"
                                           pattern="[0-9]{10}"
                                           class="w-full pl-12 pr-3 py-3 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-transparent <?php $__errorArgs = ['owner_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           required>
                                </div>
                                <p class="text-xs text-black-300 mt-1">
                                    Ingresa tu número de celular (10 dígitos) sin espacios ni guiones. Ejemplo: 3001234567
                                </p>
                                <?php $__errorArgs = ['owner_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-sm text-error-400 mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Notificaciones que recibirás -->
                            <div class="bg-white rounded-lg p-4 border border-accent-200">
                                <h4 class="text-sm font-semibold text-black-500 mb-3">📬 Notificaciones que recibirás:</h4>
                                <ul class="space-y-2 text-sm text-black-400">
                                    <li class="flex items-start gap-2">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-check-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-success-400 flex-shrink-0 mt-0.5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        <span><strong>Nuevo pedido:</strong> Cuando un cliente realiza un pedido</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-check-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-success-400 flex-shrink-0 mt-0.5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        <span><strong>Comprobante recibido:</strong> Cuando un cliente sube un comprobante de pago</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Notificaciones que reciben los clientes -->
                            <div class="bg-white rounded-lg p-4 border border-accent-200">
                                <h4 class="text-sm font-semibold text-black-500 mb-3">👥 Notificaciones automáticas a clientes:</h4>
                                <ul class="space-y-2 text-sm text-black-400">
                                    <li class="flex items-start gap-2">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-check-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-info-400 flex-shrink-0 mt-0.5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        <span><strong>Confirmación de pedido:</strong> Al crear el pedido</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-check-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 text-info-400 flex-shrink-0 mt-0.5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                        <span><strong>Cambios de estado:</strong> Cuando el pedido cambia de estado (procesando, enviado, entregado)</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-success-300 text-white px-6 py-3 rounded-lg hover:bg-success-400 transition-colors flex items-center gap-2 font-medium">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-chat-round-call-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                Guardar Configuración WhatsApp
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notificaciones -->
        <?php if(session('success')): ?>
        <div x-data="{ show: true }" x-show="show" x-transition 
             class="fixed bottom-4 right-4 bg-success-100 border border-success-200 text-success-400 px-4 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center gap-2">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-check-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                <span><?php echo e(session('success')); ?></span>
                <button @click="show = false" class="ml-2 text-success-300 hover:text-success-400">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-close-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                </button>
            </div>
        </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
        <div x-data="{ show: true }" x-show="show" x-transition 
             class="fixed bottom-4 right-4 bg-error-100 border border-error-200 text-error-400 px-4 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center gap-2">
                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-close-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                <span>Hay errores en el formulario. Revisa los campos.</span>
                <button @click="show = false" class="ml-2 text-error-300 hover:text-error-400">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-close-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('businessProfileManager', () => ({
            activeTab: 'info',
            
            init() {
                // Recuperar tab activo del localStorage
                const savedTab = localStorage.getItem('businessProfile_activeTab');
                if (savedTab) {
                    this.activeTab = savedTab;
                }
                
                // Guardar tab activo cuando cambie
                this.$watch('activeTab', (tab) => {
                    localStorage.setItem('businessProfile_activeTab', tab);
                });
                
                console.log('💼 Business Profile Manager initialized');
            }
        }));
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
<?php endif; ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/business-profile/index.blade.php ENDPATH**/ ?>