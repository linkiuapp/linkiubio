<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Mostrar página pública de nosotros
     */
    public function index(): View
    {
        return view('public::about.index');
    }
}
