
console.log('🟢 Starting app.js execution...');

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import confetti from 'canvas-confetti'

console.log('🟢 Imports loaded successfully');

import Pusher from 'pusher-js'

// Hacer confetti disponible globalmente
window.confetti = confetti

// Sistema de carrito - Solo cargar en storefront
if (window.location.pathname.includes('/admin') === false && 
    window.location.pathname.includes('/superlinkiu') === false &&
    window.location.pathname !== '/' &&
    window.location.pathname !== '/login' &&
    window.location.pathname !== '/register') {
    import('./cart.js').then(() => {
        console.log('🛒 Cart.js loaded for storefront');
    }).catch(error => {
        console.log('ℹ️ Cart.js not loaded (not in storefront):', error.message);
    });
}

console.log('🟢 Pusher imported successfully');

// Configurar Pusher DIRECTAMENTE (sin Laravel Echo para evitar auth automática)
console.log('🚀 Initializing Pusher...');
console.log('📊 VITE_PUSHER_APP_CLUSTER:', import.meta.env.VITE_PUSHER_APP_CLUSTER);

try {
    window.Pusher = Pusher
    console.log('🟢 Pusher class assigned to window');
    
    window.pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
        forceTLS: true,
        enabledTransports: ['ws', 'wss'],
        disableStats: true,
        maxReconnectionAttempts: 3
    })
    
    console.log('✅ Pusher initialized successfully:', window.pusher);
    
    // Crear objeto Echo-like para compatibilidad
    window.Echo = {
        channel: function(channelName) {
            console.log('📡 Subscribing to channel:', channelName);
            const channel = window.pusher.subscribe(channelName)
            return {
                listen: function(eventName, callback) {
                    // Remover el punto inicial si existe (.ticket.response.added -> ticket.response.added)
                    const cleanEventName = eventName.startsWith('.') ? eventName.substring(1) : eventName
                    console.log('👂 Listening for event:', cleanEventName);
                    channel.bind(cleanEventName, callback)
                    return this
                }
            }
        }
    }
    
    console.log('✅ Echo-like object created:', window.Echo);
    
} catch (error) {
    console.error('❌ Error initializing Pusher:', error);
}

console.log('🟢 About to import component files...');

// Importar archivos de componentes y funcionalidades
try {
    import('./components.js')
    console.log('🟢 components.js imported');
    
    import('./navbar.js')
    console.log('🟢 navbar.js imported');
    
    import('./sidebar.js')
    console.log('🟢 sidebar.js imported');
    
    import('./envios.js')
    console.log('🟢 envios.js imported');
    
    import('./tickets.js')
    console.log('🟢 tickets.js imported');
    
    import('./store.js')
    console.log('🟢 store.js imported');
    
    import('./components/wizard-navigation.js')
    console.log('🟢 wizard-navigation.js imported');
    
    import('./components/wizard-step.js')
    console.log('🟢 wizard-step.js imported');
    
    import('./components/wizard-state-manager.js')
    console.log('🟢 wizard-state-manager.js imported');
    
    import('./notifications.js')
    console.log('🟢 notifications.js imported');
    
    // 🛡️ Sistema de seguridad (auto-inicializa en producción)
    import('./security.js')
    console.log('🛡️ security.js imported');
    
} catch (error) {
    console.error('❌ Error importing component files:', error);
}

console.log('🟢 Setting up Alpine...');

