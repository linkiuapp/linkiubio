<?php $__env->startSection('title', 'Editar Tienda'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid" x-data="editStore()">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-lg font-bold text-black-400">Editar Tienda</h1>
        <a href="<?php echo e(route('superlinkiu.stores.index')); ?>" class="btn-outline-secondary px-4 py-2 rounded-lg flex items-center gap-2">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-arrow-left-outline'); ?>
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
            Volver
        </a>
    </div>

    <form action="<?php echo e(route('superlinkiu.stores.update', $store)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <!-- Campos ocultos para JavaScript -->
        <input type="hidden" id="original_plan_id" value="<?php echo e($store->plan_id); ?>">
        <input type="hidden" id="original_plan_allows_custom" value="<?php echo e($store->plan->allow_custom_slug ? 'true' : 'false'); ?>">
        <input type="hidden" id="original_slug" value="<?php echo e($store->slug); ?>">
        <input type="hidden" id="store_name" value="<?php echo e($store->name); ?>">
        <!-- Detectar si el slug actual es aleatorio o personalizado -->
        <input type="hidden" id="slug_is_random" value="<?php echo e(preg_match('/^tienda-[a-z0-9]{6}$/', $store->slug) ? 'true' : 'false'); ?>">
        
        <!-- Card única con toda la información -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-lg font-semibold text-black-400 mb-0">Información de la Tienda</h2>
            </div>
            
            <div class="p-6">
                <!-- Sección: Información Básica -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-black-400 mb-4 flex items-center gap-2">
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
                        Información Básica
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Nombre de la Tienda <span class="text-error-300">*</span>
                            </label>
                            <input type="text"
                                name="name"
                                value="<?php echo e(old('name', $store->name)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div 
    x-data="{ selectedPlan: <?php echo \Illuminate\Support\Js::from((string) old('plan_id', (string) ($store->plan_id ?? '')))->toHtml() ?> }"
>
    <label class="block text-sm font-medium text-black-300 mb-2">
        Plan <span class="text-error-300">*</span>
    </label>

    <select name="plan_id"
        x-model="selectedPlan"
        @change="checkPlanChange"
        class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['plan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
        required
        id="plan_id"
    >
        <option value="">Seleccionar Plan</option>
        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option 
                value="<?php echo e((string) $plan->id); ?>"
                data-slug="<?php echo e(strtolower($plan->slug ?? $plan->name)); ?>"
                data-allow-custom="<?php echo e($plan->allow_custom_slug ? 'true' : 'false'); ?>"
                <?php echo e(old('plan_id', (string) $store->plan_id) == (string) $plan->id ? 'selected' : ''); ?>

            >
                <?php echo e($plan->name); ?> - <?php echo e($plan->getPriceFormatted()); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    <?php $__errorArgs = ['plan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


<div x-data="slugManager()" x-init="initSlug()">
    <label class="block text-sm font-medium text-black-300 mb-2">
        URL de la Tienda (Slug)
    </label>
    <div class="flex items-stretch">
        <span class="inline-flex items-center px-3 text-sm text-black-300 bg-accent-100 border border-r-0 border-accent-200 rounded-l-lg">
            linkiu.bio/
        </span>
        <input type="text"
            name="slug"
            x-model="currentSlug"
            :readonly="!canEditSlug"
            @input="onSlugInput($event)"
            :class="{'bg-accent-100 cursor-not-allowed': !canEditSlug, 'bg-accent-50': canEditSlug}"
            class="flex-1 px-4 py-2 border border-accent-200 rounded-r-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    </div>
    
    <!-- Mensaje para planes que NO permiten personalización -->
    <p class="text-xs text-warning-300 mt-1 flex items-center gap-1" x-show="!canEditSlug && !isUpgrading">
        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-lock-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
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
        Este plan no permite personalizar la URL. Actualiza a un plan superior para editarla.
    </p>
    
    <!-- Mensaje para planes que SÍ permiten personalización -->
    <p class="text-xs text-success-300 mt-1 flex items-center gap-1" x-show="canEditSlug && !isUpgrading">
        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-check-circle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
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
        Puedes personalizar tu URL con este plan.
    </p>
    
    <!-- Mensaje para upgrade -->
    <p class="text-xs text-primary-300 mt-1 flex items-center gap-1" x-show="isUpgrading">
        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-star-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
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
        ¡Felicidades! Ahora puedes personalizar tu URL.
    </p>
    
    <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>


                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Email <span class="text-error-300">*</span>
                            </label>
                            <input type="email"
                                name="email"
                                value="<?php echo e(old('email', $store->email)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Teléfono
                            </label>
                            <input type="text"
                                name="phone"
                                value="<?php echo e(old('phone', $store->phone)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="+57 300 123 4567">
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Categoría de Negocio
                            </label>
                            <select name="business_category_id"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['business_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Sin categoría</option>
                                <?php $__currentLoopData = \App\Shared\Models\BusinessCategory::active()->ordered()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('business_category_id', $store->business_category_id) == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['business_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Estado
                            </label>
                            <select name="status"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none">
                                <option value="active" <?php echo e(old('status', $store->status) == 'active' ? 'selected' : ''); ?>>Activa</option>
                                <option value="inactive" <?php echo e(old('status', $store->status) == 'inactive' ? 'selected' : ''); ?>>Inactiva</option>
                                <option value="suspended" <?php echo e(old('status', $store->status) == 'suspended' ? 'selected' : ''); ?>>Suspendida</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Descripción
                            </label>
                            <textarea
                                name="description"
                                rows="3"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Breve descripción de la tienda..."><?php echo e(old('description', $store->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Verificación
                            </label>
                            <div class="flex items-center gap-3">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                        name="verified"
                                        value="1"
                                        class="sr-only peer" 
                                        <?php echo e(old('verified', $store->verified) ? 'checked' : ''); ?>>
                                    <div class="w-11 h-6 bg-accent-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-accent-50 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-accent-50 after:border-accent-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-200"></div>
                                </label>
                                <span class="text-sm text-black-300">Tienda verificada</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Documento y Ubicación -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-black-400 mb-4 flex items-center gap-2">
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
                        Documento y Ubicación
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Tipo de Documento
                            </label>
                            <select name="document_type"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Seleccionar tipo</option>
                                <option value="nit" <?php echo e(old('document_type', $store->document_type) == 'nit' ? 'selected' : ''); ?>>NIT</option>
                                <option value="cedula" <?php echo e(old('document_type', $store->document_type) == 'cedula' ? 'selected' : ''); ?>>Cédula</option>
                            </select>
                            <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Número de Documento
                            </label>
                            <input type="text"
                                name="document_number"
                                value="<?php echo e(old('document_number', $store->document_number)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['document_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="123456789-0">
                            <?php $__errorArgs = ['document_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                País
                            </label>
                            <input type="text"
                                name="country"
                                value="<?php echo e(old('country', $store->country)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Departamento
                            </label>
                            <input type="text"
                                name="department"
                                value="<?php echo e(old('department', $store->department)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Antioquia">
                            <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Ciudad
                            </label>
                            <input type="text"
                                name="city"
                                value="<?php echo e(old('city', $store->city)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Medellín">
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Dirección
                            </label>
                            <input type="text"
                                name="address"
                                value="<?php echo e(old('address', $store->address)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Calle 123 #45-67">
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-xs text-error-300 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Sección: Administradores -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-black-400 mb-4 flex items-center gap-2">
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
                        Administradores de la Tienda
                    </h3>
                    
                    <?php if($store->admins && $store->admins->count() > 0): ?>
                        <div class="space-y-4 mb-6">
                            <?php $__currentLoopData = $store->admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-accent-100 rounded-lg p-4 border border-accent-200">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-primary-300 font-bold text-sm">
                                                <?php echo e($admin->getInitialsAttribute()); ?>

                                            </span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-black-400 text-sm"><?php echo e($admin->name); ?></h4>
                                            <p class="text-xs text-black-300"><?php echo e($admin->email); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="badge-soft-info text-xs"><?php echo e(ucfirst($admin->role)); ?></span>
                                        <?php if($admin->last_login_at && $admin->last_login_at->gt(now()->subDays(7))): ?>
                                            <span class="w-2 h-2 bg-success-300 rounded-full" title="Activo"></span>
                                        <?php elseif($admin->last_login_at): ?>
                                            <span class="w-2 h-2 bg-warning-300 rounded-full" title="Inactivo"></span>
                                        <?php else: ?>
                                            <span class="w-2 h-2 bg-error-300 rounded-full" title="Sin acceso"></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button" 
                                                @click="$dispatch('send-credentials', { adminId: <?php echo e($admin->id); ?>, adminEmail: '<?php echo e($admin->email); ?>' })"
                                                class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors">
                                            Reenviar accesos
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-warning-50 border border-warning-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center gap-3">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-danger-triangle-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-warning-600']); ?>
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
                                <div>
                                    <p class="font-medium text-warning-800">No hay administradores asignados</p>
                                    <p class="text-sm text-warning-700">Esta tienda no tiene usuarios administradores. Considera crear uno.</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 🔗 ENLACES RÁPIDOS -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-link-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 text-blue-600 mt-0.5']); ?>
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
                            <div class="flex-1">
                                <h4 class="font-medium text-blue-800 mb-2">Enlaces de la Tienda</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-blue-700">Tienda pública:</span>
                                        <a href="<?php echo e(url('/' . $store->slug)); ?>" 
                                           target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                                            <?php echo e($store->slug); ?>

                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-square-arrow-right-up-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
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
                                        </a>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-blue-700">Panel admin:</span>
                                        <a href="<?php echo e(route('tenant.admin.login', $store->slug)); ?>" 
                                           target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                                            <?php echo e($store->slug); ?>/admin
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-square-arrow-right-up-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3']); ?>
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
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: SEO -->
                <div>
                    <h3 class="text-lg font-semibold text-black-400 mb-4 flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-global-outline'); ?>
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
                        SEO y Metadatos
                    </h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Meta Título
                            </label>
                            <input type="text"
                                name="meta_title"
                                value="<?php echo e(old('meta_title', $store->meta_title)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                                placeholder="Mi Tienda Online - Los mejores productos">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Meta Descripción
                            </label>
                            <textarea
                                name="meta_description"
                                rows="2"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                                placeholder="Descripción para motores de búsqueda..."><?php echo e(old('meta_description', $store->meta_description)); ?></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-black-300 mb-2">
                                Meta Keywords
                            </label>
                            <input type="text"
                                name="meta_keywords"
                                value="<?php echo e(old('meta_keywords', $store->meta_keywords)); ?>"
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                                placeholder="tienda, online, productos, calidad">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer con botones -->
            <div class="border-t border-accent-100 bg-accent-50 px-6 py-4">
                <div class="flex justify-between">
                    <a href="<?php echo e(route('superlinkiu.stores.show', $store)); ?>"
                        class="btn-outline-primary px-4 py-2 rounded-lg flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-eye-outline'); ?>
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
                        Ver Detalles
                    </a>
                    <div class="flex gap-3">
                        <a href="<?php echo e(route('superlinkiu.stores.index')); ?>"
                            class="btn-outline-secondary px-6 py-2 rounded-lg">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="btn-primary px-6 py-2 rounded-lg flex items-center gap-2">
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
                            Actualizar Tienda
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>

<input type="hidden" name="_store_id" value="<?php echo e($store->id); ?>">

<script>
function editStore() {
    return {
        // Estado inicial
        originalPlanId: document.getElementById('original_plan_id').value,
        originalPlanAllowsCustom: document.getElementById('original_plan_allows_custom').value === 'true',
        originalSlug: document.getElementById('original_slug').value,
        storeName: document.getElementById('store_name').value,
        
        init() {
            console.log('🏪 EditStore initialized', {
                originalPlanId: this.originalPlanId,
                originalPlanAllowsCustom: this.originalPlanAllowsCustom,
                originalSlug: this.originalSlug
            });
        },
        
        checkPlanChange() {
            const planSelect = document.getElementById('plan_id');
            const selectedOption = planSelect.options[planSelect.selectedIndex];
            
            if (!selectedOption || !selectedOption.value) return;
            
            const newPlanAllowsCustom = selectedOption.dataset.allowCustom === 'true';
            
            console.log('🔄 Plan change detected', {
                newPlanId: selectedOption.value,
                newPlanAllowsCustom: newPlanAllowsCustom,
                originalPlanAllowsCustom: this.originalPlanAllowsCustom
            });
            
            // Disparar evento para que el componente de slug lo maneje
            window.dispatchEvent(new CustomEvent('plan-changed', {
                detail: {
                    newPlanId: selectedOption.value,
                    newPlanAllowsCustom: newPlanAllowsCustom,
                    planSlug: selectedOption.dataset.slug,
                    isUpgrade: !this.originalPlanAllowsCustom && newPlanAllowsCustom,
                    isDowngrade: this.originalPlanAllowsCustom && !newPlanAllowsCustom
                }
            }));
        }
    }
}

function slugManager() {
    return {
        currentSlug: <?php echo \Illuminate\Support\Js::from(old('slug', $store->slug ?? ''))->toHtml() ?>,
        originalSlug: <?php echo \Illuminate\Support\Js::from($store->slug)->toHtml() ?>, // El slug original de la tienda
        userCustomSlug: '', // Slug que el usuario ha personalizado
        canEditSlug: <?php echo \Illuminate\Support\Js::from($store->plan->allow_custom_slug ?? false)->toHtml() ?>,
        isUpgrading: false,
        isDowngrading: false,
        
        initSlug() {
            // Determinar si el slug actual es aleatorio o personalizado
            const slugIsRandom = document.getElementById('slug_is_random').value === 'true';
            const originalPlanAllowsCustom = document.getElementById('original_plan_allows_custom').value === 'true';
            
            // Si el plan original permitía personalización y el slug no es aleatorio, es personalizado
            if (originalPlanAllowsCustom && !slugIsRandom) {
                this.userCustomSlug = this.originalSlug;
            } else if (!originalPlanAllowsCustom && !slugIsRandom) {
                // Si el plan no permitía personalización pero el slug no es aleatorio, 
                // probablemente es un slug personalizado de antes
                this.userCustomSlug = this.originalSlug;
            } else {
                // El slug actual es aleatorio, no hay slug personalizado preservado
                this.userCustomSlug = '';
            }
            
            // Escuchar cambios de plan
            window.addEventListener('plan-changed', (event) => {
                this.handlePlanChange(event.detail);
            });
            
            console.log('🏷️ SlugManager initialized', {
                currentSlug: this.currentSlug,
                originalSlug: this.originalSlug,
                userCustomSlug: this.userCustomSlug,
                slugIsRandom: slugIsRandom,
                originalPlanAllowsCustom: originalPlanAllowsCustom,
                canEditSlug: this.canEditSlug
            });
        },
        
        handlePlanChange(planData) {
            this.isUpgrading = planData.isUpgrade;
            this.isDowngrading = planData.isDowngrade;
            this.canEditSlug = planData.newPlanAllowsCustom;
            
            console.log('🏷️ Handling plan change', planData);
            
            if (this.isDowngrading) {
                // Downgrade: generar slug ALEATORIO como en el wizard
                this.currentSlug = this.generateRandomSlug();
                
                console.log('⬇️ Downgrade detected - generated random slug:', this.currentSlug);
                
            } else if (this.isUpgrading) {
                // Upgrade: restaurar el slug personalizado del usuario si existe
                if (this.userCustomSlug) {
                    this.currentSlug = this.userCustomSlug;
                    console.log('⬆️ Upgrade detected - restored user custom slug:', this.currentSlug);
                } else {
                    // Si no hay slug personalizado, permitir que editen el actual
                    console.log('⬆️ Upgrade detected - no custom slug to restore, keeping current:', this.currentSlug);
                }
                
            } else if (planData.newPlanAllowsCustom) {
                // Plan que permite personalización: usar el slug personalizado del usuario si existe
                if (this.userCustomSlug) {
                    this.currentSlug = this.userCustomSlug;
                    console.log('✏️ Custom slug allowed - using user custom slug:', this.currentSlug);
                } else {
                    // Si no hay slug personalizado, mantener el actual
                    console.log('✏️ Custom slug allowed - no custom slug, keeping current:', this.currentSlug);
                }
                
            } else {
                // Plan que no permite personalización: generar slug aleatorio
                this.currentSlug = this.generateRandomSlug();
                
                console.log('🔒 Custom slug not allowed - generated random slug:', this.currentSlug);
            }
        },
        
        onSlugInput(event) {
            if (this.canEditSlug) {
                // Actualizar tanto el slug actual como el personalizado del usuario
                this.userCustomSlug = event.target.value;
                this.currentSlug = event.target.value;
                
                console.log('✏️ Slug edited by user:', this.currentSlug);
            }
        },
        
        // Generar slug aleatorio como en el wizard
        generateRandomSlug() {
            const randomString = Math.random().toString(36).substring(2, 8);
            return 'tienda-' + randomString;
        },
        
        // Generar slug desde nombre (no usado actualmente, pero disponible)
        generateSlugFromName(name) {
            if (!name) return this.generateRandomSlug();
            
            return name
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '') // Remover acentos
                .replace(/[^a-z0-9\s-]/g, '') // Solo letras, números, espacios y guiones
                .trim()
                .replace(/\s+/g, '-') // Espacios a guiones
                .replace(/-+/g, '-'); // Múltiples guiones a uno solo
        }
    }
}

// 📧 MANEJO DE REENVÍO DE CREDENCIALES
document.addEventListener('send-credentials', function(event) {
    const { adminId, adminEmail } = event.detail;
    
    if (confirm(`¿Reenviar credenciales de acceso a ${adminEmail}?`)) {
        // Hacer petición AJAX para reenviar credenciales
        fetch('<?php echo e(route("superlinkiu.api.stores.send-credentials-email")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                store_id: <?php echo e($store->id); ?>,
                admin_id: adminId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar notificación de éxito con SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: '✅ Enviado',
                    text: `Credenciales enviadas a ${adminEmail}`,
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: '❌ Error',
                    text: data.message || 'Error al enviar credenciales',
                    confirmButtonColor: '#ed2e45'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: '❌ Error de conexión',
                text: 'No se pudo conectar con el servidor',
                confirmButtonColor: '#ed2e45'
            });
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('shared::layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/stores/edit.blade.php ENDPATH**/ ?>