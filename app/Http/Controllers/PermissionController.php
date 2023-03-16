<?php

namespace App\Http\Controllers;

use App\Http\Services\Auth\RoleService;

class PermissionController extends Controller
{
    private RoleService $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }





}
