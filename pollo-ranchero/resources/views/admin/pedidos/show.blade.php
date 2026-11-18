@extends('layouts.admin')

@section('title', 'Detalle del pedido')

@section('content')
    <h1>Pedido {{ $pedido->numero_cola }}</h1>
    <p style="color:var(--muted)">Código: {{ $pedido->codigo }}</p>

    <section style="margin:22px 0; padding:20px; border:1px solid var(--line); border-radius:20px; color:var(--text); background:var(--surface);">
        <p><strong>Fecha:</strong> {{ $pedido->fecha_creacion?->format('d/m/Y H:i') ?? '—' }}</p>
        <p><strong>Registrado por:</strong>
            {{ $pedido->usuario
                ? $pedido->usuario->nombre . ' ' . $pedido->usuario->apellido
                : 'Usuario no disponible' }}
        </p>
        <p><strong>Estado:</strong>
            {{ (int) $pedido->estado === 0 ? 'Pendiente' : 'Estado ' . $pedido->estado }}
        </p>
    </section>

    <section style="overflow-x:auto; border:1px solid var(--line); border-radius:20px; background:var(--surface);">
        <table style="width:100%; border-collapse:collapse; text-align:left; color:var(--text);">
            <thead style="background:var(--surface-soft); color:var(--muted);">
                <tr>
                    <th style="padding:14px;">Plato</th>
                    <th style="padding:14px;">Precio</th>
                    <th style="padding:14px;">Cantidad</th>
                    <th style="padding:14px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido->detalles as $detalle)
                    <tr style="border-top:1px solid var(--line);">
                        <td style="padding:14px;">{{ $detalle->plato?->nombre ?? 'Plato no disponible' }}</td>
                        <td style="padding:14px;">Bs {{ number_format((float) $detalle->precio, 2) }}</td>
                        <td style="padding:14px;">{{ $detalle->cantidad }}</td>
                        <td style="padding:14px;">
                            Bs {{ number_format((float) $detalle->precio * $detalle->cantidad, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="padding:16px; text-align:right; color:var(--text);">
            <strong>Total: Bs {{ number_format((float) $pedido->monto_total, 2) }}</strong>
        </p>
    </section>

    <p style="margin-top:20px;">
        <a href="{{ route('admin.pedidos.index') }}">Volver a pedidos</a>
    </p>
@endsection