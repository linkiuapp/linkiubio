<x-tenant-admin-layout :store="$store">
    @section('title', 'Notificaciones WhatsApp')
    @section('subtitle', 'Configura tus notificaciones automáticas')

    @section('content')
    <div class="space-y-6">
        
        <!-- Header -->
        <div class="bg-accent-50 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-black-500 mb-2">📱 Notificaciones WhatsApp</h2>
            <p class="text-sm text-black-300">
                Configura tu número de WhatsApp para recibir notificaciones automáticas sobre pedidos, reservas y pagos.
            </p>
        </div>

        <!-- Formulario -->
        <form action="{{ route('tenant.admin.whatsapp-notifications.update', ['store' => $store->slug]) }}" method="POST" class="bg-white rounded-lg border border-accent-200 p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Info box -->
                <div class="flex items-start gap-3 bg-info-50 border border-info-200 rounded-lg p-4">
                    <x-solar-info-circle-outline class="w-5 h-5 text-info-400 flex-shrink-0 mt-0.5" />
                    <div class="text-sm text-info-400">
                        <p class="font-medium mb-1">📱 Configuración de Notificaciones WhatsApp</p>
                        <p class="text-info-300">Configura tu número de WhatsApp para recibir notificaciones automáticas sobre pedidos y pagos. Los clientes también recibirán confirmaciones y actualizaciones.</p>
                    </div>
                </div>

                <!-- Número WhatsApp -->
                <div class="bg-accent-50 rounded-lg p-6 space-y-6">
                    <h3 class="text-lg font-semibold text-black-500 flex items-center gap-2">
                        <x-solar-chat-round-call-outline class="w-5 h-5" />
                        Número de WhatsApp del Propietario
                    </h3>
                    
                    <div>
                        <label for="owner_phone" class="block text-sm font-medium text-black-400 mb-2">
                            Número de WhatsApp <span class="text-error-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-black-300 font-medium">+57</span>
                            <input type="text" 
                                   id="owner_phone" 
                                   name="owner_phone" 
                                   value="{{ old('owner_phone', $store->owner_phone) }}"
                                   placeholder="3001234567"
                                   maxlength="10"
                                   pattern="[0-9]{10}"
                                   class="w-full pl-12 pr-3 py-3 border border-accent-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-200 focus:border-transparent @error('owner_phone') border-error-300 @enderror"
                                   required>
                        </div>
                        <p class="text-xs text-black-300 mt-1">
                            Ingresa tu número de celular (10 dígitos) sin espacios ni guiones. Ejemplo: 3001234567
                        </p>
                        @error('owner_phone')
                            <p class="text-sm text-error-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notificaciones que recibirás -->
                    <div class="bg-white rounded-lg p-4 border border-accent-200">
                        <h4 class="text-sm font-semibold text-black-500 mb-3">📬 Notificaciones que recibirás:</h4>
                        <ul class="space-y-2 text-sm text-black-400">
                            <li class="flex items-start gap-2">
                                <x-solar-check-circle-outline class="w-4 h-4 text-success-400 flex-shrink-0 mt-0.5" />
                                <span><strong>Nuevo pedido:</strong> Cuando un cliente realiza un pedido</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-solar-check-circle-outline class="w-4 h-4 text-success-400 flex-shrink-0 mt-0.5" />
                                <span><strong>Comprobante recibido:</strong> Cuando un cliente sube un comprobante de pago</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-solar-check-circle-outline class="w-4 h-4 text-success-400 flex-shrink-0 mt-0.5" />
                                <span><strong>Nueva reserva:</strong> Cuando se solicita una reserva (mesas/hotel)</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Notificaciones que reciben los clientes -->
                    <div class="bg-white rounded-lg p-4 border border-accent-200">
                        <h4 class="text-sm font-semibold text-black-500 mb-3">👥 Notificaciones automáticas a clientes:</h4>
                        <ul class="space-y-2 text-sm text-black-400">
                            <li class="flex items-start gap-2">
                                <x-solar-check-circle-outline class="w-4 h-4 text-info-400 flex-shrink-0 mt-0.5" />
                                <span><strong>Confirmación de pedido:</strong> Al crear el pedido</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-solar-check-circle-outline class="w-4 h-4 text-info-400 flex-shrink-0 mt-0.5" />
                                <span><strong>Cambios de estado:</strong> Cuando el pedido cambia de estado</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-solar-check-circle-outline class="w-4 h-4 text-info-400 flex-shrink-0 mt-0.5" />
                                <span><strong>Confirmación de reserva:</strong> Cuando se confirma una reserva</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-solar-check-circle-outline class="w-4 h-4 text-info-400 flex-shrink-0 mt-0.5" />
                                <span><strong>Recordatorios:</strong> 24h antes de reservas</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-success-300 text-white px-6 py-3 rounded-lg hover:bg-success-400 transition-colors flex items-center gap-2 font-medium">
                        <x-solar-chat-round-call-outline class="w-5 h-5" />
                        Guardar Configuración WhatsApp
                    </button>
                </div>
            </div>
        </form>

        <!-- Notificaciones -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition 
             class="fixed bottom-4 right-4 bg-success-100 border border-success-200 text-success-400 px-4 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center gap-2">
                <x-solar-check-circle-outline class="w-5 h-5" />
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif
        
        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition 
             class="fixed bottom-4 right-4 bg-error-100 border border-error-200 text-error-400 px-4 py-3 rounded-lg shadow-lg z-50">
            <div class="flex items-center gap-2">
                <x-solar-close-circle-outline class="w-5 h-5" />
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif
    </div>
    @endsection
</x-tenant-admin-layout>


