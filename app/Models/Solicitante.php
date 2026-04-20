<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    protected $table = 'solicitante';
    protected $primaryKey = 'sol_id';
    public $timestamps = false;

    protected $fillable = [
        'sol_tipo', 'PERSONA_pers_doc'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'PERSONA_pers_doc', 'pers_doc');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'SOLICITANTE_sol_id', 'sol_id');
    }
}
