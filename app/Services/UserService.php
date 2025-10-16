<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\ClienteRepository;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class UserService
{
    private $userRepository;
    private $clienteRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->clienteRepository = new ClienteRepository();
    }
    public function login($credentials)
    {
        try {
            $data = null;
            $is_logged = false;

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = JWTAuth::fromUser($user, ['sub' => $user->id]);
                $data = compact('token', 'user');
                $is_logged = true;

                // 🔸 Registrar log de inicio de sesión
                Log::create([
                    'entity' => 'user',
                    'date' => now(),
                    'description' => "Usuario {$user->user_name} inició sesión correctamente.",
                ]);
            }

            return [
                'data' => $data,
                'is_logged' => $is_logged
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function loginMovil($credentials)
    {
        try {
            $data = null;
            $is_logged = false;
            $cliente = $this->clienteRepository->findByDocument($credentials['document']);
            if (!$cliente) {
                throw new Exception("Cliente con documento {$credentials['document']} no registrado");
            }
            // Eliminar la clave 'document' del array para que Auth::attempt solo reciba email/password
            unset($credentials['document']);
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = JWTAuth::fromUser($user, ['sub' => $user->id]);
                $data = compact('token', 'user');
                $is_logged = true;

                // 🔸 Registrar log de inicio de sesión
                Log::create([
                    'entity' => 'user',
                    'date' => now(),
                    'description' => "Usuario {$user->user_name} inició sesión correctamente.",
                ]);
            }

            return [
                'data' => $data,
                'is_logged' => $is_logged
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store($input)
    {
        try {
            $validator = Validator::make($input, [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users'),
                ],
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }

            $new_user = $this->userRepository->store($input);

            return $new_user;
        } catch (ValidationException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
    }
}