<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LinkiuTool;
use App\Models\ToolPaymentHistory;
use App\Services\ToolDescriptionService;
use App\Services\ToolPaymentNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ToolController extends Controller
{
    protected $descriptionService;
    protected $notificationService;

    public function __construct(
        ToolDescriptionService $descriptionService,
        ToolPaymentNotificationService $notificationService
    ) {
        $this->descriptionService = $descriptionService;
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the tools.
     */
    public function index(Request $request)
    {
        $query = LinkiuTool::with(['creator', 'updater'])
            ->withCount('paymentHistory');

        // Filtros
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('billing_type')) {
            $query->where('billing_type', $request->billing_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $tools = $query->orderBy('name')->paginate(20);

        // Obtener categorías únicas para el filtro
        $categories = LinkiuTool::distinct()->pluck('category')->filter()->sort()->values();

        return view('superlinkiu::tools.index', compact('tools', 'categories'));
    }

    /**
     * Show the form for creating a new tool.
     */
    public function create()
    {
        return view('superlinkiu::tools.create');
    }

    /**
     * Store a newly created tool.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'usage_in_linkiu' => 'nullable|string',
            'url' => 'nullable|url',
            'dashboard_url' => 'nullable|url',
            'api_docs_url' => 'nullable|url',
            'start_date' => 'nullable|date',
            'billing_type' => 'required|in:free,monthly,yearly,pay_per_use',
            'monthly_cost' => 'nullable|numeric|min:0',
            'yearly_cost' => 'nullable|numeric|min:0',
            'minimum_recharge' => 'nullable|numeric|min:0',
            'current_balance' => 'nullable|numeric|min:0',
            'balance_currency' => 'nullable|string|size:3',
            'currency' => 'nullable|string|size:3',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'api_key' => 'nullable|string',
            'api_secret' => 'nullable|string',
            'account_id' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,deprecated',
            'is_critical' => 'boolean',
            'responsible_team' => 'nullable|string|max:255',
            'last_renewal_date' => 'nullable|date',
            'next_renewal_date' => 'nullable|date',
            'notification_phone' => 'nullable|string|max:20',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        $tool = LinkiuTool::create($validated);

        Log::info('Herramienta creada', [
            'tool_id' => $tool->id,
            'tool_name' => $tool->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('superlinkiu.linkiu-tools.show', $tool)
            ->with('success', 'Herramienta creada exitosamente');
    }

    /**
     * Display the specified tool.
     */
    public function show(LinkiuTool $tool)
    {
        $tool->load(['creator', 'updater', 'paymentHistory.creator']);
        
        // Obtener credenciales desencriptadas (solo para mostrar)
        $decryptedData = [
            'password' => $tool->getDecryptedPassword(),
            'api_key' => $tool->getDecryptedApiKey(),
            'api_secret' => $tool->getDecryptedApiSecret(),
        ];

        return view('superlinkiu::tools.show', compact('tool', 'decryptedData'));
    }

    /**
     * Show the form for editing the specified tool.
     */
    public function edit(LinkiuTool $tool)
    {
        // Obtener credenciales desencriptadas para edición
        $decryptedData = [
            'password' => $tool->getDecryptedPassword(),
            'api_key' => $tool->getDecryptedApiKey(),
            'api_secret' => $tool->getDecryptedApiSecret(),
        ];

        return view('superlinkiu::tools.edit', compact('tool', 'decryptedData'));
    }

    /**
     * Update the specified tool.
     */
    public function update(Request $request, LinkiuTool $tool)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'usage_in_linkiu' => 'nullable|string',
            'url' => 'nullable|url',
            'dashboard_url' => 'nullable|url',
            'api_docs_url' => 'nullable|url',
            'start_date' => 'nullable|date',
            'billing_type' => 'required|in:free,monthly,yearly,pay_per_use',
            'monthly_cost' => 'nullable|numeric|min:0',
            'yearly_cost' => 'nullable|numeric|min:0',
            'minimum_recharge' => 'nullable|numeric|min:0',
            'current_balance' => 'nullable|numeric|min:0',
            'balance_currency' => 'nullable|string|size:3',
            'currency' => 'nullable|string|size:3',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'api_key' => 'nullable|string',
            'api_secret' => 'nullable|string',
            'account_id' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,deprecated',
            'is_critical' => 'boolean',
            'responsible_team' => 'nullable|string|max:255',
            'last_renewal_date' => 'nullable|date',
            'next_renewal_date' => 'nullable|date',
            'notification_phone' => 'nullable|string|max:20',
        ]);

        $validated['updated_by'] = auth()->id();

        // Si las credenciales están vacías, no actualizarlas (mantener las actuales)
        if (empty($validated['password'])) {
            unset($validated['password']);
        }
        if (empty($validated['api_key'])) {
            unset($validated['api_key']);
        }
        if (empty($validated['api_secret'])) {
            unset($validated['api_secret']);
        }

        $tool->update($validated);

        Log::info('Herramienta actualizada', [
            'tool_id' => $tool->id,
            'tool_name' => $tool->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('superlinkiu.linkiu-tools.show', $tool)
            ->with('success', 'Herramienta actualizada exitosamente');
    }

    /**
     * Remove the specified tool.
     */
    public function destroy(LinkiuTool $tool)
    {
        $toolName = $tool->name;
        $tool->delete();

        Log::info('Herramienta eliminada', [
            'tool_id' => $tool->id,
            'tool_name' => $toolName,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('superlinkiu.linkiu-tools.index')
            ->with('success', 'Herramienta eliminada exitosamente');
    }

    /**
     * Generar descripción con IA
     */
    public function generateDescription(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'nullable|string',
        ]);

        $result = $this->descriptionService->generateDescription(
            $request->name,
            $request->category
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'description' => $result['description']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 500);
    }

    /**
     * Generar uso en Linkiu con IA
     */
    public function generateUsageInLinkiu(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $result = $this->descriptionService->generateUsageInLinkiu(
            $request->name,
            $request->description
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'usage' => $result['usage']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 500);
    }

    /**
     * Agregar pago o recarga al historial
     */
    public function storePayment(Request $request, LinkiuTool $tool)
    {
        $isRecharge = $tool->isPayPerUse();
        
        $validated = $request->validate([
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_type' => $isRecharge 
                ? 'required|in:recharge' 
                : 'required|in:monthly,yearly,renewal,one_time,other',
            'currency' => 'nullable|string|size:3',
            'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'notes' => 'nullable|string',
        ]);

        $validated['tool_id'] = $tool->id;
        $validated['created_by'] = auth()->id();
        $validated['currency'] = $validated['currency'] ?? $tool->getBalanceCurrency();

        // Subir comprobante si existe
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('tool-receipts', 'public');
            $validated['receipt_path'] = $path;
        }

        $payment = ToolPaymentHistory::create($validated);

        // Si es recarga (pay_per_use), sumar al saldo actual
        if ($isRecharge && $validated['payment_type'] === 'recharge') {
            $rechargeAmount = $validated['amount'];
            $currentBalance = $tool->current_balance ?? 0;
            $tool->current_balance = $currentBalance + $rechargeAmount;
            
            // Actualizar moneda del saldo si no está definida
            if (!$tool->balance_currency) {
                $tool->balance_currency = $validated['currency'];
            }
            
            $tool->save();
            
            Log::info('Recarga agregada al historial', [
                'tool_id' => $tool->id,
                'payment_id' => $payment->id,
                'recharge_amount' => $rechargeAmount,
                'previous_balance' => $currentBalance,
                'new_balance' => $tool->current_balance,
                'user_id' => auth()->id(),
            ]);
        }

        // Actualizar fechas de renovación si es necesario (solo para pagos periódicos)
        if (!$isRecharge && in_array($validated['payment_type'], ['monthly', 'yearly', 'renewal'])) {
            $paymentDate = \Carbon\Carbon::parse($validated['payment_date']);
            $tool->last_renewal_date = $paymentDate;
            
            // Determinar el período según el tipo de pago
            $periodMonths = match($validated['payment_type']) {
                'monthly' => 1,
                'yearly' => 12,
                'renewal' => match($tool->billing_type) {
                    'monthly' => 1,
                    'yearly' => 12,
                    default => 1
                },
                default => 1
            };
            
            // Calcular próxima renovación: mantener el día del mes original
            $originalDay = $tool->next_renewal_date 
                ? $tool->next_renewal_date->day 
                : $paymentDate->day;
            
            // Calcular la fecha base sumando el período desde la fecha de pago
            $baseDate = $paymentDate->copy()->addMonths($periodMonths);
            
            // Intentar usar el día original del mes en el mes calculado
            $maxDayInMonth = $baseDate->copy()->endOfMonth()->day;
            $targetDay = min($originalDay, $maxDayInMonth);
            
            $calculatedDate = $baseDate->copy()->day($targetDay);
            
            // Si la fecha calculada es en el pasado o es hoy mismo (pago tardío),
            // avanzar otro período manteniendo el día original
            if ($calculatedDate->isPast() || $calculatedDate->equalTo($paymentDate->startOfDay())) {
                $calculatedDate = $calculatedDate->addMonths($periodMonths);
                $maxDayInMonth = $calculatedDate->copy()->endOfMonth()->day;
                $targetDay = min($originalDay, $maxDayInMonth);
                $calculatedDate = $calculatedDate->day($targetDay);
            }
            
            // Si pagamos ANTES de la fecha de vencimiento actual y la fecha calculada 
            // es igual o antes de la fecha de vencimiento original, avanzar otro período
            if ($tool->next_renewal_date && $paymentDate->isBefore($tool->next_renewal_date)) {
                // Si la fecha calculada es igual o antes de la fecha original de vencimiento,
                // significa que pagamos anticipado, entonces saltamos al siguiente período
                if ($calculatedDate->lessThanOrEqualTo($tool->next_renewal_date)) {
                    $calculatedDate = $calculatedDate->addMonths($periodMonths);
                    $maxDayInMonth = $calculatedDate->copy()->endOfMonth()->day;
                    $targetDay = min($originalDay, $maxDayInMonth);
                    $calculatedDate = $calculatedDate->day($targetDay);
                }
            }
            
            $tool->next_renewal_date = $calculatedDate;
            
            // Si el tipo de pago es diferente al billing_type actual, actualizar el billing_type
            if ($validated['payment_type'] === 'monthly' && $tool->billing_type !== 'monthly') {
                $tool->billing_type = 'monthly';
            } elseif ($validated['payment_type'] === 'yearly' && $tool->billing_type !== 'yearly') {
                $tool->billing_type = 'yearly';
            }
            
            $tool->save();
        }

        // Log solo si no es recarga (ya se logueó arriba)
        if (!$isRecharge) {
            Log::info('Pago agregado al historial', [
                'tool_id' => $tool->id,
                'payment_id' => $payment->id,
                'user_id' => auth()->id(),
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pago registrado exitosamente'
            ]);
        }

        return redirect()->route('superlinkiu.linkiu-tools.show', $tool)
            ->with('success', 'Pago registrado exitosamente');
    }

    /**
     * Enviar notificación de pago por WhatsApp
     */
    public function sendPaymentNotification(Request $request, LinkiuTool $tool)
    {
        $customMessage = $request->input('message');

        $result = $this->notificationService->sendPaymentReminder($tool, $customMessage);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 400);
    }
}
