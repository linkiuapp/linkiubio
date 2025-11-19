{{-- SECTION: Table View --}}
<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cupón
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Código
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo y descuento
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Validez
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Uso
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($coupons as $coupon)
                            {{-- ITEM: coupon#{{ $loop->index }} | id:{{ $coupon->id }} | name:{{ $coupon->name }} --}}
                            @php
                                $usagePercentage = $coupon->max_uses ? min(100, (int) round(($coupon->current_uses / $coupon->max_uses) * 100)) : null;
                                $progressColor = $usagePercentage === null
                                    ? 'info'
                                    : ($usagePercentage >= 80 ? 'red' : ($usagePercentage >= 60 ? 'yellow' : 'green'));
                                $statusBadgeType = $statusBadgeMap[$coupon->status_info['text']] ?? 'info';
                                $typeBadge = $typeBadgeMap[$coupon->type] ?? 'info';
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors" data-coupon-id="{{ $coupon->id }}">
                                {{-- SECTION: Coupon info --}}
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-2">
                                    <p class="text-sm font-semibold text-gray-900">{{ $coupon->name }}</p>
                                        @if($coupon->is_public || $coupon->is_automatic)
                                            <div class="flex flex-wrap items-center gap-2">
                                                @if($coupon->is_public)
                                                    <x-badge-soft type="info" text="Público" />
                                                @endif

                                                @if($coupon->is_automatic)
                                                    <x-badge-soft type="success" text="Automático" />
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                {{-- End SECTION: Coupon info --}}

                                {{-- SECTION: Coupon name --}}
                                <td class="px-6 py-4 align-top ">
                                    <x-badge-soft type="dark" text="Código: {{ $coupon->code }}" />
                                </td>
                                {{-- End SECTION: Coupon name --}}

                                {{-- SECTION: Coupon type --}}
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-2">
                                        <x-badge-soft
                                            :type="$typeBadge"
                                            :text="\App\Features\TenantAdmin\Models\Coupon::TYPES[$coupon->type] ?? ucfirst($coupon->type)"
                                        />
                                        <p class="text-sm text-gray-700">
                                            @if($coupon->discount_type === 'percentage')
                                                <span class="font-semibold text-gray-900">{{ $coupon->discount_value }}%</span> de descuento
                                            @else
                                                <span class="font-semibold text-gray-900">${{ number_format($coupon->discount_value, 0, ',', '.') }}</span> de descuento
                                            @endif
                                        </p>
                                        @if($coupon->min_purchase_amount)
                                            <p class="text-xs text-gray-500">Compra mínima: ${{ number_format($coupon->min_purchase_amount, 0, ',', '.') }}</p>
                                        @endif
                                    </div>
                                </td>
                                {{-- End SECTION: Coupon type --}}

                                {{-- SECTION: Coupon validity --}}
                                <td class="px-6 py-4 align-top">
                                    <div class="text-sm text-gray-700 space-y-1">
                                        @if($coupon->start_date)
                                            <p>Desde {{ $coupon->start_date->format('d/m/Y') }}</p>
                                        @endif
                                        @if($coupon->end_date)
                                            <p>Hasta {{ $coupon->end_date->format('d/m/Y') }}</p>
                                        @endif
                                        @unless($coupon->start_date || $coupon->end_date)
                                            <p>Sin límite definido</p>
                                        @endunless
                                    </div>
                                </td>
                                {{-- End SECTION: Coupon validity --}}

                                {{-- SECTION: Coupon usage --}}
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-2 text-sm text-gray-700">
                                        <p>
                                            <span class="font-semibold text-gray-900">{{ $coupon->current_uses }}</span>
                                            @if($coupon->max_uses)
                                                / {{ $coupon->max_uses }} usos
                                            @else
                                                usos ilimitados
                                            @endif
                                        </p>
                                        @if($usagePercentage !== null)
                                            <x-progress-basic :value="$usagePercentage" :color="$progressColor" />
                                            <p class="text-xs text-gray-500">{{ $usagePercentage }}% utilizado</p>
                                        @endif
                                    </div>
                                </td>
                                {{-- End SECTION: Coupon usage --}}

                                {{-- SECTION: Coupon status --}}
                                <td class="px-6 py-4 align-top">
                                    <x-badge-soft :type="$statusBadgeType" :text="$coupon->status_info['text']" />
                                </td>
                                {{-- End SECTION: Coupon status --}}

                                {{-- SECTION: Coupon actions --}}
                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- COMPONENT: TooltipTop | props:{text:Ver detalles} --}}
                                        <x-tooltip-top text="Ver detalles">
                                            <a
                                                href="{{ route('tenant.admin.coupons.show', ['store' => $store->slug, 'coupon' => $coupon]) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                aria-label="Ver detalles"
                                            >
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                        </x-tooltip-top>
                                        {{-- End COMPONENT: TooltipTop --}}

                                        {{-- COMPONENT: TooltipTop | props:{text:Editar} --}}
                                        <x-tooltip-top text="Editar">
                                            <a
                                                href="{{ route('tenant.admin.coupons.edit', ['store' => $store->slug, 'coupon' => $coupon]) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors"
                                                aria-label="Editar"
                                            >
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                        </x-tooltip-top>
                                        {{-- End COMPONENT: TooltipTop --}}

                                        {{-- COMPONENT: TooltipTop | props:{text:Toggle Estado} --}}
                                        <x-tooltip-top :text="$coupon->is_active ? 'Desactivar' : 'Activar'">
                                            <form
                                                method="POST"
                                                action="{{ route('tenant.admin.coupons.toggle-status', ['store' => $store->slug, 'coupon' => $coupon]) }}"
                                                class="inline"
                                            >
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 {{ $coupon->is_active ? 'text-yellow-600 hover:bg-yellow-50' : 'text-teal-600 hover:bg-teal-50' }} rounded-lg transition-colors"
                                                    aria-label="{{ $coupon->is_active ? 'Desactivar' : 'Activar' }}"
                                                >
                                                    <i data-lucide="{{ $coupon->is_active ? 'pause' : 'play' }}" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </x-tooltip-top>
                                        {{-- End COMPONENT: TooltipTop --}}

                                        @if($coupon->current_uses === 0)
                                            {{-- COMPONENT: TooltipTop | props:{text:Eliminar} --}}
                                            <x-tooltip-top text="Eliminar">
                                                <button
                                                    type="button"
                                                    @click.stop="deleteCoupon({
                                                        id: {{ $coupon->id }},
                                                        name: @js($coupon->name),
                                                        url: @js(route('tenant.admin.coupons.destroy', ['store' => $store->slug, 'coupon' => $coupon]))
                                                    }, $event)"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                    aria-label="Eliminar"
                                                >
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </x-tooltip-top>
                                            {{-- End COMPONENT: TooltipTop --}}
                                        @endif
                                    </div>
                                </td>
                                {{-- End SECTION: Coupon actions --}}
                            </tr>
                        @empty
                            {{-- SECTION: Empty State --}}
                            <tr>
                                <td colspan="7" class="px-6 py-12">
                                    <x-empty-state
                                        :svg="$emptyStateSvg"
                                        :title="$emptyStateTitle"
                                        :message="$emptyStateMessage"
                                    >
                                        <x-slot name="action">
                                            @if(request()->hasAny(['search', 'status', 'type', 'discount_type']))
                                                <a href="{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}">
                                                    <x-button-icon
                                                        type="solid"
                                                        color="info"
                                                        size="md"
                                                        icon="rotate-ccw"
                                                        text="Limpiar filtros"
                                                    />
                                                </a>
                                            @elseif($remainingSlots > 0)
                                                <a href="{{ route('tenant.admin.coupons.create', ['store' => $store->slug]) }}">
                                                    <x-button-icon
                                                        type="solid"
                                                        color="info"
                                                        size="md"
                                                        icon="plus-circle"
                                                        text="Crear primer cupón"
                                                    />
                                                </a>
                                            @endif
                                        </x-slot>
                                    </x-empty-state>
                                </td>
                            </tr>
                            {{-- End SECTION: Empty State --}}
                        @endforelse

                        {{-- SECTION: Dynamic Empty State (hidden initially) --}}
                        <tr id="coupons-empty-state" class="hidden">
                            <td colspan="6" class="px-6 py-12">
                                <x-empty-state
                                    :svg="$emptyStateSvg"
                                    :title="$emptyStateTitle"
                                    :message="$emptyStateMessage"
                                >
                                    <x-slot name="action">
                                        @if(request()->hasAny(['search', 'status', 'type', 'discount_type']))
                                            <a href="{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}">
                                                <x-button-icon type="solid" color="info" size="md" icon="rotate-ccw" text="Limpiar filtros" />
                                            </a>
                                        @elseif($remainingSlots > 0)
                                            <a href="{{ route('tenant.admin.coupons.create', ['store' => $store->slug]) }}">
                                                <x-button-icon type="solid" color="info" size="md" icon="plus-circle" text="Crear primer cupón" />
                                            </a>
                                        @endif
                                    </x-slot>
                                </x-empty-state>
                            </td>
                        </tr>
                        {{-- End SECTION: Dynamic Empty State --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- End SECTION: Table View --}}

