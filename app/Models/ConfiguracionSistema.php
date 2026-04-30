<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionSistema extends Model
{
    protected $table = 'configuracion_sistema';
    protected $primaryKey = 'id';

    protected $fillable = ['clave', 'valor', 'descripcion'];

    /**
     * Obtiene el valor de un parámetro por su clave.
     * Retorna $default si no existe.
     */
    public static function get(string $clave, string $default = ''): string
    {
        $registro = static::where('clave', $clave)->first();
        return $registro ? $registro->valor : $default;
    }

    /**
     * Guarda o actualiza el valor de un parámetro.
     */
    public static function set(string $clave, string $valor): void
    {
        static::updateOrCreate(
            ['clave' => $clave],
            ['valor' => $valor]
        );
    }

    /**
     * Retorna el ciclo de turno configurado: 'dia' | 'semana' | 'mes'
     */
    public static function cicloDeTurno(): string
    {
        return static::get('ciclo_turno', 'dia');
    }
}
