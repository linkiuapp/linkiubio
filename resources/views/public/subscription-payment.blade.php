<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pago de Suscripción - {{ $subscription->service_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-lg mx-auto px-4 py-8">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-blue-600">LinkiuDev</h1>
            <p class="text-sm text-gray-500">Portal de Pagos</p>
        </div>

        {{-- Card Principal --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            {{-- Header con Estado --}}
            <div class="px-6 py-4 {{ $subscription->is_overdue ? 'bg-red-500' : ($subscription->is_due_soon ? 'bg-yellow-500' : 'bg-green-500') }} text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90">Estado de la suscripción</p>
                        <p class="text-lg font-semibold">
                            @if($subscription->is_overdue)
                                ⚠️ Vencida
                            @elseif($subscription->is_due_soon)
                                ⏰ Por vencer
                            @else
                                ✅ Activa
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-90">Vencimiento</p>
                        <p class="text-lg font-semibold">{{ $subscription->next_billing_date->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Detalles --}}
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <div>
                        <p class="text-sm text-gray-500">Servicio</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $subscription->service_name }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Cliente</p>
                        <p class="text-gray-900">{{ $subscription->client->partial_name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Período</p>
                        <p class="text-gray-900">{{ $subscription->period_label }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <p class="text-sm text-gray-500 mb-1">Monto a pagar</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $subscription->formatted_amount }}</p>
                </div>

                @if($subscription->description)
                    <div class="text-sm text-gray-600">
                        <p class="font-medium text-gray-700">Descripción:</p>
                        <p>{{ $subscription->description }}</p>
                    </div>
                @endif
            </div>

            @if($payment && $payment->status === 'pending' && $gateway)
                {{-- Formulario de Pago --}}
                <form action="{{ route('public.subscription.process', $subscription->payment_token) }}" method="POST" class="p-6 pt-0">
                    @csrf

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        {{-- Método de pago --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Método de pago</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="payment_method" value="pse" checked class="text-blue-600">
                                    <span class="text-sm">PSE (Bancos)</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="payment_method" value="cash" class="text-blue-600">
                                    <span class="text-sm">Efectivo</span>
                                </label>
                            </div>
                        </div>

                        {{-- Banco (PSE) --}}
                        <div id="bank-field">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Banco</label>
                            <select name="bank_code" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white">
                                <option value="">Seleccionar banco...</option>
                                @foreach($pseBanks as $bank)
                                    <option value="{{ $bank['bankCode'] ?? $bank['bank_code'] }}">
                                        {{ $bank['bankName'] ?? $bank['bank_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tipo de efectivo --}}
                        <div id="cash-field" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Punto de pago</label>
                            <select name="cash_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white">
                                <option value="EF">Efecty</option>
                                <option value="BA">Baloto</option>
                                <option value="GA">Gana</option>
                                <option value="PR">Punto Red</option>
                            </select>
                        </div>

                        {{-- Documento --}}
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                                <select name="document_type" required class="w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white">
                                    <option value="CC">CC</option>
                                    <option value="CE">CE</option>
                                    <option value="NIT">NIT</option>
                                    <option value="PA">PA</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Número de documento</label>
                                <input type="text" name="document" required placeholder="123456789" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">
                        Pagar {{ $subscription->formatted_amount }}
                    </button>
                </form>
            @elseif($payment && $payment->status === 'paid')
                <div class="p-6 pt-0 text-center">
                    <div class="bg-green-50 rounded-xl p-6">
                        <p class="text-green-600 font-semibold text-lg">✅ Pago completado</p>
                        <p class="text-sm text-gray-600 mt-2">Gracias por tu pago. Tu suscripción está activa.</p>
                    </div>
                </div>
            @else
                <div class="p-6 pt-0 text-center">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <p class="text-gray-600">No hay pagos pendientes para esta suscripción.</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="text-center mt-8 text-sm text-gray-500">
            <p>Pago seguro procesado por ePayco</p>
            <p class="mt-2">¿Tienes preguntas? Contáctanos</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const methodRadios = document.querySelectorAll('input[name="payment_method"]');
            const bankField = document.getElementById('bank-field');
            const cashField = document.getElementById('cash-field');

            methodRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'pse') {
                        bankField.style.display = 'block';
                        cashField.style.display = 'none';
                    } else {
                        bankField.style.display = 'none';
                        cashField.style.display = 'block';
                    }
                });
            });
        });
    </script>
</body>
</html>
