<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FunctionsController extends Controller
{
    /**
     * Mostrar página pública de funciones
     */
    public function index(): View
    {
        return view('public::functions.index');
    }
}
