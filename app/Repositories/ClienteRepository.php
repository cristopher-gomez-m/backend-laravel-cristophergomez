<?php

namespace App\Repositories;

use App\Models\Cliente;
use Carbon\Carbon;
use Exception;

class ClienteRepository
{
    public function getAll($per_page, array $filters = [])
    {
        try {
            $query = Cliente::where('status', 'A');

            if (isset($filters['q']) && $filters['q'] !== '') {
                $q = $filters['q'];
                $query->where(function ($query) use ($q) {
                    $query->where('nombres', 'ilike', "%$q%");
                });
            }

            $clientes = $query->paginate($per_page)->toArray();
            return $clientes;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function find($id)
    {
        return Cliente::find($id);
    }

    public function store(array $input, $usuario_id)
    {
        // Agregamos campos de auditoría automáticamente
        $data = array_merge($input, [
            'usuario_id' => $usuario_id,
            'fecha_ingreso' => Carbon::now(),
            'status' => 'A',
        ]);

        return Cliente::create($data);
    }

    public function update(Cliente $cliente, array $input, $usuario_modifica_id)
    {
        
        $data = array_merge($input, [
            'usuario_modifica_id' => $usuario_modifica_id,
            'fecha_modifica' => Carbon::now(),
        ]);

        $cliente->update($data);

        return $cliente;
    }

    public function delete(Cliente $cliente, $usuario_elimina_id)
    {
        $cliente->update([
            'usuario_elimina_id' => $usuario_elimina_id,
            'fecha_elimina' => Carbon::now(),
            'status' => 'E',
        ]);

        return $cliente;
    }
}