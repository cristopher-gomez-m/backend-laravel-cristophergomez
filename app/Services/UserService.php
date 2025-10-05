<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

class UserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
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
                    Rule::unique('users')->where(function ($query) {
                        $query->where('status', 'A');
                    })
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