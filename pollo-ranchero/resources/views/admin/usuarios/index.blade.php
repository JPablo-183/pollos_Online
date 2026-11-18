@extends('layouts.admin')

@section('title', 'Usuarios')

@section('content')
    <header class="users-heading">
        <div>
            <span class="eyebrow">Administración</span>
            <h1>Usuarios</h1>
            <p>Administra las cuentas del personal.</p>
        </div>

        <div class="heading-actions">
            <a class="user-button user-button-soft" href="{{ route('admin.usuarios.perfil') }}">
                Mi perfil
            </a>
            <a class="user-button user-button-primary" href="{{ route('admin.usuarios.create') }}">
                ＋ Crear usuario
            </a>
        </div>
    </header>

    @if (session('success'))
        <div class="user-notice">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="user-notice user-error">{{ session('error') }}</div>
    @endif

    <section class="users-card">
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha de registro</th>
                        <th>Avatar</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuarios->firstItem() + $loop->index }}</td>
                            <td>{{ $usuario->fecha_registro?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td>
                                @if ($usuario->imagen_perfil)
                                    <img class="user-avatar"
                                         src="{{ asset('storage/' . $usuario->imagen_perfil) }}"
                                         alt="Avatar de {{ $usuario->nombre }}">
                                @else
                                    <span class="avatar-placeholder">
                                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $usuario->nombre }} {{ $usuario->segundo_nombre }} {{ $usuario->apellido }}</td>
                            <td>{{ $usuario->nombre_usuario }}</td>
                            <td>
                                @switch((int) $usuario->tipo)
                                    @case(1) Administrador @break
                                    @case(2) Mesero @break
                                    @case(3) Cocina @break
                                    @default N/A
                                @endswitch
                            </td>
                            <td>
                                <div class="user-actions">
                                    <a class="user-button user-button-soft"
                                       href="{{ route('admin.usuarios.edit', $usuario->id) }}">
                                        Editar
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                                          onsubmit="return confirm('¿Eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="user-button user-button-danger" type="submit">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-row">No hay otros usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $usuarios->links() }}</div>
    </section>

    <style>
        .users-heading { display:flex; justify-content:space-between; align-items:end; gap:16px; margin-bottom:22px; }
        .users-heading h1 { margin:7px 0; font-size:clamp(30px,4vw,40px); }
        .users-heading p { margin:0; color:var(--muted); }
        .eyebrow { color:var(--action); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
        .heading-actions,.user-actions { display:flex; flex-wrap:wrap; gap:8px; }
        .users-card { overflow:hidden; border:1px solid var(--line); border-radius:20px; background:var(--surface); box-shadow:var(--shadow); }
        .table-scroll { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; text-align:left; color:var(--text); }
        th,td { padding:12px 14px; border-bottom:1px solid var(--line); }
        th { color:var(--muted); background:var(--surface-soft); font-size:11px; text-transform:uppercase; }
        td { font-size:13px; }
        .user-avatar,.avatar-placeholder { width:42px; height:42px; display:inline-grid; place-items:center; border-radius:50%; object-fit:cover; }
        .avatar-placeholder { color:#1A0000; background:var(--gold); font-weight:800; }
        .user-button { display:inline-flex; align-items:center; justify-content:center; min-height:36px; padding:0 12px; border:1px solid var(--line); border-radius:11px; color:var(--text); background:var(--surface-soft); text-decoration:none; cursor:pointer; font-size:12px; font-weight:700; }
        .user-button-primary,.user-button-danger { border-color:var(--action); color:#fff; background:var(--action); }
        .user-actions form { margin:0; }
        .user-notice { margin-bottom:16px; padding:12px 15px; border:1px solid var(--line); border-radius:12px; color:var(--text); background:var(--surface); }
        .user-error { border-color:#B42318; }
        .empty-row { padding:24px; color:var(--muted); text-align:center; }
        .pagination { padding:14px; }
        @media(max-width:700px) { .users-heading { align-items:flex-start; flex-direction:column; } }
    </style>
@endsection