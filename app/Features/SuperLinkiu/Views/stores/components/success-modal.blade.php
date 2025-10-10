{{-- ================================================================ --}}
{{-- ENHANCED CREDENTIAL MODAL - Tienda Creada (Auto-aprobada) --}}
{{-- ================================================================ --}}

@if(session('admin_credentials') && session('store_auto_approved'))
{{-- Debug script para verificar que se ejecute --}}
<script>
console.log('🟢 SUCCESS MODAL: Modal de éxito detectado en DOM');
console.log('📊 SUCCESS MODAL: Credenciales disponibles:', @json(session('admin_credentials')));
</script>

<x-superlinkiu::enhanced-credential-modal
    :credentials="session('admin_credentials')"
    :show="true"
/>
@endif

{{-- ================================================================ --}}
{{-- PENDING REVIEW MODAL - Tienda en Revisión --}}
{{-- ================================================================ --}}

@if(session('store_pending_review'))
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" 
     id="pending-review-modal"
     x-data="{ open: true }"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white"
         @click.away="open = false">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-6 border-b pb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">⏳ Solicitud en Revisión</h3>
                    <p class="text-sm text-gray-600">Tienda: {{ session('store_name') }}</p>
                </div>
            </div>
            <button @click="open = false" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Content -->
        <div class="mb-6">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-yellow-800 mb-2">
                    <strong>📋 La solicitud de tienda ha sido creada exitosamente.</strong>
                </p>
                <p class="text-sm text-yellow-700">
                    Esta tienda requiere <strong>revisión manual</strong> antes de ser activada. Nuestro equipo verificará la información y el documento fiscal proporcionado.
                </p>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Tiempo de revisión</p>
                        <p class="text-xs text-gray-600">Máximo 6 horas en horario laboral</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Notificación por email</p>
                        <p class="text-xs text-gray-600">Recibirás un correo cuando la tienda sea aprobada o rechazada</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Monitoreo en tiempo real</p>
                        <p class="text-xs text-gray-600">Puedes revisar el estado en la sección "Solicitudes de Tiendas"</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="flex justify-end gap-3 pt-4 border-t">
            <a href="{{ route('superlinkiu.store-requests.show', session('store_id')) }}" 
               class="btn-outline-primary px-4 py-2 rounded-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                </svg>
                Ver Solicitud
            </a>
            <button @click="open = false" 
                    class="btn-primary px-4 py-2 rounded-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Entendido
            </button>
        </div>
    </div>
</div>

<script>
console.log('🟢 PENDING REVIEW MODAL: Modal de revisión pendiente detectado en DOM');
console.log('📊 PENDING REVIEW MODAL: Store ID:', '{{ session("store_id") }}');
</script>
@endif 