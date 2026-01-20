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
        <div class="bg-brandWhite-50 rounded-lg p-5 border-2 border-brandWhite-300 mb-4 transition-all duration-300" id="step-1-card">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3 transition-all duration-300" id="step-1-number">
                        <span id="step-1-number-text">1</span>
                        <i data-lucide="check" class="hidden size-5" id="step-1-check"></i>
                    </div>
                    <h3 class="caption-strong text-brandNeutral-400">Fecha y Hora</h3>
                </div>
                <div id="step-1-status" class="hidden">
                    <span class="text-xs text-brandSuccess-400 font-medium">✓ Completado</span>
                </div>
            </div>
            
            <div class="space-y-4">
                <!-- Fecha -->
                <div>
                    <label for="reservation_date" class="flex items-center gap-2 caption text-brandNeutral-400 mb-2">
                        <i data-lucide="calendar" class="size-4"></i>
                        <span>Fecha de Reserva *</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="reservation_date" 
                            name="reservation_date" 
                            class="reservation-datepicker w-full px-4 py-3 pl-11 border-2 border-brandWhite-300 rounded-lg caption focus:border-brandPrimary-300 focus:ring-2 focus:ring-brandPrimary-100 transition-all duration-200"
                            placeholder="Selecciona una fecha"
                            required
                        >
                        <i data-lucide="calendar" class="absolute left-3 top-1/2 transform -translate-y-1/2 size-5 text-brandNeutral-300 pointer-events-none"></i>
                        <div id="date_success" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2">
                            <i data-lucide="check-circle" class="size-5 text-brandSuccess-400"></i>
                        </div>
                    </div>
                    <div id="date_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
                
                <!-- Horarios disponibles -->
                <div id="time-slots-container" class="hidden">
                    <label class="flex items-center gap-2 caption text-brandNeutral-400 mb-2">
                        <i data-lucide="clock" class="size-4"></i>
                        <span>Horarios Disponibles *</span>
                    </label>
                    <div id="time-slots-grid" class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <!-- Los slots se cargan dinámicamente -->
                    </div>
                    <div id="time-slots-loading" class="text-center py-6 hidden">
                        <div class="animate-spin rounded-full h-8 w-8 border-2 border-brandPrimary-300 border-t-transparent mx-auto"></div>
                        <p class="caption text-brandNeutral-400 mt-3">Cargando horarios disponibles...</p>
                    </div>
                    <div id="time-slots-error" class="hidden mt-2 p-3 bg-brandError-50 border border-brandError-200 rounded-lg">
                        <p class="caption text-brandError-400"></p>
                    </div>
                    <div id="time_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
            </div>
        </div>

        <!-- CARD 2: Información Personal -->
        <div class="bg-brandWhite-50 rounded-lg p-5 border-2 border-brandWhite-300 mb-4 transition-all duration-300" id="step-2-card">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3 transition-all duration-300" id="step-2-number">
                        <span id="step-2-number-text">2</span>
                        <i data-lucide="check" class="hidden size-5" id="step-2-check"></i>
                    </div>
                    <h3 class="caption-strong text-brandNeutral-400">Información Personal</h3>
                </div>
                <div id="step-2-status" class="hidden">
                    <span class="text-xs text-brandSuccess-400 font-medium">✓ Completado</span>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label for="customer_name" class="flex items-center gap-2 caption text-brandNeutral-400 mb-2">
                        <i data-lucide="user" class="size-4"></i>
                        <span>Nombre Completo *</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="customer_name" 
                            name="customer_name" 
                            class="w-full px-4 py-3 pl-11 border-2 border-brandWhite-300 rounded-lg caption focus:border-brandPrimary-300 focus:ring-2 focus:ring-brandPrimary-100 transition-all duration-200"
                            placeholder="Tu nombre completo"
                            required
                        >
                        <i data-lucide="user" class="absolute left-3 top-1/2 transform -translate-y-1/2 size-5 text-brandNeutral-300 pointer-events-none"></i>
                        <div id="name_success" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2">
                            <i data-lucide="check-circle" class="size-5 text-brandSuccess-400"></i>
                        </div>
                    </div>
                    <div id="name_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
                
                <div>
                    <label for="customer_phone" class="flex items-center gap-2 caption text-brandNeutral-400 mb-2">
                        <i data-lucide="phone" class="size-4"></i>
                        <span>Teléfono WhatsApp *</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="tel" 
                            id="customer_phone" 
                            name="customer_phone" 
                            class="w-full px-4 py-3 pl-11 border-2 border-brandWhite-300 rounded-lg caption focus:border-brandPrimary-300 focus:ring-2 focus:ring-brandPrimary-100 transition-all duration-200"
                            placeholder="3001234567"
                            required
                        >
                        <i data-lucide="phone" class="absolute left-3 top-1/2 transform -translate-y-1/2 size-5 text-brandNeutral-300 pointer-events-none"></i>
                        <div id="phone_success" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2">
                            <i data-lucide="check-circle" class="size-5 text-brandSuccess-400"></i>
                        </div>
                    </div>
                    <div id="phone_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
                
                <div>
                    <label for="party_size" class="flex items-center gap-2 caption text-brandNeutral-400 mb-2">
                        <i data-lucide="users" class="size-4"></i>
                        <span>Número de Personas *</span>
                    </label>
                    <div class="relative">
                        <select 
                            id="party_size" 
                            name="party_size" 
                            class="w-full px-4 py-3 pl-11 border-2 border-brandWhite-300 rounded-lg caption focus:border-brandPrimary-300 focus:ring-2 focus:ring-brandPrimary-100 transition-all duration-200 appearance-none bg-white"
                            required
                        >
                            <option value="">Selecciona número de personas</option>
                            @for($i = 2; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'persona' : 'personas' }}</option>
                            @endfor
                            <option value="11">10+ personas</option>
                        </select>
                        <i data-lucide="users" class="absolute left-3 top-1/2 transform -translate-y-1/2 size-5 text-brandNeutral-300 pointer-events-none"></i>
                        <i data-lucide="chevron-down" class="absolute right-3 top-1/2 transform -translate-y-1/2 size-5 text-brandNeutral-300 pointer-events-none"></i>
                        <div id="party_size_success" class="hidden absolute right-10 top-1/2 transform -translate-y-1/2">
                            <i data-lucide="check-circle" class="size-5 text-brandSuccess-400"></i>
                        </div>
                    </div>
                    <div id="party_size_error" class="hidden mt-1 caption text-brandError-400"></div>
                </div>
                
                <div>
                    <label for="notes" class="flex items-center gap-2 caption text-brandNeutral-400 mb-2">
                        <i data-lucide="message-square" class="size-4"></i>
                        <span>Notas Especiales (opcional)</span>
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="3"
                        class="w-full px-4 py-3 border-2 border-brandWhite-300 rounded-lg caption resize-none focus:border-brandPrimary-300 focus:ring-2 focus:ring-brandPrimary-100 transition-all duration-200"
                        placeholder="Alergias, preferencias, celebraciones especiales..."
                    ></textarea>
                </div>
            </div>
        </div>

        <!-- CARD 3: Anticipo (si está habilitado) -->
        @if($settings->require_deposit)
        <div class="bg-brandWhite-50 rounded-lg p-5 border-2 border-brandWhite-300 mb-4 transition-all duration-300" id="step-3-card">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3 transition-all duration-300" id="step-3-number">
                        <span id="step-3-number-text">3</span>
                        <i data-lucide="check" class="hidden size-5" id="step-3-check"></i>
                    </div>
                    <h3 class="caption-strong text-brandNeutral-400">Anticipo</h3>
                </div>
                <div id="step-3-status" class="hidden">
                    <span class="text-xs text-brandSuccess-400 font-medium">✓ Completado</span>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="bg-gradient-to-r from-brandInfo-50 to-brandPrimary-50 border-2 border-brandInfo-300 rounded-lg p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <i data-lucide="dollar-sign" class="size-5 text-brandInfo-400"></i>
                        <p class="caption text-brandNeutral-400">
                            <strong class="caption-strong text-brandNeutral-500">Monto del anticipo:</strong> 
                            <span id="deposit-amount-display" class="text-brandPrimary-300 font-bold">$0</span> 
                            <span class="text-brandNeutral-300">(${{ number_format($settings->deposit_per_person, 0, ',', '.') }} por persona)</span>
                        </p>
                    </div>
                    <p class="caption text-brandNeutral-400 flex items-center gap-2">
                        <i data-lucide="info" class="size-4"></i>
                        <span>Este anticipo se descontará del consumo final.</span>
                    </p>
                </div>
                
                @if($bankAccounts->count() > 0)
                    <div>
                        <label class="flex items-center gap-2 caption text-brandNeutral-400 mb-3">
                            <i data-lucide="credit-card" class="size-4"></i>
                            <span>Datos Bancarios</span>
                        </label>
                        <div class="space-y-3">
                            @foreach($bankAccounts as $account)
                                <div class="bg-brandWhite-100 border-2 border-brandWhite-300 rounded-lg p-4 hover:border-brandPrimary-200 transition-colors">
                                    <div class="space-y-2.5">
                                        <div class="flex justify-between items-center">
                                            <span class="caption text-brandNeutral-400 flex items-center gap-2">
                                                <i data-lucide="building-2" class="size-3.5"></i>
                                                Banco:
                                            </span>
                                            <span class="caption-strong text-brandNeutral-500">{{ $account->bank }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="caption text-brandNeutral-400 flex items-center gap-2">
                                                <i data-lucide="file-text" class="size-3.5"></i>
                                                Tipo:
                                            </span>
                                            <span class="caption-strong text-brandNeutral-500">{{ $account->account_type }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="caption text-brandNeutral-400 flex items-center gap-2">
                                                <i data-lucide="hash" class="size-3.5"></i>
                                                Número:
                                            </span>
                                            <span class="caption-strong text-brandNeutral-500 font-mono text-sm">{{ $account->account_number }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="caption text-brandNeutral-400 flex items-center gap-2">
                                                <i data-lucide="user" class="size-3.5"></i>
                                                Titular:
                                            </span>
                                            <span class="caption-strong text-brandNeutral-500">{{ $account->account_holder }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div>
                        <label for="payment_proof" class="flex items-center gap-2 caption text-brandNeutral-400 mb-2">
                            <i data-lucide="upload" class="size-4"></i>
                            <span>Comprobante de Pago *</span>
                        </label>
                        <div class="border-2 border-dashed border-brandWhite-300 rounded-lg p-6 text-center hover:border-brandPrimary-300 hover:bg-brandPrimary-50 transition-all duration-200 cursor-pointer group" id="payment_proof_dropzone">
                            <input 
                                type="file" 
                                id="payment_proof" 
                                name="payment_proof" 
                                accept=".jpg,.jpeg,.png,.pdf"
                                class="hidden"
                                required
                            >
                            <label for="payment_proof" class="cursor-pointer block">
                                <div class="text-5xl mb-3 group-hover:scale-110 transition-transform duration-200">📎</div>
                                <p class="caption text-brandNeutral-400 font-medium mb-1">Haz clic para subir comprobante</p>
                                <p class="caption text-brandNeutral-300 text-xs">JPG, PNG o PDF (máx. 5MB)</p>
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
        <div class="bg-brandWhite-50 rounded-lg p-5 border-2 border-brandWhite-300 sticky bottom-4 z-10 shadow-lg">
            <button 
                type="submit" 
                id="btn-submit-reservation"
                class="w-full bg-gradient-to-r from-brandPrimary-300 to-brandPrimary-400 hover:from-brandPrimary-200 hover:to-brandPrimary-300 text-brandWhite-100 py-4 rounded-full caption-strong font-medium transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:from-brandNeutral-200 disabled:to-brandNeutral-300 shadow-md hover:shadow-lg transform hover:scale-[1.02] disabled:transform-none flex items-center justify-center gap-2"
                disabled
            >
                <span id="btn-text" class="flex items-center gap-2">
                    <i data-lucide="send" class="size-4"></i>
                    <span>Solicitar Reserva</span>
                </span>
                <span id="btn-loading" class="hidden flex items-center gap-2">
                    <span class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-brandWhite-100 border-t-transparent"></span>
                    <span>Procesando...</span>
                </span>
            </button>
            <p class="text-center caption text-brandNeutral-300 mt-3">
                <i data-lucide="lock" class="size-3 inline-block mr-1"></i>
                Tus datos están protegidos
            </p>
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
    
    // Días de la semana deshabilitados (0 = domingo, 1 = lunes, ..., 6 = sábado)
    const disabledWeekdays = @json($disabledWeekdays ?? []);
    
    // DEBUG: Verificar qué días se están deshabilitando
    console.log('🔍 Días deshabilitados recibidos del backend:', disabledWeekdays);
    console.log('📅 Día de hoy (número):', new Date().getDay());
    
    // Inicializar el datepicker con días deshabilitados
    if (window.initReservationDatepicker) {
        console.log('✅ Inicializando datepicker con opciones:', { disableWeekdays: disabledWeekdays });
        await window.initReservationDatepicker(dateInput, {
            disableWeekdays: disabledWeekdays
        });
        
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
            // Validar formulario después de subir el comprobante
            setTimeout(validateForm, 100);
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
                    // Horario disponible: default, hover y active
                    button.className += ' border-brandSuccess-400 text-brandSuccess-400 bg-brandSuccess-50 hover:bg-brandPrimary-300 hover:text-brandWhite-50 cursor-pointer';
                }
                
                button.textContent = slot.time;
                button.dataset.time = slot.time;
                
                // Solo agregar evento click si está disponible
                if (slot.available && slot.status !== 'full' && slot.reservations_count === 0) {
                    button.addEventListener('click', function() {
                        // Remover estado active de todos los botones
                        document.querySelectorAll('#time-slots-grid button').forEach(btn => {
                            btn.classList.remove('bg-brandPrimary-300', 'text-brandWhite-50', 'border-brandPrimary-300');
                            // Restaurar estilo por defecto si está disponible
                            if (!btn.disabled) {
                                btn.classList.add('bg-brandSuccess-50', 'border-brandSuccess-400', 'text-brandSuccess-400');
                            }
                        });
                        // Agregar estado active al botón seleccionado
                        this.classList.remove('bg-brandSuccess-50', 'border-brandSuccess-400', 'text-brandSuccess-400');
                        this.classList.add('bg-brandPrimary-300', 'text-brandWhite-50', 'border-brandPrimary-300');
                        selectedTime.value = this.dataset.time;
                        // Actualizar estado del paso 1 cuando se selecciona hora
                        updateStepStatus(1, true);
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
        const dropzone = document.getElementById('payment_proof_dropzone');
        
        if (!file) {
            preview.classList.add('hidden');
            return;
        }
        
        const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!allowedTypes.includes(file.type)) {
            errorElement.textContent = 'Solo se permiten archivos JPG, PNG o PDF';
            errorElement.classList.remove('hidden');
            dropzone.classList.add('border-brandError-300', 'bg-brandError-50');
            dropzone.classList.remove('border-brandSuccess-300', 'bg-brandSuccess-50');
            return;
        }
        
        if (file.size > maxSize) {
            errorElement.textContent = 'El archivo no puede ser mayor a 5MB';
            errorElement.classList.remove('hidden');
            dropzone.classList.add('border-brandError-300', 'bg-brandError-50');
            dropzone.classList.remove('border-brandSuccess-300', 'bg-brandSuccess-50');
            return;
        }
        
        errorElement.classList.add('hidden');
        dropzone.classList.add('border-brandSuccess-300', 'bg-brandSuccess-50');
        dropzone.classList.remove('border-brandWhite-300', 'hover:border-brandPrimary-300', 'hover:bg-brandPrimary-50');
        
        const fileIcon = file.type === 'application/pdf' ? 'file-text' : 'image';
        preview.innerHTML = `
            <div class="flex items-center gap-3 p-4 bg-brandSuccess-50 border-2 border-brandSuccess-300 rounded-lg animate-fade-in">
                <div class="w-12 h-12 bg-brandSuccess-200 rounded-lg flex items-center justify-center">
                    <i data-lucide="${fileIcon}" class="size-6 text-brandSuccess-400"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="caption-strong text-brandNeutral-500 truncate">${file.name}</p>
                    <p class="caption text-brandNeutral-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                </div>
                <div class="text-brandSuccess-400">
                    <i data-lucide="check-circle" class="size-6"></i>
                </div>
            </div>
        `;
        preview.classList.remove('hidden');
        
        // Actualizar indicador del paso 3
        updateStepStatus(3, true);
        
        // Inicializar iconos de Lucide
        if (window.lucide) {
            lucide.createIcons();
        }
    }
    
    // Función para actualizar el estado visual de cada paso
    function updateStepStatus(stepNumber, completed) {
        const numberEl = document.getElementById(`step-${stepNumber}-number`);
        const numberText = document.getElementById(`step-${stepNumber}-number-text`);
        const checkIcon = document.getElementById(`step-${stepNumber}-check`);
        const statusEl = document.getElementById(`step-${stepNumber}-status`);
        const cardEl = document.getElementById(`step-${stepNumber}-card`);
        
        if (completed) {
            numberEl.classList.remove('bg-brandPrimary-50', 'text-brandPrimary-300');
            numberEl.classList.add('bg-brandSuccess-400', 'text-white');
            if (numberText) numberText.classList.add('hidden');
            if (checkIcon) checkIcon.classList.remove('hidden');
            if (statusEl) statusEl.classList.remove('hidden');
            if (cardEl) cardEl.classList.add('border-brandSuccess-300');
        } else {
            numberEl.classList.add('bg-brandPrimary-50', 'text-brandPrimary-300');
            numberEl.classList.remove('bg-brandSuccess-400', 'text-white');
            if (numberText) numberText.classList.remove('hidden');
            if (checkIcon) checkIcon.classList.add('hidden');
            if (statusEl) statusEl.classList.add('hidden');
            if (cardEl) cardEl.classList.remove('border-brandSuccess-300');
        }
        
        // Inicializar iconos de Lucide
        if (window.lucide) {
            lucide.createIcons();
        }
    }
    
    // Función para mostrar éxito en campos
    function showFieldSuccess(fieldId) {
        const successEl = document.getElementById(`${fieldId}_success`);
        if (successEl) {
            successEl.classList.remove('hidden');
        }
    }
    
    function hideFieldSuccess(fieldId) {
        const successEl = document.getElementById(`${fieldId}_success`);
        if (successEl) {
            successEl.classList.add('hidden');
        }
    }
    
    function validateForm() {
        const date = dateInput.value;
        const time = selectedTime.value;
        const name = document.getElementById('customer_name').value.trim();
        const phone = document.getElementById('customer_phone').value.trim();
        const partySize = partySizeInput.value;
        
        let isValid = true;
        let step1Complete = false;
        let step2Complete = false;
        let step3Complete = true; // Por defecto true si no se requiere anticipo
        
        // Validar fecha
        if (date) {
            showFieldSuccess('date');
            step1Complete = true;
        } else {
            hideFieldSuccess('date');
            isValid = false;
        }
        
        // Validar hora
        if (time) {
            step1Complete = true;
        } else {
            isValid = false;
        }
        
        // Actualizar estado del paso 1
        updateStepStatus(1, step1Complete);
        
        // Validar campos requeridos del paso 2
        if (name) {
            showFieldSuccess('name');
        } else {
            hideFieldSuccess('name');
            isValid = false;
        }
        
        if (phone) {
            showFieldSuccess('phone');
        } else {
            hideFieldSuccess('phone');
            isValid = false;
        }
        
        if (partySize) {
            showFieldSuccess('party_size');
            step2Complete = true;
        } else {
            hideFieldSuccess('party_size');
            isValid = false;
        }
        
        // Actualizar estado del paso 2
        updateStepStatus(2, step2Complete);
        
        // Validar comprobante si se requiere
        @if($settings->require_deposit)
        const paymentProof = document.getElementById('payment_proof');
        if (paymentProof) {
            if (paymentProof.files[0]) {
                step3Complete = true;
            } else {
                step3Complete = false;
                isValid = false;
            }
        }
        @endif
        
        // Actualizar estado del paso 3
        @if($settings->require_deposit)
        updateStepStatus(3, step3Complete);
        @endif
        
        submitBtn.disabled = !isValid;
        return isValid;
    }
    
    // Validar en tiempo real con feedback visual
    ['customer_name', 'customer_phone', 'party_size'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                validateForm();
            });
            field.addEventListener('blur', function() {
                if (this.value.trim()) {
                    showFieldSuccess(fieldId);
                } else {
                    hideFieldSuccess(fieldId);
                }
            });
        }
    });
    
    // Validar fecha cuando cambia
    dateInput.addEventListener('change', function() {
        if (this.value) {
            showFieldSuccess('date');
        } else {
            hideFieldSuccess('date');
        }
        validateForm();
    });
    
    // Inicializar iconos de Lucide al cargar
    if (window.lucide) {
        lucide.createIcons();
    }
});
</script>
@endpush
@endsection

