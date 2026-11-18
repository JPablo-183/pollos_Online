@extends('layouts.admin')

@section('title', $plato->exists ? 'Editar plato' : 'Crear plato')

@section('content')
    @php($editando = $plato->exists)

    <h1>{{ $editando ? 'Editar plato' : 'Crear plato' }}</h1>
    <p class="muted">Completa los datos del plato para el menú.</p>

    <form class="dish-form"
          method="POST"
          action="{{ $editando ? route('admin.menu.update', $plato->id) : route('admin.menu.store') }}">
        @csrf
        @if ($editando)
            @method('PUT')
        @endif

        <label for="categoria_id">Categoría</label>
        <select id="categoria_id" name="categoria_id" required>
            <option value="">Selecciona una categoría</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                    @selected((string) old('categoria_id', $plato->categoria_id) === (string) $categoria->id)>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
        @error('categoria_id') <small>{{ $message }}</small> @enderror

        <label for="codigo">Código</label>
        <input id="codigo" name="codigo" value="{{ old('codigo', $plato->codigo) }}" maxlength="100" required>
        @error('codigo') <small>{{ $message }}</small> @enderror

        <label for="nombre">Nombre del plato</label>
        <input id="nombre" name="nombre" value="{{ old('nombre', $plato->nombre) }}" maxlength="150" required>
        @error('nombre') <small>{{ $message }}</small> @enderror

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion', $plato->descripcion) }}</textarea>
        @error('descripcion') <small>{{ $message }}</small> @enderror

        <label for="precio">Precio (Bs)</label>
        <input id="precio" name="precio" type="number" min="0" step="0.01"
               value="{{ old('precio', $plato->precio) }}" required>
        @error('precio') <small>{{ $message }}</small> @enderror

        <label for="estado">Estado</label>
        <select id="estado" name="estado" required>
            <option value="1" @selected((string) old('estado', $plato->exists ? (int) $plato->estado : 1) === '1')>Activo</option>
            <option value="0" @selected((string) old('estado', $plato->exists ? (int) $plato->estado : 1) === '0')>Inactivo</option>
        </select>
        @error('estado') <small>{{ $message }}</small> @enderror

        <div class="form-actions">
            <a class="button" href="{{ route('admin.menu.index') }}">Cancelar</a>
            <button class="button button-primary" type="submit">
                {{ $editando ? 'Guardar cambios' : 'Crear plato' }}
            </button>
        </div>
    </form>

    <style>
        .muted { color:var(--muted); }
        .dish-form { display:grid; gap:9px; max-width:720px; margin-top:22px; padding:24px; border:1px solid var(--line); border-radius:22px; color:var(--text); background:var(--surface); box-shadow:var(--shadow); }
        .dish-form label { margin-top:8px; font-size:13px; font-weight:750; }
        .dish-form input,.dish-form select,.dish-form textarea { width:100%; padding:12px; border:1px solid var(--line); border-radius:12px; color:var(--text); background:var(--surface-soft); font:inherit; }
        .dish-form small { color:#B42318; }
        .form-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:16px; }
        .button { display:inline-flex; align-items:center; justify-content:center; min-height:40px; padding:0 14px; border:1px solid var(--line); border-radius:12px; color:var(--text); background:var(--surface-soft); text-decoration:none; cursor:pointer; font-weight:700; }
        .button-primary { border-color:var(--action); color:#fff; background:var(--action); }
    </style>
@endsection