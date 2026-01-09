@extends('shared::layouts.admin')

@section('title', 'Editar Suscripción')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 mt-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.show', $subscription) }}" class="text-gray-400 hover:text-gray-600">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Editar Suscripción</h1>
            <p class="text-sm text-gray-600">{{ $subscription->service_name }}</p>
        </div>
    </div>

    <form action="{{ route('superlinkiu.subscriptiondev.subscriptions.update', $subscription) }}" method="POST" class="bg-white rounded-lg shadow-sm border border-gray-200">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cliente *</label>
                <select name="client_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $subscription->client_id) == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Servicio</label>
                <select name="service_type_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white">
                    <option value="">Sin tipo predefinido</option>
                    @foreach($serviceTypes as $type)
                        <option value="{{ $type->id }}" {{ old('service_type_id', $subscription->service_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Servicio *</label>
                <input type="text" name="service_name" value="{{ old('service_name', $subscription->service_name) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="description" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">{{ old('description', $subscription->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Monto *</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 rounded-l-lg">$</span>
                        <input type="number" name="amount" value="{{ old('amount', $subscription->amount) }}" required min="0" step="0.01" class="flex-1 px-4 py-2.5 border border-gray-300">
                        <input type="hidden" name="currency" value="COP">
                        <span class="inline-flex items-center px-3 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 rounded-r-lg">COP</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Período *</label>
                    <select name="billing_period" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white">
                        @foreach($periods as $key => $label)
                            <option value="{{ $key }}" {{ old('billing_period', $subscription->billing_period) === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $subscription->start_date->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Próximo Cobro</label>
                    <input type="date" name="next_billing_date" value="{{ old('next_billing_date', $subscription->next_billing_date->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="status" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white">
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $subscription->status) === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notas Internas</label>
                <textarea name="notes" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">{{ old('notes', $subscription->notes) }}</textarea>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="auto_remind" id="auto_remind" value="1" {{ old('auto_remind', $subscription->auto_remind) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                <label for="auto_remind" class="text-sm text-gray-700">Enviar recordatorios automáticos</label>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between rounded-b-lg">
            <form action="{{ route('superlinkiu.subscriptiondev.subscriptions.destroy', $subscription) }}" method="POST" onsubmit="return confirm('¿Eliminar esta suscripción? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-700 font-medium">Eliminar</button>
            </form>
            <div class="flex gap-3">
                <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.show', $subscription) }}" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Guardar Cambios</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection
