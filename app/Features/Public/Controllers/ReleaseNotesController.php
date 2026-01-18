<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\ReleaseNote;
use Illuminate\View\View;

class ReleaseNotesController extends Controller
{
    /**
     * Mostrar página pública de nuevas actualizaciones
     */
    public function index(): View
    {
        // Obtener versiones activas desde la BD
        $releaseNotes = ReleaseNote::with('items')
            ->active()
            ->ordered()
            ->get();

        // Formatear para la vista (mantener compatibilidad con estructura anterior)
        $versions = $releaseNotes->map(function ($releaseNote) {
            // Formatear fecha en español
            $months = [
                1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
                5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
                9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
            ];
            $month = $months[$releaseNote->release_date->month] ?? $releaseNote->release_date->format('F');
            $formattedDate = $releaseNote->release_date->format('d') . ' de ' . $month . ', ' . $releaseNote->release_date->format('Y');
            
            return [
                'version' => $releaseNote->version,
                'date' => $formattedDate,
                'date_raw' => $releaseNote->release_date->format('Y-m-d'),
                'is_current' => $releaseNote->is_current,
                'items' => $releaseNote->items->map(function ($item) {
                    return [
                        'type' => $item->type,
                        'description' => $item->description,
                        'link' => $item->link,
                    ];
                })->toArray(),
            ];
        })->toArray();

        // Si no hay datos en BD, usar datos por defecto (fallback)
        if (empty($versions)) {
            $versions = [
                [
                    'version' => '3.8.0',
                    'date' => '8 de enero, 2026',
                    'date_raw' => '2026-01-08',
                    'is_current' => true,
                    'items' => [
                        ['type' => 'new', 'description' => 'Sistema de Ticker (anuncios deslizantes) para páginas públicas'],
                        ['type' => 'fix', 'description' => 'Mejoras en el sistema de tickets y gestión de estados'],
                        ['type' => 'fix', 'description' => 'Correcciones en la visualización de enlaces internos en sliders'],
                    ]
                ],
            ];
        }

        return view('public::release-notes.index', compact('versions'));
    }
}
