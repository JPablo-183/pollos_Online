<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'segundo_nombre',
        'apellido',
        'nombre_usuario',
        'contrasena',
        'tipo',
        'imagen_perfil',
    ];

    protected $hidden = [
        'contrasena',
    ];

    public const CREATED_AT = 'fecha_registro';
    public const UPDATED_AT = 'fecha_actualizacion';

    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'contrasena';
    }
}