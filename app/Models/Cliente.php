<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'status',
        'fecha_ingreso',
        'usuario_id',
        'fecha_modifica',
        'usuario_modifica_id',
        'fecha_elimina',
        'usuario_elimina_id',
    ];
}