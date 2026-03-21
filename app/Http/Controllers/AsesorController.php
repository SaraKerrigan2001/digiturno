<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asesor;
use App\Models\Atencion;
use App\Models\Turno;

class AsesorController extends Controller
{
    public function index($ase_id = 1) // ID de asesor quemado por ahora para pruebas
    {
        $asesor = Asesor::with('persona')->find($ase_id);
        
        // Atención en curso para este asesor
        $atencion = Atencion::where('ASESOR_ase_id', $ase_id)
                            ->whereNull('atnc_hora_fin')
                            ->with('turno.persona')
                            ->first();

        // Cola de espera general para que el asesor pueda llamar
        $turnosEnEspera = Turno::whereDate('tur_hora_fecha', now()->today())
                                ->whereDoesntHave('atencion')
                                ->orderBy('tur_id', 'asc')
                                ->get();

        return view('panel_asesor', compact('asesor', 'atencion', 'turnosEnEspera'));
    }

    public function actividad($ase_id = 1)
    {
        $asesor = Asesor::with('persona')->find($ase_id);
        
        if (!$asesor) {
            $asesor = new Asesor();
            $asesor->ase_id = $ase_id;
            $asesor->modulo = '04';
        }

        $atenciones = Atencion::where('ASESOR_ase_id', $ase_id)
                             ->with('turno.persona')
                             ->orderBy('atnc_hora_inicio', 'desc')
                             ->limit(20)
                             ->get();

        // Si no hay atenciones reales, generamos algunas para la demostración
        if ($atenciones->isEmpty()) {
            $atenciones = collect([
                (object)[
                    'atnc_id' => 1,
                    'atnc_hora_inicio' => '2026-03-20 08:20:00',
                    'atnc_hora_fin' => '2026-03-20 08:32:00',
                    'turno' => (object)[
                        'tur_numero' => 'G-001',
                        'persona' => (object)['pers_nombres' => 'María', 'pers_apellidos' => 'Rodríguez', 'pers_doc' => '10203040']
                    ]
                ],
                (object)[
                    'atnc_id' => 2,
                    'atnc_hora_inicio' => '2026-03-20 09:15:00',
                    'atnc_hora_fin' => '2026-03-20 09:23:00',
                    'turno' => (object)[
                        'tur_numero' => 'P-042',
                        'persona' => (object)['pers_nombres' => 'Juan', 'pers_apellidos' => 'Pérez', 'pers_doc' => '50607080']
                    ]
                ],
                (object)[
                    'atnc_id' => 3,
                    'atnc_hora_inicio' => '2026-03-20 10:05:00',
                    'atnc_hora_fin' => null,
                    'turno' => (object)[
                        'tur_numero' => 'V-012',
                        'persona' => (object)['pers_nombres' => 'Elena', 'pers_apellidos' => 'Gómez', 'pers_doc' => '90102030']
                    ]
                ]
            ]);
        }

        return view('asesor.actividad', compact('asesor', 'atenciones'));
    }

    public function tramites($ase_id = 1)
    {
        $asesor = Asesor::with('persona')->find($ase_id);
        return view('asesor.tramites', compact('asesor'));
    }

    public function reportes($ase_id = 1)
    {
        $asesor = Asesor::with('persona')->find($ase_id);
        
        // Si no existe, crear un objeto genérico para evitar errores en la vista (demo)
        if (!$asesor) {
            $asesor = new Asesor();
            $asesor->ase_id = $ase_id;
            $asesor->modulo = '04';
        }

        // Datos Avanzados para el Reporte
        $distribucionTipos = [
            'General' => 45,
            'Prioritario' => 30,
            'Víctimas' => 25
        ];

        $metas = [
            'atencion_meta' => 12, // minutos
            'atencion_actual' => 10.5,
            'diaria_meta' => 50, // turnos
            'diaria_actual' => 38,
            'calificacion' => 4.9
        ];

        $topTramites = [
            ['nombre' => 'Validación de HV', 'count' => 85, 'color' => 'bg-emerald-500'],
            ['nombre' => 'Inscripción SENA', 'count' => 62, 'color' => 'bg-blue-500'],
            ['nombre' => 'Certificación Laboral', 'count' => 45, 'color' => 'bg-amber-500'],
            ['nombre' => 'Orientación Ocupacional', 'count' => 30, 'color' => 'bg-purple-500'],
            ['nombre' => 'Asesoría Empresarial', 'count' => 12, 'color' => 'bg-rose-500']
        ];

        $feedback = [
            ['user' => 'María R.', 'stars' => 5, 'comentario' => 'Muy amable y resolvió todas mis dudas.', 'time' => '10 min ago'],
            ['user' => 'Juan P.', 'stars' => 5, 'comentario' => 'Atención rápida y eficiente.', 'time' => '1h ago'],
            ['user' => 'Elena G.', 'stars' => 4, 'comentario' => 'Información completa del proceso.', 'time' => '3h ago']
        ];

        $registros = [
            ['id' => 'G-001', 'hora' => '08:20 AM', 'tipo' => 'General', 'duracion' => '12 min', 'status' => 'Completado'],
            ['id' => 'P-042', 'hora' => '09:15 AM', 'tipo' => 'Prioritario', 'duracion' => '08 min', 'status' => 'Completado'],
            ['id' => 'V-012', 'hora' => '10:05 AM', 'tipo' => 'Víctimas', 'duracion' => '25 min', 'status' => 'Completado'],
            ['id' => 'G-015', 'hora' => '11:30 AM', 'tipo' => 'General', 'duracion' => '10 min', 'status' => 'Completado'],
            ['id' => 'G-022', 'hora' => '01:45 PM', 'tipo' => 'General', 'duracion' => '15 min', 'status' => 'Completado']
        ];

        return view('asesor.reportes', compact(
            'asesor', 'distribucionTipos', 'metas', 'topTramites', 'feedback', 'registros'
        ));
    }

    public function configuracion($ase_id = 1)
    {
        $asesor = Asesor::with('persona')->find($ase_id);

        if (!$asesor) {
            $asesor = new Asesor();
            $asesor->ase_id = $ase_id;
            $asesor->modulo = '04';
        }

        if (!$asesor->persona) {
            $asesor->persona = (object)[
                'pers_nombres' => 'Carlos',
                'pers_apellidos' => 'Ruiz',
                'pers_doc' => '12345678'
            ];
        }

        return view('asesor.configuracion', compact('asesor'));
    }
}
