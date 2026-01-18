@extends('shared::layouts.admin')

@section('title', 'Crear Release Note')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 mt-6" x-data="releaseNoteForm()">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.release-notes.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Crear Nueva Release Note</h1>
                <p class="text-sm text-gray-600 mt-1">Crea una nota de versión con las actualizaciones</p>
            </div>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    <form action="{{ route('superlinkiu.release-notes.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- SECTION: Contenido Principal --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- SECTION: Información de Versión --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Información de Versión</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Versión <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="version" 
                                       value="{{ old('version') }}"
                                       placeholder="Ej: 3.8.0"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('version') border-red-300 @enderror"
                                       required>
                                @error('version')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha de Lanzamiento <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="release_date" 
                                       value="{{ old('release_date', now()->format('Y-m-d')) }}"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('release_date') border-red-300 @enderror"
                                       required>
                                @error('release_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Información de Versión --}}

                {{-- SECTION: Items de la Versión --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900 mb-0">Items de Actualización</h2>
                            <button type="button" 
                                    @click="addItem()"
                                    class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Agregar Item
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-start gap-4">
                                    <div class="flex-1 space-y-3">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Tipo <span class="text-red-500">*</span>
                                                </label>
                                                <select 
                                                    :name="`items[${index}][type]`"
                                                    x-model="item.type"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                                                    required>
                                                    <option value="new">Nuevo</option>
                                                    <option value="fix">Corrección</option>
                                                    <option value="improvement">Mejora</option>
                                                    <option value="deprecated">Deprecado</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    Orden
                                                </label>
                                                <input type="number" 
                                                       :name="`items[${index}][order]`"
                                                       x-model="item.order"
                                                       min="0"
                                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Descripción <span class="text-red-500">*</span>
                                            </label>
                                            <textarea 
                                                :name="`items[${index}][description]`"
                                                x-model="item.description"
                                                rows="2"
                                                placeholder="Describe la actualización..."
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                                                required></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Link (Opcional)
                                            </label>
                                            <input type="url" 
                                                   :name="`items[${index}][link]`"
                                                   x-model="item.link"
                                                   placeholder="https://ejemplo.com/tutorial"
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                                            <p class="text-xs text-gray-500 mt-1">Enlace a tutorial o documentación relacionada</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   :name="`items[${index}][notify_tenants]`"
                                                   :id="`item_notify_${index}`"
                                                   x-model="item.notify_tenants"
                                                   value="1"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label :for="`item_notify_${index}`" class="ml-2 block text-sm text-gray-700">
                                                Notificar a tenant admins sobre este item
                                            </label>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            @click="removeItem(index)"
                                            class="text-red-600 hover:text-red-700 p-1">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <template x-if="items.length === 0">
                            <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                                <i data-lucide="file-text" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                                <p class="text-sm text-gray-600 mb-3">No hay items agregados</p>
                                <button type="button" 
                                        @click="addItem()"
                                        class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                    Agregar primer item
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
                {{-- End SECTION: Items de la Versión --}}
            </div>
            {{-- End SECTION: Contenido Principal --}}

            {{-- SECTION: Configuración Lateral --}}
            <div class="space-y-6">
                {{-- SECTION: Configuración --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Configuración</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Orden
                            </label>
                            <input type="number" 
                                   name="order" 
                                   value="{{ old('order', 0) }}"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none">
                            <p class="text-xs text-gray-500 mt-1">Menor número = aparece primero</p>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_current" 
                                   id="is_current"
                                   value="1"
                                   {{ old('is_current') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_current" class="ml-2 block text-sm text-gray-700">
                                Marcar como versión actual
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                Activo
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="notify_tenants" 
                                   id="notify_tenants"
                                   value="1"
                                   {{ old('notify_tenants') ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="notify_tenants" class="ml-2 block text-sm text-gray-700">
                                Notificar a tenant admins
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-6">Enviará una notificación a todos los administradores de tiendas</p>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Configuración --}}
            </div>
            {{-- End SECTION: Configuración Lateral --}}
        </div>

        {{-- SECTION: Actions --}}
        <div class="flex items-center justify-end gap-4 pt-6">
            <a href="{{ route('superlinkiu.release-notes.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-medium transition-colors">
                Crear Release Note
            </button>
        </div>
        {{-- End SECTION: Actions --}}
    </form>
</div>

@push('scripts')
<script>
function releaseNoteForm() {
    return {
        items: @json(old('items', $defaultItems)),
        
        addItem() {
            this.items.push({
                type: 'new',
                description: '',
                link: '',
                notify_tenants: false,
                order: this.items.length
            });
        },
        
        removeItem(index) {
            this.items.splice(index, 1);
        }
    };
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
@endsection
