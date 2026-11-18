<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetallePedido;
use App\Models\Pedido;
use App\Models\PlatoMenu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PuntoVentaController extends Controller
{
    public function index(): View
    {
        $categorias = Categoria::query()
            ->where('estado', 1)
            ->where('eliminado', 0)
            ->orderBy('nombre')
            ->get();

        $platos = PlatoMenu::with('categoria')
            ->where('estado', 1)
            ->where('eliminado', 0)
            ->orderBy('nombre')
            ->get();

        return view('admin.punto_venta.index', compact('categorias', 'platos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.plato_id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('platos_menu', 'id')
                    ->where(fn ($consulta) => $consulta
                        ->where('estado', 1)
                        ->where('eliminado', 0)),
            ],
            'items.*.cantidad' => ['required', 'integer', 'min:1', 'max:99'],
            'monto_recibido' => ['required', 'numeric', 'min:0'],
        ]);

        $pedido = DB::transaction(function () use ($datos) {
            $items = collect($datos['items']);
            $ids = $items->pluck('plato_id')->map(fn ($id) => (int) $id);

            $platos = PlatoMenu::whereIn('id', $ids)
                ->where('estado', 1)
                ->where('eliminado', 0)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($platos->count() !== $ids->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Uno de los platos ya no está disponible.',
                ]);
            }

            $totalCentavos = 0;

            foreach ($items as $item) {
                $plato = $platos->get((int) $item['plato_id']);
                $precioCentavos = (int) round((float) $plato->precio * 100);
                $totalCentavos += $precioCentavos * (int) $item['cantidad'];
            }

            $recibidoCentavos = (int) round(
                (float) $datos['monto_recibido'] * 100
            );

            if ($recibidoCentavos < $totalCentavos) {
                throw ValidationException::withMessages([
                    'monto_recibido' => 'El monto pagado no puede ser menor al total.',
                ]);
            }

            $prefijo = now()->format('Ymd');

            $ultimoCodigo = Pedido::where('codigo', 'like', $prefijo . '%')
                ->orderByDesc('codigo')
                ->lockForUpdate()
                ->value('codigo');

            $secuencia = $ultimoCodigo
                ? ((int) substr($ultimoCodigo, 8)) + 1
                : 1;

            if ($secuencia > 99999) {
                throw ValidationException::withMessages([
                    'pedido' => 'Se alcanzó el máximo de pedidos permitidos para hoy.',
                ]);
            }

            $cola = str_pad((string) $secuencia, 5, '0', STR_PAD_LEFT);

            $pedido = Pedido::create([
                'codigo' => $prefijo . $cola,
                'numero_cola' => $cola,
                'monto_total' => number_format($totalCentavos / 100, 2, '.', ''),
                'monto_recibido' => number_format($recibidoCentavos / 100, 2, '.', ''),
                'estado' => 0,
                'usuario_id' => auth()->id(),
            ]);

            foreach ($items as $item) {
                $plato = $platos->get((int) $item['plato_id']);

                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'plato_id' => $plato->id,
                    'precio' => $plato->precio,
                    'cantidad' => (int) $item['cantidad'],
                ]);
            }

            return $pedido;
        });

        return redirect()->route('admin.punto_venta.recibo', $pedido->id);
    }

    public function receipt(string $id): View
    {
        $pedido = Pedido::with('detalles.plato')->findOrFail($id);

        return view('admin.punto_venta.recibo', compact('pedido'));
    }
}