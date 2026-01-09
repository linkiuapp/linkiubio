@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Logs de Notificaciones')

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('superlinkiu.linkiudev.settings.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>
        <div>
            <h1 class="text-lg font-bold text-gray-900 dark:text-white">Logs de Notificaciones</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Historial de notificaciones enviadas</p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 mb-6">
        <form action="{{ route('superlinkiu.linkiudev.notification-logs') }}" method="GET" class="flex flex-wrap gap-4">
            <select name="type" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">Todos los tipos</option>
                <option value="client_update" {{ request('type') === 'client_update' ? 'selected' : '' }}>Actualización a Cliente</option>
                <option value="daily_summary" {{ request('type') === 'daily_summary' ? 'selected' : '' }}>Resumen Diario</option>
                <option value="task_reminder" {{ request('type') === 'task_reminder' ? 'selected' : '' }}>Recordatorio</option>
                <option value="webhook_response" {{ request('type') === 'webhook_response' ? 'selected' : '' }}>Respuesta Webhook</option>
            </select>
            <select name="status" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="">Todos los estados</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Enviado</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Entregado</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Leído</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Fallido</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="Desde" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="Hasta" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
            <button type="submit" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Filtrar
            </button>
        </form>
    </div>

    {{-- Lista --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
        @if($logs->isEmpty())
            <div class="text-center py-12">
                <i data-lucide="bell-off" class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4"></i>
                <p class="text-sm text-gray-500 dark:text-gray-400">No hay logs de notificaciones</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Destinatario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Relacionado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($logs as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $log->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $log->type_label }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $log->recipient_phone }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $log->recipient_type === 'admin' ? 'Admin' : 'Cliente' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($log->project)
                                        <a href="{{ route('superlinkiu.linkiudev.projects.show', $log->project) }}" class="text-primary-300 hover:underline">{{ $log->project->name }}</a>
                                    @elseif($log->task)
                                        <a href="{{ route('superlinkiu.linkiudev.tasks.show', $log->task) }}" class="text-primary-300 hover:underline">{{ $log->task->name }}</a>
                                    @elseif($log->client)
                                        <a href="{{ route('superlinkiu.linkiudev.clients.show', $log->client) }}" class="text-primary-300 hover:underline">{{ $log->client->name }}</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $log->status_color }}-100 text-{{ $log->status_color }}-800 dark:bg-{{ $log->status_color }}-900/30 dark:text-{{ $log->status_color }}-300">
                                        {{ $log->status_label }}
                                    </span>
                                    @if($log->error_message)
                                        <p class="text-xs text-red-500 mt-1 max-w-xs truncate" title="{{ $log->error_message }}">{{ $log->error_message }}</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $logs->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }
});
</script>
@endpush
