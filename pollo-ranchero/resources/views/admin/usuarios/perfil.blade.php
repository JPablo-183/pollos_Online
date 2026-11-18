@extends('layouts.admin')

@section('title', 'Mi perfil')

@section('content')
    <header style="margin-bottom:24px;">
        <span style="color:var(--action); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase;">
            Cuenta
        </span>
        <h1 style="margin:7px 0;">Mi perfil</h1>
        <p style="margin:0; color:var(--muted);">Actualiza tus datos personales y de acceso.</p>
    </header>

    @if (session('success'))
        <div class="profile-notice">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="profile-notice profile-error">
            <strong>Revisa estos datos:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        class="profile-form"
        method="POST"
        action="{{ route('admin.usuarios.perfil.actualizar') }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        <label for="nombre">Nombre</label>
        <input
            id="nombre"
            name="nombre"
            value="{{ old('nombre', $usuario->nombre) }}"
            required
            maxlength="100"
        >
        @error('nombre') <small>{{ $message }}</small> @enderror

        <label for="segundo_nombre">Segundo nombre</label>
        <input
            id="segundo_nombre"
            name="segundo_nombre"
            value="{{ old('segundo_nombre', $usuario->segundo_nombre) }}"
            maxlength="100"
        >
        @error('segundo_nombre') <small>{{ $message }}</small> @enderror

        <label for="apellido">Apellido</label>
        <input
            id="apellido"
            name="apellido"
            value="{{ old('apellido', $usuario->apellido) }}"
            required
            maxlength="100"
        >
        @error('apellido') <small>{{ $message }}</small> @enderror

        <label for="nombre_usuario">Nombre de usuario</label>
        <input
            id="nombre_usuario"
            name="nombre_usuario"
            value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}"
            required
            maxlength="100"
        >
        @error('nombre_usuario') <small>{{ $message }}</small> @enderror

        <label for="contrasena">Nueva contraseña (opcional)</label>
        <input
            id="contrasena"
            name="contrasena"
            type="password"
            minlength="8"
            autocomplete="new-password"
        >
        <small>Déjalo vacío si no quieres cambiar tu contraseña.</small>
        @error('contrasena') <small>{{ $message }}</small> @enderror

        <label for="imagen_perfil">Foto de perfil (JPG o PNG, máximo 2 MB)</label>
        <input
            id="imagen_perfil"
            name="imagen_perfil"
            type="file"
            accept=".jpg,.jpeg,.png"
        >
        @error('imagen_perfil') <small>{{ $message }}</small> @enderror

        @if ($usuario->imagen_perfil)
            <img
                class="profile-avatar"
                src="{{ asset('storage/' . $usuario->imagen_perfil) }}"
                alt="Foto de perfil actual"
            >
        @endif

        <div class="profile-actions">
            <button class="profile-button" type="submit">Guardar cambios</button>
        </div>
    </form>

    <style>
        .profile-form {
            display: grid;
            gap: 10px;
            max-width: 680px;
            padding: 24px;
            border: 1px solid var(--line);
            border-radius: 22px 16px;
            color: var(--text);
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .profile-form label {
            margin-top: 8px;
            font-size: 13px;
            font-weight: 750;
        }

        .profile-form input {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid var(--line);
            border-radius: 11px;
            color: var(--text);
            background: var(--surface-soft);
        }

        .profile-form small,
        .profile-form small + small {
            color: var(--muted);
            font-size: 12px;
        }

        .profile-form small:has(+ *) {
            color: #B42318;
        }

        .profile-avatar {
            width: 96px;
            height: 96px;
            border: 1px solid var(--line);
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 12px;
        }

        .profile-button {
            min-height: 42px;
            padding: 0 16px;
            border: 0;
            border-radius: 14px 10px;
            color: #fff;
            background: var(--action);
            font-weight: 750;
            cursor: pointer;
        }

        .profile-notice {
            max-width: 680px;
            margin-bottom: 16px;
            padding: 13px 16px;
            border: 1px solid var(--line);
            border-radius: 14px;
            color: var(--text);
            background: var(--surface);
        }

        .profile-error {
            border-color: #B42318;
        }
    </style>
@endsection