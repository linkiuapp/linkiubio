<?php

namespace App\Features\SuperLinkiu\Controllers\PersonalFinance;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\PersonalFinance\Reminder;
use App\Features\SuperLinkiu\Models\PersonalFinance\Debt;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ReminderController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Recordatorios globales (para todas las deudas)
        $globalReminders = Reminder::where('user_id', $userId)
            ->whereNull('debt_id')
            ->get();

        // Recordatorios por deuda específica
        $debtReminders = Reminder::where('user_id', $userId)
            ->whereNotNull('debt_id')
            ->with('debt')
            ->get()
            ->groupBy('debt_id');

        $debts = Debt::where('user_id', $userId)
            ->where('status', 'active')
            ->get();

        return view('superlinkiu::personal-finance.reminders.index', compact(
            'globalReminders',
            'debtReminders',
            'debts'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'debt_id' => 'nullable|exists:personal_finance_debts,id',
            'reminder_days_before' => 'required|integer|min:1|max:30',
            'notification_method' => 'required|in:email,whatsapp,both',
            'phone_numbers' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_active'] = $validated['is_active'] ?? true;

        // Convertir phone_numbers de string separado por comas a array
        if (!empty($validated['phone_numbers'])) {
            $validated['phone_numbers'] = array_map('trim', explode(',', $validated['phone_numbers']));
            $validated['phone_numbers'] = array_filter($validated['phone_numbers']); // Eliminar vacíos
        } else {
            $validated['phone_numbers'] = null;
        }

        Reminder::create($validated);

        return redirect()->route('superlinkiu.personal-finance.reminders.index')
            ->with('success', 'Recordatorio configurado exitosamente');
    }

    public function update(Request $request, Reminder $reminder): RedirectResponse
    {
        if ($reminder->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'reminder_days_before' => 'required|integer|min:1|max:30',
            'notification_method' => 'required|in:email,whatsapp,both',
            'phone_numbers' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Convertir phone_numbers de string separado por comas a array
        if (!empty($validated['phone_numbers'])) {
            $validated['phone_numbers'] = array_map('trim', explode(',', $validated['phone_numbers']));
            $validated['phone_numbers'] = array_filter($validated['phone_numbers']);
        } else {
            $validated['phone_numbers'] = null;
        }

        $reminder->update($validated);

        return redirect()->route('superlinkiu.personal-finance.reminders.index')
            ->with('success', 'Recordatorio actualizado exitosamente');
    }

    public function destroy(Reminder $reminder): RedirectResponse
    {
        if ($reminder->user_id !== auth()->id()) {
            abort(403);
        }

        $reminder->delete();

        return redirect()->route('superlinkiu.personal-finance.reminders.index')
            ->with('success', 'Recordatorio eliminado exitosamente');
    }
}
