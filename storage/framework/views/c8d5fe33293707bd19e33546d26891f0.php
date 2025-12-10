<?php $__env->startSection('title', 'Categorías de Negocio'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="categoryManager">
    
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Categorías de Negocio</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona las categorías y configura la aprobación automática</p>
        </div>
        <div class="flex gap-3">
            <?php
                $categoriesWithoutVertical = \App\Shared\Models\BusinessCategory::withoutVertical()->count();
            ?>
            <?php if($categoriesWithoutVertical > 0): ?>
                <a href="<?php echo e(route('superlinkiu.business-categories.migrate-verticals')); ?>" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                    Migrar Verticales
                    <span class="bg-white text-yellow-800 text-xs px-2 py-0.5 rounded-full font-bold"><?php echo e($categoriesWithoutVertical); ?></span>
                </a>
            <?php endif; ?>
            <button @click="openCreateModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Nueva Categoría
            </button>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Total</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e($categories->total()); ?></p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i data-lucide="layers" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Auto-Aprobación</p>
                    <p class="text-2xl font-bold text-green-600"><?php echo e($categories->where('requires_manual_approval', false)->where('is_active', true)->count()); ?></p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Revisión Manual</p>
                    <p class="text-2xl font-bold text-yellow-600"><?php echo e($categories->where('requires_manual_approval', true)->where('is_active', true)->count()); ?></p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i data-lucide="eye" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600 uppercase">Inactivas</p>
                    <p class="text-2xl font-bold text-gray-600"><?php echo e($categories->where('is_active', false)->count()); ?></p>
                </div>
                <div class="p-3 bg-gray-100 rounded-lg">
                    <i data-lucide="x-circle" class="w-6 h-6 text-gray-600"></i>
                </div>
            </div>
        </div>
    </div>

    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-gray-900">Todas las Categorías</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vertical</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aprobación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiendas</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50" :data-id="<?php echo e($category->id); ?>">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($category->name); ?></div>
                                    <?php if($category->description): ?>
                                        <div class="text-xs text-gray-500"><?php echo e(Str::limit($category->description, 60)); ?></div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($category->vertical): ?>
                                    <?php
                                        $verticalNames = [
                                            'ecommerce' => 'Ecommerce',
                                            'restaurant' => 'Restaurante',
                                            'hotel' => 'Hotel',
                                            'dropshipping' => 'Dropshipping'
                                        ];
                                        $verticalColors = [
                                            'ecommerce' => 'bg-blue-100 text-blue-800',
                                            'restaurant' => 'bg-orange-100 text-orange-800',
                                            'hotel' => 'bg-purple-100 text-purple-800',
                                            'dropshipping' => 'bg-green-100 text-green-800'
                                        ];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold <?php echo e($verticalColors[$category->vertical] ?? 'bg-gray-100 text-gray-800'); ?>">
                                        <?php echo e($verticalNames[$category->vertical] ?? $category->vertical); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                        Sin asignar
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($category->requires_manual_approval): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        <i data-lucide="eye" class="w-3 h-3 mr-1"></i>
                                        Revisión Manual
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                        Auto-Aprobación
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button type="button" 
                                        @click="toggleStatus(<?php echo e($category->id); ?>, <?php echo e($category->is_active ? 'true' : 'false'); ?>)"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors <?php echo e($category->is_active ? 'bg-blue-600' : 'bg-gray-300'); ?>"
                                        :class="{'bg-blue-600': categoryStates[<?php echo e($category->id); ?>], 'bg-gray-300': !categoryStates[<?php echo e($category->id); ?>]}">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform <?php echo e($category->is_active ? 'translate-x-6' : 'translate-x-1'); ?>"
                                          :class="{'translate-x-6': categoryStates[<?php echo e($category->id); ?>], 'translate-x-1': !categoryStates[<?php echo e($category->id); ?>]}"></span>
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                <?php echo e($category->stores_count ?? 0); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button @click="openEditModal(<?php echo \Illuminate\Support\Js::from(['id' => $category->id, 'name' => $category->name, 'icon' => $category->icon, 'description' => $category->description, 'vertical' => $category->vertical, 'requires_manual_approval' => $category->requires_manual_approval, 'is_active' => $category->is_active, 'features' => $category->feature_ids])->toHtml() ?>)" 
                                        class="text-blue-600 hover:text-blue-800 mr-3">
                                    <i data-lucide="edit-2" class="w-4 h-4 inline"></i>
                                </button>
                                <button @click="$dispatch('delete-category', {id: <?php echo e($category->id); ?>, name: '<?php echo e(addslashes($category->name)); ?>'})"
                                        class="text-red-600 hover:text-red-800">
                                    <i data-lucide="trash-2" class="w-4 h-4 inline"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i data-lucide="folder-open" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                                <p class="text-lg">No hay categorías registradas</p>
                                <button @click="openCreateModal()" class="mt-4 text-blue-600 hover:text-blue-800">
                                    Crear primera categoría
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if($categories->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($categories->links()); ?>

        </div>
        <?php endif; ?>
    </div>

    
    <div x-show="showModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity" 
                 aria-hidden="true"
                 @click="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <form :action="isEditing ? `/superlinkiu/business-categories/${editingId}` : '<?php echo e(route('superlinkiu.business-categories.store')); ?>'" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="_method" x-bind:value="isEditing ? 'PUT' : 'POST'">
                    
                    <div class="bg-white px-6 py-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <i :data-lucide="isEditing ? 'edit' : 'plus'" class="w-5 h-5 text-blue-600"></i>
                            <span x-text="isEditing ? 'Editar Categoría' : 'Nueva Categoría'"></span>
                        </h3>
                        
                        <div class="space-y-4">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                                <input type="text" name="name" x-model="form.name" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <textarea name="description" x-model="form.description" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>

                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Vertical <span class="text-red-500">*</span></label>
                                <select name="vertical" x-model="form.vertical" @change="onVerticalChange()" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecciona un vertical</option>
                                    <option value="ecommerce">Ecommerce</option>
                                    <option value="restaurant">Restaurante</option>
                                    <option value="hotel">Hotel</option>
                                    <option value="dropshipping">Dropshipping</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">
                                    Los features se asignarán automáticamente según el vertical.
                                </p>
                            </div>

                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Aprobación <span class="text-red-500">*</span></label>
                                <div class="space-y-2">
                                    <label class="flex items-start p-3 border-2 rounded-lg cursor-pointer transition-all" 
                                           :class="form.requires_manual_approval === '0' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300'">
                                        <input type="radio" name="requires_manual_approval" value="0" x-model="form.requires_manual_approval" class="mt-1 mr-3">
                                        <div>
                                            <span class="font-medium text-gray-900 flex items-center gap-1.5">
                                                <i data-lucide="zap" class="w-4 h-4 text-green-600"></i>
                                                Auto-Aprobación
                                            </span>
                                            <p class="text-xs text-gray-600 mt-0.5">Aprobar automáticamente si el documento es válido</p>
                                        </div>
                                    </label>
                                    <label class="flex items-start p-3 border-2 rounded-lg cursor-pointer transition-all"
                                           :class="form.requires_manual_approval === '1' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-gray-300'">
                                        <input type="radio" name="requires_manual_approval" value="1" x-model="form.requires_manual_approval" class="mt-1 mr-3">
                                        <div>
                                            <span class="font-medium text-gray-900 flex items-center gap-1.5">
                                                <i data-lucide="shield-check" class="w-4 h-4 text-yellow-600"></i>
                                                Revisión Manual
                                            </span>
                                            <p class="text-xs text-gray-600 mt-0.5">Requiere aprobación del SuperAdmin</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            
                            <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                <input type="checkbox" name="is_active" value="1" x-model="form.is_active" 
                                       class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500" 
                                       id="is_active">
                                <label for="is_active" class="flex-1 cursor-pointer">
                                    <span class="block text-sm font-medium text-gray-900">Categoría activa</span>
                                    <span class="block text-xs text-gray-600">Visible para nuevos registros</span>
                                </label>
                            </div>

                            
                            <div x-show="form.vertical" class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded">
                                <div class="flex items-start gap-2">
                                    <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                                    <div>
                                        <p class="text-sm font-medium text-blue-900">Features asignados automáticamente</p>
                                        <p class="text-xs text-blue-700 mt-1">
                                            Los features del vertical "<span x-text="getVerticalName(form.vertical)" class="font-semibold"></span>" se asignarán automáticamente.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                        <button type="button" @click="closeModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span x-text="isEditing ? 'Actualizar' : 'Crear'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div x-show="open" 
         x-cloak
         x-on:delete-category.window="openModal($event.detail.id, $event.detail.name)"
         x-on:keydown.escape.window="closeModal()"
         x-data="deleteModalData()"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeModal()"
             class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        </div>

        
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="fixed inset-0 z-10 overflow-x-hidden overflow-y-auto pointer-events-none">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg pointer-events-auto">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                    Eliminar Categoría
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Estás seguro de que deseas eliminar la categoría <span class="font-semibold text-gray-900" x-text="categoryName"></span>?
                                        Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <button type="button" 
                                @click="confirmDelete()"
                                :disabled="loading"
                                class="inline-flex w-full justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 disabled:opacity-50 sm:w-auto">
                            <span x-show="!loading">Sí, eliminar</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Eliminando...
                            </span>
                        </button>
                        <button type="button" 
                                @click="closeModal()"
                                :disabled="loading"
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:opacity-50 sm:mt-0 sm:w-auto">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php if(session('success')): ?>
<script>
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
</script>
<?php endif; ?>


<?php if(session('error')): ?>
<script>
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
</script>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('categoryManager', () => ({
        showModal: false,
        isEditing: false,
        editingId: null,
        categoryStates: <?php echo json_encode($categories->pluck('is_active', 'id')->toArray(), 512) ?>,
        availableFeatures: <?php echo json_encode($features ?? [], 15, 512) ?>,
        verticals: <?php echo json_encode(config('verticals'), 15, 512) ?>,
        form: {
            name: '',
            icon: '',
            description: '',
            vertical: '',
            requires_manual_approval: '1',
            is_active: true,
            features: []
        },

        openCreateModal() {
            this.isEditing = false;
            this.editingId = null;
            
            const defaultFeatureIds = this.availableFeatures
                .filter(f => f.is_default)
                .map(f => f.id);
            
            this.form = {
                name: '',
                icon: '',
                description: '',
                vertical: '',
                requires_manual_approval: '1',
                is_active: true,
                features: defaultFeatureIds
            };
            this.showModal = true;
            
            this.$nextTick(() => {
                if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
            });
        },

        openEditModal(category) {
            this.isEditing = true;
            this.editingId = category.id;
            this.form = {
                name: category.name,
                icon: category.icon || '',
                description: category.description || '',
                vertical: category.vertical || '',
                requires_manual_approval: category.requires_manual_approval ? '1' : '0',
                is_active: category.is_active,
                features: category.features || []
            };
            this.showModal = true;
            
            this.$nextTick(() => {
                if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
            });
        },

        closeModal() {
            this.showModal = false;
        },

        onVerticalChange() {
            // Features se asignarán automáticamente en el backend
        },

        getVerticalName(vertical) {
            const names = {
                'ecommerce': 'Ecommerce',
                'restaurant': 'Restaurante',
                'hotel': 'Hotel',
                'dropshipping': 'Dropshipping'
            };
            return names[vertical] || vertical;
        },

        async toggleStatus(categoryId, currentStatus) {
            try {
                const response = await fetch(`/superlinkiu/business-categories/${categoryId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.categoryStates[categoryId] = data.is_active;
                    
                    if (window.toast) {
                        window.toast.success(
                            '¡Estado actualizado!',
                            data.message,
                            3000,
                            'bottom-center'
                        );
                    }
                } else {
                    throw new Error(data.message || 'Error al cambiar el estado');
                }
            } catch (error) {
                console.error('Error:', error);
                if (window.toast) {
                    window.toast.error(
                        '¡Ups! algo salió mal',
                        'Error al cambiar el estado de la categoría',
                        3000,
                        'bottom-center'
                    );
                }
            }
        }
    }));

    // Modal de eliminación
    Alpine.data('deleteModalData', () => ({
        open: false,
        categoryId: null,
        categoryName: '',
        loading: false,

        openModal(id, name) {
            this.categoryId = id;
            this.categoryName = name;
            this.open = true;
            this.loading = false;
            
            this.$nextTick(() => {
                if (window.createIcons) window.createIcons({ icons: window.lucideIcons });
            });
        },

        closeModal() {
            if (this.loading) return;
            this.open = false;
            this.categoryId = null;
            this.categoryName = '';
        },

        async confirmDelete() {
            if (!this.categoryId) return;
            
            this.loading = true;
            
            try {
                const response = await fetch(`/superlinkiu/business-categories/${this.categoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                });

                const data = await response.json();
                
                if (!response.ok) {
                    // Cerrar modal y mostrar toast de error
                    this.loading = false;
                    const categoryName = this.categoryName;
                    this.closeModal();
                    
                    if (window.toast) {
                        window.toast.error(
                            '¡Ups! algo salió mal',
                            data.message || 'Error al eliminar la categoría',
                            5000,
                            'bottom-center'
                        );
                    }
                    return;
                }
                
                this.loading = false;
                const categoryName = this.categoryName;
                this.closeModal();
                
                // Remover la fila con animación
                const row = document.querySelector(`tr[data-id="${this.categoryId}"]`);
                if (row) {
                    row.style.transition = 'opacity 0.3s ease-out';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        if (row.parentNode) {
                            row.remove();
                            
                            if (window.toast) {
                                window.toast.success(
                                    '¡Hey! felicidades',
                                    `Categoría "${categoryName}" eliminada exitosamente`,
                                    5000,
                                    'bottom-center'
                                );
                            }
                        }
                    }, 300);
                } else {
                    window.location.reload();
                }
            } catch (error) {
                // Cerrar modal y mostrar toast de error
                this.loading = false;
                const categoryName = this.categoryName;
                this.closeModal();
                
                if (window.toast) {
                    window.toast.error(
                        '¡Ups! algo salió mal',
                        error.message || 'Error al eliminar la categoría',
                        5000,
                        'bottom-center'
                    );
                }
            }
        }
    }));
});

// Inicializar iconos Lucide
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
<?php $__env->stopPush(); ?>

<style>
[x-cloak] { display: none !important; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shared::layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Liniu_Final\app\Features\SuperLinkiu/Views/business-categories/index.blade.php ENDPATH**/ ?>