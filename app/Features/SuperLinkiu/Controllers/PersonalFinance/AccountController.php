<?php

namespace App\Features\SuperLinkiu\Controllers\PersonalFinance;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\PersonalFinance\Account;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $accounts = Account::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('superlinkiu::personal-finance.accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('superlinkiu::personal-finance.accounts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,credit_card,loan,other',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'current_balance' => 'nullable|numeric|min:0',
            'credit_limit' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'color' => 'nullable|string|size:7',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['current_balance'] = $validated['current_balance'] ?? 0;
        $validated['currency'] = $validated['currency'] ?? 'COP';
        $validated['color'] = $validated['color'] ?? '#3B82F6';

        Account::create($validated);

        return redirect()->route('superlinkiu.personal-finance.accounts.index')
            ->with('success', 'Cuenta creada exitosamente');
    }

    public function show(Account $account)
    {
        if ($account->user_id !== auth()->id()) {
            abort(403);
        }

        $account->load(['debts.installments', 'payments', 'transactions']);

        return view('superlinkiu::personal-finance.accounts.show', compact('account'));
    }

    public function edit(Account $account)
    {
        if ($account->user_id !== auth()->id()) {
            abort(403);
        }

        return view('superlinkiu::personal-finance.accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account): RedirectResponse
    {
        if ($account->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,credit_card,loan,other',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'current_balance' => 'nullable|numeric',
            'credit_limit' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
            'color' => 'nullable|string|size:7',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $account->update($validated);

        return redirect()->route('superlinkiu.personal-finance.accounts.index')
            ->with('success', 'Cuenta actualizada exitosamente');
    }

    public function destroy(Account $account): RedirectResponse
    {
        if ($account->user_id !== auth()->id()) {
            abort(403);
        }

        // Validar que no tenga deudas activas
        if ($account->debts()->where('status', 'active')->exists()) {
            return back()->withErrors([
                'error' => 'No se puede eliminar una cuenta con deudas activas'
            ]);
        }

        $account->delete();

        return redirect()->route('superlinkiu.personal-finance.accounts.index')
            ->with('success', 'Cuenta eliminada exitosamente');
    }
}
