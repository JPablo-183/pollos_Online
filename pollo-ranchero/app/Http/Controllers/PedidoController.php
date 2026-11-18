<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function index(): View
    {
        $pedidos = Pedido::with(['usuario', 'detalles.plato'])
            ->orderByDesc('fecha_creacion')
            ->paginate(15);

        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show(string $id): View
    {
        $pedido = Pedido::with(['usuario', 'detalles.plato'])
            ->findOrFail($id);

        return view('admin.pedidos.show', compact('pedido'));
    }
}