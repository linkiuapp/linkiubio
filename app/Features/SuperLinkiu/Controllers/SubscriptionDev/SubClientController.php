<?php

namespace App\Features\SuperLinkiu\Controllers\SubscriptionDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\SubClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubClientController extends Controller
{
    public function index(Request $request)
    {
        $query = SubClient::withCount(['subscriptions', 'activeSubscriptions']);

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $clients = $query->orderBy('name')->paginate(20)->withQueryString();

        $stats = [
            'total' => SubClient::count(),
            'active' => SubClient::active()->count(),
            'with_subscriptions' => SubClient::has('subscriptions')->count(),
        ];

        return view('superlinkiu::subscriptiondev.clients.index', compact('clients', 'stats'));
    }

    public function create()
    {
        return view('superlinkiu::subscriptiondev.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'required|string|max:5',
            'document_type' => 'nullable|string|max:10',
            'document' => 'nullable|string|max:30',
            'notes' => 'nullable|string|max:1000',
        ]);

        $client = SubClient::create($validated);

        Log::info('SubscriptionDev: Cliente creado', ['client_id' => $client->id]);

        return redirect()
            ->route('superlinkiu.subscriptiondev.clients.show', $client)
            ->with('success', 'Cliente creado correctamente.');
    }

    public function show(SubClient $client)
    {
        $client->load(['subscriptions.serviceType', 'subscriptions.payments' => function ($q) {
            $q->orderBy('created_at', 'desc')->take(5);
        }]);

        return view('superlinkiu::subscriptiondev.clients.show', compact('client'));
    }

    public function edit(SubClient $client)
    {
        return view('superlinkiu::subscriptiondev.clients.edit', compact('client'));
    }

    public function update(Request $request, SubClient $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'required|string|max:5',
            'document_type' => 'nullable|string|max:10',
            'document' => 'nullable|string|max:30',
            'notes' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $client->update($validated);

        Log::info('SubscriptionDev: Cliente actualizado', ['client_id' => $client->id]);

        return redirect()
            ->route('superlinkiu.subscriptiondev.clients.show', $client)
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(SubClient $client)
    {
        if ($client->subscriptions()->exists()) {
            return back()->with('error', 'No se puede eliminar el cliente porque tiene suscripciones asociadas.');
        }

        $clientName = $client->name;
        $client->delete();

        Log::info('SubscriptionDev: Cliente eliminado', ['client_name' => $clientName]);

        return redirect()
            ->route('superlinkiu.subscriptiondev.clients.index')
            ->with('success', "Cliente '{$clientName}' eliminado correctamente.");
    }
}
