<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    public $timestamps = false;

    protected $fillable = [
        'cliente_id',
        'status',
        'fecha',
        'hora',
        'fecha_ingreso',
        'usuario_id',
        'fecha_modifica',
        'usuario_modifica_id',
        'fecha_elimina',
        'usuario_elimina_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

        public function detalles()
    {
        return $this->hasMany(CitaDetalle::class, 'cita_id', 'id')
            ->where('status', 'A'); // solo activos
    }
}