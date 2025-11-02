<x-tenant-admin-layout :store="$store">
@section('title', 'Reservaciones')

@section('content')
<div x-data="reservationsManager" class="space-y-4">
    
    <!-- Header con estadísticas -->
    <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
        <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-black-500 mb-2">Gestión de Reservaciones</h2>
                    <p class="text-sm text-black-300">
                        Administra todas las reservas de mesas
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('tenant.admin.reservations.create', $store->slug) }}" 
                       class="btn-primary flex items-center gap-2">
                        <i data-lucide="circle-plus" class="w-5 h-5"></i>
                        Nueva Reserva
                    </a>
                    <a href="{{ route('tenant.admin.reservations.settings', $store->slug) }}" 
                       class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        Configuración
                    </a>
                </div>
            </div>
        </div>

        <!-- Estadísticas Grid -->
        <div class="px-6 py-3 border-b border-accent-100 bg-accent-50">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                <div class="text-center p-3 bg-gradient-to-r from-accent-400 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-black-500">{{ $stats['total'] }}</div>
                    <div class="text-caption text-black-300">Total</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-warning-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-black-500">{{ $stats['pending'] }}</div>
                    <div class="text-caption text-black-500">Pendientes</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-info-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-info-200">{{ $stats['confirmed'] }}</div>
                    <div class="text-caption text-info-200">Confirmadas</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-success-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-black-500">{{ $stats['completed'] }}</div>
                    <div class="text-caption text-black-500">Completadas</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-error-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-error-300">{{ $stats['cancelled'] }}</div>
                    <div class="text-caption text-error-300">Canceladas</div>
                </div>
            </div>
        </div>

        <!-- Barra de herramientas y filtros -->
        <div class="px-6 py-3 border-b border-accent-100 bg-accent-50">
            <form method="GET" action="{{ route('tenant.admin.reservations.index', $store->slug) }}">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-4">
                        <!-- Filtros rápidos -->
                        <select name="filter" class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Todas</option>
                            <option value="pending" {{ $filter === 'pending' ? 'selected' : '' }}>Pendientes</option>
                            <option value="confirmed" {{ $filter === 'confirmed' ? 'selected' : '' }}>Confirmadas</option>
                            <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>Hoy</option>
                            <option value="tomorrow" {{ $filter === 'tomorrow' ? 'selected' : '' }}>Mañana</option>
                            <option value="completed" {{ $filter === 'completed' ? 'selected' : '' }}>Completadas</option>
                            <option value="cancelled" {{ $filter === 'cancelled' ? 'selected' : '' }}>Canceladas</option>
                        </select>

                        <input type="text" name="date" value="{{ $date }}" 
                               class="reservation-datepicker px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">

                        <button type="submit" class="px-3 py-1.5 bg-primary-200 text-accent-50 rounded-lg text-sm hover:bg-primary-300 transition-colors">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </button>

                        <a href="{{ route('tenant.admin.reservations.index', $store->slug) }}" class="px-3 py-1.5 bg-accent-100 text-black-300 rounded-lg text-sm hover:bg-accent-200 transition-colors">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-black-300">{{ $reservations->total() }} reservas</span>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla de Reservaciones -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-accent-100">
                    <tr class="text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                        <th class="px-6 py-3">Referencia</th>
                        <th class="px-6 py-3">Cliente</th>
                        <th class="px-6 py-3">Fecha / Hora</th>
                        <th class="px-6 py-3">Personas</th>
                        <th class="px-6 py-3">Mesa</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Anticipo</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-accent-50 divide-y divide-accent-100">
                    @forelse($reservations as $reservation)
                        <tr class="text-black-400 hover:bg-accent-100">
                            <td class="px-6 py-4">
                                <div class="flex items-center text-sm">
                                    <div class="w-10 h-10 mr-3 flex items-center justify-center bg-primary-50 rounded-lg">
                                        <i data-lucide="calendar" class="w-5 h-5 text-primary-200"></i>
                                    </div>
                                    <div>
                                        <a href="{{ route('tenant.admin.reservations.show', [$store->slug, $reservation->id]) }}" 
                                           class="font-semibold text-info-300 underline">{{ $reservation->reference_code }}</a>
                                        <p class="text-caption text-black-200">
                                            {{ $reservation->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    <p class="font-semibold text-black-500">{{ $reservation->customer_name }}</p>
                                    <p class="text-xs text-black-200">{{ $reservation->customer_phone }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    @php
                                        // Obtener valores directamente de la base de datos sin casts
                                        $dateRaw = $reservation->getRawReservationDate();
                                        $timeRaw = $reservation->getRawReservationTime();
                                        
                                        // Parsear fecha: MySQL DATE devuelve string 'YYYY-MM-DD'
                                        // Usar createFromFormat para evitar problemas de zona horaria
                                        if (!empty($dateRaw)) {
                                            $dateObj = \Carbon\Carbon::createFromFormat('Y-m-d', $dateRaw);
                                            $dateFormatted = $dateObj->format('d/m/Y');
                                        } else {
                                            $dateFormatted = '-';
                                        }
                                        
                                        // TIME ya viene formateado de getRawReservationTime() como HH:mm
                                        $timeFormatted = $timeRaw ?: '-';
                                    @endphp
                                    <p class="text-black-500">{{ $dateFormatted }}</p>
                                    <p class="text-xs text-black-200">{{ $timeFormatted }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <p class="text-black-500">{{ $reservation->party_size }} {{ $reservation->party_size == 1 ? 'persona' : 'personas' }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($reservation->table)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-info-100 text-info-400">
                                        Mesa {{ $reservation->table->table_number }}
                                    </span>
                                @else
                                    <span class="text-xs text-black-200">Sin asignar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
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
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($reservation->deposit_amount)
                                    <div>
                                        <p class="text-black-500">${{ number_format($reservation->deposit_amount, 0, ',', '.') }}</p>
                                        @if($reservation->deposit_paid)
                                            <span class="text-xs text-success-300">✓ Pagado</span>
                                        @else
                                            <span class="text-xs text-warning-400">Pendiente</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-black-200">N/A</span>
                                @endif
                            </td>
                            <td class="py-4">
                                <div class="flex items-center justify-center gap-4">
                                    <!-- Ver -->
                                    <a href="{{ route('tenant.admin.reservations.show', [$store->slug, $reservation->id]) }}" 
                                       class="text-info-200 hover:text-info-300" title="Ver">
                                        <i data-lucide="eye" class="w-5 h-5"></i>
                                    </a>

                                    <!-- Confirmar -->
                                    @if($reservation->status === 'pending')
                                        <button @click="confirmReservationFromIndex({{ $reservation->id }}, '{{ $reservation->reference_code }}')" 
                                                class="text-success-300 hover:text-success-400" 
                                                title="Confirmar">
                                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                                        </button>
                                    @endif

                                    <!-- Completar -->
                                    @if($reservation->status === 'confirmed')
                                        <button @click="completeReservationFromIndex({{ $reservation->id }}, '{{ $reservation->reference_code }}')" 
                                                class="text-primary-200 hover:text-primary-300" 
                                                title="Marcar como completada">
                                            <i data-lucide="check-square" class="w-5 h-5"></i>
                                        </button>
                                    @endif

                                    <!-- Cancelar -->
                                    @if(!in_array($reservation->status, ['completed', 'cancelled']))
                                        <button @click="cancelReservation({{ $reservation->id }}, '{{ $reservation->reference_code }}')" 
                                                class="text-error-300 hover:text-error-400" 
                                                title="Cancelar">
                                            <i data-lucide="x-circle" class="w-5 h-5"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center">
                                <div class="text-black-300">
                                    <i data-lucide="calendar" class="w-12 h-12 mx-auto mb-2 text-black-200"></i>
                                    <p class="text-sm">No hay reservaciones</p>
                                    <a href="{{ route('tenant.admin.reservations.create', $store->slug) }}" 
                                       class="text-primary-200 hover:text-primary-300 text-sm mt-2 inline-block">
                                        Crear primera reserva
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($reservations->hasPages())
            <div class="px-6 py-4 border-t border-accent-100">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('reservationsManager', () => ({
        confirmReservationFromIndex(reservationId, referenceCode) {
            Swal.fire({
                title: '¿Confirmar reservación?',
                text: `Se confirmará la reservación ${referenceCode} y se enviará una notificación al cliente`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, confirmar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#22c55e'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('/') }}/{{ $store->slug }}/admin/reservations/${reservationId}/confirm`;
                    form.innerHTML = `@csrf`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        },
        
        completeReservationFromIndex(reservationId, referenceCode) {
            Swal.fire({
                title: '¿Marcar como completada?',
                text: `La reservación ${referenceCode} será marcada como completada`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, completar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3b82f6'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('/') }}/{{ $store->slug }}/admin/reservations/${reservationId}/complete`;
                    form.innerHTML = `@csrf`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        },
        
        cancelReservation(reservationId, referenceCode) {
            Swal.fire({
                title: '¿Cancelar reservación?',
                text: `Estás a punto de cancelar la reservación ${referenceCode}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No, mantener',
                confirmButtonColor: '#ef4444',
                input: 'text',
                inputPlaceholder: 'Razón de cancelación (opcional)'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('/') }}/{{ $store->slug }}/admin/reservations/${reservationId}/cancel`;
                    form.innerHTML = `@csrf
                        <input type="hidden" name="reason" value="${result.value || 'Cancelada por el administrador'}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    }));
});
</script>
@endpush
@endsection
</x-tenant-admin-layout>

