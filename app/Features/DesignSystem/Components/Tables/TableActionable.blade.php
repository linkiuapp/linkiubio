{{--
Tabla Accionable - Tabla con acciones, checkboxes y contenido flexible
Uso: Tabla para listados con acciones (ver, editar, eliminar), checkboxes y estados
Cuándo usar: CRUDs, listados de administración, tablas con múltiples acciones
Cuándo NO usar: Tablas simples sin acciones o interacciones
Ejemplo: 
<x-table-actionable :headers="['Nombre', 'Estado']" :items="$items">
    <x-slot:rows>
        <td>Contenido de la fila</td>
    </x-slot:rows>
</x-table-actionable>
--}}

@props([
    'headers' => [],
    'items' => [],
    'emptyMessage' => 'No hay elementos',
    'emptyIcon' => 'package',
    'showCheckbox' => false,
    'checkboxColumn' => true,
])

<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @if($checkboxColumn)
                                <th scope="col" class="px-6 py-3 text-left">
                                    @if($showCheckbox)
                                        <input 
                                            type="checkbox" 
                                            id="selectAll" 
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                        >
                                    @endif
                                </th>
                            @endif
                            @foreach($headers as $header)
                                <th 
                                    scope="col" 
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($items as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                @if($checkboxColumn)
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($showCheckbox)
                                            <input 
                                                type="checkbox" 
                                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                                value="{{ $item->id ?? $loop->index }}"
                                            >
                                        @endif
                                    </td>
                                @endif
                                @if(isset($rows))
                                    {{ $rows }}
                                @else
                                    {{ $slot }}
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td 
                                    colspan="{{ count($headers) + ($checkboxColumn ? 1 : 0) }}" 
                                    class="px-6 py-12 text-center"
                                >
                                    <div class="flex flex-col items-center">
                                        <i 
                                            data-lucide="{{ $emptyIcon }}" 
                                            class="w-12 h-12 text-gray-400 mb-3"
                                        ></i>
                                        <p class="text-sm text-gray-500">{{ $emptyMessage }}</p>
                                        @if(isset($emptyAction))
                                            {{ $emptyAction }}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush

