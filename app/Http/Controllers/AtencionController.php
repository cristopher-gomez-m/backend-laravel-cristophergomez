<?php
namespace App\Http\Controllers;

use App\Services\AtencionService;
use Illuminate\Http\Request;
use App\Utils\Pagination;
use App\Utils\ApiResponse;
use Exception;
class AtencionController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new AtencionService();
    }

    public function index(Request $request)
    {
        try {
            $per_page = (int) $request->input('per_page');
            $filters = $request->all();
            $data = $this->service->getAll($per_page, $filters);
            $pagination = new Pagination($data);
            $apiResponse = new ApiResponse($data['data']);
            $apiResponse->pagination = $pagination;
            return Response()->json($apiResponse, $apiResponse->statusCode);
        } catch (Exception $e) {
            $apiResponse = new ApiResponse([]);
            $apiResponse->message = $e->getMessage();
            $apiResponse->statusCode = 500;
            return Response()->json($apiResponse, $apiResponse->statusCode);
        }
    }

    public function getById($id)
    {
        try {
            $atencion = $this->service->find($id);
            if (!$atencion) {
                $apiResponse = new ApiResponse([]);
                $apiResponse->message = 'Atención no encontrada';
                $apiResponse->statusCode = 404;
                return response()->json($apiResponse, $apiResponse->statusCode);
            }
            return response()->json(new ApiResponse($atencion));
        } catch (Exception $e) {
            $apiResponse = new ApiResponse([]);
            $apiResponse->message = $e->getMessage();
            $apiResponse->statusCode = 500;
            return response()->json($apiResponse, $apiResponse->statusCode);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $usuario_id = (int) $request->input('usuario_id');
            // Eliminamos del array para no pasar `usuario_id` al create
            unset($data['usuario_id']);
            $atencion = $this->service->store($data, $usuario_id);
            return response()->json(new ApiResponse($atencion));
        } catch (Exception $e) {
            $apiResponse = new ApiResponse([]);
            $apiResponse->message = $e->getMessage();
            $apiResponse->statusCode = 500;
            return response()->json($apiResponse, $apiResponse->statusCode);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $usuario_id = (int) $request->input('usuario_id');
            // Eliminamos del array para no pasar `usuario_id` al create
            unset($data['usuario_id']);

            $atencion = $this->service->update($id, $data, $usuario_id);
            return response()->json(new ApiResponse($atencion));
        } catch (Exception $e) {
            $apiResponse = new ApiResponse([]);
            $apiResponse->message = $e->getMessage();
            $apiResponse->statusCode = 500;
            return response()->json($apiResponse, $apiResponse->statusCode);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $usuario_id = (int) $request->input('usuario_id');

            $this->service->delete($id, $usuario_id);
            $apiResponse = new ApiResponse([]);
            $apiResponse->message = 'Cliente eliminado correctamente';
            return response()->json($apiResponse);
        } catch (Exception $e) {
            $apiResponse = new ApiResponse([]);
            $apiResponse->message = $e->getMessage();
            $apiResponse->statusCode = 500;
            return response()->json($apiResponse, $apiResponse->statusCode);
        }
    }
}