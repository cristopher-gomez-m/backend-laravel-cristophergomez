<?php

namespace App\Repositories;

use App\Models\Atencion;
use Carbon\Carbon;

class AtencionRepository
{
    public function getAll($per_page, array $filters = [])
    {
        $query = Atencion::where('status', 'A');

        $atenciones = $query->paginate($per_page)->toArray();
        return $atenciones;
    }

    public function find($id)
    {
        return Atencion::find($id);
    }

    public function store(array $input, $usuario_id)
    {
        $data = [
            'nombre' => $input['nombre'],
            'precio' => $input['precio'],
            'usuario_id' => $usuario_id,
            'fecha_ingreso' => Carbon::now(),
            'status' => 'A',
        ];

        return Atencion::create($data);
    }

    public function update(Atencion $atencion, array $input, $usuario_modifica_id)
    {
        $data = [
            'nombre' => $input['nombre'],
            'precio' => $input['precio'],
            'usuario_modifica_id' => $usuario_modifica_id,
            'fecha_modifica' => Carbon::now(),
        ];
        $atencion->update($data);

        return $atencion;
    }

    public function delete(Atencion $atencion, $usuario_elimina_id)
    {
        $atencion->update([
            'usuario_elimina_id' => $usuario_elimina_id,
            'fecha_elimina' => Carbon::now(),
            'status' => 'E',
        ]);

        return $atencion;
    }
}