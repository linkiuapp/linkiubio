@extends('shared::layouts.admin')

@section('title', 'Crear Anuncio')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 mt-6" x-data="createAnnouncement()">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.announcements.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Crear Nuevo Anuncio</h1>
                <p class="text-sm text-gray-600 mt-1">Comunica actualizaciones importantes a las tiendas</p>
            </div>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    <form action="{{ route('superlinkiu.announcements.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- SECTION: Contenido Principal --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- SECTION: Templates --}}
                @if(isset($templates) && $templates->isNotEmpty())
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Plantillas</h2>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Selecciona una plantilla para pre-llenar el formulario:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($templates as $template)
                                <a href="{{ route('superlinkiu.announcements.create', ['template_id' => $template->id]) }}" 
                                   class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <h3 class="font-medium text-gray-900 mb-1">{{ $template->name }}</h3>
                                    <p class="text-xs text-gray-600">{{ ucfirst($template->type) }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                {{-- End SECTION: Templates --}}

                {{-- SECTION: Información Básica --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Información Básica</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Título del Anuncio <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title', $announcement->title ?? '') }}"
                                   placeholder="Ej: Mantenimiento Programado del Sistema"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('title') border-red-300 @enderror"
                                   required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipo <span class="text-red-500">*</span>
                                </label>
                                <select name="type" 
                                        x-model="formData.type"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('type') border-red-300 @enderror"
                                        required>
                                    <option value="">Seleccionar tipo</option>
                                    <option value="critical" {{ old('type') === 'critical' ? 'selected' : '' }}>Crítico</option>
                                    <option value="important" {{ old('type') === 'important' ? 'selected' : '' }}>Importante</option>
                                    <option value="info" {{ old('type') === 'info' ? 'selected' : '' }}>Información</option>
                                </select>
                                @error('type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Prioridad <span class="text-red-500">*</span>
                                </label>
                                <select name="priority" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('priority') border-red-300 @enderror"
                                        required>
                                    <option value="">Seleccionar prioridad</option>
                                    <option value="5" {{ old('priority', 3) == 5 ? 'selected' : '' }}>Crítica (Máxima urgencia)</option>
                                    <option value="4" {{ old('priority', 3) == 4 ? 'selected' : '' }}>Alta (Muy importante)</option>
                                    <option value="3" {{ old('priority', 3) == 3 ? 'selected' : '' }}>Media (Importancia normal)</option>
                                    <option value="2" {{ old('priority', 3) == 2 ? 'selected' : '' }}>Baja (Información general)</option>
                                    <option value="1" {{ old('priority', 3) == 1 ? 'selected' : '' }}>Muy Baja (Anuncios menores)</option>
                                </select>
                                @error('priority')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">
                                    Los anuncios se ordenan por prioridad. Crítica aparece primero.
                                </p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Contenido del Anuncio <span class="text-red-500">*</span>
                            </label>
                            <textarea name="content" 
                                      rows="8"
                                      placeholder="Describe detalladamente el contenido del anuncio..."
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('content') border-red-300 @enderror"
                                      required>{{ old('content', $announcement->content ?? '') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Información Básica --}}

                {{-- SECTION: Banner Configuration --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Configuración de Banner</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" 
                                   name="show_as_banner" 
                                   value="1"
                                   x-model="formData.showAsBanner"
                                   {{ old('show_as_banner') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="text-sm font-medium text-gray-700">
                                Mostrar como banner en dashboard
                            </label>
                        </div>

                        <div x-show="formData.showAsBanner" x-transition class="space-y-4">
                            {{-- HTML Banner --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    HTML del Banner <span class="text-red-500">*</span>
                                </label>
                                <textarea name="banner_html" 
                                          id="banner_html"
                                          rows="8"
                                          placeholder="<div class='w-full py-6 px-8 rounded-lg'><h2>Tu título</h2><p>Tu contenido</p></div>"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none font-mono text-sm @error('banner_html') border-red-300 @enderror">{{ old('banner_html', $announcement->banner_html ?? '') }}</textarea>
                                @error('banner_html')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">
                                    Usa HTML para crear banners personalizados. El banner ocupará todo el ancho disponible.
                                </p>
                            </div>

                            {{-- Imagen Opcional --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Imagen de Acompañamiento (Opcional)
                                </label>
                                <input type="file" 
                                       name="banner_image" 
                                       accept="image/*"
                                       @change="handleImagePreview"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('banner_image') border-red-300 @enderror">
                                @error('banner_image')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">
                                    Formatos: JPG, PNG, WebP. Máximo 2MB. Esta imagen acompañará al banner HTML.
                                </p>
                                
                                <div x-show="imagePreview" class="mt-4 bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xs text-gray-600 mb-2 font-medium">Vista previa:</p>
                                    <img :src="imagePreview" 
                                         alt="Preview" 
                                         class="border-2 border-gray-200 rounded shadow-sm max-w-md">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Color de Fondo
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="color" 
                                               name="banner_background_color" 
                                               x-model="formData.bannerBackgroundColor"
                                               @input="formData.bannerBackgroundColor = $event.target.value"
                                               value="{{ old('banner_background_color', $announcement->banner_background_color ?? '#667eea') }}"
                                               class="h-10 w-20 border border-gray-300 rounded cursor-pointer">
                                        <input type="text" 
                                               name="banner_background_color" 
                                               x-model="formData.bannerBackgroundColor"
                                               @input="formData.bannerBackgroundColor = $event.target.value"
                                               value="{{ old('banner_background_color', $announcement->banner_background_color ?? '#667eea') }}"
                                               pattern="^#[0-9A-Fa-f]{6}$"
                                               placeholder="#667eea"
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none font-mono text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Color de Texto
                                    </label>
                                    <div class="flex gap-2">
                                        <input type="color" 
                                               name="banner_text_color" 
                                               x-model="formData.bannerTextColor"
                                               @input="formData.bannerTextColor = $event.target.value"
                                               value="{{ old('banner_text_color', $announcement->banner_text_color ?? '#ffffff') }}"
                                               class="h-10 w-20 border border-gray-300 rounded cursor-pointer">
                                        <input type="text" 
                                               name="banner_text_color" 
                                               x-model="formData.bannerTextColor"
                                               @input="formData.bannerTextColor = $event.target.value"
                                               value="{{ old('banner_text_color', $announcement->banner_text_color ?? '#ffffff') }}"
                                               pattern="^#[0-9A-Fa-f]{6}$"
                                               placeholder="#ffffff"
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none font-mono text-sm">
                                    </div>
                                </div>
                            </div>

                            {{-- Preview HTML --}}
                            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-600 mb-2 font-medium">Vista previa del banner (en tiempo real):</p>
                                <div class="bg-white rounded-lg p-4 border border-gray-200 min-h-[100px]" 
                                     :style="'background-color: ' + (formData.bannerBackgroundColor || '#667eea') + '; color: ' + (formData.bannerTextColor || '#ffffff') + ';'"
                                     x-html="formData.bannerHtmlPreview || '<p class=\'text-sm\'>Tu HTML aparecerá aquí</p>'">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Enlace del Banner (Opcional)
                                </label>
                                <input type="url" 
                                       name="banner_link" 
                                       value="{{ old('banner_link', $announcement->banner_link ?? '') }}"
                                       placeholder="https://..."
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('banner_link') border-red-300 @enderror">
                                @error('banner_link')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">
                                    URL a la que dirigir cuando hagan clic en el banner
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Banner Configuration --}}
            </div>
            {{-- End SECTION: Contenido Principal --}}

            {{-- SECTION: Configuración Lateral --}}
            <div class="space-y-6">
                {{-- SECTION: Segmentación --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Segmentación</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Planes Target</label>
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @forelse($plans as $plan)
                                    <label class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" 
                                               name="target_plans[]" 
                                               value="{{ strtolower($plan->name) }}"
                                               {{ in_array(strtolower($plan->name), old('target_plans', [])) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="text-sm text-gray-700">{{ $plan->name }}</span>
                                        <span class="text-xs text-gray-500">
                                            ({{ number_format($plan->price, 0, ',', '.') }} {{ $plan->currency }})
                                        </span>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-600">No hay planes activos disponibles</p>
                                @endforelse
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Si no seleccionas ninguno, se mostrará a todos los planes
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Tiendas Específicas (Opcional)
                            </label>
                            <div class="max-h-48 overflow-y-auto border border-gray-200 rounded-lg p-3 space-y-2">
                                @forelse($stores as $store)
                                    <label class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" 
                                               name="target_stores[]" 
                                               value="{{ $store->id }}"
                                               {{ in_array($store->id, old('target_stores', [])) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div class="flex-1">
                                            <span class="text-sm text-gray-700 block">{{ $store->name }}</span>
                                            <span class="text-xs text-gray-500">
                                                @{{ $store->slug }} • {{ $store->plan->name ?? 'Sin plan' }}
                                            </span>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-600 p-2">No hay tiendas activas disponibles</p>
                                @endforelse
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Deja vacío para enviar a todas las tiendas del plan seleccionado
                            </p>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Segmentación --}}

                {{-- SECTION: Programación --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Programación</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Publicación (Opcional)
                            </label>
                            <input type="datetime-local" 
                                   name="published_at" 
                                   value="{{ old('published_at') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('published_at') border-red-300 @enderror">
                            @error('published_at')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                Si lo dejas vacío, se publicará inmediatamente al activarlo
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de Expiración
                            </label>
                            <input type="datetime-local" 
                                   name="expires_at" 
                                   value="{{ old('expires_at') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('expires_at') border-red-300 @enderror">
                            @error('expires_at')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                Déjalo vacío para que sea permanente
                            </p>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Programación --}}

                {{-- SECTION: Comportamiento --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Comportamiento</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <label class="flex items-center gap-3">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Activar inmediatamente</span>
                        </label>

                        <label class="flex items-center gap-3" x-show="formData.type === 'critical'">
                            <input type="checkbox" 
                                   name="show_popup" 
                                   value="1"
                                   {{ old('show_popup') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Mostrar popup automático</span>
                        </label>

                        <label class="flex items-center gap-3" x-show="formData.type === 'critical'">
                            <input type="checkbox" 
                                   name="send_email" 
                                   value="1"
                                   {{ old('send_email') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Enviar email</span>
                        </label>
                    </div>
                </div>
                {{-- End SECTION: Comportamiento --}}

                {{-- SECTION: Canales de Notificación --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Canales de Notificación</h2>
                    </div>
                    
                    <div class="p-6 space-y-3">
                        <p class="text-sm text-gray-600 mb-4">Selecciona los canales por los que se enviará este anuncio:</p>
                        
                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="channels[]" 
                                   value="in_app"
                                   {{ in_array('in_app', old('channels', ['in_app'])) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700">In-App</span>
                                <p class="text-xs text-gray-500">Notificación en el dashboard de la tienda</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="channels[]" 
                                   value="email"
                                   {{ in_array('email', old('channels', [])) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700">Email</span>
                                <p class="text-xs text-gray-500">Enviar por correo electrónico</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" 
                                   name="channels[]" 
                                   value="whatsapp"
                                   {{ in_array('whatsapp', old('channels', [])) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-700">WhatsApp</span>
                                <p class="text-xs text-gray-500">Enviar por WhatsApp Business</p>
                            </div>
                        </label>
                    </div>
                </div>
                {{-- End SECTION: Canales de Notificación --}}

                {{-- SECTION: Botones de Acción --}}
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2 mb-2">
                            <input type="checkbox" 
                                   name="send_now" 
                                   value="1"
                                   id="send_now"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="send_now" class="text-sm text-gray-700">
                                Enviar notificaciones inmediatamente
                            </label>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-gray-900 hover:bg-gray-800 text-white px-4 py-3 rounded-lg flex items-center justify-center gap-2 font-medium transition-colors">
                            <i data-lucide="save" class="w-5 h-5"></i>
                            Crear Anuncio
                        </button>
                        
                        <a href="{{ route('superlinkiu.announcements.index') }}" 
                           class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-3 rounded-lg flex items-center justify-center gap-2 font-medium transition-colors">
                            <i data-lucide="x" class="w-5 h-5"></i>
                            Cancelar
                        </a>
                    </div>
                </div>
                {{-- End SECTION: Botones de Acción --}}
            </div>
            {{-- End SECTION: Configuración Lateral --}}
        </div>
    </form>
</div>

@push('scripts')
<script>
// Manejar mensajes flash con toasts
@if(session('success'))
    window.toast.success('Éxito', '{{ session('success') }}', 5000, 'top-center');
@endif

@if(session('error'))
    window.toast.error('Error', '{{ session('error') }}', 5000, 'top-center');
@endif

@if($errors->any())
    @foreach($errors->all() as $error)
        window.toast.error('Error de validación', '{{ $error }}', 5000, 'top-center');
    @endforeach
@endif

function createAnnouncement() {
    return {
        formData: {
            type: '{{ old('type', 'info') }}',
            showAsBanner: {{ old('show_as_banner', isset($announcement) && $announcement->show_as_banner) ? 'true' : 'false' }},
            bannerHtmlPreview: @if(isset($announcement) && $announcement->banner_html) {!! json_encode($announcement->banner_html) !!} @else null @endif,
            bannerBackgroundColor: '{{ old('banner_background_color', $announcement->banner_background_color ?? '#667eea') }}',
            bannerTextColor: '{{ old('banner_text_color', $announcement->banner_text_color ?? '#ffffff') }}'
        },
        imagePreview: null,
        
        init() {
            // Watch for HTML changes and update preview in real-time
            const htmlTextarea = document.getElementById('banner_html');
            if (htmlTextarea) {
                // Update preview as user types
                htmlTextarea.addEventListener('input', (e) => {
                    this.formData.bannerHtmlPreview = e.target.value;
                });
                
                // Initialize preview with existing content
                if (htmlTextarea.value) {
                    this.formData.bannerHtmlPreview = htmlTextarea.value;
                }
            }
        },
        
        handleImagePreview(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.imagePreview = null;
            }
        }
    }
}
</script>
@endpush
@endsection
