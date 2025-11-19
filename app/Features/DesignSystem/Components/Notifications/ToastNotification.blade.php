{{--
ToastNotification - Notificación toast temporal
Uso: Mostrar notificaciones temporales de éxito, error, info, etc.
Cuándo usar: Para feedback de acciones (éxito, error, info)
Cuándo NO usar: Para confirmaciones (usar ModalConfirm)
Ejemplo: 
<div x-data="toastNotification('success', 'Operación exitosa', 'El pedido fue cancelado')"></div>
--}}

@props([
    'id' => null,
])

@php
    $uniqueId = $id ?? 'toast-' . uniqid();
@endphp

<div id="{{ $uniqueId }}" 
     x-data="{ show: false, type: 'success', title: '', message: '' }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-x-full"
     x-transition:enter-end="opacity-100 translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-x-0"
     x-transition:leave-end="opacity-0 translate-x-full"
     class="fixed top-4 right-4 z-[10000] max-w-sm w-full"
     style="display: none;">
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4"
         x-bind:class="{
             'border-teal-200': type === 'success',
             'border-red-200': type === 'error',
             'border-blue-200': type === 'info',
             'border-yellow-200': type === 'warning'
         }">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center"
                     x-bind:class="{
                         'bg-teal-100': type === 'success',
                         'bg-red-100': type === 'error',
                         'bg-blue-100': type === 'info',
                         'bg-yellow-100': type === 'warning'
                     }">
                    <i data-lucide="check-circle" 
                       x-show="type === 'success'"
                       class="w-5 h-5 text-teal-600"
                       x-bind:data-lucide="type === 'success' ? 'check-circle' : (type === 'error' ? 'x-circle' : (type === 'warning' ? 'alert-triangle' : 'info'))"></i>
                    <i data-lucide="x-circle" 
                       x-show="type === 'error'"
                       class="w-5 h-5 text-red-600"></i>
                    <i data-lucide="alert-triangle" 
                       x-show="type === 'warning'"
                       class="w-5 h-5 text-yellow-600"></i>
                    <i data-lucide="info" 
                       x-show="type === 'info'"
                       class="w-5 h-5 text-blue-600"></i>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-gray-900" x-text="title"></h4>
                <p class="text-sm text-gray-600 mt-1" x-text="message"></p>
            </div>
            <button @click="show = false" 
                    class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Función global para mostrar toast
window.showToast = function(type, title, message, duration = 3000) {
    const toastId = 'toast-notification';
    let toast = document.getElementById(toastId);
    
    if (!toast) {
        // Crear toast si no existe
        toast = document.createElement('div');
        toast.id = toastId;
        toast.setAttribute('x-data', '{ show: false, type: \'success\', title: \'\', message: \'\' }');
        toast.setAttribute('x-show', 'show');
        toast.setAttribute('x-transition:enter', 'transition ease-out duration-300');
        toast.setAttribute('x-transition:enter-start', 'opacity-0 translate-x-full');
        toast.setAttribute('x-transition:enter-end', 'opacity-100 translate-x-0');
        toast.setAttribute('x-transition:leave', 'transition ease-in duration-200');
        toast.setAttribute('x-transition:leave-start', 'opacity-100 translate-x-0');
        toast.setAttribute('x-transition:leave-end', 'opacity-0 translate-x-full');
        toast.className = 'fixed top-4 right-4 z-[10000] max-w-sm w-full';
        toast.style.display = 'none';
        
        toast.innerHTML = `
            <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-4"
                 x-bind:class="{
                     'border-teal-200': type === 'success',
                     'border-red-200': type === 'error',
                     'border-blue-200': type === 'info',
                     'border-yellow-200': type === 'warning'
                 }">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center"
                             x-bind:class="{
                                 'bg-teal-100': type === 'success',
                                 'bg-red-100': type === 'error',
                                 'bg-blue-100': type === 'info',
                                 'bg-yellow-100': type === 'warning'
                             }">
                            <i data-lucide="check-circle" x-show="type === 'success'" class="w-5 h-5 text-teal-600"></i>
                            <i data-lucide="x-circle" x-show="type === 'error'" class="w-5 h-5 text-red-600"></i>
                            <i data-lucide="alert-triangle" x-show="type === 'warning'" class="w-5 h-5 text-yellow-600"></i>
                            <i data-lucide="info" x-show="type === 'info'" class="w-5 h-5 text-blue-600"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900" x-text="title"></h4>
                        <p class="text-sm text-gray-600 mt-1" x-text="message"></p>
                    </div>
                    <button @click="show = false" 
                            class="flex-shrink-0 p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Inicializar Alpine.js en el nuevo elemento
        if (typeof Alpine !== 'undefined') {
            Alpine.initTree(toast);
        }
    }
    
    // Obtener el componente Alpine
    const alpineData = Alpine.$data(toast);
    if (alpineData) {
        alpineData.type = type;
        alpineData.title = title;
        alpineData.message = message;
        alpineData.show = true;
        
        // Auto-ocultar después de duration
        setTimeout(() => {
            alpineData.show = false;
        }, duration);
    }
    
    // Reinicializar iconos Lucide
    setTimeout(() => {
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        }
    }, 100);
};
</script>
@endpush

