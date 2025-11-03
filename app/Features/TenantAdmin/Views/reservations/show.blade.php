<x-tenant-admin-layout :store="$store">
@section('title', 'Detalles de Reservación')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('tenant.admin.reservations.index', $store->slug) }}" 
               class="text-black-300 hover:text-black-400">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-lg font-semibold text-black-500">Reservación {{ $reservation->reference_code }}</h1>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Información Principal -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <h2 class="text-body-large font-bold text-black-400 mb-0">Información de la Reservación</h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-black-300 mb-1">Estado</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            {{ $reservation->status === 'pending' ? 'bg-warning-100 text-warning-400' : 
                               ($reservation->status === 'confirmed' ? 'bg-info-300 text-accent-50' : 
                               ($reservation->status === 'completed' ? 'bg-success-300 text-accent-50' : 
                               'bg-error-300 text-accent-50')) }}">
                            @if($reservation->status === 'pending')
                                Pendiente
                            @elseif($reservation->status === 'confirmed')
                                Confirmada
                            @elseif($reservation->status === 'completed')
                                Completada
                            @else
                                Cancelada
                            @endif
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-black-300 mb-1">Código de Referencia</label>
                        <p class="text-sm font-mono text-black-500">{{ $reservation->reference_code }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-black-300 mb-1">Cliente</label>
                        <p class="text-sm text-black-500">{{ $reservation->customer_name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-black-300 mb-1">Teléfono</label>
                        <p class="text-sm text-black-500">{{ $reservation->customer_phone }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-black-300 mb-1">Fecha</label>
                        @php
                            // Obtener valores directamente de la base de datos sin casts
                            $dateRaw = $reservation->getRawReservationDate();
                            
                            // Parsear fecha: MySQL DATE devuelve string 'YYYY-MM-DD'
                            // Usar createFromFormat para evitar problemas de zona horaria
                            if (!empty($dateRaw)) {
                                $dateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $dateRaw);
                                $dateFormatted = $dateObj->format('d/m/Y');
                            } else {
                                $dateFormatted = '-';
                            }
                        @endphp
                        <p class="text-sm text-black-500">{{ $dateFormatted }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-black-300 mb-1">Hora</label>
                        @php
                            // Obtener valores directamente de la base de datos sin casts
                            $timeRaw = $reservation->getRawReservationTime();
                            // TIME ya viene formateado de getRawReservationTime() como HH:mm
                            $timeFormatted = $timeRaw ?: '-';
                        @endphp
                        <p class="text-sm text-black-500">{{ $timeFormatted }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-black-300 mb-1">Número de Personas</label>
                        <p class="text-sm text-black-500">{{ $reservation->party_size }} {{ $reservation->party_size == 1 ? 'persona' : 'personas' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-black-300 mb-1">Mesa Asignada</label>
                        @if($reservation->table)
                            <p class="text-sm text-black-500">Mesa {{ $reservation->table->table_number }} ({{ $reservation->table->capacity }} personas)</p>
                        @else
                            <p class="text-sm text-black-300">Sin asignar</p>
                        @endif
                    </div>
                    
                    @if($reservation->deposit_amount)
                        <div>
                            <label class="block text-sm font-semibold text-black-300 mb-1">Anticipo</label>
                            <p class="text-sm text-black-500">${{ number_format($reservation->deposit_amount, 0, ',', '.') }}</p>
                            <p class="text-xs text-black-300">
                                Estado: <span class="{{ $reservation->deposit_paid ? 'text-success-300' : 'text-warning-400' }}">
                                    {{ $reservation->deposit_paid ? 'Pagado' : 'Pendiente' }}
                                </span>
                            </p>
                        </div>
                        
                        @if($reservation->payment_proof)
                            <div>
                                <label class="block text-sm font-semibold text-black-300 mb-1">Comprobante</label>
                                <a href="{{ Storage::url($reservation->payment_proof) }}" 
                                   target="_blank"
                                   class="text-sm text-primary-200 hover:text-primary-300 underline">
                                    Ver comprobante
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
                
                @if($reservation->notes)
                    <div class="mt-6 pt-6 border-t border-accent-100">
                        <label class="block text-sm font-semibold text-black-300 mb-2">Notas Especiales</label>
                        <p class="text-sm text-black-400 bg-accent-100 rounded-lg p-3">{{ $reservation->notes }}</p>
                    </div>
                @endif
                
                @if($reservation->cancellation_reason)
                    <div class="mt-6 pt-6 border-t border-accent-100">
                        <label class="block text-sm font-semibold text-black-300 mb-2">Razón de Cancelación</label>
                        <p class="text-sm text-error-400 bg-error-50 rounded-lg p-3">{{ $reservation->cancellation_reason }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Acciones -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h3 class="text-sm font-semibold text-black-400 mb-4">Acciones</h3>
            <div class="flex flex-wrap gap-3">
                @if($reservation->status === 'pending')
                    <button onclick="confirmReservation()" 
                            class="px-4 py-2 bg-success-300 hover:bg-success-200 text-accent-50 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Confirmar Reserva
                    </button>
                @endif
                
                @if($reservation->status === 'confirmed')
                    <button onclick="completeReservation()" 
                            class="px-4 py-2 bg-primary-200 hover:bg-primary-300 text-accent-50 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="check-square" class="w-5 h-5"></i>
                        Marcar como Completada
                    </button>
                @endif
                
                @if(!in_array($reservation->status, ['completed', 'cancelled']))
                    <button onclick="cancelReservation()" 
                            class="px-4 py-2 bg-error-300 hover:bg-error-200 text-accent-50 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                        Cancelar Reserva
                    </button>
                @endif
                
                <a href="https://wa.me/57{{ str_replace(['+', ' ', '-'], '', $reservation->customer_phone) }}" 
                   target="_blank"
                   class="px-4 py-2 bg-success-300 hover:bg-success-200 text-accent-50 rounded-lg text-sm transition-colors flex items-center gap-2">
                    <i data-lucide="phone" class="w-5 h-5"></i>
                    Contactar por WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmReservation() {
    Swal.fire({
        title: '¿Confirmar reservación?',
        text: 'Se enviará una notificación de confirmación al cliente',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#22c55e'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("tenant.admin.reservations.confirm", [$store->slug, $reservation->id]) }}';
            form.innerHTML = `@csrf`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function completeReservation() {
    Swal.fire({
        title: '¿Marcar como completada?',
        text: 'La reservación será marcada como completada',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, completar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#3b82f6'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("tenant.admin.reservations.complete", [$store->slug, $reservation->id]) }}';
            form.innerHTML = `@csrf`;
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function cancelReservation() {
    Swal.fire({
        title: '¿Cancelar reservación?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'No',
        confirmButtonColor: '#ef4444',
        input: 'text',
        inputPlaceholder: 'Razón de cancelación (opcional)'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("tenant.admin.reservations.cancel", [$store->slug, $reservation->id]) }}';
            form.innerHTML = `@csrf
                <input type="hidden" name="reason" value="${result.value || 'Cancelada por el administrador'}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
@endsection
</x-tenant-admin-layout>

