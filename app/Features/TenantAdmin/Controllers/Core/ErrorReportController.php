<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\ErrorReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ErrorReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'screenshot' => 'nullable|image|max:5120', // 5MB
            'page_url' => 'nullable|url|max:500',
        ]);

        $store = $request->user()->store;
        $screenshotPath = null;

        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store(
                "error-reports/{$store->id}",
                'public'
            );
        }

        $errorReport = ErrorReport::create([
            'store_id' => $store->id,
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'screenshot_path' => $screenshotPath,
            'page_url' => $request->page_url ?? url()->previous(),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Reporte enviado! Revisaremos el error lo antes posible.',
            'report' => $errorReport,
        ]);
    }

    /**
     * Crear reporte de error sin autenticación (para errores 500 del sistema)
     */
    public function storePublic(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'screenshot' => 'nullable|image|max:5120',
            'page_url' => 'nullable|url|max:500',
            'error_message' => 'nullable|string|max:1000',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store(
                'error-reports/system',
                'public'
            );
        }

        // Intentar obtener store_id y user_id si hay autenticación
        $storeId = null;
        $userId = null;
        
        if (auth()->check()) {
            $userId = auth()->id();
            if (auth()->user()->store) {
                $storeId = auth()->user()->store->id;
            }
        }

        // Si no hay store_id, crear un reporte especial en los logs
        // ya que la tabla requiere store_id y user_id
        if (!$storeId || !$userId) {
            Log::error('Error Report (Sin Store/User)', [
                'title' => $request->title,
                'description' => $request->description,
                'error_message' => $request->error_message,
                'page_url' => $request->page_url ?? request()->fullUrl(),
                'screenshot' => $screenshotPath,
                'user_id' => $userId,
                'store_id' => $storeId,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Reporte enviado! Revisaremos el error lo antes posible.',
            ]);
        }

        // Si hay store_id y user_id, crear el reporte normalmente
        $errorReport = ErrorReport::create([
            'store_id' => $storeId,
            'user_id' => $userId,
            'title' => $request->title,
            'description' => $request->description . ($request->error_message ? "\n\nError técnico: " . $request->error_message : ''),
            'screenshot_path' => $screenshotPath,
            'page_url' => $request->page_url ?? request()->fullUrl(),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Reporte enviado! Revisaremos el error lo antes posible.',
            'report' => $errorReport,
        ]);
    }
}
