@extends('frontend.layouts.app')

@push('meta')
    <meta name="description" content="Reserva una mesa en {{ $store->name }} - Reserva tu lugar con anticipación">
    <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
<div class="px-4 py-4 sm:py-6">
    <!-- Header -->
    <div class="text-center mb-6">
        <h1 class="h1 text-brandNeutral-400 mb-2">Reservar Mesa</h1>
        <p class="caption text-brandNeutral-400">Selecciona fecha, hora y completa tu información</p>
    </div>

    <!-- Formulario de Reserva -->
    <form id="reservation-form" method="POST" action="{{ route('tenant.reservations.store', $store->slug) }}" enctype="multipart/form-data">
        @csrf

        <!-- CARD 1: Fecha y Hora -->
        <div class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">1</div>
                <h3 class="caption-strong text-brandNeutral-400">Fecha y Hora</h3>
            </div>
            
            <div class="space-y-4">
                <!-- Fecha -->
                <div>
                    <label for="reservation_date" class="block caption text-brandNeutral-400 mb-2">Fecha de Reserva *</label>
                    <input 
                        type="text" 
                        id="reservation_date" 
                        name="reservation_date" 
                        class="reservation-datepicker w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                        placeholder="Selecciona una fecha"
                        required
                    >
                    <div id="date_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
                
                <!-- Horarios disponibles -->
                <div id="time-slots-container" class="hidden">
                    <label class="block caption text-brandNeutral-400 mb-2">Horarios Disponibles *</label>
                    <div id="time-slots-grid" class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <!-- Los slots se cargan dinámicamente -->
                    </div>
                    <div id="time-slots-loading" class="text-center py-4 hidden">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-brandPrimary-300 mx-auto"></div>
                        <p class="caption text-brandNeutral-400 mt-2">Cargando horarios...</p>
                    </div>
                    <div id="time-slots-error" class="hidden mt-2">
                        <p class="caption text-brandError-400"></p>
                    </div>
                    <div id="time_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
            </div>
        </div>

        <!-- CARD 2: Información Personal -->
        <div class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">2</div>
                <h3 class="caption-strong text-brandNeutral-400">Información Personal</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label for="customer_name" class="block caption text-brandNeutral-400 mb-2">Nombre Completo *</label>
                    <input 
                        type="text" 
                        id="customer_name" 
                        name="customer_name" 
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                        placeholder="Tu nombre completo"
                        required
                    >
                    <div id="name_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
                
                <div>
                    <label for="customer_phone" class="block caption text-brandNeutral-400 mb-2">Teléfono WhatsApp *</label>
                    <input 
                        type="tel" 
                        id="customer_phone" 
                        name="customer_phone" 
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                        placeholder="3001234567"
                        required
                    >
                    <div id="phone_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
                
                <div>
                    <label for="party_size" class="block caption text-brandNeutral-400 mb-2">Número de Personas *</label>
                    <select 
                        id="party_size" 
                        name="party_size" 
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                        required
                    >
                        <option value="">Selecciona número de personas</option>
                        @for($i = 2; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'persona' : 'personas' }}</option>
                        @endfor
                        <option value="11">10+ personas</option>
                    </select>
                    <div id="party_size_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
                
                <div>
                    <label for="notes" class="block caption text-brandNeutral-400 mb-2">Notas Especiales (opcional)</label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="3"
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption resize-none"
                        placeholder="Alergias, preferencias, celebraciones especiales..."
                    ></textarea>
                </div>
            </div>
        </div>

        <!-- CARD 3: Anticipo (si está habilitado) -->
        @if($settings->require_deposit)
        <div class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">3</div>
                <h3 class="caption-strong text-brandNeutral-400">Anticipo</h3>
            </div>
            
            <div class="space-y-4">
                <div class="bg-brandInfo-50 border border-brandInfo-300 rounded-lg p-4">
                    <p class="caption text-brandNeutral-400 mb-2">
                        <strong class="caption-strong">Monto del anticipo:</strong> 
                        <span id="deposit-amount-display">$0</span> 
                        (${{ number_format($settings->deposit_per_person, 0, ',', '.') }} por persona)
                    </p>
                    <p class="caption text-brandNeutral-400">
                        Este anticipo se descontará del consumo final.
                    </p>
                </div>
                
                @if($bankAccounts->count() > 0)
                    <div>
                        <label class="block caption text-brandNeutral-400 mb-2">Datos Bancarios</label>
                        <div class="space-y-3">
                            @foreach($bankAccounts as $account)
                                <div class="bg-brandWhite-100 border border-brandWhite-300 rounded-lg p-4">
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="caption text-brandNeutral-400">Banco:</span>
                                            <span class="caption-strong text-brandNeutral-400">{{ $account->bank }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="caption text-brandNeutral-400">Tipo:</span>
                                            <span class="caption-strong text-brandNeutral-400">{{ $account->account_type }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="caption text-brandNeutral-400">Número:</span>
                                            <span class="caption-strong text-brandNeutral-400 font-mono">{{ $account->account_number }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="caption text-brandNeutral-400">Titular:</span>
                                            <span class="caption-strong text-brandNeutral-400">{{ $account->account_holder }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div>
                        <label for="payment_proof" class="block caption text-brandNeutral-400 mb-2">Comprobante de Pago *</label>
                        <div class="border-2 border-dashed border-brandWhite-300 rounded-lg p-6 text-center hover:border-brandPrimary-300 transition-colors">
                            <input 
                                type="file" 
                                id="payment_proof" 
                                name="payment_proof" 
                                accept=".jpg,.jpeg,.png,.pdf"
                                class="hidden"
                                required
                            >
                            <label for="payment_proof" class="cursor-pointer">
                                <div class="text-4xl mb-2">📎</div>
                                <p class="caption text-brandNeutral-400 font-medium mb-1">Subir comprobante</p>
                                <p class="caption text-brandNeutral-300">JPG, PNG o PDF (máx. 5MB)</p>
                            </label>
                        </div>
                        <div id="payment_proof_preview" class="hidden mt-3"></div>
                        <div id="payment_proof_error" class="hidden mt-1 caption text-brandError-400"></div>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Botón de Enviar -->
        <div class="bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300">
            <button 
                type="submit" 
                id="btn-submit-reservation"
                class="w-full bg-brandPrimary-300 hover:bg-brandPrimary-200 text-brandWhite-100 py-3 rounded-full caption transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                disabled
            >
                <span id="btn-text">Solicitar Reserva</span>
                <span id="btn-loading" class="hidden">
                    <span class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-brandWhite-100 mr-2"></span>
                    Procesando...
                </span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', async function() {
    const form = document.getElementById('reservation-form');
    const dateInput = document.getElementById('reservation_date');
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const timeSlotsGrid = document.getElementById('time-slots-grid');
    const timeSlotsLoading = document.getElementById('time-slots-loading');
    const timeSlotsError = document.getElementById('time-slots-error');
    const partySizeInput = document.getElementById('party_size');
    const depositAmountDisplay = document.getElementById('deposit-amount-display');
    const submitBtn = document.getElementById('btn-submit-reservation');
    const selectedTime = document.createElement('input');
    selectedTime.type = 'hidden';
    selectedTime.name = 'reservation_time';
    selectedTime.id = 'reservation_time';
    form.appendChild(selectedTime);
    
    const depositPerPerson = {{ $settings->deposit_per_person ?? 0 }};
    
    // Inicializar el datepicker
    if (window.initReservationDatepicker) {
        await window.initReservationDatepicker(dateInput);
        
        // Configurar evento de Litepicker cuando esté listo
        if (dateInput._litepicker) {
            dateInput._litepicker.on('selected', function(date, instance) {
                if (date) {
                    const formattedDate = date.format('YYYY-MM-DD');
                    dateInput.value = formattedDate;
                    setTimeout(handleDateChange, 100);
                }
            });
        }
    }
    
    // Control de llamadas para evitar duplicados
    let isLoadingSlots = false;
    let lastLoadedDate = null;
    
    // Función para cargar slots cuando se selecciona una fecha
    function handleDateChange() {
        const date = dateInput.value;
        if (!date) {
            timeSlotsContainer.classList.add('hidden');
            selectedTime.value = '';
            validateForm();
            return;
        }
        
        // Evitar cargar si ya se está cargando o si es la misma fecha
        if (isLoadingSlots || lastLoadedDate === date) {
            return;
        }
        
        loadTimeSlots(date);
    }
    
    // Escuchar eventos del input con debounce
    let dateChangeTimeout;
    function debouncedDateChange() {
        clearTimeout(dateChangeTimeout);
        dateChangeTimeout = setTimeout(handleDateChange, 200);
    }
    
    dateInput.addEventListener('change', handleDateChange);
    dateInput.addEventListener('input', debouncedDateChange);
    
    // Polling para detectar cambios (fallback) - reducido a 500ms
    let lastDateValue = dateInput.value;
    setInterval(function() {
        if (dateInput.value !== lastDateValue && !isLoadingSlots) {
            lastDateValue = dateInput.value;
            if (lastDateValue && lastDateValue !== lastLoadedDate) {
                handleDateChange();
            }
        }
    }, 500);
    
    // Actualizar monto de anticipo cuando cambia el número de personas
    if (partySizeInput && depositAmountDisplay) {
        partySizeInput.addEventListener('change', function() {
            const partySize = parseInt(this.value) || 0;
            const depositAmount = partySize * depositPerPerson;
            depositAmountDisplay.textContent = '$' + depositAmount.toLocaleString('es-CO');
        });
    }
    
    // Manejar selección de archivo de comprobante
    const paymentProofInput = document.getElementById('payment_proof');
    if (paymentProofInput) {
        paymentProofInput.addEventListener('change', function(e) {
            handlePaymentProofUpload(e.target.files[0]);
        });
    }
    
    // Validar formulario antes de enviar
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        submitBtn.disabled = true;
        document.getElementById('btn-text').classList.add('hidden');
        document.getElementById('btn-loading').classList.remove('hidden');
    });
    
    function loadTimeSlots(date) {
        // Marcar como cargando y actualizar fecha cargada
        isLoadingSlots = true;
        lastLoadedDate = date;
        
        // Limpiar grid completamente
        timeSlotsGrid.innerHTML = '';
        timeSlotsLoading.classList.remove('hidden');
        timeSlotsError.classList.add('hidden');
        timeSlotsContainer.classList.remove('hidden');
        
        // Construir URL manualmente para evitar problemas de resolución de rutas
        const url = `{{ url('/') }}/{{ $store->slug }}/reservaciones/api/available-slots`;
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ date: date })
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`HTTP ${response.status}: ${text.substring(0, 100)}`);
                });
            }
            return response.json();
        })
        .then(data => {
            timeSlotsLoading.classList.add('hidden');
            isLoadingSlots = false;
            
            if (!data.success) {
                timeSlotsError.querySelector('p').textContent = data.message || 'Error al cargar horarios';
                timeSlotsError.classList.remove('hidden');
                return;
            }
            
            if (!data.slots || data.slots.length === 0) {
                timeSlotsError.querySelector('p').textContent = 'No hay horarios disponibles para esta fecha';
                timeSlotsError.classList.remove('hidden');
                return;
            }
            
            // Verificar duplicados antes de agregar
            const addedTimes = new Set();
            
            data.slots.forEach(slot => {
                // Verificar duplicados
                if (addedTimes.has(slot.time)) {
                    console.warn('Slot duplicado ignorado:', slot.time);
                    return;
                }
                addedTimes.add(slot.time);
                
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'px-4 py-3 border rounded-lg caption transition-colors text-center';
                
                if (!slot.available || slot.status === 'full' || slot.reservations_count > 0) {
                    // Horario ocupado: deshabilitado y opaco
                    button.className += ' border-brandNeutral-200 text-brandNeutral-200 bg-brandWhite-100 cursor-not-allowed opacity-50';
                    button.disabled = true;
                } else {
                    // Horario disponible: siempre mismo contraste en default, hover y active
                    button.className += ' border-brandSuccess-300 text-brandSuccess-400 bg-brandSuccess-50 hover:bg-brandSuccess-50 hover:text-brandSuccess-400 cursor-pointer';
                }
                
                button.textContent = slot.time;
                button.dataset.time = slot.time;
                
                // Solo agregar evento click si está disponible
                if (slot.available && slot.status !== 'full' && slot.reservations_count === 0) {
                    button.addEventListener('click', function() {
                        // Remover estado active de todos los botones
                        document.querySelectorAll('#time-slots-grid button').forEach(btn => {
                            btn.classList.remove('bg-brandPrimary-300', 'text-brandWhite-100', 'border-brandPrimary-300');
                            // Restaurar estilo por defecto si está disponible
                            if (!btn.disabled) {
                                btn.classList.add('bg-brandSuccess-50', 'text-brandSuccess-400');
                            }
                        });
                        // Agregar estado active al botón seleccionado
                        this.classList.remove('bg-brandSuccess-50');
                        this.classList.add('bg-brandPrimary-300', 'text-brandWhite-100', 'border-brandPrimary-300');
                        selectedTime.value = this.dataset.time;
                        validateForm();
                    });
                }
                
                timeSlotsGrid.appendChild(button);
            });
        })
        .catch(error => {
            timeSlotsLoading.classList.add('hidden');
            isLoadingSlots = false;
            const errorMsg = error.message || 'Error al cargar horarios. Por favor intenta de nuevo.';
            timeSlotsError.querySelector('p').textContent = errorMsg;
            timeSlotsError.classList.remove('hidden');
        });
    }
    
    function handlePaymentProofUpload(file) {
        const preview = document.getElementById('payment_proof_preview');
        const errorElement = document.getElementById('payment_proof_error');
        
        if (!file) {
            preview.classList.add('hidden');
            return;
        }
        
        const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!allowedTypes.includes(file.type)) {
            errorElement.textContent = 'Solo se permiten archivos JPG, PNG o PDF';
            errorElement.classList.remove('hidden');
            return;
        }
        
        if (file.size > maxSize) {
            errorElement.textContent = 'El archivo no puede ser mayor a 5MB';
            errorElement.classList.remove('hidden');
            return;
        }
        
        errorElement.classList.add('hidden');
        preview.innerHTML = `
            <div class="flex items-center gap-3 p-3 bg-brandSuccess-50 border border-brandSuccess-200 rounded-lg">
                <span class="text-2xl">📎</span>
                <div class="flex-1">
                    <p class="caption-strong text-brandNeutral-400">${file.name}</p>
                    <p class="caption text-brandNeutral-300">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                </div>
            </div>
        `;
        preview.classList.remove('hidden');
    }
    
    function validateForm() {
        const date = dateInput.value;
        const time = selectedTime.value;
        const name = document.getElementById('customer_name').value;
        const phone = document.getElementById('customer_phone').value;
        const partySize = partySizeInput.value;
        
        let isValid = true;
        
        // Validar fecha
        if (!date) {
            isValid = false;
        }
        
        // Validar hora
        if (!time) {
            isValid = false;
        }
        
        // Validar campos requeridos
        if (!name || !phone || !partySize) {
            isValid = false;
        }
        
        // Validar comprobante si se requiere
        @if($settings->require_deposit)
        const paymentProof = document.getElementById('payment_proof');
        if (paymentProof && !paymentProof.files[0]) {
            isValid = false;
        }
        @endif
        
        submitBtn.disabled = !isValid;
        return isValid;
    }
    
    // Validar en tiempo real
    ['customer_name', 'customer_phone', 'party_size'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', validateForm);
        }
    });
});
</script>
@endpush
@endsection

