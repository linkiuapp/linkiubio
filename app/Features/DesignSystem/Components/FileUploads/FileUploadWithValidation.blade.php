{{--
File Upload With Validation - Subida de archivos con validación de tamaño
Uso: Permite subir archivos con validación de tamaño máximo y manejo de errores
Cuándo usar: Cuando necesites validar el tamaño del archivo antes de subirlo
Cuándo NO usar: Cuando no necesites validación de tamaño
Ejemplo: <x-file-upload-with-validation name="image" max-file-size="2" accept="image/*" />
Nota: Este componente requiere Preline UI (HSFileUpload) y Alpine.js para validación
--}}

@props([
    'name' => 'file',
    'maxFileSize' => 2, // MB
    'accept' => '*/*',
    'uniqueId' => null,
    'label' => 'Arrastra tu archivo aquí o',
    'browseText' => 'buscar',
    'helpText' => '',
    'minWidth' => null, // Ancho mínimo en píxeles (opcional)
    'minHeight' => null, // Alto mínimo en píxeles (opcional)
    'requiredWidth' => null, // Ancho exacto requerido (opcional)
    'requiredHeight' => null, // Alto exacto requerido (opcional)
])

@php
    $uniqueId = $uniqueId ?? 'file-upload-' . uniqid();
    $maxFileSizeBytes = $maxFileSize * 1024 * 1024;
    $config = json_encode([
        'url' => '#',
        'maxFilesize' => $maxFileSize,
        'acceptedFiles' => $accept,
        'autoProcessQueue' => false,
        'maxFiles' => 1,
        'extensions' => [
            'default' => [
                'class' => 'shrink-0 size-5'
            ],
            'xls' => [
                'class' => 'shrink-0 size-5'
            ],
            'zip' => [
                'class' => 'shrink-0 size-5'
            ],
            'csv' => [
                'icon' => '<i data-lucide="file-code" class="shrink-0 size-5"></i>',
                'class' => 'shrink-0 size-5'
            ]
        ]
    ]);
@endphp

<div id="{{ $uniqueId }}" 
     data-hs-file-upload='{!! $config !!}'
     data-name="{{ $name }}"
     data-max-size="{{ $maxFileSize }}">
    <template data-hs-file-upload-preview="">
        <div class="p-3 bg-white border border-solid border-gray-300 rounded-xl">
            <div class="mb-1 flex justify-between items-center">
                <div class="flex items-center gap-x-3">
                    <span class="size-10 flex justify-center items-center border border-gray-200 text-gray-500 rounded-lg" data-hs-file-upload-file-icon="">
                        <img class="rounded-lg hidden" data-dz-thumbnail="">
                    </span>
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            <span class="truncate inline-block max-w-75 align-bottom" data-hs-file-upload-file-name=""></span>.<span data-hs-file-upload-file-ext=""></span>
                        </p>
                        <p class="text-xs text-gray-500" data-hs-file-upload-file-size="" data-hs-file-upload-file-success=""></p>
                        <p class="text-xs text-red-500" style="display: none;" data-hs-file-upload-file-error="">El archivo excede el límite de tamaño de {{ $maxFileSize }}MB.</p>
                    </div>
                </div>
                <div class="flex items-center gap-x-2">
                    <span class="inline-block" style="display: none;" data-hs-file-upload-file-error="">
                        <x-tooltip-top text="Por favor intenta subir un archivo menor a {{ $maxFileSize }}MB.">
                            <span class="text-red-500 hover:text-red-800 focus:outline-hidden focus:text-red-800 cursor-pointer">
                                <i data-lucide="alert-circle" class="shrink-0 size-4"></i>
                            </span>
                        </x-tooltip-top>
                    </span>
                    <button type="button" class="text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800" data-hs-file-upload-reload="">
                        <i data-lucide="refresh-cw" class="shrink-0 size-4"></i>
                    </button>
                    <button type="button" class="text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800" data-hs-file-upload-remove="">
                        <i data-lucide="trash-2" class="shrink-0 size-4"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-x-3 whitespace-nowrap">
                <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" data-hs-file-upload-progress-bar="">
                    <div class="flex flex-col justify-center rounded-full overflow-hidden bg-blue-600 text-xs text-white text-center whitespace-nowrap transition-all duration-500 hs-file-upload-complete:bg-green-500" style="width: 0" data-hs-file-upload-progress-bar-pane=""></div>
                </div>
                <div class="w-10 text-end">
                    <span class="text-sm text-gray-800">
                        <span data-hs-file-upload-progress-bar-value="">0</span>%
                    </span>
                </div>
            </div>
        </div>
    </template>

    <div class="cursor-pointer p-12 flex justify-center bg-white border border-dashed border-gray-300 rounded-xl hover:bg-gray-50 transition-colors" data-hs-file-upload-trigger="">
        <div class="text-center">
            <span class="inline-flex justify-center items-center size-16">
                <i data-lucide="image" class="shrink-0 size-16 text-blue-600"></i>
            </span>

            <div class="mt-4 flex flex-wrap justify-center text-sm/6 text-gray-600">
                <span class="pe-1 font-medium text-gray-800">
                    {{ $label }}
                </span>
                <span class="bg-white font-semibold text-blue-600 hover:text-blue-700 rounded-lg decoration-2 hover:underline focus-within:outline-hidden focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2">{{ $browseText }}</span>
            </div>

            <p class="mt-1 text-xs text-gray-400">
                {{ $helpText ?: "Selecciona un archivo de hasta {$maxFileSize}MB." }}
            </p>
        </div>
    </div>

    <div class="mt-4 space-y-2 empty:mt-0" data-hs-file-upload-previews=""></div>
