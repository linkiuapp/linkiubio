<?php

namespace App\Features\TenantAdmin\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\ErrorReport;
use Illuminate\Http\Request;

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
}
