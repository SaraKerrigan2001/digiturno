<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atencion;
use App\Models\Asesor;
use App\Models\Turno;

class CoordinadorController extends Controller
{
    public function index()
    {
        // ... (existing index logic if needed for compatibility)
        return $this->dashboard();
    }

    public function dashboard()
    {
        $hoy = now()->today();

        // KPIs
        $usuariosHoy = Turno::whereDate('tur_hora_fecha', $hoy)->count();
        $enAtencion = Atencion::whereNull('atnc_hora_fin')->count();
        $satisfaccion = "4.8/5";
        
        // Tiempo Medio de Espera (Minutos)
        $atencionesHoy = Atencion::whereDate('atnc_hora_inicio', $hoy)->with('turno')->get();
        $tiempoMedio = round($atencionesHoy->avg(function($at) {
            return $at->atnc_hora_inicio->diffInMinutes($at->turno->tur_hora_fecha);
        }) ?? 0);

        // Chart: Flow per Hour
        $flowData = Turno::whereDate('tur_hora_fecha', $hoy)
            ->selectRaw('HOUR(tur_hora_fecha) as hour, count(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour')
            ->toArray();
        
        // Fill missing hours with 0
        $flowPerHour = [];
        for ($i = 8; $i <= 18; $i++) {
            $flowPerHour[$i] = $flowData[$i] ?? 0;
        }

        // Chart: Document Types
        $docTypes = \App\Models\Persona::selectRaw('pers_tipodoc, count(*) as count')
            ->groupBy('pers_tipodoc')
            ->pluck('count', 'pers_tipodoc')
            ->toArray();

        // Advisor Status
        $asesoresStatus = Asesor::with('persona')->get()->map(function($ase) {
            $tieneAtencion = Atencion::where('ASESOR_ase_id', $ase->ase_id)
                                    ->whereNull('atnc_hora_fin')
                                    ->exists();
            return [
                'nombre' => $ase->persona->pers_nombres . ' ' . $ase->persona->pers_apellidos,
                'modulo' => $ase->ase_id,
                'estado' => $tieneAtencion ? 'Free' : 'Break Time', // Lógica simple para demo
                'color' => $tieneAtencion ? 'green' : 'red'
            ];
        });

        $alertas = [
            ['msg' => 'Wait time exceeded 20m in Module 3', 'time' => '5m ago'],
            ['msg' => 'High volume of Prioritario turns', 'time' => '12m ago'],
            ['msg' => 'Advisor "Pedro" is on extended break', 'time' => '25m ago'],
        ];

        return view('dashboard_coordinador', compact(
            'usuariosHoy', 'enAtencion', 'satisfaccion', 'tiempoMedio', 
            'flowPerHour', 'docTypes', 'asesoresStatus', 'alertas'
        ));
    }

    public function export()
    {
        $fileName = 'digiturno_export_' . date('Y-m-d') . '.csv';
        $turnos = Turno::with(['solicitante.persona', 'atencion.asesor.persona'])->get();

        $headers = array(
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Numero', 'Tipo', 'Fecha/Hora', 'Solicitante', 'Documento', 'Asesor', 'Inicio Atencion', 'Fin Atencion');

        $callback = function() use($turnos, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($turnos as $t) {
                $row['ID'] = $t->tur_id;
                $row['Numero'] = $t->tur_numero;
                $row['Tipo'] = $t->tur_tipo;
                $row['Fecha/Hora'] = $t->tur_hora_fecha;
                $row['Solicitante'] = $t->solicitante->persona->pers_nombres . ' ' . $t->solicitante->persona->pers_apellidos;
                $row['Documento'] = $t->solicitante->persona->pers_doc;
                $row['Asesor'] = $t->atencion && $t->atencion->asesor ? $t->atencion->asesor->persona->pers_nombres : 'N/A';
                $row['Inicio Atencion'] = $t->atencion ? $t->atencion->atnc_hora_inicio : 'N/A';
                $row['Fin Atencion'] = $t->atencion ? $t->atencion->atnc_hora_fin : 'N/A';

                fputcsv($file, array($row['ID'], $row['Numero'], $row['Tipo'], $row['Fecha/Hora'], $row['Solicitante'], $row['Documento'], $row['Asesor'], $row['Inicio Atencion'], $row['Fin Atencion']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function reportes()
    {
        $turnos = Turno::with(['solicitante.persona', 'atencion'])->orderBy('tur_hora_fecha', 'desc')->paginate(15);
        return view('reportes', compact('turnos'));
    }

    public function modulos()
    {
        $asesores = Asesor::with('persona')->get();
        return view('modulos_gestion', compact('asesores'));
    }

    public function configuracion()
    {
        return view('configuracion');
    }
}
