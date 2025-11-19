@props(['order', 'store'])

<div class="order-receipt-pos" style="width: 120mm; padding: 5mm; background: white; font-family: 'Courier New', monospace; font-size: 10pt; color: #000; line-height: 1.3;">
    <!-- Header POS -->
    <div class="text-center mb-4">
        <h1 style="font-size: 14pt; font-weight: bold; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 1px;">{{ $store->name }}</h1>
        @if($store->address)
        <p style="margin: 2px 0; font-size: 9pt;">{{ $store->address }}</p>
        @endif
        @if($store->phone)
        <p style="margin: 2px 0; font-size: 9pt;">Tel: {{ $store->phone }}</p>
        @endif
        @if($store->email)
        <p style="margin: 2px 0; font-size: 9pt;">{{ $store->email }}</p>
        @endif
        <div style="border-top: 1px solid #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Información del Pedido -->
    <div style="margin-bottom: 9px;">
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Pedido:</span>
            <span style="font-weight: bold;">#{{ $order->order_number }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Fecha:</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Estado:</span>
            <span>{{ $order->status_label }}</span>
        </div>
        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Información del Cliente -->
    <div style="margin-bottom: 9px;">
        <p style="font-size: 9pt; font-weight: bold; margin-bottom: 3px;">CLIENTE:</p>
        <p style="font-size: 9pt; margin: 2px 0;">{{ $order->customer_name }}</p>
        <p style="font-size: 9pt; margin: 2px 0;">Tel: {{ $order->customer_phone }}</p>
        @if($order->customer_address)
        <p style="font-size: 9pt; margin: 2px 0;">{{ $order->customer_address }}</p>
        @endif
        @if($order->city)
        <p style="font-size: 9pt; margin: 2px 0;">{{ $order->city }}{{ $order->department ? ', ' . $order->department : '' }}</p>
        @endif
        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Productos -->
    <div style="margin-bottom: 9px;">
        <p style="font-size: 9pt; font-weight: bold; margin-bottom: 6px;">PRODUCTOS:</p>
        <table style="width: 100%; border-collapse: collapse; margin: 4px 0; font-size: 9pt; table-layout: fixed;">
            <colgroup>
                <col style="width: 15%;">
                <col style="width: 40%;">
                <col style="width: 22.5%;">
                <col style="width: 22.5%;">
            </colgroup>
            <thead>
                <tr style="border-bottom: 1px solid #000;">
                    <th style="text-align: left; padding: 4px 3px; font-weight: bold; text-transform: uppercase; font-size: 8pt;">Cant</th>
                    <th style="text-align: left; padding: 4px 3px; font-weight: bold; text-transform: uppercase; font-size: 8pt;">Descripción</th>
                    <th style="text-align: right; padding: 4px 3px; font-weight: bold; text-transform: uppercase; font-size: 8pt;">P.Unit</th>
                    <th style="text-align: right; padding: 4px 3px; font-weight: bold; text-transform: uppercase; font-size: 8pt;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr style="border-bottom: 1px dashed #666;">
                    <td style="padding: 4px 3px; vertical-align: top; text-align: left;">{{ $item->quantity }}</td>
                    <td style="padding: 4px 3px; vertical-align: top; word-wrap: break-word; overflow-wrap: break-word; hyphens: auto;">
                        {{ $item->product_name }}
                        @if($item->variant_details)
                        <br><span style="font-size: 8pt; color: #666;">({{ $item->formatted_variants }})</span>
                        @endif
                    </td>
                    <td style="text-align: right; padding: 4px 3px; vertical-align: top; white-space: nowrap;">${{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td style="text-align: right; padding: 4px 3px; vertical-align: top; font-weight: 600; white-space: nowrap;">${{ number_format($item->item_total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Totales -->
    <div style="margin-bottom: 9px;">
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Subtotal:</span>
            <span>${{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>
        @if($order->shipping_cost > 0)
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Envío:</span>
            <span>${{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
        </div>
        @endif
        @if($order->coupon_discount > 0)
        <div style="display: flex; justify-content: space-between; font-size: 9pt; margin-bottom: 3px;">
            <span>Descuento:</span>
            <span>-${{ number_format($order->coupon_discount, 0, ',', '.') }}</span>
        </div>
        @endif
        <div style="border-top: 2px solid #000; margin: 6px 0;"></div>
        <div style="display: flex; justify-content: space-between; font-size: 10pt; font-weight: bold; margin-bottom: 6px;">
            <span>TOTAL:</span>
            <span>${{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Información de Pago y Entrega -->
    <div style="margin-bottom: 9px; font-size: 9pt;">
        <p style="margin-bottom: 3px;"><strong>Método de Pago:</strong> 
            @if($order->payment_method === 'transferencia' || $order->payment_method === 'bank_transfer')
                Transferencia Bancaria
            @elseif($order->payment_method === 'contra_entrega')
                Pago Contra Entrega
            @elseif($order->payment_method === 'efectivo' || $order->payment_method === 'cash')
                Efectivo
            @else
                {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
            @endif
        </p>
        <p style="margin-bottom: 3px;"><strong>Tipo de Entrega:</strong> 
            @if(in_array($order->delivery_type, ['domicilio', 'local', 'national']))
                @if($order->delivery_type === 'national')
                    Envío Nacional
                @else
                    Domicilio
                @endif
            @else
                Consumo en Local
            @endif
        </p>
        @if($order->notes)
        <p style="margin-bottom: 3px;"><strong>Notas:</strong> {{ $order->notes }}</p>
        @endif
        <div style="border-top: 1px dashed #000; margin: 6px 0;"></div>
    </div>
    
    <!-- Footer POS -->
    <div style="text-align: center; font-size: 9pt; margin-top: 12px;">
        <p style="margin-bottom: 3px;">¡Gracias por su compra!</p>
        <p style="margin-bottom: 3px;">Pedido #{{ $order->order_number }}</p>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</div>

