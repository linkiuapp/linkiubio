<x-tenant-admin-layout :store="$store">
    @section('title', 'Diseño de Tienda')

    @section('content')
    <div class="flex flex-col h-full">
        {{-- Header de la página --}}
        <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-semibold text-black-500 mb-0">Diseño de Tienda</h1>
                <div class="flex items-center gap-3">
                    <button 
                        x-data
                        @click="publishDesign()"
                        class="btn-primary flex items-center gap-2"
                    >
                        <x-solar-check-circle-outline class="w-5 h-5" />
                        Publicar
                    </button>
                </div>
            </div>
        </div>

        {{-- Contenido principal --}}
        <div class="flex-1 flex overflow-hidden">
            {{-- Panel izquierdo: Logo y Favicon --}}
            <div class="w-[350px] border-r border-accent-100 bg-accent-50 overflow-y-auto">
                <div class="p-4 space-y-6">
                    {{-- Logo de la Tienda --}}
                    <div>
                        <h2 class="text-base font-semibold text-black-500 mb-3">Logo de la Tienda</h2>
                        <div x-data="imageUploader('logo')" class="space-y-3">
                            <div class="flex items-center justify-center w-full h-32 bg-accent-100 rounded-lg overflow-hidden">
                                <template x-if="!preview && !currentLogo">
                                    <div class="text-center p-4">
                                        <x-solar-gallery-add-outline class="w-6 h-6 mx-auto text-black-300" />
                                        <p class="mt-2 text-black-300 text-sm">Arrastra tu logo aquí o haz clic para seleccionar</p>
                                    </div>
                                </template>
                                <template x-if="preview || currentLogo">
                                    <img :src="preview || currentLogo" class="object-contain w-full h-full" alt="Logo preview">
                                </template>
                            </div>
                            <input type="file" x-ref="fileInput" @change="handleFileSelect" class="hidden" accept="image/*">
                            <div class="flex items-center gap-2">
                                <button @click="$refs.fileInput.click()" class="btn-secondary flex-1 flex items-center justify-center gap-2 py-2">
                                    <x-solar-upload-outline class="w-4 h-4" />
                                    Subir Logo
                                </button>
                                <button x-show="preview || currentLogo" @click="removeImage" class="btn-error flex items-center justify-center gap-2 py-2 px-3">
                                    <x-solar-trash-bin-trash-outline class="w-4 h-4" />
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Favicon --}}
                    <div>
                        <h2 class="text-base font-semibold text-black-500 mb-3">Favicon</h2>
                        <div x-data="imageUploader('favicon')" class="space-y-3">
                            <div class="flex items-center justify-center w-full h-32 bg-accent-100 rounded-lg overflow-hidden">
                                <template x-if="!preview && !currentFavicon">
                                    <div class="text-center p-4">
                                        <x-solar-gallery-add-outline class="w-6 h-6 mx-auto text-black-300" />
                                        <p class="mt-2 text-black-300 text-sm">Arrastra el favicon aquí o haz clic para seleccionar</p>
                                    </div>
                                </template>
                                <template x-if="preview || currentFavicon">
                                    <img :src="preview || currentFavicon" class="object-contain w-full h-full" alt="Favicon preview">
                                </template>
                            </div>
                            <input type="file" x-ref="fileInput" @change="handleFileSelect" class="hidden" accept="image/*">
                            <div class="flex items-center gap-2">
                                <button @click="$refs.fileInput.click()" class="btn-secondary flex-1 flex items-center justify-center gap-2 py-2">
                                    <x-solar-upload-outline class="w-4 h-4" />
                                    Subir Favicon
                                </button>
                                <button x-show="preview || currentFavicon" @click="removeImage" class="btn-error flex items-center justify-center gap-2 py-2 px-3">
                                    <x-solar-trash-bin-trash-outline class="w-4 h-4" />
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel central: Colores del Header --}}
            <div class="flex-1 bg-accent-50 border-r border-accent-100 overflow-y-auto">
                <div class="p-4">
                    <div x-data="headerDesign">
                        <h2 class="text-base font-semibold text-black-500 mb-3">Colores del Header</h2>
                        <div class="space-y-4">
                            {{-- Color de Fondo --}}
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-black-400">Color de Fondo</label>
                                <x-tenant-admin::color-picker 
                                    model-name="bgColor"
                                    required
                                />
                            </div>

                            {{-- Color del Texto --}}
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-black-400">Color del Texto</label>
                                <x-tenant-admin::color-picker 
                                    model-name="textColor"
                                    required
                                />
                            </div>

                            {{-- Color de la Descripción --}}
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-black-400">Color de la Descripción</label>
                                <x-tenant-admin::color-picker 
                                    model-name="descriptionColor"
                                    required
                                />
                            </div>
                        </div>

                        {{-- Nueva Sección: Información de la Tienda --}}
                        <div class="mt-8 pt-6 border-t border-accent-200">
                            <h2 class="text-base font-semibold text-black-500 mb-3">Información de la Tienda</h2>
                            <div class="space-y-4">
                                {{-- Nombre de la Tienda --}}
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-black-400">Nombre de la Tienda</label>
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            name="store_name"
                                            id="store_name_input"
                                            x-model="storeName"
                                            @input="updatePreview"
                                            maxlength="40"
                                            class="w-full px-3 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none text-sm"
                                            placeholder="Nombre de tu tienda"
                                        >
                                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-xs text-black-300">
                                            <span x-text="(storeName || '').length"></span>/40
                                        </div>
                                    </div>
                                    <p class="text-xs text-black-300">Letras, números, espacios, guiones y acentos permitidos</p>
                                </div>

                                {{-- Descripción de la Tienda --}}
                                <div class="space-y-2">
                                    <label class="text-sm font-medium text-black-400">Descripción de la Tienda</label>
                                    <div class="relative">
                                        <input 
                                            type="text" 
                                            name="store_description"
                                            id="store_description_input"
                                            x-model="storeDescription"
                                            @input="updatePreview"
                                            maxlength="50"
                                            class="w-full px-3 py-2 border border-accent-200 rounded-lg focus:border-primary-200 focus:ring-1 focus:ring-primary-200 focus:outline-none text-sm"
                                            placeholder="Breve descripción de tu tienda"
                                        >
                                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-xs text-black-300">
                                            <span x-text="(storeDescription || '').length"></span>/50
                                        </div>
                                    </div>
                                    <p class="text-xs text-black-300">Describe brevemente qué ofrece tu tienda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel derecho: Vista Previa --}}
            <div class="w-[450px] bg-accent-100 overflow-y-auto p-4">
                <h2 class="text-base font-semibold text-black-500 mb-3">Vista Previa</h2>
                <div class="rounded-xl overflow-hidden shadow-lg">
                    <x-tenant-admin::header-preview :store="$store" :design="$design" />
                </div>
            </div>
        </div>

        {{-- Historial (Abajo) --}}
        <div class="bg-accent-50 border-t border-accent-100 p-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-base font-semibold text-black-500 mb-3">Historial de Cambios</h2>
                <div class="space-y-3">
                    @forelse($history as $version)
                        <div class="p-3 rounded-lg bg-accent-100">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-black-400">
                                        {{ $version->created_at->diffForHumans() }}
                                    </p>
                                    <button 
                                        x-data
                                        @click="$dispatch('revert-design', { historyId: {{ $version->id }} })"
                                        class="btn-secondary text-sm py-1 px-2"
                                    >
                                        Restaurar
                                    </button>
                                </div>
                                @if($version->note)
                                    <p class="text-sm text-black-300">
                                        {{ $version->note }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-3 rounded-lg bg-accent-100">
                            <p class="text-sm text-black-300 text-center">
                                No hay cambios registrados
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    

    @push('scripts')
    <script>
        // Inicializar el diseño con los datos del servidor
        window.initialDesign = @json($initialDesign);
        
        // Función para manejar la publicación del diseño (disponible globalmente)
        window.publishDesign = function() {
            console.log('=== PUBLISH DESIGN FUNCTION CALLED ===');
            
            try {
                // Get store slug from the URL
                const storePath = window.location.pathname.split('/')[1];
                console.log('Store path:', storePath);
                
                // Crear FormData para enviar archivos y datos
                const formData = new FormData();
                
                // Colores: leer primero de los inputs visibles; fallback al store
                const designStore = window.Alpine?.store('design') || {};
                const bgInput = document.getElementById('color_input_bgColor');
                const textInput = document.getElementById('color_input_textColor');
                const descInputColor = document.getElementById('color_input_descriptionColor');
                const bgColor = (bgInput?.value || designStore.bgColor || '#FFFFFF');
                const textColor = (textInput?.value || designStore.textColor || '#000000');
                const descriptionColor = (descInputColor?.value || designStore.descriptionColor || '#666666');
                console.log('Colors to publish:', { bgColor, textColor, descriptionColor });
                formData.append('header_background_color', bgColor);
                formData.append('header_text_color', textColor);
                formData.append('header_description_color', descriptionColor);
                
                // Nombre/Descripción: inputs visibles primero; fallback al store
                const storeDesign = window.Alpine?.store('design');
                const nameInput = document.getElementById('store_name_input');
                const descInput = document.getElementById('store_description_input');
                let nameToSend = (nameInput?.value ?? '').toString().trim();
                let descToSend = (descInput?.value ?? '').toString();
                if (!nameToSend && storeDesign) nameToSend = (storeDesign.storeName ?? '').toString().trim();
                if (!descToSend && storeDesign) descToSend = (storeDesign.storeDescription ?? '').toString();
                formData.append('store_name', nameToSend);
                formData.append('store_description', descToSend);
                console.log('Store info found:', { name: nameToSend, description: descToSend });
                
                // Realizar petición POST
                fetch(`/${storePath}/admin/store-design/publish`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response:', data);
                    if (data.message) {
                        showMessage(data.message, 'success');
                    }
                    if (data.design) {
                        console.log('Design updated:', data.design);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('Error al publicar el diseño', 'error');
                });
                
            } catch (error) {
                console.error('Publish error:', error);
                showMessage('Error al publicar el diseño', 'error');
            }
        };
        
        // Función para mostrar mensajes
        function showMessage(message, type = 'success') {
            const messageDiv = document.createElement('div');
            messageDiv.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 ${
                type === 'success' ? 'bg-success-200 text-black-500' : 'bg-error-200 text-error-50'
            }`;
            
            const icon = type === 'success' 
                ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
                : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            
            messageDiv.innerHTML = `${icon}<span>${message}</span>`;
            document.body.appendChild(messageDiv);
            
            setTimeout(() => {
                messageDiv.remove();
            }, 3000);
        }
        
        // Inicializar Alpine.js components cuando esté listo
        document.addEventListener('alpine:init', () => {
            // Store de diseño simplificado
            Alpine.store('design', {
                bgColor: window.initialDesign?.bgColor || '#FFFFFF',
                textColor: window.initialDesign?.textColor || '#000000',
                descriptionColor: window.initialDesign?.descriptionColor || '#666666',
                logo: window.initialDesign?.logo || null,
                favicon: window.initialDesign?.favicon || null,
                storeName: @json($store->name),
                storeDescription: @json($store->description)
            });
            
            // Color picker simplificado
            Alpine.data('colorPicker', (modelName) => ({
                color: '',
                isOpen: false,
                error: null,
                
                init() {
                    this.color = this.$store?.design?.[modelName] || '#FFFFFF';
                },
                
                open() { this.isOpen = true; },
                close() { this.isOpen = false; },
                
                setColor(color) {
                    this.color = color;
                    if (this.$store?.design) {
                        this.$store.design[modelName] = color;
                    }
                    this.close();
                },
                
                validate() {
                    // Validación básica
                }
            }));
            
            // Image uploader simplificado
            Alpine.data('imageUploader', (type) => ({
                preview: null,
                currentImage: null,
                error: null,
                
                init() {
                    this.currentImage = this.$store?.design?.[type] || null;
                },
                
                get currentLogo() {
                    return type === 'logo' ? this.currentImage : null;
                },
                
                get currentFavicon() {
                    return type === 'favicon' ? this.currentImage : null;
                },
                
                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.preview = e.target.result;
                            if (this.$store?.design) {
                                this.$store.design[type] = e.target.result;
                            }
                            // Enviar automáticamente al servidor
                            this.updateDesign(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                },
                
                removeImage() {
                    this.preview = null;
                    this.currentImage = null;
                    if (this.$store?.design) {
                        this.$store.design[type] = null;
                    }
                    // Enviar el cambio al servidor (eliminar imagen)
                    this.updateDesign('');
                },
                
                updateDesign(imageData) {
                    const storePath = window.location.pathname.split('/')[1];
                    const formData = new FormData();
                    
                    // Agregar colores actuales del store
                    formData.append('header_background_color', this.$store.design.bgColor || '#FFFFFF');
                    formData.append('header_text_color', this.$store.design.textColor || '#000000');
                    formData.append('header_description_color', this.$store.design.descriptionColor || '#666666');
                    
                    // Agregar imagen específica
                    if (type === 'logo') {
                        formData.append('logo_base64', imageData);
                    } else if (type === 'favicon') {
                        formData.append('favicon_base64', imageData);
                    }
                    
                    fetch(`/${storePath}/admin/store-design/update`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Design updated:', data);
                        if (data.design) {
                            // Actualizar las URLs actuales
                            if (type === 'logo' && data.design.logo_url) {
                                this.currentImage = data.design.logo_url;
                                this.$store.design.logo = data.design.logo_url;
                            } else if (type === 'favicon' && data.design.favicon_url) {
                                this.currentImage = data.design.favicon_url;
                                this.$store.design.favicon = data.design.favicon_url;
                            }
                            this.preview = null; // Limpiar preview después de guardar
                        }
                    })
                    .catch(error => {
                        console.error('Error updating design:', error);
                        this.error = 'Error al subir la imagen';
                    });
                }
            }));
            
            // Header design component
            Alpine.data('headerDesign', () => ({
                storeName: @json($store->name),
                storeDescription: @json($store->description),
                
                init() {
                    // Inicializar datos en el store global para la vista previa
                    if (this.$store && this.$store.design) {
                        this.$store.design.storeName = this.storeName;
                        this.$store.design.storeDescription = this.storeDescription;
                    }
                },
                
                updatePreview() {
                    // Validar caracteres permitidos para nombre
                    this.storeName = this.sanitizeName(this.storeName);
                    
                    // Validar caracteres permitidos para descripción
                    this.storeDescription = this.sanitizeDescription(this.storeDescription);
                    
                    // Actualizar el store global para vista previa
                    if (this.$store && this.$store.design) {
                        this.$store.design.storeName = this.storeName;
                        this.$store.design.storeDescription = this.storeDescription;
                    }
                },
                
                sanitizeName(text) {
                    const safe = (text ?? '').toString();
                    return safe.replace(/[^a-zA-Z0-9\s\-áéíóúñÁÉÍÓÚÑüÜ\.]/g, '');
                },
                
                sanitizeDescription(text) {
                    const safe = (text ?? '').toString();
                    return safe.replace(/[^a-zA-Z0-9\s\-áéíóúñÁÉÍÓÚÑüÜ\.,¿?!:]/g, '');
                }
            }));
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 