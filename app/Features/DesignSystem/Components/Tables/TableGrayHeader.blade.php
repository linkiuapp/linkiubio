{{--
Table Gray Header - Tabla con encabezado gris
Uso: Tabla con encabezado de fondo gris
Cuándo usar: Cuando quieras destacar visualmente el encabezado de la tabla
Cuándo NO usar: Cuando prefieras un diseño más simple sin encabezado destacado
Ejemplo: <x-table-gray-header :headers="['Nombre', 'Edad', 'Dirección']" :rows="[['John', 45, 'New York'], ['Jim', 27, 'London']]" />
--}}

@props([
    'headers' => [],
    'rows' => [],
])

<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
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
                            <tr>
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















