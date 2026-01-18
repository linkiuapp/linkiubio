@extends('shared::layouts.admin')

@section('title', 'Editar Tutorial')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 mt-6">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.tutorials.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Editar Tutorial</h1>
                <p class="text-sm text-gray-600 mt-1">{{ $tutorial->title }}</p>
            </div>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    <form action="{{ route('superlinkiu.tutorials.update', $tutorial) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                   value="{{ old('title', $tutorial->title) }}"
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
                                   value="{{ old('slug', $tutorial->slug) }}"
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
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('description') border-red-300 @enderror">{{ old('description', $tutorial->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Contenido <span class="text-red-500">*</span>
                            </label>
                            
                            {{-- Toolbar del Editor --}}
                            <div class="mb-2 flex items-center gap-2 flex-wrap p-2 bg-gray-50 rounded-lg border border-gray-200">
                                <button type="button" 
                                        onclick="insertAtCursor('content', '<p></p>')"
                                        class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors"
                                        title="Párrafo">
                                    P
                                </button>
                                <button type="button" 
                                        onclick="insertAtCursor('content', '<strong></strong>')"
                                        class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors"
                                        title="Negrita">
                                    <strong>B</strong>
                                </button>
                                <button type="button" 
                                        onclick="insertAtCursor('content', '<em></em>')"
                                        class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors"
                                        title="Cursiva">
                                    <em>I</em>
                                </button>
                                <button type="button" 
                                        onclick="insertAtCursor('content', '<ul><li></li></ul>')"
                                        class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50 transition-colors"
                                        title="Lista">
                                    • Lista
                                </button>
                                <div class="w-px h-6 bg-gray-300"></div>
                                <button type="button" 
                                        onclick="openImageUpload('content')"
                                        class="px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100 transition-colors flex items-center gap-1"
                                        title="Insertar Imagen">
                                    <i data-lucide="image" class="w-4 h-4"></i> Imagen
                                </button>
                                <button type="button" 
                                        onclick="openVideoInsert('content')"
                                        class="px-3 py-1.5 text-xs font-medium text-purple-700 bg-purple-50 border border-purple-200 rounded hover:bg-purple-100 transition-colors flex items-center gap-1"
                                        title="Insertar Video">
                                    <i data-lucide="video" class="w-4 h-4"></i> Video
                                </button>
                            </div>

                            <textarea name="content" 
                                      id="content"
                                      rows="15"
                                      placeholder="Escribe el contenido del tutorial aquí. Usa los botones de arriba para insertar imágenes y videos..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none font-mono text-sm @error('content') border-red-300 @enderror"
                                      required>{{ old('content', $tutorial->content) }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Puedes usar HTML básico. Usa los botones para insertar imágenes y videos fácilmente.</p>
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
                        {{-- Cover (Vista General) --}}
                        @if($tutorial->featured_image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Cover Actual (Vista General)
                                </label>
                                <img src="{{ Storage::disk('public')->url($tutorial->featured_image) }}" 
                                     alt="{{ $tutorial->title }}"
                                     class="w-full max-w-md h-auto rounded-lg border border-gray-200">
                                <p class="text-xs text-gray-500 mt-2">Sube una nueva imagen para reemplazarla</p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $tutorial->featured_image ? 'Nueva Imagen Cover' : 'Imagen Cover (Vista General)' }}
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

                        {{-- Portada (Vista Individual) --}}
                        @if($tutorial->portada_image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Portada Actual (Vista Individual)
                                </label>
                                <img src="{{ Storage::disk('public')->url($tutorial->portada_image) }}" 
                                     alt="{{ $tutorial->title }}"
                                     class="w-full max-w-md h-auto rounded-lg border border-gray-200"
                                     style="max-width: 830px; max-height: 200px; object-fit: cover;">
                                <p class="text-xs text-gray-500 mt-2">Sube una nueva imagen para reemplazarla</p>
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $tutorial->portada_image ? 'Nueva Imagen Portada' : 'Imagen Portada (Vista Individual)' }}
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
                                   value="{{ old('video_url', $tutorial->video_url) }}"
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
                                    <option value="{{ $category->id }}" {{ old('category_id', $tutorial->category_id) == $category->id ? 'selected' : '' }}>
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
                                    <option value="{{ $key }}" {{ old('difficulty_level', $tutorial->difficulty_level) == $key ? 'selected' : '' }}>
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
                                   value="{{ old('order', $tutorial->order) }}"
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
                                   {{ old('is_active', $tutorial->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                Tutorial activo
                            </label>
                        </div>

                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-2">Estadísticas</p>
                            <div class="space-y-1 text-xs text-gray-500">
                                <p>Vistas: <span class="font-medium text-gray-700">{{ number_format($tutorial->views_count) }}</span></p>
                                <p>Creado: <span class="font-medium text-gray-700">{{ $tutorial->created_at->format('d/m/Y H:i') }}</span></p>
                                <p>Actualizado: <span class="font-medium text-gray-700">{{ $tutorial->updated_at->format('d/m/Y H:i') }}</span></p>
                            </div>
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
                                           {{ in_array($tag->id, old('tags', $tutorial->tags->pluck('id')->toArray())) ? 'checked' : '' }}
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
                Actualizar Tutorial
            </button>
        </div>
        {{-- End SECTION: Actions --}}
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });

    // Función para insertar texto en el cursor
    function insertAtCursor(textareaId, text) {
        const textarea = document.getElementById(textareaId);
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const value = textarea.value;
        
        // Si hay texto seleccionado, envolverlo
        if (start !== end) {
            const selectedText = value.substring(start, end);
            if (text.includes('</strong>')) {
                textarea.value = value.substring(0, start) + '<strong>' + selectedText + '</strong>' + value.substring(end);
                textarea.selectionStart = textarea.selectionEnd = start + 8 + selectedText.length;
            } else if (text.includes('</em>')) {
                textarea.value = value.substring(0, start) + '<em>' + selectedText + '</em>' + value.substring(end);
                textarea.selectionStart = textarea.selectionEnd = start + 4 + selectedText.length;
            } else {
                textarea.value = value.substring(0, start) + text + value.substring(end);
                textarea.selectionStart = textarea.selectionEnd = start + text.length;
            }
        } else {
            // Insertar en la posición del cursor
            textarea.value = value.substring(0, start) + text + value.substring(end);
            // Posicionar cursor dentro de las etiquetas
            if (text.includes('</strong>')) {
                textarea.selectionStart = textarea.selectionEnd = start + 8;
            } else if (text.includes('</em>')) {
                textarea.selectionStart = textarea.selectionEnd = start + 4;
            } else if (text.includes('</p>')) {
                textarea.selectionStart = textarea.selectionEnd = start + 3;
            } else if (text.includes('</li>')) {
                textarea.selectionStart = textarea.selectionEnd = start + 4;
            } else {
                textarea.selectionStart = textarea.selectionEnd = start + text.length;
            }
        }
        textarea.focus();
    }

    // Función para abrir modal de subida de imagen
    function openImageUpload(textareaId) {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/jpeg,image/png,image/jpg,image/gif,image/webp';
        input.onchange = function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Crear FormData
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            // Mostrar loading
            const loading = document.createElement('div');
            loading.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            loading.innerHTML = '<div class="bg-white p-6 rounded-lg"><p class="text-gray-700">Subiendo imagen...</p></div>';
            document.body.appendChild(loading);

            // Subir imagen
            fetch('{{ route("superlinkiu.tutorials.upload-image") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    // Si no es JSON, leer como texto para ver el error
                    const text = await response.text();
                    throw new Error('El servidor devolvió una respuesta no válida. ' + text.substring(0, 200));
                }
            })
            .then(data => {
                document.body.removeChild(loading);
                if (data.success && data.url) {
                    // Insertar imagen en el contenido
                    const imgTag = '<img src="' + data.url + '" alt="Imagen" class="max-w-full h-auto rounded-lg my-4">';
                    insertAtCursor(textareaId, imgTag);
                } else {
                    alert('Error al subir la imagen: ' + (data.message || 'Error desconocido'));
                }
            })
            .catch(error => {
                document.body.removeChild(loading);
                alert('Error al subir la imagen: ' + error.message);
            });
        };
        input.click();
    }

    // Función para insertar video
    function openVideoInsert(textareaId) {
        const url = prompt('Ingresa la URL del video (YouTube o Vimeo):');
        if (!url) return;

        // Detectar plataforma y extraer ID
        let videoId = null;
        let platform = null;
        
        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            platform = 'youtube';
            const match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
            if (match) videoId = match[1];
        } else if (url.includes('vimeo.com')) {
            platform = 'vimeo';
            const match = url.match(/vimeo\.com\/(?:.*\/)?(\d+)/);
            if (match) videoId = match[1];
        }

        if (!videoId || !platform) {
            alert('URL de video no válida. Por favor, usa YouTube o Vimeo.');
            return;
        }

        // Insertar iframe del video
        const embedUrl = platform === 'youtube' 
            ? 'https://www.youtube.com/embed/' + videoId
            : 'https://player.vimeo.com/video/' + videoId;
        
        const videoTag = '<div class="relative w-full my-4" style="padding-bottom: 56.25%; height: 0; overflow: hidden;"><iframe src="' + embedUrl + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="absolute top-0 left-0 w-full h-full rounded-lg" style="border: 0;"></iframe></div>';
        insertAtCursor(textareaId, videoTag);
    }
</script>
@endpush
@endsection
