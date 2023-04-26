<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    protected AuthService $authService;
    public function __construct(AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->authService = $authService;
    }

    /**
     * provides a JWT token
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['user_name', 'password']);

        return response()->json($this->authService->login($credentials));
    }

    /**
     * invalidates the token
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     *  returns user's data that is currently authenticated
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json($this->authService->me());
    }

    /**
     * invalidates the old token and provide a new one with updated TTL
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
         return response()->json($this->authService->refresh());
    }

}
