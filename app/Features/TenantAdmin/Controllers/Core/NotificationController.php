<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Shared\Models\Order;
use App\Shared\Models\Ticket;
use App\Shared\Models\PlatformAnnouncement;
use App\Shared\Models\Invoice;
use App\Features\SuperLinkiu\Models\ReleaseNote;
use App\Models\IconRequest;
use App\Models\ErrorReport;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display a unified notifications page showing orders, tickets, and announcements
     */
    public function index(Request $request): View
    {
        $store = $request->route('store');
        
        // Obtener pedidos recientes (últimos 30 días)
        $recentOrders = Order::byStore($store->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($order) use ($store) {
                return [
                    'id' => $order->id,
                    'type' => 'order',
                    'title' => '📦 Nuevo Pedido',
                    'message' => "Pedido #{$order->order_number} de {$order->customer_name} - Total: $" . number_format($order->total, 0, ',', '.'),
                    'url' => route('tenant.admin.orders.show', [$store->slug, $order->id]),
                    'icon' => 'party-popper',
                    'color' => 'red',
                    'timestamp' => $order->created_at,
                    'formatted_time' => $order->created_at->diffForHumans(),
                ];
            });

        // Obtener tickets con respuestas recientes o tickets nuevos (últimos 30 días)
        $recentTickets = Ticket::where('store_id', $store->id)
            ->where(function ($q) {
                // Tickets con respuestas recientes
                $q->whereHas('responses', function ($subQ) {
                    $subQ->where('created_at', '>=', now()->subDays(30));
                })
                // O tickets nuevos
                ->orWhere('created_at', '>=', now()->subDays(30));
            })
            ->with(['responses' => function ($q) {
                $q->orderBy('created_at', 'desc')->limit(1);
            }])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($ticket) use ($store) {
                $latestResponse = $ticket->responses->first();
                $isResponse = $latestResponse && $latestResponse->created_at > $ticket->created_at && $latestResponse->created_at >= now()->subDays(30);
                
                return [
                    'id' => $ticket->id,
                    'type' => 'ticket',
                    'title' => $isResponse ? '💬 Nueva Respuesta en Ticket' : '🎫 Nuevo Ticket',
                    'message' => $isResponse 
                        ? "Ticket #{$ticket->ticket_number}: " . \Str::limit($latestResponse->message, 100)
                        : "Ticket #{$ticket->ticket_number}: " . \Str::limit($ticket->title, 100),
                    'url' => route('tenant.admin.tickets.show', [$store->slug, $ticket->id]),
                    'icon' => 'message-square-more',
                    'color' => 'blue',
                    'timestamp' => $isResponse ? $latestResponse->created_at : $ticket->created_at,
                    'formatted_time' => ($isResponse ? $latestResponse->created_at : $ticket->created_at)->diffForHumans(),
                ];
            });

        // Obtener anuncios recientes (últimos 30 días)
        $storePlan = strtolower($store->plan->name ?? $store->plan->slug ?? 'explorer');
        $recentAnnouncements = PlatformAnnouncement::active()
            ->forPlan($storePlan)
            ->forStore($store->id)
            ->where('published_at', '<=', now())
            ->where(function ($q) {
                $q->where('published_at', '>=', now()->subDays(30))
                  ->orWhereNull('published_at');
            })
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($announcement) use ($store) {
                return [
                    'id' => $announcement->id,
                    'type' => 'announcement',
                    'title' => '📢 ' . $announcement->title,
                    'message' => \Str::limit(strip_tags($announcement->content), 150),
                    'url' => route('tenant.admin.announcements.show', [$store->slug, $announcement->id]),
                    'icon' => 'megaphone',
                    'color' => 'yellow',
                    'timestamp' => $announcement->published_at ?? $announcement->created_at,
                    'formatted_time' => ($announcement->published_at ?? $announcement->created_at)->diffForHumans(),
                ];
            });

        // Obtener release notes recientes (últimos 30 días, solo las que fueron notificadas)
        // Incluir también las que tienen notify_tenants = true o las recientes activas
        $recentReleaseNotes = ReleaseNote::with('items')
            ->active()
            ->where(function ($query) {
                $query->where('notify_tenants', true)
                      ->orWhere(function ($q) {
                          // Incluir release notes recientes activas (últimos 7 días) aunque no tengan notify_tenants
                          $q->where('created_at', '>=', now()->subDays(7))
                            ->whereNull('notify_tenants');
                      });
            })
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($releaseNote) {
                $itemsCount = $releaseNote->items->count();
                return [
                    'id' => 'release-note_' . $releaseNote->id,
                    'type' => 'release-note',
                    'title' => '🚀 Nueva Actualización: v' . $releaseNote->version,
                    'message' => 'Se ha publicado una nueva versión con ' . $itemsCount . ' actualización(es)',
                    'url' => route('release-notes.index'),
                    'icon' => 'rocket',
                    'color' => 'purple',
                    'timestamp' => $releaseNote->created_at,
                    'formatted_time' => $releaseNote->created_at->diffForHumans(),
                ];
            });

        // Obtener facturas recientes (últimos 30 días)
        $recentInvoices = Invoice::byStore($store->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($invoice) use ($store) {
                // Determinar icono y color según el estado
                $statusConfig = [
                    'pending' => ['icon' => 'file-text', 'color' => 'orange', 'emoji' => '📄', 'label' => 'Pendiente'],
                    'paid' => ['icon' => 'check-circle', 'color' => 'green', 'emoji' => '✅', 'label' => 'Pagada'],
                    'overdue' => ['icon' => 'alert-circle', 'color' => 'red', 'emoji' => '⚠️', 'label' => 'Vencida'],
                    'cancelled' => ['icon' => 'x-circle', 'color' => 'gray', 'emoji' => '❌', 'label' => 'Cancelada'],
                ];
                
                $config = $statusConfig[$invoice->status] ?? $statusConfig['pending'];
                
                return [
                    'id' => 'invoice_' . $invoice->id,
                    'type' => 'invoice',
                    'title' => $config['emoji'] . ' Factura ' . $invoice->invoice_number . ' - ' . $config['label'],
                    'message' => 'Monto: $' . number_format($invoice->amount, 0, ',', '.') . ' - Vence: ' . $invoice->due_date->format('d/m/Y'),
                    'url' => route('tenant.admin.invoices.show', [$store->slug, $invoice->id]),
                    'icon' => $config['icon'],
                    'color' => $config['color'],
                    'timestamp' => $invoice->created_at,
                    'formatted_time' => $invoice->created_at->diffForHumans(),
                ];
            });

        // Obtener solicitudes de íconos aprobadas (últimos 30 días)
        $recentIconRequests = IconRequest::where('store_id', $store->id)
            ->where('status', 'approved')
            ->where('approved_at', '>=', now()->subDays(30))
            ->orderBy('approved_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($iconRequest) use ($store) {
                return [
                    'id' => 'icon-request_' . $iconRequest->id,
                    'type' => 'icon-request-approved',
                    'title' => '✨ Ícono Aprobado',
                    'message' => 'Tu solicitud de ícono "' . $iconRequest->category_name . '" ha sido aprobada',
                    'url' => route('tenant.admin.categories.index', $store->slug),
                    'icon' => 'sparkles',
                    'color' => 'purple',
                    'timestamp' => $iconRequest->approved_at,
                    'formatted_time' => $iconRequest->approved_at->diffForHumans(),
                ];
            });

        // Obtener reportes de errores resueltos (últimos 30 días)
        $recentErrorReports = ErrorReport::where('store_id', $store->id)
            ->where('status', 'resolved')
            ->where('resolved_at', '>=', now()->subDays(30))
            ->orderBy('resolved_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($errorReport) use ($store) {
                return [
                    'id' => 'error-report_' . $errorReport->id,
                    'type' => 'error-report-resolved',
                    'title' => '✅ Error Resuelto',
                    'message' => 'Tu reporte "' . $errorReport->title . '" ha sido resuelto',
                    'url' => null,
                    'icon' => 'check-circle',
                    'color' => 'green',
                    'timestamp' => $errorReport->resolved_at,
                    'formatted_time' => $errorReport->resolved_at->diffForHumans(),
                ];
            });

        // Notificación de verificación de tienda (siempre visible, mostrando el estado actual)
        $verificationNotification = collect([[
            'id' => 'store-verification_' . $store->id,
            'type' => 'store_verification_changed',
            'title' => $store->verified ? '✨ ¡Tienda Verificada!' : '📋 Tienda No Verificada',
            'message' => $store->verified 
                ? '¡Genial! Tu tienda tiene el badge oficial de Linkiu. Destacarás más en la plataforma 🚀'
                : 'Tu tienda actualmente no está verificada. Sigue mejorando tu contenido y servicios para obtener la verificación 💪',
            'url' => null,
            'icon' => $store->verified ? 'badge-check' : 'shield-off',
            'color' => $store->verified ? 'green' : 'gray',
            'timestamp' => now(), // Timestamp actual para que aparezca al inicio
            'formatted_time' => $store->verified ? 'Tienda verificada' : 'Estado actual',
        ]]);

        // Combinar todas las notificaciones y ordenar por fecha
        $allNotifications = collect()
            ->merge($recentOrders)
            ->merge($recentTickets)
            ->merge($recentAnnouncements)
            ->merge($recentReleaseNotes)
            ->merge($recentInvoices)
            ->merge($recentIconRequests)
            ->merge($recentErrorReports)
            ->merge($verificationNotification)
            ->sortByDesc(function ($notification) {
                // Convertir timestamp a timestamp unix para ordenar correctamente
                $timestamp = $notification['timestamp'];
                if (is_object($timestamp) && method_exists($timestamp, 'timestamp')) {
                    return $timestamp->timestamp;
                }
                return strtotime($timestamp);
            })
            ->values()
            ->take(50) // Limitar a 50 notificaciones
            ->map(function ($notification) {
                // Preparar datos para JavaScript (convertir timestamps a string)
                $timestamp = $notification['timestamp'];
                $timestampString = is_object($timestamp) 
                    ? ($timestamp instanceof \Carbon\Carbon ? $timestamp->toISOString() : (string) $timestamp)
                    : (string) $timestamp;
                
                return [
                    'id' => $notification['type'] . '_' . $notification['id'],
                    'type' => $notification['type'],
                    'title' => $notification['title'],
                    'message' => $notification['message'],
                    'url' => $notification['url'],
                    'icon' => $notification['icon'],
                    'color' => $notification['color'],
                    'timestamp' => $timestampString,
                    'formatted_time' => $notification['formatted_time']
                ];
            })
            ->values()
            ->all();

        // Estadísticas
        $stats = [
            'orders' => [
                'total' => Order::byStore($store->id)->where('created_at', '>=', now()->subDays(30))->count(),
                'pending' => Order::byStore($store->id)->where('status', 'pending')->count(),
            ],
            'tickets' => [
                'total' => Ticket::where('store_id', $store->id)->count(),
                'open' => Ticket::where('store_id', $store->id)->open()->count(),
            ],
            'announcements' => [
                'total' => PlatformAnnouncement::active()
                    ->forPlan($storePlan)
                    ->forStore($store->id)
                    ->where('published_at', '<=', now())
                    ->count(),
                'unread' => PlatformAnnouncement::active()
                    ->forPlan($storePlan)
                    ->forStore($store->id)
                    ->whereDoesntHave('reads', function ($q) use ($store) {
                        $q->where('store_id', $store->id);
                    })
                    ->where('published_at', '<=', now())
                    ->count(),
            ],
        ];

        return view('tenant-admin::Core/notifications.index', compact('allNotifications', 'stats', 'store'));
    }
}
