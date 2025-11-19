{{--
Table Hoverable - Tabla con filas hover
Uso: Tabla con efecto hover en las filas
Cuándo usar: Cuando quieras mejorar la UX mostrando qué fila está siendo señalada
Cuándo NO usar: Cuando las tablas sean muy simples o no necesiten interacción
Ejemplo: <x-table-hoverable :headers="['Nombre', 'Edad', 'Dirección']" :rows="[['John', 45, 'New York'], ['Jim', 27, 'London']]" />
--}}

@props([
    'headers' => [],
    'rows' => [],
])

<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            @foreach($headers as $header)
                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($rows as $row)
                            <tr class="hover:bg-gray-100">
                                @foreach($row as $cell)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $cell }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>







