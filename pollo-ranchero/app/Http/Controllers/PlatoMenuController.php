<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\PlatoMenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PlatoMenuController extends Controller
{
    public function index(): View
    {
        $platos = PlatoMenu::with('categoria')
            ->where('eliminado', 0)
            ->orderBy('codigo')
            ->orderBy('nombre')
            ->paginate(12);

        return view('admin.menu.index', compact('platos'));
    }

    public function create(): View
    {
        $categorias = Categoria::where('estado', 1)
            ->where('eliminado', 0)
            ->orderBy('nombre')
            ->get();

        return view('admin.menu.form', [
            'plato' => new PlatoMenu(),
            'categorias' => $categorias,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        PlatoMenu::create($this->validarPlato($request) + ['eliminado' => 0]);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Plato creado correctamente.');
    }

    public function show(string $id): View
    {
        $plato = PlatoMenu::with('categoria')
            ->where('eliminado', 0)
            ->findOrFail($id);

        return view('admin.menu.show', compact('plato'));
    }

    public function edit(string $id): View
    {
        $plato = PlatoMenu::where('eliminado', 0)->findOrFail($id);

        $categorias = Categoria::where(function ($consulta) use ($plato) {
            $consulta->where(function ($activas) {
                $activas->where('estado', 1)->where('eliminado', 0);
            })->orWhere('id', $plato->categoria_id);
        })
            ->orderBy('nombre')
            ->get();

        return view('admin.menu.form', compact('plato', 'categorias'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $plato = PlatoMenu::where('eliminado', 0)->findOrFail($id);
        $plato->update($this->validarPlato($request, $plato));

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Plato actualizado correctamente.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $plato = PlatoMenu::where('eliminado', 0)->findOrFail($id);
        $plato->update(['eliminado' => 1]);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Plato retirado del listado.');
    }

    private function validarPlato(Request $request, ?PlatoMenu $plato = null): array
    {
        $codigoUnico = Rule::unique('platos_menu', 'codigo')
            ->where(fn($consulta) => $consulta->where('eliminado', 0));

        if ($plato !== null) {
            $codigoUnico->ignore($plato->id);
        }

        return $request->validate([
            'categoria_id' => ['required', 'integer', Rule::exists('categorias', 'id')],
            'codigo' => ['required', 'string', 'max:100', $codigoUnico],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string'],
            'precio' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'estado' => ['required', 'boolean'],
        ]);
    }
}