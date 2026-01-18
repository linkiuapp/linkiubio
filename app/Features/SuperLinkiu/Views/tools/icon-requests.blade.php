@extends('shared::layouts.admin')

@section('title', 'Solicitudes de Íconos')

@section('content')
<div class="container-fluid px-6 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Solicitudes de Íconos</h1>
        <p class="mt-2 text-sm text-gray-600">Gestiona las solicitudes de íconos personalizados de tus clientes</p>
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
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $requests->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Aprobadas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $requests->where('status', 'approved')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i data-lucide="x-circle" class="w-6 h-6 text-red-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Rechazadas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $requests->where('status', 'rejected')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i data-lucide="file-text" class="w-6 h-6 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $requests->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tienda</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría Negocio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referencia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $request)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->store->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $request->user->name ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($request->businessCategory)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $request->businessCategory->icon ?? '🏪' }} {{ $request->businessCategory->name }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">Sin categoría</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->category_name }}</div>
                                    @if($request->description)
                                        <div class="text-sm text-gray-500 mt-1">{{ Str::limit($request->description, 50) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($request->reference_image_path)
                                    <button 
                                        type="button"
                                        onclick="showImageModal('{{ Storage::disk('public')->url($request->reference_image_path) }}')"
                                        class="text-indigo-600 hover:text-indigo-900"
                                    >
                                        <i data-lucide="image" class="w-6 h-6"></i>
                                    </button>
                                @else
                                    <span class="text-sm text-gray-400">Sin imagen</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($request->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pendiente
                                    </span>
                                @elseif($request->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aprobada
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Rechazada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($request->status === 'pending')
                                    <div class="flex space-x-2">
                                        <form action="{{ route('superlinkiu.tools.icon-requests.approve', $request) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">
                                                <i data-lucide="check-circle" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                        <button 
                                            type="button"
                                            onclick="showRejectModal({{ $request->id }})"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            <i data-lucide="x-circle" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-gray-400">
                                        {{ $request->approvedBy ? 'Por ' . $request->approvedBy->name : '-' }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No hay solicitudes de íconos
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50">
            {{ $requests->links() }}
        </div>
    </div>
</div>

<!-- Modal para ver imagen -->
<div id="imageModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[80vh] overflow-auto">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Imagen de Referencia</h3>
            <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="p-6">
            <img id="modalImage" src="" alt="Referencia" class="w-full h-auto rounded-lg">
        </div>
    </div>
</div>

<!-- Modal para rechazar -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Rechazar Solicitud</h3>
            <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-500">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <form id="rejectForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                    Motivo del rechazo
                </label>
                <textarea 
                    id="rejection_reason" 
                    name="rejection_reason" 
                    rows="4" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    required
                    placeholder="Explica el motivo del rechazo..."
                ></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button 
                    type="button" 
                    onclick="closeRejectModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
                >
                    Cancelar
                </button>
                <button 
                    type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                >
                    Rechazar
                </button>
            </div>
        </form>
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

function showRejectModal(requestId) {
    const form = document.getElementById('rejectForm');
    form.action = `/superlinkiu/tools/icon-requests/${requestId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejection_reason').value = '';
}
</script>
@endpush
@endsection
