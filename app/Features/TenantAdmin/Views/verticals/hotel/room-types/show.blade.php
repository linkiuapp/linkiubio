<x-tenant-admin-layout :store="$store">
@section('title', 'Detalles Tipo de Habitación')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-accent-50 rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('tenant.admin.hotel.room-types.index', $store->slug) }}" 
                   class="text-black-400 hover:text-primary-300 transition-colors">
                    <x-solar-arrow-left-outline class="w-6 h-6" />
                </a>
                <div>
                    <h2 class="text-lg font-semibold text-black-500 mb-2">{{ $roomType->name }}</h2>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roomType->is_active ? 'bg-success-200 text-black-300' : 'bg-error-200 text-accent-50' }}">
                            {{ $roomType->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('tenant.admin.hotel.room-types.edit', ['store' => $store->slug, 'roomType' => $roomType->id]) }}" 
                   class="btn-primary flex items-center gap-2">
                    <x-solar-pen-outline class="w-4 h-4" />
                    Editar
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información Básica -->
            <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
                <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                    <h3 class="text-lg font-semibold text-black-500">Información Básica</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-black-400 mb-1">Nombre</label>
                        <p class="text-sm text-black-500">{{ $roomType->name }}</p>
                    </div>
                    
                    @if($roomType->description)
                    <div>
                        <label class="block text-sm font-medium text-black-400 mb-1">Descripción</label>
                        <p class="text-sm text-black-500">{{ $roomType->description }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-black-400 mb-1">Capacidad Máxima</label>
                            <p class="text-sm text-black-500">{{ $roomType->max_occupancy }} personas</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-black-400 mb-1">Personas Incluidas (Base)</label>
                            <p class="text-sm text-black-500">{{ $roomType->base_occupancy }} personas</p>
                        </div>
                    </div>

                    @if($roomType->max_adults || $roomType->max_children)
                    <div class="grid grid-cols-2 gap-4">
                        @if($roomType->max_adults)
                        <div>
                            <label class="block text-sm font-medium text-black-400 mb-1">Máximo Adultos</label>
                            <p class="text-sm text-black-500">{{ $roomType->max_adults }}</p>
                        </div>
                        @endif
                        @if($roomType->max_children)
                        <div>
                            <label class="block text-sm font-medium text-black-400 mb-1">Máximo Niños</label>
                            <p class="text-sm text-black-500">{{ $roomType->max_children }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Precios -->
            <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
                <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                    <h3 class="text-lg font-semibold text-black-500">Precios</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-black-400 mb-1">Precio Base por Noche</label>
                            <p class="text-lg font-semibold text-primary-300">${{ number_format($roomType->base_price_per_night, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-black-400 mb-1">Precio por Persona Adicional</label>
                            <p class="text-sm text-black-500">${{ number_format($roomType->extra_person_price, 0, ',', '.') }} por noche</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Habitaciones -->
            @if($roomType->rooms && $roomType->rooms->count() > 0)
            <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
                <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                    <h3 class="text-lg font-semibold text-black-500">Habitaciones de este Tipo ({{ $roomType->rooms->count() }})</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($roomType->rooms as $room)
                        <div class="bg-accent-100 rounded-lg p-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-black-500">Habitación #{{ $room->room_number }}</p>
                                @if($room->floor)
                                <p class="text-xs text-black-300">Piso: {{ $room->floor }}</p>
                                @endif
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                {{ $room->status->value === 'available' ? 'bg-success-200 text-black-300' : '' }}
                                {{ $room->status->value === 'occupied' ? 'bg-warning-200 text-black-500' : '' }}
                                {{ $room->status->value === 'maintenance' ? 'bg-info-200 text-black-300' : '' }}
                                {{ $room->status->value === 'blocked' ? 'bg-error-200 text-accent-50' : '' }}">
                                {{ $room->status->label() }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Estadísticas -->
            <div class="bg-accent-50 rounded-lg p-6">
                <h3 class="text-base font-semibold text-black-500 mb-4">Estadísticas</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-black-400">Total Habitaciones:</span>
                        <span class="text-sm font-medium text-black-500">{{ $roomType->rooms_count ?? $roomType->rooms->count() ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-black-400">Reservas Totales:</span>
                        <span class="text-sm font-medium text-black-500">{{ $roomType->hotel_reservations_count ?? $roomType->hotelReservations->count() ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-black-400">Orden:</span>
                        <span class="text-sm font-medium text-black-500">{{ $roomType->sort_order }}</span>
                    </div>
                </div>
            </div>

            <!-- Reservas Recientes -->
            @if($roomType->hotelReservations && $roomType->hotelReservations->count() > 0)
            <div class="bg-accent-50 rounded-lg p-6">
                <h3 class="text-base font-semibold text-black-500 mb-4">Reservas Recientes</h3>
                <div class="space-y-2">
                    @foreach($roomType->hotelReservations->take(5) as $reservation)
                    <div class="bg-accent-100 rounded-lg p-3">
                        <p class="text-xs font-medium text-black-500">{{ $reservation->reservation_code }}</p>
                        <p class="text-xs text-black-300">{{ $reservation->check_in_date->format('d/m/Y') }} - {{ $reservation->check_out_date->format('d/m/Y') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
</x-tenant-admin-layout>

