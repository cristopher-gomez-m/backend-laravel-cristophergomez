<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Clientes y Valores</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222; margin: 0; padding: 0; }
        h2 { text-align: center; margin-bottom: 20px; color: #111; }

        .cliente-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 12px;
            background: #fafafa;
        }

        .cliente-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .cliente-info p {
            margin: 4px 0;
            font-size: 11px;
            color: #444;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Reporte de Clientes y Valores</h2>

    @if(count($clientes) === 0)
        <div class="no-data">No se encontraron datos.</div>
    @else
        @foreach($clientes as $c)
            <div class="cliente-card">
                <div class="cliente-header">
                    <span>{{ $c['first_name'] }} {{ $c['last_name'] ?? '' }}</span>
                    <span>{{ $c['document'] }}</span>
                </div>

                <div class="cliente-info">
                    <p><strong>Email:</strong> {{ $c['email'] ?? '—' }}</p>
                    <p><strong>Total servicios:</strong> {{ $c['total_servicios'] ?? 0 }}</p>
                    <p><strong>Total ventas:</strong> ${{ $c['total_ventas'] ?? 0 }}</p>
                </div>
            </div>
        @endforeach
    @endif
</body>
</html>
