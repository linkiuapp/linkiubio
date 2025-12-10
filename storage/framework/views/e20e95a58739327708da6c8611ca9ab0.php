<?php $__env->startSection('title', 'Gestión de Planes'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Gestión de Planes</h1>
            <p class="text-sm text-gray-600 mt-1">Administra los planes de suscripción disponibles</p>
        </div>
        <a href="<?php echo e(route('superlinkiu.plans.create')); ?>" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nuevo Plan
        </a>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden <?php echo e($plan->is_featured ? 'ring-2 ring-blue-500' : ''); ?>">
                
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-br from-gray-50 to-white relative">
                    <?php if($plan->is_featured): ?>
                        <span class="absolute top-3 right-3 px-2 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                            POPULAR
                        </span>
                    <?php endif; ?>
                    <h2 class="text-lg font-semibold text-gray-900 mb-1"><?php echo e($plan->name); ?></h2>
                    <p class="text-sm text-gray-600 line-clamp-2"><?php echo e($plan->description ?: 'Sin descripción'); ?></p>
                    <div class="mt-3">
                        <span class="text-2xl font-bold text-blue-600">
                            <?php echo e($plan->getFormattedPriceForPeriod('monthly')); ?>

                        </span>
                        <span class="text-sm text-gray-600">/mes</span>
                    </div>
                </div>

                
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-800 mb-3">Características incluidas:</h3>
                    <?php
                        $features = $plan->features_list;
                        if (is_string($features)) {
                            $features = json_decode($features, true) ?: [];
                        }
                        $features = is_array($features) ? $features : [];
                    ?>
                    <?php if($features && count($features) > 0): ?>
                        <ul class="space-y-2 mb-4">
                            <?php $__currentLoopData = array_slice($features, 0, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-start text-sm text-gray-700">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-green-600 mr-2 flex-shrink-0 mt-0.5"></i>
                                    <?php echo e($feature); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count($features) > 5): ?>
                                <li class="text-sm text-blue-600 font-medium">
                                    Y <?php echo e(count($features) - 5); ?> más...
                                </li>
                            <?php endif; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 italic">Sin características definidas</p>
                    <?php endif; ?>

                    
                    <?php if($plan->prices): ?>
                        <div class="border-t border-gray-200 pt-4 mb-4">
                            <p class="text-xs font-medium text-gray-700 mb-2">Precios por período:</p>
                            <div class="space-y-1.5">
                                <?php $__currentLoopData = ['quarterly' => ['label' => 'Trimestral', 'months' => 3], 'semester' => ['label' => 'Semestral', 'months' => 6], 'annual' => ['label' => 'Anual', 'months' => 12]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(isset($plan->prices[$period]) && $plan->prices[$period] > 0): ?>
                                        <?php
                                            $monthlyTotal = $plan->price * $info['months'];
                                            $periodPrice = $plan->prices[$period];
                                            $discount = $monthlyTotal > $periodPrice ? round((($monthlyTotal - $periodPrice) / $monthlyTotal) * 100) : 0;
                                        ?>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-gray-600"><?php echo e($info['label']); ?>:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="text-gray-900 font-medium">
                                                    $<?php echo e(number_format($periodPrice, 0, ',', '.')); ?>

                                                </span>
                                                <?php if($discount > 0): ?>
                                                    <span class="px-1.5 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded">-<?php echo e($discount); ?>%</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="flex flex-col">
                            <span class="text-gray-600 mb-1">Estado:</span>
                            <?php if($plan->is_active): ?>
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-full w-fit">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i>
                                    Activo
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-50 text-red-700 text-xs font-medium rounded-full w-fit">
                                    <i data-lucide="x-circle" class="w-3 h-3"></i>
                                    Inactivo
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-600 mb-1">Tiendas:</span>
                            <span class="text-gray-900 font-semibold"><?php echo e($plan->stores_count ?? 0); ?></span>
                        </div>
                    </div>
                </div>

                
                <div class="border-t border-gray-200 bg-gray-50 px-6 py-3">
                    <div class="flex gap-2">
                        <a href="<?php echo e(route('superlinkiu.plans.show', $plan)); ?>"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 py-2 rounded-lg transition-colors text-sm font-medium">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            Ver
                        </a>
                        <a href="<?php echo e(route('superlinkiu.plans.edit', $plan)); ?>"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg transition-colors text-sm font-medium">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                            Editar
                        </a>
                        <?php if(!$plan->hasActiveStores()): ?>
                            <button type="button"
                                onclick="deletePlan(<?php echo e($plan->id); ?>, '<?php echo e($plan->name); ?>')"
                                class="flex-1 inline-flex items-center justify-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 py-2 rounded-lg transition-colors text-sm font-medium">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                Eliminar
                            </button>
                        <?php else: ?>
                            <div class="flex-1 inline-flex items-center justify-center gap-1.5 bg-gray-100 text-gray-400 py-2 rounded-lg text-sm font-medium cursor-not-allowed" title="No se puede eliminar un plan con tiendas activas">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                                Bloqueado
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full bg-white rounded-lg border border-gray-200 shadow-sm p-12 text-center">
                <i data-lucide="package-x" class="w-16 h-16 mx-auto mb-4 text-gray-400"></i>
                <p class="text-gray-600 text-lg font-medium mb-2">No hay planes registrados</p>
                <p class="text-gray-500 text-sm mb-4">Crea tu primer plan de suscripción</p>
                <a href="<?php echo e(route('superlinkiu.plans.create')); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Crear Primer Plan
                </a>
            </div>
        <?php endif; ?>
    </div>

    
    <?php if($plans->hasPages()): ?>
    <div class="mt-6 flex justify-center">
        <?php echo e($plans->links()); ?>

    </div>
    <?php endif; ?>

    
    <div 
        x-data="deleteModalData()"
        x-on:keydown.escape.window="closeModal()"
        @delete-plan.window="openModal($event.detail.id, $event.detail.name)"
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
            x-cloak
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
            aria-labelledby="delete-modal-label"
            style="display: none;"
            x-cloak
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 id="delete-modal-label" class="font-bold text-gray-800">
                            ¿Eliminar plan?
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
                            <div class="flex-1">
                                <p class="text-gray-800">
                                    Se eliminará el plan <strong>"<span x-text="planName"></span>"</strong> de forma permanente.
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Mostrar toast de éxito si hay mensaje
<?php if(session('success')): ?>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.success(
            '¡Hey! felicidades',
            '<?php echo e(session('success')); ?>',
            5000,
            'bottom-center'
        );
    }
});
<?php endif; ?>

