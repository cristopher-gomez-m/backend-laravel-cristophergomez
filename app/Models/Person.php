<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'person';
    public $timestamps = false;

    protected $fillable = [
        'document',
        'first_name',
        'last_name',
        'address',
        'phone',
        'email',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class, 'cliente_id', 'id');
    }
}
