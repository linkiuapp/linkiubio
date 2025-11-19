@extends('design-system::layout')

@section('title', 'File Upload Preline UI')
@section('page-title', 'File Upload Components')
@section('page-description', 'Componentes para subida de archivos basados en Preline UI (requieren Dropzone.js)')


@section('content')

{{-- SECTION: Documentation --}}
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
    <h4 class="h4 text-yellow-800 mb-4">⚠️ Requisitos</h4>
    <p class="body-small text-yellow-700 mb-4">
        Los componentes de file upload requieren <strong>Dropzone.js</strong> y los <strong>helpers de Preline UI</strong> para funcionar. Para implementarlos:
    </p>
    <ol class="list-decimal list-inside space-y-2 body-small text-yellow-700">
        <li>Instalar Dropzone: <code class="bg-yellow-100 px-2 py-1 rounded">npm i dropzone</code></li>
        <li>Instalar Lodash: <code class="bg-yellow-100 px-2 py-1 rounded">npm i lodash</code></li>
        <li>Incluir Dropzone CSS: <code class="bg-yellow-100 px-2 py-1 rounded">&lt;link rel="stylesheet" href="./assets/vendor/dropzone/dist/dropzone.css"&gt;</code></li>
        <li>Incluir JavaScript: <code class="bg-yellow-100 px-2 py-1 rounded">&lt;script src="./assets/vendor/dropzone/dist/dropzone-min.js"&gt;&lt;/script&gt;</code></li>
        <li>Incluir helpers de Preline: <code class="bg-yellow-100 px-2 py-1 rounded">&lt;script src="./assets/vendor/preline/dist/helper-file-upload.js"&gt;&lt;/script&gt;</code></li>
    </ol>
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-4">
        <p class="body-small text-green-800 font-medium mb-2">✅ Configuración optimizada:</p>
        <p class="body-small text-green-700">
            Los componentes están configurados con <code class="bg-green-100 px-2 py-1 rounded">autoProcessQueue: false</code> para evitar múltiples peticiones automáticas. 
            Los archivos se agregan a la cola pero no se suben automáticamente. Si necesitas subir archivos automáticamente cuando se agregan, puedes procesar manualmente la cola o cambiar la configuración.
        </p>
    </div>
    <p class="body-small text-yellow-700 mt-4">
        Ver código completo en <code class="bg-yellow-100 px-2 py-1 rounded">Componentes-3.md</code> listado 43.
    </p>
</div>

