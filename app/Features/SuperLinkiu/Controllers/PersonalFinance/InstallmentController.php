<?php

namespace App\Features\SuperLinkiu\Controllers\PersonalFinance;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\PersonalFinance\Installment;
use App\Features\SuperLinkiu\Models\PersonalFinance\Account;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class InstallmentController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = Installment::with(['debt.account'])
            ->whereHas('debt', function($q) use ($userId) {
                $q->where('user_id', $userId);
            });

        // Filtros
        if ($request->filled('status')) {
            if ($request->status === 'overdue') {
                $query->where(function($q) {
                    $q->where('status', 'overdue')
                      ->orWhere(function($q2) {
                          $q2->where('status', 'pending')
                             ->where('due_date', '<', now());
                      });
                });
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('account_id')) {
            $query->whereHas('debt', function($q) use ($request) {
                $q->where('account_id', $request->account_id);
            });
        }

        // Próximos vencimientos por defecto
        if (!$request->filled('status')) {
            $query->where('status', 'pending')
                  ->whereBetween('due_date', [now(), now()->addDays(30)]);
        }

        $installments = $query->orderBy('due_date', 'asc')->paginate(20)->withQueryString();
        $accounts = Account::where('user_id', $userId)->where('is_active', true)->get();

        return view('superlinkiu::personal-finance.installments.index', compact('installments', 'accounts'));
    }

    public function markAsPaid(Request $request, Installment $installment): RedirectResponse
    {
        if ($installment->debt->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:' . $installment->amount,
            'payment_date' => 'required|date',
            'account_id' => 'required|exists:personal_finance_accounts,id',
            'payment_method' => 'required|in:transfer,cash,account_bank,nequi,daviplata,other',
            'reference_number' => 'nullable|string|max:255',
            'receipt_file' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:5120',
            'notes' => 'nullable|string',
        ]);

        // Marcar cuota como pagada
        $installment->markAsPaid(
            $validated['payment_method'],
            Carbon::parse($validated['payment_date'])
        );

        // Subir imagen de soporte si existe
        $receiptPath = null;
        if ($request->hasFile('receipt_file')) {
            $receiptPath = $request->file('receipt_file')->store('personal-finance/receipts', 'public');
        }

        // Crear registro de pago
        $payment = \App\Features\SuperLinkiu\Models\PersonalFinance\Payment::create([
            'user_id' => auth()->id(),
            'installment_id' => $installment->id,
            'account_id' => $validated['account_id'],
            'amount' => $validated['amount'],
            'payment_date' => $validated['payment_date'],
            'payment_method' => $validated['payment_method'],
            'reference_number' => $validated['reference_number'] ?? null,
            'receipt_file' => $receiptPath,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Actualizar saldo de la cuenta (disminuir porque es un pago/gasto)
        $account = Account::find($validated['account_id']);
        if ($account) {
            $account->decrement('current_balance', $validated['amount']);
        }

        return redirect()->back()
            ->with('success', 'Cuota marcada como pagada exitosamente');
    }
}
