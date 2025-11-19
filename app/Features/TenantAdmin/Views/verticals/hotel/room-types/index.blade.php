<x-tenant-admin-layout :store="$store">
@section('title', 'Tipos de Habitación')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
        <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-black-500 mb-2">Tipos de Habitación</h2>
                    <p class="text-sm text-black-300">
                        Gestiona los tipos de habitación disponibles en tu hotel
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('tenant.admin.hotel.reservations.index', $store->slug) }}" 
                       class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="home" class="w-5 h-5"></i>
                        Reservas
                    </a>
                    <a href="{{ route('tenant.admin.hotel.rooms.index', $store->slug) }}" 
                       class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="door-open" class="w-5 h-5"></i>
                        Habitaciones
                    </a>
                    <a href="{{ route('tenant.admin.hotel.room-types.create', $store->slug) }}" 
                       class="btn-primary flex items-center gap-2">
                        <i data-lucide="circle-plus" class="w-5 h-5"></i>
                        Nuevo Tipo
                    </a>
                </div>
            </div>
        </div>

        <!-- Lista de tipos -->
        <div class="overflow-x-auto">
            @forelse($roomTypes as $roomType)
                <div class="border-b border-accent-100 px-6 py-4 hover:bg-accent-100 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-base font-semibold text-black-500">
                                    <a href="{{ route('tenant.admin.hotel.room-types.show', ['store' => $store->slug, 'roomType' => $roomType->id]) }}" 
                                       class="hover:text-primary-300">
                                        {{ $roomType->name }}
                                    </a>
                                </h3>
                                @if($roomType->is_active)
                                    <span class="px-2 py-1 bg-success-100 text-success-400 rounded-full text-xs font-medium">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-black-100 text-black-300 rounded-full text-xs font-medium">
                                        Inactivo
                                    </span>
                                @endif
                            </div>
                            
                            @if($roomType->description)
                                <p class="text-sm text-black-300 mb-3">{{ Str::limit($roomType->description, 100) }}</p>
                            @endif
                            
                            <div class="flex flex-wrap items-center gap-4 text-sm text-black-400">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="users" class="w-4 h-4"></i>
                                    <span>Capacidad: {{ $roomType->max_occupancy }} personas</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i data-lucide="door-open" class="w-4 h-4"></i>
                                    <span>{{ $roomType->rooms_count }} habitaciones</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                    <span>{{ $roomType->hotel_reservations_count }} reservas</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                                    <span>${{ number_format($roomType->base_price_per_night, 0, ',', '.') }}/noche</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 ml-4">
                            <a href="{{ route('tenant.admin.hotel.room-types.show', ['store' => $store->slug, 'roomType' => $roomType->id]) }}" 
                               class="px-3 py-1.5 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors">
                                Ver
                            </a>
                            <a href="{{ route('tenant.admin.hotel.room-types.edit', ['store' => $store->slug, 'roomType' => $roomType->id]) }}" 
                               class="px-3 py-1.5 bg-info-100 hover:bg-info-200 text-info-400 rounded-lg text-sm transition-colors">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('tenant.admin.hotel.room-types.toggle-status', ['store' => $store->slug, 'roomType' => $roomType->id]) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="px-3 py-1.5 bg-warning-100 hover:bg-warning-200 text-warning-400 rounded-lg text-sm transition-colors">
                                    {{ $roomType->is_active ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <i data-lucide="home" class="w-16 h-16 text-black-200 mx-auto mb-4"></i>
                    <p class="text-black-400 mb-4">No hay tipos de habitación creados aún</p>
                    <a href="{{ route('tenant.admin.hotel.room-types.create', $store->slug) }}" 
                       class="btn-primary inline-flex items-center gap-2">
                        <i data-lucide="circle-plus" class="w-5 h-5"></i>
                        Crear Primer Tipo de Habitación
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
</x-tenant-admin-layout>