{{-- SECTION: Basic Usage --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Basic Usage
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Uso básico de file upload con preview de archivos y barra de progreso.</p>
    
    <x-file-upload-basic uploadUrl="/upload" maxFileSize="2" />
    
    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
        <p class="body-small text-gray-600 mb-2"><strong>Uso:</strong></p>
        <pre class="body-small text-gray-700"><code>&lt;x-file-upload-basic uploadUrl="/upload" maxFileSize="2" /&gt;</code></pre>
        <p class="caption text-gray-500 mt-2">Ver código completo en Componentes-3.md línea 2018-2119</p>
    </div>
</div>

{{-- SECTION: Error Handling --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Error Handling
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Subida de archivos con validación de tamaño máximo y mensajes de error con tooltip.</p>
    
    <x-file-upload-error uploadUrl="/upload" maxFileSize="1" />
    
    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
        <p class="body-small text-gray-600 mb-2"><strong>Uso:</strong></p>
        <pre class="body-small text-gray-700"><code>&lt;x-file-upload-error uploadUrl="/upload" maxFileSize="1" /&gt;</code></pre>
        <p class="caption text-gray-500 mt-2">Ver código completo en Componentes-3.md línea 2121-2257</p>
    </div>
</div>

{{-- SECTION: Gallery --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Gallery
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Subida de múltiples imágenes con preview en formato de galería (grid 4 columnas).</p>
    
    <x-file-upload-gallery uploadUrl="/upload" />
    
    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
        <p class="body-small text-gray-600 mb-2"><strong>Uso:</strong></p>
        <pre class="body-small text-gray-700"><code>&lt;x-file-upload-gallery uploadUrl="/upload" /&gt;</code></pre>
        <p class="caption text-gray-500 mt-2">Ver código completo en Componentes-3.md línea 2259-2352</p>
    </div>
</div>

{{-- SECTION: Single Image Upload --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Single Image Upload
    </h4>
    <p class="body-small text-brandNeutral-200 mb-6">Subida de una sola imagen con preview circular (ideal para avatares o imágenes de perfil).</p>
    
    <x-file-upload-single-image uploadUrl="/upload" />
    
    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
        <p class="body-small text-gray-600 mb-2"><strong>Uso:</strong></p>
        <pre class="body-small text-gray-700"><code>&lt;x-file-upload-single-image uploadUrl="/upload" /&gt;</code></pre>
        <p class="caption text-gray-500 mt-2">Ver código completo en Componentes-3.md línea 2354-2394</p>
    </div>
</div>

{{-- SECTION: Props Documentation --}}
<div class="bg-white rounded-xl shadow-sm border border-brandNeutral-50 p-8 mb-8">
    <h4 class="h4 text-brandNeutral-400 mb-6 pb-4 border-b border-brandNeutral-50">
        Documentación de Props
    </h4>
    
    <div class="mt-4 body-small text-brandNeutral-200 space-y-4">
        <div>
            <p class="font-medium mb-2"><strong>FileUploadBasic:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4">
                <li><code>uploadUrl</code>: URL del endpoint de subida (default: '/upload')</li>
                <li><code>maxFileSize</code>: Tamaño máximo en MB (default: 2)</li>
                <li><code>uniqueId</code>: ID único del componente (opcional, se genera automáticamente)</li>
            </ul>
        </div>
        
        <div>
            <p class="font-medium mb-2"><strong>FileUploadError:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4">
                <li><code>uploadUrl</code>: URL del endpoint de subida (default: '/upload')</li>
                <li><code>maxFileSize</code>: Tamaño máximo en MB (default: 1)</li>
                <li><code>uniqueId</code>: ID único del componente (opcional, se genera automáticamente)</li>
            </ul>
        </div>
        
        <div>
            <p class="font-medium mb-2"><strong>FileUploadGallery:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4">
                <li><code>uploadUrl</code>: URL del endpoint de subida (default: '/upload')</li>
                <li><code>uniqueId</code>: ID único del componente (opcional, se genera automáticamente)</li>
            </ul>
        </div>
        
        <div>
            <p class="font-medium mb-2"><strong>FileUploadSingleImage:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4">
                <li><code>uploadUrl</code>: URL del endpoint de subida (default: '/upload')</li>
                <li><code>uniqueId</code>: ID único del componente (opcional, se genera automáticamente)</li>
            </ul>
        </div>
    </div>
</div>

@endsection

@push('scripts-before-preline')
<!-- Dropzone.js y Lodash - DEBEN cargarse ANTES de Preline UI -->
<link rel="stylesheet" href="https://unpkg.com/dropzone@6.0.0-beta.2/dist/dropzone.css">
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.2/dist/dropzone-min.js"></script>
@endpush

@push('scripts')
<!-- Helper de Preline UI para File Upload - DEBE cargarse DESPUÉS de Preline UI -->
<script>
// Cargar helper desde CDN (no está incluido en el paquete npm)
(function() {
    const script = document.createElement('script');
    script.src = 'https://preline.co/assets/js/helper-file-upload.js';
    script.onload = function() {
        console.log('✅ Helper File Upload cargado');
    };
    script.onerror = function() {
        console.warn('⚠️ No se pudo cargar helper-file-upload.js desde CDN');
    };
    document.head.appendChild(script);
})();
</script>

<script>
// Esperar a que todas las librerías estén cargadas
(function() {
    console.log('🔍 Iniciando File Upload Components...');
    
    function initFileUploadComponents() {
        console.log('🔍 Verificando dependencias...', {
            Dropzone: typeof Dropzone !== 'undefined',
            HSFileUpload: typeof HSFileUpload !== 'undefined',
            HSStaticMethods: typeof HSStaticMethods !== 'undefined'
        });
        
        // Verificar que todas las dependencias estén disponibles
        if (typeof Dropzone === 'undefined') {
            console.log('⏳ Esperando Dropzone...');
            setTimeout(initFileUploadComponents, 100);
            return;
        }
        
        // Verificar Preline UI de múltiples formas
        const hasPreline = typeof window.HSStaticMethods !== 'undefined' || 
                          typeof HSStaticMethods !== 'undefined' ||
                          typeof window.HS !== 'undefined';
        
        if (!hasPreline) {
            console.log('⏳ Esperando Preline UI (HSStaticMethods)...');
            console.log('🔍 Verificando:', {
                'window.HSStaticMethods': typeof window.HSStaticMethods,
                'HSStaticMethods': typeof HSStaticMethods,
                'window.HS': typeof window.HS
            });
            setTimeout(initFileUploadComponents, 300);
            return;
        }
        
        console.log('✅ Preline UI disponible');
        
        // Inicializar iconos de Lucide con el objeto icons
        if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
            window.createIcons({ icons: window.lucideIcons });
            console.log('✅ Iconos de Lucide inicializados');
        } else if (typeof lucide !== 'undefined' && lucide.createIcons) {
            if (typeof icons !== 'undefined') {
                lucide.createIcons({ icons });
            } else {
                lucide.createIcons();
            }
        }
        
        // Inicializar automáticamente todos los componentes de File Upload
        const fileUploadElements = document.querySelectorAll('[data-hs-file-upload]');
        console.log('📁 Componentes encontrados:', fileUploadElements.length);
        
        // Usar HSStaticMethods del window o global para inicializar
        const staticMethods = window.HSStaticMethods || HSStaticMethods;
        if (staticMethods && staticMethods.autoInit) {
            // Inicializar file-upload (Preline UI debería detectarlo automáticamente)
            staticMethods.autoInit(['file-upload']);
            console.log('✅ Preline UI autoInit ejecutado para file-upload');
            
            // Esperar un momento para que Preline UI inicialice los componentes
            setTimeout(() => {
                // Verificar si HSFileUpload está disponible después de autoInit
                if (typeof HSFileUpload !== 'undefined') {
                    console.log('✅ HSFileUpload helper disponible');
                    
                    fileUploadElements.forEach(element => {
                        try {
                            const instance = HSFileUpload.getInstance('#' + element.id, true);
                            if (instance && instance.element && instance.element.dropzone) {
                                const dropzone = instance.element.dropzone;
                                console.log('✅ Instancia inicializada:', element.id);
                                
                                // Manejar errores
                                dropzone.on('error', function(file, errorMessage) {
                                    console.error('Error al subir:', file.name, errorMessage);
                                });
                                
                                // Manejar éxito
                                dropzone.on('success', function(file, response) {
                                    console.log('Archivo subido exitosamente:', file.name);
                                });
                            } else {
                                console.warn('⚠️ No se pudo obtener dropzone para:', element.id);
                            }
                        } catch (error) {
                            console.warn('❌ Error al inicializar:', element.id, error);
                        }
                    });
                } else {
                    console.warn('⚠️ HSFileUpload helper no está disponible después de autoInit');
                    console.log('💡 Intentando inicializar Dropzone manualmente...');
                    
                    // Fallback: inicializar Dropzone manualmente si el helper no está disponible
                    fileUploadElements.forEach(element => {
                        try {
                            const config = element.getAttribute('data-hs-file-upload');
                            if (config && typeof Dropzone !== 'undefined') {
                                const options = JSON.parse(config);
                                
                                // Encontrar el trigger (área de drop)
                                const trigger = element.querySelector('[data-hs-file-upload-trigger]');
                                const previewsContainer = element.querySelector('[data-hs-file-upload-previews]');
                                const previewTemplate = element.querySelector('template[data-hs-file-upload-preview]');
                                
                                if (trigger) {
                                    // Crear input file oculto
                                    const fileInput = document.createElement('input');
                                    fileInput.type = 'file';
                                    fileInput.style.display = 'none';
                                    fileInput.multiple = !options.maxFiles || options.maxFiles > 1;
                                    if (options.acceptedFiles) {
                                        fileInput.accept = options.acceptedFiles;
                                    }
                                    element.appendChild(fileInput);
                                    
                                    // Configurar Dropzone en el trigger
                                    const dropzone = new Dropzone(trigger, {
                                        url: options.url || '/upload',
                                        autoProcessQueue: options.autoProcessQueue !== undefined ? options.autoProcessQueue : false,
                                        maxFilesize: options.maxFilesize || 2,
                                        acceptedFiles: options.acceptedFiles || null,
                                        maxFiles: options.maxFiles || null,
                                        clickable: true,
                                        previewsContainer: previewsContainer || false,
                                        previewTemplate: previewTemplate ? previewTemplate.innerHTML : null,
                                        addRemoveLinks: true
                                    });
                                    
                                    // Hacer clickable el trigger
                                    trigger.addEventListener('click', function(e) {
                                        if (e.target === trigger || trigger.contains(e.target)) {
                                            fileInput.click();
                                        }
                                    });
                                    
                                    // Sincronizar con input file
                                    fileInput.addEventListener('change', function() {
                                        if (this.files.length > 0) {
                                            Array.from(this.files).forEach(file => {
                                                dropzone.addFile(file);
                                            });
                                        }
                                    });
                                    
                                    console.log('✅ Dropzone inicializado manualmente para:', element.id);
                                }
                            }
                        } catch (error) {
                            console.error('❌ Error al inicializar Dropzone manualmente:', error);
                            console.error(error.stack);
                        }
                    });
                }
            }, 1000);
        } else {
            console.warn('⚠️ HSStaticMethods.autoInit no está disponible');
            console.log('🔍 staticMethods:', staticMethods);
        }
    }
    
    // Esperar a que la página esté completamente cargada
    // El layout ya tiene un script que inicializa Preline UI
    // Esperamos tiempo suficiente para que Preline UI y el helper se carguen
    window.addEventListener('load', function() {
        console.log('🪟 Ventana cargada completamente, iniciando en 2500ms...');
        setTimeout(initFileUploadComponents, 2500);
    });
    
    // Fallback: también intentar después de delays adicionales
    setTimeout(function() {
        console.log('⏰ Timeout 1 (3500ms), verificando dependencias...');
        if (document.readyState === 'complete') {
            initFileUploadComponents();
        }
    }, 3500);
    
    setTimeout(function() {
        console.log('⏰ Timeout 2 (5000ms), verificando dependencias...');
        if (document.readyState === 'complete') {
            initFileUploadComponents();
        }
    }, 5000);
})();
</script>
@endpush
