@extends('layouts.admin')

@section('title', 'Recibo del pedido')

@section('content')
    @php
        $cambio = (float) $pedido->monto_recibido - (float) $pedido->monto_total;
    @endphp

    <div class="receipt-actions">
        <a href="{{ route('admin.punto_venta.index') }}">Volver al Punto de venta</a>
        <button type="button" onclick="window.print()">Imprimir de nuevo</button>
    </div>

    <article class="receipt">
        <header class="receipt-header">
            <h1>Pollo's Ranchero</h1>
            <p>Recibo de venta</p>
        </header>

        <dl class="receipt-data">
            <div>
                <dt>Número de transacción</dt>
                <dd>{{ $pedido->codigo }}</dd>
            </div>
            <div>
                <dt>Fecha y hora</dt>
                <dd>{{ $pedido->fecha_creacion?->format('d/m/Y H:i') ?? '—' }}</dd>
            </div>
            <div>
                <dt>Generado por</dt>
                <dd>{{ $pedido->usuario?->nombre_usuario ?? 'N/A' }}</dd>
            </div>
        </dl>

        <div class="receipt-items">
            <div class="receipt-row receipt-items-heading">
                <span>Cant.</span>
                <span>Pedido</span>
                <span>Total</span>
            </div>

            @foreach ($pedido->detalles as $detalle)
                <div class="receipt-row">
                    <span>{{ $detalle->cantidad }}</span>
                    <span>
                        {{ $detalle->plato?->codigo ?? '' }}
                        {{ $detalle->plato?->nombre ?? 'Plato no disponible' }}
                        <small>x Bs {{ number_format((float) $detalle->precio, 2) }}</small>
                    </span>
                    <span>
                        Bs {{ number_format((float) $detalle->precio * $detalle->cantidad, 2) }}
                    </span>
                </div>
            @endforeach
        </div>

        <dl class="receipt-totals">
            <div>
                <dt>Total</dt>
                <dd>Bs {{ number_format((float) $pedido->monto_total, 2) }}</dd>
            </div>
            <div>
                <dt>Pago</dt>
                <dd>Bs {{ number_format((float) $pedido->monto_recibido, 2) }}</dd>
            </div>
            <div>
                <dt>Cambio</dt>
                <dd>Bs {{ number_format($cambio, 2) }}</dd>
            </div>
        </dl>

        <footer class="queue-number">
            <span>Cola #</span>
            <strong>{{ $pedido->numero_cola }}</strong>
        </footer>
    </article>

    <style>
        .receipt-actions {
            display:flex;
            justify-content:center;
            gap:12px;
            margin-bottom:20px;
        }

        .receipt-actions a,
        .receipt-actions button {
            padding:10px 14px;
            border:1px solid var(--line);
            border-radius:12px;
            color:var(--text);
            background:var(--surface);
            text-decoration:none;
            cursor:pointer;
        }

        .receipt {
            width:min(100%, 440px);
            margin:0 auto;
            padding:24px;
            border:1px solid var(--line);
            border-radius:16px;
            color:var(--text);
            background:var(--surface);
            box-shadow:var(--shadow);
            font-size:13px;
        }

        .receipt-header { text-align:center; }
        .receipt-header h1 { margin:0; font-size:21px; }
        .receipt-header p { margin:5px 0 18px; color:var(--muted); }

        .receipt-data,
        .receipt-totals { margin:0; }

        .receipt-data div,
        .receipt-totals div {
            display:flex;
            justify-content:space-between;
            gap:12px;
            padding:7px 0;
        }

        .receipt-data {
            padding-bottom:10px;
            border-bottom:1px dashed var(--line);
        }

        .receipt-data dt,
        .receipt-totals dt { color:var(--muted); }

        .receipt-data dd,
        .receipt-totals dd {
            margin:0;
            text-align:right;
        }

        .receipt-items { margin:12px 0; }
        .receipt-row {
            display:grid;
            grid-template-columns:48px minmax(0, 1fr) 95px;
            gap:8px;
            padding:8px 0;
            border-bottom:1px solid var(--line);
        }

        .receipt-row span:last-child { text-align:right; }
        .receipt-items-heading { font-weight:800; }
        .receipt-row small { display:block; color:var(--muted); }

        .receipt-totals {
            padding-top:8px;
            border-top:1px dashed var(--line);
        }

        .queue-number {
            display:grid;
            justify-items:center;
            gap:4px;
            margin-top:14px;
            padding-top:14px;
            border-top:1px dashed var(--line);
        }

        .queue-number strong { font-size:28px; }

        @media print {
            .receipt-actions { display:none !important; }
            .receipt {
                width:100%;
                max-width:76mm;
                margin:0 auto;
                padding:0;
                border:0;
                border-radius:0;
                color:#000;
                background:#fff;
                box-shadow:none;
                font-size:11px;
            }

            .receipt-data dt,
            .receipt-header p,
            .receipt-row small { color:#333; }

            @page { size:80mm auto; margin:4mm; }
        }
    </style>

    <script>
        window.addEventListener('load', () => window.print());
    </script>
@endsection