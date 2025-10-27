<x-tenant-admin-layout :store="$store">

@section('title', 'Métodos de Pago')

@section('content')
<div class="container-fluid" x-data="paymentMethodsSimple">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 px-6">
        <div>
            <h1 class="text-body-large font-bold text-black-400">Métodos de Pago</h1>
            <p class="text-caption text-black-300 mt-1">Activa y configura los métodos de pago para tus clientes</p>
        </div>
    </div>

    {{-- Información rápida --}}
    <div class="bg-gradient-to-r from-primary-300 to-accent-300 rounded-lg p-4 mb-6 border border-accent-300">
        <div class="flex items-center gap-3">
            <div class="rounded-full bg-accent-300 p-2">
                <x-solar-info-circle-outline class="w-5 h-5 text-primary-300" />
            </div>
            <div class="flex-1">
                <h3 class="text-body-large font-bold text-accent-50">Gestión de Métodos de Pago</h3>
                <p class="text-caption text-accent-50">Activa los métodos que necesites y configura sus opciones específicas. Solo uno puede ser predeterminado.</p>
            </div>
        </div>
    </div>

    {{-- Métodos de Pago Predefinidos --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
        
        {{-- 1. TRANSFERENCIA BANCARIA --}}
        @php
            $bankTransferMethod = $paymentMethods->firstWhere('type', 'bank_transfer');
            $isDefaultBank = $defaultMethod && $bankTransferMethod && $defaultMethod->id === $bankTransferMethod->id;
        @endphp
        
        <div class="payment-method-card bg-accent-50 rounded-lg p-4 lg:p-6 shadow-sm border border-accent-200 {{ $bankTransferMethod && $bankTransferMethod->is_active ? 'active' : 'inactive' }}">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center">
                        <x-solar-card-transfer-outline class="w-6 h-6 text-primary-300" />
                    </div>
                    <div>
                        <h3 class="text-body-large font-bold text-black-400 flex items-center gap-2">
                            Transferencia Bancaria
                            @if($isDefaultBank)
                                <span class="bg-primary-300 text-accent-50 px-2 py-1 rounded-full text-caption font-bold flex items-center gap-1">
                                    <x-solar-star-bold class="w-3 h-3" />
                                    Predeterminado
                                </span>
                            @endif
                        </h3>
                        <p class="text-caption text-black-300">Pago mediante transferencia a cuentas bancarias</p>
                    </div>
                </div>
                
                {{-- Toggle principal --}}
                <button @click="toggleMethod('bank_transfer', {{ $bankTransferMethod ? ($bankTransferMethod->is_active ? 'true' : 'false') : 'false' }})" 
                        class="toggle-switch focus:outline-none">
                    <div class="flex items-center gap-3">
                        <span class="text-caption font-bold {{ $bankTransferMethod && $bankTransferMethod->is_active ? 'text-success-500' : 'text-black-300' }}">
                            {{ $bankTransferMethod && $bankTransferMethod->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                        <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out {{ $bankTransferMethod && $bankTransferMethod->is_active ? 'bg-success-300' : 'bg-black-200' }} rounded-full">
                            <span class="absolute left-0 inline-block w-5 h-5 mt-0.5 ml-0.5 transition duration-200 ease-in-out transform bg-accent-50 rounded-full {{ $bankTransferMethod && $bankTransferMethod->is_active ? 'translate-x-6' : 'translate-x-0' }}"></span>
                        </div>
                    </div>
                </button>
            </div>
            
            @if($bankTransferMethod && $bankTransferMethod->is_active)
                {{-- Configuraciones --}}
                <div class="border-t border-accent-200 pt-4 mb-4">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="config-badge {{ $bankTransferMethod->available_for_pickup ? 'active' : '' }}">
                            {{ $bankTransferMethod->available_for_pickup ? '✅' : '❌' }} Recojo
                        </span>
                        <span class="config-badge {{ $bankTransferMethod->available_for_delivery ? 'active' : '' }}">
                            {{ $bankTransferMethod->available_for_delivery ? '✅' : '❌' }} Entrega
                        </span>
                        @if(!$isDefaultBank)
                            <button @click="setAsDefault('bank_transfer')" class="text-caption font-bold text-primary-300 hover:text-primary-200 flex items-center gap-1">
                                <x-solar-star-outline class="w-3 h-3" />
                                Hacer predeterminado
                            </button>
                        @endif
                    </div>
                    
                    <div class="flex gap-3">
                        <button @click="configureMethod('bank_transfer')" 
                                class="text-caption font-bold bg-secondary-300 text-accent-50 px-3 py-1 rounded-lg hover:bg-primary-200 hover:text-accent-50 transition-colors flex items-center gap-1">
                            <x-solar-settings-outline class="w-5 h-5" /> <span class="text-caption font-bold text-accent-50">Configurar</span>
                        </button>
                        <button @click="manageBankAccounts()" 
                                class="text-caption font-bold bg-primary-300 text-accent-50 px-3 py-1 rounded-lg hover:bg-primary-200 hover:text-accent-50 transition-colors flex items-center gap-1">
                            <x-solar-card-2-outline class="w-5 h-5" /> Gestionar Cuentas <span class="text-caption font-bold text-accent-50">({{ $bankTransferMethod->bankAccounts->count() }})</span>
                        </button>
                    </div>
                </div>
                
                {{-- Vista previa de cuentas bancarias --}}
                @if($bankTransferMethod->bankAccounts->isNotEmpty())
                    <div class="bg-accent-50 rounded-lg p-2">
                        <h5 class="text-caption font-bold text-black-300 mb-2">Cuentas configuradas:</h5>
                        <div class="space-y-1 max-h-16 overflow-y-auto">
                            @foreach($bankTransferMethod->bankAccounts->take(2) as $account)
                                <div class="bank-account-mini bg-success-50 rounded p-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-caption font-bold text-black-300">{{ $account->bank_name }}</span>
                                        <span class="text-caption font-bold text-black-300">•••{{ substr($account->account_number, -4) }}</span>
                                    </div>
                                </div>
                            @endforeach
                            @if($bankTransferMethod->bankAccounts->count() > 2)
                                <div class="text-center">
                                    <span class="text-caption text-black-300">+{{ $bankTransferMethod->bankAccounts->count() - 2 }} más</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-accent-50 rounded-lg p-2 text-center flex flex-col items-center justify-center">
                        <p class="text-caption text-black-300 mb-1">No hay cuentas bancarias configuradas</p>
                        <button @click="manageBankAccounts()" class="text-caption font-bold bg-primary-300 text-accent-50 px-3 py-1 rounded-lg hover:bg-primary-200 hover:text-accent-50 transition-colors flex items-center gap-1">
                            <x-solar-add-circle-outline class="w-5 h-5" /> <span class="text-caption font-bold text-accent-50">Agregar primera cuenta</span>
                        </button>
                    </div>
                @endif
            @endif
        </div>

        {{-- 2. EFECTIVO --}}
        @php
            $cashMethod = $paymentMethods->firstWhere('type', 'cash');
            $isDefaultCash = $defaultMethod && $cashMethod && $defaultMethod->id === $cashMethod->id;
        @endphp
        
        <div class="payment-method-card bg-accent-50 rounded-lg p-4 lg:p-6 shadow-sm border border-accent-200 {{ $cashMethod && $cashMethod->is_active ? 'active' : 'inactive' }}">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center">
                        <x-solar-wallet-money-outline class="w-6 h-6 text-primary-300" />
                    </div>
                    <div>
                        <h3 class="text-body-large font-bold text-black-400 flex items-center gap-2">
                            Efectivo
                            @if($isDefaultCash)
                                <span class="bg-primary-300 text-accent-50 px-2 py-1 rounded-full text-caption font-bold flex items-center gap-1">
                                    <x-solar-star-bold class="w-3 h-3" />
                                    Predeterminado
                                </span>
                            @endif
                        </h3>
                        <p class="text-caption text-black-300">Pago en efectivo al momento de entrega</p>
                    </div>
                </div>
                
                <button @click="toggleMethod('cash', {{ $cashMethod ? ($cashMethod->is_active ? 'true' : 'false') : 'false' }})" 
                        class="toggle-switch focus:outline-none">
                    <div class="flex items-center gap-3">
                        <span class="text-caption font-bold {{ $cashMethod && $cashMethod->is_active ? 'text-success-500' : 'text-black-300' }}">
                            {{ $cashMethod && $cashMethod->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                        <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out {{ $cashMethod && $cashMethod->is_active ? 'bg-success-300' : 'bg-black-200' }} rounded-full">
                            <span class="absolute left-0 inline-block w-5 h-5 mt-0.5 ml-0.5 transition duration-200 ease-in-out transform bg-accent-50 rounded-full {{ $cashMethod && $cashMethod->is_active ? 'translate-x-6' : 'translate-x-0' }}"></span>
                        </div>
                    </div>
                </button>
            </div>
            
            @if($cashMethod && $cashMethod->is_active)
                <div class="border-t border-accent-200 pt-4">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="config-badge {{ $cashMethod->available_for_pickup ? 'active' : '' }}">
                            {{ $cashMethod->available_for_pickup ? '✅' : '❌' }} Recojo
                        </span>
                        <span class="config-badge {{ $cashMethod->available_for_delivery ? 'active' : '' }}">
                            {{ $cashMethod->available_for_delivery ? '✅' : '❌' }} Entrega
                        </span>
                            <span class="config-badge active">✅ Permitir cambio</span>
                        @if(!$isDefaultCash)
                            <button @click="setAsDefault('cash')" class="text-caption font-bold text-primary-300 hover:text-primary-200 flex items-center gap-1">
                                <x-solar-star-outline class="w-3 h-3" />
                                Hacer predeterminado
                            </button>
                        @endif
                    </div>
                    
                    <button @click="configureMethod('cash')" 
                            class="text-caption font-bold bg-secondary-300 text-accent-50 px-3 py-1 rounded-lg hover:bg-primary-200 hover:text-accent-50 transition-colors flex items-center gap-1">
                            <x-solar-settings-outline class="w-5 h-5" /> <span class="text-caption font-bold text-accent-50">Configurar</span>
                    </button>
                </div>
            @endif
        </div>

        {{-- 3. DATÁFONO --}}
        @php
            $cardMethod = $paymentMethods->firstWhere('type', 'card_terminal');
            $isDefaultCard = $defaultMethod && $cardMethod && $defaultMethod->id === $cardMethod->id;
        @endphp
        
        <div class="payment-method-card bg-accent-50 rounded-lg p-4 lg:p-6 shadow-sm border border-accent-200 {{ $cardMethod && $cardMethod->is_active ? 'active' : 'inactive' }}">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center">
                        <x-solar-card-outline class="w-6 h-6 text-primary-300" />
                    </div>
                    <div>
                        <h3 class="text-body-large font-bold text-black-400 flex items-center gap-2">
                            Datáfono
                            @if($isDefaultCard)
                                <span class="bg-primary-300 text-accent-50 px-2 py-1 rounded-full text-caption font-bold flex items-center gap-1">
                                    <x-solar-star-bold class="w-3 h-3" />
                                    Predeterminado
                                </span>
                            @endif
                        </h3>
                        <p class="text-caption text-black-300">Pago con tarjeta de crédito o débito</p>
                    </div>
                </div>
                
                <button @click="toggleMethod('card_terminal', {{ $cardMethod ? ($cardMethod->is_active ? 'true' : 'false') : 'false' }})" 
                        class="toggle-switch focus:outline-none">
                    <div class="flex items-center gap-3">
                        <span class="text-caption font-bold {{ $cardMethod && $cardMethod->is_active ? 'text-success-500' : 'text-black-300' }}">
                            {{ $cardMethod && $cardMethod->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                        <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out {{ $cardMethod && $cardMethod->is_active ? 'bg-success-300' : 'bg-black-200' }} rounded-full">
                            <span class="absolute left-0 inline-block w-5 h-5 mt-0.5 ml-0.5 transition duration-200 ease-in-out transform bg-accent-50 rounded-full {{ $cardMethod && $cardMethod->is_active ? 'translate-x-6' : 'translate-x-0' }}"></span>
                        </div>
                    </div>
                </button>
            </div>
            
            @if($cardMethod && $cardMethod->is_active)
                <div class="border-t border-accent-200 pt-4">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="config-badge {{ $cardMethod->available_for_pickup ? 'active' : '' }}">
                            {{ $cardMethod->available_for_pickup ? '✅' : '❌' }} Recojo
                        </span>
                        <span class="config-badge {{ $cardMethod->available_for_delivery ? 'active' : '' }}">
                            {{ $cardMethod->available_for_delivery ? '✅' : '❌' }} Entrega
                        </span>
                        <span class="config-badge active">✅ Visa, Mastercard</span>
                        @if(!$isDefaultCard)
                            <button @click="setAsDefault('card_terminal')" class="text-caption font-bold text-primary-300 hover:text-primary-200 flex items-center gap-1">
                                <x-solar-star-outline class="w-3 h-3" />
                                Hacer predeterminado
                            </button>
                        @endif
                    </div>
                    
                    <button @click="configureMethod('card_terminal')" 
                            class="text-caption font-bold bg-secondary-300 text-accent-50 px-3 py-1 rounded-lg hover:bg-primary-200 hover:text-accent-50 transition-colors flex items-center gap-1">
                            <x-solar-settings-outline class="w-5 h-5" /> <span class="text-caption font-bold text-accent-50">Configurar</span>
                    </button>
                </div>
            @endif
        </div>

        {{-- 4. CONTRA ENTREGA --}}
        @php
            $codMethod = $paymentMethods->firstWhere('type', 'cash_on_delivery');
            $isDefaultCod = $defaultMethod && $codMethod && $defaultMethod->id === $codMethod->id;
        @endphp
        
        <div class="payment-method-card bg-accent-50 rounded-lg p-4 lg:p-6 shadow-sm {{ $codMethod && $codMethod->is_active ? 'active' : 'inactive' }}">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-primary-50 flex items-center justify-center">
                        <x-solar-delivery-outline class="w-6 h-6 text-primary-300" />
                    </div>
                    <div>
                        <h3 class="text-body-large font-bold text-black-400 flex items-center gap-2">
                            Contra Entrega
                            @if($isDefaultCod)
                                <span class="bg-primary-300 text-accent-50 px-2 py-1 rounded-full text-caption font-bold flex items-center gap-1">
                                    <x-solar-star-bold class="w-3 h-3" />
                                    Predeterminado
                                </span>
                            @endif
                        </h3>
                        <p class="text-caption text-black-300">El cliente paga al recibir el producto</p>
                    </div>
                </div>
                
                <button @click="toggleMethod('cash_on_delivery', {{ $codMethod ? ($codMethod->is_active ? 'true' : 'false') : 'false' }})" 
                        class="toggle-switch focus:outline-none">
                    <div class="flex items-center gap-3">
                        <span class="text-caption font-bold {{ $codMethod && $codMethod->is_active ? 'text-success-500' : 'text-black-300' }}">
                            {{ $codMethod && $codMethod->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                        <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out {{ $codMethod && $codMethod->is_active ? 'bg-success-300' : 'bg-black-200' }} rounded-full">
                            <span class="absolute left-0 inline-block w-5 h-5 mt-0.5 ml-0.5 transition duration-200 ease-in-out transform bg-accent-50 rounded-full {{ $codMethod && $codMethod->is_active ? 'translate-x-6' : 'translate-x-0' }}"></span>
                        </div>
                    </div>
                </button>
            </div>
            
            @if($codMethod && $codMethod->is_active)
                <div class="border-t border-accent-200 pt-4">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="config-badge">✅ Recojo</span>
                        <span class="config-badge {{ $codMethod->available_for_delivery ? 'active' : '' }}">
                            {{ $codMethod->available_for_delivery ? '✅' : '❌' }} Entrega
                        </span>
                        @if(!$isDefaultCod)
                            <button @click="setAsDefault('cash_on_delivery')" class="text-caption font-bold text-primary-300 hover:text-primary-200 flex items-center gap-1">
                                <x-solar-star-outline class="w-3 h-3" />
                                Hacer predeterminado
                            </button>
                        @endif
                    </div>
                    
                    <button @click="configureMethod('cash_on_delivery')" 
                            class="text-caption font-bold bg-secondary-300 text-accent-50 px-3 py-1 rounded-lg hover:bg-primary-200 hover:text-accent-50 transition-colors flex items-center gap-1">
                            <x-solar-settings-outline class="w-5 h-5" /> <span class="text-caption font-bold text-accent-50">Configurar</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Información adicional --}}
    <div class="mt-8 bg-accent-50 rounded-lg p-4 border border-accent-200 mb-8">
        <div class="flex items-start gap-3">
            <x-solar-lightbulb-minimalistic-outline class="w-5 h-5 text-warning-300 mt-1 flex-shrink-0" />
            <div>
                <h4 class="text-body-large font-bold text-black-400 mb-1">Consejos para configurar métodos de pago</h4>
                <ul class="text-caption text-black-300 space-y-1">
                    <li>• <strong>Transferencia:</strong> Agrega al menos una cuenta bancaria activa</li>
                    <li>• <strong>Efectivo:</strong> Ideal para pickup y entregas locales</li>
                    <li>• <strong>Datáfono:</strong> Perfecto para ventas presenciales</li>
                    <li>• <strong>Contra entrega:</strong> Genera confianza pero solo para domicilios</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Modals simples aquí (configuración y cuentas bancarias) --}}
    {{-- Modal de configuración --}}
    <div x-show="showConfigModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black-400 bg-opacity-50">
        <div x-show="showConfigModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold text-black-400 mb-4" x-text="'Configurar ' + currentMethodName"></h3>
            
            <div class="space-y-4">
                <div>
                    <label class="flex items-center gap-2" :class="currentMethodType === 'cash_on_delivery' ? 'opacity-50 cursor-not-allowed' : ''">
                        <input type="checkbox" 
                               x-model="methodConfig.available_for_pickup" 
                               :disabled="currentMethodType === 'cash_on_delivery'"
                               class="rounded">
                        <span class="text-caption font-medium text-black-400">Disponible para Recojo</span>
                    </label>
                    <p x-show="currentMethodType === 'cash_on_delivery'" class="text-caption text-warning-300 mt-1 ml-6">
                        Contra entrega solo está disponible para domicilio
                    </p>
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" x-model="methodConfig.available_for_delivery" class="rounded">
                        <span class="text-caption font-medium text-black-400">Disponible para Entrega</span>
                    </label>
                </div>
                
                {{-- Configuraciones específicas por método --}}
                <div x-show="currentMethodType === 'cash'">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" x-model="methodConfig.allow_change" class="rounded">
                        <span class="text-caption font-medium text-black-400">Permitir que el cliente solicite cambio</span>
                    </label>
                </div>
                
                <div x-show="currentMethodType === 'card_terminal'">
                    <label class="block text-caption font-bold text-black-400 mb-2">Tarjetas Aceptadas:</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" x-model="methodConfig.accept_visa" class="rounded">
                            <span class="text-caption font-medium text-black-400">Visa</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" x-model="methodConfig.accept_mastercard" class="rounded">
                            <span class="text-caption font-medium text-black-400">Mastercard</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" x-model="methodConfig.accept_american_express" class="rounded">
                            <span class="text-caption font-medium text-black-400">American Express</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button @click="showConfigModal = false" 
                        class="flex-1 px-4 py-2 border border-accent-200 text-black-400 rounded-lg hover:bg-accent-50">
                    Cancelar
                </button>
                <button @click="saveMethodConfig()" 
                        class="flex-1 px-4 py-2 bg-primary-300 text-accent-50 rounded-lg hover:bg-primary-200">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('paymentMethodsSimple', () => ({
        // Estados
        isLoading: false,
        showNotification: false,
        notificationMessage: '',
        notificationType: 'success',
        showConfigModal: false,
        currentMethodType: '',
        currentMethodName: '',
        
        // Configuración del método actual
        methodConfig: {
            available_for_pickup: true,
            available_for_delivery: true,
            allow_change: true,
            accept_visa: true,
            accept_mastercard: true,
            accept_american_express: false
        },
        
        init() {
            // Inicialización
        },
        
        // Toggle activar/desactivar método
        async toggleMethod(type, isActive) {
            this.isLoading = true;
            
            try {
                const response = await fetch(`{{ route("tenant.admin.payment-methods.toggle-simple", ["store" => $store->slug]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        type: type,
                        is_active: !isActive
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const methodName = this.getMethodName(type);
                    const action = !isActive ? 'activado' : 'desactivado';
                    await Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: `${methodName} ${action} exitosamente`,
                        confirmButtonColor: '#00c76f',
                        confirmButtonText: 'OK',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al cambiar estado del método',
                        confirmButtonColor: '#ed2e45'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'Intenta nuevamente',
                    confirmButtonColor: '#ed2e45'
                });
            } finally {
                this.isLoading = false;
            }
        },
        
        // Establecer como predeterminado
        async setAsDefault(type) {
            this.isLoading = true;
            
            try {
                const response = await fetch(`{{ route("tenant.admin.payment-methods.set-default-simple", ["store" => $store->slug]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ type: type })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const methodName = this.getMethodName(type);
                    await Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: `${methodName} establecido como predeterminado`,
                        confirmButtonColor: '#00c76f',
                        confirmButtonText: 'OK',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al establecer predeterminado',
                        confirmButtonColor: '#ed2e45'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'Intenta nuevamente',
                    confirmButtonColor: '#ed2e45'
                });
            } finally {
                this.isLoading = false;
            }
        },
        
        // Configurar método
        configureMethod(type) {
            this.currentMethodType = type;
            this.currentMethodName = this.getMethodName(type);
            
            // Cargar configuración actual
            this.loadMethodConfig(type);
            this.showConfigModal = true;
        },
        
        // Obtener nombre del método
        getMethodName(type) {
            const names = {
                'bank_transfer': 'Transferencia Bancaria',
                'cash': 'Efectivo',
                'card_terminal': 'Datáfono',
                'cash_on_delivery': 'Contra Entrega'
            };
            return names[type] || type;
        },
        
        // Cargar configuración del método
        loadMethodConfig(type) {
            // Cargar configuración actual del método desde el PHP
            @if($bankTransferMethod)
            if (type === 'bank_transfer') {
                this.methodConfig.available_for_pickup = {{ $bankTransferMethod->available_for_pickup ? 'true' : 'false' }};
                this.methodConfig.available_for_delivery = {{ $bankTransferMethod->available_for_delivery ? 'true' : 'false' }};
            }
            @endif
            
            @if($cashMethod)
            if (type === 'cash') {
                this.methodConfig.available_for_pickup = {{ $cashMethod->available_for_pickup ? 'true' : 'false' }};
                this.methodConfig.available_for_delivery = {{ $cashMethod->available_for_delivery ? 'true' : 'false' }};
                this.methodConfig.allow_change = true; // Siempre permitir cambio por defecto
            }
            @endif
            
            @if($cardMethod)
            if (type === 'card_terminal') {
                this.methodConfig.available_for_pickup = {{ $cardMethod->available_for_pickup ? 'true' : 'false' }};
                this.methodConfig.available_for_delivery = {{ $cardMethod->available_for_delivery ? 'true' : 'false' }};
                this.methodConfig.accept_visa = true;
                this.methodConfig.accept_mastercard = true;
                this.methodConfig.accept_american_express = false;
            }
            @endif
            
            @if($codMethod)
            if (type === 'cash_on_delivery') {
                this.methodConfig.available_for_pickup = false; // COD no disponible para pickup
                this.methodConfig.available_for_delivery = {{ $codMethod->available_for_delivery ? 'true' : 'false' }};
            }
            @endif
        },
        
        // Guardar configuración
        async saveMethodConfig() {
            this.isLoading = true;
            
            try {
                const response = await fetch(`{{ route("tenant.admin.payment-methods.configure-simple", ["store" => $store->slug]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        type: this.currentMethodType,
                        config: this.methodConfig
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showConfigModal = false;
                    await Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Configuración guardada exitosamente',
                        confirmButtonColor: '#00c76f',
                        confirmButtonText: 'OK',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Error al guardar configuración',
                        confirmButtonColor: '#ed2e45'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al guardar la configuración',
                    confirmButtonColor: '#ed2e45'
                });
            } finally {
                this.isLoading = false;
            }
        },
        
        // Gestionar cuentas bancarias
        manageBankAccounts() {
            // Encontrar el ID del método de transferencia bancaria
            @if($bankTransferMethod)
                window.location.href = '{{ route("tenant.admin.payment-methods.bank-accounts.index", ["store" => $store->slug, "paymentMethod" => $bankTransferMethod->id]) }}';
            @else
                Swal.fire({
                    icon: 'warning',
                    title: 'Método no activo',
                    text: 'Primero activa el método de transferencia bancaria',
                    confirmButtonColor: '#ffad0d'
                });
            @endif
        }
    }));
});
</script>
@endpush

@endsection
</x-tenant-admin-layout>