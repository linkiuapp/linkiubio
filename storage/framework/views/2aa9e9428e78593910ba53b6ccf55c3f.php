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
    <?php $__env->startSection('title', 'Cupones'); ?>

    <?php $__env->startSection('content'); ?>
    
    <?php if (isset($component)) { $__componentOriginal214c6f8b7c938c390f16ac62b88da20d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal214c6f8b7c938c390f16ac62b88da20d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-trigger','data' => ['tour' => 'gestionar_cupones','autoStart' => true,'showButton' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-trigger'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => 'gestionar_cupones','autoStart' => true,'showButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
    
    
    <?php
        $emptyStateSvg = 'base_ui_empty_cupones.svg';
        $emptyStateTitle = 'No hay cupones disponibles';
        $emptyStateMessage = 'Crea tu primer cupón y premia la fidelidad de tus clientes.';

        $statusBadgeMap = [
            'Activo' => 'success',
            'Inactivo' => 'error',
            'Próximo' => 'info',
            'Expirado' => 'error',
            'Agotado' => 'warning',
        ];

        $typeBadgeMap = [
            'percentage' => 'secondary',
            'fixed' => 'info',
            'free_shipping' => 'success',
        ];
    ?>
    

    
    <div
        x-data="couponManagement()"
        x-init="init()"
        class="space-y-4"
    >
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

        
        <?php if(session('coupon_created') || session('coupon_updated') || session('coupon_deleted')): ?>
        <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Usar una clave única para evitar duplicados en la misma carga de página
                <?php if(session('coupon_created')): ?>
                if (!window.couponCreatedToastShown && window.toast) {
                    window.couponCreatedToastShown = true;
                    setTimeout(() => {
                        window.toast.success(
                            'Actualización exitosa',
                            'El cupón se ha creado correctamente.',
                            5000,
                            'bottom-center'
                        );
                    }, 300);
                }
                <?php endif; ?>

                <?php if(session('coupon_updated')): ?>
                if (!window.couponUpdatedToastShown && window.toast) {
                    window.couponUpdatedToastShown = true;
                    setTimeout(() => {
                        window.toast.success(
                            'Actualización exitosa',
                            'El cupón se ha actualizado correctamente.',
                            5000,
                            'bottom-center'
                        );
                    }, 300);
                }
                <?php endif; ?>

                <?php if(session('coupon_deleted')): ?>
                if (!window.couponDeletedToastShown && window.toast) {
                    window.couponDeletedToastShown = true;
                    setTimeout(() => {
                        window.toast.success(
                            'Actualización exitosa',
                            'El cupón se ha eliminado correctamente.',
                            5000,
                            'bottom-center'
                        );
                    }, 300);
                }
                <?php endif; ?>
            });
        </script>
        <?php $__env->stopPush(); ?>
        <?php endif; ?>

        
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Cupones</h2>
                        <p class="text-sm text-gray-600">
                            Usando <?php echo e($currentCount); ?> de <?php echo e($maxCoupons); ?> cupones disponibles en tu plan <?php echo e($store->plan->name); ?>

                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <?php if($remainingSlots > 0): ?>
                            <a href="<?php echo e(route('tenant.admin.coupons.create', ['store' => $store->slug])); ?>" data-tour="coupon-button">
                                <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Nuevo cupón']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'solid','color' => 'info','size' => 'md','icon' => 'plus-circle','text' => 'Nuevo cupón']); ?>
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
                            </a>
                        <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginal30e169a586a2bd405d6a25d5afef85c0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal30e169a586a2bd405d6a25d5afef85c0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Buttons.ButtonIcon','data' => ['type' => 'outline','color' => 'secondary','size' => 'md','icon' => 'plus-circle','text' => 'Límite alcanzado','disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'outline','color' => 'secondary','size' => 'md','icon' => 'plus-circle','text' => 'Límite alcanzado','disabled' => true]); ?>
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
                </div>
            </div>
            

            
            <div class="px-6 py-3 bg-gray-50" x-data="couponFilters()">
                <form id="coupon-filters-form" method="GET">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-72">
                                <?php if (isset($component)) { $__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Inputs.InputWithIcon','data' => ['icon' => 'search','name' => 'search','placeholder' => 'Buscar por nombre o código...','xModel' => 'form.search','xOn:keyup.debounce.500' => 'submitFilters()','xOn:keydown.enter.prevent' => 'submitFilters()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-with-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'search','name' => 'search','placeholder' => 'Buscar por nombre o código...','x-model' => 'form.search','x-on:keyup.debounce.500' => 'submitFilters()','x-on:keydown.enter.prevent' => 'submitFilters()']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34)): ?>
