<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atencion extends Model
{
    protected $table = 'atenciones';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'precio',
        'status',
        'fecha_ingreso',
        'usuario_id',
        'fecha_modifica',
        'usuario_modifica_id',
        'fecha_elimina',
        'usuario_elimina_id',
    ];
}