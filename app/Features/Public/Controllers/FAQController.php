<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FAQController extends Controller
{
    /**
     * Mostrar página pública de preguntas frecuentes
     */
    public function index(): View
    {
        return view('public::faq.index');
    }
}
