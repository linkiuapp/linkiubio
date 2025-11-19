{{--
Vista Edit - Formulario de edición de categorías
Permite editar categorías existentes con icono, nombre, slug, descripción y configuración
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Editar Categoría')

    @section('content')
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
                    const storeSlug = '{{ $store->slug }}';
                    const categoryId = '{{ $category->id }}';
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
        class="max-w-4xl mx-auto space-y-6"
    >
        {{-- SECTION: Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.admin.categories.index', $store->slug) }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Editar Categoría</h1>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Info Alert --}}
        {{-- COMPONENT: AlertSoft | props:{type:info} --}}
        <x-alert-soft 
            type="info"
            :message="'Estás usando ' . $totalCategories . ' de ' . $categoryLimit . ' categorías disponibles en tu plan ' . $store->plan->name . '.'"
        />
        {{-- End COMPONENT: AlertSoft --}}
        {{-- End SECTION: Info Alert --}}

        {{-- SECTION: Form Card --}}
        <form action="{{ route('tenant.admin.categories.update', [$store->slug, $category->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                {{-- SECTION: Card Body --}}
                <div class="p-6 space-y-6">
                    {{-- SECTION: Icon Selector --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 mb-3">
                            Icono de la categoría <span class="text-red-500">*</span>
                        </label>
                        
                        {{-- COMPONENT: IconSelectorGrid | props:{name:icon_id, icons:$icons, selected:old('icon_id', $category->icon_id), required:true} --}}
                        <x-icon-selector-grid 
                            name="icon_id"
                            :icons="$icons"
                            :selected="old('icon_id', $category->icon_id)"
                            :required="true"
                            :searchable="true"
                            :columns="['mobile' => 4, 'tablet' => 6, 'desktop' => 12]"
                        />
                        {{-- End COMPONENT: IconSelectorGrid --}}

                        <p class="text-xs text-gray-500 mt-6">
                            Mostrando {{ $icons->count() }} icono(s) disponibles para tu categoría de negocio
                        </p>

                        @error('icon_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- End SECTION: Icon Selector --}}

                    {{-- SECTION: Basic Information --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- ITEM: Name Field --}}
                        <x-ds.text-input
                            type="text"
                            name="name"
                            id="name"
                            label="Nombre"
                            placeholder="Ej: Hamburguesas"
                            :value="old('name', $category->name)"
                            :required="true"
                            :error="$errors->first('name')"
                        />
                        {{-- End ITEM: Name Field --}}

                        {{-- ITEM: Slug Field --}}
                        <div>
                            <x-ds.text-input
                                type="text"
                                name="slug"
                                id="slug"
                                label="Slug (URL)"
                                placeholder="Se genera automáticamente"
                                :value="old('slug', $category->slug)"
                                :error="$errors->first('slug')"
                            />
                            <p class="mt-1 text-xs text-gray-500">
                                URL: {{ config('app.url') }}/{{ $store->slug }}/categoria/<span id="slug-preview">{{ old('slug', $category->slug) }}</span>
                            </p>
                        </div>
                        {{-- End ITEM: Slug Field --}}
                    </div>
                    {{-- End SECTION: Basic Information --}}

                    {{-- SECTION: Description --}}
                    <x-textarea-with-label
                        textarea-name="description"
                        textarea-id="description"
                        label="Descripción"
                        placeholder="Descripción opcional de la categoría"
                        :rows="3"
                        container-class="w-full"
                        :error="$errors->first('description')"
                    >
                        {{ old('description', $category->description) }}
                    </x-textarea-with-label>
                    {{-- End SECTION: Description --}}

                    {{-- SECTION: Parent Category --}}
                    @if($parentCategories->count() > 0 || $category->parent_id)
                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-800 mb-2">
                                Categoría padre (opcional)
                            </label>
                            {{-- COMPONENT: SelectBasic | props:{name:parent_id, select-id:parent_id} --}}
                            <x-select-basic 
                                name="parent_id"
                                select-id="parent_id"
                                :options="['' => 'Ninguna (será categoría principal)'] + $parentCategories->pluck('name', 'id')->toArray()"
                                :selected="old('parent_id', $category->parent_id)"
                                placeholder=""
                            />
                            {{-- End COMPONENT: SelectBasic --}}
                            @error('parent_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                    {{-- End SECTION: Parent Category --}}

                    {{-- SECTION: Additional Settings --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- ITEM: Active Status --}}
                        <div>
                            <input type="hidden" name="is_active" value="0">
                            <label class="flex px-2 items-center gap-3 mb-2">
                                {{-- COMPONENT: SwitchBasic | props:{switchName:is_active, checked:true} --}}
                                <x-switch-basic 
                                    switch-name="is_active"
                                    :checked="old('is_active', $category->is_active)"
                                    value="1"
                                />
                                {{-- End COMPONENT: SwitchBasic --}}
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-800">Categoría activa</span>
                                    <p class="text-xs text-gray-500">
                                        Las categorías inactivas no se muestran en la tienda
                                    </p>
                                </div>
                            </label>
                        </div>
                        {{-- End ITEM: Active Status --}}
                    </div>
                    {{-- End SECTION: Additional Settings --}}

                    {{-- SECTION: Warning Alerts --}}
                    @if($category->children->count() > 0)
                        {{-- COMPONENT: AlertSoft | props:{type:warning} --}}
                        <x-alert-soft 
                            type="warning"
                            :message="'Esta categoría tiene ' . $category->children->count() . ' subcategoría(s). Si cambias esta categoría a subcategoría, sus subcategorías actuales se convertirán en categorías principales.'"
                        />
                        {{-- End COMPONENT: AlertSoft --}}
                    @endif

                    @if($category->products_count > 0)
                        {{-- COMPONENT: AlertSoft | props:{type:info} --}}
                        <x-alert-soft 
                            type="info"
                            :message="'Esta categoría tiene ' . $category->products_count . ' producto(s) asociado(s).'"
                        />
                        {{-- End COMPONENT: AlertSoft --}}
                    @endif
                    {{-- End SECTION: Warning Alerts --}}
                </div>
                {{-- End SECTION: Card Body --}}

                {{-- SECTION: Card Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t border-gray-200">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('tenant.admin.categories.index', $store->slug) }}">
                            {{-- COMPONENT: ButtonBase | props:{type:outline, color:error, text:Cancelar} --}}
                            <x-button-base 
                                type="outline" 
                                color="error" 
                                size="md"
                                text="Cancelar"
                            />
                            {{-- End COMPONENT: ButtonBase --}}
                        </a>
                        @if($category->products_count == 0)
                            {{-- COMPONENT: ButtonBase | props:{type:outline, color:error, text:Eliminar} --}}
                            <x-button-base 
                                type="solid" 
                                color="error" 
                                size="md"
                                text="Eliminar"
                                @click="openDeleteModal()"
                            />
                            {{-- End COMPONENT: ButtonBase --}}
                        @endif
                    </div>
                    {{-- COMPONENT: ButtonIcon | props:{type:solid, color:dark, icon:save, text:Guardar Cambios} --}}
                    <x-button-icon 
                        type="solid" 
                        color="dark" 
                        icon="check"
                        size="md"
                        text="Guardar Cambios"
                        html-type="submit"
                    />
                    {{-- End COMPONENT: ButtonIcon --}}
                </div>
                {{-- End SECTION: Card Footer --}}
            </div>
        </form>
        {{-- End SECTION: Form Card --}}

        {{-- SECTION: Delete Confirmation Modal --}}
        @if($category->products_count == 0)
            <div x-show="deleteModalOpen" style="display: none;">
                {{-- Modal Overlay --}}
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

                {{-- Modal Content --}}
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
                            {{-- SECTION: Modal Header --}}
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
                            {{-- End SECTION: Modal Header --}}

                            {{-- SECTION: Modal Body --}}
                            <div class="p-4 overflow-y-auto">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                            <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-800">
                                            Se eliminará la categoría <strong>"{{ $category->name }}"</strong> de forma permanente.
                                        </p>
                                        <p class="text-sm text-gray-600 mt-2">
                                            Esta acción no se puede deshacer.
                                        </p>
                                        
                                        {{-- ITEM: Error Alert --}}
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
                                        {{-- End ITEM: Error Alert --}}
                                    </div>
                                </div>
                            </div>
                            {{-- End SECTION: Modal Body --}}

                            {{-- SECTION: Modal Footer --}}
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
                            {{-- End SECTION: Modal Footer --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- End SECTION: Delete Confirmation Modal --}}
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const slugPreview = document.getElementById('slug-preview');

            if (!nameInput || !slugInput || !slugPreview) return;

            // Auto-generar slug desde el nombre (solo si está vacío o fue auto-generado)
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

            // Inicializar iconos Lucide
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
