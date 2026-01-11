<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * Mostrar página pública de equipo
     */
    public function index(): View
    {
        // Datos de ejemplo para el equipo
        // En producción, esto vendría de una base de datos
        $teamMembers = [
            [
                'name' => 'Equipo Linkiu',
                'role' => 'Desarrolladores y Diseñadores',
                'description' => 'Nuestro equipo está comprometido con crear la mejor plataforma para que tu negocio crezca en línea.',
                'image' => null,
            ],
        ];

        return view('public::team.index', compact('teamMembers'));
    }
}
