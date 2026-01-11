<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Mostrar página pública de contacto
     */
    public function index(): View
    {
        return view('public::contact.index');
    }
}
