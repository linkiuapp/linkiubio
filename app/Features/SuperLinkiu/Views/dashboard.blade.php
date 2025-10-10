@extends('shared::layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Header con título y botón de acción -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-lg font-bold text-black-400">Dashboard</h1>
        <a href="{{ route('superlinkiu.stores.create') }}" class="btn-primary px-4 py-2 rounded-lg flex items-center gap-2">
            <x-solar-add-circle-outline class="w-5 h-5" />
            Nueva Tienda
        </a>
    </div>

    <!-- Widgets de estadísticas principales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Tiendas -->
        <div class="border border-accent-100 rounded-lg h-full bg-gradient-to-r from-primary-100 to-accent-100">
            <div class="p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-semibold text-black-300 mb-1">Total Tiendas</p>
                        <h6 class="text-xl font-black mb-0 text-black-400">{{ number_format($stats['total_stores']) }}</h6>
                    </div>
                    <div class="w-[48px] h-[48px] bg-primary-200 rounded-full flex justify-center items-center">
                        <x-solar-shop-2-outline class="text-accent-50 w-6 h-6" />
                    </div>
                </div>
                <p class="font-medium text-sm text-black-300 mt-3 mb-0">
                    Total de tiendas registradas
                </p>
            </div>
        </div>

        <!-- Tiendas Activas -->
        <div class="border border-accent-100 rounded-lg h-full bg-gradient-to-r from-success-100 to-accent-100">
            <div class="p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-semibold text-black-300 mb-1">Tiendas Activas</p>
                        <h6 class="text-xl font-black mb-0 text-black-400">{{ number_format($stats['active_stores']) }}</h6>
                    </div>
                    <div class="w-[48px] h-[48px] bg-success-200 rounded-full flex justify-center items-center">
                        <x-solar-check-circle-outline class="text-accent-50 w-6 h-6" />
                    </div>
                </div>
                <p class="font-medium text-sm text-black-300 mt-3 mb-0 flex items-center gap-2">
                    <span class="badge-soft-success">{{ $stats['active_percentage'] }}%</span>
                    del total
                </p>
            </div>
        </div>

        <!-- Tiendas Verificadas -->
        <div class="border border-accent-100 rounded-lg h-full bg-gradient-to-r from-info-100 to-accent-100">
            <div class="p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-semibold text-black-300 mb-1">Verificadas</p>
                        <h6 class="text-xl font-black mb-0 text-black-400">{{ number_format($stats['verified_stores']) }}</h6>
                    </div>
                    <div class="w-[48px] h-[48px] bg-info-200 rounded-full flex justify-center items-center">
                        <x-solar-shield-check-outline class="text-accent-50 w-6 h-6" />
                    </div>
                </div>
                <p class="font-medium text-sm text-black-300 mt-3 mb-0">
                    Con documentación verificada
                </p>
            </div>
        </div>

        <!-- Ingresos del Mes -->
        <div class="border border-accent-100 rounded-lg h-full bg-gradient-to-r from-secondary-100 to-accent-100">
            <div class="p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-semibold text-black-300 mb-1">Ingresos del Mes</p>
                        <h6 class="text-xl font-black mb-0 text-black-400">${{ number_format($monthlyRevenue, 0, ',', '.') }}</h6>
                    </div>
                    <div class="w-[48px] h-[48px] bg-secondary-200 rounded-full flex justify-center items-center">
                        <x-solar-wallet-outline class="text-accent-50 w-6 h-6" />
                    </div>
                </div>
                <p class="font-medium text-sm text-black-300 mt-3 mb-0 flex items-center gap-2">
                    @if($revenueGrowth > 0)
                        <span class="badge-soft-success flex items-center gap-1">
                            <x-solar-arrow-up-outline class="w-3 h-3" />
                            +{{ $revenueGrowth }}%
                        </span>
                    @else
                        <span class="badge-soft-error flex items-center gap-1">
                            <x-solar-arrow-down-outline class="w-3 h-3" />
                            {{ $revenueGrowth }}%
                        </span>
                    @endif
                    vs mes anterior
                </p>
            </div>
        </div>
    </div>

    <!-- ✅ Widget de Solicitudes Pendientes -->
    @if($pendingStats['total'] > 0)
    <div class="mb-6">
        <div class="border border-accent-100 rounded-lg bg-gradient-to-r from-warning-100 via-accent-50 to-accent-100 overflow-hidden relative">
            <!-- Badge flotante con prioridad -->
            @if($pendingStats['critical'] > 0)
            <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">
                🚨 {{ $pendingStats['critical'] }} CRÍTICA(S)
            </div>
            @elseif($pendingStats['urgent'] > 0)
            <div class="absolute top-4 right-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                ⚠️ {{ $pendingStats['urgent'] }} URGENTE(S)
            </div>
            @endif
            
            <div class="p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-black-400 mb-2 flex items-center gap-2">
                            <span class="w-10 h-10 bg-warning-200 rounded-full flex items-center justify-center">
                                <x-solar-document-add-outline class="w-5 h-5 text-warning-500" />
                            </span>
                            Solicitudes de Tiendas Pendientes
                        </h3>
                        <p class="text-sm text-black-300">
                            {{ $pendingStats['total'] }} solicitud(es) esperando revisión
                            @if($pendingStats['oldest'])
                                • La más antigua: <strong>{{ $pendingStats['oldest']->created_at->diffForHumans() }}</strong>
                            @endif
                        </p>
                    </div>
                </div>
                
                <!-- Estadísticas en grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Total Pendientes -->
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-black-300 mb-1">Total Pendientes</p>
                                <p class="text-3xl font-bold text-warning-500">{{ $pendingStats['total'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-warning-100 rounded-full flex items-center justify-center">
                                <x-solar-clock-circle-outline class="w-6 h-6 text-warning-500" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Críticas (>24h) -->
                    <div class="bg-white rounded-lg p-4 shadow-sm @if($pendingStats['critical'] > 0) ring-2 ring-red-300 @endif">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-black-300 mb-1">Críticas (>24h)</p>
                                <p class="text-3xl font-bold text-red-500">{{ $pendingStats['critical'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <x-solar-danger-triangle-outline class="w-6 h-6 text-red-500" />
                            </div>
                        </div>
                        @if($pendingStats['critical'] > 0)
                        <p class="text-xs text-red-600 mt-2 font-semibold">⚠️ Requiere atención inmediata</p>
                        @endif
                    </div>
                    
                    <!-- Urgentes (>6h) -->
                    <div class="bg-white rounded-lg p-4 shadow-sm @if($pendingStats['urgent'] > 0) ring-2 ring-orange-300 @endif">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-black-300 mb-1">Urgentes (>6h)</p>
                                <p class="text-3xl font-bold text-orange-500">{{ $pendingStats['urgent'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                                <x-solar-alarm-outline class="w-6 h-6 text-orange-500" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tiempo Promedio -->
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-black-300 mb-1">Tiempo Promedio</p>
                                <p class="text-3xl font-bold text-blue-500">{{ $pendingStats['avg_hours'] }}h</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <x-solar-hourglass-outline class="w-6 h-6 text-blue-500" />
                            </div>
                        </div>
                        <p class="text-xs text-black-300 mt-2">
                            @if($pendingStats['avg_hours'] > 6)
                                <span class="text-orange-600 font-semibold">⚠️ Por encima del objetivo (6h)</span>
                            @else
                                <span class="text-green-600 font-semibold">✓ Dentro del objetivo (6h)</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <!-- Botones de acción -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('superlinkiu.store-requests.index') }}" 
                       class="btn-primary px-6 py-3 rounded-lg flex items-center gap-2 font-semibold">
                        <x-solar-document-text-outline class="w-5 h-5" />
                        Revisar Solicitudes ({{ $pendingStats['total'] }})
                    </a>
                    
                    @if($pendingStats['critical'] > 0)
                    <a href="{{ route('superlinkiu.store-requests.index', ['tab' => 'pending']) }}" 
                       class="btn bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg flex items-center gap-2 font-semibold animate-pulse">
                        <x-solar-danger-triangle-outline class="w-5 h-5" />
                        Atender Críticas ({{ $pendingStats['critical'] }})
                    </a>
                    @endif
                    
                    <button onclick="window.location.reload()" 
                            class="btn-outline-secondary px-4 py-3 rounded-lg flex items-center gap-2">
                        <x-solar-refresh-outline class="w-4 h-4" />
                        Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Alertas de Monitoreo -->
    @if(count($alerts) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            @foreach($alerts as $alert)
                <div class="alert-{{ $alert['type'] }}">
                    <div class="flex items-start gap-3 flex-1">
                        <x-dynamic-component :component="'solar-' . str_replace('solar-', '', $alert['icon'])" class="w-6 h-6 shrink-0 mt-1" />
                        <div class="flex-1">
                            <h4 class="font-semibold mb-1">{{ $alert['title'] }}</h4>
                            <p class="text-sm font-normal opacity-90">{{ $alert['message'] }}</p>
                            
                            @if(isset($alert['items']))
                                <ul class="mt-2 space-y-1">
                                    @foreach($alert['items'] as $item)
                                        <li class="text-sm font-normal opacity-80">
                                            • {{ $item['store'] }} - Plan {{ $item['plan'] }} ({{ $item['days'] }} días)
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            
                            @if(isset($alert['action']))
                                <a href="{{ $alert['action'] }}" class="text-sm font-semibold mt-2 inline-block underline">
                                    Ver detalles →
                                </a>
                            @endif
                        </div>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <x-solar-close-circle-outline class="w-5 h-5" />
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Gráfico de Crecimiento Mensual -->
        <div class="card">
            <div class="card-header">
                <h2 class="title-card">Crecimiento Mensual</h2>
            </div>
            <div class="card-body">
                <canvas id="growthChart" height="300"></canvas>
            </div>
        </div>

        <!-- Gráfico de Distribución por Plan -->
        <div class="card">
            <div class="card-header">
                <h2 class="title-card">Distribución por Plan</h2>
            </div>
            <div class="card-body">
                <canvas id="planChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabla de Últimas Tiendas -->
    <div class="card">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h2 class="title-card">Últimas Tiendas Creadas</h2>
                <a href="{{ route('superlinkiu.stores.index') }}" class="text-primary-200 hover:text-primary-300 text-sm font-semibold">
                    Ver todas →
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-black-300 uppercase border-b border-accent-100 bg-accent-50">
                        <th class="px-6 py-3">Tienda</th>
                        <th class="px-6 py-3">Plan</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Fecha</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-accent-50 divide-y divide-accent-100">
                    @forelse($latestStores as $store)
                        <tr class="text-black-400">
                            <td class="px-6 py-4">
                                <div class="flex items-center text-sm">
                                    @if($store->logo_url)
                                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                            <img class="object-cover w-full h-full rounded-full"
                                                src="{{ $store->logo_url }}"
                                                alt="{{ $store->name }}"
                                                loading="lazy" />
                                        </div>
                                    @else
                                        <div class="w-8 h-8 mr-3 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-primary-300 font-semibold text-xs">
                                                {{ substr($store->name, 0, 2) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold">{{ $store->name }}</p>
                                        <p class="text-xs text-black-200">{{ $store->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="badge-soft-primary">{{ $store->plan->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($store->status === 'active')
                                    <span class="badge-soft-success">Activa</span>
                                @elseif($store->status === 'inactive')
                                    <span class="badge-soft-warning">Inactiva</span>
                                @else
                                    <span class="badge-soft-error">Suspendida</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-black-200">
                                {{ $store->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3 text-sm">
                                    <a href="{{ route('superlinkiu.stores.show', $store) }}"
                                        class="bg-primary-50 hover:bg-primary-200 hover:text-primary-50 text-primary-300 px-2 py-2 rounded-lg" 
                                        title="Ver detalles">
                                        <x-solar-eye-outline class="w-5 h-5" />
                                    </a>
                                    <a href="{{ route('superlinkiu.stores.edit', $store) }}"
                                        class="bg-info-50 hover:bg-info-200 hover:text-info-50 text-info-300 px-2 py-2 rounded-lg"
                                        title="Editar">
                                        <x-solar-pen-2-outline class="w-5 h-5" />
                                    </a>
                                    <button onclick="loginAsStore({{ $store->id }})"
                                        class="bg-success-50 hover:bg-success-100 text-success-300 px-2 py-2 rounded-lg"
                                        title="Entrar como admin">
                                        <x-solar-login-3-outline class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-black-200">
                                No hay tiendas registradas aún
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuración de colores según el diseño
    const colors = {
        primary: '#7432F8',
        secondary: '#FD6905',
        success: '#00DF7F',
        info: '#191CD9',
        warning: '#FFC300',
        error: '#F60F21'
    };

    // Gráfico de Crecimiento Mensual
    const growthCtx = document.getElementById('growthChart').getContext('2d');
    new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($monthlyGrowth, 'month')) !!},
            datasets: [{
                label: 'Tiendas Nuevas',
                data: {!! json_encode(array_column($monthlyGrowth, 'count')) !!},
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.primary,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#E8F2FC',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6D6D71',
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6D6D71',
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });

    // Gráfico de Distribución por Plan
    const planCtx = document.getElementById('planChart').getContext('2d');
    const planData = {!! json_encode($storesByPlan) !!};
    
    new Chart(planCtx, {
        type: 'doughnut',
        data: {
            labels: planData.map(item => item.plan),
            datasets: [{
                data: planData.map(item => item.total),
                backgroundColor: planData.map(item => item.color),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        color: '#2E2E34',
                        font: {
                            size: 14
                        },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Función para login como admin de tienda
    function loginAsStore(storeId) {
        if (confirm('¿Deseas entrar como administrador de esta tienda?')) {
            // Implementar lógica de login as
            console.log('Login as store:', storeId);
            // window.location.href = `/superlinkiu/stores/${storeId}/login-as`;
        }
    }
</script>
@endpush
@endsection  