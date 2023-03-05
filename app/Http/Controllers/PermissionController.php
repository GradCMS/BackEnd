<?php

namespace App\Http\Controllers;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Http\Repository\PermissionRepo;
use App\Http\Services\PermissionService;
use http\Env;
use Illuminate\Http\Request;

class PermissionController extends Controller
{


    private $permissionRepo;
    public function __construct(CRUDRepoInterface $CRUDRepo)
    {
        app()->bind(CRUDRepoInterface::class, PermissionRepo::class);

        $this->permissionRepo = $CRUDRepo;
    }
    public function getPermission($id)
    {
        return $this->permissionRepo->getById($id);
    }

//    public function addPermission(Request $request){
//        $permissionName = $request->get('name');
//        return $this->permissionService->getPermission($permissionName);
//    }
}
