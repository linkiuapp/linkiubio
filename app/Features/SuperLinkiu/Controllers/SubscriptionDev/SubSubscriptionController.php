<?php

namespace App\Features\SuperLinkiu\Controllers\SubscriptionDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\SubClient;
use App\Features\SuperLinkiu\Models\SubServiceType;
use App\Features\SuperLinkiu\Models\SubSubscription;
use App\Features\SuperLinkiu\Services\SubscriptionDev\SubWhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = SubSubscription::with(['client', 'serviceType']);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('period')) {
            $query->byPeriod($request->period);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $subscriptions = $query->orderBy('next_billing_date')->paginate(20)->withQueryString();

        $stats = [
            'total' => SubSubscription::count(),
            'active' => SubSubscription::active()->count(),
            'pending' => SubSubscription::pendingPayment()->count(),
            'expired' => SubSubscription::expired()->count(),
        ];

        $clients = SubClient::active()->orderBy('name')->get();
        $statuses = SubSubscription::getStatuses();
        $periods = SubSubscription::getPeriods();

        return view('superlinkiu::subscriptiondev.subscriptions.index', compact(
            'subscriptions', 'stats', 'clients', 'statuses', 'periods'
        ));
    }

    public function create(Request $request)
    {
        $clients = SubClient::active()->orderBy('name')->get();
        $serviceTypes = SubServiceType::active()->ordered()->get();
        $periods = SubSubscription::getPeriods();

        $selectedClient = null;
        if ($request->filled('client_id')) {
            $selectedClient = SubClient::find($request->client_id);
        }

        return view('superlinkiu::subscriptiondev.subscriptions.create', compact(
            'clients', 'serviceTypes', 'periods', 'selectedClient'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:sub_clients,id',
            'service_type_id' => 'nullable|exists:sub_service_types,id',
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'billing_period' => 'required|in:monthly,quarterly,semiannual,annual',
            'start_date' => 'required|date',
            'next_billing_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string|max:1000',
            'auto_remind' => 'boolean',
        ]);

        $validated['auto_remind'] = $request->boolean('auto_remind', true);
        $validated['status'] = 'active';

        $subscription = SubSubscription::create($validated);

        Log::info('SubscriptionDev: Suscripción creada', [
            'subscription_id' => $subscription->id,
            'client_id' => $subscription->client_id
        ]);

        return redirect()
            ->route('superlinkiu.subscriptiondev.subscriptions.show', $subscription)
            ->with('success', 'Suscripción creada correctamente.');
    }

    public function show(SubSubscription $subscription)
    {
        $subscription->load([
            'client', 
            'serviceType', 
            'payments' => fn($q) => $q->orderBy('created_at', 'desc'),
            'reminders' => fn($q) => $q->orderBy('created_at', 'desc')->take(10)
        ]);

        return view('superlinkiu::subscriptiondev.subscriptions.show', compact('subscription'));
    }

    public function edit(SubSubscription $subscription)
    {
        $clients = SubClient::active()->orderBy('name')->get();
        $serviceTypes = SubServiceType::active()->ordered()->get();
        $periods = SubSubscription::getPeriods();
        $statuses = SubSubscription::getStatuses();

        return view('superlinkiu::subscriptiondev.subscriptions.edit', compact(
            'subscription', 'clients', 'serviceTypes', 'periods', 'statuses'
        ));
    }

    public function update(Request $request, SubSubscription $subscription)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:sub_clients,id',
            'service_type_id' => 'nullable|exists:sub_service_types,id',
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'billing_period' => 'required|in:monthly,quarterly,semiannual,annual',
            'start_date' => 'required|date',
            'next_billing_date' => 'required|date',
            'status' => 'required|in:active,pending_payment,expired,cancelled',
            'notes' => 'nullable|string|max:1000',
            'auto_remind' => 'boolean',
        ]);

        $validated['auto_remind'] = $request->boolean('auto_remind');

        $subscription->update($validated);

        Log::info('SubscriptionDev: Suscripción actualizada', ['subscription_id' => $subscription->id]);

        return redirect()
            ->route('superlinkiu.subscriptiondev.subscriptions.show', $subscription)
            ->with('success', 'Suscripción actualizada correctamente.');
    }

    public function destroy(SubSubscription $subscription)
    {
        $serviceName = $subscription->service_name;
        $subscription->delete();

        Log::info('SubscriptionDev: Suscripción eliminada', ['service_name' => $serviceName]);

        return redirect()
            ->route('superlinkiu.subscriptiondev.subscriptions.index')
            ->with('success', "Suscripción '{$serviceName}' eliminada correctamente.");
    }

    /**
     * Enviar recordatorio manual
     */
    public function sendReminder(SubSubscription $subscription)
    {
        try {
            $whatsappService = app(SubWhatsAppService::class);
            $result = $whatsappService->sendPaymentReminder($subscription);

            if ($result) {
                return back()->with('success', 'Recordatorio enviado correctamente.');
            } else {
                return back()->with('error', 'Error al enviar el recordatorio.');
            }
        } catch (\Exception $e) {
            Log::error('SubscriptionDev: Error enviando recordatorio manual', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Generar pago pendiente
     */
    public function generatePayment(SubSubscription $subscription)
    {
        // Verificar si ya tiene un pago pendiente
        $pendingPayment = $subscription->payments()->pending()->first();

        if ($pendingPayment) {
            return back()->with('info', 'Ya existe un pago pendiente para esta suscripción.');
        }

        $payment = $subscription->createPayment();

        Log::info('SubscriptionDev: Pago generado', [
            'subscription_id' => $subscription->id,
            'payment_id' => $payment->id
        ]);

        return back()->with('success', 'Pago pendiente generado correctamente.');
    }

    /**
     * Renovar suscripción manualmente (marcar como pagado)
     */
    public function renew(SubSubscription $subscription)
    {
        $subscription->renewSubscription();

        Log::info('SubscriptionDev: Suscripción renovada manualmente', [
            'subscription_id' => $subscription->id
        ]);

        return back()->with('success', 'Suscripción renovada correctamente.');
    }
}
