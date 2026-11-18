<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReporteController extends Controller
{
    public function index(Request $request): View
    {
        $datos = $request->validate([
            'periodo' => [
                'nullable',
                Rule::in(['diario', 'semanal', 'semestral', 'anual', 'personalizado']),
            ],
            'fecha' => ['nullable', 'date'],
            'desde' => ['nullable', 'required_if:periodo,personalizado', 'date'],
            'hasta' => [
                'nullable',
                'required_if:periodo,personalizado',
                'date',
                'after_or_equal:desde',
            ],
        ]);

        $periodo = $datos['periodo'] ?? 'diario';
        $fecha = CarbonImmutable::parse($datos['fecha'] ?? now()->toDateString());

        switch ($periodo) {
            case 'semanal':
                $inicio = $fecha->startOfWeek(Carbon::MONDAY);
                $fin = $inicio->addDays(6);
                break;

            case 'semestral':
                if ($fecha->month <= 6) {
                    $inicio = $fecha->setDate($fecha->year, 1, 1);
                    $fin = $fecha->setDate($fecha->year, 6, 30);
                } else {
                    $inicio = $fecha->setDate($fecha->year, 7, 1);
                    $fin = $fecha->setDate($fecha->year, 12, 31);
                }
                break;

            case 'anual':
                $inicio = $fecha->startOfYear();
                $fin = $fecha->endOfYear();
                break;

            case 'personalizado':
                $inicio = CarbonImmutable::parse($datos['desde']);
                $fin = CarbonImmutable::parse($datos['hasta']);
                break;

            default:
                $inicio = $fecha;
                $fin = $fecha;
                $periodo = 'diario';
        }

        $inicio = $inicio->startOfDay();
        $fin = $fin->endOfDay();

        $pedidos = Pedido::with('usuario')
            ->whereBetween('fecha_creacion', [$inicio, $fin])
            ->orderBy('fecha_creacion')
            ->get();

        $totalVentas = $pedidos->sum(
            fn (Pedido $pedido) => (float) $pedido->monto_total
        );

        return view('admin.reportes.index', [
            'pedidos' => $pedidos,
            'totalVentas' => $totalVentas,
            'periodo' => $periodo,
            'fecha' => $fecha->toDateString(),
            'desde' => $datos['desde'] ?? '',
            'hasta' => $datos['hasta'] ?? '',
            'inicio' => $inicio,
            'fin' => $fin,
        ]);
    }
}