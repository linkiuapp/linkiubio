{{--
Spinner Card - Spinner dentro de una card
Uso: Loading states en cards, contenedores con contenido en carga
Cuándo usar: Cuando necesites mostrar un spinner centrado dentro de una card
Cuándo NO usar: Cuando necesites un spinner inline o sin contenedor
Ejemplo: <x-spinner-card color="blue" size="md" />
--}}

@props([
    'color' => 'blue',
    'size' => 'md',
    'minHeight' => 'min-h-60',
    'label' => 'Loading...',
])

<div class="{{ $minHeight }} flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl" {{ $attributes }}>
    <div class="flex flex-auto flex-col justify-center items-center p-4 md:p-5">
        <div class="flex justify-center">
            <x-spinner-basic color="{{ $color }}" size="{{ $size }}" label="{{ $label }}" />
        </div>
    </div>
</div>















