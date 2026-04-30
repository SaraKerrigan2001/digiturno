<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Solicitante;
use App\Models\Turno;
use App\Models\ConfiguracionSistema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TurnoController extends Controller
{
    // ── Helpers de ciclo ────────────────────────────────────────────────────

    /**
     * Retorna el rango de fechas [inicio, fin] según el ciclo configurado.
     * Usado para validar duplicados y generar el correlativo.
     */
    private function rangoCiclo(): array
    {
        $ciclo = ConfiguracionSistema::cicloDeTurno();

        return match ($ciclo) {
            'semana' => [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ],
            'mes' => [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString(),
            ],
            default => [ // 'dia'
                now()->toDateString(),
                now()->toDateString(),
            ],
        };
    }

    /**
     * Aplica el filtro de rango de ciclo a un query de Turno.
     */
    private function aplicarFiltroCiclo($query): mixed
    {
        [$inicio, $fin] = $this->rangoCiclo();

        if ($inicio === $fin) {
            return $query->whereDate('tur_hora_fecha', $inicio);
        }

        return $query->whereBetween(
            DB::raw('DATE(tur_hora_fecha)'),
            [$inicio, $fin]
        );
    }

    // ── Vistas ───────────────────────────────────────────────────────────────

    public function index()
    {
        $ciclo = ConfiguracionSistema::cicloDeTurno();
        return view('kiosco.index', compact('ciclo'));
    }

    /**
     * Muestra el tiquete de un turno generado hoy.
     */
    public function tiquete($tur_numero)
    {
        $turno = Turno::where('tur_numero', $tur_numero)
            ->whereDate('tur_hora_fecha', now()->toDateString())
            ->firstOrFail();

        return view('kiosco.tiquete', compact('turno'));
    }

    // ── API: Consulta de turno por documento ─────────────────────────────────

    /**
     * Consulta el turno activo de un ciudadano por número de documento.
     * Respeta el ciclo configurado (día / semana / mes).
     * Retorna JSON para consumo desde el kiosco vía fetch.
     */
    public function consultarTurno(Request $request)
    {
        $request->validate([
            'pers_doc' => 'required|numeric',
        ]);

        $ciclo = ConfiguracionSistema::cicloDeTurno();
        [$inicio, $fin] = $this->rangoCiclo();

        // Buscar solicitante por documento
        $solicitante = Solicitante::whereHas('persona', function ($q) use ($request) {
            $q->where('pers_doc', $request->pers_doc);
        })->with('persona')->first();

        if (!$solicitante) {
            return response()->json([
                'encontrado' => false,
                'mensaje'    => 'No se encontró ningún turno para este documento en el período actual.',
                'ciclo'      => $ciclo,
            ]);
        }

        // Buscar turnos del solicitante en el ciclo actual
        $query = Turno::where('SOLICITANTE_sol_id', $solicitante->sol_id)
            ->with(['atencion.asesor.persona'])
            ->orderBy('tur_hora_fecha', 'desc');

        $query = $this->aplicarFiltroCiclo($query);
        $turnos = $query->get();

        if ($turnos->isEmpty()) {
            return response()->json([
                'encontrado' => false,
                'mensaje'    => 'No se encontró ningún turno para este documento en el período actual.',
                'ciclo'      => $ciclo,
            ]);
        }

        // Formatear turnos para la respuesta
        $turnosFormateados = $turnos->map(function ($t) {
            $asesorNombre = null;
            if ($t->atencion && $t->atencion->asesor && $t->atencion->asesor->persona) {
                $asesorNombre = $t->atencion->asesor->persona->pers_nombres
                    . ' ' . $t->atencion->asesor->persona->pers_apellidos;
            }

            $estadoLabel = match ($t->tur_estado) {
                'Espera'     => 'En espera',
                'Atendiendo' => 'Siendo atendido',
                'Finalizado' => 'Atendido',
                'Ausente'    => 'Ausente',
                default      => $t->tur_estado,
            };

            $estadoColor = match ($t->tur_estado) {
                'Espera'     => 'amber',
                'Atendiendo' => 'blue',
                'Finalizado' => 'green',
                'Ausente'    => 'red',
                default      => 'gray',
            };

            return [
                'tur_id'          => $t->tur_id,
                'tur_numero'      => $t->tur_numero,
                'tur_estado'      => $t->tur_estado,
                'estado_label'    => $estadoLabel,
                'estado_color'    => $estadoColor,
                'tur_perfil'      => $t->tur_perfil,
                'tur_servicio'    => $t->tur_servicio,
                'tur_tipo_atencion'=> $t->tur_tipo_atencion,
                'tur_hora_fecha'  => Carbon::parse($t->tur_hora_fecha)->format('d/m/Y h:i A'),
                'tur_hora_llamado'=> $t->tur_hora_llamado
                    ? Carbon::parse($t->tur_hora_llamado)->format('h:i A')
                    : null,
                'asesor'          => $asesorNombre,
                'modulo'          => $t->atencion ? $t->atencion->ASESOR_ase_id : null,
            ];
        });

        $persona = $solicitante->persona;

        return response()->json([
            'encontrado' => true,
            'ciclo'      => $ciclo,
            'periodo'    => $this->etiquetaPeriodo($ciclo),
            'ciudadano'  => $persona
                ? $persona->pers_nombres . ' ' . $persona->pers_apellidos
                : 'Ciudadano',
            'turnos'     => $turnosFormateados,
        ]);
    }

    /**
     * Etiqueta legible del período según el ciclo.
     */
    private function etiquetaPeriodo(string $ciclo): string
    {
        return match ($ciclo) {
            'semana' => 'Semana del ' . now()->startOfWeek()->format('d/m') . ' al ' . now()->endOfWeek()->format('d/m/Y'),
            'mes'    => 'Mes de ' . now()->translatedFormat('F Y'),
            default  => 'Hoy ' . now()->format('d/m/Y'),
        };
    }

    // ── Generación de turno ──────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'pers_doc'          => 'required|numeric',
            'pers_tipodoc'      => 'required',
            'pers_nombres'      => 'required|string|max:100',
            'pers_apellidos'    => 'required|string|max:100',
            'tur_perfil'        => 'required|in:General,Victima,Prioritario,Empresario',
            'tur_tipo_atencion' => 'required|in:Normal,Especial',
            'tur_servicio'      => 'required|in:Orientacion,Formacion,Emprendimiento',
            'tur_telefono'      => 'nullable|string|max:20',
        ]);

        return DB::transaction(function () use ($request) {

            $ciclo = ConfiguracionSistema::cicloDeTurno();

            // ── Advertencia si el documento NO existe en la APE ──────────────
            $advertenciaAPE = null;
            $existeEnAPE = Persona::where('pers_doc', $request->pers_doc)->exists();
            if (!$existeEnAPE) {
                $advertenciaAPE = '¡Bienvenido! Hemos generado su turno con éxito. Notamos que aún no cuenta con un registro formal en la Agencia Pública de Empleo; no se preocupe, el asesor que le atenderá le orientará para completar su inscripción y que pueda acceder a todos los servicios y beneficios del SENA.';
            }

            // 1. Guardar o actualizar Persona
            $persona = Persona::updateOrCreate(
                ['pers_doc' => $request->pers_doc],
                $request->only(['pers_tipodoc', 'pers_nombres', 'pers_apellidos', 'pers_fecha_nac'])
                + ['pers_telefono' => $request->tur_telefono ?? $request->pers_telefono ?? null]
            );

            // 2. Crear o recuperar Solicitante
            $solicitante = Solicitante::firstOrCreate(
                ['PERSONA_pers_doc' => $persona->pers_doc],
                ['sol_tipo' => $request->tur_perfil]
            );

            // ── Regla de Negocio: turno duplicado según ciclo configurado ────
            $queryDuplicado = Turno::where('SOLICITANTE_sol_id', $solicitante->sol_id)
                ->where(function ($q) {
                    $q->whereDoesntHave('atencion')
                      ->orWhereHas('atencion', fn($q2) => $q2->whereNull('atnc_hora_fin'));
                });

            $queryDuplicado = $this->aplicarFiltroCiclo($queryDuplicado);

            if ($queryDuplicado->exists()) {
                $etiqueta = match ($ciclo) {
                    'semana' => 'esta semana',
                    'mes'    => 'este mes',
                    default  => 'hoy',
                };
                return back()->with('error',
                    "Ya tienes un turno activo {$etiqueta}. No es posible generar otro hasta que seas atendido o tu turno sea finalizado. Por favor dirígete a la sala de espera."
                );
            }

            // ── Perfilamiento: prefijo y tipo legacy ─────────────────────────
            $perfilMap = [
                'Victima'    => ['prefix' => 'V', 'tur_tipo' => 'Victimas'],
                'Empresario' => ['prefix' => 'E', 'tur_tipo' => 'Prioritario'],
                'Prioritario'=> ['prefix' => 'P', 'tur_tipo' => 'Prioritario'],
                'General'    => ['prefix' => 'G', 'tur_tipo' => 'General'],
            ];

            $perfil  = $request->tur_perfil;
            $mapping = $perfilMap[$perfil] ?? $perfilMap['General'];
            $prefix  = $mapping['prefix'];
            $turTipo = $mapping['tur_tipo'];

            // ── Correlativo dentro del ciclo con bloqueo pesimista ───────────
            $queryCorrelativo = Turno::where('tur_perfil', $perfil)->lockForUpdate();
            $queryCorrelativo = $this->aplicarFiltroCiclo($queryCorrelativo);
            $count = $queryCorrelativo->count();

            $numero     = str_pad($count + 1, 3, '0', STR_PAD_LEFT);
            $tur_numero = "{$prefix}-{$numero}";

            // ── Crear Turno ──────────────────────────────────────────────────
            Turno::create([
                'tur_hora_fecha'    => now(),
                'tur_numero'        => $tur_numero,
                'tur_tipo'          => $turTipo,
                'tur_perfil'        => $perfil,
                'tur_tipo_atencion' => $request->tur_tipo_atencion,
                'tur_servicio'      => $request->tur_servicio,
                'tur_telefono'      => $request->tur_telefono,
                'SOLICITANTE_sol_id'=> $solicitante->sol_id,
            ]);

            $response = back()->with('success', "Turno solicitado con éxito: {$tur_numero}");
            if ($advertenciaAPE) {
                $response = $response->with('warning', $advertenciaAPE);
            }
            return $response;
        });
    }
}
