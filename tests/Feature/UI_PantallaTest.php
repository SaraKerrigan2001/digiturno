<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Persona;
use App\Models\Solicitante;
use App\Models\Turno;
use App\Models\Asesor;
use App\Models\Atencion;

/**
 * Pruebas de interfaz: Pantalla Pública (/pantalla)
 * y API de datos en tiempo real (/api/pantalla/data)
 * Cubre: carga, turno activo, cola de espera, orden de prioridad.
 */
class UI_PantallaTest extends TestCase
{
    use RefreshDatabase;

    private function crearAsesor(): Asesor
    {
        $persona = Persona::create([
            'pers_doc' => '10000001', 'pers_tipodoc' => 'CC',
            'pers_nombres' => 'Asesor', 'pers_apellidos' => 'Test',
        ]);
        return Asesor::create([
            'PERSONA_pers_doc' => $persona->pers_doc,
            'ase_correo'       => 'asesor@test.com',
            'ase_password'     => bcrypt('test'),
            'ase_tipo_asesor'  => 'OT',
            'ase_vigencia'     => now()->addYear()->toDateString(),
        ]);
    }

    private function crearTurno(string $perfil, string $tipo, int $docOffset = 0): Turno
    {
        $doc = 20000000 + $docOffset;
        $persona = Persona::create([
            'pers_doc' => $doc, 'pers_tipodoc' => 'CC',
            'pers_nombres' => 'Ciudadano', 'pers_apellidos' => 'Test',
        ]);
        $sol = Solicitante::create(['PERSONA_pers_doc' => $doc, 'sol_tipo' => $perfil]);
        return Turno::create([
            'tur_hora_fecha'    => now(),
            'tur_numero'        => strtoupper(substr($perfil, 0, 1)) . '-00' . ($docOffset + 1),
            'tur_tipo'          => $tipo,
            'tur_perfil'        => $perfil,
            'tur_estado'        => 'Espera',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
            'SOLICITANTE_sol_id'=> $sol->sol_id,
        ]);
    }

    // ── Carga de interfaz ────────────────────────────────────────────────────

    /** La pantalla pública carga con HTTP 200. */
    public function test_pantalla_carga_correctamente(): void
    {
        $this->get('/pantalla')->assertStatus(200);
    }

    /** La API de datos de pantalla responde JSON con estructura correcta. */
    public function test_api_pantalla_retorna_json_con_estructura_correcta(): void
    {
        $response = $this->get('/api/pantalla/data');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'timestamp',
                     'turnoActual',
                     'turnosEnEspera',
                 ]);
    }

    // ── Sin turnos activos ───────────────────────────────────────────────────

    /** Sin atenciones activas, turnoActual es null. */
    public function test_sin_atencion_activa_turno_actual_es_null(): void
    {
        $response = $this->get('/api/pantalla/data');
        $response->assertJson(['turnoActual' => null]);
    }

    /** Sin turnos en espera, la lista está vacía. */
    public function test_sin_turnos_en_espera_lista_vacia(): void
    {
        $response = $this->get('/api/pantalla/data');
        $data = $response->json();
        $this->assertEmpty($data['turnosEnEspera']);
    }

    // ── Con turno activo ─────────────────────────────────────────────────────

    /** Con atención activa, turnoActual contiene el número de turno. */
    public function test_con_atencion_activa_turno_actual_no_es_null(): void
    {
        $asesor = $this->crearAsesor();
        $turno  = $this->crearTurno('General', 'General', 0);

        Atencion::create([
            'atnc_hora_inicio' => now(),
            'ASESOR_ase_id'    => $asesor->ase_id,
            'TURNO_tur_id'     => $turno->tur_id,
            'atnc_tipo'        => 'General',
        ]);
        $turno->update(['tur_estado' => 'Atendiendo']);

        $response = $this->get('/api/pantalla/data');
        $data = $response->json();

        $this->assertNotNull($data['turnoActual']);
        $this->assertEquals($turno->tur_numero, $data['turnoActual']['tur_numero']);
    }

    // ── Orden de prioridad en cola ───────────────────────────────────────────

    /** Los turnos en espera se ordenan: Víctimas → Prioritario → General. */
    public function test_cola_espera_ordenada_por_prioridad(): void
    {
        $this->crearTurno('General',    'General',    0);
        $this->crearTurno('Prioritario','Prioritario', 1);
        $this->crearTurno('Victima',    'Victimas',   2);

        $response = $this->get('/api/pantalla/data');
        $turnos   = $response->json('turnosEnEspera');

        $this->assertCount(3, $turnos);
        // El primero debe ser Victimas
        $this->assertEquals('Victimas', $turnos[0]['tur_tipo']);
        // El segundo debe ser Prioritario
        $this->assertEquals('Prioritario', $turnos[1]['tur_tipo']);
        // El tercero debe ser General
        $this->assertEquals('General', $turnos[2]['tur_tipo']);
    }

    /** Turnos finalizados no aparecen en la cola de espera de la pantalla. */
    public function test_turnos_finalizados_no_aparecen_en_pantalla(): void
    {
        $turno = $this->crearTurno('General', 'General', 0);
        $turno->update(['tur_estado' => 'Finalizado']);

        $data = $this->get('/api/pantalla/data')->json();
        $this->assertEmpty($data['turnosEnEspera']);
    }
}
