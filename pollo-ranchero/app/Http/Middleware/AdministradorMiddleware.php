<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministradorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ((int) $request->user()?->tipo !== 1) {
            abort(403, 'No tienes permiso para administrar usuarios.');
        }

        return $next($request);
    }
}