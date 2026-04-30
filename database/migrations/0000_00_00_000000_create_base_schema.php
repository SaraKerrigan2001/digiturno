<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración base: crea el schema completo del sistema APE SENA.
 * Necesaria para que los tests con SQLite en memoria funcionen,
 * ya que el schema original viene de script.sql (no de migraciones).
 *
 * En MySQL esta migración se salta si las tablas ya existen.
 */
return new class extends Migration
{
    public function up(): void
    {
        // persona
        if (!Schema::hasTable('persona')) {
            Schema::create('persona', function (Blueprint $table) {
                $table->unsignedBigInteger('pers_doc')->primary();
                $table->string('pers_tipodoc', 45)->nullable();
                $table->string('pers_nombres', 100)->nullable();
                $table->string('pers_apellidos', 100)->nullable();
                $table->bigInteger('pers_telefono')->nullable();
                $table->dateTime('pers_fecha_nac')->nullable();
            });
        }

        // asesor
        if (!Schema::hasTable('asesor')) {
            Schema::create('asesor', function (Blueprint $table) {
                $table->increments('ase_id');
                $table->string('ase_nrocontrato', 45)->nullable();
                $table->string('ase_tipo_asesor', 2)->default('OT');
                $table->string('ase_vigencia', 45)->nullable();
                $table->string('ase_password', 255)->nullable();
                $table->string('ase_correo', 100)->nullable();
                $table->string('ase_foto', 255)->default('images/foto de perfil.jpg')->nullable();
                $table->unsignedBigInteger('PERSONA_pers_doc')->nullable();
                $table->foreign('PERSONA_pers_doc')->references('pers_doc')->on('persona');
            });
        }

        // coordinador
        if (!Schema::hasTable('coordinador')) {
            Schema::create('coordinador', function (Blueprint $table) {
                $table->increments('coor_id');
                $table->string('coor_vigencia', 45)->nullable();
                $table->string('coor_correo', 100)->nullable();
                $table->string('coor_password', 255)->nullable();
                $table->unsignedBigInteger('PERSONA_pers_doc')->nullable();
                $table->foreign('PERSONA_pers_doc')->references('pers_doc')->on('persona');
            });
        }

        // solicitante
        if (!Schema::hasTable('solicitante')) {
            Schema::create('solicitante', function (Blueprint $table) {
                $table->increments('sol_id');
                $table->string('sol_tipo', 45)->nullable();
                $table->unsignedBigInteger('PERSONA_pers_doc')->nullable();
                $table->foreign('PERSONA_pers_doc')->references('pers_doc')->on('persona');
            });
        }

        // turno
        if (!Schema::hasTable('turno')) {
            Schema::create('turno', function (Blueprint $table) {
                $table->increments('tur_id');
                $table->string('tur_estado', 20)->default('Espera');
                $table->dateTime('tur_hora_fecha')->nullable();
                $table->dateTime('tur_hora_llamado')->nullable();
                $table->string('tur_numero', 45)->nullable();
                $table->string('tur_tipo', 20)->default('General');
                $table->string('tur_perfil', 20)->default('General');
                $table->string('tur_tipo_atencion', 20)->default('Normal');
                $table->string('tur_servicio', 20)->default('Orientacion');
                $table->string('tur_telefono', 20)->nullable();
                $table->unsignedInteger('SOLICITANTE_sol_id')->nullable();
                $table->foreign('SOLICITANTE_sol_id')->references('sol_id')->on('solicitante');
            });
        }

        // atencion
        if (!Schema::hasTable('atencion')) {
            Schema::create('atencion', function (Blueprint $table) {
                $table->increments('atnc_id');
                $table->dateTime('atnc_hora_inicio')->nullable();
                $table->dateTime('atnc_hora_fin')->nullable();
                $table->string('atnc_tipo', 20)->default('General');
                $table->unsignedInteger('ASESOR_ase_id')->nullable();
                $table->unsignedInteger('TURNO_tur_id')->nullable();
                $table->foreign('ASESOR_ase_id')->references('ase_id')->on('asesor');
                $table->foreign('TURNO_tur_id')->references('tur_id')->on('turno');
            });
        }

        // pausas_asesor
        if (!Schema::hasTable('pausas_asesor')) {
            Schema::create('pausas_asesor', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('ASESOR_ase_id');
                $table->dateTime('hora_inicio');
                $table->dateTime('hora_fin')->nullable();
                $table->unsignedInteger('duracion')->nullable();
                $table->timestamps();
                $table->foreign('ASESOR_ase_id')->references('ase_id')->on('asesor')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pausas_asesor');
        Schema::dropIfExists('atencion');
        Schema::dropIfExists('turno');
        Schema::dropIfExists('solicitante');
        Schema::dropIfExists('coordinador');
        Schema::dropIfExists('asesor');
        Schema::dropIfExists('persona');
    }
};
