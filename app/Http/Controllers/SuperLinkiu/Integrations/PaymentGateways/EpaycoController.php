<?php

namespace App\Http\Controllers\SuperLinkiu\Integrations\PaymentGateways;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EpaycoController extends Controller
{
    /**
     * Mostrar configuración de Epayco
     */
    public function index()
    {
        $epayco = PaymentGateway::where('name', 'epayco')->first();
        
        return view('superlinkiu::integrations.payment-gateways.epayco.index', compact('epayco'));
    }

    /**
     * Guardar/Actualizar configuración de Epayco
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_test_mode' => 'boolean',
            'public_key' => 'required|string',
            'private_key' => 'required|string',
            'customer_id' => 'required|string',
            'p_key' => 'required|string',
        ]);

        $epayco = PaymentGateway::firstOrNew(['name' => 'epayco']);
        
        $epayco->fill([
            'display_name' => $validated['display_name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', false),
            'is_test_mode' => $request->boolean('is_test_mode', true),
        ]);

        // Guardar credenciales (encriptadas usando el método del modelo)
        $epayco->setCredential('public_key', $validated['public_key']);
        $epayco->setCredential('private_key', $validated['private_key']);
        $epayco->setCredential('customer_id', $validated['customer_id']);
        $epayco->setCredential('p_key', $validated['p_key']);
        $epayco->save();

        return redirect()
            ->route('superlinkiu.integrations.payment-gateways.epayco.index')
            ->with('success', 'Configuración de Epayco guardada correctamente');
    }

    /**
     * Listar transacciones
     */
    public function transactions()
    {
        $epayco = PaymentGateway::where('name', 'epayco')->first();
        
        if (!$epayco) {
            return redirect()
                ->route('superlinkiu.integrations.payment-gateways.epayco.index')
                ->with('error', 'Epayco no está configurado');
        }

        $transactions = PaymentGatewayTransaction::where('payment_gateway_id', $epayco->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('superlinkiu::integrations.payment-gateways.epayco.transactions', compact('epayco', 'transactions'));
    }

    /**
     * Ver detalle de transacción
     */
    public function showTransaction(PaymentGatewayTransaction $transaction)
    {
        return view('superlinkiu::integrations.payment-gateways.epayco.transaction-detail', compact('transaction'));
    }
}
