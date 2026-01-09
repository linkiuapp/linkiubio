@extends('shared::layouts.admin')

@section('title', 'LinkiuDev - Mi Agenda')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
<style>
    /* FullCalendar */
    .fc-event { cursor: pointer; }
    .fc-toolbar-title { font-size: 1.1rem !important; font-weight: 600; }
    
    /* Sidebar */
    .sidebar-section { max-height: 150px; overflow-y: auto; }
    .sidebar-section::-webkit-scrollbar { width: 4px; }
    .sidebar-section::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }
</style>
@endpush

@section('content')
<div class="max-w-full px-2">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-3">
        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Mi Agenda</h1>
        <button 
            type="button"
            onclick="openEventModal()"
            class="bg-primary-300 hover:bg-primary-400 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors text-sm"
        >
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            Nuevo Evento
        </button>
    </div>

    <div class="flex gap-4">
        {{-- Sidebar compacto --}}
        <div class="w-48 flex-shrink-0 space-y-2 overflow-y-auto">
            {{-- Hoy --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-2">
                <h3 class="text-xs font-semibold text-gray-900 dark:text-white mb-1.5 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                    Hoy, {{ now()->format('d M') }}
                </h3>
                <div id="today-summary" class="space-y-1 sidebar-section text-xs">
                    <p class="text-gray-500 dark:text-gray-400">Cargando...</p>
                </div>
            </div>

            {{-- Tareas pendientes --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-2">
                <h3 class="text-xs font-semibold text-gray-900 dark:text-white mb-1.5">Sin programar</h3>
                <div id="unscheduled-tasks" class="space-y-1 sidebar-section text-xs">
                    <p class="text-gray-500 dark:text-gray-400">Cargando...</p>
                </div>
            </div>

            {{-- Leyenda de colores --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-2">
                <h3 class="text-xs font-semibold text-gray-900 dark:text-white mb-1.5">Leyenda</h3>
                <div class="grid grid-cols-1 gap-0.5 text-[10px]">
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded bg-green-500/50 border border-green-500"></span>
                        <span class="text-gray-600 dark:text-gray-400">Completada</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded bg-red-500/50 border border-red-500"></span>
                        <span class="text-gray-600 dark:text-gray-400">Vencida</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded bg-red-500"></span>
                        <span class="text-gray-600 dark:text-gray-400">Alta</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded bg-yellow-500"></span>
                        <span class="text-gray-600 dark:text-gray-400">Media</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded bg-purple-500"></span>
                        <span class="text-gray-600 dark:text-gray-400">Evento</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calendario ocupa todo el espacio disponible --}}
        <div class="flex-1 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-2 overflow-auto">
            <div id="calendar"></div>
        </div>
    </div>
</div>

{{-- Modal para ver/editar tarea --}}
<div id="task-modal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeTaskModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detalle de Tarea</h3>
                <button onclick="closeTaskModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <h4 id="task-modal-title" class="text-lg font-medium text-gray-900 dark:text-white"></h4>
                    <p id="task-modal-project" class="text-sm text-gray-500 dark:text-gray-400 mt-1"></p>
                </div>
                
                <div class="flex items-center gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-gray-400"></i>
                        <span id="task-modal-date" class="text-gray-600 dark:text-gray-300"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i>
                        <span id="task-modal-time" class="text-gray-600 dark:text-gray-300"></span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cambiar Estado</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="updateTaskStatusFromCalendar('pending')" id="task-btn-pending" class="px-3 py-2 text-sm rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 flex items-center justify-center gap-2 transition-all">
                            <span class="w-2 h-2 rounded-full bg-gray-400"></span> Pendiente
                        </button>
                        <button onclick="updateTaskStatusFromCalendar('in_progress')" id="task-btn-in_progress" class="px-3 py-2 text-sm rounded-lg border-2 border-blue-300 text-blue-700 hover:bg-blue-50 flex items-center justify-center gap-2 transition-all">
                            <span class="w-2 h-2 rounded-full bg-blue-400"></span> En Progreso
                        </button>
                        <button onclick="updateTaskStatusFromCalendar('review')" id="task-btn-review" class="px-3 py-2 text-sm rounded-lg border-2 border-yellow-300 text-yellow-700 hover:bg-yellow-50 flex items-center justify-center gap-2 transition-all">
                            <span class="w-2 h-2 rounded-full bg-yellow-400"></span> En Revisión
                        </button>
                        <button onclick="updateTaskStatusFromCalendar('completed')" id="task-btn-completed" class="px-3 py-2 text-sm rounded-lg border-2 border-green-300 text-green-700 hover:bg-green-50 flex items-center justify-center gap-2 transition-all">
                            <span class="w-2 h-2 rounded-full bg-green-400"></span> Completada
                        </button>
                    </div>
                </div>
                
                <p id="task-modal-description" class="text-sm text-gray-600 dark:text-gray-300"></p>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-between bg-gray-50 dark:bg-gray-700/50 rounded-b-xl">
                <a id="task-modal-link" href="#" class="px-4 py-2 text-blue-600 hover:text-blue-700 flex items-center gap-2">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    Ver detalles
                </a>
                <button type="button" onclick="closeTaskModal()" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-600 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-500 font-medium transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal para crear/editar evento --}}
<div id="event-modal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeEventModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
            <form id="event-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 id="modal-title" class="text-lg font-semibold text-gray-900 dark:text-white">Nuevo Evento</h3>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título</label>
                        <input type="text" name="title" id="event-title" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo</label>
                        <select name="type" id="event-type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="meeting">Reunión</option>
                            <option value="call">Llamada</option>
                            <option value="reminder">Recordatorio</option>
                            <option value="task">Tarea</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha</label>
                        <input type="date" name="date" id="event-date" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    
                    <div class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="is_all_day" id="event-all-day" value="1" class="w-4 h-4 text-primary-300 rounded">
                        <label for="event-all-day" class="text-sm text-gray-700 dark:text-gray-300">Todo el día</label>
                    </div>
                    
                    <div id="time-fields" class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora inicio</label>
                            <input type="time" name="start_time" id="event-start-time" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora fin</label>
                            <input type="time" name="end_time" id="event-end-time" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Recordatorio (minutos antes)</label>
                        <select name="reminder_minutes" id="event-reminder" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Sin recordatorio</option>
                            <option value="15">15 minutos</option>
                            <option value="30" selected>30 minutos</option>
                            <option value="60">1 hora</option>
                            <option value="120">2 horas</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea name="description" id="event-description" rows="2" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Proyecto (opcional)</label>
                        <select name="project_id" id="event-project" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Sin proyecto</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                    <button type="button" id="delete-event-btn" class="hidden px-4 py-2 text-red-600 hover:text-red-700" onclick="deleteEvent()">
                        Eliminar
                    </button>
                    <div class="flex gap-2 ml-auto">
                        <button type="button" onclick="closeEventModal()" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-primary-300 hover:bg-primary-400 text-white rounded-lg">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        lucide.createIcons();
    }

    // Inicializar calendario
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: '{{ $view === "month" ? "dayGridMonth" : "timeGridWeek" }}',
        locale: 'es',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana'
        },
        events: '{{ route("superlinkiu.linkiudev.agenda.calendar-data") }}',
        eventClick: function(info) {
            const props = info.event.extendedProps;
            if (props.type === 'agenda_entry') {
                const entryId = info.event.id.replace('agenda_', '');
                editEvent(entryId, info.event);
            } else if (props.type === 'task') {
                const taskId = info.event.id.replace('task_', '');
                openTaskModal(taskId, info.event);
            }
        },
        dateClick: function(info) {
            openEventModal(info.dateStr);
        },
        slotMinTime: '05:00:00',
        slotMaxTime: '22:00:00',
        slotDuration: '00:30:00',
        allDaySlot: true,
        nowIndicator: true,
        editable: false,
        selectable: true,
        dayMaxEvents: 3,
        moreLinkClick: 'popover',
        scrollTime: '08:00:00'
    });
    calendar.render();

    // Cargar resumen del día
    loadTodaySummary();
    loadUnscheduledTasks();

    // Toggle campos de hora
    document.getElementById('event-all-day').addEventListener('change', function() {
        document.getElementById('time-fields').style.display = this.checked ? 'none' : 'grid';
    });

    // Form submit
    document.getElementById('event-form').addEventListener('submit', function(e) {
        e.preventDefault();
        saveEvent();
    });
});

