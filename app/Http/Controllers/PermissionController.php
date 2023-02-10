<?php

namespace App\Http\Controllers;

use App\Http\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $permissionService;


    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    public function getPermission($id)
    {
        return $this->permissionService->getPermission($id);
    }

    public function addPermission(Request $request){
        $permissionName = $request->get('name');
        return $this->permissionService->getPermission($permissionName);
    }
}
