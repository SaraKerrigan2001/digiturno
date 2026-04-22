<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TurnoRepository;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    protected $turnoRepo;

    public function __construct(TurnoRepository $turnoRepo)
    {
        $this->turnoRepo = $turnoRepo;
    }

    /**
     * Obtiene estadísticas de turnos en espera para el Coordinador.
     */
    public function getCoordinatorStats()
    {
        // Solo coordinadores autenticados si se desea reforzar
        if (!session()->has('coordinador_id')) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $stats = $this->turnoRepo->getWaitingStats();

        return response()->json([
            'success'     => true,
            'timestamp'   => now()->format('H:i:s'),
            'data' => [
                'General'     => $stats['General'] ?? 0,
                'Prioritario' => $stats['Prioritario'] ?? 0,
                'Victimas'    => $stats['Victimas'] ?? 0,
                'Total'       => array_sum($stats)
            ]
        ]);
    }

    /**
     * Obtiene los datos de la pantalla de turnos (Turno Actual y Espera).
     */
    public function getPantallaData()
    {
        $atencionActual = $this->turnoRepo->getCurrentAttention();

        $turnoActual = $atencionActual ? [
            'tur_id' => $atencionActual->turno->tur_id,
            'tur_numero' => $atencionActual->turno->tur_numero,
            'modulo' => $atencionActual->ASESOR_ase_id,
            'ase_foto' => $atencionActual->asesor->ase_foto ? asset($atencionActual->asesor->ase_foto) : asset('images/foto de perfil.jpg'),
            'atnc_id' => $atencionActual->atnc_id
        ] : null;

        $turnosEnEspera = $this->turnoRepo->getWaitingForPublicScreen()
                                ->map(function($t) {
                                    return [
                                        'tur_id'        => $t->tur_id,
                                        'tur_numero'    => $t->tur_numero,
                                        'tur_tipo'      => $t->tur_tipo,
                                        'tur_hora_fecha'=> $t->tur_hora_fecha,
                                    ];
                                });

        return response()->json([
            'success' => true,
            'timestamp' => now()->format('H:i:s'),
            'turnoActual' => $turnoActual,
            'turnosEnEspera' => $turnosEnEspera
        ]);
    }
}
