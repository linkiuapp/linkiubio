{{--
Table With Pagination - Tabla con paginación y búsqueda
Uso: Tabla con funcionalidad de búsqueda y paginación
Cuándo usar: Cuando necesites tablas grandes con búsqueda y paginación
Cuándo NO usar: Cuando las tablas sean pequeñas y no requieran estas funcionalidades
Ejemplo: <x-table-with-pagination :headers="['Nombre', 'Edad', 'Dirección']" :rows="[['John', 45, 'New York']]" />
--}}

@props([
    'headers' => [],
    'rows' => [],
    'searchPlaceholder' => 'Buscar elementos',
    'showCheckboxes' => false,
])

<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="border border-gray-200 rounded-lg divide-y divide-gray-200">
                {{-- Search --}}
                <div class="py-3 px-4">
                    <div class="relative max-w-xs">
                        <label class="sr-only">Buscar</label>
                        <input 
                            type="text" 
                            name="hs-table-with-pagination-search" 
                            id="hs-table-with-pagination-search" 
                            class="py-1.5 sm:py-2 px-3 ps-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" 
                            placeholder="{{ $searchPlaceholder }}"
                        >
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                            <i data-lucide="search" class="size-4 text-gray-400" x-init="lucide.createIcons()"></i>
                        </div>
                    </div>
                </div>
                
                {{-- Table --}}
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @if($showCheckboxes)
                                    <th scope="col" class="py-3 px-4 pe-0">
                                        <div class="flex items-center h-5">
                                            <input 
                                                id="hs-table-pagination-checkbox-all" 
                                                type="checkbox" 
                                                class="border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500"
                                            >
                                            <label for="hs-table-pagination-checkbox-all" class="sr-only">Checkbox</label>
                                        </div>
                                    </th>
                                @endif
                                @foreach($headers as $header)
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                        {{ $header }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($rows as $index => $row)
                                <tr>
                                    @if($showCheckboxes)
                                        <td class="py-3 ps-4">
                                            <div class="flex items-center h-5">
                                                <input 
                                                    id="hs-table-pagination-checkbox-{{ $index + 1 }}" 
                                                    type="checkbox" 
                                                    class="border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500"
                                                >
                                                <label for="hs-table-pagination-checkbox-{{ $index + 1 }}" class="sr-only">Checkbox</label>
                                            </div>
                                        </td>
                                    @endif
                                    @foreach($row as $cellIndex => $cell)
                                        @if($cellIndex === count($row) - 1 && $cell === '')
                                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">Eliminar</button>
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                {{ $cell }}
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                <div class="py-1 px-4">
                    <nav class="flex items-center space-x-1" aria-label="Paginación">
                        <button 
                            type="button" 
                            class="p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" 
                            aria-label="Anterior"
                        >
                            <span aria-hidden="true">«</span>
                            <span class="sr-only">Anterior</span>
                        </button>
                        <button 
                            type="button" 
                            class="min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none" 
                            aria-current="page"
                        >
                            1
                        </button>
                        <button 
                            type="button" 
                            class="min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none"
                        >
                            2
                        </button>
                        <button 
                            type="button" 
                            class="min-w-10 flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none"
                        >
                            3
                        </button>
                        <button 
                            type="button" 
                            class="p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" 
                            aria-label="Siguiente"
                        >
                            <span class="sr-only">Siguiente</span>
                            <span aria-hidden="true">»</span>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

