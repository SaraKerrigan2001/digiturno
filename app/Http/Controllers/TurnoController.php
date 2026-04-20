<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Solicitante;
use App\Models\Turno;
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
            'pers_doc'     => 'required|numeric',
            'pers_tipodoc' => 'required',
            'tur_tipo'     => 'required|in:General,Prioritario,Victimas,Victima,Empresario',
        ]);

        return DB::transaction(function () use ($request) {

            // Normalizar tur_tipo a los valores del ENUM de la BD
            $tipoMap = [
                'Victima'    => 'Victimas',
                'Empresario' => 'Prioritario',
            ];
            $turTipo = $tipoMap[$request->tur_tipo] ?? $request->tur_tipo;

            // 1. Guardar o actualizar Persona
            $persona = Persona::updateOrCreate(
                ['pers_doc' => $request->pers_doc],
                [
                    'pers_tipodoc'   => $request->pers_tipodoc,
                    'pers_nombres'   => $request->pers_nombres   ?? 'Usuario',
                    'pers_apellidos' => $request->pers_apellidos ?? 'Kiosco',
                    'pers_telefono'  => $request->pers_telefono  ?? null,
                ]
            );

            // 2. Crear o recuperar Solicitante
            $solicitante = Solicitante::firstOrCreate(
                ['PERSONA_pers_doc' => $persona->pers_doc],
                ['sol_tipo' => 'Externo']
            );

            // 3. Evitar turno duplicado activo en el día
            $hasActive = Turno::where('SOLICITANTE_sol_id', $solicitante->sol_id)
                ->whereDate('tur_hora_fecha', now()->toDateString())
                ->where(function ($q) {
                    $q->whereDoesntHave('atencion')
                      ->orWhereHas('atencion', fn($q2) => $q2->whereNull('atnc_hora_fin'));
                })->exists();

            if ($hasActive) {
                return back()->with('error', 'Ya tienes un turno activo para hoy. Espera a ser atendido.');
            }

            // 4. Generar número de turno correlativo por tipo
            $prefixMap = ['Victimas' => 'V', 'Prioritario' => 'P', 'General' => 'G'];
            $prefix    = $prefixMap[$turTipo] ?? 'G';

            $count  = Turno::whereDate('tur_hora_fecha', now()->toDateString())
                           ->where('tur_tipo', $turTipo)
                           ->lockForUpdate()
                           ->count();

            $numero     = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            $tur_numero = "{$prefix}-{$numero}";

            // 5. Crear Turno
            Turno::create([
                'tur_hora_fecha'     => now(),
                'tur_numero'         => $tur_numero,
                'tur_tipo'           => $turTipo,
                'SOLICITANTE_sol_id' => $solicitante->sol_id,
            ]);

            return back()->with('success', "Turno solicitado con éxito: {$tur_numero}");
        });
    }
}
