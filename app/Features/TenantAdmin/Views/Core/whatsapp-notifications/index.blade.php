<x-tenant-admin-layout :store="$store">
    @section('title', 'Notificaciones WhatsApp')
    
    @section('content')
    <div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="whatsappNotifications()" x-init="init()">
        <x-toast-notification />
        
        {{-- SECTION: Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Notificaciones WhatsApp</h1>
                <p class="text-sm text-gray-600 mt-1">
                    Configura tu número para recibir notificaciones automáticas sobre pedidos, reservas y pagos
                </p>
            </div>
        </div>
        {{-- End SECTION: Header --}}
        
        {{-- Auto-iniciar tour --}}
        <x-tour-trigger tour="notificaciones_whatsapp" :autoStart="true" :showButton="false" />
        
        {{-- SECTION: Grid de Configuración --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- SECTION: Configuración Principal Card --}}
            <x-card-base shadow="sm" data-tour="whatsapp-config">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="message-circle" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Número de WhatsApp</h3>
                        <p class="text-xs text-gray-600 mt-0.5">Tu número para recibir notificaciones</p>
                    </div>
                </div>
                
                <form 
                    action="{{ route('tenant.admin.whatsapp-notifications.update', ['store' => $store->slug]) }}" 
                    @submit.prevent="submitForm" 
                    class="space-y-4"
                >
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="owner_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Número de WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium z-10">+57</span>
                            <input 
                                type="text" 
                                id="owner_phone" 
                                name="owner_phone"
                                data-tour="owner-phone-input" 
                                value="{{ old('owner_phone', $store->owner_phone) }}"
                                placeholder="3001234567"
                                maxlength="10"
                                pattern="[0-9]{10}"
                                class="w-full pl-12 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm @error('owner_phone') border-red-300 @enderror"
                                required
                            />
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Ingresa tu número de celular (10 dígitos) sin espacios ni guiones
                        </p>
                        @error('owner_phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button 
                            type="submit" 
                            data-tour="save-button" 
                            x-bind:disabled="loading"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 focus:bg-gray-900 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-sm font-medium"
                        >
                            <i data-lucide="save" class="w-4 h-4"></i>
                            <span x-text="loading ? 'Guardando...' : 'Guardar Configuración'"></span>
                        </button>
                    </div>
                </form>
            </x-card-base>
            {{-- End SECTION: Configuración Principal Card --}}
            
            {{-- SECTION: Notificaciones que Recibirás Card --}}
            <x-card-base shadow="sm" data-tour="notificaciones-propietario">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="bell" class="w-6 h-6 text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Notificaciones que recibirás</h3>
                        <p class="text-xs text-gray-600 mt-0.5">Alertas automáticas en tu WhatsApp</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <i data-lucide="shopping-cart" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Nuevo pedido</p>
                            <p class="text-xs text-gray-600">Cuando un cliente realiza un pedido</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <i data-lucide="file-check" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Comprobante recibido</p>
                            <p class="text-xs text-gray-600">Cuando un cliente sube un comprobante de pago</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                        <i data-lucide="calendar" class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Nueva reserva</p>
                            <p class="text-xs text-gray-600">Cuando se solicita una reserva (mesas/hotel)</p>
                        </div>
                    </div>
                </div>
            </x-card-base>
            {{-- End SECTION: Notificaciones que Recibirás Card --}}
        </div>
        {{-- End SECTION: Grid de Configuración --}}
        
        {{-- SECTION: Notificaciones a Clientes Card --}}
        <x-card-base shadow="sm" data-tour="notificaciones-clientes">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-indigo-600"></i>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Notificaciones automáticas a clientes</h3>
                    <p class="text-xs text-gray-600 mt-0.5">Mensajes que tus clientes recibirán automáticamente</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Confirmación de pedido</p>
                        <p class="text-xs text-gray-600">Al crear el pedido</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <i data-lucide="refresh-cw" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Cambios de estado</p>
                        <p class="text-xs text-gray-600">Cuando el pedido cambia de estado</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <i data-lucide="calendar-check" class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Confirmación de reserva</p>
                        <p class="text-xs text-gray-600">Cuando se confirma una reserva</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <i data-lucide="clock" class="w-5 h-5 text-orange-600 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Recordatorios</p>
                        <p class="text-xs text-gray-600">24h antes de reservas</p>
                    </div>
                </div>
            </div>
        </x-card-base>
        {{-- End SECTION: Notificaciones a Clientes Card --}}
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('whatsappNotifications', function() {
                return {
                    loading: false,
                    
                    init() {
                        @if(session('success'))
                        if (window.toast) {
                            window.toast.success(
                                'Actualización exitosa',
                                '{{ session('success') }}',
                                5000,
                                'bottom-center'
                            );
                        }
                        @endif

                        @if(session('error'))
                        if (window.toast) {
                            window.toast.error(
                                'Error',
                                '{{ session('error') }}',
                                5000,
                                'bottom-center'
                            );
                        }
                        @endif
                    },
                    
                    async submitForm(event) {
                        event.preventDefault();
                        this.loading = true;
                        
                        const form = event.target;
                        const formData = new FormData(form);
                        const url = form.action;
                        
                        try {
                            // Agregar el método PUT al FormData para que Laravel lo reconozca
                            formData.append('_method', 'PUT');
                            
                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                },
                                body: formData
                            });
                            
                            const data = await response.json();
                            
                            if (response.ok && !data.errors) {
                                // Éxito
                                if (window.toast) {
                                    window.toast.success(
                                        'Actualización exitosa',
                                        data.message || 'Número de WhatsApp configurado correctamente. Ya recibirás notificaciones de pedidos y pagos.',
                                        5000,
                                        'bottom-center'
                                    );
                                }
                            } else {
                                // Error de validación
                                const errorMessage = data.message || (data.errors && Object.values(data.errors).flat().join(', ')) || 'Error al guardar la configuración';
                                
                                if (window.toast) {
                                    window.toast.error(
                                        'Error',
                                        errorMessage,
                                        5000,
                                        'bottom-center'
                                    );
                                }
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            if (window.toast) {
                                window.toast.error(
                                    'Error',
                                    'Error de conexión. Por favor, intenta nuevamente.',
                                    5000,
                                    'bottom-center'
                                );
                            }
                        } finally {
                            this.loading = false;
                        }
                    }
                };
            });
        });
    </script>
    @endpush
    @endsection
</x-tenant-admin-layout>


