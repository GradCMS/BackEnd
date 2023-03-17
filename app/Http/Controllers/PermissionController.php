<?php

namespace App\Http\Controllers;

use App\Http\Services\Auth\PermissionService;
use App\Http\Services\Auth\RoleService;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

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
