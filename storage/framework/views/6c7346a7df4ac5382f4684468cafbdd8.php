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
<?php $__env->startSection('title', 'Clave Maestra'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" x-data="masterKeyManager">
    <!-- Header -->
    <div class="bg-accent-50 rounded-lg p-6 border border-accent-200">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-body-large font-bold text-black-500 mb-2">🔐 Clave Maestra</h2>
                <p class="text-body-small text-black-300 max-w-2xl">
                    Protege acciones críticas de tu tienda. Solo tú podrás ejecutarlas ingresando la clave maestra.
                </p>
            </div>
            <?php if($store->hasMasterKey()): ?>
                <span class="flex items-center gap-2 px-3 py-1.5 bg-success-50 text-success-500 rounded-lg text-caption font-bold">
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
<?php endif; ?> Activada
                </span>
            <?php else: ?>
                <span class="flex items-center gap-2 px-3 py-1.5 bg-error-50 text-error-300 rounded-lg text-caption font-bold">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-close-circle-bold'); ?>
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
<?php endif; ?> Desactivada
                </span>
            <?php endif; ?>
        </div>
    </div>

    <?php if(!$store->hasMasterKey()): ?>
        <!-- Crear Clave Maestra -->
        <div class="bg-white rounded-lg p-6 border border-accent-200">
            <h3 class="text-body-large font-bold text-black-500 mb-4">Crear Clave Maestra</h3>
            
            <form action="<?php echo e(route('tenant.admin.master-key.store', $store->slug)); ?>" method="POST" class="space-y-4">
                <?php echo csrf_field(); ?>
                
                <div>
                    <label class="block text-body-small font-medium text-black-400 mb-2">
                        Clave Maestra (4-8 caracteres)
                    </label>
                    <input type="password" 
                           name="master_key" 
                           class="w-full md:w-1/2 px-4 py-2.5 border border-accent-200 rounded-lg text-body-regular focus:outline-none focus:ring-2 focus:ring-primary-200 <?php $__errorArgs = ['master_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Ingresa tu clave maestra"
                           maxlength="8"
                           required>
                    <?php $__errorArgs = ['master_key'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-caption text-error-300 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-body-small font-medium text-black-400 mb-2">
                        Confirmar Clave Maestra
                    </label>
                    <input type="password" 
                           name="master_key_confirmation" 
                           class="w-full md:w-1/2 px-4 py-2.5 border border-accent-200 rounded-lg text-body-regular focus:outline-none focus:ring-2 focus:ring-primary-200 <?php $__errorArgs = ['master_key_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-error-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Confirma tu clave maestra"
                           maxlength="8"
                           required>
                    <?php $__errorArgs = ['master_key_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-caption text-error-300 mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-primary flex items-center gap-2">
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('solar-lock-bold'); ?>
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
<?php endif; ?> Activar Clave Maestra
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <!-- Configurar Acciones Protegidas -->
        <div class="bg-white rounded-lg p-6 border border-accent-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-h6 font-bold text-black-500">Acciones Protegidas</h3>
                <div class="flex gap-3">
                    <form action="<?php echo e(route('tenant.admin.master-key.request-recovery', $store->slug)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-warning-300 hover:text-warning-400 text-caption font-bold">
                            🔑 ¿Olvidaste tu clave?
                        </button>
                    </form>
                    <button @click="showDisableModal = true" class="text-error-300 hover:text-error-400 text-caption font-bold">
                        🔓 Desactivar Clave Maestra
                    </button>
                </div>
            </div>

            <form action="<?php echo e(route('tenant.admin.master-key.update-actions', $store->slug)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="space-y-6">
                    <!-- Pedidos -->
                    <div class="border border-accent-200 rounded-lg p-4">
                        <h4 class="text-body-large font-bold text-black-500 mb-3 flex items-center gap-2">
                            <span>📦</span> PEDIDOS
                        </h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[orders][delete]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('orders', 'delete') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Eliminar pedido</span>
                            </label>
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[orders][cancel]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('orders', 'cancel') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Cancelar pedido</span>
                            </label>
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[orders][mark_delivered]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('orders', 'mark_delivered') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Marcar como entregado</span>
                            </label>
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[orders][edit_total]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('orders', 'edit_total') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Editar total del pedido</span>
                            </label>
                        </div>
                    </div>

                    <!-- Productos -->
                    <div class="border border-accent-200 rounded-lg p-4">
                        <h4 class="text-body-large font-bold text-black-500 mb-3 flex items-center gap-2">
                            <span>🛍️</span> PRODUCTOS
                        </h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[products][delete]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('products', 'delete') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Eliminar producto</span>
                            </label>
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[products][change_price]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('products', 'change_price') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Cambiar precio</span>
                            </label>
                        </div>
                    </div>

                    <!-- Cuentas Bancarias -->
                    <div class="border border-accent-200 rounded-lg p-4">
                        <h4 class="text-body-large font-bold text-black-500 mb-3 flex items-center gap-2">
                            <span>💳</span> CUENTAS BANCARIAS
                        </h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[bank_accounts][create]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('bank_accounts', 'create') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Crear cuenta bancaria</span>
                            </label>
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[bank_accounts][delete]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('bank_accounts', 'delete') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Eliminar cuenta bancaria</span>
                            </label>
                        </div>
                    </div>

                    <!-- Envíos -->
                    <div class="border border-accent-200 rounded-lg p-4">
                        <h4 class="text-body-large font-bold text-black-500 mb-3 flex items-center gap-2">
                            <span>🚚</span> ENVÍOS
                        </h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[shipping][delete_zone]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('shipping', 'delete_zone') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Eliminar zona de envío</span>
                            </label>
                        </div>
                    </div>

                    <!-- Diseño -->
                    <div class="border border-accent-200 rounded-lg p-4">
                        <h4 class="text-body-large font-bold text-black-500 mb-3 flex items-center gap-2">
                            <span>🎨</span> DISEÑO
                        </h4>
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 p-2 hover:bg-accent-50 rounded cursor-pointer">
                                <input type="checkbox" 
                                       name="protected_actions[store_design][publish]" 
                                       value="1"
                                       <?php echo e($store->isActionProtected('store_design', 'publish') ? 'checked' : ''); ?>

                                       class="w-5 h-5 text-primary-300 border-accent-300 rounded focus:ring-2 focus:ring-primary-200">
                                <span class="text-body-small text-black-400">Publicar diseño</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-accent-200">
                    <button type="submit" class="btn-primary">
                        💾 Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- Modal para desactivar clave maestra -->
    <div x-show="showDisableModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="showDisableModal = false">
                <div class="absolute inset-0 bg-black-500/75 backdrop-blur-sm"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="<?php echo e(route('tenant.admin.master-key.destroy', $store->slug)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-error-50 sm:mx-0 sm:h-10 sm:w-10">
                                <span class="text-2xl">🔓</span>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-body-large leading-6 font-bold text-black-500">
                                    Desactivar Clave Maestra
                                </h3>
                                <div class="mt-4">
                                    <p class="text-body-small text-black-300 mb-4">
                                        Para desactivar la clave maestra, debes ingresar tu clave actual. 
                                        Todas las protecciones serán removidas.
                                    </p>
                                    <input type="password" 
                                           name="current_key" 
                                           placeholder="Ingresa tu clave maestra"
                                           class="w-full px-4 py-2.5 border border-accent-200 rounded-lg text-body-regular focus:outline-none focus:ring-2 focus:ring-primary-200"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-accent-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-error-300 text-body-small font-bold text-white hover:bg-error-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-error-300 sm:w-auto transition-colors">
                            Desactivar
                        </button>
                        <button type="button" 
                                @click="showDisableModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-accent-300 shadow-sm px-4 py-2 bg-white text-body-small font-medium text-black-400 hover:bg-accent-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-200 sm:mt-0 sm:w-auto transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('masterKeyManager', () => ({
        showDisableModal: false
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
<?php endif; ?>

<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/master-key/index.blade.php ENDPATH**/ ?>