

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
    <?php $__env->startSection('title', 'Editar Variable'); ?>

    <?php $__env->startSection('content'); ?>
    <div 
        x-data="{ 
            deleteModalOpen: false,
            deleteLoading: false,
            deleteError: null,
            openDeleteModal() {
                this.deleteError = null;
                this.deleteModalOpen = true;
            },
            closeDeleteModal() {
                if (!this.deleteLoading) {
                    this.deleteModalOpen = false;
                    this.deleteError = null;
                }
            },
            async confirmDelete() {
                this.deleteLoading = true;
                this.deleteError = null;
                
                try {
                    const storeSlug = '<?php echo e($store->slug); ?>';
                    const variableId = '<?php echo e($variable->id); ?>';
                    const response = await fetch('/' + storeSlug + '/admin/variables/' + variableId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        }
                    });

                    let data;
                    try {
                        data = await response.json();
                    } catch (e) {
                        throw new Error('Error al procesar la respuesta del servidor');
                    }

                    if (!response.ok) {
                        throw new Error(data.error || 'Error al eliminar la variable');
                    }

                    if (data.error) {
                        throw new Error(data.error);
                    }

                    this.deleteLoading = false;
                    this.closeDeleteModal();
                    
                    window.location.href = '/' + storeSlug + '/admin/variables';
                } catch (error) {
                    this.deleteError = error.message || 'Error al eliminar la variable';
                    this.deleteLoading = false;
                }
            }
        }"
        x-on:keydown.escape.window="closeDeleteModal()"
        class="max-w-4xl mx-auto space-y-6"
    >
        
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('tenant.admin.variables.index', $store->slug)); ?>" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Editar Variable</h1>
        </div>
        

        
        
        <?php if (isset($component)) { $__componentOriginal41ce05244c62d53131dc2872106fd4c6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41ce05244c62d53131dc2872106fd4c6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertSoft','data' => ['type' => 'info','message' => 'Editando variable: ' . $variable->name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Editando variable: ' . $variable->name)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41ce05244c62d53131dc2872106fd4c6)): ?>
