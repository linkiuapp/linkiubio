{{--
Vista Index - Listado de Sliders
Muestra todos los sliders con filtros, acciones y paginación
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Sliders')

    @section('content')
    {{-- SECTION: Empty State Configuration --}}
    @php
        $emptyStateSvg = 'base_ui_empty_sliders.svg';
        $emptyStateTitle = 'No hay sliders disponibles';
        $emptyStateMessage = 'Comienza agregando sliders para tu tienda.';
    @endphp
    {{-- End SECTION: Empty State Configuration --}}

    {{-- SECTION: Main Container --}}
    <div 
        x-data="sliderManagement" 
        class="space-y-4" 
        x-init="init()"
    >
        {{-- SECTION: Success Alert - Slider Created --}}
        @if(session('slider_created'))
            <div 
                x-data="{ show: true }"
                x-show="show"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                x-init="setTimeout(() => show = false, 5000)"
            >
                <x-alert-bordered 
                    type="success" 
                    title="Actualización exitosa" 
                    message="El slider se ha creado correctamente."
                />
            </div>
        @endif
        {{-- End SECTION: Success Alert - Slider Created --}}

        {{-- SECTION: Success Alert - Slider Updated --}}
        @if(session('slider_updated'))
            <div 
                x-data="{ show: true }"
                x-show="show"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                x-init="setTimeout(() => show = false, 5000)"
            >
                <x-alert-bordered 
                    type="success" 
                    title="Actualización exitosa" 
                    message="El slider se ha actualizado correctamente."
                />
            </div>
        @endif
        {{-- End SECTION: Success Alert - Slider Updated --}}

        {{-- SECTION: Success Alert - Slider Deleted --}}
        <div 
            x-show="showSuccessAlert"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            style="display: none;"
        >
            <x-alert-bordered 
                type="success" 
                title="Actualización exitosa" 
                message="El slider se ha eliminado correctamente."
            />
        </div>
        {{-- End SECTION: Success Alert - Slider Deleted --}}

        {{-- SECTION: Success Alert - Bulk Delete --}}
        <div 
            x-show="showBulkDeleteSuccessAlert"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            style="display: none;"
        >
            <template x-if="bulkDeleteError">
                <x-alert-bordered type="warning" title="Eliminación parcial">
                    <span x-text="bulkDeleteError"></span>
                </x-alert-bordered>
            </template>
            <template x-if="!bulkDeleteError">
                <x-alert-bordered type="success" title="Actualización exitosa">
                    <span x-text="'Se eliminaron ' + bulkDeleteSuccessCount + (bulkDeleteSuccessCount === 1 ? ' slider correctamente.' : ' sliders correctamente.')"></span>
                </x-alert-bordered>
            </template>
        </div>
        {{-- End SECTION: Success Alert - Bulk Delete --}}

        {{-- SECTION: Content Card --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            {{-- SECTION: Header --}}
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Sliders</h2>
                        <p class="text-sm text-gray-600">
                            Usando {{ $currentCount }} de {{ $maxSliders }} sliders disponibles en tu plan {{ $store->plan->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div x-show="selectedSliders.length > 0" x-cloak style="display: none;">
                            <button
                                type="button"
                                @click="deleteSelectedSliders()"
                                class="inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none py-3 px-4 body-small bg-red-500 text-white hover:bg-red-600 focus:bg-red-600 border border-transparent"
                            >
                                <i data-lucide="trash-2" class="shrink-0 w-4 h-4"></i>
                                <span x-text="'Eliminar ' + selectedSliders.length + (selectedSliders.length === 1 ? ' slider' : ' sliders')"></span>
                            </button>
                        </div>
                        @if($currentCount < $maxSliders)
                            <a href="{{ route('tenant.admin.sliders.create', $store->slug) }}">
                                {{-- COMPONENT: ButtonIcon | props:{type:solid, color:info, icon:plus-circle} --}}
                                <x-button-icon 
                                    type="solid" 
                                    color="info" 
                                    size="md" 
                                    icon="plus-circle"
                                    text="Nuevo Slider"
                                />
                                {{-- End COMPONENT: ButtonIcon --}}
                            </a>
                        @else
                            {{-- COMPONENT: ButtonIcon | props:{type:outline, color:secondary, icon:plus-circle, disabled:true} --}}
                            <x-button-icon 
                                type="outline" 
                                color="secondary" 
                                size="md" 
                                icon="plus-circle"
                                text="Límite Alcanzado"
                                :disabled="true"
                            />
                            {{-- End COMPONENT: ButtonIcon --}}
                        @endif
                    </div>
                </div>
            </div>
            {{-- End SECTION: Header --}}

            {{-- SECTION: Filters --}}
            <div class="border-b border-gray-200 bg-gray-50 py-3 px-6">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4 flex-1">
                        {{-- COMPONENT: SelectBasic | props:{label:Estado} --}}
                        <div class="w-48">
                            <x-select-basic 
                                name="status"
                                :options="[
                                    '' => 'Todos los estados',
                                    'active' => 'Activos',
                                    'inactive' => 'Inactivos',
                                ]"
                                :value="request('status', '')"
                                x-model="filterStatus"
                                @change="applyFilters()"
                            />
                        </div>
                        {{-- End COMPONENT: SelectBasic --}}

                        {{-- COMPONENT: SelectBasic | props:{label:Programación} --}}
                        <div class="w-56">
                            <x-select-basic 
                                name="scheduling"
                                :options="[
                                    '' => 'Todas las programaciones',
                                    'scheduled' => 'Programados',
                                    'permanent' => 'Permanentes',
                                ]"
                                :value="request('scheduling', '')"
                                x-model="filterScheduled"
                                @change="applyFilters()"
                            />
                        </div>
                        {{-- End COMPONENT: SelectBasic --}}
                    </div>

                    <div class="text-sm text-gray-600">
                        Mostrando {{ $sliders->firstItem() ?? 0 }} - {{ $sliders->lastItem() ?? 0 }} de {{ $sliders->total() }} sliders
                    </div>
                </div>
            </div>
            {{-- End SECTION: Filters --}}

            {{-- SECTION: Table --}}
            @include('tenant-admin::Core/sliders/components/table-view', [
                'sliders' => $sliders,
                'store' => $store,
                'currentCount' => $currentCount,
                'maxSliders' => $maxSliders,
                'emptyStateSvg' => $emptyStateSvg,
                'emptyStateTitle' => $emptyStateTitle,
                'emptyStateMessage' => $emptyStateMessage,
            ])
            {{-- End SECTION: Table --}}

            {{-- SECTION: Pagination --}}
            @if($sliders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $sliders->links() }}
                </div>
            @endif
            {{-- End SECTION: Pagination --}}
        </div>
        {{-- End SECTION: Content Card --}}

        {{-- SECTION: Delete Confirmation Modal --}}
        <div 
            x-data="deleteModalData()"
            x-on:keydown.escape.window="closeModal()"
            @delete-slider.window="openModal($event.detail.id, $event.detail.name, $event.detail.rowElement)"
        >
            {{-- Modal Overlay --}}
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

            {{-- Modal Content --}}
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
            >
                <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                    <div 
                        @click.stop
                        class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                    >
                        {{-- SECTION: Modal Header --}}
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <h3 id="delete-modal-label" class="font-bold text-gray-800">
                                ¿Eliminar slider?
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
                                        Se eliminará el slider <strong>"<span x-text="sliderName"></span>"</strong> de forma permanente.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Esta acción no se puede deshacer.
                                    </p>
                                    
                                    {{-- ITEM: Error Alert --}}
                                    <div x-show="error" class="mt-3" x-cloak>
                                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                            <div class="flex">
                                                <div class="shrink-0">
                                                    <i data-lucide="alert-circle" class="size-5"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p x-text="error"></p>
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
                        {{-- End SECTION: Modal Footer --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- End SECTION: Delete Confirmation Modal --}}

        {{-- SECTION: Duplicate Modal --}}
        <div 
            x-data="{ 
                open: false, 
                sliderId: null, 
                sliderName: '', 
                newSliderName: '',
                loading: false,
                error: null,
                openModal(id, name) {
                    this.sliderId = id;
                    this.sliderName = name;
                    this.newSliderName = name + ' (Copia)';
                    this.error = null;
                    this.open = true;
                },
                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.sliderId = null;
                        this.sliderName = '';
                    this.newSliderName = '';
                        this.error = null;
                    }
                },
                async confirmDuplicate() {
                    if (!this.sliderId) return;
                    
                    if (!this.newSliderName.trim()) {
                        this.error = 'El nombre del slider es requerido';
                        return;
                    }
                    
                    this.loading = true;
                    this.error = null;
                    
                    try {
                        const storeSlug = '{{ $store->slug }}';
                        const response = await fetch('/' + storeSlug + '/admin/sliders/' + this.sliderId + '/duplicate', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                name: this.newSliderName.trim()
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.error || 'Error al duplicar el slider');
                        }
                        
                        window.location.reload();
                    } catch (error) {
                        this.error = error.message || 'Error al duplicar el slider';
                        this.loading = false;
                    }
                },
            }"
            x-on:keydown.escape.window="closeModal()"
            @duplicate-slider.window="openModal($event.detail.id, $event.detail.name)"
            x-cloak
        >
            {{-- Modal Overlay --}}
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

            {{-- Modal Content --}}
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
                aria-labelledby="duplicate-modal-label"
                style="display: none;"
            >
                <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                    <div 
                        @click.stop
                        class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                    >
                        {{-- SECTION: Modal Header --}}
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <h3 id="duplicate-modal-label" class="font-bold text-gray-800">
                                Duplicar Slider
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
                        {{-- End SECTION: Modal Header --}}

                        {{-- SECTION: Modal Body --}}
                        <div class="p-4 overflow-y-auto">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="size-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="copy" class="size-5 text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800 mb-4">
                                        Ingresa el nombre para la copia de <strong>"<span x-text="sliderName"></span>"</strong>
                                    </p>
                                    
                                    <div>
                                        <label for="new-slider-name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nombre del nuevo slider
                                        </label>
                                        <input 
                                            type="text" 
                                            id="new-slider-name"
                                            x-model="newSliderName"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Nombre del nuevo slider"
                                            @keydown.enter="confirmDuplicate()"
                                        >
                                    </div>
                                    
                                    {{-- ITEM: Error Alert --}}
                                    <div x-show="error" class="mt-3" x-cloak>
                                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                            <div class="flex">
                                                <div class="shrink-0">
                                                    <i data-lucide="alert-circle" class="size-5"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p x-text="error"></p>
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
                                @click="closeModal()"
                                :disabled="loading"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="button" 
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                @click="confirmDuplicate()"
                                :disabled="loading"
                            >
                                <span x-show="!loading">Duplicar</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <i data-lucide="loader" class="size-4 animate-spin"></i>
                                    Duplicando...
                                </span>
                            </button>
                        </div>
                        {{-- End SECTION: Modal Footer --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- End SECTION: Duplicate Modal --}}

        {{-- SECTION: Bulk Delete Confirmation Modal --}}
        <div 
            x-show="showBulkDeleteModal"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
            @click="closeBulkDeleteModal()"
            style="display: none;"
            x-cloak
            x-on:keydown.escape.window="closeBulkDeleteModal()"
        ></div>

        <div 
            x-show="showBulkDeleteModal"
            x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
            role="dialog"
            tabindex="-1"
            aria-labelledby="bulk-delete-modal-label"
            style="display: none;"
            x-cloak
        >
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                <div 
                    @click.stop
                    class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                >
                    {{-- SECTION: Modal Header --}}
                    <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                        <h3 id="bulk-delete-modal-label" class="font-bold text-gray-800">
                            ¿Eliminar sliders?
                        </h3>
                        <button 
                            type="button" 
                            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
                            aria-label="Cerrar"
                            @click="closeBulkDeleteModal()"
                            :disabled="bulkDeleteLoading"
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
                                    Se eliminarán <strong><span x-text="selectedSliders.length"></span> <span x-text="selectedSliders.length === 1 ? 'slider' : 'sliders'"></span></strong> de forma permanente.
                                </p>
                                <p class="text-sm text-gray-600 mt-2">
                                    Esta acción no se puede deshacer.
                                </p>
                                
                                {{-- ITEM: Error Alert --}}
                                <div x-show="bulkDeleteError" class="mt-3" x-cloak>
                                    <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                        <div class="flex">
                                            <div class="shrink-0">
                                                <i data-lucide="alert-circle" class="size-5"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p x-text="bulkDeleteError"></p>
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
                            @click="closeBulkDeleteModal()"
                            :disabled="bulkDeleteLoading"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="button" 
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                            @click="confirmBulkDelete()"
                            :disabled="bulkDeleteLoading"
                        >
                            <span x-show="!bulkDeleteLoading">Sí, eliminar</span>
                            <span x-show="bulkDeleteLoading" class="flex items-center gap-2">
                                <i data-lucide="loader" class="size-4 animate-spin"></i>
                                Eliminando...
                            </span>
                        </button>
                    </div>
                    {{-- End SECTION: Modal Footer --}}
                </div>
            </div>
        </div>
        {{-- End SECTION: Bulk Delete Confirmation Modal --}}
    </div>
    {{-- End SECTION: Main Container --}}

    @push('scripts')
    <script>
        function deleteModalData() {
            return {
                open: false,
                sliderId: null,
                sliderName: '',
                sliderRow: null,
                loading: false,
                error: null,
                
                openModal(id, name, rowElement) {
                    this.sliderId = id;
                    this.sliderName = name;
                    this.sliderRow = rowElement;
                    this.error = null;
                    this.open = true;
                },
                
                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.sliderId = null;
                        this.sliderName = '';
                        this.sliderRow = null;
                        this.error = null;
                    }
                },
                
                async confirmDelete() {
                    if (!this.sliderId) return;
                    
                    this.loading = true;
                    this.error = null;
                    
                    try {
                        const storeSlug = '{{ $store->slug }}';
                        const response = await fetch('/' + storeSlug + '/admin/sliders/' + this.sliderId, {
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
                            throw new Error(data.error || 'Error al eliminar el slider');
                        }

                        if (data.error) {
                            throw new Error(data.error);
                        }

                        this.loading = false;
                        
                        const rowToDelete = this.sliderRow;
                        const sliderIdToRemove = this.sliderId;
                        const sliderName = this.sliderName;
                        
                        // Remover de la selección ANTES de eliminar el elemento del DOM
                        const sliderManagement = Alpine.$data(document.querySelector('[x-data="sliderManagement"]'));
                        if (sliderManagement) {
                            // Desmarcar el checkbox si existe ANTES de remover del array
                            if (rowToDelete) {
                                const checkbox = rowToDelete.querySelector('.slider-checkbox');
                                if (checkbox) {
                                    checkbox.checked = false;
                                }
                            }
                            
                            // Remover el slider del array de selección usando una nueva referencia para forzar reactividad
                            const currentSelected = [...sliderManagement.selectedSliders];
                            sliderManagement.selectedSliders = currentSelected.filter(id => id !== sliderIdToRemove);
                            
                            // Si no quedan seleccionados, limpiar también el selectAll
                            if (sliderManagement.selectedSliders.length === 0) {
                                sliderManagement.selectAll = false;
                                const selectAllCheckbox = document.getElementById('select-all-sliders');
                                if (selectAllCheckbox) {
                                    selectAllCheckbox.checked = false;
                                }
                            }
                            
                            // Actualizar el estado del select all
                            sliderManagement.updateSelectAllState();
                        }
                        
                        this.closeModal();
                        
                        if (rowToDelete && rowToDelete.parentNode) {
                            rowToDelete.style.transition = 'opacity 0.3s ease-out';
                            rowToDelete.style.opacity = '0';
                            setTimeout(() => {
                                if (rowToDelete.parentNode) {
                                    rowToDelete.remove();
                                    
                                    // Verificar si quedan sliders y mostrar EmptyState si es necesario
                                    if (sliderManagement && sliderManagement.checkAndShowEmptyState) {
                                        sliderManagement.checkAndShowEmptyState();
                                    }
                                    
                                    window.dispatchEvent(new CustomEvent('show-success-alert'));
                                }
                            }, 300);
                        } else {
                            window.location.reload();
                            return;
                        }
                    } catch (error) {
                        this.error = error.message || 'Error al eliminar el slider';
                        this.loading = false;
                    }
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('sliderManagement', () => ({
                filterStatus: '{{ request('status', '') }}',
                filterScheduled: '{{ request('scheduling', '') }}',
                showSuccessAlert: false,
                selectedSliders: [],
                selectAll: false,
                showBulkDeleteModal: false,
                bulkDeleteLoading: false,
                bulkDeleteError: null,
                bulkDeleteSuccessCount: 0,
                showBulkDeleteSuccessAlert: false,

                init() {
                    window.addEventListener('show-success-alert', () => {
                        this.showSuccessAlert = true;
                        this.$nextTick(() => {
                            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                window.createIcons({ icons: window.lucideIcons });
                            }
                        });
                        setTimeout(() => {
                            this.showSuccessAlert = false;
                        }, 5000);
                    });

                    // Inicializar iconos Lucide
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                },

                applyFilters() {
                    const params = new URLSearchParams(window.location.search);
                    
                    if (this.filterStatus) {
                        params.set('status', this.filterStatus);
                    } else {
                        params.delete('status');
                    }
                    
                    if (this.filterScheduled) {
                        params.set('scheduling', this.filterScheduled);
                    } else {
                        params.delete('scheduling');
                    }
                    
                    window.location.search = params.toString();
                },

                toggleSelectAll() {
                    const selectAllCheckbox = document.getElementById('select-all-sliders');
                    if (!selectAllCheckbox) return;
                    
                    const isChecked = selectAllCheckbox.checked;
                    this.selectAll = isChecked;
                    
                    const checkboxes = document.querySelectorAll('.slider-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                        const sliderId = parseInt(checkbox.value);
                        if (isChecked) {
                            if (!this.selectedSliders.includes(sliderId)) {
                                this.selectedSliders.push(sliderId);
                            }
                        } else {
                            this.selectedSliders = this.selectedSliders.filter(id => id !== sliderId);
                        }
                    });
                },

                toggleSlider(checkbox) {
                    if (!checkbox) return;
                    const sliderId = parseInt(checkbox.value);
                    if (checkbox.checked) {
                        if (!this.selectedSliders.includes(sliderId)) {
                            this.selectedSliders.push(sliderId);
                        }
                    } else {
                        this.selectedSliders = this.selectedSliders.filter(id => id !== sliderId);
                    }
                    this.updateSelectAllState();
                },

                updateSelectAllState() {
                    const checkboxes = document.querySelectorAll('.slider-checkbox');
                    const selectAllCheckbox = document.getElementById('select-all-sliders');
                    if (!checkboxes.length || !selectAllCheckbox) return;
                    
                    const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
                    this.selectAll = checkedCount === checkboxes.length;
                    selectAllCheckbox.checked = this.selectAll;
                },

                deleteSelectedSliders() {
                    if (this.selectedSliders.length === 0) return;
                    this.showBulkDeleteModal = true;
                },

                closeBulkDeleteModal() {
                    if (!this.bulkDeleteLoading) {
                        this.showBulkDeleteModal = false;
                        this.bulkDeleteError = null;
                    }
                },

                async confirmBulkDelete() {
                    if (this.selectedSliders.length === 0) return;
                    
                    this.bulkDeleteLoading = true;
                    this.bulkDeleteError = null;
                    
                    const storeSlug = '{{ $store->slug }}';
                    const sliderIdsToDelete = [...this.selectedSliders];
                    let successCount = 0;
                    let errorCount = 0;
                    
                    for (const sliderId of sliderIdsToDelete) {
                        try {
                            const response = await fetch('/' + storeSlug + '/admin/sliders/' + sliderId, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                                    'Accept': 'application/json',
                                }
                            });
                            
                            const data = await response.json();
                            if (response.ok && data.success) {
                                successCount++;
                                
                                // Eliminar fila del DOM
                                const row = document.querySelector(`tr[data-slider-id="${sliderId}"]`);
                                if (row) {
                                    row.style.transition = 'opacity 0.3s ease-out';
                                    row.style.opacity = '0';
                                    setTimeout(() => {
                                        if (row.parentNode) {
                                            row.remove();
                                        }
                                    }, 300);
                                }
                            } else {
                                errorCount++;
                            }
                        } catch (error) {
                            errorCount++;
                        }
                    }
                    
                    this.bulkDeleteLoading = false;
                    this.closeBulkDeleteModal();
                    this.selectedSliders = [];
                    this.selectAll = false;
                    const selectAllCheckbox = document.getElementById('select-all-sliders');
                    if (selectAllCheckbox) {
                        selectAllCheckbox.checked = false;
                    }
                    
                    // Esperar un poco para que las animaciones de eliminación terminen
                    setTimeout(() => {
                        this.updateSelectAllState();
                        
                        // Verificar si quedan sliders y mostrar EmptyState si es necesario
                        this.checkAndShowEmptyState();
                        
                        if (errorCount === 0) {
                            this.bulkDeleteSuccessCount = successCount;
                            
                            // Mostrar alerta de éxito
                            this.showBulkDeleteSuccessAlert = true;
                            
                            // Inicializar iconos Lucide después de mostrar la alerta
                            this.$nextTick(() => {
                                if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                    window.createIcons({ icons: window.lucideIcons });
                                }
                            });
                            
                            // Scroll suave hacia arriba para ver la alerta
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            
                            // Ocultar alerta después de 5 segundos
                            setTimeout(() => {
                                this.showBulkDeleteSuccessAlert = false;
                            }, 5000);
                        } else {
                            // Mostrar alerta de error si hubo errores
                            this.bulkDeleteError = `Se eliminaron ${successCount} sliders. ${errorCount > 0 ? `${errorCount} sliders no pudieron ser eliminados.` : ''}`;
                            
                            // Mostrar alerta de error en lugar de modal
                            this.bulkDeleteSuccessCount = successCount;
                            this.showBulkDeleteSuccessAlert = true;
                            
                            // Inicializar iconos Lucide
                            this.$nextTick(() => {
                                if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                    window.createIcons({ icons: window.lucideIcons });
                                }
                            });
                            
                            // Scroll suave hacia arriba para ver la alerta
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            
                            // Ocultar alerta después de 5 segundos
                            setTimeout(() => {
                                this.showBulkDeleteSuccessAlert = false;
                            }, 5000);
                        }
                    }, 350);
                },

                checkAndShowEmptyState() {
                    // Esperar un poco para que las animaciones de eliminación terminen
                    setTimeout(() => {
                        const tbody = document.querySelector('tbody');
                        if (!tbody) return;
                        
                        // Contar filas visibles (excluyendo el empty state dinámico)
                        const sliderRows = tbody.querySelectorAll('tr[data-slider-id]');
                        const visibleRows = Array.from(sliderRows).filter(row => {
                            // Verificar si la fila está realmente visible en el DOM
                            const style = window.getComputedStyle(row);
                            return style.display !== 'none' && 
                                   row.style.opacity !== '0' && 
                                   row.offsetParent !== null &&
                                   !row.classList.contains('removing');
                        });
                        
                        const dynamicEmptyState = document.getElementById('dynamic-empty-state');
                        
                        if (visibleRows.length === 0 && dynamicEmptyState) {
                            // Ocultar el thead de la tabla
                            const thead = document.querySelector('thead');
                            if (thead) {
                                thead.style.display = 'none';
                            }
                            
                            // Ocultar cualquier empty state de Blade que pueda estar visible
                            const bladeEmptyStateRows = tbody.querySelectorAll('tr:not([data-slider-id]):not(#dynamic-empty-state)');
                            bladeEmptyStateRows.forEach(row => {
                                if (row.id !== 'dynamic-empty-state') {
                                    row.style.display = 'none';
                                }
                            });
                            
                            // Mostrar el empty state dinámico
                            dynamicEmptyState.style.display = '';
                            
                            // Inicializar iconos Lucide en el empty state
                            this.$nextTick(() => {
                                if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                    window.createIcons({ icons: window.lucideIcons });
                                }
                            });
                        } else {
                            // Mostrar el thead si hay filas
                            const thead = document.querySelector('thead');
                            if (thead) {
                                thead.style.display = '';
                            }
                            
                            // Ocultar el empty state dinámico
                            if (dynamicEmptyState) {
                                dynamicEmptyState.style.display = 'none';
                            }
                        }
                    }, 400); // Esperar un poco más que la animación de eliminación (300ms)
                }
            }));
        });

        // Checkbox functionality
        document.addEventListener('change', function(e) {
            // Select all checkbox
            if (e.target.id === 'select-all-sliders') {
                const sliderManagement = Alpine.$data(document.querySelector('[x-data="sliderManagement"]'));
                if (sliderManagement) {
                    sliderManagement.toggleSelectAll();
                }
            }
            
            // Individual checkboxes
            if (e.target.classList.contains('slider-checkbox')) {
                const sliderManagement = Alpine.$data(document.querySelector('[x-data="sliderManagement"]'));
                if (sliderManagement) {
                    sliderManagement.toggleSlider(e.target);
                }
            }
            
            // Toggle functionality
            if (e.target.classList.contains('slider-toggle')) {
                const sliderId = e.target.dataset.sliderId;
                const url = e.target.dataset.url;
                
                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.error || 'Error al cambiar el estado');
                        e.target.checked = !e.target.checked;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cambiar el estado');
                    e.target.checked = !e.target.checked;
                });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 
