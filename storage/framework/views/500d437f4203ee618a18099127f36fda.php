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

<?php $__env->startSection('title', 'Cuentas Bancarias'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="bankAccountsManager()" class="space-y-4">
    
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
                    <div class="flex items-center gap-3 mb-1">
                <a href="<?php echo e(route('tenant.admin.payment-methods.index', ['store' => $store->slug])); ?>" 
                           class="text-gray-400 hover:text-gray-600 transition-colors">
                            <i data-lucide="arrow-left" class="w-5 h-5"></i>
                        </a>
                        <h2 class="text-lg font-semibold text-gray-900">Cuentas Bancarias</h2>
                    </div>
                    <p class="text-sm text-gray-600 ml-8">
                        <?php echo e($currentCount); ?> de <?php echo e($maxAccounts); ?> cuentas en tu plan <?php echo e($planName); ?>

                    </p>
                </div>
                <div class="flex items-center gap-3">
                <?php if($remainingSlots > 0): ?>
                <a href="<?php echo e(route('tenant.admin.payment-methods.bank-accounts.create', ['store' => $store->slug, 'paymentMethod' => $paymentMethod->id])); ?>" 
                           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                    Nueva Cuenta
                </a>
                <?php else: ?>
                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                    Límite Alcanzado
                        </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

        
        <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-gray-500">Uso del plan</span>
                <span class="text-xs font-medium text-gray-700"><?php echo e($currentCount); ?>/<?php echo e($maxAccounts); ?></span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: <?php echo e(($currentCount / $maxAccounts) * 100); ?>%"></div>
            </div>
        </div>

        
        <div class="p-6">
            <?php if($bankAccounts->isEmpty()): ?>
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <i data-lucide="landmark" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Sin cuentas bancarias</h3>
                    <p class="text-sm text-gray-500 mb-6 max-w-sm mx-auto">Agrega cuentas bancarias para que tus clientes puedan realizar transferencias</p>
                    <?php if($remainingSlots > 0): ?>
                        <a href="<?php echo e(route('tenant.admin.payment-methods.bank-accounts.create', ['store' => $store->slug, 'paymentMethod' => $paymentMethod->id])); ?>" 
                           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Agregar primera cuenta
                    </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                            <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-4 bg-white border rounded-xl <?php echo e($account->is_active ? 'border-blue-200' : 'border-gray-200'); ?> transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl <?php echo e($account->is_active ? 'bg-blue-100' : 'bg-gray-100'); ?> flex items-center justify-center">
                                    <i data-lucide="landmark" class="w-6 h-6 <?php echo e($account->is_active ? 'text-blue-600' : 'text-gray-400'); ?>"></i>
                                            </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-semibold text-gray-900"><?php echo e($account->bank_name); ?></h4>
                                        <?php if(!$account->is_active): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                Inactiva
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-sm text-gray-500">
                                        <?php echo e($account->account_type == 'savings' ? 'Ahorros' : 'Corriente'); ?> - 
                                        <span class="font-mono">****<?php echo e(substr($account->account_number, -4)); ?></span>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-0.5"><?php echo e($account->account_holder_name); ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                
                                <label class="relative inline-block w-11 h-6 cursor-pointer">
                                    <input type="checkbox" 
                                           class="peer sr-only"
                                           <?php echo e($account->is_active ? 'checked' : ''); ?>

                                           @change="toggleActive('<?php echo e(route('tenant.admin.payment-methods.bank-accounts.toggle-active', ['store' => $store->slug, 'paymentMethod' => $paymentMethod->id, 'bankAccount' => $account->id])); ?>', '<?php echo e($account->is_active ? 'desactivar' : 'activar'); ?>')">
                                    <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                </label>
                                
                                
                                <a href="<?php echo e(route('tenant.admin.payment-methods.bank-accounts.edit', ['store' => $store->slug, 'paymentMethod' => $paymentMethod->id, 'bankAccount' => $account->id])); ?>" 
                                   class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i data-lucide="pencil" class="w-5 h-5"></i>
                                </a>
                                
                                
                                            <button type="button" 
                                        class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors"
                                        @click="<?php if($store->isActionProtected('bank_accounts', 'delete')): ?>
                                                    openMasterKey('<?php echo e($account->bank_name); ?> - ****<?php echo e(substr($account->account_number, -4)); ?>', '<?php echo e(route('tenant.admin.payment-methods.bank-accounts.destroy', ['store' => $store->slug, 'paymentMethod' => $paymentMethod->id, 'bankAccount' => $account->id])); ?>')
                                                <?php else: ?>
                                                    openDeleteModal('<?php echo e($account->bank_name); ?>', '<?php echo e(route('tenant.admin.payment-methods.bank-accounts.destroy', ['store' => $store->slug, 'paymentMethod' => $paymentMethod->id, 'bankAccount' => $account->id])); ?>')
                                                            <?php endif; ?>">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </div>
                        </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <?php if($remainingSlots <= 0): ?>
                    <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <div class="flex items-start gap-3">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                            <div>
                                <p class="text-sm font-medium text-amber-800">Límite de cuentas alcanzado</p>
                                <p class="text-sm text-amber-700 mt-0.5">Tu plan permite máximo <?php echo e($maxAccounts); ?> cuentas.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    
    <div 
        x-show="showMasterKey"
        x-cloak
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[99998] bg-black/50 backdrop-blur-sm"
        @click="closeMasterKey()"
    ></div>

    <div 
        x-show="showMasterKey"
        x-cloak
        class="fixed inset-0 z-[99998] overflow-x-hidden overflow-y-auto pointer-events-none"
    >
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto pointer-events-none min-h-[calc(100%-56px)] flex items-center">
            <div 
                x-show="showMasterKey"
                x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.stop
                class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-lg pointer-events-auto"
            >
                
                <div class="flex items-start gap-4 p-6 border-b border-gray-200">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <i data-lucide="lock-keyhole" class="w-6 h-6 text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Clave Maestra Requerida</h3>
                        <div class="text-sm text-gray-600 space-y-2">
                            <p>Eliminar cuenta:</p>
                            <p class="font-bold text-gray-900" x-text="masterKeyAccountName"></p>
                        </div>
                    </div>
                    <button 
                        type="button" 
                        class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors" 
                        @click="closeMasterKey()"
                        :disabled="masterKeyLoading"
                    >
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                
                <div class="p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Clave Maestra</label>
                    <input 
                        type="password"
                        x-model="masterKeyValue"
                        x-ref="masterKeyInput"
                        @keydown.enter="verifyMasterKey()"
                        :disabled="masterKeyLoading"
                        placeholder="********"
                        maxlength="8"
                        autocomplete="off"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-center text-lg tracking-widest font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:opacity-50"
                    >
                    <p x-show="masterKeyError" x-text="masterKeyError" class="mt-2 text-sm text-red-600"></p>
                </div>

                
                <div class="flex justify-end items-center gap-3 p-6 border-t border-gray-200">
                    <button 
                        type="button" 
                        @click="closeMasterKey()"
                        :disabled="masterKeyLoading"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50"
                    >
                        Cancelar
                    </button>
                    <button 
                        type="button" 
                        @click="verifyMasterKey()"
                        :disabled="masterKeyLoading || !masterKeyValue"
                        class="px-4 py-2 text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 rounded-lg transition-colors disabled:opacity-50 flex items-center gap-2 min-w-[130px] justify-center"
                    >
                        <svg x-show="masterKeyLoading" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="masterKeyLoading ? 'Verificando...' : 'Verificar'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div 
        x-show="showDeleteConfirm"
        x-cloak
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
        @click="closeDeleteModal()"
    ></div>

    <div 
        x-show="showDeleteConfirm"
        x-cloak
        class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
    >
        <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
            <div 
                x-show="showDeleteConfirm"
                x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-all ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                @click.stop
                class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
            >
                <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800">¿Eliminar cuenta bancaria?</h3>
                    <button 
                        type="button" 
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors" 
                        @click="closeDeleteModal()"
                        :disabled="deleteLoading"
                    >
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
                                Se eliminará la cuenta <strong>"<span x-text="deleteAccountName"></span>"</strong> de forma permanente.
                            </p>
                            <p class="text-sm text-gray-600 mt-2">Esta acción no se puede deshacer.</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                    <button 
                        type="button" 
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 transition-colors disabled:opacity-50" 
                        @click="closeDeleteModal()"
                        :disabled="deleteLoading"
                    >
                        Cancelar
                    </button>
                    <button 
                        type="button" 
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 transition-colors disabled:opacity-50"
                        @click="confirmDelete()"
                        :disabled="deleteLoading"
                    >
                        <span x-show="!deleteLoading">Sí, eliminar</span>
                        <span x-show="deleteLoading" class="flex items-center gap-2">
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
function bankAccountsManager() {
    return {
        // Delete modal
        showDeleteConfirm: false,
        deleteAccountName: '',
        deleteUrl: '',
        deleteLoading: false,
        
        // Master key modal
        showMasterKey: false,
        masterKeyAccountName: '',
        masterKeyUrl: '',
        masterKeyValue: '',
        masterKeyError: '',
        masterKeyLoading: false,
        
        init() {
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        },
        
        toggleActive(url, action) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;
            form.innerHTML = `<input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">`;
            document.body.appendChild(form);
            form.submit();
        },
        
        openDeleteModal(name, url) {
            this.deleteAccountName = name;
            this.deleteUrl = url;
            this.showDeleteConfirm = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });
        },
        
        closeDeleteModal() {
            this.showDeleteConfirm = false;
            this.deleteAccountName = '';
            this.deleteUrl = '';
            this.deleteLoading = false;
        },
        
        confirmDelete() {
            this.deleteLoading = true;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = this.deleteUrl;
            form.innerHTML = `
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                <input type="hidden" name="_method" value="DELETE">
            `;
        document.body.appendChild(form);
        form.submit();
        },
        
        openMasterKey(name, url) {
            this.masterKeyAccountName = name;
            this.masterKeyUrl = url;
            this.masterKeyValue = '';
            this.masterKeyError = '';
            this.masterKeyLoading = false;
            this.showMasterKey = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') lucide.createIcons();
                this.$refs.masterKeyInput?.focus();
            });
        },
        
        closeMasterKey() {
            this.showMasterKey = false;
            this.masterKeyValue = '';
            this.masterKeyError = '';
            this.masterKeyLoading = false;
        },
        
        async verifyMasterKey() {
            if (!this.masterKeyValue || this.masterKeyLoading) return;
            
            this.masterKeyLoading = true;
            this.masterKeyError = '';
            
            try {
                const response = await fetch('<?php echo e(route("tenant.admin.master-key.verify", ["store" => $store->slug])); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        key: this.masterKeyValue,
                        action: 'bank_accounts.delete'
                    })
                });
                
                const data = await response.json();
                
                if (!response.ok || !data.success) {
                    this.masterKeyError = data.message || 'Clave incorrecta';
                    this.masterKeyLoading = false;
                    return;
                }
                
                // Clave correcta, cerrar modal y abrir eliminar
                const url = this.masterKeyUrl;
                const name = this.masterKeyAccountName;
                this.closeMasterKey();
                
                setTimeout(() => {
                    this.openDeleteModal(name, url);
                }, 350);
            } catch (error) {
                this.masterKeyError = 'Error de conexión';
                this.masterKeyLoading = false;
            }
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/bank-accounts/index.blade.php ENDPATH**/ ?>