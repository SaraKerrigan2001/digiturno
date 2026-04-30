<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Tabla de configuración del sistema.
 * Almacena parámetros globales como el ciclo de reinicio de turnos.
 *
 * ciclo_turno:
 *   'dia'    → los turnos se reinician cada día (comportamiento original)
 *   'semana' → los turnos se reinician cada semana (lunes a domingo)
 *   'mes'    → los turnos se reinician cada mes (día 1 al último)
 *
 * La validación de turno duplicado y la numeración correlativa
 * respetan el ciclo configurado.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('configuracion_sistema')) {
            Schema::create('configuracion_sistema', function (Blueprint $table) {
                $table->increments('id');
                $table->string('clave', 100)->unique()->comment('Nombre del parámetro');
                $table->string('valor', 255)->comment('Valor del parámetro');
                $table->string('descripcion', 255)->nullable()->comment('Descripción del parámetro');
                $table->timestamps();
            });
        }

        // Insertar valor por defecto: ciclo diario
        $existe = DB::table('configuracion_sistema')->where('clave', 'ciclo_turno')->exists();
        if (!$existe) {
            DB::table('configuracion_sistema')->insert([
                'clave'       => 'ciclo_turno',
                'valor'       => 'dia',
                'descripcion' => 'Ciclo de reinicio de numeración de turnos: dia | semana | mes',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_sistema');
    }
};
