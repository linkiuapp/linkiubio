<x-tenant-admin-layout :store="$store">
@section('title', 'Nueva Reserva')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('tenant.admin.reservations.index', $store->slug) }}" 
               class="text-black-300 hover:text-black-400">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-lg font-semibold text-black-500">Nueva Reserva Manual</h1>
        </div>
        <p class="text-sm text-black-300">Crea una reserva desde una llamada telefónica o solicitud directa</p>
    </div>

    @if($errors->has('error'))
        <div class="mb-6 p-4 bg-error-50 border border-error-200 rounded-lg">
            <p class="text-sm text-error-600">{{ $errors->first('error') }}</p>
        </div>
    @endif

    <form action="{{ route('tenant.admin.reservations.store', $store->slug) }}" method="POST" class="space-y-6" id="reservation-form" onsubmit="return validateReservationForm(event)">
        @csrf

        <!-- Información del Cliente -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Información del Cliente</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="lg:col-span-2">
                    <label for="customer_name" class="block text-sm font-medium text-black-400 mb-2">
                        Nombre Completo *
                    </label>
                    <input type="text" 
                           id="customer_name" 
                           name="customer_name" 
                           value="{{ old('customer_name') }}" 
                           required
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="Nombre completo del cliente">
                    @error('customer_name')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="customer_phone" class="block text-sm font-medium text-black-400 mb-2">
                        Teléfono / WhatsApp *
                    </label>
                    <input type="tel" 
                           id="customer_phone" 
                           name="customer_phone" 
                           value="{{ old('customer_phone') }}" 
                           required
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="3001234567">
                    @error('customer_phone')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="party_size" class="block text-sm font-medium text-black-400 mb-2">
                        Número de Personas *
                    </label>
                    <input type="number" 
                           id="party_size" 
                           name="party_size" 
                           value="{{ old('party_size') }}" 
                           min="1" 
                           max="50"
                           required
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="2">
                    @error('party_size')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Fecha y Hora -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Fecha y Hora</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="reservation_date" class="block text-sm font-medium text-black-400 mb-2">
                        Fecha de Reserva *
                    </label>
                    <input type="text" 
                           id="reservation_date" 
                           name="reservation_date" 
                           value="{{ old('reservation_date') }}" 
                           required
                           class="reservation-datepicker w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500"
                           placeholder="Selecciona una fecha">
                    @error('reservation_date')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reservation_time" class="block text-sm font-medium text-black-400 mb-2">
                        Hora de Reserva *
                    </label>
                    <input type="text" 
                           id="reservation_time" 
                           name="reservation_time"
                           value="{{ old('reservation_time') }}" 
                           required
                           class="reservation-timepicker w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500"
                           placeholder="Selecciona una hora">
                    @error('reservation_time')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Mesa (Opcional) -->
        @if($tables->count() > 0)
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Asignación de Mesa</h3>
            <div>
                <label for="table_id" class="block text-sm font-medium text-black-400 mb-2">
                    Mesa (Opcional)
                </label>
                <select id="table_id" 
                        name="table_id" 
                        class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500">
                    <option value="">Asignar automáticamente</option>
                    @foreach($tables as $table)
                        <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                            Mesa {{ $table->table_number }} ({{ $table->capacity }} personas)
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-black-200 mt-1">Si no seleccionas una mesa, el sistema la asignará automáticamente según disponibilidad</p>
            </div>
        </div>
        @endif

        <!-- Estado Inicial -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Estado Inicial</h3>
            <div>
                <label class="block text-sm font-medium text-black-400 mb-2">Estado *</label>
                <div class="space-y-3">
                    <label class="flex items-center p-3 border border-accent-200 rounded-lg hover:bg-accent-100 cursor-pointer">
                        <input type="radio" 
                               name="status" 
                               value="pending" 
                               {{ old('status', 'confirmed') === 'pending' ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-200 border-accent-300 focus:ring-primary-200">
                        <span class="ml-3 text-sm text-black-500">Pendiente (requiere confirmación)</span>
                    </label>
                    <label class="flex items-center p-3 border border-accent-200 rounded-lg hover:bg-accent-100 cursor-pointer">
                        <input type="radio" 
                               name="status" 
                               value="confirmed" 
                               {{ old('status', 'confirmed') === 'confirmed' ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-200 border-accent-300 focus:ring-primary-200">
                        <span class="ml-3 text-sm text-black-500">Confirmada (lista para usar)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Notas -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Notas Especiales</h3>
            <div>
                <label for="notes" class="block text-sm font-medium text-black-400 mb-2">
                    Notas (Opcional)
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="4"
                          class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                          placeholder="Alergias, preferencias, celebraciones especiales...">{{ old('notes') }}</textarea>
            </div>
        </div>

        <!-- Enviar Confirmación -->
        <div class="bg-accent-50 rounded-lg p-6">
            <div class="flex items-start">
                <input type="checkbox" 
                       id="send_confirmation" 
                       name="send_confirmation" 
                       value="1"
                       class="mt-1 w-4 h-4 text-primary-200 border-accent-300 rounded focus:ring-primary-200">
                <label for="send_confirmation" class="ml-3 text-sm text-black-500">
                    Enviar confirmación por WhatsApp al cliente
                    <span class="block text-xs text-black-300 mt-1">
                        El cliente recibirá un mensaje de WhatsApp con los detalles de la reserva
                    </span>
                </label>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('tenant.admin.reservations.index', $store->slug) }}" 
               class="px-6 py-3 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-primary-200 hover:bg-primary-300 text-accent-50 rounded-lg text-sm transition-colors">
                Crear Reserva
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Validar formulario antes de enviar
function validateReservationForm(event) {
    const dateInput = document.getElementById('reservation_date');
    const timeInput = document.getElementById('reservation_time');
    
    if (!dateInput.value || dateInput.value.trim() === '') {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor selecciona una fecha de reserva'
        });
        dateInput.focus();
        return false;
    }
    
    if (!timeInput.value || timeInput.value.trim() === '' || !timeInput.value.match(/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/)) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor selecciona una hora válida (formato HH:mm)'
        });
        timeInput.focus();
        return false;
    }
    
    return true;
}

// Forzar inicialización de datepickers y timepickers después de que todo esté cargado
(function() {
    let attempts = 0;
    const maxAttempts = 5;
    
    async function tryInit() {
        attempts++;
        
        // Inicializar datepickers
        if (window.initializeAllDatepickers) {
            await window.initializeAllDatepickers();
        }
        
        // Inicializar timepickers
        if (window.initCustomTimepicker) {
            const timeInputs = document.querySelectorAll('.reservation-timepicker');
            timeInputs.forEach(input => {
                // Asegurar que el input esté vacío inicialmente
                if (!input.value || input.value.trim() === '') {
                    input.value = '';
                }
                window.initCustomTimepicker(input);
            });
        }
        
        if (attempts < maxAttempts) {
            setTimeout(tryInit, 500);
        }
    }
    
    // Intentar inicializar después de que todo esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(tryInit, 1000);
        });
    } else {
        setTimeout(tryInit, 1000);
    }
    
    // También intentar después de Alpine
    if (window.Alpine) {
        document.addEventListener('alpine:init', () => {
            setTimeout(tryInit, 1500);
        });
    }
})();
</script>
@endpush

@endsection
</x-tenant-admin-layout>

