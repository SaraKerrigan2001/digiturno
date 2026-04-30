<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinador';
    protected $primaryKey = 'coor_id';
    public $timestamps = false;

    protected $fillable = [
        'coor_vigencia',
        'coor_correo',
        'coor_password',
        'PERSONA_pers_doc',
    ];

    /** Ocultar la contraseña en serialización JSON */
    protected $hidden = ['coor_password'];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'PERSONA_pers_doc', 'pers_doc');
    }
}
