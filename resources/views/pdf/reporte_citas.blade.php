<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reporte de citas y clientes</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
      margin: 20px;
      color: #333;
    }

    .page-container {
      max-width: 100%;
      margin: 0 auto;
    }

    .report-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
    }

    .title {
      text-align: center;
      margin-bottom: 20px;
      font-size: 18px;
      font-weight: bold;
      color: #222;
    }

    .report-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .report-item {
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 10px 12px;
      margin-bottom: 10px;
      background: #f9f9f9;
    }

    .cita-header {
      font-weight: bold;
      background: #f2f2f2;
      padding: 6px 8px;
      border-radius: 4px;
      margin-bottom: 5px;
    }

    .cita-body {
      margin: 4px 0;
    }

    .meta {
      color: #777;
      font-size: 11px;
      margin-left: 6px;
    }

    .cita-footer {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      margin-top: 6px;
      border-top: 1px dashed #ccc;
      padding-top: 4px;
    }

    .estado {
      text-transform: uppercase;
      font-weight: bold;
      color: #007bff;
    }

    .empty {
      text-align: center;
      color: #999;
      margin-top: 20px;
    }

    .footer {
      text-align: right;
      font-size: 10px;
      color: #666;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="page-container">
    <div class="report-card">
      <h2 class="title">Reportes de citas y clientes</h2>

      @if (count($citas))
        <ul class="report-list">
          @foreach ($citas as $c)
            <li class="report-item">
              <div class="cita-header">
                Cita #{{ $c->id }} — Fecha: {{ $c->fecha }} Hora: {{ $c->hora }}
              </div>

              <div class="cita-body">
                <strong>Cliente:</strong>
                <span>{{ $c->cliente->first_name }} {{ $c->cliente->last_name ?? '' }}</span>
                <span class="meta">({{ $c->cliente->document }})</span>
              </div>

              <div class="cita-footer">
                <small>Total servicio: {{ $c->total_service ?? '-' }}</small>
                <small class="estado">Estado: {{ $c->status }}</small>
              </div>
            </li>
          @endforeach
        </ul>
      @else
        <div class="empty">No hay registros para mostrar</div>
      @endif

      <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }}
      </div>
    </div>
  </div>
</body>
</html>
