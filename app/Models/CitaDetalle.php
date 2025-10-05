<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitaDetalle extends Model
{
    protected $table = 'cita-detalle';
    public $timestamps = false;

    protected $fillable = [
        'cita_id',
        'atencion_id',
        'status',
        'fecha_ingreso',
        'usuario_id',
        'fecha_modifica',
        'usuario_modifica_id',
        'fecha_elimina',
        'usuario_elimina_id',
    ];

    public function atencion()
    {
        return $this->belongsTo(Atencion::class);
    }

}