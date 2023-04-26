<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckIsSuspended
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next):JsonResponse
    {
        $user = auth()->user();

        if ($user && $user->is_suspended) {
            return response()->json(['error' => 'User is suspended'], 401);
        }
        return $next($request);
    }
}
