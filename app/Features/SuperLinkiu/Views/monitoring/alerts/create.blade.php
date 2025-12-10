@extends('shared::layouts.admin')

@section('title', 'Crear Alerta de Monitoreo')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 mt-6" x-data="createAlert()">
    {{-- SECTION: Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.monitoring.alerts.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Crear Nueva Alerta</h1>
                <p class="text-sm text-gray-600 mt-1">Configura alertas para recibir notificaciones sobre eventos del sistema</p>
            </div>
        </div>
    </div>
    {{-- End SECTION: Header --}}

    <form action="{{ route('superlinkiu.monitoring.alerts.store') }}" method="POST">
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
                                Nombre de la Alerta <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   placeholder="Ej: Alerta de Errores Críticos"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('name') border-red-300 @enderror"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo de Alerta <span class="text-red-500">*</span>
                            </label>
                            <select name="type" 
                                    x-model="alertType"
                                    @change="updateConditions()"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none @error('type') border-red-300 @enderror"
                                    required>
                                <option value="">Seleccionar tipo</option>
                                <option value="error_rate">Tasa de Errores</option>
                                <option value="traffic_spike">Pico de Tráfico</option>
                                <option value="slow_response">Respuesta Lenta</option>
                                <option value="high_memory">Alto Uso de Memoria</option>
                                <option value="custom">Personalizado</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                Selecciona el tipo de evento que activará esta alerta
                            </p>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Información Básica --}}

                {{-- SECTION: Condiciones --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Condiciones</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div x-show="alertType === 'error_rate'">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Umbral (cantidad) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="conditions[threshold]" 
                                           value="{{ old('conditions.threshold', 10) }}"
                                           min="1"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Número de errores</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        En (minutos) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="conditions[minutes]" 
                                           value="{{ old('conditions.minutes', 5) }}"
                                           min="1"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Ventana de tiempo</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nivel
                                    </label>
                                    <select name="conditions[level]" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="ERROR" {{ old('conditions.level', 'ERROR') === 'ERROR' ? 'selected' : '' }}>ERROR</option>
                                        <option value="WARNING" {{ old('conditions.level') === 'WARNING' ? 'selected' : '' }}>WARNING</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Filtrar por Ruta (Opcional)
                                </label>
                                <input type="text" 
                                       name="conditions[route_pattern]" 
                                       value="{{ old('conditions.route_pattern') }}"
                                       placeholder="Ej: categories, products, orders"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">
                                    Solo alertará si el error ocurre en rutas que contengan este texto. Dejar vacío para todas las rutas.
                                </p>
                            </div>
                        </div>

                        <div x-show="alertType === 'traffic_spike'">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Umbral (requests) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="conditions[threshold]" 
                                           value="{{ old('conditions.threshold', 1000) }}"
                                           min="1"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        En (minutos) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="conditions[minutes]" 
                                           value="{{ old('conditions.minutes', 1) }}"
                                           min="1"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                           required>
                                </div>
                            </div>
                        </div>

                        <div x-show="alertType === 'slow_response'">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Umbral (ms) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="conditions[threshold_ms]" 
                                           value="{{ old('conditions.threshold_ms', 3000) }}"
                                           min="100"
                                           step="100"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                           required>
                                    <p class="text-xs text-gray-500 mt-1">Tiempo promedio de respuesta</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        En (minutos) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="conditions[minutes]" 
                                           value="{{ old('conditions.minutes', 10) }}"
                                           min="1"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                           required>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Filtrar por Ruta (Opcional)
                                </label>
                                <input type="text" 
                                       name="conditions[route_pattern]" 
                                       value="{{ old('conditions.route_pattern') }}"
                                       placeholder="Ej: categories, products, orders"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">
                                    Solo alertará si la lentitud ocurre en rutas que contengan este texto. Dejar vacío para todas las rutas.
                                </p>
                            </div>
                        </div>

                        <div x-show="alertType === 'high_memory'">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Umbral (MB) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="conditions[threshold_mb]" 
                                           value="{{ old('conditions.threshold_mb', 512) }}"
                                           min="1"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        En (minutos) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           name="conditions[minutes]" 
                                           value="{{ old('conditions.minutes', 10) }}"
                                           min="1"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                           required>
                                </div>
                            </div>
                        </div>

                        <div x-show="alertType === 'custom'">
                            <p class="text-sm text-gray-600">Las alertas personalizadas requieren configuración manual en el código.</p>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Condiciones --}}
            </div>
            {{-- End SECTION: Contenido Principal --}}

            {{-- SECTION: Sidebar --}}
            <div class="space-y-6">
                {{-- SECTION: Configuración --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-0">Configuración</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Canal de Notificación <span class="text-red-500">*</span>
                            </label>
                            <select name="channel" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('channel') border-red-300 @enderror"
                                    required>
                                <option value="">Seleccionar canal</option>
                                <option value="email" {{ old('channel') === 'email' ? 'selected' : '' }}>Email</option>
                                <option value="whatsapp" {{ old('channel') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="in_app" {{ old('channel') === 'in_app' ? 'selected' : '' }}>In-App</option>
                            </select>
                            @error('channel')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Cooldown (minutos) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="cooldown_minutes" 
                                   value="{{ old('cooldown_minutes', 60) }}"
                                   min="1"
                                   max="1440"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('cooldown_minutes') border-red-300 @enderror"
                                   required>
                            @error('cooldown_minutes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                Tiempo mínimo entre alertas (1-1440 minutos)
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="text-sm font-medium text-gray-700">
                                Activar alerta inmediatamente
                            </label>
                        </div>
                    </div>
                </div>
                {{-- End SECTION: Configuración --}}

                {{-- SECTION: Acciones --}}
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-6 space-y-3">
                        <button type="submit" 
                                class="w-full bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Crear Alerta
                        </button>
                        <a href="{{ route('superlinkiu.monitoring.alerts.index') }}" 
                           class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                            Cancelar
                        </a>
                    </div>
                </div>
                {{-- End SECTION: Acciones --}}
            </div>
            {{-- End SECTION: Sidebar --}}
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function createAlert() {
    return {
        alertType: '{{ old("type", "") }}',
        updateConditions() {
            // Remover el atributo name de todos los inputs de condiciones para que no se envíen
            const allConditionInputs = document.querySelectorAll('input[name^="conditions["], select[name^="conditions["]');
            allConditionInputs.forEach(input => {
                if (!input.hasAttribute('data-name')) {
                    input.setAttribute('data-name', input.getAttribute('name'));
                }
                input.removeAttribute('name');
            });
            
            // Restaurar el name solo de los inputs visibles del tipo seleccionado
            setTimeout(() => {
                const sections = document.querySelectorAll('div[x-show^="alertType ==="]');
                sections.forEach(section => {
                    const isVisible = section.offsetParent !== null;
                    if (isVisible) {
                        const inputs = section.querySelectorAll('input[data-name^="conditions["], select[data-name^="conditions["]');
                        inputs.forEach(input => {
                            const originalName = input.getAttribute('data-name');
                            if (originalName) {
                                input.setAttribute('name', originalName);
                            }
                        });
                    }
                });
            }, 50);
        },
        init() {
            // Guardar los names originales
            const allConditionInputs = document.querySelectorAll('input[name^="conditions["], select[name^="conditions["]');
            allConditionInputs.forEach(input => {
                if (!input.hasAttribute('data-name')) {
                    input.setAttribute('data-name', input.getAttribute('name'));
                }
            });
            
            // Ejecutar updateConditions al inicializar si hay un tipo seleccionado
            if (this.alertType) {
                setTimeout(() => {
                    this.updateConditions();
                }, 100);
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    @if($errors->any())
        @foreach($errors->all() as $error)
            if (window.toast) {
                window.toast.error(
                    'Error de validación',
                    '{{ $error }}',
                    5000,
                    'bottom-center'
                );
            }
        @endforeach
    @endif
});
</script>
@endpush

