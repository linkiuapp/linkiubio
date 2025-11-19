{{--
Checkbox Group - Grupo de checkboxes
Uso: Múltiples checkboxes en grupo horizontal
Cuándo usar: Cuando necesites varias opciones relacionadas en una sola línea
Cuándo NO usar: Cuando las opciones deban estar en líneas separadas
Ejemplo: <x-checkbox-group :options="[['id' => '1', 'label' => 'Apple'], ['id' => '2', 'label' => 'Pear']]" />
--}}

@props([
    'options' => [], // [['id' => '...', 'label' => '...', 'checked' => false, 'disabled' => false]]
    'groupName' => null,
    'gap' => 'gap-x-6', // Gap entre checkboxes
])

@php
    $groupNameAttr = $groupName ?? 'checkbox-group-' . uniqid();
@endphp

<div class="flex {{ $gap }}">
    @foreach($options as $option)
        @php
            $checkboxId = $option['id'] ?? 'checkbox-' . uniqid();
            $label = $option['label'] ?? '';
            $isChecked = $option['checked'] ?? false;
            $isDisabled = $option['disabled'] ?? false;
        @endphp
        <div class="flex {{ $isDisabled ? 'opacity-40' : '' }}">
            <input 
                type="checkbox" 
                id="{{ $checkboxId }}"
                name="{{ $groupNameAttr }}"
                @if($isChecked) checked @endif
                @if($isDisabled) disabled @endif
                class="shrink-0 mt-0.5 border-gray-400 rounded-sm text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none"
            >
            <label for="{{ $checkboxId }}" class="text-sm text-gray-500 ms-3">{{ $label }}</label>
        </div>
    @endforeach
</div>















