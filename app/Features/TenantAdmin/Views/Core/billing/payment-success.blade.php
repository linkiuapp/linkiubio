@extends('shared::layouts.tenant-admin')

@section('title', 'Pago Exitoso')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-md w-full text-center">
        {{-- Icono de éxito --}}
        <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
            <i data-lucide="check-circle" class="w-12 h-12 text-green-600"></i>
        </div>

        {{-- Título --}}
        <h1 class="text-2xl font-bold text-gray-900 mb-2">¡Pago Exitoso!</h1>
        <p class="text-gray-600 mb-8">Tu suscripción ha sido renovada correctamente.</p>

        {{-- Detalles --}}
        @if($subscription && $plan)
        <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Detalles de la renovación</h3>
            
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Plan</span>
                    <span class="font-medium text-gray-900">{{ $plan->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Período</span>
                    <span class="font-medium text-gray-900">{{ $subscription->billing_cycle_label }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Válido hasta</span>
                    <span class="font-medium text-gray-900">{{ $subscription->current_period_end->locale('es')->isoFormat('D MMM YYYY') }}</span>
                </div>
                @if($transaction)
                <div class="flex justify-between text-sm pt-3 border-t border-gray-200">
                    <span class="text-gray-600">Referencia</span>
                    <span class="font-mono text-xs text-gray-500">{{ $transaction->reference }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Mensaje de confirmación --}}
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
            <p class="text-sm text-green-800 flex items-center justify-center gap-2">
                <i data-lucide="mail" class="w-4 h-4"></i>
                Te hemos enviado un comprobante a tu correo electrónico.
            </p>
        </div>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('tenant.admin.billing.index', $store->slug) }}" 
               class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                Ver Facturación
            </a>
            <a href="{{ route('tenant.admin.dashboard', $store->slug) }}" 
               class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition-colors">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                Ir al Panel
            </a>
        </div>
    </div>
</div>
@endsection
