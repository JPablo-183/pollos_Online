@extends('layouts.admin')

@section('title', 'Menú')

@section('content')
    <header class="menu-heading">
        <div>
            <span class="eyebrow">Administración</span>
            <h1>Menú</h1>
            <p>Administra los platos disponibles en el restaurante.</p>
        </div>

        <a class="button button-primary" href="{{ route('admin.menu.create') }}">
            ＋ Crear plato
        </a>
    </header>

    @if (session('success'))
        <div class="notice">{{ session('success') }}</div>
    @endif

    <section class="menu-card">
        <h2>Platos registrados <span>({{ $platos->total() }})</span></h2>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Plato</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($platos as $plato)
                        <tr>
                            <td>{{ $plato->codigo }}</td>
                            <td>
                                <strong>{{ $plato->nombre }}</strong>
                                <div class="muted">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($plato->descripcion), 70) }}
                                </div>
                            </td>
                            <td>{{ $plato->categoria?->nombre ?? 'Sin categoría' }}</td>
                            <td>Bs {{ number_format((float) $plato->precio, 2) }}</td>
                            <td>{{ $plato->estado ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                <div class="actions">
                                    <a class="button button-soft"
                                       href="{{ route('admin.menu.show', $plato->id) }}">Ver</a>
                                    <a class="button button-soft"
                                       href="{{ route('admin.menu.edit', $plato->id) }}">Editar</a>

                                    <form method="POST"
                                          action="{{ route('admin.menu.destroy', $plato->id) }}"
                                          onsubmit="return confirm('¿Retirar este plato del menú?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="button button-danger" type="submit">Retirar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">Todavía no hay platos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $platos->links() }}</div>
    </section>

    <style>
        .menu-heading { display:flex; justify-content:space-between; align-items:end; gap:18px; margin-bottom:24px; }
        .menu-heading h1 { margin:7px 0; font-size:clamp(30px,4vw,40px); }
        .menu-heading p,.muted { margin:0; color:var(--muted); }
        .eyebrow { color:var(--action); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
        .menu-card { overflow:hidden; border:1px solid var(--line); border-radius:22px; background:var(--surface); box-shadow:var(--shadow); }
        .menu-card h2 { margin:0; padding:20px; border-bottom:1px solid var(--line); font-size:18px; }
        .menu-card h2 span { color:var(--muted); font-weight:500; }
        .table-scroll { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; text-align:left; }
        th,td { padding:14px 16px; border-bottom:1px solid var(--line); vertical-align:middle; }
        th { color:var(--muted); background:var(--surface-soft); font-size:11px; text-transform:uppercase; }
        td { color:var(--text); font-size:13px; }
        .muted { margin-top:4px; font-size:12px; }
        .actions { display:flex; flex-wrap:wrap; gap:6px; }
        .actions form { margin:0; }
        .button { display:inline-flex; align-items:center; justify-content:center; min-height:36px; padding:0 12px; border:1px solid var(--line); border-radius:12px; color:var(--text); background:var(--surface-soft); text-decoration:none; cursor:pointer; font-size:12px; font-weight:700; }
        .button-primary,.button-danger { border-color:var(--action); color:#fff; background:var(--action); }
        .empty { padding:32px; color:var(--muted); text-align:center; }
        .notice { margin-bottom:18px; padding:13px 16px; border:1px solid var(--line); border-radius:14px; background:var(--surface); }
        .pagination { padding:16px; }
        @media(max-width:700px) { .menu-heading { align-items:flex-start; flex-direction:column; } }
    </style>
@endsection