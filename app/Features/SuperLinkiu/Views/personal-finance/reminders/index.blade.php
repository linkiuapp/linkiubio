@extends('shared::layouts.admin')

@section('title', 'Recordatorios de Pagos')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 mt-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-800">Recordatorios de Pagos</h1>
            <p class="text-sm text-gray-600 mt-1">Configura notificaciones WhatsApp para recordarte los pagos pendientes</p>
        </div>
        <button onclick="openReminderModal()" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Nuevo Recordatorio
        </button>
    </div>

    {{-- Recordatorios Globales --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Recordatorios Globales</h2>
            <p class="text-sm text-gray-600 mt-1">Aplican para todas las deudas</p>
        </div>
        <div class="p-4">
            @if($globalReminders->count() > 0)
                <div class="space-y-3">
                    @foreach($globalReminders as $reminder)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Global</span>
                                    <span class="px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded">
                                        {{ $reminder->reminder_days_before }} día(s) antes
                                    </span>
                                    @if($reminder->is_active)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Activo</span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">Inactivo</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mt-2">
                                    Método: {{ $reminder->notification_method === 'whatsapp' ? 'WhatsApp' : ($reminder->notification_method === 'email' ? 'Email' : 'Ambos') }}
                                </p>
                                @if($reminder->phone_numbers && count($reminder->phone_numbers) > 0)
                                    <p class="text-sm text-gray-600 mt-1">
                                        Teléfonos: {{ implode(', ', $reminder->phone_numbers) }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <button onclick="editReminder({{ $reminder->id }}, {{ $reminder->reminder_days_before }}, '{{ $reminder->notification_method }}', @json($reminder->phone_numbers ?? []), {{ $reminder->is_active ? 'true' : 'false' }}, null)"
                                    class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm rounded transition-colors">
                                    Editar
                                </button>
                                <form action="{{ route('superlinkiu.personal-finance.reminders.destroy', $reminder) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este recordatorio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-sm rounded transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No hay recordatorios globales configurados</p>
            @endif
        </div>
    </div>

    {{-- Recordatorios por Deuda --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Recordatorios por Deuda</h2>
            <p class="text-sm text-gray-600 mt-1">Recordatorios específicos para deudas individuales</p>
        </div>
        <div class="p-4">
            @if($debtReminders->count() > 0)
                <div class="space-y-3">
                    @foreach($debtReminders as $debtId => $reminders)
                        @php
                            $debt = $reminders->first()->debt;
                        @endphp
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">{{ $debt->name }}</h3>
                            <div class="space-y-2">
                                @foreach($reminders as $reminder)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded">
                                                    {{ $reminder->reminder_days_before }} día(s) antes
                                                </span>
                                                @if($reminder->is_active)
                                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Activo</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">Inactivo</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">
                                                Método: {{ $reminder->notification_method === 'whatsapp' ? 'WhatsApp' : ($reminder->notification_method === 'email' ? 'Email' : 'Ambos') }}
                                            </p>
                                            @if($reminder->phone_numbers && count($reminder->phone_numbers) > 0)
                                                <p class="text-sm text-gray-600 mt-1">
                                                    Teléfonos: {{ implode(', ', $reminder->phone_numbers) }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="flex gap-2">
                                            <button onclick="editReminder({{ $reminder->id }}, {{ $reminder->reminder_days_before }}, '{{ $reminder->notification_method }}', @json($reminder->phone_numbers ?? []), {{ $reminder->is_active ? 'true' : 'false' }}, {{ $debtId }})"
                                                class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm rounded transition-colors">
                                                Editar
                                            </button>
                                            <form action="{{ route('superlinkiu.personal-finance.reminders.destroy', $reminder) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este recordatorio?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-sm rounded transition-colors">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No hay recordatorios por deuda configurados</p>
            @endif
        </div>
    </div>
</div>

{{-- Modal para crear/editar recordatorio --}}
<div id="reminderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center backdrop-blur-sm" onclick="closeReminderModal()">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800" id="modalTitle">Nuevo Recordatorio</h2>
                <button onclick="closeReminderModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="reminderForm" method="POST">
                @csrf
                <input type="hidden" name="reminder_id" id="reminder_id">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Para Deuda Específica (Opcional)</label>
                        <select name="debt_id" id="reminder_debt_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todas las deudas (Global)</option>
                            @foreach($debts as $debt)
                                <option value="{{ $debt->id }}">{{ $debt->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Deja en blanco para aplicar a todas las deudas</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Recordar con cuántos días de anticipación *</label>
                        <input type="number" name="reminder_days_before" id="reminder_days_before" required min="1" max="30"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Ejemplo: 3 = te recordará 3 días antes del vencimiento</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Método de Notificación *</label>
                        <select name="notification_method" id="reminder_notification_method" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="whatsapp">WhatsApp</option>
                            <option value="email">Email</option>
                            <option value="both">Ambos</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Números de Teléfono (WhatsApp) *</label>
                        <input type="text" name="phone_numbers" id="reminder_phone_numbers" required
                            placeholder="Ej: 3001234567, 3009876543"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Separa múltiples números con comas. Ejemplo: 3001234567, 3009876543</p>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" id="reminder_is_active" checked
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="reminder_is_active" class="ml-2 text-sm text-gray-700">Recordatorio activo</label>
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                        Guardar
                    </button>
                    <button type="button" onclick="closeReminderModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openReminderModal(debtId = null) {
        document.getElementById('reminderForm').action = '{{ route('superlinkiu.personal-finance.reminders.store') }}';
        document.getElementById('reminderForm').method = 'POST';
        document.getElementById('reminder_id').value = '';
        document.getElementById('reminder_debt_id').value = debtId || '';
        document.getElementById('reminder_days_before').value = '3';
        document.getElementById('reminder_notification_method').value = 'whatsapp';
        document.getElementById('reminder_phone_numbers').value = '';
        document.getElementById('reminder_is_active').checked = true;
        document.getElementById('modalTitle').textContent = 'Nuevo Recordatorio';
        document.getElementById('reminderModal').classList.remove('hidden');
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function editReminder(id, days, method, phoneNumbers, isActive, debtId) {
        // Crear formulario nuevo para evitar problemas con método PUT
        const form = document.getElementById('reminderForm');
        form.action = `/superlinkiu/personal-finance/reminders/${id}`;
        
        // Remover método PUT anterior si existe
        const existingMethod = form.querySelector('input[name="_method"]');
        if (existingMethod) {
            existingMethod.remove();
        }
        
        // Agregar método PUT
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
        
        document.getElementById('reminder_id').value = id;
        document.getElementById('reminder_debt_id').value = debtId || '';
        document.getElementById('reminder_days_before').value = days;
        document.getElementById('reminder_notification_method').value = method;
        document.getElementById('reminder_phone_numbers').value = phoneNumbers && Array.isArray(phoneNumbers) ? phoneNumbers.join(', ') : (phoneNumbers || '');
        document.getElementById('reminder_is_active').checked = isActive === true || isActive === 'true' || isActive === 1;
        document.getElementById('modalTitle').textContent = 'Editar Recordatorio';
        document.getElementById('reminderModal').classList.remove('hidden');
        
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function closeReminderModal() {
        document.getElementById('reminderModal').classList.add('hidden');
        // Resetear formulario
        const form = document.getElementById('reminderForm');
        form.reset();
        // Remover método PUT si existe
        const methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.remove();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeReminderModal();
            }
        });
    });
</script>
@endpush
@endsection
