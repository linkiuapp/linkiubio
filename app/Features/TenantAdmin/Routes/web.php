<?php

use Illuminate\Support\Facades\Route;
use App\Features\TenantAdmin\Controllers\PaymentMethodController;
use App\Features\TenantAdmin\Controllers\BankAccountController;
use App\Features\TenantAdmin\Controllers\AuthController;
use App\Features\TenantAdmin\Controllers\DashboardController;
use App\Features\TenantAdmin\Controllers\BusinessProfileController;
use App\Features\TenantAdmin\Controllers\StoreDesignController;
use App\Features\TenantAdmin\Controllers\CategoryController;
use App\Features\TenantAdmin\Controllers\VariableController;
use App\Features\TenantAdmin\Controllers\ProductController;
use App\Features\TenantAdmin\Controllers\SliderController;
use App\Features\TenantAdmin\Controllers\LocationController;
use App\Features\TenantAdmin\Controllers\SimpleShippingController;
use App\Features\TenantAdmin\Controllers\TicketController;
use App\Features\TenantAdmin\Controllers\AnnouncementController;
use App\Features\TenantAdmin\Controllers\OrderController;
use App\Features\TenantAdmin\Controllers\BillingController;
use App\Features\TenantAdmin\Controllers\CouponController;
use App\Features\TenantAdmin\Controllers\PreviewController;
use App\Features\TenantAdmin\Controllers\MasterKeyController;
use App\Features\TenantAdmin\Controllers\TableReservationController;
use App\Features\TenantAdmin\Controllers\RoomTypeController;
use App\Features\TenantAdmin\Controllers\RoomController;
use App\Features\TenantAdmin\Controllers\HotelReservationController;
use App\Features\TenantAdmin\Controllers\TableController;
use App\Features\TenantAdmin\Controllers\DineInSettingController;


/*
|--------------------------------------------------------------------------
| Tenant Admin Routes
|--------------------------------------------------------------------------
|
| Rutas para el panel de administración de las tiendas
| URL: linkiu.bio/{tienda}/admin
|
*/

// Rutas de autenticación (sin middleware auth)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Rate limiting: 5 intentos por minuto por IP
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');



