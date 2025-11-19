{{--
File Upload Progress - Componente de progreso de subida de archivos
Uso: Uploads de archivos, progreso de carga, indicadores de estado de archivos
Cuándo usar: Cuando necesites mostrar el progreso de subida de archivos con información del archivo
Cuándo NO usar: Cuando necesites barras de progreso simples sin información de archivo
Ejemplo: <x-file-upload-progress fileName="preline-ui.xls" fileSize="7 KB" :progress="25" status="uploading" />
--}}

@props([
    'fileName' => '',
    'fileSize' => '',
    'progress' => 0, // 0-100
    'status' => 'uploading', // uploading, completed, error
    'fileIcon' => 'file', // Icono de Lucide para el tipo de archivo
    'showActions' => true, // Mostrar botones de pausa/eliminar
    'onPause' => null, // Callback para pausar
    'onDelete' => null, // Callback para eliminar
])

@php
    $value = max(0, min(100, $progress));
    
    // Determinar color según estado
    $progressColor = match($status) {
        'completed' => 'bg-teal-500',
        'error' => 'bg-red-500',
        default => 'bg-blue-600',
    };
    
    // Determinar si mostrar porcentaje o icono de estado
    $showPercentage = $status === 'uploading';
    $showSuccessIcon = $status === 'completed';
    $showErrorIcon = $status === 'error';
    
    // Clase para el nombre del archivo según estado
    $fileNameClass = match($status) {
        'error' => 'font-semibold text-red-500',
        default => 'body-small font-medium text-gray-800',
    };
@endphp

<div {{ $attributes }}>
    <!-- Uploading File Content -->
    <div class="mb-2 flex justify-between items-center">
        <div class="flex items-center gap-x-3">
            <span class="size-8 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg">
                <i data-lucide="{{ $fileIcon }}" class="shrink-0 size-5"></i>
            </span>
            <div>
                <p class="{{ $fileNameClass }}">{{ $fileName }}</p>
                <p class="caption text-gray-500">{{ $fileSize }}</p>
            </div>
        </div>
        @if($showActions)
            <div class="inline-flex items-center gap-x-2">
                @if($status === 'uploading')
                    <button type="button" 
                            class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800"
                            @if($onPause) onclick="{{ $onPause }}" @endif>
                        <i data-lucide="pause" class="shrink-0 size-4"></i>
                        <span class="sr-only">Pausar</span>
                    </button>
                @endif
                
                @if($showSuccessIcon)
                    <span class="relative">
                        <i data-lucide="check-circle" class="shrink-0 size-4 text-teal-500"></i>
                        <span class="sr-only">Éxito</span>
                    </span>
                @endif
                
                @if($showErrorIcon)
                    <span class="relative">
                        <i data-lucide="alert-circle" class="shrink-0 size-4 text-red-500"></i>
                        <span class="sr-only">Error</span>
                    </span>
                @endif
                
                <button type="button" 
                        class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800"
                        @if($onDelete) onclick="{{ $onDelete }}" @endif>
                    <i data-lucide="trash-2" class="shrink-0 size-4"></i>
                    <span class="sr-only">Eliminar</span>
                </button>
            </div>
        @endif
    </div>
    <!-- End Uploading File Content -->

    <!-- Progress Bar -->
    <div class="flex items-center gap-x-3 whitespace-nowrap">
        <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden" 
             role="progressbar" 
             aria-valuenow="{{ $value }}" 
             aria-valuemin="0" 
             aria-valuemax="100">
            <div class="flex flex-col justify-center rounded-full overflow-hidden {{ $progressColor }} text-xs text-white text-center whitespace-nowrap transition duration-500" 
                 style="width: {{ $value }}%"></div>
        </div>
        @if($showPercentage)
            <div class="w-6 text-end">
                <span class="body-small text-gray-800">{{ $value }}%</span>
            </div>
        @endif
    </div>
    <!-- End Progress Bar -->
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos de Lucide
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    } else if (typeof createIcons !== 'undefined') {
        createIcons();
    }
});
</script>
@endpush















