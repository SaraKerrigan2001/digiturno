<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TurnoRepository;
use App\Models\Turno;
use App\Models\Atencion;
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
     * Retorna atenciones activas cuyo tiempo desde llamado supera 40 segundos.
     * Usado por el coordinador para disparar el modal de tiempo vencido.
     */
    public function getTurnosVencidos()
    {
        if (!session()->has('coordinador_id')) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $vencidos = Atencion::whereNull('atnc_hora_fin')
            ->whereDate('atnc_hora_inicio', now()->toDateString())
            ->where('atnc_hora_inicio', '<', now()->subSeconds(40))
            ->with(['turno.solicitante.persona', 'asesor.persona'])
            ->get()
            ->map(function ($a) {
                $persona = $a->turno->solicitante->persona ?? null;
                return [
                    'atnc_id'        => $a->atnc_id,
                    'tur_numero'     => $a->turno->tur_numero ?? '—',
                    'ciudadano'      => $persona ? $persona->pers_nombres . ' ' . $persona->pers_apellidos : 'Ciudadano',
                    'tur_perfil'     => $a->turno->tur_perfil ?? '—',
                    'tur_servicio'   => $a->turno->tur_servicio ?? '—',
                    'asesor'         => $a->asesor->persona->pers_nombres ?? 'Asesor',
                    'modulo'         => $a->ASESOR_ase_id,
                    'segundos'       => (int) $a->atnc_hora_inicio->diffInSeconds(now()),
                ];
            });

        return response()->json([
            'success'  => true,
            'total'    => $vencidos->count(),
            'vencidos' => $vencidos,
        ]);
    }
    public function getPantallaData()
    {
        $atencionActual = $this->turnoRepo->getCurrentAttention();

        $turnoActual = $atencionActual ? [
            'tur_id'     => $atencionActual->turno->tur_id,
            'tur_numero' => $atencionActual->turno->tur_numero,
            'modulo'     => $atencionActual->ASESOR_ase_id,
            'ase_foto'   => $atencionActual->asesor->ase_foto ? asset($atencionActual->asesor->ase_foto) : asset('images/foto de perfil.jpg'),
            'atnc_id'    => $atencionActual->atnc_id,
            'ciudadano'  => trim(
                ($atencionActual->turno->solicitante?->persona?->pers_nombres ?? '') . ' ' .
                ($atencionActual->turno->solicitante?->persona?->pers_apellidos ?? '')
            ) ?: 'Ciudadano',
        ] : null;

        $turnosEnEspera = Turno::whereDate('tur_hora_fecha', now()->toDateString())
                                ->where('tur_estado', 'Espera')
                                ->orderByRaw("CASE
                                    WHEN tur_perfil = 'Victima'     THEN 1
                                    WHEN tur_perfil = 'Empresario'  THEN 2
                                    WHEN tur_perfil = 'Prioritario' THEN 3
                                    ELSE 4 END ASC")
                                ->orderBy('tur_id', 'asc')
                                ->get()
                                ->map(function($t) {
                                    return [
                                        'tur_id'     => $t->tur_id,
                                        'tur_numero' => $t->tur_numero,
                                        'tur_tipo'   => $t->tur_tipo,
                                    ];
                                });

        return response()->json([
            'success'        => true,
            'timestamp'      => now()->format('H:i:s'),
            'turnoActual'    => $turnoActual,
            'turnosEnEspera' => $turnosEnEspera,
        ]);
    }

    /**
     * Devuelve el último turno generado hoy desde el kiosco.
     * Usado por la pantalla para mostrar el overlay de "Turno Generado".
     */
    public function getUltimoTurno()
    {
        $turno = Turno::whereDate('tur_hora_fecha', now()->toDateString())
            ->orderBy('tur_id', 'desc')
            ->first();

        if (!$turno) {
            return response()->json(['success' => true, 'turno' => null]);
        }

        return response()->json([
            'success' => true,
            'turno'   => [
                'tur_id'     => $turno->tur_id,
                'tur_numero' => $turno->tur_numero,
                'tur_perfil' => $turno->tur_perfil,
                'tur_hora'   => $turno->tur_hora_fecha,
            ],
        ]);
    }
}
