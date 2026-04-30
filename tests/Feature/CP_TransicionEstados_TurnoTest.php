<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Asesor;
use App\Models\Persona;
use App\Models\Solicitante;
use App\Models\Turno;
use App\Models\Atencion;
use App\Models\PausaAsesor;
use App\Repositories\TurnoRepository;

/**
 * Técnica 3: Pruebas de Transición de Estados
 * Ciclo: Espera → Atendiendo → Finalizado / Ausente
 */
class CP_TransicionEstados_TurnoTest extends TestCase
{
    use RefreshDatabase;

    private function crearAsesor(string $tipo = 'OT'): Asesor
    {
        $persona = Persona::create([
            'pers_doc'       => '10000001',
            'pers_tipodoc'   => 'CC',
            'pers_nombres'   => 'Asesor',
            'pers_apellidos' => 'Test',
        ]);

        return Asesor::create([
            'PERSONA_pers_doc' => $persona->pers_doc,
            'ase_correo'       => 'asesor@test.com',
            'ase_password'     => bcrypt('test'),
            'ase_tipo_asesor'  => $tipo,
            'ase_vigencia'     => now()->addYear()->toDateString(),
        ]);
    }

    private function crearTurnoEnEspera(string $perfil = 'General'): Turno
    {
        $persona = Persona::create([
            'pers_doc'       => '20000001',
            'pers_tipodoc'   => 'CC',
            'pers_nombres'   => 'Ciudadano',
            'pers_apellidos' => 'Test',
        ]);

        $solicitante = Solicitante::create([
            'PERSONA_pers_doc' => $persona->pers_doc,
            'sol_tipo'         => $perfil,
        ]);

        return Turno::create([
            'tur_hora_fecha'    => now(),
            'tur_numero'        => 'G-001',
            'tur_tipo'          => 'General',
            'tur_perfil'        => $perfil,
            'tur_estado'        => 'Espera',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
            'SOLICITANTE_sol_id'=> $solicitante->sol_id,
        ]);
    }

    /**
     * CP-14: Espera → Atendiendo
     * Asesor llama el turno: tur_estado cambia a Atendiendo,
     * se registra tur_hora_llamado y se crea registro en atencion.
     */
    public function test_CP14_espera_a_atendiendo_al_llamar_turno(): void
    {
        $asesor = $this->crearAsesor();
        $turno  = $this->crearTurnoEnEspera();
        $repo   = app(TurnoRepository::class);

        $atencion = $repo->callNextTurn($asesor);

        $this->assertNotNull($atencion);
        $this->assertDatabaseHas('turno', [
            'tur_id'     => $turno->tur_id,
            'tur_estado' => 'Atendiendo',
        ]);
        $this->assertNotNull($turno->fresh()->tur_hora_llamado);
        $this->assertDatabaseHas('atencion', [
            'ASESOR_ase_id' => $asesor->ase_id,
            'TURNO_tur_id'  => $turno->tur_id,
        ]);
    }

    /**
     * CP-15: Atendiendo → Finalizado
     * Asesor finaliza la atención: atnc_hora_fin se registra,
     * tur_estado cambia a Finalizado.
     */
    public function test_CP15_atendiendo_a_finalizado(): void
    {
        $asesor = $this->crearAsesor();
        $turno  = $this->crearTurnoEnEspera();

        $atencion = Atencion::create([
            'atnc_hora_inicio' => now(),
            'ASESOR_ase_id'    => $asesor->ase_id,
            'TURNO_tur_id'     => $turno->tur_id,
            'atnc_tipo'        => 'General',
        ]);
        $turno->update(['tur_estado' => 'Atendiendo']);

        // Simular sesión del asesor
        $this->withSession(['ase_id' => $asesor->ase_id]);
        $response = $this->post("/asesor/finalizar/{$atencion->atnc_id}");

        $response->assertRedirect(route('asesor.index'));
        $this->assertDatabaseHas('turno', [
            'tur_id'     => $turno->tur_id,
            'tur_estado' => 'Finalizado',
        ]);
        $this->assertNotNull(Atencion::find($atencion->atnc_id)->atnc_hora_fin);
    }

    /**
     * CP-16: Atendiendo → Ausente
     * Asesor marca ciudadano ausente: tur_estado cambia a Ausente.
     */
    public function test_CP16_atendiendo_a_ausente(): void
    {
        $asesor = $this->crearAsesor();
        $turno  = $this->crearTurnoEnEspera();

        $atencion = Atencion::create([
            'atnc_hora_inicio' => now(),
            'ASESOR_ase_id'    => $asesor->ase_id,
            'TURNO_tur_id'     => $turno->tur_id,
            'atnc_tipo'        => 'General',
        ]);
        $turno->update(['tur_estado' => 'Atendiendo']);

        $this->withSession(['ase_id' => $asesor->ase_id]);
        $response = $this->post("/asesor/ausente/{$atencion->atnc_id}");

        $response->assertRedirect(route('asesor.index'));
        $this->assertDatabaseHas('turno', [
            'tur_id'     => $turno->tur_id,
            'tur_estado' => 'Ausente',
        ]);
    }

    /**
     * CP-17: Asesor en receso no puede llamar turno (estado bloqueado).
     * Resultado esperado: callNextTurn retorna null.
     */
    public function test_CP17_asesor_en_receso_no_puede_llamar_turno(): void
    {
        $asesor = $this->crearAsesor();
        $this->crearTurnoEnEspera();

        // Crear pausa activa
        PausaAsesor::create([
            'ASESOR_ase_id' => $asesor->ase_id,
            'hora_inicio'   => now(),
        ]);

        $repo     = app(TurnoRepository::class);
        $atencion = $repo->callNextTurn($asesor);

        $this->assertNull($atencion);
        // El turno debe seguir en Espera
        $this->assertDatabaseHas('turno', ['tur_estado' => 'Espera']);
    }

    /**
     * CP-18: Turno Finalizado no aparece en la cola de espera.
     * Transición inválida bloqueada por el filtro del repositorio.
     */
    public function test_CP18_turno_finalizado_no_aparece_en_cola(): void
    {
        $this->crearTurnoEnEspera();

        // Finalizar el turno
        Turno::whereDate('tur_hora_fecha', now()->toDateString())
             ->update(['tur_estado' => 'Finalizado']);

        $repo    = app(TurnoRepository::class);
        $turnos  = $repo->getWaitingForAsesor('OT');

        $this->assertCount(0, $turnos);
    }
}
