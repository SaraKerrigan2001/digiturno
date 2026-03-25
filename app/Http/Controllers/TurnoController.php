<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Solicitante;
use App\Models\Turno;
use Carbon\Carbon;

class TurnoController extends Controller
{
    public function index()
    {
        return view('solicitar_turno');
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

        // 3. Generar tur_numero (Modelo SENA: A-Víctima, B-Prioritaria, C-General)
        $prefixMap = [
            'Victimas' => 'A',
            'Prioritario' => 'B',
            'General' => 'C'
        ];
        $prefix = $prefixMap[$request->tur_tipo] ?? 'C';

        $count = Turno::whereDate('tur_hora_fecha', Carbon::today())
                      ->where('tur_tipo', $request->tur_tipo)
                      ->count();
        $numero = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
        $tur_numero = "{$prefix}-{$numero}";

        // 4. Crear Turno
        $turno = Turno::create([
            'tur_hora_fecha' => now(),
            'tur_numero' => $tur_numero,
            'tur_tipo' => $request->tur_tipo,
            'SOLICITANTE_sol_id' => $solicitante->sol_id
        ]);

        return back()->with('success', "Turno solicitado con éxito: {$tur_numero}");
    }
}
