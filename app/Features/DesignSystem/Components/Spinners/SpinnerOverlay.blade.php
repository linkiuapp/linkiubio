{{--
Spinner Overlay - Spinner con overlay sobre contenido
Uso: Loading states sobre contenido existente, formularios en proceso
Cuándo usar: Cuando necesites mostrar un spinner sobre contenido que ya existe
Cuándo NO usar: Cuando necesites un spinner standalone o dentro de una card
Ejemplo: <x-spinner-overlay color="blue" size="md">Contenido aquí</x-spinner-overlay>
--}}

@props([
    'color' => 'blue',
    'size' => 'md',
    'overlayOpacity' => 'bg-white/50', // Opacidad del overlay
    'label' => 'Loading...',
])

<div class="relative" {{ $attributes }}>
    {{ $slot }}
    
    <div class="absolute top-0 start-0 size-full {{ $overlayOpacity }} rounded-lg"></div>
    
    <div class="absolute top-1/2 start-1/2 transform -translate-x-1/2 -translate-y-1/2">
        <x-spinner-basic color="{{ $color }}" size="{{ $size }}" label="{{ $label }}" />
    </div>
</div>















