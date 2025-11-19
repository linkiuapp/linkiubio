{{--
File Upload Progress Multiple - Múltiples archivos en formato card
Uso: Lista de archivos subiendo, múltiples uploads simultáneos
Cuándo usar: Cuando necesites mostrar múltiples archivos en proceso de subida
Cuándo NO usar: Cuando solo necesites un archivo o formato simple
Ejemplo: <x-file-upload-progress-multiple :files="[['name' => 'file.html', 'size' => '7 KB', 'progress' => 1, 'status' => 'uploading']]" />
--}}

@props([
    'files' => [], // Array de objetos: ['name', 'size', 'progress', 'status', 'icon'?]
    'showFooter' => true, // Mostrar footer con contador y acciones
    'footerText' => null, // Texto personalizado para el footer (opcional, se calcula automáticamente si es null)
    'showFooterActions' => true, // Mostrar botones de acción en el footer
    'onPauseAll' => null, // Callback para pausar todos
    'onStartAll' => null, // Callback para iniciar/reanudar todos
    'onDeleteAll' => null, // Callback para eliminar todos
])

@php
    // Calcular estadísticas de archivos
    $totalFiles = count($files);
    $uploadingCount = collect($files)->where('status', 'uploading')->count();
    $completedCount = collect($files)->where('status', 'completed')->count();
    $errorCount = collect($files)->where('status', 'error')->count();
    
    // Generar texto del footer automáticamente si no se proporciona
    if ($footerText === null) {
        if ($errorCount > 0 && $completedCount > 0) {
            $footerText = "{$completedCount} éxito, {$errorCount} fallido";
        } elseif ($uploadingCount > 0) {
            $footerText = "{$uploadingCount} restante" . ($uploadingCount > 1 ? 's' : '');
        } else {
            $footerText = "{$totalFiles} archivo" . ($totalFiles > 1 ? 's' : '');
        }
    }
    
    // Determinar qué botón mostrar en el footer (Pause o Start)
    $hasUploading = $uploadingCount > 0;
@endphp

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl" {{ $attributes }}>
    <!-- Body -->
    <div class="p-4 md:p-5 space-y-7">
        @foreach($files as $file)
            @php
                $fileName = $file['name'] ?? '';
                $fileSize = $file['size'] ?? '';
                $progress = $file['progress'] ?? 0;
                $status = $file['status'] ?? 'uploading';
                $fileIcon = $file['icon'] ?? 'file';
                
                $value = max(0, min(100, $progress));
                
                $progressColor = match($status) {
                    'completed' => 'bg-teal-500',
                    'error' => 'bg-red-500',
                    default => 'bg-blue-600',
                };
                
                $fileNameClass = match($status) {
                    'error' => 'font-semibold text-red-500',
                    default => 'body-small font-medium text-gray-800',
                };
            @endphp
            
            <div>
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
                    <div class="inline-flex items-center gap-x-2">
                        @if($status === 'uploading')
                            <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800">
                                <i data-lucide="pause" class="shrink-0 size-4"></i>
                                <span class="sr-only">Pausar</span>
                            </button>
                        @endif
                        
                        @if($status === 'completed')
                            <span class="relative">
                                <i data-lucide="check-circle" class="shrink-0 size-4 text-teal-500"></i>
                                <span class="sr-only">Éxito</span>
                            </span>
                        @endif
                        
                        @if($status === 'error')
                            <span class="relative">
                                <i data-lucide="alert-circle" class="shrink-0 size-4 text-red-500"></i>
                                <span class="sr-only">Error</span>
                            </span>
                        @endif
                        
                        <button type="button" class="relative text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800">
                            <i data-lucide="trash-2" class="shrink-0 size-4"></i>
                            <span class="sr-only">Eliminar</span>
                        </button>
                    </div>
                </div>
                <!-- End Uploading File Content -->

                <!-- Progress Bar -->
                <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden" 
                     role="progressbar" 
                     aria-valuenow="{{ $value }}" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                    <div class="flex flex-col justify-center rounded-full overflow-hidden {{ $progressColor }} text-xs text-white text-center whitespace-nowrap transition duration-500" 
                         style="width: {{ $value }}%"></div>
                </div>
                <!-- End Progress Bar -->
            </div>
        @endforeach
    </div>
    <!-- End Body -->

    @if($showFooter)
        <!-- Footer -->
        <div class="bg-gray-50 border-t border-gray-200 rounded-b-xl py-2 px-4 md:px-5">
            <div class="flex flex-wrap justify-between items-center gap-x-3">
                <div>
                    <span class="body-small font-semibold text-gray-800">
                        {{ $footerText }}
                    </span>
                </div>
                <!-- End Col -->

                @if($showFooterActions)
                    <div class="-me-2.5">
                        @if($hasUploading)
                            <button type="button" 
                                    class="py-2 px-3 inline-flex items-center gap-x-1.5 body-small font-medium rounded-lg border border-transparent text-gray-500 hover:bg-gray-200 hover:text-gray-800 focus:outline-hidden focus:bg-gray-200 focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none"
                                    @if($onPauseAll) onclick="{{ $onPauseAll }}" @endif>
                                <i data-lucide="pause" class="shrink-0 size-4"></i>
                                <span class="sr-only">Pausar</span>
                                Pausar
                            </button>
                        @else
                            <button type="button" 
                                    class="py-2 px-3 inline-flex items-center gap-x-1.5 body-small font-medium rounded-lg border border-transparent text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none"
                                    @if($onStartAll) onclick="{{ $onStartAll }}" @endif>
                                <i data-lucide="play" class="shrink-0 size-4"></i>
                                Iniciar
                            </button>
                        @endif
                        <button type="button" 
                                class="py-2 px-3 inline-flex items-center gap-x-1.5 body-small font-medium rounded-lg border border-transparent text-gray-500 hover:bg-gray-200 hover:text-gray-800 focus:outline-hidden focus:bg-gray-200 focus:text-gray-800 disabled:opacity-50 disabled:pointer-events-none"
                                @if($onDeleteAll) onclick="{{ $onDeleteAll }}" @endif>
                            <i data-lucide="trash-2" class="shrink-0 size-4"></i>
                            Eliminar
                        </button>
                    </div>
                    <!-- End Col -->
                @endif
            </div>
        </div>
        <!-- End Footer -->
    @endif
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

