<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Verifica que exista una sesión activa de asesor.
 * Redirige al login si no está autenticado.
 */
class AuthAsesor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('ase_id')) {
            return redirect()->route('asesor.login')
                ->with('error', 'Debe iniciar sesión para acceder a esta sección.');
        }

        return $next($request);
    }
}