<?php $attributes = $__attributesOriginal41ce05244c62d53131dc2872106fd4c6; ?>
<?php unset($__attributesOriginal41ce05244c62d53131dc2872106fd4c6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41ce05244c62d53131dc2872106fd4c6)): ?>
<?php $component = $__componentOriginal41ce05244c62d53131dc2872106fd4c6; ?>
<?php unset($__componentOriginal41ce05244c62d53131dc2872106fd4c6); ?>
<?php endif; ?>
        
        

        
        <?php if($errors->any()): ?>
            
            <?php if (isset($component)) { $__componentOriginal4e12e3fb830c932c6bff0347987a4573 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e12e3fb830c932c6bff0347987a4573 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertBordered','data' => ['type' => 'error','title' => 'Por favor corrige los siguientes errores:']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-bordered'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'error','title' => 'Por favor corrige los siguientes errores:']); ?>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="text-sm text-gray-700"><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
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
            
        <?php endif; ?>
        

        
        <form action="<?php echo e(route('tenant.admin.variables.update', [$store->slug, $variable->id])); ?>" method="POST" x-data="variableForm()">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                
                <div class="p-6 space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="md:col-span-2">
                            <?php if (isset($component)) { $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.TextInput','data' => ['type' => 'text','name' => 'name','id' => 'name','label' => 'Nombre de la Variable','placeholder' => 'Ej: Talla, Color, Material','value' => old('name', $variable->name),'required' => true,'error' => $errors->first('name')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ds.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'name','id' => 'name','label' => 'Nombre de la Variable','placeholder' => 'Ej: Talla, Color, Material','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('name', $variable->name)),'required' => true,'error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('name'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $attributes = $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $component = $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
                        </div>
                        

                        
                        <div>
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'type','selectId' => 'type','options' => [
                                    '' => 'Selecciona un tipo',
                                    'radio' => 'Selección única (Compatible con Variantes)',
                                    'checkbox' => 'Selección múltiple (NO Compatible con Variantes)',
                                    'text' => 'Texto libre',
                                    'numeric' => 'Numérico'
                                ],'selected' => old('type', $variable->type),'placeholder' => '','xModel' => 'variableType','@change' => 'handleTypeChange()','error' => $errors->first('type'),'required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'type','select-id' => 'type','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    '' => 'Selecciona un tipo',
                                    'radio' => 'Selección única (Compatible con Variantes)',
                                    'checkbox' => 'Selección múltiple (NO Compatible con Variantes)',
                                    'text' => 'Texto libre',
                                    'numeric' => 'Numérico'
                                ]),'selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('type', $variable->type)),'placeholder' => '','x-model' => 'variableType','@change' => 'handleTypeChange()','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('type')),'required' => true]); ?>
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

                            
                            <div x-show="variableType === 'checkbox'" x-cloak class="mt-3">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <div class="flex gap-2">
                                        <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-600 flex-shrink-0"></i>
                                        <div class="text-sm text-yellow-800">
                                            <p class="font-medium">Limitación de Checkbox</p>
                                            <p class="mt-1 text-xs">
                                                Las variables de selección múltiple <strong>no permiten controlar stock por combinaciones</strong> (variantes). 
                                                Úsalas solo para productos simples donde el stock no depende de la combinación.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        
                        <div>
                            <input type="hidden" name="is_required_default" value="0">
                            <label class="flex items-center gap-3">
                                
                                <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'is_required_default','checked' => old('is_required_default', $variable->is_required_default),'value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'is_required_default','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_required_default', $variable->is_required_default)),'value' => '1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $attributes = $__attributesOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $component = $__componentOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__componentOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
                                
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-800">Requerido por defecto</span>
                                    <p class="text-xs text-gray-500">
                                        Esta variable será requerida al crear productos
                                    </p>
                                </div>
                            </label>
                        </div>
                        
                    </div>
                    

                    
                    <div 
                        x-show="variableType === 'numeric'" 
                        x-cloak
                        class="grid grid-cols-1 md:grid-cols-2 gap-6"
                    >
                        
                        <div>
                            <?php if (isset($component)) { $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.TextInput','data' => ['type' => 'number','name' => 'min_value','id' => 'min_value','label' => 'Valor Mínimo','placeholder' => '0.00','value' => old('min_value', $variable->min_value),'step' => '0.01','error' => $errors->first('min_value')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ds.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'min_value','id' => 'min_value','label' => 'Valor Mínimo','placeholder' => '0.00','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('min_value', $variable->min_value)),'step' => '0.01','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('min_value'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $attributes = $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $component = $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
                        </div>
                        

                        
                        <div>
                            <?php if (isset($component)) { $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.TextInput','data' => ['type' => 'number','name' => 'max_value','id' => 'max_value','label' => 'Valor Máximo','placeholder' => '100.00','value' => old('max_value', $variable->max_value),'step' => '0.01','error' => $errors->first('max_value')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ds.text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'max_value','id' => 'max_value','label' => 'Valor Máximo','placeholder' => '100.00','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('max_value', $variable->max_value)),'step' => '0.01','error' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->first('max_value'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $attributes = $__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__attributesOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712)): ?>
<?php $component = $__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712; ?>
<?php unset($__componentOriginal23908c4dcfbc7bed00e0fcf18a7b6712); ?>
<?php endif; ?>
                        </div>
                        
                    </div>
                    

                    
                    <div>
                        <input type="hidden" name="is_active" value="0">
                        <label class="flex items-center gap-3">
                            
                            <?php if (isset($component)) { $__componentOriginal1131acd2b56c97b61455de948c6a2e41 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1131acd2b56c97b61455de948c6a2e41 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Switches.SwitchBasic','data' => ['switchName' => 'is_active','checked' => old('is_active', $variable->is_active),'value' => '1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('switch-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['switch-name' => 'is_active','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_active', $variable->is_active)),'value' => '1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $attributes = $__attributesOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__attributesOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1131acd2b56c97b61455de948c6a2e41)): ?>
<?php $component = $__componentOriginal1131acd2b56c97b61455de948c6a2e41; ?>
<?php unset($__componentOriginal1131acd2b56c97b61455de948c6a2e41); ?>
<?php endif; ?>
                            
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-800">Variable activa</span>
                                <p class="text-xs text-gray-500">
                                    Las variables inactivas no se muestran en la tienda
                                </p>
                            </div>
                        </label>
                    </div>
                    
                </div>
                

                
                <div 
                    x-show="variableType === 'radio' || variableType === 'checkbox'" 
                    x-cloak
                    class="border-t border-gray-200 p-6 space-y-4"
                >
                    
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-800">Opciones de la Variable</h3>
                        
                        <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'plus-circle','size' => 'md','text' => 'Agregar Opción','htmlType' => 'button','@click' => 'addOption()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'plus-circle','size' => 'md','text' => 'Agregar Opción','html-type' => 'button','@click' => 'addOption()']); ?>
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
                    

                    
                    
                    <?php if (isset($component)) { $__componentOriginal41ce05244c62d53131dc2872106fd4c6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal41ce05244c62d53131dc2872106fd4c6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Alerts.AlertSoft','data' => ['type' => 'info','message' => 'Importante: Si planeas usar Variantes (controlar stock por combinaciones), los precios que definas aquí serán ignorados. En ese caso, definirás el precio final directamente en cada variante.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert-soft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','message' => 'Importante: Si planeas usar Variantes (controlar stock por combinaciones), los precios que definas aquí serán ignorados. En ese caso, definirás el precio final directamente en cada variante.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal41ce05244c62d53131dc2872106fd4c6)): ?>
