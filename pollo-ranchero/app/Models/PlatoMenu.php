<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlatoMenu extends Model
{
    protected $table = 'platos_menu';

    public $timestamps = false;

    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'estado',
        'eliminado',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'estado' => 'boolean',
            'eliminado' => 'boolean',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}