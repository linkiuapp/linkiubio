<x-tenant-admin-layout :store="$store">

@section('title', 'Detalles del Cupón')

@section('content')
<div class="container-fluid" x-data="couponShow">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 px-6">
        <div>
            <h1 class="text-body-large font-bold text-black-400">{{ $coupon->name }}</h1>
            <p class="text-caption text-black-300">Código: <span class="font-mono bg-accent-200 px-2 py-1 rounded">{{ $coupon->code }}</span></p>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Estado -->
            @php
                $now = now();
                if (!$coupon->is_active) {
                    $statusInfo = [
                        'status' => 'inactive',
                        'text' => 'Inactivo',
                        'color' => 'text-black-300',
                        'bg' => 'bg-black-50',
                        'border' => 'border-black-200'
                    ];
                } elseif ($coupon->start_date && $coupon->start_date > $now) {
                    $statusInfo = [
                        'status' => 'upcoming',
                        'text' => 'Próximo',
                        'color' => 'text-info-200',
                        'bg' => 'bg-info-50',
                        'border' => 'border-info-100'
                    ];
                } elseif ($coupon->end_date && $coupon->end_date < $now) {
                    $statusInfo = [
                        'status' => 'expired',
                        'text' => 'Expirado',
                        'color' => 'text-error-200',
                        'bg' => 'bg-error-50',
                        'border' => 'border-error-100'
                    ];
                } elseif ($coupon->max_uses && $coupon->current_uses >= $coupon->max_uses) {
                    $statusInfo = [
                        'status' => 'exhausted',
                        'text' => 'Agotado',
                        'color' => 'text-warning-200',
                        'bg' => 'bg-warning-50',
                        'border' => 'border-warning-100'
                    ];
                } else {
                    $statusInfo = [
                        'status' => 'active',
                        'text' => 'Activo',
                        'color' => 'text-black-500',
                        'bg' => 'bg-success-50',
                        'border' => 'border-success-100'
                    ];
                }
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-caption font-bold {{ $statusInfo['bg'] }} {{ $statusInfo['color'] }} border {{ $statusInfo['border'] }}">
                {{ $statusInfo['text'] }}
            </span>
            
            <!-- Acciones -->
            <div class="flex items-center gap-2">
                <a href="{{ route('tenant.admin.coupons.edit', ['store' => $store->slug, 'coupon' => $coupon]) }}" 
                   class="btn-secondary flex items-center gap-2">
                    <x-solar-pen-outline class="w-4 h-4" />
                    Editar
                </a>
                
                <a href="{{ route('tenant.admin.coupons.index', ['store' => $store->slug]) }}" 
                   class="btn-secondary flex items-center gap-2">
                    <x-solar-arrow-left-outline class="w-4 h-4" />
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Información principal --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Información básica --}}
            <div class="bg-accent-50 rounded-lg border border-accent-200 p-6">
                <h3 class="text-body-large font-bold text-black-400 mb-4">Información del Cupón</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-caption font-bold text-black-300 mb-3">Detalles básicos</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-caption text-black-200">Nombre:</dt>
                                <dd class="text-caption font-bold text-black-400">{{ $coupon->name }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-caption text-black-200">Código:</dt>
                                <dd class="text-caption font-mono bg-accent-200 px-2 py-1 rounded">{{ $coupon->code }}</dd>
                            </div>
                            @if($coupon->description)
                                <div>
                                    <dt class="text-caption text-black-200 mb-1">Descripción:</dt>
                                    <dd class="text-caption text-black-400">{{ $coupon->description }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <div>
                        <h4 class="text-caption font-bold text-black-300 mb-3">Configuración</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-caption text-black-200">Tipo:</dt>
                                <dd class="text-caption">
                                    <span class="inline-block bg-primary-100 text-primary-300 text-xs px-2 py-1 rounded-full font-medium">
                                        {{ \App\Features\TenantAdmin\Models\Coupon::TYPES[$coupon->type] }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-caption text-black-200">Descuento:</dt>
                                <dd class="text-caption font-bold text-secondary-300">
                                    @if($coupon->discount_type === 'percentage')
                                        {{ $coupon->discount_value }}%
                                    @else
                                        ${{ number_format($coupon->discount_value, 0, ',', '.') }}
                                    @endif
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-caption text-black-200">Público:</dt>
                                <dd class="text-caption">
                                    @if($coupon->is_public)
                                        <span class="text-success-300">✓ Sí</span>
                                    @else
                                        <span class="text-error-300">✗ No</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-caption text-black-200">Automático:</dt>
                                <dd class="text-caption">
                                    @if($coupon->is_automatic)
                                        <span class="text-success-300">✓ Sí</span>
                                    @else
                                        <span class="text-error-300">✗ No</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Restricciones --}}
            <div class="bg-accent-50 rounded-lg border border-accent-200 p-6">
                <h3 class="text-body-large font-bold text-black-400 mb-4">Restricciones y Límites</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-caption font-bold text-black-300 mb-3">Límites monetarios</h4>
                        <dl class="space-y-2">
                            @if($coupon->min_purchase_amount)
                                <div class="flex justify-between">
                                    <dt class="text-caption text-black-200">Compra mínima:</dt>
                                    <dd class="text-caption font-bold text-black-400">${{ number_format($coupon->min_purchase_amount, 0, ',', '.') }}</dd>
                                </div>
                            @endif
                            @if($coupon->max_discount_amount && $coupon->discount_type === 'percentage')
                                <div class="flex justify-between">
                                    <dt class="text-caption text-black-200">Descuento máximo:</dt>
                                    <dd class="text-caption font-bold text-black-400">${{ number_format($coupon->max_discount_amount, 0, ',', '.') }}</dd>
                                </div>
                            @endif
                            @if(!$coupon->min_purchase_amount && !$coupon->max_discount_amount)
                                <p class="text-caption text-black-200">Sin restricciones monetarias</p>
                            @endif
                        </dl>
                    </div>

                    <div>
                        <h4 class="text-caption font-bold text-black-300 mb-3">Límites de uso</h4>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-caption text-black-200">Usos totales:</dt>
                                <dd class="text-caption font-bold text-black-400">
                                    {{ $coupon->current_uses }}{{ $coupon->max_uses ? '/' . $coupon->max_uses : ' (ilimitado)' }}
                                </dd>
                            </div>
                            @if($coupon->uses_per_session)
                                <div class="flex justify-between">
                                    <dt class="text-caption text-black-200">Por cliente:</dt>
                                    <dd class="text-caption font-bold text-black-400">{{ $coupon->uses_per_session }}</dd>
                                </div>
                            @endif
                            @if($coupon->max_uses)
                                @php
                                    $remaining = max(0, $coupon->max_uses - $coupon->current_uses);
                                    $percentage = round(($coupon->current_uses / $coupon->max_uses) * 100);
                                @endphp
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <dt class="text-caption text-black-200">Disponibles:</dt>
                                        <dd class="text-caption font-bold text-black-400">{{ $remaining }}</dd>
                                    </div>
                                    <div class="w-full bg-accent-200 rounded-full h-2">
                                        <div class="bg-primary-300 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Restricciones temporales --}}
            @if($coupon->start_date || $coupon->end_date || $coupon->days_of_week || $coupon->start_time || $coupon->end_time)
                <div class="bg-accent-50 rounded-lg border border-accent-200 p-6">
                    <h3 class="text-body-large font-bold text-black-400 mb-4">Restricciones Temporales</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-caption font-bold text-black-300 mb-3">Fechas</h4>
                            <dl class="space-y-2">
                                @if($coupon->start_date)
                                    <div class="flex justify-between">
                                        <dt class="text-caption text-black-200">Desde:</dt>
                                        <dd class="text-caption font-bold text-black-400">{{ $coupon->start_date->format('d/m/Y H:i') }}</dd>
                                    </div>
                                @endif
                                @if($coupon->end_date)
                                    <div class="flex justify-between">
                                        <dt class="text-caption text-black-200">Hasta:</dt>
                                        <dd class="text-caption font-bold text-black-400">{{ $coupon->end_date->format('d/m/Y H:i') }}</dd>
                                    </div>
                                @endif
                                @if(!$coupon->start_date && !$coupon->end_date)
                                    <p class="text-caption text-black-200">Sin restricciones de fecha</p>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h4 class="text-caption font-bold text-black-300 mb-3">Horarios</h4>
                            <dl class="space-y-2">
                                @if($coupon->days_of_week)
                                    <div>
                                        <dt class="text-caption text-black-200 mb-1">Días permitidos:</dt>
                                        <dd class="text-caption">
                                            @php
                                                $dayNames = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
                                                $selectedDays = collect($coupon->days_of_week)->map(fn($day) => $dayNames[$day] ?? $day);
                                            @endphp
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($selectedDays as $day)
                                                    <span class="bg-info-100 text-info-300 text-xs px-2 py-1 rounded">{{ $day }}</span>
                                                @endforeach
                                            </div>
                                        </dd>
                                    </div>
                                @endif
                                @if($coupon->start_time || $coupon->end_time)
                                    <div class="flex justify-between">
                                        <dt class="text-caption text-black-200">Horario:</dt>
                                        <dd class="text-caption font-bold text-black-400">
                                            {{ $coupon->start_time ? $coupon->start_time->format('H:i') : '00:00' }} - 
                                            {{ $coupon->end_time ? $coupon->end_time->format('H:i') : '23:59' }}
                                        </dd>
                                    </div>
                                @endif
                                @if(!$coupon->days_of_week && !$coupon->start_time && !$coupon->end_time)
                                    <p class="text-caption text-black-200">Sin restricciones horarias</p>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Aplicabilidad --}}
            @if($coupon->type !== 'global')
                <div class="bg-accent-50 rounded-lg border border-accent-200 p-6">
                    <h3 class="text-body-large font-bold text-black-400 mb-4">
                        {{ $coupon->type === 'categories' ? 'Categorías Aplicables' : 'Productos Aplicables' }}
                    </h3>
                    
                    @if($coupon->type === 'categories' && $coupon->categories->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($coupon->categories as $category)
                                <div class="bg-accent-100 border border-accent-200 rounded-lg p-3">
                                    <span class="text-caption font-bold text-black-400">{{ $category->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    @elseif($coupon->type === 'products' && $coupon->products->count() > 0)
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @foreach($coupon->products as $product)
                                <div class="bg-accent-100 border border-accent-200 rounded-lg p-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-caption font-bold text-black-400">{{ $product->name }}</span>
                                        <span class="text-caption text-black-200">${{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-caption text-black-200">
                            No hay {{ $coupon->type === 'categories' ? 'categorías' : 'productos' }} asociados a este cupón.
                        </p>
                    @endif
                </div>
            @endif

            {{-- Historial de uso reciente --}}
            @if($recentUsage->count() > 0)
                <div class="bg-accent-50 rounded-lg border border-accent-200 p-6">
                    <h3 class="text-body-large font-bold text-black-400 mb-4">Uso Reciente</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="border-b border-accent-200">
                                <tr>
                                    <th class="text-left text-caption font-bold text-black-300 py-2">Fecha</th>
                                    <th class="text-left text-caption font-bold text-black-300 py-2">Orden</th>
                                    <th class="text-right text-caption font-bold text-black-300 py-2">Descuento</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-accent-100">
                                @foreach($recentUsage as $usage)
                                    <tr>
                                        <td class="py-2 text-caption text-black-400">
                                            {{ $usage->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="py-2 text-caption text-black-400">
                                            @if($usage->order)
                                                <a href="{{ route('tenant.admin.orders.show', ['store' => $store->slug, 'order' => $usage->order]) }}" 
                                                   class="text-primary-300 hover:text-primary-200 font-mono">
                                                    #{{ $usage->order->id }}
                                                </a>
                                            @else
                                                <span class="text-black-200">#{{ $usage->order_id ?? 'N/A' }}</span>
                                            @endif
                                        </td>
                                        <td class="py-2 text-caption font-bold text-secondary-300 text-right">
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

        {{-- Sidebar con estadísticas --}}
        <div class="space-y-6">
            {{-- Estadísticas generales --}}
            <div class="bg-accent-50 rounded-lg border border-accent-200 p-6">
                <h3 class="text-body-large font-bold text-black-400 mb-4">Estadísticas</h3>
                
                <div class="space-y-4">
                    <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                        <div class="text-center">
                            <div class="text-h5 font-bold text-primary-300">{{ $stats['total_uses'] }}</div>
                            <div class="text-caption text-primary-200">Usos totales</div>
                        </div>
                    </div>

                    <div class="bg-secondary-50 border border-secondary-200 rounded-lg p-4">
                        <div class="text-center">
                            <div class="text-h5 font-bold text-secondary-300">${{ number_format($stats['total_discount_given'], 0, ',', '.') }}</div>
                            <div class="text-caption text-secondary-200">Descuento total otorgado</div>
                        </div>
                    </div>

                    <div class="bg-info-50 border border-info-200 rounded-lg p-4">
                        <div class="text-center">
                            <div class="text-h5 font-bold text-info-300">{{ $stats['orders_count'] }}</div>
                            <div class="text-caption text-info-200">Órdenes con este cupón</div>
                        </div>
                    </div>

                    @if($stats['total_uses'] > 0)
                        <div class="bg-success-50 border border-success-200 rounded-lg p-4">
                            <div class="text-center">
                                <div class="text-h5 font-bold text-success-300">${{ number_format($stats['average_discount'], 0, ',', '.') }}</div>
                                <div class="text-caption text-success-200">Descuento promedio</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Acciones rápidas --}}
            <div class="bg-accent-50 rounded-lg border border-accent-200 p-6">
                <h3 class="text-body-large font-bold text-black-400 mb-4">Acciones Rápidas</h3>
                
                <div class="space-y-3">
                    <!-- Toggle estado -->
                    <form method="POST" action="{{ route('tenant.admin.coupons.toggle-status', ['store' => $store->slug, 'coupon' => $coupon]) }}">
                        @csrf
                        <button type="submit" 
                                class="w-full btn-secondary {{ $coupon->is_active ? 'bg-warning-300 text-black-500 border-warning-200' : 'bg-success-300 text-accent-50 border-success-200' }} py-2 rounded-lg flex items-center justify-center gap-2">
                            @if($coupon->is_active)
                                <x-solar-pause-outline class="w-4 h-4" />
                                Desactivar cupón
                            @else
                                <x-solar-play-outline class="w-4 h-4" />
                                Activar cupón
                            @endif
                        </button>
                    </form>

                    <!-- Duplicar -->
                    <form method="POST" action="{{ route('tenant.admin.coupons.duplicate', ['store' => $store->slug, 'coupon' => $coupon]) }}">
                        @csrf
                        <button type="submit" 
                                class="w-full btn-secondary flex items-center justify-center gap-2">
                            <x-solar-copy-outline class="w-4 h-4" />
                            Duplicar cupón
                        </button>
                    </form>

                    <!-- Eliminar (solo si no ha sido usado) -->
                    @if($coupon->current_uses === 0)
                        <button type="button" 
                                @click="confirmDelete()"
                                class="w-full btn-primary bg-error-300 hover:bg-error-200 text-accent-50 flex items-center justify-center gap-2">
                            <x-solar-trash-bin-trash-outline class="w-4 h-4" />
                            Eliminar cupón
                        </button>
                    @endif
                </div>
            </div>

            {{-- Información adicional --}}
            <div class="bg-accent-50 rounded-lg border border-accent-200 p-6">
                <h3 class="text-body-large font-bold text-black-400 mb-4">Información</h3>
                
                <dl class="space-y-2 text-caption">
                    <div class="flex justify-between">
                        <dt class="text-black-200">Creado:</dt>
                        <dd class="text-black-400">{{ $coupon->created_at->format('d/m/Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-black-200">Actualizado:</dt>
                        <dd class="text-black-400">{{ $coupon->updated_at->format('d/m/Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-black-200">Estado:</dt>
                        <dd>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-caption font-bold {{ $statusInfo['bg'] }} {{ $statusInfo['color'] }} border {{ $statusInfo['border'] }}">
                                {{ $statusInfo['text'] }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function couponShow() {
        return {
            async confirmDelete() {
                const result = await Swal.fire({
                    title: '¿Eliminar cupón?',
                    html: '¿Estás seguro de que deseas eliminar el cupón "<strong>{{ $coupon->name }}</strong>"?<br>Esta acción no se puede deshacer.',
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
                    form.action = '{{ route('tenant.admin.coupons.destroy', ['store' => $store->slug, 'coupon' => $coupon]) }}';
                    
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