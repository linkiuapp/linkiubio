{{--
Modal Master Key - Modal para solicitar clave maestra
Uso: Modal para acciones protegidas que requieren clave maestra
Cuándo usar: Cuando una acción esté protegida por clave maestra
Cuándo NO usar: Cuando la acción no requiera protección
Ejemplo: 
<x-modal-master-key 
    modalId="master-key-modal"
    action="orders.cancel"
    actionLabel="Cancelar pedido #123"
    :onVerify="function() { cancelOrder(); }"
/>
--}}

@props([
    'modalId' => null,
    'action' => '',
    'actionLabel' => 'Acción protegida',
    'onVerify' => null,
])

@php
    $uniqueId = $modalId ?? 'modal-master-key-' . uniqid();
    $storeSlug = request()->route('store')?->slug ?? '';
@endphp

<div x-data="masterKeyModal('{{ $uniqueId }}', '{{ $action }}', '{{ $actionLabel }}', '{{ $storeSlug }}')" 
     x-init="init()">
    
    {{-- Modal Overlay --}}
    <div 
        x-show="open"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[99998] bg-black/50 backdrop-blur-sm"
        style="display: none;"
        @click="close()"
    ></div>

    {{-- Modal Content --}}
    <div 
        x-show="open"
        class="fixed inset-0 z-[99998] overflow-x-hidden overflow-y-auto pointer-events-none"
        role="dialog"
        tabindex="-1"
        style="display: none;"
    >
        <div 
            class="sm:max-w-lg sm:w-full m-3 sm:mx-auto pointer-events-none min-h-[calc(100%-56px)] flex items-center"
            x-transition:enter="transition-all ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition-all ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <div 
                @click.stop
                class="w-full flex flex-col bg-white border border-gray-200 shadow-xl rounded-lg pointer-events-auto"
            >
                {{-- Header --}}
                <div class="flex items-start gap-4 p-6 border-b border-gray-200">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <i data-lucide="lock-keyhole" class="w-6 h-6 text-yellow-600"></i>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            Clave Maestra Requerida
                        </h3>
                        <div class="text-sm text-gray-600 space-y-2">
                            <p>Esta acción está protegida:</p>
                            <p class="font-bold text-gray-900" x-text="actionLabel"></p>
                            <p class="mt-2">Ingresa la clave maestra para continuar</p>
                        </div>
                    </div>
                    <button 
                        type="button" 
                        class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors" 
                        aria-label="Cerrar"
                        @click="close()"
                        :disabled="loading"
                    >
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                {{-- Body --}}
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="{{ $uniqueId }}-key" class="block text-sm font-medium text-gray-700 mb-2">
                                Clave Maestra
                            </label>
                            <input 
                                type="password"
                                id="{{ $uniqueId }}-key"
                                x-model="masterKey"
                                @keydown.enter="verify()"
                                :disabled="loading"
                                placeholder="********"
                                maxlength="8"
                                autocomplete="off"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-center text-lg tracking-widest font-mono focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                            <p x-show="error" x-text="error" class="mt-2 text-sm text-red-600"></p>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end items-center gap-3 p-6 border-t border-gray-200">
                    <button 
                        type="button" 
                        @click="close()"
                        :disabled="loading"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" 
                    >
                        Cancelar
                    </button>
                    <button 
                        type="button" 
                        @click="verify()"
                        :disabled="loading || !masterKey"
                        class="px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 min-w-[130px] shadow-sm"
                        :class="loading ? 'bg-gray-600' : 'bg-gray-900 hover:bg-gray-800'"
                    >
                        <svg x-show="loading" 
                             x-transition:enter="transition-opacity duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition-opacity duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="animate-spin h-4 w-4 text-white" 
                             xmlns="http://www.w3.org/2000/svg" 
                             fill="none" 
                             viewBox="0 0 24 24"
                             style="display: none;">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="loading ? 'Verificando...' : 'Verificar'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Definir la función del modal primero
function masterKeyModal(modalId, action, actionLabel, storeSlug) {
    return {
        open: false,
        loading: false,
        masterKey: '',
        error: '',
        action: action,
        actionLabel: actionLabel,
        storeSlug: storeSlug,
        callback: null,

        init() {
            // Registrar este modal globalmente inmediatamente
            window[`masterKeyModal_${modalId}`] = this;
            // También registrar con el ID estándar si es el modal principal
            if (modalId === 'master-key-modal') {
                window.masterKeyModalInstance = this;
            }
        },

        show(callback, newActionLabel = null) {
            this.callback = callback;
            if (newActionLabel) {
                this.actionLabel = newActionLabel;
            }
            this.open = true;
            this.masterKey = '';
            this.error = '';
            this.loading = false;
            
            // Focus en el input después de la animación
            setTimeout(() => {
                const input = document.getElementById(`${modalId}-key`);
                if (input) {
                    input.focus();
                }
            }, 300);
        },

        close() {
            // Permitir cerrar incluso si está cargando (para casos de error)
            this.open = false;
            this.masterKey = '';
            this.error = '';
            this.loading = false;
            this.callback = null;
        },

        async verify() {
            if (!this.masterKey || this.loading) return;

            this.loading = true;
            this.error = '';

            try {
                const response = await fetch(`/${this.storeSlug}/admin/master-key/verify`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        key: this.masterKey,
                        action: this.action
                    })
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    this.error = data.message || 'Clave incorrecta';
                    this.loading = false;
                    return;
                }

                // Clave correcta, guardar callback antes de resetear
                const callbackToExecute = this.callback;
                
                // Resetear estado de loading primero
                this.loading = false;
                
                // Cerrar modal (esto resetea todo el estado)
                this.open = false;
                this.masterKey = '';
                this.error = '';
                
                // Ejecutar callback después de que el modal se haya cerrado completamente
                // Delay suficiente para la animación de cierre (300ms)
                setTimeout(() => {
                    // Limpiar callback después de ejecutarlo
                    const cb = callbackToExecute;
                    this.callback = null;
                    
                    if (cb && typeof cb === 'function') {
                        cb();
                    }
                }, 350);
            } catch (error) {
                this.error = 'Error de conexión. Intenta de nuevo.';
                this.loading = false;
            }
        }
    };
}

// Sobrescribir requireMasterKey después de que Alpine inicialice el componente
// Esperar a que Alpine esté listo y el componente se haya inicializado
document.addEventListener('alpine:init', () => {
    // Esperar un momento para que Alpine termine de inicializar todos los componentes
    setTimeout(() => {
        // Guardar la función original de app.js
        const originalRequireMasterKey = window.requireMasterKey;
        
        // Sobrescribir con la nueva función que usa el modal del DesignSystem
        window.requireMasterKey = async function(action, actionLabel, callback) {
            const modalId = 'master-key-modal';
            const modal = window[`masterKeyModal_${modalId}`];
            
            // Intentar usar el modal del DesignSystem primero
            if (modal && typeof modal.show === 'function') {
                modal.show(callback, actionLabel);
                return;
            }
            
            // Fallback: usar la función original (SweetAlert) si el modal no está disponible
            if (originalRequireMasterKey && typeof originalRequireMasterKey === 'function') {
                return originalRequireMasterKey(action, actionLabel, callback);
            }
        };
    }, 500); // Esperar 500ms para que Alpine inicialice completamente
});
</script>
@endpush