<?php $attributes = $__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34; ?>
<?php unset($__attributesOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34)): ?>
<?php $component = $__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34; ?>
<?php unset($__componentOriginal0dbd7e7f78f35b7c9a4ea8d840ba2e34); ?>
<?php endif; ?>
                            </div>

                            <div class="w-48">
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'status','selectId' => 'coupon-status-filter','selected' => request('status'),'options' => [
                                    '' => 'Todos los estados',
                                    'active' => 'Activos',
                                    'inactive' => 'Inactivos',
                                    'expired' => 'Expirados',
                                    'upcoming' => 'Próximos',
                                ],'placeholder' => 'Filtrar por estado','class' => 'w-48','xModel' => 'form.status','xOn:change' => 'submitFilters()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'status','select-id' => 'coupon-status-filter','selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('status')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                    '' => 'Todos los estados',
                                    'active' => 'Activos',
                                    'inactive' => 'Inactivos',
                                    'expired' => 'Expirados',
                                    'upcoming' => 'Próximos',
                                ]),'placeholder' => 'Filtrar por estado','class' => 'w-48','x-model' => 'form.status','x-on:change' => 'submitFilters()']); ?>
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
                            </div>

                            <div class="w-48">
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'type','selectId' => 'coupon-type-filter','selected' => request('type'),'options' => collect(\App\Features\TenantAdmin\Models\Coupon::TYPES)->toArray(),'placeholder' => 'Filtrar por tipo','class' => 'w-56','xModel' => 'form.type','xOn:change' => 'submitFilters()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'type','select-id' => 'coupon-type-filter','selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('type')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(collect(\App\Features\TenantAdmin\Models\Coupon::TYPES)->toArray()),'placeholder' => 'Filtrar por tipo','class' => 'w-56','x-model' => 'form.type','x-on:change' => 'submitFilters()']); ?>
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
                            </div>

                            <div class="w-48">
                            <?php if (isset($component)) { $__componentOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcd4a0d97450f8b684ae88c84a2f25b81 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'design-system::Selects.SelectBasic','data' => ['name' => 'discount_type','selectId' => 'coupon-discount-filter','selected' => request('discount_type'),'options' => collect(\App\Features\TenantAdmin\Models\Coupon::DISCOUNT_TYPES)->toArray(),'placeholder' => 'Filtrar por descuento','class' => 'w-56','xModel' => 'form.discountType','xOn:change' => 'submitFilters()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('select-basic'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'discount_type','select-id' => 'coupon-discount-filter','selected' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('discount_type')),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(collect(\App\Features\TenantAdmin\Models\Coupon::DISCOUNT_TYPES)->toArray()),'placeholder' => 'Filtrar por descuento','class' => 'w-56','x-model' => 'form.discountType','x-on:change' => 'submitFilters()']); ?>
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
                            </div>
                            <button type="submit" class="sr-only">Filtrar</button>

                            <?php if(request()->hasAny(['search', 'status', 'type', 'discount_type'])): ?>
                                <button
                                    type="button"
                                    class="py-2 px-3 text-sm font-medium text-gray-600 hover:text-blue-600"
                                    x-on:click="clearFilters()"
                                >
                                    Limpiar filtros
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="text-sm text-gray-600">
                            Mostrando <span data-coupon-count="<?php echo e($coupons->count()); ?>"><?php echo e($coupons->count()); ?></span> cupones
                        </div>
                    </div>

                </form>
            </div>
            

            
            <div class="space-y-6">
                <?php echo $__env->make('tenant-admin::Core/coupons/components/table-view', [
                    'coupons' => $coupons,
                    'store' => $store,
                    'statusBadgeMap' => $statusBadgeMap,
                    'typeBadgeMap' => $typeBadgeMap,
                    'emptyStateSvg' => $emptyStateSvg,
                    'emptyStateTitle' => $emptyStateTitle,
                    'emptyStateMessage' => $emptyStateMessage,
                    'remainingSlots' => $remainingSlots,
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <?php if($coupons->hasPages()): ?>
                    <div class="border-t border-gray-200 pt-4">
                        <?php echo e($coupons->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
            
        </div>
        

        
        <div
            x-data="couponDeleteModalData()"
            x-on:keydown.escape.window="closeModal()"
            @delete-coupon.window="openModal($event.detail.id, $event.detail.name, $event.detail.url, $event.detail.rowElement)"
        >
            
            <div
                x-show="open"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
                @click="closeModal()"
                style="display: none;"
            ></div>

            
            <div
                x-show="open"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
                role="dialog"
                tabindex="-1"
                aria-labelledby="delete-coupon-modal-label"
                style="display: none;"
            >
                <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                    <div
                        @click.stop
                        class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                    >
                        
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <h3 id="delete-coupon-modal-label" class="font-bold text-gray-800">
                                ¿Eliminar cupón?
                            </h3>
                            <button
                                type="button"
                                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                                aria-label="Cerrar"
                                @click="closeModal()"
                                :disabled="loading"
                            >
                                <span class="sr-only">Cerrar</span>
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
                                <div class="flex-1 text-sm text-gray-700">
                                    <p>
                                        Se eliminará el cupón <strong>"<span x-text="couponName"></span>"</strong> de forma permanente.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Esta acción no se puede deshacer.
                                    </p>

                                    <div x-show="error" class="mt-3" x-cloak>
                                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                            <div class="flex">
                                                <div class="shrink-0">
                                                    <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <h3 class="text-sm font-medium">
                                                        Error: <span x-text="error"></span>
                                                    </h3>
                                                </div>
                                                <div class="ps-3 ms-auto">
                                                    <div class="-mx-1.5 -my-1.5">
                                                        <button
                                                            type="button"
                                                            class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100"
                                                            @click="error = null"
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
                                @click="closeModal()"
                                :disabled="loading"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                                @click="confirmDelete()"
                                :disabled="loading"
                            >
                                <span x-show="!loading">Sí, eliminar</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <i data-lucide="loader" class="size-4 animate-spin"></i>
                                    Eliminando...
                                </span>
                            </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    

    <?php $__env->startPush('scripts'); ?>
    <script>
        function couponManagement() {
            return {
                couponUrl: '',

                init() {
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }

                    window.addEventListener('coupon-delete-success', (event) => {
                        const message = event.detail?.message || 'El cupón se ha eliminado correctamente.';
                        if (window.toast) {
                            window.toast.success(
                                'Actualización exitosa',
                                message,
                                5000,
                                'bottom-center'
                            );
                        }
                    });

                    window.addEventListener('coupon-delete-error', (event) => {
                        const message = event.detail?.message || 'No pudimos eliminar el cupón.';
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                message,
                                5000,
                                'bottom-center'
                            );
                        }
                    });

                    window.addEventListener('coupons-check-empty', () => {
                        this.checkAndShowEmptyState();
                    });
                },

                deleteCoupon(coupon, event) {
                    const rowElement = event.target.closest('tr');
                    window.dispatchEvent(new CustomEvent('delete-coupon', {
                        detail: {
                            id: coupon.id,
                            name: coupon.name,
                            url: coupon.url,
                            rowElement
                        }
                    }));
                },

                checkAndShowEmptyState() {
                    const rows = document.querySelectorAll('tr[data-coupon-id]');
                    const emptyStateRow = document.getElementById('coupons-empty-state');
                    if (rows.length === 0 && emptyStateRow) {
                        emptyStateRow.classList.remove('hidden');
                    }

                    const countElement = document.querySelector('[data-coupon-count]');
                    if (countElement) {
                        countElement.textContent = rows.length;
                    }
                }
            };
        }

        function couponFilters() {
            return {
                form: {
                    search: <?php echo \Illuminate\Support\Js::from(request('search', ''))->toHtml() ?>,
                    status: <?php echo \Illuminate\Support\Js::from(request('status', ''))->toHtml() ?>,
                    type: <?php echo \Illuminate\Support\Js::from(request('type', ''))->toHtml() ?>,
                    discountType: <?php echo \Illuminate\Support\Js::from(request('discount_type', ''))->toHtml() ?>,
                },
                submitFilters() {
                    const form = document.getElementById('coupon-filters-form');
                    if (form) {
                        form.requestSubmit();
                    }
                },
                clearFilters() {
                    this.form.search = '';
                    this.form.status = '';
                    this.form.type = '';
                    this.form.discountType = '';
                    const url = new URL(window.location.href);
                    ['search', 'status', 'type', 'discount_type'].forEach(param => url.searchParams.delete(param));
                    window.location.href = url.toString();
                }
            };
        }

        function couponDeleteModalData() {
            return {
                open: false,
                couponId: null,
                couponName: '',
                couponUrl: '',
                couponRow: null,
                loading: false,
                error: null,

                openModal(id, name, url, rowElement) {
                    this.couponId = id;
                    this.couponName = name;
                     this.couponUrl = url;
                    this.couponRow = rowElement;
                    this.error = null;
                    this.open = true;
                    this.$nextTick(() => {
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    });
                },

                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.couponId = null;
                        this.couponName = '';
                        this.couponUrl = '';
                        this.couponRow = null;
                        this.error = null;
                    }
                },

                async confirmDelete() {
                    if (!this.couponId) {
                        return;
                    }

                    this.loading = true;
                    this.error = null;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        const response = await fetch(this.couponUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                        });

                        let data = null;
                        try {
                            data = await response.json();
                        } catch (e) {
                            // Ignorar si no hay JSON
                        }

                        if (!response.ok) {
                            throw new Error(data?.message || data?.error || 'Error al eliminar el cupón');
                        }

                        this.loading = false;

                        const rowToDelete = this.couponRow;
                        const couponName = this.couponName;

                        this.closeModal();

                        if (rowToDelete && rowToDelete.parentNode) {
                            rowToDelete.style.transition = 'opacity 0.3s ease-out';
                            rowToDelete.style.opacity = '0';
                            setTimeout(() => {
                                if (rowToDelete.parentNode) {
                                    rowToDelete.remove();
                                }

                                window.dispatchEvent(new CustomEvent('coupon-delete-success', {
                                    detail: {
                                        message: `El cupón "${couponName}" se eliminó correctamente.`
                                    }
                                }));

                                window.dispatchEvent(new CustomEvent('coupons-check-empty'));
                            }, 300);
                        } else {
                            window.dispatchEvent(new CustomEvent('coupon-delete-success', {
                                detail: {
                                    message: `El cupón "${couponName}" se eliminó correctamente.`
                                }
                            }));
                            window.location.reload();
                        }
                    } catch (error) {
                        const message = error?.message || 'Error al eliminar el cupón';
                        this.error = message;
                        this.loading = false;
                        window.dispatchEvent(new CustomEvent('coupon-delete-error', {
                            detail: { message }
                        }));
                    }
                },
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
<?php endif; ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/coupons/index.blade.php ENDPATH**/ ?>