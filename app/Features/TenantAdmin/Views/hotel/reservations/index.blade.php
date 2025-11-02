<x-tenant-admin-layout :store="$store">
@section('title', 'Reservas de Hotel')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
        <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-black-500 mb-2">Gestión de Reservas de Hotel</h2>
                    <p class="text-sm text-black-300">
                        Administra todas las reservas de habitaciones
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('tenant.admin.hotel.room-types.index', $store->slug) }}" 
                       class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="home" class="w-5 h-5"></i>
                        Tipos
                    </a>
                    <a href="{{ route('tenant.admin.hotel.rooms.index', $store->slug) }}" 
                       class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="door-open" class="w-5 h-5"></i>
                        Habitaciones
                    </a>
                    <a href="{{ route('tenant.admin.hotel.settings', $store->slug) }}" 
                       class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        Configuración
                    </a>
                    <a href="{{ route('tenant.admin.hotel.reservations.create', $store->slug) }}" 
                       class="btn-primary flex items-center gap-2">
                        <i data-lucide="circle-plus" class="w-5 h-5"></i>
                        Nueva Reserva
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
                    <div class="text-h6 font-bold text-black-500">{{ $stats['checked_in'] }}</div>
                    <div class="text-caption text-black-500">Check-In</div>
                </div>
                <div class="text-center p-3 bg-gradient-to-r from-error-100 to-accent-50 rounded-lg">
                    <div class="text-h6 font-bold text-error-300">{{ $stats['cancelled'] }}</div>
                    <div class="text-caption text-error-300">Canceladas</div>
                </div>
            </div>
        </div>

        <!-- Barra de herramientas y filtros -->
        <div class="px-6 py-3 border-b border-accent-100 bg-accent-50">
            <form method="GET" action="{{ route('tenant.admin.hotel.reservations.index', $store->slug) }}">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-4">
                        <!-- Filtros rápidos -->
                        <select name="filter" class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                            <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Todas</option>
                            <option value="pending" {{ $filter === 'pending' ? 'selected' : '' }}>Pendientes</option>
                            <option value="confirmed" {{ $filter === 'confirmed' ? 'selected' : '' }}>Confirmadas</option>
                            <option value="checked_in" {{ $filter === 'checked_in' ? 'selected' : '' }}>Check-In</option>
                            <option value="today_checkin" {{ $filter === 'today_checkin' ? 'selected' : '' }}>Check-In Hoy</option>
                            <option value="today_checkout" {{ $filter === 'today_checkout' ? 'selected' : '' }}>Check-Out Hoy</option>
                            <option value="upcoming" {{ $filter === 'upcoming' ? 'selected' : '' }}>Próximas</option>
                            <option value="cancelled" {{ $filter === 'cancelled' ? 'selected' : '' }}>Canceladas</option>
                        </select>

                        @if($roomTypes->count() > 0)
                        <select name="room_type_id" class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                            <option value="">Todos los tipos</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}" {{ $roomTypeId == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @endif

                        <input type="date" name="date" value="{{ $date }}" 
                               class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">

                        <button type="submit" class="px-3 py-1.5 bg-primary-200 text-accent-50 rounded-lg text-sm hover:bg-primary-300 transition-colors">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </button>

                        <a href="{{ route('tenant.admin.hotel.reservations.index', $store->slug) }}" class="px-3 py-1.5 bg-accent-100 text-black-300 rounded-lg text-sm hover:bg-accent-200 transition-colors">
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
                        <th class="px-6 py-3">Código</th>
                        <th class="px-6 py-3">Huésped</th>
                        <th class="px-6 py-3">Habitación</th>
                        <th class="px-6 py-3">Fechas</th>
                        <th class="px-6 py-3">Huéspedes</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Estado</th>
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
                                        <a href="{{ route('tenant.admin.hotel.reservations.show', [$store->slug, $reservation->id]) }}" 
                                           class="font-semibold text-info-300 underline">{{ $reservation->reservation_code }}</a>
                                        <p class="text-caption text-black-200">
                                            {{ $reservation->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    <p class="font-semibold text-black-500">{{ $reservation->guest_name }}</p>
                                    <p class="text-xs text-black-200">{{ $reservation->guest_phone }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    <p class="text-black-500">{{ $reservation->roomType->name }}</p>
                                    @if($reservation->room)
                                        <p class="text-xs text-black-200">Habitación #{{ $reservation->room->room_number }}</p>
                                    @else
                                        <p class="text-xs text-warning-400">Sin asignar</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    <p class="text-black-500">
                                        <i data-lucide="log-in" class="w-4 h-4 inline mr-1"></i>
                                        {{ $reservation->check_in_date->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-black-200">
                                        <i data-lucide="log-out" class="w-4 h-4 inline mr-1"></i>
                                        {{ $reservation->check_out_date->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs text-black-300 mt-1">
                                        {{ $reservation->num_nights }} {{ $reservation->num_nights == 1 ? 'noche' : 'noches' }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div>
                                    <p class="text-black-500">{{ $reservation->num_adults }} adultos</p>
                                    @if($reservation->num_children > 0)
                                        <p class="text-xs text-black-200">{{ $reservation->num_children }} niños</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <p class="font-semibold text-black-500">${{ number_format($reservation->total, 0, ',', '.') }}</p>
                                @if($reservation->deposit_amount > 0)
                                    <p class="text-xs text-black-300">
                                        Anticipo: ${{ number_format($reservation->deposit_amount, 0, ',', '.') }}
                                        @if($reservation->deposit_paid)
                                            <span class="text-success-400">✓</span>
                                        @else
                                            <span class="text-warning-400">Pendiente</span>
                                        @endif
                                    </p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $reservation->status === 'pending' ? 'bg-warning-100 text-warning-400' : 
                                       ($reservation->status === 'confirmed' ? 'bg-info-300 text-accent-50' : 
                                       ($reservation->status === 'checked_in' ? 'bg-primary-300 text-accent-50' : 
                                       ($reservation->status === 'checked_out' ? 'bg-success-300 text-accent-50' : 
                                       'bg-error-300 text-accent-50'))) }}">
                                    @if($reservation->status === 'pending')
                                        Pendiente
                                    @elseif($reservation->status === 'confirmed')
                                        Confirmada
                                    @elseif($reservation->status === 'checked_in')
                                        Check-In
                                    @elseif($reservation->status === 'checked_out')
                                        Check-Out
                                    @else
                                        Cancelada
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('tenant.admin.hotel.reservations.show', [$store->slug, $reservation->id]) }}" 
                                       class="px-3 py-1.5 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-xs transition-colors">
                                        Ver
                                    </a>
                                    
                                    @if($reservation->status === 'pending')
                                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.confirm', [$store->slug, $reservation->id]) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-3 py-1.5 bg-info-100 hover:bg-info-200 text-info-400 rounded-lg text-xs transition-colors">
                                                Confirmar
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($reservation->status === 'confirmed')
                                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.check-in', [$store->slug, $reservation->id]) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-3 py-1.5 bg-primary-100 hover:bg-primary-200 text-primary-400 rounded-lg text-xs transition-colors">
                                                Check-In
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($reservation->status === 'checked_in')
                                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.check-out', [$store->slug, $reservation->id]) }}" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-3 py-1.5 bg-success-100 hover:bg-success-200 text-success-400 rounded-lg text-xs transition-colors">
                                                Check-Out
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($reservation->deposit_amount > 0 && !$reservation->deposit_paid && in_array($reservation->status, ['pending', 'confirmed', 'checked_in']))
                                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.mark-deposit-paid', [$store->slug, $reservation->id]) }}" 
                                              onsubmit="return confirm('¿Marcar anticipo de ${{ number_format($reservation->deposit_amount, 0, ',', '.') }} como pagado?')" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    title="Marcar anticipo como pagado"
                                                    class="px-3 py-1.5 bg-success-100 hover:bg-success-200 text-success-400 rounded-lg text-xs transition-colors flex items-center gap-1">
                                                <i data-lucide="dollar-sign" class="w-3 h-3"></i>
                                                Pagar Anticipo
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array($reservation->status, ['pending', 'confirmed']))
                                        <form method="POST" action="{{ route('tenant.admin.hotel.reservations.cancel', [$store->slug, $reservation->id]) }}" 
                                              onsubmit="return confirm('¿Cancelar esta reserva?')" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-3 py-1.5 bg-error-100 hover:bg-error-200 text-error-400 rounded-lg text-xs transition-colors">
                                                Cancelar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <i data-lucide="calendar-x" class="w-16 h-16 text-black-200 mx-auto mb-4"></i>
                                <p class="text-black-400 mb-4">No hay reservas registradas</p>
                                <a href="{{ route('tenant.admin.hotel.reservations.create', $store->slug) }}" 
                                   class="btn-primary inline-flex items-center gap-2">
                                    <i data-lucide="circle-plus" class="w-5 h-5"></i>
                                    Crear Primera Reserva
                                </a>
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
@endsection
</x-tenant-admin-layout>

