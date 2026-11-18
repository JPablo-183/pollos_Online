<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(): View
    {
        $usuarios = User::where('id', '!=', auth()->id())
            ->orderBy('nombre')
            ->paginate(12);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create(): View
    {
        return view('admin.usuarios.form', [
            'usuario' => new User(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'segundo_nombre' => ['nullable', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'nombre_usuario' => ['required', 'string', 'max:100', 'unique:usuarios,nombre_usuario'],
            'contrasena' => ['required', 'string', 'min:8'],
            'tipo' => ['required', Rule::in([1, 2, 3])],
            'imagen_perfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        unset($datos['imagen_perfil']);

        if ($request->hasFile('imagen_perfil')) {
            $datos['imagen_perfil'] = $request->file('imagen_perfil')->store('avatars', 'public');
        }

        User::create($datos);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(string $id): View
    {
        $usuario = User::findOrFail($id);

        return view('admin.usuarios.form', compact('usuario'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $usuario = User::findOrFail($id);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'segundo_nombre' => ['nullable', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'nombre_usuario' => [
                'required',
                'string',
                'max:100',
                Rule::unique('usuarios', 'nombre_usuario')->ignore($usuario->id),
            ],
            'contrasena' => ['nullable', 'string', 'min:8'],
            'tipo' => ['required', Rule::in([1, 2, 3])],
            'imagen_perfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if (empty($datos['contrasena'])) {
            unset($datos['contrasena']);
        }

        unset($datos['imagen_perfil']);

        if ($request->hasFile('imagen_perfil')) {
            if ($usuario->imagen_perfil) {
                Storage::disk('public')->delete($usuario->imagen_perfil);
            }

            $datos['imagen_perfil'] = $request->file('imagen_perfil')->store('avatars', 'public');
        }

        $usuario->update($datos);

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        if ((int) $id === (int) auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario = User::findOrFail($id);

        if ($usuario->imagen_perfil) {
            Storage::disk('public')->delete($usuario->imagen_perfil);
        }

        $usuario->delete();

        return redirect()
            ->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    public function perfil(): View
    {
        return view('admin.usuarios.perfil', [
            'usuario' => auth()->user(),
        ]);
    }

    public function actualizarPerfil(Request $request): RedirectResponse
    {
        $usuario = auth()->user();

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'segundo_nombre' => ['nullable', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'nombre_usuario' => [
                'required',
                'string',
                'max:100',
                Rule::unique('usuarios', 'nombre_usuario')->ignore($usuario->id),
            ],
            'contrasena' => ['nullable', 'string', 'min:8'],
            'imagen_perfil' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if (empty($datos['contrasena'])) {
            unset($datos['contrasena']);
        }

        unset($datos['imagen_perfil']);

        if ($request->hasFile('imagen_perfil')) {
            if ($usuario->imagen_perfil) {
                Storage::disk('public')->delete($usuario->imagen_perfil);
            }

            $datos['imagen_perfil'] = $request->file('imagen_perfil')->store('avatars', 'public');
        }

        $usuario->update($datos);

        return redirect()
            ->route('admin.usuarios.perfil')
            ->with('success', 'Tu perfil se actualizó correctamente.');
    }
}