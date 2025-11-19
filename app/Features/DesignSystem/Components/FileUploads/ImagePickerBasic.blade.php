{{--
Image Picker Basic - Selector de imagen con previsualización
Uso: Permite seleccionar una imagen, previsualizarla y emitir eventos hacia Alpine
Cuándo usar: Cuando necesites subir un logo, favicon o una imagen única
Cuándo NO usar: Cuando requieras subir múltiples archivos o manejar colas complejas
Eventos emitidos:
- image-selected: { name, base64, fileName }
- image-removed: { name }
Ejemplo: <x-image-picker-basic name="logo" label="Logo" />
--}}

@props([
    'label' => null,
    'name' => 'image',
    'currentUrl' => null,
    'helper' => null,
    'accept' => 'image/*',
    'showRemove' => true,
])

<div
    x-data="(() => {
        return {
            preview: null,
            current: @js($currentUrl),
            error: null,
            fileName: null,
            selectFile(event) {
                const file = event.target.files[0];
                if (!file) {
                    return;
                }
                this.fileName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.preview = e.target.result;
                    this.error = null;
                    this.$dispatch('image-selected', {
                        name: '{{ $name }}',
                        base64: e.target.result,
                        fileName: file.name,
                    });
                };
                reader.onerror = () => {
                    this.error = 'No se pudo leer el archivo seleccionado.';
                };
                reader.readAsDataURL(file);
            },
            openFilePicker() {
                this.$refs.fileInput.click();
            },
            removeImage() {
                this.preview = null;
                this.current = null;
                this.fileName = null;
                this.$refs.fileInput.value = '';
                this.$dispatch('image-removed', {
                    name: '{{ $name }}',
                });
            },
            handleUpdated(detail) {
                if (!detail || detail.name !== '{{ $name }}') {
                    return;
                }
                this.preview = null;
                this.current = detail.url || null;
                this.fileName = detail.fileName || null;
            }
        };
    })()"
    x-on:image-updated.window="handleUpdated($event.detail)"
    class="space-y-3"
>
    @if($label)
        <div class="flex items-center justify-between">
            <label class="text-sm font-semibold text-gray-800">{{ $label }}</label>
            <template x-if="fileName">
                <span class="text-xs text-gray-500" x-text="fileName"></span>
            </template>
        </div>
    @endif

    <div class="flex items-center gap-4">
        <div class="flex h-24 w-24 items-center justify-center overflow-hidden rounded-xl border border-gray-200 bg-gray-50">
            <template x-if="preview">
                <img :src="preview" alt="Previsualización" class="h-full w-full object-contain" />
            </template>
            <template x-if="!preview && current">
                <img :src="current" alt="Imagen actual" class="h-full w-full object-contain" />
            </template>
            <template x-if="!preview && !current">
                <div class="flex flex-col items-center gap-1 text-gray-400">
                    <i data-lucide="image" class="size-6"></i>
                    <span class="text-xs font-medium">Sin imagen</span>
                </div>
            </template>
        </div>

        <div class="flex-1 space-y-2">
            <div class="flex flex-wrap gap-2">
                <x-button-icon
                    type="outline"
                    color="secondary"
                    size="sm"
                    icon="upload"
                    text="Seleccionar"
                    html-type="button"
                    @click="openFilePicker()"
                />
                @if($showRemove)
                    <x-button-icon
                        type="outline"
                        color="error"
                        size="sm"
                        icon="trash-2"
                        text="Eliminar"
                        html-type="button"
                        @click="removeImage()"
                        x-bind:disabled="!preview && !current"
                    />
                @endif
            </div>
            @if($helper)
                <p class="text-xs text-gray-500">{{ $helper }}</p>
            @endif
            <p x-show="error" x-text="error" class="text-xs text-error-500"></p>
        </div>
    </div>

    <input
        type="file"
        x-ref="fileInput"
        class="hidden"
        accept="{{ $accept }}"
        @change="selectFile"
    >
</div>
