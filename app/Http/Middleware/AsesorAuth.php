<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AsesorAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('ase_id')) {
            return redirect()->route('asesor.login')->with('error', 'Debe iniciar sesión para acceder.');
        }
        return $next($request);
    }
}
