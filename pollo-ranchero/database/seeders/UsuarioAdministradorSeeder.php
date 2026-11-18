<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioAdministradorSeeder extends Seeder
{
    public function run(): void
    {
        $yaExiste = DB::table('usuarios')
            ->where('nombre_usuario', 'admin')
            ->exists();

        if ($yaExiste) {
            return;
        }

        DB::table('usuarios')->insert([
            'nombre' => 'Administrador',
            'segundo_nombre' => null,
            'apellido' => 'Sistema',
            'nombre_usuario' => 'Juanpy',
            'contrasena' => Hash::make('Juanppy18'),
            'tipo' => 1,
            'imagen_perfil' => '',
            'fecha_registro' => now(),
            'fecha_actualizacion' => now(),
        ]);
    }
}