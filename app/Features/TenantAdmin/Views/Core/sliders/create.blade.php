<x-tenant-admin-layout :store="$store">
    @section('title', 'Crear Slider')

    @section('content')
    <div
        class="max-w-4xl mx-auto"
        x-data="(() => ({
            isScheduled: {{ json_encode((bool) old('is_scheduled')) }},
            isPermanent: {{ json_encode((bool) old('is_permanent')) }},
            urlType: {{ json_encode(old('url_type', 'none')) }},
            urlValue: {{ json_encode(old('url')) }},
            selectedInternalLabel: '',
            suggestions: [],
            isLoadingSuggestions: false,
            highlightedIndex: -1,
            feedbackMessage: '',
            minSearchLength: 3,
            shouldDisplaySuggestions: false,
            searchDelay: 300,
            searchTimeout: null,
            internalSearchEndpoint: {{ json_encode(route('tenant.admin.sliders.internal-links', $store->slug)) }},

            init() {
                this.applyUrlState();
                this.$nextTick(() => {
                    this.initializeLucideIcons();
                });
            },

            initializeLucideIcons() {
                const hasCreateIcons = typeof window.createIcons !== 'undefined';
                const hasLucideIcons = typeof window.lucideIcons !== 'undefined';

                if (hasCreateIcons && hasLucideIcons) {
                    window.createIcons({ icons: window.lucideIcons });
                }
            },

            get isUrlDisabled() {
                return this.urlType === 'none';
            },

            setUrlType(type) {
                this.urlType = type;
                this.applyUrlState();
            },

            applyUrlState() {
                if (this.urlType === 'none') {
                    this.urlValue = '';
                    this.selectedInternalLabel = '';
                    this.closeSuggestions();
                    return;
                }

                if (this.urlType !== 'internal') {
                    this.closeSuggestions();
                    this.selectedInternalLabel = '';
                    return;
                }

                if (this.urlValue && !this.selectedInternalLabel) {
                    this.selectedInternalLabel = this.urlValue;
                }
            },

            handleUrlFocus() {
                if (this.urlType !== 'internal') {
                    return;
                }

                if (this.urlValue && this.urlValue.trim().length > 0) {
                    if (this.suggestions.length > 0) {
                        this.shouldDisplaySuggestions = true;
                    }
                    return;
                }

                this.feedbackMessage = `Escribe al menos ${this.minSearchLength} caracteres para buscar.`;
                this.shouldDisplaySuggestions = true;
            },

            handleUrlInput(value) {
                this.urlValue = value;

                if (this.urlType !== 'internal') {
                    return;
                }

                this.selectedInternalLabel = '';

                const trimmed = value.trim();

                if (this.searchTimeout) {
                    clearTimeout(this.searchTimeout);
                }

                if (trimmed.length === 0) {
                    this.suggestions = [];
                    this.feedbackMessage = `Escribe al menos ${this.minSearchLength} caracteres para buscar.`;
                    this.shouldDisplaySuggestions = true;
                    return;
                }

                if (trimmed.length < this.minSearchLength) {
                    this.suggestions = [];
                    this.feedbackMessage = `Escribe al menos ${this.minSearchLength} caracteres para buscar.`;
                    this.shouldDisplaySuggestions = true;
                    return;
                }

                this.shouldDisplaySuggestions = true;
                this.isLoadingSuggestions = true;
                this.feedbackMessage = '';
                this.highlightedIndex = -1;

                this.searchTimeout = setTimeout(() => {
                    this.fetchInternalLinks(trimmed);
                }, this.searchDelay);
            },

            async fetchInternalLinks(query) {
                try {
                    const response = await fetch(`${this.internalSearchEndpoint}?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Error al obtener resultados');
                    }

                    const data = await response.json();

                    if (this.urlType !== 'internal') {
                        this.closeSuggestions();
                        return;
                    }

                    this.suggestions = Array.isArray(data.results) ? data.results : [];
                    this.feedbackMessage = this.suggestions.length === 0
                        ? 'Sin coincidencias. Ajusta tu búsqueda.'
                        : '';

                    this.$nextTick(() => this.initializeLucideIcons());
                } catch (error) {
                    this.suggestions = [];
                    this.feedbackMessage = 'No se pudieron cargar los enlaces. Intenta nuevamente.';
                } finally {
                    this.isLoadingSuggestions = false;
                }
            },

            selectSuggestion(suggestion) {
                this.urlValue = suggestion.url;
                this.selectedInternalLabel = `${suggestion.type_label} • ${suggestion.label}`;
                this.closeSuggestions();

                this.$nextTick(() => {
                    if (this.$refs.urlInput) {
                        this.$refs.urlInput.focus();
                    }
                });
            },

            highlightNextSuggestion() {
                if (!this.shouldDisplaySuggestions || this.suggestions.length === 0) {
                    return;
                }

                const nextIndex = this.highlightedIndex + 1;
                this.highlightedIndex = nextIndex % this.suggestions.length;
            },

            highlightPreviousSuggestion() {
                if (!this.shouldDisplaySuggestions || this.suggestions.length === 0) {
                    return;
                }

                if (this.highlightedIndex <= 0) {
                    this.highlightedIndex = this.suggestions.length - 1;
                    return;
                }

                this.highlightedIndex = this.highlightedIndex - 1;
            },

            selectHighlightedSuggestion() {
                const isOutOfRange = this.highlightedIndex < 0 || this.highlightedIndex >= this.suggestions.length;

                if (isOutOfRange) {
                    return;
                }

                this.selectSuggestion(this.suggestions[this.highlightedIndex]);
            },

            closeSuggestions() {
                this.shouldDisplaySuggestions = false;
                this.isLoadingSuggestions = false;
                this.highlightedIndex = -1;
                this.feedbackMessage = '';
            }
        }))()"
    >
        <!-- Header con botón de volver -->
        <div class="mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.sliders.index', $store->slug) }}">
                    <x-button-icon type="ghost" color="secondary" icon="arrow-left" text="" />
                </a>
                <h1 class="text-lg font-semibold text-gray-800">Crear Slider</h1>
            </div>
        </div>

        <!-- Alerta informativa -->
        <div class="mb-6">
            <x-alert-soft type="info" message="Las medidas recomendadas para el slider son de 420x200px." />
        </div>

        <!-- Formulario dentro de Card -->
        <x-card-base size="lg" shadow="sm">
            <form action="{{ route('tenant.admin.sliders.store', $store->slug) }}" method="POST" enctype="multipart/form-data" id="slider-form">
                @csrf

                <!-- Errores de validación -->
                @if($errors->any())
                    <div class="mb-6">
                        <x-alert-bordered type="error" title="Errores de validación">
                            <ul class="list-disc list-inside space-y-1 mt-2">
                                @foreach($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert-bordered>
                    </div>
                @endif

                <!-- Información Básica -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Información Básica</h3>
                    <p class="text-sm text-gray-600 mb-6">Configura los datos principales del slider</p>
                    
                    <div class="mb-6">
                        <x-input-with-label
                            label="Nombre"
                            name="name"
                            placeholder="Promoción Navidad 2024"
                            :value="old('name')"
                            required
                            container-class="w-full"
                            class="border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium mb-2">Descripción</label>
                        <textarea 
                            id="description"
                            name="description"
                            rows="3"
                            placeholder="Descuentos especiales en toda la tienda"
                            class="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        >{{ old('description') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <x-switch-basic 
                            switch-name="is_active"
                            :checked="old('is_active', true)"
                            switch-id="is_active"
                            value="1"
                        />
                        <label for="is_active" class="text-sm font-medium text-gray-700">Slider activo</label>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Imagen</h3>
                    <p class="text-sm text-gray-600 mb-6">Sube la imagen del slider (debe ser exactamente 420x200px)</p>
                    
                    <x-file-upload-with-validation 
                        name="image"
                        max-file-size="2"
                        accept="image/*"
                        label="Arrastra tu archivo aquí o"
                        browse-text="buscar"
                        help-text="Debe ser exactamente 420x200px, máximo 2MB"
                        required-width="420"
                        required-height="200"
                    />
                    @error('image')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Enlace -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Enlace</h3>
                    <p class="text-sm text-gray-600 mb-6">Configura hacia dónde dirigirá el slider</p>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de enlace</label>
                        <div class="space-y-3">
                            <x-radio-basic 
                                radio-name="url_type"
                                label="Sin enlace"
                                :checked="old('url_type', 'none') == 'none'"
                                radio-id="url_type_none"
                                value="none"
                                x-on:change="setUrlType('none')"
                            />
                            <x-radio-basic 
                                radio-name="url_type"
                                label="Enlace interno"
                                :checked="old('url_type') == 'internal'"
                                radio-id="url_type_internal"
                                value="internal"
                                x-on:change="setUrlType('internal')"
                            />
                            <x-radio-basic 
                                radio-name="url_type"
                                label="Enlace externo"
                                :checked="old('url_type') == 'external'"
                                radio-id="url_type_external"
                                value="external"
                                x-on:change="setUrlType('external')"
                            />
                        </div>
                    </div>
                    
                    <div class="relative">
                        <x-input-with-icon 
                            name="url"
                            icon="link"
                            placeholder="https://ejemplo.com o /categoria/ropa"
                            :value="old('url')"
                            x-model="urlValue"
                            x-ref="urlInput"
                            x-on:input="handleUrlInput($event.target.value)"
                            x-on:focus="handleUrlFocus()"
                            x-on:keydown.arrow-down.prevent="highlightNextSuggestion()"
                            x-on:keydown.arrow-up.prevent="highlightPreviousSuggestion()"
                            x-on:keydown.enter.prevent="selectHighlightedSuggestion()"
                            x-on:keydown.escape="closeSuggestions()"
                            x-bind:disabled="isUrlDisabled"
                            x-bind:class="isUrlDisabled ? 'bg-gray-100 cursor-not-allowed' : 'bg-white'"
                        />
                        <div 
                            x-show="shouldDisplaySuggestions"
                            x-cloak
                            x-transition
                            x-on:click.outside="closeSuggestions()"
                            class="absolute z-50 mt-2 w-full rounded-lg border border-gray-200 bg-white shadow-lg"
                        >
                            <template x-if="isLoadingSuggestions">
                                <div class="flex items-center gap-2 px-4 py-3 text-sm text-gray-500">
                                    <span class="inline-flex size-4 animate-spin rounded-full border-2 border-gray-200 border-t-transparent"></span>
                                    Buscando resultados...
                                </div>
                            </template>

                            <template x-if="!isLoadingSuggestions && suggestions.length === 0 && feedbackMessage">
                                <div class="px-4 py-3 text-sm text-gray-500" x-text="feedbackMessage"></div>
                            </template>

                            <template x-if="!isLoadingSuggestions && suggestions.length > 0">
                                <ul class="py-2">
                                    <template x-for="(suggestion, index) in suggestions" :key="suggestion.id">
                                        <li>
                                            <button 
                                                type="button"
                                                class="flex w-full flex-col gap-1 px-4 py-2 text-left transition hover:bg-gray-50"
                                                :class="highlightedIndex === index ? 'bg-gray-50' : ''"
                                                x-on:mouseenter="highlightedIndex = index"
                                                x-on:mousedown.prevent="selectSuggestion(suggestion)"
                                            >
                                                <span class="text-sm font-medium text-gray-700" x-text="suggestion.label"></span>
                                                <span class="text-xs text-gray-500 flex items-center gap-2">
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-[11px] font-medium text-gray-600">
                                                        <i data-lucide="hash" class="size-3 text-gray-400"></i>
                                                        <span x-text="suggestion.type_label"></span>
                                                    </span>
                                                    <span x-text="suggestion.url"></span>
                                                </span>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </template>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        Interna: /categoria/ropa, /producto/camiseta. Escribe al menos 3 caracteres para buscar.<br>
                        Externa: https://instagram.com/mitienda
                    </p>
                    <p 
                        class="text-xs text-blue-600 mt-2 font-medium flex items-center gap-1"
                        x-show="selectedInternalLabel"
                        x-text="'Recurso seleccionado: ' + selectedInternalLabel"
                    ></p>
                    @error('url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Programación -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Programación</h3>
                    <p class="text-sm text-gray-600 mb-6">Configura cuándo se mostrará el slider (opcional)</p>
                    
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-6">
                            <input type="hidden" name="is_scheduled" value="0">
                            <x-switch-basic 
                                switch-name="is_scheduled"
                                :checked="old('is_scheduled')"
                                switch-id="is_scheduled"
                                value="1"
                                x-model="isScheduled"
                            />
                            <label for="is_scheduled" class="text-sm font-medium text-gray-700">Programar slider</label>
                        </div>
                    </div>

                    <div x-show="isScheduled" x-cloak style="display: none;" class="space-y-6">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_permanent" value="0">
                            <x-switch-basic 
                                switch-name="is_permanent"
                                :checked="old('is_permanent')"
                                switch-id="is_permanent"
                                value="1"
                                x-model="isPermanent"
                            />
                            <label for="is_permanent" class="text-sm font-medium text-gray-700">Slider permanente (sin fecha fin)</label>
                        </div>

                        <div x-show="!isPermanent" x-cloak style="display: none;" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-with-label 
                                    label="Fecha inicio"
                                    name="start_date"
                                    type="date"
                                    :value="old('start_date')"
                                />
                            </div>
                            <div>
                                <x-input-with-label 
                                    label="Fecha fin"
                                    name="end_date"
                                    type="date"
                                    :value="old('end_date')"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-with-label 
                                    label="Hora inicio"
                                    name="start_time"
                                    type="time"
                                    :value="old('start_time')"
                                />
                            </div>
                            <div>
                                <x-input-with-label 
                                    label="Hora fin"
                                    name="end_time"
                                    type="time"
                                    :value="old('end_time')"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Días de la semana</label>
                            <div class="grid grid-cols-7 gap-2">
                                @foreach(['monday' => 'L', 'tuesday' => 'M', 'wednesday' => 'X', 'thursday' => 'J', 'friday' => 'V', 'saturday' => 'S', 'sunday' => 'D'] as $day => $label)
                                    <label class="flex items-center justify-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors has-[:checked]:bg-blue-50 has-[:checked]:border-blue-500">
                                        <input type="checkbox" 
                                               name="scheduled_days[{{ $day }}]" 
                                               value="1" 
                                               {{ old("scheduled_days.{$day}") ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <span class="text-sm font-medium text-gray-700 peer-checked:text-blue-600">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <a href="{{ route('tenant.admin.sliders.index', $store->slug) }}">
                        <x-button-base type="outline" color="error" text="Cancelar" />
                    </a>
                    <x-button-icon type="solid" color="dark" icon="plus" text="Crear Slider" html-type="submit" />
                </div>
            </form>
        </x-card-base>
    </div>

    @endsection
</x-tenant-admin-layout>
