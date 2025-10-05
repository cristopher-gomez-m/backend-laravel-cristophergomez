<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Utils\ApiResponse;
use Illuminate\Validation\ValidationException;
use Exception;
class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $credentials['status'] = 'A';
            $data = $this->userService->login($credentials);
            if ($data['is_logged'] == true) {
                $apiResponse = new ApiResponse($data['data']);
                return response()->json($apiResponse, $apiResponse->statusCode);
            } else {
                $apiResponse = new ApiResponse([]);
                $apiResponse->message = 'Credenciales no válidas';
                $apiResponse->statusCode = 401;
                return Response()->json($apiResponse, $apiResponse->statusCode);
            }
        } catch (Exception $e) {
            $apiResponse = new ApiResponse([]);
            $apiResponse->message = $e->getMessage();
            $apiResponse->statusCode = 500;
            return Response()->json($apiResponse, $apiResponse->statusCode);
        }
    }

    public function store(Request $request)
    {
        try {
            $input = $request->all(); // Obtén los datos del formulario
            //$usuario_id = $request->get('usuario_id');
            // Llama al método del servicio para crear una nueva promotora
            $cliente = $this->userService->store($input);

            // Devuelve una respuesta JSON con la promotora creada y un código de estado 201 (creado)
            return response()->json($cliente, 201);
        } catch (ValidationException $e) {
            // Manejar errores de validación
            \Log::error($e);
            return response()->json(['error' => $e->errors()], 422); // 422 Unprocessable Entity para errores de validación
        } catch (Exception $e) {
            \Log::error($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}