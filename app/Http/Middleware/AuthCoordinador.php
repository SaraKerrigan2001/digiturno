<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Verifica que exista una sesión activa de coordinador.
 * Redirige al login si no está autenticado.
 */
class AuthCoordinador
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('coordinador_id')) {
            return redirect()->route('coordinador.login')
                ->with('error', 'Debe iniciar sesión para acceder a esta sección.');
        }

        return $next($request);
    }
}
