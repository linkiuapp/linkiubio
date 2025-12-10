<?php $__env->startSection('title', 'Nuevo Icono de Categoría'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex-1 space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-4">
        <a href="<?php echo e(route('superlinkiu.category-icons.index')); ?>" 
           class="p-2 text-black-300 hover:text-black-400 hover:bg-accent-100 rounded-lg transition-colors">
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
        </a>
        <div>
            <h1 class="text-3xl font-semibold text-black-400">Nuevo Icono de Categoría</h1>
            <p class="text-black-300 mt-1">Agrega un nuevo icono que estará disponible para las tiendas</p>
        </div>
    </div>

    <!-- Main Form -->
    <div class="max-w-5xl">
        <form action="<?php echo e(route('superlinkiu.category-icons.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>

            <!-- Main Content Card -->
            <div class="bg-accent-50 rounded-xl shadow-sm border border-accent-100 overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 border-b border-accent-100 bg-gradient-to-r from-accent-50 to-accent-100">
                    <h2 class="text-xl font-semibold text-black-500">Información del Icono</h2>
                </div>

                <!-- Card Content -->
                <div class="p-6 space-y-8">
                                                        <!-- File Upload Section -->
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- File Upload Area -->
                            <div class="space-y-4">
                                <label for="icon_file" class="block text-sm font-semibold text-black-400">
                                    Archivo del Icono <span class="text-error-400">*</span>
                                </label>
                                
                                <div class="relative border-2 border-dashed border-accent-300 rounded-xl p-8 text-center hover:border-primary-200 hover:bg-primary-50 transition-all duration-200">
                                    
                                    <!-- Default Upload State -->
                                    <div id="upload-area" class="space-y-4">
                                        <div class="w-16 h-16 mx-auto bg-accent-200 rounded-xl flex items-center justify-center">
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-gallery-add-outline'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 text-black-300']); ?>
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
                                        </div>
                                        <div>
                                            <label for="icon_file" class="cursor-pointer">
                                                <span class="text-primary-400 hover:text-primary-300 font-medium">Selecciona un archivo</span>
                                                <span class="text-black-300"> o arrastra y suelta aquí</span>
                                            </label>
                                        </div>
                                        <p class="text-sm text-black-300">
                                            Formatos: SVG, PNG, JPG • Tamaño máximo: 2MB
                                        </p>
                                    </div>

                                    <!-- Preview State (hidden initially) -->
                                    <div id="preview-area" class="space-y-4 hidden">
                                        <div class="relative">
                                            <div class="w-32 h-32 mx-auto bg-accent-100 rounded-xl p-4 flex items-center justify-center shadow-inner">
                                                <img id="preview-image" class="max-w-full max-h-full object-contain" alt="Preview">
                                            </div>
                                            <button type="button" 
                                                    onclick="clearPreview()"
                                                    class="absolute -top-2 -right-2 w-8 h-8 bg-error-400 text-accent-50 rounded-full hover:bg-error-300 transition-colors flex items-center justify-center">
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
                                        <p id="file-name" class="text-sm font-medium text-black-400"></p>
                                        <p class="text-xs text-success-400">✓ Archivo seleccionado</p>
                                    </div>

                                    <!-- Hidden File Input -->
                                    <input id="icon_file" 
                                           name="icon_file" 
                                           type="file" 
                                           class="sr-only" 
                                           accept=".svg,.png,.jpg,.jpeg"
                                           onchange="handleFileSelect(this)"
                                           required>
                                </div>
                                
                                <?php $__errorArgs = ['icon_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-sm text-error-400 flex items-center gap-2">
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
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Preview Sizes (only shown when file selected) -->
                            <div id="preview-sizes" class="space-y-4 hidden">
                                <label class="block text-sm font-semibold text-black-400">
                                    Vista Previa en Diferentes Tamaños
                                </label>
                                
                                <div class="bg-accent-100 rounded-xl p-6 space-y-6">
                                    <div class="grid grid-cols-1 gap-4">
                                        <!-- Small -->
                                        <div class="flex items-center gap-4 p-3 bg-accent-50 rounded-lg">
                                            <div class="w-8 h-8 bg-accent-200 rounded-lg p-1 flex items-center justify-center">
                                                <img class="preview-small w-full h-full object-contain" alt="Pequeño">
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-black-400">Tamaño pequeño</span>
                                                <p class="text-xs text-black-300">32×32px • Para listas y menús</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Medium -->
                                        <div class="flex items-center gap-4 p-3 bg-accent-50 rounded-lg">
                                            <div class="w-12 h-12 bg-accent-200 rounded-lg p-2 flex items-center justify-center">
                                                <img class="preview-medium w-full h-full object-contain" alt="Mediano">
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-black-400">Tamaño mediano</span>
                                                <p class="text-xs text-black-300">48×48px • Para selector de categorías</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Large -->
                                        <div class="flex items-center gap-4 p-3 bg-accent-50 rounded-lg">
                                            <div class="w-16 h-16 bg-accent-200 rounded-lg p-3 flex items-center justify-center">
                                                <img class="preview-large w-full h-full object-contain" alt="Grande">
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-black-400">Tamaño grande</span>
                                                <p class="text-xs text-black-300">64×64px • Para vista de detalles</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <!-- Display Name -->
                        <div class="space-y-2">
                            <label for="display_name" class="block text-sm font-semibold text-black-400">
                                Nombre para Mostrar <span class="text-error-400">*</span>
                            </label>
                            <input type="text" 
                                   name="display_name" 
                                   id="display_name"
                                   value="<?php echo e(old('display_name')); ?>"
                                   class="w-full px-4 py-3 rounded-lg bg-accent-100 border border-accent-200 
                                          focus:ring-2 focus:ring-primary-200 focus:border-primary-200 transition-colors
                                          <?php $__errorArgs = ['display_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 focus:ring-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Ej: Hamburguesas, Pizza, Bebidas..."
                                   required>
                            <?php $__errorArgs = ['display_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-error-400 flex items-center gap-2">
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
                                    <?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Internal Name (opcional, se genera automáticamente) -->
                        <input type="hidden" name="name" id="name" value="<?php echo e(old('name')); ?>">
                    </div>

                    <!-- Categorías de Negocio -->
                    <div class="space-y-3" x-data="{ isGlobal: <?php echo e(old('is_global') ? 'true' : 'false'); ?> }">
                        <label class="block text-sm font-semibold text-black-400">
                            Categorías de Negocio <span class="text-error-400">*</span>
                        </label>

                        <!-- Checkbox Global -->
                        <div class="bg-primary-50 border border-primary-100 rounded-lg p-4 mb-4">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="hidden" name="is_global" value="0">
                                <input type="checkbox" 
                                       name="is_global" 
                                       value="1"
                                       x-model="isGlobal"
                                       class="mt-0.5 rounded border-primary-200 text-primary-300 focus:ring-primary-200"
                                       <?php echo e(old('is_global') ? 'checked' : ''); ?>>
                                <div>
                                    <span class="text-sm font-semibold text-primary-400 flex items-center gap-2">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-star-bold'); ?>
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
                                        Icono Global (aparece en todas las categorías)
                                    </span>
                                    <p class="text-xs text-primary-300 mt-1">
                                        Usa esto para iconos universales como "Destacado", "Nuevo", "Oferta", etc.
                                    </p>
                                </div>
                            </label>
                        </div>

                        <!-- Multiselect de Categorías -->
                        <div x-show="!isGlobal" x-transition class="space-y-3">
                            <div class="bg-accent-100 rounded-lg p-4 max-h-64 overflow-y-auto">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <?php $__currentLoopData = $businessCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-start gap-3 p-3 bg-accent-50 rounded-lg hover:bg-accent-200 cursor-pointer transition-colors">
                                            <input type="checkbox" 
                                                   name="business_categories[]" 
                                                   value="<?php echo e($category->id); ?>"
                                                   class="mt-0.5 rounded border-accent-300 text-primary-300 focus:ring-primary-200"
                                                   <?php echo e(in_array($category->id, old('business_categories', [])) ? 'checked' : ''); ?>>
                                            <div class="flex-1">
                                                <span class="text-sm font-medium text-black-400"><?php echo e($category->name); ?></span>
                                                <?php if($category->icon): ?>
                                                    <span class="text-xs text-black-300"><?php echo e($category->icon); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            
                            <div class="flex gap-2">
                                <button type="button" 
                                        onclick="document.querySelectorAll('input[name=\'business_categories[]\']').forEach(cb => cb.checked = true)"
                                        class="text-xs px-3 py-1.5 bg-primary-100 text-primary-400 rounded-lg hover:bg-primary-200">
                                    Seleccionar todas
                                </button>
                                <button type="button" 
                                        onclick="document.querySelectorAll('input[name=\'business_categories[]\']').forEach(cb => cb.checked = false)"
                                        class="text-xs px-3 py-1.5 bg-accent-200 text-black-400 rounded-lg hover:bg-accent-300">
                                    Deseleccionar todas
                                </button>
                            </div>
                        </div>

                        <?php $__errorArgs = ['business_categories'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-sm text-error-400 flex items-center gap-2">
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
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Status -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-black-400">Estado Inicial</label>
                        <div class="flex items-center gap-3 p-4 bg-accent-100 rounded-lg">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" 
                                       name="is_active" 
                                       value="1"
                                       class="sr-only peer"
                                       <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                                <div class="w-11 h-6 bg-accent-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary-200 rounded-full peer 
                                            peer-checked:after:translate-x-full peer-checked:after:border-accent-50 
                                            after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                            after:bg-accent-50 after:rounded-full after:h-5 after:w-5 after:transition-all 
                                            peer-checked:bg-success-300"></div>
                            </label>
                            <div>
                                <span class="text-sm font-medium text-black-400">Icono activo</span>
                                <p class="text-xs text-black-300">Los iconos inactivos no aparecen en las tiendas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between p-6 bg-accent-50 rounded-xl border border-accent-100">
                <a href="<?php echo e(route('superlinkiu.category-icons.index')); ?>" 
                   class="btn-secondary flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-arrow-left-outline'); ?>
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
                    Cancelar
                </a>
                
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-diskette-outline'); ?>
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
                    Crear Icono
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-generar slug desde display_name
    document.getElementById('display_name').addEventListener('input', function(e) {
        const slug = e.target.value
            .toLowerCase()
            .replace(/[áàäâ]/g, 'a')
            .replace(/[éèëê]/g, 'e')
            .replace(/[íìïî]/g, 'i')
            .replace(/[óòöô]/g, 'o')
            .replace(/[úùüû]/g, 'u')
            .replace(/ñ/g, 'n')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        
        document.getElementById('name').value = slug;
    });

    // Simple vanilla JavaScript for file preview (no Alpine.js)
    function handleFileSelect(input) {
        const file = input.files[0];
        
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Show preview area, hide upload area
                document.getElementById('upload-area').classList.add('hidden');
                document.getElementById('preview-area').classList.remove('hidden');
                document.getElementById('preview-sizes').classList.remove('hidden');
                
                // Set preview images
                const previewSrc = e.target.result;
                document.getElementById('preview-image').src = previewSrc;
                document.querySelector('.preview-small').src = previewSrc;
                document.querySelector('.preview-medium').src = previewSrc;
                document.querySelector('.preview-large').src = previewSrc;
                
                // Set filename
                document.getElementById('file-name').textContent = file.name;
            };
            reader.readAsDataURL(file);
        } else if (file) {
            alert('Por favor selecciona un archivo de imagen válido (SVG, PNG, JPG, WebP)');
            clearPreview();
        }
    }
    
    function clearPreview() {
        // Reset file input
        document.getElementById('icon_file').value = '';
        
        // Show upload area, hide preview
        document.getElementById('upload-area').classList.remove('hidden');
        document.getElementById('preview-area').classList.add('hidden');
        document.getElementById('preview-sizes').classList.add('hidden');
        
        // Clear preview images
        document.getElementById('preview-image').src = '';
        document.querySelector('.preview-small').src = '';
        document.querySelector('.preview-medium').src = '';
        document.querySelector('.preview-large').src = '';
        
        // Clear filename
        document.getElementById('file-name').textContent = '';
    }
    
    // Optional: Handle click on upload area to trigger file input
    document.getElementById('upload-area').addEventListener('click', function() {
        document.getElementById('icon_file').click();
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('shared::layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/category-icons/create.blade.php ENDPATH**/ ?>