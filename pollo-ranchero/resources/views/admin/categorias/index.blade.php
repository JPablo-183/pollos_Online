@extends('layouts.admin')

@section('title', 'Categorías')

@section('content')
<section class="categories-page">
    <header class="page-heading">
        <div>
            <span class="eyebrow">Administración</span>
            <h1>Categorías</h1>
            <p>Organiza las categorías disponibles en el menú.</p>
        </div>

        <a class="button button-primary" href="{{ route('admin.categorias.create') }}">
            <span aria-hidden="true">＋</span>
            Crear categoría
        </a>
    </header>

    @if (session('success'))
        <div class="notice" role="status">{{ session('success') }}</div>
    @endif

    <section class="category-card">
        <div class="card-heading">
            <div>
                <h2>Lista de categorías</h2>
                <p>{{ $categorias->total() }} registro(s)</p>
            </div>
        </div>

        <div class="table-scroll">
            <table class="category-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha de creación</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>{{ $categorias->firstItem() + $loop->index }}</td>
                            <td>{{ $categoria->fecha_creacion?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td class="category-name">{{ $categoria->nombre }}</td>
                            <td class="description">
                                {{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($categoria->descripcion)), 100) }}
                            </td>
                            <td>
                                @if ($categoria->estado)
                                    <span class="status status-active">Activa</span>
                                @else
                                    <span class="status status-inactive">Inactiva</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="button button-soft"
                                       href="{{ route('admin.categorias.show', $categoria->id) }}">
                                        Ver
                                    </a>

                                    <a class="button button-soft"
                                       href="{{ route('admin.categorias.edit', $categoria->id) }}">
                                        Editar
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.categorias.destroy', $categoria->id) }}"
                                          onsubmit="return confirm('¿Retirar esta categoría del listado?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="button button-danger" type="submit">
                                            Retirar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                Todavía no hay categorías registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categorias->hasPages())
            <nav class="pagination" aria-label="Paginación de categorías">
                @if ($categorias->onFirstPage())
                    <span class="page-disabled">Anterior</span>
                @else
                    <a href="{{ $categorias->previousPageUrl() }}">Anterior</a>
                @endif

                <span>Página {{ $categorias->currentPage() }} de {{ $categorias->lastPage() }}</span>

                @if ($categorias->hasMorePages())
                    <a href="{{ $categorias->nextPageUrl() }}">Siguiente</a>
                @else
                    <span class="page-disabled">Siguiente</span>
                @endif
            </nav>
        @endif
    </section>
</section>

<style>
    .categories-page {
        color: var(--text);
    }

    .page-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 24px;
    }

    .eyebrow {
        color: var(--action);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .page-heading h1 {
        margin: 7px 0;
        font-size: clamp(30px, 4vw, 40px);
        letter-spacing: -.04em;
    }

    .page-heading p,
    .card-heading p {
        margin: 0;
        color: var(--muted);
    }

    .button {
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0 14px;
        border: 1px solid transparent;
        border-radius: 14px 10px 14px 10px;
        font-size: 13px;
        font-weight: 750;
        text-decoration: none;
        cursor: pointer;
        transition: transform .2s ease, filter .2s ease;
    }

    .button:hover {
        filter: brightness(1.08);
        transform: translateY(-1px);
    }

    .button-primary,
    .button-danger {
        color: #fff;
        background: var(--action);
    }

    .button-soft {
        border-color: var(--line);
        color: var(--text);
        background: var(--surface-soft);
    }

    .notice {
        margin-bottom: 18px;
        padding: 13px 16px;
        border: 1px solid var(--line);
        border-radius: 16px;
        color: var(--text);
        background: var(--surface-soft);
    }

    .category-card {
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: 24px 17px 24px 17px;
        background: var(--surface);
        box-shadow: var(--shadow);
    }

    .card-heading {
        padding: 20px 22px;
        border-bottom: 1px solid var(--line);
    }

    .card-heading h2 {
        margin: 0 0 5px;
        font-size: 18px;
    }

    .card-heading p {
        font-size: 13px;
    }

    .table-scroll {
        overflow-x: auto;
    }

    .category-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .category-table th,
    .category-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--line);
        vertical-align: middle;
    }

    .category-table th {
        color: var(--muted);
        background: var(--surface-soft);
        font-size: 11px;
        letter-spacing: .06em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .category-table td {
        color: var(--text);
        font-size: 13px;
    }

    .category-name {
        font-weight: 750;
    }

    .description {
        min-width: 220px;
        color: var(--muted) !important;
    }

    .status {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
    }

    .status-active {
        color: #1A0000;
        background: var(--gold);
    }

    .status-inactive {
        border: 1px solid var(--line);
        color: var(--muted);
        background: var(--surface-soft);
    }

    .actions {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .actions form {
        margin: 0;
    }

    .actions .button {
        min-height: 34px;
        padding: 0 10px;
        font-size: 11px;
    }

    .empty-state {
        padding: 34px !important;
        color: var(--muted) !important;
        text-align: center;
    }

    .pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 18px;
        color: var(--muted);
        font-size: 13px;
    }

    .pagination a,
    .page-disabled {
        padding: 8px 12px;
        border: 1px solid var(--line);
        border-radius: 999px;
        color: var(--text);
        background: var(--surface-soft);
        text-decoration: none;
    }

    .page-disabled {
        opacity: .5;
    }

    @media (max-width: 700px) {
        .page-heading {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endsection