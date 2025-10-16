<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Clientes, Atenciones y Detalles de Servicios</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; margin: 0; padding: 0; }
        h2 { text-align: center; margin-bottom: 20px; color: #111; }
        h3 { margin: 8px 0; color: #333; }
        h4 { margin: 6px 0; font-size: 13px; color: #555; }

        .reporte-item {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            background: #fafafa;
        }

        .cliente-info p,
        .detalle-item p {
            margin: 2px 0;
            font-size: 11px;
            color: #444;
        }

        .detalle-box {
            margin-top: 8px;
            padding: 8px;
            border-top: 1px solid #ddd;
        }

        .detalle-item {
            border-bottom: 1px solid #eee;
            padding: 4px 0;
        }

        .no-detalle, .no-data {
            text-align: center;
            font-style: italic;
            color: #777;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <h2>Reporte: Clientes, Atenciones y Detalles de Servicios</h2>

    @if($clientes->isEmpty())
        <div class="no-data">No hay registros para mostrar.</div>
    @else
        <ul>
            @foreach($clientes as $cliente)
                @if($cliente->citas->isNotEmpty())
                    @foreach($cliente->citas as $cita)
                        <li class="reporte-item">
                            <h3>🗓️ Cita #{{ $cita->id }} - {{ $cita->fecha }} {{ $cita->hora }}</h3>

                            <div class="cliente-info">
                                <p><strong>Cliente:</strong> {{ $cliente->first_name }} {{ $cliente->last_name ?? '' }}</p>
                                <p><strong>Documento:</strong> {{ $cliente->document }}</p>
                                @if($cliente->phone)
                                    <p><strong>Teléfono:</strong> {{ $cliente->phone }}</p>
                                @endif
                                @if($cliente->email)
                                    <p><strong>Email:</strong> {{ $cliente->email }}</p>
                                @endif
                            </div>

                            @if($cita->detalles->isNotEmpty())
                                <div class="detalle-box">
                                    <h4>Detalles de Atenciones:</h4>
                                    <ul>
                                        @foreach($cita->detalles as $detalle)
                                            <li class="detalle-item">
                                                <p><strong>Atención:</strong> {{ $detalle->atencion->nombre ?? '—' }}</p>
                                                <p><strong>Precio:</strong> ${{ number_format($detalle->atencion->precio ?? 0, 2) }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p class="no-detalle">No hay detalles registrados.</p>
                            @endif
                        </li>
                    @endforeach
                @else
                    <li class="reporte-item">
                        <h3>Cliente: {{ $cliente->first_name }} {{ $cliente->last_name ?? '' }}</h3>
                        <p class="no-detalle">No tiene citas registradas.</p>
                    </li>
                @endif
            @endforeach
        </ul>
    @endif
</body>
</html>
