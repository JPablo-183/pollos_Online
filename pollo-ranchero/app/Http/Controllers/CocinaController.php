<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CocinaController extends Controller
{
    public function index(): View
    {
        $pedidos = Pedido::with(['detalles.plato'])
            ->where('estado', 0)
            ->orderBy('fecha_creacion')
            ->get();

        return view('admin.cocina.index', compact('pedidos'));
    }

    public function servir(string $id): RedirectResponse
    {
        $pedido = Pedido::where('estado', 0)->findOrFail($id);
        $pedido->update(['estado' => 1]);

        return redirect()
            ->route('admin.cocina.index')
            ->with('success', "El pedido {$pedido->numero_cola} fue marcado como servido.");
    }
}