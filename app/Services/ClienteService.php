<?php

namespace App\Services;

use App\Repositories\ClienteRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class ClienteService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new ClienteRepository();
    }

    public function getAll($per_page, array $filters = [])
    {
        try {
            return $this->repository->getAll($per_page, $filters);
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data, $usuario_id)
    {
        return $this->repository->store($data, $usuario_id);
    }

    public function update($id, array $data, $usuario_id)
    {
        $cliente = $this->repository->find($id);
        return $this->repository->update($cliente, $data, $usuario_id);
    }

    public function delete($id, $usuario_id)
    {
        $cliente = $this->repository->find($id);
        return $this->repository->delete($cliente, $usuario_id);
    }

    public function reporteClientesAtenciones()
    {
        return $this->repository->reporteClientesAtenciones();
    }

    public function reporteClientesAtencionesPDF()
    {
        $clientes = $this->repository->reporteClientesAtenciones();
        $pdf = Pdf::loadView('pdf.reporte_clientes_atenciones', compact('clientes'));
        return $response = $pdf->download('reporte_clientes_atenciones.pdf');
    }

    public function getClientesCitasTotales()
    {
        return $this->repository->getClientesCitasTotales();
    }
    public function reporteClienteCitasTotalesPDF()
    {
        $clientes = $this->repository->getClientesCitasTotales();
        $pdf = Pdf::loadView('pdf.reporte_clientes_citas_totales', compact('clientes'));
        return $response = $pdf->download('reporte_clientes_citas_totales.pdf');
    }
}