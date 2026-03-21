<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'pers_doc';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'pers_doc', 'pers_tipodoc', 'pers_nombres', 'pers_apellidos', 'pers_telefono', 'pers_fecha_nac'
    ];

    public function asesor()
    {
        return $this->hasOne(Asesor::class, 'PERSONA_pers_doc', 'pers_doc');
    }

    public function solicitante()
    {
        return $this->hasOne(Solicitante::class, 'PERSONA_pers_doc', 'pers_doc');
    }

    public function coordinador()
    {
        return $this->hasOne(Coordinador::class, 'PERSONA_pers_doc', 'pers_doc');
    }
}
