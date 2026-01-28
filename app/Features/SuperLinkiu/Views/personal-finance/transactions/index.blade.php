@extends('shared::layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Ingresos y Gastos')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Ingresos y Gastos</h1>
            <p class="text-sm text-gray-600 mt-1">Registra tus ingresos y gastos para conocer dónde está tu dinero</p>
        </div>
        <a href="{{ route('superlinkiu.personal-finance.transactions.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva Transacción
        </a>
    </div>

    {{-- Estadísticas del mes --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Ingresos del Mes</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-5 h-5 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Gastos del Mes</p>
                    <p class="text-2xl font-bold text-red-600">${{ number_format($totalExpenses, 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <i data-lucide="trending-down" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Balance del Mes</p>
                    <p class="text-2xl font-bold {{ ($totalIncome - $totalExpenses) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        ${{ number_format($totalIncome - $totalExpenses, 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-10 h-10 {{ ($totalIncome - $totalExpenses) >= 0 ? 'bg-green-100' : 'bg-red-100' }} rounded-lg flex items-center justify-center">
                    <i data-lucide="{{ ($totalIncome - $totalExpenses) >= 0 ? 'check-circle' : 'alert-circle' }}" class="w-5 h-5 {{ ($totalIncome - $totalExpenses) >= 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <select name="type" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Todos</option>
                <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Ingresos</option>
                <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Gastos</option>
            </select>
            <select name="account_id" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Todas las cuentas</option>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                @endforeach
            </select>
            <select name="category" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Todas las categorías</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            <input type="date" name="start_date" value="{{ request('start_date') }}" placeholder="Fecha inicio"
                class="px-3 py-2 border border-gray-300 rounded-lg">
            <input type="date" name="end_date" value="{{ request('end_date') }}" placeholder="Fecha fin"
                class="px-3 py-2 border border-gray-300 rounded-lg">
            <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}"
                class="px-3 py-2 border border-gray-300 rounded-lg md:col-span-5">
            <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg md:col-span-5">
                Filtrar
            </button>
        </form>
    </div>

    @if($transactions->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cuenta</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Soporte</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <p class="text-gray-900">{{ $transaction->transaction_date->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->transaction_date->diffForHumans() }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded
                                        {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}
                                    ">
                                        {{ $transaction->type === 'income' ? 'Ingreso' : 'Gasto' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-900">{{ $transaction->category }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-900">{{ $transaction->description ?: '-' }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $transaction->account->color }}"></span>
                                        {{ $transaction->account->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 0, ',', '.') }}
                                    </p>
                                </td>
                                <td class="px-4 py-3">
                                    @if($transaction->receipt_file)
                                        <button onclick="openReceiptModal('{{ Storage::url($transaction->receipt_file) }}', '{{ $transaction->receipt_file }}')" 
                                            class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800">
                                            <i data-lucide="file-text" class="w-4 h-4"></i>
                                            Ver soporte
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-sm">Sin soporte</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('superlinkiu.personal-finance.transactions.edit', $transaction) }}" class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm rounded transition-colors">
                                            Editar
                                        </a>
                                        <form action="{{ route('superlinkiu.personal-finance.transactions.destroy', $transaction) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta transacción?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-sm rounded transition-colors">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i data-lucide="receipt" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay transacciones registradas</h3>
            <p class="text-gray-600 mb-6">Comienza registrando tus ingresos y gastos</p>
            <a href="{{ route('superlinkiu.personal-finance.transactions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Registrar Primera Transacción
            </a>
        </div>
    @endif
</div>

{{-- Modal para ver soporte --}}
<div id="receiptModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center backdrop-blur-sm" onclick="closeReceiptModal()">
    <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-4 max-h-[90vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Soporte de Transacción</h2>
            <button onclick="closeReceiptModal()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="flex-1 overflow-auto p-4 flex items-center justify-center bg-gray-50" id="receiptContent">
            <img id="receiptImage" src="" alt="Soporte" class="max-w-full max-h-[70vh] object-contain rounded-lg hidden">
            <iframe id="receiptPdf" src="" class="w-full h-[70vh] rounded-lg hidden"></iframe>
        </div>
        <div class="p-4 border-t border-gray-200 flex justify-end gap-3">
            <a id="downloadReceipt" href="#" download class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-lucide="download" class="w-4 h-4"></i>
                Descargar
            </a>
            <button onclick="closeReceiptModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                Cerrar
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openReceiptModal(fileUrl, filePath) {
        const imageEl = document.getElementById('receiptImage');
        const pdfEl = document.getElementById('receiptPdf');
        const downloadEl = document.getElementById('downloadReceipt');
        
        // Ocultar ambos primero
        imageEl.classList.add('hidden');
        pdfEl.classList.add('hidden');
        
        // Detectar si es PDF o imagen
        const isPdf = filePath.toLowerCase().endsWith('.pdf');
        
        if (isPdf) {
            pdfEl.src = fileUrl;
            pdfEl.classList.remove('hidden');
        } else {
            imageEl.src = fileUrl;
            imageEl.classList.remove('hidden');
        }
        
        downloadEl.href = fileUrl;
        document.getElementById('receiptModal').classList.remove('hidden');
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function closeReceiptModal() {
        document.getElementById('receiptModal').classList.add('hidden');
        // Limpiar contenido
        document.getElementById('receiptImage').src = '';
        document.getElementById('receiptPdf').src = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeReceiptModal();
            }
        });
    });
</script>
@endpush
@endsection
