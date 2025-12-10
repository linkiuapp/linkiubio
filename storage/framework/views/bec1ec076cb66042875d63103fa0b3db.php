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
    <?php $__env->startSection('title', 'Notificaciones WhatsApp'); ?>
    
    <?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="whatsappNotifications()" x-init="init()">
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
        
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Notificaciones WhatsApp</h1>
                <p class="text-sm text-gray-600 mt-1">
                    Configura tu número para recibir notificaciones automáticas sobre pedidos, reservas y pagos
                </p>
            </div>
        </div>
        
        
        
        <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'notificaciones_whatsapp','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'notificaciones_whatsapp','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
        
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            
            <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['shadow' => 'sm','dataTour' => 'whatsapp-config']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['shadow' => 'sm','data-tour' => 'whatsapp-config']); ?>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="message-circle" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Número de WhatsApp</h3>
                        <p class="text-xs text-gray-600 mt-0.5">Tu número para recibir notificaciones</p>
                    </div>
                </div>
                
                <form 
                    action="<?php echo e(route('tenant.admin.whatsapp-notifications.update', ['store' => $store->slug])); ?>" 
                    @submit.prevent="submitForm" 
                    class="space-y-4"
                >
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div>
                        <label for="owner_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Número de WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium z-10">+57</span>
                            <input 
                                type="text" 
                                id="owner_phone" 
                                name="owner_phone"
                                data-tour="owner-phone-input" 
                                value="<?php echo e(old('owner_phone', $store->owner_phone)); ?>"
                                placeholder="3001234567"
                                maxlength="10"
                                pattern="[0-9]{10}"
                                class="w-full pl-12 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm <?php $__errorArgs = ['owner_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required
                            />
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Ingresa tu número de celular (10 dígitos) sin espacios ni guiones
                        </p>
                        <?php $__errorArgs = ['owner_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button 
                            type="submit" 
                            data-tour="save-button" 
                            x-bind:disabled="loading"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 focus:bg-gray-900 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-sm font-medium"
                        >
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span x-text="loading ? 'Guardando...' : 'Guardar Configuración'"></span>
                        </button>
                    </div>
                </form>
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
            
            
            
            <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['shadow' => 'sm','dataTour' => 'notificaciones-propietario']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['shadow' => 'sm','data-tour' => 'notificaciones-propietario']); ?>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="bell" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Notificaciones que recibirás</h3>
                        <p class="text-xs text-gray-600 mt-0.5">Alertas automáticas en tu WhatsApp</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <i data-lucide="shopping-cart" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Nuevo pedido</p>
                            <p class="text-xs text-gray-600">Cuando un cliente realiza un pedido</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <i data-lucide="file-check" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Comprobante recibido</p>
                            <p class="text-xs text-gray-600">Cuando un cliente sube un comprobante de pago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <i data-lucide="calendar" class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Nueva reserva</p>
                            <p class="text-xs text-gray-600">Cuando se solicita una reserva (mesas/hotel)</p>
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
        
        
        
        <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['shadow' => 'sm','dataTour' => 'notificaciones-clientes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['shadow' => 'sm','data-tour' => 'notificaciones-clientes']); ?>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-indigo-600"></i>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Notificaciones automáticas a clientes</h3>
                    <p class="text-xs text-gray-600 mt-0.5">Mensajes que tus clientes recibirán automáticamente</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Confirmación de pedido</p>
                        <p class="text-xs text-gray-600">Al crear el pedido</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <i data-lucide="refresh-cw" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Cambios de estado</p>
                        <p class="text-xs text-gray-600">Cuando el pedido cambia de estado</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <i data-lucide="calendar-check" class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Confirmación de reserva</p>
                        <p class="text-xs text-gray-600">Cuando se confirma una reserva</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <i data-lucide="clock" class="w-5 h-5 text-orange-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Recordatorios</p>
                        <p class="text-xs text-gray-600">24h antes de reservas</p>
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

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('whatsappNotifications', function() {
                return {
                    loading: false,
                    
                    init() {
                        <?php if(session('success')): ?>
                        if (window.toast) {
                            window.toast.success(
                                'Actualización exitosa',
                                '<?php echo e(session('success')); ?>',
                                5000,
                                'bottom-center'
                            );
                        }
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                '<?php echo e(session('error')); ?>',
                                5000,
                                'bottom-center'
                            );
                        }
                        <?php endif; ?>
                    },
                    
                    async submitForm(event) {
                        event.preventDefault();
                        this.loading = true;
                        
                        const form = event.target;
                        const formData = new FormData(form);
                        const url = form.action;
                        
                        try {
                            // Agregar el método PUT al FormData para que Laravel lo reconozca
                            formData.append('_method', 'PUT');
                            
                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                },
                                body: formData
                            });
                            
                            const data = await response.json();
                            
                            if (response.ok && !data.errors) {
                                // Éxito
                                if (window.toast) {
                                    window.toast.success(
                                        'Actualización exitosa',
                                        data.message || 'Número de WhatsApp configurado correctamente. Ya recibirás notificaciones de pedidos y pagos.',
                                        5000,
                                        'bottom-center'
                                    );
                                }
                            } else {
                                // Error de validación
                                const errorMessage = data.message || (data.errors && Object.values(data.errors).flat().join(', ')) || 'Error al guardar la configuración';
                                
                                if (window.toast) {
                                    window.toast.error(
                                        'Error',
                                        errorMessage,
                                        5000,
                                        'bottom-center'
                                    );
                                }
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            if (window.toast) {
                                window.toast.error(
                                    'Error',
                                    'Error de conexión. Por favor, intenta nuevamente.',
                                    5000,
                                    'bottom-center'
                                );
                            }
                        } finally {
                            this.loading = false;
                        }
                    }
                };
            });
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


<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/whatsapp-notifications/index.blade.php ENDPATH**/ ?>