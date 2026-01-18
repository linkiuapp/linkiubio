@extends('shared::layouts.admin')

@section('title', 'Reportes de Errores')
@section('content')
<div class="container-fluid px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Reportes de Errores</h1>
        <p class="mt-2 text-sm text-gray-600">Gestiona los reportes de errores enviados por tus clientes</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i data-lucide="alert-circle" class="w-6 h-6 text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Abiertos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reports->where('status', 'open')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i data-lucide="rotate-cw" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">En Progreso</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reports->where('status', 'in_progress')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Resueltos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reports->where('status', 'resolved')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 bg-gray-100 rounded-lg">
                    <i data-lucide="file-text" class="w-6 h-6 text-gray-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reports->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tienda / Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Captura</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reports as $report)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900">{{ $report->store->name ?? 'Sin tienda' }}</div>
                                    <div class="text-sm text-gray-500">{{ $report->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $report->subject }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 max-w-md">
                                    {{ Str::limit($report->description, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($report->screenshot_path)
                                    <button 
                                        type="button"
                                        onclick="showImageModal('{{ Storage::disk('public')->url($report->screenshot_path) }}')"
                                        class="text-indigo-600 hover:text-indigo-900"
                                    >
                                        <i data-lucide="image" class="w-6 h-6"></i>
                                    </button>
                                @else
                                    <span class="text-sm text-gray-400">Sin captura</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('superlinkiu.tools.error-reports.update-status', $report) }}" method="POST">
                                    @csrf
                                    <select 
                                        name="status" 
                                        onchange="this.form.submit()"
                                        class="text-xs rounded-full px-2.5 py-0.5 border-0
                                            @if($report->status === 'open') bg-red-100 text-red-800
                                            @elseif($report->status === 'in_progress') bg-blue-100 text-blue-800
                                            @elseif($report->status === 'resolved') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif"
                                    >
                                        <option value="open" {{ $report->status === 'open' ? 'selected' : '' }}>Abierto</option>
                                        <option value="in_progress" {{ $report->status === 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                        <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resuelto</option>
                                        <option value="closed" {{ $report->status === 'closed' ? 'selected' : '' }}>Cerrado</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $report->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button 
                                    type="button"
                                    onclick="showDetailModal({{ $report->id }}, '{{ $report->subject }}', '{{ addslashes($report->description) }}', '{{ $report->screenshot_path ? Storage::disk('public')->url($report->screenshot_path) : '' }}')"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3"
                                >
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </button>
                                <form action="{{ route('superlinkiu.tools.error-reports.delete', $report) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este reporte?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No hay reportes de errores
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50">
            {{ $reports->links() }}
        </div>
    </div>
</div>

<!-- Modal para ver imagen -->
<div id="imageModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl max-h-screen overflow-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Captura de Pantalla</h3>
            <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <img id="modalImage" src="" alt="Captura" class="max-w-full h-auto">
    </div>
</div>

<!-- Modal para ver detalle completo -->
<div id="detailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900" id="detailSubject"></h3>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="mb-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Descripción completa:</h4>
            <p class="text-sm text-gray-600 whitespace-pre-wrap" id="detailDescription"></p>
        </div>
        <div id="detailImageContainer" class="hidden">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Captura:</h4>
            <img id="detailImage" src="" alt="Captura" class="max-w-full h-auto rounded-lg">
        </div>
    </div>
</div>

@push('scripts')
<script>
function showImageModal(url) {
    document.getElementById('modalImage').src = url;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

function showDetailModal(id, subject, description, screenshot) {
    document.getElementById('detailSubject').textContent = subject;
    document.getElementById('detailDescription').textContent = description;
    
    if (screenshot) {
        document.getElementById('detailImage').src = screenshot;
        document.getElementById('detailImageContainer').classList.remove('hidden');
    } else {
        document.getElementById('detailImageContainer').classList.add('hidden');
    }
    
    document.getElementById('detailModal').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}
</script>
@endpush
@endsection
