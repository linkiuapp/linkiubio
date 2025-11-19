<x-tenant-admin-layout :store="$store">
    @section('title', 'Detalles del cupón')

    @section('content')
    <div class="max-w-5xl mx-auto space-y-4" x-data="couponShowData()" x-init="init()">
        @php
            $now = now();
            if (!$coupon->is_active) {
                $statusInfo = [
                    'label' => 'Inactivo',
                    'badgeType' => 'error',
                ];
            } elseif ($coupon->start_date && $coupon->start_date->isFuture()) {
                $statusInfo = [
                    'label' => 'Próximo',
                    'badgeType' => 'info',
                ];
            } elseif ($coupon->end_date && $coupon->end_date->isPast()) {
                $statusInfo = [
                    'label' => 'Expirado',
                    'badgeType' => 'error',
                ];
            } elseif ($coupon->max_uses && $coupon->current_uses >= $coupon->max_uses) {
                $statusInfo = [
                    'label' => 'Agotado',
                    'badgeType' => 'warning',
                ];
            } else {
                $statusInfo = [
                    'label' => 'Activo',
                    'badgeType' => 'success',
                ];
            }
        @endphp

        {{-- Encabezado global --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}">
                <x-button-icon
                    type="outline"
                    color="dark"
                    icon="arrow-left"
                    size="sm"
                    text="Volver"
                />
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Detalles del cupón</h1>
        </div>

        @if(session('coupon_status_updated'))
            <x-alert-bordered type="success" title="Estado actualizado" class="mt-2">
                <span>{{ session('coupon_status_updated') }}</span>
            </x-alert-bordered>
        @endif

        {{-- Tarjeta principal --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 flex flex-col-2 gap-4 justify-between">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="text-base font-semibold text-gray-900">{{ $coupon->name }}</h2>
                        <x-badge-soft :type="$statusInfo['badgeType']" :text="$statusInfo['label']" />
                        @if($coupon->is_public)
                            <x-badge-soft type="info" text="Público" />
                        @else
                            <x-badge-soft type="secondary" text="Privado" />
                        @endif
                        @if($coupon->is_automatic)
                            <x-badge-soft type="success" text="Automático" />
                        @else
                            <x-badge-soft type="secondary" text="Manual" />
                        @endif
                    </div>
                    <div class="flex items-center gap-3 flex-wrap text-xs text-gray-600">
                        <span class="inline-flex items-center gap-1 font-mono bg-gray-100 px-2 py-1 rounded">
                            <i data-lucide="ticket" class="w-3 h-3"></i>
                            {{ $coupon->code }}
                        </span>
                        <span>|</span>
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            Creado el {{ $coupon->created_at->format('d/m/Y H:i') }}
                        </span>
                        <span>|</span>
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="clock" class="w-3 h-3"></i>
                            Última actualización {{ $coupon->updated_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
                
                {{-- SECTION: Toggle Switch --}}
                <form method="POST" action="{{ route('tenant.admin.coupons.toggle-status', [$store->slug, $coupon->id]) }}" class="flex items-center gap-3">
                    @csrf
                    <span class="text-sm font-medium text-gray-800 mr-2">Desactivar</span>
                        <label for="toggle-{{ $coupon->id }}" class="relative inline-block w-11 h-6 cursor-pointer">
                            <input 
                                type="checkbox" 
                                onchange="this.form.requestSubmit()"
                                id="toggle-{{ $coupon->id }}"
                                class="peer sr-only coupon-toggle"
                                {{ $coupon->is_active ? 'checked' : '' }}
                            >
                            <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                            <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                        </label>
                    <span class="text-sm font-medium text-gray-800 ml-2">Activar</span>
                </form>
                {{-- End SECTION: Toggle Switch --}}
            </div>

            <div class="p-4 md:p-6 space-y-6">
                {{-- Resumen rápido --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <p class="text-xs font-medium text-gray-500">Tipo de cupón</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">
                            {{ \App\Features\TenantAdmin\Models\Coupon::TYPES[$coupon->type] ?? ucfirst($coupon->type) }}
                        </p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <p class="text-xs font-medium text-gray-500">Valor del descuento</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">
                            {{ $coupon->discount_type === 'percentage' ? $coupon->discount_value . '%' : '$' . number_format($coupon->discount_value, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <p class="text-xs font-medium text-gray-500">Vigencia</p>
                        <p class="text-xs text-gray-900 mt-1">
                            @if($coupon->start_date)
                                Desde {{ $coupon->start_date->format('d/m/Y H:i') }}
                            @else
                                Inicia inmediatamente
                            @endif
                            <br>
                            @if($coupon->end_date)
                                Hasta {{ $coupon->end_date->format('d/m/Y H:i') }}
                            @else
                                Sin fecha fin
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Información general --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-3">
                        <h3 class="text-sm font-semibold text-gray-900">Información general</h3>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div>
                                <span class="text-xs font-medium text-gray-500">Código</span>
                                <p class="mt-1 font-mono bg-gray-100 px-2 py-1 rounded inline-block">{{ $coupon->code }}</p>
                            </div>
                            @if($coupon->description)
                                <div>
                                    <span class="text-xs font-medium text-gray-500">Descripción</span>
                                    <p class="mt-1 text-sm text-gray-700">{{ $coupon->description }}</p>
                                </div>
                            @endif
                            <div>
                                <span class="text-xs font-medium text-gray-500">Aplicación</span>
                                <p class="mt-1 text-sm text-gray-700">
                                    {{ \App\Features\TenantAdmin\Models\Coupon::TYPES[$coupon->type] ?? ucfirst($coupon->type) }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs font-medium text-gray-500">Tipo de descuento</span>
                                <p class="mt-1 text-sm text-gray-700">
                                    {{ $coupon->discount_type === 'percentage' ? 'Porcentaje' : 'Monto fijo' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-sm font-semibold text-gray-900">Restricciones</h3>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex justify-between">
                                <span class="text-xs font-medium text-gray-500">Compra mínima</span>
                                <span>{{ $coupon->min_purchase_amount ? '$' . number_format($coupon->min_purchase_amount, 0, ',', '.') : 'Sin límite' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs font-medium text-gray-500">Descuento máximo</span>
                                <span>{{ $coupon->max_discount_amount ? '$' . number_format($coupon->max_discount_amount, 0, ',', '.') : 'No aplica' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs font-medium text-gray-500">Usos totales</span>
                                <span>{{ $coupon->current_uses }}{{ $coupon->max_uses ? '/' . $coupon->max_uses : ' (ilimitado)' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs font-medium text-gray-500">Usos por cliente</span>
                                <span>{{ $coupon->uses_per_session ?? 'Ilimitado' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Restricciones horarias --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900">Restricciones horarias</h3>
                        <i data-lucide="alarm-clock" class="w-4 h-4 text-gray-500"></i>
                    </div>
                    @if(!$coupon->start_date && !$coupon->end_date && !$coupon->days_of_week && !$coupon->start_time && !$coupon->end_time)
                        <p class="text-sm text-gray-500">Sin restricciones configuradas.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm text-gray-700">
                            @if($coupon->start_date || $coupon->end_date)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                    <span class="text-xs font-medium text-gray-500">Rango de fechas</span>
                                    <p class="mt-2 text-sm text-gray-700">
                                        {{ $coupon->start_date ? $coupon->start_date->format('d/m/Y') : 'Inmediato' }}<br>
                                        {{ $coupon->end_date ? 'Hasta ' . $coupon->end_date->format('d/m/Y') : 'Sin fecha fin' }}
                                    </p>
                                </div>
                            @endif
                            @if($coupon->days_of_week)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                    <span class="text-xs font-medium text-gray-500">Días permitidos</span>
                                    <div class="mt-2 flex flex-wrap gap-1">
                                        @foreach($coupon->days_of_week as $day)
                                            <x-badge-soft type="secondary" :text="['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'][$day] ?? $day" />
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($coupon->start_time || $coupon->end_time)
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                    <span class="text-xs font-medium text-gray-500">Horario</span>
                                    <p class="mt-2 text-sm text-gray-700">
                                        {{ optional($coupon->start_time)->format('H:i') ?? '00:00' }} - {{ optional($coupon->end_time)->format('H:i') ?? '23:59' }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Aplicabilidad --}}
                @if($coupon->type !== 'global')
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900">
                                {{ $coupon->type === 'categories' ? 'Categorías aplicables' : 'Productos aplicables' }}
                            </h3>
                            <i data-lucide="list-checks" class="w-4 h-4 text-gray-500"></i>
                        </div>
                        @if($coupon->type === 'categories')
                            <div class="flex flex-wrap gap-2">
                                @forelse($coupon->categories as $category)
                                    <x-badge-soft type="info" :text="$category->name" />
                                @empty
                                    <p class="text-sm text-gray-500">Sin categorías asociadas.</p>
                                @endforelse
                            </div>
                        @else
                            <div class="space-y-2 max-h-64 overflow-y-auto pr-1">
                                @forelse($coupon->products as $product)
                                    <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-3">
                                        <span class="text-sm font-medium text-gray-800">{{ $product->name }}</span>
                                        <span class="text-xs text-gray-500">${{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Sin productos asociados.</p>
                                @endforelse
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Uso reciente --}}
                @if($recentUsage->count() > 0)
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900">Uso reciente</h3>
                            <i data-lucide="history" class="w-4 h-4 text-gray-500"></i>
                        </div>
                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left font-medium text-gray-500">Fecha</th>
                                        <th class="px-4 py-2 text-left font-medium text-gray-500">Orden</th>
                                        <th class="px-4 py-2 text-right font-medium text-gray-500">Descuento</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($recentUsage as $usage)
                                        <tr>
                                            <td class="px-4 py-2 text-gray-700">{{ $usage->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="px-4 py-2">
                                                @if($usage->order)
                                                    <a href="{{ route('tenant.admin.orders.show', [$store->slug, $usage->order]) }}" class="text-blue-600 hover:text-blue-700 font-mono">
                                                        #{{ $usage->order->id }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 font-mono">#{{ $usage->order_id ?? 'N/A' }}</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-right font-medium text-gray-800">
                                                ${{ number_format($usage->discount_amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Acciones rápidas --}}
        <x-card-base shadow="sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-center">
                <a href="{{ route('tenant.admin.coupons.edit', ['store' => $store->slug, 'coupon' => $coupon]) }}" class="inline-flex">
                    <x-button-icon
                        type="solid"
                        color="dark"
                        icon="pencil"
                        text="Editar cupón"
                    />
                </a>
                @if($coupon->current_uses == 0)
                    <div class="inline-flex">
                        <x-button-icon
                            type="outline"
                            color="error"
                            icon="trash"
                            text="Eliminar cupón"
                            html-type="button"
                            @click="openDeleteModal()"
                        />
                    </div>
                @endif
            </div>
        </x-card-base>

        {{-- SECTION: Delete Confirmation Modal --}}
        @if($coupon->current_uses == 0)
            <div
                x-show="deleteModalOpen"
                x-cloak
                style="display: none;"
                class="fixed inset-0 z-[80] overflow-y-auto"
                role="dialog"
                aria-modal="true"
                aria-labelledby="hs-modal-delete-coupon"
            >
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div
                        x-show="deleteModalOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        style="display: none;"
                        class="fixed inset-0 bg-gray-800 bg-opacity-50"
                        @click="closeDeleteModal()"
                    ></div>

                    <div
                        x-show="deleteModalOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        style="display: none;"
                        class="relative bg-white rounded-lg shadow-lg max-w-md w-full p-6"
                        @click.stop
                    >
                        <div class="flex items-center justify-between mb-4">
                            <h3 id="hs-modal-delete-coupon" class="text-lg font-semibold text-gray-800">
                                Eliminar cupón
                            </h3>
                            <button
                                type="button"
                                class="text-gray-400 hover:text-gray-600"
                                @click="closeDeleteModal()"
                                :disabled="deleteLoading"
                            >
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <div class="mb-4">
                            <div class="flex gap-4">
                                <div class="shrink-0">
                                    <div class="size-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <i data-lucide="alert-triangle" class="size-5 text-red-600"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800">
                                        Se eliminará el cupón <strong>"{{ $coupon->name }}"</strong> de forma permanente.
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        Esta acción no se puede deshacer.
                                    </p>

                                    <div x-show="deleteError" class="mt-3" x-cloak>
                                        <div class="bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4" role="alert">
                                            <div class="flex">
                                                <div class="shrink-0">
                                                    <i data-lucide="x-circle" class="shrink-0 size-4 mt-0.5"></i>
                                                </div>
                                                <div class="ms-2">
                                                    <h3 class="text-sm font-medium">
                                                        Error: <span x-text="deleteError"></span>
                                                    </h3>
                                                </div>
                                                <div class="ps-3 ms-auto">
                                                    <div class="-mx-1.5 -my-1.5">
                                                        <button
                                                            type="button"
                                                            class="inline-flex bg-red-50 rounded-lg p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:bg-red-100"
                                                            @click="deleteError = null"
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

                        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                            <button
                                type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none"
                                @click="closeDeleteModal()"
                                :disabled="deleteLoading"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                                @click="confirmDelete()"
                                :disabled="deleteLoading"
                            >
                                <span x-show="!deleteLoading">Sí, eliminar</span>
                                <span x-show="deleteLoading" class="flex items-center gap-2">
                                    <i data-lucide="loader" class="size-4 animate-spin"></i>
                                    Eliminando...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- End SECTION: Delete Confirmation Modal --}}
    </div>

    @push('scripts')
    <script>
        function couponShowData() {
            return {
                deleteModalOpen: false,
                deleteLoading: false,
                deleteError: null,
                init() {
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                },
                openDeleteModal() {
                    this.deleteError = null;
                    this.deleteModalOpen = true;
                },
                closeDeleteModal() {
                    if (!this.deleteLoading) {
                        this.deleteModalOpen = false;
                        this.deleteError = null;
                    }
                },
                async confirmDelete() {
                    this.deleteLoading = true;
                    this.deleteError = null;

                    try {
                        const response = await fetch('{{ route('tenant.admin.coupons.destroy', ['store' => $store->slug, 'coupon' => $coupon]) }}', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                        });

                        if (!response.ok) {
                            const data = await response.json().catch(() => ({}));
                            throw new Error(data.message || 'No se pudo eliminar el cupón.');
                        }

                        await response.json().catch(() => ({}));

                        window.location.href = '{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}';
                    } catch (error) {
                        this.deleteError = error.message || 'Ocurrió un error al eliminar el cupón.';
                        this.deleteLoading = false;
                    }
                }
            };
        }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 