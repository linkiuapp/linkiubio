{{--
Vista Index - Listado de Sedes
Muestra todas las sedes con filtros, acciones y paginación siguiendo el patrón del Design System
--}}

<x-tenant-admin-layout :store="$store">
    @section('title', 'Gestión de Sedes')

    @section('content')
    {{-- SECTION: Main Container --}}
    <div
        class="space-y-4"
        x-data="locationsPage()"
        x-init="init()"
    >
        {{-- SECTION: Session Alerts --}}
        @foreach ([
            'location_created' => 'La sede se ha creado correctamente.',
            'location_updated' => 'La sede se ha actualizado correctamente.',
            'location_deleted' => 'La sede se ha eliminado correctamente.',
        ] as $sessionKey => $message)
            @if(session($sessionKey))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2"
                    x-init="setTimeout(() => show = false, 5000)"
                >
                    <x-alert-bordered
                        type="success"
                        title="Actualización exitosa"
                        :message="$message"
                    />
                </div>
            @endif
        @endforeach
        {{-- End SECTION: Session Alerts --}}

        {{-- SECTION: Delete Success Alert --}}
        <div
            x-show="showSuccessAlert"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
        >
            <x-alert-bordered
                type="success"
                title="Acción exitosa"
            >
                <span x-text="successMessage"></span>
            </x-alert-bordered>
        </div>
        {{-- End SECTION: Delete Success Alert --}}

        @php
            $emptyStateSvg = 'base_ui_empty_locations.svg';
            $emptyStateTitle = 'Aún no registras sedes';
            $emptyStateMessage = 'Crea tu primera sede para organizar horarios, contactos y estados operativos.';
        @endphp

        {{-- SECTION: Content Card --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            {{-- SECTION: Header --}}
            <div class="bg-gray-50 py-4 px-6">
                <div class="flex flex-col justify-between gap-3 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Sedes</h2>
                        <p class="text-sm text-gray-600">
                            Usando {{ $currentCount }} de {{ $maxLocations }} sedes disponibles en tu plan {{ $store->plan->name }}.
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($remainingSlots > 0)
                            <a href="{{ route('tenant.admin.locations.create', ['store' => $store->slug]) }}">
                                <x-button-icon
                                    type="solid"
                                    color="info"
                                    size="md"
                                    icon="plus-circle"
                                    text="Nueva sede"
                                />
                            </a>
                        @else
                            <x-button-icon
                                type="outline"
                                color="secondary"
                                size="md"
                                icon="slash"
                                text="Límite alcanzado"
                                :disabled="true"
                            />
                        @endif
                    </div>
                </div>
            </div>
            {{-- End SECTION: Header --}}

            {{-- SECTION: Toolbar --}}
            <div class="px-6 py-4 bg-gray-50">
                <form
                    id="filterForm"
                    method="GET"
                    action="{{ route('tenant.admin.locations.index', ['store' => $store->slug]) }}"
                    class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
                >
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:gap-4">
                        <div class="w-full">
                            <x-input-with-icon
                                name="search"
                                icon="search"
                                placeholder="Buscar por nombre, ciudad o encargado..."
                                value="{{ request('search') }}"
                            />
                        </div>
                        <div class="w-full">
                            <x-select-basic
                                name="status"
                                select-id="location-status-filter"
                                :selected="request('status', '')"
                                :options="[
                                    '' => 'Todas',
                                    'active' => 'Activas',
                                    'inactive' => 'Inactivas',
                                ]"
                                placeholder="Todas"
                            />
                        </div>
                    </div>
                    <div class="flex flex-col items-center gap-3 sm:flex-row">
                        <x-button-icon
                            type="solid"
                            size="sm"
                            color="dark"
                            icon="filter"
                            text="Filtrar"
                            html-type="submit"
                        />
                        <a href="{{ route('tenant.admin.locations.index', ['store' => $store->slug]) }}">
                            <x-button-base
                                type="outline"
                                size="sm"
                                color="secondary"
                                text="Limpiar"
                            />
                        </a>
                    </div>
                </form>
            </div>
            {{-- End SECTION: Toolbar --}}

            {{-- SECTION: Table Content --}}
            @include('tenant-admin::core.locations.components.table-view', [
                'locations' => $locations,
                'store' => $store,
                'remainingSlots' => $remainingSlots,
                'emptyStateTitle' => $emptyStateTitle,
                'emptyStateMessage' => $emptyStateMessage,
            ])
            {{-- End SECTION: Table Content --}}

            {{-- SECTION: Pagination --}}
            @if($locations->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $locations->links('tenant-admin::core.locations.components.pagination') }}
                </div>
            @endif
            {{-- End SECTION: Pagination --}}
        </div>
        {{-- End SECTION: Content Card --}}

        {{-- SECTION: Delete Modal --}}
        <div
            x-data="deleteModalData()"
            x-on:keydown.escape.window="closeModal()"
            @delete-location.window="openModal($event.detail.id, $event.detail.name, $event.detail.rowElement)"
        >
            <div
                x-show="open"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
                @click="closeModal()"
                style="display: none;"
            ></div>

            <div
                x-show="open"
                x-transition:enter="transition-opacity duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 overflow-x-hidden overflow-y-auto pointer-events-none"
                role="dialog"
                tabindex="-1"
                aria-labelledby="delete-location-modal-label"
                style="display: none;"
            >
                <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                    <div
                        @click.stop
                        class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                    >
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <h3 id="delete-location-modal-label" class="font-bold text-gray-800">
                                ¿Eliminar sede?
                            </h3>
                            <button
                                type="button"
                                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                                aria-label="Cerrar"
                                @click="closeModal()"
                                :disabled="loading"
                            >
                                <span class="sr-only">Cerrar</span>
                                <i data-lucide="x" class="shrink-0 size-4"></i>
                            </button>
                        </div>

                        <div class="p-4 overflow-y-auto">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1 space-y-2">
                                    <p class="text-gray-800">
                                        Se eliminará la sede <strong>"<span x-text="locationName"></span>"</strong> de forma permanente.
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Esta acción no se puede deshacer.
                                    </p>

                                    <div x-show="error" class="mt-3" x-cloak>
                                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                            <div class="flex items-start gap-2">
                                                <i data-lucide="x-circle" class="size-4 mt-0.5"></i>
                                                <span>Error: <span x-text="error"></span></span>
                                                <button
                                                    type="button"
                                                    class="ms-auto inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100"
                                                    @click="error = null"
                                                >
                                                    <span class="sr-only">Descartar</span>
                                                    <i data-lucide="x" class="size-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end items-center gap-2 border-t border-gray-200 px-4 py-3">
                            <button
                                type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                @click="closeModal()"
                                :disabled="loading"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                                @click="confirmDelete()"
                                :disabled="loading"
                            >
                                <span x-show="!loading">Sí, eliminar</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <i data-lucide="loader" class="size-4 animate-spin"></i>
                                    Eliminando...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End SECTION: Delete Modal --}}
    </div>
    {{-- End SECTION: Main Container --}}

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('locationsPage', () => ({
                showSuccessAlert: false,
                successMessage: '',
                init() {
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }

                    const storedMessage = window.localStorage.getItem('locations-success-message');
                    if (storedMessage) {
                        this.successMessage = storedMessage;
                        window.localStorage.removeItem('locations-success-message');
                        this.triggerSuccessAlert();
                    }

                    window.addEventListener('show-success-alert', (event) => {
                        const detail = event.detail || {};
                        this.successMessage = detail.message || 'Operación realizada correctamente.';
                        this.triggerSuccessAlert();
                    });

                    this.registerToggleHandlers();
                    this.registerSetAsMainHandlers();
                },
                triggerSuccessAlert() {
                    if (!this.successMessage) {
                        this.successMessage = 'Operación realizada correctamente.';
                    }
                    this.showSuccessAlert = true;
                    this.$nextTick(() => {
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    });
                    setTimeout(() => {
                        this.showSuccessAlert = false;
                    }, 5000);
                },
                deleteLocation(id, name, event) {
                    const rowElement = event.target.closest('tr');
                    window.dispatchEvent(new CustomEvent('delete-location', {
                        detail: { id, name, rowElement }
                    }));
                },
                registerToggleHandlers() {
                    document.addEventListener('change', (event) => {
                        if (!event.target.classList.contains('location-toggle')) {
                            return;
                        }
                        const checkbox = event.target;
                        const url = checkbox.dataset.url;
                        const isChecked = checkbox.checked;
                        checkbox.disabled = true;

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
                            if (!data.success) {
                                checkbox.checked = !isChecked;
                                alert(data.message || 'No se pudo actualizar el estado.');
                                checkbox.disabled = false;
                                return;
                            }
                            window.location.reload();
                        })
                        .catch(() => {
                            checkbox.checked = !isChecked;
                            alert('Ocurrió un error al actualizar el estado.');
                            checkbox.disabled = false;
                        });
                    });
                },
                registerSetAsMainHandlers() {
                    document.addEventListener('click', (event) => {
                        const button = event.target.closest('[data-location-set-main]');
                        if (!button) {
                            return;
                        }
                        const row = button.closest('tr');
                        const url = button.dataset.url;
                        button.disabled = true;

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
                            if (!data.success) {
                                alert(data.message || 'No se pudo establecer la sede como principal.');
                                button.disabled = false;
                                return;
                            }
                            this.setMainSuccess(row, button, data.message);
                        })
                        .catch(() => {
                            alert('Ocurrió un error al establecer la sede como principal.');
                            button.disabled = false;
                        });
                    });
                },
                setMainSuccess(newMainRow, button, message = 'Sede establecida como principal exitosamente.') {
                    const tbody = newMainRow.parentElement;
                    const previousMainRow = tbody.querySelector('tr[data-location-main="true"]');

                    if (previousMainRow && previousMainRow !== newMainRow) {
                        this.markRowAsNotMain(previousMainRow);
                    }

                    this.markRowAsMain(newMainRow, button);
                    this.successMessage = message;
                    this.triggerSuccessAlert();
                },
                markRowAsMain(row, button) {
                    row.dataset.locationMain = 'true';

                    const badgeWrapper = row.querySelector('[data-location-main-wrapper]');
                    if (badgeWrapper && !badgeWrapper.querySelector('.badge-principal')) {
                        const badge = document.createElement('span');
                        badge.className = 'badge-principal inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                        badge.textContent = 'Principal';
                        badgeWrapper.appendChild(badge);
                    }

                    const toggle = row.querySelector('.location-toggle');
                    const track = row.querySelector('.toggle-track');
                    if (toggle) {
                        toggle.disabled = true;
                        toggle.setAttribute('disabled', 'disabled');
                    }
                    if (track) {
                        track.classList.add('opacity-50', 'cursor-not-allowed');
                    }

                    const tooltipWrapper = row.querySelector('[data-location-main-tooltip]');
                    if (tooltipWrapper) {
                        tooltipWrapper.classList.remove('hidden');
                    }

                    if (button) {
                        button.classList.add('hidden');
                        button.disabled = true;
                    }
                },
                markRowAsNotMain(row) {
                    row.dataset.locationMain = 'false';

                    const badgeWrapper = row.querySelector('[data-location-main-wrapper]');
                    if (badgeWrapper) {
                        const badge = badgeWrapper.querySelector('.badge-principal');
                        if (badge) {
                            badge.remove();
                        }
                    }

                    const toggle = row.querySelector('.location-toggle');
                    const track = row.querySelector('.toggle-track');
                    if (toggle) {
                        toggle.disabled = false;
                        toggle.removeAttribute('disabled');
                    }
                    if (track) {
                        track.classList.remove('opacity-50', 'cursor-not-allowed');
                    }

                    const tooltipWrapper = row.querySelector('[data-location-main-tooltip]');
                    if (tooltipWrapper) {
                        tooltipWrapper.classList.add('hidden');
                    }

                    const setMainButton = row.querySelector('[data-location-set-main]');
                    if (setMainButton) {
                        setMainButton.classList.remove('hidden');
                        setMainButton.disabled = false;
                    }
                },
            }));
        });

        function deleteModalData() {
            return {
                open: false,
                locationId: null,
                locationName: '',
                locationRow: null,
                loading: false,
                error: null,

                openModal(id, name, rowElement) {
                    this.locationId = id;
                    this.locationName = name;
                    this.locationRow = rowElement;
                    this.error = null;
                    this.open = true;
                },

                closeModal() {
                    if (this.loading) {
                        return;
                    }
                    this.open = false;
                    this.locationId = null;
                    this.locationName = '';
                    this.locationRow = null;
                    this.error = null;
                },

                async confirmDelete() {
                    if (!this.locationId) {
                        return;
                    }

                    this.loading = true;
                    this.error = null;

                    try {
                        const storeSlug = '{{ $store->slug }}';
                        const response = await fetch(`/${storeSlug}/admin/locations/${this.locationId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                        });

                        let data;
                        try {
                            data = await response.json();
                        } catch (e) {
                            throw new Error('Error al procesar la respuesta del servidor.');
                        }

                        if (!response.ok || data.success === false) {
                            throw new Error((data && (data.message || data.error)) || 'No se pudo eliminar la sede.');
                        }

                        window.localStorage.setItem('locations-success-message', data.message || 'La sede se ha eliminado correctamente.');
                        window.location.reload();
                    } catch (error) {
                        this.error = error.message || 'No se pudo eliminar la sede.';
                        this.loading = false;
                    }
                },
            };
        }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 
