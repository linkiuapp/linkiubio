<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Shared\Models\Ticket;
use App\Shared\Models\TicketResponse;
use App\Shared\Models\TicketCategory;
use App\Shared\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\TicketResponseAdded;

class TicketController extends Controller
{
    public function index(Request $request): View
    {
        $store = $request->route('store');
        
        $query = Ticket::with(['categoryModel', 'responses.user'])
            ->where('store_id', $store->id)
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Paginación
        $perPage = $request->get('per_page', 15);
        $tickets = $query->paginate($perPage)->withQueryString();

        // Categorías para filtros
        $categories = TicketCategory::getActiveOptions();

        // Estadísticas básicas
        $stats = [
            'total' => Ticket::where('store_id', $store->id)->count(),
            'open' => Ticket::where('store_id', $store->id)->open()->count(),
            'in_progress' => Ticket::where('store_id', $store->id)->inProgress()->count(),
            'resolved' => Ticket::where('store_id', $store->id)->resolved()->count(),
        ];

        return view('tenant-admin::Core/tickets.index', compact('tickets', 'categories', 'stats', 'store'));
    }

    public function show(Request $request, $storeSlug, Ticket $ticket): View
    {
        $store = $request->route('store');
        
        // Verificar que el ticket pertenece a la tienda actual
        if ($ticket->store_id !== $store->id) {
            abort(404);
        }

        $ticket->load(['categoryModel', 'responses.user']);
        
        // Marcar como visto por store admin
        $ticket->markAsViewed();

        return view('tenant-admin::Core/tickets.show', compact('ticket', 'store'));
    }

    public function create(Request $request): View
    {
        $store = $request->route('store');
        $categories = TicketCategory::getActiveOptions();

        return view('tenant-admin::Core/tickets.create', compact('categories', 'store'));
    }

    public function store(Request $request): RedirectResponse
    {
        $store = $request->route('store');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'category' => 'required|exists:ticket_categories,slug',
            'priority' => 'required|in:low,medium,high,urgent',
            'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx,txt', // 5MB máximo
        ], [
            'title.required' => 'El título es obligatorio',
            'title.max' => 'El título no puede exceder 255 caracteres',
            'description.required' => 'La descripción es obligatoria',
            'description.max' => 'La descripción no puede exceder 5000 caracteres',
            'category.required' => 'La categoría es obligatoria',
            'category.exists' => 'La categoría seleccionada no es válida',
            'priority.required' => 'La prioridad es obligatoria',
            'priority.in' => 'La prioridad seleccionada no es válida',
            'attachments.*.file' => 'El archivo adjunto debe ser un archivo válido',
            'attachments.*.max' => 'Cada archivo no puede exceder 5MB',
            'attachments.*.mimes' => 'El archivo debe ser: jpg, jpeg, png, pdf, doc, docx o txt',
        ]);

        // Agregar información automática
        $userInfo = [
            'browser' => $this->getBrowserInfo($request->header('User-Agent')),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'plan' => $store->plan->name ?? 'Sin plan',
            'created_by' => auth()->user()->name ?? 'Usuario',
        ];

        $validated['store_id'] = $store->id;
        $validated['metadata'] = $userInfo;
        $validated['status'] = 'open';

        $ticket = Ticket::create($validated);

        // Procesar archivos adjuntos si los hay
        if ($request->hasFile('attachments')) {
            $attachments = $this->handleAttachments($request->file('attachments'), $ticket, $store->slug);
            $ticket->update(['attachments' => $attachments]);
        }

        // Enviar email de confirmación al Tenant Admin
        $this->sendTicketCreatedEmail($ticket);

        return redirect()
            ->route('tenant.admin.tickets.show', ['store' => $store->slug, 'ticket' => $ticket])
            ->with('swal_success', 'Ticket creado exitosamente. Recibirás una confirmación por email.');
    }

    public function addResponse(Request $request, $storeSlug, Ticket $ticket): RedirectResponse
    {
        $store = $request->route('store');
        
        // Verificar que el ticket pertenece a la tienda actual
        if ($ticket->store_id !== $store->id) {
            abort(404);
        }

        // Verificar que el ticket esté abierto o en progreso
        if (!in_array($ticket->status, ['open', 'in_progress'])) {
            return redirect()->back()->with('error', 'No se puede responder a un ticket cerrado o resuelto.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
        ], [
            'message.required' => 'El mensaje es obligatorio',
            'message.max' => 'El mensaje no puede exceder 2000 caracteres',
            'attachments.*.file' => 'El archivo adjunto debe ser un archivo válido',
            'attachments.*.max' => 'Cada archivo no puede exceder 5MB',
            'attachments.*.mimes' => 'El archivo debe ser: jpg, jpeg, png, pdf, doc, docx o txt',
        ]);

        // Crear la respuesta
        $response = $ticket->addResponse(
            auth()->id(),
            $validated['message'],
            'response',
            true // Todas las respuestas de store_admin son públicas
        );

        // Disparar evento para WebSocket
        \Log::info('🚀 Dispatching TicketResponseAdded event from TenantAdmin', [
            'ticket_id' => $ticket->id,
            'ticket_number' => $ticket->ticket_number,
            'response_from' => auth()->user()->role,
            'store_slug' => $ticket->store->slug
        ]);
        
        event(new TicketResponseAdded($ticket, $response));

        // Procesar archivos adjuntos si los hay
        if ($request->hasFile('attachments')) {
            $attachments = $this->handleAttachments($request->file('attachments'), $ticket, $store->slug, $response->id);
            $response->update(['attachments' => $attachments]);
        }

        return redirect()
            ->route('tenant.admin.tickets.show', ['store' => $storeSlug, 'ticket' => $ticket])
            ->with('swal_success', 'Respuesta agregada exitosamente.');
    }

    public function updateStatus(Request $request, $storeSlug, Ticket $ticket): JsonResponse
    {
        $store = $request->route('store');
        
        if ($ticket->store_id !== $store->id) {
            return response()->json(['success' => false, 'message' => 'Acceso denegado'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,closed', // Solo closed ahora
        ]);

        $oldStatus = $ticket->status;
        $newStatus = $validated['status'];

        switch ($newStatus) {
            case 'closed':
                // Marcar primero como resuelto si no lo está
                if ($ticket->status !== 'resolved') {
                    $ticket->markAsResolved(auth()->id());
                }
                // Luego cerrar
                $ticket->markAsClosed(auth()->id());
                break;
            default:
                $ticket->update(['status' => $newStatus]);
                break;
        }

        // Crear nota del cambio
        $ticket->addResponse(
            auth()->id(),
            "Estado cambiado de '{$ticket->getStatusLabelAttribute()}' a '{$ticket->fresh()->getStatusLabelAttribute()}'",
            'status_change',
            false
        );

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado exitosamente',
            'status' => $ticket->fresh()->status,
            'status_label' => $ticket->fresh()->status_label,
        ]);
    }

    public function reopen(Request $request, $storeSlug, Ticket $ticket): RedirectResponse
    {
        $store = $request->route('store');
        
        // Verificar que el ticket pertenece a la tienda actual
        if ($ticket->store_id !== $store->id) {
            abort(403);
        }

        // Validar que el ticket esté cerrado o resuelto
        if (!in_array($ticket->status, ['resolved', 'closed'])) {
            return redirect()->back()->with('error', 'Solo se pueden reabrir tickets cerrados o resueltos.');
        }

        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ], [
            'reason.max' => 'La razón no puede exceder 500 caracteres',
        ]);

        // Reabrir el ticket
        $ticket->reopen(auth()->id(), $validated['reason'] ?? null);

        // Enviar email de reapertura
        $this->sendTicketReopenedEmail($ticket, $validated['reason'] ?? null);

        return redirect()
            ->route('tenant.admin.tickets.show', ['store' => $storeSlug, 'ticket' => $ticket])
            ->with('swal_success', 'Ticket reabierto exitosamente. Puedes continuar agregando respuestas.');
    }

    private function sendTicketCreatedEmail(Ticket $ticket): void
    {
        try {
            $storeAdmin = $ticket->store->admins()->first();
            
            if (!$storeAdmin) {
                Log::warning('📧 No se pudo enviar email de creación de ticket (sin admin)', [
                    'ticket_id' => $ticket->id
                ]);
                return;
            }

            $estimatedTime = match($ticket->priority) {
                'urgent' => '2-4 horas',
                'high' => '4-8 horas',
                'medium' => '1-2 días',
                'low' => '2-3 días',
                default => '24-48 horas'
            };

            \App\Jobs\SendEmailJob::dispatch('template', $storeAdmin->email, [
                'template_key' => 'ticket_created_tenant',
                'variables' => [
                    'user_name' => $storeAdmin->name,
                    'store_name' => $ticket->store->name,
                    'ticket_number' => $ticket->ticket_number,
                    'ticket_title' => $ticket->title,
                    'ticket_content' => \Str::limit($ticket->description, 200),
                    'priority' => $ticket->priority_label,
                    'created_at' => $ticket->created_at->format('d/m/Y H:i'),
                    'estimated_response_time' => $estimatedTime,
                    'ticket_url' => route('tenant.admin.tickets.show', [
                        'store' => $ticket->store->slug,
                        'ticket' => $ticket->id
                    ])
                ]
            ]);

            /*Log::info('📧 Email de creación de ticket enviado', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'admin_email' => $storeAdmin->email
            ]);*/

        } catch (\Exception $e) {
            Log::error('❌ Error enviando email de creación de ticket', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function sendTicketReopenedEmail(Ticket $ticket, ?string $reason): void
    {
        try {
            $storeAdmin = $ticket->store->admins()->first();
            
            if (!$storeAdmin) {
                Log::warning('📧 No se pudo enviar email de reapertura (sin admin)', [
                    'ticket_id' => $ticket->id
                ]);
                return;
            }

            \App\Jobs\SendEmailJob::dispatch('template', $storeAdmin->email, [
                'template_key' => 'ticket_reopened',
                'variables' => [
                    'user_name' => $storeAdmin->name,
                    'store_name' => $ticket->store->name,
                    'ticket_number' => $ticket->ticket_number,
                    'ticket_title' => $ticket->title,
                    'reopened_date' => now()->format('d/m/Y H:i'),
                    'reopen_reason' => $reason ?: 'No se especificó razón',
                    'ticket_url' => route('tenant.admin.tickets.show', [
                        'store' => $ticket->store->slug,
                        'ticket' => $ticket->id
                    ]),
                    'superadmin_note' => 'Nuestro equipo de soporte ha sido notificado y responderá a la brevedad.'
                ]
            ]);

            Log::info('📧 Email de reapertura enviado', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->ticket_number,
                'admin_email' => $storeAdmin->email
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Error enviando email de reapertura', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function handleAttachments(array $files, Ticket $ticket, string $storeSlug, ?int $responseId = null): array
    {
        $attachments = [];
        $maxFiles = 3;

        foreach (array_slice($files, 0, $maxFiles) as $file) {
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = "tickets/{$storeSlug}/{$ticket->id}";
            
            if ($responseId) {
                $path .= "/responses/{$responseId}";
            }

            // Obtener el tamaño ANTES de mover el archivo
            $fileSize = $file->getSize();

            // Guardar archivo temporalmente en local y luego mover a S3 manualmente
            $tempPath = sys_get_temp_dir() . '/' . $filename;
            if (!move_uploaded_file($file->getPathname(), $tempPath)) {
                throw new \Exception('Error moviendo archivo temporal');
            }
            
            // Por ahora guardamos en local en lugar de S3 para evitar finfo
            // $path ya incluye 'tickets/' al inicio
            $localPath = storage_path('app/' . $path);
            if (!file_exists($localPath)) {
                mkdir($localPath, 0755, true);
            }
            
            $finalPath = $localPath . '/' . $filename;
            if (!copy($tempPath, $finalPath)) {
                throw new \Exception('Error guardando archivo');
            }
            
            \Log::info('📁 File saved successfully:', [
                'temp_path' => $tempPath,
                'final_path' => $finalPath,
                'file_exists' => file_exists($finalPath)
            ]);
            
            // Limpiar archivo temporal
            unlink($tempPath);
            
            // $path ya incluye 'tickets/' al inicio, no duplicar
            $filePath = $path . '/' . $filename;
            
            \Log::info('💾 Path stored in DB:', [
                'file_path' => $filePath,
                'path_variable' => $path,
                'filename' => $filename
            ]);

            // Obtener MIME type de forma segura (sin finfo)
            $extension = strtolower($file->getClientOriginalExtension());
            $mimeTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'txt' => 'text/plain',
                'zip' => 'application/zip',
            ];
            $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';

            $attachments[] = [
                'original_name' => $file->getClientOriginalName(),
                'filename' => $filename,
                'path' => $filePath,
                'size' => $fileSize,
                'mime_type' => $mimeType,
            ];
        }

        return $attachments;
    }

    private function getBrowserInfo(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'Desconocido';
        }

        if (str_contains($userAgent, 'Chrome')) {
            preg_match('/Chrome\/([0-9.]+)/', $userAgent, $matches);
            return 'Chrome ' . ($matches[1] ?? 'desconocido');
        }

        if (str_contains($userAgent, 'Firefox')) {
            preg_match('/Firefox\/([0-9.]+)/', $userAgent, $matches);
            return 'Firefox ' . ($matches[1] ?? 'desconocido');
        }

        if (str_contains($userAgent, 'Safari') && !str_contains($userAgent, 'Chrome')) {
            preg_match('/Version\/([0-9.]+)/', $userAgent, $matches);
            return 'Safari ' . ($matches[1] ?? 'desconocido');
        }

        if (str_contains($userAgent, 'Edge')) {
            preg_match('/Edge\/([0-9.]+)/', $userAgent, $matches);
            return 'Edge ' . ($matches[1] ?? 'desconocido');
        }

        return 'Otro navegador';
    }

    /**
     * Descargar adjunto de ticket
     */
    public function downloadAttachment($store, $path)
    {
        // El path viene como: tickets/store-slug/ticket-id/filename.ext
        // o: tickets/store-slug/ticket-id/responses/response-id/filename.ext
        
        // Intentar primero con file_exists directo
        $fullPath = storage_path('app/' . $path);
        if (file_exists($fullPath)) {
            $fileContent = file_get_contents($fullPath);
            $mimeType = mime_content_type($fullPath);
            $filename = basename($path);
            
            return response($fileContent)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }
        
        // Si no, intentar con Storage facade
        if (Storage::disk('local')->exists($path)) {
            $fileContent = Storage::disk('local')->get($path);
            $mimeType = Storage::disk('local')->mimeType($path);
            $filename = basename($path);
            
            return response($fileContent)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
        }
        
        abort(404, 'Archivo no encontrado');
    }
}
