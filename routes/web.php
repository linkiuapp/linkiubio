<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Broadcast;

// Ruta de preview para SuperAdmin (debe estar antes de las rutas catch-all)
Route::get('/admin-preview/{token}', [App\Features\TenantAdmin\Controllers\Core\PreviewController::class, 'preview'])
    ->name('linkiu.admin-preview');
Route::post('/admin-preview/exit', [App\Features\TenantAdmin\Controllers\Core\PreviewController::class, 'exitPreview'])
    ->name('linkiu.admin-preview.exit');

// Página para acceder al login de tenant admin
Route::get('/admin-login', function () {
    return view('public::auth.store-login');
})->name('store.login');

// Wizard de Registro Público
Route::prefix('registre')->name('register.')->group(function () {
    Route::get('/', [App\Features\Public\Controllers\RegistrationWizardController::class, 'step1'])->name('step1');
    Route::post('/step1', [App\Features\Public\Controllers\RegistrationWizardController::class, 'storeStep1'])->name('step1.store');
    Route::get('/step2', [App\Features\Public\Controllers\RegistrationWizardController::class, 'step2'])->name('step2');
    Route::post('/step2', [App\Features\Public\Controllers\RegistrationWizardController::class, 'storeStep2'])->name('step2.store');
    Route::get('/step3', [App\Features\Public\Controllers\RegistrationWizardController::class, 'step3'])->name('step3');
    Route::post('/step3', [App\Features\Public\Controllers\RegistrationWizardController::class, 'storeStep3'])->name('step3.store');
    Route::get('/step4', [App\Features\Public\Controllers\RegistrationWizardController::class, 'step4'])->name('step4');
    Route::post('/complete', [App\Features\Public\Controllers\RegistrationWizardController::class, 'complete'])->name('complete');
    Route::get('/step5/{registration}', [App\Features\Public\Controllers\RegistrationWizardController::class, 'step5'])->name('step5');
    Route::get('/success/{registration}', [App\Features\Public\Controllers\RegistrationWizardController::class, 'success'])->name('success');
    Route::get('/rejected/{registration}', [App\Features\Public\Controllers\RegistrationWizardController::class, 'rejected'])->name('rejected');
    
    // Rutas de pago con Epayco
    Route::post('/payment/initiate', [App\Http\Controllers\Public\RegistrationPaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::get('/payment/response', [App\Http\Controllers\Public\RegistrationPaymentController::class, 'paymentResponse'])->name('payment.response');
    Route::post('/payment/webhook', [App\Http\Controllers\Public\RegistrationPaymentController::class, 'webhook'])->name('payment.webhook');
});

// API para verificar estado de registro
Route::get('/api/check-registration-status/{registration}', [App\Features\Public\Controllers\RegistrationWizardController::class, 'checkStatus']);

// API para validar email en tiempo real durante registro
Route::post('/api/validate-registration-email', [App\Features\Public\Controllers\RegistrationWizardController::class, 'validateEmail'])->name('api.validate-registration-email');

// API para validar slug en tiempo real durante registro
Route::post('/api/validate-registration-slug', [App\Features\Public\Controllers\RegistrationWizardController::class, 'validateSlug'])->name('api.validate-registration-slug');

// API para validar nombre de tienda en tiempo real durante registro
Route::post('/api/validate-registration-store-name', [App\Features\Public\Controllers\RegistrationWizardController::class, 'validateStoreName'])->name('api.validate-registration-store-name');

// Landing Page Principal
Route::get('/', function () {
    // Obtener tiendas activas con logos para el carrusel
    try {
        $stores = \App\Shared\Models\Store::where('status', 'active')
            ->where('approval_status', 'approved')
            ->with('design')
            ->get();
        
        $featuredStores = $stores->filter(function($store) {
            // Verificar si tiene design
            if (!$store->design) {
                return false;
            }
            
            // Verificar logo_url - puede estar en los attributes o usar el accessor
            $logoUrl = $store->design->logo_url ?? null;
            
            // Si el accessor devuelve null, verificar directamente en attributes
            if (empty($logoUrl)) {
                $rawLogoUrl = $store->design->getAttributes()['logo_url'] ?? null;
                if (empty($rawLogoUrl)) {
                    return false;
                }
                // Si hay raw logo_url, el accessor debería funcionar
                $logoUrl = $store->design->logo_url;
            }
            
            return !empty($logoUrl);
        })
        ->take(12) // Limitar a 12 tiendas para el carrusel
        ->values() // Re-indexar
        ->map(function($store) {
            return [
                'slug' => $store->slug,
                'name' => $store->name,
                'logo_url' => $store->design->logo_url,
                'url' => route('tenant.home', $store->slug),
            ];
        });
    } catch (\Exception $e) {
        // Si hay error, usar colección vacía
        \Log::error('Error obteniendo tiendas destacadas para landing', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        $featuredStores = collect([]);
    }
    
    // Obtener el máximo de días de prueba de los planes activos
    $maxTrialDays = \App\Shared\Models\Plan::where('is_active', true)
        ->where('is_public', true)
        ->max('trial_days') ?? 15; // Default a 15 si no hay planes
    
    return view('landing.index', compact('featuredStores', 'maxTrialDays'));
})->name('landing');

// Página de Planes Pública
Route::get('/planes', [App\Features\Public\Controllers\PlansController::class, 'index'])->name('plans.index');
Route::post('/planes/select', [App\Features\Public\Controllers\PlansController::class, 'selectPlan'])->name('plans.select');

// Página de Funciones Pública
Route::get('/funciones', [App\Features\Public\Controllers\FunctionsController::class, 'index'])->name('functions.index');

// Página de Ecommerce Pública
Route::get('/ecommerce', [App\Features\Public\Controllers\EcommerceController::class, 'index'])->name('ecommerce.index');
Route::get('/restaurante', [App\Features\Public\Controllers\RestaurantController::class, 'index'])->name('restaurant.index');

// Página de Preguntas Frecuentes Pública
Route::get('/preguntas-frecuentes', [App\Features\Public\Controllers\FAQController::class, 'index'])->name('faq.index');

// Página de Contacto Pública
Route::get('/contacto', [App\Features\Public\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contacto', [App\Features\Public\Controllers\ContactController::class, 'send'])->name('contact.send');

// Página de Nosotros Pública
Route::get('/nosotros', [App\Features\Public\Controllers\AboutController::class, 'index'])->name('about.index');

// Página de Nuevas Actualizaciones Pública
Route::get('/nuevas-actualizaciones', [App\Features\Public\Controllers\ReleaseNotesController::class, 'index'])->name('release-notes.index');

// Página de Equipo Pública
Route::get('/equipo', [App\Features\Public\Controllers\TeamController::class, 'index'])->name('team.index');

// Página de Partners Pública
Route::get('/partners', [App\Features\Public\Controllers\PartnersController::class, 'index'])->name('partners.index');

// Páginas Legales
Route::get('/terminos-y-condiciones', [App\Features\Public\Controllers\LegalController::class, 'terms'])->name('legal.terms');
Route::get('/politica-de-privacidad', [App\Features\Public\Controllers\LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/politica-de-cookies', [App\Features\Public\Controllers\LegalController::class, 'cookies'])->name('legal.cookies');
Route::get('/politica-de-reembolsos', [App\Features\Public\Controllers\LegalController::class, 'refunds'])->name('legal.refunds');
Route::get('/aviso-legal', [App\Features\Public\Controllers\LegalController::class, 'legalNotice'])->name('legal.notice');

// Ruta para autenticación de WebSocket (requerida aunque usemos canales públicos)
Broadcast::routes(['middleware' => ['auth']]);

// API de notificaciones con autenticación por sesión web
Route::middleware(['web', 'auth'])->group(function () {
    // SuperLinkiu - Contadores para super_admin usando autenticación web
    Route::get('/api/superlinkiu/notifications', function () {
        // Verificar que el usuario esté autenticado y sea super_admin
        if (!auth()->check() || auth()->user()->role !== 'super_admin') {
            return response()->json([
                'error' => 'Unauthorized',
                'authenticated' => auth()->check(),
                'role' => auth()->user()?->role
            ], 401);
        }
        
        $openTicketsCount = \App\Shared\Models\Ticket::whereIn('status', ['open', 'in_progress'])->count();
        
        // Contar mensajes no leídos de store_admin usando la nueva lógica
        $newMessagesCount = \App\Shared\Models\Ticket::with('responses.user')
            ->get()
            ->sum(function($ticket) {
                return $ticket->new_store_responses_count;
            });
            
        return response()->json([
            'open_tickets' => $openTicketsCount,
            'new_messages' => $newMessagesCount
        ]);
    });
    
    // TenantAdmin - Contadores para store_admin usando autenticación web
    Route::get('/api/tenant/{store}/notifications', function ($storeSlug) {
        // Verificar que el usuario esté autenticado y sea store_admin
        if (!auth()->check() || auth()->user()->role !== 'store_admin') {
            return response()->json([
                'error' => 'Unauthorized',
                'authenticated' => auth()->check(),
                'role' => auth()->user()?->role
            ], 401);
        }
        
        $store = \App\Shared\Models\Store::where('slug', $storeSlug)->firstOrFail();
        
        // Verificar que el store_admin pertenezca a esta tienda
        if (auth()->user()->store_id !== $store->id) {
            return response()->json([
                'error' => 'Forbidden - User does not belong to this store',
                'user_store_id' => auth()->user()->store_id,
                'store_id' => $store->id
            ], 403);
        }
        
        $openTicketsCount = $store->tickets()->whereIn('status', ['open', 'in_progress'])->count();
        
        // Usar el atributo del modelo Store que ya implementa la lógica correcta
        $newMessagesCount = $store->unread_support_responses_count;
            
        return response()->json([
            'open_tickets' => $openTicketsCount,
            'new_messages' => $newMessagesCount
        ]);
    });
});

// Ruta para servir imágenes de tickets (tanto local como public)
Route::get('/storage/tickets/{store}/{ticket}/{filename}', function ($store, $ticket, $filename) {
    // Intentar encontrar el archivo en diferentes ubicaciones
    $possiblePaths = [
        "tickets/{$store}/{$ticket}/{$filename}",
        "public/tickets/{$store}/{$ticket}/{$filename}",
    ];
    
    foreach ($possiblePaths as $path) {
        if (Storage::disk('local')->exists($path)) {
            $file = Storage::disk('local')->get($path);
            $mimeType = Storage::disk('local')->mimeType($path);
            
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Cache-Control', 'public, max-age=31536000');
        }
    }
    
    // Intentar en disco public
    $publicPath = "tickets/{$store}/{$ticket}/{$filename}";
    if (Storage::disk('public')->exists($publicPath)) {
        $file = Storage::disk('public')->get($publicPath);
        $mimeType = Storage::disk('public')->mimeType($publicPath);
        
        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Cache-Control', 'public, max-age=31536000');
    }
    
    abort(404);
})->where([
    'store' => '[a-zA-Z0-9\-_]+',
    'ticket' => '[0-9]+',
    'filename' => '[a-zA-Z0-9\-_\.]+',
]);

// Ruta para servir imágenes de respuestas de tickets
Route::get('/storage/tickets/{store}/{ticket}/responses/{response}/{filename}', function ($store, $ticket, $response, $filename) {
    // Intentar encontrar el archivo en diferentes ubicaciones
    $possiblePaths = [
        "tickets/{$store}/{$ticket}/responses/{$response}/{$filename}",
        "public/tickets/{$store}/{$ticket}/responses/{$response}/{$filename}",
    ];
    
    foreach ($possiblePaths as $path) {
        if (Storage::disk('local')->exists($path)) {
            $file = Storage::disk('local')->get($path);
            $mimeType = Storage::disk('local')->mimeType($path);
            
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Cache-Control', 'public, max-age=31536000');
        }
    }
    
    // Intentar en disco public
    $publicPath = "tickets/{$store}/{$ticket}/responses/{$response}/{$filename}";
    if (Storage::disk('public')->exists($publicPath)) {
        $file = Storage::disk('public')->get($publicPath);
        $mimeType = Storage::disk('public')->mimeType($publicPath);
        
        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Cache-Control', 'public, max-age=31536000');
    }
    
    abort(404);
})->where([
    'store' => '[a-zA-Z0-9\-_]+',
    'ticket' => '[0-9]+',
    'response' => '[0-9]+',
    'filename' => '[a-zA-Z0-9\-_\.]+',
]);

// Ruta para servir SVG del DesignSystem desde app/Features/DesignSystem/images-ui
Route::get('/images-ui/{filename}', function ($filename) {
    $filePath = app_path('Features/DesignSystem/images-ui/' . $filename);
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    $file = file_get_contents($filePath);
    $mimeType = mime_content_type($filePath) ?: 'image/svg+xml';
    
    return response($file, 200)
        ->header('Content-Type', $mimeType)
        ->header('Cache-Control', 'public, max-age=31536000');
})->where('filename', '[a-zA-Z0-9\-_\.]+');

// Test temporal para SuperAdmin
Route::get('/test-superlinkiu', function () {
    return 'SuperLinkiu funciona! Rutas cargadas correctamente.';
});

// Las rutas de SuperLinkiu ahora están en:
// app/Features/SuperLinkiu/Routes/web.php
// y se cargan automáticamente mediante SuperLinkiuServiceProvider


// System Debug Routes (Emergency Access - Independent of SuperLinkiu)
Route::middleware(['web', \App\Http\Middleware\DebugAuthMiddleware::class])->group(function () {
    Route::get('/system-debug', [App\Http\Controllers\SystemDebugController::class, 'index']);
    Route::post('/system-debug', [App\Http\Controllers\SystemDebugController::class, 'index']); // Handle login POST
    Route::get('/system-debug/errors', [App\Http\Controllers\SystemDebugController::class, 'getErrors']);
    Route::get('/system-debug/stats', [App\Http\Controllers\SystemDebugController::class, 'getStats']);
    Route::post('/system-debug/clear-logs', [App\Http\Controllers\SystemDebugController::class, 'clearLogs']);
    Route::post('/system-debug/test-notification', [App\Http\Controllers\SystemDebugController::class, 'testNotification']);
    Route::get('/system-debug/logout', [App\Http\Controllers\SystemDebugController::class, 'logout']);
});

// ==========================================
// SubscriptionDev - Vista pública de pago
// ==========================================
Route::prefix('pago')->name('public.subscription.')->group(function () {
    Route::get('/{token}', [App\Features\Public\Controllers\SubscriptionPaymentController::class, 'show'])
        ->name('show');
    Route::post('/{token}', [App\Features\Public\Controllers\SubscriptionPaymentController::class, 'processPayment'])
        ->name('process');
    Route::get('/factura/{paymentToken}/resultado', [App\Features\Public\Controllers\SubscriptionPaymentController::class, 'paymentResponse'])
        ->name('payment.response');
});