<?php $attributes = $__attributesOriginal41ce05244c62d53131dc2872106fd4c6; ?>
<?php unset($__attributesOriginal41ce05244c62d53131dc2872106fd4c6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal41ce05244c62d53131dc2872106fd4c6)): ?>
<?php $component = $__componentOriginal41ce05244c62d53131dc2872106fd4c6; ?>
<?php unset($__componentOriginal41ce05244c62d53131dc2872106fd4c6); ?>
<?php endif; ?>
                    
                    

                    
                    <div id="optionsContainer" class="space-y-4">
                        <template x-for="(option, index) in options" :key="index">
                            
                            <?php if (isset($component)) { $__componentOriginale7abd09368360b706a1fc8b7cc9ba036 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale7abd09368360b706a1fc8b7cc9ba036 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Cards.CardBase','data' => ['size' => 'md']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('card-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'md']); ?>
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-sm font-semibold text-gray-800" x-text="'Opción ' + (index + 1)"></h4>
                                    <button 
                                        type="button" 
                                        @click="removeOption(index)"
                                        class="inline-flex items-center justify-center text-red-600 hover:text-red-700 transition-colors"
                                        x-show="options.length > 1"
                                    >
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    
                                    <div>
                                        <label :for="'option-name-' + index" class="block text-sm font-medium text-gray-800 mb-2">
                                            Nombre <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            :name="'options[' + index + '][name]'"
                                            :id="'option-name-' + index"
                                            x-model="option.name"
                                            class="py-3 px-4 block w-full rounded-lg border border-gray-200 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none bg-white"
                                            placeholder="Ej: Rojo, Talla M, etc."
                                            required
                                        >
                                    </div>
                                    

                                    
                                    <div>
                                        <label :for="'option-price-' + index" class="block text-sm font-medium text-gray-800 mb-2">
                                            Modificador de Precio
                                        </label>
                                        <input 
                                            type="number" 
                                            :name="'options[' + index + '][price_modifier]'"
                                            :id="'option-price-' + index"
                                            x-model="option.price_modifier"
                                            step="0.01"
                                            class="py-3 px-4 block w-full rounded-lg border border-gray-200 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none bg-white"
                                            placeholder="0.00 (vacío = 0)"
                                        >
                                        <p class="mt-1 text-xs text-gray-500">Solo aplica para productos simples (sin variantes combinadas)</p>
                                    </div>
                                    

                                    
                                    <div>
                                        <label :for="'option-color-' + index" class="block text-sm font-medium text-gray-800 mb-2">
                                            Color (hex)
                                        </label>
                                        <input 
                                            type="text" 
                                            :name="'options[' + index + '][color_hex]'"
                                            :id="'option-color-' + index"
                                            x-model="option.color_hex"
                                            class="py-3 px-4 block w-full rounded-lg border border-gray-200 text-sm text-gray-800 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none bg-white"
                                            placeholder="#FF0000"
                                            maxlength="7"
                                        >
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
                            
                        </template>
                    </div>
                    
                </div>
                

                
                <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t border-gray-200">
                    <div class="flex items-center gap-3">
                        <a href="<?php echo e(route('tenant.admin.variables.index', $store->slug)); ?>">
                            
                            <?php if (isset($component)) { $__componentOriginal04708fbebc5edddfdc2817d72c5db4fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04708fbebc5edddfdc2817d72c5db4fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonBase','data' => ['type' => 'outline','color' => 'error','size' => 'md','text' => 'Cancelar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'error','size' => 'md','text' => 'Cancelar']); ?>
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
                        <?php if($variable->products_count == 0): ?>
                            
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'error','icon' => 'trash-2','size' => 'md','text' => 'Eliminar','htmlType' => 'button','@click' => 'openDeleteModal()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'error','icon' => 'trash-2','size' => 'md','text' => 'Eliminar','html-type' => 'button','@click' => 'openDeleteModal()']); ?>
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
                    
                    <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'dark','icon' => 'check','size' => 'md','text' => 'Actualizar Variable','htmlType' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'dark','icon' => 'check','size' => 'md','text' => 'Actualizar Variable','html-type' => 'submit']); ?>
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
        </form>
        

        
        <?php if($variable->products_count == 0): ?>
            <div 
                x-show="deleteModalOpen" 
                style="display: none;"
                class="fixed inset-0 z-[80] overflow-y-auto"
                role="dialog"
                aria-modal="true"
                aria-labelledby="hs-modal-delete-variable"
            >
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div 
                        x-show="deleteModalOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-gray-800 bg-opacity-50"
                        @click="closeDeleteModal()"
                    ></div>
                    <div 
                        x-show="deleteModalOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="relative bg-white rounded-lg shadow-lg max-w-md w-full p-6"
                        @click.stop
                    >
                        
                        <div class="flex items-center justify-between mb-4">
                            <h3 id="hs-modal-delete-variable" class="text-lg font-semibold text-gray-800">
                                Eliminar Variable
                            </h3>
                            <button 
                                type="button" 
                                class="text-gray-400 hover:text-gray-600"
                                @click="closeDeleteModal()"
                                :disabled="deleteLoading"
                            >
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>
                        

                        
                        <div class="mb-4">
                            <div class="flex gap-4">
                                <div class="shrink-0">
                                    <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800">
                                        Se eliminará la variable <strong>"<?php echo e($variable->name); ?>"</strong> de forma permanente.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Esta acción no se puede deshacer.
                                    </p>
                                    
                                    
                                    <div x-show="deleteError" class="mt-3" x-cloak>
                                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                            <div class="flex">
                                                <div class="shrink-0">
                                                    <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <h3 class="text-sm font-medium">
                                                        Error: <span x-text="deleteError"></span>
                                                    </h3>
                                                </div>
                                                <div class="ps-3 ms-auto">
                                                    <div class="-mx-1.5 -my-1.5">
                                                        <button 
                                                            type="button" 
                                                            class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100" 
                                                            @click="deleteError = null"
                                                        >
                                                            <span class="sr-only">Descartar</span>
                                                            <i data-lucide="x" class="shrink-0 size-4"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        

                        
                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                            <button 
                                type="button" 
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" 
                                @click="closeDeleteModal()"
                                :disabled="deleteLoading"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="button" 
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
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
        <?php endif; ?>
        
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function variableForm() {
            <?php
                // Cargar opciones existentes o valores antiguos
                $oldOptions = old('options', []);
                if (empty($oldOptions) && isset($variable->options)) {
                    $oldOptions = $variable->options->map(function($option) {
                        return [
                            'name' => $option->name,
                            'price_modifier' => $option->price_modifier ?? '',
                            'color_hex' => $option->color_hex ?? ''
                        ];
                    })->toArray();
                }
                $optionsJson = json_encode($oldOptions);
            ?>

            return {
                variableType: <?php echo json_encode(old('type', $variable->type), 512) ?>,
                options: <?php echo $optionsJson; ?>.map(opt => ({
                    name: opt.name || '',
                    price_modifier: opt.price_modifier !== null && opt.price_modifier !== '' ? opt.price_modifier : '',
                    color_hex: opt.color_hex || ''
                })),

                init() {
                    // Inicializar iconos Lucide
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }

                    // Si hay tipo seleccionado y es radio/checkbox, asegurar al menos una opción
                    if ((this.variableType === 'radio' || this.variableType === 'checkbox') && this.options.length === 0) {
                        this.addOption();
                    }
                },

                handleTypeChange() {
                    if (this.variableType === 'radio' || this.variableType === 'checkbox') {
                        if (this.options.length === 0) {
                            this.addOption();
                        }
                    } else {
                        this.options = [];
                    }
                },

                addOption() {
                    this.options.push({
                        name: '',
                        price_modifier: '',
                        color_hex: ''
                    });
                    
                    // Re-inicializar iconos después de agregar opción
                    this.$nextTick(() => {
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    });
                },

                removeOption(index) {
                    if (this.options.length > 1) {
                        this.options.splice(index, 1);
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/variables/edit.blade.php ENDPATH**/ ?>