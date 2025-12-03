<x-tenant-admin-layout :store="$store">

@section('title', 'Métodos de Pago')

@section('content')
<div x-data="paymentMethodsManager()" class="space-y-4">
    {{-- Header Card --}}
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 py-4 px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-1">Métodos de Pago</h2>
                    <p class="text-sm text-gray-600">Configura cómo tus clientes pueden pagar sus pedidos</p>
                </div>
            </div>
        </div>

        {{-- Grid de métodos --}}
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                
                {{-- TRANSFERENCIA BANCARIA --}}
                @php
                    $bankTransferMethod = $paymentMethods->firstWhere('type', 'bank_transfer');
                    $isDefaultBank = $defaultMethod && $bankTransferMethod && $defaultMethod->id === $bankTransferMethod->id;
                @endphp
                
                <div class="bg-white rounded-xl border-2 transition-all duration-200 {{ $bankTransferMethod && $bankTransferMethod->is_active ? 'border-blue-200 shadow-sm' : 'border-gray-200' }}">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl {{ $bankTransferMethod && $bankTransferMethod->is_active ? 'bg-blue-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <i data-lucide="landmark" class="w-6 h-6 {{ $bankTransferMethod && $bankTransferMethod->is_active ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-semibold text-gray-900">Transferencia Bancaria</h3>
                                        @if($isDefaultBank)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                                Principal
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500">Transferencia a cuentas bancarias</p>
                                </div>
                            </div>
                            
                            {{-- Toggle estilo productos --}}
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" 
                                       class="peer sr-only"
                                       {{ $bankTransferMethod && $bankTransferMethod->is_active ? 'checked' : '' }}
                                       @change="toggleMethod('bank_transfer', {{ $bankTransferMethod ? ($bankTransferMethod->is_active ? 'true' : 'false') : 'false' }})">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </div>
                        
                        @if($bankTransferMethod && $bankTransferMethod->is_active)
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium {{ $bankTransferMethod->available_for_pickup ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <i data-lucide="{{ $bankTransferMethod->available_for_pickup ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                    Recogida
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium {{ $bankTransferMethod->available_for_delivery ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <i data-lucide="{{ $bankTransferMethod->available_for_delivery ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                    Entrega
                                </span>
                                @if($bankTransferMethod->require_proof)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-50 text-amber-700">
                                        <i data-lucide="file-check" class="w-3 h-3"></i>
                                        Comprobante obligatorio
                                    </span>
                                @endif
                            </div>
                            
                            @if($bankTransferMethod->bankAccounts->isNotEmpty())
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <p class="text-xs font-medium text-gray-500 mb-2">{{ $bankTransferMethod->bankAccounts->count() }} cuenta(s) configurada(s)</p>
                                    <div class="space-y-1">
                                        @foreach($bankTransferMethod->bankAccounts->take(2) as $account)
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-700">{{ $account->bank_name }}</span>
                                                <span class="text-gray-400 font-mono text-xs">****{{ substr($account->account_number, -4) }}</span>
                                            </div>
                                        @endforeach
                                        @if($bankTransferMethod->bankAccounts->count() > 2)
                                            <p class="text-xs text-gray-400">+{{ $bankTransferMethod->bankAccounts->count() - 2 }} más</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <div class="flex flex-wrap gap-2">
                                <button @click="configureMethod('bank_transfer')" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    Configurar
                                </button>
                                <button @click="manageBankAccounts()" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                                    Cuentas
                                </button>
                                @if(!$isDefaultBank)
                                    <button @click="setAsDefault('bank_transfer')" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                        Hacer principal
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- EFECTIVO --}}
                @php
                    $cashMethod = $paymentMethods->firstWhere('type', 'cash');
                    $isDefaultCash = $defaultMethod && $cashMethod && $defaultMethod->id === $cashMethod->id;
                @endphp
                
                <div class="bg-white rounded-xl border-2 transition-all duration-200 {{ $cashMethod && $cashMethod->is_active ? 'border-blue-200 shadow-sm' : 'border-gray-200' }}">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl {{ $cashMethod && $cashMethod->is_active ? 'bg-blue-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <i data-lucide="banknote" class="w-6 h-6 {{ $cashMethod && $cashMethod->is_active ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-semibold text-gray-900">Efectivo</h3>
                                        @if($isDefaultCash)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                                Principal
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500">Pago en efectivo al momento</p>
                                </div>
                            </div>
                            
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" 
                                       class="peer sr-only"
                                       {{ $cashMethod && $cashMethod->is_active ? 'checked' : '' }}
                                       @change="toggleMethod('cash', {{ $cashMethod ? ($cashMethod->is_active ? 'true' : 'false') : 'false' }})">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </div>
                        
                        @if($cashMethod && $cashMethod->is_active)
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium {{ $cashMethod->available_for_pickup ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <i data-lucide="{{ $cashMethod->available_for_pickup ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                    Recogida
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium {{ $cashMethod->available_for_delivery ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <i data-lucide="{{ $cashMethod->available_for_delivery ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                    Entrega
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700">
                                    <i data-lucide="check" class="w-3 h-3"></i>
                                    Permite cambio
                                </span>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                <button @click="configureMethod('cash')" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    Configurar
                                </button>
                                @if(!$isDefaultCash)
                                    <button @click="setAsDefault('cash')" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                        Hacer principal
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- DATÁFONO --}}
                @php
                    $cardMethod = $paymentMethods->firstWhere('type', 'card_terminal');
                    $isDefaultCard = $defaultMethod && $cardMethod && $defaultMethod->id === $cardMethod->id;
                @endphp
                
                <div class="bg-white rounded-xl border-2 transition-all duration-200 {{ $cardMethod && $cardMethod->is_active ? 'border-blue-200 shadow-sm' : 'border-gray-200' }}">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl {{ $cardMethod && $cardMethod->is_active ? 'bg-blue-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <i data-lucide="smartphone-nfc" class="w-6 h-6 {{ $cardMethod && $cardMethod->is_active ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-semibold text-gray-900">Datáfono</h3>
                                        @if($isDefaultCard)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                                Principal
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500">Tarjeta de crédito o débito</p>
                                </div>
                            </div>
                            
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" 
                                       class="peer sr-only"
                                       {{ $cardMethod && $cardMethod->is_active ? 'checked' : '' }}
                                       @change="toggleMethod('card_terminal', {{ $cardMethod ? ($cardMethod->is_active ? 'true' : 'false') : 'false' }})">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </div>
                        
                        @if($cardMethod && $cardMethod->is_active)
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium {{ $cardMethod->available_for_pickup ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <i data-lucide="{{ $cardMethod->available_for_pickup ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                    Recogida
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium {{ $cardMethod->available_for_delivery ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <i data-lucide="{{ $cardMethod->available_for_delivery ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                    Entrega
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-purple-50 text-purple-700">
                                    <i data-lucide="credit-card" class="w-3 h-3"></i>
                                    Visa, Mastercard
                                </span>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                <button @click="configureMethod('card_terminal')" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    Configurar
                                </button>
                                @if(!$isDefaultCard)
                                    <button @click="setAsDefault('card_terminal')" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                        Hacer principal
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- CONTRA ENTREGA --}}
                @php
                    $codMethod = $paymentMethods->firstWhere('type', 'cash_on_delivery');
                    $isDefaultCod = $defaultMethod && $codMethod && $defaultMethod->id === $codMethod->id;
                @endphp
                
                <div class="bg-white rounded-xl border-2 transition-all duration-200 {{ $codMethod && $codMethod->is_active ? 'border-blue-200 shadow-sm' : 'border-gray-200' }}">
                    <div class="p-5">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl {{ $codMethod && $codMethod->is_active ? 'bg-blue-100' : 'bg-gray-100' }} flex items-center justify-center">
                                    <i data-lucide="truck" class="w-6 h-6 {{ $codMethod && $codMethod->is_active ? 'text-blue-600' : 'text-gray-400' }}"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-semibold text-gray-900">Contra Entrega</h3>
                                        @if($isDefaultCod)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                                Principal
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500">Pago al recibir el producto</p>
                                </div>
                            </div>
                            
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" 
                                       class="peer sr-only"
                                       {{ $codMethod && $codMethod->is_active ? 'checked' : '' }}
                                       @change="toggleMethod('cash_on_delivery', {{ $codMethod ? ($codMethod->is_active ? 'true' : 'false') : 'false' }})">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </div>
                        
                        @if($codMethod && $codMethod->is_active)
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-500">
                                    <i data-lucide="x" class="w-3 h-3"></i>
                                    Recogida
                                </span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium {{ $codMethod->available_for_delivery ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                                    <i data-lucide="{{ $codMethod->available_for_delivery ? 'check' : 'x' }}" class="w-3 h-3"></i>
                                    Entrega
                                </span>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                <button @click="configureMethod('cash_on_delivery')" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    Configurar
                                </button>
                                @if(!$isDefaultCod)
                                    <button @click="setAsDefault('cash_on_delivery')" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                        Hacer principal
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Footer con consejos --}}
        <div class="border-t border-gray-200 bg-amber-50 px-6 py-4">
            <div class="flex items-start gap-3">
                <i data-lucide="lightbulb" class="w-5 h-5 text-amber-600 mt-0.5 flex-shrink-0"></i>
                <div class="text-sm text-amber-800">
                    <p class="font-medium mb-1">Consejos</p>
                    <ul class="text-amber-700 space-y-0.5">
                        <li>Agrega al menos una cuenta bancaria para recibir transferencias</li>
                        <li>Contra entrega solo está disponible para envíos a domicilio</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Configuración --}}
    <div x-show="showConfigModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         @keydown.escape.window="showConfigModal = false">
        
        <div class="fixed inset-0 bg-black/50" @click="showConfigModal = false"></div>
        
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="showConfigModal"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6"
                 @click.stop>
                
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="'Configurar ' + currentMethodName"></h3>
                    <button @click="showConfigModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    {{-- Disponibilidad --}}
                    <div class="space-y-3">
                        <p class="text-sm font-medium text-gray-700">Disponibilidad</p>
                        
                        <label class="flex items-center justify-between p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors"
                               :class="currentMethodType === 'cash_on_delivery' ? 'opacity-50' : ''">
                            <div class="flex items-center gap-3">
                                <i data-lucide="store" class="w-5 h-5 text-gray-500"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Disponible para recogida</span>
                                    <p x-show="currentMethodType === 'cash_on_delivery'" class="text-xs text-amber-600 mt-0.5">
                                        Solo disponible para domicilio
                                    </p>
                                </div>
                            </div>
                            <label class="relative inline-block w-11 h-6 cursor-pointer" :class="currentMethodType === 'cash_on_delivery' ? 'pointer-events-none opacity-50' : ''">
                                <input type="checkbox" class="peer sr-only" x-model="methodConfig.available_for_pickup" :disabled="currentMethodType === 'cash_on_delivery'">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </label>
                        
                        <label class="flex items-center justify-between p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <i data-lucide="truck" class="w-5 h-5 text-gray-500"></i>
                                <span class="text-sm font-medium text-gray-900">Disponible para entrega</span>
                            </div>
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" class="peer sr-only" x-model="methodConfig.available_for_delivery">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </label>
                    </div>
                    
                    {{-- Configuración de Efectivo --}}
                    <div x-show="currentMethodType === 'cash'" class="pt-2 border-t border-gray-200">
                        <label class="flex items-center justify-between p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <i data-lucide="coins" class="w-5 h-5 text-gray-500"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Permitir solicitar cambio</span>
                                    <p class="text-xs text-gray-500 mt-0.5">El cliente indica con cuánto pagará</p>
                                </div>
                            </div>
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" class="peer sr-only" x-model="methodConfig.allow_change">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </label>
                    </div>
                    
                    {{-- Configuración de Datáfono --}}
                    <div x-show="currentMethodType === 'card_terminal'" class="pt-2 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-3">Tarjetas aceptadas</p>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="flex flex-col items-center gap-2 p-3 rounded-lg border-2 cursor-pointer transition-all"
                                   :class="methodConfig.accept_visa ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:bg-gray-50'"
                                   @click="methodConfig.accept_visa = !methodConfig.accept_visa">
                                <i data-lucide="credit-card" class="w-5 h-5" :class="methodConfig.accept_visa ? 'text-green-600' : 'text-gray-400'"></i>
                                <span class="text-sm font-medium" :class="methodConfig.accept_visa ? 'text-green-700' : 'text-gray-700'">Visa</span>
                            </label>
                            <label class="flex flex-col items-center gap-2 p-3 rounded-lg border-2 cursor-pointer transition-all"
                                   :class="methodConfig.accept_mastercard ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:bg-gray-50'"
                                   @click="methodConfig.accept_mastercard = !methodConfig.accept_mastercard">
                                <i data-lucide="credit-card" class="w-5 h-5" :class="methodConfig.accept_mastercard ? 'text-green-600' : 'text-gray-400'"></i>
                                <span class="text-sm font-medium" :class="methodConfig.accept_mastercard ? 'text-green-700' : 'text-gray-700'">Mastercard</span>
                            </label>
                            <label class="flex flex-col items-center gap-2 p-3 rounded-lg border-2 cursor-pointer transition-all"
                                   :class="methodConfig.accept_american_express ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:bg-gray-50'"
                                   @click="methodConfig.accept_american_express = !methodConfig.accept_american_express">
                                <i data-lucide="credit-card" class="w-5 h-5" :class="methodConfig.accept_american_express ? 'text-green-600' : 'text-gray-400'"></i>
                                <span class="text-sm font-medium" :class="methodConfig.accept_american_express ? 'text-green-700' : 'text-gray-700'">Amex</span>
                            </label>
                        </div>
                    </div>
                    
                    {{-- Requerir comprobante (solo transferencia) --}}
                    <div x-show="currentMethodType === 'bank_transfer'" class="pt-4 border-t border-gray-200">
                        <label class="flex items-center justify-between p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3">
                                <i data-lucide="file-check" class="w-5 h-5 text-gray-500"></i>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Requerir comprobante de pago</span>
                                    <p class="text-xs text-gray-500 mt-0.5">El cliente debe subir foto del comprobante</p>
                                </div>
                            </div>
                            <label class="relative inline-block w-11 h-6 cursor-pointer">
                                <input type="checkbox" class="peer sr-only" x-model="methodConfig.require_proof">
                                <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600"></span>
                                <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full"></span>
                            </label>
                        </label>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6 pt-4 border-t border-gray-200">
                    <button @click="showConfigModal = false" 
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Cancelar
                    </button>
                    <button @click="saveMethodConfig()" 
                            :disabled="isLoading"
                            class="flex-1 px-4 py-2.5 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors disabled:opacity-50">
                        <span x-show="!isLoading">Guardar cambios</span>
                        <span x-show="isLoading" class="flex items-center justify-center gap-2">
                            <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                            Guardando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function paymentMethodsManager() {
    return {
        isLoading: false,
        showConfigModal: false,
        currentMethodType: '',
        currentMethodName: '',
        
        methodConfig: {
            available_for_pickup: true,
            available_for_delivery: true,
            allow_change: true,
            accept_visa: true,
            accept_mastercard: true,
            accept_american_express: false,
            require_proof: false
        },
        
        init() {
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        },
        
        async toggleMethod(type, isActive) {
            if (this.isLoading) return;
            this.isLoading = true;
            
            try {
                const response = await fetch(`{{ route("tenant.admin.payment-methods.toggle-simple", ["store" => $store->slug]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ type, is_active: !isActive })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const methodName = this.getMethodName(type);
                    const action = !isActive ? 'activado' : 'desactivado';
                    window.toast.success('¡Actualización exitosa!', `${methodName} ${action}`, 3000, 'bottom-center');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.toast.error('Error', data.message || 'No se pudo actualizar', 5000, 'bottom-center');
                }
            } catch (error) {
                window.toast.error('Error', 'Error de conexión', 5000, 'bottom-center');
            } finally {
                this.isLoading = false;
            }
        },
        
        async setAsDefault(type) {
            if (this.isLoading) return;
            this.isLoading = true;
            
            try {
                const response = await fetch(`{{ route("tenant.admin.payment-methods.set-default-simple", ["store" => $store->slug]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ type })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.toast.success('¡Actualización exitosa!', `${this.getMethodName(type)} es ahora el principal`, 3000, 'bottom-center');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.toast.error('Error', data.message || 'No se pudo actualizar', 5000, 'bottom-center');
                }
            } catch (error) {
                window.toast.error('Error', 'Error de conexión', 5000, 'bottom-center');
            } finally {
                this.isLoading = false;
            }
        },
        
        configureMethod(type) {
            this.currentMethodType = type;
            this.currentMethodName = this.getMethodName(type);
            this.loadMethodConfig(type);
            this.showConfigModal = true;
            this.$nextTick(() => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            });
        },
        
        getMethodName(type) {
            const names = {
                'bank_transfer': 'Transferencia Bancaria',
                'cash': 'Efectivo',
                'card_terminal': 'Datáfono',
                'cash_on_delivery': 'Contra Entrega'
            };
            return names[type] || type;
        },
        
        loadMethodConfig(type) {
            this.methodConfig = {
                available_for_pickup: true,
                available_for_delivery: true,
                allow_change: true,
                accept_visa: true,
                accept_mastercard: true,
                accept_american_express: false,
                require_proof: false
            };
            
            @if($bankTransferMethod)
            if (type === 'bank_transfer') {
                this.methodConfig.available_for_pickup = {{ $bankTransferMethod->available_for_pickup ? 'true' : 'false' }};
                this.methodConfig.available_for_delivery = {{ $bankTransferMethod->available_for_delivery ? 'true' : 'false' }};
                this.methodConfig.require_proof = {{ $bankTransferMethod->require_proof ? 'true' : 'false' }};
            }
            @endif
            
            @if($cashMethod)
            if (type === 'cash') {
                this.methodConfig.available_for_pickup = {{ $cashMethod->available_for_pickup ? 'true' : 'false' }};
                this.methodConfig.available_for_delivery = {{ $cashMethod->available_for_delivery ? 'true' : 'false' }};
                this.methodConfig.allow_change = true;
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
                this.methodConfig.available_for_pickup = false;
                this.methodConfig.available_for_delivery = {{ $codMethod->available_for_delivery ? 'true' : 'false' }};
            }
            @endif
        },
        
        async saveMethodConfig() {
            if (this.isLoading) return;
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
                    window.toast.success('¡Actualización exitosa!', 'Configuración guardada', 3000, 'bottom-center');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.toast.error('Error', data.message || 'No se pudo guardar', 5000, 'bottom-center');
                }
            } catch (error) {
                window.toast.error('Error', 'Error al guardar', 5000, 'bottom-center');
            } finally {
                this.isLoading = false;
            }
        },
        
        manageBankAccounts() {
            @if($bankTransferMethod)
                window.location.href = '{{ route("tenant.admin.payment-methods.bank-accounts.index", ["store" => $store->slug, "paymentMethod" => $bankTransferMethod->id]) }}';
            @else
                window.toast.warning('Atención', 'Primero activa Transferencia Bancaria', 4000, 'bottom-center');
            @endif
        }
    }
}
</script>
@endpush

@endsection
</x-tenant-admin-layout>
 