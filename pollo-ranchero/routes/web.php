<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PlatoMenuController;
use App\Http\Controllers\PuntoVentaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CocinaController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'create'])
    ->name('login');

Route::post('/login', [AuthController::class, 'store'])
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Todo usuario autenticado puede ver el panel
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Perfil propio: cualquier usuario autenticado
        Route::get('/usuarios/perfil', [UsuarioController::class, 'perfil'])
            ->name('usuarios.perfil');

        Route::put('/usuarios/perfil', [UsuarioController::class, 'actualizarPerfil'])
            ->name('usuarios.perfil.actualizar');

        // Solo administrador: Categorías, Menú, Reportes y gestión de usuarios
        Route::middleware('tipo:1')->group(function () {
            Route::get('/categorias', [CategoriaController::class, 'index'])
                ->name('categorias.index');
            Route::get('/categorias/crear', [CategoriaController::class, 'create'])
                ->name('categorias.create');
            Route::post('/categorias', [CategoriaController::class, 'store'])
                ->name('categorias.store');
            Route::get('/categorias/{id}/editar', [CategoriaController::class, 'edit'])
                ->name('categorias.edit');
            Route::put('/categorias/{id}', [CategoriaController::class, 'update'])
                ->name('categorias.update');
            Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])
                ->name('categorias.destroy');
            Route::get('/categorias/{id}', [CategoriaController::class, 'show'])
                ->name('categorias.show');

            Route::get('/menu', [PlatoMenuController::class, 'index'])
                ->name('menu.index');
            Route::get('/menu/crear', [PlatoMenuController::class, 'create'])
                ->name('menu.create');
            Route::post('/menu', [PlatoMenuController::class, 'store'])
                ->name('menu.store');
            Route::get('/menu/{id}/editar', [PlatoMenuController::class, 'edit'])
                ->name('menu.edit');
            Route::put('/menu/{id}', [PlatoMenuController::class, 'update'])
                ->name('menu.update');
            Route::delete('/menu/{id}', [PlatoMenuController::class, 'destroy'])
                ->name('menu.destroy');
            Route::get('/menu/{id}', [PlatoMenuController::class, 'show'])
                ->name('menu.show');

            Route::get('/reportes', [ReporteController::class, 'index'])
                ->name('reportes.index');

            Route::get('/usuarios', [UsuarioController::class, 'index'])
                ->name('usuarios.index');
            Route::get('/usuarios/crear', [UsuarioController::class, 'create'])
                ->name('usuarios.create');
            Route::post('/usuarios', [UsuarioController::class, 'store'])
                ->name('usuarios.store');
            Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'edit'])
                ->name('usuarios.edit');
            Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])
                ->name('usuarios.update');
            Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])
                ->name('usuarios.destroy');
        });

        // Administrador y mesero: Punto de venta y Pedidos
        Route::middleware('tipo:1,2')->group(function () {
            Route::get('/punto-venta', [PuntoVentaController::class, 'index'])
                ->name('punto_venta.index');
            Route::post('/punto-venta', [PuntoVentaController::class, 'store'])
                ->name('punto_venta.store');
            Route::get('/punto-venta/recibo/{id}', [PuntoVentaController::class, 'receipt'])
                ->name('punto_venta.recibo');

            Route::get('/pedidos', [PedidoController::class, 'index'])
                ->name('pedidos.index');
            Route::get('/pedidos/{id}', [PedidoController::class, 'show'])
                ->name('pedidos.show');
        });

        // Administrador y cocina: módulo Cocina
        Route::middleware('tipo:1,3')->group(function () {
            Route::get('/cocina', [CocinaController::class, 'index'])
                ->name('cocina.index');
            Route::patch('/cocina/{id}/servir', [CocinaController::class, 'servir'])
                ->name('cocina.servir');
        });
    });