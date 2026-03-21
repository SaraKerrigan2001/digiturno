<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $table = 'turno';
    protected $primaryKey = 'tur_id';
    public $timestamps = false;

    protected $fillable = [
        'tur_hora_fecha', 'tur_numero', 'tur_tipo', 'SOLICITANTE_sol_id'
    ];

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class, 'SOLICITANTE_sol_id', 'sol_id');
    }

    public function atencion()
    {
        return $this->hasOne(Atencion::class, 'TURNO_tur_id', 'tur_id');
    }
}
