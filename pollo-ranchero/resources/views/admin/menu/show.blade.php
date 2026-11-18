@extends('layouts.admin')

@section('title', 'Detalle del plato')

@section('content')
    <h1>{{ $plato->nombre }}</h1>
    <p class="muted">Detalle del plato registrado en el menú.</p>

    <section class="dish-details">
        <p><strong>Código:</strong> {{ $plato->codigo }}</p>
        <p><strong>Categoría:</strong> {{ $plato->categoria?->nombre ?? 'Sin categoría' }}</p>
        <p><strong>Descripción:</strong> {{ $plato->descripcion }}</p>
        <p><strong>Precio:</strong> Bs {{ number_format((float) $plato->precio, 2) }}</p>
        <p><strong>Estado:</strong> {{ $plato->estado ? 'Activo' : 'Inactivo' }}</p>

        <div class="actions">
            <a class="button" href="{{ route('admin.menu.index') }}">Volver</a>
            <a class="button button-primary" href="{{ route('admin.menu.edit', $plato->id) }}">Editar</a>
        </div>
    </section>

    <style>
        .muted { color:var(--muted); }
        .dish-details { max-width:720px; margin-top:22px; padding:24px; border:1px solid var(--line); border-radius:22px; color:var(--text); background:var(--surface); box-shadow:var(--shadow); }
        .dish-details p { padding-bottom:12px; border-bottom:1px solid var(--line); }
        .actions { display:flex; gap:10px; margin-top:20px; }
        .button { display:inline-flex; align-items:center; justify-content:center; min-height:40px; padding:0 14px; border:1px solid var(--line); border-radius:12px; color:var(--text); background:var(--surface-soft); text-decoration:none; font-weight:700; }
        .button-primary { border-color:var(--action); color:#fff; background:var(--action); }
    </style>
@endsection