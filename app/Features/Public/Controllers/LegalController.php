<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LegalController extends Controller
{
    /**
     * Mostrar página de Términos y Condiciones
     */
    public function terms(): View
    {
        return view('public::legal.terms');
    }

    /**
     * Mostrar página de Política de Privacidad
     */
    public function privacy(): View
    {
        return view('public::legal.privacy');
    }

    /**
     * Mostrar página de Política de Cookies
     */
    public function cookies(): View
    {
        return view('public::legal.cookies');
    }

    /**
     * Mostrar página de Política de Reembolsos
     */
    public function refunds(): View
    {
        return view('public::legal.refunds');
    }

    /**
     * Mostrar página de Aviso Legal
     */
    public function legalNotice(): View
    {
        return view('public::legal.legal-notice');
    }
}
