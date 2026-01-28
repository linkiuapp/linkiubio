<?php

namespace App\Features\SuperLinkiu\Controllers\PersonalFinance;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\PersonalFinance\Debt;
use App\Features\SuperLinkiu\Models\PersonalFinance\Account;
use App\Features\SuperLinkiu\Services\PersonalFinance\DebtCalculationService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class DebtController extends Controller
{
    protected DebtCalculationService $calculationService;

    public function __construct(DebtCalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    public function index(Request $request)
    {
        $query = Debt::where('user_id', auth()->id())
            ->with(['account', 'installments']);

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('account_id')) {
            $query->where('account_id', $request->account_id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $debts = $query->orderBy('start_date', 'desc')->paginate(15)->withQueryString();
        $accounts = Account::where('user_id', auth()->id())->where('is_active', true)->get();

        return view('superlinkiu::personal-finance.debts.index', compact('debts', 'accounts'));
    }

    public function create()
    {
        $accounts = Account::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        return view('superlinkiu::personal-finance.debts.create', compact('accounts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_id' => 'nullable|exists:personal_finance_accounts,id',
            'description' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:0',
            'installment_amount' => 'nullable|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'interest_included' => 'boolean',
            'total_installments' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'payment_frequency' => 'required|in:monthly,biweekly,weekly,daily',
            'auto_calculate_installments' => 'boolean',
        ]);

        // Si se especifica monto de cuota, calcular el total automáticamente
        if (!empty($validated['installment_amount']) && $validated['total_installments'] > 0) {
            $validated['total_amount'] = $validated['installment_amount'] * $validated['total_installments'];
        } elseif (empty($validated['total_amount'])) {
            return redirect()->back()
                ->withErrors(['total_amount' => 'Debes especificar el monto total o el monto de la cuota'])
                ->withInput();
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'active';
        $validated['paid_installments'] = 0;
        $validated['auto_calculate_installments'] = $validated['auto_calculate_installments'] ?? true;
        $validated['interest_included'] = $validated['interest_included'] ?? false;

        $debt = Debt::create($validated);

        // Crear cuotas automáticamente si está habilitado
        if ($validated['auto_calculate_installments']) {
            $this->calculationService->generateInstallments($debt);
        }

        return redirect()->route('superlinkiu.personal-finance.debts.show', $debt)
            ->with('success', 'Deuda creada exitosamente');
    }

    public function show(Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }

        $debt->load(['account', 'installments' => function($query) {
            $query->orderBy('installment_number');
        }, 'reminders']);

        return view('superlinkiu::personal-finance.debts.show', compact('debt'));
    }

    public function edit(Debt $debt)
    {
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }

        $accounts = Account::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        return view('superlinkiu::personal-finance.debts.edit', compact('debt', 'accounts'));
    }

    public function update(Request $request, Debt $debt): RedirectResponse
    {
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'account_id' => 'nullable|exists:personal_finance_accounts,id',
            'description' => 'nullable|string',
            'total_amount' => 'nullable|numeric|min:0',
            'installment_amount' => 'nullable|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'interest_included' => 'boolean',
            'status' => 'required|in:active,paid,cancelled,overdue',
        ]);

        // Si se especifica monto de cuota, calcular el total automáticamente
        if (!empty($validated['installment_amount']) && $debt->total_installments > 0) {
            $validated['total_amount'] = $validated['installment_amount'] * $debt->total_installments;
        } elseif (empty($validated['total_amount'])) {
            $validated['total_amount'] = $debt->total_amount; // Mantener el valor actual
        }

        $validated['interest_included'] = $validated['interest_included'] ?? false;

        // Si cambió interest_included y hay cuotas pendientes, regenerarlas
        $interestIncludedChanged = $debt->interest_included != $validated['interest_included'];
        $hasPendingInstallments = $debt->installments()->where('status', 'pending')->exists();

        $debt->update($validated);

        // Regenerar cuotas si cambió el interés incluido y hay cuotas pendientes
        if ($interestIncludedChanged && $hasPendingInstallments) {
            // Eliminar cuotas pendientes
            $debt->installments()->where('status', 'pending')->delete();
            // Resetear contador de cuotas pagadas
            $debt->update(['paid_installments' => $debt->installments()->where('status', 'paid')->count()]);
            // Regenerar cuotas
            $this->calculationService->generateInstallments($debt);
        }

        return redirect()->route('superlinkiu.personal-finance.debts.show', $debt)
            ->with('success', 'Deuda actualizada exitosamente' . ($interestIncludedChanged && $hasPendingInstallments ? '. Las cuotas pendientes han sido regeneradas.' : ''));
    }

    public function destroy(Debt $debt): RedirectResponse
    {
        if ($debt->user_id !== auth()->id()) {
            abort(403);
        }

        // Solo permitir eliminar si no tiene pagos realizados
        if ($debt->installments()->where('status', 'paid')->exists()) {
            return back()->withErrors([
                'error' => 'No se puede eliminar una deuda con pagos realizados'
            ]);
        }

        $debt->installments()->delete();
        $debt->delete();

        return redirect()->route('superlinkiu.personal-finance.debts.index')
            ->with('success', 'Deuda eliminada exitosamente');
    }
}
