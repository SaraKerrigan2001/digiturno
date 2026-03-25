<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turno;
use App\Models\Atencion;

class PantallaController extends Controller
{
    public function index()
    {
        // Turno que está siendo atendido actualmente (con hora_fin null)
        $atencionActual = Atencion::whereNull('atnc_hora_fin')
                                  ->with('turno')
                                  ->latest('atnc_hora_inicio')
                                  ->first();

        $turnoActual = $atencionActual ? (object)[
            'tur_numero' => $atencionActual->turno->tur_numero,
            'modulo' => $atencionActual->ASESOR_ase_id // Simulación del módulo por ID de asesor
        ] : null;

        // Turnos en espera (Ordenados por prioridad SENA: Víctima > Prioritario > General)
        $turnosEnEspera = Turno::whereDate('tur_hora_fecha', now()->today())
                                ->whereDoesntHave('atencion')
                                ->orderByRaw("CASE 
                                    WHEN tur_tipo = 'Victimas' THEN 1 
                                    WHEN tur_tipo = 'Prioritario' THEN 2 
                                    ELSE 3 END ASC")
                                ->orderBy('tur_id', 'asc')
                                ->get();

        return view('pantalla_turnos', compact('turnoActual', 'turnosEnEspera'));
    }
}
