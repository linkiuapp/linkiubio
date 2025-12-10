<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; padding-bottom: 15px; border-bottom: 2px solid #e5e7eb; margin-bottom: 20px; }
        .header-left h1 { font-size: 18px; color: #1f2937; margin-bottom: 5px; }
        .header-left p { font-size: 10px; color: #6b7280; margin-bottom: 2px; }
        .header-right { text-align: right; }
        .header-right p { font-size: 10px; color: #6b7280; margin-bottom: 2px; }
        .header-right .logo { font-size: 16px; font-weight: bold; color: #3b82f6; margin-bottom: 5px; }
        .section-title { font-size: 12px; font-weight: 600; color: #1f2937; margin-bottom: 8px; }
        .info-table { width: 100%; }
        .info-table td { padding: 3px 0; font-size: 10px; }
        .info-table td:first-child { color: #6b7280; width: 100px; }
        .info-table td:last-child { color: #1f2937; font-weight: 500; }
        .invoice-details { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .invoice-details-block { flex: 1; }
        table.items { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table.items th { background: #f3f4f6; padding: 8px; text-align: left; font-size: 10px; font-weight: 600; color: #374151; border-bottom: 2px solid #e5e7eb; }
        table.items td { padding: 8px; border-bottom: 1px solid #e5e7eb; font-size: 10px; color: #1f2937; }
        table.items tr:last-child td { border-bottom: none; }
        .totals { text-align: right; margin-top: 15px; }
        .totals table { margin-left: auto; min-width: 250px; }
        .totals td { padding: 5px 10px; font-size: 10px; }
        .totals td:first-child { text-align: left; color: #6b7280; }
        .totals td:last-child { text-align: right; font-weight: 600; color: #1f2937; }
        .totals .total-row { border-top: 2px solid #e5e7eb; padding-top: 8px; }
        .totals .total-row td { font-size: 13px; font-weight: bold; color: #1f2937; padding-top: 8px; }
        .footer { text-align: center; margin-top: 40px; padding-top: 15px; border-top: 1px solid #e5e7eb; }
        .footer p { font-size: 9px; color: #9ca3af; }
        .signatures { display: table; width: 100%; margin-top: 40px; }
        .signature-line { display: table-cell; width: 50%; border-top: 1px solid #9ca3af; padding-top: 6px; font-size: 9px; color: #6b7280; text-align: center; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 9px; font-weight: 600; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <div class="header-left">
                <h1>Factura {{ $invoice->invoice_number }}</h1>
                <p>Fecha de Emisión: {{ $invoice->issue_date->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
                <p>Fecha de Vencimiento: {{ $invoice->due_date->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
                @if($invoice->status === 'paid' && $invoice->paid_date)
                <p>Fecha de Pago: {{ $invoice->paid_date->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
                @endif
            </div>
            <div class="header-right">
                <p class="logo">LINKIU</p>
                <p>{{ $billingSettings->company_name ?? 'Linkiu S.A.S' }}</p>
                <p>NIT: {{ $billingSettings->nit ?? '901234567-1' }}</p>
                <p>{{ $billingSettings->address ?? 'Sincelejo, Sucre' }}</p>
                <p>{{ $billingSettings->email ?? 'facturacion@linkiu.bio' }}</p>
                <p>{{ $billingSettings->phone ?? '+57 310 459 4344' }}</p>
            </div>
        </div>

        {{-- Cliente y Detalles de Factura --}}
        <div class="invoice-details">
            <div class="invoice-details-block">
                <h3 class="section-title">Facturado a:</h3>
                <table class="info-table">
                    <tr>
                        <td>Nombre:</td>
                        <td>{{ $store->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ ucfirst($store->document_type) }}:</td>
                        <td>{{ $store->document_number }}</td>
                    </tr>
                    <tr>
                        <td>Dirección:</td>
                        <td>{{ $store->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Ciudad:</td>
                        <td>{{ $store->city }}, {{ $store->department }}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>{{ $store->email }}</td>
                    </tr>
                    <tr>
                        <td>Teléfono:</td>
                        <td>{{ $store->phone }}</td>
                    </tr>
                </table>
            </div>
            <div class="invoice-details-block" style="text-align: right;">
                <h3 class="section-title">Detalles de Factura:</h3>
                <table class="info-table" style="margin-left: auto;">
                    <tr>
                        <td>Factura:</td>
                        <td><strong>{{ $invoice->invoice_number }}</strong></td>
                    </tr>
                    <tr>
                        <td>Plan:</td>
                        <td>{{ $invoice->plan->name }}</td>
                    </tr>
                    <tr>
                        <td>Período:</td>
                        <td>{{ ucfirst($invoice->period) }}</td>
                    </tr>
                    <tr>
                        <td>Estado:</td>
                        <td>
                            <span class="status-badge status-{{ $invoice->status }}">
                                {{ strtoupper($invoice->status === 'paid' ? 'PAGADA' : ($invoice->status === 'pending' ? 'PENDIENTE' : 'VENCIDA')) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Items de la Factura --}}
        <table class="items">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th style="text-align: center;">Período</th>
                    <th style="text-align: right;">Monto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Suscripción Plan {{ $invoice->plan->name }}</strong><br>
                        <span style="font-size: 12px; color: #6b7280;">
                            {{ $invoice->notes }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        {{ ucfirst($invoice->period) }}
                    </td>
                    <td style="text-align: right;">
                        <strong>${{ number_format($invoice->amount, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Totales --}}
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>${{ number_format($invoice->amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Descuento:</td>
                    <td>$0</td>
                </tr>
                <tr>
                    <td>Impuestos:</td>
                    <td>$0</td>
                </tr>
                <tr class="total-row">
                    <td>TOTAL:</td>
                    <td>${{ number_format($invoice->amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        {{-- Nota de Agradecimiento --}}
        <div class="footer">
            <p style="font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">¡Gracias por confiar en Linkiu!</p>
            <p>Para cualquier consulta, contáctanos en soporte@linkiu.bio o WhatsApp: +57 310 459 4344</p>
        </div>

        {{-- Firmas --}}
        <div class="signatures">
            <div class="signature-line">_______________________<br>Firma del Cliente</div>
            <div class="signature-line">_______________________<br>Firma Autorizada</div>
        </div>
    </div>
</body>
</html>

