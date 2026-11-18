<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $categorias = DB::table('categorias')
            ->where('estado', 1)
            ->where('eliminado', 0)
            ->count();

        $platos = DB::table('platos_menu')
            ->where('estado', 1)
            ->where('eliminado', 0)
            ->count();

        $pedidosEnCola = DB::table('pedidos')
            ->where('estado', 0)
            ->count();

        $ventasHoy = DB::table('pedidos')
            ->whereDate('fecha_creacion', today())
            ->sum('monto_total');

        return view('admin.dashboard', compact(
            'categorias',
            'platos',
            'pedidosEnCola',
            'ventasHoy'
        ));
    }
}