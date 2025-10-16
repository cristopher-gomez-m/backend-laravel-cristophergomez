<?php

namespace App\Services;

use App\Repositories\CitaRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class CitaService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new CitaRepository();
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
        $cita = $this->repository->find($id);
        return $this->repository->update($cita, $data, $usuario_id);
    }

    public function delete($id, $usuario_id)
    {
        $cita = $this->repository->find($id);
        return $this->repository->delete($cita, $usuario_id);
    }

    public function reporteCitaCliente()
    {
        return $this->repository->reporteCitaCliente();
    }

    public function pdfCitaCliente()
    {
        $citas = $this->repository->reporteCitaCliente();
        $pdf = Pdf::loadView('pdf.reporte_citas', compact('citas'));
        return $response = $pdf->download('reporte_citas.pdf');
    }

    public function reporteCitaAtencion()
    {
        return $this->repository->reporteCitaAtencion();
    }

    public function reporteCitaAtencionPDF()
    {
        $citas = $this->repository->reporteCitaAtencion();
        $pdf = Pdf::loadView('pdf.reporte_citas_atenciones', compact('citas'));
        return $response = $pdf->download('reporte_citas_atenciones.pdf');
    }
}