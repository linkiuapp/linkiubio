@extends('shared::layouts.admin')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Historial de Pagos')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Historial de Pagos</h1>
            <p class="text-sm text-gray-600 mt-1">Registro de todos tus pagos realizados</p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form method="GET" class="flex gap-4">
            <input type="date" name="start_date" value="{{ request('start_date') }}" placeholder="Fecha inicio"
                class="px-3 py-2 border border-gray-300 rounded-lg">
            <input type="date" name="end_date" value="{{ request('end_date') }}" placeholder="Fecha fin"
                class="px-3 py-2 border border-gray-300 rounded-lg">
            <select name="payment_method" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Todos los métodos</option>
                <option value="transfer" {{ request('payment_method') === 'transfer' ? 'selected' : '' }}>Transferencia</option>
                <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Efectivo</option>
                <option value="card" {{ request('payment_method') === 'card' ? 'selected' : '' }}>Tarjeta</option>
                <option value="nequi" {{ request('payment_method') === 'nequi' ? 'selected' : '' }}>Nequi</option>
                <option value="daviplata" {{ request('payment_method') === 'daviplata' ? 'selected' : '' }}>Daviplata</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
                Filtrar
            </button>
        </form>
    </div>

    @if($payments->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deuda</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cuota</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cuenta</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <p class="text-gray-900">{{ $payment->payment_date->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment->payment_date->diffForHumans() }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900">{{ $payment->installment->debt->name }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-900">Cuota #{{ $payment->installment->installment_number }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900">${{ number_format($payment->amount, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">
                                        {{ $payment->payment_method_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $payment->account->color }}"></span>
                                        {{ $payment->account->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($payment->receipt_file)
                                        <button onclick="openReceiptModal('{{ Storage::url($payment->receipt_file) }}', '{{ $payment->receipt_file }}')" 
                                            class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800">
                                            <i data-lucide="file-text" class="w-4 h-4"></i>
                                            Ver comprobante
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-sm">Sin comprobante</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $payments->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i data-lucide="history" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay pagos registrados</h3>
            <p class="text-gray-600">Los pagos que realices aparecerán aquí</p>
        </div>
    @endif
</div>

{{-- Modal para ver comprobante --}}
<div id="receiptModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center backdrop-blur-sm" onclick="closeReceiptModal()">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Comprobante de Pago</h2>
            <button onclick="closeReceiptModal()" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="flex-1 overflow-auto p-4 flex items-center justify-center bg-gray-50" id="receiptContent">
            <img id="receiptImage" src="" alt="Comprobante" class="max-w-full max-h-[70vh] object-contain rounded-lg hidden">
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
