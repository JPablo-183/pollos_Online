<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'eliminado',
        'fecha_creacion',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
        'fecha_creacion' => 'datetime',
        'estado' => 'boolean',
    ];
    }
}