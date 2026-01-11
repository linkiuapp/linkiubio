<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PartnersController extends Controller
{
    /**
     * Mostrar página pública de partners
     */
    public function index(): View
    {
        return view('public::partners.index');
    }
}
