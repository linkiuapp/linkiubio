{{--
Vista Edit - Formulario de edición de variables de producto
Permite editar variables existentes con tipo, configuración y opciones dinámicas
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Editar Variable')

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
                    const variableId = '{{ $variable->id }}';
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
        {{-- SECTION: Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.admin.variables.index', $store->slug) }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <h1 class="text-lg font-semibold text-gray-800">Editar Variable</h1>
        </div>
        {{-- End SECTION: Header --}}

        {{-- SECTION: Info Alert --}}
        {{-- COMPONENT: AlertSoft | props:{type:info} --}}
        <x-alert-soft 
            type="info"
            :message="'Editando variable: ' . $variable->name"
        />
        {{-- End COMPONENT: AlertSoft --}}
        {{-- End SECTION: Info Alert --}}

        {{-- SECTION: Validation Errors Alert --}}
        @if($errors->any())
            {{-- COMPONENT: AlertBordered | props:{type:error, title:Por favor corrige los siguientes errores} --}}
            <x-alert-bordered type="error" title="Por favor corrige los siguientes errores:">
                <ul class="list-disc list-inside mt-2 space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-sm text-gray-700">{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert-bordered>
            {{-- End COMPONENT: AlertBordered --}}
        @endif
        {{-- End SECTION: Validation Errors Alert --}}

        {{-- SECTION: Form Card --}}
        <form action="{{ route('tenant.admin.variables.update', [$store->slug, $variable->id]) }}" method="POST" x-data="variableForm()">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                {{-- SECTION: Card Body --}}
                <div class="p-6 space-y-6">
                    {{-- SECTION: Basic Information --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- ITEM: Name Field --}}
                        <div class="md:col-span-2">
                            <x-ds.text-input
                                type="text"
                                name="name"
                                id="name"
                                label="Nombre de la Variable"
                                placeholder="Ej: Talla, Color, Material"
                                :value="old('name', $variable->name)"
                                :required="true"
                                :error="$errors->first('name')"
                            />
                        </div>
                        {{-- End ITEM: Name Field --}}

                        {{-- ITEM: Type Field --}}
                        <div>
                            <x-select-basic 
                                name="type"
                                select-id="type"
                                :options="[
                                    '' => 'Selecciona un tipo',
                                    'radio' => 'Selección única',
                                    'checkbox' => 'Selección múltiple',
                                    'text' => 'Texto libre',
                                    'numeric' => 'Numérico'
                                ]"
                                :selected="old('type', $variable->type)"
                                placeholder=""
                                x-model="variableType"
                                @change="handleTypeChange()"
                                :error="$errors->first('type')"
                                :required="true"
                            />
                        </div>
                        {{-- End ITEM: Type Field --}}

                        {{-- ITEM: Required Default --}}
                        <div>
                            <input type="hidden" name="is_required_default" value="0">
                            <label class="flex items-center gap-3">
                                {{-- COMPONENT: SwitchBasic | props:{switchName:is_required_default} --}}
                                <x-switch-basic 
                                    switch-name="is_required_default"
                                    :checked="old('is_required_default', $variable->is_required_default)"
                                    value="1"
                                />
                                {{-- End COMPONENT: SwitchBasic --}}
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-800">Requerido por defecto</span>
                                    <p class="text-xs text-gray-500">
                                        Esta variable será requerida al crear productos
                                    </p>
                                </div>
                            </label>
                        </div>
                        {{-- End ITEM: Required Default --}}
                    </div>
                    {{-- End SECTION: Basic Information --}}

                    {{-- SECTION: Numeric Fields (conditional) --}}
                    <div 
                        x-show="variableType === 'numeric'" 
                        x-cloak
                        class="grid grid-cols-1 md:grid-cols-2 gap-6"
                    >
                        {{-- ITEM: Min Value --}}
                        <div>
                            <x-ds.text-input
                                type="number"
                                name="min_value"
                                id="min_value"
                                label="Valor Mínimo"
                                placeholder="0.00"
                                :value="old('min_value', $variable->min_value)"
                                step="0.01"
                                :error="$errors->first('min_value')"
                            />
                        </div>
                        {{-- End ITEM: Min Value --}}

                        {{-- ITEM: Max Value --}}
                        <div>
                            <x-ds.text-input
                                type="number"
                                name="max_value"
                                id="max_value"
                                label="Valor Máximo"
                                placeholder="100.00"
                                :value="old('max_value', $variable->max_value)"
                                step="0.01"
                                :error="$errors->first('max_value')"
                            />
                        </div>
                        {{-- End ITEM: Max Value --}}
                    </div>
                    {{-- End SECTION: Numeric Fields --}}

                    {{-- SECTION: Active Status --}}
                    <div>
                        <input type="hidden" name="is_active" value="0">
                        <label class="flex items-center gap-3">
                            {{-- COMPONENT: SwitchBasic | props:{switchName:is_active} --}}
                            <x-switch-basic 
                                switch-name="is_active"
                                :checked="old('is_active', $variable->is_active)"
                                value="1"
                            />
                            {{-- End COMPONENT: SwitchBasic --}}
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-800">Variable activa</span>
                                <p class="text-xs text-gray-500">
                                    Las variables inactivas no se muestran en la tienda
                                </p>
                            </div>
                        </label>
                    </div>
                    {{-- End SECTION: Active Status --}}
                </div>
                {{-- End SECTION: Card Body --}}

                {{-- SECTION: Options Section (conditional) --}}
                <div 
                    x-show="variableType === 'radio' || variableType === 'checkbox'" 
                    x-cloak
                    class="border-t border-gray-200 p-6 space-y-4"
                >
                    {{-- ITEM: Options Header --}}
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-800">Opciones de la Variable</h3>
                        {{-- COMPONENT: ButtonIcon | props:{type:solid, color:dark, icon:plus-circle, text:Agregar Opción} --}}
                        <x-button-icon 
                            type="solid" 
                            color="dark" 
                            icon="plus-circle"
                            size="md"
                            text="Agregar Opción"
                            html-type="button"
                            @click="addOption()"
                        />
                        {{-- End COMPONENT: ButtonIcon --}}
                    </div>
                    {{-- End ITEM: Options Header --}}

                    {{-- ITEM: Options Info Alert --}}
                    {{-- COMPONENT: AlertSoft | props:{type:info} --}}
                    <x-alert-soft 
                        type="info"
                        message="Si una opción no tiene precio adicional, puedes dejar el modificador de precio vacío (se asumirá 0)."
                    />
                    {{-- End COMPONENT: AlertSoft --}}
                    {{-- End ITEM: Options Info Alert --}}

                    {{-- ITEM: Options Container --}}
                    <div id="optionsContainer" class="space-y-4">
                        <template x-for="(option, index) in options" :key="index">
                            {{-- COMPONENT: CardBase | props:{size:md} --}}
                            <x-card-base size="md">
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
                                    {{-- ITEM: Option Name --}}
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
                                    {{-- End ITEM: Option Name --}}

                                    {{-- ITEM: Price Modifier --}}
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
                                        <p class="mt-1 text-xs text-gray-500">Dejar vacío si no hay precio adicional</p>
                                    </div>
                                    {{-- End ITEM: Price Modifier --}}

                                    {{-- ITEM: Color Hex --}}
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
                                    {{-- End ITEM: Color Hex --}}
                                </div>
                            </x-card-base>
                            {{-- End COMPONENT: CardBase --}}
                        </template>
                    </div>
                    {{-- End ITEM: Options Container --}}
                </div>
                {{-- End SECTION: Options Section --}}

                {{-- SECTION: Card Footer --}}
                <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t border-gray-200">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('tenant.admin.variables.index', $store->slug) }}">
                            {{-- COMPONENT: ButtonBase | props:{type:outline, color:error, text:Cancelar} --}}
                            <x-button-base 
                                type="outline" 
                                color="error" 
                                size="md"
                                text="Cancelar"
                            />
                            {{-- End COMPONENT: ButtonBase --}}
                        </a>
                        @if($variable->products_count == 0)
                            {{-- COMPONENT: ButtonIcon | props:{type:solid, color:error, icon:trash-2, text:Eliminar} --}}
                            <x-button-icon 
                                type="solid" 
                                color="error" 
                                icon="trash-2"
                                size="md"
                                text="Eliminar"
                                html-type="button"
                                @click="openDeleteModal()"
                            />
                            {{-- End COMPONENT: ButtonIcon --}}
                        @endif
                    </div>
                    {{-- COMPONENT: ButtonIcon | props:{type:solid, color:dark, icon:check, text:Actualizar Variable} --}}
                    <x-button-icon 
                        type="solid" 
                        color="dark" 
                        icon="check"
                        size="md"
                        text="Actualizar Variable"
                        html-type="submit"
                    />
                    {{-- End COMPONENT: ButtonIcon --}}
                </div>
                {{-- End SECTION: Card Footer --}}
            </div>
        </form>
        {{-- End SECTION: Form Card --}}

        {{-- SECTION: Delete Confirmation Modal --}}
        @if($variable->products_count == 0)
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
                        {{-- SECTION: Modal Header --}}
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
                        {{-- End SECTION: Modal Header --}}

                        {{-- SECTION: Modal Body --}}
                        <div class="mb-4">
                            <div class="flex gap-4">
                                <div class="shrink-0">
                                    <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800">
                                        Se eliminará la variable <strong>"{{ $variable->name }}"</strong> de forma permanente.
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
        @endif
        {{-- End SECTION: Delete Confirmation Modal --}}
    </div>

    @push('scripts')
    <script>
        function variableForm() {
            @php
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
            @endphp

            return {
                variableType: @json(old('type', $variable->type)),
                options: {!! $optionsJson !!}.map(opt => ({
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
    @endpush
    @endsection
</x-tenant-admin-layout>
