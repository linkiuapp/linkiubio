<?php

namespace App\Features\SuperLinkiu\Controllers\SubscriptionDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\SubPayment;
use App\Features\SuperLinkiu\Models\SubSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = SubPayment::with(['subscription.client', 'subscription.serviceType']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('subscription_id')) {
            $query->where('subscription_id', $request->subscription_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $stats = [
            'total' => SubPayment::count(),
            'pending' => SubPayment::pending()->count(),
            'paid' => SubPayment::paid()->count(),
            'total_collected' => SubPayment::paid()->sum('amount'),
            'pending_amount' => SubPayment::pending()->sum('amount'),
        ];

        return view('superlinkiu::subscriptiondev.payments.index', compact('payments', 'stats'));
    }

    public function show(SubPayment $payment)
    {
        $payment->load(['subscription.client', 'subscription.serviceType', 'reminders']);

        return view('superlinkiu::subscriptiondev.payments.show', compact('payment'));
    }

    /**
     * Marcar pago como pagado manualmente
     */
    public function markAsPaid(Request $request, SubPayment $payment)
    {
        $validated = $request->validate([
            'payment_method' => 'nullable|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment->markAsPaid(
            $validated['payment_method'] ?? 'manual',
            $validated['payment_reference'] ?? null
        );

        if ($validated['notes'] ?? null) {
            $payment->update(['notes' => $validated['notes']]);
        }

        Log::info('SubscriptionDev: Pago marcado como pagado manualmente', [
            'payment_id' => $payment->id
        ]);

        return back()->with('success', 'Pago marcado como pagado correctamente.');
    }

    /**
     * Cancelar pago
     */
    public function cancel(SubPayment $payment)
    {
        if ($payment->status === 'paid') {
            return back()->with('error', 'No se puede cancelar un pago que ya fue procesado.');
        }

        $payment->update(['status' => 'cancelled']);

        Log::info('SubscriptionDev: Pago cancelado', ['payment_id' => $payment->id]);

        return back()->with('success', 'Pago cancelado correctamente.');
    }
}