let currentEventId = null;
let currentTaskId = null;
let currentTaskStatus = null;

// ========== FUNCIONES PARA TAREAS ==========

function openTaskModal(taskId, event) {
    currentTaskId = taskId;
    const props = event.extendedProps;
    currentTaskStatus = props.status || 'pending';
    
    document.getElementById('task-modal-title').textContent = event.title;
    document.getElementById('task-modal-project').textContent = props.project_name || 'Sin proyecto';
    
    // Formatear fecha
    const dateStr = event.start ? event.start.toLocaleDateString('es-ES', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    }) : '';
    document.getElementById('task-modal-date').textContent = dateStr;
    
    // Formatear hora
    let timeStr = '';
    if (event.start && !event.allDay) {
        timeStr = event.start.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        if (event.end) {
            timeStr += ' - ' + event.end.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        }
    } else {
        timeStr = 'Todo el día';
    }
    document.getElementById('task-modal-time').textContent = timeStr;
    
    // Descripción
    document.getElementById('task-modal-description').textContent = props.description || '';
    
    // Link a detalles
    document.getElementById('task-modal-link').href = `/superlinkiu/linkiudev/tasks/${taskId}`;
    
    // Resaltar estado actual
    highlightCurrentStatus(currentTaskStatus);
    
    document.getElementById('task-modal').classList.remove('hidden');
    
    // Re-inicializar iconos
    if (typeof lucide !== 'undefined' && lucide.createIcons) {
        setTimeout(() => lucide.createIcons(), 100);
    }
}

