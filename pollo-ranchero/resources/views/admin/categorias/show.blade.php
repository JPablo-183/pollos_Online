@extends('layouts.admin')

@section('title', 'Detalle de categoría')

@section('content')
    <header style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:24px;">
        <div>
            <span style="color:var(--action); font-size:11px; font-weight:800; text-transform:uppercase;">
                Administración
            </span>
            <h1 style="margin:7px 0;">{{ $categoria->nombre }}</h1>
            <p style="margin:0; color:var(--muted);">Detalle de la categoría.</p>
        </div>

        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.categorias.index') }}">Volver</a>
            <a href="{{ route('admin.categorias.edit', $categoria->id) }}">Editar</a>
        </div>
    </header>

    <section style="max-width:760px; padding:24px; border:1px solid var(--line); border-radius:20px; background:var(--surface);">
        <p><strong>Nombre:</strong> {{ $categoria->nombre }}</p>
        <p><strong>Descripción:</strong> {{ $categoria->descripcion }}</p>
        <p><strong>Estado:</strong> {{ $categoria->estado ? 'Activa' : 'Inactiva' }}</p>
        <p>
            <strong>Creada:</strong>
            {{ $categoria->fecha_creacion?->format('d/m/Y H:i') ?? '—' }}
        </p>
    </section>
@endsection