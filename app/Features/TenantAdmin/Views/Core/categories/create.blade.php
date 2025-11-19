{{--
Vista Create - Formulario de creación de categorías
Permite crear nuevas categorías con icono, nombre, slug, descripción y configuración
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Nueva Categoría')

    @section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        {{-- SECTION: Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.admin.categories.index', $store->slug) }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Nueva Categoría</h1>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Info Alert --}}
        {{-- COMPONENT: AlertSoft | props:{type:info} --}}
        <x-alert-soft 
            type="info"
            :message="'Estás usando ' . $totalCategories . ' de ' . $categoryLimit . ' categorías disponibles en tu plan ' . $store->plan->name . '.' . ($parentCategories->count() > 0 ? ' Crear una subcategoría también cuenta para el límite.' : '')"
        />
        {{-- End COMPONENT: AlertSoft --}}
        {{-- End SECTION: Info Alert --}}

        {{-- SECTION: Form Card --}}
        <form action="{{ route('tenant.admin.categories.store', $store->slug) }}" method="POST">
            @csrf

            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                {{-- SECTION: Card Body --}}
                <div class="p-6 space-y-6">
                    {{-- SECTION: Icon Selector --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-800 mb-3">
                            Icono de la categoría <span class="text-red-500">*</span>
                        </label>
                        
                        {{-- COMPONENT: IconSelectorGrid | props:{name:icon_id, icons:$icons, selected:old('icon_id'), required:true} --}}
                        <x-icon-selector-grid 
                            name="icon_id"
                            :icons="$icons"
                            :selected="old('icon_id')"
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
                            :value="old('name')"
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
                                :value="old('slug')"
                                :error="$errors->first('slug')"
                            />
                            <p class="mt-1 text-xs text-gray-500">
                                URL: {{ config('app.url') }}/{{ $store->slug }}/categoria/<span id="slug-preview">slug</span>
                            </p>
                        </div>
                        {{-- End ITEM: Slug Field --}}
                    </div>
                    {{-- End SECTION: Basic Information --}}

                    {{-- SECTION: Description --}}
                    <div>
                        <x-textarea-with-label
                            textarea-name="description"
                            textarea-id="description"
                            label="Descripción"
                            placeholder="Descripción opcional de la categoría"
                            :rows="3"
                            container-class="w-full"
                        >
                            {{ old('description') }}
                        </x-textarea-with-label>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- End SECTION: Description --}}

                    {{-- SECTION: Parent Category --}}
                    @if($parentCategories->count() > 0)
                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-800 mb-2">
                                Categoría padre (opcional)
                            </label>
                            {{-- COMPONENT: SelectBasic | props:{name:parent_id, select-id:parent_id} --}}
                            <x-select-basic 
                                name="parent_id"
                                select-id="parent_id"
                                :options="['' => 'Ninguna (será categoría principal)'] + $parentCategories->pluck('name', 'id')->toArray()"
                                :selected="old('parent_id', '')"
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
                                    :checked="old('is_active', true)"
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
                </div>
                {{-- End SECTION: Card Body --}}

                {{-- SECTION: Card Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t border-gray-200">
                    <a href="{{ route('tenant.admin.categories.index', $store->slug) }}" class="inline-flex items-center">
                        {{-- COMPONENT: ButtonBase | props:{type:outline, color:error, text:Cancelar} --}}
                        <x-button-base 
                            type="outline" 
                            color="error" 
                            size="md"
                            text="Cancelar"
                        />
                        {{-- End COMPONENT: ButtonBase --}}
                    </a>
                    {{-- COMPONENT: ButtonIcon | props:{type:solid, color:dark, icon:plus, text:Crear Categoría} --}}
                    <x-button-icon 
                        type="solid" 
                        color="dark" 
                        icon="plus"
                        size="md"
                        text="Crear Categoría"
                        html-type="submit"
                    />
                    {{-- End COMPONENT: ButtonIcon --}}
                </div>
                {{-- End SECTION: Card Footer --}}
            </div>
        </form>
        {{-- End SECTION: Form Card --}}
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const slugPreview = document.getElementById('slug-preview');

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

            // Inicializar iconos Lucide
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
