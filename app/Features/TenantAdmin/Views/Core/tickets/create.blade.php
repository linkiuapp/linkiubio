<x-tenant-admin-layout :store="$store">
    @section('title', 'Crear Ticket de Soporte')

    @section('content')
    <div class="max-w-4xl mx-auto space-y-6 mt-6" x-data="createTicket()">
        <x-toast-notification />

        {{-- SECTION: Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Crear Ticket de Soporte</h1>
                <p class="text-sm text-gray-600 mt-1">
                    Envía tu consulta o problema a nuestro equipo
                </p>
            </div>
            <a href="{{ route('tenant.admin.tickets.index', ['store' => $store->slug]) }}">
                <x-button-icon 
                    type="outline" 
                    color="secondary" 
                    icon="arrow-left"
                    size="md"
                    text="Volver"
                />
            </a>
        </div>
        {{-- End SECTION: Header --}}

        <form action="{{ route('tenant.admin.tickets.store', ['store' => $store->slug]) }}" 
              method="POST" 
              enctype="multipart/form-data"
              @submit.prevent="submitForm">
            @csrf
            
            {{-- SECTION: Información del Ticket --}}
            <x-card-base shadow="sm">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h2 class="text-base font-semibold text-gray-900">Información del Ticket</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Columna izquierda --}}
                    <div class="space-y-4">
                        <div>
                            <x-select-basic 
                                name="category"
                                select-id="category"
                                label="Categoría *"
                                :options="array_merge(['' => 'Selecciona una categoría'], $categories)"
                                :selected="old('category', '')"
                                required
                            />
                            @error('category')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-select-basic 
                                name="priority"
                                select-id="priority"
                                label="Prioridad *"
                                :options="[
                                    '' => 'Selecciona la prioridad',
                                    'low' => 'Baja',
                                    'medium' => 'Media',
                                    'high' => 'Alta',
                                    'urgent' => 'Urgente'
                                ]"
                                :selected="old('priority', 'medium')"
                                required
                            />
                            @error('priority')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-with-label 
                                label="Asunto *"
                                name="title"
                                type="text"
                                :value="old('title')"
                                placeholder="Describe brevemente tu problema"
                                required
                                maxlength="255"
                            />
                            @error('title')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Columna derecha --}}
                    <div class="space-y-4">
                        <x-card-base shadow="none" class="bg-gray-50">
                            <div class="space-y-3">
                                <h3 class="font-semibold text-gray-900 mb-3">Información Automática</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tienda:</span>
                                        <span class="text-gray-900 font-medium">{{ $store->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Plan:</span>
                                        <span class="text-gray-900 font-medium">{{ $store->plan->name ?? 'Sin plan' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Usuario:</span>
                                        <span class="text-gray-900 font-medium">{{ auth()->user()->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Fecha:</span>
                                        <span class="text-gray-900 font-medium">{{ now()->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </x-card-base>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Archivos Adjuntos
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors"
                                 x-on:dragover.prevent
                                 x-on:drop.prevent="handleFileDrop($event)">
                                <input type="file" 
                                       name="attachments[]" 
                                       multiple
                                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                                       class="hidden"
                                       x-ref="fileInput"
                                       x-on:change="handleFileSelect($event)">
                                <div class="cursor-pointer" x-on:click="$refs.fileInput.click()">
                                    <i data-lucide="upload" class="w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                                    <p class="text-sm text-gray-600">
                                        Arrastra archivos aquí o <span class="text-gray-900 font-medium">haz clic para seleccionar</span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Máximo 3 archivos, 5MB cada uno (JPG, PNG, PDF, DOC, TXT)
                                    </p>
                                </div>
                            </div>

                            {{-- Lista de archivos seleccionados --}}
                            <div x-show="selectedFiles.length > 0" class="mt-3 space-y-2">
                                <template x-for="(file, index) in selectedFiles" :key="index">
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                        <div class="flex items-center gap-2">
                                            <i data-lucide="file" class="w-4 h-4 text-gray-400"></i>
                                            <span class="text-sm text-gray-700" x-text="file.name"></span>
                                            <span class="text-xs text-gray-500" x-text="formatFileSize(file.size)"></span>
                                        </div>
                                        <button type="button" 
                                                x-on:click="removeFile(index)"
                                                class="text-red-600 hover:text-red-700">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            @error('attachments.*')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Descripción (ancho completo) --}}
                <div class="mt-6">
                    <x-textarea-with-label 
                        label="Descripción *"
                        name="description"
                        rows="6"
                        placeholder="Describe detalladamente tu problema o consulta..."
                        required
                        maxlength="5000"
                    >{{ old('description') }}</x-textarea-with-label>
                    <div class="flex justify-between mt-1">
                        @error('description')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="text-xs text-gray-500">Sé lo más específico posible para una respuesta más rápida</p>
                        @enderror
                        <p class="text-xs text-gray-500">Máximo 5000 caracteres</p>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('tenant.admin.tickets.index', ['store' => $store->slug]) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium">
                        Cancelar
                    </a>
                    <button type="submit" 
                            x-bind:disabled="isSubmitting"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-sm font-medium">
                        <i data-lucide="send" class="w-4 h-4"></i>
                        <span x-text="isSubmitting ? 'Creando...' : 'Crear Ticket'"></span>
                    </button>
                </div>
            </x-card-base>
            {{-- End SECTION: Información del Ticket --}}
        </form>
    </div>

    @push('scripts')
    <script>
    function createTicket() {
        return {
            selectedFiles: [],
            isSubmitting: false,

            init() {
                @if($errors->any())
                    this.isSubmitting = false;
                @endif
            },

            submitForm(event) {
                const form = event.target.closest('form');
                if (form.checkValidity()) {
                    this.isSubmitting = true;
                    form.submit();
                } else {
                    form.reportValidity();
                }
            },

            handleFileSelect(event) {
                this.processFiles(Array.from(event.target.files));
            },

            handleFileDrop(event) {
                this.processFiles(Array.from(event.dataTransfer.files));
            },

            processFiles(files) {
                const maxFiles = 3;
                const validFiles = files.slice(0, maxFiles - this.selectedFiles.length);
                
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'];
                const maxSize = 5 * 1024 * 1024; // 5MB

                validFiles.forEach(file => {
                    if (allowedTypes.includes(file.type) && file.size <= maxSize) {
                        this.selectedFiles.push(file);
                    } else {
                        if (window.toast) {
                            window.toast.error(
                                'Archivo inválido',
                                file.name + ' no cumple con los requisitos (tipo o tamaño)',
                                5000,
                                'bottom-center'
                            );
                        }
                    }
                });

                this.updateFileInput();
            },

            removeFile(index) {
                this.selectedFiles.splice(index, 1);
                this.updateFileInput();
            },

            updateFileInput() {
                const dt = new DataTransfer();
                this.selectedFiles.forEach(file => dt.items.add(file));
                this.$refs.fileInput.files = dt.files;
            },

            formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        }
    }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>
