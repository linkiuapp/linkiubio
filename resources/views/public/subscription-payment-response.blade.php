<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Pago - LinkiuDev</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden text-center">
            {{-- Icono de estado --}}
            <div class="p-8 {{ $status === 'approved' ? 'bg-green-500' : ($status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }}">
                @if($status === 'approved')
                    <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                @elseif($status === 'rejected')
                    <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                @else
                    <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <div class="p-6 space-y-4">
                <h1 class="text-xl font-bold text-gray-900">
                    @if($status === 'approved')
                        ¡Pago Exitoso!
                    @elseif($status === 'rejected')
                        Pago Rechazado
                    @else
                        Pago en Proceso
                    @endif
                </h1>
                
                <p class="text-gray-600">{{ $message }}</p>

                <div class="bg-gray-50 rounded-xl p-4 text-left space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Servicio:</span>
                        <span class="text-gray-900 font-medium">{{ $payment->subscription->service_name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Monto:</span>
                        <span class="text-gray-900 font-medium">{{ $payment->formatted_amount }}</span>
                    </div>
                    @if($payment->payment_reference)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Referencia:</span>
                            <span class="text-gray-900 font-medium">{{ $payment->payment_reference }}</span>
                        </div>
                    @endif
                </div>

                @if($status === 'approved')
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-700">
                        Tu suscripción está activa hasta el <strong>{{ $payment->subscription->next_billing_date->format('d/m/Y') }}</strong>
                    </div>
                @elseif($status === 'rejected')
                    <a href="{{ route('public.subscription.show', $payment->subscription->payment_token) }}" class="inline-block w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                        Intentar de nuevo
                    </a>
                @endif
            </div>
        </div>

        <div class="text-center mt-6 text-sm text-gray-500">
            <p>LinkiuDev - Portal de Pagos</p>
        </div>
    </div>
</body>
</html>
