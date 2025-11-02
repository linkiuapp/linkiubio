<x-tenant-admin-layout :store="$store">
@section('title', 'Habitaciones')

@section('content')
<div class="space-y-4">
    <div x-data="roomsManager">
    <!-- Header -->
    <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
        <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-black-500 mb-2">Inventario de Habitaciones</h2>
                    <p class="text-sm text-black-300">
                        Gestiona las habitaciones físicas de tu hotel
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('tenant.admin.hotel.room-types.index', $store->slug) }}" 
                       class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="home" class="w-5 h-5"></i>
                        Tipos
                    </a>
                    <a href="{{ route('tenant.admin.hotel.reservations.index', $store->slug) }}" 
                       class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg text-sm transition-colors flex items-center gap-2">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                        Reservas
                    </a>
                    <button @click="showCreateModal = true" class="btn-primary flex items-center gap-2">
                        <i data-lucide="circle-plus" class="w-5 h-5"></i>
                        Nueva Habitación
                    </button>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="px-6 py-3 border-b border-accent-100 bg-accent-50">
            <form method="GET" action="{{ route('tenant.admin.hotel.rooms.index', $store->slug) }}">
                <div class="flex items-center gap-4">
                    <select name="room_type_id" onchange="this.form.submit()"
                            class="px-3 py-1.5 border border-accent-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-200">
                        <option value="">Todos los tipos</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ $roomTypeId == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Lista de habitaciones -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-accent-100">
                    <tr class="text-left text-xs font-medium text-black-400 uppercase tracking-wider">
                        <th class="px-6 py-3">Número</th>
                        <th class="px-6 py-3">Tipo</th>
                        <th class="px-6 py-3">Piso</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Reservas Activas</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-accent-50 divide-y divide-accent-100">
                    @forelse($rooms as $room)
                        <tr class="text-black-400 hover:bg-accent-100">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 flex items-center justify-center bg-primary-50 rounded-lg">
                                        <i data-lucide="door-open" class="w-5 h-5 text-primary-200"></i>
                                    </div>
                                    <span class="font-semibold text-black-500">{{ $room->room_number }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="text-black-500">{{ $room->roomType->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="text-black-400">{{ $room->floor ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $room->status === 'available' ? 'bg-success-100 text-success-400' : 
                                       ($room->status === 'occupied' ? 'bg-error-100 text-error-400' : 
                                       ($room->status === 'maintenance' ? 'bg-warning-100 text-warning-400' : 
                                       'bg-black-100 text-black-300')) }}">
                                    @if($room->status === 'available')
                                        Disponible
                                    @elseif($room->status === 'occupied')
                                        Ocupada
                                    @elseif($room->status === 'maintenance')
                                        Mantenimiento
                                    @else
                                        Bloqueada
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="text-black-500">{{ $room->hotel_reservations_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <button @click="editRoom({{ $room->id }})" 
                                            class="px-3 py-1.5 bg-info-100 hover:bg-info-200 text-info-400 rounded-lg text-xs transition-colors">
                                        Editar
                                    </button>
                                    <form method="POST" action="{{ route('tenant.admin.hotel.rooms.destroy', [$store->slug, $room->id]) }}" 
                                          onsubmit="event.preventDefault(); deleteRoom(this); return false;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1.5 bg-error-100 hover:bg-error-200 text-error-400 rounded-lg text-xs transition-colors">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i data-lucide="door-open" class="w-16 h-16 text-black-200 mx-auto mb-4"></i>
                                <p class="text-black-400 mb-4">No hay habitaciones creadas aún</p>
                                <button @click="showCreateModal = true" class="btn-primary inline-flex items-center gap-2">
                                    <i data-lucide="circle-plus" class="w-5 h-5"></i>
                                    Crear Primera Habitación
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal Crear/Editar -->
        <div x-show="showCreateModal || showEditModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black-500 bg-opacity-50"
         @click.self="showCreateModal = false; showEditModal = false">
        <div class="bg-accent-50 rounded-lg p-6 max-w-md w-full mx-4 relative z-10" @click.stop>
            <h3 class="text-lg font-semibold text-black-500 mb-4" x-text="showEditModal ? 'Editar Habitación' : 'Nueva Habitación'"></h3>
            
            <form @submit.prevent="saveRoom()" class="space-y-4" @click.stop>
                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Tipo de Habitación *</label>
                    <select x-model="roomForm.room_type_id" required
                            class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200">
                        <option value="">Seleccione...</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Número de Habitación *</label>
                    <input type="text" x-model="roomForm.room_number" required
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200"
                           placeholder="Ej: 301, Penthouse A">
                </div>

                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Piso</label>
                    <input type="text" x-model="roomForm.floor"
                           class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200"
                           placeholder="Ej: 3, Planta Alta">
                </div>

                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Estado *</label>
                    <select x-model="roomForm.status" required
                            class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200">
                        <option value="available">Disponible</option>
                        <option value="occupied">Ocupada</option>
                        <option value="maintenance">Mantenimiento</option>
                        <option value="blocked">Bloqueada</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-black-400 mb-2">Notas de Ubicación</label>
                    <textarea x-model="roomForm.location_notes" rows="2"
                              class="w-full px-4 py-2 border border-accent-200 rounded-lg focus:ring-2 focus:ring-primary-200"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-accent-100">
                    <button type="button" @click="showCreateModal = false; showEditModal = false"
                            class="px-4 py-2 bg-accent-100 hover:bg-accent-200 text-black-400 rounded-lg transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-primary">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

@push('scripts')
<script>
async function deleteRoom(form) {
    const result = await Swal.fire({
        title: '¿Eliminar habitación?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ed2e45',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: '✓ Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });
    
    if (result.isConfirmed) {
        form.submit();
    }
}

document.addEventListener('alpine:init', () => {
    Alpine.data('roomsManager', () => ({
        showCreateModal: false,
        showEditModal: false,
        roomForm: {
            room_type_id: '',
            room_number: '',
            floor: '',
            status: 'available',
            location_notes: ''
        },

        async saveRoom() {
            const url = this.showEditModal 
                ? `/{{ $store->slug }}/admin/hotel/rooms/${this.roomForm.id}`
                : `/{{ $store->slug }}/admin/hotel/rooms`;
            const method = this.showEditModal ? 'PUT' : 'POST';

            // Preparar datos (excluir id si no es edición)
            const dataToSend = { ...this.roomForm };
            if (!this.showEditModal) {
                delete dataToSend.id;
            }

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(dataToSend)
                });

                const data = await response.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    // Limpiar formulario y cerrar modal
                    this.roomForm = {
                        room_type_id: '',
                        room_number: '',
                        floor: '',
                        status: 'available',
                        location_notes: ''
                    };
                    this.showCreateModal = false;
                    this.showEditModal = false;
                    setTimeout(() => location.reload(), 2000);
                } else {
                    // Mostrar errores de validación si existen
                    let errorMessage = data.message || 'Error al guardar la habitación';
                    if (data.errors) {
                        const errors = Object.values(data.errors).flat();
                        errorMessage = errors.join('\n');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar la habitación'
                });
            }
        },

        async editRoom(roomId) {
            // Cargar datos de la habitación
            try {
                const response = await fetch(`/{{ $store->slug }}/admin/hotel/rooms/${roomId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success && data.room) {
                    // Llenar el formulario con los datos de la habitación
                    this.roomForm = {
                        id: data.room.id,
                        room_type_id: data.room.room_type_id,
                        room_number: data.room.room_number,
                        floor: data.room.floor || '',
                        status: data.room.status,
                        location_notes: data.room.location_notes || ''
                    };
                    this.showEditModal = true;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la habitación'
                    });
                }
            } catch (error) {
                console.error('Error cargando habitación:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar la habitación'
                });
            }
        }
    }));
});
</script>
@endpush
@endsection
</x-tenant-admin-layout>

