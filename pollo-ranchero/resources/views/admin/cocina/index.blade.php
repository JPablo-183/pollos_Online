@extends('layouts.admin')

@section('title', 'Cocina')

@section('content')
    <header style="margin-bottom:24px;">
        <span style="color:var(--action); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase;">
            Preparación
        </span>
        <h1 style="margin:7px 0;">Cocina</h1>
        <p style="margin:0; color:var(--muted);">Pedidos pendientes de preparación.</p>
    </header>

    @if (session('success'))
        <div class="kitchen-notice" role="status">
            {{ session('success') }}
        </div>
    @endif

    <section class="kitchen-grid">
        @forelse ($pedidos as $pedido)
            <article class="kitchen-card">
                <header class="kitchen-card-header">
                    <div>
                        <span class="queue-label">Cola</span>
                        <h2>{{ $pedido->numero_cola }}</h2>
                    </div>

                    <span class="pending-badge">Pendiente</span>
                </header>

                <p class="order-code">Pedido {{ $pedido->codigo }}</p>

                <ul class="dish-list">
                    @foreach ($pedido->detalles as $detalle)
                        <li>
                            <strong>{{ $detalle->cantidad }} ×</strong>
                            {{ $detalle->plato?->nombre ?? 'Plato no disponible' }}
                        </li>
                    @endforeach
                </ul>

                <footer class="kitchen-card-footer">
                    Recibido:
                    {{ $pedido->fecha_creacion?->format('H:i') ?? '—' }}
                </footer>

                <form method="POST"
                      action="{{ route('admin.cocina.servir', $pedido->id) }}"
                      class="serve-form">
                    @csrf
                    @method('PATCH')

                    <button class="serve-button" type="submit">
                        Marcar como servido
                    </button>
                </form>
            </article>
        @empty
            <div class="empty-kitchen">
                No hay pedidos pendientes en este momento.
            </div>
        @endforelse
    </section>

    <style>
        .kitchen-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 16px;
        }

        .kitchen-card {
            padding: 20px;
            border: 1px solid var(--line);
            border-radius: 22px 16px;
            color: var(--text);
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .kitchen-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .queue-label,
        .order-code,
        .kitchen-card-footer {
            color: var(--muted);
            font-size: 12px;
        }

        .kitchen-card-header h2 {
            margin: 3px 0 0;
            font-size: 30px;
        }

        .pending-badge {
            padding: 7px 11px;
            border-radius: 999px;
            color: var(--active-text);
            background: var(--active-bg);
            font-size: 11px;
            font-weight: 800;
        }

        .dish-list {
            display: grid;
            gap: 10px;
            margin: 20px 0;
            padding: 0;
            list-style: none;
        }

        .dish-list li {
            padding: 11px 12px;
            border-radius: 12px;
            background: var(--surface-soft);
        }

        .kitchen-card-footer {
            padding-top: 12px;
            border-top: 1px solid var(--line);
        }

        .kitchen-notice {
            margin-bottom: 16px;
            padding: 12px 16px;
            border: 1px solid var(--line);
            border-radius: 14px;
            color: var(--text);
            background: var(--surface);
        }

        .serve-form {
            margin-top: 14px;
        }

        .serve-button {
            width: 100%;
            min-height: 42px;
            border: 0;
            border-radius: 12px;
            color: #fff;
            background: var(--action);
            font-weight: 750;
            cursor: pointer;
        }

        .serve-button:hover {
            filter: brightness(1.08);
        }

        .empty-kitchen {
            grid-column: 1 / -1;
            padding: 28px;
            border: 1px dashed var(--line);
            border-radius: 18px;
            color: var(--muted);
            text-align: center;
        }
    </style>
@endsection