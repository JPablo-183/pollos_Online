<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::query()
            ->where('eliminado', 0)
            ->orderBy('nombre')
            ->paginate(12);

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        return view('admin.categorias.form', [
            'categoria' => new Categoria(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['required', 'string'],
            'estado' => ['required', 'in:0,1'],
        ]);

        $datos['estado'] = (int) $datos['estado'];
        $datos['eliminado'] = 0;
        $datos['fecha_creacion'] = now();

        Categoria::create($datos);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'La categoría se creó correctamente.');
    }

    public function show(int $id): View
    {
        $categoria = $this->buscarActiva($id);

        return view('admin.categorias.show', compact('categoria'));
    }

    public function edit(int $id): View
    {
        $categoria = $this->buscarActiva($id);

        return view('admin.categorias.form', compact('categoria'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $categoria = $this->buscarActiva($id);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['required', 'string'],
            'estado' => ['required', 'in:0,1'],
        ]);

        $datos['estado'] = (int) $datos['estado'];

        $categoria->update($datos);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'La categoría se actualizó correctamente.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $categoria = $this->buscarActiva($id);
        $categoria->update(['eliminado' => 1]);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'La categoría se retiró del listado.');
    }

    private function buscarActiva(int $id): Categoria
    {
        return Categoria::query()
            ->where('eliminado', 0)
            ->findOrFail($id);
    }
}