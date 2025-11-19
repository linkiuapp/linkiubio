<x-tenant-admin-layout :store="$store">
    @section('title', 'Cupones')

    @section('content')
    {{-- SECTION: Estado vacío configuración --}}
    @php
        $emptyStateSvg = 'base_ui_empty_cupones.svg';
        $emptyStateTitle = 'No hay cupones disponibles';
        $emptyStateMessage = 'Crea tu primer cupón y premia la fidelidad de tus clientes.';

        $statusBadgeMap = [
            'Activo' => 'success',
            'Inactivo' => 'error',
            'Próximo' => 'info',
            'Expirado' => 'error',
            'Agotado' => 'warning',
        ];

        $typeBadgeMap = [
            'percentage' => 'secondary',
            'fixed' => 'info',
            'free_shipping' => 'success',
        ];
    @endphp
    {{-- End SECTION: Estado vacío configuración --}}

    {{-- SECTION: Contenedor principal --}}
    <div
        x-data="couponManagement()"
        x-init="init()"
        class="space-y-4"
    >
        {{-- SECTION: Alertas de sesión --}}
        @foreach ([
            'coupon_created' => 'El cupón se ha creado correctamente.',
            'coupon_updated' => 'El cupón se ha actualizado correctamente.',
            'coupon_status_updated' => 'El estado del cupón se actualizó correctamente.',
            'coupon_deleted' => 'El cupón se ha eliminado correctamente.',
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
                    {{-- COMPONENT: x-alert-bordered | props:{type:success,title:Actualización exitosa,message:$message} --}}
                    <x-alert-bordered
                        type="success"
                        title="Actualización exitosa"
                        :message="$message"
                    />
                    {{-- End COMPONENT: x-alert-bordered --}}
                </div>
            @endif
        @endforeach

        {{-- SECTION: Alerta dinámica eliminación --}}
        <div
            x-show="showSuccessAlert"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            style="display: none;"
        >
            <x-alert-bordered
                type="success"
                title="Actualización exitosa"
            >
                <span x-text="successMessage"></span>
            </x-alert-bordered>
        </div>

        <div
            x-show="showErrorAlert"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            style="display: none;"
        >
            <x-alert-bordered
                type="error"
                title="Ocurrió un error"
            >
                <span x-text="errorMessage"></span>
            </x-alert-bordered>
        </div>
        {{-- End SECTION: Alertas --}}

        {{-- SECTION: Content Card --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            {{-- SECTION: Header --}}
            <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Cupones</h2>
                        <p class="text-sm text-gray-600">
                            Usando {{ $currentCount }} de {{ $maxCoupons }} cupones disponibles en tu plan {{ $store->plan->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($remainingSlots > 0)
                            <a href="{{ route('tenant.admin.coupons.create', ['store' => $store->slug]) }}">
                                <x-button-icon
                                    type="solid"
                                    color="info"
                                    size="md"
                                    icon="plus-circle"
                                    text="Nuevo cupón"
                                />
                            </a>
                        @else
                            <x-button-icon
                                type="outline"
                                color="secondary"
                                size="md"
                                icon="plus-circle"
                                text="Límite alcanzado"
                                :disabled="true"
                            />
                        @endif
                    </div>
                </div>
            </div>
            {{-- End SECTION: Header --}}

            {{-- SECTION: Toolbar --}}
            <div class="px-6 py-3 bg-gray-50" x-data="couponFilters()">
                <form id="coupon-filters-form" method="GET">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div class="w-72">
                                <x-input-with-icon
                                    icon="search"
                                    name="search"
                                    placeholder="Buscar por nombre o código..."
                                    x-model="form.search"
                                    x-on:keyup.debounce.500="submitFilters()"
                                    x-on:keydown.enter.prevent="submitFilters()"
                                />
                            </div>

                            <div class="w-48">
                            <x-select-basic
                                name="status"
                                select-id="coupon-status-filter"
                                :selected="request('status')"
                                :options="[
                                    '' => 'Todos los estados',
                                    'active' => 'Activos',
                                    'inactive' => 'Inactivos',
                                    'expired' => 'Expirados',
                                    'upcoming' => 'Próximos',
                                ]"
                                placeholder="Filtrar por estado"
                                class="w-48"
                                x-model="form.status"
                                x-on:change="submitFilters()"
                            />
                            </div>

                            <div class="w-48">
                            <x-select-basic
                                name="type"
                                select-id="coupon-type-filter"
                                :selected="request('type')"
                                :options="collect(\App\Features\TenantAdmin\Models\Coupon::TYPES)->toArray()"
                                placeholder="Filtrar por tipo"
                                class="w-56"
                                x-model="form.type"
                                x-on:change="submitFilters()"
                            />
                            </div>

                            <div class="w-48">
                            <x-select-basic
                                name="discount_type"
                                select-id="coupon-discount-filter"
                                :selected="request('discount_type')"
                                :options="collect(\App\Features\TenantAdmin\Models\Coupon::DISCOUNT_TYPES)->toArray()"
                                placeholder="Filtrar por descuento"
                                class="w-56"
                                x-model="form.discountType"
                                x-on:change="submitFilters()"
                            />
                            </div>
                            <button type="submit" class="sr-only">Filtrar</button>

                            @if(request()->hasAny(['search', 'status', 'type', 'discount_type']))
                                <button
                                    type="button"
                                    class="py-2 px-3 text-sm font-medium text-gray-600 hover:text-blue-600"
                                    x-on:click="clearFilters()"
                                >
                                    Limpiar filtros
                                </button>
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">
                            Mostrando <span data-coupon-count="{{ $coupons->count() }}">{{ $coupons->count() }}</span> cupones
                        </div>
                    </div>

                </form>
            </div>
            {{-- End SECTION: Toolbar --}}

            {{-- SECTION: Table Content --}}
            <div class="space-y-6">
                @include('tenant-admin::Core/coupons/components/table-view', [
                    'coupons' => $coupons,
                    'store' => $store,
                    'statusBadgeMap' => $statusBadgeMap,
                    'typeBadgeMap' => $typeBadgeMap,
                    'emptyStateSvg' => $emptyStateSvg,
                    'emptyStateTitle' => $emptyStateTitle,
                    'emptyStateMessage' => $emptyStateMessage,
                    'remainingSlots' => $remainingSlots,
                ])

                @if($coupons->hasPages())
                    <div class="border-t border-gray-200 pt-4">
                        {{ $coupons->links() }}
                    </div>
                @endif
            </div>
            {{-- End SECTION: Table Content --}}
        </div>
        {{-- End SECTION: Content Card --}}

        {{-- SECTION: Modal eliminar cupón --}}
        <div
            x-data="couponDeleteModalData()"
            x-on:keydown.escape.window="closeModal()"
            @delete-coupon.window="openModal($event.detail.id, $event.detail.name, $event.detail.url, $event.detail.rowElement)"
        >
            {{-- Modal Overlay --}}
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

            {{-- Modal Content --}}
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
                aria-labelledby="delete-coupon-modal-label"
                style="display: none;"
            >
                <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center pointer-events-none">
                    <div
                        @click.stop
                        class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-xl pointer-events-auto"
                    >
                        {{-- Modal Header --}}
                        <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                            <h3 id="delete-coupon-modal-label" class="font-bold text-gray-800">
                                ¿Eliminar cupón?
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
                        {{-- End Modal Header --}}

                        {{-- Modal Body --}}
                        <div class="p-4 overflow-y-auto">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1 text-sm text-gray-700">
                                    <p>
                                        Se eliminará el cupón <strong>"<span x-text="couponName"></span>"</strong> de forma permanente.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Esta acción no se puede deshacer.
                                    </p>

                                    <div x-show="error" class="mt-3" x-cloak>
                                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                            <div class="flex">
                                                <div class="shrink-0">
                                                    <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <h3 class="text-sm font-medium">
                                                        Error: <span x-text="error"></span>
                                                    </h3>
                                                </div>
                                                <div class="ps-3 ms-auto">
                                                    <div class="-mx-1.5 -my-1.5">
                                                        <button
                                                            type="button"
                                                            class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100"
                                                            @click="error = null"
                                                        >
                                                            <span class="sr-only">Descartar</span>
                                                            <i data-lucide="x" class="shrink-0 size-4"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Modal Body --}}

                        {{-- Modal Footer --}}
                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
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
                        {{-- End Modal Footer --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- End SECTION: Modal eliminar cupón --}}
    </div>
    {{-- End SECTION: Contenedor principal --}}

    @push('scripts')
    <script>
        function couponManagement() {
            return {
                successMessage: null,
                errorMessage: null,
                showSuccessAlert: false,
                showErrorAlert: false,
                couponUrl: '',

                init() {
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }

                    window.addEventListener('coupon-delete-success', (event) => {
                        this.successMessage = event.detail?.message || 'El cupón se ha eliminado correctamente.';
                        this.errorMessage = null;
                        this.showSuccessAlert = true;
                        this.showErrorAlert = false;
                        this.$nextTick(() => {
                            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                window.createIcons({ icons: window.lucideIcons });
                            }
                        });
                        setTimeout(() => {
                            this.showSuccessAlert = false;
                        }, 5000);
                    });

                    window.addEventListener('coupon-delete-error', (event) => {
                        this.errorMessage = event.detail?.message || 'No pudimos eliminar el cupón.';
                        this.showErrorAlert = true;
                        this.showSuccessAlert = false;
                        this.$nextTick(() => {
                            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                window.createIcons({ icons: window.lucideIcons });
                            }
                        });
                        setTimeout(() => {
                            this.showErrorAlert = false;
                        }, 5000);
                    });

                    window.addEventListener('coupons-check-empty', () => {
                        this.checkAndShowEmptyState();
                    });
                },

                deleteCoupon(coupon, event) {
                    const rowElement = event.target.closest('tr');
                    window.dispatchEvent(new CustomEvent('delete-coupon', {
                        detail: {
                            id: coupon.id,
                            name: coupon.name,
                            url: coupon.url,
                            rowElement
                        }
                    }));
                },

                checkAndShowEmptyState() {
                    const rows = document.querySelectorAll('tr[data-coupon-id]');
                    const emptyStateRow = document.getElementById('coupons-empty-state');
                    if (rows.length === 0 && emptyStateRow) {
                        emptyStateRow.classList.remove('hidden');
                    }

                    const countElement = document.querySelector('[data-coupon-count]');
                    if (countElement) {
                        countElement.textContent = rows.length;
                    }
                }
            };
        }

        function couponFilters() {
            return {
                form: {
                    search: @js(request('search', '')),
                    status: @js(request('status', '')),
                    type: @js(request('type', '')),
                    discountType: @js(request('discount_type', '')),
                },
                submitFilters() {
                    const form = document.getElementById('coupon-filters-form');
                    if (form) {
                        form.requestSubmit();
                    }
                },
                clearFilters() {
                    this.form.search = '';
                    this.form.status = '';
                    this.form.type = '';
                    this.form.discountType = '';
                    const url = new URL(window.location.href);
                    ['search', 'status', 'type', 'discount_type'].forEach(param => url.searchParams.delete(param));
                    window.location.href = url.toString();
                }
            };
        }

        function couponDeleteModalData() {
            return {
                open: false,
                couponId: null,
                couponName: '',
                couponUrl: '',
                couponRow: null,
                loading: false,
                error: null,

                openModal(id, name, url, rowElement) {
                    this.couponId = id;
                    this.couponName = name;
                     this.couponUrl = url;
                    this.couponRow = rowElement;
                    this.error = null;
                    this.open = true;
                    this.$nextTick(() => {
                        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                            window.createIcons({ icons: window.lucideIcons });
                        }
                    });
                },

                closeModal() {
                    if (!this.loading) {
                        this.open = false;
                        this.couponId = null;
                        this.couponName = '';
                        this.couponUrl = '';
                        this.couponRow = null;
                        this.error = null;
                    }
                },

                async confirmDelete() {
                    if (!this.couponId) {
                        return;
                    }

                    this.loading = true;
                    this.error = null;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        const response = await fetch(this.couponUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                        });

                        let data = null;
                        try {
                            data = await response.json();
                        } catch (e) {
                            // Ignorar si no hay JSON
                        }

                        if (!response.ok) {
                            throw new Error(data?.message || data?.error || 'Error al eliminar el cupón');
                        }

                        this.loading = false;

                        const rowToDelete = this.couponRow;
                        const couponName = this.couponName;

                        this.closeModal();

                        if (rowToDelete && rowToDelete.parentNode) {
                            rowToDelete.style.transition = 'opacity 0.3s ease-out';
                            rowToDelete.style.opacity = '0';
                            setTimeout(() => {
                                if (rowToDelete.parentNode) {
                                    rowToDelete.remove();
                                }

                                window.dispatchEvent(new CustomEvent('coupon-delete-success', {
                                    detail: {
                                        message: `El cupón "${couponName}" se eliminó correctamente.`
                                    }
                                }));

                                window.dispatchEvent(new CustomEvent('coupons-check-empty'));
                            }, 300);
                        } else {
                            window.dispatchEvent(new CustomEvent('coupon-delete-success', {
                                detail: {
                                    message: `El cupón "${couponName}" se eliminó correctamente.`
                                }
                            }));
                            window.location.reload();
                        }
                    } catch (error) {
                        const message = error?.message || 'Error al eliminar el cupón';
                        this.error = message;
                        this.loading = false;
                        window.dispatchEvent(new CustomEvent('coupon-delete-error', {
                            detail: { message }
                        }));
                    }
                },
            };
        }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>