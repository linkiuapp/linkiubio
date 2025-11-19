{{--
LatestStoresTableWidget - Tabla de últimas tiendas creadas
Uso: Mostrar las últimas tiendas registradas en el sistema
Cuándo usar: Dashboards de Super Admin
Cuándo NO usar: Cuando no hay tiendas o se necesita otra vista
Ejemplo: <x-latest-stores-table-widget :stores="$latestStores" :viewAllUrl="route('stores.index')" />
--}}

@props([
    'title' => 'Últimas Tiendas Creadas',
    'stores' => [],
    'viewAllUrl' => '#',
])

<div class="bg-white rounded-lg shadow-sm p-5">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-0 flex items-center gap-2">
            <i data-lucide="store" class="w-5 h-5 text-primary-400"></i>
            {{ $title }}
        </h3>
        <a href="{{ $viewAllUrl }}" 
           class="text-sm font-medium text-primary-400 hover:text-primary-500 transition-colors">
            Ver todas →
        </a>
    </div>
    
    @if(count($stores) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Tienda
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Plan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($stores as $store)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm">
                                    @if($store->logo_url)
                                        <div class="relative hidden w-10 h-10 mr-3 rounded-full md:block">
                                            <img class="object-cover w-full h-full rounded-full"
                                                src="{{ $store->logo_url }}"
                                                alt="{{ $store->name }}"
                                                loading="lazy" />
                                        </div>
                                    @else
                                        <div class="w-10 h-10 mr-3 rounded-full bg-primary-100 flex items-center justify-center">
                                            <span class="text-primary-400 font-semibold text-xs">
                                                {{ strtoupper(substr($store->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $store->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $store->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge-soft type="info" :text="$store->plan->name ?? 'Sin plan'" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($store->status === 'active')
                                    <x-badge-soft type="success" text="Activa" />
                                @elseif($store->status === 'inactive')
                                    <x-badge-soft type="warning" text="Inactiva" />
                                @else
                                    <x-badge-soft type="error" text="Suspendida" />
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $store->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('superlinkiu.stores.show', $store) }}"
                                        class="bg-primary-50 hover:bg-primary-100 text-primary-600 px-3 py-2 rounded-lg transition-colors" 
                                        title="Ver detalles">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('superlinkiu.stores.edit', $store) }}"
                                        class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-2 rounded-lg transition-colors"
                                        title="Editar">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <button onclick="loginAsStore({{ $store->id }})"
                                        class="bg-green-50 hover:bg-green-100 text-green-600 px-3 py-2 rounded-lg transition-colors"
                                        title="Entrar como admin">
                                        <i data-lucide="log-in" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <i data-lucide="store" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
            <p class="text-sm text-gray-500">No hay tiendas registradas aún</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush

