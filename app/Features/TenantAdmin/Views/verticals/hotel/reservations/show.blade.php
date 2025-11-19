<x-tenant-admin-layout :store="$store">
@section('title', 'Reserva #' . $hotelReservation->reservation_code)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-accent-50 rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('tenant.admin.hotel.reservations.index', $store->slug) }}" 
                   class="text-black-400 hover:text-primary-300 transition-colors">
                    <x-solar-arrow-left-outline class="w-6 h-6" />
                </a>
                <div>
                    <h2 class="text-lg font-semibold text-black-500 mb-2">Reserva #{{ $hotelReservation->reservation_code }}</h2>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $hotelReservation->status === 'pending' ? 'bg-warning-100 text-warning-400' : 
                               ($hotelReservation->status === 'confirmed' ? 'bg-info-300 text-accent-50' : 
                               ($hotelReservation->status === 'checked_in' ? 'bg-primary-300 text-accent-50' : 
                               ($hotelReservation->status === 'checked_out' ? 'bg-success-300 text-accent-50' : 
                               'bg-error-300 text-accent-50'))) }}">
                            {{ $hotelReservation->status === 'pending' ? 'Pendiente' : 
                               ($hotelReservation->status === 'confirmed' ? 'Confirmada' : 
                               ($hotelReservation->status === 'checked_in' ? 'Check-In Realizado' : 
                               ($hotelReservation->status === 'checked_out' ? 'Check-Out Realizado' : 
                               'Cancelada'))) }}
                        </span>
                        <span class="text-xs text-black-300">
                            Creada el {{ $hotelReservation->created_at->format('d/m/Y \a \l\a\s H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Columna Principal -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Información del Huésped -->
            <div class="bg-accent-50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-black-400 mb-4">Información del Huésped</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-black-400 mb-1">Nombre Completo</label>
                        <div class="text-sm text-black-500">{{ $hotelReservation->guest_name }}</div>
                    </div>
                    <div>
                        <label class="block text-xs text-black-400 mb-1">Teléfono</label>
                        <div class="text-sm text-black-500">
                            <a href="https://wa.me/57{{ preg_replace('/\D/', '', $hotelReservation->guest_phone) }}" 
                               target="_blank" class="text-success-300 hover:text-success-400 flex items-center gap-1">
                                {{ $hotelReservation->guest_phone }}
                                <x-solar-chat-round-dots-outline class="w-4 h-4" />
                            </a>
                        </div>
                    </div>
                    @if($hotelReservation->guest_email)
                    <div>
                        <label class="block text-xs text-black-400 mb-1">Email</label>
                        <div class="text-sm text-black-500">{{ $hotelReservation->guest_email }}</div>
                    </div>
                    @endif
                    @if($hotelReservation->guest_document_type || $hotelReservation->guest_document)
                    <div>
                        <label class="block text-xs text-black-400 mb-1">Documento</label>
                        <div class="text-sm text-black-500">
                            @if($hotelReservation->guest_document_type)
                                {{ $hotelReservation->guest_document_type }}: 
                            @endif
                            {{ $hotelReservation->guest_document ?? '-' }}
                        </div>
                    </div>
                    @endif
                    @if($hotelReservation->guest_city)
                    <div>
                        <label class="block text-xs text-black-400 mb-1">Ciudad de Origen</label>
                        <div class="text-sm text-black-500">{{ $hotelReservation->guest_city }}</div>
                    </div>
                    @endif
                    @if($hotelReservation->estimated_arrival_time)
                    <div class="lg:col-span-2">
                        <label class="block text-xs text-black-400 mb-1">Hora Estimada de Llegada</label>
                        <div class="text-sm text-black-500">{{ $hotelReservation->estimated_arrival_time }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Huéspedes Adicionales -->
            @php
                $additionalGuests = [];
                $additionalChildren = [];
                if ($hotelReservation->admin_notes) {
                    $notesData = json_decode($hotelReservation->admin_notes, true);
                    if (isset($notesData['additional_guests']) && is_array($notesData['additional_guests'])) {
                        foreach ($notesData['additional_guests'] as $guest) {
                            if (isset($guest['type']) && $guest['type'] === 'child') {
                                $additionalChildren[] = $guest;
                            } else {
                                $additionalGuests[] = $guest;
                            }
                        }
                    }
                }
            @endphp
            @if(!empty($additionalGuests))
            <div class="bg-accent-50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-black-400 mb-4">Adultos Adicionales</h3>
                <div class="space-y-4">
                    @foreach($additionalGuests as $index => $guest)
                        <div class="bg-accent-100 rounded-lg p-4 border border-accent-200">
                            <h4 class="text-sm font-semibold text-black-500 mb-3">Adulto {{ $index + 2 }}</h4>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <div class="lg:col-span-2">
                                    <label class="block text-xs text-black-400 mb-1">Nombre Completo</label>
                                    <div class="text-sm text-black-500">{{ $guest['name'] ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-black-400 mb-1">Tipo de Documento</label>
                                    <div class="text-sm text-black-500">{{ $guest['document_type'] ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-black-400 mb-1">Número de Documento</label>
                                    <div class="text-sm text-black-500">{{ $guest['document'] ?? '-' }}</div>
                                </div>
                                <div class="lg:col-span-2">
                                    <label class="block text-xs text-black-400 mb-1">Ciudad de Origen</label>
                                    <div class="text-sm text-black-500">{{ $guest['city'] ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            @if(!empty($additionalChildren))
            <div class="bg-warning-50 rounded-lg p-6 border border-warning-200">
                <h3 class="text-sm font-medium text-black-400 mb-4">Niños Adicionales</h3>
                <div class="space-y-4">
                    @foreach($additionalChildren as $index => $child)
                        <div class="bg-warning-100 rounded-lg p-4 border border-warning-200">
                            <h4 class="text-sm font-semibold text-black-500 mb-3">Niño {{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <div class="lg:col-span-2">
                                    <label class="block text-xs text-black-400 mb-1">Nombre Completo</label>
                                    <div class="text-sm text-black-500">{{ $child['name'] ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-black-400 mb-1">Edad</label>
                                    <div class="text-sm text-black-500">{{ $child['age'] ?? '-' }} años</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-black-400 mb-1">Tipo de Documento</label>
                                    <div class="text-sm text-black-500">{{ $child['document_type'] ?? '-' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-black-400 mb-1">Número de Documento</label>
                                    <div class="text-sm text-black-500">{{ $child['document'] ?? '-' }}</div>
                                </div>
                                <div class="lg:col-span-2">
                                    <label class="block text-xs text-black-400 mb-1">Ciudad de Origen</label>
                                    <div class="text-sm text-black-500">{{ $child['city'] ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Información de la Reserva -->
            <div class="bg-accent-50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-black-400 mb-4">Detalles de la Reserva</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Tipo de Habitación</label>
                            <div class="text-sm text-black-500">{{ $hotelReservation->roomType->name }}</div>
                            @if($hotelReservation->roomType->description)
                                <p class="text-xs text-black-300 mt-1">{{ $hotelReservation->roomType->description }}</p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Habitación Asignada</label>
                            @if($hotelReservation->room)
                                <div class="text-sm text-black-500">
                                    Habitación #{{ $hotelReservation->room->room_number }}
                                    @if($hotelReservation->room->floor)
                                        <span class="text-black-300">(Piso {{ $hotelReservation->room->floor }})</span>
                                    @endif
                                </div>
                            @else
                                <div class="text-sm text-warning-400">Sin asignar</div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Check-In</label>
                            <div class="text-sm font-semibold text-black-500">
                                {{ $hotelReservation->check_in_date->format('d/m/Y') }}
                            </div>
                            @if($hotelReservation->checked_in_at)
                                <p class="text-xs text-black-300 mt-1">
                                    Realizado: {{ $hotelReservation->checked_in_at->format('d/m/Y H:i') }}
                                </p>
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Check-Out</label>
                            <div class="text-sm font-semibold text-black-500">
                                {{ $hotelReservation->check_out_date->format('d/m/Y') }}
                            </div>
                            @if($hotelReservation->checked_out_at)
                                <p class="text-xs text-black-300 mt-1">
                                    Realizado: {{ $hotelReservation->checked_out_at->format('d/m/Y H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Huéspedes</label>
                            <div class="text-sm text-black-500">
                                {{ $hotelReservation->num_adults }} {{ $hotelReservation->num_adults == 1 ? 'adulto' : 'adultos' }}
                                @if($hotelReservation->num_children > 0)
                                    • {{ $hotelReservation->num_children }} {{ $hotelReservation->num_children == 1 ? 'niño' : 'niños' }}
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-black-400 mb-1">Noches</label>
                            <div class="text-sm text-black-500">{{ $hotelReservation->num_nights }} {{ $hotelReservation->num_nights == 1 ? 'noche' : 'noches' }}</div>
                        </div>
                    </div>

                    @if($hotelReservation->special_requests)
                    <div>
                        <label class="block text-xs text-black-400 mb-1">Solicitudes Especiales</label>
                        <div class="text-sm text-black-500 bg-accent-100 p-3 rounded-lg">{{ $hotelReservation->special_requests }}</div>
                    </div>
                    @endif

                    @php
                        // Extraer notas administrativas (excluyendo additional_guests que ya se muestra arriba)
                        $adminNotesDisplay = null;
                        if ($hotelReservation->admin_notes) {
                            $notesData = json_decode($hotelReservation->admin_notes, true);
                            
                            if (is_array($notesData)) {
                                // Si es JSON, extraer solo las notas que no sean additional_guests
                                $notesToShow = [];
                                foreach ($notesData as $key => $value) {
                                    if ($key !== 'additional_guests') {
                                        if (is_array($value) || is_object($value)) {
                                            $notesToShow[$key] = $value;
                                        } else {
                                            $notesToShow[$key] = $value;
                                        }
                                    }
                                }
                                
                                // Si hay notas además de additional_guests
                                if (!empty($notesToShow)) {
                                    $adminNotesDisplay = json_encode($notesToShow, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                }
                            } else {
                                // Si no es JSON válido, mostrar como texto simple
                                $adminNotesDisplay = $hotelReservation->admin_notes;
                            }
                        }
                    @endphp
                    @if($adminNotesDisplay)
                    <div>
                        <label class="block text-xs text-black-400 mb-1">Notas Administrativas</label>
                        <div class="text-xs text-black-500 bg-warning-50 p-3 rounded-lg border border-warning-200">
                            <pre class="whitespace-pre-wrap font-mono text-xs">{{ $adminNotesDisplay }}</pre>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Servicios Adicionales -->
            @if($hotelReservation->selected_services && count($hotelReservation->selected_services) > 0)
            <div class="bg-accent-50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-black-400 mb-4">Servicios Adicionales</h3>
                <div class="space-y-2">
                    @foreach($hotelReservation->selected_services as $service)
                        <div class="flex items-center justify-between p-3 bg-accent-100 rounded-lg">
                            <span class="text-sm text-black-500">{{ $service['name'] ?? $service }}</span>
                            @if(isset($service['price']))
                                <span class="text-sm font-semibold text-black-500">${{ number_format($service['price'], 0, ',', '.') }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Historial de Estados -->
            <div class="bg-accent-50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-black-400 mb-4">Historial</h3>
                <div class="space-y-3">
                    <div class="flex">
                        <div class="flex-shrink-0 w-8 h-8 bg-primary-50 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="calendar" class="w-4 h-4 text-primary-200"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm text-black-500">Reserva creada</div>
                            <div class="text-xs text-black-300">
                                {{ $hotelReservation->created_at->format('d/m/Y H:i') }}
                                @if($hotelReservation->createdBy)
                                    • Por: {{ $hotelReservation->createdBy->name }}
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if($hotelReservation->confirmed_at)
                    <div class="flex">
                        <div class="flex-shrink-0 w-8 h-8 bg-info-200 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="check-circle" class="w-4 h-4 text-accent-50"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm text-black-500">Reserva confirmada</div>
                            <div class="text-xs text-black-300">{{ $hotelReservation->confirmed_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($hotelReservation->checked_in_at)
                    <div class="flex">
                        <div class="flex-shrink-0 w-8 h-8 bg-primary-300 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="log-in" class="w-4 h-4 text-accent-50"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm text-black-500">Check-in realizado</div>
                            <div class="text-xs text-black-300">{{ $hotelReservation->checked_in_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($hotelReservation->checked_out_at)
                    <div class="flex">
                        <div class="flex-shrink-0 w-8 h-8 bg-success-300 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="log-out" class="w-4 h-4 text-accent-50"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm text-black-500">Check-out realizado</div>
                            <div class="text-xs text-black-300">{{ $hotelReservation->checked_out_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($hotelReservation->cancelled_at)
                    <div class="flex">
                        <div class="flex-shrink-0 w-8 h-8 bg-error-300 rounded-full flex items-center justify-center mr-3">
                            <i data-lucide="x-circle" class="w-4 h-4 text-accent-50"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm text-black-500">Reserva cancelada</div>
                            <div class="text-xs text-black-300">{{ $hotelReservation->cancelled_at->format('d/m/Y H:i') }}</div>
                            @if($hotelReservation->cancellation_reason)
                                <div class="text-xs text-black-400 mt-1">{{ $hotelReservation->cancellation_reason }}</div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Resumen Financiero -->
            <div class="bg-accent-50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-black-400 mb-4">Resumen Financiero</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-black-400">Precio Base ({{ $hotelReservation->num_nights }} noches):</span>
                        <span class="text-black-500">${{ number_format($hotelReservation->base_price_per_night * $hotelReservation->num_nights, 0, ',', '.') }}</span>
                    </div>
                    @if($hotelReservation->extra_person_charge > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-black-400">Personas Adicionales:</span>
                        <span class="text-black-500">${{ number_format($hotelReservation->extra_person_charge, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($hotelReservation->services_total > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-black-400">Servicios:</span>
                        <span class="text-black-500">${{ number_format($hotelReservation->services_total, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="border-t border-accent-200 pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-black-500">Total:</span>
                            <span class="text-lg font-semibold text-primary-200">${{ number_format($hotelReservation->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @if($hotelReservation->security_deposit > 0)
                    <div class="pt-2 border-t border-accent-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-black-400">Depósito de Seguridad:</span>
                            <span class="text-black-500">${{ number_format($hotelReservation->security_deposit, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif
                    @if($hotelReservation->deposit_amount > 0)
                    <div class="pt-2 border-t border-accent-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-black-400">Anticipo:</span>
                            <span class="text-black-500">${{ number_format($hotelReservation->deposit_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs mt-1">
                            <span class="text-black-300">Estado del Anticipo:</span>
                            <span class="{{ $hotelReservation->deposit_paid ? 'text-success-400' : 'text-warning-400' }}">
                                {{ $hotelReservation->deposit_paid ? 'Pagado ✓' : 'Pendiente' }}
                            </span>
                        </div>
                        @if($hotelReservation->payment_proof)
                        <div class="mt-2">
                            <a href="{{ route('tenant.admin.hotel.reservations.download-payment-proof', ['store' => $store->slug, 'hotelReservation' => $hotelReservation->id]) }}" 
                               target="_blank"
                               class="text-xs text-info-300 hover:text-info-400 flex items-center gap-1">
                                <x-solar-file-outline class="w-3 h-3" />
                                Descargar comprobante
                            </a>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            <div class="bg-accent-50 rounded-lg p-6">
                <h3 class="text-sm font-medium text-black-400 mb-4">Acciones</h3>
                <div class="space-y-3">
                    @if($hotelReservation->status === 'pending')
                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.confirm', ['store' => $store->slug, 'hotelReservation' => $hotelReservation->id]) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-xs text-black-400 mb-1">Seleccionar Habitación</label>
                                <select name="room_id" required
                                        class="w-full px-3 py-2 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                                    <option value="">Seleccione una habitación</option>
                                    @php
                                        $availableRooms = \App\Shared\Models\Room::where('store_id', $store->id)
                                            ->where('room_type_id', $hotelReservation->room_type_id)
                                            ->where('status', 'available')
                                            ->get();
                                    @endphp
                                    @foreach($availableRooms as $room)
                                        <option value="{{ $room->id }}">Habitación #{{ $room->room_number }}
                                            @if($room->floor) - Piso {{ $room->floor }} @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full btn-primary text-sm">
                                Confirmar y Asignar Habitación
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.cancel', ['store' => $store->slug, 'hotelReservation' => $hotelReservation->id]) }}" 
                              onsubmit="event.preventDefault(); cancelReservation(this); return false;">
                            @csrf
                            <div class="mb-2">
                                <label class="block text-xs text-black-400 mb-1">Motivo de Cancelación</label>
                                <textarea name="cancellation_reason" rows="2"
                                          class="w-full px-3 py-2 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200"
                                          required></textarea>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-error-200 hover:bg-error-300 text-accent-50 rounded-lg text-sm transition-colors">
                                Cancelar Reserva
                            </button>
                        </form>
                    @endif

                    @if($hotelReservation->status === 'confirmed' && !$hotelReservation->checked_in_at)
                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.check-in', ['store' => $store->slug, 'hotelReservation' => $hotelReservation->id]) }}">
                            @csrf
                            <button type="submit" class="w-full btn-primary text-sm">
                                Realizar Check-In
                            </button>
                        </form>
                        
                        @if($hotelReservation->deposit_amount > 0 && !$hotelReservation->deposit_paid)
                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.mark-deposit-paid', ['store' => $store->slug, 'hotelReservation' => $hotelReservation->id]) }}" 
                              onsubmit="event.preventDefault(); markDepositPaid(this, {{ $hotelReservation->deposit_amount }}); return false;">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-success-200 hover:bg-success-300 text-accent-50 rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Marcar Anticipo como Pagado
                            </button>
                        </form>
                        @endif
                        
                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.cancel', ['store' => $store->slug, 'hotelReservation' => $hotelReservation->id]) }}" 
                              onsubmit="event.preventDefault(); cancelReservation(this); return false;">
                            @csrf
                            <div class="mb-2">
                                <label class="block text-xs text-black-400 mb-1">Motivo de Cancelación</label>
                                <textarea name="cancellation_reason" rows="2"
                                          class="w-full px-3 py-2 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200"
                                          required></textarea>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-error-200 hover:bg-error-300 text-accent-50 rounded-lg text-sm transition-colors">
                                Cancelar Reserva
                            </button>
                        </form>
                    @endif

                    @if($hotelReservation->status === 'checked_in' && !$hotelReservation->checked_out_at)
                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.check-out', ['store' => $store->slug, 'hotelReservation' => $hotelReservation->id]) }}">
                            @csrf
                            <button type="submit" class="w-full btn-primary text-sm">
                                Realizar Check-Out
                            </button>
                        </form>
                        
                        @if($hotelReservation->deposit_amount > 0 && !$hotelReservation->deposit_paid)
                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.mark-deposit-paid', ['store' => $store->slug, 'hotelReservation' => $hotelReservation->id]) }}" 
                              onsubmit="event.preventDefault(); markDepositPaid(this, {{ $hotelReservation->deposit_amount }}); return false;">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-success-200 hover:bg-success-300 text-accent-50 rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Marcar Anticipo como Pagado
                            </button>
                        </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
async function cancelReservation(form) {
    const cancellationReason = form.querySelector('textarea[name="cancellation_reason"]')?.value?.trim();
    
    if (!cancellationReason) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor ingresa un motivo de cancelación',
            confirmButtonColor: '#ed2e45'
        });
        return;
    }
    
    const result = await Swal.fire({
        title: '¿Cancelar reserva?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ed2e45',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: '✓ Sí, cancelar',
        cancelButtonText: 'Cancelar'
    });
    
    if (result.isConfirmed) {
        form.submit();
    }
}

async function markDepositPaid(form, amount) {
    const formattedAmount = '$' + amount.toLocaleString('es-CO');
    
    const result = await Swal.fire({
        title: '¿Marcar anticipo como pagado?',
        html: `Se marcará el anticipo de <strong>${formattedAmount}</strong> como pagado`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#00c76f',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: '✓ Sí, marcar',
        cancelButtonText: 'Cancelar'
    });
    
    if (result.isConfirmed) {
        form.submit();
    }
}
</script>
@endpush
@endsection
</x-tenant-admin-layout>

