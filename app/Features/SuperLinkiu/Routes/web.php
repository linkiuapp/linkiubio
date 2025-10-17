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
        Route::resource('stores', StoreController::class)->names('stores');
        Route::post('stores/bulk-action', [StoreController::class, 'bulkAction'])
            ->name('stores.bulk-action');
        Route::post('stores/{store}/toggle-verified', [StoreController::class, 'toggleVerified'])
            ->name('stores.toggle-verified');
        Route::post('stores/{store}/update-status', [StoreController::class, 'updateStatus'])
            ->name('stores.update-status');
        Route::post('stores/{store}/extend-plan', [StoreController::class, 'extendPlan'])
            ->name('stores.extend-plan');
            
        // Business Categories
        Route::resource('business-categories', \App\Features\SuperLinkiu\Controllers\BusinessCategoryController::class)
            ->names('business-categories');
        Route::post('business-categories/{businessCategory}/toggle-status', 
            [\App\Features\SuperLinkiu\Controllers\BusinessCategoryController::class, 'toggleStatus'])
            ->name('business-categories.toggle-status');
        Route::post('business-categories/reorder', 
            [\App\Features\SuperLinkiu\Controllers\BusinessCategoryController::class, 'reorder'])
            ->name('business-categories.reorder');
        
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
        Route::resource('plans', PlanController::class)->names('plans');
        
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
        Route::post('tickets/{ticket}/assign', [TicketController::class, 'assign'])
            ->name('tickets.assign');
        Route::post('tickets/{ticket}/priority', [TicketController::class, 'updatePriority'])
            ->name('tickets.update-priority');

        // Gestión de anuncios
        Route::resource('announcements', AnnouncementController::class)->names('announcements');
        Route::post('announcements/{announcement}/toggle-active', [AnnouncementController::class, 'toggleActive'])
            ->name('announcements.toggle-active');
        Route::post('announcements/{announcement}/duplicate', [AnnouncementController::class, 'duplicate'])
            ->name('announcements.duplicate');

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
            Route::put('/{categoryIcon}', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'update'])
                ->name('update');
            Route::delete('/{categoryIcon}', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'destroy'])
                ->name('destroy');
            Route::post('/{categoryIcon}/toggle-active', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'toggleActive'])
                ->name('toggle-active');
            Route::post('/update-order', [\App\Features\SuperLinkiu\Controllers\CategoryIconController::class, 'updateOrder'])
                ->name('update-order');
        });
            
        // Rutas del perfil
        // Profile routes
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
        Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.delete-avatar');
        Route::patch('/profile/app-settings', [ProfileController::class, 'updateAppSettings'])->name('profile.update-app-settings');

        // Billing Settings
        Route::prefix('billing-settings')->name('billing-settings.')->group(function () {
            Route::get('/', [BillingSettingController::class, 'index'])->name('index');
            Route::put('/', [BillingSettingController::class, 'update'])->name('update');
            Route::post('/remove-logo', [BillingSettingController::class, 'removeLogo'])->name('remove-logo');
        });



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

        // Logout (dentro del middleware auth)
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
}); 