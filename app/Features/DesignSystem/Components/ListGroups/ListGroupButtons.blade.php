{{--
List Group Buttons - Grupo de lista con botones interactivos
Uso: Formularios, acciones, opciones seleccionables
Cuándo usar: Cuando necesites listas con botones que tengan estados (active, hover, disabled)
Cuándo NO usar: Cuando necesites enlaces o listas estáticas
Ejemplo: <x-list-group-buttons :items="[['label' => 'Active', 'icon' => 'bell', 'active' => true]]" />
--}}

@props([
    'items' => [], // Array de objetos: ['label', 'icon'?, 'active'?, 'disabled'?, 'onclick'?]
    'width' => 'max-w-xs',
    'textSize' => 'body-small',
])

@php
    $containerClasses = "{$width} flex flex-col";
@endphp

<div class="{{ $containerClasses }}" {{ $attributes }}>
    @foreach($items as $item)
        @php
            $label = $item['label'] ?? '';
            $icon = $item['icon'] ?? null;
            $active = $item['active'] ?? false;
            $disabled = $item['disabled'] ?? false;
            $onclick = $item['onclick'] ?? null;
            
            $buttonClasses = "inline-flex items-center gap-x-2 py-3 px-4 {$textSize} text-start font-medium border border-gray-200 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg focus:z-10 focus:outline-hidden focus:ring-2 focus:ring-blue-600";
            
            if ($active) {
                $buttonClasses .= " text-blue-600";
            } elseif ($disabled) {
                $buttonClasses .= " text-gray-800 opacity-50 cursor-not-allowed";
            } else {
                $buttonClasses .= " text-gray-800 hover:text-blue-600";
            }
        @endphp
        <button type="button" 
                class="{{ $buttonClasses }}"
                @if($disabled) disabled @endif
                @if($onclick && !$disabled) onclick="{{ $onclick }}" @endif>
            @if($icon)
                <i data-lucide="{{ $icon }}" class="shrink-0 size-4"></i>
            @endif
            {{ $label }}
        </button>
    @endforeach
</div>















