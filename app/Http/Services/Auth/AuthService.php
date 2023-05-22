<?php

namespace App\Http\Services\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTGuard;

class AuthService
{

    public function login(array $creds): ?array
    {
        if (!$token = auth()->attempt($creds)){
            return null;
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return auth()->user();
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function refresh(): array
    {
        $newToken = auth()->refresh();
        return $this->respondWithToken($newToken);
    }
    protected function respondWithToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
/**
 * defines the behviour when an unauthorized happens
 * @return JsonResponse
 */
public function unauthorized():JsonResponse
{
    return response()->json(['error'=>'Unauthorized | bad token'], 401);
}




}
