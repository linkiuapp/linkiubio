// File Upload Helpers - Cargar Dropzone y lodash globalmente para Preline UI
import Dropzone from 'dropzone';
import _ from 'lodash';

// Hacer disponibles globalmente ANTES de importar Preline UI
window.Dropzone = Dropzone;
window._ = _;

// Deshabilitar auto-descubrimiento de Dropzone (Preline UI lo maneja)
Dropzone.autoDiscover = false;

// Importar Preline UI DESPUÉS de que las dependencias estén disponibles
import('preline/dist/index.mjs').then((Preline) => {
    // Exponer componentes de Preline UI globalmente
    if (Preline.HSFileUpload) {
        window.HSFileUpload = Preline.HSFileUpload;
    }
    if (Preline.HSStaticMethods) {
        window.HSStaticMethods = Preline.HSStaticMethods;
    }
    
    // Auto-inicializar componentes de file upload
    if (Preline.HSFileUpload && typeof Preline.HSFileUpload.autoInit === 'function') {
        // Esperar a que el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                Preline.HSFileUpload.autoInit();
            });
        } else {
            Preline.HSFileUpload.autoInit();
        }
    }
    
    console.log('✅ Dropzone, Lodash y Preline UI cargados globalmente');
}).catch((error) => {
    console.error('❌ Error cargando Preline UI:', error);
});

