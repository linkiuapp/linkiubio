<?php

namespace App\Features\SuperLinkiu\Controllers\PersonalFinance;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\PersonalFinance\Account;
use App\Features\SuperLinkiu\Models\PersonalFinance\Debt;
use App\Features\SuperLinkiu\Models\PersonalFinance\Installment;
use App\Features\SuperLinkiu\Models\PersonalFinance\Payment;
use App\Features\SuperLinkiu\Models\PersonalFinance\Transaction;
use App\Features\SuperLinkiu\Models\PersonalFinance\AccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Total adeudado (suma de cuotas pendientes)
        // IMPORTANTE: Esto suma TODAS las cuotas pendientes de TODAS las deudas activas
        // Si una deuda de $84,000 se divide en múltiples cuotas, todas las cuotas pendientes se suman
        $totalOwed = Installment::whereHas('debt', function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'active');
        })
        ->where('status', 'pending')
        ->sum('amount');

        // Total pagado este mes
        $totalPaidThisMonth = Payment::where('user_id', $userId)
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        // Próximos vencimientos (próximos 7 días)
        $upcomingDue = Installment::whereHas('debt', function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'active');
        })
        ->where('status', 'pending')
        ->whereBetween('due_date', [now(), now()->addDays(7)])
        ->count();

        // Cuotas vencidas
        $overdueCount = Installment::whereHas('debt', function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'active');
        })
        ->where('status', 'pending')
        ->where('due_date', '<', now())
        ->count();

        // Próximos pagos (próximos 7 días)
        $upcomingPayments = Installment::with(['debt'])
            ->whereHas('debt', function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('status', 'active');
            })
            ->where('status', 'pending')
            ->whereBetween('due_date', [now(), now()->addDays(7)])
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        // Resumen por cuenta bancaria
        $accountsSummary = Account::where('user_id', $userId)
            ->where('is_active', true)
            ->withCount(['debts' => function($query) {
                $query->where('status', 'active');
            }])
            ->get()
            ->map(function($account) {
                // Calcular total de cuotas pendientes de deudas vinculadas
                $account->linked_debts_total = Installment::whereHas('debt', function($query) use ($account) {
                    $query->where('account_id', $account->id)
                          ->where('status', 'active');
                })
                ->where('status', 'pending')
                ->sum('amount');
                
                // Contar deudas activas vinculadas
                $account->linked_debts_count = Debt::where('account_id', $account->id)
                    ->where('user_id', $account->user_id)
                    ->where('status', 'active')
                    ->count();
                
                return $account;
            });

        // Deudas activas
        $activeDebts = Debt::where('user_id', $userId)
            ->where('status', 'active')
            ->with(['account', 'installments'])
            ->orderBy('start_date', 'desc')
            ->limit(5)
            ->get();

        // Desglose del total adeudado por deuda (para debugging)
        $totalOwedBreakdown = Debt::where('user_id', $userId)
            ->where('status', 'active')
            ->with(['installments' => function($query) {
                $query->where('status', 'pending');
            }])
            ->get()
            ->map(function($debt) {
                $pendingAmount = $debt->installments->sum('amount');
                return [
                    'debt_name' => $debt->name,
                    'total_amount' => $debt->total_amount,
                    'pending_installments' => $debt->installments->count(),
                    'pending_amount' => $pendingAmount,
                ];
            });

        // Pagos recientes
        $recentPayments = Payment::where('user_id', $userId)
            ->with(['installment.debt', 'account'])
            ->orderBy('payment_date', 'desc')
            ->limit(10)
            ->get();

        // Ingresos y gastos del mes
        $monthlyIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $monthlyExpenses = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        // Transacciones recientes
        $recentTransactions = Transaction::where('user_id', $userId)
            ->with('account')
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        // Token de acceso rápido (el más reciente activo)
        $accessToken = AccessToken::where('user_id', $userId)
            ->valid()
            ->orderBy('created_at', 'desc')
            ->first();

        return view('superlinkiu::personal-finance.dashboard', compact(
            'totalOwed',
            'totalPaidThisMonth',
            'upcomingDue',
            'overdueCount',
            'upcomingPayments',
            'accountsSummary',
            'activeDebts',
            'recentPayments',
            'totalOwedBreakdown',
            'monthlyIncome',
            'monthlyExpenses',
            'recentTransactions',
            'accessToken'
        ));
    }

    /**
     * Generar nuevo token de acceso rápido
     */
    public function generateAccessToken(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'days_valid' => 'nullable|integer|min:1|max:365',
        ]);

        $token = AccessToken::generate(
            auth()->id(),
            $validated['name'] ?? 'Acceso rápido móvil',
            $validated['days_valid'] ?? null
        );

        return redirect()->route('superlinkiu.personal-finance.dashboard')
            ->with('success', 'Token de acceso generado exitosamente')
            ->with('new_token', $token->token);
    }

    /**
     * Revocar token de acceso
     */
    public function revokeAccessToken(AccessToken $accessToken)
    {
        if ($accessToken->user_id !== auth()->id()) {
            abort(403);
        }

        $accessToken->update(['is_active' => false]);

        return redirect()->route('superlinkiu.personal-finance.dashboard')
            ->with('success', 'Token revocado exitosamente');
    }
}
