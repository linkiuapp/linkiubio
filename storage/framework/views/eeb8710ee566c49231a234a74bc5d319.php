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

<?php $__env->startSection('title', 'Métodos de Pago'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="paymentMethodsManager()" class="space-y-4">
    
    <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'gestionar_metodos_pago','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'gestionar_metodos_pago','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
    
    
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-1">Métodos de Pago</h2>
                    <p class="text-sm text-gray-600">Configura cómo tus clientes pueden pagar sus pedidos</p>
                </div>
            </div>
        </div>

        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                
                
                <?php
                    $bankTransferMethod = $paymentMethods->firstWhere('type', 'bank_transfer');
                    $isDefaultBank = $defaultMethod && $bankTransferMethod && $defaultMethod->id === $bankTransferMethod->id;
                ?>
                
                <div class="bg-white rounded-xl border-2 transition-all duration-200 <?php echo e($bankTransferMethod && $bankTransferMethod->is_active ? 'border-blue-200 shadow-sm' : 'border-gray-200'); ?>" data-tour="bank-transfer-section">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl <?php echo e($bankTransferMethod && $bankTransferMethod->is_active ? 'bg-blue-100' : 'bg-gray-100'); ?> flex items-center justify-center">
                                    <i data-lucide="landmark" class="w-6 h-6 <?php echo e($bankTransferMethod && $bankTransferMethod->is_active ? 'text-blue-600' : 'text-gray-400'); ?>"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-semibold text-gray-900">Transferencia Bancaria</h3>
                                        <?php if($isDefaultBank): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                                Principal
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-sm text-gray-500">Transferencia a cuentas bancarias</p>
                                </div>
                            </div>
                            
                            
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" 
                                       class="peer sr-only"
                                       <?php echo e($bankTransferMethod && $bankTransferMethod->is_active ? 'checked' : ''); ?>

                                       @change="toggleMethod('bank_transfer', <?php echo e($bankTransferMethod ? ($bankTransferMethod->is_active ? 'true' : 'false') : 'false'); ?>)">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </div>
                        
                        <?php if($bankTransferMethod && $bankTransferMethod->is_active): ?>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium <?php echo e($bankTransferMethod->available_for_pickup ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500'); ?>">
                                    <i data-lucide="<?php echo e($bankTransferMethod->available_for_pickup ? 'check' : 'x'); ?>" class="w-3 h-3"></i>
                                    Recogida
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium <?php echo e($bankTransferMethod->available_for_delivery ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500'); ?>">
                                    <i data-lucide="<?php echo e($bankTransferMethod->available_for_delivery ? 'check' : 'x'); ?>" class="w-3 h-3"></i>
                                    Entrega
                                </span>
                                <?php if($bankTransferMethod->require_proof): ?>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-50 text-amber-700">
                                        <i data-lucide="file-check" class="w-3 h-3"></i>
                                        Comprobante obligatorio
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($bankTransferMethod->bankAccounts->isNotEmpty()): ?>
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <p class="text-xs font-medium text-gray-500 mb-2"><?php echo e($bankTransferMethod->bankAccounts->count()); ?> cuenta(s) configurada(s)</p>
                                    <div class="space-y-1">
                                        <?php $__currentLoopData = $bankTransferMethod->bankAccounts->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-700"><?php echo e($account->bank_name); ?></span>
                                                <span class="text-gray-400 font-mono text-xs">****<?php echo e(substr($account->account_number, -4)); ?></span>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($bankTransferMethod->bankAccounts->count() > 2): ?>
                                            <p class="text-xs text-gray-400">+<?php echo e($bankTransferMethod->bankAccounts->count() - 2); ?> más</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex flex-wrap gap-2">
                                <button @click="configureMethod('bank_transfer')" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    Configurar
                                </button>
                                <button @click="manageBankAccounts()" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors"
                                        data-tour="bank-accounts-button">
                                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                                    Cuentas
                                </button>
                                <?php if(!$isDefaultBank): ?>
                                    <button @click="setAsDefault('bank_transfer')" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                        Hacer principal
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php
                    $cashMethod = $paymentMethods->firstWhere('type', 'cash');
                    $isDefaultCash = $defaultMethod && $cashMethod && $defaultMethod->id === $cashMethod->id;
                ?>
                
                <div class="bg-white rounded-xl border-2 transition-all duration-200 <?php echo e($cashMethod && $cashMethod->is_active ? 'border-blue-200 shadow-sm' : 'border-gray-200'); ?>" data-tour="cash-section">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl <?php echo e($cashMethod && $cashMethod->is_active ? 'bg-blue-100' : 'bg-gray-100'); ?> flex items-center justify-center">
                                    <i data-lucide="banknote" class="w-6 h-6 <?php echo e($cashMethod && $cashMethod->is_active ? 'text-blue-600' : 'text-gray-400'); ?>"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-semibold text-gray-900">Efectivo</h3>
                                        <?php if($isDefaultCash): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                                Principal
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-sm text-gray-500">Pago en efectivo al momento</p>
                                </div>
                            </div>
                            
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" 
                                       class="peer sr-only"
                                       <?php echo e($cashMethod && $cashMethod->is_active ? 'checked' : ''); ?>

                                       @change="toggleMethod('cash', <?php echo e($cashMethod ? ($cashMethod->is_active ? 'true' : 'false') : 'false'); ?>)">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </div>
                        
                        <?php if($cashMethod && $cashMethod->is_active): ?>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium <?php echo e($cashMethod->available_for_pickup ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500'); ?>">
                                    <i data-lucide="<?php echo e($cashMethod->available_for_pickup ? 'check' : 'x'); ?>" class="w-3 h-3"></i>
                                    Recogida
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium <?php echo e($cashMethod->available_for_delivery ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500'); ?>">
                                    <i data-lucide="<?php echo e($cashMethod->available_for_delivery ? 'check' : 'x'); ?>" class="w-3 h-3"></i>
                                    Entrega
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700">
                                    <i data-lucide="check" class="w-3 h-3"></i>
                                    Permite cambio
                                </span>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                <button @click="configureMethod('cash')" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    Configurar
                                </button>
                                <?php if(!$isDefaultCash): ?>
                                    <button @click="setAsDefault('cash')" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                        Hacer principal
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php
                    $cardMethod = $paymentMethods->firstWhere('type', 'card_terminal');
                    $isDefaultCard = $defaultMethod && $cardMethod && $defaultMethod->id === $cardMethod->id;
                ?>
                
                <div class="bg-white rounded-xl border-2 transition-all duration-200 <?php echo e($cardMethod && $cardMethod->is_active ? 'border-blue-200 shadow-sm' : 'border-gray-200'); ?>" data-tour="card-terminal-section">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl <?php echo e($cardMethod && $cardMethod->is_active ? 'bg-blue-100' : 'bg-gray-100'); ?> flex items-center justify-center">
                                    <i data-lucide="smartphone-nfc" class="w-6 h-6 <?php echo e($cardMethod && $cardMethod->is_active ? 'text-blue-600' : 'text-gray-400'); ?>"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-semibold text-gray-900">Datáfono</h3>
                                        <?php if($isDefaultCard): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                                Principal
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-sm text-gray-500">Tarjeta de crédito o débito</p>
                                </div>
                            </div>
                            
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" 
                                       class="peer sr-only"
                                       <?php echo e($cardMethod && $cardMethod->is_active ? 'checked' : ''); ?>

                                       @change="toggleMethod('card_terminal', <?php echo e($cardMethod ? ($cardMethod->is_active ? 'true' : 'false') : 'false'); ?>)">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </div>
                        
                        <?php if($cardMethod && $cardMethod->is_active): ?>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium <?php echo e($cardMethod->available_for_pickup ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500'); ?>">
                                    <i data-lucide="<?php echo e($cardMethod->available_for_pickup ? 'check' : 'x'); ?>" class="w-3 h-3"></i>
                                    Recogida
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium <?php echo e($cardMethod->available_for_delivery ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500'); ?>">
                                    <i data-lucide="<?php echo e($cardMethod->available_for_delivery ? 'check' : 'x'); ?>" class="w-3 h-3"></i>
                                    Entrega
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-purple-50 text-purple-700">
                                    <i data-lucide="credit-card" class="w-3 h-3"></i>
                                    Visa, Mastercard
                                </span>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                <button @click="configureMethod('card_terminal')" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    Configurar
                                </button>
                                <?php if(!$isDefaultCard): ?>
                                    <button @click="setAsDefault('card_terminal')" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                        Hacer principal
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php
                    $codMethod = $paymentMethods->firstWhere('type', 'cash_on_delivery');
                    $isDefaultCod = $defaultMethod && $codMethod && $defaultMethod->id === $codMethod->id;
                ?>
                
                <div class="bg-white rounded-xl border-2 transition-all duration-200 <?php echo e($codMethod && $codMethod->is_active ? 'border-blue-200 shadow-sm' : 'border-gray-200'); ?>" data-tour="cash-on-delivery-section">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl <?php echo e($codMethod && $codMethod->is_active ? 'bg-blue-100' : 'bg-gray-100'); ?> flex items-center justify-center">
                                    <i data-lucide="truck" class="w-6 h-6 <?php echo e($codMethod && $codMethod->is_active ? 'text-blue-600' : 'text-gray-400'); ?>"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-semibold text-gray-900">Contra Entrega</h3>
                                        <?php if($isDefaultCod): ?>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                                Principal
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-sm text-gray-500">Pago al recibir el producto</p>
                                </div>
                            </div>
                            
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" 
                                       class="peer sr-only"
                                       <?php echo e($codMethod && $codMethod->is_active ? 'checked' : ''); ?>

                                       @change="toggleMethod('cash_on_delivery', <?php echo e($codMethod ? ($codMethod->is_active ? 'true' : 'false') : 'false'); ?>)">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </div>
                        
                        <?php if($codMethod && $codMethod->is_active): ?>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-500">
                                    <i data-lucide="x" class="w-3 h-3"></i>
                                    Recogida
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium <?php echo e($codMethod->available_for_delivery ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500'); ?>">
                                    <i data-lucide="<?php echo e($codMethod->available_for_delivery ? 'check' : 'x'); ?>" class="w-3 h-3"></i>
                                    Entrega
                                </span>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                <button @click="configureMethod('cash_on_delivery')" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    Configurar
                                </button>
                                <?php if(!$isDefaultCod): ?>
                                    <button @click="setAsDefault('cash_on_delivery')" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                        Hacer principal
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        
        <div class="border-t border-gray-200 bg-amber-50 px-6 py-4">
            <div class="flex items-start gap-3">
                <i data-lucide="lightbulb" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                <div class="text-sm text-amber-800">
                    <p class="font-medium mb-1">Consejos</p>
                    <ul class="text-amber-700 space-y-0.5">
                        <li>Agrega al menos una cuenta bancaria para recibir transferencias</li>
                        <li>Contra entrega solo está disponible para envíos a domicilio</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    
    <div x-show="showConfigModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         @keydown.escape.window="showConfigModal = false">
        
        <div class="fixed inset-0 bg-black/50" @click="showConfigModal = false"></div>
        
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="showConfigModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6"
                 @click.stop>
                
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="'Configurar ' + currentMethodName"></h3>
                    <button @click="showConfigModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    
                    <div class="space-y-3">
                        <p class="text-sm font-medium text-gray-700">Disponibilidad</p>
                        
                        <label class="flex items-center justify-between p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors"
                               :class="currentMethodType === 'cash_on_delivery' ? 'opacity-50' : ''">
                            <div class="flex items-center gap-3">
                                <i data-lucide="store" class="w-5 h-5 text-gray-500"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Disponible para recogida</span>
                                    <p x-show="currentMethodType === 'cash_on_delivery'" class="text-xs text-amber-600 mt-0.5">
                                        Solo disponible para domicilio
                                    </p>
                                </div>
                            </div>
                            <label class="relative inline-block w-11 h-6 cursor-pointer" :class="currentMethodType === 'cash_on_delivery' ? 'pointer-events-none opacity-50' : ''">
                                <input type="checkbox" class="peer sr-only" x-model="methodConfig.available_for_pickup" :disabled="currentMethodType === 'cash_on_delivery'">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </label>
                        
                        <label class="flex items-center justify-between p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <i data-lucide="truck" class="w-5 h-5 text-gray-500"></i>
                                <span class="text-sm font-medium text-gray-900">Disponible para entrega</span>
                            </div>
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" class="peer sr-only" x-model="methodConfig.available_for_delivery">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </label>
                    </div>
                    
                    
                    <div x-show="currentMethodType === 'cash'" class="pt-2 border-t border-gray-200">
                        <label class="flex items-center justify-between p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <i data-lucide="coins" class="w-5 h-5 text-gray-500"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Permitir solicitar cambio</span>
                                    <p class="text-xs text-gray-500 mt-0.5">El cliente indica con cuánto pagará</p>
                                </div>
                            </div>
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" class="peer sr-only" x-model="methodConfig.allow_change">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </label>
                    </div>
                    
                    
                    <div x-show="currentMethodType === 'card_terminal'" class="pt-2 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-3">Tarjetas aceptadas</p>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="flex flex-col items-center gap-2 p-3 rounded-lg border-2 cursor-pointer transition-all"
                                   :class="methodConfig.accept_visa ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:bg-gray-50'"
                                   @click="methodConfig.accept_visa = !methodConfig.accept_visa">
                                <i data-lucide="credit-card" class="w-5 h-5" :class="methodConfig.accept_visa ? 'text-green-600' : 'text-gray-400'"></i>
                                <span class="text-sm font-medium" :class="methodConfig.accept_visa ? 'text-green-700' : 'text-gray-700'">Visa</span>
                            </label>
                            <label class="flex flex-col items-center gap-2 p-3 rounded-lg border-2 cursor-pointer transition-all"
                                   :class="methodConfig.accept_mastercard ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:bg-gray-50'"
                                   @click="methodConfig.accept_mastercard = !methodConfig.accept_mastercard">
                                <i data-lucide="credit-card" class="w-5 h-5" :class="methodConfig.accept_mastercard ? 'text-green-600' : 'text-gray-400'"></i>
                                <span class="text-sm font-medium" :class="methodConfig.accept_mastercard ? 'text-green-700' : 'text-gray-700'">Mastercard</span>
                            </label>
                            <label class="flex flex-col items-center gap-2 p-3 rounded-lg border-2 cursor-pointer transition-all"
                                   :class="methodConfig.accept_american_express ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:bg-gray-50'"
                                   @click="methodConfig.accept_american_express = !methodConfig.accept_american_express">
                                <i data-lucide="credit-card" class="w-5 h-5" :class="methodConfig.accept_american_express ? 'text-green-600' : 'text-gray-400'"></i>
                                <span class="text-sm font-medium" :class="methodConfig.accept_american_express ? 'text-green-700' : 'text-gray-700'">Amex</span>
                            </label>
                        </div>
                    </div>
                    
                    
                    <div x-show="currentMethodType === 'bank_transfer'" class="pt-4 border-t border-gray-200">
                        <label class="flex items-center justify-between p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <i data-lucide="file-check" class="w-5 h-5 text-gray-500"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Requerir comprobante de pago</span>
                                    <p class="text-xs text-gray-500 mt-0.5">El cliente debe subir foto del comprobante</p>
                                </div>
                            </div>
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" class="peer sr-only" x-model="methodConfig.require_proof">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </label>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                    <button @click="showConfigModal = false" 
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button @click="saveMethodConfig()" 
                            :disabled="isLoading"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors disabled:opacity-50">
                        <span x-show="!isLoading">Guardar cambios</span>
                        <span x-show="isLoading" class="flex items-center justify-center gap-2">
                            <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                            Guardando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function paymentMethodsManager() {
    return {
        isLoading: false,
        showConfigModal: false,
        currentMethodType: '',
        currentMethodName: '',
        
        methodConfig: {
            available_for_pickup: true,
            available_for_delivery: true,
            allow_change: true,
            accept_visa: true,
            accept_mastercard: true,
            accept_american_express: false,
            require_proof: false
        },
        
        init() {
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        },
        
        async toggleMethod(type, isActive) {
            if (this.isLoading) return;
            this.isLoading = true;
            
            try {
                const response = await fetch(`<?php echo e(route("tenant.admin.payment-methods.toggle-simple", ["store" => $store->slug])); ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ type, is_active: !isActive })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const methodName = this.getMethodName(type);
                    const action = !isActive ? 'activado' : 'desactivado';
                    window.toast.success('¡Actualización exitosa!', `${methodName} ${action}`, 3000, 'bottom-center');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.toast.error('Error', data.message || 'No se pudo actualizar', 5000, 'bottom-center');
                }
            } catch (error) {
                window.toast.error('Error', 'Error de conexión', 5000, 'bottom-center');
            } finally {
                this.isLoading = false;
            }
        },
        
        async setAsDefault(type) {
            if (this.isLoading) return;
            this.isLoading = true;
            
            try {
                const response = await fetch(`<?php echo e(route("tenant.admin.payment-methods.set-default-simple", ["store" => $store->slug])); ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ type })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.toast.success('¡Actualización exitosa!', `${this.getMethodName(type)} es ahora el principal`, 3000, 'bottom-center');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.toast.error('Error', data.message || 'No se pudo actualizar', 5000, 'bottom-center');
                }
            } catch (error) {
                window.toast.error('Error', 'Error de conexión', 5000, 'bottom-center');
            } finally {
                this.isLoading = false;
            }
        },
        
        configureMethod(type) {
            this.currentMethodType = type;
            this.currentMethodName = this.getMethodName(type);
            this.loadMethodConfig(type);
            this.showConfigModal = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        },
        
        getMethodName(type) {
            const names = {
                'bank_transfer': 'Transferencia Bancaria',
                'cash': 'Efectivo',
                'card_terminal': 'Datáfono',
                'cash_on_delivery': 'Contra Entrega'
            };
            return names[type] || type;
        },
        
        loadMethodConfig(type) {
            this.methodConfig = {
                available_for_pickup: true,
                available_for_delivery: true,
                allow_change: true,
                accept_visa: true,
                accept_mastercard: true,
                accept_american_express: false,
                require_proof: false
            };
            
            <?php if($bankTransferMethod): ?>
            if (type === 'bank_transfer') {
                this.methodConfig.available_for_pickup = <?php echo e($bankTransferMethod->available_for_pickup ? 'true' : 'false'); ?>;
                this.methodConfig.available_for_delivery = <?php echo e($bankTransferMethod->available_for_delivery ? 'true' : 'false'); ?>;
                this.methodConfig.require_proof = <?php echo e($bankTransferMethod->require_proof ? 'true' : 'false'); ?>;
            }
            <?php endif; ?>
            
            <?php if($cashMethod): ?>
            if (type === 'cash') {
                this.methodConfig.available_for_pickup = <?php echo e($cashMethod->available_for_pickup ? 'true' : 'false'); ?>;
                this.methodConfig.available_for_delivery = <?php echo e($cashMethod->available_for_delivery ? 'true' : 'false'); ?>;
                this.methodConfig.allow_change = true;
            }
            <?php endif; ?>
            
            <?php if($cardMethod): ?>
            if (type === 'card_terminal') {
                this.methodConfig.available_for_pickup = <?php echo e($cardMethod->available_for_pickup ? 'true' : 'false'); ?>;
                this.methodConfig.available_for_delivery = <?php echo e($cardMethod->available_for_delivery ? 'true' : 'false'); ?>;
                this.methodConfig.accept_visa = true;
                this.methodConfig.accept_mastercard = true;
                this.methodConfig.accept_american_express = false;
            }
            <?php endif; ?>
            
            <?php if($codMethod): ?>
            if (type === 'cash_on_delivery') {
                this.methodConfig.available_for_pickup = false;
                this.methodConfig.available_for_delivery = <?php echo e($codMethod->available_for_delivery ? 'true' : 'false'); ?>;
            }
            <?php endif; ?>
        },
        
        async saveMethodConfig() {
            if (this.isLoading) return;
            this.isLoading = true;
            
            try {
                const response = await fetch(`<?php echo e(route("tenant.admin.payment-methods.configure-simple", ["store" => $store->slug])); ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        type: this.currentMethodType,
                        config: this.methodConfig
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showConfigModal = false;
                    window.toast.success('¡Actualización exitosa!', 'Configuración guardada', 3000, 'bottom-center');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.toast.error('Error', data.message || 'No se pudo guardar', 5000, 'bottom-center');
                }
            } catch (error) {
                window.toast.error('Error', 'Error al guardar', 5000, 'bottom-center');
            } finally {
                this.isLoading = false;
            }
        },
        
        manageBankAccounts() {
            <?php if($bankTransferMethod): ?>
                window.location.href = '<?php echo e(route("tenant.admin.payment-methods.bank-accounts.index", ["store" => $store->slug, "paymentMethod" => $bankTransferMethod->id])); ?>';
            <?php else: ?>
                window.toast.warning('Atención', 'Primero activa Transferencia Bancaria', 4000, 'bottom-center');
            <?php endif; ?>
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
 <?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/payment-methods/index.blade.php ENDPATH**/ ?>