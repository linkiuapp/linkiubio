<x-tenant-admin-layout :store="$store">

@section('title', 'Detalles de Sede')

@section('content')
<div class="max-w-6xl mx-auto space-y-5" x-data="locationShow()">
    {{-- Sistema de notificaciones flotantes --}}
    @include('tenant-admin::core.locations.components.notifications')

    {{-- Alertas de sesión --}}
    @if(session('location_updated'))
        <x-alert-bordered type="success" title="Cambios guardados">
            <span>{{ session('location_updated') }}</span>
        </x-alert-bordered>
    @endif

    @if(session('success'))
        <x-alert-bordered type="success" title="Acción completada">
            <span>{{ session('success') }}</span>
        </x-alert-bordered>
    @endif

    @if(session('error'))
        <x-alert-bordered type="error" title="No se pudo completar la acción">
            <span>{{ session('error') }}</span>
        </x-alert-bordered>
    @endif

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('tenant.admin.locations.index', ['store' => $store->slug]) }}">
            <x-button-icon
                type="outline"
                color="dark"
                icon="arrow-left"
                size="sm"
                text="Volver"
            />
        </a>
        <h1 class="text-lg font-semibold text-gray-900">Detalles de la sede</h1>
    </div>

    {{-- Card principal --}}
    @php
        $statusColor = $location->currentStatus['statusColor'] ?? 'gray';
        $statusText = $location->currentStatus['statusText'] ?? 'Sin estado';
        $statusHint = $location->currentStatus['nextChangeText'] ?? null;
        $days = [
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
        ];
        $today = now()->dayOfWeek;
    @endphp
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-start gap-3 flex-1 min-w-0">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-sm font-semibold uppercase text-blue-700">
                    {{ strtoupper(substr($location->name, 0, 2)) }}
                </div>
                <div class="space-y-2 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="text-base font-semibold text-gray-900 truncate">{{ $location->name }}</h2>
                        <x-badge-soft :type="$location->is_active ? 'success' : 'error'" :text="$location->is_active ? 'Activa' : 'Inactiva'" />
                        @if($location->is_main)
                            <x-badge-soft type="info" text="Principal" />
                        @endif
                        <x-badge-soft type="secondary" :text="$location->city . ', ' . $location->department" />
                    </div>
                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            Creada el {{ $location->created_at->format('d/m/Y H:i') }}
                        </span>
                        <span>•</span>
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            Actualizada el {{ $location->updated_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('tenant.admin.locations.edit', ['store' => $store->slug, 'location' => $location->id]) }}">
                    <x-button-icon
                        type="solid"
                        color="dark"
                        icon="edit"
                        text="Editar"
                    />
                </a>
            </div>
        </div>

        <div class="p-4 md:p-6 space-y-6">
            {{-- Resumen rápido --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <p class="text-xs font-medium text-gray-500">Estado operativo</p>
                    <p class="mt-1 text-sm font-semibold text-{{ $statusColor }}-600">{{ $statusText }}</p>
                    @if($statusHint)
                        <p class="mt-1 text-xs text-gray-500">{{ $statusHint }}</p>
                    @endif
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <p class="text-xs font-medium text-gray-500">Sede principal</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $location->is_main ? 'Sí' : 'No' }}</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <p class="text-xs font-medium text-gray-500">Clics en WhatsApp</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $location->whatsapp_clicks ?? 0 }}</p>
                </div>
            </div>

            {{-- Información general --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <h3 class="text-sm font-semibold text-gray-900">Información de contacto</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-gray-500">Teléfono</span>
                            <span class="font-medium text-gray-900">{{ $location->phone }}</span>
                        </div>
                        @if($location->whatsapp)
                            <div class="flex flex-col gap-2">
                                <span class="text-xs font-medium text-gray-500">WhatsApp</span>
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-gray-900">{{ $location->whatsapp }}</span>
                                    <a
                                        href="{{ \App\Shared\Models\LocationSocialLink::formatWhatsAppUrl($location->whatsapp, $location->whatsapp_message) }}"
                                        target="_blank"
                                        class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-700"
                                        @click="incrementWhatsAppClicks"
                                    >
                                        <i data-lucide="send" class="w-3 h-3"></i>
                                        Abrir chat
                                    </a>
                                </div>
                            </div>
                        @endif
                        <div class="flex flex-col gap-1">
                            <span class="text-xs font-medium text-gray-500">Dirección</span>
                            <p class="text-sm text-gray-700">{{ $location->address }}, {{ $location->city }}, {{ $location->department }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    <h3 class="text-sm font-semibold text-gray-900">Descripción y mensajes</h3>
                    <div class="space-y-4 text-sm text-gray-700">
                        <div>
                            <span class="text-xs font-medium text-gray-500 block mb-1">Descripción</span>
                            <p class="text-sm text-gray-700">{{ $location->description ?: 'Sin descripción registrada.' }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-gray-500 block mb-1">Mensaje de WhatsApp</span>
                            <p class="text-sm text-gray-700">
                                {{ $location->whatsapp_message ?: 'Sin mensaje automático configurado.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards secundarias --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-5">
            {{-- Horarios --}}
            <x-card-base title="Horarios de atención" shadow="none">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600 uppercase tracking-wide text-xs">Día</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600 uppercase tracking-wide text-xs">Estado</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-600 uppercase tracking-wide text-xs">Horario</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($days as $dayNum => $dayName)
                                @php
                                    $schedule = $schedulesByDay[$dayNum] ?? null;
                                    $isToday = $dayNum === $today;
                                    $isClosed = !$schedule || $schedule->is_closed;
                                @endphp
                                <tr class="{{ $isToday ? 'bg-blue-50' : '' }}">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-gray-900">{{ $dayName }}</span>
                                            @if($isToday)
                                                <span class="text-xs text-blue-600">(Hoy)</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <x-badge-soft :type="$isClosed ? 'error' : 'success'" :text="$isClosed ? 'Cerrado' : 'Abierto'" />
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($isClosed)
                                            <span class="text-sm text-gray-500">No disponible</span>
                                        @else
                                            @php
                                                $openTime1 = $schedule->open_time_1 ? \Carbon\Carbon::parse($schedule->open_time_1)->format('H:i') : null;
                                                $closeTime1 = $schedule->close_time_1 ? \Carbon\Carbon::parse($schedule->close_time_1)->format('H:i') : null;
                                                $openTime2 = $schedule->open_time_2 ? \Carbon\Carbon::parse($schedule->open_time_2)->format('H:i') : null;
                                                $closeTime2 = $schedule->close_time_2 ? \Carbon\Carbon::parse($schedule->close_time_2)->format('H:i') : null;
                                            @endphp
                                            <div class="flex flex-wrap items-center gap-2 text-sm text-gray-700">
                                                @if($openTime1 && $closeTime1)
                                                    <span>{{ $openTime1 }} - {{ $closeTime1 }}</span>
                                                @endif
                                                @if($openTime2 && $closeTime2)
                                                    <span class="text-gray-500">|</span>
                                                    <span>{{ $openTime2 }} - {{ $closeTime2 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card-base>

            {{-- Redes sociales --}}
            <x-card-base title="Redes sociales" shadow="none">
                @php
                    $hasLinks = $socialLinksByPlatform->isNotEmpty();
                @endphp
                @if($hasLinks)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($platforms as $platform => $label)
                            @php
                                $social = $socialLinksByPlatform->get($platform);
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100">
                                    <i data-lucide="share-2" class="w-5 h-5 text-gray-500"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $label }}</p>
                                    @if($social)
                                        <a
                                            href="{{ $social->url }}"
                                            target="_blank"
                                            class="text-xs text-blue-600 hover:text-blue-700 break-all"
                                        >
                                            {{ $social->url }}
                                        </a>
                                    @else
                                        <p class="text-xs text-gray-500">Sin enlace configurado.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-6">
                        <x-empty-state
                            svg="base_ui_empty_socialMedia.svg"
                            title="Sin redes registradas"
                            description="Configura enlaces de redes sociales en la edición de la sede."
                        />
                    </div>
                @endif
            </x-card-base>
        </div>

        {{-- Columna lateral --}}
        <div class="space-y-5">
            <x-card-base title="Estado en tiempo real" shadow="none">
                <div class="text-center space-y-3">
                    <div class="mx-auto inline-flex h-16 w-16 items-center justify-center rounded-full bg-{{ $statusColor }}-50">
                        <i data-lucide="activity" class="h-8 w-8 text-{{ $statusColor }}-500"></i>
                    </div>
                    <div>
                        <p class="text-lg font-semibold text-{{ $statusColor }}-600">{{ $statusText }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $location->city }}, {{ $location->department }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm text-gray-700 pt-4 border-t border-gray-100">
                        <div class="text-left">
                            <p class="text-xs font-medium text-gray-500">Día actual</p>
                            <p class="mt-1 font-semibold">{{ $days[$today] }}</p>
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-medium text-gray-500">Hora actual</p>
                            <p class="mt-1 font-semibold">{{ now()->format('H:i') }}</p>
                        </div>
                        @if($location->whatsapp)
                            <div class="text-left">
                                <p class="text-xs font-medium text-gray-500">Clics WhatsApp</p>
                                <p class="mt-1 font-semibold">{{ $location->whatsapp_clicks ?? 0 }}</p>
                            </div>
                        @endif
                        <div class="text-left">
                            <p class="text-xs font-medium text-gray-500">Último cambio</p>
                            <p class="mt-1 font-semibold">{{ $statusHint ?: 'Sin información' }}</p>
                        </div>
                    </div>
                </div>
            </x-card-base>

            <x-card-base title="Acciones rápidas" shadow="none">
                <div class="space-y-3">
                    @if(!$location->is_main)
                        <x-button-base
                            type="outline"
                            color="secondary"
                            text="Establecer como principal"
                            class="w-full"
                            @click="setAsMain({{ $location->id }})"
                        />
                    @endif

                    <x-button-base
                        type="{{ $location->is_active ? 'outline' : 'solid' }}"
                        color="{{ $location->is_active ? 'warning' : 'success' }}"
                        text="{{ $location->is_active ? 'Desactivar sede' : 'Activar sede' }}"
                        class="w-full"
                        :disabled="$location->is_main"
                        @click="toggleStatus({{ $location->id }}, {{ $location->is_active ? 'true' : 'false' }})"
                    />

                    <x-button-base
                        type="outline"
                        color="error"
                        text="Eliminar sede"
                        class="w-full"
                        :disabled="$location->is_main"
                        @click="openDeleteModal({{ $location->id }}, '{{ $location->name }}')"
                    />
                </div>
            </x-card-base>
        </div>
    </div>

    {{-- Modal de eliminación --}}
    @include('tenant-admin::core.locations.components.delete-modal')
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('locationShow', () => ({
        showDeleteModal: false,
        deleteLocationId: null,
        deleteLocationName: '',
        showNotification: false,
        notificationMessage: '',
        notificationType: 'success',

        openDeleteModal(id, name) {
            this.deleteLocationId = id;
            this.deleteLocationName = name;
            this.showDeleteModal = true;
        },

        closeDeleteModal() {
            this.showDeleteModal = false;
            this.deleteLocationId = null;
            this.deleteLocationName = '';
        },

        confirmDelete() {
            if (!this.deleteLocationId) {
                return;
            }

            const url = `{{ route('tenant.admin.locations.destroy', ['store' => $store->slug, 'location' => ':id']) }}`.replace(':id', this.deleteLocationId);

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.showNotificationMessage(data.message, 'success');
                        setTimeout(() => {
                            window.location.href = '{{ route('tenant.admin.locations.index', ['store' => $store->slug]) }}';
                        }, 1200);
                    } else {
                        this.showNotificationMessage(data.message, 'error');
                    }
                    this.closeDeleteModal();
                })
                .catch(() => {
                    this.showNotificationMessage('Error al eliminar la sede.', 'error');
                    this.closeDeleteModal();
                });
        },

        toggleStatus(id, isActive) {
            const url = `{{ route('tenant.admin.locations.toggle-status', ['store' => $store->slug, 'location' => ':id']) }}`.replace(':id', id);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.showNotificationMessage(data.message, 'success');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        this.showNotificationMessage(data.message, 'error');
                    }
                })
                .catch(() => {
                    this.showNotificationMessage('Error al cambiar el estado de la sede.', 'error');
                });
        },

        setAsMain(id) {
            const url = `{{ route('tenant.admin.locations.set-as-main', ['store' => $store->slug, 'location' => ':id']) }}`.replace(':id', id);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.showNotificationMessage(data.message, 'success');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        this.showNotificationMessage(data.message, 'error');
                    }
                })
                .catch(() => {
                    this.showNotificationMessage('Error al establecer la sede como principal.', 'error');
                });
        },

        incrementWhatsAppClicks() {
            const url = `{{ route('tenant.admin.locations.increment-whatsapp-clicks', ['store' => $store->slug, 'location' => $location->id]) }}`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            }).catch(() => {
                // Silencioso
            });
        },

        showNotificationMessage(message, type = 'success') {
            this.notificationMessage = message;
            this.notificationType = type;
            this.showNotification = true;

            setTimeout(() => {
                this.showNotification = false;
            }, 5000);
        },
    }));
});
</script>
@endpush
@endsection
</x-tenant-admin-layout>
