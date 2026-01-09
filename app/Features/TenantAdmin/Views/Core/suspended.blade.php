@extends('shared::layouts.tenant-admin')

@section('title', 'Tienda Suspendida')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="max-w-lg w-full">
        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl shadow-lg border border-red-200 overflow-hidden">
            {{-- Header con fondo rojo --}}
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-8 text-center">
                <div class="mx-auto w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="alert-octagon" class="w-10 h-10 text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">Tienda Suspendida</h1>
                <p class="text-red-100 mt-2">Tu acceso ha sido restringido temporalmente</p>
            </div>

            {{-- Contenido --}}
            <div class="p-6">
                {{-- Motivo de suspensión --}}
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <h3 class="text-sm font-semibold text-red-900 mb-2 flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4"></i>
                        Motivo de la suspensión
                    </h3>
                    <p class="text-sm text-red-800">
                        @if($store->suspension_reason === 'billing_overdue')
                            Tu tienda ha sido suspendida debido a facturas vencidas sin pagar. 
                            Por favor, regulariza tu situación para reactivar todos los servicios.
                        @elseif($store->suspension_reason === 'trial_expired_no_payment')
                            Tu período de prueba ha finalizado y no se ha registrado ningún pago.
                            Realiza el pago de tu suscripción para continuar usando la plataforma.
                        @else
                            Tu tienda ha sido suspendida. Por favor, contacta a soporte para más información.
                        @endif
                    </p>
                </div>

                {{-- Qué puedes hacer --}}
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">¿Qué puedes hacer?</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-500 mt-0.5 shrink-0"></i>
                            <span>Realizar el pago pendiente para reactivar tu tienda inmediatamente</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-500 mt-0.5 shrink-0"></i>
                            <span>Revisar tu estado de facturación</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-500 mt-0.5 shrink-0"></i>
                            <span>Contactar a soporte si crees que es un error</span>
                        </li>
                    </ul>
                </div>

                {{-- Información de facturación --}}
                @if($pendingInvoice)
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-amber-600 font-medium">Factura pendiente</p>
                            <p class="text-lg font-bold text-amber-900">${{ number_format($pendingInvoice->amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-amber-600">Vencida hace</p>
                            <p class="text-sm font-semibold text-amber-900">{{ $pendingInvoice->due_date->diffInDays(now()) }} días</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Botones de acción --}}
                <div class="flex flex-col gap-3">
                    <a href="{{ route('tenant.admin.billing.checkout', $store->slug) }}" 
                       class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-colors shadow-lg shadow-green-600/30">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                        Pagar Ahora y Reactivar
                    </a>
                    
                    <a href="{{ route('tenant.admin.billing.index', $store->slug) }}" 
                       class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl transition-colors">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                        Ver Estado de Facturación
                    </a>
                </div>

                {{-- Soporte --}}
                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-500 mb-3">¿Necesitas ayuda?</p>
                    <a href="https://wa.me/573104594344?text=Hola,%20mi%20tienda%20{{ urlencode($store->name) }}%20ha%20sido%20suspendida%20y%20necesito%20ayuda" 
                       target="_blank"
                       class="inline-flex items-center gap-2 text-sm text-green-600 hover:text-green-700 font-medium">
                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                        Contactar por WhatsApp
                    </a>
                </div>
            </div>
        </div>

        {{-- Info adicional --}}
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                Una vez realizado el pago, tu tienda será reactivada automáticamente en un plazo máximo de 24 horas.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Inicializar iconos Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endpush
@endsection
