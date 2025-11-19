<?php

use App\Features\DesignSystem\Controllers\ComponentLibraryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Design System Routes (Solo Local)
|--------------------------------------------------------------------------
| Biblioteca de componentes del design system.
| Solo disponible en ambiente local para desarrollo.
*/

if (app()->environment('local')) {
    Route::prefix('design-system')
        ->name('design-system.')
        ->middleware(['web', 'auth'])
        ->group(function () {
            Route::get('/', [ComponentLibraryController::class, 'index'])->name('index');
            Route::get('/colores', [ComponentLibraryController::class, 'colores'])->name('colores');
            Route::get('/tipografias', [ComponentLibraryController::class, 'tipografias'])->name('tipografias');
            Route::get('/estados', [ComponentLibraryController::class, 'estados'])->name('estados');
            Route::get('/iconos', [ComponentLibraryController::class, 'iconos'])->name('iconos');
                    Route::get('/inputs-preline', function () {
                        return view('design-system::inputs-preline');
                    })->name('inputs-preline');
                    Route::get('/alerts-preline', function () {
                        return view('design-system::alerts-preline');
                    })->name('alerts-preline');
                    Route::get('/badges-preline', function () {
                        return view('design-system::badges-preline');
                    })->name('badges-preline');
                    Route::get('/buttons-preline', function () {
                        return view('design-system::buttons-preline');
                    })->name('buttons-preline');
                    Route::get('/cards-preline', function () {
                        return view('design-system::cards-preline');
                    })->name('cards-preline');
                    Route::get('/datepicker-preline', function () {
                        return view('design-system::datepicker-preline');
                    })->name('datepicker-preline');
                    Route::get('/lists-preline', function () {
                        return view('design-system::lists-preline');
                    })->name('lists-preline');
                    Route::get('/listgroup-preline', function () {
                        return view('design-system::listgroup-preline');
                    })->name('listgroup-preline');
                    Route::get('/legend-preline', function () {
                        return view('design-system::legend-preline');
                    })->name('legend-preline');
                    Route::get('/progress-preline', function () {
                        return view('design-system::progress-preline');
                    })->name('progress-preline');
                    Route::get('/fileupload-preline', function () {
                        return view('design-system::fileupload-preline');
                    })->name('fileupload-preline');
                    Route::get('/ratings-preline', function () {
                        return view('design-system::ratings-preline');
                    })->name('ratings-preline');
                    Route::get('/spinners-preline', function () {
                        return view('design-system::spinners-preline');
                    })->name('spinners-preline');
                    Route::get('/toasts-preline', function () {
                        return view('design-system::toasts-preline');
                    })->name('toasts-preline');
                    Route::get('/timeline-preline', function () {
                        return view('design-system::timeline-preline');
                    })->name('timeline-preline');
                    Route::get('/navs-preline', function () {
                        return view('design-system::navs-preline');
                    })->name('navs-preline');
                    Route::get('/tabs-preline', function () {
                        return view('design-system::tabs-preline');
                    })->name('tabs-preline');
                    Route::get('/sidebar-preline', function () {
                        return view('design-system::sidebar-preline');
                    })->name('sidebar-preline');
                    Route::get('/breadcrumb-preline', function () {
                        return view('design-system::breadcrumb-preline');
                    })->name('breadcrumb-preline');
                    Route::get('/pagination-preline', function () {
                        return view('design-system::pagination-preline');
                    })->name('pagination-preline');
                    Route::get('/stepper-preline', function () {
                        return view('design-system::stepper-preline');
                    })->name('stepper-preline');
                    Route::get('/input-group-preline', function () {
                        return view('design-system::input-group-preline');
                    })->name('input-group-preline');
                    Route::get('/textarea-preline', function () {
                        return view('design-system::textarea-preline');
                    })->name('textarea-preline');
                    Route::get('/file-input-preline', function () {
                        return view('design-system::file-input-preline');
                    })->name('file-input-preline');
                    Route::get('/checkbox-preline', function () {
                        return view('design-system::checkbox-preline');
                    })->name('checkbox-preline');
                    Route::get('/radio-preline', function () {
                        return view('design-system::radio-preline');
                    })->name('radio-preline');
                    Route::get('/switch-preline', function () {
                        return view('design-system::switch-preline');
                    })->name('switch-preline');
                    Route::get('/select-preline', function () {
                        return view('design-system::select-preline');
                    })->name('select-preline');
                    Route::get('/time-picker-preline', function () {
                        return view('design-system::time-picker-preline');
                    })->name('time-picker-preline');
                    Route::get('/searchbox-preline', function () {
                        return view('design-system::searchbox-preline');
                    })->name('searchbox-preline');
                    Route::get('/input-number-preline', function () {
                        return view('design-system::input-number-preline');
                    })->name('input-number-preline');
                    Route::get('/toggle-password-preline', function () {
                        return view('design-system::toggle-password-preline');
                    })->name('toggle-password-preline');
                    Route::get('/copy-markup-preline', function () {
                        return view('design-system::copy-markup-preline');
                    })->name('copy-markup-preline');
                    Route::get('/pin-input-preline', function () {
                        return view('design-system::pin-input-preline');
                    })->name('pin-input-preline');
                    Route::get('/dropdown-preline', function () {
                        return view('design-system::dropdown-preline');
                    })->name('dropdown-preline');
                    Route::get('/modal-preline', function () {
                        return view('design-system::modal-preline');
                    })->name('modal-preline');
                    Route::get('/popover-preline', function () {
                        return view('design-system::popover-preline');
                    })->name('popover-preline');
                    Route::get('/tooltip-preline', function () {
                        return view('design-system::tooltip-preline');
                    })->name('tooltip-preline');
                    Route::get('/table-preline', function () {
                        return view('design-system::table-preline');
                    })->name('table-preline');
                    Route::get('/chart-preline', function () {
                        return view('design-system::chart-preline');
                    })->name('chart-preline');
                    Route::get('/clipboard-preline', function () {
                        return view('design-system::clipboard-preline');
                    })->name('clipboard-preline');
                    Route::get('/file-upload-preline', function () {
                        return view('design-system::file-upload-preline');
                    })->name('file-upload-preline');
    
        });
}

