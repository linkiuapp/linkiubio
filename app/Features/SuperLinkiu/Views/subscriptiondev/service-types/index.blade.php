@extends('shared::layouts.admin')

@section('title', 'Tipos de Servicio')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Tipos de Servicio</h1>
            <p class="text-sm text-gray-600 mt-1">Configura los tipos de suscripciones disponibles</p>
        </div>
        <a href="{{ route('superlinkiu.subscriptiondev.service-types.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nuevo Tipo
        </a>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form action="{{ route('superlinkiu.subscriptiondev.service-types.index') }}" method="GET" class="flex flex-wrap gap-3">
            <select name="category" class="w-auto min-w-[150px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                <option value="">Todas las categorías</option>
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <select name="status" class="w-auto min-w-[120px] px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                <option value="">Todos</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
            </select>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg flex items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i>
                Filtrar
            </button>
        </form>
    </div>

    {{-- Lista --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        @if($serviceTypes->isEmpty())
            <div class="text-center py-12">
                <i data-lucide="tags" class="w-16 h-16 text-gray-300 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay tipos de servicio</h3>
                <p class="text-sm text-gray-500 mb-4">Crea tipos como Dominio, Hosting, SSL, etc.</p>
                <a href="{{ route('superlinkiu.subscriptiondev.service-types.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nuevo Tipo
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Base</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Suscripciones</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($serviceTypes as $type)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i data-lucide="{{ $type->category_icon }}" class="w-4 h-4 text-blue-600"></i>
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $type->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $type->category_label }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $type->formatted_price }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $type->subscriptions_count }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $type->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $type->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('superlinkiu.subscriptiondev.service-types.edit', $type) }}" class="text-gray-400 hover:text-gray-600" title="Editar">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        @if($type->subscriptions_count == 0)
                                            <form action="{{ route('superlinkiu.subscriptiondev.service-types.destroy', $type) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este tipo de servicio?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600" title="Eliminar">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($serviceTypes->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $serviceTypes->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.toast) {
        window.toast.success('¡Listo!', '{{ session('success') }}', 5000, 'bottom-center');
    }
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection
