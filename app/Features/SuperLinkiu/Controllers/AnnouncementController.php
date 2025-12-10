<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\PlatformAnnouncement;
use App\Shared\Models\AnnouncementRead;
use App\Shared\Models\Store;
use App\Shared\Models\Plan;
use App\Shared\Models\NotificationChannel;
use App\Shared\Models\NotificationTemplate;
use App\Services\AnnouncementNotificationService;
use App\Services\NotificationTemplateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    protected $notificationService;
    protected $templateService;

    public function __construct(
        AnnouncementNotificationService $notificationService,
        NotificationTemplateService $templateService
    ) {
        $this->notificationService = $notificationService;
        $this->templateService = $templateService;
    }
    /**
     * Display a listing of announcements.
     */
    public function index(Request $request): View
    {
        $query = PlatformAnnouncement::with('reads');

        // Filtros
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Ordenar por prioridad y fecha
        $announcements = $query->ordered()->paginate(15)->withQueryString();

        // Estadísticas
        $stats = [
            'total' => PlatformAnnouncement::count(),
            'active' => PlatformAnnouncement::where('is_active', true)->count(),
            'banners' => PlatformAnnouncement::where('show_as_banner', true)->count(),
            'critical' => PlatformAnnouncement::byType('critical')->count(),
        ];

        return view('superlinkiu::announcements.index', compact('announcements', 'stats'));
    }

    /**
     * Show the form for creating a new announcement.
     */
    public function create(Request $request): View
    {
        $plans = Plan::where('is_active', true)->orderBy('name')->get();
        $stores = Store::where('status', 'active')->orderBy('name')->get();
        $templates = $this->templateService->getActiveTemplates();
        
        // Si hay un template_id, aplicar template
        $announcement = null;
        if ($request->has('template_id')) {
            $template = NotificationTemplate::find($request->template_id);
            if ($template) {
                $announcement = $this->templateService->createFromTemplate($template);
            }
        }

        return view('superlinkiu::announcements.create', compact('plans', 'stores', 'templates', 'announcement'));
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request): RedirectResponse
    {
        // Obtener nombres de planes válidos dinámicamente
        $validPlans = Plan::where('is_active', true)
            ->get()
            ->map(fn($plan) => strtolower($plan->name))
            ->toArray();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:critical,important,info',
            'priority' => 'required|integer|min:1|max:5',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_html' => 'nullable|string',
            'banner_background_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'banner_text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'banner_link' => 'nullable|url',
            'target_plans' => 'nullable|array',
            'target_plans.*' => 'string|in:' . implode(',', $validPlans),
            'target_stores' => 'nullable|array',
            'target_stores.*' => 'integer|exists:stores,id',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'is_active' => 'boolean',
            'show_popup' => 'boolean',
            'send_email' => 'boolean',
            'auto_mark_read_after' => 'nullable|integer|min:1|max:365',
            'channels' => 'nullable|array',
            'channels.*' => 'in:whatsapp,email,in_app',
        ]);

        // Procesar imagen del banner si existe
        if ($request->hasFile('banner_image')) {
            try {
                $bannerFilename = $this->handleBannerUpload($request->file('banner_image'));
                $validated['banner_image'] = $bannerFilename;
                $validated['show_as_banner'] = true;
            } catch (\Exception $e) {
                return back()->withErrors(['banner_image' => $e->getMessage()])->withInput();
            }
        }

        // Separar canales del validated
        $channels = $validated['channels'] ?? ['in_app'];
        unset($validated['channels']);

        // Crear anuncio
        $announcement = PlatformAnnouncement::create($validated);

        // Crear canales de notificación
        foreach ($channels as $channel) {
            NotificationChannel::create([
                'announcement_id' => $announcement->id,
                'channel' => $channel,
                'enabled' => true,
            ]);
        }

        // Si está activo, enviar notificaciones
        if ($announcement->is_active && $request->boolean('send_now', false)) {
            try {
                $this->notificationService->sendAnnouncement($announcement);
            } catch (\Exception $e) {
                \Log::error('Failed to send announcement notifications', [
                    'announcement_id' => $announcement->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        // 🔔 Disparar evento de nuevo anuncio para notificar a todos los admins de tiendas
        if ($announcement->is_active) {
            try {
                event(new \App\Events\NewAnnouncement($announcement));
            } catch (\Exception $e) {
                // No fallar la creación si Pusher tiene problemas
                \Log::warning('Broadcast announcement failed (non-critical)', [
                    'announcement_id' => $announcement->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return redirect()
            ->route('superlinkiu.announcements.index')
            ->with('success', 'Anuncio creado exitosamente.');
    }

    /**
     * Display the specified announcement.
     */
    public function show(PlatformAnnouncement $announcement): View
    {
        $announcement->load('reads.store');

        // Estadísticas de lectura
        $totalStores = Store::where('status', 'active')->count();
        $readCount = $announcement->reads()->count();
        $unreadCount = $totalStores - $readCount;

        $readStats = [
            'total_stores' => $totalStores,
            'read_count' => $readCount,
            'unread_count' => $unreadCount,
            'read_percentage' => $totalStores > 0 ? round(($readCount / $totalStores) * 100, 1) : 0
        ];

        return view('superlinkiu::announcements.show', compact('announcement', 'readStats'));
    }

    /**
     * Show the form for editing the announcement.
     */
    public function edit(PlatformAnnouncement $announcement): View
    {
        $announcement->load('reads.store', 'channels');

        $plans = Plan::where('is_active', true)->orderBy('name')->get();
        $stores = Store::where('status', 'active')->orderBy('name')->get();
        $templates = $this->templateService->getActiveTemplates();

        // Estadísticas de lectura
        $totalStores = Store::where('status', 'active')->count();
        $readCount = $announcement->reads()->count();
        $unreadCount = $totalStores - $readCount;

        $readStats = [
            'total_stores' => $totalStores,
            'read_count' => $readCount,
            'unread_count' => $unreadCount,
            'read_percentage' => $totalStores > 0 ? round(($readCount / $totalStores) * 100, 1) : 0
        ];

        // Get existing channels
        $existingChannels = $announcement->channels->pluck('channel')->toArray();

        return view('superlinkiu::announcements.edit', compact('announcement', 'plans', 'stores', 'readStats', 'templates', 'existingChannels'));
    }

    /**
     * Update the specified announcement.
     */
    public function update(Request $request, PlatformAnnouncement $announcement): RedirectResponse
    {
        // Obtener nombres de planes válidos dinámicamente
        $validPlans = Plan::where('is_active', true)
            ->get()
            ->map(fn($plan) => strtolower($plan->name))
            ->toArray();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:critical,important,info',
            'priority' => 'required|integer|min:1|max:5',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_html' => 'nullable|string',
            'banner_background_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'banner_text_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'banner_link' => 'nullable|url',
            'target_plans' => 'nullable|array',
            'target_plans.*' => 'string|in:' . implode(',', $validPlans),
            'target_stores' => 'nullable|array',
            'target_stores.*' => 'integer|exists:stores,id',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'is_active' => 'boolean',
            'show_popup' => 'boolean',
            'send_email' => 'boolean',
            'auto_mark_read_after' => 'nullable|integer|min:1|max:365',
            'remove_banner' => 'boolean',
            'channels' => 'nullable|array',
            'channels.*' => 'in:whatsapp,email,in_app',
        ]);

        // Manejar eliminación de banner
        if ($request->boolean('remove_banner') && $announcement->banner_image) {
            $this->deleteBannerImage($announcement->banner_image);
            $validated['banner_image'] = null;
            $validated['show_as_banner'] = false;
        }

        // Procesar nueva imagen del banner si existe
        if ($request->hasFile('banner_image')) {
            try {
                // Eliminar banner anterior si existe
                if ($announcement->banner_image) {
                    $this->deleteBannerImage($announcement->banner_image);
                }

                $bannerFilename = $this->handleBannerUpload($request->file('banner_image'));
                $validated['banner_image'] = $bannerFilename;
                $validated['show_as_banner'] = true;
            } catch (\Exception $e) {
                return back()->withErrors(['banner_image' => $e->getMessage()])->withInput();
            }
        }

        // Separar canales del validated
        $channels = $validated['channels'] ?? null;
        unset($validated['channels']);

        // Actualizar anuncio
        $announcement->update($validated);

        // Actualizar canales si se proporcionaron
        if ($channels !== null) {
            // Eliminar canales existentes
            $announcement->channels()->delete();
            
            // Crear nuevos canales
            foreach ($channels as $channel) {
                NotificationChannel::create([
                    'announcement_id' => $announcement->id,
                    'channel' => $channel,
                    'enabled' => true,
                ]);
            }
        }

        return redirect()
            ->route('superlinkiu.announcements.show', $announcement)
            ->with('success', 'Anuncio actualizado exitosamente.');
    }

    /**
     * Remove the specified announcement.
     */
    public function destroy(PlatformAnnouncement $announcement): RedirectResponse
    {
        // Eliminar imagen del banner si existe
        if ($announcement->banner_image) {
            $this->deleteBannerImage($announcement->banner_image);
        }

        $announcement->delete();

        return redirect()
            ->route('superlinkiu.announcements.index')
            ->with('success', 'Anuncio eliminado exitosamente.');
    }

    /**
     * Toggle active status of announcement.
     */
    public function toggleActive(PlatformAnnouncement $announcement): JsonResponse
    {
        $announcement->update(['is_active' => !$announcement->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $announcement->is_active,
            'message' => $announcement->is_active ? 'Anuncio activado' : 'Anuncio desactivado'
        ]);
    }

    /**
     * Duplicate announcement.
     */
    public function duplicate(PlatformAnnouncement $announcement): RedirectResponse
    {
        $newAnnouncement = $announcement->replicate();
        $newAnnouncement->title = $announcement->title . ' (Copia)';
        $newAnnouncement->is_active = false;
        $newAnnouncement->published_at = null;

        // Duplicar banner si existe
        if ($announcement->banner_image) {
            try {
                $newBannerFilename = $this->duplicateBannerImage($announcement->banner_image);
                $newAnnouncement->banner_image = $newBannerFilename;
            } catch (\Exception $e) {
                // Si falla la duplicación del banner, crear sin banner
                $newAnnouncement->banner_image = null;
                $newAnnouncement->show_as_banner = false;
            }
        }

        $newAnnouncement->save();

        return redirect()
            ->route('superlinkiu.announcements.edit', $newAnnouncement)
            ->with('success', 'Anuncio duplicado exitosamente. Puedes editarlo antes de activarlo.');
    }

    /**
     * Handle banner image upload with validation.
     */
    private function handleBannerUpload($file): string
    {
        // Validar dimensiones (628x200px)
        $imageInfo = getimagesize($file->getPathname());
        if ($imageInfo[0] !== 628 || $imageInfo[1] !== 200) {
            throw new \Exception('La imagen del banner debe ser exactamente 628x200 píxeles.');
        }

        // Generar nombre único
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        // ✅ Usar mismo método que ProductImageService (putFileAs)
        $directory = 'announcements/banners';
        $relativePath = Storage::disk('public')->putFileAs($directory, $file, $filename);
        
        if (!$relativePath) {
            throw new \Exception('Error guardando banner en storage');
        }

        // ✅ Retornar PATH RELATIVO (igual que ProductImageService)
        return $relativePath;
    }

    /**
     * Delete banner image from storage.
     */
    private function deleteBannerImage(string $filename): void
    {
        // ✅ Eliminar usando Storage facade
        \Storage::disk('public')->delete('announcements/banners/' . $filename);
    }

    /**
     * Duplicate banner image.
     */
    private function duplicateBannerImage(string $originalFilename): string
    {
        // ✅ Verificar archivo original usando Storage
        if (!\Storage::disk('public')->exists('announcements/banners/' . $originalFilename)) {
            throw new \Exception('Archivo original no encontrado');
        }

        $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
        $newFilename = time() . '_' . Str::random(10) . '.' . $extension;

        // ✅ Copiar archivo usando Storage
        \Storage::disk('public')->copy(
            'announcements/banners/' . $originalFilename,
            'announcements/banners/' . $newFilename
        );

        return $newFilename;
    }

    /**
     * Send notifications for announcement
     */
    public function sendNotifications(PlatformAnnouncement $announcement): JsonResponse
    {
        try {
            $results = $this->notificationService->sendAnnouncement($announcement);
            
            return response()->json([
                'success' => true,
                'message' => 'Notificaciones enviadas exitosamente',
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar notificaciones: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show analytics for announcement
     */
    public function analytics(PlatformAnnouncement $announcement): View
    {
        $stats = $this->notificationService->getDeliveryStats($announcement);
        $announcement->load('deliveries.store', 'channels');

        return view('superlinkiu::announcements.analytics', compact('announcement', 'stats'));
    }
} 