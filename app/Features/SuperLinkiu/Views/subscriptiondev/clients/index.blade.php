@extends('shared::layouts.admin')

@section('title', 'SubscriptionDev - Clientes')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Clientes</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona tus clientes de suscripciones</p>
        </div>
        <a href="{{ route('superlinkiu.subscriptiondev.clients.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nuevo Cliente
        </a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            <p class="text-sm text-gray-500">Total</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
            <p class="text-sm text-gray-500">Activos</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $stats['with_subscriptions'] }}</p>
            <p class="text-sm text-gray-500">Con Suscripciones</p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form action="{{ route('superlinkiu.subscriptiondev.clients.index') }}" method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, email, teléfono..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
            </div>
            <select name="status" class="w-auto min-w-[130px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                <option value="">Todos</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
            </select>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i>
                Buscar
            </button>
        </form>
    </div>

    {{-- Lista --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($clients->isEmpty())
            <div class="text-center py-12">
                <i data-lucide="users" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay clientes</h3>
                <a href="{{ route('superlinkiu.subscriptiondev.clients.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nuevo Cliente
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contacto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Suscripciones</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($clients as $client)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('superlinkiu.subscriptiondev.clients.show', $client) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                        {{ $client->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if($client->email)
                                        <p>{{ $client->email }}</p>
                                    @endif
                                    @if($client->phone)
                                        <p>{{ $client->country_code }} {{ $client->phone }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm">{{ $client->subscriptions_count }} total</span>
                                    @if($client->active_subscriptions_count > 0)
                                        <span class="text-xs text-green-600">({{ $client->active_subscriptions_count }} activas)</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $client->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $client->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('superlinkiu.subscriptiondev.clients.edit', $client) }}" class="text-gray-400 hover:text-gray-600" title="Editar">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($clients->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $clients->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection
