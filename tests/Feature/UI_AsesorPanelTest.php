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

/**
 * Pruebas de interfaz: Panel del Asesor
 * Cubre: llamar turno, finalizar, ausente, receso, protección de rutas.
 */
class UI_AsesorPanelTest extends TestCase
{
    use RefreshDatabase;

    private function crearAsesor(): Asesor
    {
        $persona = Persona::create([
            'pers_doc' => '10000001', 'pers_tipodoc' => 'CC',
            'pers_nombres' => 'Carlos', 'pers_apellidos' => 'Ruiz',
        ]);
        return Asesor::create([
            'PERSONA_pers_doc' => $persona->pers_doc,
            'ase_correo'       => 'asesor@sena.edu.co',
            'ase_password'     => bcrypt('test1234'),
            'ase_tipo_asesor'  => 'OT',
            'ase_vigencia'     => now()->addYear()->toDateString(),
        ]);
    }

    private function crearTurnoEnEspera(string $perfil = 'General'): Turno
    {
        $persona = Persona::create([
            'pers_doc' => '20000001', 'pers_tipodoc' => 'CC',
            'pers_nombres' => 'Ciudadano', 'pers_apellidos' => 'Test',
        ]);
        $sol = Solicitante::create(['PERSONA_pers_doc' => $persona->pers_doc, 'sol_tipo' => $perfil]);
        return Turno::create([
            'tur_hora_fecha'    => now(),
            'tur_numero'        => 'G-001',
            'tur_tipo'          => 'General',
            'tur_perfil'        => $perfil,
            'tur_estado'        => 'Espera',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
            'SOLICITANTE_sol_id'=> $sol->sol_id,
        ]);
    }

    // ── Protección de rutas ──────────────────────────────────────────────────

    /** Panel asesor sin sesión redirige al login. */
    public function test_panel_sin_sesion_redirige_login(): void
    {
        $this->get('/asesor')->assertRedirect(route('asesor.login'));
    }

    /** Llamar turno sin sesión redirige al login. */
    public function test_llamar_sin_sesion_redirige_login(): void
    {
        $this->post('/asesor/llamar')->assertRedirect();
    }

    // ── Llamar turno ─────────────────────────────────────────────────────────

    /** Asesor autenticado puede llamar el siguiente turno. */
    public function test_asesor_puede_llamar_turno(): void
    {
        $asesor = $this->crearAsesor();
        $turno  = $this->crearTurnoEnEspera();

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post('/asesor/llamar')
             ->assertRedirect(route('asesor.index'))
             ->assertSessionHas('success');

        $this->assertDatabaseHas('turno', [
            'tur_id'     => $turno->tur_id,
            'tur_estado' => 'Atendiendo',
        ]);
    }

    /** Sin turnos disponibles, muestra error. */
    public function test_llamar_sin_turnos_disponibles_muestra_error(): void
    {
        $asesor = $this->crearAsesor();

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post('/asesor/llamar')
             ->assertSessionHas('error');
    }

    /** Asesor en receso no puede llamar turno. */
    public function test_asesor_en_receso_no_puede_llamar(): void
    {
        $asesor = $this->crearAsesor();
        $this->crearTurnoEnEspera();

        PausaAsesor::create([
            'ASESOR_ase_id' => $asesor->ase_id,
            'hora_inicio'   => now(),
        ]);

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post('/asesor/llamar')
             ->assertSessionHas('error');
    }

    // ── Finalizar atención ───────────────────────────────────────────────────

    /** Asesor puede finalizar una atención activa. */
    public function test_asesor_puede_finalizar_atencion(): void
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

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post("/asesor/finalizar/{$atencion->atnc_id}")
             ->assertRedirect(route('asesor.index'))
             ->assertSessionHas('success');

        $this->assertDatabaseHas('turno', ['tur_id' => $turno->tur_id, 'tur_estado' => 'Finalizado']);
        $this->assertNotNull(Atencion::find($atencion->atnc_id)->atnc_hora_fin);
    }

    // ── Marcar ausente ───────────────────────────────────────────────────────

    /** Asesor puede marcar ciudadano como ausente. */
    public function test_asesor_puede_marcar_ausente(): void
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

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post("/asesor/ausente/{$atencion->atnc_id}")
             ->assertRedirect(route('asesor.index'))
             ->assertSessionHas('warning');

        $this->assertDatabaseHas('turno', ['tur_id' => $turno->tur_id, 'tur_estado' => 'Ausente']);
    }

    // ── Receso ───────────────────────────────────────────────────────────────

    /** Asesor puede iniciar receso si no tiene atención activa. */
    public function test_asesor_puede_iniciar_receso(): void
    {
        $asesor = $this->crearAsesor();

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post('/asesor/receso/iniciar')
             ->assertSessionHas('warning');

        $this->assertDatabaseHas('pausas_asesor', [
            'ASESOR_ase_id' => $asesor->ase_id,
        ]);
    }

    /** Asesor no puede iniciar receso con atención activa. */
    public function test_asesor_no_puede_iniciar_receso_con_atencion_activa(): void
    {
        $asesor = $this->crearAsesor();
        $turno  = $this->crearTurnoEnEspera();

        Atencion::create([
            'atnc_hora_inicio' => now(),
            'ASESOR_ase_id'    => $asesor->ase_id,
            'TURNO_tur_id'     => $turno->tur_id,
            'atnc_tipo'        => 'General',
        ]);

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post('/asesor/receso/iniciar')
             ->assertSessionHas('error');
    }

    /** Asesor puede finalizar receso activo. */
    public function test_asesor_puede_finalizar_receso(): void
    {
        $asesor = $this->crearAsesor();

        PausaAsesor::create([
            'ASESOR_ase_id' => $asesor->ase_id,
            'hora_inicio'   => now()->subMinutes(10),
        ]);

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post('/asesor/receso/finalizar')
             ->assertSessionHas('success');

        $this->assertNotNull(
            PausaAsesor::where('ASESOR_ase_id', $asesor->ase_id)->first()->hora_fin
        );
    }

    /** Finalizar receso sin pausa activa muestra error. */
    public function test_finalizar_receso_sin_pausa_activa_muestra_error(): void
    {
        $asesor = $this->crearAsesor();

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post('/asesor/receso/finalizar')
             ->assertSessionHas('error');
    }
}
