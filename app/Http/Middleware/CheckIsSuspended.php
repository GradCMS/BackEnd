<?php

namespace App\Http\Middleware;

use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckIsSuspended
{

    private $registry;
    private $userRepo;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->userRepo = $this->registry->get('user');
    }
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

        $userName = $request->get('user_name');
        $retrivedUser = $this->userRepo->getUserByName($userName);
        $retrivedUser->makeVisible('is_suspended');
        $isSuspended = $retrivedUser->is_suspended;

        if ($isSuspended) {
            return response()->json(['error' => 'User is suspended'], 401);
        }
        else{
            return $next($request);
        }

    }
}