// DEFINICIONES SIMPLES PARA EVITAR ERRORES
document.addEventListener('alpine:init', () => {
    // Definir storeManagement
    Alpine.data('storeManagement', () => ({
        selectedStores: [],
        showDeleteModal: false,
        deleteStoreId: null,
        deleteStoreName: '',
        showNotification: false,
        notificationMessage: '',
        notificationType: 'success',
        
        showNotificationMessage(message, type = 'success') {
            this.notificationMessage = message;
            this.notificationType = type;
            this.showNotification = true;
            setTimeout(() => { this.showNotification = false; }, 5000);
        },
        
        openDeleteModal(storeIdentifier, storeName) {
            console.log('🗑️ MODAL DELETE: Abriendo modal para tienda:', storeName, 'Identifier:', storeIdentifier);
            this.deleteStoreId = storeIdentifier; // Puede ser ID o slug
            this.deleteStoreName = storeName;
            this.showDeleteModal = true;
        },
        
        closeDeleteModal() {
            console.log('🗑️ MODAL DELETE: Cerrando modal');
            this.showDeleteModal = false;
            this.deleteStoreId = null;
            this.deleteStoreName = '';
        },
        
        confirmDelete() {
            console.log('🗑️ MODAL DELETE: Confirmando eliminación de tienda ID:', this.deleteStoreId);
            if (this.deleteStoreId) {
                // Crear y enviar formulario de eliminación
                const form = document.createElement('form');
                form.method = 'POST';
                
                // Corregir URL: debe ir a /superlinkiu/stores/{id} no /stores/{id}
                const baseUrl = window.location.origin;
                form.action = `${baseUrl}/superlinkiu/stores/${this.deleteStoreId}`;
                
                console.log('🗑️ MODAL DELETE: URL generada:', form.action);
                
                // Token CSRF
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken.content;
                    form.appendChild(csrfInput);
                } else {
                    console.error('❌ MODAL DELETE: Token CSRF no encontrado en meta tag');
                    // Intentar obtener de otro lugar
                    const altToken = document.querySelector('input[name="_token"]');
                    if (altToken) {
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = altToken.value;
                        form.appendChild(csrfInput);
                    } else {
                        console.error('❌ MODAL DELETE: No se encontró token CSRF en ningún lugar');
                        alert('Error: Token CSRF no encontrado. Recarga la página e intenta de nuevo.');
                        return;
                    }
                }
                
                // Método DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        },
        
        async loginAsStore(storeId) {
            console.log('🔑 LOGIN AS STORE: Función llamada para tienda ID:', storeId);
            
            if (!confirm('¿Deseas entrar como administrador de esta tienda?\n\nSe abrirá una nueva pestaña con el dashboard del admin.')) {
                return;
            }

            try {
                // Llamar al backend para generar token
                const response = await fetch(`/superlinkiu/stores/${storeId}/generate-admin-token`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.url) {
                    // Abrir en nueva pestaña
                    console.log('✅ TOKEN GENERADO: Abriendo nueva pestaña...', data.url);
                    window.open(data.url, '_blank');
                } else if (data.error) {
                    alert('Error: ' + data.error);
                    console.error('❌ ERROR:', data.error);
                }
            } catch (error) {
                console.error('❌ ERROR al generar token:', error);
                alert('Error al abrir la tienda. Por favor intenta de nuevo.');
            }
        },
        
        init() {
            console.log('🟢 STORE MANAGEMENT: Componente Alpine inicializado correctamente');
        }
    }));
});

Alpine.plugin(collapse)
window.Alpine = Alpine
Alpine.start()

console.log('🟢 Alpine started successfully')

// Función global para login as store (disponible en window)
window.handleLoginAsStore = async function(storeSlug) {
    console.log('🔑 GLOBAL LOGIN AS STORE: Función llamada para tienda SLUG:', storeSlug);
    
    const message = '¿Deseas entrar como administrador de esta tienda?\n\n' +
        '⚠️ IMPORTANTE: Se cerrará tu sesión de SuperAdmin en esta pestaña.\n\n' +
        '💡 RECOMENDACIÓN: Abre esta pestaña en modo incógnito primero\n' +
        '   (Ctrl+Shift+N en Chrome/Edge) para mantener tu sesión.\n\n' +
        '¿Continuar de todos modos?';
    
    if (!confirm(message)) {
        return;
    }

    try {
        // Llamar al backend para generar token
        const response = await fetch(`/superlinkiu/stores/${storeSlug}/generate-admin-token`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();

        if (data.url) {
            // Abrir en nueva pestaña
            console.log('✅ TOKEN GENERADO: Abriendo nueva pestaña...', data.url);
            
            // Intentar abrir en ventana nueva (NO incógnito, pero sí nueva ventana)
            const width = 1200;
            const height = 800;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;
            
            window.open(
                data.url, 
                'preview_' + Date.now(),
                `width=${width},height=${height},left=${left},top=${top},menubar=yes,toolbar=yes,location=yes,status=yes,scrollbars=yes,resizable=yes`
            );
        } else if (data.error) {
            alert('Error: ' + data.error);
            console.error('❌ ERROR:', data.error);
        }
    } catch (error) {
        console.error('❌ ERROR al generar token:', error);
        alert('Error al abrir la tienda. Por favor intenta de nuevo.');
    }
};

// ==========================================
// Sistema de Clave Maestra
// ==========================================

/**
 * Solicitar clave maestra antes de ejecutar una acción
 * @param {string} action - La acción a proteger (ej: 'orders.delete')
 * @param {string} actionLabel - Etiqueta descriptiva de la acción
 * @param {function} callback - Función a ejecutar si la clave es correcta
 */
window.requireMasterKey = async function(action, actionLabel, callback) {
    // Obtener el slug de la tienda desde la URL
    const storeSlug = window.location.pathname.split('/')[1];
    
    // Paso 1: Pedir clave maestra
    const result = await Swal.fire({
        title: '🔐 Clave Maestra Requerida',
        html: `
            <div class="text-body-small text-black-400 mb-4">
                <p>Esta acción está protegida:</p>
                <p class="font-bold text-black-500 mt-2">${actionLabel}</p>
                <p class="mt-3">Ingresa la clave maestra para continuar</p>
            </div>
        `,
        input: 'password',
        inputPlaceholder: 'Ingresa la clave maestra',
        inputAttributes: {
            autocapitalize: 'off',
            autocomplete: 'off',
            maxlength: 8,
            class: 'text-center text-h6 tracking-widest'
        },
        showCancelButton: true,
        confirmButtonText: 'Verificar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#da27a7',
        cancelButtonColor: '#001b48',
        showLoaderOnConfirm: true,
        preConfirm: async (key) => {
            try {
                // Verificar clave con backend
                const response = await fetch(`/${storeSlug}/admin/master-key/verify`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ key, action })
                });
                
                const data = await response.json();
                
                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Clave incorrecta');
                }
                
                return data;
            } catch (error) {
                Swal.showValidationMessage(error.message);
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    });

    if (!result.isConfirmed) {
        return; // Usuario canceló
    }

    // Paso 2: Clave correcta, ejecutar callback
    callback();
};