</div>

@push('scripts')
<script>
(function() {
    const uniqueId = '{{ $uniqueId }}';
    const inputName = '{{ $name }}';
    const maxFileSize = {{ $maxFileSize }};
    const minWidth = {{ $minWidth ?? 'null' }};
    const minHeight = {{ $minHeight ?? 'null' }};
    const requiredWidth = {{ $requiredWidth ?? 'null' }};
    const requiredHeight = {{ $requiredHeight ?? 'null' }};
    let hiddenInput = null;
    let initAttempts = 0;
    const maxAttempts = 50; // Máximo 5 segundos de intentos
    let isInitialized = false; // Bandera para evitar inicializaciones múltiples
    
    // Inicializar iconos de Lucide primero
    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
        window.createIcons({ icons: window.lucideIcons });
    } else if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
    
    // Esperar a que Preline UI, Dropzone y lodash estén disponibles
    function initFileUploadWithValidation() {
        // Evitar inicializaciones múltiples
        if (isInitialized) {
            return;
        }
        
        initAttempts++;
        if (initAttempts > maxAttempts) {
            console.error('No se pudo inicializar File Upload después de múltiples intentos');
            return;
        }
        
        const container = document.getElementById(uniqueId);
        if (!container) {
            setTimeout(initFileUploadWithValidation, 100);
            return;
        }
        
        // Verificar que Dropzone y lodash estén disponibles
        if (typeof Dropzone === 'undefined') {
            console.warn('Dropzone no está disponible aún, reintentando...');
            setTimeout(initFileUploadWithValidation, 100);
            return;
        }
        
        if (typeof _ === 'undefined') {
            console.warn('Lodash no está disponible aún, reintentando...');
            setTimeout(initFileUploadWithValidation, 100);
            return;
        }
        
        if (typeof HSFileUpload === 'undefined') {
            console.warn('HSFileUpload no está disponible aún, reintentando...');
            setTimeout(initFileUploadWithValidation, 100);
            return;
        }
        
        try {
            // Verificar si la instancia ya existe
            let instanceResult = HSFileUpload.getInstance('#' + uniqueId, true);
            let instance = null;
            
            // getInstance puede devolver el objeto completo o solo el elemento
            if (instanceResult) {
                if (instanceResult.element) {
                    instance = instanceResult.element;
                } else if (instanceResult.el) {
                    instance = instanceResult;
                } else {
                    // Es solo el elemento, buscar en la colección
                    const collectionItem = window.$hsFileUploadCollection?.find(item => item.element.el === instanceResult);
                    if (collectionItem) {
                        instance = collectionItem.element;
                    }
                }
            }
            
            // Si no existe la instancia, crearla manualmente
            if (!instance || !instance.dropzone) {
                console.log('Creando nueva instancia de HSFileUpload para:', uniqueId);
                try {
                    // Crear nueva instancia directamente
                    const newInstance = new HSFileUpload(container);
                    // Esperar un momento para que se inicialice
                    setTimeout(() => {
                        const createdInstance = window.$hsFileUploadCollection?.find(item => item.element.el === container)?.element;
                        if (createdInstance && createdInstance.dropzone) {
                            setupDropzoneHandlers(createdInstance, container);
                        } else {
                            console.error('No se pudo crear la instancia de HSFileUpload');
                            if (!isInitialized) {
                                setTimeout(initFileUploadWithValidation, 100);
                            }
                        }
                    }, 200);
                    return; // Salir y esperar a que se cree la instancia
                } catch (error) {
                    console.error('Error al crear instancia de HSFileUpload:', error);
                    if (!isInitialized) {
                        setTimeout(initFileUploadWithValidation, 100);
                    }
                    return;
                }
            }
            
            setupDropzoneHandlers(instance, container);
            
        } catch (error) {
            console.error('Error al inicializar File Upload:', error);
            if (!isInitialized) {
                setTimeout(initFileUploadWithValidation, 200);
            }
        }
    }
    
    // Función para configurar los manejadores de Dropzone
    function setupDropzoneHandlers(instance, container) {
        // Evitar configuraciones múltiples
        if (isInitialized) {
            return;
        }
        
        if (!instance || !instance.dropzone) {
            console.error('Instancia no válida para setupDropzoneHandlers');
            return;
        }
        
        if (!container) {
            container = instance.el || document.getElementById(uniqueId);
            if (!container) {
                console.error('No se pudo obtener el contenedor');
                return;
            }
        }
            
        const dropzone = instance.dropzone;
        
        // Crear input oculto DESPUÉS de que Preline UI esté inicializado
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'file';
            hiddenInput.name = inputName;
            hiddenInput.id = uniqueId + '-input';
            hiddenInput.className = 'hidden';
            hiddenInput.setAttribute('accept', '{{ $accept }}');
            // Agregar al formulario, no al contenedor para evitar interferencias
            const form = container.closest('form');
            if (form) {
                form.appendChild(hiddenInput);
            } else {
                container.appendChild(hiddenInput);
            }
        }
        
        // Configurar Dropzone para permitir solo un archivo
        dropzone.options.maxFiles = 1;
        
        // Sincronizar archivos de Dropzone con el input oculto
        dropzone.on('addedfile', (file) => {
            // Limpiar archivos anteriores si hay más de uno
            if (dropzone.files.length > 1) {
                dropzone.files.forEach((existingFile) => {
                    if (existingFile !== file) {
                        dropzone.removeFile(existingFile);
                    }
                });
            }
            
            // Validar dimensiones si se especificaron
            const needsDimensionValidation = (requiredWidth && requiredHeight) || (minWidth && minHeight);
            if (needsDimensionValidation && file.type && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
                    img.onload = () => {
                        let dimensionError = false;
                        let errorMessage = '';
                        
                        // Validar dimensiones exactas si se especificaron
                        if (requiredWidth && requiredHeight) {
                            if (img.width !== requiredWidth || img.height !== requiredHeight) {
                                dimensionError = true;
                                errorMessage = `La imagen debe ser exactamente de ${requiredWidth}x${requiredHeight}px. Tamaño actual: ${img.width}x${img.height}px.`;
                            }
                        }
                        // Validar dimensiones mínimas si se especificaron (y no hay requerimientos exactos)
                        else if (minWidth && minHeight) {
                            if (img.width < minWidth || img.height < minHeight) {
                                dimensionError = true;
                                errorMessage = `La imagen debe tener un mínimo de ${minWidth}x${minHeight}px. Tamaño actual: ${img.width}x${img.height}px.`;
                            }
                        }
                        
                        if (dimensionError) {
                            // Mostrar error de dimensiones
                            const previewElement = file.previewElement;
                            if (previewElement) {
                                // Ocultar mensaje de éxito
                                const successEls = previewElement.querySelectorAll('[data-hs-file-upload-file-success]');
                                successEls.forEach(el => el.style.display = 'none');

                                // Mostrar mensaje de error
                                const errorEls = previewElement.querySelectorAll('[data-hs-file-upload-file-error]');
                                errorEls.forEach(el => {
                                    if (el.tagName === 'P') {
                                        el.textContent = errorMessage;
                                        el.style.display = '';
                                    }
                                });

                                // Mostrar el icono de error con tooltip
                                const errorIconContainer = previewElement.querySelector('span[data-hs-file-upload-file-error]');
                                if (errorIconContainer) {
                                    errorIconContainer.style.display = 'inline-block';
                                }

                                // Limpiar el input oculto
                                if (hiddenInput) {
                                    hiddenInput.value = '';
                                }

                                // Marcar el archivo con estado de error en Dropzone
                                file.accepted = false;
                                file.status = Dropzone.ERROR;
                                dropzone.emit('error', file, errorMessage);
                                dropzone.emit('complete', file);

                                // Inicializar iconos Lucide
                                setTimeout(() => {
                                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                                        window.createIcons({ icons: window.lucideIcons });
                                    }
                                }, 100);
                            }
                        } else {
                            // Dimensiones válidas, proceder normalmente
                            completeFileUpload(file, e.target.result);
                        }
                    };
                    img.onerror = () => {
                        // Si no se puede cargar la imagen, proceder de todas formas
                        completeFileUpload(file, e.target.result);
                    };
                    img.src = e.target.result;
                };
                reader.onerror = () => {
                    // Si hay error al leer, proceder de todas formas
                    completeFileUpload(file, null);
                };
                reader.readAsDataURL(file);
            } else {
                // No hay validación de dimensiones, proceder normalmente
                completeFileUpload(file, null);
            }
        });

        dropzone.on('removedfile', (file) => {
            document.dispatchEvent(new CustomEvent('file-upload:removed', {
                detail: {
                    name: inputName,
                    fileName: file?.name ?? null,
                },
            }));
        });
        
        // Función para completar la subida del archivo
        function completeFileUpload(file, base64Preview) {
            // Si el archivo ya fue marcado con error, no continuar
            if (file.status === Dropzone.ERROR) {
                return;
            }
            // Simular progreso al 100% inmediatamente ya que no hay subida real
            // Esto hace que la barra de progreso se complete visualmente
            setTimeout(() => {
                const previewElement = file.previewElement;
                if (previewElement) {
                    const progressBar = previewElement.querySelector('[data-hs-file-upload-progress-bar]');
                    const progressBarPane = previewElement.querySelector('[data-hs-file-upload-progress-bar-pane]');
                    const progressBarValue = previewElement.querySelector('[data-hs-file-upload-progress-bar-value]');
                    
                    if (progressBar) {
                        progressBar.setAttribute('aria-valuenow', '100');
                    }
                    if (progressBarPane) {
                        progressBarPane.style.width = '100%';
                        progressBarPane.classList.add('bg-green-500');
                    }
                    if (progressBarValue) {
                        progressBarValue.textContent = '100';
                    }
                    
                    // Marcar como completo
                    previewElement.classList.add('complete');
                }
            }, 100);
            
            // Actualizar el input oculto usando DataTransfer
            if (hiddenInput) {
                try {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    hiddenInput.files = dataTransfer.files;
                } catch (e) {
                    console.warn('No se pudo actualizar el input file:', e);
                }
            }

            // Leer el archivo y asignarlo al input oculto
            const reader = new FileReader();
            reader.onload = (event) => {
                const detailPayload = {
                    name: inputName,
                    file: file,
                    base64: base64Preview || null,
                };

                if (!detailPayload.base64) {
                    const previewReader = new FileReader();
                    previewReader.onload = (event) => {
                        detailPayload.base64 = event.target?.result || null;
                        document.dispatchEvent(new CustomEvent('file-upload:selected', {
                            detail: detailPayload,
                        }));
                    };
                    previewReader.readAsDataURL(file);
                } else {
                    document.dispatchEvent(new CustomEvent('file-upload:selected', {
                        detail: detailPayload,
                    }));
                }
            };
            reader.readAsDataURL(file);
        }
        
        // Limpiar input cuando se remueve el archivo
        dropzone.on('error', (file, response) => {
            if (file.size > maxFileSize * 1024 * 1024) {
                const successEls = container.querySelectorAll('[data-hs-file-upload-file-success]');
                const errorEls = container.querySelectorAll('[data-hs-file-upload-file-error]');

                successEls.forEach((el) => el.style.display = 'none');
                errorEls.forEach((el) => el.style.display = '');
                
                // Inicializar iconos Lucide en el tooltip después de mostrar errores
                setTimeout(() => {
                    if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                        window.createIcons({ icons: window.lucideIcons });
                    } else if (typeof lucide !== 'undefined' && lucide.createIcons) {
                        lucide.createIcons();
                    }
                }, 100);
            }
        });
        
        // Reinicializar iconos después de que todo esté listo
        setTimeout(() => {
            if (typeof window.createIcons !== 'undefined' && typeof window.lucideIcons !== 'undefined') {
                window.createIcons({ icons: window.lucideIcons });
            } else if (typeof lucide !== 'undefined' && lucide.createIcons) {
                lucide.createIcons();
            }
        }, 500);
        
        // Marcar como inicializado para evitar duplicados
        isInitialized = true;
        console.log('✅ File Upload inicializado correctamente');
    }
    
    // Forzar inicialización de Preline UI si es necesario
    function forcePrelineInit() {
        if (typeof HSStaticMethods !== 'undefined' && HSStaticMethods.autoInit) {
            HSStaticMethods.autoInit(['file-upload']);
        } else if (typeof HSFileUpload !== 'undefined' && HSFileUpload.autoInit) {
            HSFileUpload.autoInit();
        }
    }
    
    // Función para esperar a que Preline UI esté completamente cargado
    function waitForPrelineUI(callback, maxWait = 10000) {
        const startTime = Date.now();
        const checkInterval = setInterval(() => {
            if (typeof window.HSFileUpload !== 'undefined' && 
                typeof window.Dropzone !== 'undefined' && 
                typeof window._ !== 'undefined') {
                clearInterval(checkInterval);
                console.log('✅ Preline UI está disponible');
                callback();
            } else if (Date.now() - startTime > maxWait) {
                clearInterval(checkInterval);
                console.error('❌ Timeout esperando Preline UI');
            }
        }, 100);
    }
    
    // Iniciar después de que el DOM esté listo y Preline UI se haya cargado
    function startInit() {
        // Evitar múltiples inicializaciones
        if (isInitialized) {
            return;
        }
        
        waitForPrelineUI(() => {
            // Forzar inicialización de Preline UI primero
            forcePrelineInit();
            
            // Esperar un poco más para que Preline UI se inicialice automáticamente
            setTimeout(() => {
                forcePrelineInit();
                initFileUploadWithValidation();
            }, 500);
        });
    }
    
    // Inicializar solo una vez cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startInit, { once: true });
    } else {
        startInit();
    }
    
    // También escuchar el evento de carga completa como respaldo
    window.addEventListener('load', () => {
        if (!isInitialized) {
            startInit();
        }
    }, { once: true });
})();
</script>
@endpush