// Mostrar toast de error si hay mensaje
<?php if(session('error')): ?>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.error(
            '¡Ups! algo salió mal',
            '<?php echo e(session('error')); ?>',
            5000,
            'bottom-center'
        );
    }
});
<?php endif; ?>

// Función para abrir modal de eliminación
function deletePlan(planId, planName) {
    window.dispatchEvent(new CustomEvent('delete-plan', {
        detail: { id: planId, name: planName }
    }));
}

// Modal de eliminación de plan (igual que productos)
function deleteModalData() {
    return {
        open: false,
        loading: false,
        error: null,
        planId: null,
        planName: '',
        
        openModal(id, name) {
            this.planId = id;
            this.planName = name;
            this.error = null;
            this.open = true;
            
            // Reinicializar iconos cuando se abre el modal
            this.$nextTick(() => {
                if (window.createIcons && window.lucideIcons) {
                    window.createIcons({ icons: window.lucideIcons });
                }
            });
        },
        
        closeModal() {
            if (this.loading) return;
            this.open = false;
            this.error = null;
            this.planId = null;
            this.planName = '';
        },
        
        async confirmDelete() {
            if (!this.planId || this.loading) return;
            
            this.loading = true;
            this.error = null;
            
            try {
                const response = await fetch(`/superlinkiu/plans/${this.planId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.error || 'Error al eliminar el plan');
                }
                
                if (data.error) {
                    throw new Error(data.error);
                }
                
                this.loading = false;
                
                const planName = this.planName;
                
                this.closeModal();
                
                // Mostrar toast y recargar
                if (window.toast) {
                    window.toast.success(
                        '¡Hey! felicidades',
                        `Plan "${planName}" eliminado exitosamente`,
                        5000,
                        'bottom-center'
                    );
                }
                
                // Recargar después del toast
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
                
            } catch (error) {
                this.error = error.message || 'Error al eliminar el plan';
                this.loading = false;
            }
        }
    };
}

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
<?php $__env->stopPush(); ?> 
<?php echo $__env->make('shared::layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/plans/index.blade.php ENDPATH**/ ?>