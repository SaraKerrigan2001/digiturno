<?php

namespace App\Repositories;

use App\Models\Turno;
use App\Models\Atencion;
use App\Models\Asesor;
use Illuminate\Support\Facades\DB;

class TurnoRepository
{
    /**
     * Obtiene los turnos en espera para la pantalla pública.
     * Orden: Víctimas (1), Prioritario (2), General (3) + FIFO.
     */
    public function getWaitingForPublicScreen()
    {
        return Turno::whereDate('tur_hora_fecha', now()->toDateString())
            ->whereDoesntHave('atencion')
            ->orderByRaw("CASE 
                WHEN tur_tipo = 'Victimas' THEN 1 
                WHEN tur_tipo = 'Prioritario' THEN 2 
                ELSE 3 END ASC")
            ->orderBy('tur_id', 'asc')
            ->get();
    }

    /**
     * Obtiene estadísticas de espera para el Dashboard del Coordinador.
     */
    public function getWaitingStats()
    {
        return Turno::whereDate('tur_hora_fecha', now()->toDateString())
            ->whereDoesntHave('atencion')
            ->selectRaw('tur_tipo, count(*) as count')
            ->groupBy('tur_tipo')
            ->pluck('count', 'tur_tipo')
            ->toArray();
    }

    /**
     * Obtiene turnos en espera según el perfil del asesor.
     */
    public function getWaitingForAsesor($tipoAsesor)
    {
        $query = Turno::whereDate('tur_hora_fecha', now()->toDateString())
                      ->whereDoesntHave('atencion');

        if ($tipoAsesor === 'Especializado') {
            // Asesor 1: Solo población víctima
            return $query->where('tur_tipo', 'Victimas')
                         ->orderBy('tur_id', 'asc')
                         ->get();
        } else {
            // Asesor 2: Prioridad Prioritario -> General
            return $query->whereIn('tur_tipo', ['Prioritario', 'General'])
                         ->orderByRaw("CASE 
                            WHEN tur_tipo = 'Prioritario' THEN 1 
                            ELSE 2 END ASC")
                         ->orderBy('tur_id', 'asc')
                         ->get();
        }
    }

    /**
     * Lógica transaccional para llamar al siguiente turno en la fila.
     */
    public function callNextTurn(Asesor $asesor)
    {
        return DB::transaction(function () use ($asesor) {
            $tipoAsesor = $asesor->ase_tipo_asesor ?? 'General';
            $ase_id = $asesor->ase_id;

            $query = Turno::whereDate('tur_hora_fecha', now()->toDateString())
                        ->whereDoesntHave('atencion');

            if ($tipoAsesor === 'Especializado') {
                $turno = $query->where('tur_tipo', 'Victimas')
                             ->orderBy('tur_id', 'asc')
                             ->lockForUpdate()
                             ->first();
            } else {
                $turno = $query->whereIn('tur_tipo', ['Prioritario', 'General'])
                             ->orderByRaw("CASE 
                                 WHEN tur_tipo = 'Prioritario' THEN 1 
                                 ELSE 2 END ASC")
                             ->orderBy('tur_id', 'asc')
                             ->lockForUpdate()
                             ->first();
            }

            if (!$turno) return null;

            $tipoAtencion = $turno->tur_tipo;
            if ($tipoAtencion == 'Prioritario') $tipoAtencion = 'Prioritaria';

            return Atencion::create([
                'atnc_hora_inicio' => now(),
                'ASESOR_ase_id' => $ase_id,
                'TURNO_tur_id' => $turno->tur_id,
                'atnc_tipo' => $tipoAtencion
            ]);
        });
    }

    /**
     * Obtiene el turno que está siendo atendido actualmente a nivel global.
     */
    public function getCurrentAttention()
    {
        return Atencion::whereNull('atnc_hora_fin')
                       ->with(['turno', 'asesor'])
                       ->latest('atnc_hora_inicio')
                       ->first();
    }

    /**
     * Obtiene la atención activa para un asesor específico.
     */
    public function getActiveAttentionForAsesor($ase_id)
    {
        return Atencion::where('ASESOR_ase_id', $ase_id)
                       ->whereNull('atnc_hora_fin')
                       ->with('turno.solicitante.persona')
                       ->first();
    }
}
