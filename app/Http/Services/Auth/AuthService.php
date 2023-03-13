<?php

namespace App\Http\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTGuard;

class AuthService
{

    public function login(array $creds): mixed
    {
        if (!$token = auth()->attempt($creds)){
            return false;
        }

        return $token;
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function refresh()
    {
        try {
            if (!$token = JWTAuth::refresh()) {
                return null;
            }
        } catch (JWTException $e) {
            return null;
        }

        return $token;
    }






}
