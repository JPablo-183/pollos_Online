@extends('layouts.admin')

@section('title', $categoria->exists ? 'Editar categoría' : 'Crear categoría')

@section('content')
    @php($editando = $categoria->exists)

    <section class="category-form-page">
        <header class="form-heading">
            <div>
                <span class="eyebrow">Administración</span>
                <h1>{{ $editando ? 'Editar categoría' : 'Crear categoría' }}</h1>
                <p>Completa los datos de la categoría del menú.</p>
            </div>

            <a class="form-button form-button-soft"
               href="{{ route('admin.categorias.index') }}">
                Volver al listado
            </a>
        </header>

        <form class="form-card"
              method="POST"
              action="{{ $editando
                  ? route('admin.categorias.update', $categoria->id)
                  : route('admin.categorias.store') }}">
            @csrf

            @if ($editando)
                @method('PUT')
            @endif

            <div class="form-field">
                <label for="nombre">Nombre</label>
                <input
                    id="nombre"
                    name="nombre"
                    type="text"
                    value="{{ old('nombre', $categoria->nombre) }}"
                    maxlength="100"
                    required
                    autofocus
                >
                @error('nombre')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-field">
                <label for="descripcion">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="5"
                    required
                >{{ old('descripcion', $categoria->descripcion) }}</textarea>
                @error('descripcion')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-field">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="1"
                        @selected((string) old('estado', $categoria->exists ? (int) $categoria->estado : 1) === '1')>
                        Activa
                    </option>
                    <option value="0"
                        @selected((string) old('estado', $categoria->exists ? (int) $categoria->estado : 1) === '0')>
                        Inactiva
                    </option>
                </select>
                @error('estado')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-actions">
                <a class="form-button form-button-soft"
                   href="{{ route('admin.categorias.index') }}">
                    Cancelar
                </a>

                <button class="form-button form-button-primary" type="submit">
                    {{ $editando ? 'Guardar cambios' : 'Crear categoría' }}
                </button>
            </div>
        </form>
    </section>

    <style>
        .category-form-page {
            color: var(--text);
        }

        .form-heading {
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

        .form-heading h1 {
            margin: 7px 0;
            font-size: clamp(28px, 4vw, 38px);
        }

        .form-heading p {
            margin: 0;
            color: var(--muted);
        }

        .form-card {
            max-width: 760px;
            padding: 24px;
            border: 1px solid var(--line);
            border-radius: 24px 17px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .form-field {
            display: grid;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-field label {
            font-size: 13px;
            font-weight: 750;
        }

        .form-field input,
        .form-field textarea,
        .form-field select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 12px;
            color: var(--text);
            background: var(--surface-soft);
            font: inherit;
        }

        .form-field textarea {
            resize: vertical;
        }

        .field-error {
            color: #B42318;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 8px;
        }

        .form-button {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
            border: 1px solid transparent;
            border-radius: 14px 10px;
            font-size: 13px;
            font-weight: 750;
            text-decoration: none;
            cursor: pointer;
        }

        .form-button-primary {
            color: #fff;
            background: var(--action);
        }

        .form-button-soft {
            border-color: var(--line);
            color: var(--text);
            background: var(--surface-soft);
        }

        @media (max-width: 650px) {
            .form-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .form-card {
                padding: 18px;
            }
        }
    </style>
@endsection