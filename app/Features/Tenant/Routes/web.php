<?php

use Illuminate\Support\Facades\Route;
use App\Features\Tenant\Controllers\StorefrontController;
use App\Features\Tenant\Controllers\OrderController;
use App\Features\Tenant\Controllers\PageController;
use App\Features\Tenant\Controllers\ReservationController;
use App\Features\Tenant\Controllers\HotelReservationController;
use App\Features\Tenant\Controllers\DineInController;

/*
|--------------------------------------------------------------------------
| Tenant (Store Frontend) Routes
|--------------------------------------------------------------------------
|
| Rutas para el frontend público de las tiendas
| URL: linkiu.bio/{tienda}
|
*/

// Página principal de la tienda (Próximamente)
Route::get('/', [StorefrontController::class, 'index'])->name('home');

// API para verificar estado de verificación en tiempo real
Route::get('/verification-status', [StorefrontController::class, 'verificationStatus'])->name('verification-status');

// Página de información de verificación
Route::get('/verificada', [StorefrontController::class, 'verified'])->name('verified');

// Catálogo de productos con buscador
Route::get('/catalogo', [StorefrontController::class, 'catalog'])->name('catalog');

// API para búsqueda en tiempo real
Route::get('/api/search', [StorefrontController::class, 'searchProducts'])->name('search.api');

// Rutas de productos
Route::get('/producto/{productSlug}', [StorefrontController::class, 'product'])->name('product');

// Carrito y Checkout Routes
Route::prefix('carrito')->name('cart.')->group(function () {
    Route::get('/', [StorefrontController::class, 'cart'])->name('index');
    Route::post('/agregar', [OrderController::class, 'addToCart'])->name('add');
    Route::get('/contenido', [OrderController::class, 'getCart'])->name('get');
    Route::put('/actualizar', [OrderController::class, 'updateCartItem'])->name('update');
    Route::delete('/eliminar', [OrderController::class, 'removeFromCart'])->name('remove');
    Route::delete('/limpiar', [OrderController::class, 'clearCart'])->name('clear');
    Route::post('/aplicar-cupon', [OrderController::class, 'applyCoupon'])->name('apply-coupon');
});

// Checkout Routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [OrderController::class, 'create'])->name('create');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::post('/shipping-cost', [OrderController::class, 'getShippingCost'])->name('shipping-cost');
    Route::get('/shipping-methods', [OrderController::class, 'getShippingMethods'])->name('shipping-methods');
    Route::get('/payment-methods', [OrderController::class, 'getPaymentMethods'])->name('payment-methods');
    Route::get('/shipping-departments', [OrderController::class, 'getShippingDepartments'])->name('shipping-departments');
    Route::get('/exito', [OrderController::class, 'success'])->name('success');
    Route::get('/error', [OrderController::class, 'error'])->name('error');
    
    // API Routes para estado de pedidos
    Route::prefix('api')->group(function () {
        Route::get('/order-status', [OrderController::class, 'getOrderStatusSimple'])->name('api.order.status.simple');
    });
});

// Order Routes
Route::prefix('pedido')->name('order.')->group(function () {
    Route::get('/seguimiento', [OrderController::class, 'tracking'])->name('tracking');
});

// DEBUG Routes (temporal)
Route::prefix('debug')->name('debug.')->group(function () {
    Route::get('/cart', [OrderController::class, 'debugCart'])->name('cart');
    Route::post('/cart/add', [OrderController::class, 'debugAddToCart'])->name('cart.add');
    Route::match(['GET', 'POST'], '/shipping-cost', [OrderController::class, 'debugShippingCost'])->name('shipping-cost');
});

// Rutas de categorías
Route::get('/categorias', [StorefrontController::class, 'categories'])->name('categories');
Route::get('/categoria/{categorySlug}', [StorefrontController::class, 'category'])->name('category');

// Ruta de contacto/sedes
Route::get('/contacto', [StorefrontController::class, 'contact'])->name('contact');

// Ruta de promociones/cupones
Route::get('/promociones', [StorefrontController::class, 'promotions'])->name('promotions');

// Ruta de próximamente (reservas y otras funciones futuras)
Route::get('/proximamente', function() {
    $store = request()->route('store');
    return view('tenant::storefront.coming-soon', compact('store'));
})->name('coming-soon');

// Prepágina de selección de tipo de reserva (si ambos están activos)
Route::middleware(['feature:reservas_mesas,reservas_hotel'])->get('/reservaciones/tipo', [ReservationController::class, 'selectType'])->name('reservations.select-type');

// Reservaciones de Mesa (protegidas por feature:reservas_mesas)
Route::middleware(['feature:reservas_mesas'])->prefix('reservaciones')->name('reservations.')->group(function () {
    Route::get('/', [ReservationController::class, 'index'])->name('index');
    Route::post('/', [ReservationController::class, 'store'])->name('store');
    // Ruta success sin parámetros en la URL (igual que checkout) - usa query parameter
    Route::get('/exito', [ReservationController::class, 'success'])->name('success');
    
    // API Routes para validación en tiempo real
    Route::prefix('api')->name('api.')->group(function () {
        Route::post('/available-slots', [ReservationController::class, 'getAvailableSlots'])->name('available-slots');
        Route::post('/check-availability', [ReservationController::class, 'checkAvailability'])->name('check-availability');
    });
});

// Reservaciones de Hotel (protegidas por feature:reservas_hotel)
Route::middleware(['feature:reservas_hotel'])->prefix('reservas-hotel')->name('hotel-reservations.')->group(function () {
    Route::get('/', [HotelReservationController::class, 'index'])->name('index');
    Route::post('/', [HotelReservationController::class, 'store'])->name('store');
    Route::get('/exito', [HotelReservationController::class, 'success'])->name('success');
    
    // API Routes
    Route::prefix('api')->name('api.')->group(function () {
        Route::post('/available-room-types', [HotelReservationController::class, 'getAvailableRoomTypes'])->name('available-room-types');
        Route::post('/calculate-pricing', [HotelReservationController::class, 'calculatePricing'])->name('calculate-pricing');
    });
});

// Dine-In / Room Service (protegidas por feature:consumo_local o consumo_hotel)
// IMPORTANTE: {number} debe ser un parámetro literal, no model binding
Route::prefix('mesa')->name('dine-in.')->group(function () {
    Route::get('/{number}', [DineInController::class, 'detectTable'])
        ->where('number', '[0-9]+') // Solo números
        ->name('table');
});

Route::prefix('habitacion')->name('dine-in.')->group(function () {
    Route::get('/{number}', [DineInController::class, 'detectTable'])
        ->where('number', '[0-9]+') // Solo números
        ->name('room');
});

Route::prefix('dine-in')->name('dine-in.')->group(function () {
    Route::get('/checkout', [DineInController::class, 'checkout'])->name('checkout');
});

// API Routes para checkout (mesas y habitaciones disponibles)
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/available-tables', [OrderController::class, 'getAvailableTables'])->name('available-tables');
    Route::get('/available-rooms', [OrderController::class, 'getAvailableRooms'])->name('available-rooms');
});

// Rutas de páginas informativas
Route::get('/politicas-legales', [PageController::class, 'legalPolicies'])->name('legal-policies');
Route::get('/acerca-de-nosotros', [PageController::class, 'aboutUs'])->name('about-us');
Route::get('/reportar-problema', [PageController::class, 'reportProblem'])->name('report-problem');
Route::post('/reportar-problema', [PageController::class, 'submitReport'])->name('report-problem.submit');

// Más rutas del frontend se añadirán aquí en el futuro...
// Route::get('/buscar', [StorefrontController::class, 'search'])->name('search'); 