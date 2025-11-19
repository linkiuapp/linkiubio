{{--
Botón de Carga - Botón con spinner para indicar procesamiento en curso
Uso: Botones que desencadenan acciones asíncronas o que requieren tiempo de procesamiento
Cuándo usar: Formularios de envío, operaciones de guardado, llamadas API, procesos largos
Cuándo NO usar: Acciones instantáneas, navegación simple, botones que no procesan datos
Ejemplo: <x-button-loading type="solid" color="info" text="Guardando..." :loading="true" />
--}}

@props([
    'type' => 'solid', // solid, outline, ghost, soft, white
    'color' => 'info', // dark, secondary, success, info, error, warning, light
    'size' => 'md', // sm, md, lg
    'text' => 'Button',
    'loadingText' => 'Cargando...',
    'loading' => false, // Estado de carga
    'loadingOnly' => false, // Solo mostrar spinner sin texto
    'disabled' => false,
    'block' => false,
    'htmlType' => 'button',
])

@php
    // Size classes
    $sizeClasses = [
        'sm' => 'py-2 px-3 body-small',
        'md' => 'py-3 px-4 body-small',
        'lg' => 'p-4 sm:p-5 body-small',
    ];
    
    // Spinner sizes based on button size
    $spinnerSizes = [
        'sm' => 'w-3 h-3 border-2',
        'md' => 'w-4 h-4 border-2',
        'lg' => 'w-5 h-5 border-2',
    ];
    
    // Size classes for loading only buttons (square)
    $loadingOnlySizes = [
        'sm' => 'flex justify-center items-center w-9 h-9 body-small',
        'md' => 'flex justify-center items-center w-11 h-11 body-small',
        'lg' => 'flex justify-center items-center w-16 h-16 body-small',
    ];
    
    // Type and color combinations
    $typeColorClasses = [
        'solid' => [
            'dark' => 'bg-gray-800 text-white hover:bg-gray-900 focus:bg-gray-900',
            'secondary' => 'bg-gray-500 text-white hover:bg-gray-600 focus:bg-gray-600',
            'success' => 'bg-green-500 text-white hover:bg-green-600 focus:bg-green-600',
            'info' => 'bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700',
            'error' => 'bg-red-500 text-white hover:bg-red-600 focus:bg-red-600',
            'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600 focus:bg-yellow-600',
            'light' => 'bg-white text-gray-800 hover:bg-gray-200 focus:bg-gray-200',
        ],
        'outline' => [
            'dark' => 'border-2 border-gray-800 text-gray-800 hover:border-gray-500 hover:text-gray-500 focus:border-gray-500 focus:text-gray-500',
            'secondary' => 'border-2 border-gray-500 text-gray-500 hover:border-gray-800 hover:text-gray-800 focus:border-gray-800 focus:text-gray-800',
            'success' => 'border-2 border-green-500 text-green-500 hover:border-green-400 hover:text-green-400 focus:border-green-400 focus:text-green-400',
            'info' => 'border-2 border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:border-blue-500 focus:text-blue-500',
            'error' => 'border-2 border-red-500 text-red-500 hover:border-red-400 hover:text-red-400 focus:border-red-400 focus:text-red-400',
            'warning' => 'border-2 border-yellow-500 text-yellow-500 hover:border-yellow-400 focus:border-yellow-400 focus:text-yellow-400',
            'light' => 'border-2 border-gray-200 text-gray-500 hover:border-blue-600 hover:text-blue-600 focus:border-blue-600 focus:text-blue-600',
        ],
        'ghost' => [
            'dark' => 'text-gray-800 hover:bg-gray-100 focus:bg-gray-100',
            'secondary' => 'text-gray-500 hover:bg-gray-100 focus:bg-gray-100',
            'success' => 'text-green-500 hover:bg-green-100 focus:bg-green-100 hover:text-green-800',
            'info' => 'text-blue-600 hover:bg-blue-100 focus:bg-blue-100 hover:text-blue-800 focus:text-blue-800',
            'error' => 'text-red-500 hover:bg-red-100 focus:bg-red-100 hover:text-red-800',
            'warning' => 'text-yellow-500 hover:bg-yellow-100 focus:bg-yellow-100 hover:text-yellow-800',
            'light' => 'text-white hover:bg-gray-100 focus:bg-gray-100 hover:text-gray-800',
        ],
        'soft' => [
            'dark' => 'bg-gray-100 text-gray-800 hover:bg-gray-200 focus:bg-gray-200',
            'secondary' => 'bg-gray-100 text-gray-500 hover:bg-gray-200 focus:bg-gray-200',
            'success' => 'bg-green-100 text-green-800 hover:bg-green-200 focus:bg-green-200',
            'info' => 'bg-blue-100 text-blue-800 hover:bg-blue-200 focus:bg-blue-200',
            'error' => 'bg-red-100 text-red-800 hover:bg-red-200 focus:bg-red-200',
            'warning' => 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200 focus:bg-yellow-200',
            'light' => 'bg-white/10 text-white hover:bg-white/20 focus:bg-white/20',
        ],
        'white' => [
            'dark' => 'border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50',
            'secondary' => 'border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50',
            'success' => 'border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50',
            'info' => 'border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50',
            'error' => 'border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50',
            'warning' => 'border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50',
            'light' => 'border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-gray-50',
        ],
    ];
    
    // Spinner color based on type and color
    $spinnerColors = [
        'solid' => 'text-white',
        'outline' => $color === 'info' ? 'text-blue-600' : 'text-current',
        'ghost' => $color === 'info' ? 'text-blue-600' : 'text-current', 
        'soft' => $color === 'info' ? 'text-blue-800' : 'text-current',
        'white' => 'text-blue-600',
    ];
    
    // Base classes
    $baseClasses = 'inline-flex items-center gap-x-2 font-medium rounded-lg focus:outline-none transition-colors disabled:opacity-50 disabled:pointer-events-none';
    
    // Get classes
    $sizeClass = $loadingOnly ? ($loadingOnlySizes[$size] ?? $loadingOnlySizes['md']) : ($sizeClasses[$size] ?? $sizeClasses['md']);
    $spinnerSize = $spinnerSizes[$size] ?? $spinnerSizes['md'];
    $spinnerColor = $spinnerColors[$type] ?? $spinnerColors['solid'];
    $typeColorClass = $typeColorClasses[$type][$color] ?? $typeColorClasses['solid']['info'];
    
    // Border class based on type
    $borderClass = in_array($type, ['outline']) ? '' : 'border border-transparent';
    
    // Block class
    $blockClass = $block ? 'w-full justify-center' : '';
    
    // Final classes
    $classes = trim("{$baseClasses} {$sizeClass} {$typeColorClass} {$borderClass} {$blockClass}");
    
    // Force disabled when loading
    $isDisabled = $loading || $disabled;
    
    // Display text
    $displayText = $loading ? $loadingText : $text;
@endphp

<button type="{{ $htmlType }}" 
        class="{{ $classes }}" 
        @if($isDisabled) disabled @endif
        {{ $attributes }}>
    @if($loading)
        <span class="animate-spin inline-block {{ $spinnerSize }} border-current border-t-transparent {{ $spinnerColor }} rounded-full" 
              role="status" 
              aria-label="loading">
            <span class="sr-only">Cargando...</span>
        </span>
    @endif
    
    @if(!$loadingOnly)
        {{ $displayText }}
    @endif
</button>
