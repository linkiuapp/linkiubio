@extends('design-system::layout')

@section('page-title', 'File Uploading Progress')
@section('page-description', 'Componentes de progreso de subida de archivos basados en Preline UI')

@section('content')
{{-- SECTION: File Upload Progress Básico --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        File Upload Progress
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: just-uploaded --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Recién Subido (0%)</h4>
            <x-file-upload-progress 
                fileName="preline-ui.xls"
                fileSize="7 KB"
                :progress="1"
                status="uploading"
                fileIcon="file-spreadsheet"
            />
        </div>
        
        {{-- ITEM: in-progress --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">En Progreso (25%)</h4>
            <x-file-upload-progress 
                fileName="preline-ui.xls"
                fileSize="7 KB"
                :progress="25"
                status="uploading"
                fileIcon="file-spreadsheet"
            />
        </div>
        
        {{-- ITEM: completed --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Completado (100%)</h4>
            <x-file-upload-progress 
                fileName="preline-ui.xls"
                fileSize="7 KB"
                :progress="100"
                status="completed"
                fileIcon="file-spreadsheet"
            />
        </div>
        
        {{-- ITEM: error --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Error</h4>
            <x-file-upload-progress 
                fileName="preline-ui.xls"
                fileSize="7 KB"
                :progress="25"
                status="error"
                fileIcon="file-spreadsheet"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Uploads de archivos, progreso de carga, indicadores de estado de archivos</p>
            <p><strong>❌ NO usar para:</strong> Cuando necesites barras de progreso simples sin información de archivo</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-file-upload-progress 
    fileName="preline-ui.xls" 
    fileSize="7 KB" 
    :progress="25" 
    status="uploading" 
    fileIcon="file-spreadsheet"
/&gt;

&lt;x-file-upload-progress 
    fileName="preline-ui.xls" 
    fileSize="7 KB" 
    :progress="100" 
    status="completed" 
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: File Upload Progress Multiple --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        File Upload Progress Multiple
    </h4>
    
    <div class="space-y-8">
        {{-- ITEM: multiple-files-just-uploaded --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Múltiples Archivos: Recién Subidos</h4>
            <x-file-upload-progress-multiple 
                :files="[
                    ['name' => 'preline-ui.html', 'size' => '7 KB', 'progress' => 1, 'status' => 'uploading', 'icon' => 'upload'],
                    ['name' => 'preline-ui.mp4', 'size' => '105.5 MB', 'progress' => 1, 'status' => 'uploading', 'icon' => 'upload'],
                    ['name' => 'preline-ui-cover.jpg', 'size' => '55 KB', 'progress' => 1, 'status' => 'uploading', 'icon' => 'upload']
                ]"
            />
        </div>
        
        {{-- ITEM: multiple-files-in-progress --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Múltiples Archivos: En Progreso</h4>
            <x-file-upload-progress-multiple 
                :files="[
                    ['name' => 'preline-ui.html', 'size' => '7 KB', 'progress' => 100, 'status' => 'completed', 'icon' => 'upload'],
                    ['name' => 'preline-ui.mp4', 'size' => '105.5 MB', 'progress' => 25, 'status' => 'uploading', 'icon' => 'upload'],
                    ['name' => 'preline-ui-cover.jpg', 'size' => '55 KB', 'progress' => 100, 'status' => 'completed', 'icon' => 'upload']
                ]"
            />
        </div>
        
        {{-- ITEM: multiple-files-error --}}
        <div class="space-y-4">
            <h4 class="body-lg-medium text-brandNeutral-400">Múltiples Archivos: Con Error</h4>
            <x-file-upload-progress-multiple 
                :files="[
                    ['name' => 'preline-ui.html', 'size' => '7 KB', 'progress' => 100, 'status' => 'completed', 'icon' => 'upload'],
                    ['name' => 'preline-ui.mp4', 'size' => '105.5 MB', 'progress' => 25, 'status' => 'error', 'icon' => 'upload'],
                    ['name' => 'preline-ui-cover.jpg', 'size' => '55 KB', 'progress' => 100, 'status' => 'completed', 'icon' => 'upload']
                ]"
            />
        </div>
        
        <div class="body-small text-brandNeutral-200">
            <p><strong>✅ Usar para:</strong> Lista de archivos subiendo, múltiples uploads simultáneos</p>
            <p><strong>❌ NO usar para:</strong> Cuando solo necesites un archivo o formato simple</p>
        </div>
    </div>
    
    <div class="mt-6 bg-brandNeutral-50 rounded-lg p-4">
        <pre class="body-small text-brandNeutral-300"><code>&lt;x-file-upload-progress-multiple 
    :files="[
        ['name' => 'file.html', 'size' => '7 KB', 'progress' => 1, 'status' => 'uploading', 'icon' => 'file-code'],
        ['name' => 'file.mp4', 'size' => '105.5 MB', 'progress' => 45, 'status' => 'uploading', 'icon' => 'video'],
        ['name' => 'file.pdf', 'size' => '2.3 MB', 'progress' => 100, 'status' => 'completed', 'icon' => 'file-text']
    ]"
/&gt;</code></pre>
    </div>
</div>

{{-- SECTION: Props Documentation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Documentación de Props
    </h4>
    
    <div class="mt-4 body-small text-brandNeutral-200 space-y-4">
        <div>
            <p><strong>FileUploadProgress props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>fileName</code>: Nombre del archivo (required)</li>
                <li><code>fileSize</code>: Tamaño del archivo (required)</li>
                <li><code>progress</code>: Progreso de subida (0-100) - default: 0</li>
                <li><code>status</code>: Estado ('uploading', 'completed', 'error') - default: 'uploading'</li>
                <li><code>fileIcon</code>: Nombre del icono Lucide para el tipo de archivo - default: 'file'</li>
                <li><code>showActions</code>: Si mostrar botones de acción - default: true</li>
                <li><code>onPause</code>: Callback para pausar (opcional)</li>
                <li><code>onDelete</code>: Callback para eliminar (opcional)</li>
            </ul>
        </div>
        
        <div>
            <p><strong>FileUploadProgressMultiple props:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                <li><code>files</code>: Array de objetos con 'name', 'size', 'progress', 'status', y opcionalmente 'icon' (required)</li>
                <li><code>showFooter</code>: Si mostrar el footer con contador y acciones - default: true</li>
                <li><code>footerText</code>: Texto personalizado para el footer (opcional, se calcula automáticamente si es null)</li>
                <li><code>showFooterActions</code>: Si mostrar botones de acción en el footer - default: true</li>
                <li><code>onPauseAll</code>: Callback para pausar todos los archivos (opcional)</li>
                <li><code>onStartAll</code>: Callback para iniciar/reanudar todos los archivos (opcional)</li>
                <li><code>onDeleteAll</code>: Callback para eliminar todos los archivos (opcional)</li>
            </ul>
        </div>
    </div>
</div>
@endsection

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

