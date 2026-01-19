@extends('shared::layouts.admin')

@section('title', 'Crear Tutorial')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.tutorials.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Crear Nuevo Tutorial</h1>
                <p class="text-sm text-gray-600 mt-1">Crea una guía paso a paso para los usuarios</p>
            </div>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    <form action="{{ route('superlinkiu.tutorials.store') }}" 
          method="POST" 
          enctype="multipart/form-data"
          onsubmit="return validateTinyMCE()">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- SECTION: Contenido Principal --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- SECTION: Información Básica --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Información Básica</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Título del Tutorial <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="Ej: Cómo crear un producto"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('title') border-red-300 @enderror"
                                   required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Slug (URL amigable)
                            </label>
                            <input type="text" 
                                   name="slug" 
                                   value="{{ old('slug') }}"
                                   placeholder="Se genera automáticamente si se deja vacío"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('slug') border-red-300 @enderror">
                            @error('slug')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Deja vacío para generar automáticamente desde el título</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción Corta
                            </label>
                            <textarea name="description" 
                                      rows="3"
                                      placeholder="Breve descripción del tutorial..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Contenido <span class="text-red-500">*</span>
                            </label>

                            <textarea name="content" 
                                      id="content"
                                      rows="15"
                                      class="w-full @error('content') border-red-300 @enderror">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Editor visual WYSIWYG - Escribe y formatea sin necesidad de HTML. Puedes arrastrar y soltar imágenes directamente.</p>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Información Básica --}}

                {{-- SECTION: Multimedia --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Multimedia</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Imagen Cover (Vista General)
                            </label>
                            <input type="file" 
                                   name="featured_image" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('featured_image') border-red-300 @enderror">
                            @error('featured_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Se muestra en el listado de tutoriales. Formatos: JPEG, PNG, JPG, GIF, WEBP. Máximo 2MB</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Imagen Portada (Vista Individual)
                            </label>
                            <input type="file" 
                                   name="portada_image" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('portada_image') border-red-300 @enderror">
                            @error('portada_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Se muestra en la vista individual del tutorial. Medidas recomendadas: 830x200px. Formatos: JPEG, PNG, JPG, GIF, WEBP. Máximo 2MB</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                URL del Video (Opcional)
                            </label>
                            <input type="url" 
                                   name="video_url" 
                                   value="{{ old('video_url') }}"
                                   placeholder="https://www.youtube.com/watch?v=... o https://vimeo.com/..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('video_url') border-red-300 @enderror">
                            @error('video_url')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Soporta YouTube y Vimeo</p>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Multimedia --}}
            </div>
            {{-- End SECTION: Contenido Principal --}}

            {{-- SECTION: Configuración Lateral --}}
            <div class="space-y-6">
                {{-- SECTION: Categoría y Configuración --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Configuración</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Categoría <span class="text-red-500">*</span>
                            </label>
                            <select name="category_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('category_id') border-red-300 @enderror"
                                    required>
                                <option value="">Selecciona una categoría</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nivel de Dificultad <span class="text-red-500">*</span>
                            </label>
                            <select name="difficulty_level" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('difficulty_level') border-red-300 @enderror"
                                    required>
                                @foreach($difficulties as $key => $label)
                                    <option value="{{ $key }}" {{ old('difficulty_level', 'beginner') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('difficulty_level')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Orden
                            </label>
                            <input type="number" 
                                   name="order" 
                                   value="{{ old('order', 0) }}"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('order') border-red-300 @enderror">
                            @error('order')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Número para ordenar los tutoriales (menor = primero)</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                Tutorial activo
                            </label>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Categoría y Configuración --}}

                {{-- SECTION: Etiquetas --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Etiquetas</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-2 max-h-64 overflow-y-auto">
                            @forelse($tags as $tag)
                                <label class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded cursor-pointer">
                                    <input type="checkbox" 
                                           name="tags[]" 
                                           value="{{ $tag->id }}"
                                           {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-600">No hay etiquetas disponibles</p>
                            @endforelse
                        </div>
                        <p class="text-xs text-gray-500 mt-3">
                            Las etiquetas ayudan a los usuarios a encontrar tutoriales relacionados
                        </p>
                    </div>
                </div>
                {{-- End SECTION: Etiquetas --}}
            </div>
            {{-- End SECTION: Configuración Lateral --}}
        </div>

        {{-- SECTION: Actions --}}
        <div class="flex items-center justify-end gap-4 pt-6">
            <a href="{{ route('superlinkiu.tutorials.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-medium transition-colors">
                Crear Tutorial
            </button>
        </div>
        {{-- End SECTION: Actions --}}
    </form>
</div>

@push('scripts')
{{-- TinyMCE CDN --}}
<script src="https://cdn.tiny.cloud/1/do5np1q80r9ez92agz8y9snks9n3egskv7qssw6lkwo1wvxf/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Inicializar TinyMCE
        tinymce.init({
            selector: '#content',
            height: 600,
            menubar: true,
            plugins: [
                // Core editing features (plan gratuito)
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount', 'image'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
            
            // Configurar upload de imágenes (usando nuestro endpoint)
            images_upload_handler: function (blobInfo, progress) {
                return new Promise(function (resolve, reject) {
                    const xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '{{ route("superlinkiu.tutorials.upload-image") }}');

                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.setRequestHeader('Accept', 'application/json');

                    xhr.upload.onprogress = function (e) {
                        progress(e.loaded / e.total * 100);
                    };

                    xhr.onload = function () {
                        if (xhr.status === 403) {
                            reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                            return;
                        }

                        if (xhr.status < 200 || xhr.status >= 300) {
                            reject('HTTP Error: ' + xhr.status);
                            return;
                        }

                        const json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.url != 'string') {
                            reject('Invalid JSON: ' + xhr.responseText);
                            return;
                        }

                        resolve(json.url);
                    };

                    xhr.onerror = function () {
                        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                    };

                    const formData = new FormData();
                    formData.append('image', blobInfo.blob(), blobInfo.filename());
                    formData.append('_token', '{{ csrf_token() }}');

                    xhr.send(formData);
                });
            },
            
            // Permitir drag & drop de imágenes
            paste_data_images: true,
            
            // Configurar inserción de video
            media_live_embeds: true,
            
            // Idioma español
            language: 'es',
            language_url: 'https://cdn.tiny.cloud/1/do5np1q80r9ez92agz8y9snks9n3egskv7qssw6lkwo1wvxf/tinymce/8/langs/es.js'
        });
    });

    // Validar contenido de TinyMCE antes de enviar formulario
    function validateTinyMCE() {
        const editor = tinymce.get('content');
        if (!editor) {
            alert('El editor no está inicializado. Por favor, espera un momento e intenta nuevamente.');
            return false;
        }
        
        // Sincronizar contenido de TinyMCE al textarea antes de validar
        editor.save();
        
        const content = editor.getContent({ format: 'text' }).trim();
        if (!content || content.length === 0) {
            alert('El contenido es requerido. Por favor, agrega contenido al tutorial.');
            editor.focus();
            return false;
        }
        
        return true;
    }
</script>
@endpush
@endsection
