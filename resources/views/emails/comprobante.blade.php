<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.1); }
        .header { background: #dc3545; color: white; padding: 30px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0; opacity: .8; font-size: 14px; }
        .body { padding: 30px; }
        .badge-success { background: #198754; color: white; padding: 6px 16px; border-radius: 20px; font-weight: bold; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #f8f9fa; padding: 10px; text-align: left; font-size: 12px; text-transform: uppercase; color: #666; }
        td { padding: 10px; border-bottom: 1px solid #eee; font-size: 14px; }
        .total-row td { font-weight: bold; font-size: 16px; color: #dc3545; border-top: 2px solid #ddd; border-bottom: none; }
        .info-box { background: #f8f9fa; border-radius: 8px; padding: 16px; margin: 16px 0; }
        .info-box h4 { margin: 0 0 8px; font-size: 13px; text-transform: uppercase; color: #666; }
        .footer { background: #1a1a2e; color: rgba(255,255,255,.6); text-align: center; padding: 20px; font-size: 12px; }
        .footer strong { color: white; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>⚡ FUERZA URBANA</h1>
        <p>Comprobante de compra — {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="body">
        <p>Hola <strong>{{ $order->user->name }}</strong>,</p>
        <p>¡Tu compra fue procesada exitosamente! Aquí está el detalle de tu pedido.</p>

        <p><span class="badge-success">✓ PAGO APROBADO</span></p>

        <div class="info-box">
            <h4>Número de pedido</h4>
            <strong style="font-size:18px">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>
            &nbsp;&nbsp;
            <span style="color:#666;font-size:13px">{{ $factura->numero }}</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cant.</th>
                    <th style="text-align:right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td style="text-align:right">${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2" style="text-align:right;color:#666">Envío</td>
                    <td style="text-align:right">${{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2" style="text-align:right">TOTAL</td>
                    <td style="text-align:right">${{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="info-box">
            <h4>Dirección de envío</h4>
            <p style="margin:0">{{ $order->address->street }}, {{ $order->address->city }}, {{ $order->address->province }} ({{ $order->address->postal_code }})</p>
        </div>

        <p style="color:#666;font-size:13px">
            Método de pago: <strong>{{ $order->payment->method }}</strong><br>
            Transacción: <strong>{{ $order->payment->transaction_id }}</strong>
        </p>

        <p>Si tenés alguna consulta, respondé este correo o escribinos a <a href="mailto:contacto@fuerzaurbana.com" style="color:#dc3545">contacto@fuerzaurbana.com</a></p>
    </div>
    <div class="footer">
        Gracias por comprar en <strong>Fuerza Urbana</strong> · Corrientes, Argentina
    </div>
</div>
</body>
</html>
