{{--
Radio Group - Grupo de radios
Uso: Múltiples radios en grupo (horizontal o vertical)
Cuándo usar: Cuando necesites varias opciones mutuamente excluyentes
Cuándo NO usar: Cuando las opciones no sean mutuamente excluyentes (usa checkbox)
Ejemplo: <x-radio-group name="fruits" :options="[['id' => '1', 'label' => 'Apple'], ['id' => '2', 'label' => 'Pear']]" layout="horizontal" />
--}}

@props([
    'options' => [], // [['id' => '...', 'label' => '...', 'checked' => false, 'disabled' => false]]
    'groupName' => null,
    'layout' => 'horizontal', // 'horizontal' o 'vertical'
    'gap' => 'gap-x-6', // Gap entre radios (horizontal)
])

@php
    $groupNameAttr = $groupName ?? 'radio-group-' . uniqid();
    $isVertical = $layout === 'vertical';
@endphp

<div class="flex {{ $isVertical ? 'flex-col gap-y-3' : $gap }}">
    @foreach($options as $option)
        @php
            $radioId = $option['id'] ?? 'radio-' . uniqid();
            $label = $option['label'] ?? '';
            $isChecked = $option['checked'] ?? false;
            $isDisabled = $option['disabled'] ?? false;
        @endphp
        <div class="flex {{ $isDisabled ? 'opacity-40' : '' }}">
            <input 
                type="radio" 
                id="{{ $radioId }}"
                name="{{ $groupNameAttr }}"
                @if($isChecked) checked @endif
                @if($isDisabled) disabled @endif
                class="shrink-0 mt-0.5 border-gray-400 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none"
            >
            <label for="{{ $radioId }}" class="text-sm text-gray-500 ms-2">{{ $label }}</label>
        </div>
    @endforeach
</div>















