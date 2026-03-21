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

        // Turnos en espera (que no tienen atención iniciada hoy)
        $turnosEnEspera = Turno::whereDate('tur_hora_fecha', now()->today())
                                ->whereDoesntHave('atencion')
                                ->orderBy('tur_id', 'asc')
                                ->get();

        return view('pantalla_turnos', compact('turnoActual', 'turnosEnEspera'));
    }
}
