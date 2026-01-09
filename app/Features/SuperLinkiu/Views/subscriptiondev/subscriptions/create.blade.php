@extends('shared::layouts.admin')

@section('title', 'Nueva Suscripción')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.index') }}" class="text-gray-400 hover:text-gray-600">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Nueva Suscripción</h1>
            <p class="text-sm text-gray-600">Crea una nueva suscripción para un cliente</p>
        </div>
    </div>

    <form action="{{ route('superlinkiu.subscriptiondev.subscriptions.store') }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-200">
        @csrf

        <div class="p-6 space-y-6">
            {{-- Cliente --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cliente *</label>
                <select name="client_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <option value="">Seleccionar cliente...</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $selectedClient?->id) == $client->id ? 'selected' : '' }}>
                            {{ $client->name }} {{ $client->email ? "({$client->email})" : '' }}
                        </option>
                    @endforeach
                </select>
                @error('client_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-500 mt-1">
                    <a href="{{ route('superlinkiu.subscriptiondev.clients.create') }}" class="text-blue-600 hover:underline">+ Crear nuevo cliente</a>
                </p>
            </div>

            {{-- Tipo de servicio (opcional) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Servicio</label>
                <select name="service_type_id" id="service_type_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <option value="">Sin tipo predefinido</option>
                    @foreach($serviceTypes as $type)
                        <option value="{{ $type->id }}" data-price="{{ $type->default_price }}" data-name="{{ $type->name }}" {{ old('service_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }} - {{ $type->formatted_price }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nombre del servicio --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Servicio *</label>
                <input type="text" name="service_name" value="{{ old('service_name') }}" required placeholder="Ej: Dominio miempresa.com" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                @error('service_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="description" rows="2" placeholder="Detalles adicionales..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- Monto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Monto *</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 rounded-l-lg">$</span>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0" step="0.01" placeholder="150000" class="flex-1 px-4 py-2.5 border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                        <input type="hidden" name="currency" value="COP">
                        <span class="inline-flex items-center px-3 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 rounded-r-lg">COP</span>
                    </div>
                    @error('amount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Período --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Período de Facturación *</label>
                    <select name="billing_period" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        @foreach($periods as $key => $label)
                            <option value="{{ $key }}" {{ old('billing_period', 'annual') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- Fecha de inicio --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                </div>

                {{-- Próximo cobro --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Próximo Cobro *</label>
                    <input type="date" name="next_billing_date" value="{{ old('next_billing_date', date('Y-m-d', strtotime('+1 year'))) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                </div>
            </div>

            {{-- Notas --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notas Internas</label>
                <textarea name="notes" rows="2" placeholder="Notas privadas..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">{{ old('notes') }}</textarea>
            </div>

            {{-- Recordatorios automáticos --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="auto_remind" id="auto_remind" value="1" checked class="w-4 h-4 text-blue-600 rounded">
                <label for="auto_remind" class="text-sm text-gray-700">Enviar recordatorios automáticos por WhatsApp</label>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3 rounded-b-lg">
            <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                Crear Suscripción
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }

    // Auto-fill from service type
    const serviceTypeSelect = document.getElementById('service_type_id');
    const amountInput = document.getElementById('amount');
    const serviceNameInput = document.querySelector('input[name="service_name"]');

    serviceTypeSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (option.value) {
            const price = option.dataset.price;
            const name = option.dataset.name;
            if (price && !amountInput.value) {
                amountInput.value = price;
            }
            if (name && !serviceNameInput.value) {
                serviceNameInput.value = name;
            }
        }
    });
});
</script>
@endsection
