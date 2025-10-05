<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
class UserRepository
{
    public function store($input)
    {
        try {
            // Creamos el usuario sin depender del ID
            $usuario = User::create([
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'status' => 'A',
                'fecha_ingreso' => Carbon::now(),
            ]);


            $usuario->usuario_id = $usuario->id;
            $usuario->save();


            return $usuario;

        } catch (Exception $e) {
            throw $e;
        }
    }
}
