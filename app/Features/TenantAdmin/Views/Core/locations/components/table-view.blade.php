{{-- SECTION: Table View --}}
<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sede
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ubicación
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contacto
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Activar/Desactivar
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado operativo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($locations as $location)
                            <tr
                                class="hover:bg-gray-50 transition-colors"
                                data-location-id="{{ $location->id }}"
                                data-location-main="{{ $location->is_main ? 'true' : 'false' }}"
                                data-set-main-url="{{ route('tenant.admin.locations.set-as-main', ['store' => $store->slug, 'location' => $location->id]) }}"
                            >
                                {{-- COLUMN: Info --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-semibold text-blue-600">
                                            {{ mb_strtoupper(mb_substr($location->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2" data-location-main-wrapper>
                                                <p class="text-sm font-semibold text-gray-900">{{ $location->name }}</p>
                                                @if($location->is_main)
                                                    <span class="badge-principal inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Principal</span>
                                                @endif
                                            </div>
                                            @if($location->manager_name)
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <span class="font-medium text-gray-700">Encargado:</span> {{ $location->manager_name }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                {{-- COLUMN: Location --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <p class="text-sm text-gray-900">{{ $location->city }}, {{ $location->department }}</p>
                                    <p class="text-xs text-gray-500">{{ $location->address }}</p>
                                </td>
                                {{-- COLUMN: Contact --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <p class="text-sm text-gray-900">{{ $location->phone }}</p>
                                    @if($location->whatsapp)
                                        <p class="text-xs text-gray-500">
                                            <span class="font-medium text-gray-700">WhatsApp:</span> {{ $location->whatsapp }}
                                        </p>
                                    @endif
                                </td>
                                {{-- COLUMN: Estado --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex flex-col gap-2">
                                        <label for="toggle-{{ $location->id }}" class="flex items-center gap-3">
                                            <span class="text-xs font-medium text-gray-600">
                                                {{ $location->is_active ? 'Activa' : 'Inactiva' }}
                                            </span>
                                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                                <input
                                                    type="checkbox"
                                                    id="toggle-{{ $location->id }}"
                                                    class="peer sr-only location-toggle"
                                                    data-url="{{ route('tenant.admin.locations.toggle-status', ['store' => $store->slug, 'location' => $location->id]) }}"
                                                    {{ $location->is_active ? 'checked' : '' }}
                                                    {{ $location->is_main ? 'disabled' : '' }}
                                                >
                                                <span class="toggle-track absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 {{ $location->is_main ? 'opacity-50 cursor-not-allowed' : '' }}"></span>
                                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                                            </label>
                                            <span data-location-main-tooltip class="{{ $location->is_main ? '' : 'hidden' }}">
                                                <x-tooltip-top text="No puedes desactivar la sede principal. Asigna otra sede como principal primero.">
                                                    <i data-lucide="info" class="w-4 h-4 text-gray-400"></i>
                                                </x-tooltip-top>
                                            </span>
                                        </label>
                                    </div>
                                </td>
                                {{-- COLUMN: Status --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="flex flex-col gap-2">
                                        @php
                                            $operationalStatus = $location->currentStatus['status'] ?? 'closed';
                                            $statusMap = [
                                                'open' => ['type' => 'success', 'text' => 'Abierto'],
                                                'temporarily_closed' => ['type' => 'warning', 'text' => 'Cerrado temporalmente'],
                                                'closed' => ['type' => 'error', 'text' => 'Cerrado'],
                                            ];
                                            $operationalBadge = $statusMap[$operationalStatus] ?? $statusMap['closed'];
                                        @endphp
                                        <x-badge-soft
                                            :type="$operationalBadge['type']"
                                            :text="$operationalBadge['text']"
                                        />
                                    </div>
                                </td>
                                {{-- COLUMN: Actions --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-2">
                                        <x-tooltip-top text="Ver detalles">
                                            <a
                                                href="{{ route('tenant.admin.locations.show', ['store' => $store->slug, 'location' => $location->id]) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                aria-label="Ver detalles"
                                            >
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                        </x-tooltip-top>

                                        <x-tooltip-top text="Editar">
                                            <a
                                                href="{{ route('tenant.admin.locations.edit', ['store' => $store->slug, 'location' => $location->id]) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                                aria-label="Editar"
                                            >
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                        </x-tooltip-top>

                                        <x-tooltip-top text="Eliminar">
                                            <button
                                                type="button"
                                                class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                aria-label="Eliminar"
                                                @click.stop="deleteLocation({{ $location->id }}, '{{ addslashes($location->name) }}', $event)"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </x-tooltip-top>

                                        <x-tooltip-top text="Establecer como principal">
                                            <button
                                                type="button"
                                                class="inline-flex items-center justify-center w-8 h-8 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors {{ $location->is_main ? 'hidden' : '' }}"
                                                aria-label="Establecer como principal"
                                                data-location-set-main
                                                data-url="{{ route('tenant.admin.locations.set-as-main', ['store' => $store->slug, 'location' => $location->id]) }}"
                                                {{ $location->is_main ? 'disabled' : '' }}
                                            >
                                                <i data-lucide="star" class="w-4 h-4"></i>
                                            </button>
                                        </x-tooltip-top>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12">
                                    <x-empty-state
                                        :svg="$emptyStateSvg"
                                        :title="$emptyStateTitle"
                                        :message="$emptyStateMessage"
                                    >
                                        @if($remainingSlots > 0)
                                            <x-slot:action>
                                                <a href="{{ route('tenant.admin.locations.create', ['store' => $store->slug]) }}">
                                                    <x-button-icon
                                                        type="solid"
                                                        color="info"
                                                        size="md"
                                                        icon="plus-circle"
                                                        text="Crear sede"
                                                    />
                                                </a>
                                            </x-slot:action>
                                        @endif
                                    </x-empty-state>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="dynamic-empty-state" style="display: none;">
                            <td colspan="5" class="px-6 py-12">
                                <x-empty-state
                                    :svg="$emptyStateSvg"
                                    :title="$emptyStateTitle"
                                    :message="$emptyStateMessage"
                                >
                                    @if($remainingSlots > 0)
                                        <x-slot:action>
                                            <a href="{{ route('tenant.admin.locations.create', ['store' => $store->slug]) }}">
                                                <x-button-icon
                                                    type="solid"
                                                    color="info"
                                                    size="md"
                                                    icon="plus-circle"
                                                    text="Crear sede"
                                                />
                                            </a>
                                        </x-slot:action>
                                    @endif
                                </x-empty-state>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- End SECTION: Table View --}}
