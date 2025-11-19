{{--
Card Panel Actions - Card con botones de acción en el header como refresh, fullscreen, close
Uso: Paneles de control, dashboards, secciones que requieren acciones rápidas
Cuándo usar: Contenido que necesita acciones de control, paneles interactivos
Cuándo NO usar: Contenido estático, cards simples sin acciones
Ejemplo: <x-card-panel-actions title="Panel de control" :actions='[["icon" => "refresh-cw", "tooltip" => "Actualizar"], ["icon" => "maximize", "tooltip" => "Pantalla completa"]]' />
--}}

@props([
    'title' => 'Card title',
    'content' => '',
    'link' => '',
    'linkText' => 'Card link',
    'actions' => [], // Array de acciones [['icon' => 'refresh-cw', 'tooltip' => 'Refresh', 'action' => 'refresh()']]
])

@php
    // Default actions if none provided
    $defaultActions = [
        ['icon' => 'refresh-cw', 'tooltip' => 'Actualizar', 'action' => ''],
        ['icon' => 'maximize', 'tooltip' => 'Pantalla completa', 'action' => ''],
        ['icon' => 'x', 'tooltip' => 'Cerrar', 'action' => ''],
    ];
    
    $actionButtons = empty($actions) ? $defaultActions : $actions;
@endphp

<div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl" {{ $attributes }}>
    {{-- Header with actions --}}
    <div class="flex justify-between items-center border-b border-gray-200 rounded-t-xl py-3 px-4 md:px-5">
        @if($title)
            <h4 class="h4 text-gray-800">
                {{ $title }}
            </h4>
        @endif

        <div class="flex items-center gap-x-1">
            @foreach($actionButtons as $action)
                <div class="inline-block">
                    <button type="button" 
                            class="w-8 h-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition-colors"
                            @if(isset($action['action']) && $action['action']) onclick="{{ $action['action'] }}" @endif
                            title="{{ $action['tooltip'] ?? '' }}">
                        <i data-lucide="{{ $action['icon'] }}" class="w-4 h-4"></i>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- Content --}}
    <div class="p-4 md:p-5">
        @if($content)
            <p class="mt-2 body-small text-gray-500">
                {{ $content }}
            </p>
        @endif
        
        {{ $slot }}
        
        @if($link && $linkText)
            <a class="mt-3 inline-flex items-center gap-x-1 body-small font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-700 hover:underline focus:underline focus:outline-none focus:text-blue-700" 
               href="{{ $link }}">
                {{ $linkText }}
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        @endif
    </div>
</div>
