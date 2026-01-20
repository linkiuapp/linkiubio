@extends('shared::layouts.admin')

@section('title', $tool->name . ' - Herramienta de Linkiu')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6" x-data="toolShow()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('superlinkiu.linkiu-tools.index') }}" class="inline-flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-5 h-5 text-gray-600 hover:text-gray-800"></i>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold text-gray-800">{{ $tool->name }}</h1>
                    @if($tool->is_critical)
                        <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">CRÍTICA</span>
                    @endif
                    @if($tool->status === 'active')
                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">ACTIVA</span>
                    @elseif($tool->status === 'inactive')
                        <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">INACTIVA</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">DEPRECADA</span>
                    @endif
                </div>
                <p class="text-sm text-gray-600 mt-1">{{ $tool->category ?? 'Sin categoría' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if($tool->billing_type !== 'free')
                <button onclick="openPaymentModal({{ $tool->id }}, '{{ $tool->name }}', '{{ $tool->getFormattedCost() }}', '{{ $tool->billing_type }}', '{{ $tool->currency }}')" 
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                    <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                    {{ $tool->isPayPerUse() ? 'Recargar' : 'Pagar' }}
                </button>
            @endif
            @if($tool->notification_phone)
                <button @click="sendNotification()" 
                        :disabled="sendingNotification"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2 disabled:opacity-50">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    <span x-show="!sendingNotification">Enviar Notificación</span>
                    <span x-show="sendingNotification">Enviando...</span>
                </button>
            @endif
            <a href="{{ route('superlinkiu.linkiu-tools.edit', $tool) }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="edit" class="w-4 h-4"></i>
                Editar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Columna Principal --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Información Básica --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                        Información
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    @if($tool->description)
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Para qué sirve</label>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $tool->description }}</p>
                        </div>
                    @endif
                    @if($tool->usage_in_linkiu)
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Para qué lo usamos en Linkiu</label>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $tool->usage_in_linkiu }}</p>
                        </div>
                    @endif
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                        @if($tool->url)
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">URL Principal</label>
                                <a href="{{ $tool->url }}" target="_blank" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                                    {{ Str::limit($tool->url, 40) }}
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                            </div>
                        @endif
                        @if($tool->dashboard_url)
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Panel de Administración</label>
                                <a href="{{ $tool->dashboard_url }}" target="_blank" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                                    {{ Str::limit($tool->dashboard_url, 40) }}
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                            </div>
                        @endif
                        @if($tool->api_docs_url)
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Documentación API</label>
                                <a href="{{ $tool->api_docs_url }}" target="_blank" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                                    {{ Str::limit($tool->api_docs_url, 40) }}
                                    <i data-lucide="external-link" class="w-3 h-3"></i>
                                </a>
                            </div>
                        @endif
                        @if($tool->responsible_team)
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Equipo Responsable</label>
                                <p class="text-sm text-gray-900">{{ $tool->responsible_team }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Credenciales --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="lock" class="w-5 h-5 text-red-600"></i>
                        Credenciales
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($tool->username)
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Usuario</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-mono flex-1">{{ $tool->username }}</p>
                                    <button @click="copyToClipboard('{{ $tool->username }}')" 
                                            class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if($decryptedData['password'])
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Contraseña</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-mono flex-1" x-text="showPassword ? '{{ $decryptedData['password'] }}' : '••••••••'"></p>
                                    <button @click="showPassword = !showPassword" 
                                            class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">
                                        <i data-lucide="eye" x-show="!showPassword" class="w-4 h-4"></i>
                                        <i data-lucide="eye-off" x-show="showPassword" class="w-4 h-4"></i>
                                    </button>
                                    <button @click="copyToClipboard('{{ $decryptedData['password'] }}')" 
                                            class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if($decryptedData['api_key'])
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">API Key</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-mono flex-1" x-text="showApiKey ? '{{ $decryptedData['api_key'] }}' : '••••••••'"></p>
                                    <button @click="showApiKey = !showApiKey" 
                                            class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">
                                        <i data-lucide="eye" x-show="!showApiKey" class="w-4 h-4"></i>
                                        <i data-lucide="eye-off" x-show="showApiKey" class="w-4 h-4"></i>
                                    </button>
                                    <button @click="copyToClipboard('{{ $decryptedData['api_key'] }}')" 
                                            class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if($decryptedData['api_secret'])
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">API Secret</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-mono flex-1" x-text="showApiSecret ? '{{ $decryptedData['api_secret'] }}' : '••••••••'"></p>
                                    <button @click="showApiSecret = !showApiSecret" 
                                            class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">
                                        <i data-lucide="eye" x-show="!showApiSecret" class="w-4 h-4"></i>
                                        <i data-lucide="eye-off" x-show="showApiSecret" class="w-4 h-4"></i>
                                    </button>
                                    <button @click="copyToClipboard('{{ $decryptedData['api_secret'] }}')" 
                                            class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                        @if($tool->account_id)
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">ID de Cuenta</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-mono flex-1">{{ $tool->account_id }}</p>
                                    <button @click="copyToClipboard('{{ $tool->account_id }}')" 
                                            class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded">
                                        <i data-lucide="copy" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Historial de Pagos/Recargas --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="dollar-sign" class="w-5 h-5 text-green-600"></i>
                        {{ $tool->isPayPerUse() ? 'Historial de Recargas' : 'Historial de Pagos' }}
                    </h2>
                </div>
                <div class="p-6">
                    {{-- Lista de Pagos --}}
                    @if($tool->paymentHistory->count() > 0)
                        <div class="space-y-3">
                            @foreach($tool->paymentHistory->sortByDesc('payment_date') as $payment)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-1">
                                            <span class="text-sm font-semibold text-gray-900">{{ $payment->getFormattedAmount() }}</span>
                                            <span class="px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded">
                                                {{ $payment->payment_type === 'recharge' ? 'Recarga' : ucfirst($payment->payment_type) }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-600">
                                            {{ $payment->payment_date->format('d/m/Y') }}
                                            @if($payment->notes)
                                                • {{ $payment->notes }}
                                            @endif
                                        </div>
                                    </div>
                                    @if($payment->receipt_path)
                                        <a href="{{ Storage::url($payment->receipt_path) }}" target="_blank"
                                           class="px-3 py-1.5 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                                            <i data-lucide="file-text" class="w-4 h-4 inline mr-1"></i>
                                            Ver Comprobante
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 text-center py-8">
                            {{ $tool->isPayPerUse() ? 'No hay recargas registradas' : 'No hay pagos registrados' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Facturación --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <i data-lucide="dollar-sign" class="w-5 h-5 text-green-600"></i>
                        Facturación
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tipo</label>
                        <p class="text-sm text-gray-900 font-semibold">
                            @if($tool->billing_type === 'free')
                                Gratis
                            @elseif($tool->billing_type === 'monthly')
                                Mensual
                            @elseif($tool->billing_type === 'yearly')
                                Anual
                            @else
                                Por uso
                            @endif
                        </p>
                    </div>
                    @if($tool->billing_type !== 'free')
                        @if($tool->isPayPerUse())
                            @if($tool->current_balance !== null)
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Saldo Actual</label>
                                    <p class="text-lg font-bold {{ $tool->isBalanceLow() ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $tool->getFormattedBalance() }}
                                        @if($tool->isBalanceLow())
                                            <span class="ml-2 text-xs text-red-600">⚠️ Saldo bajo</span>
                                        @endif
                                    </p>
                                </div>
                                @if($tool->minimum_recharge)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Recarga Mínima Recomendada</label>
                                        <p class="text-sm text-gray-900">{{ $tool->getBalanceCurrency() }} {{ number_format($tool->minimum_recharge, 2) }}</p>
                                    </div>
                                @endif
                            @else
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Saldo Actual</label>
                                    <p class="text-sm text-gray-500">No disponible</p>
                                </div>
                            @endif
                        @else
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Costo</label>
                                <p class="text-lg font-bold text-gray-900">{{ $tool->getFormattedCost() }}</p>
                            </div>
                        @endif
                    @endif
                    @if($tool->start_date)
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Fecha de Inicio</label>
                            <p class="text-sm text-gray-900">{{ $tool->start_date->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    @if($tool->last_renewal_date)
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Última Renovación</label>
                            <p class="text-sm text-gray-900">{{ $tool->last_renewal_date->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    @if($tool->next_renewal_date)
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Próxima Renovación</label>
                            <div class="flex flex-col gap-1">
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $tool->next_renewal_date->format('d/m/Y') }}
                                </p>
                                @if($tool->getPaymentStatus())
                                    @php
                                        $status = $tool->getPaymentStatus();
                                        $label = $tool->getPaymentStatusLabel();
                                        $daysOverdue = $tool->getDaysOverdue();
                                    @endphp
                                    @if($status === 'active')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 w-fit">
                                            {{ $label }}
                                        </span>
                                    @elseif($status === 'upcoming')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 w-fit">
                                            {{ $label }}
                                        </span>
                                    @elseif($status === 'due')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 w-fit">
                                            {{ $label }}
                                        </span>
                                    @elseif($status === 'overdue')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 w-fit">
                                            {{ $label }} ({{ $daysOverdue }} días)
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Notas --}}
            @if($tool->notes)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-5 h-5 text-gray-600"></i>
                            Notas
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $tool->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal de Pago --}}
<div x-data="paymentModal()" 
     x-show="open" 
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center"
     style="display: none;"
     x-init="init()">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal()"></div>
    
    {{-- Modal Container --}}
    <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full mx-4 z-10" @click.stop>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900" x-text="billingType === 'pay_per_use' ? 'Registrar Recarga' : 'Registrar Pago'"></h3>
                <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form :id="'paymentForm-' + toolId" method="POST" enctype="multipart/form-data" @submit.prevent="submitPayment">
                @csrf
                <input type="hidden" name="tool_id" :value="toolId">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Herramienta</label>
                        <input type="text" :value="toolName" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <span x-text="billingType === 'pay_per_use' ? 'Fecha de Recarga' : 'Fecha de Pago'"></span> <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="payment_date" required :value="today" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <span x-text="billingType === 'pay_per_use' ? 'Monto de Recarga' : 'Monto'"></span> <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" name="currency" :value="currency" readonly class="w-20 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 text-sm">
                            <input type="number" name="amount" step="0.01" :value="amountValue" required class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div x-show="billingType !== 'pay_per_use'">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Pago <span class="text-red-500">*</span></label>
                        <select name="payment_type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="monthly" :selected="billingType === 'monthly'">Mensual</option>
                            <option value="yearly" :selected="billingType === 'yearly'">Anual</option>
                            <option value="renewal">Renovación</option>
                            <option value="one_time">Pago único</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>
                    <input type="hidden" name="payment_type" value="recharge" x-show="billingType === 'pay_per_use'">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comprobante</label>
                        <input type="file" name="receipt" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Formatos: PDF, JPG, PNG (máx. 5MB)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                        <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
                                  :placeholder="billingType === 'pay_per_use' ? 'Notas adicionales sobre la recarga...' : 'Notas adicionales sobre el pago...'"></textarea>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" @click="closeModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <span x-text="billingType === 'pay_per_use' ? 'Registrar Recarga' : 'Registrar Pago'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
function paymentModal() {
    return {
        open: false,
        toolId: null,
        toolName: '',
        amount: '',
        amountValue: '',
        billingType: '',
        currency: '',
        today: new Date().toISOString().split('T')[0],
        
        init() {
            // Escuchar evento para abrir modal
            const self = this;
            window.addEventListener('openPaymentModal', function(e) {
                self.toolId = e.detail.toolId;
                self.toolName = e.detail.toolName;
                self.amount = e.detail.amount;
                self.amountValue = e.detail.amount.replace(/[^\d.]/g, '');
                self.billingType = e.detail.billingType;
                self.currency = e.detail.currency;
                self.open = true;
                // Forzar actualización de Alpine
                self.$nextTick(() => {
                    if (window.createIcons && window.lucideIcons) {
                        window.createIcons({ icons: window.lucideIcons });
                    }
                });
            });
        },
        
        closeModal() {
            this.open = false;
        },
        
        submitPayment() {
            const formId = 'paymentForm-' + this.toolId;
            const form = document.getElementById(formId);
            if (!form) {
                alert('Error: No se encontró el formulario');
                return;
            }
            
            const formData = new FormData(form);
            
            fetch(`/superlinkiu/linkiu-tools/${this.toolId}/payment`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                } else if (response.ok) {
                    return response.json();
                } else {
                    return response.text().then(text => {
                        throw new Error(text || 'Error en la respuesta del servidor');
                    });
                }
            })
            .then(data => {
                if (data && data.success) {
                    window.location.reload();
                } else if (data) {
                    alert(data?.message || 'Error al registrar el pago');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al registrar el pago. Por favor, intenta nuevamente.');
            });
        }
    }
}

function openPaymentModal(toolId, toolName, amount, billingType, currency) {
    // Buscar el modal en la página
    const modal = document.querySelector('[x-data*="paymentModal"]');
    if (modal && modal.__x && modal.__x.$data) {
        // Usar Alpine directamente si está disponible
        modal.__x.$data.toolId = toolId;
        modal.__x.$data.toolName = toolName;
        modal.__x.$data.amount = amount;
        modal.__x.$data.amountValue = amount.replace(/[^\d.]/g, '');
        modal.__x.$data.billingType = billingType;
        modal.__x.$data.currency = currency;
        modal.__x.$data.open = true;
    } else {
        // Si Alpine no está disponible, usar evento
        window.dispatchEvent(new CustomEvent('openPaymentModal', {
            detail: {
                toolId: toolId,
                toolName: toolName,
                amount: amount,
                billingType: billingType,
                currency: currency
            }
        }));
    }
}

document.addEventListener('alpine:init', () => {
    Alpine.data('toolShow', () => ({
        showPassword: false,
        showApiKey: false,
        showApiSecret: false,
        sendingNotification: false,

        copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Copiado al portapapeles');
                });
            } else {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Copiado al portapapeles');
            }
        },

        async sendNotification() {
            if (!confirm('¿Enviar notificación de pago por WhatsApp?')) {
                return;
            }

            this.sendingNotification = true;
            try {
                const response = await fetch('{{ route("superlinkiu.linkiu-tools.send-notification", $tool) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                });

                const data = await response.json();
                if (data.success) {
                    alert('Notificación enviada exitosamente');
                } else {
                    alert('Error: ' + (data.message || 'No se pudo enviar la notificación'));
                }
            } catch (error) {
                alert('Error al enviar notificación: ' + error.message);
            } finally {
                this.sendingNotification = false;
            }
        }
    }));
});

document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endpush
@endsection
