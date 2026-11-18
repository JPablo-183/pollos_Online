@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
    <h1>Pedidos</h1>
    <p style="color:var(--muted)">Consulta los pedidos registrados en el sistema.</p>

    <section style="overflow-x:auto; margin-top:22px; border:1px solid var(--line); border-radius:20px; background:var(--surface);">
        <table style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:var(--surface-soft); color:var(--muted);">
                    <th style="padding:14px;">Cola</th>
                    <th style="padding:14px;">Código</th>
                    <th style="padding:14px;">Fecha</th>
                    <th style="padding:14px;">Registrado por</th>
                    <th style="padding:14px;">Platos</th>
                    <th style="padding:14px;">Total</th>
                    <th style="padding:14px;">Estado</th>
                    <th style="padding:14px;">Detalle</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pedidos as $pedido)
                    <tr style="border-top:1px solid var(--line); color:var(--text);">
                        <td style="padding:14px;">{{ $pedido->numero_cola }}</td>
                        <td style="padding:14px;">{{ $pedido->codigo }}</td>
                        <td style="padding:14px;">
                            {{ $pedido->fecha_creacion?->format('d/m/Y H:i') ?? '—' }}
                        </td>
                        <td style="padding:14px;">
                            {{ $pedido->usuario
                                ? $pedido->usuario->nombre . ' ' . $pedido->usuario->apellido
                                : 'Usuario no disponible' }}
                        </td>
                        <td style="padding:14px;">
                            {{ $pedido->detalles->sum('cantidad') }}
                        </td>
                        <td style="padding:14px;">
                            Bs {{ number_format((float) $pedido->monto_total, 2) }}
                        </td>
                        <td style="padding:14px;">
                            {{ (int) $pedido->estado === 0 ? 'Pendiente' : 'Estado ' . $pedido->estado }}
                        </td>
                        <td style="padding:14px;">
                            <a href="{{ route('admin.pedidos.show', $pedido->id) }}">Ver pedido</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding:24px; color:var(--muted); text-align:center;">
                            Todavía no hay pedidos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="padding:16px;">
            {{ $pedidos->links() }}
        </div>
    </section>
@endsection