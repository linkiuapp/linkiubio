<?php

namespace App\Features\SuperLinkiu\Controllers\PersonalFinance;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\PersonalFinance\Transaction;
use App\Features\SuperLinkiu\Models\PersonalFinance\Account;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = Transaction::where('user_id', $userId)
            ->with('account')
            ->orderBy('transaction_date', 'desc');

        // Filtros
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('account_id')) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }

        $transactions = $query->paginate(20)->withQueryString();
        $accounts = Account::where('user_id', $userId)->where('is_active', true)->get();

        // Obtener categorías únicas para filtro
        $categories = Transaction::where('user_id', $userId)
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        // Estadísticas
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $totalExpenses = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        return view('superlinkiu::personal-finance.transactions.index', compact(
            'transactions',
            'accounts',
            'categories',
            'totalIncome',
            'totalExpenses'
        ));
    }

    public function create()
    {
        $accounts = Account::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        return view('superlinkiu::personal-finance.transactions.create', compact('accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:personal_finance_accounts,id',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'payment_method' => 'required|in:transfer,cash,account_bank,card,nequi,daviplata,other',
            'receipt_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'tags' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        // Subir imagen de soporte si existe
        if ($request->hasFile('receipt_file')) {
            $validated['receipt_file'] = $request->file('receipt_file')->store('personal-finance/receipts', 'public');
        }

        // Convertir tags de string separado por comas a array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = array_filter($validated['tags']); // Eliminar vacíos
        } else {
            $validated['tags'] = null;
        }

        // Asegurar que receipt_file sea null si no se subió archivo
        if (!isset($validated['receipt_file'])) {
            $validated['receipt_file'] = null;
        }

        $transaction = Transaction::create($validated);

        // Actualizar saldo de la cuenta
        $account = Account::find($validated['account_id']);
        if ($account) {
            if ($validated['type'] === 'income') {
                $account->increment('current_balance', $validated['amount']);
            } else {
                $account->decrement('current_balance', $validated['amount']);
            }
        }

        return redirect()->route('superlinkiu.personal-finance.transactions.index')
            ->with('success', 'Transacción registrada exitosamente');
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $accounts = Account::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        return view('superlinkiu::personal-finance.transactions.edit', compact('transaction', 'accounts'));
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'account_id' => 'required|exists:personal_finance_accounts,id',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'payment_method' => 'required|in:transfer,cash,account_bank,card,nequi,daviplata,other',
            'receipt_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'tags' => 'nullable|string',
        ]);

        // Subir nueva imagen de soporte si existe
        if ($request->hasFile('receipt_file')) {
            // Eliminar archivo anterior si existe
            if ($transaction->receipt_file) {
                \Storage::disk('public')->delete($transaction->receipt_file);
            }
            $validated['receipt_file'] = $request->file('receipt_file')->store('personal-finance/receipts', 'public');
        } else {
            // Mantener el archivo actual si no se sube uno nuevo
            $validated['receipt_file'] = $transaction->receipt_file;
        }

        // Convertir tags de string separado por comas a array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
            $validated['tags'] = array_filter($validated['tags']); // Eliminar vacíos
        } else {
            $validated['tags'] = null;
        }

        // Revertir saldo anterior
        $oldAccount = Account::find($transaction->account_id);
        if ($oldAccount) {
            if ($transaction->type === 'income') {
                $oldAccount->decrement('current_balance', $transaction->amount);
            } else {
                $oldAccount->increment('current_balance', $transaction->amount);
            }
        }

        $transaction->update($validated);

        // Aplicar nuevo saldo
        $newAccount = Account::find($validated['account_id']);
        if ($newAccount) {
            if ($validated['type'] === 'income') {
                $newAccount->increment('current_balance', $validated['amount']);
            } else {
                $newAccount->decrement('current_balance', $validated['amount']);
            }
        }

        return redirect()->route('superlinkiu.personal-finance.transactions.index')
            ->with('success', 'Transacción actualizada exitosamente');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        // Revertir saldo
        $account = Account::find($transaction->account_id);
        if ($account) {
            if ($transaction->type === 'income') {
                $account->decrement('current_balance', $transaction->amount);
            } else {
                $account->increment('current_balance', $transaction->amount);
            }
        }

        $transaction->delete();

        return redirect()->route('superlinkiu.personal-finance.transactions.index')
            ->with('success', 'Transacción eliminada exitosamente');
    }
}
