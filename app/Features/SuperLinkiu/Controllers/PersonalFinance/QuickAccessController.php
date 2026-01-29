<?php

namespace App\Features\SuperLinkiu\Controllers\PersonalFinance;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\PersonalFinance\AccessToken;
use App\Features\SuperLinkiu\Models\PersonalFinance\Account;
use App\Features\SuperLinkiu\Models\PersonalFinance\Installment;
use App\Features\SuperLinkiu\Models\PersonalFinance\Transaction;
use App\Features\SuperLinkiu\Models\PersonalFinance\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuickAccessController extends Controller
{
    /**
     * Mostrar vista pública mobile
     */
    public function show(Request $request, string $code)
    {
        // Buscar por código corto (más común) o por token completo (compatibilidad)
        $accessToken = AccessToken::findByShortCode($code) 
            ?? AccessToken::where('token', $code)->valid()->first();

        if (!$accessToken || !$accessToken->isValid()) {
            abort(404, 'Token de acceso inválido o expirado');
        }

        $user = $accessToken->user;
        $accessToken->recordUsage();

        // Obtener cuentas bancarias activas
        $accounts = Account::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Calcular saldo total disponible
        $totalBalance = $accounts->sum('current_balance');

        // Obtener próximos pagos (próximos 7 días)
        $upcomingInstallments = Installment::with(['debt'])
            ->whereHas('debt', function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->where('status', 'active');
            })
            ->where('status', 'pending')
            ->whereBetween('due_date', [now(), now()->addDays(7)])
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        // Obtener cuotas vencidas
        $overdueInstallments = Installment::with(['debt'])
            ->whereHas('debt', function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->where('status', 'active');
            })
            ->where('status', 'pending')
            ->where('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        // Calcular total a pagar esta semana
        $totalDueThisWeek = $upcomingInstallments->sum('amount') + $overdueInstallments->sum('amount');

        // Últimas transacciones
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        return view('superlinkiu::personal-finance.quick-access', compact(
            'user',
            'accounts',
            'totalBalance',
            'upcomingInstallments',
            'overdueInstallments',
            'totalDueThisWeek',
            'recentTransactions',
            'accessToken'
        ));
    }

    /**
     * Pagar cuota rápidamente
     */
    public function payInstallment(Request $request, string $code)
    {
        $accessToken = AccessToken::findByShortCode($code) 
            ?? AccessToken::where('token', $code)->valid()->first();

        if (!$accessToken || !$accessToken->isValid()) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        $validated = $request->validate([
            'installment_id' => 'required|exists:personal_finance_installments,id',
            'account_id' => 'required|exists:personal_finance_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:transfer,cash,account_bank,nequi,daviplata,other',
        ]);

        $installment = Installment::with('debt')->findOrFail($validated['installment_id']);

        // Verificar que la cuota pertenece al usuario
        if ($installment->debt->user_id !== $accessToken->user_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        DB::beginTransaction();
        try {
            // Marcar cuota como pagada
            $installment->update([
                'status' => 'paid',
                'paid_date' => now(),
                'payment_method' => $validated['payment_method'],
            ]);

            // Crear registro de pago
            Payment::create([
                'installment_id' => $installment->id,
                'account_id' => $validated['account_id'],
                'amount' => $validated['amount'],
                'payment_date' => now(),
                'payment_method' => $validated['payment_method'],
            ]);

            // Actualizar saldo de la cuenta
            $account = Account::findOrFail($validated['account_id']);
            $account->decrement('current_balance', $validated['amount']);

            // Actualizar contador de cuotas pagadas
            $installment->debt->increment('paid_installments');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pago registrado exitosamente',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al procesar el pago'], 500);
        }
    }

    /**
     * Agregar ingreso rápido
     */
    public function addIncome(Request $request, string $code)
    {
        $accessToken = AccessToken::findByShortCode($code) 
            ?? AccessToken::where('token', $code)->valid()->first();

        if (!$accessToken || !$accessToken->isValid()) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:personal_finance_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'transaction_date' => 'nullable|date',
        ]);

        $account = Account::findOrFail($validated['account_id']);

        // Verificar que la cuenta pertenece al usuario
        if ($account->user_id !== $accessToken->user_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $transaction = Transaction::create([
            'user_id' => $accessToken->user_id,
            'account_id' => $validated['account_id'],
            'type' => 'income',
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'transaction_date' => $validated['transaction_date'] ?? now(),
            'payment_method' => 'transfer',
        ]);

        // Actualizar saldo de la cuenta
        $account->increment('current_balance', $validated['amount']);

        return response()->json([
            'success' => true,
            'message' => 'Ingreso agregado exitosamente',
            'transaction' => $transaction,
        ]);
    }

    /**
     * Agregar gasto rápido
     */
    public function addExpense(Request $request, string $token)
    {
        $accessToken = AccessToken::where('token', $token)->valid()->first();

        if (!$accessToken) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:personal_finance_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'transaction_date' => 'nullable|date',
            'payment_method' => 'required|in:transfer,cash,account_bank,nequi,daviplata,other',
        ]);

        $account = Account::findOrFail($validated['account_id']);

        // Verificar que la cuenta pertenece al usuario
        if ($account->user_id !== $accessToken->user_id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $transaction = Transaction::create([
            'user_id' => $accessToken->user_id,
            'account_id' => $validated['account_id'],
            'type' => 'expense',
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'transaction_date' => $validated['transaction_date'] ?? now(),
            'payment_method' => $validated['payment_method'],
        ]);

        // Actualizar saldo de la cuenta
        $account->decrement('current_balance', $validated['amount']);

        return response()->json([
            'success' => true,
            'message' => 'Gasto agregado exitosamente',
            'transaction' => $transaction,
        ]);
    }
}
