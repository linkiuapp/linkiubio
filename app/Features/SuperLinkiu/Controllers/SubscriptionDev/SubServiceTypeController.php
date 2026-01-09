<?php

namespace App\Features\SuperLinkiu\Controllers\SubscriptionDev;

use App\Http\Controllers\Controller;
use App\Features\SuperLinkiu\Models\SubServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubServiceTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = SubServiceType::withCount('subscriptions');

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $serviceTypes = $query->ordered()->paginate(20)->withQueryString();

        $categories = SubServiceType::getCategories();

        return view('superlinkiu::subscriptiondev.service-types.index', compact('serviceTypes', 'categories'));
    }

    public function create()
    {
        $categories = SubServiceType::getCategories();
        return view('superlinkiu::subscriptiondev.service-types.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
            'default_price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_quarterly' => 'nullable|numeric|min:0',
            'price_semiannual' => 'nullable|numeric|min:0',
            'price_annual' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $periodPrices = [];
        if ($request->filled('price_monthly')) {
            $periodPrices['monthly'] = (float) $request->price_monthly;
        }
        if ($request->filled('price_quarterly')) {
            $periodPrices['quarterly'] = (float) $request->price_quarterly;
        }
        if ($request->filled('price_semiannual')) {
            $periodPrices['semiannual'] = (float) $request->price_semiannual;
        }
        if ($request->filled('price_annual')) {
            $periodPrices['annual'] = (float) $request->price_annual;
        }

        $serviceType = SubServiceType::create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'default_price' => $validated['default_price'],
            'currency' => $validated['currency'],
            'period_prices' => !empty($periodPrices) ? $periodPrices : null,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        Log::info('SubscriptionDev: Tipo de servicio creado', ['service_type_id' => $serviceType->id]);

        return redirect()
            ->route('superlinkiu.subscriptiondev.service-types.index')
            ->with('success', 'Tipo de servicio creado correctamente.');
    }

    public function edit(SubServiceType $serviceType)
    {
        $categories = SubServiceType::getCategories();
        return view('superlinkiu::subscriptiondev.service-types.edit', compact('serviceType', 'categories'));
    }

    public function update(Request $request, SubServiceType $serviceType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'description' => 'nullable|string|max:1000',
            'default_price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_quarterly' => 'nullable|numeric|min:0',
            'price_semiannual' => 'nullable|numeric|min:0',
            'price_annual' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $periodPrices = [];
        if ($request->filled('price_monthly')) {
            $periodPrices['monthly'] = (float) $request->price_monthly;
        }
        if ($request->filled('price_quarterly')) {
            $periodPrices['quarterly'] = (float) $request->price_quarterly;
        }
        if ($request->filled('price_semiannual')) {
            $periodPrices['semiannual'] = (float) $request->price_semiannual;
        }
        if ($request->filled('price_annual')) {
            $periodPrices['annual'] = (float) $request->price_annual;
        }

        $serviceType->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'default_price' => $validated['default_price'],
            'currency' => $validated['currency'],
            'period_prices' => !empty($periodPrices) ? $periodPrices : null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        Log::info('SubscriptionDev: Tipo de servicio actualizado', ['service_type_id' => $serviceType->id]);

        return redirect()
            ->route('superlinkiu.subscriptiondev.service-types.index')
            ->with('success', 'Tipo de servicio actualizado correctamente.');
    }

    public function destroy(SubServiceType $serviceType)
    {
        if ($serviceType->subscriptions()->exists()) {
            return back()->with('error', 'No se puede eliminar porque tiene suscripciones asociadas.');
        }

        $name = $serviceType->name;
        $serviceType->delete();

        Log::info('SubscriptionDev: Tipo de servicio eliminado', ['name' => $name]);

        return redirect()
            ->route('superlinkiu.subscriptiondev.service-types.index')
            ->with('success', "Tipo de servicio '{$name}' eliminado correctamente.");
    }
}
