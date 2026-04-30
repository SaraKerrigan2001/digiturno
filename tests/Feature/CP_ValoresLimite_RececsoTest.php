<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Asesor;
use App\Models\Persona;
use App\Models\Atencion;
use App\Models\PausaAsesor;
use App\Repositories\TurnoRepository;

/**
 * Técnica 2: Análisis de Valores Límite
 * Escenario A: Duración del receso del asesor (TurnoRepository)
 * Escenario B: Longitud de campos en solicitud de turno
 */
class CP_ValoresLimite_RececsoTest extends TestCase
{
    use RefreshDatabase;

    private function crearAsesor(): Asesor
    {
        $persona = Persona::create([
            'pers_doc'       => '11111111',
            'pers_tipodoc'   => 'CC',
            'pers_nombres'   => 'Carlos',
            'pers_apellidos' => 'Ruiz',
        ]);

        return Asesor::create([
            'PERSONA_pers_doc' => $persona->pers_doc,
            'ase_correo'       => 'asesor@sena.edu.co',
            'ase_password'     => bcrypt('test1234'),
            'ase_tipo_asesor'  => 'OT',
            'ase_vigencia'     => now()->addYear()->toDateString(),
        ]);
    }

    /**
     * CP-06: Límite inferior — receso de exactamente 1 minuto.
     * Resultado esperado: duracion = 1, receso finalizado con éxito.
     */
    public function test_CP06_receso_duracion_minima_1_minuto(): void
    {
        $asesor = $this->crearAsesor();
        $repo   = app(TurnoRepository::class);

        // Crear pausa con inicio hace 1 minuto exacto
        PausaAsesor::create([
            'ASESOR_ase_id' => $asesor->ase_id,
            'hora_inicio'   => now()->subMinutes(1),
        ]);

        $resultado = $repo->finalizarReceso($asesor);

        $this->assertInstanceOf(PausaAsesor::class, $resultado);
        $this->assertEquals(1, $resultado->duracion);
        $this->assertNotNull($resultado->hora_fin);
    }

    /**
     * CP-07: Valor normal — receso de 15 minutos.
     * Resultado esperado: duracion = 15.
     */
    public function test_CP07_receso_duracion_normal_15_minutos(): void
    {
        $asesor = $this->crearAsesor();
        $repo   = app(TurnoRepository::class);

        PausaAsesor::create([
            'ASESOR_ase_id' => $asesor->ase_id,
            'hora_inicio'   => now()->subMinutes(15),
        ]);

        $resultado = $repo->finalizarReceso($asesor);

        $this->assertInstanceOf(PausaAsesor::class, $resultado);
        $this->assertEquals(15, $resultado->duracion);
    }

    /**
     * CP-08: Límite — finalizar receso sin pausa activa.
     * Resultado esperado: retorna string de error.
     */
    public function test_CP08_finalizar_receso_sin_pausa_activa_retorna_error(): void
    {
        $asesor = $this->crearAsesor();
        $repo   = app(TurnoRepository::class);

        $resultado = $repo->finalizarReceso($asesor);

        $this->assertIsString($resultado);
        $this->assertStringContainsString('receso activo', $resultado);
    }

    /**
     * CP-09: Doble pausa — iniciar receso con uno ya activo.
     * Resultado esperado: retorna string de error (o trigger MySQL lo bloquea).
     */
    public function test_CP09_doble_receso_es_bloqueado(): void
    {
        $asesor = $this->crearAsesor();
        $repo   = app(TurnoRepository::class);

        // Primera pausa
        $repo->iniciarReceso($asesor);

        // Segunda pausa — debe ser bloqueada
        $resultado = $repo->iniciarReceso($asesor);

        $this->assertIsString($resultado);
        $this->assertStringContainsString('receso activo', $resultado);
    }

    /**
     * CP-10: Límite superior pers_nombres — exactamente 100 caracteres.
     * Resultado esperado: turno creado con éxito.
     */
    public function test_CP10_nombres_exactamente_100_caracteres_es_valido(): void
    {
        $response = $this->post('/turno/solicitar', [
            'pers_doc'          => '22222222',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => str_repeat('A', 100),
            'pers_apellidos'    => 'Apellido',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
        ]);

        $response->assertSessionMissing('errors');
        $response->assertSessionHas('success');
    }

    /**
     * CP-11: Fuera de rango pers_nombres — 101 caracteres.
     * Resultado esperado: error de validación max:100.
     */
    public function test_CP11_nombres_101_caracteres_falla_validacion(): void
    {
        $response = $this->post('/turno/solicitar', [
            'pers_doc'          => '33333333',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => str_repeat('A', 101),
            'pers_apellidos'    => 'Apellido',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
        ]);

        $response->assertSessionHasErrors(['pers_nombres']);
    }

    /**
     * CP-12: Límite superior tur_telefono — exactamente 20 caracteres.
     * Resultado esperado: éxito.
     */
    public function test_CP12_telefono_exactamente_20_caracteres_es_valido(): void
    {
        $response = $this->post('/turno/solicitar', [
            'pers_doc'          => '44444444',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => 'Ana',
            'pers_apellidos'    => 'López',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
            'tur_telefono'      => str_repeat('3', 20),
        ]);

        $response->assertSessionMissing('errors');
    }

    /**
     * CP-13: Fuera de rango tur_telefono — 21 caracteres.
     * Resultado esperado: error de validación max:20.
     */
    public function test_CP13_telefono_21_caracteres_falla_validacion(): void
    {
        $response = $this->post('/turno/solicitar', [
            'pers_doc'          => '55555555',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => 'Ana',
            'pers_apellidos'    => 'López',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
            'tur_telefono'      => str_repeat('3', 21),
        ]);

        $response->assertSessionHasErrors(['tur_telefono']);
    }
}
