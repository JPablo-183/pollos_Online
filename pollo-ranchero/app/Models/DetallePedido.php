<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePedido extends Model
{
    protected $table = 'detalle_pedido';

    public $timestamps = false;

    protected $fillable = [
        'pedido_id',
        'plato_id',
        'precio',
        'cantidad',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'cantidad' => 'integer',
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function plato(): BelongsTo
    {
        return $this->belongsTo(PlatoMenu::class, 'plato_id');
    }
}