<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TipoUsuarioMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$tipos
    ): Response {
        $usuario = $request->user();

        if (!$usuario || !in_array((string) $usuario->tipo, $tipos, true)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}