// Rutas protegidas (con middleware auth + verificación de aprobación)
Route::middleware(['auth', 'store.admin', \App\Shared\Middleware\CheckStoreApprovalStatus::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->withoutMiddleware(\App\Shared\Middleware\CheckStoreApprovalStatus::class);
    
    // Profile Routes (Usuario/Seguridad)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [\App\Features\TenantAdmin\Controllers\ProfileController::class, 'index'])->name('index');
        Route::post('/change-password', [\App\Features\TenantAdmin\Controllers\ProfileController::class, 'changePassword'])->name('change-password');
    });
    
    // Master Key Routes (Clave Maestra)
    Route::prefix('master-key')->name('master-key.')->group(function () {
        Route::get('/', [MasterKeyController::class, 'index'])->name('index');
        Route::post('/store', [MasterKeyController::class, 'store'])->name('store');
        Route::post('/update-actions', [MasterKeyController::class, 'updateActions'])->name('update-actions');
        Route::post('/verify', [MasterKeyController::class, 'verify'])->name('verify');
        Route::delete('/destroy', [MasterKeyController::class, 'destroy'])->name('destroy');
        Route::post('/request-recovery', [MasterKeyController::class, 'requestRecovery'])->name('request-recovery');
    });
    
    // Business Profile Routes
    Route::prefix('business-profile')->name('business-profile.')->group(function () {
        Route::get('/', [BusinessProfileController::class, 'index'])->name('index');
        Route::post('/update-owner', [BusinessProfileController::class, 'updateOwner'])->name('update-owner');
        Route::post('/update-store', [BusinessProfileController::class, 'updateStore'])->name('update-store');
        Route::post('/update-fiscal', [BusinessProfileController::class, 'updateFiscal'])->name('update-fiscal');
        Route::post('/update-seo', [BusinessProfileController::class, 'updateSeo'])->name('update-seo');
        Route::post('/update-policies', [BusinessProfileController::class, 'updatePolicies'])->name('update-policies');
        Route::post('/update-about', [BusinessProfileController::class, 'updateAbout'])->name('update-about');
        Route::post('/update-whatsapp', [BusinessProfileController::class, 'updateWhatsApp'])->name('update-whatsapp');
    });

    // WhatsApp Notifications Routes (vista independiente)
    Route::prefix('whatsapp-notifications')->name('whatsapp-notifications.')->group(function () {
        Route::get('/', [BusinessProfileController::class, 'whatsappIndex'])->name('index');
        Route::put('/update', [BusinessProfileController::class, 'updateWhatsApp'])->name('update');
    });

    // Store Design Routes
    Route::prefix('store-design')->name('store-design.')->group(function () {
        Route::get('/', [StoreDesignController::class, 'index'])->name('index');
        Route::post('/update', [StoreDesignController::class, 'update'])->name('update');
        Route::post('/upload-logo', [StoreDesignController::class, 'uploadLogo'])->name('upload-logo');
        Route::post('/upload-favicon', [StoreDesignController::class, 'uploadFavicon'])->name('upload-favicon');
        Route::post('/publish', [StoreDesignController::class, 'publish'])->name('publish');
        Route::post('/revert', [StoreDesignController::class, 'revert'])->name('revert');
    });
    
    // Categories Routes
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        Route::post('/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/update-order', [CategoryController::class, 'updateOrder'])->name('update-order');
    });
    
    // Variables Routes
    Route::prefix('variables')->name('variables.')->group(function () {
        Route::get('/', [VariableController::class, 'index'])->name('index');
        Route::get('/create', [VariableController::class, 'create'])->name('create');
        Route::post('/', [VariableController::class, 'store'])->name('store');
        Route::get('/{variable}', [VariableController::class, 'show'])->name('show');
        Route::get('/{variable}/edit', [VariableController::class, 'edit'])->name('edit');
        Route::put('/{variable}', [VariableController::class, 'update'])->name('update');
        Route::delete('/{variable}', [VariableController::class, 'destroy'])->name('destroy');
        Route::post('/{variable}/toggle-status', [VariableController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{variable}/duplicate', [VariableController::class, 'duplicate'])->name('duplicate');
    });

    // Products Routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::post('/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{product}/set-main-image', [ProductController::class, 'setMainImage'])->name('set-main-image');
        Route::post('/{product}/toggle-sharing', [ProductController::class, 'toggleSharing'])->name('toggle-sharing');
    });

    // Sliders Routes
    Route::prefix('sliders')->name('sliders.')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        Route::get('/create', [SliderController::class, 'create'])->name('create');
        Route::post('/', [SliderController::class, 'store'])->name('store');
        Route::get('/{slider}', [SliderController::class, 'show'])->name('show');
        Route::get('/{slider}/edit', [SliderController::class, 'edit'])->name('edit');
        Route::put('/{slider}', [SliderController::class, 'update'])->name('update');
        Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('destroy');
        Route::post('/{slider}/duplicate', [SliderController::class, 'duplicate'])->name('duplicate');
        Route::patch('/{slider}/toggle-status', [SliderController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/reorder', [SliderController::class, 'updateOrder'])->name('reorder');
    });

    // Rutas para métodos de pago
    Route::prefix('payment-methods')->name('payment-methods.')->group(function () {
        Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
        Route::get('/create', [PaymentMethodController::class, 'create'])->name('create');
        Route::post('/', [PaymentMethodController::class, 'store'])->name('store');
        Route::get('/{paymentMethod}', [PaymentMethodController::class, 'show'])->name('show');
        Route::get('/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('edit');
        Route::put('/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('update');
        Route::delete('/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('destroy');
        Route::post('/{paymentMethod}/toggle-active', [PaymentMethodController::class, 'toggleActive'])->name('toggle-active');
        Route::post('/{paymentMethod}/set-default', [PaymentMethodController::class, 'setDefault'])->name('set-default');
        Route::post('/update-order', [PaymentMethodController::class, 'updateOrder'])->name('update-order');
        
        // Rutas simplificadas para métodos predefinidos
        Route::post('/toggle-simple', [PaymentMethodController::class, 'toggleSimple'])->name('toggle-simple');
        Route::post('/set-default-simple', [PaymentMethodController::class, 'setDefaultSimple'])->name('set-default-simple');
        Route::post('/configure-simple', [PaymentMethodController::class, 'configureSimple'])->name('configure-simple');
        
        // Rutas para cuentas bancarias (anidadas bajo payment-methods)
        Route::prefix('{paymentMethod}/bank-accounts')->name('bank-accounts.')->group(function () {
            Route::get('/', [BankAccountController::class, 'index'])->name('index');
            Route::get('/create', [BankAccountController::class, 'create'])->name('create');
            Route::post('/', [BankAccountController::class, 'store'])->name('store');
            Route::get('/{bankAccount}/edit', [BankAccountController::class, 'edit'])->name('edit');
            Route::put('/{bankAccount}', [BankAccountController::class, 'update'])->name('update');
            Route::delete('/{bankAccount}', [BankAccountController::class, 'destroy'])->name('destroy');
            Route::post('/{bankAccount}/toggle-active', [BankAccountController::class, 'toggleActive'])->name('toggle-active');
        });
    });

    // Rutas directas para cuentas bancarias (para compatibilidad con las vistas existentes)
    Route::prefix('bank-accounts')->name('bank-accounts.')->group(function () {
        Route::get('/{paymentMethod}', [BankAccountController::class, 'index'])->name('index');
        Route::get('/{paymentMethod}/create', [BankAccountController::class, 'create'])->name('create');
        Route::post('/{paymentMethod}', [BankAccountController::class, 'store'])->name('store');
        Route::get('/{paymentMethod}/{bankAccount}/edit', [BankAccountController::class, 'edit'])->name('edit');
        Route::put('/{paymentMethod}/{bankAccount}', [BankAccountController::class, 'update'])->name('update');
        Route::delete('/{paymentMethod}/{bankAccount}', [BankAccountController::class, 'destroy'])->name('destroy');
        Route::post('/{paymentMethod}/{bankAccount}/toggle-active', [BankAccountController::class, 'toggleActive'])->name('toggle-active');
    });

    // Locations Routes
    Route::prefix('locations')->name('locations.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/create', [LocationController::class, 'create'])->name('create');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::get('/{location}', [LocationController::class, 'show'])->name('show');
        Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('edit');
        Route::put('/{location}', [LocationController::class, 'update'])->name('update');
        Route::delete('/{location}', [LocationController::class, 'destroy'])->name('destroy');
        Route::post('/{location}/toggle-status', [LocationController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{location}/set-as-main', [LocationController::class, 'setAsMain'])->name('set-as-main');
        Route::post('/{location}/increment-whatsapp-clicks', [LocationController::class, 'incrementWhatsAppClicks'])->name('increment-whatsapp-clicks');
    });


    // Simple Shipping Routes (New System)
    Route::prefix('envios')->name('simple-shipping.')->group(function () {
        Route::get('/', [SimpleShippingController::class, 'index'])->name('index');
        Route::put('/update', [SimpleShippingController::class, 'update'])->name('update');
        
        // Zones management
        Route::post('/zones', [SimpleShippingController::class, 'createZone'])->name('zones.create');
        Route::match(['PUT', 'POST'], '/zones/{zone_id}', [SimpleShippingController::class, 'updateZone'])->name('zones.update');
        Route::match(['DELETE', 'POST'], '/zones/{zone_id}', [SimpleShippingController::class, 'deleteZone'])->name('zones.delete');
        Route::post('/zones/reorder', [SimpleShippingController::class, 'reorderZones'])->name('zones.reorder');
        
        // API endpoints
        Route::post('/calculate-cost', [SimpleShippingController::class, 'calculateCost'])->name('calculate-cost');
        Route::get('/options', [SimpleShippingController::class, 'getOptions'])->name('options');
    });

    // Coupons Routes
    Route::prefix('coupons')->name('coupons.')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/', [CouponController::class, 'store'])->name('store');
        Route::get('/{coupon}', [CouponController::class, 'show'])->name('show');
        Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('edit');
        Route::put('/{coupon}', [CouponController::class, 'update'])->name('update');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('destroy');
        Route::post('/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{coupon}/duplicate', [CouponController::class, 'duplicate'])->name('duplicate');
    });

    // Tickets Routes
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::post('/', [TicketController::class, 'store'])->name('store');
        // IMPORTANTE: attachment debe estar ANTES de /{ticket} para evitar conflictos
        Route::get('/attachment/{path}', [TicketController::class, 'downloadAttachment'])
            ->where('path', '.*')
            ->name('attachment');
    Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
    Route::post('/{ticket}/add-response', [TicketController::class, 'addResponse'])->name('add-response');
    Route::post('/{ticket}/update-status', [TicketController::class, 'updateStatus'])->name('update-status');
    Route::post('/{ticket}/reopen', [TicketController::class, 'reopen'])->name('reopen');
    });

    // Table Reservations Routes (protegidas por feature:reservas_mesas)
    Route::middleware(['feature:reservas_mesas'])->prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [TableReservationController::class, 'index'])->name('index');
        Route::get('/create', [TableReservationController::class, 'create'])->name('create');
        Route::post('/', [TableReservationController::class, 'store'])->name('store');
        Route::get('/settings', [TableReservationController::class, 'settings'])->name('settings');
        Route::put('/settings', [TableReservationController::class, 'updateSettings'])->name('update-settings');
        Route::get('/{reservation}', [TableReservationController::class, 'show'])->name('show');
        Route::post('/{reservation}/confirm', [TableReservationController::class, 'confirm'])->name('confirm');
        Route::post('/{reservation}/cancel', [TableReservationController::class, 'cancel'])->name('cancel');
        Route::post('/{reservation}/complete', [TableReservationController::class, 'complete'])->name('complete');
        
        // Rutas para gestión de mesas
        Route::post('/settings/tables', [TableReservationController::class, 'storeTable'])->name('tables.store');
        Route::put('/settings/tables/{table}', [TableReservationController::class, 'updateTable'])->name('tables.update');
        Route::delete('/settings/tables/{table}', [TableReservationController::class, 'destroyTable'])->name('tables.destroy');
        Route::patch('/settings/tables/{table}/toggle', [TableReservationController::class, 'toggleTable'])->name('tables.toggle');
    });

    // Hotel Reservations Routes (protegidas por feature:reservas_hotel)
    Route::middleware(['feature:reservas_hotel'])->prefix('hotel')->name('hotel.')->group(function () {
        // Tipos de habitación
        Route::prefix('room-types')->name('room-types.')->group(function () {
            Route::get('/', [RoomTypeController::class, 'index'])->name('index');
            Route::get('/create', [RoomTypeController::class, 'create'])->name('create');
            Route::post('/', [RoomTypeController::class, 'store'])->name('store');
            Route::get('/{roomType}', [RoomTypeController::class, 'show'])->name('show');
            Route::get('/{roomType}/edit', [RoomTypeController::class, 'edit'])->name('edit');
            Route::put('/{roomType}', [RoomTypeController::class, 'update'])->name('update');
            Route::delete('/{roomType}', [RoomTypeController::class, 'destroy'])->name('destroy');
            Route::post('/{roomType}/toggle-status', [RoomTypeController::class, 'toggleStatus'])->name('toggle-status');
        });
        
        // Habitaciones (inventario)
        Route::prefix('rooms')->name('rooms.')->group(function () {
            Route::get('/', [RoomController::class, 'index'])->name('index');
            Route::post('/', [RoomController::class, 'store'])->name('store');
            Route::get('/{room}', [RoomController::class, 'show'])->name('show');
            Route::put('/{room}', [RoomController::class, 'update'])->name('update');
            Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy');
            Route::post('/{room}/update-status', [RoomController::class, 'updateStatus'])->name('update-status');
        });
        
        // Reservas de hotel
        Route::prefix('reservations')->name('reservations.')->group(function () {
            Route::get('/', [HotelReservationController::class, 'index'])->name('index');
            Route::get('/create', [HotelReservationController::class, 'create'])->name('create');
            Route::post('/', [HotelReservationController::class, 'store'])->name('store');
            Route::get('/{hotelReservation}/download-payment-proof', [HotelReservationController::class, 'downloadPaymentProof'])->name('download-payment-proof');
            Route::get('/{hotelReservation}', [HotelReservationController::class, 'show'])->name('show');
            Route::post('/{hotelReservation}/confirm', [HotelReservationController::class, 'confirm'])->name('confirm');
            Route::post('/{hotelReservation}/check-in', [HotelReservationController::class, 'checkIn'])->name('check-in');
            Route::post('/{hotelReservation}/check-out', [HotelReservationController::class, 'checkOut'])->name('check-out');
            Route::post('/{hotelReservation}/cancel', [HotelReservationController::class, 'cancel'])->name('cancel');
            Route::post('/{hotelReservation}/mark-deposit-paid', [HotelReservationController::class, 'markDepositAsPaid'])->name('mark-deposit-paid');
            
            // API
            Route::get('/api/available-rooms', [HotelReservationController::class, 'getAvailableRooms'])->name('api.available-rooms');
            Route::post('/api/calculate-pricing', [HotelReservationController::class, 'calculatePricing'])->name('api.calculate-pricing');
        });
        
        // Configuración de Hotel
        Route::get('/settings', [HotelReservationController::class, 'settings'])->name('settings');
        Route::put('/settings', [HotelReservationController::class, 'updateSettings'])->name('update-settings');
    });

    // Dine-In / Room Service Routes (protegidas por feature:consumo_local o consumo_hotel)
    Route::middleware(['feature:consumo_local,consumo_hotel'])->prefix('dine-in')->name('dine-in.')->group(function () {
        // Dashboard en tiempo real
        Route::get('/dashboard', [TableController::class, 'dashboard'])->name('dashboard');
        Route::get('/api/status', [TableController::class, 'getStatus'])->name('api.status');
        
        // Gestión de mesas/habitaciones
        Route::prefix('tables')->name('tables.')->group(function () {
            Route::get('/', [TableController::class, 'index'])->name('index');
            Route::post('/', [TableController::class, 'store'])->name('store');
            Route::put('/{id}', [TableController::class, 'update'])->name('update');
            Route::delete('/{id}', [TableController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/generate-qr', [TableController::class, 'generateQR'])->name('generate-qr');
            Route::post('/{id}/liberate', [TableController::class, 'liberate'])->name('liberate');
        });
        
        // Configuración de Dine-In (unificada)
        Route::put('/settings', [DineInSettingController::class, 'update'])->name('settings');
    });

    // Announcements Routes
    Route::prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('show');
        Route::post('/{announcement}/mark-as-read', [AnnouncementController::class, 'markAsRead'])->name('mark-as-read');
        Route::post('/mark-all-as-read', [AnnouncementController::class, 'markAllAsRead'])->name('mark-all-as-read');
        
        // API Routes for AJAX
        Route::get('/api/banners', [AnnouncementController::class, 'getBanners'])->name('api.banners');
        Route::get('/api/popups', [AnnouncementController::class, 'getPopups'])->name('api.popups');
        Route::get('/api/notification-count', [AnnouncementController::class, 'getNotificationCount'])->name('api.notification-count');
        Route::get('/api/recent', [AnnouncementController::class, 'getRecentAnnouncements'])->name('api.recent');
    });

    // Orders Routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        // Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy'); // REMOVIDO: Los pedidos NO se eliminan, solo se cancelan
        
        // Order Management Actions
        Route::post('/{order}/update-status', [OrderController::class, 'updateStatus'])->name('update-status');
        Route::post('/{order}/duplicate', [OrderController::class, 'duplicate'])->name('duplicate');
        
        // API para notificaciones en tiempo real
        Route::get('/api/count', [OrderController::class, 'getOrderCount'])->name('api.count');
        Route::get('/{order}/download-payment-proof', [OrderController::class, 'downloadPaymentProof'])->name('download-payment-proof');
        
        // AJAX Routes
        Route::post('/get-shipping-cost', [OrderController::class, 'getShippingCost'])->name('get-shipping-cost');
    });

    // Billing Routes (Plan y Facturación)
    Route::prefix('billing')->name('billing.')->group(function () {
        Route::get('/', [BillingController::class, 'index'])->name('index');
        
        // Plan management
        Route::post('/change-plan', [BillingController::class, 'changePlan'])->name('change-plan');
        Route::post('/change-billing-cycle', [BillingController::class, 'changeBillingCycle'])->name('change-billing-cycle');
        Route::post('/request-plan-change', [BillingController::class, 'requestPlanChange'])->name('request-plan-change');
        
        // Subscription management
        Route::post('/cancel-subscription', [BillingController::class, 'cancelSubscription'])->name('cancel-subscription');
        Route::post('/reactivate-subscription', [BillingController::class, 'reactivateSubscription'])->name('reactivate-subscription');
    });

    // Invoice Routes
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/{invoice}', [\App\Features\TenantAdmin\Controllers\InvoiceController::class, 'show'])->name('show');
        Route::get('/{invoice}/download', [\App\Features\TenantAdmin\Controllers\InvoiceController::class, 'downloadPdf'])->name('download');
        Route::get('/{invoice}/preview', [\App\Features\TenantAdmin\Controllers\InvoiceController::class, 'preview'])->name('preview');
    });

    // Ruta para manejar bajada de plan
    Route::post('/handle-plan-downgrade', [BankAccountController::class, 'handlePlanDowngrade'])->name('handle-plan-downgrade');
});


// Ruta por defecto que redirige
Route::get('/', function (\Illuminate\Http\Request $request) {
    // Obtener la tienda desde el segmento de URL
    $storeSlug = $request->segment(1); // Primer segmento será el slug de la tienda
    
    if (auth()->check() && auth()->user()->role === 'store_admin') {
        return redirect()->route('tenant.admin.dashboard', ['store' => $storeSlug]);
    }
    return redirect()->route('tenant.admin.login', ['store' => $storeSlug]);
})->name('index'); 