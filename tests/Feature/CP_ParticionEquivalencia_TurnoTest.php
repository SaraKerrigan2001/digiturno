<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Persona;
use App\Models\Solicitante;
use App\Models\Turno;

/**
 * Técnica 1: Partición de Equivalencia
 * Escenario: Solicitud de turno en el Kiosco (POST /turno/solicitar)
 */
class CP_ParticionEquivalencia_TurnoTest extends TestCase
{
    use RefreshDatabase;

    /** Datos base válidos reutilizables */
    private function datosValidos(array $override = []): array
    {
        return array_merge([
            'pers_doc'          => '12345678',
            'pers_tipodoc'      => 'CC',
            'pers_nombres'      => 'Juan',
            'pers_apellidos'    => 'Pérez',
            'tur_perfil'        => 'General',
            'tur_tipo_atencion' => 'Normal',
            'tur_servicio'      => 'Orientacion',
            'tur_telefono'      => null,
        ], $override);
    }

    /**
     * CP-01: Clase válida — todos los datos correctos.
     * Resultado esperado: turno creado, flash success con número de turno.
     */
    public function test_CP01_solicitud_valida_crea_turno(): void
    {
        $response = $this->post('/turno/solicitar', $this->datosValidos());

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('turno', [
            'tur_perfil' => 'General',
            'tur_estado' => 'Espera',
        ]);
    }

    /**
     * CP-02: Clase inválida — documento no numérico.
     * Resultado esperado: error de validación.
     */
    public function test_CP02_documento_no_numerico_falla_validacion(): void
    {
        $response = $this->post('/turno/solicitar', $this->datosValidos([
            'pers_doc' => 'ABC123',
        ]));

        $response->assertSessionHasErrors(['pers_doc']);
        $this->assertDatabaseMissing('turno', ['tur_perfil' => 'General']);
    }

    /**
     * CP-03: Clase inválida — perfil fuera del enum permitido.
     * Resultado esperado: error de validación en tur_perfil.
     */
    public function test_CP03_perfil_invalido_falla_validacion(): void
    {
        $response = $this->post('/turno/solicitar', $this->datosValidos([
            'tur_perfil' => 'VIP',
        ]));

        $response->assertSessionHasErrors(['tur_perfil']);
    }

    /**
     * CP-04: Clase inválida — turno duplicado para el mismo documento hoy.
     * Resultado esperado: flash error "Ya tienes un turno activo".
     */
    public function test_CP04_turno_duplicado_mismo_dia_es_rechazado(): void
    {
        // Crear el primer turno
        $this->post('/turno/solicitar', $this->datosValidos());

        // Intentar crear un segundo turno con el mismo documento
        $response = $this->post('/turno/solicitar', $this->datosValidos());

        $response->assertSessionHas('error');
        $this->assertStringContainsString(
            'turno activo',
            session('error') ?? ''
        );
    }

    /**
     * CP-05: Clase válida especial — ciudadano nuevo (no registrado en APE).
     * Resultado esperado: turno creado + flash warning con mensaje de bienvenida APE.
     */
    public function test_CP05_ciudadano_nuevo_recibe_advertencia_APE(): void
    {
        // Asegurarse de que el documento NO existe en persona
        $this->assertDatabaseMissing('persona', ['pers_doc' => '99887766']);

        $response = $this->post('/turno/solicitar', $this->datosValidos([
            'pers_doc' => '99887766',
        ]));

        $response->assertSessionHas('success');
        $response->assertSessionHas('warning');
        $this->assertDatabaseHas('persona', ['pers_doc' => '99887766']);
    }
}
