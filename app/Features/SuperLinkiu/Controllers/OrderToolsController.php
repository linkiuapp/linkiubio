<?php

namespace App\Features\SuperLinkiu\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shared\Models\Store;
use App\Shared\Models\Order;
use App\Features\SuperLinkiu\Models\OrderDeletionLog;
use Illuminate\Support\Facades\DB;

class OrderToolsController extends Controller
{
    public function deleteOrderForm()
    {
        $stores = Store::orderBy('name')->get(['id', 'name', 'slug']);
        $deletionLogs = OrderDeletionLog::with('deletedByUser')
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
        
        return view('superlinkiu::tools.delete-order', compact('stores', 'deletionLogs'));
    }

    public function searchOrder(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'order_number' => 'required|string',
        ]);

        $store = Store::findOrFail($request->store_id);
        
        $order = Order::where('store_id', $store->id)
            ->where(function($query) use ($request) {
                $query->where('order_number', $request->order_number)
                    ->orWhere('id', $request->order_number);
            })
            ->with(['items'])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado en esta tienda'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'store_name' => $store->name,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'customer_email' => $order->customer_email,
                'total' => $order->total,
                'status' => $order->status,
                'status_label' => $this->getStatusLabel($order->status),
                'payment_method' => $order->payment_method_label ?? 'N/A',
                'delivery_type' => $order->delivery_type,
                'items_count' => $order->items->count(),
                'created_at' => $order->created_at->format('d/m/Y H:i'),
            ]
        ]);
    }

    public function deleteOrder(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'order_id' => 'required|integer',
            'reason' => 'required|string|min:10|max:500',
        ], [
            'reason.required' => 'El motivo de eliminación es obligatorio',
            'reason.min' => 'El motivo debe tener al menos 10 caracteres',
        ]);

        $store = Store::findOrFail($request->store_id);
        $order = Order::where('store_id', $store->id)
            ->where('id', $request->order_id)
            ->with(['items'])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        DB::beginTransaction();
        try {
            // Guardar log de eliminación
            OrderDeletionLog::create([
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'store_id' => $store->id,
                'store_name' => $store->name,
                'customer_name' => $order->customer_name,
                'total' => $order->total,
                'status' => $order->status,
                'order_data' => $order->toArray(),
                'deleted_by' => auth()->id(),
                'reason' => $request->reason,
            ]);

            // Eliminar items del pedido primero
            $order->items()->delete();
            
            // Eliminar el pedido
            $order->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pedido #' . $order->order_number . ' eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deletionLogs()
    {
        $logs = OrderDeletionLog::with('deletedByUser')
            ->orderByDesc('created_at')
            ->paginate(50);
        
        return view('superlinkiu::tools.deletion-logs', compact('logs'));
    }

    private function getStatusLabel($status)
    {
        return match($status) {
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmado',
            'preparing' => 'En preparación',
            'ready' => 'Listo',
            'on_the_way' => 'En camino',
            'delivered' => 'Entregado',
            'completed' => 'Completado',
            'cancelled' => 'Cancelado',
            default => ucfirst($status),
        };
    }
}

