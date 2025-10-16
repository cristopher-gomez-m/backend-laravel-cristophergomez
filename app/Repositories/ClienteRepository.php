<?php

namespace App\Repositories;

use App\Models\Person;
use Exception;

class ClienteRepository
{
    public function getAll($per_page, array $filters = [])
    {
        try {
            $query = Person::query();

            if (isset($filters['q']) && $filters['q'] !== '') {
                $q = $filters['q'];
                $query->where(function ($query) use ($q) {
                    $query->where('first_name', 'like', "%$q%")
                        ->orWhere('last_name', 'like', "%$q%")
                        ->orWhere('document', 'like', "%$q%");
                });
            }

            return $query->paginate($per_page)->toArray();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function find($id)
    {
        return Person::find($id);
    }

    public function findByDocument($document)
    {
        return Person::where('document', $document)->first();
    }

    public function store(array $input, $usuario_id)
    {
        // No hay campos de auditoría, solo se guarda la persona
        return Person::create([
            'document' => $input['document'],
            'first_name' => $input['first_name'] ?? null,
            'last_name' => $input['last_name'] ?? null,
            'address' => $input['address'] ?? null,
            'phone' => $input['phone'] ?? null,
            'email' => $input['email'] ?? null,
        ]);
    }

    public function update(Person $cliente, array $input, $usuario_modifica_id)
    {
        $cliente->update($input);
        return $cliente;
    }

    public function delete(Person $cliente, $usuario_elimina_id)
    {
        // Como no hay "status" ni "fecha_elimina", eliminamos directamente
        $cliente->delete();
        return $cliente;
    }

    public function reporteClientesAtenciones()
    {
        $data = Person::with(['citas.detalles.atencion'])->get();
        return $data;
    }

    public function getClientesCitasTotales()
    {
        // Agrupamos por cliente, sumando precios y contando servicios
        return Person::with(['citas.detalles.atencion'])
            ->get()
            ->map(function ($cliente) {
                $totalServicios = 0;
                $totalVentas = 0;

                foreach ($cliente->citas as $cita) {
                    foreach ($cita->detalles as $detalle) {
                        if ($detalle->atencion) {
                            $totalServicios++;
                            $totalVentas += floatval($detalle->atencion->precio);
                        }
                    }
                }

                return [
                    'id' => $cliente->id,
                    'document' => $cliente->document,
                    'first_name' => $cliente->first_name,
                    'last_name' => $cliente->last_name,
                    'email' => $cliente->email,
                    'total_servicios' => $totalServicios,
                    'total_ventas' => $totalVentas,
                ];
            });
    }
}
