<?php

namespace App\Repositories;

use App\Models\Turno;
use App\Models\Atencion;
use App\Models\Asesor;
use App\Models\PausaAsesor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TurnoRepository
{
    /**
     * Obtiene los turnos en espera para la pantalla pública.
     * Orden de prioridad: Víctima (V) → Empresario (E) → Prioritario (P) → General (G) + FIFO.
     */
    public function getWaitingForPublicScreen()
    {
        return Turno::whereDate('tur_hora_fecha', now()->toDateString())
            ->whereDoesntHave('atencion')
            ->orderByRaw("CASE
                WHEN tur_perfil = 'Victima'     THEN 1
                WHEN tur_perfil = 'Empresario'  THEN 2
                WHEN tur_perfil = 'Prioritario' THEN 3
                ELSE 4 END ASC")
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
     * Obtiene turnos en espera según el perfil del asesor (CU-02).
     */
    public function getWaitingForAsesor($tipoAsesor)
    {
        $query = Turno::whereDate('tur_hora_fecha', now()->toDateString())
                      ->whereDoesntHave('atencion');

        if ($tipoAsesor === 'Especializado') {
            // Asesor especializado: Víctimas primero
            return $query->whereIn('tur_perfil', ['Víctima'])
                         ->orderBy('tur_id', 'asc')
                         ->get();
        } else {
            // Asesor general: Prioridad Víctima → Empresario → Prioritario → General
            return $query->orderByRaw("CASE
                            WHEN tur_perfil = 'Victima'     THEN 1
                            WHEN tur_perfil = 'Empresario'  THEN 2
                            WHEN tur_perfil = 'Prioritario' THEN 3
                            ELSE 4 END ASC")
                         ->orderBy('tur_id', 'asc')
                         ->get();
        }
    }

    /**
     * Lógica transaccional para llamar al siguiente turno en la fila (CU-02).
     * Prioriza el turno MÁS ANTIGUO del grupo de mayor prioridad:
     * Víctima → Empresario → Prioritario → General.
     */
    public function callNextTurn(Asesor $asesor)
    {
        return DB::transaction(function () use ($asesor) {
            $tipoAsesor = $asesor->ase_tipo_asesor ?? 'General';
            $ase_id     = $asesor->ase_id;

            // Verificar si el asesor tiene una pausa activa — no se puede llamar durante receso
            $pausaActiva = PausaAsesor::where('ASESOR_ase_id', $ase_id)
                                      ->whereNull('hora_fin')
                                      ->exists();
            if ($pausaActiva) {
                return null; // Bloqueado por pausa activa
            }

            $query = Turno::whereDate('tur_hora_fecha', now()->toDateString())
                        ->whereDoesntHave('atencion');

            if ($tipoAsesor === 'Especializado') {
                $turno = $query->where('tur_perfil', 'Victima')
                               ->orderBy('tur_id', 'asc')
                               ->lockForUpdate()
                               ->first();
            } else {
                // CU-02: Priorizar el turno más antiguo del grupo prioritario
                $turno = $query->orderByRaw("CASE
                                    WHEN tur_perfil = 'Victima'     THEN 1
                                    WHEN tur_perfil = 'Empresario'  THEN 2
                                    WHEN tur_perfil = 'Prioritario' THEN 3
                                    ELSE 4 END ASC")
                               ->orderBy('tur_id', 'asc')   // FIFO dentro de cada grupo
                               ->lockForUpdate()
                               ->first();
            }

            if (!$turno) return null;

            // Mapear perfil al enum de atencion (compatibilidad con tabla existente)
            $tipoAtencion = match ($turno->tur_perfil) {
                'Victima'    => 'Victimas',
                'Empresario', 'Prioritario' => 'Prioritaria',
                default      => 'General',
            };

            $atencion = Atencion::create([
                'atnc_hora_inicio' => now(),
                'ASESOR_ase_id'    => $ase_id,
                'TURNO_tur_id'     => $turno->tur_id,
                'atnc_tipo'        => $tipoAtencion,
            ]);

            return $atencion->load('turno');
        });
    }

    /**
     * Inicia un receso para el asesor (CU-03).
     * Bloquea si hay una atención activa sin finalizar.
     *
     * @return PausaAsesor|string  Devuelve la pausa creada o un mensaje de error.
     */
    public function iniciarReceso(Asesor $asesor)
    {
        $ase_id = $asesor->ase_id;

        // ── Bloqueo: no se puede pausar si hay atención activa ──
        $atencionActiva = Atencion::where('ASESOR_ase_id', $ase_id)
                                  ->whereNull('atnc_hora_fin')
                                  ->exists();
        if ($atencionActiva) {
            return 'No puedes iniciar un receso mientras tienes una atención activa. Finaliza la atención primero.';
        }

        // ── Bloqueo: evitar doble pausa activa ──
        $pausaActiva = PausaAsesor::where('ASESOR_ase_id', $ase_id)
                                   ->whereNull('hora_fin')
                                   ->exists();
        if ($pausaActiva) {
            return 'Ya tienes un receso activo en curso.';
        }

        return PausaAsesor::create([
            'ASESOR_ase_id' => $ase_id,
            'hora_inicio'   => now(),
        ]);
    }

    /**
     * Finaliza el receso activo del asesor (CU-03).
     * Calcula la duración en minutos.
     *
     * @return PausaAsesor|string
     */
    public function finalizarReceso(Asesor $asesor)
    {
        $pausa = PausaAsesor::where('ASESOR_ase_id', $asesor->ase_id)
                             ->whereNull('hora_fin')
                             ->latest('hora_inicio')
                             ->first();

        if (!$pausa) {
            return 'No tienes un receso activo para finalizar.';
        }

        $fin      = now();
        $duracion = (int) $pausa->hora_inicio->diffInMinutes($fin);

        $pausa->update([
            'hora_fin' => $fin,
            'duracion' => $duracion,
        ]);

        return $pausa;
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