function closeTaskModal() {
    document.getElementById('task-modal').classList.add('hidden');
    currentTaskId = null;
}

function highlightCurrentStatus(status) {
    const statuses = ['pending', 'in_progress', 'review', 'completed'];
    statuses.forEach(s => {
        const btn = document.getElementById(`task-btn-${s}`);
        if (btn) {
            if (s === status) {
                btn.classList.add('ring-2', 'ring-offset-2');
                btn.classList.add(s === 'pending' ? 'ring-gray-400' : 
                                  s === 'in_progress' ? 'ring-blue-400' : 
                                  s === 'review' ? 'ring-yellow-400' : 'ring-green-400');
            } else {
                btn.classList.remove('ring-2', 'ring-offset-2', 'ring-gray-400', 'ring-blue-400', 'ring-yellow-400', 'ring-green-400');
            }
        }
    });
}

function updateTaskStatusFromCalendar(newStatus) {
    if (!currentTaskId) return;
    
    fetch(`/superlinkiu/linkiudev/tasks/${currentTaskId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentTaskStatus = newStatus;
            highlightCurrentStatus(newStatus);
            // Mostrar feedback
            if (window.toast) {
                window.toast.success('¡Listo!', 'Estado actualizado correctamente', 3000, 'bottom-center');
            }
            // Recargar el calendario después de un momento
            setTimeout(() => location.reload(), 1000);
        } else {
            alert('Error al actualizar el estado');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el estado');
    });
}

// ========== FUNCIONES PARA EVENTOS ==========

function openEventModal(date = null) {
    currentEventId = null;
    document.getElementById('modal-title').textContent = 'Nuevo Evento';
    document.getElementById('event-form').reset();
    document.getElementById('form-method').value = 'POST';
    document.getElementById('delete-event-btn').classList.add('hidden');
    document.getElementById('time-fields').style.display = 'grid';
    
    if (date) {
        document.getElementById('event-date').value = date;
    } else {
        document.getElementById('event-date').value = new Date().toISOString().split('T')[0];
    }
    
    document.getElementById('event-modal').classList.remove('hidden');
}

function editEvent(id, event) {
    currentEventId = id;
    document.getElementById('modal-title').textContent = 'Editar Evento';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('delete-event-btn').classList.remove('hidden');
    
    document.getElementById('event-title').value = event.title;
    document.getElementById('event-date').value = event.startStr.split('T')[0];
    
    const props = event.extendedProps;
    document.getElementById('event-type').value = props.entry_type || 'other';
    document.getElementById('event-description').value = props.description || '';
    
    if (event.allDay) {
        document.getElementById('event-all-day').checked = true;
        document.getElementById('time-fields').style.display = 'none';
    } else {
        document.getElementById('event-all-day').checked = false;
        document.getElementById('time-fields').style.display = 'grid';
        if (event.start) {
            document.getElementById('event-start-time').value = event.start.toTimeString().slice(0, 5);
        }
        if (event.end) {
            document.getElementById('event-end-time').value = event.end.toTimeString().slice(0, 5);
        }
    }
    
    document.getElementById('event-modal').classList.remove('hidden');
}

function closeEventModal() {
    document.getElementById('event-modal').classList.add('hidden');
}

function saveEvent() {
    const form = document.getElementById('event-form');
    const formData = new FormData(form);
    
    let url = '{{ route("superlinkiu.linkiudev.agenda.entries.store") }}';
    let method = 'POST';
    
    if (currentEventId) {
        url = `/superlinkiu/linkiudev/agenda/entries/${currentEventId}`;
        formData.append('_method', 'PUT');
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeEventModal();
            location.reload();
        } else {
            alert('Error al guardar el evento');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el evento');
    });
}

function deleteEvent() {
    if (!currentEventId || !confirm('¿Eliminar este evento?')) return;
    
    fetch(`/superlinkiu/linkiudev/agenda/entries/${currentEventId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeEventModal();
            location.reload();
        }
    });
}

function loadTodaySummary() {
    fetch('{{ route("superlinkiu.linkiudev.agenda.today") }}', {
        headers: { 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('today-summary');
        if (data.events.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">No hay eventos para hoy</p>';
            return;
        }
        
        container.innerHTML = data.events.map(event => `
            <div class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-700/50 rounded text-sm">
                <span class="text-xs text-gray-500 dark:text-gray-400 w-12">${event.time}</span>
                <span class="flex-1 truncate text-gray-900 dark:text-white">${event.title}</span>
            </div>
        `).join('');
    });
}

function loadUnscheduledTasks() {
    fetch('{{ route("superlinkiu.linkiudev.tasks.index") }}?scheduled_only=0&status=pending', {
        headers: { 'Accept': 'application/json' }
    })
    .then(response => response.text())
    .then(html => {
        // Por ahora mostrar mensaje simple
        document.getElementById('unscheduled-tasks').innerHTML = `
            <a href="{{ route('superlinkiu.linkiudev.tasks.index') }}" class="text-sm text-primary-300 hover:underline">
                Ver todas las tareas →
            </a>
        `;
    });
}
</script>
@endpush
