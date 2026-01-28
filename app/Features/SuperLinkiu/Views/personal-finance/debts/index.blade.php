@extends('shared::layouts.admin')

@section('title', 'Deudas')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Deudas</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona todas tus deudas y créditos</p>
        </div>
        <a href="{{ route('superlinkiu.personal-finance.debts.create') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nueva Deuda
        </a>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <form method="GET" class="flex gap-4">
            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Todas</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activas</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Pagadas</option>
                <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Vencidas</option>
            </select>
            <select name="account_id" class="px-3 py-2 border border-gray-300 rounded-lg">
                <option value="">Todas las cuentas</option>
                @foreach($accounts as $account)
                    <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                @endforeach
            </select>
            <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}"
                class="px-3 py-2 border border-gray-300 rounded-lg flex-1">
            <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
                Filtrar
            </button>
        </form>
    </div>

    @if($debts->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deuda</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cuenta</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progreso</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($debts as $debt)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-900">{{ $debt->name }}</p>
                                    @if($debt->description)
                                        <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($debt->description, 50) }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($debt->account)
                                        <span class="inline-flex items-center gap-1">
                                            <span class="w-3 h-3 rounded-full" style="background-color: {{ $debt->account->color }}"></span>
                                            {{ $debt->account->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Sin cuenta</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900">${{ number_format($debt->total_amount, 0, ',', '.') }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $debt->progress_percentage }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600">{{ round($debt->progress_percentage) }}%</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $debt->paid_installments }}/{{ $debt->total_installments }} cuotas</p>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded
                                        {{ $debt->status === 'active' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $debt->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $debt->status === 'overdue' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $debt->status === 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}
                                    ">
                                        {{ $debt->status_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('superlinkiu.personal-finance.debts.show', $debt) }}" class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm rounded transition-colors">
                                            Ver
                                        </a>
                                        <a href="{{ route('superlinkiu.personal-finance.debts.edit', $debt) }}" class="px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-sm rounded transition-colors">
                                            Editar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $debts->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <i data-lucide="file-text" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No tienes deudas registradas</h3>
            <p class="text-gray-600 mb-6">Comienza agregando tu primera deuda o crédito</p>
            <a href="{{ route('superlinkiu.personal-finance.debts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Crear Primera Deuda
            </a>
        </div>
    @endif
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
