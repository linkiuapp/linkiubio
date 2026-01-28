@extends('shared::layouts.admin')

@section('title', 'Detalle de Deuda')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">{{ $debt->name }}</h1>
            <p class="text-sm text-gray-600 mt-1">{{ $debt->description }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('superlinkiu.personal-finance.debts.edit', $debt) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                Editar
            </a>
            <a href="{{ route('superlinkiu.personal-finance.debts.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                Volver
            </a>
        </div>
    </div>

    {{-- Información General --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Monto Total</p>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($debt->total_amount, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Progreso</p>
            <p class="text-2xl font-bold text-gray-900">{{ round($debt->progress_percentage) }}%</p>
            <p class="text-xs text-gray-500 mt-1">{{ $debt->paid_installments }}/{{ $debt->total_installments }} cuotas</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-600">Estado</p>
            <span class="inline-block px-3 py-1 text-sm rounded mt-2
                {{ $debt->status === 'active' ? 'bg-blue-100 text-blue-800' : '' }}
                {{ $debt->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
            ">
                {{ $debt->status_label }}
            </span>
        </div>
    </div>

    {{-- Barra de Progreso --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="mb-2 flex justify-between text-sm">
            <span class="text-gray-600">Progreso de Pago</span>
            <span class="font-semibold text-gray-900">{{ round($debt->progress_percentage) }}%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="bg-blue-600 h-4 rounded-full transition-all" style="width: {{ $debt->progress_percentage }}%"></div>
        </div>
        <div class="mt-4 flex justify-between text-sm text-gray-600">
            <span>Pagado: ${{ number_format($debt->total_paid, 0, ',', '.') }}</span>
            <span>Pendiente: ${{ number_format($debt->total_pending, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Lista de Cuotas --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Cuotas</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vencimiento</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($debt->installments as $installment)
                        <tr class="hover:bg-gray-50 {{ $installment->is_overdue ? 'bg-red-50' : '' }}">
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-900">#{{ $installment->installment_number }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-900">${{ number_format($installment->amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-900">{{ $installment->due_date->format('d/m/Y') }}</p>
                                @if($installment->days_until_due !== null && $installment->status === 'pending')
                                    <p class="text-xs {{ $installment->days_until_due < 0 ? 'text-red-600' : ($installment->days_until_due <= 3 ? 'text-orange-600' : 'text-gray-500') }}">
                                        @if($installment->days_until_due < 0)
                                            Vencida hace {{ abs($installment->days_until_due) }} día(s)
                                        @elseif($installment->days_until_due == 0)
                                            Vence hoy
                                        @else
                                            Vence en {{ $installment->days_until_due }} día(s)
                                        @endif
                                    </p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded
                                    {{ $installment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $installment->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $installment->status === 'overdue' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ $installment->status_label }}
                                </span>
                                @if($installment->paid_date)
                                    <p class="text-xs text-gray-500 mt-1">Pagada: {{ $installment->paid_date->format('d/m/Y') }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($installment->status === 'pending')
                                    <a href="{{ route('superlinkiu.personal-finance.installments.index', ['debt_id' => $debt->id]) }}" 
                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition-colors">
                                        Pagar
                                    </a>
                                @else
                                    <span class="text-sm text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush
@endsection
