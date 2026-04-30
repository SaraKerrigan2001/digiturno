<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Persona;
use App\Models\Solicitante;
use App\Models\Turno;

/**
 * Pruebas de interfaz: Kiosco Digital (/)
 * Cubre: carga de página, flujo de solicitud de turno,
 * partición de equivalencia y valores límite en formulario.
 */
class UI_KioscoTest extends TestCase
{
    use RefreshDatabase;

    // ── Carga de interfaz ────────────────────────────────────────────────────

    /** La página del kiosco carga correctamente (HTTP 200). */
    public function test_kiosco_carga_correctamente(): void
    {
        $this->get('/')->assertStatus(200);
        $this->get('/kiosco')->assertStatus(200);
        $this->get('/solicitar')->assertStatus(200);
    }

    /** La página contiene los elementos clave del formulario. */
    public function test_kiosco_contiene_formulario_y_campos_ocultos(): void
    {
        $response = $this->get('/');
        $response->assertSee('pers_tipodoc', false);
        $response->assertSee('tur_perfil', false);
        $response->assertSee('tur_servicio', false);
    }

    // ── Partición de Equivalencia ────────────────────────────────────────────

    /** CP-01: Solicitud válida — todos los perfiles permitidos generan turno. */
    public function test_todos_los_perfiles_validos_generan_turno(): void
    {
        $perfiles = ['General', 'Victima', 'Prioritario', 'Empresario'];

        foreach ($perfiles as $i => $perfil) {
            // Doc único por perfil para evitar conflicto de turno duplicado
            $doc = 10000000 + ($i * 100);
            $response = $this->post('/turno/solicitar', [
                'pers_doc'          => $doc,
                'pers_tipodoc'      => 'CC',
                'pers_nombres'      => 'Ciudadano' . $i,
                'pers_apellidos'    => 'Test',
                'tur_perfil'        => $perfil,
                'tur_tipo_atencion' => 'Normal',
                'tur_servicio'      => 'Orientacion',
            ]);

            $response->assertSessionHas('success');
            $this->assertDatabaseHas('turno', ['tur_perfil' => $perfil]);
        }
    }

    /** CP-02: Perfil inválido es rechazado por validación. */
    public function test_perfil_invalido_es_rechazado(): void
    {
        $this->post('/turno/solicitar', [
            'pers_doc'          => '99999999',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => 'Test',
            'pers_apellidos'    => 'Test',
            'tur_perfil'        => 'INVALIDO',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
        ])->assertSessionHasErrors(['tur_perfil']);
    }

    /** CP-03: Servicio inválido es rechazado. */
    public function test_servicio_invalido_es_rechazado(): void
    {
        $this->post('/turno/solicitar', [
            'pers_doc'          => '88888888',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => 'Test',
            'pers_apellidos'    => 'Test',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Otro',
        ])->assertSessionHasErrors(['tur_servicio']);
    }

    /** CP-04: Campos requeridos vacíos son rechazados. */
    public function test_campos_requeridos_vacios_fallan_validacion(): void
    {
        $this->post('/turno/solicitar', [])
             ->assertSessionHasErrors(['pers_doc', 'pers_nombres', 'tur_perfil']);
    }

    /** CP-05: Turno duplicado en el mismo día es bloqueado. */
    public function test_turno_duplicado_mismo_dia_es_bloqueado(): void
    {
        $datos = [
            'pers_doc'          => '77777777',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => 'Juan',
            'pers_apellidos'    => 'Pérez',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
        ];

        $this->post('/turno/solicitar', $datos)->assertSessionHas('success');
        $this->post('/turno/solicitar', $datos)->assertSessionHas('error');
    }

    // ── Valores Límite ───────────────────────────────────────────────────────

    /** Nombres con exactamente 100 caracteres son aceptados. */
    public function test_nombres_limite_100_caracteres_aceptado(): void
    {
        $this->post('/turno/solicitar', [
            'pers_doc'          => '66666666',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => str_repeat('A', 100),
            'pers_apellidos'    => 'Test',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
        ])->assertSessionMissing('errors');
    }

    /** Nombres con 101 caracteres son rechazados. */
    public function test_nombres_101_caracteres_rechazado(): void
    {
        $this->post('/turno/solicitar', [
            'pers_doc'          => '55555555',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => str_repeat('A', 101),
            'pers_apellidos'    => 'Test',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
        ])->assertSessionHasErrors(['pers_nombres']);
    }

    /** Teléfono con 20 caracteres es aceptado. */
    public function test_telefono_limite_20_caracteres_aceptado(): void
    {
        $this->post('/turno/solicitar', [
            'pers_doc'          => '44444444',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => 'Ana',
            'pers_apellidos'    => 'Test',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
            'tur_telefono'      => str_repeat('3', 20),
        ])->assertSessionMissing('errors');
    }

    /** Teléfono con 21 caracteres es rechazado. */
    public function test_telefono_21_caracteres_rechazado(): void
    {
        $this->post('/turno/solicitar', [
            'pers_doc'          => '33333333',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => 'Ana',
            'pers_apellidos'    => 'Test',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
            'tur_telefono'      => str_repeat('3', 21),
        ])->assertSessionHasErrors(['tur_telefono']);
    }

    // ── Numeración correlativa ───────────────────────────────────────────────

    /** Los turnos se numeran correlativamente por perfil (G-001, G-002...). */
    public function test_numeracion_correlativa_por_perfil(): void
    {
        // Docs con rangos separados para evitar colisión con otros tests
        $docs = [30000001, 30000002, 30000003];

        foreach ($docs as $doc) {
            $this->post('/turno/solicitar', [
                'pers_doc'          => $doc,
                'pers_tipodoc'      => 'CC',
                'pers_nombres'      => 'Ciudadano',
                'pers_apellidos'    => 'Test',
                'tur_perfil'        => 'General',
                'tur_tipo_atencion' => 'Normal',
                'tur_servicio'      => 'Orientacion',
            ]);
        }

        $this->assertDatabaseHas('turno', ['tur_numero' => 'G-001']);
        $this->assertDatabaseHas('turno', ['tur_numero' => 'G-002']);
        $this->assertDatabaseHas('turno', ['tur_numero' => 'G-003']);
    }
}
