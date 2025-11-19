{{--
List Group Invoice - Grupo de lista estilo factura con valores y footer resaltado
Uso: Facturas, recibos, resúmenes de pago, listas con totales
Cuándo usar: Cuando necesites mostrar items con valores y un total destacado
Cuándo NO usar: Cuando necesites listas simples sin valores o totales
Ejemplo: <x-list-group-invoice :items="[['label' => 'Payment to Front', 'value' => '$264.00']]" :total="['label' => 'Amount paid', 'value' => '$316.8']" />
--}}

@props([
    'items' => [], // Array de objetos: ['label', 'value']
    'total' => null, // Objeto con 'label' y 'value' para el footer resaltado
    'textSize' => 'body-small',
    'textColor' => 'text-gray-800',
])

<ul class="mt-3 flex flex-col" {{ $attributes }}>
    @foreach($items as $item)
        @php
            $label = $item['label'] ?? '';
            $value = $item['value'] ?? '';
        @endphp
        <li class="inline-flex items-center gap-x-2 py-3 px-4 {{ $textSize }} border border-gray-200 {{ $textColor }} -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg">
            <div class="flex items-center justify-between w-full">
                <span>{{ $label }}</span>
                <span>{{ $value }}</span>
            </div>
        </li>
    @endforeach
    
    @if($total)
        <li class="inline-flex items-center gap-x-2 py-3 px-4 {{ $textSize }} font-semibold bg-gray-50 border border-gray-200 {{ $textColor }} -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg">
            <div class="flex items-center justify-between w-full">
                <span>{{ $total['label'] ?? '' }}</span>
                <span>{{ $total['value'] ?? '' }}</span>
            </div>
        </li>
    @endif
</ul>















