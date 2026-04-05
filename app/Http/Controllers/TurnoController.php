<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Solicitante;
use App\Models\Turno;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TurnoController extends Controller
{
    public function index()
    {
        return view('kiosco.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pers_doc' => 'required|numeric',
            'pers_tipodoc' => 'required',
            'pers_nombres' => 'required|string|max:100',
            'pers_apellidos' => 'required|string|max:100',
            'tur_tipo' => 'required|in:General,Prioritario,Victimas',
            'sol_tipo' => 'required'
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Guardar o actualizar Persona
            $persona = Persona::updateOrCreate(
                ['pers_doc' => $request->pers_doc],
                $request->only(['pers_tipodoc', 'pers_nombres', 'pers_apellidos', 'pers_telefono', 'pers_fecha_nac'])
            );

            // 2. Crear Solicitante
            $solicitante = Solicitante::firstOrCreate([
                'PERSONA_pers_doc' => $persona->pers_doc,
                'sol_tipo' => $request->sol_tipo
            ]);

            // 3. Validación de Turnos Activos (Una persona puede tener UN SOLO turno por cada TIPO de atención seleccionado al día)
            $hasActive = Turno::where('SOLICITANTE_sol_id', $solicitante->sol_id)
                ->where('tur_tipo', $request->tur_tipo)
                ->whereDate('tur_hora_fecha', now()->toDateString())
                ->where(function($q) {
                    $q->whereDoesntHave('atencion') // En espera
                      ->orWhereHas('atencion', function($q2) {
                          $q2->whereNull('atnc_hora_fin'); // En proceso de atención
                      });
                })->exists();

            if ($hasActive) {
                return back()->with('error', 'Ya tienes un turno activo para hoy. Por favor, espera a ser atendido.');
            }

            // 4. Generar tur_numero (Modelo SENA: A-Víctima, B-Prioritaria, C-General)
            // Usamos Lock Pesimista (lockForUpdate) para asegurar que el correlativo sea único
            $prefixMap = [
                'Victimas' => 'A',
                'Prioritario' => 'B',
                'General' => 'C'
            ];
            $prefix = $prefixMap[$request->tur_tipo] ?? 'C';

            $count = Turno::whereDate('tur_hora_fecha', now()->toDateString())
                          ->where('tur_tipo', $request->tur_tipo)
                          ->lockForUpdate() 
                          ->count();
            
            $numero = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            $tur_numero = "{$prefix}-{$numero}";

            // 5. Crear Turno
            $turno = Turno::create([
                'tur_hora_fecha' => now(),
                'tur_numero' => $tur_numero,
                'tur_tipo' => $request->tur_tipo,
                'SOLICITANTE_sol_id' => $solicitante->sol_id
            ]);

            return back()->with('success', "Turno solicitado con éxito: {$tur_numero}");
        });
    }
}
