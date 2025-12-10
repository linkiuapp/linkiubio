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
    <?php $__env->startSection('title', 'Mi Perfil'); ?>
    <?php $__env->startSection('subtitle', 'Gestiona tu información y seguridad'); ?>

    <?php $__env->startSection('content'); ?>
    <div class="max-w-3xl mx-auto space-y-6">
        
        <!-- Información del Usuario -->
        <div class="bg-accent-50 rounded-lg p-6 border border-accent-200">
            <h2 class="text-lg font-semibold text-black-500 mb-4">Información Personal</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-1">Nombre</label>
                    <p class="text-black-500 font-medium"><?php echo e($user->name); ?></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-1">Email</label>
                    <p class="text-black-500 font-medium"><?php echo e($user->email); ?></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-1">Tienda</label>
                    <p class="text-black-500 font-medium"><?php echo e($store->name); ?></p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-black-300 mb-1">Último acceso</label>
                    <p class="text-black-300">
                        <?php echo e($user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca'); ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- Cambiar Contraseña -->
        <div class="bg-accent-50 rounded-lg p-6 border border-accent-200">
            <h2 class="text-lg font-semibold text-black-500 mb-4">🔐 Cambiar Contraseña</h2>
            
            <form method="POST" action="<?php echo e(route('tenant.admin.profile.change-password', ['store' => $store->slug])); ?>">
                <?php echo csrf_field(); ?>
                
                <div class="space-y-4">
                    <!-- Contraseña Actual -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-black-300 mb-2">
                            Contraseña Actual <span class="text-error-300">*</span>
                        </label>
                        <input type="password" 
                               id="current_password" 
                               name="current_password" 
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               required>
                        <?php $__errorArgs = ['current_password'];
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

                    <!-- Nueva Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-black-300 mb-2">
                            Nueva Contraseña <span class="text-error-300">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-200 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               required>
                        <p class="text-xs text-black-300 mt-1">Mínimo 8 caracteres, debe incluir letras y números</p>
                        <?php $__errorArgs = ['password'];
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

                    <!-- Confirmar Nueva Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-black-300 mb-2">
                            Confirmar Nueva Contraseña <span class="text-error-300">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none"
                               required>
                    </div>

                    <!-- Botón -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="bg-primary-300 hover:bg-primary-200 text-accent-50 px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-key mr-2"></i> Cambiar Contraseña
                        </button>
                    </div>
                </div>
            </form>
        </div>

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



<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/profile/index.blade.php ENDPATH**/ ?>