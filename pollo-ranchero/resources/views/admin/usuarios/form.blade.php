@extends('layouts.admin')

@section('title', $usuario->exists ? 'Editar usuario' : 'Crear usuario')

@section('content')
    @php($editando = $usuario->exists)

    <h1>{{ $editando ? 'Editar usuario' : 'Crear usuario' }}</h1>
    <p class="muted">Completa los datos de la cuenta del personal.</p>

    <form class="user-form"
          method="POST"
          enctype="multipart/form-data"
          action="{{ $editando
              ? route('admin.usuarios.update', $usuario->id)
              : route('admin.usuarios.store') }}">
        @csrf
        @if ($editando)
            @method('PUT')
        @endif

        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
        @error('nombre') <small>{{ $message }}</small> @enderror

        <label for="segundo_nombre">Segundo nombre</label>
        <input id="segundo_nombre" name="segundo_nombre"
               value="{{ old('segundo_nombre', $usuario->segundo_nombre) }}">
        @error('segundo_nombre') <small>{{ $message }}</small> @enderror

        <label for="apellido">Apellido</label>
        <input id="apellido" name="apellido" value="{{ old('apellido', $usuario->apellido) }}" required>
        @error('apellido') <small>{{ $message }}</small> @enderror

        <label for="nombre_usuario">Usuario</label>
        <input id="nombre_usuario" name="nombre_usuario"
               value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}" required>
        @error('nombre_usuario') <small>{{ $message }}</small> @enderror

        <label for="contrasena">{{ $editando ? 'Nueva contraseña (opcional)' : 'Contraseña' }}</label>
        <input id="contrasena" name="contrasena" type="password"
               {{ $editando ? '' : 'required' }} minlength="8" autocomplete="new-password">
        @error('contrasena') <small>{{ $message }}</small> @enderror

        <label for="tipo">Tipo de usuario</label>
        <select id="tipo" name="tipo" required>
            <option value="1" @selected((string) old('tipo', $usuario->tipo ?: 2) === '1')>Administrador</option>
            <option value="2" @selected((string) old('tipo', $usuario->tipo ?: 2) === '2')>Mesero</option>
            <option value="3" @selected((string) old('tipo', $usuario->tipo ?: 2) === '3')>Cocina</option>
        </select>
        @error('tipo') <small>{{ $message }}</small> @enderror

        <label for="imagen_perfil">Avatar (JPG o PNG, máximo 2 MB)</label>
        <input id="imagen_perfil" name="imagen_perfil" type="file" accept=".jpg,.jpeg,.png">
        @error('imagen_perfil') <small>{{ $message }}</small> @enderror

        @if ($usuario->imagen_perfil)
            <img class="user-avatar-preview"
                 src="{{ asset('storage/' . $usuario->imagen_perfil) }}"
                 alt="Avatar actual">
        @endif

        <div class="form-actions">
            <a class="user-button user-button-soft" href="{{ route('admin.usuarios.index') }}">Cancelar</a>
            <button class="user-button user-button-primary" type="submit">
                {{ $editando ? 'Guardar cambios' : 'Crear usuario' }}
            </button>
        </div>
    </form>

    <style>
        .muted { color:var(--muted); }
        .user-form { display:grid; gap:9px; max-width:700px; margin-top:22px; padding:22px; border:1px solid var(--line); border-radius:20px; color:var(--text); background:var(--surface); box-shadow:var(--shadow); }
        .user-form label { margin-top:8px; font-size:13px; font-weight:750; }
        .user-form input,.user-form select { width:100%; padding:11px; border:1px solid var(--line); border-radius:10px; color:var(--text); background:var(--surface-soft); }
        .user-form small { color:#B42318; }
        .user-avatar-preview { width:90px; height:90px; border-radius:50%; object-fit:cover; }
        .form-actions { display:flex; justify-content:flex-end; gap:9px; margin-top:14px; }
        .user-button { display:inline-flex; align-items:center; justify-content:center; min-height:40px; padding:0 14px; border:1px solid var(--line); border-radius:11px; color:var(--text); background:var(--surface-soft); text-decoration:none; cursor:pointer; font-weight:700; }
        .user-button-primary { border-color:var(--action); color:#fff; background:var(--action); }
    </style>
@endsection