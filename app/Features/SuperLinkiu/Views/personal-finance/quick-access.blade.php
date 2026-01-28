<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Finanzas Rápidas - LINKIU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
    <style>
        /* Estilos específicos para mobile - App Bancaria */
        * {
            -webkit-tap-highlight-color: transparent;
        }
        body {
            overscroll-behavior: none;
            background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Gradientes de tarjetas bancarias */
        .card-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-gradient-blue {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        .card-gradient-green {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        }
        .card-gradient-orange {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
        }
        .card-gradient-red {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        }
        .card-gradient-purple {
            background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        }
        
        /* Carrusel de tarjetas */
        .cards-wrapper {
            position: relative;
        }
        .cards-container {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            gap: 16px;
            padding: 0 50px 20px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .cards-container::-webkit-scrollbar {
            display: none;
        }
        .card-item {
            flex: 0 0 85%;
            scroll-snap-align: start;
            scroll-snap-stop: always;
        }
        .card-shadow {
            box-shadow: 0 20px 40px rgba(0,0,0,0.15), 0 0 0 1px rgba(255,255,255,0.1);
        }
        
        /* Flechas del carrusel */
        .carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        .carousel-arrow:hover {
            background: #f3f4f6;
            transform: translateY(-50%) scale(1.1);
        }
        .carousel-arrow:active {
            transform: translateY(-50%) scale(0.95);
        }
        .carousel-arrow.left {
            left: 8px;
        }
        .carousel-arrow.right {
            right: 8px;
        }
        .carousel-arrow:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        
        /* Indicadores de página */
        .card-indicators {
            display: flex;
            justify-content: center;
            gap: 6px;
            padding: 12px 0;
        }
        .indicator {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .indicator.active {
            width: 20px;
            border-radius: 3px;
            background: #3b82f6;
        }
        
        /* Animaciones */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.4s ease-out;
        }
        
        /* Mejoras de texto */
        .text-balance {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .text-card-title {
            font-size: 14px;
            font-weight: 500;
            opacity: 0.9;
        }
        .text-card-amount {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        /* Modales más pequeños */
        .modal-content {
            max-width: 85%;
            width: 100%;
        }
    </style>
</head>
<body class="min-h-screen pb-24">
    <div class="max-w-md mx-auto">
        <!-- Header Moderno - Mejor Organizado -->
        <div class="bg-white shadow-sm sticky top-0 z-20 rounded-full border-gray-100 mt-8">
            <div class="px-5 py-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                            <i data-lucide="wallet" class="w-5 h-5 text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-base font-bold text-gray-900">Mis Finanzas</h1>
                            <p class="text-xs text-gray-500">{{ now()->format('d M Y') }}</p>
                        </div>
                    </div>
                    <button onclick="location.reload()" class="p-2.5 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors active:scale-95">
                        <i data-lucide="refresh-cw" class="w-5 h-5 text-gray-700"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Resumen Rápido - Estilo App Bancaria -->
        <div class="px-5 pt-6 pb-4">
            <div class="bg-white rounded-3xl shadow-lg p-6 mb-6 animate-slide-in">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Saldo Total</span>
                    <i data-lucide="wallet" class="w-5 h-5 text-gray-400"></i>
                </div>
                <p class="text-balance text-gray-900 mb-6">${{ number_format($totalBalance, 0, ',', '.') }}</p>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">A pagar esta semana</p>
                        <p class="text-lg font-bold text-red-600">${{ number_format($totalDueThisWeek, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 mb-1">Cuentas activas</p>
                        <p class="text-lg font-bold text-gray-900">{{ $accounts->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuentas Bancarias - Carrusel Deslizable -->
        @if($accounts->count() > 0)
        <div class="mb-6">
            <div class="px-5 mb-3 flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-900">Mis Tarjetas</h2>
                <span class="text-xs text-gray-500">{{ $accounts->count() }} cuenta(s)</span>
            </div>
            
            <div class="cards-wrapper">
                <!-- Flecha izquierda -->
                <button class="carousel-arrow left" id="prevCard" onclick="scrollCard(-1)">
                    <i data-lucide="chevron-left" class="w-5 h-5 text-gray-700"></i>
                </button>
                
                <div class="cards-container" id="cardsContainer">
                    @foreach($accounts as $account)
                        @php
                            $gradients = ['card-gradient-blue', 'card-gradient-green', 'card-gradient-orange', 'card-gradient-red', 'card-gradient-purple'];
                            $gradient = $gradients[$loop->index % count($gradients)];
                        @endphp
                        <div class="card-item">
                            <div class="relative rounded-3xl p-5 text-white {{ $gradient }} card-shadow overflow-hidden min-h-[170px]">
                            <!-- Patrón decorativo mejorado -->
                            <div class="absolute top-0 right-0 w-40 h-40 bg-white opacity-10 rounded-full -mr-20 -mt-20"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-10 rounded-full -ml-16 -mb-16"></div>
                            <div class="absolute top-1/2 right-0 w-24 h-24 bg-white opacity-5 rounded-full -mr-12"></div>
                            
                            <div class="relative z-10 h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <p class="text-card-title mb-1">{{ $account->name }}</p>
                                            <p class="text-xs opacity-80">{{ $account->type_label }}</p>
                                        </div>
                                        <div class="w-11 h-11 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                            @if($account->type === 'credit_card')
                                                <i data-lucide="credit-card" class="w-6 h-6"></i>
                                            @else
                                                <i data-lucide="wallet" class="w-6 h-6"></i>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-xs opacity-80 mb-2">Saldo Disponible</p>
                                        <p class="text-card-amount">${{ number_format($account->current_balance, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                @if($account->bank_name || $account->account_number)
                                <div class="flex items-center justify-between text-xs opacity-80 pt-3 border-t border-white/20">
                                    @if($account->bank_name)
                                        <span class="font-medium">{{ $account->bank_name }}</span>
                                    @endif
                                    @if($account->account_number)
                                        <span class="font-mono tracking-wider">****{{ substr($account->account_number, -4) }}</span>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
                
                <!-- Flecha derecha -->
                <button class="carousel-arrow right" id="nextCard" onclick="scrollCard(1)">
                    <i data-lucide="chevron-right" class="w-5 h-5 text-gray-700"></i>
                </button>
            </div>
            
            <!-- Indicadores de página -->
            @if($accounts->count() > 1)
            <div class="card-indicators" id="cardIndicators">
                @foreach($accounts as $index => $account)
                    <div class="indicator {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        <!-- Próximos Pagos - Estilo App -->
        <div class="px-5 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-gray-900">Próximos Pagos</h2>
                @if($overdueInstallments->count() > 0 || $upcomingInstallments->count() > 0)
                    <span class="text-xs font-medium text-red-600 bg-red-50 px-2.5 py-1 rounded-full">
                        {{ $overdueInstallments->count() + $upcomingInstallments->count() }} pendiente(s)
                    </span>
                @endif
            </div>
            
            @if($overdueInstallments->count() > 0)
            <div class="mb-4">
                <p class="text-xs font-semibold text-red-600 mb-3 uppercase tracking-wide">⚠️ Vencidas</p>
                @foreach($overdueInstallments as $installment)
                    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-4 mb-3 animate-slide-in">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900 mb-1">{{ $installment->debt->name }}</p>
                                <p class="text-xs text-gray-500 mb-2">Vencida el {{ $installment->due_date->format('d M Y') }}</p>
                                <p class="text-xl font-bold text-red-600">${{ number_format($installment->amount, 0, ',', '.') }}</p>
                            </div>
                            <button onclick="openPayModal({{ $installment->id }}, {{ $installment->amount }}, '{{ $installment->debt->name }}')" 
                                class="ml-3 px-5 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold shadow-lg active:scale-95 transition-transform">
                                Pagar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif

            @if($upcomingInstallments->count() > 0)
            <div class="space-y-3">
                @foreach($upcomingInstallments as $installment)
                    @php
                        $daysUntilDue = now()->diffInDays($installment->due_date, false);
                        $isUrgent = $daysUntilDue <= 3;
                    @endphp
                    <div class="bg-white rounded-2xl shadow-sm border {{ $isUrgent ? 'border-yellow-200 bg-yellow-50/50' : 'border-gray-100' }} p-4 animate-slide-in">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900 mb-1">{{ $installment->debt->name }}</p>
                                <div class="flex items-center gap-2 mb-2">
                                    <p class="text-xs text-gray-500">Vence {{ $installment->due_date->format('d M') }}</p>
                                    @if($daysUntilDue >= 0)
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $isUrgent ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $daysUntilDue === 0 ? 'Hoy' : ($daysUntilDue === 1 ? 'Mañana' : "{$daysUntilDue}d") }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xl font-bold text-gray-900">${{ number_format($installment->amount, 0, ',', '.') }}</p>
                            </div>
                            <button onclick="openPayModal({{ $installment->id }}, {{ $installment->amount }}, '{{ $installment->debt->name }}')" 
                                class="ml-3 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold shadow-lg active:scale-95 transition-all">
                                Pagar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            @elseif($overdueInstallments->count() === 0)
                <div class="bg-white rounded-2xl p-8 text-center border border-gray-100">
                    <i data-lucide="check-circle" class="w-14 h-14 text-green-300 mx-auto mb-3"></i>
                    <p class="text-sm font-medium text-gray-600">No hay pagos pendientes</p>
                    <p class="text-xs text-gray-400 mt-1">Esta semana está al día</p>
                </div>
            @endif
        </div>

        <!-- Acciones Rápidas - Estilo App -->
        <div class="px-5 mb-6">
            <h2 class="text-base font-bold text-gray-900 mb-4">Acciones Rápidas</h2>
            <div class="grid grid-cols-2 gap-3">
                <button onclick="openIncomeModal()" class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl p-5 flex flex-col items-center justify-center shadow-lg active:scale-95 transition-all">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-3">
                        <i data-lucide="arrow-down-circle" class="w-8 h-8"></i>
                    </div>
                    <span class="font-bold text-sm">Ingreso</span>
                    <span class="text-xs opacity-90 mt-0.5">Agregar</span>
                </button>
                <button onclick="openExpenseModal()" class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-2xl p-5 flex flex-col items-center justify-center shadow-lg active:scale-95 transition-all">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-3">
                        <i data-lucide="arrow-up-circle" class="w-8 h-8"></i>
                    </div>
                    <span class="font-bold text-sm">Gasto</span>
                    <span class="text-xs opacity-90 mt-0.5">Agregar</span>
                </button>
            </div>
        </div>

        <!-- Historial Reciente - Estilo App -->
        @if($recentTransactions->count() > 0)
        <div class="px-5 mb-6">
            <h2 class="text-base font-bold text-gray-900 mb-4">Últimas Transacciones</h2>
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                @foreach($recentTransactions as $transaction)
                    <div class="p-4 border-b border-gray-50 last:border-0 flex items-center justify-between active:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0 {{ $transaction->type === 'income' ? 'bg-green-100' : 'bg-red-100' }}">
                                <i data-lucide="{{ $transaction->type === 'income' ? 'arrow-down' : 'arrow-up' }}" class="w-6 h-6 {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ Str::limit($transaction->description, 25) }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $transaction->transaction_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <p class="text-base font-bold ml-3 flex-shrink-0 {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Modal Pagar Cuota -->
    <div id="payModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden items-center justify-center p-4" onclick="closePayModal(event)">
        <div class="bg-white rounded-2xl max-w-md w-full p-6" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Pagar Cuota</h3>
                <button onclick="closePayModal(event)" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="payForm" onsubmit="payInstallment(event)">
                <input type="hidden" id="payInstallmentId">
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-1">Deuda</p>
                    <p class="font-semibold text-gray-900" id="payDebtName"></p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cuenta Bancaria *</label>
                    <select id="payAccountId" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Selecciona una cuenta</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }} - ${{ number_format($account->current_balance, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Monto a Pagar *</label>
                    <input type="number" id="payAmount" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Monto mínimo: $<span id="payMinAmount"></span></p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago *</label>
                    <select id="payMethod" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="transfer">Transferencia</option>
                        <option value="cash">Efectivo</option>
                        <option value="account_bank">Cuenta Bancaria</option>
                        <option value="nequi">Nequi</option>
                        <option value="daviplata">Daviplata</option>
                        <option value="other">Otro</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg py-3 font-medium transition-colors">
                    Confirmar Pago
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Agregar Ingreso -->
    <div id="incomeModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden items-center justify-center p-4" onclick="closeIncomeModal(event)">
        <div class="bg-white rounded-2xl modal-content p-5" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Agregar Ingreso</h3>
                <button onclick="closeIncomeModal(event)" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="incomeForm" onsubmit="addIncome(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cuenta Bancaria *</label>
                    <select id="incomeAccountId" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Selecciona una cuenta</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Monto *</label>
                    <input type="number" id="incomeAmount" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción *</label>
                    <input type="text" id="incomeDescription" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white rounded-lg py-3 font-medium transition-colors">
                    Agregar Ingreso
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Agregar Gasto -->
    <div id="expenseModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden items-center justify-center p-4" onclick="closeExpenseModal(event)">
        <div class="bg-white rounded-2xl modal-content p-5" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Agregar Gasto</h3>
                <button onclick="closeExpenseModal(event)" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="expenseForm" onsubmit="addExpense(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cuenta Bancaria *</label>
                    <select id="expenseAccountId" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Selecciona una cuenta</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Monto *</label>
                    <input type="number" id="expenseAmount" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción *</label>
                    <input type="text" id="expenseDescription" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Método de Pago *</label>
                    <select id="expenseMethod" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="transfer">Transferencia</option>
                        <option value="cash">Efectivo</option>
                        <option value="account_bank">Cuenta Bancaria</option>
                        <option value="nequi">Nequi</option>
                        <option value="daviplata">Daviplata</option>
                        <option value="other">Otro</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white rounded-lg py-3 font-medium transition-colors">
                    Agregar Gasto
                </button>
            </form>
        </div>
    </div>

    <script>
        const code = '{{ $accessToken->short_code }}';
        
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Inicializar carrusel de tarjetas
            initCardCarousel();
        });

        // Carrusel de tarjetas con indicadores y flechas
        let currentCardIndex = 0;
        let totalCards = 0;
        
        function initCardCarousel() {
            const container = document.getElementById('cardsContainer');
            const indicators = document.querySelectorAll('.indicator');
            const prevBtn = document.getElementById('prevCard');
            const nextBtn = document.getElementById('nextCard');
            
            if (!container) return;
            
            totalCards = container.querySelectorAll('.card-item').length;
            if (totalCards === 0) return;
            
            const cardWidth = container.querySelector('.card-item').offsetWidth;
            const gap = 16;
            const scrollWidth = cardWidth + gap;
            
            // Función para actualizar botones de flechas
            function updateArrows() {
                if (prevBtn) {
                    prevBtn.disabled = currentCardIndex === 0;
                }
                if (nextBtn) {
                    nextBtn.disabled = currentCardIndex >= totalCards - 1;
                }
            }
            
            // Función para scroll a una tarjeta específica
            window.scrollCard = function(direction) {
                currentCardIndex += direction;
                currentCardIndex = Math.max(0, Math.min(currentCardIndex, totalCards - 1));
                
                container.scrollTo({
                    left: currentCardIndex * scrollWidth,
                    behavior: 'smooth'
                });
                
                updateArrows();
                updateIndicators();
            };
            
            // Actualizar indicadores al hacer scroll
            container.addEventListener('scroll', function() {
                const scrollLeft = container.scrollLeft;
                const newIndex = Math.round(scrollLeft / scrollWidth);
                
                if (newIndex !== currentCardIndex) {
                    currentCardIndex = newIndex;
                    updateIndicators();
                    updateArrows();
                }
            });
            
            // Inicializar estado de flechas
            updateArrows();
            
            // Touch events para mejor experiencia móvil
            let startX = 0;
            let scrollLeft = 0;
            let isDown = false;
            
            container.addEventListener('touchstart', (e) => {
                isDown = true;
                startX = e.touches[0].pageX - container.offsetLeft;
                scrollLeft = container.scrollLeft;
            });
            
            container.addEventListener('touchmove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.touches[0].pageX - container.offsetLeft;
                const walk = (x - startX) * 2;
                container.scrollLeft = scrollLeft - walk;
            });
            
            container.addEventListener('touchend', () => {
                isDown = false;
            });
            
            function updateIndicators() {
                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.add('active');
                    } else {
                        indicator.classList.remove('active');
                    }
                });
            }
            
            // Click en indicadores para navegar
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    container.scrollTo({
                        left: index * scrollWidth,
                        behavior: 'smooth'
                    });
                });
            });
        }

        function openPayModal(installmentId, amount, debtName) {
            document.getElementById('payInstallmentId').value = installmentId;
            document.getElementById('payDebtName').textContent = debtName;
            document.getElementById('payAmount').value = amount;
            document.getElementById('payMinAmount').textContent = amount.toLocaleString('es-CO');
            document.getElementById('payModal').classList.remove('hidden');
            document.getElementById('payModal').classList.add('flex');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

        function closePayModal(event) {
            if (event.target === event.currentTarget || event.target.closest('button')) {
                document.getElementById('payModal').classList.add('hidden');
                document.getElementById('payModal').classList.remove('flex');
            }
        }

        function openIncomeModal() {
            document.getElementById('incomeModal').classList.remove('hidden');
            document.getElementById('incomeModal').classList.add('flex');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

        function closeIncomeModal(event) {
            if (event.target === event.currentTarget || event.target.closest('button')) {
                document.getElementById('incomeModal').classList.add('hidden');
                document.getElementById('incomeModal').classList.remove('flex');
            }
        }

        function openExpenseModal() {
            document.getElementById('expenseModal').classList.remove('hidden');
            document.getElementById('expenseModal').classList.add('flex');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

        function closeExpenseModal(event) {
            if (event.target === event.currentTarget || event.target.closest('button')) {
                document.getElementById('expenseModal').classList.add('hidden');
                document.getElementById('expenseModal').classList.remove('flex');
            }
        }

        async function payInstallment(event) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Procesando...';

            try {
                const response = await fetch(`/superlinkiu/finances/quick-add/${code}/pay`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        installment_id: document.getElementById('payInstallmentId').value,
                        account_id: document.getElementById('payAccountId').value,
                        amount: parseFloat(document.getElementById('payAmount').value),
                        payment_method: document.getElementById('payMethod').value,
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + (data.error || 'Error al procesar el pago'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Error de conexión. Intenta nuevamente.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        }

        async function addIncome(event) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Agregando...';

            try {
                const response = await fetch(`/superlinkiu/finances/quick-add/${code}/income`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        account_id: document.getElementById('incomeAccountId').value,
                        amount: parseFloat(document.getElementById('incomeAmount').value),
                        description: document.getElementById('incomeDescription').value,
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + (data.error || 'Error al agregar el ingreso'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Error de conexión. Intenta nuevamente.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        }

        async function addExpense(event) {
            event.preventDefault();
            const form = event.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Agregando...';

            try {
                const response = await fetch(`/superlinkiu/finances/quick-add/${code}/expense`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        account_id: document.getElementById('expenseAccountId').value,
                        amount: parseFloat(document.getElementById('expenseAmount').value),
                        description: document.getElementById('expenseDescription').value,
                        payment_method: document.getElementById('expenseMethod').value,
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + (data.error || 'Error al agregar el gasto'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Error de conexión. Intenta nuevamente.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        }
    </script>
</body>
</html>
