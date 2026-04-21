<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CoordinadorAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('coordinador_id')) {
            return redirect()->route('coordinador.login')->with('error', 'Debe iniciar sesión para acceder.');
        }
        return $next($request);
    }
}
