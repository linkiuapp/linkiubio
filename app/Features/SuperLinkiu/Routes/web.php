<?php

use App\Features\SuperLinkiu\Controllers\AuthController;
use App\Features\SuperLinkiu\Controllers\StoreController;
use App\Features\SuperLinkiu\Controllers\DashboardController;
use App\Features\SuperLinkiu\Controllers\PlanController;
use App\Features\SuperLinkiu\Controllers\InvoiceController;
use App\Features\SuperLinkiu\Controllers\TicketController;
use App\Features\SuperLinkiu\Controllers\AnnouncementController;
use App\Features\SuperLinkiu\Controllers\ProfileController;
use App\Features\SuperLinkiu\Controllers\BillingSettingController;
use App\Features\SuperLinkiu\Controllers\MasterKeyRecoveryController;
use App\Features\SuperLinkiu\Controllers\StoreReportController;
use App\Features\SuperLinkiu\Controllers\OrderToolsController;
use App\Features\SuperLinkiu\Controllers\ToolController;
use App\Features\SuperLinkiu\Controllers\DepartmentsAndCitiesController;
use Illuminate\Support\Facades\Route;

// Rutas de SuperLinkiu
Route::prefix('superlinkiu')->name('superlinkiu.')->middleware('web')->group(function () {
    // Rutas de autenticación
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        // Rate limiting: 5 intentos por minuto por IP
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('throttle:5,1')
            ->name('login.submit');
    });

    // Rutas protegidas - Solo super admins
    Route::middleware(['auth', 'super.admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Gestión de tiendas
        Route::get('stores/create-wizard', [StoreController::class, 'createWizard'])
            ->name('stores.create-wizard');
        
        // Rutas específicas ANTES del resource (para evitar conflictos)
        Route::post('stores/bulk-action', [StoreController::class, 'bulkAction'])
            ->name('stores.bulk-action');
        Route::post('stores/{store}/toggle-verified', [StoreController::class, 'toggleVerified'])
            ->name('stores.toggle-verified');
        Route::post('stores/{store}/update-status', [StoreController::class, 'updateStatus'])
            ->name('stores.update-status');
        Route::post('stores/{store}/extend-plan', [StoreController::class, 'extendPlan'])
            ->name('stores.extend-plan');
        Route::post('stores/{store}/generate-admin-token', [StoreController::class, 'generateAdminToken'])
            ->name('stores.generate-admin-token');
            
        // Resource routes (deben ir después de las rutas específicas)
        Route::resource('stores', StoreController::class)->names('stores');
            
        // Business Categories
        Route::get('business-categories/migrate-verticals', 
            [\App\Features\SuperLinkiu\Controllers\BusinessCategoryController::class, 'migrateVerticals'])
            ->name('business-categories.migrate-verticals');
        Route::post('business-categories/apply-verticals', 
            [\App\Features\SuperLinkiu\Controllers\BusinessCategoryController::class, 'applyVerticals'])
            ->name('business-categories.apply-verticals');
        Route::post('business-categories/{businessCategory}/toggle-status', 
            [\App\Features\SuperLinkiu\Controllers\BusinessCategoryController::class, 'toggleStatus'])
            ->name('business-categories.toggle-status');
        Route::post('business-categories/reorder', 
            [\App\Features\SuperLinkiu\Controllers\BusinessCategoryController::class, 'reorder'])
            ->name('business-categories.reorder');
        Route::resource('business-categories', \App\Features\SuperLinkiu\Controllers\BusinessCategoryController::class)
            ->except(['show'])
            ->names('business-categories');

        // Pending Registrations (Wizard)
        Route::prefix('pending-registrations')->name('pending-registrations.')->group(function () {
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\PendingRegistrationController::class, 'index'])->name('index');
            Route::get('/{pendingRegistration}', [\App\Features\SuperLinkiu\Controllers\PendingRegistrationController::class, 'show'])->name('show');
            Route::post('/{pendingRegistration}/approve', [\App\Features\SuperLinkiu\Controllers\PendingRegistrationController::class, 'approve'])->name('approve');
            Route::post('/{pendingRegistration}/reject', [\App\Features\SuperLinkiu\Controllers\PendingRegistrationController::class, 'reject'])->name('reject');
            
            // API para polling
            Route::get('/{registrationId}/check-status', [\App\Features\SuperLinkiu\Controllers\PendingRegistrationController::class, 'checkStatus'])->name('check-status');
        });

        // Registration Payment Settings
        Route::prefix('registration-payment-settings')->name('registration-payment-settings.')->group(function () {
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\RegistrationPaymentSettingController::class, 'index'])->name('index');
            Route::put('/update', [\App\Features\SuperLinkiu\Controllers\RegistrationPaymentSettingController::class, 'update'])->name('update');
            Route::delete('/delete-qr', [\App\Features\SuperLinkiu\Controllers\RegistrationPaymentSettingController::class, 'deleteQr'])->name('delete-qr');
        });

        // Plan Change Requests
        Route::prefix('plan-change-requests')->name('plan-change-requests.')->group(function () {
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\PlanChangeRequestController::class, 'index'])->name('index');
            Route::post('/{planChangeRequest}/approve', [\App\Features\SuperLinkiu\Controllers\PlanChangeRequestController::class, 'approve'])->name('approve');
            Route::post('/{planChangeRequest}/reject', [\App\Features\SuperLinkiu\Controllers\PlanChangeRequestController::class, 'reject'])->name('reject');
        });

        // User Management
        Route::resource('user-management', \App\Features\SuperLinkiu\Controllers\UserManagementController::class)
            ->except(['show'])
            ->parameters(['user-management' => 'user'])
            ->names('user-management');
        
        // Store Approval Requests
        Route::prefix('store-requests')->name('store-requests.')->group(function () {
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\StoreApprovalController::class, 'index'])->name('index');
            Route::get('/{store}', [\App\Features\SuperLinkiu\Controllers\StoreApprovalController::class, 'show'])->name('show');
            Route::post('/{store}/approve', [\App\Features\SuperLinkiu\Controllers\StoreApprovalController::class, 'approve'])->name('approve');
            Route::post('/{store}/reject', [\App\Features\SuperLinkiu\Controllers\StoreApprovalController::class, 'reject'])->name('reject');
            Route::post('/{store}/assign-category', [\App\Features\SuperLinkiu\Controllers\StoreApprovalController::class, 'assignCategory'])->name('assign-category');
            Route::post('/{store}/update-notes', [\App\Features\SuperLinkiu\Controllers\StoreApprovalController::class, 'updateNotes'])->name('update-notes');
        });
        
        // Template API endpoints
        Route::prefix('api/templates')->name('api.templates.')->group(function () {
            Route::get('/', [StoreController::class, 'getTemplates'])->name('index');
            Route::get('/{templateId}/config', [StoreController::class, 'getTemplateConfig'])->name('config');
            Route::get('/{templateId}/validation-rules', [StoreController::class, 'getTemplateValidationRules'])->name('validation-rules');
            Route::get('/{templateId}/field-mapping', [StoreController::class, 'getTemplateFieldMapping'])->name('field-mapping');
            Route::get('/by-capability/{capability}', [StoreController::class, 'getTemplatesByCapability'])->name('by-capability');
        });

        // Store validation API endpoints
        Route::prefix('api/stores')->name('api.stores.')->group(function () {
            Route::post('/validate-email', [StoreController::class, 'validateEmail'])->name('validate-email');
            Route::post('/validate-slug', [StoreController::class, 'validateSlug'])->name('validate-slug');
            Route::post('/suggest-slug', [StoreController::class, 'suggestSlug'])->name('suggest-slug');
            Route::post('/suggest-email-domain', [StoreController::class, 'suggestEmailDomain'])->name('suggest-email-domain');
            Route::post('/calculate-billing', [StoreController::class, 'calculateBilling'])->name('calculate-billing');
            Route::get('/search-locations', [StoreController::class, 'searchLocations'])->name('search-locations');
            Route::get('/departments/{countryCode}', [StoreController::class, 'getDepartmentsByCountry'])->name('departments-by-country');
            Route::get('/cities/{countryCode}/{departmentCode}', [StoreController::class, 'getCitiesByDepartment'])->name('cities-by-department');
            Route::post('/validate-location', [StoreController::class, 'validateLocation'])->name('validate-location');
            Route::get('/location-suggestions', [StoreController::class, 'getLocationSuggestions'])->name('location-suggestions');
            Route::post('/send-credentials-email', [StoreController::class, 'sendCredentialsByEmail'])->name('send-credentials-email');
            Route::post('/send-welcome-email', [StoreController::class, 'sendWelcomeEmail'])->name('send-welcome-email');
            Route::post('/validation-suggestions', [StoreController::class, 'getValidationSuggestions'])->name('validation-suggestions');
            
            // Fiscal validation endpoints - Requirements: 3.3, 3.4
            Route::post('/validate-fiscal-document', [StoreController::class, 'validateFiscalDocument'])->name('validate-fiscal-document');
            Route::get('/tax-regimes', [StoreController::class, 'getTaxRegimes'])->name('tax-regimes');
            Route::get('/document-types', [StoreController::class, 'getDocumentTypes'])->name('document-types');
            Route::post('/validate-fiscal-information', [StoreController::class, 'validateFiscalInformation'])->name('validate-fiscal-information');
            
            // Draft management endpoints - Requirements: 5.1, 5.2, 5.3
            Route::post('/save-draft', [StoreController::class, 'saveDraft'])->name('save-draft');
            Route::get('/get-draft', [StoreController::class, 'getDraft'])->name('get-draft');
            Route::delete('/delete-draft/{draftId?}', [StoreController::class, 'deleteDraft'])->name('delete-draft');
            Route::post('/check-draft-conflict', [StoreController::class, 'checkDraftConflict'])->name('check-draft-conflict');
            Route::post('/extend-draft/{draftId}', [StoreController::class, 'extendDraft'])->name('extend-draft');
        });
            
        // Gestión de planes
        Route::get('plans/dashboard', [\App\Features\SuperLinkiu\Controllers\PlanDashboardController::class, 'index'])->name('plans.dashboard');
        Route::resource('plans', PlanController::class)->names('plans');

        // Gestión de Tutoriales
        Route::resource('tutorials', \App\Features\SuperLinkiu\Controllers\TutorialController::class)->names('tutorials');
        Route::post('tutorials/upload-image', [\App\Features\SuperLinkiu\Controllers\TutorialController::class, 'uploadImage'])->name('tutorials.upload-image');
        Route::resource('tutorial-categories', \App\Features\SuperLinkiu\Controllers\TutorialCategoryController::class)->names('tutorial-categories');
        Route::resource('tutorial-tags', \App\Features\SuperLinkiu\Controllers\TutorialTagController::class)->names('tutorial-tags');
        
        // Gestión de Release Notes (Nuevas Actualizaciones)
        Route::resource('release-notes', \App\Features\SuperLinkiu\Controllers\ReleaseNoteController::class)->names('release-notes');
        
        // Gestión de facturas
        Route::resource('invoices', InvoiceController::class)->names('invoices');
        Route::post('invoices/{invoice}/mark-as-paid', [InvoiceController::class, 'markAsPaid'])
            ->name('invoices.mark-as-paid');
        Route::post('invoices/{invoice}/cancel', [InvoiceController::class, 'cancel'])
            ->name('invoices.cancel');
        Route::post('stores/{store}/generate-invoice', [InvoiceController::class, 'generateForStore'])
            ->name('invoices.generate-for-store');
        Route::post('invoices/update-overdue', [InvoiceController::class, 'updateOverdueInvoices'])
            ->name('invoices.update-overdue');
        Route::get('invoices/stats', [InvoiceController::class, 'getStats'])
            ->name('invoices.stats');

        // Solicitudes de Pago (Payment Requests)
        Route::prefix('payment-requests')->name('payment-requests.')->group(function () {
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\PaymentRequestController::class, 'index'])->name('index');
            Route::get('/{invoice}', [\App\Features\SuperLinkiu\Controllers\PaymentRequestController::class, 'show'])->name('show');
            Route::post('/{invoice}/approve', [\App\Features\SuperLinkiu\Controllers\PaymentRequestController::class, 'approve'])->name('approve');
            Route::post('/{invoice}/reject', [\App\Features\SuperLinkiu\Controllers\PaymentRequestController::class, 'reject'])->name('reject');
            Route::get('/{invoice}/download-proof', [\App\Features\SuperLinkiu\Controllers\PaymentRequestController::class, 'downloadProof'])->name('download-proof');
        });

        // Gestión de tickets
        // IMPORTANTE: attachment debe estar ANTES del resource para evitar conflictos
        Route::get('tickets/attachment/{path}', [TicketController::class, 'downloadAttachment'])
            ->where('path', '.*')
            ->name('tickets.attachment');
        Route::get('tickets/stats', [TicketController::class, 'getStats'])
            ->name('tickets.stats');
        Route::resource('tickets', TicketController::class)->names('tickets');
        Route::post('tickets/{ticket}/add-response', [TicketController::class, 'addResponse'])
            ->name('tickets.add-response');
        Route::post('tickets/{ticket}/status', [TicketController::class, 'updateStatus'])
            ->name('tickets.update-status');

        // Herramientas - Gestión de pedidos
        Route::prefix('tools')->name('tools.')->group(function () {
            Route::get('/delete-order', [OrderToolsController::class, 'deleteOrderForm'])->name('delete-order');
            Route::post('/search-order', [OrderToolsController::class, 'searchOrder'])->name('search-order');
            Route::post('/delete-order', [OrderToolsController::class, 'deleteOrder'])->name('delete-order.execute');
            Route::get('/deletion-logs', [OrderToolsController::class, 'deletionLogs'])->name('deletion-logs');
            
            // Solicitudes de íconos
            Route::get('/icon-requests', [\App\Features\SuperLinkiu\Controllers\IconRequestController::class, 'iconRequests'])->name('icon-requests');
            Route::post('/icon-requests/{request}/approve', [\App\Features\SuperLinkiu\Controllers\IconRequestController::class, 'approve'])->name('icon-requests.approve');
            Route::post('/icon-requests/{request}/reject', [\App\Features\SuperLinkiu\Controllers\IconRequestController::class, 'reject'])->name('icon-requests.reject');
            
            // Reportes de errores
            Route::get('/error-reports', [\App\Features\SuperLinkiu\Controllers\IconRequestController::class, 'errorReports'])->name('error-reports');
            Route::post('/error-reports/{report}/update-status', [\App\Features\SuperLinkiu\Controllers\IconRequestController::class, 'updateErrorStatus'])->name('error-reports.update-status');
            Route::delete('/error-reports/{report}', [\App\Features\SuperLinkiu\Controllers\IconRequestController::class, 'deleteErrorReport'])->name('error-reports.delete');
        });

        // Herramientas de Linkiu - Administración de servicios y herramientas
        Route::prefix('linkiu-tools')->name('linkiu-tools.')->group(function () {
            Route::get('/', [ToolController::class, 'index'])->name('index');
            Route::get('/create', [ToolController::class, 'create'])->name('create');
            Route::post('/', [ToolController::class, 'store'])->name('store');
            Route::get('/{tool}', [ToolController::class, 'show'])->name('show');
            Route::get('/{tool}/edit', [ToolController::class, 'edit'])->name('edit');
            Route::put('/{tool}', [ToolController::class, 'update'])->name('update');
            Route::delete('/{tool}', [ToolController::class, 'destroy'])->name('destroy');
            
            // Generar descripciones con IA
            Route::post('/generate-description', [ToolController::class, 'generateDescription'])->name('generate-description');
            Route::post('/generate-usage', [ToolController::class, 'generateUsageInLinkiu'])->name('generate-usage');
            
            // Historial de pagos
            Route::post('/{tool}/payment', [ToolController::class, 'storePayment'])->name('store-payment');
            
            // Notificaciones WhatsApp
            Route::post('/{tool}/send-notification', [ToolController::class, 'sendPaymentNotification'])->name('send-notification');
        });

        Route::post('tickets/{ticket}/assign', [TicketController::class, 'assign'])
            ->name('tickets.assign');
        Route::post('tickets/{ticket}/priority', [TicketController::class, 'updatePriority'])
            ->name('tickets.update-priority');

        // Gestión de departamentos y ciudades (Dropshipping)
        Route::prefix('departments-cities')->name('departments-cities.')->group(function () {
            Route::get('/', [DepartmentsAndCitiesController::class, 'index'])->name('index');
            Route::get('/create', [DepartmentsAndCitiesController::class, 'create'])->name('create');
            Route::post('/', [DepartmentsAndCitiesController::class, 'store'])->name('store');
            Route::get('/{department}/edit', [DepartmentsAndCitiesController::class, 'edit'])->name('edit');
            Route::put('/{department}', [DepartmentsAndCitiesController::class, 'update'])->name('update');
            Route::delete('/{department}', [DepartmentsAndCitiesController::class, 'destroy'])->name('destroy');
            
            // Rutas para ciudades
            Route::post('/{department}/cities', [DepartmentsAndCitiesController::class, 'storeCity'])->name('cities.store');
            Route::put('/{department}/cities/{city}', [DepartmentsAndCitiesController::class, 'updateCity'])->name('cities.update');
            Route::delete('/{department}/cities/{city}', [DepartmentsAndCitiesController::class, 'destroyCity'])->name('cities.destroy');
        });

        // Gestión de anuncios
        Route::resource('announcements', AnnouncementController::class)->names('announcements');
        Route::post('announcements/{announcement}/toggle-active', [AnnouncementController::class, 'toggleActive'])
            ->name('announcements.toggle-active');
        Route::post('announcements/{announcement}/duplicate', [AnnouncementController::class, 'duplicate'])
            ->name('announcements.duplicate');
        Route::post('announcements/{announcement}/send-notifications', [AnnouncementController::class, 'sendNotifications'])
            ->name('announcements.send-notifications');
        Route::get('announcements/{announcement}/analytics', [AnnouncementController::class, 'analytics'])
            ->name('announcements.analytics');

        // Gestión de iconos de categorías
        Route::prefix('category-icons')->name('category-icons.')->group(function () {
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'index'])
                ->name('index');
            Route::get('/create', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'create'])
                ->name('create');
            Route::post('/', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'store'])
                ->name('store');
            Route::get('/{categoryIcon}/edit', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'edit'])
                ->name('edit');
            Route::post('/{categoryIcon}', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'update'])
                ->name('update');
            Route::delete('/{categoryIcon}', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'destroy'])
                ->name('destroy');
            Route::post('/{categoryIcon}/toggle-active', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'toggleActive'])
                ->name('toggle-active');
            Route::post('/update-order', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'updateOrder'])
                ->name('update-order');
        });

        // Gestión de imágenes UI
        Route::prefix('ui-images')->name('ui-images.')->group(function () {
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\UiImageController::class, 'index'])
                ->name('index');
            Route::get('/create', [\App\Features\SuperLinkiu\Controllers\UiImageController::class, 'create'])
                ->name('create');
            Route::post('/', [\App\Features\SuperLinkiu\Controllers\UiImageController::class, 'store'])
                ->name('store');
            Route::get('/{uiImage}/edit', [\App\Features\SuperLinkiu\Controllers\UiImageController::class, 'edit'])
                ->name('edit');
            Route::put('/{uiImage}', [\App\Features\SuperLinkiu\Controllers\UiImageController::class, 'update'])
                ->name('update');
            Route::delete('/{uiImage}', [\App\Features\SuperLinkiu\Controllers\UiImageController::class, 'destroy'])
                ->name('destroy');
            Route::post('/{uiImage}/toggle-active', [\App\Features\SuperLinkiu\Controllers\UiImageController::class, 'toggleActive'])
                ->name('toggle-active');
        });
            
        // Rutas del perfil
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

        // Master Key Recovery Management
        Route::prefix('master-key-recovery')->name('master-key-recovery.')->group(function () {
            Route::get('/', [MasterKeyRecoveryController::class, 'index'])->name('index');
            Route::post('/{id}/approve', [MasterKeyRecoveryController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [MasterKeyRecoveryController::class, 'reject'])->name('reject');
        });

        // Store Reports (Reportes de Tiendas)
        Route::prefix('store-reports')->name('store-reports.')->group(function () {
            Route::get('/', [StoreReportController::class, 'index'])->name('index');
            Route::get('/{report}', [StoreReportController::class, 'show'])->name('show');
            Route::put('/{report}/mark-reviewed', [StoreReportController::class, 'markAsReviewed'])->name('mark-reviewed');
            Route::put('/{report}/mark-resolved', [StoreReportController::class, 'markAsResolved'])->name('mark-resolved');
            Route::put('/{report}/update-notes', [StoreReportController::class, 'updateNotes'])->name('update-notes');
            Route::delete('/{report}', [StoreReportController::class, 'destroy'])->name('destroy');
        });

        // Store Statistics (Estadísticas de Tiendas)
        Route::prefix('store-statistics')->name('store-statistics.')->group(function () {
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\StoreStatisticsController::class, 'index'])->name('index');
            Route::get('/{store}', [\App\Features\SuperLinkiu\Controllers\StoreStatisticsController::class, 'show'])->name('show');
        });

        Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.delete-avatar');
        Route::patch('/profile/app-settings', [ProfileController::class, 'updateAppSettings'])->name('profile.update-app-settings');

        // Integraciones
        Route::prefix('integrations')->name('integrations.')->group(function () {
            // Pasarelas de Pagos
            Route::prefix('payment-gateways')->name('payment-gateways.')->group(function () {
                // Epayco
                Route::prefix('epayco')->name('epayco.')->group(function () {
                    Route::get('/', [\App\Http\Controllers\SuperLinkiu\Integrations\PaymentGateways\EpaycoController::class, 'index'])->name('index');
                    Route::post('/', [\App\Http\Controllers\SuperLinkiu\Integrations\PaymentGateways\EpaycoController::class, 'store'])->name('store');
                    Route::get('/transactions', [\App\Http\Controllers\SuperLinkiu\Integrations\PaymentGateways\EpaycoController::class, 'transactions'])->name('transactions');
                    Route::get('/transactions/{transaction}', [\App\Http\Controllers\SuperLinkiu\Integrations\PaymentGateways\EpaycoController::class, 'showTransaction'])->name('transaction.show');
                });
            });
        });

        // Billing Settings
        Route::prefix('billing-settings')->name('billing-settings.')->group(function () {
            Route::get('/', [BillingSettingController::class, 'index'])->name('index');
            Route::put('/', [BillingSettingController::class, 'update'])->name('update');
            Route::post('/remove-logo', [BillingSettingController::class, 'removeLogo'])->name('remove-logo');
        });

        // Monitoring
        // Sistema de monitoreo removido - ahora usando Sentry



        // Sistema de Emails con SendGrid
        Route::prefix('email')->name('email.')->group(function () {
            // Configuración de SendGrid
            Route::get('/configuration', [\App\Features\SuperLinkiu\Controllers\EmailConfigurationController::class, 'index'])
                ->name('configuration');
            Route::post('/validate-api', [\App\Features\SuperLinkiu\Controllers\EmailConfigurationController::class, 'validateApiKey'])
                ->name('validate-api');
            Route::post('/validate-template', [\App\Features\SuperLinkiu\Controllers\EmailConfigurationController::class, 'validateTemplate'])
                ->name('validate-template');
            Route::post('/send-test', [\App\Features\SuperLinkiu\Controllers\EmailConfigurationController::class, 'sendTestEmail'])
                ->name('send-test');
            Route::post('/save-config', [\App\Features\SuperLinkiu\Controllers\EmailConfigurationController::class, 'saveConfiguration'])
                ->name('save-config');
            Route::post('/save-sender-config', [\App\Features\SuperLinkiu\Controllers\EmailConfigurationController::class, 'saveSenderConfig'])
                ->name('save-sender-config');
            Route::get('/stats', [\App\Features\SuperLinkiu\Controllers\EmailConfigurationController::class, 'getStats'])
                ->name('stats');
            Route::post('/deactivate', [\App\Features\SuperLinkiu\Controllers\EmailConfigurationController::class, 'deactivate'])
                ->name('deactivate');
        });

        // Componentes de diseño
            Route::get('/components/alerts', function () {
        return view('superlinkiu::components.alerts');
    })->name('components.alerts');

    Route::get('/components/badges', function () {
        return view('superlinkiu::components.badges');
    })->name('components.badges');

    Route::get('/components/buttons', function () {
        return view('superlinkiu::components.buttons');
    })->name('components.buttons');

    Route::get('/components/widgets', function () {
        return view('superlinkiu::components.widgets');
    })->name('components.widgets');

    Route::get('/components/pricing', function () {
        return view('superlinkiu::components.pricing');
    })->name('components.pricing');

    Route::get('/components/image-upload', function () {
        return view('superlinkiu::components.image-upload');
    })->name('components.image-upload');

    // Users components
    Route::get('/components/users/profile', function () {
        return view('superlinkiu::components.users.profile');
    })->name('components.users.profile');

    Route::get('/components/users/add-user', function () {
        return view('superlinkiu::components.users.add-user');
    })->name('components.users.add-user');

    Route::get('/components/users/users-list', function () {
        return view('superlinkiu::components.users.users-list');
    })->name('components.users.users-list');

    // Table components
    Route::get('/components/table-basic', function () {
        return view('superlinkiu::components.table-basic');
    })->name('components.table-basic');

    Route::get('/components/table-data', function () {
        return view('superlinkiu::components.table-data');
    })->name('components.table-data');

    // Invoice components
    Route::get('/components/invoice/invoice-add', function () {
        return view('superlinkiu::components.invoice.invoice-add');
    })->name('components.invoice.invoice-add');

    Route::get('/components/invoice/invoice-edit', function () {
        return view('superlinkiu::components.invoice.invoice-edit');
    })->name('components.invoice.invoice-edit');

    Route::get('/components/invoice/invoice-list', function () {
        return view('superlinkiu::components.invoice.invoice-list');
    })->name('components.invoice.invoice-list');

    Route::get('/components/invoice/invoice-preview', function () {
        return view('superlinkiu::components.invoice.invoice-preview');
    })->name('components.invoice.invoice-preview');

    // Form components
    Route::get('/components/forms/form-basic', function () {
        return view('superlinkiu::components.forms.form-basic');
    })->name('components.forms.form-basic');

    Route::get('/components/forms/form-layout', function () {
        return view('superlinkiu::components.forms.form-layout');
    })->name('components.forms.form-layout');

    Route::get('/components/forms/form-validation', function () {
        return view('superlinkiu::components.forms.form-validation');
    })->name('components.forms.form-validation');

    Route::get('/components/forms/form-wizard', function () {
        return view('superlinkiu::components.forms.form-wizard');
    })->name('components.forms.form-wizard');

    // UI Components
    Route::get('/components/tags', function () {
        return view('superlinkiu::components.tags');
    })->name('components.tags');

    Route::get('/components/radio', function () {
        return view('superlinkiu::components.radio');
    })->name('components.radio');

    Route::get('/components/switch', function () {
        return view('superlinkiu::components.switch');
    })->name('components.switch');

    Route::get('/components/star-rating', function () {
        return view('superlinkiu::components.star-rating');
    })->name('components.star-rating');

    Route::get('/components/progress', function () {
        return view('superlinkiu::components.progress');
    })->name('components.progress');

    Route::get('/components/pagination', function () {
        return view('superlinkiu::components.pagination');
    })->name('components.pagination');

    Route::get('/components/dropdown', function () {
        return view('superlinkiu::components.dropdown');
    })->name('components.dropdown');

    Route::get('/components/calendar', function () {
        return view('superlinkiu::components.calendar');
    })->name('components.calendar');

    Route::get('/components/create-forms', function () {
        return view('superlinkiu::components.create-forms');
    })->name('components.create-forms');

    // Chart components
    Route::get('/components/charts/column-chart', function () {
        return view('superlinkiu::components.charts.column-chart');
    })->name('components.charts.column-chart');

    Route::get('/components/charts/line-chart', function () {
        return view('superlinkiu::components.charts.line-chart');
    })->name('components.charts.line-chart');

    Route::get('/components/charts/pie-chart', function () {
        return view('superlinkiu::components.charts.pie-chart');
    })->name('components.charts.pie-chart');

    // Páginas components
    Route::get('/components/paginas/faq', function () {
        return view('superlinkiu::components.paginas.faq');
    })->name('components.paginas.faq');

    Route::get('/components/paginas/error-404', function () {
        return view('superlinkiu::components.paginas.error-404');
    })->name('components.paginas.error-404');

    Route::get('/components/paginas/terms-conditions', function () {
        return view('superlinkiu::components.paginas.terms-conditions');
    })->name('components.paginas.terms-conditions');

    // Email components
    Route::get('/components/email/inbox', function () {
        return view('superlinkiu::components.email.inbox');
    })->name('components.email.inbox');

    Route::get('/components/email/details', function () {
        return view('superlinkiu::components.email.details');
    })->name('components.email.details');

    Route::get('/components/email/compose', function () {
        return view('superlinkiu::components.email.compose');
    })->name('components.email.compose');

        // ==========================================
        // LinkiuDev - Gestión de Proyectos Dev
        // ==========================================
        Route::prefix('linkiudev')->name('linkiudev.')->group(function () {
            
            // Dashboard de LinkiuDev
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\DashboardController::class, 'index'])
                ->name('dashboard');
            
            // Clientes
            Route::prefix('clients')->name('clients.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ClientController::class, 'index'])->name('index');
                Route::get('/create', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ClientController::class, 'create'])->name('create');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ClientController::class, 'store'])->name('store');
                Route::get('/{client}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ClientController::class, 'show'])->name('show');
                Route::get('/{client}/edit', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ClientController::class, 'edit'])->name('edit');
                Route::put('/{client}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ClientController::class, 'update'])->name('update');
                Route::delete('/{client}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ClientController::class, 'destroy'])->name('destroy');
                Route::post('/{client}/toggle-active', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ClientController::class, 'toggleActive'])->name('toggle-active');
            });
            
            // Proyectos
            Route::prefix('projects')->name('projects.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ProjectController::class, 'index'])->name('index');
                Route::get('/create', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ProjectController::class, 'create'])->name('create');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ProjectController::class, 'store'])->name('store');
                Route::get('/{project}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ProjectController::class, 'show'])->name('show');
                Route::get('/{project}/edit', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ProjectController::class, 'edit'])->name('edit');
                Route::put('/{project}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ProjectController::class, 'update'])->name('update');
                Route::delete('/{project}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ProjectController::class, 'destroy'])->name('destroy');
                Route::post('/{project}/update-status', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ProjectController::class, 'updateStatus'])->name('update-status');
                Route::post('/{project}/notify-client', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\ProjectController::class, 'notifyClient'])->name('notify-client');
            });
            
            // Tareas
            Route::prefix('tasks')->name('tasks.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'index'])->name('index');
                Route::get('/create', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'create'])->name('create');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'store'])->name('store');
                Route::get('/{task}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'show'])->name('show');
                Route::get('/{task}/edit', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'edit'])->name('edit');
                Route::put('/{task}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'update'])->name('update');
                Route::delete('/{task}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'destroy'])->name('destroy');
                Route::post('/{task}/update-status', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'updateStatus'])->name('update-status');
                Route::post('/{task}/schedule', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'schedule'])->name('schedule');
                Route::post('/reorder', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'reorder'])->name('reorder');
                
                // Subtareas
                Route::post('/{task}/subtasks', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'storeSubtask'])->name('subtasks.store');
                Route::put('/subtasks/{subtask}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'updateSubtask'])->name('subtasks.update');
                Route::delete('/subtasks/{subtask}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'destroySubtask'])->name('subtasks.destroy');
                Route::post('/subtasks/{subtask}/toggle', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\TaskController::class, 'toggleSubtask'])->name('subtasks.toggle');
            });
            
            // Agenda
            Route::prefix('agenda')->name('agenda.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\AgendaController::class, 'index'])->name('index');
                Route::get('/calendar-data', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\AgendaController::class, 'calendarData'])->name('calendar-data');
                Route::post('/entries', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\AgendaController::class, 'store'])->name('entries.store');
                Route::put('/entries/{entry}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\AgendaController::class, 'update'])->name('entries.update');
                Route::delete('/entries/{entry}', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\AgendaController::class, 'destroy'])->name('entries.destroy');
                Route::get('/today', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\AgendaController::class, 'today'])->name('today');
            });
            
            // Configuración de notificaciones
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\SettingsController::class, 'index'])->name('index');
                Route::put('/', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\SettingsController::class, 'update'])->name('update');
                Route::post('/test-notification', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\SettingsController::class, 'testNotification'])->name('test-notification');
                Route::get('/debug', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\SettingsController::class, 'debug'])->name('debug');
            });
            
            // Logs de notificaciones
            Route::get('/notification-logs', [\App\Features\SuperLinkiu\Controllers\LinkiuDev\SettingsController::class, 'notificationLogs'])
                ->name('notification-logs');
        });

        // ==========================================
        // SubscriptionDev - Gestión de Suscripciones
        // ==========================================
        Route::prefix('subscriptiondev')->name('subscriptiondev.')->group(function () {
            
            // Dashboard
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubDashboardController::class, 'index'])
                ->name('dashboard');
            
            // Clientes
            Route::prefix('clients')->name('clients.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubClientController::class, 'index'])->name('index');
                Route::get('/create', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubClientController::class, 'create'])->name('create');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubClientController::class, 'store'])->name('store');
                Route::get('/{client}', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubClientController::class, 'show'])->name('show');
                Route::get('/{client}/edit', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubClientController::class, 'edit'])->name('edit');
                Route::put('/{client}', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubClientController::class, 'update'])->name('update');
                Route::delete('/{client}', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubClientController::class, 'destroy'])->name('destroy');
            });
            
            // Tipos de servicio
            Route::prefix('service-types')->name('service-types.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubServiceTypeController::class, 'index'])->name('index');
                Route::get('/create', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubServiceTypeController::class, 'create'])->name('create');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubServiceTypeController::class, 'store'])->name('store');
                Route::get('/{serviceType}/edit', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubServiceTypeController::class, 'edit'])->name('edit');
                Route::put('/{serviceType}', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubServiceTypeController::class, 'update'])->name('update');
                Route::delete('/{serviceType}', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubServiceTypeController::class, 'destroy'])->name('destroy');
            });
            
            // Suscripciones
            Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'index'])->name('index');
                Route::get('/create', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'create'])->name('create');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'store'])->name('store');
                Route::get('/{subscription}', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'show'])->name('show');
                Route::get('/{subscription}/edit', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'edit'])->name('edit');
                Route::put('/{subscription}', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'update'])->name('update');
                Route::delete('/{subscription}', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'destroy'])->name('destroy');
                Route::post('/{subscription}/send-reminder', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'sendReminder'])->name('send-reminder');
                Route::post('/{subscription}/generate-payment', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'generatePayment'])->name('generate-payment');
                Route::post('/{subscription}/renew', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubSubscriptionController::class, 'renew'])->name('renew');
            });
            
            // Pagos
            Route::prefix('payments')->name('payments.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubPaymentController::class, 'index'])->name('index');
                Route::get('/{payment}', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubPaymentController::class, 'show'])->name('show');
                Route::post('/{payment}/mark-paid', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubPaymentController::class, 'markAsPaid'])->name('mark-paid');
                Route::post('/{payment}/cancel', [\App\Features\SuperLinkiu\Controllers\SubscriptionDev\SubPaymentController::class, 'cancel'])->name('cancel');
            });
        });

        // ==========================================
        // Personal Finance - Finanzas Personales
        // ==========================================
        Route::prefix('personal-finance')->name('personal-finance.')->group(function () {
            // Dashboard
            Route::get('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DashboardController::class, 'index'])
                ->name('dashboard');
            Route::post('/generate-token', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DashboardController::class, 'generateAccessToken'])
                ->name('generate-token');
            Route::post('/revoke-token/{accessToken}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DashboardController::class, 'revokeAccessToken'])
                ->name('revoke-token');
            
            // Cuentas Bancarias
            Route::prefix('accounts')->name('accounts.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\AccountController::class, 'index'])->name('index');
                Route::get('/create', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\AccountController::class, 'create'])->name('create');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\AccountController::class, 'store'])->name('store');
                Route::get('/{account}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\AccountController::class, 'show'])->name('show');
                Route::get('/{account}/edit', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\AccountController::class, 'edit'])->name('edit');
                Route::put('/{account}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\AccountController::class, 'update'])->name('update');
                Route::delete('/{account}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\AccountController::class, 'destroy'])->name('destroy');
            });
            
            // Deudas
            Route::prefix('debts')->name('debts.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DebtController::class, 'index'])->name('index');
                Route::get('/create', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DebtController::class, 'create'])->name('create');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DebtController::class, 'store'])->name('store');
                Route::get('/{debt}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DebtController::class, 'show'])->name('show');
                Route::get('/{debt}/edit', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DebtController::class, 'edit'])->name('edit');
                Route::put('/{debt}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DebtController::class, 'update'])->name('update');
                Route::delete('/{debt}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\DebtController::class, 'destroy'])->name('destroy');
            });
            
            // Cuotas
            Route::prefix('installments')->name('installments.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\InstallmentController::class, 'index'])->name('index');
                Route::post('/{installment}/mark-paid', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\InstallmentController::class, 'markAsPaid'])->name('mark-paid');
            });
            
            // Pagos
            Route::prefix('payments')->name('payments.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\PaymentController::class, 'index'])->name('index');
            });
            
            // Transacciones (Ingresos y Gastos)
            Route::prefix('transactions')->name('transactions.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\TransactionController::class, 'index'])->name('index');
                Route::get('/create', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\TransactionController::class, 'create'])->name('create');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\TransactionController::class, 'store'])->name('store');
                Route::get('/{transaction}/edit', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\TransactionController::class, 'edit'])->name('edit');
                Route::put('/{transaction}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\TransactionController::class, 'update'])->name('update');
                Route::delete('/{transaction}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\TransactionController::class, 'destroy'])->name('destroy');
            });
            
            // Recordatorios de Pagos
            Route::prefix('reminders')->name('reminders.')->group(function () {
                Route::get('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\ReminderController::class, 'index'])->name('index');
                Route::post('/', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\ReminderController::class, 'store'])->name('store');
                Route::put('/{reminder}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\ReminderController::class, 'update'])->name('update');
                Route::delete('/{reminder}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\ReminderController::class, 'destroy'])->name('destroy');
            });
        });

        // Acceso Rápido Mobile (Público con token)
        Route::prefix('finances/quick-add')->name('finances.quick-add.')->group(function () {
            Route::get('/{token}', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\QuickAccessController::class, 'show'])->name('show');
            Route::post('/{token}/pay', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\QuickAccessController::class, 'payInstallment'])->name('pay');
            Route::post('/{token}/income', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\QuickAccessController::class, 'addIncome'])->name('income');
            Route::post('/{token}/expense', [\App\Features\SuperLinkiu\Controllers\PersonalFinance\QuickAccessController::class, 'addExpense'])->name('expense');
        });

        // Logout (dentro del middleware auth)
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
}); 