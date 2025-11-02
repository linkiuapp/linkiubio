@extends('frontend.layouts.app')

@push('meta')
    <meta name="description" content="Reserva una habitación en {{ $store->name }} - Reserva tu estadía con anticipación">
    <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
<div class="px-4 py-4 sm:py-6">
    <!-- Header -->
    <div class="text-center mb-6">
        <h1 class="h1 text-brandNeutral-400 mb-2">Reservar Habitación</h1>
        <p class="caption text-brandNeutral-400">Selecciona fechas, habitación y completa tu información</p>
    </div>

    <!-- Formulario de Reserva -->
    <form id="hotel-reservation-form" method="POST" action="{{ route('tenant.hotel-reservations.store', $store->slug) }}" enctype="multipart/form-data">
        @csrf

        <!-- PASO 1: Fechas y Huéspedes -->
        <div id="step-1" class="step-container bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">1</div>
                <h3 class="caption-strong text-brandNeutral-400">Fechas y Huéspedes</h3>
            </div>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="check_in_date" class="block caption text-brandNeutral-400 mb-2">Check-in *</label>
                        <input 
                            type="date" 
                            id="check_in_date" 
                            name="check_in_date"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                            required
                        >
                        <div id="check_in_error" class="hidden mt-1 caption text-brandError-400"></div>
                    </div>
                    
                    <div>
                        <label for="check_out_date" class="block caption text-brandNeutral-400 mb-2">Check-out *</label>
                        <input 
                            type="date" 
                            id="check_out_date" 
                            name="check_out_date"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                            required
                        >
                        <div id="check_out_error" class="hidden mt-1 caption text-brandError-400"></div>
                    </div>
                </div>
                
                <div id="nights-display" class="hidden p-3 bg-brandInfo-50 border border-brandInfo-300 rounded-lg">
                    <p class="caption text-brandNeutral-400">
                        <span id="nights-count">0</span> <span id="nights-text">noches</span>
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="num_adults" class="block caption text-brandNeutral-400 mb-2">Adultos *</label>
                        <select 
                            id="num_adults" 
                            name="num_adults"
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                            required
                        >
                            <option value="">Selecciona...</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'adulto' : 'adultos' }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div>
                        <label for="num_children" class="block caption text-brandNeutral-400 mb-2">Niños</label>
                        <select 
                            id="num_children" 
                            name="num_children"
                            class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                        >
                            <option value="0">0</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'niño' : 'niños' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="button" id="btn-search-availability" class="btn-primary" disabled>
                        Buscar Disponibilidad
                    </button>
                </div>
            </div>
        </div>

        <!-- PASO 2: Selección de Habitación (oculto inicialmente) -->
        <div id="step-2" class="step-container bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4 hidden">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">2</div>
                <h3 class="caption-strong text-brandNeutral-400">Selecciona Habitación</h3>
            </div>
            
            <div id="room-types-container" class="space-y-4">
                <div id="loading-room-types" class="text-center py-8 hidden">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-brandPrimary-300 mx-auto mb-2"></div>
                    <p class="caption text-brandNeutral-400">Buscando habitaciones disponibles...</p>
                </div>
                <div id="room-types-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Se carga dinámicamente -->
                </div>
                <div id="no-room-types" class="hidden text-center py-8">
                    <p class="caption text-brandError-400">No hay habitaciones disponibles para las fechas seleccionadas</p>
                </div>
            </div>
        </div>

        <!-- PASO 3: Datos del Huésped (oculto inicialmente) -->
        <div id="step-3" class="step-container bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4 hidden">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">3</div>
                <h3 class="caption-strong text-brandNeutral-400">Datos del Huésped</h3>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label for="guest_name" class="block caption text-brandNeutral-400 mb-2">Nombre Completo *</label>
                    <input 
                        type="text" 
                        id="guest_name" 
                        name="guest_name"
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                        placeholder="Tu nombre completo"
                        required
                    >
                </div>
                
                <div>
                    <label for="guest_phone" class="block caption text-brandNeutral-400 mb-2">Teléfono WhatsApp *</label>
                    <input 
                        type="tel" 
                        id="guest_phone" 
                        name="guest_phone"
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                        placeholder="3001234567"
                        required
                    >
                </div>
                
                <div>
                    <label for="guest_email" class="block caption text-brandNeutral-400 mb-2">Email</label>
                    <input 
                        type="email" 
                        id="guest_email" 
                        name="guest_email"
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                        placeholder="correo@ejemplo.com"
                    >
                </div>
                
                <div>
                    <label for="guest_document" class="block caption text-brandNeutral-400 mb-2">Documento (Cédula/Pasaporte)</label>
                    <input 
                        type="text" 
                        id="guest_document" 
                        name="guest_document"
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                        placeholder="Número de documento"
                    >
                </div>
                
                <div>
                    <label for="estimated_arrival_time" class="block caption text-brandNeutral-400 mb-2">Hora Estimada de Llegada</label>
                    <select 
                        id="estimated_arrival_time" 
                        name="estimated_arrival_time"
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption"
                    >
                        <option value="">Selecciona...</option>
                        <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                        <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                        <option value="4:00 PM - 5:00 PM">4:00 PM - 5:00 PM</option>
                        <option value="5:00 PM - 6:00 PM">5:00 PM - 6:00 PM</option>
                        <option value="Después de 6:00 PM">Después de 6:00 PM</option>
                    </select>
                </div>
                
                <div>
                    <label for="special_requests" class="block caption text-brandNeutral-400 mb-2">Solicitudes Especiales</label>
                    <textarea 
                        id="special_requests" 
                        name="special_requests"
                        rows="3"
                        class="w-full px-4 py-3 border border-brandWhite-300 rounded-lg caption resize-none"
                        placeholder="Alergias, preferencias, celebraciones especiales..."
                    ></textarea>
                </div>
            </div>
        </div>

        <!-- PASO 4: Resumen y Anticipo (oculto inicialmente) -->
        <div id="step-4" class="step-container bg-brandWhite-50 rounded-lg p-4 border border-brandWhite-300 mb-4 hidden">
            <div class="flex items-center mb-4">
                <div class="w-8 h-8 bg-brandPrimary-50 text-brandPrimary-300 rounded-full flex items-center justify-center caption-strong mr-3">4</div>
                <h3 class="caption-strong text-brandNeutral-400">Resumen y Anticipo</h3>
            </div>
            
            <div id="summary-container" class="space-y-4">
                <!-- Se completa dinámicamente -->
            </div>
        </div>

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
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del formulario
    const form = document.getElementById('hotel-reservation-form');
    const checkInInput = document.getElementById('check_in_date');
    const checkOutInput = document.getElementById('check_out_date');
    const numAdultsSelect = document.getElementById('num_adults');
    const numChildrenSelect = document.getElementById('num_children');
    const btnSearchAvailability = document.getElementById('btn-search-availability');
    const btnSubmit = document.getElementById('btn-submit-reservation');
    
    // Campos ocultos para almacenar selección
    const selectedRoomTypeInput = document.createElement('input');
    selectedRoomTypeInput.type = 'hidden';
    selectedRoomTypeInput.name = 'room_type_id';
    selectedRoomTypeInput.id = 'selected_room_type_id';
    form.appendChild(selectedRoomTypeInput);
    
    const selectedServicesInput = document.createElement('input');
    selectedServicesInput.type = 'hidden';
    selectedServicesInput.name = 'selected_services';
    selectedServicesInput.id = 'selected_services';
    form.appendChild(selectedServicesInput);
    
    let currentPricing = null;
    let selectedRoomType = null;
    let selectedServices = [];
    let bankAccounts = @json($bankAccounts ?? []);
    
    // Calcular número de noches
    function calculateNights() {
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;
        
        if (checkIn && checkOut) {
            const checkInDate = new Date(checkIn);
            const checkOutDate = new Date(checkOut);
            const diffTime = Math.abs(checkOutDate - checkInDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            const nightsDisplay = document.getElementById('nights-display');
            const nightsCount = document.getElementById('nights-count');
            const nightsText = document.getElementById('nights-text');
            
            if (diffDays > 0) {
                nightsDisplay.classList.remove('hidden');
                nightsCount.textContent = diffDays;
                nightsText.textContent = diffDays === 1 ? 'noche' : 'noches';
            } else {
                nightsDisplay.classList.add('hidden');
            }
        }
        
        validateStep1();
    }
    
    // Validar paso 1
    function validateStep1() {
        const isValid = checkInInput.value && 
                       checkOutInput.value && 
                       checkOutInput.value > checkInInput.value &&
                       numAdultsSelect.value;
        btnSearchAvailability.disabled = !isValid;
    }
    
    // Buscar disponibilidad
    btnSearchAvailability.addEventListener('click', async function() {
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;
        
        if (!checkIn || !checkOut || checkOut <= checkIn) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor, selecciona fechas válidas'
            });
            return;
        }
        
        const step2 = document.getElementById('step-2');
        const loadingContainer = document.getElementById('loading-room-types');
        const gridContainer = document.getElementById('room-types-grid');
        const noRoomsContainer = document.getElementById('no-room-types');
        
        step2.classList.remove('hidden');
        loadingContainer.classList.remove('hidden');
        gridContainer.innerHTML = '';
        noRoomsContainer.classList.add('hidden');
        
        try {
            const response = await fetch(`/{{ $store->slug }}/reservas-hotel/api/available-room-types`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    check_in_date: checkIn,
                    check_out_date: checkOut
                })
            });
            
            const data = await response.json();
            loadingContainer.classList.add('hidden');
            
            if (!data.success) {
                noRoomsContainer.classList.remove('hidden');
                return;
            }
            
            if (!data.room_types || data.room_types.length === 0) {
                noRoomsContainer.classList.remove('hidden');
                return;
            }
            
            // Renderizar tipos de habitación disponibles
            gridContainer.innerHTML = '';
            data.room_types.forEach(roomType => {
                const card = createRoomTypeCard(roomType, checkIn, checkOut);
                gridContainer.appendChild(card);
            });
            
        } catch (error) {
            loadingContainer.classList.add('hidden');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al buscar disponibilidad. Por favor intenta de nuevo.'
            });
        }
    });
    
    // Crear tarjeta de tipo de habitación
    function createRoomTypeCard(roomType, checkIn, checkOut) {
        const card = document.createElement('div');
        card.className = 'bg-brandWhite-100 border-2 border-brandWhite-300 rounded-lg p-4 hover:border-brandPrimary-300 transition-colors';
        card.innerHTML = `
            <div class="space-y-3">
                <h4 class="caption-strong text-brandNeutral-400">${roomType.name}</h4>
                ${roomType.description ? `<p class="caption text-brandNeutral-300">${roomType.description}</p>` : ''}
                
                <div class="flex items-center gap-2 text-sm text-brandNeutral-400">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span>Hasta ${roomType.max_occupancy} personas</span>
                </div>
                
                ${roomType.amenities && roomType.amenities.length > 0 ? `
                    <div class="flex flex-wrap gap-1">
                        ${roomType.amenities.map(a => `<span class="text-xs bg-brandInfo-50 text-brandInfo-400 px-2 py-1 rounded">${a}</span>`).join('')}
                    </div>
                ` : ''}
                
                <div class="pt-2 border-t border-brandWhite-300">
                    <p class="caption text-brandNeutral-400">
                        <span class="font-semibold">$${new Intl.NumberFormat('es-CO').format(roomType.base_price_per_night)}</span> por noche
                    </p>
                    ${roomType.extra_person_price > 0 ? `
                        <p class="caption text-brandNeutral-300 text-xs">
                            Persona adicional: $${new Intl.NumberFormat('es-CO').format(roomType.extra_person_price)}/noche
                        </p>
                    ` : ''}
                    <p class="caption text-brandSuccess-400 mt-1">
                        ${roomType.available_count} disponible${roomType.available_count === 1 ? '' : 's'}
                    </p>
                </div>
                
                <button type="button" class="w-full btn-primary select-room-type-btn" data-room-type-id="${roomType.room_type_id}">
                    Seleccionar
                </button>
            </div>
        `;
        
        // Event listener para seleccionar habitación
        card.querySelector('.select-room-type-btn').addEventListener('click', async function() {
            await selectRoomType(roomType, checkIn, checkOut);
        });
        
        return card;
    }
    
    // Seleccionar tipo de habitación
    async function selectRoomType(roomType, checkIn, checkOut) {
        selectedRoomType = roomType;
        selectedRoomTypeInput.value = roomType.room_type_id;
        
        // Calcular precio
        const numAdults = parseInt(numAdultsSelect.value) || 1;
        const numChildren = parseInt(numChildrenSelect.value) || 0;
        
        try {
            const response = await fetch(`/{{ $store->slug }}/reservas-hotel/api/calculate-pricing`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    room_type_id: roomType.room_type_id,
                    check_in_date: checkIn,
                    check_out_date: checkOut,
                    num_adults: numAdults,
                    num_children: numChildren,
                    selected_services: selectedServices
                })
            });
            
            const data = await response.json();
            
            if (!data.success) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error al calcular el precio'
                });
                return;
            }
            
            currentPricing = data.pricing;
            
            // Mostrar paso 3
            document.getElementById('step-3').classList.remove('hidden');
            
            // Mostrar paso 4 con resumen
            showSummary(data.pricing, data.deposit_amount, roomType);
            document.getElementById('step-4').classList.remove('hidden');
            
            // Habilitar botón de submit
            btnSubmit.disabled = false;
            
            // Scroll a paso 3
            document.getElementById('step-3').scrollIntoView({ behavior: 'smooth', block: 'start' });
            
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al calcular el precio'
            });
        }
    }
    
    // Manejar subida de comprobante de pago
    function handlePaymentProofUpload(file) {
        const preview = document.getElementById('payment_proof_preview');
        const errorElement = document.getElementById('payment_proof_error');
        
        if (!file) {
            if (preview) preview.classList.add('hidden');
            return;
        }
        
        const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!allowedTypes.includes(file.type)) {
            if (errorElement) {
                errorElement.textContent = 'Solo se permiten archivos JPG, PNG o PDF';
                errorElement.classList.remove('hidden');
            }
            return;
        }
        
        if (file.size > maxSize) {
            if (errorElement) {
                errorElement.textContent = 'El archivo no puede ser mayor a 5MB';
                errorElement.classList.remove('hidden');
            }
            return;
        }
        
        if (errorElement) errorElement.classList.add('hidden');
        if (preview) {
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
    }
    
    // Event listener para comprobante de pago
    document.addEventListener('change', function(e) {
        if (e.target && e.target.id === 'payment_proof' && e.target.files && e.target.files[0]) {
            handlePaymentProofUpload(e.target.files[0]);
        }
    });
    
    // Mostrar resumen
    function showSummary(pricing, depositAmount, roomType) {
        const container = document.getElementById('summary-container');
        container.innerHTML = `
            <div class="space-y-4">
                <div class="bg-brandWhite-100 border border-brandWhite-300 rounded-lg p-4">
                    <h4 class="caption-strong text-brandNeutral-400 mb-3">Resumen de Reserva</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-brandNeutral-400">Habitación:</span>
                            <span class="text-brandNeutral-400 font-semibold">${roomType.name}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-brandNeutral-400">Check-in:</span>
                            <span class="text-brandNeutral-400">${formatDate(checkInInput.value)}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-brandNeutral-400">Check-out:</span>
                            <span class="text-brandNeutral-400">${formatDate(checkOutInput.value)}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-brandNeutral-400">Noches:</span>
                            <span class="text-brandNeutral-400">${pricing.num_nights}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-brandNeutral-400">Huéspedes:</span>
                            <span class="text-brandNeutral-400">${numAdultsSelect.value} adultos${numChildrenSelect.value > 0 ? `, ${numChildrenSelect.value} niños` : ''}</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-brandInfo-50 border border-brandInfo-300 rounded-lg p-4">
                    <h4 class="caption-strong text-brandNeutral-400 mb-3">Desglose de Precios</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-brandNeutral-400">Habitación (${pricing.num_nights} noches):</span>
                            <span class="text-brandNeutral-400">$${new Intl.NumberFormat('es-CO').format(pricing.base_price)}</span>
                        </div>
                        ${pricing.extra_person_charge > 0 ? `
                            <div class="flex justify-between">
                                <span class="text-brandNeutral-400">Personas adicionales:</span>
                                <span class="text-brandNeutral-400">$${new Intl.NumberFormat('es-CO').format(pricing.extra_person_charge)}</span>
                            </div>
                        ` : ''}
                        ${pricing.services_total > 0 ? `
                            <div class="flex justify-between">
                                <span class="text-brandNeutral-400">Servicios adicionales:</span>
                                <span class="text-brandNeutral-400">$${new Intl.NumberFormat('es-CO').format(pricing.services_total)}</span>
                            </div>
                        ` : ''}
                        ${pricing.security_deposit > 0 ? `
                            <div class="flex justify-between">
                                <span class="text-brandNeutral-400">Depósito de seguridad:</span>
                                <span class="text-brandNeutral-400">$${new Intl.NumberFormat('es-CO').format(pricing.security_deposit)}</span>
                            </div>
                        ` : ''}
                        <div class="flex justify-between pt-2 border-t border-brandInfo-300">
                            <span class="caption-strong text-brandNeutral-400">Total:</span>
                            <span class="caption-strong text-brandPrimary-300">$${new Intl.NumberFormat('es-CO').format(pricing.total)}</span>
                        </div>
                    </div>
                </div>
                
                ${depositAmount > 0 ? `
                    <div class="bg-brandWarning-50 border border-brandWarning-300 rounded-lg p-4">
                        <p class="caption text-brandNeutral-400 mb-2">
                            <strong class="caption-strong">Anticipo requerido:</strong> $${new Intl.NumberFormat('es-CO').format(depositAmount)}
                        </p>
                        <p class="caption text-brandNeutral-300 text-xs">
                            El anticipo se descontará del total al momento del check-out.
                        </p>
                    </div>
                    ${bankAccounts && bankAccounts.length > 0 ? `
                        <div class="bg-brandInfo-50 border border-brandInfo-300 rounded-lg p-4">
                            <h4 class="caption-strong text-brandNeutral-400 mb-3">Datos Bancarios para Transferencia</h4>
                            <div class="space-y-3">
                                ${bankAccounts.map(account => {
                                    const bankName = account.bank_name || '-';
                                    const accountType = account.account_type || '-';
                                    const accountNumber = account.account_number || '-';
                                    const accountHolder = account.account_holder || '-';
                                    return `
                                        <div class="bg-brandWhite-100 border border-brandWhite-300 rounded-lg p-3">
                                            <div class="space-y-1">
                                                <div class="flex justify-between">
                                                    <span class="caption text-brandNeutral-400">Banco:</span>
                                                    <span class="caption-strong text-brandNeutral-400">${bankName}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="caption text-brandNeutral-400">Tipo:</span>
                                                    <span class="caption-strong text-brandNeutral-400">${accountType}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="caption text-brandNeutral-400">Número:</span>
                                                    <span class="caption-strong text-brandNeutral-400 font-mono">${accountNumber}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="caption text-brandNeutral-400">Titular:</span>
                                                    <span class="caption-strong text-brandNeutral-400">${accountHolder}</span>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                }).join('')}
                            </div>
                        </div>
                    ` : ''}
                    <div>
                        <label for="payment_proof" class="block caption text-brandNeutral-400 mb-2">Comprobante de Pago ${depositAmount > 0 ? '(Opcional)' : ''}</label>
                        <div class="border-2 border-dashed border-brandWhite-300 rounded-lg p-6 text-center hover:border-brandPrimary-300 transition-colors">
                            <input 
                                type="file" 
                                id="payment_proof" 
                                name="payment_proof" 
                                accept=".jpg,.jpeg,.png,.pdf"
                                class="hidden"
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
                ` : ''}
            </div>
        `;
    }
    
    // Formatear fecha
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
    }
    
    // Event listeners
    checkInInput.addEventListener('change', function() {
        if (checkOutInput.value && checkOutInput.value <= this.value) {
            const minDate = new Date(this.value);
            minDate.setDate(minDate.getDate() + 1);
            checkOutInput.min = minDate.toISOString().split('T')[0];
        }
        calculateNights();
    });
    
    checkOutInput.addEventListener('change', calculateNights);
    numAdultsSelect.addEventListener('change', validateStep1);
    numChildrenSelect.addEventListener('change', validateStep1);
    
    // Validar formulario antes de enviar
    form.addEventListener('submit', function(e) {
        if (!selectedRoomTypeInput.value) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Faltan datos',
                text: 'Por favor, completa todos los pasos del formulario'
            });
            return false;
        }
        
        btnSubmit.disabled = true;
        document.getElementById('btn-text').classList.add('hidden');
        document.getElementById('btn-loading').classList.remove('hidden');
    });
    
    // Inicializar
    validateStep1();
});
</script>
@endpush
@endsection

