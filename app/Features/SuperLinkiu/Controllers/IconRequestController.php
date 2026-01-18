<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IconRequest;
use App\Models\ErrorReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IconRequestController extends Controller
{
    public function iconRequests()
    {
        $requests = IconRequest::with(['store', 'user', 'businessCategory', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('superlinkiu::Tools.icon-requests', compact('requests'));
    }

    public function approve(IconRequest $request)
    {
        $request->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Enviar notificación al tenant admin
        event(new \App\Events\IconRequestApproved($request));

        return redirect()->back()->with('success', 'Solicitud aprobada. El ícono debe ser subido manualmente en Categorías Globales.');
    }

    public function reject(IconRequest $request)
    {
        $validatedData = request()->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $request->update([
            'status' => 'rejected',
            'rejection_reason' => $validatedData['rejection_reason'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Solicitud rechazada.');
    }

    public function errorReports()
    {
        $reports = ErrorReport::with(['store', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('superlinkiu::Tools.error-reports', compact('reports'));
    }

    public function updateErrorStatus(ErrorReport $report, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed',
        ]);

        $oldStatus = $report->status;
        
        $updateData = [
            'status' => $request->status,
        ];

        // Si cambió a "resolved", actualizar resolved_at y resolved_by
        if ($request->status === 'resolved' && $oldStatus !== 'resolved') {
            $updateData['resolved_at'] = now();
            $updateData['resolved_by'] = auth()->id();
        }

        $report->update($updateData);

        // Si cambió a "resolved", enviar notificación al tenant
        if ($request->status === 'resolved' && $oldStatus !== 'resolved') {
            event(new \App\Events\ErrorReportResolved($report));
        }

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }

    public function deleteErrorReport(ErrorReport $report)
    {
        if ($report->screenshot_path) {
            Storage::disk('public')->delete($report->screenshot_path);
        }

        $report->delete();

        return redirect()->back()->with('success', 'Reporte eliminado correctamente.');
    }
}
