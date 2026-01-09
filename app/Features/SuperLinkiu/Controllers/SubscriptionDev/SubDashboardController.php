<?php

namespace App\Features\SuperLinkiu\Controllers\SubscriptionDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\SubClient;
use App\Features\SuperLinkiu\Models\SubSubscription;
use App\Features\SuperLinkiu\Models\SubPayment;
use App\Features\SuperLinkiu\Models\SubServiceType;
use Carbon\Carbon;

class SubDashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_clients' => SubClient::active()->count(),
            'total_subscriptions' => SubSubscription::count(),
            'active_subscriptions' => SubSubscription::active()->count(),
            'pending_payments' => SubSubscription::pendingPayment()->count(),
            'expired' => SubSubscription::expired()->count(),
            'due_this_month' => SubSubscription::dueSoon(30)->count(),
            'total_monthly_revenue' => $this->calculateMonthlyRevenue(),
            'payments_this_month' => SubPayment::paid()->whereMonth('paid_at', now()->month)->sum('amount'),
        ];

        // Suscripciones próximas a vencer (7 días)
        $dueSoon = SubSubscription::with('client')
            ->dueSoon(7)
            ->active()
            ->orderBy('next_billing_date')
            ->take(5)
            ->get();

        // Suscripciones vencidas
        $overdue = SubSubscription::with('client')
            ->overdue()
            ->orderBy('next_billing_date')
            ->take(5)
            ->get();

        // Últimos pagos
        $recentPayments = SubPayment::with('subscription.client')
            ->paid()
            ->orderBy('paid_at', 'desc')
            ->take(5)
            ->get();

        // Suscripciones por estado
        $statusChart = [
            'active' => SubSubscription::active()->count(),
            'pending_payment' => SubSubscription::pendingPayment()->count(),
            'expired' => SubSubscription::expired()->count(),
            'cancelled' => SubSubscription::where('status', 'cancelled')->count(),
        ];

        return view('superlinkiu::subscriptiondev.dashboard.index', compact(
            'stats',
            'dueSoon',
            'overdue',
            'recentPayments',
            'statusChart'
        ));
    }

    protected function calculateMonthlyRevenue(): float
    {
        $total = 0;
        
        $subscriptions = SubSubscription::active()->get();
        
        foreach ($subscriptions as $sub) {
            // Convertir a ingreso mensual equivalente
            $monthlyAmount = match($sub->billing_period) {
                'monthly' => $sub->amount,
                'quarterly' => $sub->amount / 3,
                'semiannual' => $sub->amount / 6,
                'annual' => $sub->amount / 12,
                default => $sub->amount / 12,
            };
            
            $total += $monthlyAmount;
        }
        
        return $total;
    }
}
