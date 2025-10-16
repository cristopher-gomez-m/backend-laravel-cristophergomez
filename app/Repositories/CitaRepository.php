<?php

namespace App\Repositories;

use App\Models\Cita;
use App\Models\CitaDetalle;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CitaRepository
{
    public function getAll($per_page, array $filters = [])
    {
        $query = Cita::with(['cliente', 'detalles']);

        if (isset($filters['cliente_id'])) {
            $query->where('cliente_id', $filters['cliente_id']);
        }

        $citas = $query->paginate($per_page)->toArray();
        return $citas;
    }

    public function find($id)
    {
        return Cita::with(['cliente', 'detalles.atencion'])->find($id);
    }


    public function store(array $input, $usuario_id)
    {
        DB::beginTransaction();

        try {
            // Guardar cita principal
            $cita = Cita::create([
                'fecha' => Carbon::parse($input['fecha'])->format('Y-m-d'),
                'hora' => Carbon::parse($input['hora'])->format('H:i:s'),
                'cliente_id' => $input['cliente_id'],
                'usuario_id' => $usuario_id,
                'fecha_ingreso' => Carbon::now(),
                'status' => 'A',
            ]);

            // Guardar detalles si vienen
            if (!empty($input['detalle'])) {
                foreach ($input['detalle'] as $detalle) {
                    CitaDetalle::create([
                        'cita_id' => $cita->id,
                        'atencion_id' => $detalle['atencion_id'],
                        'status' => 'A',
                        'fecha_ingreso' => Carbon::now(),
                        'usuario_id' => $usuario_id,
                    ]);
                }
            }

            DB::commit();
            return $cita;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function update(Cita $cita, array $input, $usuario_modifica_id)
    {
        DB::beginTransaction();

        try {
            // Actualizar datos de la cita
            $cita->update([
                'fecha' => Carbon::parse($input['fecha'])->format('Y-m-d'),
                'hora' => Carbon::parse($input['hora'])->format('H:i:s'),
                'cliente_id' => $input['cliente_id'],
                'usuario_modifica_id' => $usuario_modifica_id,
                'fecha_modifica' => Carbon::now(),
            ]);

            // Eliminar detalles (eliminación lógica)
            if (!empty($input['detalleEliminar'])) {
                foreach ($input['detalleEliminar'] as $detalleId) {
                    $detalle = CitaDetalle::find($detalleId);
                    if ($detalle) {
                        $detalle->update([
                            'status' => 'E',
                            'fecha_modifica' => Carbon::now(),
                            'usuario_modifica_id' => $usuario_modifica_id,
                        ]);
                    }
                }
            }

            // Crear nuevos detalles
            if (!empty($input['detalleNuevo'])) {
                foreach ($input['detalleNuevo'] as $detalle) {
                    CitaDetalle::create([
                        'cita_id' => $cita->id,
                        'atencion_id' => $detalle['atencion_id'],
                        'status' => 'A',
                        'fecha_ingreso' => Carbon::now(),
                        'usuario_id' => $usuario_modifica_id,
                    ]);
                }
            }

            DB::commit();
            return $cita;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function delete(Cita $cita, $usuario_elimina_id)
    {
        $cita->update([
            'usuario_elimina_id' => $usuario_elimina_id,
            'fecha_elimina' => Carbon::now(),
            'status' => 'E',
        ]);

        return $cita;
    }

    public function reporteCitaCliente()
    {
        $citas = Cita::with([
            'cliente'
        ])->get();

        return $citas;
    }

    public function reporteCitaAtencion()
    {
        $citas = Cita::with([
            'cliente',
            'detalles.atencion'
        ])->get();

        return $citas;
    }
}