

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
    <?php $__env->startSection('title', 'Editar Categoría'); ?>

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
                    const categoryId = '<?php echo e($category->id); ?>';
                    const response = await fetch('/' + storeSlug + '/admin/categories/' + categoryId, {
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
                        throw new Error(data.error || 'Error al eliminar la categoría');
                    }

                    if (data.error) {
                        throw new Error(data.error);
                    }

                    this.deleteLoading = false;
                    this.closeDeleteModal();
                    
                    window.location.href = '/' + storeSlug + '/admin/categories';
                } catch (error) {
                    this.deleteError = error.message || 'Error al eliminar la categoría';
                    this.deleteLoading = false;
                }
            }
        }"
        x-on:keydown.escape.window="closeDeleteModal()"
        class="max-w-7xl mx-auto space-y-6"
    >
        
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('tenant.admin.categories.index', $store->slug)); ?>" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-bold text-gray-800">Editar Categoría</h1>
        </div>
        

        
        <div class="bg-blue-50 border border-blue-200 text-blue-800 text-sm rounded-lg px-4 py-3" role="alert">
            Estás usando <strong><?php echo e($totalCategories); ?> de <?php echo e($categoryLimit); ?></strong> categorías disponibles en tu plan <?php echo e(e($store->plan->name)); ?>.
        </div>
        

        
        <form action="<?php echo e(route('tenant.admin.categories.update', [$store->slug, $category->id])); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <label class="block text-sm font-medium text-gray-800 mb-3">
                        Ícono de la categoría <span class="text-red-500">*</span>
                    </label>
                    
                    
                    <div 
                        x-data="{ 
                            searchIcon: '',
                            get visibleCount() {
                                return Array.from(this.$el.querySelectorAll('.icon-option'))
                                    .filter(el => window.getComputedStyle(el).display !== 'none').length;
                            }
                        }"
                        class="icon-selector-container"
                    >
                        
                        <div class="relative mb-4">
                            <input 
                                type="text"
                                id="icon-search-input"
                                placeholder="Buscar ícono..."
                                x-model="searchIcon"
                                class="py-2.5 ps-11 pe-4 block w-full border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                                <i data-lucide="search" class="flex-shrink-0 size-4 text-gray-400"></i>
                            </div>
                        </div>

                        
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2">
                                <?php $__currentLoopData = $icons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $icon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label 
                                        class="relative cursor-pointer icon-option"
                                        x-show="searchIcon === '' || '<?php echo e(Str::lower(e($icon->display_name ?? $icon->name ?? ''))); ?>'.includes(searchIcon.toLowerCase())"
                                    >
                                        <input 
                                            type="radio" 
                                            name="icon_id" 
                                            value="<?php echo e($icon->id); ?>" 
                                            class="sr-only peer"
                                            <?php echo e((old('icon_id', $category->icon_id) == $icon->id) ? 'checked' : ''); ?>

                                            required
                                        >
                                        
                                        <div class="w-full aspect-square bg-white rounded-lg p-3 border-2 border-transparent
                                                    peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:border-2 hover:border-blue-300
                                                    hover:bg-gray-50
                                                    transition-all duration-200 flex items-center justify-center relative">
                                            <?php if(isset($icon->image_url)): ?>
                                                <img 
                                                    src="<?php echo e($icon->image_url); ?>" 
                                                    alt="<?php echo e(e($icon->display_name ?? $icon->name ?? 'Icono')); ?>" 
                                                    class="max-w-full max-h-full object-contain"
                                                    loading="lazy"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                                                >
                                                <i data-lucide="image" class="w-6 h-6 text-gray-400" style="display: none;"></i>
                                            <?php elseif(isset($icon->icon)): ?>
                                                <i data-lucide="<?php echo e(e($icon->icon)); ?>" class="w-6 h-6 text-gray-400"></i>
                                            <?php else: ?>
                                                <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                            <?php endif; ?>
                                        </div>
                                        
                                        
                                        <div class="absolute -top-1.5 -right-1.5 bg-blue-600 rounded-full p-1 shadow-lg opacity-0 scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200 pointer-events-none">
                                            <i data-lucide="check" class="w-3 h-3 text-white stroke-[3]"></i>
                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            
                            <div 
                                x-show="searchIcon !== '' && visibleCount === 0" 
                                class="text-center py-8"
                                x-cloak
                            >
                                <p class="text-sm text-gray-500">No se encontraron iconos con ese nombre</p>
                            </div>

                            <p class="text-xs text-gray-500 text-center mt-4">
                                Mostrando <?php echo e($icons->count()); ?> ícono(s) disponibles para tu categoría de negocio
                            </p>
                        </div>
                    </div>
                    

                    <?php $__errorArgs = ['icon_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                

                
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="space-y-5">
                        
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-800 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Ej: Hamburguesas"
                                value="<?php echo e(old('name', $category->name)); ?>"
                                maxlength="255"
                                required
                                class="py-2.5 px-4 block w-full border <?php echo e($errors->first('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'); ?> rounded-lg text-sm"
                            >
                            <?php $__errorArgs = ['name'];
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

                        
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-800 mb-2">
                                Slug (URL)
                            </label>
                            <input 
                                type="text"
                                id="slug"
                                name="slug"
                                placeholder="Se genera automáticamente"
                                value="<?php echo e(old('slug', $category->slug)); ?>"
                                maxlength="255"
                                pattern="[a-z0-9\-]*"
                                title="Solo letras minúsculas, números y guiones"
                                class="py-2.5 px-4 block w-full border <?php echo e($errors->first('slug') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500'); ?> rounded-lg text-sm"
                            >
                            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <p class="mt-2 text-xs text-gray-500">
                                URL: <?php echo e(config('app.url')); ?>/<?php echo e(e($store->slug)); ?>/categoria/<span id="slug-preview"><?php echo e(old('slug', $category->slug)); ?></span>
                            </p>
                        </div>

                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-800 mb-2">
                                Descripción
                            </label>
                            <textarea 
                                id="description"
                                name="description"
                                rows="3"
                                maxlength="500"
                                placeholder="Descripción opcional de la categoría"
                                class="py-2.5 px-4 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 resize-none"
                            ><?php echo e(old('description', $category->description)); ?></textarea>
                            <p class="text-xs text-gray-500 mt-1 text-right">
                                <span id="char-count"><?php echo e(strlen(old('description', $category->description))); ?></span>/500 caracteres
                            </p>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <?php if($parentCategories->count() > 0 || $category->parent_id): ?>
                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-800 mb-2">
                                Categoría padre (opcional)
                            </label>
                            <select 
                                id="parent_id"
                                name="parent_id"
                                class="py-2.5 px-4 pe-9 block w-full border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 bg-white"
                            >
                                <option value="">Ninguna (será categoría principal)</option>
                                <?php $__currentLoopData = $parentCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($parent->id); ?>" <?php echo e(old('parent_id', $category->parent_id) == $parent->id ? 'selected' : ''); ?>>
                                        <?php echo e(e($parent->name)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php endif; ?>

                        
                        <div class="border border-gray-200 rounded-lg p-4">
                            <input type="hidden" name="is_active" value="0">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <div class="relative inline-block w-11 h-6">
                                    <input 
                                        type="checkbox" 
                                        id="is_active"
                                        name="is_active"
                                        value="1"
                                        <?php echo e(old('is_active', $category->is_active) ? 'checked' : ''); ?>

                                        class="peer sr-only"
                                    >
                                    <span class="absolute inset-0 bg-gray-300 rounded-full transition-colors peer-checked:bg-blue-600"></span>
                                    <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-full"></span>
                                </div>
                                <div class="flex-1">
                                    <span class="block text-sm font-medium text-gray-800">Categoría activa</span>
                                    <p class="text-xs text-gray-500">
                                        Las categorías inactivas no se muestran en la tienda
                                    </p>
                                </div>
                            </label>
                        </div>

                        
                        <?php if($category->children->count() > 0): ?>
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm rounded-lg px-4 py-3" role="alert">
                                Esta categoría tiene <strong><?php echo e($category->children->count()); ?></strong> subcategoría(s). Si cambias esta categoría a subcategoría, sus subcategorías actuales se convertirán en categorías principales.
                            </div>
                        <?php endif; ?>

                        <?php if($category->products_count > 0): ?>
                            <div class="bg-blue-50 border border-blue-200 text-blue-800 text-sm rounded-lg px-4 py-3" role="alert">
                                Esta categoría tiene <strong><?php echo e($category->products_count); ?></strong> producto(s) asociado(s).
                            </div>
                        <?php endif; ?>

                        
                        <div class="flex justify-between items-center gap-3 pt-4">
                            <div class="flex items-center gap-3">
                                <a href="<?php echo e(route('tenant.admin.categories.index', $store->slug)); ?>">
                                    <button type="button" 
                                            class="inline-flex items-center gap-x-2 py-2.5 px-6 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                                        Cancelar
                                    </button>
                                </a>
                                <?php if($category->products_count == 0): ?>
                                    <button type="button" 
                                            @click="openDeleteModal()"
                                            class="inline-flex items-center gap-x-2 py-2.5 px-6 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                        Eliminar
                                    </button>
                                <?php endif; ?>
                            </div>
                            <button type="submit" 
                                    class="inline-flex items-center gap-x-2 py-2.5 px-6 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors text-sm font-medium">
                                <i data-lucide="check" class="shrink-0 size-4"></i>
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
        

        
        <?php if($category->products_count == 0): ?>
            <div x-show="deleteModalOpen" style="display: none;">
                
                <div 
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
                >
                    <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                        <div 
                            @click.stop
                            class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                        >
                            
                            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                                <h3 id="delete-modal-label" class="font-bold text-gray-800">
                                    ¿Eliminar categoría?
                                </h3>
                                <button 
                                    type="button" 
                                    class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                                    aria-label="Cerrar"
                                    @click="closeDeleteModal()"
                                    :disabled="deleteLoading"
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
                                            Se eliminará la categoría <strong>"<?php echo e($category->name); ?>"</strong> de forma permanente.
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
            </div>
        <?php endif; ?>
        
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const slugPreview = document.getElementById('slug-preview');
            const descriptionTextarea = document.getElementById('description');
            const charCount = document.getElementById('char-count');

            if (!nameInput || !slugInput || !slugPreview) return;

            // Auto-generar slug desde el nombre
            nameInput.addEventListener('input', function(e) {
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
                
                if (!slugInput.value || slugInput.dataset.autoGenerated) {
                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                    slugPreview.textContent = slug || 'slug';
                }
            });

            // Actualizar preview del slug
            slugInput.addEventListener('input', function(e) {
                slugPreview.textContent = e.target.value || 'slug';
                if (e.target.value) {
                    e.target.dataset.autoGenerated = 'false';
                }
            });

            // Contador de caracteres para descripción
            if (descriptionTextarea && charCount) {
                const updateCharCount = () => {
                    const count = descriptionTextarea.value.length;
                    charCount.textContent = count;
                    
                    // Cambiar color si se acerca al límite
                    if (count >= 450) {
                        charCount.classList.add('text-red-600', 'font-semibold');
                    } else if (count >= 400) {
                        charCount.classList.add('text-yellow-600', 'font-semibold');
                        charCount.classList.remove('text-red-600');
                    } else {
                        charCount.classList.remove('text-red-600', 'text-yellow-600', 'font-semibold');
                    }
                };
                
                // Actualizar al cargar (por si hay old value)
                updateCharCount();
                
                descriptionTextarea.addEventListener('input', updateCharCount);
            }

            // Inicializar iconos Lucide
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
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
<?php /**PATH C:\laragon\www\Liniu_Final\app\Features\TenantAdmin/Views/Core/categories/edit.blade.php ENDPATH**/ ?>