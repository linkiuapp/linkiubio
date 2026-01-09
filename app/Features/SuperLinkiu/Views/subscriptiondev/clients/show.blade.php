@extends('shared::layouts.admin')

@section('title', 'Cliente - ' . $client->name)

@section('content')
<div class="max-w-5xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('superlinkiu.subscriptiondev.clients.index') }}" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">{{ $client->name }}</h1>
                <p class="text-sm text-gray-600">{{ $client->email }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.create', ['client_id' => $client->id]) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Nueva Suscripción
            </a>
            <a href="{{ route('superlinkiu.subscriptiondev.clients.edit', $client) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                Editar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Info del Cliente --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Información del Cliente</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Nombre</p>
                    <p class="font-medium text-gray-900">{{ $client->name }}</p>
                </div>
                @if($client->email)
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-gray-900">{{ $client->email }}</p>
                    </div>
                @endif
                @if($client->phone)
                    <div>
                        <p class="text-sm text-gray-500">Teléfono</p>
                        <p class="text-gray-900">{{ $client->country_code }} {{ $client->phone }}</p>
                    </div>
                @endif
                @if($client->document)
                    <div>
                        <p class="text-sm text-gray-500">{{ $client->document_type_label }}</p>
                        <p class="text-gray-900">{{ $client->document }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-sm text-gray-500">Estado</p>
                    <span class="px-2 py-1 text-xs rounded-full {{ $client->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $client->is_active ? 'Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>

            @if($client->notes)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-500">Notas</p>
                    <p class="text-gray-700 text-sm">{{ $client->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Suscripciones --}}
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="font-semibold text-gray-900">Suscripciones</h3>
                <span class="text-sm text-gray-500">{{ $client->subscriptions->count() }} total</span>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($client->subscriptions as $sub)
                    <div class="p-4 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <a href="{{ route('superlinkiu.subscriptiondev.subscriptions.show', $sub) }}" class="font-medium text-gray-900 hover:text-blue-600">
                                    {{ $sub->service_name }}
                                </a>
                                <p class="text-sm text-gray-500">{{ $sub->period_label }} - {{ $sub->formatted_amount }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 text-xs rounded-full bg-{{ $sub->status_color }}-100 text-{{ $sub->status_color }}-800">
                                    {{ $sub->status_label }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Vence: {{ $sub->next_billing_date->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        Este cliente no tiene suscripciones
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (window.createIcons && window.lucideIcons) {
        window.createIcons({ icons: window.lucideIcons });
    }
});
</script>
@endsection
