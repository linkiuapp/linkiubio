<x-tenant-admin-layout :store="$store">
@section('title', 'Nueva Reserva de Hotel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('tenant.admin.hotel.reservations.index', $store->slug) }}" 
               class="text-black-300 hover:text-black-400">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-lg font-semibold text-black-500">Nueva Reserva Manual</h1>
        </div>
        <p class="text-sm text-black-300">Crea una reserva de habitación desde una llamada telefónica o solicitud directa</p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-error-50 border border-error-200 rounded-lg">
            <ul class="list-disc list-inside space-y-1 text-sm text-error-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tenant.admin.hotel.reservations.store', $store->slug) }}" method="POST" class="space-y-6" id="hotel-reservation-form">
        @csrf

        <!-- Información del Huésped -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Información del Huésped</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="lg:col-span-2">
                    <label for="guest_name" class="block text-sm font-medium text-black-400 mb-2">
                        Nombre Completo *
                    </label>
                    <input type="text" 
                           id="guest_name" 
                           name="guest_name" 
                           value="{{ old('guest_name') }}" 
                           required
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="Nombre completo del huésped">
                    @error('guest_name')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="guest_phone" class="block text-sm font-medium text-black-400 mb-2">
                        Teléfono / WhatsApp *
                    </label>
                    <input type="tel" 
                           id="guest_phone" 
                           name="guest_phone" 
                           value="{{ old('guest_phone') }}" 
                           required
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="3001234567">
                    @error('guest_phone')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="guest_email" class="block text-sm font-medium text-black-400 mb-2">
                        Email (Opcional)
                    </label>
                    <input type="email" 
                           id="guest_email" 
                           name="guest_email" 
                           value="{{ old('guest_email') }}" 
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="correo@ejemplo.com">
                    @error('guest_email')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="guest_document_type" class="block text-sm font-medium text-black-400 mb-2">
                        Tipo de Documento *
                    </label>
                    <select id="guest_document_type" 
                            name="guest_document_type" 
                            required
                            class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500">
                        <option value="">Selecciona un tipo</option>
                        <option value="CC" {{ old('guest_document_type') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía (CC)</option>
                        <option value="CE" {{ old('guest_document_type') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería (CE)</option>
                        <option value="PA" {{ old('guest_document_type') == 'PA' ? 'selected' : '' }}>Pasaporte (PA)</option>
                        <option value="TI" {{ old('guest_document_type') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad (TI)</option>
                        <option value="NIT" {{ old('guest_document_type') == 'NIT' ? 'selected' : '' }}>NIT</option>
                    </select>
                    @error('guest_document_type')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="guest_document" class="block text-sm font-medium text-black-400 mb-2">
                        Número de Documento *
                    </label>
                    <input type="text" 
                           id="guest_document" 
                           name="guest_document" 
                           value="{{ old('guest_document') }}" 
                           required
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="Número de documento">
                    @error('guest_document')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="guest_city" class="block text-sm font-medium text-black-400 mb-2">
                        Ciudad de Origen *
                    </label>
                    <input type="text" 
                           id="guest_city" 
                           name="guest_city" 
                           value="{{ old('guest_city') }}" 
                           required
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="Ciudad de origen">
                    @error('guest_city')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Información de la Reserva -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Información de la Reserva</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="room_type_id" class="block text-sm font-medium text-black-400 mb-2">
                        Tipo de Habitación *
                    </label>
                    <select id="room_type_id" 
                            name="room_type_id" 
                            required
                            class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 bg-white"
                            onchange="loadAvailableRooms(); calculatePricing();">
                        <option value="">Selecciona un tipo</option>
                        @foreach($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}" {{ old('room_type_id', request('room_type_id')) == $roomType->id ? 'selected' : '' }}>
                                {{ $roomType->name }} - ${{ number_format($roomType->base_price, 0, ',', '.') }}/noche
                            </option>
                        @endforeach
                    </select>
                    @error('room_type_id')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="room_selection_container" style="display: none;">
                    <label for="room_id" class="block text-sm font-medium text-black-400 mb-2">
                        Habitación Específica (Opcional)
                    </label>
                    <select id="room_id" 
                            name="room_id" 
                            class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500">
                        <option value="">Asignar automáticamente</option>
                    </select>
                    <p class="text-xs text-black-200 mt-1">Si no seleccionas una habitación, se asignará automáticamente según disponibilidad</p>
                    @error('room_id')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Fechas -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Fechas de Estancia</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="check_in_date" class="block text-sm font-medium text-black-400 mb-2">
                        Fecha de Check-In *
                    </label>
                    <input type="text" 
                           id="check_in_date" 
                           name="check_in_date" 
                           value="{{ old('check_in_date') }}" 
                           required
                           class="reservation-datepicker w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500"
                           placeholder="Selecciona fecha de entrada"
                           readonly
                           onchange="updateCheckOutMinDate(); calculatePricing();">
                    @error('check_in_date')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="check_out_date" class="block text-sm font-medium text-black-400 mb-2">
                        Fecha de Check-Out *
                    </label>
                    <input type="text" 
                           id="check_out_date" 
                           name="check_out_date" 
                           value="{{ old('check_out_date') }}" 
                           required
                           class="reservation-datepicker w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500"
                           placeholder="Selecciona fecha de salida"
                           readonly
                           onchange="loadAvailableRooms(); calculatePricing();">
                    @error('check_out_date')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div id="nights_display" class="mt-4 text-sm text-black-400" style="display: none;">
                <span class="font-medium">Noches: </span><span id="nights_count">0</span>
            </div>
        </div>

        <!-- Huéspedes -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Número de Huéspedes</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="num_adults" class="block text-sm font-medium text-black-400 mb-2">
                        Adultos *
                    </label>
                    <input type="number" 
                           id="num_adults" 
                           name="num_adults" 
                           value="{{ old('num_adults', 1) }}" 
                           min="1" 
                           max="20"
                           required
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="1"
                           onchange="updateGuestFields(); calculatePricing();">
                    @error('num_adults')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="num_children" class="block text-sm font-medium text-black-400 mb-2">
                        Niños (Opcional)
                    </label>
                    <input type="number" 
                           id="num_children" 
                           name="num_children" 
                           value="{{ old('num_children', 0) }}" 
                           min="0" 
                           max="10"
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="0"
                           onchange="updateGuestFields(); calculatePricing();">
                    @error('num_children')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Campos dinámicos para huéspedes adicionales (adultos) -->
            <div id="additional_guests_container" class="space-y-4 mt-6">
                <!-- Los campos se generan dinámicamente con JavaScript -->
            </div>

            <!-- Campos dinámicos para niños -->
            <div id="additional_children_container" class="space-y-4 mt-6">
                <!-- Los campos se generan dinámicamente con JavaScript -->
            </div>
        </div>

        <!-- Resumen de Costos -->
        <div class="bg-primary-50 rounded-lg p-6 border-2 border-primary-200">
            <h3 class="text-sm font-semibold text-black-500 mb-4">💰 Resumen de Costos</h3>
            <div id="pricing_summary" class="space-y-2 text-sm">
                <div class="text-center py-4 text-black-300">
                    <p>Completa los campos de arriba para ver el cálculo</p>
                </div>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-medium text-black-400 mb-4">Información Adicional</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="estimated_arrival_time" class="block text-sm font-medium text-black-400 mb-2">
                        Hora Estimada de Llegada (Opcional)
                    </label>
                    <input type="text" 
                           id="estimated_arrival_time" 
                           name="estimated_arrival_time" 
                           value="{{ old('estimated_arrival_time') }}" 
                           class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                           placeholder="Ej: 3:00 PM">
                    @error('estimated_arrival_time')
                        <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="special_requests" class="block text-sm font-medium text-black-400 mb-2">
                    Solicitudes Especiales (Opcional)
                </label>
                <textarea id="special_requests" 
                          name="special_requests" 
                          rows="4"
                          class="w-full px-4 py-3 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200"
                          placeholder="Cama extra, vista al mar, cuna para bebé...">{{ old('special_requests') }}</textarea>
                @error('special_requests')
                    <p class="text-error-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

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
                               {{ old('status', 'pending') === 'pending' ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-200 border-accent-300 focus:ring-primary-200"
                               onchange="toggleRoomSelection()">
                        <span class="ml-3 text-sm text-black-500">Pendiente (requiere confirmación)</span>
                    </label>
                    <label class="flex items-center p-3 border border-accent-200 rounded-lg hover:bg-accent-100 cursor-pointer">
                        <input type="radio" 
                               name="status" 
                               value="confirmed" 
                               {{ old('status', 'pending') === 'confirmed' ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-200 border-accent-300 focus:ring-primary-200"
                               onchange="toggleRoomSelection()">
                        <span class="ml-3 text-sm text-black-500">Confirmada (requiere asignar habitación)</span>
                    </label>
                </div>
                <p class="text-xs text-black-200 mt-2">
                    Si seleccionas "Confirmada", debes asignar una habitación específica
                </p>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex items-center justify-end gap-4">
            <a href="{{ route('tenant.admin.hotel.reservations.index', $store->slug) }}" 
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
// Cargar habitaciones disponibles cuando cambian el tipo, check-in o check-out
function loadAvailableRooms() {
    const roomTypeId = document.getElementById('room_type_id').value;
    const checkInDate = document.getElementById('check_in_date').value;
    const checkOutDate = document.getElementById('check_out_date').value;
    const roomSelect = document.getElementById('room_id');
    const container = document.getElementById('room_selection_container');
    
    // Ocultar si no hay datos completos
    if (!roomTypeId || !checkInDate || !checkOutDate) {
        container.style.display = 'none';
        return;
    }
    
    // Mostrar contenedor
    container.style.display = 'block';
    
    // Verificar si status es confirmed para habilitar selección
    const status = document.querySelector('input[name="status"]:checked').value;
    if (status === 'confirmed') {
        roomSelect.disabled = false;
        roomSelect.required = true;
    } else {
        roomSelect.disabled = false;
        roomSelect.required = false;
    }
    
    // Limpiar opciones
    roomSelect.innerHTML = '<option value="">Cargando habitaciones...</option>';
    
    // Hacer petición AJAX
    fetch(`/{{ $store->slug }}/admin/hotel/reservations/api/available-rooms?room_type_id=${roomTypeId}&check_in_date=${checkInDate}&check_out_date=${checkOutDate}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        roomSelect.innerHTML = '<option value="">Asignar automáticamente</option>';
        
        if (data.success && data.rooms && data.rooms.length > 0) {
            data.rooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.id;
                option.textContent = `Habitación ${room.room_number}${room.floor ? ' - Piso ' + room.floor : ''}${room.location_notes ? ' - ' + room.location_notes : ''}`;
                roomSelect.appendChild(option);
            });
        } else {
            roomSelect.innerHTML += '<option value="" disabled>No hay habitaciones disponibles para estas fechas</option>';
        }
    })
    .catch(error => {
        console.error('Error cargando habitaciones:', error);
        roomSelect.innerHTML = '<option value="">Error al cargar habitaciones</option>';
    });
}

// Actualizar fecha mínima de check-out
function updateCheckOutMinDate() {
    const checkInDate = document.getElementById('check_in_date').value;
    const checkOutInput = document.getElementById('check_out_date');
    
    if (checkInDate) {
        // Calcular fecha mínima (check-in + 1 día)
        const checkIn = new Date(checkInDate);
        const minDate = new Date(checkIn);
        minDate.setDate(minDate.getDate() + 1);
        
        // Si hay un litepicker inicializado, actualizarlo
        if (checkOutInput._litepicker) {
            checkOutInput._litepicker.setMinDate(minDate);
        }
        
        // Recalcular noches
        calculateNights();
    }
    
    // Recargar habitaciones disponibles
    loadAvailableRooms();
}

// Calcular número de noches
function calculateNights() {
    const checkInDate = document.getElementById('check_in_date').value;
    const checkOutDate = document.getElementById('check_out_date').value;
    const display = document.getElementById('nights_display');
    const count = document.getElementById('nights_count');
    
    if (checkInDate && checkOutDate) {
        const checkIn = new Date(checkInDate);
        const checkOut = new Date(checkOutDate);
        const diffTime = Math.abs(checkOut - checkIn);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        count.textContent = diffDays + (diffDays === 1 ? ' noche' : ' noches');
        display.style.display = 'block';
    } else {
        display.style.display = 'none';
    }
}

// Toggle habilitación de selección de habitación según estado
function toggleRoomSelection() {
    const status = document.querySelector('input[name="status"]:checked').value;
    const roomSelect = document.getElementById('room_id');
    
    if (status === 'confirmed') {
        roomSelect.required = true;
        // Recargar habitaciones si hay datos
        if (document.getElementById('room_type_id').value && 
            document.getElementById('check_in_date').value && 
            document.getElementById('check_out_date').value) {
            loadAvailableRooms();
        }
    } else {
        roomSelect.required = false;
    }
}

// Actualizar campos de huéspedes adicionales (adultos)
function updateGuestFields() {
    const numAdults = parseInt(document.getElementById('num_adults').value) || 1;
    const numChildren = parseInt(document.getElementById('num_children').value) || 0;
    const adultsContainer = document.getElementById('additional_guests_container');
    const childrenContainer = document.getElementById('additional_children_container');
    
    adultsContainer.innerHTML = '';
    childrenContainer.innerHTML = '';
    
    // Si hay más de 1 adulto, mostrar campos para los adicionales (el primero ya está en la sección principal)
    if (numAdults > 1) {
        for (let i = 2; i <= numAdults; i++) {
            const guestCard = document.createElement('div');
            guestCard.className = 'bg-accent-100 rounded-lg p-4 border border-accent-200';
            guestCard.innerHTML = `
                <h4 class="text-sm font-semibold text-black-500 mb-4">Adulto ${i}</h4>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium text-black-400 mb-2">Nombre Completo *</label>
                        <input type="text" 
                               name="additional_guests[${i}][name]" 
                               required
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200 text-sm"
                               placeholder="Nombre completo">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-black-400 mb-2">Tipo de Documento *</label>
                        <select name="additional_guests[${i}][document_type]" 
                                required
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 bg-white text-sm">
                            <option value="">Selecciona</option>
                            <option value="CC">Cédula de Ciudadanía (CC)</option>
                            <option value="CE">Cédula de Extranjería (CE)</option>
                            <option value="PA">Pasaporte (PA)</option>
                            <option value="TI">Tarjeta de Identidad (TI)</option>
                            <option value="NIT">NIT</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-black-400 mb-2">Número de Documento *</label>
                        <input type="text" 
                               name="additional_guests[${i}][document]" 
                               required
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200 text-sm"
                               placeholder="Número de documento">
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium text-black-400 mb-2">Ciudad de Origen *</label>
                        <input type="text" 
                               name="additional_guests[${i}][city]" 
                               required
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200 text-sm"
                               placeholder="Ciudad de origen">
                    </div>
                </div>
            `;
            adultsContainer.appendChild(guestCard);
        }
    }
    
    // Si hay niños, mostrar campos para cada niño
    if (numChildren > 0) {
        for (let i = 1; i <= numChildren; i++) {
            const childCard = document.createElement('div');
            childCard.className = 'bg-warning-50 rounded-lg p-4 border border-warning-200';
            childCard.innerHTML = `
                <h4 class="text-sm font-semibold text-black-500 mb-4">Niño ${i}</h4>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium text-black-400 mb-2">Nombre Completo *</label>
                        <input type="text" 
                               name="additional_children[${i}][name]" 
                               required
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200 text-sm"
                               placeholder="Nombre completo">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-black-400 mb-2">Edad *</label>
                        <input type="number" 
                               name="additional_children[${i}][age]" 
                               required
                               min="0"
                               max="17"
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200 text-sm"
                               placeholder="Años"
                               onchange="calculatePricing();">
                        <p class="text-xs text-black-300 mt-1">Edad al momento de la reserva</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-black-400 mb-2">Tipo de Documento *</label>
                        <select name="additional_children[${i}][document_type]" 
                                required
                                class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 bg-white text-sm">
                            <option value="">Selecciona</option>
                            <option value="TI">Tarjeta de Identidad (TI)</option>
                            <option value="CC">Cédula de Ciudadanía (CC)</option>
                            <option value="CE">Cédula de Extranjería (CE)</option>
                            <option value="PA">Pasaporte (PA)</option>
                            <option value="RC">Registro Civil (RC)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-black-400 mb-2">Número de Documento *</label>
                        <input type="text" 
                               name="additional_children[${i}][document]" 
                               required
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200 text-sm"
                               placeholder="Número de documento">
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium text-black-400 mb-2">Ciudad de Origen *</label>
                        <input type="text" 
                               name="additional_children[${i}][city]" 
                               required
                               class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200 focus:border-primary-300 transition-colors text-black-500 placeholder-black-200 text-sm"
                               placeholder="Ciudad de origen">
                    </div>
                </div>
            `;
            childrenContainer.appendChild(childCard);
        }
    }
}

// Inicializar datepickers
(function() {
    let attempts = 0;
    const maxAttempts = 10;
    
    async function tryInit() {
        attempts++;
        
        // Inicializar datepickers usando la función global
        if (window.initializeAllDatepickers) {
            await window.initializeAllDatepickers();
        }
        
        if (attempts < maxAttempts) {
            setTimeout(tryInit, 500);
        } else {
            // Si después de varios intentos no se inicializó, forzar con litepicker directamente
            const checkInInput = document.getElementById('check_in_date');
            const checkOutInput = document.getElementById('check_out_date');
            
            if (checkInInput && !checkInInput._litepicker && window.Litepicker) {
                new Litepicker({
                    element: checkInInput,
                    format: 'YYYY-MM-DD',
                    minDate: new Date(),
                    singleMode: true,
                    onSelect: function(date) {
                        updateCheckOutMinDate();
                    }
                });
            }
            
            if (checkOutInput && !checkOutInput._litepicker && window.Litepicker) {
                new Litepicker({
                    element: checkOutInput,
                    format: 'YYYY-MM-DD',
                    minDate: new Date(Date.now() + 86400000), // Mañana
                    singleMode: true,
                    onSelect: function(date) {
                        loadAvailableRooms();
                        calculateNights();
                    }
                });
            }
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
    
    // Escuchar cambios en fechas para calcular noches
    const checkInInput = document.getElementById('check_in_date');
    const checkOutInput = document.getElementById('check_out_date');
    if (checkInInput) {
        checkInInput.addEventListener('change', calculateNights);
    }
    if (checkOutInput) {
        checkOutInput.addEventListener('change', calculateNights);
    }
    
    // Inicializar campos de huéspedes adicionales
    updateGuestFields();
})();

// Calcular precio en tiempo real
function calculatePricing() {
    const roomTypeId = document.getElementById('room_type_id').value;
    const checkInDate = document.getElementById('check_in_date').value;
    const checkOutDate = document.getElementById('check_out_date').value;
    const numAdults = parseInt(document.getElementById('num_adults').value) || 1;
    const numChildren = parseInt(document.getElementById('num_children').value) || 0;
    const summary = document.getElementById('pricing_summary');
    
    // Si no hay datos completos, mostrar mensaje
    if (!roomTypeId || !checkInDate || !checkOutDate) {
        summary.innerHTML = '<div class="text-center py-4 text-black-300"><p>Completa los campos de arriba para ver el cálculo</p></div>';
        return;
    }
    
    // Mostrar carga
    summary.innerHTML = '<div class="text-center py-4 text-black-300"><div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-primary-300"></div><p class="mt-2">Calculando...</p></div>';
    
    // Recolectar edades de niños
    const childrenAges = [];
    const childrenInputs = document.querySelectorAll('input[name^="additional_children"][name$="[age]"]');
    childrenInputs.forEach(input => {
        if (input.value) {
            childrenAges.push(parseInt(input.value) || 0);
        }
    });
    
    // Hacer petición AJAX
    fetch(`/{{ $store->slug }}/admin/hotel/reservations/api/calculate-pricing`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            room_type_id: roomTypeId,
            check_in_date: checkInDate,
            check_out_date: checkOutDate,
            num_adults: numAdults,
            num_children: numChildren,
            children_ages: childrenAges,
            selected_services: [] // Por ahora sin servicios adicionales en admin
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.pricing && data.formatted) {
            const pricing = data.pricing;
            const formatted = data.formatted;
            
            summary.innerHTML = `
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-primary-100">
                        <span class="text-black-400">Precio por noche</span>
                        <span class="font-semibold text-black-500">${formatted.base_price}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-primary-100">
                        <span class="text-black-400">${pricing.num_nights} ${pricing.num_nights === 1 ? 'noche' : 'noches'}</span>
                        <span class="font-semibold text-black-500">${formatted.base_price_total}</span>
                    </div>
                    ${pricing.children_charge > 0 ? `
                    <div class="flex justify-between items-center py-2 border-b border-primary-100">
                        <span class="text-black-400">Cargo por niños${pricing.children_discounted_count > 0 ? ` (${pricing.children_discounted_count} con descuento)` : ''}</span>
                        <span class="font-semibold text-black-500">${'$' + new Intl.NumberFormat('es-CO').format(Math.round(pricing.children_charge))}</span>
                    </div>
                    ` : ''}
                    ${pricing.children_free_count > 0 ? `
                    <div class="flex justify-between items-center py-2 border-b border-primary-100">
                        <span class="text-xs text-black-300">Niños gratis (0-2 años): ${pricing.children_free_count}</span>
                        <span class="text-xs text-success-400">Gratis</span>
                    </div>
                    ` : ''}
                    ${pricing.extra_person_charge > 0 ? `
                    <div class="flex justify-between items-center py-2 border-b border-primary-100">
                        <span class="text-black-400">Personas adicionales</span>
                        <span class="font-semibold text-black-500">${formatted.extra_person_charge}</span>
                    </div>
                    ` : ''}
                    ${pricing.services_total > 0 ? `
                    <div class="flex justify-between items-center py-2 border-b border-primary-100">
                        <span class="text-black-400">Servicios adicionales</span>
                        <span class="font-semibold text-black-500">${formatted.services_total}</span>
                    </div>
                    ` : ''}
                    ${pricing.security_deposit > 0 ? `
                    <div class="flex justify-between items-center py-2 border-b border-primary-100">
                        <span class="text-black-400">Depósito de seguridad</span>
                        <span class="font-semibold text-black-500">${formatted.security_deposit}</span>
                    </div>
                    ` : ''}
                    <div class="flex justify-between items-center py-2 border-b-2 border-primary-300">
                        <span class="text-sm font-semibold text-black-500">Subtotal</span>
                        <span class="text-lg font-bold text-primary-300">${formatted.subtotal}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 bg-primary-100 rounded-lg px-3">
                        <span class="text-sm font-semibold text-black-500">Total a pagar</span>
                        <span class="text-xl font-bold text-primary-400">${formatted.total}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 text-xs">
                        <span class="text-black-300">Anticipo requerido (${data.deposit_percentage}%)</span>
                        <span class="font-semibold text-warning-400">${formatted.deposit_amount}</span>
                    </div>
                </div>
            `;
        } else {
            summary.innerHTML = '<div class="text-center py-4 text-error-400"><p>Error al calcular el precio</p></div>';
        }
    })
    .catch(error => {
        console.error('Error calculando precio:', error);
        summary.innerHTML = '<div class="text-center py-4 text-error-400"><p>Error al calcular el precio</p></div>';
    });
}

// Validación antes de enviar
document.getElementById('hotel-reservation-form').addEventListener('submit', function(e) {
    const roomTypeId = document.getElementById('room_type_id').value;
    const checkInDate = document.getElementById('check_in_date').value;
    const checkOutDate = document.getElementById('check_out_date').value;
    const status = document.querySelector('input[name="status"]:checked').value;
    const roomId = document.getElementById('room_id').value;
    
    if (!roomTypeId || !checkInDate || !checkOutDate) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor completa todos los campos requeridos'
        });
        return false;
    }
    
    if (status === 'confirmed' && !roomId) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Para confirmar la reserva, debes seleccionar una habitación específica'
        });
        return false;
    }
    
    return true;
});
</script>
@endpush

@endsection
</x-tenant-admin-layout>

