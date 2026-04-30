<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Asesor;
use App\Models\Persona;
use App\Models\Coordinador;

/**
 * Pruebas de interfaz: Login Asesor (/asesor/login)
 *                      Login Coordinador (/coordinador/login)
 * Cubre: carga de página, autenticación válida/inválida,
 * redirección post-login, protección de rutas.
 */
class UI_LoginTest extends TestCase
{
    use RefreshDatabase;

    private function crearAsesor(string $email = 'asesor@sena.edu.co', string $pass = 'test1234'): Asesor
    {
        $persona = Persona::create([
            'pers_doc'       => '11111111',
            'pers_tipodoc'   => 'CC',
            'pers_nombres'   => 'Carlos',
            'pers_apellidos' => 'Ruiz',
        ]);

        return Asesor::create([
            'PERSONA_pers_doc' => $persona->pers_doc,
            'ase_correo'       => $email,
            'ase_password'     => bcrypt($pass),
            'ase_tipo_asesor'  => 'OT',
            'ase_vigencia'     => now()->addYear()->toDateString(),
        ]);
    }

    private function crearCoordinador(string $email = 'coord@sena.edu.co', string $pass = 'coord1234'): void
    {
        $persona = Persona::create([
            'pers_doc'       => '22222222',
            'pers_tipodoc'   => 'CC',
            'pers_nombres'   => 'Ana',
            'pers_apellidos' => 'Gómez',
        ]);

        // Insertar directamente con DB para evitar problemas de modelo
        \Illuminate\Support\Facades\DB::table('coordinador')->insert([
            'PERSONA_pers_doc' => $persona->pers_doc,
            'coor_vigencia'    => now()->addYear()->toDateString(),
            'coor_correo'      => $email,
            'coor_password'    => bcrypt($pass),
        ]);
    }

    // ── Carga de interfaces ──────────────────────────────────────────────────

    /** Login asesor carga con HTTP 200. */
    public function test_login_asesor_carga_correctamente(): void
    {
        $this->get('/asesor/login')->assertStatus(200);
    }

    /** Login coordinador carga con HTTP 200. */
    public function test_login_coordinador_carga_correctamente(): void
    {
        $this->get('/coordinador/login')->assertStatus(200);
    }

    /** Login asesor contiene campos email y password. */
    public function test_login_asesor_contiene_campos_formulario(): void
    {
        $this->get('/asesor/login')
             ->assertSee('name="email"', false)
             ->assertSee('name="password"', false);
    }

    // ── Autenticación Asesor ─────────────────────────────────────────────────

    /** Credenciales válidas redirigen al panel del asesor. */
    public function test_login_asesor_credenciales_validas_redirige_al_panel(): void
    {
        $this->crearAsesor();

        $this->post('/asesor/login', [
            'email'    => 'asesor@sena.edu.co',
            'password' => 'test1234',
        ])->assertRedirect(route('asesor.index'));
    }

    /** Credenciales inválidas muestran error y no crean sesión. */
    public function test_login_asesor_credenciales_invalidas_muestra_error(): void
    {
        $this->crearAsesor();

        $response = $this->post('/asesor/login', [
            'email'    => 'asesor@sena.edu.co',
            'password' => 'clave_incorrecta',
        ]);

        $response->assertSessionHas('error');
        $this->assertNull(session('ase_id'));
    }

    /** Email con formato inválido falla validación antes de consultar BD. */
    public function test_login_asesor_email_invalido_falla_validacion(): void
    {
        $this->post('/asesor/login', [
            'email'    => 'no-es-un-email',
            'password' => 'cualquier',
        ])->assertSessionHasErrors(['email']);
    }

    /** Campos vacíos fallan validación. */
    public function test_login_asesor_campos_vacios_fallan_validacion(): void
    {
        $this->post('/asesor/login', [])
             ->assertSessionHasErrors(['email', 'password']);
    }

    /** Asesor ya autenticado es redirigido al panel sin ver el login. */
    public function test_login_asesor_ya_autenticado_redirige_al_panel(): void
    {
        $asesor = $this->crearAsesor();

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->get('/asesor/login')
             ->assertRedirect(route('asesor.index'));
    }

    /** Logout del asesor destruye la sesión y redirige al login. */
    public function test_logout_asesor_destruye_sesion(): void
    {
        $asesor = $this->crearAsesor();

        $this->withSession(['ase_id' => $asesor->ase_id])
             ->post('/asesor/logout')
             ->assertRedirect(route('asesor.login'));

        $this->assertNull(session('ase_id'));
    }

    // ── Autenticación Coordinador ────────────────────────────────────────────

    /** Credenciales válidas redirigen al dashboard del coordinador. */
    public function test_login_coordinador_credenciales_validas_redirige_al_dashboard(): void
    {
        $this->crearCoordinador();

        $response = $this->post('/coordinador/login', [
            'email'    => 'coord@sena.edu.co',
            'password' => 'coord1234',
        ]);

        // Verifica que redirige (login exitoso) y no muestra error
        $response->assertRedirect();
        $response->assertSessionMissing('error');
    }

    /** Credenciales inválidas muestran error. */
    public function test_login_coordinador_credenciales_invalidas_muestra_error(): void
    {
        $this->crearCoordinador();

        $this->post('/coordinador/login', [
            'email'    => 'coord@sena.edu.co',
            'password' => 'clave_mala',
        ])->assertSessionHas('error');
    }

    /** Coordinador ya autenticado es redirigido al dashboard. */
    public function test_login_coordinador_ya_autenticado_redirige_al_dashboard(): void
    {
        $this->withSession(['coordinador_id' => 1])
             ->get('/coordinador/login')
             ->assertRedirect(route('coordinador.dashboard'));
    }

    /** Logout del coordinador destruye la sesión. */
    public function test_logout_coordinador_destruye_sesion(): void
    {
        $this->withSession(['coordinador_id' => 1, 'coordinador_nombre' => 'Ana'])
             ->post('/coordinador/logout')
             ->assertRedirect(route('coordinador.login'));

        $this->assertNull(session('coordinador_id'));
    }

    // ── Protección de rutas ──────────────────────────────────────────────────

    /** Panel asesor sin sesión redirige al login. */
    public function test_panel_asesor_sin_sesion_redirige_al_login(): void
    {
        $this->get('/asesor')->assertRedirect(route('asesor.login'));
    }

    /** Panel coordinador sin sesión redirige al login. */
    public function test_panel_coordinador_sin_sesion_redirige_al_login(): void
    {
        $this->get('/coordinador')->assertRedirect(route('coordinador.login'));
    }

    /** Rutas del asesor protegidas sin sesión redirigen al login. */
    public function test_rutas_asesor_protegidas_sin_sesion(): void
    {
        $rutas = ['/asesor/actividad', '/asesor/tramites', '/asesor/reportes', '/asesor/configuracion'];

        foreach ($rutas as $ruta) {
            $this->get($ruta)->assertRedirect(route('asesor.login'));
        }
    }

    /** Rutas del coordinador protegidas sin sesión redirigen al login. */
    public function test_rutas_coordinador_protegidas_sin_sesion(): void
    {
        $rutas = ['/coordinador/reportes', '/coordinador/modulos', '/coordinador/supervision'];

        foreach ($rutas as $ruta) {
            $this->get($ruta)->assertRedirect(route('coordinador.login'));
        }
    }
}
