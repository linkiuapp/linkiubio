{{--
Toast Loading - Toast con indicador de carga
Uso: Notificaciones de procesos en curso, acciones asíncronas
Cuándo usar: Cuando necesites mostrar que una acción está en progreso
Cuándo NO usar: Cuando necesites un toast con mensaje estático
Ejemplo: <x-toast-loading message="Acción en progreso" />
--}}

@props([
    'message' => 'Acción en progreso',
    'spinnerColor' => 'blue', // Color del spinner
    'id' => null,
])

@php
    $uniqueId = $id ?? uniqid('toast-loading-');
    $labelId = $uniqueId . '-label';
    
    $spinnerColorClass = match($spinnerColor) {
        'blue' => 'text-blue-600',
        'gray' => 'text-gray-600',
        'red' => 'text-red-600',
        'yellow' => 'text-yellow-600',
        'green' => 'text-green-600',
        default => 'text-blue-600',
    };
@endphp

<div class="max-w-xs bg-white border border-gray-200 rounded-xl shadow-lg" 
     role="alert" 
     tabindex="-1" 
     aria-labelledby="{{ $labelId }}"
     id="{{ $uniqueId }}"
     {{ $attributes }}>
    <div class="flex items-center p-4">
        <x-spinner-basic color="{{ $spinnerColor }}" size="sm" />
        <p id="{{ $labelId }}" class="ms-3 body-small text-gray-700">
            {{ $message ?: $slot }}
        </p>
    </div>
</div>















