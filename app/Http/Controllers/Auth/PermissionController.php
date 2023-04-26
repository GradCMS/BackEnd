<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\PermissionService;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    private  $permissionService;
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * get all the permissions
     * @return JsonResponse
    */
    public function getPermissions():JsonResponse
    {
        $permissions = $this->permissionService->getAllPermissions();
        return response()->json([
            'Permissions'=>$permissions
        ]);
    }

}
