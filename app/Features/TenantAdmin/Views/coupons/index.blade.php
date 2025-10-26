<x-tenant-admin-layout :store="$store">
    @section('title', 'Cupones')

    @section('content')
    <div x-data="couponManagement" class="space-y-4">
        <!-- Header con contador y botón crear -->
        <div class="bg-accent-50 rounded-lg p-0 overflow-hidden">
            <div class="border-b border-accent-100 bg-accent-50 py-4 px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-body-large font-semibold text-black-500 mb-2">Cupones</h2>
                        <p class="text-caption text-black-300">
                            Usando {{ $currentCount }} de {{ $maxCoupons }} cupones disponibles en tu plan {{ $store->plan->name }}
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($remainingSlots > 0)
                            <a href="{{ route('tenant.admin.coupons.create', ['store' => $store->slug]) }}" 
                               class="btn-primary flex items-center gap-2">
                                <x-solar-add-circle-outline class="w-5 h-5" />
                                Nuevo Cupón
                            </a>
                        @else
                            <button class="btn-secondary opacity-50 cursor-not-allowed flex items-center gap-2 text-caption font-bold text-accent-50 hover:bg-secondary-300" disabled>
                                <x-solar-add-circle-outline class="w-5 h-5" />
                                Límite Alcanzado
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Barra de herramientas -->
            <div class="px-6 py-3 border-b border-accent-100 bg-accent-50">
                <form method="GET" class="flex flex-wrap items-center gap-4 text-caption font-bold text-black-300">
                    <!-- Búsqueda -->
                    <div class="flex-1 min-w-64">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Buscar por nombre o código..."
                               class="w-full px-3 py-1.5 border border-accent-200 rounded-lg text-caption font-bold text-black-300 focus:outline-none focus:ring-2 focus:ring-primary-200">
                    </div>

                    <!-- Filtros -->
                    <select name="status" class="px-3 py-1.5 border border-accent-200 rounded-lg text-caption font-bold text-black-300 focus:outline-none">
                        <option value="">Todos los estados</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expirados</option>
                        <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Próximos</option>
                    </select>

                    <select name="type" class="px-3 py-1.5 border border-accent-200 rounded-lg text-caption font-bold text-black-300 focus:outline-none">
                        <option value="">Todos los tipos</option>
                        @foreach(\App\Features\TenantAdmin\Models\Coupon::TYPES as $key => $label)
                            <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>

                    <select name="discount_type" class="px-3 py-1.5 border border-accent-200 rounded-lg text-caption font-bold text-black-300 focus:outline-none">
                        <option value="">Todos los descuentos</option>
                        @foreach(\App\Features\TenantAdmin\Models\Coupon::DISCOUNT_TYPES as $key => $label)
                            <option value="{{ $key }}" {{ request('discount_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>

                    <!-- Botones -->
                    <button type="submit" class="btn-secondary px-4 py-1.5 text-caption font-bold text-accent-50 hover:bg-secondary-300">Filtrar</button>
                    <a href="{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}" 
                       class="btn-secondary px-4 py-1.5 text-caption font-bold text-accent-50 hover:bg-secondary-300">Limpiar</a>
                </form>
            </div>

            <!-- Contenido principal -->
            <div class="p-6">
                @if($coupons->count() > 0)
                    <!-- Tabla de cupones -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-caption font-bold text-black-300">
                            <thead class="border-b border-accent-200">
                                <tr>
                                    <th class="px-0 py-3 text-left text-caption font-bold text-black-300 uppercase tracking-wider">Cupón</th>
                                    <th class="px-4 py-3 text-left text-caption font-bold text-black-300 uppercase tracking-wider">Tipo & Descuento</th>
                                    <th class="px-4 py-3 text-left text-caption font-bold text-black-300 uppercase tracking-wider">Validez</th>
                                    <th class="px-4 py-3 text-left text-caption font-bold text-black-300 uppercase tracking-wider">Uso</th>
                                    <th class="px-4 py-3 text-left text-caption font-bold text-black-300 uppercase tracking-wider">Estado</th>
                                    <th class="px-4 py-3 text-center text-caption font-bold text-black-300 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-accent-100">
                                @foreach($coupons as $coupon)
                                    <tr class="hover:bg-accent-100 transition-colors">
                                        {{-- Información del cupón --}}
                                        <td class="px-4 py-4">
                                            <div>
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="text-body-regular font-bold text-black-500">{{ $coupon->name }}</span>
                                                    @if($coupon->is_public)
                                                        <x-solar-eye-outline class="w-5 h-5 text-info-200" title="Público" />
                                                    @endif
                                                    @if($coupon->is_automatic)
                                                        <x-solar-magic-stick-outline class="w-5 h-5 text-secondary-200" title="Automático" />
                                                    @endif
                                                </div>
                                                <div class="font-bold text-black-300">
                                                    <span class="text-caption font-bold text-black-500 bg-accent-200 px-2 py-1 rounded">{{ $coupon->code }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Tipo y descuento --}}
                                        <td class="px-4 py-4">
                                            <div>
                                                <span class="inline-block bg-primary-50 text-primary-200 text-caption font-bold px-2 py-1 rounded-full mb-1">
                                                    {{ \App\Features\TenantAdmin\Models\Coupon::TYPES[$coupon->type] }}
                                                </span>
                                                <div class="text-caption font-bold text-black-300">
                                                    @if($coupon->discount_type === 'percentage')
                                                        <span class="text-secondary-200">{{ $coupon->discount_value }}%</span>
                                                    @else
                                                        <span class="text-secondary-200">${{ number_format($coupon->discount_value, 0, ',', '.') }}</span>
                                                    @endif
                                                    <span class="text-black-300">descuento</span>
                                                </div>
                                                @if($coupon->min_purchase_amount)
                                                    <div class="text-caption font-bold text-black-300">
                                                        Mín: ${{ number_format($coupon->min_purchase_amount, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Validez --}}
                                        <td class="px-4 py-4">
                                            <div class="text-caption font-bold text-black-300">
                                                @if($coupon->start_date || $coupon->end_date)
                                                    @if($coupon->start_date)
                                                        <div class="text-black-300">
                                                            Desde: {{ $coupon->start_date->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                    @if($coupon->end_date)
                                                        <div class="text-black-300">
                                                            Hasta: {{ $coupon->end_date->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="text-caption font-bold text-black-300">Sin límite</span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Uso --}}
                                        <td class="px-4 py-4">
                                            <div class="text-caption font-bold text-black-300">
                                                <div class="text-caption font-bold text-black-300">
                                                    {{ $coupon->current_uses }}{{ $coupon->max_uses ? '/' . $coupon->max_uses : '' }}
                                                </div>
                                                @if($coupon->max_uses)
                                                    @php
                                                        $percentage = round(($coupon->current_uses / $coupon->max_uses) * 100);
                                                        $colorClass = $percentage >= 80 ? 'bg-error-100' : ($percentage >= 60 ? 'bg-warning-100' : 'bg-success-100');
                                                    @endphp
                                                    <div class="w-full bg-accent-200 rounded-full h-1 mt-1">
                                                        <div class="{{ $colorClass }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                    <span class="text-caption font-bold text-black-300">{{ $percentage }}% usado</span>
                                                @else
                                                    <span class="text-caption font-bold text-black-300">Ilimitado</span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Estado --}}
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-caption font-bold {{ $coupon->status_info['bg'] }} {{ $coupon->status_info['color'] }} border {{ $coupon->status_info['border'] }}">
                                                {{ $coupon->status_info['text'] }}
                                            </span>
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center gap-4">
                                                <!-- Ver -->
                                                <a href="{{ route('tenant.admin.coupons.show', ['store' => $store->slug, 'coupon' => $coupon]) }}" 
                                                   class="text-info-300 hover:text-info-400 transition-colors" title="Ver detalles">
                                                    <x-solar-eye-outline class="w-5 h-5" />
                                                </a>

                                                <!-- Editar -->
                                                <a href="{{ route('tenant.admin.coupons.edit', ['store' => $store->slug, 'coupon' => $coupon]) }}" 
                                                   class="text-secondary-300 hover:text-secondary-400 transition-colors" title="Editar">
                                                    <x-solar-pen-outline class="w-5 h-5" />
                                                </a>

                                                <!-- Toggle Estado -->
                                                <form method="POST" action="{{ route('tenant.admin.coupons.toggle-status', ['store' => $store->slug, 'coupon' => $coupon]) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="{{ $coupon->is_active ? 'text-warning-300 hover:text-warning-400' : 'text-success-300 hover:text-success-400' }} transition-colors" 
                                                            title="{{ $coupon->is_active ? 'Desactivar' : 'Activar' }}">
                                                        @if($coupon->is_active)
                                                            <x-solar-pause-outline class="w-5 h-5" />
                                                        @else
                                                            <x-solar-play-outline class="w-5 h-5" />
                                                        @endif
                                                    </button>
                                                </form>

                                                <!-- Eliminar -->
                                                @if($coupon->current_uses === 0)
                                                    <button @click="confirmDelete({{ $coupon->id }}, '{{ $coupon->name }}')"
                                                            class="text-error-200 hover:text-error-100 transition-colors" 
                                                            title="Eliminar">
                                                        <x-solar-trash-bin-trash-outline class="w-5 h-5" />
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Paginación --}}
                    @if($coupons->hasPages())
                        <div class="mt-6 pt-4 border-t border-accent-200">
                            {{ $coupons->links() }}
                        </div>
                    @endif
                @else
                    {{-- Estado vacío --}}
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-secondary-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-solar-ticket-outline class="w-8 h-8 text-secondary-200" />
                        </div>
                        <h3 class="text-lg font-semibold text-black-500 mb-2">No hay cupones</h3>
                        @if(request()->hasAny(['search', 'status', 'type', 'discount_type']))
                            <p class="text-black-300 text-sm mb-4">No se encontraron cupones con los filtros aplicados</p>
                            <a href="{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}" 
                               class="btn-secondary">
                                Limpiar filtros
                            </a>
                        @else
                            <p class="text-black-300 text-sm mb-4">Crea tu primer cupón para ofrecer descuentos a tus clientes</p>
                            @if($remainingSlots > 0)
                                <a href="{{ route('tenant.admin.coupons.create', ['store' => $store->slug]) }}" 
                                   class="btn-primary">
                                    Crear primer cupón
                                </a>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        function couponManagement() {
            return {
                async confirmDelete(couponId, couponName) {
                    const result = await Swal.fire({
                        title: '¿Eliminar cupón?',
                        html: `¿Estás seguro de que deseas eliminar el cupón "<strong>${couponName}</strong>"?<br>Esta acción no se puede deshacer.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ed2e45',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: '✓ Eliminar',
                        cancelButtonText: 'Cancelar'
                    });
                    
                    if (result.isConfirmed) {
                        // Crear formulario dinámico para eliminar
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}/${couponId}`;
                        
                        // CSRF Token
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';
                        form.appendChild(csrfInput);
                        
                        // Method DELETE
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);
                        
                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            }
        }
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout> 