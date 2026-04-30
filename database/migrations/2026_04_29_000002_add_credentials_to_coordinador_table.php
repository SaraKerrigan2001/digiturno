<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * CU-04: Agrega coor_correo y coor_password a la tabla coordinador.
 * El CoordinadorController usa estos campos para autenticar al coordinador
 * mediante sesión PHP nativa.
 *
 * También inserta un coordinador por defecto si la tabla está vacía,
 * para permitir el primer acceso al sistema.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coordinador', function (Blueprint $table) {
            if (!Schema::hasColumn('coordinador', 'coor_correo')) {
                $table->string('coor_correo', 100)
                      ->nullable()
                      ->after('coor_vigencia')
                      ->comment('Correo de acceso al panel del coordinador');
            }

            if (!Schema::hasColumn('coordinador', 'coor_password')) {
                $table->string('coor_password', 255)
                      ->nullable()
                      ->after('coor_correo')
                      ->comment('Contraseña hasheada del coordinador');
            }
        });

        // Insertar coordinador por defecto si no existe ninguno
        $existe = DB::table('coordinador')->exists();
        if (!$existe) {
            // Primero asegurar que exista la persona base
            $doc = 99999999;
            $personaExiste = DB::table('persona')->where('pers_doc', $doc)->exists();
            if (!$personaExiste) {
                DB::table('persona')->insert([
                    'pers_doc'       => $doc,
                    'pers_tipodoc'   => 'CC',
                    'pers_nombres'   => 'Coordinador',
                    'pers_apellidos' => 'APE SENA',
                    'pers_telefono'  => null,
                    'pers_fecha_nac' => null,
                ]);
            }

            DB::table('coordinador')->insert([
                'PERSONA_pers_doc' => $doc,
                'coor_vigencia'    => now()->addYear()->toDateString(),
                'coor_correo'      => 'coordinador@sena.edu.co',
                'coor_password'    => bcrypt('sena2026'),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('coordinador', function (Blueprint $table) {
            $cols = ['coor_correo', 'coor_password'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('coordinador', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
