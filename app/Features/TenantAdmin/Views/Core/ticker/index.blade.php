<x-tenant-admin-layout :store="$store">
    @section('title', 'Ticker de Promociones')

    @section('content')
    <div 
        x-data="tickerManagement()"
        class="space-y-6"
        x-init="init()"
    >
        <x-toast-notification />

        {{-- SECTION: Header --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Ticker de Promociones</h2>
                        <p class="text-sm text-gray-600">
                            Textos promocionales que se mostrarán en la página de inicio de tu tienda
                        </p>
                    </div>
                </div>
            </div>

            {{-- SECTION: Configuración Global --}}
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Configuración Global</h3>
                <div class="grid gap-6 md:grid-cols-3">
                    <div>
                        <x-color-picker-basic
                            name="background_color"
                            label="Color de fondo"
                            :value="$globalConfig['background_color']"
                            helper="Color de fondo de la cinta"
                            x-model="globalConfig.backgroundColor"
                        />
                    </div>
                    <div>
                        <x-color-picker-basic
                            name="text_color"
                            label="Color del texto"
                            :value="$globalConfig['text_color']"
                            helper="Color del texto del ticker"
                            x-model="globalConfig.textColor"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Velocidad de desplazamiento
                        </label>
                        <select 
                            x-model="globalConfig.scrollSpeed"
                            @change="updateGlobalConfig('scroll_speed', $event.target.value)"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        >
                            <option value="slow">Lento</option>
                            <option value="medium">Medio</option>
                            <option value="fast">Rápido</option>
                        </select>
                    </div>
                </div>
            </div>
            {{-- End SECTION: Configuración Global --}}

            {{-- SECTION: Lista de Textos --}}
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900">
                        Textos del Ticker 
                        <span class="text-sm font-normal text-gray-600">
                            (<span x-text="tickers.length"></span>/8)
                        </span>
                    </h3>
                    <button
                        type="button"
                        @click="addTicker()"
                        :disabled="tickers.length >= 8"
                        class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                    >
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Agregar Texto
                    </button>
                </div>

                <div class="space-y-3" x-ref="tickersList">
                    <template x-for="(ticker, index) in tickers" :key="ticker.id || 'new-' + index">
                        <div 
                            class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200"
                            :data-id="ticker.id"
                        >
                            {{-- Drag Handle --}}
                            <div class="cursor-move text-gray-400 hover:text-gray-600">
                                <i data-lucide="grip-vertical" class="w-5 h-5"></i>
                            </div>

                            {{-- Text Input con botón de emoji --}}
                            <div class="flex-1 flex items-center gap-2">
                                <div class="relative flex-1">
                                    <input
                                        type="text"
                                        x-model="ticker.text"
                                        placeholder="Escribe el texto del ticker..."
                                        maxlength="100"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                    />
                                </div>
                                {{-- Botón Emoji Picker --}}
                                <div class="relative">
                                    <button
                                        type="button"
                                        @click="openEmojiPicker(index)"
                                        class="w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-lg"
                                        title="Agregar emoji"
                                    >
                                        <span>😀</span>
                                    </button>
                                    <div 
                                        x-show="emojiPickerOpen === index"
                                        @click.away="emojiPickerOpen = null"
                                        class="absolute z-10 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg p-2 w-64 max-h-48 overflow-y-auto"
                                        style="display: none;"
                                        x-cloak
                                    >
                                        <div class="grid grid-cols-8 gap-1">
                                            <template x-for="emoji in commonEmojis">
                                                <button
                                                    type="button"
                                                    @click="insertEmoji(index, emoji)"
                                                    class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded text-lg"
                                                    x-text="emoji"
                                                ></button>
                                            </template>
                                        </div>
                                        <div class="mt-2 pt-2 border-t border-gray-200">
                                            <input
                                                type="text"
                                                @input="insertEmoji(index, $event.target.value)"
                                                placeholder="Escribe un emoji..."
                                                class="w-full px-2 py-1 text-sm border border-gray-300 rounded"
                                                maxlength="2"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Toggle Activo --}}
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input
                                    type="checkbox"
                                    x-model="ticker.is_active"
                                    class="sr-only peer"
                                >
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>

                            {{-- Guardar Button --}}
                            <button
                                type="button"
                                @click="saveTicker(index)"
                                :disabled="saving || !ticker.text.trim()"
                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                title="Guardar"
                            >
                                <i data-lucide="save" class="w-5 h-5"></i>
                            </button>

                            {{-- Delete Button --}}
                            <button
                                type="button"
                                @click="deleteTicker(index, ticker.id, ticker.text)"
                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg"
                                title="Eliminar"
                            >
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </template>

                    {{-- Empty State --}}
                    <div x-show="tickers.length === 0" class="text-center py-12" x-cloak style="display: none;">
                        <i data-lucide="scroll-text" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                        <p class="text-gray-600 mb-4">No hay textos configurados</p>
                        <button
                            type="button"
                            @click="addTicker()"
                            class="inline-flex items-center gap-x-2 px-4 py-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700"
                        >
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Agregar Primer Texto
                        </button>
                    </div>
                </div>
            </div>
            {{-- End SECTION: Lista de Textos --}}

            {{-- SECTION: Vista Previa --}}
            <div class="p-6 border-t border-gray-200 bg-gray-50">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Vista Previa</h3>
                <div 
                    class="overflow-hidden rounded-lg w-full ticker-preview-container"
                    :style="`background-color: ${globalConfig.backgroundColor}; color: ${globalConfig.textColor};`"
                >
                    <div 
                        class="flex items-center gap-2 py-3 px-4 whitespace-nowrap ticker-preview-content"
                        :style="getPreviewAnimationStyle()"
                        x-ref="previewContainer"
                    >
                        <template x-for="(ticker, index) in activeTickers" :key="index">
                            <div class="flex items-center gap-2 shrink-0">
                                <span x-text="ticker.text" class="text-sm font-extrabold"></span>
                                <span class="mx-2 text-sm font-medium">•</span>
                            </div>
                        </template>
                        {{-- Duplicar para efecto continuo (siempre duplicar, incluso con un solo texto) --}}
                        <template x-for="(ticker, index) in activeTickers" :key="'dup-' + index">
                            <div class="flex items-center gap-2 shrink-0">
                                <span x-text="ticker.text" class="text-sm font-extrabold"></span>
                                <span class="mx-2 text-sm font-medium">•</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            {{-- End SECTION: Vista Previa --}}
        </div>
        {{-- End SECTION: Header Card --}}

        {{-- SECTION: Delete Confirmation Modal --}}
        <div 
            x-data="deleteModalData()"
            x-on:keydown.escape.window="closeModal()"
            @delete-ticker.window="openModal($event.detail.id, $event.detail.text, $event.detail.index)"
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
                style="display: none;"
                x-cloak
            >
                <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                    <div 
                        @click.stop
                        class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                    >
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800">¿Eliminar texto del ticker?</h3>
                            <button 
                                type="button" 
                                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" 
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
                                        Se eliminará el texto <strong>"<span x-text="tickerText"></span>"</strong> de forma permanente.
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
        {{-- End SECTION: Delete Confirmation Modal --}}
    </div>

    @push('styles')
    <style>
        @keyframes ticker-scroll-10 {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes ticker-scroll-15 {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes ticker-scroll-20 {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        /* Asegurar que el contenedor tenga overflow hidden */
        .ticker-preview-container {
            overflow: hidden;
            width: 100%;
        }
        .ticker-preview-content {
            display: inline-flex;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        function tickerManagement() {
            return {
                storeSlug: @js($store->slug),
                tickers: {!! json_encode($tickers->map(function($ticker) {
                    return [
                        'id' => $ticker->id,
                        'text' => $ticker->text,
                        'emoji' => $ticker->emoji,
                        'is_active' => $ticker->is_active,
                        'sort_order' => $ticker->sort_order,
                    ];
                })->values()) !!},
                globalConfig: {
                    backgroundColor: @js($globalConfig['background_color']),
                    textColor: @js($globalConfig['text_color']),
                    scrollSpeed: @js($globalConfig['scroll_speed']),
                },
                emojiPickerOpen: null,
                commonEmojis: ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😙', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '😵', '😵‍💫', '🤯', '🤠', '🥳', '😎', '🤓', '🧐', '🎉', '🎊', '🛍️', '🛒', '💰', '💸', '💳', '💎', '⭐', '🌟', '✨', '🔥', '💯', '✅', '❌', '⚠️', '🚀', '📢', '📣', '🔔', '🎁', '🎈', '🎀', '🏆', '🥇', '🥈', '🥉'],
                saving: false,

                init() {
                    this.updatePreview();
                    
                    // Inicializar iconos Lucide
                    this.$nextTick(() => {
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    });

                    // Guardar valores iniciales para comparar cambios reales
                    this._initialBackgroundColor = this.globalConfig.backgroundColor;
                    this._initialTextColor = this.globalConfig.textColor;
                    
                    // Bandera para ignorar eventos de inicialización
                    this._colorPickerInitialized = false;
                    
                    // Esperar un momento para que los color pickers se inicialicen
                    setTimeout(() => {
                        this._colorPickerInitialized = true;
                    }, 1000);

                    // Escuchar cambios de color desde el color picker
                    const colorChangedHandler = (event) => {
                        // Ignorar eventos durante la inicialización
                        if (!this._colorPickerInitialized) {
                            return;
                        }
                        
                        const { name, value } = event.detail || {};
                        if (!name || !value) return;
                        
                        // Verificar si el valor realmente cambió
                        let valueChanged = false;
                        if (name === 'background_color') {
                            if (this.globalConfig.backgroundColor !== value) {
                                this.globalConfig.backgroundColor = value;
                                valueChanged = true;
                            }
                        } else if (name === 'text_color') {
                            if (this.globalConfig.textColor !== value) {
                                this.globalConfig.textColor = value;
                                valueChanged = true;
                            }
                        }
                        
                        // Solo guardar si el valor realmente cambió
                        if (valueChanged) {
                            this.updateGlobalConfig(name, value);
                        }
                    };

                    window.addEventListener('color-changed', colorChangedHandler);

                    // Guardar referencia para poder remover el listener si es necesario
                    this._colorChangedHandler = colorChangedHandler;
                },

                get activeTickers() {
                    return this.tickers.filter(t => t.is_active && t.text.trim() !== '');
                },

                get scrollDuration() {
                    const speeds = {
                        'slow': 20,
                        'medium': 15,
                        'fast': 10
                    };
                    return speeds[this.globalConfig.scrollSpeed] || 15;
                },

                getPreviewAnimationStyle() {
                    const duration = this.scrollDuration;
                    // Usar el mismo formato que el frontend: ticker-scroll-10, ticker-scroll-15, ticker-scroll-20
                    return `animation: ticker-scroll-${duration} ${duration}s linear infinite; width: max-content; display: inline-flex;`;
                },

                openEmojiPicker(index) {
                    this.emojiPickerOpen = this.emojiPickerOpen === index ? null : index;
                },

                insertEmoji(index, emoji) {
                    if (this.tickers[index] && emoji) {
                        const currentText = this.tickers[index].text || '';
                        this.tickers[index].text = currentText + emoji;
                        this.emojiPickerOpen = null;
                    }
                },

                addTicker() {
                    if (this.tickers.length >= 8) {
                        if (window.toast) {
                            window.toast.warning(
                                'Límite alcanzado',
                                'Solo puedes agregar hasta 8 textos para el ticker.',
                                5000,
                                'bottom-center'
                            );
                        }
                        return;
                    }

                    const maxSortOrder = this.tickers.length > 0 
                        ? Math.max(...this.tickers.map(t => t.sort_order || 0))
                        : 0;

                    this.tickers.push({
                        id: null,
                        text: '',
                        is_active: true,
                        sort_order: maxSortOrder + 1,
                    });

                    // Reinicializar iconos después de agregar
                    this.$nextTick(() => {
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    });
                },

                async saveTicker(index) {
                    if (this.saving) return;
                    
                    const ticker = this.tickers[index];
                    if (!ticker || !ticker.text.trim()) {
                        return;
                    }

                    this.saving = true;

                    try {
                        const formData = new FormData();
                        if (ticker.id) {
                            formData.append('id', ticker.id);
                        }
                        formData.append('text', ticker.text);
                        formData.append('is_active', ticker.is_active ? '1' : '0');
                        formData.append('sort_order', ticker.sort_order);
                        formData.append('background_color', this.globalConfig.backgroundColor);
                        formData.append('text_color', this.globalConfig.textColor);
                        formData.append('scroll_speed', this.globalConfig.scrollSpeed);

                        const response = await fetch(`/${this.storeSlug}/admin/ticker`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });

                        const data = await response.json();

                        if (!response.ok || data.error) {
                            throw new Error(data.error || 'Error al guardar el ticker');
                        }

                        if (data.ticker) {
                            this.tickers[index] = {
                                id: data.ticker.id,
                                text: data.ticker.text,
                                is_active: data.ticker.is_active,
                                sort_order: data.ticker.sort_order,
                            };
                        }

                        this.updatePreview();

                        // Mostrar toast de éxito
                        if (window.toast) {
                            window.toast.success(
                                'Guardado',
                                'El texto del ticker se ha guardado correctamente.',
                                2000,
                                'bottom-center'
                            );
                        }
                    } catch (error) {
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                error.message || 'Error al guardar el ticker',
                                5000,
                                'bottom-center'
                            );
                        }
                    } finally {
                        this.saving = false;
                    }
                },

                async updateGlobalConfig(field, value) {
                    if (field === 'background_color') {
                        this.globalConfig.backgroundColor = value;
                    } else if (field === 'text_color') {
                        this.globalConfig.textColor = value;
                    } else if (field === 'scroll_speed') {
                        this.globalConfig.scrollSpeed = value;
                    }

                    // Guardar configuración global
                    try {
                        const formData = new FormData();
                        formData.append(field, value);
                        
                        // Si hay tickers, actualizar todos con la nueva configuración
                        if (this.tickers.length > 0) {
                            const firstTicker = this.tickers[0];
                            if (firstTicker.id) {
                                formData.append('id', firstTicker.id);
                            }
                            formData.append('text', firstTicker.text || '');
                            formData.append('is_active', firstTicker.is_active ? '1' : '0');
                            formData.append('sort_order', firstTicker.sort_order || 0);
                        }
                        
                        formData.append('background_color', this.globalConfig.backgroundColor);
                        formData.append('text_color', this.globalConfig.textColor);
                        formData.append('scroll_speed', this.globalConfig.scrollSpeed);

                        const response = await fetch(`/${this.storeSlug}/admin/ticker`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });

                        const data = await response.json();
                        if (!response.ok || data.error) {
                            console.error('Error al actualizar configuración global:', data.error);
                            if (window.toast) {
                                window.toast.error(
                                    'Error',
                                    'Error al guardar la configuración',
                                    3000,
                                    'bottom-center'
                                );
                            }
                        } else {
                            // Mostrar toast de éxito
                            if (window.toast) {
                                window.toast.success(
                                    'Guardado',
                                    'La configuración se ha guardado correctamente.',
                                    2000,
                                    'bottom-center'
                                );
                            }
                        }
                    } catch (error) {
                        console.error('Error al actualizar configuración global:', error);
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                'Error al guardar la configuración',
                                3000,
                                'bottom-center'
                            );
                        }
                    }

                    this.updatePreview();
                },

                deleteTicker(index, id, text) {
                    // Si no tiene ID, eliminar directamente del array
                    if (!id) {
                        this.tickers.splice(index, 1);
                        this.updatePreview();
                        return;
                    }
                    
                    // Asegurar que el ID sea un número
                    const tickerId = parseInt(id, 10);
                    if (isNaN(tickerId)) {
                        console.error('ID de ticker inválido:', id);
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                'ID de ticker inválido',
                                3000,
                                'bottom-center'
                            );
                        }
                        return;
                    }
                    
                    console.log('Dispatching delete-ticker event:', { id: tickerId, text, index });
                    
                    this.$dispatch('delete-ticker', {
                        id: tickerId,
                        text: text || 'este texto',
                        index: index
                    });
                },

                async confirmDeleteTicker(index, id) {
                    if (!id) {
                        // Si no tiene ID, solo eliminar del array
                        this.tickers.splice(index, 1);
                        this.updatePreview();
                        return;
                    }

                    // Asegurar que el ID sea un número
                    const tickerId = parseInt(id, 10);
                    if (isNaN(tickerId) || tickerId <= 0) {
                        console.error('ID de ticker inválido:', id);
                        throw new Error('ID de ticker inválido');
                    }

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]');
                        if (!csrfToken) {
                            throw new Error('No se encontró el token CSRF');
                        }

                        const url = `/${this.storeSlug}/admin/ticker/${tickerId}`;
                        console.log('Eliminando ticker:', { url, tickerId, originalId: id, storeSlug: this.storeSlug });

                        const response = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken.content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        });

                        console.log('Respuesta del servidor:', { status: response.status, ok: response.ok });

                        let data;
                        const responseText = await response.text();
                        console.log('Respuesta texto:', responseText);

                        try {
                            data = JSON.parse(responseText);
                        } catch (e) {
                            console.error('Error al parsear JSON:', e);
                            throw new Error('Error al procesar la respuesta del servidor: ' + responseText);
                        }

                        if (!response.ok) {
                            const errorMsg = data.error || data.message || `Error ${response.status}: ${response.statusText}`;
                            console.error('Error en respuesta:', errorMsg);
                            throw new Error(errorMsg);
                        }

                        if (data.error) {
                            console.error('Error en datos:', data.error);
                            throw new Error(data.error);
                        }

                        // Eliminar del array solo si la eliminación fue exitosa
                        this.tickers.splice(index, 1);
                        this.updatePreview();

                        if (window.toast) {
                            window.toast.success(
                                'Actualización exitosa',
                                'El texto del ticker se ha eliminado correctamente.',
                                3000,
                                'bottom-center'
                            );
                        }
                    } catch (error) {
                        console.error('Error completo al eliminar ticker:', error);
                        const errorMessage = error.message || 'Error al eliminar el ticker';
                        
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                errorMessage,
                                5000,
                                'bottom-center'
                            );
                        }
                        throw error; // Re-lanzar para que el modal pueda manejarlo
                    }
                },

                updatePreview() {
                    // La vista previa se actualiza automáticamente con Alpine
                    this.$nextTick(() => {
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    });
                }
            };
        }

        function deleteModalData() {
            return {
                open: false,
                tickerId: null,
                tickerText: '',
                tickerIndex: null,
                loading: false,
                error: null,

                openModal(id, text, index) {
                    // Asegurar que el ID sea un número
                    this.tickerId = id ? parseInt(id, 10) : null;
                    this.tickerText = text;
                    this.tickerIndex = index;
                    this.error = null;
                    this.open = true;
                    console.log('Modal abierto:', { tickerId: this.tickerId, text, index });
                },

                closeModal() {
                    // Permitir cerrar el modal incluso si está cargando (útil para casos de éxito)
                    this.open = false;
                    this.tickerId = null;
                    this.tickerText = '';
                    this.tickerIndex = null;
                    this.error = null;
                    this.loading = false;
                },

                async confirmDelete() {
                    if (!this.tickerId && this.tickerIndex === null) return;

                    this.loading = true;
                    this.error = null;

                    try {
                        const tickerManagementElement = document.querySelector('[x-data="tickerManagement()"]');
                        if (!tickerManagementElement) {
                            throw new Error('No se pudo encontrar el componente de gestión de tickers');
                        }
                        
                        const tickerManagement = Alpine.$data(tickerManagementElement);
                        await tickerManagement.confirmDeleteTicker(this.tickerIndex, this.tickerId);
                        
                        // Si la eliminación fue exitosa, cerrar el modal
                        this.loading = false;
                        this.closeModal();
                    } catch (error) {
                        console.error('Error en confirmDelete:', error);
                        this.error = error.message || 'Error al eliminar el ticker';
                        this.loading = false;
                    }
                }
            };
        }

        {{-- Eliminado: Los toasts ahora se muestran solo cuando el usuario realiza acciones --}}

        // Inicializar iconos Lucide
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            }
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
