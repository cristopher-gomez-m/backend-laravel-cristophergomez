<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte: Clientes, Atenciones y Detalles de Servicios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #222;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #111;
        }

        h3 {
            margin: 8px 0;
            color: #333;
        }

        h4 {
            margin: 6px 0;
            font-size: 13px;
            color: #555;
        }

        .reporte-item {
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 12px;
            background: #fafafa;
        }

        .cliente-info p,
        .detalle-item p {
            margin: 2px 0;
            font-size: 11px;
            color: #444;
        }

        .detalle-box {
            margin-top: 6px;
            padding: 6px 10px;
            border-top: 1px solid #ddd;
        }

        .detalle-item {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }

        .no-detalle,
        .no-data {
            text-align: center;
            font-style: italic;
            color: #777;
            margin-top: 8px;
        }

        .cita-footer {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #333;
            margin-top: 6px;
        }

        .estado {
            font-weight: 600;
            color: #2b7a0b;
        }
    </style>
</head>

<body>
    <h2>Reporte: Clientes, Atenciones y Detalles de Servicios</h2>

    @if($citas->isEmpty())
        <div class="no-data">No hay registros para mostrar.</div>
    @else
        @foreach($citas as $c)
            <div class="reporte-item">
                <h3>🗓️ Cita #{{ $c->id }} - {{ $c->fecha }} {{ $c->hora }}</h3>

                <div class="cliente-info">
                    <p><strong>Cliente:</strong> {{ $c->cliente->first_name }} {{ $c->cliente->last_name ?? '' }}</p>
                    <p><strong>Documento:</strong> {{ $c->cliente->document }}</p>
                    @if($c->cliente->phone)
                        <p><strong>Teléfono:</strong> {{ $c->cliente->phone }}</p>
                    @endif
                    @if($c->cliente->email)
                        <p><strong>Email:</strong> {{ $c->cliente->email }}</p>
                    @endif
                </div>

                @if($c->detalles->isNotEmpty())
                    <div class="detalle-box">
                        <h4>Detalles de Atenciones:</h4>
                        <ul>
                            @foreach($c->detalles as $d)
                                <li class="detalle-item">
                                    <span>{{ $d->atencion->nombre ?? '—' }}</span>
                                    <span>${{ number_format($d->atencion->precio ?? 0, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="no-detalle">No hay detalles registrados.</p>
                @endif
            </div>
        @endforeach
    @endif
</body>

</html>
