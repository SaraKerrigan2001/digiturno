<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * CU-01 / CU-02: Agrega tur_estado a la tabla turno.
 * El repositorio TurnoRepository usa este campo para filtrar turnos en espera
 * y actualizar el estado al llamar/finalizar un turno.
 *
 * Estados:
 *   Espera     → turno generado, esperando ser llamado
 *   Atendiendo → asesor llamó al turno, atención en curso
 *   Finalizado → atención completada o ciudadano ausente
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('turno', function (Blueprint $table) {
            if (!Schema::hasColumn('turno', 'tur_estado')) {
                // Incluye 'Ausente' para consistencia con optimize_turno_table migration
                $table->enum('tur_estado', ['Espera', 'Atendiendo', 'Finalizado', 'Ausente'])
                      ->default('Espera')
                      ->after('tur_numero')
                      ->comment('Estado del ciclo de vida del turno (CU-01)');
            }
        });

        // Sincronizar registros existentes según la tabla atencion
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("
                UPDATE turno t
                LEFT JOIN atencion a ON a.TURNO_tur_id = t.tur_id
                SET t.tur_estado = CASE
                    WHEN a.atnc_id IS NULL          THEN 'Espera'
                    WHEN a.atnc_hora_fin IS NULL     THEN 'Atendiendo'
                    ELSE                                  'Finalizado'
                END
            ");
        }
    }

    public function down(): void
    {
        Schema::table('turno', function (Blueprint $table) {
            if (Schema::hasColumn('turno', 'tur_estado')) {
                $table->dropColumn('tur_estado');
            }
        });
    }
};
